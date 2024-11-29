<?php
session_start();

require '../DatabaseConnection/Database.php';

$AccDetails = "SELECT a.`ACC_Username`, a.`ACC_Password`, b.`ACCS_Status`, c.`DI_ID` FROM account a
JOIN account_status b ON a.ACC_StatusID = b.ACCS_ID
JOIN driver_information c ON a.ACC_ID = c.DI_AccountID;";


$AccInfo= mysqli_query($conn, $AccDetails);            

if (!$AccInfo) {
    die("Query failed: " . mysqli_error($conn));
};

$DRVACC_COUNT = 0; //Array for Vehicles
// Put Driver Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($AccInfo)) {
 
    //Drivers Account Variable
    $DRVACC[$DRVACC_COUNT] = [
        "Username" => $row["ACC_Username"],
        "Password" => $row["ACC_Password"],
        "Status"=> $row["ACCS_Status"],
        "ID" => $row["DI_ID"],
    ];

    $DRVACC_COUNT += 1;
};


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $Acc = false;

    for ($i = 0; $i < count($DRVACC); $i++) {
        if ($user == $DRVACC[$i]["Username"] && $pass == $DRVACC[$i]["Password"]) {
            if ($DRVACC[$i]["Status"] == "Active") {
                $_SESSION['DVID'] = $DRVACC[$i]["ID"];
                header("Location: ../Employee PHP/EMP_INDEX.PHP");
                exit();
            } elseif ($DRVACC[$i]["Status"] == "Inactive") {
                header("Location: ../LoginSignup/employeelogin.php?error=inactive");
                exit();
            } else {
                header("Location: ../LoginSignup/employeelogin.php?error=pending");
                exit();
            }
        }
    }

    // If no match is found, redirect with an error message
    if (!$Acc) {
        header("Location: ../LoginSignup/employeelogin.php?error=invalid");
        exit();
    }
}


?>