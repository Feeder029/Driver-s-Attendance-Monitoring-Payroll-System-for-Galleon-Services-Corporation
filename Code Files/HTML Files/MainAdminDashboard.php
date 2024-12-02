<?php


    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll4.0";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['DVID'])) {
        $accountId = $_SESSION['DVID']; // The account ID of the logged-in admin

        // Prepare the SQL query
        $stmt = $conn->prepare("
            SELECT 
                tl.TL_ProfileIMg AS LEAD_PROFILE, 
                CONCAT(tln.TLN_FName, ' ', tln.TLN_MName, ' ', tln.TLN_LName, ' ', tln.TLN_Suffix) AS LEAD_NAME, 
                tlp.TLP_Position AS LEAD_POSITION
            FROM teamlead_information tl
            JOIN teamlead_name tln ON tl.TL_NameID = tln.TLN_ID
            JOIN teamlead_position tlp ON tl.TL_PositionID = tlp.TLP_ID
            WHERE tl.TL_AccountID = ?
        ");
        $stmt->bind_param("i", $accountId); // Bind the account ID
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch data
        if ($row = $result->fetch_assoc()) {
            $_SESSION['LEAD_PROFILE'] = $row['LEAD_PROFILE'];
            $_SESSION['LEAD_NAME'] = $row['LEAD_NAME'];
            $_SESSION['LEAD_POSITION'] = $row['LEAD_POSITION'];
        } else {
            // Handle case where no data is found
            $_SESSION['LEAD_PROFILE'] = null;
            $_SESSION['LEAD_NAME'] = "Admin";
            $_SESSION['LEAD_POSITION'] = "Unknown Position";
        }
        $stmt->close();
    }   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../CSS Files/MainAdminDashboard.css?v=1.3">
    <title>ADMIN DASHBOARD</title>
</head>
<body>

    <!-- <div class="navbar" id="navbar">
        <nav>          
            <img src="../Imagess/comp-logo2.png" alt="">
        </nav>
    </div> -->

    <div class="side-bar">
        <div class="side-profile">
            <!-- Display Profile Image -->
             <div class="bg"></div>
            <?php if (isset($_SESSION['LEAD_PROFILE']) && $_SESSION['LEAD_PROFILE']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['LEAD_PROFILE']); ?>" alt="Profile Image" class="profile-img" draggable="false">
            <?php else: ?>
           
            <?php endif; ?>

            <!-- Display Name and Position -->
            <h3 class="admin-name"><?php echo $_SESSION['LEAD_NAME'] ?? "Admin Name"; ?></h3>
            <h5 class="admin-role"><?php echo $_SESSION['LEAD_POSITION'] ?? "Admin Role"; ?></h5>
        </div>


        <div class="side-menu">
            <ul>
                <li><a href="Dashboard.html?v=1.2" target="iframe-dashboard" draggable="false"><i class='bx bxs-dashboard' ></i>&nbsp;DASHBOARD</a></li>
                <li><a href="http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/HTML%20Files/Accounts.php" target="iframe-dashboard" draggable="false"><i class='bx bxs-user'></i>&nbsp;ACCOUNTS</a></li>
                <!-- <li><a href="Driver.html" target="iframe-dashboard" draggable="false"><i class="fa-solid fa-car"></i> &nbsp;DRIVERS</a></li>
                <li><a href="Admin.html" target="iframe-dashboard" draggable="false"><i class='bx bxs-user-check'></i>&nbsp;ADMIN</a></li> -->
                <li><a href="http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/HTML%20Files/Hubs.php" target="iframe-dashboard" draggable="false"><i class="fa-solid fa-location-dot"></i>&nbsp;&nbsp; HUBS</a></li>
                <li><a href="http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/HTML%20Files/Contribution.php" target="iframe-dashboard" draggable="false"><i class='bx bxs-credit-card-alt' ></i>&nbsp;CONTRIBUTION</a></li>
                <li><a href="Event2.html?v=1.3" target="iframe-dashboard" draggable="false"><i class='bx bxs-calendar'></i>&nbsp;EVENT</a></li>
                <li><a href="http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/HTML%20Files/Attendance.php" target="iframe-dashboard" draggable="false"><i class='bx bxs-check-circle'></i>&nbsp;ATTENDANCE</a></li>
                <li><a href="http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/HTML%20Files/Delivery.php" target="iframe-dashboard" draggable="false"><i class='bx bxs-package'></i>&nbsp;DELIVERY</a></li>
                <li><a href="http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/HTML%20Files/Payroll.php" target="iframe-dashboard" draggable="false"><i class='bx bxs-dollar-circle' ></i>&nbsp;PAYROLL</a></li>
                <li><a href="../HTML Files/Logout.php" draggable="false"><i class='bx bxs-log-out-circle'></i>&nbsp;LOGOUT</a></li>
            </ul>
  
        </div>
       
    </div>

    <div class="iframe-container">
        <iframe id="iframe-dashboard" name="iframe-dashboard" ></iframe>  
    </div>


    <script src="../JS Files/AdminDashboard.js?v=1.2"></script>
</body>
</html>