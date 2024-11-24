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
    <title>Reset Password</title>
    <link rel="stylesheet" href="../LoginSignup/employee.css">
    <script>
        function validatePasswords(event) {
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-new-password').value;

            if (newPassword !== confirmPassword) {
                alert('Passwords do not match. Please try again.');
                event.preventDefault(); // Stop form submission
            }
        }
    </script>
</head>
<body>
    <form action="process-reset-pass.php" method="post" onsubmit="validatePasswords(event)">

        <!-- Form Container -->
        <div class="form-container">
            <div class="col col-1">
                <div class="image-layer">
                    <img src="../LoginSignup/IMG/IMG1.png" class="form-image rider">
                </div>
                <p class="featured-word">Your one-stop workforce <span>Solution.</span></p>
            </div>

            <div class="col col-2">
                <div class="btn-box">
                    <button type="button" class="btn btn-1" id="signin">Login</button>
                    <button type="button" class="btn btn-2" id="signup">Register</button>
                </div>

                <!-- New Password Form Container -->
                <div class="new-password-form">
                    <div class="form-title">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <span>Reset Password</span>
                    </div>
                    <div class="form-input">
                        <div class="input-box">
                            <input type="password" class="input-field" id="new-password" placeholder="New Password" name="Password" required>
                            <span class="toggle-password" onclick="togglePassword('new-password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" id="confirm-new-password" placeholder="Confirm Password" name="Password_Confirm" required>
                            <span class="toggle-password" onclick="togglePassword('confirm-new-password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div class="input-box">
                            <button type="submit" class="input-submit" id="reset-password-btn">
                                <span>Reset Password</span>
                            </button>
                        </div>
                    </div>
                </div>     
                

            </div>
        </div>
    </form>
</body>
</html>
