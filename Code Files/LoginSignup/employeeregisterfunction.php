<?php
session_start();
require '../DatabaseConnection/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Basic Information
    $User = $_POST['user'];
    $Pass = $_POST['pass'];
    $FName = $_POST['fname'];
    $MName = $_POST['mname'];
    $LName = $_POST['lname'];
    $Sufx = $_POST['sfx'];
    $HN = $_POST['HouseNo'];
    $LN = $_POST['LotNo'];
    $ST = $_POST['Street'];
    $BRG = $_POST['barangay_text'];
    $Cty = $_POST['city_text'];
    $Pvn = $_POST['province_text'];
    $Zip = $_POST['Zip'];
    $Phil = $_POST['PH'];
    $SSS = $_POST['SSS'];
    $Pagibig = $_POST['PIBG'];
    $UnitID = $_POST['UnitID'];
    $HubID = $_POST['HubID'];
    $Age = $_POST['Age'];
    $ConNo = $_POST['Contact'];
    $Gen = $_POST['Gender'];
    $DOB = $_POST['DOB'];
    $email = $_POST['Email'];
    $GNo = $_POST['GcashNo'];
    $GName = $_POST['GcashName'];
    $DrivID = $_POST['DriverID'];
    $VP = $_POST['VehiclePlate'];
    
    // File Handling
    $LcnsData = getFileBinaryData('License','License');
    $BrgyData = getFileBinaryData('Brgy','Barangay');
    $PolData = getFileBinaryData('Police','Popo');
    $NBIData = getFileBinaryData('NBI','NBI');
    $Profile = getFileBinaryData('Profile',name: 'Profile');
    $ORData = getFileBinaryData('OR','OR');
    $CRData = getFileBinaryData('CR','CR');

    if (!$LcnsData || !$BrgyData || !$PolData || !$NBIData || !$Profile || !$ORData || !$CRData) {
        echo "Error: One or more images failed to upload.";
        exit;
    }

    savedriverdata(
        $conn,
        $User, $Pass, $FName, $MName, $LName, $Sufx, $HN, $LN, $ST, $BRG, $Cty, $Pvn, $Zip,
        $Phil, $SSS, $Pagibig, $UnitID, $HubID, $Age, $ConNo, $Gen, $DOB, $email, $GNo, $GName,
        $LcnsData, $BrgyData, $PolData, $NBIData, $Profile,  
        $DrivID,$VP,$ORData,$CRData
    );
}

function getFileBinaryData($inputName,$name) {

    if (isset($_FILES[$inputName])) {
        if ($_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$inputName]['tmp_name'];
            $fileType = mime_content_type($fileTmpPath);

            // Ensure uploaded file is an image
            if (strpos($fileType, 'image/') === 0) {
                return file_get_contents($fileTmpPath); // Get binary data
            } else {
                echo $name." Error: Uploaded file is not a valid image.";
                return null;
            }
        } else {
            echo "Error uploading file: " . $_FILES[$inputName]['error'];
            return null;
        }
    }
    return null; // If the file input is not set
}


