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
$DriversInfo = 
"SELECT a.`DI_ID`, c.`DN_FName`, c.`DN_MName`, c.`DN_LName`, c.`DN_Suffix`, a.`DI_Age`, a.`DI_ContactNo`, a.`DI_Gender`, a.`DI_DOB`, a.`DI_Email`,
a.`DI_LicenseImg`, a.`DI_BrgyClearanceImg`, a.`DI_PoliceClearanceImg`,
a.`DI_NBIClearanceImg`, a.`Gcash_No`, a.`GCash_Name`,
b.`ACC_Username`, b.`ACC_Password`, b.`ACC_ProfilePicture`,
d.`DA_HouseNo`, d.`DA_LotNo`, d.`DA_Street`, d.`DA_Barangay`,
d.`DA_City`, d.`DA_Province`, d.`DA_ZipCode`, e.`DUT_UnitType`,
f.`DV_VehiclePlate`, f.`DV_ORImg`, f.`DV_CRImg`,
g.`HASS_Name`, h.`GOV_PhilHealthNo`, h.`GOV_SSSNo`, h.`GOV_PagibigNo`
FROM driver_information a
JOIN account b on a.`DI_AccountID` = b.`ACC_ID`
JOIN driver_name c on a.`DI_NameID` = c.`DN_ID`
JOIN driver_address d on a.`DI_AddressID` = d.`DA_ID`
JOIN driver_unit_type e on a.`DI_UnitTypeID` = e.`DUT_ID`
JOIN driver_vehicle f on a.`DI_VehicleID` = f.`DV_ID`
JOIN hub_assigned g on a.`DI_HubAssignedID` = g.`HASS_ID`
JOIN government_information h on a.`DI_GovInfoID` = h.`GOV_ID` where a.`DI_ID` = $DriverID;";

$result = mysqli_query($conn, $DriversInfo);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Put Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($result)) {
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
    $D_Plate = $row['DV_VehiclePlate'];
    $D_Hub = $row['HASS_Name'];
    $D_PhilHealth = $row['GOV_PhilHealthNo'];
    $D_SSS = $row['GOV_SSSNo'];
    $D_Pagibig = $row['GOV_PagibigNo'];
}

mysqli_close($conn)
?>


</body>
<p> 
<?php echo "<h2>Driver Information</h2>";
echo "Driver ID: $D_ID<br>";
echo "Name: $D_FN $D_MN $D_LN $D_Sfx<br>";
echo "Age: $D_Age<br>";
echo "Contact No: $D_CN<br>";
echo "Gender: $D_Gender<br>";
echo "Date of Birth: $D_DOB<br>";
echo "Email: $D_Email<br>";
echo "GCash No: $D_GcashNo<br>";
echo "GCash Name: $D_GCash_Name<br>";
echo "Username: $D_Username<br>";
echo "Password: $D_Password<br>";
echo "Address: $D_HouseNo, $D_LotNo, $D_Street, $D_Barangay, $D_City, $D_Province, $D_Zip<br>";
echo "Unit Type: $D_UnitType<br>";
echo "Vehicle Plate: $D_Plate<br>";
echo "Hub Assigned: $D_Hub<br>";
echo "PhilHealth No: $D_PhilHealth<br>";
echo "SSS No: $D_SSS<br>";
echo "Pagibig No: $D_Pagibig<br>";
?>

</p>
</html>
