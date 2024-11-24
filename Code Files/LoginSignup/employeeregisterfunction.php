<?php
session_start();
require '../DatabaseConnection/Database.php';


   //Initializing Variable based on employeelogin.php submission 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Data = sanitizeData($_POST, [
        'DriverID','user', 'pass', 'fname', 'mname', 'lname', 'sfx', 'HouseNo', 'LotNo', 'Street',
        'barangay_text', 'city_text', 'province_text', 'Zip', 'PH', 'SSS', 'PIBG',
        'UnitID', 'HubID', 'Age', 'Contact', 'Gender', 'DOB', 'Email', 'GcashNo',
        'GcashName', 'DriverID', 'VehiclePlate'
    ]);

    // Picture Handling
    $fileFields = ['License', 'Brgy', 'Police', 'NBI', 'Profile', 'OR', 'CR'];
    $fileData = handleFileUploads($fileFields);

    if (in_array(null, $fileData, true)) {
        exit("Error: One or more images failed to upload.");
    }


    //Variables to the Database
    try {
        $conn->begin_transaction();
        
        $AccID = insertAccount($conn, $Data['user'], $Data['pass']);
        $NameID = insertName($conn, $Data['fname'], $Data['mname'], $Data['lname'], $Data['sfx']);
        $AddID = insertAddress($conn, $Data['HouseNo'], $Data['LotNo'], $Data['Street'], $Data['barangay_text'], $Data['city_text'], $Data['province_text'], $Data['Zip']);
        $GovID = insertGovernment($conn, $Data['PH'], $Data['SSS'], $Data['PIBG']);
        
        insertDriver($conn, $Data['DriverID'],$Data, $AccID, $NameID, $AddID, $GovID);
        insertVehicle($conn, $Data['DriverID'], $Data['VehiclePlate'], $fileData['OR'], $fileData['CR']);
        insertDriverImg($conn, $Data['DriverID'],  $fileData);
        $conn->commit();
        echo "Driver data saved successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        exit("Transaction error: " . $e->getMessage());
    }
}

// Initialize Data to the $Result and Returning it to the $Data
function sanitizeData($data, $fields) {
    $result = [];
    foreach ($fields as $field) {
        $result[$field] = $data[$field] ?? null;
    }
    return $result;
}

//Getting all of the pictures binary data for the database
function handleFileUploads($fields) {
    $result = [];
    foreach ($fields as $field) {
        $result[$field] = getFileBinaryData($field, $field);
    }
    return $result;
}

//Looking if its an valid picture
function getFileBinaryData($inputName, $name) {
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$inputName]['tmp_name'];
        if (strpos(mime_content_type($fileTmpPath), 'image/') === 0) {
            return file_get_contents($fileTmpPath);
        }
        echo "$name Error: Uploaded file is not a valid image.";
    }
    return null;
}

//Account Database
function insertAccount($conn, $user, $pass) {
    $sql = "INSERT INTO `account`(`ACC_AcountStatID`, `ACC_Username`, `ACC_Password`, `ACC_DateCreated`) VALUES (1,?,?,?)";
    $stmt = $conn->prepare($sql);
    $date = date('Y-m-d');
    $stmt->bind_param("sss", $user, $pass,$date);
    execute($stmt);    
    return $conn->insert_id;
}

//Name Database
function insertName($conn, $fname, $mname, $lname, $sfx) {
    $sql = "INSERT INTO `driver_name`(`DN_FName`, `DN_MName`, `DN_LName`, `DN_Suffix`) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fname, $mname, $lname, $sfx);
    execute($stmt);    
    return $conn->insert_id;
}

//Address Database
function insertAddress($conn, $houseNo, $lotNo, $street, $barangay, $city, $province, $zip) {
    $sql = "INSERT INTO `driver_address`(`DA_HouseNo`, `DA_LotNo`, `DA_Street`, `DA_Barangay`, `DA_City`, `DA_Province`, `DA_ZipCode`) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $houseNo, $lotNo, $street, $barangay, $city, $province, $zip);
    execute($stmt);    
    return $conn->insert_id;
}

//Government Database
function insertGovernment($conn, $phil, $sss, $pagibig) {
    $sssql = "INSERT INTO sss(SSS_No, SSSCR_ID, SSS_RSS_ER, SSS_RSS_EE, SSS_RSS_Total, SSS_EC_ER, SSS_TC_ER, SSS_TC_EE, SSS_TotalContribution) 
    VALUES (?,1,0.00,0.00,0.00,0.00,0.00,0.00,0.00);";
    $pgbgsql = "INSERT INTO pagibig(PBIG_No, PBIG_Start, PBIG_End, PBIG_ERPercent, PBIG_EEPercent) 
    VALUES (?,0.00,0.00,0.00,0.00)";
    $phlsql = "INSERT INTO philhealth(PHI_No, PHI_ERPercent, PHI_EEPercent, PHI_ER, PHI_EE, PHI_Total) 
    VALUES (?,0.00,0.00,0.00,0.00,0.00)";
    $sssstmt = $conn->prepare($sssql);
    $sssstmt->bind_param("s", $sss);
    $sssstmt->execute();
    $pgbgtmt = $conn->prepare($pgbgsql);
    $pgbgtmt->bind_param("s", $pagibig);
    $pgbgtmt->execute();
    $phltmt = $conn->prepare($phlsql);
    $phltmt->bind_param("s", $phil);
    $phltmt->execute();    
    
    $sql = "INSERT INTO `government_information`(`GOV_PhilHealthNo`, `GOV_SSSNo`, `GOV_PagibigNo`) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $phil, $sss, $pagibig);
    execute($stmt);    
    return $conn->insert_id;
}

//Driver Information Database
function insertDriver($conn,$id, $data, $accID, $nameID, $addID, $govID) {
    $sql = "INSERT INTO driver_information
        (DI_ID, DI_AccountID, DI_NameID, DI_AddressID, DI_UnitTypeID, 
        DI_HubAssignedID, DI_GovInfoID, DI_Age, DI_ContactNo, 
        DI_Gender, DI_DOB, DI_Email, Gcash_No, GCash_Name) 
        VALUES (?,?,?,?,?, ?,?,?,?, ?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iiiiiiiissssss",
        $id,$accID, $nameID, $addID, $data['UnitID'], 
        $data['HubID'], $govID, $data['Age'], $data['Contact'],
        $data['Gender'], $data['DOB'], $data['Email'], $data['GcashNo'], $data['GcashName']
    );
    execute($stmt);    
}

//Driver Information for Images Database
function insertDriverImg($conn, $id, $files) {
    $sql = "UPDATE driver_information
        SET DI_LicenseImg = ?, 
            DI_BrgyClearanceImg = ?, 
            DI_PoliceClearanceImg = ?, 
            DI_NBIClearanceImg = ?, 
            DI_ProfileImage = ?
        WHERE DI_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssi",
        $files['License'], $files['Brgy'], $files['Police'], $files['NBI'], $files['Profile'], $id
    );
    execute($stmt);    
}

//Vehicle Database
function insertVehicle($conn, $driverID, $plate, $orImg, $crImg) {
    $sql = "INSERT INTO `driver_vehicle`(`DV_DriverID`, `DV_VehiclePlate`, `DV_ORImg`, `DV_CRImg`) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $driverID, $plate, $orImg, $crImg);
    execute($stmt);    
}

//Check the Database
function execute($file){
    if (!$file->execute()) {
        throw new Exception("Error updating driver information: " . $file->error);
    } 
}

?>
