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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS Files/Accounts.css?v=1.4">
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
                                        <h3 id='date'>Created on&nbsp;<span id='date-created'>" . $dateCreated . "</span></h3>
                                        <div class='td-btn'>
                                            <button id='accept-btn'>ACCEPT</button>
                                            <button id='decline-btn'>DECLINE</button>
                                            <button popovertarget='view-more-container' id='view-btn' data-id='" . htmlspecialchars($row['AI_AccountID']) . "'>VIEW MORE</button>

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
        <?php
            if ($result && $result->num_rows > 0) {
                // Loop through the data again to display additional details for the selected account
                mysqli_data_seek($result, 0); // Reset the result pointer to the start
                while ($row = $result->fetch_assoc()) {
                    $dateCreated = date('M-d-y', strtotime($row['ACC_DateCreated']));
                    echo "
                    <div class='view-left'>
                                <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                <button id='change-view-img'>CHANGE IMAGE</button>

                                <div id='view-role'>
                                    <label for='view--role'>Role:</label>
                                    <!-- <input type='text' id='view-role-role' value='ROLE' disabled> -->
                                    <select name='' id='view-role-role' value='ROLE' disabled>
                                        <option selected>" . htmlspecialchars($row['ARL_Role']) . "</option>
                                    </select>
                                </div>

                                <div id='account-status'>
                                    <label for='account-status'>Account Status:</label> <br>
                                    <input type='radio' name='status-" . htmlspecialchars($row['AI_AccountID']) . "' value='Active'> ACTIVE <br>
                                    <input type='radio' name='status-" . htmlspecialchars($row['AI_AccountID']) . "' value='Inactive'> INACTIVE <br>
                                    <input type='radio' name='status-" . htmlspecialchars($row['AI_AccountID']) . "' value='Pending' checked> PENDING
                                </div>

                                <button onclick='DisableEnableInput()'>EDIT</button>
                            </div>

                            <div class='view-right'>
                                <div class='view-space'>
                                    <button popovertarget='view-more-container' popovertargetaction='hide'>CLOSE</button>
                                </div>
                                <div class='view-name'>
                                    <h2>NAME:</h2>
                                    <div class='field-group-1' id='fg1'>        
                                        <input type='text' id='firstname' value='" . htmlspecialchars($row['AN_FName']) . "' disabled>
                                        <h5 for='firstname'>FIRST NAME</h5>
                                    </div>
                                    <div class='field-group-1' id='fg1'>                   
                                        <input type='text' id='middlename' value='" . htmlspecialchars($row['AN_MName']) . "' disabled>
                                        <h5 for='middlename'>MIDDLE NAME</h5>
                                    </div>
                                    <div class='field-group-1' id='fg2'>                   
                                        <input type='text' id='lastname' value='" . htmlspecialchars($row['AN_LName']) . "' disabled>
                                        <h5 for='lastname'>LAST NAME</h5>
                                    </div>
                                    <div class='field-group-1' id='fg2'>                  
                                        <input type='text' id='suffix' value='" . htmlspecialchars($row['AN_Suffix']) . "' disabled>
                                        <h5 for='suffix'>SUFFIX</h5>
                                    </div>
                                </div>
                                <div class='view-contact'>
                                    <h2>CONTACTS:</h2>
                                    <div class='field-group-2'>
                                        <input type='text' id='contact' value='" . htmlspecialchars($row['AI_Contact']) . "' disabled>
                                        <h5 for='contact'>CONTACT NO</h5>
                                    </div>
                                    <div class='field-group-2'>
                                        <input type='text' id='email' value='" . htmlspecialchars($row['AI_Email']) . "' disabled>
                                        <h5 for='email'>EMAIL</h5>
                                    </div>
                                </div>
                                <div class='view-account'>
                                    <h2>ACCOUNT:</h2>
                                    <div class='field-group-3'>
                                        <input type='text' id='user' value='" . htmlspecialchars($row['ACC_Username']) . "' disabled>
                                        <h5 for='user'>USERNAME</h5>
                                    </div>
                                    <div class='field-group-3'>
                                        <input type='text' id='pass' value='" . htmlspecialchars($row['ACC_Password']) . "' disabled>
                                        <h5 for='pass'>PASSWORD</h5>
                                    </div>
                                </div>
                                <div class='view-date'>
                                    <h2>ACCOUNT CREATED: &nbsp;</h2>
                                    <h2>" . htmlspecialchars($dateCreated) . "</h2>
                                </div>
                        </div>";
                }
            }
    
        ?>
    </div>
</body>
</html>


