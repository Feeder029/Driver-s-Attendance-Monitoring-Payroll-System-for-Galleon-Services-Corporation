<?php
require '../DatabaseConnection/Database.php';


$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$resetsql = "SELECT * FROM account a WHERE ACC_ResetTokenHash = ?";
$stmt = $conn->prepare($resetsql);

$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user===null){
    die("token not found");
}

if (strtotime($user["ACC_ResetExpire"]) <= time()){
    die("token has expired");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>RESET PASSWORD</h1>
    <form action="process-reset-pass.php" method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="Password">New Password</label>
        <input type="Password" id="Password" name="Password">

        <label for="Password">Confirm Password</label>
        <input type="Password" id="Password_Confirm" name="Password_Confirm">


        <button>SEND</button>
    </form>
</body>
</html>