<?php
    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll3.0";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());

    //join query
    $sql = "
        SELECT
            i.DI_ProfileImage,
            n.DN_FName,
            n.DN_MName,
            n.DN_LName,
            n.DN_Suffix,
            d.DEL_ID,
            d.DEL_ParcelCarried,
            d.DEL_ParcelDelivered,
            d.DEL_ParcelReturned,
            d.DEL_RemittanceReciept,
            t.ATT_Date,
            h.HASS_Name

        FROM
            attendance a
        JOIN
            delivery_information d ON a.ATT_DeliveryID = d.DEL_ID
        JOIN
            driver_information i ON a.ATT_DriverID = i.DI_ID
        JOIN
            driver_name n ON i.DI_NameID = n.DN_ID
        JOIN
        	attendance_date_type t ON a.ADT_ID = t.ADT_ID
        JOIN
            hub_assigned h ON i.DI_HubAssignedID = h.HASS_ID
         WHERE a.ATT_Status = 1
    ";

    $sql2="
        SELECT
                i.DI_ProfileImage,
                n.DN_FName,
                n.DN_MName,
                n.DN_LName,
                n.DN_Suffix,
                d.DEL_ID,
                SUM(d.DEL_ParcelCarried) AS Carried_Sum,
                SUM(d.DEL_ParcelDelivered) AS Delivered_Sum,
                SUM(d.DEL_ParcelReturned) AS Returned_Sum,
                d.DEL_RemittanceReciept,
                t.ATT_Date,
                a.ATT_Status,
                h.HASS_Name
            FROM
                attendance a
            JOIN
                delivery_information d ON a.ATT_DeliveryID = d.DEL_ID
            JOIN
                driver_information i ON a.ATT_DriverID = i.DI_ID
            JOIN
                driver_name n ON i.DI_NameID = n.DN_ID
            JOIN
                attendance_date_type t ON a.ADT_ID = t.ADT_ID
            JOIN
                hub_assigned h ON i.DI_HubAssignedID = h.HASS_ID
            WHERE a.ATT_Status = 2
            ";

        $result = $conn->query($sql); 
        $result2 = $conn->query($sql2);  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Attendance.css?v=1.4">
    <script src="../JS Files/Attendance.js?v=1.2"></script>
    <title>ATTENDANCE</title>
</head>
<body style="background-color: rgb(25, 0, 255);">
    <div class="navbar">
        <nav>
            
            <h3>ATTENDANCE</h3>

            <div class="navbar-input">
                <div class="category-btn">
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-list" checked="" onclick="toggleTable('list')">
                        <div class="btn">
                            <span class="span">LIST</span>
                        </div>
                    </div>
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-summary"  onclick="toggleTable('summary')">
                        <div class="btn">
                            <span class="span"> SUMMARY</span>
                        </div>  
                    </div>
                </div>

                <div class="pay">
                    <label for="payperiod">ATTENDANCE PERIOD: </label>
                    <input type="date" name="payperiod1" id="">
                    <label for="">TO</label>
                    <input type="date" name="payperiod2" id="">
                </div>

                <div class="search-bar">
                    <i class='bx bx-search'></i>
                    <input type="search" name="search" id="search" placeholder="Search" > 
                    
                    <div class="dropdown-category">
                        <div class="selected" data-default="All" data-one="Active" data-two="Pending">
                          <svg height="1em" viewBox="0 0 512 512" class="arrow">
                            <path
                              d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"
                            ></path>
                          </svg>
                        </div>
                        <div class="options">
                            <div title="dd-all">
                                <input id="dd-all" name="option" type="radio" checked="" />
                                <label class="option" for="dd-all" data-txt="All"></label>
                            </div>
                            <div title="dd-active">
                                <input id="dd-active" name="option" type="radio" />
                                <label class="option" for="dd-active" data-txt="Active"></label>
                            </div>
                            <div title="dd-pending">
                                <input id="dd-pending" name="option" type="radio" />
                                <label class="option" for="dd-pending" data-txt="Pending"></label>
                            </div>
                        </div>
                </div>

                

                </div>     
        </nav>
    </div>

    <div class="table-container">
        <table class="table-accounts">
        <?php
                if ($result && $result->num_rows > 0) {
                    // Fetch and display each row from the result set
                    while ($row = $result->fetch_assoc()) {
                        // Combine first name, middle name, and last name
                        $fullname = trim($row['DN_FName'] . ' ' . $row['DN_MName'] . ' ' . $row['DN_LName']);
                        $dateCreated = date('M-d-y', strtotime($row['ATT_Date'])); 
                        $profileImageData = base64_encode($row['DI_ProfileImage']);
                        $profileImage = "data:image/jpeg;base64,$profileImageData";
                        $remittanceImageData = base64_encode($row['DEL_RemittanceReciept']);
                        $remittanceImage = "data:image/jpeg;base64,$remittanceImageData";
                        echo "
                        <tr>
                            <td>
                                <div class='td-content'>
                                    <div class='td-left'>
                                        <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                        <div class='td-name'>
                                            <h3 id='username' name='Username'>" . htmlspecialchars($fullname) . "</h3>
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['HASS_Name']) . "</h5>
                                            <h5 id='position-name' name='Position'> | <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelCarried']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Delivered: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelDelivered']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Returned: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelReturned']) . "</span>  </h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <h3 id='date'>Submitted on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>
                                            <button id='accept-btn'>ACCEPT</button>
                                            <button id='decline-btn'>DECLINE</button>
                                           <button id='view-btn' data-image='$remittanceImage'>REMITTANCE RECEIPT</button>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td>No data found</td></tr>";
                }
            ?>
        </table>

        <div id="remittance-modal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="remittance-image">
        </div>
    </div>

    <div class="table-container-2">
        <table class="table-accounts-2">
        <?php
                if ($result2 && $result2->num_rows > 0) {
                    // Fetch and display each row from the result set
                    while ($row = $result2->fetch_assoc()) {
                        // Combine first name, middle name, and last name
                        $fullname = trim($row['DN_FName'] . ' ' . $row['DN_MName'] . ' ' . $row['DN_LName']);
                        $dateCreated = date('M-d-y', strtotime($row['ATT_Date'])); 
                        $profileImageData = base64_encode($row['DI_ProfileImage']);
                        $profileImage = "data:image/jpeg;base64,$profileImageData";
                        $remittanceImageData2 = base64_encode($row['DEL_RemittanceReciept']);
                        $remittanceImage2 = "data:image/jpeg;base64,$remittanceImageData2";
                        echo "
                        <tr>
                            <td>
                                <div class='td-content'>
                                    <div class='td-left'>
                                        <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                        <div class='td-name'>
                                            <h3 id='username' name='Username'>" . htmlspecialchars($fullname) . "</h3>
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['HASS_Name']) . "</h5>
                                            <h5 id='position-name' name='Position'> | <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['Carried_Sum']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Delivered: </span><span id='type'>" . htmlspecialchars($row['Delivered_Sum']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Returned: </span><span id='type'>" . htmlspecialchars($row['Returned_Sum']) . "</span>&nbsp;  </h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <div class='td-btn'>
                                           <button id='view-btn-2' data-image-2='$remittanceImage2'>REMITTANCE RECEIPT</button>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td>No data found</td></tr>";
                }
            ?>
        </table>

        <div id="remittance-modal-2" class="modal-2">
            <span class="close-2">&times;</span>
            <img class="modal-content-2" id="remittance-image-2">
        </div>
    </div>
</body>
</html>