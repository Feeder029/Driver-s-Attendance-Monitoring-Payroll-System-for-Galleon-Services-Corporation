<?php
//Connect to Database
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gsc_attendanceandpayroll";
$conn = "";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if ($conn) {
    echo "Database connected successfully.<br>";
} else {
    die("Connection failed: " . mysqli_connect_error());
}

// A Variable for once they sign in, theyll took their driver id and use it to take all of their info! 
$DriverID = 34534;


//Mysql Code to Select every drivers detail
$DriversDetails = 
"SELECT a.`DI_ID`, c.`DN_FName`, c.`DN_MName`, c.`DN_LName`, c.`DN_Suffix`, a.`DI_Age`, a.`DI_ContactNo`, a.`DI_Gender`, a.`DI_DOB`, a.`DI_Email`,
a.`DI_LicenseImg`, a.`DI_BrgyClearanceImg`, a.`DI_PoliceClearanceImg`,
a.`DI_NBIClearanceImg`, a.`Gcash_No`, a.`GCash_Name`,
b.`ACC_Username`, b.`ACC_Password`, b.`ACC_ProfilePicture`,
d.`DA_HouseNo`, d.`DA_LotNo`, d.`DA_Street`, d.`DA_Barangay`,
d.`DA_City`, d.`DA_Province`, d.`DA_ZipCode`, e.`DUT_UnitType`,
g.`HASS_Name`, h.`GOV_PhilHealthNo`, h.`GOV_SSSNo`, h.`GOV_PagibigNo`
FROM driver_information a
JOIN account b on a.`DI_AccountID` = b.`ACC_ID`
JOIN driver_name c on a.`DI_NameID` = c.`DN_ID`
JOIN driver_address d on a.`DI_AddressID` = d.`DA_ID`
JOIN driver_unit_type e on a.`DI_UnitTypeID` = e.`DUT_ID`
JOIN hub_assigned g on a.`DI_HubAssignedID` = g.`HASS_ID`
JOIN government_information h on a.`DI_GovInfoID` = h.`GOV_ID` 
where DI_ID = $DriverID";

//Mysql Code to Select every drivers vehicles
$VehiclesDetails = "SELECT a.DV_VehiclePlate,a.DV_ORImg,a.DV_CRImg FROM driver_vehicle a
JOIN driver_information b ON a.DV_DriverID = b.DI_ID
WHERE b.DI_ID = $DriverID";

$DriverInfo = mysqli_query($conn, $DriversDetails); 
$VehiclesInfo = mysqli_query($conn, $VehiclesDetails);

if (!$DriverInfo) {
    die("Query failed: " . mysqli_error($conn));
}
// Put Driver Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($DriverInfo)) {
    //Text
    $D_ID = $row['DI_ID'];
    $D_FN = $row['DN_FName'];
    $D_MN = $row['DN_MName'];
    $D_LN = $row['DN_LName'];
    $D_Sfx = $row['DN_Suffix'];
    $D_Age = $row['DI_Age'];
    $D_CN = $row['DI_ContactNo'];
    $D_Gender = $row['DI_Gender'];
    $D_DOB = $row['DI_DOB'];
    $D_Email = $row['DI_Email'];
    $D_GcashNo = $row['Gcash_No'];
    $D_GCash_Name = $row['GCash_Name'];
    $D_Username = $row['ACC_Username'];
    $D_Password = $row['ACC_Password'];
    $D_HouseNo = $row['DA_HouseNo'];
    $D_LotNo = $row['DA_LotNo'];
    $D_Street = $row['DA_Street'];
    $D_Barangay = $row['DA_Barangay'];
    $D_City = $row['DA_City'];
    $D_Province = $row['DA_Province'];
    $D_Zip = $row['DA_ZipCode'];
    $D_UnitType = $row['DUT_UnitType'];
    // $D_Plate = $row['DV_VehiclePlate'];
    $D_Hub = $row['HASS_Name'];
    $D_PhilHealth = $row['GOV_PhilHealthNo'];
    $D_SSS = $row['GOV_SSSNo'];
    $D_Pagibig = $row['GOV_PagibigNo'];

    if($D_MN == ''){
        $FullName = $D_FN." " .$D_LN." ".$D_Sfx;
    } else {
        $FullName = $D_FN." ".substr($D_MN,0,1 ).". ".$D_LN." ".$D_Sfx;
    }

    //Images (Encode the Text to the Image) -  src="data:image/jpeg;base64,<?php echo $orImage; > (How to Call it)    
    $D_PPIC = base64_encode($row['ACC_ProfilePicture']);
    $D_License = base64_encode($row['DI_LicenseImg']);
    $D_BrgyClear = base64_encode($row['DI_BrgyClearanceImg']);
    $D_PolClear = base64_encode($row['DI_PoliceClearanceImg']);
    $D_NBI_Clear = base64_encode($row['DI_NBIClearanceImg']);
    // $D_OR = base64_encode($row['DV_ORImg']);
    // $D_CR = base64_encode($row['DV_CRImg']);
}

