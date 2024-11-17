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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $Carried = filter_var($_POST["parcel-carried"], FILTER_SANITIZE_NUMBER_INT);
    $Delivered = filter_var($_POST["parcel-delivered"], FILTER_SANITIZE_NUMBER_INT);
    $Returned = filter_var($_POST["parcel-returned"], FILTER_SANITIZE_NUMBER_INT);

    // File upload handling
    if (isset($_FILES['remittance-receipt']) && $_FILES['remittance-receipt']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['remittance-receipt']['tmp_name'];
        $fileData = file_get_contents($fileTmpPath);
        $RRI_FINALE = mysqli_real_escape_string($conn, $fileData);
    } else {
        echo "Error: Failed to upload remittance receipt.";
        exit();
    }

    // Submit the attendance
    SubmitAttendance($conn, $DriverID, $Carried, $Delivered, $Returned, $RRI_FINALE);
    header(header:"Location: EMP_INDEX.PHP");
    exit();
} 

//Submit Attendance to the Database
function SubmitAttendance($conn, $DriverID, $Carried, $Delivered, $Returned, $RRI_FINALE) {
    $date = date('Y-m-d');

    try {
        // Begin transaction
        $conn->begin_transaction();

        // Insert into delivery_information
        $sql1 = "INSERT INTO delivery_information 
                (`DEL_ID`, `DEL_ParcelCarried`, `DEL_ParcelDelivered`, `DEL_ParcelReturned`, `DEL_RemittanceReciept`) 
                VALUES (NULL, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("iiis", $Carried, $Delivered, $Returned, $RRI_FINALE);
        if (!$stmt1->execute()) {
            throw new Exception("Failed to insert delivery information.");
        }

        $deliveryID = $conn->insert_id;

        // Insert into attendance
        $sql2 = "INSERT INTO attendance 
                (`ATT_ID`, `ATT_DriverID`, `ATT_DeliveryID`, `ATT_Date`) 
                VALUES (NULL, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("iis", $DriverID, $deliveryID, $date);
        if (!$stmt2->execute()) {
            throw new Exception("Failed to insert attendance.");
        }

        // Commit transaction
        $conn->commit();

        echo "Attendance submitted successfully.";
    } catch (Exception $e) {
        // Rollback on failure
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