function savedriverdata(
    $conn, $User, $Pass, $FName, $MName, $LName, $Sufx, $HN, $LN, $ST, $BRG, $Cty, $Pvn, $Zip,
    $Phil, $SSS, $Pagibig, $UnitID, $HubID, $Age, $ConNo, $Gen, $DOB, $email, $GNo, $GName,
    $LcnsData, $BrgyData, $PolData, $NBIData, $Profile, $DrivID,$VP,$ORData,$CRData
) {
    $PENDING = 1;
    $date = date('Y-m-d');

    try {
        $conn->begin_transaction();

        // Account Insert
        $accountsql = "INSERT INTO `account`(`ACC_ID`,`ACC_AcountStatID`, `ACC_Username`, `ACC_Password`, `ACC_DateCreated`) 
        VALUES (NULL,?,?,?,?)";
        $accstmt = $conn->prepare($accountsql);
        $accstmt->bind_param("isss", $PENDING, $User, $Pass, $date);
        $accstmt->execute();
        $AccID = $conn->insert_id;

        // Driver Name Insert
        $namesql = "INSERT INTO `driver_name`(`DN_ID`,`DN_FName`, `DN_MName`, `DN_LName`, `DN_Suffix`) 
        VALUES (NULL,?,?,?,?)";
        $namestmt = $conn->prepare($namesql);
        $namestmt->bind_param("ssss", $FName, $MName, $LName, $Sufx);
        $namestmt->execute();
        $NameID = $conn->insert_id;

        // Address Insert
        $addresssql = "INSERT INTO `driver_address`(`DA_ID`, `DA_HouseNo`, `DA_LotNo`, `DA_Street`, `DA_Barangay`, `DA_City`, `DA_Province`, `DA_ZipCode`) 
        VALUES (NULL,?,?,?,?,?,?,?)";
        $addstmt = $conn->prepare($addresssql);
        $addstmt->bind_param("ssssssi", $HN, $LN, $ST, $BRG, $Cty, $Pvn, $Zip);
        $addstmt->execute();
        $AddID = $conn->insert_id;


        $sssql = "INSERT INTO `sss`(`SSS_No`, `SSSCR_ID`, `SSS_RSS_ER`, `SSS_RSS_EE`, `SSS_RSS_Total`, `SSS_EC_ER`, `SSS_TC_ER`, `SSS_TC_EE`, `SSS_TotalContribution`) 
        VALUES (?,1,0.00,0.00,0.00,0.00,0.00,0.00,0.00);";
        $pgbgsql = "INSERT INTO `pagibig`(`PBIG_No`, `PBIG_Start`, `PBIG_End`, `PBIG_ERPercent`, `PBIG_EEPercent`) 
        VALUES (?,0.00,0.00,0.00,0.00)";
        $phlsql = "INSERT INTO `philhealth`(`PHI_No`, `PHI_ERPercent`, `PHI_EEPercent`, `PHI_ER`, `PHI_EE`, `PHI_Total`) 
        VALUES (?,0.00,0.00,0.00,0.00,0.00)";
        $sssstmt = $conn->prepare($sssql);
        $sssstmt->bind_param("s", $SSS);
        $sssstmt->execute();
        $pgbgtmt = $conn->prepare($pgbgsql);
        $pgbgtmt->bind_param("s", $Pagibig);
        $pgbgtmt->execute();
        $phltmt = $conn->prepare($phlsql);
        $phltmt->bind_param("s", $Phil);
        $phltmt->execute();    

        // Government Information Insert
        $governmentsql = "INSERT INTO `government_information`(`GOV_ID`, `GOV_PhilHealthNo`, `GOV_SSSNo`, `GOV_PagibigNo`) 
        VALUES (NULL,?,?,?)";
        $govstmt = $conn->prepare($governmentsql);
        $govstmt->bind_param("sss", $Phil, $SSS, $Pagibig);
        if (!$govstmt->execute()){
            throw new Exception("Error inserting into delivery_information: " .$govstmt->error);
        }
        $GovID = $conn->insert_id;
        echo $GovID;

        // Driver Information Insert
    $DriverSql = "INSERT INTO `driver_information`
        (`DI_ID`, `DI_AccountID`, `DI_NameID`, `DI_AddressID`, `DI_UnitTypeID`, 
        `DI_HubAssignedID`, `DI_GovInfoID`, `DI_Age`, `DI_ContactNo`, 
        `DI_Gender`, `DI_DOB`, `DI_Email`, `Gcash_No`, `GCash_Name`) 
        VALUES (?,?,?,?,?, ?,?,?,?, ?,?,?,?,?)";
        $DriverStmt = $conn->prepare($DriverSql);
        $DriverStmt->bind_param(
            "iiiiiiiissssss",
            $DrivID, $AccID, $NameID, $AddID, $UnitID, 
            $HubID, $GovID, $Age, $ConNo, 
            $Gen, $DOB, $email, $GNo, $GName
        );
        if (!$DriverStmt->execute()) {
            throw new Exception("Error inserting driver information: " . $DriverStmt->error);
        }

    $DriverImgSql = "UPDATE `driver_information`
        SET `DI_LicenseImg` = ?, 
            `DI_BrgyClearanceImg` = ?, 
            `DI_PoliceClearanceImg` = ?, 
            `DI_NBIClearanceImg` = ?, 
            `DI_ProfileImage` = ?
        WHERE `DI_ID` = ?";
    $DriverImgStmt = $conn->prepare($DriverImgSql);
        $DriverImgStmt->bind_param("sssssi", $LcnsData, $BrgyData, $PolData, $NBIData, $Profile, $DrivID);
    if (!$DriverImgStmt->execute()) {
        throw new Exception("Error updating driver information: " . $DriverImgStmt->error);
    }


    $VehicleSql = "INSERT INTO `driver_vehicle`(`DV_ID`, `DV_DriverID`, `DV_VehiclePlate`, `DV_ORImg`, `DV_CRImg`) 
    VALUES (NULL,?,?,?,?)";
    $VehicleStmt = $conn->prepare($VehicleSql);
    $VehicleStmt->bind_param("iiss",$DrivID,$VP,$ORData,$CRData);
    if (!$VehicleStmt->execute()) {
        throw new Exception("Error updating driver information: " . $DriverImgStmt->error);
    }






        $conn->commit();
        echo "Driver data saved successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Transaction error: " . $e->getMessage();
    }
}
?>
