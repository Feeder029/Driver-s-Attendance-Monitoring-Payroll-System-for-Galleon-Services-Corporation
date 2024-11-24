<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galleon Services Corp | Login & Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- STYLE -->
    <link rel="stylesheet" href="employee.css?v=1.1">

      <!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

<?php
require "HubandType.php";
?>

    <!-- Form Container -->
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="IMG/IMG1.png" class="form-image rider">
            </div>
            <p class="featured-word">Your one-stop workforce <span>Solution.</span></p>
        </div>
    
        <div class="col col-2">
            <div class="btn-box">
                <button class="btn btn-1" id="signin">Login</button>
                <button class="btn btn-2" id="signup">Register</button>
            </div>


            <?php
         // Check if there's an error in the query string
           $error_message = '';
        if (isset($_GET['error'])) {
        switch ($_GET['error']) {
        case 'invalid':
            $error_message = 'Invalid username or password.';
            break;
        case 'inactive':
            $error_message = 'Your account is inactive. Please contact the company.';
            break;
        case 'pending':
            $error_message = 'Your account is pending approval. Please wait for an admin to accept your registration.';
            break;
        default:
            $error_message = 'An error occurred. Please try again.';
            break;
        }
        }
        ?>

 <form action="employeeloginfunction.php" method="post">
            <!-- Login Form Container -->
            <div class="login-form">
                <div class="form-title">
                    <span>Login</span>
                </div>
                <div class="form-input">
            <!-- Display Error Message -->
            <?php if ($error_message): ?>
                <p class="errormessage"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Username" name="user" required>
                        <i class="bx bx-user icon"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" placeholder="Password" name="pass" required>
                        <i class="bx bx-lock-alt icon"></i>
                    </div>
                    <div class="forgot-pass">
                        <a href="../PasswordResetPHP/forgot-password.php?Driver">Forgot Password?</a>
                    </div>
                    <div class="input-box">
                        <button type="submit" class="input-submit">
                            <span>Login</span>  
                        </button>
                    </div>
                </div>
            </div>
            </form>

 <form action="employeeregisterfunction.php" method="post" enctype="multipart/form-data">
            <!-- Register Form Container -->
            <div class="register-form">
                <div class="form-title">
                    <span>Create Account</span>
                </div>
                <div class="form-input">
                    <div class="input-box name-info">
                        <input type="text" class="input-field" placeholder="Last Name" name="lname" required>
                        <input type="text" class="input-field" placeholder="First Name" name="fname" required>
                    </div>
                    <div class="input-box name-info">
                        <input type="text" class="input-field" placeholder="Middle Name" name="mname" >
                        <input type="text" class="input-field" placeholder="Suffix (e.g., Jr., Sr.)" name="sfx">
                    </div>
                    <div class="input-box">
                        <label for="birthdate" class="input-label bday">Birthdate</label>
                        <input type="date" id="birthdate" class="input-field" placeholder="MM/DD/YYYY" name="DOB" required>
                    </div>
                    <div class="input-box gender-age">
                        <select id="gender" class="input-field" name="Gender" required>
                            <option value="" disabled selected >Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="number" id="age" class="input-field" placeholder="Age" name="Age" required>
                    </div>
                    <div class="input-box file">
                        <label for="profile-photo" class="input-label" >Upload a profile photo</label>
                            <input type="file" class="input-field image-input" accept="image/*" name="Profile" required>
                    </div>
                </div>
                <div class="input-box btn-box button">
                    <button type="button" class="btn btn-3" id="next1">Next</button>
                    
                </div>
            </div>
    
            <!-- Address Form Container -->
            <div class="address-form" style="display: none;"> <!-- Initially hidden -->
                <div class="form-title">
                    <span>Contact & Address</span>
                </div>
                <div class="form-input">
                    <div class="input-box contact">
                        <input type="email" class="input-field" placeholder="Email" name="Email" required>
                    </div>
                    <div class="input-box address">
                        <select id="province" class="input-field" >
                        </select>
                        <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>

                        <select id="city" class="input-field" >
                        </select>
                        <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>

                      </div>
                      <!-- Barangay Dropdown and Street Input -->
                      <div class="input-box address">
                        <select id="barangay" class="input-field" >
                        </select>
                        <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>


                        <input type="text" class="input-field" placeholder="Street" name="Street">
                      </div>
                    <div class="input-box address">
                        <input type="text" class="input-field" placeholder="House Number" name="HouseNo">
                        <input type="text" class="input-field" placeholder="Lot Number" name="LotNo">
                    </div>
                    <div class="input-box address">
                        <input type="text" class="input-field" placeholder="ZIP Code" name="Zip" required>
                        <input type="tel" class="input-field" placeholder="Contact Number" name="Contact" required>
                    </div>
                    <div class="input-box btn-box button">
                        <button class="btn btn-6" id="back1"  type="button" >Back</button>
                        <button class="btn btn-4" id="next2"  type="button" >Next</button>
                    </div>
                </div>
            </div>

            <!-- Vehicle Form Container -->
            <div class="vehicle-form" style="display: none;"> <!-- Initially hidden -->
                <div class="form-title">
                    <span>Vehicle Information</span>
                </div>
                <div class="form-input">
                    <div class="input-box input">
                        <input type="text" class="input-field" placeholder="Rider ID Number" name="DriverID">
                        <select class="input-field" name="UnitID" required>
                            <option value="" disabled selected>Select Rider Type</option>
                            <?php 
                             for ($i = 0; $i < count($UnitTypes); $i++) {
                              echo '<option value="' . htmlspecialchars($UnitTypesID[$i]) . '"' .'>' . htmlspecialchars($UnitTypes[$i]) . '</option>';
                            }
                      ?>
                        </select>
                    </div>
                
                    <div class="input-box input">
                        <select class="input-field" name="HubID" required>
                            <option value="" disabled selected >Select Hub Name</option>
                            <?php 
                             for ($i = 0; $i < count($Hub); $i++) {
                              echo '<option value="' . htmlspecialchars($HubID[$i]) . '"' .'>' . htmlspecialchars($Hub[$i]) . '</option>';
                            }
                      ?>
                        </select>
                        <!-- <select class="input-field" >
                            <option value="" disabled selected>Select Hub Location</option>
                            <option value="location1">Location 1</option>
                            <option value="location2">Location 2</option>
                            <option value="location3">Location 3</option>
                        </select> -->
                    </div>

                    <div class="input-box file">
                        <div>
                            <label for="official-receipt" class="input-label" required>Upload a photo of OR</label>
                            <input type="file" class="input-field image-input" accept="image/*" name="OR">
                        </div>
                        <div>
                            <label for="certification" class="input-label" required >Upload a photo of CR</label>
                            <input type="file" class="input-field image-input" accept="image/*" name="CR">
                        </div>
                    </div>
                    <div class="input-box file">
                        <div>
                            <label for="license-f" class="input-label" required>Upload a photo of your License (Front)</label>
                            <input type="file" class="input-field image-input" accept="image/*" name="License">
                        </div>
                        <!-- <div>
                            <label for="license-b" class="input-label" >Upload a photo of your License (Back)</label>
                            <input type="file" class="input-field" accept="image/*" >
                        </div> -->
                    </div>
                    
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Vehicle Plate No." name="VehiclePlate" required>
                    </div>
                    <div class="input-box btn-box button">
                        <button class="btn btn-7" id="back2"  type="button"  >Back</button>
                        <button class="btn btn-5" id="next3"  type="button" >Next</button>
                    </div>
                </div>
            </div>


            <!-- Clearnace Form Container -->
            <div class="clearance-form" style="display: none;"> <!-- Initially hidden -->
                <div class="form-title">
                    <span>Clearance</span>
                </div>
                <div class="form-input">
                    
                
                    <div class="input-box">
                        <div>
                            <label for="brgy" class="input-label" >Upload a photo of Barangay Clearance</label>
                            <input type="file" class="input-field image-input" accept="image/*" name="Brgy" required>
                        </div>
                        <div>
                            <label for="police" class="input-label" >Upload a photo of Police Clearance</label>
                            <input type="file" class="input-field image-input" accept="image/*" name="Police" required>
                        </div>
                        <div>
                            <label for="nbi" class="input-label" >Upload a photo of NBI Clearance</label>
                            <input type="file" class="input-field image-input" accept="image/*" name="NBI" required>
                        </div>
                    </div>
                    <div class="input-box btn-box button">
                        <button class="btn btn-7" id="back3"  type="button" >Back</button>
                        <button class="btn btn-5" id="next4"  type="button" >Next</button>
                    </div>
                </div>
            </div>

            <!-- Benefits Form Container -->
            <div class="benefits-form" style="display: none;">
                <div class="form-title">
                    <span>Benefits & Gcash Information</span>
                </div>
                <div class="form-input">
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Gcash Account Name" name="GcashName" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Gcash Number" name="GcashNo" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Social Security System Number" name="SSS" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="PhilHealth Number" name="PH" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Pag-IBIG Number" name="PIBG" required>
                    </div>
                
                    <div class="input-box btn-box button">
                        <button class="btn btn-8" id="back4"  type="button" >Back</button>
                        <button class="btn btn-6" id="next5"  type="button" >Next</button>
                    </div>

                    </div>
                </div>


            <!-- Password Form Container -->
            <div class="password-form" style="display: none;">
                <div class="form-title">
                    <span>Username & Password</span>
                </div>
                <div class="input-box">
                        <input type="text" class="input-field" placeholder="Username" name="user" required>
                        <i class="bx bx-user icon"></i>
                    </div>
                 <!-- Password Input Fields -->
                 <div class="input-box">
                    <input type="password" class="input-field" id="desired-password" placeholder="Desired Password" name="pass" required>
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
                    <input type="checkbox" id="terms-conditions" name="terms-conditions" >
                    <label for="terms-conditions">I agree to the <a href="#" id="terms-link" class="terms-link">Terms and Conditions</a></label>
                </div>

                <div class="input-box">
                    <button class="input-submit" id="submit-button">
                        <span>Submit</span>
                    </button>
                </div>


           <!-- id="submit-button" -->
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
        </div>
        </form>

    <!-- JS -->
    <script src="employee.js?v=1.5"></script>
    <script src="../Dropdown-Json/ph-address-selector.js?v=1.1"></script>

</body>
</html>