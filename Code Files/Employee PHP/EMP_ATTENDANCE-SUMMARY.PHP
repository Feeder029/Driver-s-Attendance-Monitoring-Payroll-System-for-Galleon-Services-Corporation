<!-- attendance-summary-form.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Summary</title>
  <link rel="stylesheet" href="../CSS Files/ATTENDANCE-SUMMARY.CSS"> <!-- Link to your CSS file -->
</head>
<body>


  <!-- Attendance Summary Form Section -->
  <div id="attendance-summary" class="form-sections">
     <h2>Attendance Summary</h2>

    <!-- First Section: Date Range and Stats Row -->
    <section id="date-range-summary" class="info-section">
        <h3>Summary</h3>

        <!-- Date Range Selection in Row -->
        <div class="date-range">
            <div class="date-input">
                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date" name="start-date" required>
            </div>

            <div class="date-input">
                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end-date" required>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat">
                <span id="days-with-trips" class="stat-value">15</span>
                <label>Days with Trips</label>
            </div>
            <div class="stat">
                <span id="packages-carried" class="stat-value">120</span>
                <label>Packages Carried</label>
            </div>
            <div class="stat">
                <span id="packages-delivered" class="stat-value">115</span>
                <label>Packages Delivered</label>
            </div>
            <div class="stat">
                <span id="packages-returned" class="stat-value">5</span>
                <label>Packages Returned</label>
            </div>
        </div>
    </section>

    <!-- Second Section: Expanding Cards for Monthly Stats -->
    <section id="monthly-stats" class="info-section">
        <h3>Monthly Stats</h3>

        <!-- Expandable Card for November Stats -->
        <div class="expandable-card">
            <div class="card-header">
                <span>1/11/24 - 30/11/24</span>
                <button class="view-button" onclick="toggleCard(this)">View</button>
            </div>
            <div class="card-content">
                <div class="stats-row">
                    <div class="stat">
                        <span class="stat-value">20</span>
                        <label>Days with Trips</label>
                    </div>
                    <div class="stat">
                        <span class="stat-value">150</span>
                        <label>Packages Carried</label>
                    </div>
                    <div class="stat">
                        <span class="stat-value">145</span>
                        <label>Packages Delivered</label>
                    </div>
                    <div class="stat">
                        <span class="stat-value">5</span>
                        <label>Packages Returned</label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Third Section: Yearly Stats -->
    <section id="yearly-stats" class="info-section">
        <h3>Yearly Stats</h3>

        <!-- Expandable Card for Yearly Stats -->               
        <div class="expandable-card">
            <div class="card-header">
                <span>Year 2024</span>
                <button class="view-button" onclick="toggleCard(this)">View</button>
            </div>
            <div class="card-content">
                <div class="stats-row">
                    <div class="stat">
                        <span id="days-with-trips-year" class="stat-value">200</span>
                        <label>Days with Trips</label>
                    </div>
                    <div class="stat">
                        <span id="packages-carried-year" class="stat-value">1800</span>
                        <label>Packages Carried</label>
                    </div>
                    <div class="stat">
                        <span id="packages-delivered-year" class="stat-value">1750</span>
                        <label>Packages Delivered</label>
                    </div>
                    <div class="stat">
                        <span id="packages-returned-year" class="stat-value">50</span>
                        <label>Packages Returned</label>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </div>
</body>
</html>
