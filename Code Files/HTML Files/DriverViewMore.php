<?php
$AccID = htmlspecialchars($_GET['id']); // Sanitize the input

// Ensure $AccID is an integer
$AccID = (int)$AccID;


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
g.`HASS_Name`, h.`GOV_PhilHealthNo`, h.`GOV_SSSNo`, h.`GOV_PagibigNo`,b.`ACC_AcountStatID`
FROM driver_information a
JOIN account b on a.`DI_AccountID` = b.`ACC_ID`
JOIN driver_name c on a.`DI_NameID` = c.`DN_ID`
JOIN driver_address d on a.`DI_AddressID` = d.`DA_ID`
JOIN driver_unit_type e on a.`DI_UnitTypeID` = e.`DUT_ID`
JOIN hub_assigned g on a.`DI_HubAssignedID` = g.`HASS_ID`
JOIN government_information h on a.`DI_GovInfoID` = h.`GOV_ID`
where b.`ACC_ID` = $AccID";

//Mysql Code to Select every drivers information
$DriverInfo = mysqli_query($conn, $DriversDetails);            

if (!$DriverInfo) {
    die("Query failed: " . mysqli_error($conn));
}
// Put Driver Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($DriverInfo)) {
 
    //Drivers Variable
    $DRV = [
        "STAT" => $row['ACC_AcountStatID'],
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

    
    if($DRV["MN"] == ''){
        $FullName = $DRV["FN"]." " .$DRV["LN"]." ".$DRV["SFX"];
    } else {
        $FullName = $DRV["FN"]." ".substr($DRV["MN"],0,1 ).". ".$DRV["LN"]." ".$DRV["SFX"];
    }

}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="ACC_DRIVER.CSS">
    <script src="../JS Files/Accounts.js?v=1.1"></script>
    <link rel="stylesheet" href="../CSS Files/DriverView.css">
    <title>ACCOUNTS</title>
      <!--JQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

    <div>
        <div class="view-left">
             <img src="data:image/png;base64,<?php echo $DRV["Profile"]; ?>" alt="Driver Photo" class="profile-image">
            <button id="change-view-img">CHANGE IMAGE</button>
            <div id="view-driver-id">
                <label for="driver-id">Driver's ID:</label>
                <input type="text" id="driver-id" value="<?php echo $DRV["ID"] ?>" disabled>
            </div>
            <div id="view-hub">
                <label for="hub">Hub:</label>
                <select id="hub" class="editable_status_P-A" name="hub" class="inputs" disabled required>
              <?php for ($i = 0; $i < count($Hub); $i++){
             $selectedunit =  ($DRV["Hub"] == $Hub[$i]) ? 'selected' : '';
             echo '<option value="' . htmlspecialchars($HubID[$i]) . '"' . $selectedunit . '>' . htmlspecialchars($Hub[$i]) . '</option>';
            } ?>
             </select>
            </div>

            <div id="view-unit-type">
                <label for="unit-type">Unit Type:</label>
                <select id="unit-type" class="editable_status_P-A" name="unittype" disabled required>
                 <?php 
                 for ($i = 0; $i < count($UnitTypes); $i++) {
                 $selectedunit = ($DRV["Unit"] == $UnitTypes[$i]) ? ' selected' : '';
                 echo '<option value="' . htmlspecialchars($UnitTypesID[$i]) . '"' . $selectedunit . '>' . htmlspecialchars($UnitTypes[$i]) . '</option>';
                 }
                  ?>
                 </select>
            </div>

            <div id="account-status" disabled>
                <label for="account-status">Account Status:</label><br>
                <input type="radio" name="status" id="Active" value="2" <?php if($DRV["STAT"] == 2) echo "checked"; else { echo "disabled";} ?>> ACTIVE<br>
                <input type="radio" name="status" id="Inactive" value="3" <?php if($DRV["STAT"] == 3) echo "checked"; else { echo "disabled";}  ?>> INACTIVE<br>
                <input type="radio" name="status" id="Pending" value="1" <?php if($DRV["STAT"] == 1) echo "checked"; else { echo "disabled";}  ?>> PENDING<br>

            </div>
            <button onclick="DisableEnableInput()">EDIT</button>
        </div>

        <div class="view-right">
            <div class="view-space">
                <button popovertarget="view-more-container" popovertargetaction="hide" onclick='closeView()'>CLOSE</button>
            </div>
            <div class="view-name">
                <h2>NAME:</h2>
                <div class="field-group-1">
                    <input type="text" id="firstname" value="<?php echo $DRV["FN"] ?>" disabled>
                    <h5 for="firstname" >FIRST NAME</h5>
                </div>
                <div class="field-group-1">
                    <input type="text" id="middlename" value="<?php echo $DRV["MN"] ?>" disabled>
                    <h5 for="middlename" >MIDDLE NAME</h5>
                </div>
                <div class="field-group-1">
                    <input type="text" id="lastname" value="<?php echo $DRV["LN"] ?>" disabled>
                    <h5 for="lastname">LAST NAME</h5>
                </div>
                <div class="field-group-1">
                    <input type="text" id="suffix" value="<?php echo $DRV["SFX"] ?>" disabled>
                    <h5 for="suffix">SUFFIX</h5>
                </div>
            </div>
            <div class="view-personal">
                <h2>PERSONAL INFORMATION:</h2>
                <div class="field-group-2">
                    <input type="date" id="birthdate" value="<?php echo $DRV["DOB"] ?>" disabled>
                    <h5 for="birthdate">BIRTHDATE</h5>
                </div>
                <div class="field-group-2">
                    <select id="gender" disabled>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <h5 for="gender">GENDER</h5>
                </div>
                <div class="field-group-2">
                    <input type="number" id="age" value="<?php echo $DRV["Age"] ?>" disabled>
                    <h5 for="age">AGE</h5>
                </div>
            </div>
            <div class="view-address">
                <h2>ADDRESS:</h2>
                <div class="field-group-3">
                    <select id="province" disabled>
                        <option value="Province 1">Province 1</option>
                        <option value="Province 2">Province 2</option>
                    </select>
                    <h5 for="province">PROVINCE</h5>
                </div>
                <div class="field-group-3">
                    <select id="city" disabled>
                        <option value="City 1">City 1</option>
                        <option value="City 2">City 2</option>
                    </select>
                    <h5 for="city">CITY</h5>
                </div>
                <div class="field-group-3">
                    <select id="barangay" disabled>
                        <option value="Barangay 1">Barangay 1</option>
                        <option value="Barangay 2">Barangay 2</option>
                    </select>
                    <h5 for="barangay">BARANGAY</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="street" value="<?php echo $DRV["Street"] ?>" disabled>
                    <h5 for="street">STREET</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="lotno" value="<?php echo $DRV["Lot"] ?>"disabled>
                    <h5 for="lotno">LOT NO</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="houseno" value="<?php echo $DRV["Age"] ?>" disabled>
                    <h5 for="houseno">HOUSE NO</h5>
                </div>
            </div>


      <div style="display: none">
        <select id="province" name="province" class="editable_status_P-A" disabled required>
       <option value="<?php echo $DRV['Province']; ?>" selected><?php echo $DRV['Province']; ?></option>
      </select>
      <input type="hidden" name="province_text" id="province-text" value="<?php echo $DRV['Province']; ?>" required>

     <label for="city">City/Municipality:</label>
     <select id="city" name="city" class="editable_status_P-A" disabled required>
      <option value="<?php echo $DRV['City']; ?>" selected><?php echo $DRV['City']; ?></option>
     </select>
     <input type="hidden" name="city_text" id="city-text" value="<?php echo $DRV['City']; ?>" required>

      <label for="barangay">Barangay:</label>
      <select id="barangay" name="barangay" class="editable_status_P-A" disabled required>
      <option value="<?php echo $DRV['Brgy']; ?>" selected><?php echo $DRV['Brgy']; ?></option>
     </select>
     <input type="hidden" name="barangay_text" id="barangay-text" value="<?php echo $DRV['Brgy']; ?>" required>
     </div>

            <div class="view-contact">
                <h2>CONTACT & LICENSE:</h2>
                <div class="field-group-3">
                    <input type="text" id="contact"  value="<?php echo $DRV["CN"] ?>"  disabled>
                    <h5 for="contact">CONTACT NO</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="email"  value="<?php echo $DRV["Email"] ?>"  disabled>
                    <h5 for="email">EMAIL</h5>
                </div>
            </div>
            <div class="view-contribution">
                <h2>CONTRIBUTIONS:</h2>
                <div class="field-group-3">
                    <input type="text" id="pagibig" value="<?php echo $DRV["PagNo"] ?>" disabled>
                    <h5 for="pagibig">PAG-IBIG NO</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="philhealth" value="<?php echo $DRV["PhilNo"] ?>" disabled>
                    <h5 for="philhealth">PHILHEALTH NO</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="sss" value="<?php echo $DRV["SSSNo"] ?>" disabled>
                    <h5 for="sss">SSS NO</h5>
                </div>
                <div class="field-group-3">
        
                </div>
            </div>
            <div class="view-gcash-detail">
                <h2>GCASH DETAILS:</h2>
                <div class="field-group-3">
                    <input type="text" id="gcash-num" value="<?php echo $DRV["GC_NO"] ?>" disabled>
                    <h5 for="gcash-num">GCASH NO</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="gcash-name"  value="<?php echo $DRV["GC_Name"] ?>" disabled>
                    <h5 for="gcash-name">GCASH NAME</h5>
                </div>
            </div>
            <div class="view-account">
                <h2>ACCOUNT:</h2>
                <div class="field-group-3">
                    <input type="text" id="user"  value="<?php echo $DRV["USER"] ?>"  disabled>
                    <h5 for="user">USERNAME</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="pass"  value="<?php echo $DRV["PASS"] ?>"  disabled>
                    <h5 for="pass">PASSWORD</h5>
                </div>
                <div class="view-date">
                    <h2>ACCOUNT CREATED: &nbsp;</h2>
                    <h2>Nov-13-24</h2>
                </div>
            </div>
            <div class="view-documents">
                <button id="docu-btn">DOCUMENT PHOTOS</button>
            </div>
        </div>
    </div>
    <script src="updateaddress.js?v=1.1"></script>
    <script>
        function closeView() {
            window.history.back();
        }

    </script>
</body>
</html>
