<!-- vehicle-form.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vehicle Information</title>
  <link rel="stylesheet" href="../CSS Files/VEHICLE.CSS"> <!-- Link to your CSS file -->
</head>
<body>

<?php
  include("employee_profile.php");
    ?> 


  <!-- Vehicle Form Section -->
  <div id="vehicle" class="form-section">
  <FORM enctype="multipart/form-data" method="POST" action="employee_vehicles.php">
    <input type="hidden" name="id" value="Vehicles"> <!-- Hidden field to identify the submission type -->
    <h2>Vehicle Information</h2>

    <!-- Vehicle Info Container for multiple sections -->
    <div id="vehicle-info-container">
        <!-- Driver's License Image Section -->
        <section id="license-image" class="info-section">
            <h3>Driver's License</h3>
            <label for="license-front">Front of License:</label>
            <div class="image-display">
                <img src="data:image/png;base64,<?php echo $DRV["DriversLicense"]; ?>" alt="Front of License" id="license-front-img">
                <input type="file" id="license-front" name="License" accept="image/*" style="display: none;" class="editimage">
            </div>
        </section>
        <h3>Vehicle Plate & Documentation</h3>

        <div class="LICENSECENTER">
            <?php 
            for ($i = 0; $i < count($VHC); $i++) { 
              Vehicle($VHC, $i);
            } ?>
        </div>
    </div>

    <!-- Button Container stays outside the vehicle-info sections -->
    <div class="button-container">
       <button type="button" onclick="BackVehicles()" name="BACK" value="BACK" id="back" style="display: none;">Back</button>  
        <button type="button" onclick="editVehicles()" name="EDIT" value="EDIT" id="edit">Edit</button>
        <button id="save-btn" disabled class="editable_status_Vehicle" value="NEW_VEHICLE"  style="display: none;">Save</button>
        <button type="button" onclick="addNewVehicle()" id="add">Add Vehicle</button>
    </div>
</FORM>
  </div>

</body>
</html>
