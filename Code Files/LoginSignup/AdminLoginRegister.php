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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <!-- Form Container -->
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="IMG/IMG2.png" class="form-image rider">
            </div>
            <p class="featured-word">Your one-stop workforce <span>Solution.</span></p>
        </div>
    
        <div class="col col-2">
            <div class="btn-box">
                <button class="btn btn-1" id="signin">Login</button>
                <button class="btn btn-2" id="signup">Register</button>
            </div>
            
            <!-- Login Form Container -->
            <div class="login-form">
                <div class="form-title">
                    <span>Login</span>
                </div>
                <div class="form-input">
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Username" required>
                        <i class="bx bx-user icon"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" placeholder="Password" required>
                        <i class="bx bx-lock-alt icon"></i>
                    </div>
                    <div class="forgot-pass">
                        <a href="../PasswordResetPHP/forgot-password.php?Admin">Forgot Password?</a>
                    </div>
                    <div class="input-box">
                        <button class="input-submit">
                            <span>Login</span>  
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Register Form Container -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="registerform" enctype="multipart/form-data">
                <div class="register-form">
                    <div class="form-title">
                        <span>Create Account</span>
                    </div>
                    <div class="form-input">
                        <div class="input-box name-info">
                            <input type="text" class="input-field" placeholder="Last Name" required name="Lastname">
                            <input type="text" class="input-field" placeholder="First Name" required name="Firstname">
                        </div>
                        <div class="input-box name-info">
                            <input type="text" class="input-field" placeholder="Middle Name" required name="Middlename">
                            <input type="text" class="input-field" placeholder="Suffix (e.g., Jr., Sr.)" name="Suffix">
                        </div>

                        <select class="input-field" required name="Position">
                            <option value="" disabled selected>Role</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Agency Coordinator">Agency Coordinator</option>
                            <option value="Payroll">Payroll</option>
                        </select>
                    </div>

                    <div class="input-box file">
                        <label for="profile-photo" class="input-label" required>Upload a profile photo</label>
                            <input type="file" class="input-field" accept="image/*" required name="Profilepic">
                    </div>

                    <div class="input-box">
                        <button type="submit" class="btn btn-1" id="next">Next</button>
                    </div>
                </div>  
        
                <!-- Account Form Container -->
                <div class="account-form" style="display: none;"> <!-- Initially hidden -->
                    <div class="form-title">
                        <span>Account & Contact</span>
                    </div>
                    <div class="form-input">
                        <div class="input-box">
                            <input type="email" class="input-field AC" placeholder="Email" required name="Email">
                        </div>

                        <div class="input-box">
                            <input type="tel" class="input-field AC" placeholder="Contact Number" required name="Contact">
                        </div>

                        <div class="input-box">
                            <input type="text" class="input-field AC" placeholder="Username" required name="Username">
                        </div>
                    </div>
                <!-- Password Input Fields -->
                <div class="input-box">
                    <input type="password" class="input-field AC" id="desired-password" placeholder="Desired Password" required name="Password">
                        <span class="toggle-password" onclick="togglePassword('desired-password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                <div class="input-box">
                    <input type="password" class="input-field AC" id="confirm-password" placeholder="Confirm Password" required>
                        <span class="toggle-password" onclick="togglePassword('confirm-password', this)">
                            <i class="fas fa-eye"></i>
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
            </form>  
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
    <script src="admin.js"></script>
</body>
</html>

<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll4.0";
    $conn = "";

    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);

    if ($conn) {
        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $Lastname = filter_input(INPUT_POST,"Lastname", FILTER_SANITIZE_SPECIAL_CHARS);
            $Firstname = filter_input(INPUT_POST,"Firstname", FILTER_SANITIZE_SPECIAL_CHARS);
            $Middlename = filter_input(INPUT_POST,"Middlename", FILTER_SANITIZE_SPECIAL_CHARS);
            $Suffix = filter_input(INPUT_POST,"Suffix", FILTER_SANITIZE_SPECIAL_CHARS);
            $Position = filter_input(INPUT_POST,"Position", FILTER_SANITIZE_SPECIAL_CHARS);
            $Email = filter_input(INPUT_POST,"Email", FILTER_SANITIZE_SPECIAL_CHARS);
            $Contact = filter_input(INPUT_POST,"Contact", FILTER_SANITIZE_SPECIAL_CHARS);
            $Username = filter_input(INPUT_POST,"Username", FILTER_SANITIZE_SPECIAL_CHARS);
            $Password = filter_input(INPUT_POST,"Password", FILTER_SANITIZE_SPECIAL_CHARS);
            $StatId= 1;

             // Handle the file upload
            if (isset($_FILES['Profilepic']) && $_FILES['Profilepic']['error'] == 0) {
                $Profilepic = file_get_contents($_FILES['Profilepic']['tmp_name']);
                $Profilepic = mysqli_real_escape_string($conn, $Profilepic);
            } else {
                $Profilepic = null; // Set to null if not uploaded
            }
            
            if (empty($Lastname) || empty($Firstname) || empty($Lastname) || empty($Position) || empty($Profilepic) || empty($Email) || empty($Contact) || empty($Username) || empty($Password)) {
                echo "<script type='text/javascript'>alert('EMPTY FIELDS');</script>";
            } else {
                $hash = password_hash($Password, PASSWORD_DEFAULT);
    
                // Insert into admin_name
                $sql1 = "INSERT INTO teamlead_name (TLN_FName, TLN_MName, TLN_LName, TLN_Suffix) VALUES ('$Firstname', '$Middlename', '$Lastname', '$Suffix')";
                if (mysqli_query($conn, $sql1)) {
                    // Get the last inserted ID for admin_name
                    $adminNameId = mysqli_insert_id($conn);

                    // Insert into admin_role
                    $sql2 = "INSERT INTO teamlead_position (TLP_Position) VALUES ('$Position')";
                    if (mysqli_query($conn, $sql2)) {
                        // Get the last inserted ID for admin_role
                        $adminPositionId = mysqli_insert_id($conn);

                        // Insert into account
                        $sql3 = "INSERT INTO `account`(`ACC_Username`, `ACC_Password`) VALUES ('$Username','$Password')";
                        if (mysqli_query($conn, $sql3)) {
                            // Get the last inserted ID for account
                            $accountId = mysqli_insert_id($conn);

                            // Insert into admin_information with all foreign keys
                            $sql4 = "INSERT INTO teamlead_information (`TL_AccountID`, `TL_PositionID`, `TL_NameID`, `TL_Contact`, `TL_Email`, `TL_ProfileImg`) 
                                    VALUES ('$accountId','$adminNameId', '$adminPositionId', '$Email', '$Contact', '$Profilepic')";
                            mysqli_query($conn, $sql4);

                            echo "<script type='text/javascript'>alert('REGISTER SUCCESSFULLY');</script>";
                        } else {
                            echo "<script type='text/javascript'>alert('Error inserting into account: " . mysqli_error($conn) . "');</script>";
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Error inserting into admin_role: " . mysqli_error($conn) . "');</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Error inserting into admin_name: " . mysqli_error($conn) . "');</script>";
                }
                $currentDateTime = date('Y-m-d H:i:s');
            }
        }
    
        mysqli_close($conn);
    } else {
        die("Connection failed: " . mysqli_connect_error());
    }

    
?>