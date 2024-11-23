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
            a.ATT_Date,
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
            hub_assigned h ON i.DI_HubAssignedID = h.HASS_ID
    ";
    $result = $conn->query($sql);   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Delivery.css?v=1.2">
    <script src="../JS Files/Delivery.js"></script>
    <title>DELIVERY</title>
</head>
<body style="background-color: rgb(217, 255, 0);">
<div class="navbar">
        <nav>
            
            <h3>Delivery</h3>

            <div class="navbar-input">
               

                <div class="pay">
                    <label for="payperiod">DELIVERY PERIOD: </label>
                    <input type="date" name="payperiod1" id="">
                    <label for="">TO</label>
                    <input type="date" name="payperiod2" id="">
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
                            <div title="dd-all">
                                <input id="dd-all" name="option" type="radio" checked="" />
                                <label class="option" for="dd-all" data-txt="Driver"></label>
                            </div>
                            <div title="dd-active">
                                <input id="dd-active" name="option" type="radio" />
                                <label class="option" for="dd-active" data-txt="Hub"></label>
                            </div>
                            <div title="dd-pending">
                                <input id="dd-pending" name="option" type="radio" />
                                <label class="option" for="dd-pending" data-txt="Date"></label>
                            </div>
                        </div>
                </div>

                

                </div>     
        </nav>
    </div>

    <section id="Driver">
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
    </section>
    
</body>
</html>