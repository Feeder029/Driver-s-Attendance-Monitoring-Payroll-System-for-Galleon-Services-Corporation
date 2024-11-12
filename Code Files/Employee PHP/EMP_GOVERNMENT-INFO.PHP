<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Government Information</title>
  <link rel="stylesheet" href="../CSS Files/GOVERNMENT-INFO.CSS"> <!-- Link to your CSS file -->
</head>
<body>

<?php
include("employee_profile.php");
?>

  <!-- Government Information Form Section -->
  <div id="government-info" class="form-section">
  <form method="post" action="employeegovinfo.php"  enctype="multipart/form-data">

    <h2>Government Information</h2>

    <!-- Benefits Section -->
    <section id="benefits-info" class="info-section">
      <h3>Benefits</h3>
      <label for="sss-number">SSS Number:</label>
      <input type="text" id="pagibig-number" value="<?php echo $DRV["SSSNo"]?>" disabled class="editable_status_GOV" name = "SSSNo" required>

      <label for="philhealth-number">PhilHealth Number:</label>
      <input type="text" id="philhealth-number" value="<?php echo $DRV["PhilNo"]?>" disabled class="editable_status_GOV" name = "PhilHealthNo" required>

      <label for="pagibig-number">Pag-IBIG Number:</label>
      <input type="text" id="sss-number" value="<?php echo $DRV["PagNo"]?>" disabled class="editable_status_GOV" name = "PagibigNo" required>
      </section>

    <!-- Clearance Section -->
    <section id="clearance-info" class="info-section">
      <h3>Clearance</h3>

      <!-- NBI Clearance -->
      <label for="nbi-clearance">NBI Clearance:</label>
      <div class="image-display">
      <img src="data:image/png;base64,<?php echo $DRV["NBI_Clear"]; ?>"  alt="NBI Clearance" id="nbi-clearance-img">
      <input type="file" id="nbi-clearance" name="NBI" accept="image/*,application/pdf" style="display: none;" class="editimage_clearance">
      </div>

      <!-- Police Clearance -->
      <label for="police-clearance">Police Clearance:</label>
      <div class="image-display">
      <img src="data:image/png;base64,<?php echo $DRV["Pol_Clear"]; ?>" alt="Police Clearance" id="police-clearance-img">
      <input type="file" id="police-clearance"name="Pol" accept="image/*,application/pdf" style="display: none;" class="editimage_clearance">
      </div>

      <!-- Barangay Clearance -->
      <label for="barangay-clearance">Barangay Clearance:</label>
      <div class="image-display">
      <img src="data:image/png;base64,<?php echo $DRV["Brgy_Clear"]; ?>" alt="Barangay Clearance" id="barangay-clearance-img">
      <input type="file" name="Brgy" id="barangay-clearance" accept="image/*,application/pdf" style="display: none;" class="editimage_clearance">
      </div>
    </section>

    <!-- Edit and Save Buttons -->
    <div class="button-container">
    <button type="button" onclick="editGovernmentInfo()" id="edit">Edit</button>
    <button type="button" onclick="BackGovernmentInfo()" name="BACK" value="BACK" id="back" style="display: none;">Back</button>  
    <button type="submit" onclick="saveGovernmentInfo()" id="save" style="display: none;">Save</button>
    </div>
  </form>

  </div>


  <script src="GOVERNMENT-INFO.JS"></script> <!-- Include JS for edit functionality -->
</body>
</html>
