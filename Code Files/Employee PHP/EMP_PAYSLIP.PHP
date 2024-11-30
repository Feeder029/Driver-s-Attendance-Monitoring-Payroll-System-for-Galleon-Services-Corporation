<!-- payslip-form.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payslip</title>
  <link rel="stylesheet" href="../CSS Files/PAYSLIP.CSS"> <!-- Link to your CSS file -->
</head>
<body>

  <!-- Payslip Form Section -->
  <div id="payslip" class="form-sections">
    <h2>Payslip</h2>

    <!-- Date Range Selection -->
    <div class="date-range">
      <span>01/12/2024 - 31/12/2024</span>
      <button class="details-button" onclick="toggleDetails()">Details ▼</button>
    </div>

    <!-- Hidden by default, shown when expanded -->
    <div class="details" id="details-content">
      <!-- Driver Info at the Top -->
      <div class="driver-info">
        <p><strong>Name:</strong> John Doe </p>
        <p><strong>ID NO.:</strong> 1001</p>
        <p><strong>Hub:</strong> Low QC Hub</p>
      </div>

      <!-- Earnings and Deductions Summary -->
      <div class="pay-summary">
        <h3>Earnings</h3>
        <div class="earnings">
          <div class="row">
            <span class="label">REG DAY:</span> <span class="days">5</span> <span class="amount">Value</span>
          </div>
          <div class="row">
            <span class="label">S. HOLIDAY:</span> <span class="days">2</span> <span class="amount">Value</span>
          </div>
          <div class="row">
            <span class="label">R. HOLIDAY:</span> <span class="days">1</span> <span class="amount">Value</span>
          </div>
          <div class="row total">
            <span class="label">TOTAL EARNINGS:</span> <span class="total-earnings">Value</span>
          </div>
        </div>  

        <h3>Deduction</h3>
        <div class="deductions">
          <div class="row">
            <span class="label">SSS:</span> <span class="amount">Value</span>
          </div>
          <div class="row">
            <span class="label">PhilHealth:</span> <span class="amount">Value</span>
          </div>
          <div class="row">
            <span class="label">Pagibig:</span> <span class="amount">Value</span>
          </div>
          <div class="row total">
            <span class="label">TOTAL Deductions:</span> <span class="total-deductions">Value</span>
          </div>
          <div class="row net-pay">
            <span class="label">Net Pay:</span> <span class="net-pay-amount">Value</span>
          </div>
        </div>
      </div>

      <!-- Download button -->
      <button class="download-button">Download</button>
    </div>
  </div>
  <script src="PAYSLIP.JS"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</body>
</html>
