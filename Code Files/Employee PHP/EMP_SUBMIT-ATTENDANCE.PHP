<!-- submit-attendance-form.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Attendance</title>
  <link rel="stylesheet" href="../CSS Files/SUBMIT-ATTENDANCE.CSS"> <!-- Link to your CSS file -->
</head>
<body>
  
 <?php require "../Employee PHP/employee_submit_attendance.php"; ?>
  
 <form action="employee_submit_attendance.php" method="post" enctype="multipart/form-data" onsubmit="return confirmSubmission(event);">
    <div id="submit-attendance" class="form-sections">
      <h2>Submit Attendance</h2>

      <div id="date-time-section">
        <h3>Date and Time</h3>
        <div id="current-date"></div>
        <div id="current-time"></div>
      </div>

      <div id="parcel-info-section">
        <h3>Parcel Information</h3>
        <label for="parcel-carried">Parcel Carried:</label>
        <input type="text" id="parcel-carried" name="parcel-carried" <?php echo $disableInput ? 'disabled value="' . $Attendance["PC"] . '"' : ''; ?> required>
        <label for="parcel-delivered">Parcel Delivered:</label>
        <input type="text" id="parcel-delivered" name="parcel-delivered" <?php echo $disableInput ? 'disabled value="' . $Attendance["PD"] . '"' : ''; ?> required>
        <label for="parcel-returned">Parcel Returned:</label>
        <input type="text" id="parcel-returned" name="parcel-returned" <?php echo $disableInput ? 'disabled value="' . $Attendance["PR"] . '"' : ''; ?> required>
      </div>

      <div id="remittance-image-section">
        <h3>Remittance Image</h3>
        <img src="data:image/png;base64,<?php echo $disableInput ? $Attendance["RR"] : ''; ?>" 
             alt="REMITTANCE RECEIPT" 
             style="display: <?php echo $disableInput ? 'block' : 'none'; ?>; width:35%;height:auto; margin-bottom: 20px;">
        <label for="remittance-receipt">Upload Remittance Receipt:</label>
        <input type="file" id="remittance-receipt" name="remittance-receipt" accept="image/*" <?php echo $disableInput ? 'disabled' : ''; ?> required>
      </div>

      <div class="button-container">
        <button type="submit" <?php if ($disableInput) echo "style='display: none;'"; ?>> Submit </button>      
        <button type="reset" <?php if ($disableInput) echo "style='display: none;'"; ?> >Reset</button>
        <h4 style="<?php echo $disableInput ? 'display: block;' : 'display: none;'; ?>"> 
        Please contact the Admins if there are any errors or changes needed in your todays submission. 
      </div>
    </div>
</form>

</body>
</html>
