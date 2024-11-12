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
    <link rel="stylesheet" href="employee.css">
</head>
<body>

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

            <form action="employeeloginfunction.php" method="post">
            <!-- Login Form Container -->
            <div class="login-form">
                <div class="form-title">
                    <span>Login</span>
                </div>
                <div class="form-input">
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Username" name="user" required>
                        <i class="bx bx-user icon"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" placeholder="Password" name="pass" required>
                        <i class="bx bx-lock-alt icon"></i>
                    </div>
                    <div class="forgot-pass">
                        <a href="#">Forgot Password?</a>
                    </div>
                    <div class="input-box">
                        <button type="submit" class="input-submit">
                            <span>Login</span>  
                        </button>
                    </div>
                </div>
            </div>
            </form>

            <!-- Register Form Container -->
            <div class="register-form">
                <div class="form-title">
                    <span>Create Account</span>
                </div>
                <div class="form-input">
                    <div class="input-box name-info">
                        <input type="text" class="input-field" placeholder="Last Name" required>
                        <input type="text" class="input-field" placeholder="First Name" required>
                    </div>
                    <div class="input-box name-info">
                        <input type="text" class="input-field" placeholder="Middle Name" required>
                        <input type="text" class="input-field" placeholder="Suffix (e.g., Jr., Sr.)">
                    </div>
                    <div class="input-box">
                        <label for="birthdate" class="input-label bday">Birthdate</label>
                        <input type="date" id="birthdate" class="input-field" placeholder="MM/DD/YYYY" required>
                    </div>
                    <div class="input-box gender-age">
                        <select id="gender" class="input-field" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="number" id="age" class="input-field" placeholder="Age" required>
                    </div>
                    <div class="input-box file">
                        <label for="profile-photo" class="input-label" required>Upload a profile photo</label>
                            <input type="file" class="input-field" accept="image/*" required>
                    </div>
                </div>
                <div class="input-box btn-box button">
                    <button class="btn btn-3" id="next1">Next</button>
                    
                </div>
            </div>
    
            <!-- Address Form Container -->
            <div class="address-form" style="display: none;"> <!-- Initially hidden -->
                <div class="form-title">
                    <span>Contact & Address</span>
                </div>
                <div class="form-input">
                    <div class="input-box contact">
                        <input type="email" class="input-field" placeholder="Email" required>
                    </div>
                    <div class="input-box address">
                        <select id="province" class="input-field" required>
                          <option value="">Select Province</option>
                          <option value="ProvinceA">Province A</option>
                          <option value="ProvinceB">Province B</option>
                          <option value="ProvinceC">Province C</option>
                        </select>
                        <select id="city" class="input-field" required>
                          <option value="">Select City/Municipality</option>
                        </select>
                      </div>
                      <!-- Barangay Dropdown and Street Input -->
                      <div class="input-box address">
                        <select id="barangay" class="input-field" required>
                          <option value="">Select Barangay</option>
                        </select>
                        <input type="text" class="input-field" placeholder="Street" required>
                      </div>
                    <div class="input-box address">
                        <input type="text" class="input-field" placeholder="House Number" required>
                        <input type="text" class="input-field" placeholder="Lot Number">
                    </div>
                    <div class="input-box address">
                        <input type="text" class="input-field" placeholder="ZIP Code" required>
                        <input type="tel" class="input-field" placeholder="Contact Number" required>
                    </div>
                    <div class="input-box btn-box button">
                        <button class="btn btn-6" id="back1">Back</button>
                        <button class="btn btn-4" id="next2">Next</button>
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
                        <input type="text" class="input-field" placeholder="Rider ID Number" required>
                        <select class="input-field" required>
                            <option value="" disabled selected>Select Rider Type</option>
                            <option value="full-time">Two Wheels</option>
                            <option value="part-time">Three Wheels</option>
                            <option value="contractor">Four Wheels</option>
                            <option value="contractor">Flexy</option>
                        </select>
                    </div>
                
                    <div class="input-box input">
                        <select class="input-field" required>
                            <option value="" disabled selected>Select Hub Name</option>
                            <option value="hub1">Hub 1</option>
                            <option value="hub2">Hub 2</option>
                            <option value="hub3">Hub 3</option>
                            <!-- Add more hub options as needed -->
                        </select>
                        <select class="input-field" required>
                            <option value="" disabled selected>Select Hub Location</option>
                            <option value="location1">Location 1</option>
                            <option value="location2">Location 2</option>
                            <option value="location3">Location 3</option>
                            <!-- Add more location options as needed -->
                        </select>
                    </div>

                    <div class="input-box file">
                        <div>
                            <label for="official-receipt" class="input-label" required>Upload a photo of OR</label>
                            <input type="file" class="input-field" accept="image/*" required>
                        </div>
                        <div>
                            <label for="certification" class="input-label" required>Upload a photo of CR</label>
                            <input type="file" class="input-field" accept="image/*" required>
                        </div>
                    </div>
                    <div class="input-box file">
                        <div>
                            <label for="license-f" class="input-label" required>Upload a photo of your License (Front)</label>
                            <input type="file" class="input-field" accept="image/*" required>
                        </div>
                        <div>
                            <label for="license-b" class="input-label" required>Upload a photo of your License (Back)</label>
                            <input type="file" class="input-field" accept="image/*" required>
                        </div>
                    </div>
                    
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Vehicle Plate No." required>
                    </div>
                    <div class="input-box btn-box button">
                        <button class="btn btn-7" id="back2">Back</button>
                        <button class="btn btn-5" id="next3">Next</button>
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
                            <label for="brgy" class="input-label" required>Upload a photo of Barangay Clearance</label>
                            <input type="file" class="input-field" accept="image/*" required>
                        </div>
                        <div>
                            <label for="police" class="input-label" required>Upload a photo of Police Clearance</label>
                            <input type="file" class="input-field" accept="image/*" required>
                        </div>
                        <div>
                            <label for="nbi" class="input-label" required>Upload a photo of NBI Clearance</label>
                            <input type="file" class="input-field" accept="image/*" required>
                        </div>
                    </div>
                    <div class="input-box btn-box button">
                        <button class="btn btn-7" id="back3">Back</button>
                        <button class="btn btn-5" id="next4">Next</button>
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
                        <input type="text" class="input-field" placeholder="Gcash Account Name" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Gcash Number" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Social Security System Number" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="PhilHealth Number" required>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Pag-IBIG Number" required>
                    </div>
                
                    <div class="input-box btn-box button">
                        <button class="btn btn-8" id="back4">Back</button>
                        <button class="btn btn-6" id="next5">Next</button>
                    </div>

                    </div>
                </div>


            <!-- Password Form Container -->
            <div class="password-form" style="display: none;">
                <div class="form-title">
                    <span>Password</span>
                </div>
                 <!-- Password Input Fields -->
                 <div class="input-box">
                    <input type="password" class="input-field" id="desired-password" placeholder="Desired Password" required>
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
                    <button class="input-submit" id="submit-button">
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
        </div>
    

    <!-- JS -->
    <script src="employee.js?v=1.1"></script>
</body>
</html>