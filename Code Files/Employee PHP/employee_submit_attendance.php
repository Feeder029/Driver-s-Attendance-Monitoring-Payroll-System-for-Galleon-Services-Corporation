<?php
session_start();


if (isset($_SESSION['DVID'])) {
    $DriverID = $_SESSION['DVID'];
} else {
    // Redirect to login if DVID is not set
    header("Location: ../LoginSignup/employeelogin.php");
    exit();
}

require '../DatabaseConnection/Database.php';

$datetoday = date('Y-m-d');

$sql = "SELECT b.DEL_ParcelCarried, b.DEL_ParcelDelivered, b.DEL_ParcelReturned, b.DEL_RemittanceReciept FROM attendance a JOIN delivery_information b ON a.ATT_DeliveryID = b.DEL_ID WHERE ATT_Date = ? AND ATT_DriverID = ?;"; $stmt = $conn->prepare($sql);

// Bind parameters 
$stmt->bind_param("si", $datetoday, $DriverID);

// Execute the statement 
$stmt->execute();

// Get the result set from the statement 
$result = $stmt->get_result();

// Check if there are results 
if ($result->num_rows == 1) { // Fetch all results as an associative array 
$resultsArray = $result->fetch_all(MYSQLI_ASSOC);

// You can now loop through the results or process them as needed
foreach ($resultsArray as $row) {
    $Attendance = [
        "PC"=> $row["DEL_ParcelCarried"],
        "PR"=> $row["DEL_ParcelReturned"],
        "PD"=> $row["DEL_ParcelDelivered"],
        "RR" => base64_encode($row['DEL_RemittanceReciept'])
    ];
}
$disableInput = true;
} else { $disableInput = false; }

// Close the statement $stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $Carried = filter_var($_POST["parcel-carried"], FILTER_SANITIZE_NUMBER_INT);
    $Delivered = filter_var($_POST["parcel-delivered"], FILTER_SANITIZE_NUMBER_INT);
    $Returned = filter_var($_POST["parcel-returned"], FILTER_SANITIZE_NUMBER_INT);

    // File upload handling with validation
    if (isset($_FILES['remittance-receipt']) && $_FILES['remittance-receipt']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['remittance-receipt']['tmp_name'];
        $fileType = mime_content_type($fileTmpPath);

        // Ensure uploaded file is an image
        if (strpos($fileType, 'image/') !== 0) {
            echo "Error: Uploaded file is not a valid image.";
            exit();
        }

        $fileData = file_get_contents($fileTmpPath); // Get binary data
    } else {
        echo "Error: Failed to upload remittance receipt.";
        exit();
    }

    // Submit the attendance
    SubmitAttendance($conn, $DriverID, $Carried, $Delivered, $Returned, $fileData);

    // Redirect after success
    header(header: "Location: EMP_INDEX.PHP");
    exit();
}

// Submit Attendance to the Database
function SubmitAttendance($conn, $DriverID, $Carried, $Delivered, $Returned, $fileData) {
    $date = date('Y-m-d');

    try {
        $conn->begin_transaction();

        // Insert into delivery_information
        $sql1 = "INSERT INTO delivery_information 
                (`DEL_ID`, `DEL_ParcelCarried`, `DEL_ParcelDelivered`, `DEL_ParcelReturned`, `DEL_RemittanceReciept`) 
                VALUES (NULL, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $null = NULL; // Placeholder for binary data
        $stmt1->bind_param("iiib", $Carried, $Delivered, $Returned, $null);
        $stmt1->send_long_data(3, $fileData); // Bind binary data
        if (!$stmt1->execute()) {
            throw new Exception("Error inserting into delivery_information: " . $stmt1->error);
        }

        $deliveryID = $conn->insert_id;

        // Insert into attendance
        $sql2 = "INSERT INTO attendance 
                (`ATT_ID`, `ATT_DriverID`, `ATT_DeliveryID`, `ATT_Date`) 
                VALUES (NULL, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("iis", $DriverID, $deliveryID, $date);
        if (!$stmt2->execute()) {
            throw new Exception("Error inserting into attendance: " . $stmt2->error);
        }

        $conn->commit();
        echo "Attendance submitted successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Transaction error: " . $e->getMessage();
    }
}

?>
