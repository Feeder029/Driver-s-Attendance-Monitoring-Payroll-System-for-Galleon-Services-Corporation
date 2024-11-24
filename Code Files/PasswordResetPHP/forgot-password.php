<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT PASSWORD</title>
    <link rel="stylesheet" href="../LoginSignup/employee.css">
</head>
<body>


    <form action="send-password-reset.php" method="post">

    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="../LoginSignup/IMG/IMG1.png" class="form-image rider">
            </div>
            <p class="featured-word">Your one-stop workforce <span>Solution.</span></p>
        </div>
    
        <div class="col col-2">
            <div class="btn-box">
                <button class="btn btn-1" id="signin">Login</button>
                <button class="btn btn-2" id="signup">Register</button>
            </div>

            <!-- Forgot Password Form Container -->
            <div class="forgot-password-form" > <!-- Initially hidden -->
                <div class="form-title">
                    <span>Forgot Password</span>
                </div>
                <div class="form-input">
                    <div class="input-box">
                        <input type="email" class="input-field" placeholder="Enter your registered email" name="Email" required>
                        <i class="bx bx-envelope icon"></i>
                    </div>
                    <p class="info-text">We'll send a reset password link to your email.</p>
                    <div class="input-box">
                        <button class="input-submit" id="send-reset-link">
                            <span>Send Reset Link</span>
                        </button>
                    </div>
                    <div class="input-box">
                        <button class="btn btn-6" id="back-to-login" type="button">Back to Login</button>
                    </div>
                </div>
            </div>
    </div>
    </div>

    </form>

    <script>
        // Redirect to login page when "Back to Login" button is clicked
        document.getElementById("back-to-login").addEventListener("click", function() {
            window.location.href = "../LoginSignup/employeelogin.php"; // Replace with the correct path to your login page
        });
        document.getElementById("signin").addEventListener("click", function() {
            window.location.href = "../LoginSignup/employeelogin.php"; // Replace with the correct path to your login page
        });
    </script>

</body>
</html>


