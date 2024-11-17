<?php
require '../DatabaseConnection/Database.php';

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

// Fetch user based on the token hash
$resetsql = "SELECT * FROM account a WHERE ACC_ResetTokenHash = ?";
$stmt = $conn->prepare($resetsql);

$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found"); //Replace Token is Not Found
}

// Check if the token has expired
if (strtotime($user["ACC_ResetExpire"]) <= time()) {
    die("Token has expired"); //Replace Token is Expired
}

$Pass = $_POST["Password"];
$ID = $user["ACC_ID"]; // Use the ID from the fetched user

// Update the account
$sql = "UPDATE account a
SET 
    a.`ACC_Password` = ?, 
    a.`ACC_ResetTokenHash` = NULL,
    a.`ACC_ResetExpire` = NULL
WHERE a.`ACC_ResetTokenHash` = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

// Bind parameters
$stmt->bind_param("ss", $Pass, $token_hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header(header: "Location: ../LoginSignup/employeelogin.php"); // Refresh for updated one!
    echo "Password updated successfully"; //Replace Successful Form
} else {
    echo "Password update failed or no changes made"; //If nothing is updated
}

$stmt->close();
$conn->close();
?>
