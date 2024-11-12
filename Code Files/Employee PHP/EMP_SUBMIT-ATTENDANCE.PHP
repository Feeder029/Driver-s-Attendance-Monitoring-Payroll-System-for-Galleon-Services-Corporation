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

  <!-- Submit Attendance Form Section -->
  <div id="submit-attendance" class="form-sections">
    <h2>Submit Attendance</h2>

    <!-- Date and Time Section -->
    <div id="date-time-section">
      <h3>Date and Time</h3>
      <div id="current-date"></div>
      <div id="current-time"></div>
    </div>

    <!-- Parcel Information Section -->
    <div id="parcel-info-section">
      <h3>Parcel Information</h3>
      <label for="parcel-carried">Parcel Carried:</label>
      <input type="text" id="parcel-carried" name="parcel-carried" required>

      <label for="parcel-delivered">Parcel Delivered:</label>
      <input type="text" id="parcel-delivered" name="parcel-delivered" required>

      <label for="parcel-returned">Parcel Returned:</label>
      <input type="text" id="parcel-returned" name="parcel-returned" required>
    </div>

    <!-- Remittance Image Section -->
    <div id="remittance-image-section">
      <h3>Remittance Image</h3>
      <label for="remittance-receipt">Upload Remittance Receipt:</label>
      <input type="file" id="remittance-receipt" name="remittance-receipt" accept="image/*" required>
    </div>

    <!-- Submit and Reset Buttons -->
    <div class="button-container">
      <button type="submit">Submit</button>
      <button type="reset">Reset</button>
    </div>
  </div>


</body>
</html>
