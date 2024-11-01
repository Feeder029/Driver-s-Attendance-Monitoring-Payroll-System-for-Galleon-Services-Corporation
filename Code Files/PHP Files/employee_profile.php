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

//Mysql Code to Select every drivers information
$DriverInfo = mysqli_query($conn, $DriversDetails);            

if (!$DriverInfo) {
    die("Query failed: " . mysqli_error($conn));
}
// Put Driver Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($DriverInfo)) {
 
    //Drivers Variable
    $DRV = [
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
        "Profile" => base64_encode($row['ACC_ProfilePicture']),
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

//Mysql Code to Select every drivers vehicles
$VehiclesDetails = "SELECT a.DV_VehiclePlate,a.DV_ORImg,a.DV_CRImg FROM driver_vehicle a
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
        "Plate" =>  $row['DV_VehiclePlate'],
        "OR" => base64_encode($row['DV_ORImg']),
        "CR" => base64_encode($row['DV_CRImg'])
    ];
    $Vehicle_Count += 1;
}


// Connection to get in the HtmlDesign 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Assigning Values to a Variable (I use htmlspecialchars cause youtube says it make it safe somehow)
    $FN = htmlspecialchars($_POST['FirstName']);
    $LN = htmlspecialchars($_POST['LastName']);
    $UR = htmlspecialchars($_POST['User']);
    $PS= htmlspecialchars($_POST['Password']);
    $MN = htmlspecialchars($_POST['Middle']);
    $SX = htmlspecialchars($_POST['Suffix']);
    $AG = htmlspecialchars($_POST['Age']);
    $DB = htmlspecialchars($_POST['DOB']);
    $HN = htmlspecialchars($_POST['House']);
    $LT = htmlspecialchars($_POST['Lot']);
    $ST = htmlspecialchars($_POST['Street']);
    $BY = htmlspecialchars($_POST['barangay']);
    $CY = htmlspecialchars($_POST['city']);
    $PV = htmlspecialchars($_POST['province']);
    $ZP = htmlspecialchars($_POST['Zip']);

    if (isset($_POST['gender'])) {
        $GD = $_POST['gender']; 
    } else {
        $GD = 'Others';
    }

    if (isset($_POST['unittype'])) {
        $UT = $_POST['unittype'];
        echo $UT;
        } else {
        echo "Not working";
    }

    if (isset($_POST['hub'])) {
        $HB = $_POST['hub'];
        echo $HB;
        } else {
        echo "Not working";
    }



    Personal_AccountUpdate($conn,$AG, $UT,$HB,$DB, $FN, $LN , $GD, $UR , $PS,$MN,
     $SX, $DriverID,$HN,$LT,$ST,$BY,$CY,$PV,$ZP);

    header(header: "Location: " . $_SERVER['PHP_SELF']);
    exit(); 
}


//Function for update in Personal & Account Details
function Personal_AccountUpdate($conn,$AG,$UT,$HB,$DB,$FN, $LN , $GD, $UR , $PS,$MN, $SX, $DriverID,$HN,$LT,$ST,$BY,$CY,$PV,$ZP) {
    //Update Code
    $REPLACE =
    "UPDATE driver_information a
    JOIN driver_name c ON a.DI_NameID = c.DN_ID
    JOIN account b on a.`DI_AccountID` = b.`ACC_ID`
    JOIN driver_address d on a.`DI_AddressID` = d.`DA_ID`
    SET
        a.`DI_Age` = $AG,
        a.`DI_UnitTypeID` = $UT,
        a.`DI_HubAssignedID` = $HB,
        a.`DI_DOB` = '$DB',
        a.`DI_Gender` = '$GD',
        b.`ACC_Username` = '$UR',
        b.`ACC_Password` = '$PS',
        c.`DN_FName` = '$FN',
        c.`DN_LName` = '$LN',
        c.`DN_MName` = '$MN',
        c.`DN_Suffix` = '$SX',
        d.`DA_HouseNo` = '$HN', 
        d.`DA_LotNo` = '$LT', 
        d.`DA_Street` = '$ST', 
        d.`DA_Barangay` = '$BY',
        d.`DA_City` = '$CY', 
        d.`DA_Province` = '$PV',
        d.`DA_ZipCode` = '$ZP'
    WHERE a.DI_ID = $DriverID;";
    
    
    $Replacement = mysqli_query($conn, $REPLACE);
    if (!$Replacement) {
        echo "non-working";
        die("Query failed: " . mysqli_error($conn));
    }
}

mysqli_close($conn)

?>


