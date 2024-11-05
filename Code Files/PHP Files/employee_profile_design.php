
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Portal</title>
  <link rel="stylesheet" href="../CSS Files/ProfileEmployee.css">
</head>
<body>


  <div class="container">

<?php
include("employee_profile.php");
?>

    <header>
      <h1>Profile</h1>
      <div class="menu-icon" onclick="toggleMenu()">
        &#9776; <!-- Hamburger icon -->
      </div>
      
      <div class="dropdown" id="dropdown-menu">
        <a href="#payslip" onclick="showForm('payslip', false)">Payslip</a>
        <a href="#attendance-summary" onclick="showForm('attendance-summary', false)">Attendance Summary</a>
        <a href="#submit-attendance" onclick="showForm('submit-attendance', false)">Submit Attendance</a>
        <a href="#profile" onclick="showForm('profile', true)">Profile</a>
      </div>
    </header>
    
    <section class="profile"> 
      <div class="photo-name">
          <img src="data:image/png;base64,<?php echo $DRV["Profile"]; ?>" alt="Driver Photo" class="driver-photo">
          <div>
              <h2 class="driver-name"> <?php echo "$FullName"; ?> </h2>
              <button class="edit-photo-btn">Edit Photo</button>
              <input type="file" name="profile" id="image" accept="image/*" style="display: none;">
              <input type="hidden" name="id" value="profileform">

          </div>
      </div>
    </section>
  
    <nav class="nav-menu">
      <a href="#personal-account" onclick="showForm('personal-account', true)">Personal & Account</a>
      <a href="#vehicle" onclick="showForm('vehicle', true)">Vehicle</a>
      <a href="#contacts" onclick="showForm('contacts', true)">Contacts</a>
      <a href="#government-info" onclick="showForm('government-info', true)">Government Information</a>
    </nav>
    
    <!--Personal & Account Form-->
    <section id="form-container">


    <form method="post" name="id" id="Personal&Account" action="employee_perandacc.php">
    <div id="personal-account" class="form-section">
        <h2>Personal & Account Information</h2>
          <!-- Personal Information Section -->
            <section id="personal-info" class="info-section">
              <h3>Personal Information</h3>
              
              <label for="first-name">First Name:</label>
              <input type="text" id="first-name" name="FirstName" disabled value="<?php echo $DRV["FN"] ?>" class="editable_status_P-A" required>

              <label for="middle-name">Middle Name:</label>
              <input type="text" id="middle-name" name="Middle" disabled value="<?php echo $DRV["MN"] ?>" class="editable_status_P-A">

              <label for="last-name">Last Name:</label>
              <input type="text" id="last-name" name="LastName" disabled value="<?php echo $DRV["LN"] ?>" class="editable_status_P-A" required>

              <label for="suffix">Suffix:</label>
              <input type="text" id="suffix" name="Suffix" disabled value="<?php echo $DRV["SFX"] ?>" class="editable_status_P-A">

              <label for="age">Age:</label>
              <input type="number" id="age" name="Age" disabled value="<?php echo $DRV["Age"] ?>" class="editable_status_P-A" required min="0">

              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" name="DOB" value="<?php echo $DRV["DOB"] ?>" disabled class="editable_status_P-A" required>

              <label for="gender">Gender:</label>
              <select id="gender" name="gender" disabled class="editable_status_P-A"  required>
              <option value="Male" <?php echo ($DRV["Gender"] == 'Male') ? 'selected' : ''; ?> >Male</option>
              <option value="Female" <?php echo ($DRV["Gender"]  == 'Female') ? 'selected' : ''; ?> >Female</option>
              <option value="Others" <?php echo ($DRV["Gender"]  == 'Others') ? 'selected' : ''; ?> >Others</option>
              </select>
            </section>

          <!-- Address Information Section -->
            <section id="address-info" class="info-section">
              <h3>Address Information</h3>
              
              <label for="province">Province:</label>
              <select id="province" name="province"  disabled class="editable_status_P-A" required>
                  <option value= "<?php echo $DRV["Province"] ?>"> <?php echo $DRV["Province"] ?> </option>
                  <option value="">Select Province</option>
                  <option value="province1">Province 1</option>
                  <option value="province2">Province 2</option>
                  <option value="province3">Province 3</option>
                  <!-- Add more provinces as needed -->
              </select>

              <label for="city-municipality">City/Municipality:</label>
              <select id="city-municipality" name="city"  disabled class="editable_status_P-A" required>
                 <option value= "<?php echo $DRV["City"] ?>"> <?php echo $DRV["City"] ?> </option>
                  <option value="">Select City/Municipality</option>
                  <option value="city1">City 1</option>
                  <option value="city2">City 2</option>
                  <option value="city3">City 3</option>
                  <!-- Add more cities/municipalities as needed -->
              </select>

              <label for="barangay">Barangay:</label>
              <select id="barangay" name="barangay" disabled class="editable_status_P-A"  required>
                <option value= "<?php echo $DRV["Brgy"] ?>"> <?php echo $DRV["Brgy"] ?> </option>
                  <option value="">Select Barangay</option>
                  <option value="barangay1">Barangay 1</option>
                  <option value="barangay2">Barangay 2</option>
                  <option value="barangay3">Barangay 3</option>
                  <!-- Add more barangays as needed -->
              </select>

              <label for="street">Street:</label>
              <input type="text" id="street" name="Street" value="<?php echo $DRV["Street"] ?>" disabled class="editable_status_P-A" required>

              <label for="lot-no">Lot No.:</label>
              <input type="text" id="lot-no" name="Lot" value="<?php echo $DRV["Lot"] ?>" value="<?php echo $DRV["Lot"] ?>" disabled class="editable_status_P-A" >

              <label for="house-no">House No.:</label>
              <input type="text" id="house-no" name="House"  value="<?php echo $DRV["House"] ?>" disabled class="editable_status_P-A" >
            </section>


            <!-- GCash Information Section -->
            <section id="gcash-info" class="info-section">
              <h3>GCash Information</h3>
              
              <label for="gcash-name">GCash Name:</label>
              <input type="text" id="gcash-name" name="GcashNo"  value="<?php echo $DRV["GC_NO"] ?>" disabled class="editable_status_P-A"  required>

              <label for="gcash-number">GCash Number:</label>
              <input type="tel" id="gcash-number" name="GcashName"  value="<?php echo $DRV["GC_Name"] ?>" disabled class="editable_status_P-A"  required>
            </section>

          <!-- Driver Hub Information Section -->
            <section id="driver-hub-info" class="info-section">
              <h3>Driver Hub Information</h3>

              <label for="driver-id">Driver ID:</label>
              <input type="text" id="driver-id" name="DrivID" value="<?php echo $DRV["ID"]?>" disabled required>

              <label for="unit-type">Unit Type:</label>
              <select id="unit-type" class="editable_status_P-A" name="unittype" disabled required>
              <?php 
               for ($i = 0; $i < count($UnitTypes); $i++) {
            $selectedunit = ($DRV["Unit"] == $UnitTypes[$i]) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($UnitTypesID[$i]) . '"' . $selectedunit . '>' . htmlspecialchars($UnitTypes[$i]) . '</option>';
            }
                ?>
              </select>

              <label for="hub">Hub:</label>
              <select id="hub" class="editable_status_P-A" name="hub" disabled required>
              <?php 
             for ($i = 0; $i < count($Hub); $i++){
             $selectedunit =  ($DRV["Hub"] == $Hub[$i]) ? 'selected' : '';
             echo '<option value="' . htmlspecialchars($HubID[$i]) . '"' . $selectedunit . '>' . htmlspecialchars($Hub[$i]) . '</option>';
             } ?>

              </select>
            </section>

          <!-- Account Information Section -->
          <section id="account-info" class="info-section">
              <h3>Account Information</h3>
              <!-- Add fields for account information (e.g., Username, Password) -->
              <label for="username">Username:</label>
              <input type="text" id="username" value="<?php echo $DRV["USER"]  ?>" class="editable_status_P-A" name = "User" disabled required >

              <label for="password">Password:</label>
              <input type="password" id="password"  value="<?php echo $DRV["PASS"] ?>" class="editable_status_P-A" disabled name = "Password" required>
          </section>


          <!-- Edit and Save Buttons -->
          <div class="button-container">
            <button type="button" onclick="editProfile()" name="EDIT" value="EDIT" id="edit">Edit</button>
            <button type="submit" onclick="saveProfile()" name="SAVE" value="SAVE" id="save"  class="editable_status_P-A">Save</button>
          </div>

      </div>
    </form>
    </section>







    <!--Vehicle Form-->
    <div id="vehicle" class="form-section">
        <h2>Vehicle Information</h2>
    
        <!-- Driver's License Image Section -->
        <section id="license-image" class="info-section">
            <h3>Driver's License</h3>
    
            <label for="license-front">Front of License:</label>
            <div class="image-display">
                <img src="path/to/front-license.jpg" alt="Front of License" id="license-front-img">
                <input type="file" id="license-front" name="license-front" accept="image/*" style="display: none;">
            </div>
    
            <label for="license-back">Back of License:</label>
            <div class="image-display">
                <img src="path/to/back-license.jpg" alt="Back of License" id="license-back-img">
                <input type="file" id="license-back" name="license-back" accept="image/*" style="display: none;">
            </div>
        </section>
    
        <!-- Vehicle Plate Number Section -->
        <section id="vehicle-plate" class="info-section">
            <h3>Vehicle Plate Number</h3>
    
            <label for="plate-number">Plate Number:</label>
            <input type="text" id="plate-number" name="plate-number" required>
        </section>
    
        <!-- Official Receipt and Certificate of Registration Section -->
        <section id="or-cr-images" class="info-section">
            <h3>Official Receipt & Certificate of Registration</h3>
    
            <label for="or-image">Official Receipt (OR) Image:</label>
            <div class="image-display">
                <img src="path/to/or-image.jpg" alt="Official Receipt Image" id="or-image-img">
                <input type="file" id="or-image" name="or-image" accept="image/*" style="display: none;">
            </div>
    
            <label for="cr-image">Certificate of Registration (CR) Image:</label>
            <div class="image-display">
                <img src="path/to/cr-image.jpg" alt="Certificate of Registration Image" id="cr-image-img">
                <input type="file" id="cr-image" name="cr-image" accept="image/*" style="display: none;">
            </div>
        </section>
    
        <!-- Edit, Save, and Add Buttons -->
        <div class="button-container">
            <button type="button" onclick="toggleEditMode()">Edit</button>
            <button type="submit" onclick="saveVehicleInfo()" id="save-btn" style="display: none;">Save</button>
            <button type="button" onclick="addNewVehicle()">Add</button>
        </div>
    </div>
    
    <!-- Link to the external JavaScript file -->
    <script src="../JS Files/vehicleForm.js"></script>
    
    <!-- Contacts Form --> 
      <div id="contacts" class="form-section">
        <h2>Contacts</h2>
        <!-- Contacts form fields -->
            <section id="contacts-info" class="info-section">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>

              <label for="contact-number">Contact Number:</label>
              <input type="tel" id="contact-number" name="contact-number" required>
          </section>

          <!-- Edit and Save Buttons -->
          <div class="button-container">
              <button type="button" onclick="editContacts()">Edit</button>
              <button type="submit" onclick="saveContacts()">Save</button>
          </div>
      </div>

      <!--Government Information Form -->
    <div id="government-info" class="form-section">
        <h2>Government Information</h2>
    
        <!-- Benefits Section -->
        <section id="benefits-info" class="info-section">
            <h3>Benefits</h3>
            
            <label for="sss-number">SSS Number:</label>
            <input type="text" id="sss-number" name="sss-number" required>
    
            <label for="philhealth-number">PhilHealth Number:</label>
            <input type="text" id="philhealth-number" name="philhealth-number" required>
    
            <label for="pagibig-number">Pag-IBIG Number:</label>
            <input type="text" id="pagibig-number" name="pagibig-number" required>
        </section>
    
        <!-- Clearance Section -->
        <section id="clearance-info" class="info-section">
            <h3>Clearance</h3>
    
            <!-- NBI Clearance -->
            <label for="nbi-clearance">NBI Clearance:</label>
            <div class="image-display">
                <img src="path/to/nbi-clearance.jpg" alt="NBI Clearance" id="nbi-clearance-img">
                <input type="file" id="nbi-clearance" name="nbi-clearance" accept="image/*,application/pdf">
            </div>
    
            <!-- Police Clearance -->
            <label for="police-clearance">Police Clearance:</label>
            <div class="image-display">
                <img src="path/to/police-clearance.jpg" alt="Police Clearance" id="police-clearance-img">
                <input type="file" id="police-clearance" name="police-clearance" accept="image/*,application/pdf">
            </div>
    
            <!-- Barangay Clearance -->
            <label for="barangay-clearance">Barangay Clearance:</label>
            <div class="image-display">
                <img src="path/to/barangay-clearance.jpg" alt="Barangay Clearance" id="barangay-clearance-img">
                <input type="file" id="barangay-clearance" name="barangay-clearance" accept="image/*,application/pdf">
            </div>

             <!-- Edit and Save Buttons -->
            <div class="button-container">
                        <button type="button" onclick="editGovernmentInfo()">Edit</button>
                        <button type="submit" onclick="saveGovernmentInfo()">Save</button>
            </div>
        </section>
    
    </div>



      
    </section>
  </div>
  <!--For Form nav & menu function-->
  <script src="../JS Files/Dash.js"></script>
  <script src="../JS Files/Employee_Profile.js?v=1.0"></script>

</body>
</html>


