<?php
    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll4.0";

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
            a.ATT_ID,
            h.hub_Name,
            o.`AS_ID`
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
            hub h ON i.DI_HubAssignedID = h.hub_ID
        JOIN
            attendance_status o ON a.`ATT_StatusID` = o.`AS_ID`
        ORDER BY o.`AS_ID` ASC, t.ATT_Date DESC
    ";

    //summary
    $sql2="
 SELECT
    i.DI_ProfileImage,
    n.DN_FName,
    n.DN_MName,
    n.DN_LName,
    n.DN_Suffix,
    d.DEL_ID,
    COUNT(a.ATT_DriverID) AS Trips,
    SUM(d.DEL_ParcelCarried) AS Carried_Sum,
    SUM(d.DEL_ParcelDelivered) AS Delivered_Sum,
    SUM(d.DEL_ParcelReturned) AS Returned_Sum,
    d.DEL_RemittanceReciept,
    MAX(t.ATT_Date) AS Latest_Date,
    a.ATT_ID,
    a.ATT_StatusID,
    h.hub_Name
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
    hub h ON i.DI_HubAssignedID = h.hub_ID
WHERE a.ATT_StatusID = 2
GROUP BY
    a.ATT_DriverID
ORDER BY
COUNT(a.ATT_DriverID) DESC, SUM(d.DEL_ParcelCarried) DESC
            ";
        //pending
        $sql3 = "
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
                a.ATT_ID,
                t.ATT_Date,
                h.hub_Name
    
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
                hub h ON i.DI_HubAssignedID = h.hub_ID
            WHERE ATT_StatusID = 1
            
        ";
        //accepted
        $sql4 = "
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
                a.ATT_ID,
                h.hub_Name

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
                hub h ON i.DI_HubAssignedID = h.hub_ID
            WHERE ATT_StatusID = 2
            
        ";
        //denied
        $sql5 = "
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
                a.ATT_ID,
                h.hub_Name

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
                hub h ON i.DI_HubAssignedID = h.hub_ID
            WHERE ATT_StatusID = 3
            
        ";

        $result = $conn->query($sql); 
        $result2 = $conn->query($sql2); //summary
        $result3 = $conn->query($sql3); 
        $result4 = $conn->query($sql4); 
        $result5 = $conn->query($sql5); 
        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Attendance.css?v=1.5">
    <script src="../JS Files/Attendance.js?v=1.2"></script>
    <title>ATTENDANCE</title>
