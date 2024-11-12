<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Portal</title>
  <link rel="stylesheet" href="../CSS Files/INDEX.CSS?v=1.2">
</head>
<body>
  <div class="container">
    <img src="/PIC" alt="">
    <header>
      <img src="LOGO.png" alt="Company Logo" class="logo">
      <h1>Driver Portal</h1>
      <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
      <div class="dropdown" id="dropdown-menu">
        <a href="javascript:void(0)" onclick="showForm('EMP_PERSONAL-ACCOUNT', true)">Profile</a>
        <a href="javascript:void(0)" onclick="showForm('EMP_PAYSLIP', false)">Payslip</a>
        <a href="javascript:void(0)" onclick="showForm('EMP_ATTENDANCE-SUMMARY', false)">Attendance Summary</a>
        <a href="javascript:void(0)" onclick="showForm('EMP_SUBMIT-ATTENDANCE', false)">Submit Attendance</a>
        <a href="javascript:void(0)" onclick="logout()">Logout</a>
      </div>
    </header>
    
    <?php
  include("employee_profile.php");
    ?> 

    <!-- Profile Section - Static -->
    <form method="post" id="profileform" enctype="multipart/form-data" action="employee_profilepic.php">
    <section class="profile"> 
        <div class="photo-name">
            <img src="data:image/png;base64,<?php echo $DRV["Profile"]; ?>" alt="Driver Photo" class="driver-photo">
            <div>
                <h2 class="driver-name"> <?php echo "$FullName"; ?> </h2>
                <input type="file" name="profile" id="profile" style="display: none;" accept="image/*" onchange="document.getElementById('profileform').submit();">
                <button type="button" class="edit-photo-btn" onclick="document.getElementById('profile').click();">Edit Photo</button>
                <input type="hidden" name="id" value="profileform"> <!-- Add this hidden input -->
            </div>
        </div>
    </section>
</form>

    <!-- Navigation Menu - Static -->
    <nav class="nav-menu">
      <a href="javascript:void(0)" onclick="showForm('EMP_PERSONAL-ACCOUNT', true)">Personal & Account</a>
      <a href="javascript:void(0)" onclick="showForm('EMP_VEHICLE', true)">Vehicle</a>
      <a href="javascript:void(0)" onclick="showForm('EMP_CONTACTS', true)">Contacts</a>
      <a href="javascript:void(0)" onclick="showForm('EMP_GOVERNMENT-INFO', true)">Government Information</a>
    </nav>

    <!-- This is where the form content will be dynamically loaded -->
    <div id="form-container"></div>
  </div>

  <script src="../JS Files/INDEX.JS?v=1.1"></script>
  <script src="../JS Files/VEHICLE.JS?v=1.2"></script>
  <script src="../JS Files/GOVERNMENT-INFO.JS?v=1.2"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="../JS Files/PAYSLIP.JS"></script> 
  <script src="../JS Files/ATTENDANCE-SUMMARY.JS"></script> 
  <script src="../JS Files/SUBMIT-ATTENDANCE.JS"></script> 
  <script src="../JS Files/Employee_Profile.js?v=1.3"></script>
</body>
</html>
