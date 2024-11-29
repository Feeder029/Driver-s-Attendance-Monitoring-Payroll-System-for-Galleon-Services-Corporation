<?php

session_start();
require '../DatabaseConnection/Database.php';

//Options for Hubs
$hubcount = 0;
$Hub_OptionCodes = "SELECT hub_ID,hub_Name FROM hub;";
$Hub_Option = mysqli_query($conn, $Hub_OptionCodes);            
if (!$Hub_Option) {
    die("Query failed: " . mysqli_error($conn));
} while ($row = mysqli_fetch_assoc($Hub_Option)) {
    $Hub[$hubcount] = $row['hub_Name'];
    $HubID[$hubcount] = $row['hub_ID'];
    $hubcount++;
}

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


?>