</head>
<body>
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
                        <div class="selected" data-default="All" data-one="Active" data-two="Pending" data-three="Denied">
                          <svg height="1em" viewBox="0 0 512 512" class="arrow">
                            <path
                              d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"
                            ></path>
                          </svg>
                        </div>
                        <div class="options">
                            <div title="dd-all">
                                <input id="dd-all" name="option" type="radio" checked="" />
                                <label class="option" for="dd-all" data-txt="All" onclick="toggleTable('all')"></label>
                            </div>
                            <div title="dd-active">
                                <input id="dd-active" name="option" type="radio" />
                                <label class="option" for="dd-active" data-txt="Active" onclick="toggleTable('accepted')"></label>
                            </div>
                            <div title="dd-pending">
                                <input id="dd-pending" name="option" type="radio" />
                                <label class="option" for="dd-pending" data-txt="Pending" onclick="toggleTable('pending')"></label>
                            </div>
                            <div title="dd-denied">
                                <input id="dd-denied" name="option" type="radio" />
                                <label class="option" for="dd-denied" data-txt="Denied" onclick="toggleTable('denied')"></label>
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
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['hub_Name']) . "</h5>"."
                                            <h5 id='position-name' name='Position'> | <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelCarried']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Delivered: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelDelivered']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Returned: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelReturned']) . "</span>  </h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <h3 id='date'>Submitted on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>";
                                        if($row['AS_ID']==1){
                                            echo "                                            
                                            <button id='accept-btn'>ACCEPT</button>
                                            <button id='decline-btn'>DECLINE</button>
                                            <button id='view-btn' data-image='$remittanceImage'>REMITTANCE RECEIPT</button>";
                                        }  else if($row['AS_ID']==2){
                                            echo"<button id='view-btn' data-image='$remittanceImage'>REMITTANCE RECEIPT</button>";                                 
                                        } else {
                                            echo"<button id='view-btn' data-image='$remittanceImage' style='background-color:red;'>REMITTANCE RECEIPT</button>";                                 
                                        }

                                        echo"

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
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['hub_Name']) . "</h5>
                                            <h5 id='position-name' name='Position'> | <span id='position'>No. of Trips: </span><span id='type'>" . htmlspecialchars($row['Trips']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'> <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['Carried_Sum']) . "</span> | </h5>
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

    <div class="table-container-3">
        <table class="table-accounts-3">
        <?php
                if ($result3 && $result3->num_rows > 0) {
                    // Fetch and display each row from the result set
                    while ($row = $result3->fetch_assoc()) {
                        // Combine first name, middle name, and last name
                        $fullname = trim($row['DN_FName'] . ' ' . $row['DN_MName'] . ' ' . $row['DN_LName']);
                        $dateCreated = date('M-d-y', strtotime($row['ATT_Date'])); 
                        $profileImageData = base64_encode($row['DI_ProfileImage']);
                        $profileImage = "data:image/jpeg;base64,$profileImageData";
                        $remittanceImageData3 = base64_encode($row['DEL_RemittanceReciept']);
                        $remittanceImage3 = "data:image/jpeg;base64,$remittanceImageData3";
                        echo "
                        <tr>
                            <td>
                                <div class='td-content'>
                                    <div class='td-left'>
                                        <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                        <div class='td-name'>
                                            <h3 id='username' name='Username'>" . htmlspecialchars($fullname) . "</h3>
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['hub_Name']) . "</h5>
                                            <h5 id='position-name' name='Position'> | <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelCarried']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Delivered: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelDelivered']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Returned: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelReturned']) . "</span>  </h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <h3 id='date'>Submitted on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>
                                            <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                                                <input type='hidden' name='ATT_ID' value='" . htmlspecialchars($row['ATT_ID']) . "'>
                                                <button type='submit'  id='accept-btn-3' name='accept_btn-3'>ACCEPT</button>
                                                <button type='submit'  id='decline-btn-3' name='decline_btn-3'>DECLINE</button>
                                                
                                            </form>
                                            <button id='view-btn-3' data-image-3='$remittanceImage3'>REMITTANCE RECEIPT</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td>No data found</td></tr>";
                }
            
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Check if the ACCEPT button was clicked
                    if (isset($_POST['accept_btn-3'])) {
                        // Retrieve the record ID
                        $att_id = intval($_POST['ATT_ID']); // Sanitize input
                
                        // Prepare and execute the SQL update
                        $stmt = $conn->prepare("UPDATE attendance SET ATT_StatusID = ? WHERE ATT_ID = ?");
                        $status = 2;
                        $stmt->bind_param("ii", $status, $att_id);
                
                        if ($stmt->execute()) {
                            echo "Status updated successfully!";
                        } else {
                            echo "Error updating status: " . $stmt->error;
                        }
                
                        $stmt->close();
                    } else if (isset($_POST['decline_btn-3'])) {
                        // Retrieve the record ID
                        $att_id = intval($_POST['ATT_ID']); // Sanitize input
                
                        // Prepare and execute the SQL update
                        $stmt = $conn->prepare("UPDATE attendance SET ATT_StatusID = ? WHERE ATT_ID = ?");
                        $status = 3;
                        $stmt->bind_param("ii", $status, $att_id);
                
                        if ($stmt->execute()) {
                            echo "Status updated successfully!";
                        } else {
                            echo "Error updating status: " . $stmt->error;
                        }
                
                        $stmt->close();
                    }
                }
                ?>
        </table>

        <div id="remittance-modal-3" class="modal-3">
            <span class="close-3">&times;</span>
            <img class="modal-content-3" id="remittance-image-3">
        </div>
    </div>

    <div class="table-container-4">
        <table class="table-accounts-4">
        <?php
                if ($result4 && $result4->num_rows > 0) {
                    // Fetch and display each row from the result set
                    while ($row = $result4->fetch_assoc()) {
                        // Combine first name, middle name, and last name
                        $fullname = trim($row['DN_FName'] . ' ' . $row['DN_MName'] . ' ' . $row['DN_LName']);
                        $dateCreated = date('M-d-y', strtotime($row['ATT_Date'])); 
                        $profileImageData = base64_encode($row['DI_ProfileImage']);
                        $profileImage = "data:image/jpeg;base64,$profileImageData";
                        $remittanceImageData4 = base64_encode($row['DEL_RemittanceReciept']);
                        $remittanceImage4 = "data:image/jpeg;base64,$remittanceImageData4";
                        echo "
                        <tr>
                            <td>
                                <div class='td-content'>
                                    <div class='td-left'>
                                        <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                        <div class='td-name'>
                                            <h3 id='username' name='Username'>" . htmlspecialchars($fullname) . "</h3>
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['hub_Name']) . "</h5>
                                            <h5 id='position-name' name='Position'> | <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelCarried']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Delivered: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelDelivered']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Returned: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelReturned']) . "</span>&nbsp;  </h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <h3 id='date'>Submitted on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>
                                           <button id='view-btn-4' data-image-4='$remittanceImage4'>REMITTANCE RECEIPT</button>

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

        <div id="remittance-modal-4" class="modal-4">
            <span class="close-4">&times;</span>
            <img class="modal-content-4" id="remittance-image-4">
        </div>
    </div>

    <div class="table-container-5">
        <table class="table-accounts-5">
        <?php
                if ($result5 && $result5->num_rows > 0) {
                    // Fetch and display each row from the result set
                    while ($row = $result5->fetch_assoc()) {
                        // Combine first name, middle name, and last name
                        $fullname = trim($row['DN_FName'] . ' ' . $row['DN_MName'] . ' ' . $row['DN_LName']);
                        $dateCreated = date('M-d-y', strtotime($row['ATT_Date'])); 
                        $profileImageData = base64_encode($row['DI_ProfileImage']);
                        $profileImage = "data:image/jpeg;base64,$profileImageData";
                        $remittanceImageData5 = base64_encode($row['DEL_RemittanceReciept']);
                        $remittanceImage5 = "data:image/jpeg;base64,$remittanceImageData5";
                        echo "
                        <tr>
                            <td>
                                <div class='td-content'>
                                    <div class='td-left'>
                                        <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                        <div class='td-name'>
                                            <h3 id='username' name='Username'>" . htmlspecialchars($fullname) . "</h3>
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['hub_Name']) . "</h5>
                                            <h5 id='position-name' name='Position'> | <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelCarried']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Delivered: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelDelivered']) . "</span> | </h5>
                                            <h5 id='position-name' name='Position'>  <span id='position'>Parcel Returned: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelReturned']) . "</span>&nbsp;  </h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <h3 id='date'>Submitted on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>
                                           <button id='view-btn-5' data-image-5='$remittanceImage5'>REMITTANCE RECEIPT</button>

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

        <div id="remittance-modal-5" class="modal-5">
            <span class="close-5">&times;</span>
            <img class="modal-content-5" id="remittance-image-5">
        </div>
    </div>
</body>
</html>

<?php

?>
