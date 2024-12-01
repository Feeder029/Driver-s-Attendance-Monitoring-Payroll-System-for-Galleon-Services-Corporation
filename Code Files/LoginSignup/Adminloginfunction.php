<?php
session_start();

require '../DatabaseConnection/Database.php';

$AccDetails = "SELECT a.`ACC_Username`, a.`ACC_Password`, b.`ACCS_Status`, c.`TL_ID` FROM account a
JOIN account_status b ON a.ACC_StatusID = b.ACCS_ID
JOIN teamlead_information c ON a.ACC_ID = c.TL_AccountID";


$AccInfo= mysqli_query($conn, $AccDetails);            

if (!$AccInfo) {
    die("Query failed: " . mysqli_error($conn));
};

$ADDACC_COUNT = 0; //Array for Vehicles
// Put Driver Results in a Variable so we can easily use it later on
while ($row = mysqli_fetch_assoc($AccInfo)) {
 
    //Drivers Account Variable
    $ADACC[$ADDACC_COUNT] = [
        "Username" => $row["ACC_Username"],
        "Password" => $row["ACC_Password"],
        "Status"=> $row["ACCS_Status"],
        "ID" => $row["TL_ID"],
    ];

    $ADDACC_COUNT += 1;
};


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $Acc = false;

    for ($i = 0; $i < count($ADACC); $i++) {
        if ($user == $ADACC[$i]["Username"] && $pass == $ADACC[$i]["Password"]) {
            $Acc = true;
            if ($ADACC[$i]["Status"] == "Active") {
                $_SESSION['DVID'] = $ADACC[$i]["ID"];
                header("Location: ../HTML Files/MainAdminDashboard.php");
                exit();
            } else if ($ADACC[$i]["Status"] == "Inactive") {
                header("Location: ../LoginSignup/AdminLoginRegister.php?error=inactive");
                exit();
            } else {
                header("Location: ../LoginSignup/AdminLoginRegister.php?error=pending");
                exit();
            }
        }
    }

    // If no match is found, redirect with an error message
    if (!$Acc) {
        header("Location: ../LoginSignup/AdminLoginRegister.php?error=invalid");
        
        exit();
    }
}


?>