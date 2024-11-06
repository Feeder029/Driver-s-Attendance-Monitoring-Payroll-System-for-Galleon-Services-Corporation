<?php
    include("employee_profile.php");


 
// Connection for the Personal and Account Form

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
    $GNO = htmlspecialchars($_POST['GcashNo']);
    $GNA = htmlspecialchars($_POST['GcashName']);
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
     $SX, $DriverID,$HN,$LT,$ST,$BY,$CY,$PV,$ZP,$GNO,$GNA);

     header(header: "Location: EMP_INDEX.PHP"); // Refresh for updated one!
     exit(); 
}




//Function for update in Personal & Account Details
function Personal_AccountUpdate($conn,$AG,$UT,$HB,$DB,$FN, $LN , $GD, $UR , $PS,$MN, $SX, $DriverID,$HN,$LT,$ST,$BY,$CY,$PV,$ZP,$GNO,$GNA) {
    //Update Code
    $UpdateAccandPer =
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
        a.`Gcash_No` = '$GNO',
        a.`GCash_Name` = '$GNA',
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
    
    
    $UpdateQuery = mysqli_query($conn, $UpdateAccandPer);
    if (!$UpdateQuery) {
        echo "non-working";
        die("Query failed: " . mysqli_error($conn));
    }
}





mysqli_close($conn)

?>