<?php
include("employee_profile.php");


$OR = [];
$CR = [];
$License = [];
$V_ID = [];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && $_POST['id'] == 'Vehicles') {
    $vehicleIDs = $_POST['VehicleID'];
    $plates = $_POST['Plate'];
    $orImages = $_FILES['OR'];
    $crImages = $_FILES['CR'];

    for ($i = 0; $i < count($vehicleIDs); $i++) {
        $vehicleID = $vehicleIDs[$i];
        $plate = mysqli_real_escape_string($conn, $plates[$i]);
        $orImage = null;
        $crImage = null;

        // Handle OR image upload
        if ($orImages['error'][$i] == UPLOAD_ERR_OK) {
            $orImage = mysqli_real_escape_string($conn, file_get_contents($orImages['tmp_name'][$i]));
        }

        // Handle CR image upload
        if ($crImages['error'][$i] == UPLOAD_ERR_OK) {
            $crImage = mysqli_real_escape_string($conn, file_get_contents($crImages['tmp_name'][$i]));
        }

        Vehicles_Update($conn, $vehicleID, $plate, $orImage, $crImage);
    }

    $DriverLicense = $_FILES['License'];

    if ($DriverLicense['error'] == UPLOAD_ERR_OK) {
        // Get the Binary Data
        $DriverLicenses = mysqli_real_escape_string($conn, file_get_contents($DriverLicense['tmp_name']));
        
        // Assuming $DriverID is defined and valid
        License_Update($conn, $DriverID, $DriverLicenses);
    } else {
        // Handle the error accordingly
        echo "Error uploading file: " . $DriverLicense['error'];
    }

    header(header: "Location: EMP_INDEX.PHP"); // Refresh for updated one!
    exit(); 
}

//Connect to Adding a Vehicles Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && $_POST['id'] == 'Vehicles') {
    // Existing vehicles update code here

    // Check for new vehicle data
    if (isset($_POST['newPlate'])) {
        $newPlates = $_POST['newPlate'];
        $newORImages = $_FILES['newOR'];
        $newCRImages = $_FILES['newCR'];

        for ($i = 0; $i < count($newPlates); $i++) {
            $newPlate = htmlspecialchars($newPlates[$i]);

            $newOR = null;
            $newCR = null;

            if ($newORImages['error'][$i] == UPLOAD_ERR_OK) {
                $newOR = mysqli_real_escape_string($conn, file_get_contents($newORImages['tmp_name'][$i]));
            }

            if ($newCRImages['error'][$i] == UPLOAD_ERR_OK) {
                $newCR = mysqli_real_escape_string($conn, file_get_contents($newCRImages['tmp_name'][$i]));
            }

            // Insert new vehicle data into the database
            NewVehicles($conn, $DriverID, $newPlate, $newOR, $newCR);
        }
    }

    header("Location: EMP_INDEX.PHP");
    exit();
}


//Function for Adding a New Vehicle
function NewVehicles($conn,$DriveID, $Plate,$OR,$CR) {

    $InsertNewVehicle = "
    INSERT INTO driver_vehicle(DV_ID, DV_DriverID, DV_VehiclePlate, DV_ORImg, DV_CRImg)
     VALUES ('','$DriveID',' $Plate','$OR','$CR');";
     $result = mysqli_query($conn, $InsertNewVehicle);
    
     if (!$result) {
         echo "Update failed: " . mysqli_error($conn);
     } else {
         echo "Vehicle information updated successfully.";
     }

}

//Function for update in Vehicle Details
function Vehicles_Update($conn, $vehicleID, $plate, $orImage, $crImage) {
    $sql_Vehicle = "UPDATE driver_vehicle SET 
    DV_VehiclePlate = '$plate', 
    DV_ORImg = " . ($orImage ? "'$orImage'" : 'DV_ORImg') . ", 
    DV_CRImg = " . ($crImage ? "'$crImage'" : 'DV_CRImg') . "
    WHERE DV_ID = $vehicleID;";

    $result = mysqli_query($conn, $sql_Vehicle);
    
    if (!$result) {
        echo "Update failed: " . mysqli_error($conn);
    } else {
        echo "Vehicle information updated successfully.";
    }
}

if (isset($_POST['deleteVehicleID'])) {
    $vehicleID = $_POST['deleteVehicleID'];
    DeleteVehicles($conn, $vehicleID); // Call the delete function
}

// Delete function
function DeleteVehicles($conn, $vehicleID) {
    // Sanitize vehicleID to prevent SQL injection
    $vehicleID = mysqli_real_escape_string($conn, $vehicleID);
    $DeleteVehicleQuery = "DELETE FROM driver_vehicle WHERE DV_ID ='$vehicleID'";

    // Execute query
    $result = mysqli_query($conn, $DeleteVehicleQuery);

    if (!$result) {
        echo "Deletion failed: " . mysqli_error($conn);
    } else {
        echo "Vehicle information deleted successfully.";
    }
}


//Function for License Update
function License_Update($conn, $DriverID, $LicenseImage) {
    // Ensure the LicenseImage is properly quoted for SQL
    $UpdateLicense = 
    "UPDATE driver_information a
    SET a.`DI_LicenseImg` = '$LicenseImage'
    WHERE a.`DI_ID` = $DriverID;";

    $result = mysqli_query($conn, $UpdateLicense);
    
    if (!$result) {
        echo "Update failed: " . mysqli_error($conn);
    } else {
        echo "Driver license information updated successfully.";
    }
}


?>