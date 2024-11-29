<?php

require '../DatabaseConnection/Database.php';

$email = $_POST["Email"];
$Role = $_POST["Role"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256",$token);
$expiry = date("Y-m-d H:i:s",time() + 60 * 30);

$sql = "UPDATE account  a
JOIN driver_information b on a.`ACC_ID` = b.`DI_AccountID`
SET a.`ACC_ResetTokenHash`= ?,
a.`ACC_ResetExpire` = ?
WHERE b.`DI_Email`= ? AND ACC_StatusID= 2;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss",  $token_hash, $expiry,$email);
$stmt ->execute();

if ($conn->affected_rows) {
require "emailsend.php";
SendEmail($email,$token);
}
echo("Message Sent,Please check your inbox"); // Delete once the Account is
header(header: "Location: ../PasswordResetPHP/forgot-password.php?$Role=Submitted");
?>