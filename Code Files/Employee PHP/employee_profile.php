<?php
session_start();

if (isset($_SESSION['DVID'])) {
    $DriverID = $_SESSION['DVID'];
} else {
    // Redirect to login if DVID is not set
    header(header: "Location: ../LoginSignup/employeelogin.php");
    exit();
}

require '../DatabaseConnection/Database.php';

// A Variable for once they sign in, theyll took their driver id and use it to take all of their info! 

//Options for Unit Type
$unitcount = 0;
$UnitType_OptionCodes = "SELECT DUT_ID, DUT_UnitType FROM driver_unit_type;";
$UnitType_Option = mysqli_query($conn, $UnitType_OptionCodes);            
if (!$UnitType_Option) {
    die("Query failed: " . mysqli_error($conn));
} while ($row = mysqli_fetch_assoc($UnitType_Option)) {
    $UnitTypes[$unitcount] = $row['DUT_UnitType'];
    $UnitTypesID[$unitcount] = $row['DUT_ID'];   
    $unitcount++;
}



//Options for Hubs
$hubcount = 0;
$Hub_OptionCodes = "SELECT HASS_ID,HASS_Name FROM hub_assigned;";
$Hub_Option = mysqli_query($conn, $Hub_OptionCodes);            
if (!$Hub_Option) {
    die("Query failed: " . mysqli_error($conn));
} while ($row = mysqli_fetch_assoc($Hub_Option)) {
    $Hub[$hubcount] = $row['HASS_Name'];
    $HubID[$hubcount] = $row['HASS_ID'];
    $hubcount++;
}


//Mysql Code to Select every drivers detail
$DriversDetails = 
"SELECT a.`DI_ID`, c.`DN_FName`, c.`DN_MName`, c.`DN_LName`, c.`DN_Suffix`, a.`DI_Age`, a.`DI_ContactNo`, a.`DI_Gender`, a.`DI_DOB`, a.`DI_Email`,
a.`DI_LicenseImg`, a.`DI_BrgyClearanceImg`, a.`DI_PoliceClearanceImg`,
a.`DI_NBIClearanceImg`, a.`Gcash_No`, a.`GCash_Name`,
b.`ACC_Username`, b.`ACC_Password`, a.`DI_ProfileImage`,
d.`DA_HouseNo`, d.`DA_LotNo`, d.`DA_Street`, d.`DA_Barangay`,
d.`DA_City`, d.`DA_Province`, d.`DA_ZipCode`, e.`DUT_UnitType`,
g.`HASS_Name`, h.`GOV_PhilHealthNo`, h.`GOV_SSSNo`, h.`GOV_PagibigNo`,
DRIVERNAMEDISPLAY (c.`DN_FName`,c.`DN_MName`,c.`DN_LName`, c.`DN_Suffix`) AS FullName
FROM driver_information a
JOIN account b on a.`DI_AccountID` = b.`ACC_ID`
JOIN driver_name c on a.`DI_NameID` = c.`DN_ID`
JOIN driver_address d on a.`DI_AddressID` = d.`DA_ID`
JOIN driver_unit_type e on a.`DI_UnitTypeID` = e.`DUT_ID`
JOIN hub_assigned g on a.`DI_HubAssignedID` = g.`HASS_ID`
JOIN government_information h on a.`DI_GovInfoID` = h.`GOV_ID` 
where DI_ID = $DriverID";

//Mysql Code to Select every drivers information
$DriverInfo = mysqli_query($conn, $DriversDetails);            

if (!$DriverInfo) {
    die("Query failed: " . mysqli_error($conn));
}
// Put Driver Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($DriverInfo)) {
 
    //Drivers Variable
    $DRV = [
        "FullName" => $row['FullName'],
        "ID" => $row['DI_ID'],
        "FN" => $row['DN_FName'],
        "MN" => $row['DN_MName'],
        "LN" => $row['DN_LName'],
        "SFX" => $row['DN_Suffix'],
        "Age" => $row['DI_Age'],
        "CN" => $row['DI_ContactNo'],
        "Gender" => $row['DI_Gender'],
        "DOB" => $row['DI_DOB'],
        "Email" => $row['DI_Email'],
        "GC_NO" => $row['Gcash_No'],
        "GC_Name" => $row['GCash_Name'],
        "USER" => $row['ACC_Username'],
        "PASS" => $row['ACC_Password'],
        "House" => $row['DA_HouseNo'],
        "Lot" => $row['DA_LotNo'],
        "Brgy" => $row['DA_Barangay'],
        "Street" => $row['DA_Street'],
        "City" => $row['DA_City'],
        "Province" => $row['DA_Province'],
        "Zip" => $row['DA_ZipCode'],
        "Unit" => $row['DUT_UnitType'],
        "Hub" => $row['HASS_Name'],
        "PhilNo" => $row['GOV_PhilHealthNo'],
        "SSSNo" => $row['GOV_SSSNo'],
        "PagNo" => $row['GOV_PagibigNo'],
        "Profile" => base64_encode($row['DI_ProfileImage']),
        "DriversLicense" => base64_encode($row['DI_LicenseImg']),
        "Brgy_Clear" => base64_encode($row['DI_BrgyClearanceImg']),
        "Pol_Clear" => base64_encode($row['DI_PoliceClearanceImg']),
        "NBI_Clear" => base64_encode($row['DI_NBIClearanceImg'])
    ];
}

