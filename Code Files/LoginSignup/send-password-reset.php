<?php
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

$username = $_POST["Username"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256",$token);
$expiry = date("Y-m-d H:i:s",time() + 60 * 30);

$sql = "UPDATE account
SET ACC_ResetTokenHash= ?,
ACC_ResetExpire = ?
WHERE ACC_Username = ? AND ACC_AcountStatID = 2;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss",  $token_hash, $expiry,$username);
$stmt ->execute();

if ($mysqli->affected_rows) {

}

?>