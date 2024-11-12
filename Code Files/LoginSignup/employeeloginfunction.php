<?php
session_start();



//Connect to Database
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gsc_attendanceandpayrolltest";
$conn = "";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if ($conn) {
} else {
    die("Connection failed: " . mysqli_connect_error());
}


$AccDetails = "SELECT a.`ACC_Username`, a.`ACC_Password`, b.`ACCS_Status`, c.`DI_ID` FROM account a
JOIN account_status b ON a.ACC_AcountStatID = b.ACCS_ID
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

    for ($i = 0; $i < count($DRVACC); $i++) { // Use count() for the array length
        if ($user == $DRVACC[$i]["Username"] && $pass == $DRVACC[$i]["Password"]) { // Use == for comparison
            $DVID = $DRVACC[$i]["ID"];
            $_SESSION['DVID'] = $DVID; // Save DVID to the session
            header("Location: ../Employee PHP/EMP_INDEX.PHP");
            exit(); // Ensure no further code is executed after the redirect
        }
    }
    // Redirect here if no match is found
    header("Location: ../LoginSignup/employeelogin.php");
    exit();    
}

?>