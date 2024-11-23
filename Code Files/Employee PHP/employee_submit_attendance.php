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

$sql = "SELECT b.`DEL_ParcelCarried`,
b.`DEL_ParcelDelivered`,
b.`DEL_ParcelReturned`,
b.`DEL_RemittanceReciept`,
c.`ATT_Date`
FROM attendance a
JOIN delivery_information b ON a.ATT_DeliveryID = b.DEL_ID
JOIN attendance_date_type c ON a.ADT_ID = c.ADT_ID
WHERE c.`ATT_Date` = ? AND a.`ATT_DriverID` = ?;"; 

$stmt = $conn->prepare($sql);

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

// Close the statement 
$stmt->close();

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
// Set the timezone to Philippine Time
date_default_timezone_set('Asia/Manila');

$date = date('Y-m-d');
$timesubmission = time(); // Get current Unix timestamp
$formattedTime = date('H:i:s', $timesubmission); // Convert to 'HH:MM:SS'
    try {
        $conn->begin_transaction();

        // Insert date
        $dateID = "SELECT ADT_ID FROM attendance_date_type WHERE ATT_Date = ?";
        $stmt3 = $conn->prepare($dateID);
        // Bind parameters 
        $stmt3->bind_param("s", $date);
        $stmt3->execute();
        // Get the result set from the statement 
        $result = $stmt3->get_result();
        $dateRow = $result->fetch_assoc(); // Fetch single row

        if (!$dateRow) {
            throw new Exception("No date ID found for today's date: $date");
        }

        $DateID_Today = $dateRow['ADT_ID']; // Extract the ID

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
                (`ATT_ID`, `ATT_DriverID`, `ATT_DeliveryID`, `ATT_SubmitTime`, `ADT_ID`) 
                VALUES (NULL, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("iisi", $DriverID, $deliveryID, $formattedTime, $DateID_Today); // Corrected binding
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
