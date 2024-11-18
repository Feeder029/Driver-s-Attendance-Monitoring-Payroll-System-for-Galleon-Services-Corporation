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
    // $ZP = htmlspecialchars($_POST['Zip']);


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
     $SX, $DriverID,$HN,$LT,$ST,$BY,$CY,$PV,$GNO,$GNA);

     header(header: "Location: EMP_INDEX.PHP"); // Refresh for updated one!
     exit(); 
}




//Function for update in Personal & Account Details using Prepared Statements
function Personal_AccountUpdate($conn, $AG, $UT, $HB, $DB, $FN, $LN, $GD, $UR, $PS, $MN, $SX, $DriverID, $HN, $LT, $ST, $BY, $CY, $PV, $GNO, $GNA) {
    //Update Code using prepared statement
    $UpdateAccandPer = 
    "UPDATE driver_information a
    JOIN driver_name c ON a.DI_NameID = c.DN_ID
    JOIN account b on a.`DI_AccountID` = b.`ACC_ID`
    JOIN driver_address d on a.`DI_AddressID` = d.`DA_ID`
    SET
        a.`DI_Age` = ?, 
        a.`DI_UnitTypeID` = ?, 
        a.`DI_HubAssignedID` = ?, 
        a.`DI_DOB` = ?, 
        a.`DI_Gender` = ?, 
        a.`Gcash_No` = ?, 
        a.`GCash_Name` = ?, 
        b.`ACC_Username` = ?, 
        b.`ACC_Password` = ?, 
        c.`DN_FName` = ?, 
        c.`DN_LName` = ?, 
        c.`DN_MName` = ?, 
        c.`DN_Suffix` = ?, 
        d.`DA_HouseNo` = ?, 
        d.`DA_LotNo` = ?, 
        d.`DA_Street` = ?, 
        d.`DA_Barangay` = ?, 
        d.`DA_City` = ?, 
        d.`DA_Province` = ?
    WHERE a.DI_ID = ?";

    $stmt = $conn->prepare($UpdateAccandPer);

    if ($stmt === false) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param(
        "iiissssssssssssssssi",$AG,$UT,$HB,$DB,$GD,$GNO,$GNA,$UR,$PS,$FN,$LN,$MN,$SX,$HN,$LT,$ST,$BY,$CY,$PV,$DriverID
    );

    if ($stmt->execute()) {
    } else {
        echo "Update failed: " . $stmt->error;
    }

    $stmt->close();
}





mysqli_close($conn)

?>