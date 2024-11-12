<!-- personal-account.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personal & Account Information</title>
  <link rel="stylesheet" href="../CSS Files/PERSONAL-ACCOUNT.CSS"> <!-- Link to your CSS file -->
</head>

<?php
  include("employee_profile.php");
?>

  <form method="post" name="id" id="Personal&Account" action="employee_perandacc.php">
  <section id="personal-account" class="form-section">
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
      <input type="tel" id="gcash-number" name="GcashName"  value="<?php echo $DRV["GC_Name"] ?>" disabled class="editable_status_P-A"  required>

      <label for="gcash-number">GCash Number:</label>
      <input type="text" id="gcash-name" name="GcashNo"  value="<?php echo $DRV["GC_NO"] ?>" disabled class="editable_status_P-A"  required>
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
      <?php for ($i = 0; $i < count($Hub); $i++){
             $selectedunit =  ($DRV["Hub"] == $Hub[$i]) ? 'selected' : '';
             echo '<option value="' . htmlspecialchars($HubID[$i]) . '"' . $selectedunit . '>' . htmlspecialchars($Hub[$i]) . '</option>';
      } ?>
      </select>
    </section>

    <!-- Account Information Section -->
    <section id="account-info" class="info-section">
      <h3>Account Information</h3>
      <label for="username">Username:</label>
      <input type="text" id="username" value="<?php echo $DRV["USER"]  ?>" class="editable_status_P-A" name = "User" disabled required >

      <label for="password">Password:</label>
      <input type="password" id="password"  value="<?php echo $DRV["PASS"] ?>" class="editable_status_P-A" disabled name = "Password" required>
      </section>

    <!-- Edit and Save Buttons -->
    <div class="button-container">
    <button type="button" onclick="editProfile()" name="EDIT" value="EDIT" id="edit">Edit</button>
    <button type="button" onclick="BackProfile()" name="BACK" value="BACK" id="back" style="display: none;">Back</button>  
    <button type="submit" onclick="saveProfile()" name="SAVE" value="SAVE" id="save" style="display: none;">Save</button>
    </div>


    
  <script src="../JS Files/Employee_Profile.js?v=1.1"></script>
  <script src="../JS Files/Employee_Profile2.js?v=1.1"></script>


  </section>
  </form>


</body>
</html>
