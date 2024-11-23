<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="employeeregisterfunction.php" method="post">
            <!-- Password Form Container -->
            <div class="password-form">
                <div class="form-title">
                    <span>Username & Password</span>
                </div>
                <div class="input-box">
                        <input type="text" class="input-field" placeholder="Username" name="user" required>
                        <i class="bx bx-user icon"></i>
                    </div>
                    
                 <!-- Password Input Fields -->
                 <div class="input-box">
                    <input type="password" class="input-field" id="desired-password" placeholder="Desired Password"  name="pass"  required>
                    <span class="toggle-password" onclick="togglePassword('desired-password', this)">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" id="confirm-password" placeholder="Confirm Password" required>
                    <span class="toggle-password" onclick="togglePassword('confirm-password', this)">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="remember-me" name="remember-me">
                    <label for="remember-me" class="slider"></label>
                    <span>Remember Me</span>
                </div>

           <!-- Terms and Conditions Checkbox -->
                <div class="checkbox-containerterm">
                    <input type="checkbox" id="terms-conditions" name="terms-conditions" required>
                    <label for="terms-conditions">I agree to the <a href="#" id="terms-link" class="terms-link">Terms and Conditions</a></label>
                </div>

                <div class="input-box">
                    <button type="submit" class="input-submit" id="submit-button">
                        <span>Submit</span>
                    </button>
                </div>

           <!-- Information Box for Terms and Conditions -->
                <div id="terms-info" class="terms-info" style="display: none;">
                    <div class="terms-content">
                        <h3>Terms and Conditions</h3>
                        <p>
                            <!-- Replace the text below with your actual terms and conditions -->
                            By using this service, you agree to the following terms and conditions. Please read them carefully.
                            1. You must be 18 years or older.
                            2. All users must provide accurate information.
                            3. ...
                        </p>
                        <button id="close-terms">Close</button>
                    </div>
                </div>
            </div>
</form>

<script src="employee.js?v=1.2"></script>

</body>
</html>