//Mysql Code to Select every drivers vehicles
$VehiclesDetails = "SELECT a.DV_ID,a.DV_VehiclePlate,a.DV_ORImg,a.DV_CRImg FROM driver_vehicle a
JOIN driver_information b ON a.DV_DriverID = b.DI_ID
WHERE b.DI_ID = $DriverID";

//Connection
$VehiclesInfo = mysqli_query($conn, $VehiclesDetails);

if (!$VehiclesInfo) {
    die("Query failed: " . mysqli_error($conn));
}

$Vehicle_Count = 0; //Array for Vehicles

// Put Vehicle Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($VehiclesInfo)) {
    $VHC[$Vehicle_Count] = [
        "ID" =>  $row['DV_ID'],
        "Plate" =>  $row['DV_VehiclePlate'],
        "OR" => base64_encode($row['DV_ORImg']),
        "CR" => base64_encode($row['DV_CRImg'])
    ];
    $Vehicle_Count += 1;
}


// Connection for the Personal and Account Form

//Connect to Personal & Accounts Form
function AddDisplayVehicle($VHC,$i){
    echo '<div class="ColoredBackground">
    <input type="hidden" name="VehicleID[]" value="'. htmlspecialchars($VHC[$i]["ID"]) .'">
    <h4 class="vehicle"> VEHICLE NO. ' . ($i + 1) . ' </h4>
<h4 class="vehicle"> PLATE NO: </h4>
        <input type="text" value="' . htmlspecialchars($VHC[$i]["Plate"]) . '" disabled class="editable_status_Vehicle textbox_vehicle" name="Plate[]">
    <div class="Two-Textbox center">
        <div class="Top-Bottom centered">
            <h4> OR: </h4>
            <img id="orPreview_' . $i . '" src="data:image/png;base64,' . htmlspecialchars($VHC[$i]["OR"]) . '" alt="OR" style="width:90%; height: auto;" class="ORCR">
            <label for="OR_' . $i . '" style="cursor: pointer; color: blue; text-decoration: underline; display: none" class="editimage">Edit OR</label>
            <input type="file" name="OR[]" id="OR_' . $i . '" accept="image/*" style="display: none;" onchange="previewImage(event, \'orPreview_' . $i . '\')">
        </div>
        <div class="Top-Bottom centered">
            <h4> CR: </h4>
            <img id="crPreview_' . $i . '" src="data:image/png;base64,' . htmlspecialchars($VHC[$i]["CR"]) . '" alt="CR" style="width:90%; height: auto;" class="ORCR">        
            <label for="CR_' . $i . '" style="cursor: pointer; color: blue; text-decoration: underline; display: none" class="editimage">Edit CR</label>
            <input type="file" name="CR[]" id="CR_' . $i . '" accept="image/*" style="display: none;" onchange="previewImage(event, \'crPreview_' . $i . '\')">
        </div>
    </div>
</div>'; 

}


function Vehicle($VHC,$i){
    echo
'
<section id="vehicle-info" class="info-section vehicle-info">
<!-- Delete Icon -->
<span class="delete-icon" onclick="deleteVehicleInfo(this)">✖</span>
<input type="hidden" name="VehicleID[]" value="'. htmlspecialchars($VHC[$i]["ID"]) .'">
<label for="plate-number">Plate Number:</label>
        <input type="text" value="' . htmlspecialchars($VHC[$i]["Plate"]) . '" disabled class="editable_status_Vehicle textbox_vehicle" name="Plate[]">

<label for="or-image">Official Receipt (OR) Image:</label>
<div class="image-display">
  <img alt="Official Receipt Image" id="orPreview_' . $i . '" src="data:image/png;base64,' . htmlspecialchars($VHC[$i]["OR"]) . '"  class="ORCR">
  <input type="file" name="OR[]" id="OR_' . $i . '" name="or-image" accept="image/*" style="display: none;" class="editimage" onchange="previewImage(event, \'orPreview_' . $i . '\')">
</div>

<label for="cr-image">Certificate of Registration (CR) Image:</label>
<div class="image-display">
  <img alt="Certificate of Registration Image" id="crPreview_' . $i . '" src="data:image/png;base64,' . htmlspecialchars($VHC[$i]["CR"]) . '" class="ORCR">
  <input type="file" name="CR[]" id="CR_' . $i . '" accept="image/*" style="display: none;" class="editimage"  onchange="previewImage(event, \'crPreview_' . $i . '\')">
</div>

</section>
'; 
}
?>