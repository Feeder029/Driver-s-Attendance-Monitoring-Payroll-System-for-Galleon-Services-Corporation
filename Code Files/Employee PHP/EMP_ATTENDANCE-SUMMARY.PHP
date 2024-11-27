<!-- attendance-summary-form.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Summary</title>
  <link rel="stylesheet" href="../CSS Files/ATTENDANCE-SUMMARY.CSS"> <!-- Link to your CSS file -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    $(document).ready(function () {
        const fetchFilteredData = () => {
            const Start = $("#start-date").val();
            const End = $("#end-date").val();

            console.log("Start Date:", Start);
            console.log("Start Date:", End);
            console.log("Making AJAX Request...");

            $.ajax({
                url: "employee_attsummary.php",
                method: "POST",
                data: { DateFrom: Start, DateTo:End},
                success: function (data) {
                    console.log("AJAX Success:", data); 
                    $("#Stats").html(data);
                },
                error: function (error) {
                    console.error("AJAX Error:", error);
                }
            });
        };

        // Trigger AJAX on input change
        $("#start-date").on("change blur", fetchFilteredData);
        $("#end-date").on("change blur", fetchFilteredData);

    });
  </script>
</head>
<body>

<?php
require "employee_attsummary.php";
?>

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
                <input type="date" id="start-date" name="start-date" value="<?php echo $DateStart?>" required>
            </div>

            <div class="date-input">
                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end-date" value="<?php echo $DateEnd?>" required>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row" id="Stats">
       <?PHP
         DateSearchQuery($conn,$DateStart,$DateEnd,$DriverID );
        ?>
        </div>
    </section>

    <!-- Second Section: Expanding Cards for Monthly Stats -->
    <section id="monthly-stats" class="info-section">
        <h3>Monthly Stats</h3>

        <?PHP
        $Monthresult = $conn->query($MonthlyReport); 
        if ($Monthresult && $Monthresult->num_rows > 0) {
         while ($row = $Monthresult->fetch_assoc()) {
            echo        
            " <!-- Expandable Card for November Stats -->
            <div class='expandable-card'>
                <div class='card-header'>
                    <span>".$row["MonthName"]." ".$row["Year"]."</span>
                    <button class='view-button' onclick="."toggleCard(this)".">View</button>
                </div>
                <div class='card-content'>
                    <div class='stats-row'>
                        <div class='stat'>
                            <span class='stat-value'>".$row["Trips"]."</span>
                            <label>Days with Trips</label>
                        </div>
                        <div class='stat'>
                            <span class='stat-value'>".$row["Carried"]."</span>
                            <label>Packages Carried</label>
                        </div>
                        <div class='stat'>
                            <span class='stat-value'>".$row["Delivered"]."</span>
                            <label>Packages Delivered</label>
                        </div>
                        <div class='stat'>
                            <span class='stat-value'>".$row["Returned"]."</span>
                            <label>Packages Returned</label>
                        </div>
                    </div>
                </div>
            </div>";
         }
        } else {
         echo"   
            <div class='expandable-card'>
                <div class='card-header'>
                No attendance records have been submitted yet
                </div>
            </div>";
        }
        ?>


    </section>

    <!-- Third Section: Yearly Stats -->
    <section id="yearly-stats" class="info-section">
        <h3>Yearly Stats</h3>

        <!-- Expandable Card for Yearly Stats -->               
        <?PHP 
        $Yearlyresult = $conn->query($YearlyReport); 
        if ($Yearlyresult && $Yearlyresult->num_rows > 0) {
         while ($row = $Yearlyresult->fetch_assoc()) {
            echo " <div class='expandable-card'>
            <div class='card-header'>
                <span>Year ".$row["Year"]."</span>
                <button class='view-button' onclick="."toggleCard(this)".">View</button>
            </div>
            <div class='card-content'>
                <div class='stats-row'>
                    <div class='stat'>
                        <span id='days-with-trips-year' class='stat-value'>".$row["Trips"]."</span>
                        <label>Days with Trips</label>
                    </div>
                    <div class='stat'>
                        <span id='packages-carried-year' class='stat-value'>".$row["Carried"]."</span>
                        <label>Packages Carried</label>
                    </div>
                    <div class='stat'>
                        <span id='packages-delivered-year' class='stat-value'>".$row["Delivered"]."</span>
                        <label>Packages Delivered</label>
                    </div>
                    <div class='stat'>
                        <span id='packages-returned-year' class='stat-value'>".$row["Returned"]."</span>
                        <label>Packages Returned</label>
                    </div>
                </div>
            </div>
         </div>";



         }} 
        ?>


    </section>

  </div>
</body>
</html>
