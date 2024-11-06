<?php
    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayrolltest";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());

    // Get the ID from a GET request, for example
    // $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // // Function to fetch single row data
    // function fetchSingleRow($conn, $sql) {
    //     $result = $conn->query($sql);
    //     return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    // }

    // // Queries
    // $usernameRow = fetchSingleRow($conn, "SELECT ACC_Username FROM account");
    // $fullnameRow = fetchSingleRow($conn, "SELECT AN_FName, AN_MName, AN_LName FROM admin_name");
    // $positionRow = fetchSingleRow($conn, "SELECT ARL_Role FROM admin_role");
    

    //join query
    $sql = "
        SELECT
            a.ACC_Username,
            a.ACC_DateCreated,
            n.AN_FName,
            n.AN_MName,
            n.AN_LName,
            r.ARL_Role,
            i.AI_ProfileImg
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS Files/Accounts.css?v=1.2">
    <script src="../JS Files/Accounts.js"></script>
    <title>ACCOUNTS</title>
</head>
<body>
    <div class="navbar">
        <nav>
            
            <h3>ACCOUNTS LIST</h3>

            <div class="navbar-input">
                <div class="category-btn">
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-all" checked="">
                        <div class="btn">
                            <span class="span">ALL</span>
                        </div>
                    </div>
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-active">
                        <div class="btn">
                            <span class="span">ACTIVE</span>
                        </div>  </div>
                    <div class="btn-option">
                        <input class="input" type="radio" name="btn" value="btn-pending">
                        <div class="btn">
                            <span class="span">&nbsp;PENDING&nbsp;</span>
                        </div>  
                    </div>
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
                        $dateCreated = date('M-d-y'); 
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
                                        <h3 id='date'>Created on <span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>
                                            <button id='accept-btn'>ACCEPT</button>
                                            <button id='decline-btn'>DECLINE</button>
                                            <button id='view-btn' popovertarget='view-more-container'>VIEW MORE</button>
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

    <div popover id="view-more-container">

        <div class="view-left">
            <i class='bx bx-user-circle'></i>
            <button id="change-view-img">CHANGE IMAGE</button>

            <div id="view-role">
                <label for="view-role">Role:</label>
                <input type="text" id="view-role-role" value="ROLE" disabled>
            </div>

            <div id="account-status">
                <label for="account-status">Account Status:</label> <br>
                <input type="radio" name="status" id="Active">ACTIVE <br>
                <input type="radio" name="status" id="Inactive">INACTIVE <br>
                <input type="radio" name="status" id="Pending" checked>PENDING
            </div>

            <button onclick="DisableEnableInput()">EDIT</button>
        </div>

        <div class="view-right">
            <div class="view-space">
                <button popovertarget="view-more-container" popovertargetaction="hide">CLOSE</button>
            </div>
            <div class="view-name">
                <h2>NAME:</h2>
                <div class="field-group-1" id="fg1">        
                    <input type="text" id="firstname" value="name" disabled>
                    <h5 for="firstname">FIRST NAME</h5>
                </div>
                <div class="field-group-1" id="fg1">                   
                    <input type="text" id="middlename" value="name" disabled>
                    <h5 for="middlename">MIDDLE NAME</h5>
                </div>
                <div class="field-group-1" id="fg2">                   
                    <input type="text" id="lastname" value="name" disabled>
                    <h5 for="lastname">LAST NAME</h>
                </div>
                <div class="field-group-1" id="fg2">                  
                    <input type="text" id="suffix" value="name" disabled>
                    <h5 for="suffix">SUFFIX</h5>
                </div>
            </div>
            <div class="view-contact">
                <h2>CONTACTS:</h2>
                <div class="field-group-2">
                    <input type="text" id="contact" value="123123" disabled>
                    <h5 for="contact">CONTACT NO</h5>
                </div>
                <div class="field-group-2">
                    <input type="text" id="email" value="name@gmail.com" disabled>
                    <h5 for="email">EMAIL</h5>
                </div>
            </div>
            <div class="view-account">
                <h2>ACCOUNT:</h2>
                <div class="field-group-3">
                    <input type="text" id="user" value="user" disabled>
                    <h5 for="user">USERNAME</h5>
                </div>
                <div class="field-group-3">
                    <input type="text" id="pass" value="pass" disabled>
                    <h5 for="pass">PASSWORD</h5>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


