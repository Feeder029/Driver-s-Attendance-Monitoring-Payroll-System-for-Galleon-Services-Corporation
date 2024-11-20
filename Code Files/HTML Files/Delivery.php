<?php
    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayrolltest";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());

    //join query
    $sql = "
        SELECT
            a.ACC_Username,
            a.ACC_Password,
            a.ACC_DateCreated,
            n.AN_FName,
            n.AN_MName,
            n.AN_LName,
            n.AN_Suffix,
            r.ARL_Role,
            i.AI_ID,
            i.AI_ProfileImg,
            i.AI_Contact,
            i.AI_Email,
            i.AI_AccountID
        FROM
            admin_information i
        JOIN
            account a ON i.AI_AccountID = a.ACC_ID
        JOIN
            admin_name n ON i.AI_AdminNameID = n.AN_ID
        JOIN 
            admin_role r ON i.AI_AdminPositionID = r.ARL_ID
    ";
    $result = $conn->query($sql);   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Delivery.css">
    <title>DELIVERY</title>
</head>
<body style="background-color: rgb(217, 255, 0);">
<div class="navbar">
        <nav>
            
            <h3>Delivery</h3>

            <div class="navbar-input">
                <div class="category-btn">
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-all" checked="">
                        <div class="btn">
                            <span class="span">ALL</span>
                        </div>
                    </div>
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-accepted">
                        <div class="btn">
                            <span class="span">ACCEPTED</span>
                        </div>  </div>
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-pending">
                        <div class="btn">
                            <span class="span">&nbsp;PENDING&nbsp;</span>
                        </div>  
                    </div>
                </div>

                <div class="pay">
                    <label for="payperiod">PAY PERIOD: </label>
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
                        $fullname = trim($row['AN_FName'] . ' ' . $row['AN_MName'] . ' ' . $row['AN_LName']);
                        $dateCreated = date('M-d-y', strtotime($row['ACC_DateCreated'])); 
                        $profileImageData = base64_encode($row['AI_ProfileImg']);
                        $profileImage = "data:image/jpeg;base64,$profileImageData";
                        echo "
                        <tr>
                            <td>
                                <div class='td-content'>
                                    <div class='td-left'>
                                        <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                        <div class='td-name'>
                                            <h3 id='username' name='Username'>" . htmlspecialchars($row['ACC_Username']) . "</h3>
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($fullname) . "</h5>
                                            <h5 id='position-name' name='Position'>(<span id='position'>Position</span>&nbsp;:&nbsp;<span id='type'>" . htmlspecialchars($row['ARL_Role']) . "</span>)</h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <h3 id='date'>Submitted on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>
                                            <button id='accept-btn'>ACCEPT</button>
                                            <button id='decline-btn'>DECLINE</button>
                                            <button popovertarget='view-more-container' id='view-btn' data-id='" . htmlspecialchars($row['AI_AccountID']) . "'>REMITTANCE RECEIPT</button>

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
    </div>
</body>
</html>