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

// Set the timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Get today's date in the format 'Y-m-d'
$datetoday = date('Y-m-d');

$sql = "SELECT 
b.`DEL_ParcelCarried`,
b.`DEL_ParcelDelivered`,
b.`DEL_ParcelReturned`,
b.`DEL_RemittanceReciept`,
c.`ATT_Date`,
a.ATT_StatusID
FROM attendance a
JOIN delivery_information b ON a.ATT_DeliveryID = b.DEL_ID
JOIN attendance_date_type c ON a.ADT_ID = c.ADT_ID
WHERE c.`ATT_Date` = ? AND a.`ATT_DriverID` = ? ;"; 

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
        "RR" => base64_encode($row['DEL_RemittanceReciept']),
        "Stat" => $row["ATT_StatusID"]
    ];

}

if ($Attendance['Stat']==2){
    $disableInput = true;
    $deniedInput  = false; 

    $Message = "Your Attendance Submission has been approved and recorded to the system!";
} elseif($Attendance['Stat']==1){
    $disableInput = true;
    $deniedInput  = false; 

    $Message = "Your Attendance is currently in pending and being check if its accurate, Please contact the Admins if there are any errors or changes needed in your todays submission.";
} else{
    $disableInput = false;
    $Message = "Your Attendance Submission has been denied, please try again and fix the issues!";
    $deniedInput  = true; 
}
} else { 
    $disableInput = false; 
    $deniedInput  = false; 
}


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
                (`ATT_ID`, `ATT_DriverID`, `ATT_DeliveryID`) 
                VALUES (NULL, ?, ?)";
        $stmt2 = $conn->prepare($sql2);

        $stmt2->bind_param("ii", $DriverID, $deliveryID); // Corrected binding
        if (!$stmt2->execute()) {
            throw new Exception("Error inserting into attendance: " . $stmt2->error);
        }   
        $ID = $conn->insert_id;

        $conn->commit();
        echo "Attendance submitted successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Transaction error: " . $e->getMessage();
    }

    $SelectDatas = "SELECT
    a.`ATT_ID`, 
    a.`ATT_DriverID`, 
    a.`ATT_DeliveryID`, 
    a.`ATT_SubmitTime`, 
    b.`ADT_ID`, 
    b.`ATT_Date`, 
    DATE_FORMAT(b.`ATT_Date`, '%m %Y') AS MonthYear,
    c.`AS_Status`, 
    b.`DT_ID` AS DayID, 
    d.`Day_Type`,
    DATE_FORMAT(DATE(b.`ATT_Date`), '%Y-%m-01') AS StartOfMonth,
    LAST_DAY(b.`ATT_Date`) AS EndOfMonth
    FROM 
    attendance a
    JOIN
    attendance_date_type b ON a.`ADT_ID` = b.`ADT_ID`
    JOIN
    attendance_status c ON a.`ATT_StatusID` = c.`AS_ID`
    JOIN
    day_type d ON b.`DT_ID` = d.`DT_ID`
    WHERE a.`ATT_ID` = $ID;";

    $result = $conn->query($SelectDatas);   
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            $START = $row['StartOfMonth'];
            $END = $row['EndOfMonth'];


            $Summary = "SELECT `ASUM_ID`, `ASUM_DriverID`, `ASUM_DateStart`, `ASUM_DateEnd` 
            FROM `attendance_summary` 
            WHERE ASUM_DriverID=$DriverID 
            AND ASUM_DateStart= '$START'";
            
            $resultSummary = $conn->query($Summary);   
            if ($resultSummary && $resultSummary->num_rows > 0) {
                $updateSTMT = "";
                echo "STOP";
                switch ($row['DayID']){
                    case 1:
                    $updateSTMT = "UPDATE `attendance_summary` 
                    SET `ASUM_RegularDay`=`ASUM_RegularDay`+1,`ASUM_OverallAttendance`=`ASUM_OverallAttendance`+1
                    WHERE `ASUM_DriverID`=? AND ASUM_DateStart= ?"; 
                    $Updatestmt = $conn->prepare($updateSTMT);
                    $Updatestmt->bind_param("is",$DriverID,$row['StartOfMonth']);      
                    if (!$Updatestmt->execute()) {
                        throw new Exception("Error inserting into attendance: " . $stmt2->error);
                    }      
                    break;
                    case 2:
                    $updateSTMT = "UPDATE `attendance_summary` 
                    SET `ASUM_RegularHoliday`=`ASUM_RegularHoliday`+1,`ASUM_OverallAttendance`=`ASUM_OverallAttendance`+1
                    WHERE `ASUM_DriverID`=? AND ASUM_DateStart= ?";
                    $Updatestmt = $conn->prepare($updateSTMT);
                    $Updatestmt->bind_param("is",$DriverID,$row['StartOfMonth']);      
                    if (!$Updatestmt->execute()) {
                        throw new Exception("Error inserting into attendance: " . $stmt2->error);
                    }  
                    break;
                    case 3:
                    $updateSTMT = "UPDATE `attendance_summary`  
                    SET `ASUM_SpecialHoliday`=`ASUM_SpecialHoliday`+1,`ASUM_OverallAttendance`=`ASUM_OverallAttendance`+1
                    WHERE `ASUM_DriverID`=? AND ASUM_DateStart= ?";  
                    $Updatestmt = $conn->prepare($updateSTMT);
                    $Updatestmt->bind_param("is",$DriverID,$row['StartOfMonth']);      
                    if (!$Updatestmt->execute()) {
                        throw new Exception("Error inserting into attendance: " . $stmt2->error);
                    }                   
                    break;
                };
            } else {
                echo "GOOD";
                $Regular = 0;
                $Special = 0;
                $RegularHol = 0;
    
                $row['DayID'];
    
                switch ($row['DayID']){
                    case 1:
                    $Regular = 1;                  
                    break;
                    case 2:
                    $RegularHol = 1;
                    break;
                    case 3:
                    $Special = 1;                   
                    break;
                };
    
                $Total = 1;
    
                $SummarySQL = "INSERT INTO `attendance_summary`
                (`ASUM_DriverID`, `ASUM_RegularDay`, `ASUM_SpecialHoliday`, `ASUM_RegularHoliday`, `ASUM_OverallAttendance`, `ASUM_DateStart`, `ASUM_DateEnd`) 
                VALUES (?,?,?,?,?,?,?)";
                $Summarystmt = $conn->prepare($SummarySQL);
                $Summarystmt->bind_param("iiiiiss",$DriverID,$Regular,$Special,$RegularHol,$Total,$row['StartOfMonth'],$row['EndOfMonth']); 
                if (!$Summarystmt->execute()) {
                    throw new Exception("Error inserting into attendance: " . $stmt2->error);
                } 
            }
        }
    }
}
?>
