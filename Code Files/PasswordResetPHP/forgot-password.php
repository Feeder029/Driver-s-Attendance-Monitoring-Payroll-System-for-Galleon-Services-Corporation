<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT PASSWORD</title>
    <link rel="stylesheet" href="../LoginSignup/employee.css?v=1.3">
</head>
<body>



     <?php
      if (isset($_GET['Driver'])) {
        $image = "../LoginSignup/IMG/IMG1.png";
        $Role = 'Driver';
        $Backto = 'back-to-login';

        switch ($_GET['Driver']){
        case 'Submitted':
            $ShowForm = 'block';
            $IsDisabled = 'disabled';
        break;

        default: 
        $ShowForm = 'none';
        $IsDisabled = '';             
        break;
        }
      } else if(isset($_GET['Admin'])) {
        $image = "../LoginSignup/IMG/IMG2.png";
        $Role = 'Admin';
        $Backto = 'back-to-Admin';


        switch ($_GET['Admin']){
        case 'Submitted':
            $ShowForm = 'block';
            $IsDisabled = 'disabled';
        break;

        default: 
        $ShowForm = 'none';
        $IsDisabled = '';             
        break;
        }
      }
    ?>

    <form action="send-password-reset.php" method="post">

    <input type="hidden" name="Role" value="<?php echo $Role?>">
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src= "<?php echo $image ?>" class="form-image rider">
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
                        <input type="email" class="input-field" placeholder="Enter your registered email" name="Email" <?php echo $IsDisabled ?> required>
                        <i class="bx bx-envelope icon"></i>
                    </div>
                    <p class="info-text">We'll send a reset password link to your email.</p>
                    <div class="input-box">
                        <button class="input-submit" id="send-reset-link"  <?php echo $IsDisabled ?>>
                            <span>Send Reset Link</span>
                        </button>
                    </div>
                    <div class="input-box">
                        <button class="btn btn-6" id="back-to-login" type="<?php echo $Backto ?>"  <?php  echo $IsDisabled ?>>Back to Login</button>
                    </div>
                </div>
            </div>

           

        <div id="floating-info" class="floating-info" style="display: <?php echo $ShowForm?>;">
            <div class="info-content">
                <p>Message sent successfully! Message sent to your email. Please check your inbox.</p>
                <button type="button"id="close-info-btn">Close</button>
             </div>
        </div>
           
           
           
    </div>
    </div>

    </form>

    <script>
    const closeInfoBtn = document.getElementById("close-info-btn");

    // Add event listener to the "Close" button
    closeInfoBtn.addEventListener("click", function() {
        // Hide the floating-info div
        const floatingInfo = document.getElementById("floating-info");
        floatingInfo.style.display = "none";

        // Enable all form elements
        const emailInput = document.querySelector("input[name='Email']");
        const sendResetLinkButton = document.getElementById("send-reset-link");
        const backToLoginButton = document.getElementById("back-to-login");

        emailInput.removeAttribute("disabled");
        sendResetLinkButton.removeAttribute("disabled");
        backToLoginButton.removeAttribute("disabled");
    });
    // Redirect to login page when "Back to Login" button is clicked
    document.getElementById("back-to-login").addEventListener("click", function() {
        window.location.href = "../LoginSignup/employeelogin.php"; // Replace with the correct path to your login page
    });

    document.getElementById("back-to-Admin").addEventListener("click", function() {
        window.location.href = "../LoginSignup/AdminLoginRegister.php.php"; // Replace with the correct path to your login page
    });

    document.getElementById("signin").addEventListener("click", function() {
        window.location.href = "../LoginSignup/employeelogin.php"; // Replace with the correct path to your login page
    });
</script>

</body>
</html>


