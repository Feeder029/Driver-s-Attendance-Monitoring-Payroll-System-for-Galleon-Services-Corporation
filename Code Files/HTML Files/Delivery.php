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
    ";

    $sql2="
        SELECT
            SUM(d.DEL_ParcelCarried) AS TotalCarried,
            SUM(d.DEL_ParcelDelivered) AS TotalDelivered,
            SUM(d.DEL_ParcelReturned) AS TotalReturned,
            h.hub_Name
        FROM
            attendance a
        JOIN
            delivery_information d ON a.ATT_DeliveryID = d.DEL_ID
        JOIN
            driver_information i ON a.ATT_DriverID = i.DI_ID
        JOIN
            hub h ON i.DI_HubAssignedID = h.hub_ID
    ";


    $result = $conn->query($sql);  
    $result2 = $conn->query($sql2); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Delivery.css?v=1.3">
    <script src="../JS Files/Delivery.js?v=1.2"></script>
    <title>DELIVERY</title>
</head>
<body style="background-color: rgb(217, 255, 0);">
<div class="navbar">
        <nav>
            
            <h3>Delivery</h3>

            <div class="navbar-input">
               

                <div class="pay">
                    <label for="deliveryperiod">DELIVERY PERIOD: </label>
                    <input type="date" name="deliveryperiod1" id="deliveryperiod1">
                    <label for="">TO</label>
                    <input type="date" name="deliveryperiod2" id="deliveryperiod2">
                </div>

                <div class="search-bar">
                    <i class='bx bx-search'></i>
                    <input type="search" name="search" id="search" placeholder="Search" > 
                    
                    <div class="dropdown-category">
                        <div class="selected" data-default="Driver" data-one="Hub" data-two="Date">
                          <svg height="1em" viewBox="0 0 512 512" class="arrow">
                            <path
                              d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"
                            ></path>
                          </svg>
                        </div>
                        <div class="options">
                            <div title="dd-driver">
                                <input id="dd-driver" name="option" type="radio" checked="" />
                                <label class="option" for="dd-driver" data-txt="Driver"></label>
                            </div>
                            <div title="dd-hub">
                                <input id="dd-hub" name="option" type="radio" />
                                <label class="option" for="dd-hub" data-txt="Hub"></label>
                            </div>
                            <div title="dd-date">
                                <input id="dd-date" name="option" type="radio" />
                                <label class="option" for="dd-date" data-txt="Date"></label>
                            </div>
                        </div>
                </div>

                

                </div>     
        </nav>
    </div>

    <div id="DriverSection">
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
                                                <h5 id='fullname' name='Fullname'>" . htmlspecialchars($row['hub_Name']) . "</h5>
                                                <h5 id='position-name' name='Position'> | <span id='position'>Parcel Carried: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelCarried']) . "</span> | </h5>
                                                <h5 id='position-name' name='Position'>  <span id='position'>Parcel Delivered: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelDelivered']) . "</span> | </h5>
                                                <h5 id='position-name' name='Position'>  <span id='position'>Parcel Returned: </span><span id='type'>" . htmlspecialchars($row['DEL_ParcelReturned']) . "</span>  </h5>
                                            </div>
                                        </div>
                                        <div class='td-right'>
                                            <h3 id='date'>Submitted on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                            <div class='td-btn'>
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
    </div>


    <div id="HubSection" style="display: none;">
        <?php
            if ($result2 && $result2->num_rows > 0) {
                // Fetch and display each row from the result set
                while ($row2 = $result2->fetch_assoc()) {
                    echo"
                        <div class='hub-container'>
                            <div class='hub-left'>
                                <h1>" . htmlspecialchars($row2['hub_Name']) . "</h1>
                                <div class='parcel-count'>
                                    <div class='parcel'id='parcel-carried'>
                                        <h1>" . htmlspecialchars($row2['TotalCarried']) . "</h1>
                                        <h3>PARCEL CARRIED</h3>
                                    </div>
                                    <div class='parcel' id='parcel-delivered'>
                                        <h1>" . htmlspecialchars($row2['TotalDelivered']) . "</h1>
                                        <h3>PARCEL DELIVERED</h3>
                                    </div>
                                    <div class='parcel' id='parcel-returned'>
                                        <h1>" . htmlspecialchars($row2['TotalReturned']) . "</h1>
                                        <h3>PARCEL RETURNED</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }
        ?>
        
    </div>

    <div id="DateSection" style="display: none;">
        <h1 style="font-size: 100px;">DATE SECTIONS</h1>
    </div>

    
</body>
</html>