if (!$VehiclesInfo) {
    die("Query failed: " . mysqli_error($conn));
}
$i = 0;
// Put Vehicle Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($VehiclesInfo)) {
    $D_VP[$i] = $row['DV_VehiclePlate'];
    $D_OR = base64_encode($row['DV_ORImg']);
    $D_CR = base64_encode($row['DV_CRImg']);
    $i++;
}

mysqli_close($conn)






// To Update the Details about their personal and account details

/*
UPDATE driver_information a
JOIN driver_name c ON a.DI_NameID = c.DN_ID
 JOIN account b on a.`DI_AccountID` = b.`ACC_ID`
SET
    a.`DI_Age` = 32,
    a.`DI_UnitTypeID` = 1,
    a.`DI_HubAssignedID` = 2,
    a.`DI_DOB` = '1992-10-22',
    a.`DI_Gender` = 'Female',
    b.`ACC_Username` = 'TinaBurnesr_34534',
    b.`ACC_Password` = '9342_Passd',
    c.`DN_FName` = 'Tina',
    c.`DN_LName` = 'Burner',
    c.`DN_MName` = 'Akap',
    c.`DN_Suffix` = 'Sr.'
WHERE a.DI_ID = 34534;
*/

?>


<body>
<p> 
    <link rel="stylesheet" href="../CSS Files/employeeprofile.css">

    <!-- Profile  -->
    <img src="data:image/png;base64,<?php echo $D_PPIC; ?>" alt="Profile Picture" style="width: 100px; height: 100px"> 
    <h1> <?php echo "$FullName"?></h1>
    <label for="imageInput" style="cursor: pointer; color: blue; text-decoration: underline;"> Edit Profile </label>
    </p>
    <hr>
    <hr>

    <!-- Personal & Account: JOB ONES -->

    <div class="Two-Textbox">
    
    <div class="Top-Bottom">
    <h4>DRIVER ID: </h4>
    <input type="text" value="<?php echo $D_ID ?>" disabled>
    </div>

    <div class="Top-Bottom">
    <h4>UNIT TYPE: </h4>
    <input type="text" value="<?php echo $D_UnitType ?>" disabled>
    </div>

    </div>

    <div class="Two-Textbox">
    <div class="Top-Bottom">
    <h4> HUB: </h4>
    <input type="text" value="<?php echo  $D_Hub ?>" disabled>
    <hr>
    </div>
    </div>

    <hr>

    <!-- Personal & Account: PERSON -->

    <div class="Two-Textbox">
    
    <div class="Top-Bottom">
    <h4>FIRST NAME: </h4>
    <input type="text" value="<?php echo $D_FN ?>" disabled>
    </div>

    <div class="Top-Bottom">
    <h4>LAST NAME: </h4>
    <input type="text" value="<?php echo $D_LN ?>" disabled>
    </div>

    </div>

    <div class="Two-Textbox">
    
    <div class="Top-Bottom">
    <h4>MIDDLE NAME: </h4>
    <input type="text" value="<?php echo $D_MN ?>" disabled>
    </div>

    <div class="Top-Bottom">
    <h4>SUFFIX: </h4>
    <input type="text" value="<?php echo $D_Sfx ?>" disabled>
    </div>

    </div>

    <div class="Two-Textbox">
    
    <div class="Top-Bottom">
    <h4>AGE: </h4>
    <input type="text" value="<?php echo $D_Age ?>" disabled>
    </div>

    <div class="Top-Bottom">
    <h4>DATE OF BIRTH: </h4>
    <input type="date" value="<?php echo $D_DOB?>" disabled>
    </div>

    </div>
    
    <div class="Two-Textbox">
    
    <div class="Top-Bottom">
    <h4>Gender: </h4>

    <select  id="myDropdown" disabled>
        <option value="" selected><?php echo $D_Gender ?></option>
        <option value="option1">Option 1</option>
    </select>

    </div>
    </div>

    <hr>

    <!-- Personal & Account: Account -->

    <div class="Top-Bottom">
    <h4> Username: </h4>
    <input type="text" value="<?php echo $D_Username ?>" disabled>
    </div>

    <div class="Top-Bottom">
    <h4> Password: </h4>
    <input type="password" value="<?php echo $D_Password?>" disabled>
    </div>


</html>
</body>