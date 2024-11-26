<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS Files/Accounts.css?v=1.5">
    <script src="../JS Files/Accounts.js"></script>
    <title>ACCOUNTS</title>
    <style>
        body{
            overflow: hidden; /* Disable scrolling on both */

        }
    </style>
</head>
<body>
<?php
require "GetAccount.php";
?>
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
                        <div class="selected" data-default="All" data-one="Admin" data-two="Driver">
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
                            <div title="dd-admin">
                                <input id="dd-admin" name="option" type="radio" />
                                <label class="option" for="dd-admin" data-txt="Admin"></label>
                            </div>
                            <div title="dd-driver">
                                <input id="dd-driver" name="option" type="radio" />
                                <label class="option" for="dd-driver" data-txt="Driver"></label>
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
                        $fullname = trim($row['FirstName'] . ' ' . $row['MiddleName'] . ' ' . $row['LastName']);
                        $dateCreated = date('M-d-y', strtotime($row['DateCreated'])); 
                        $profileImageData = base64_encode($row['ProfileImage']);
                        $profileImage = "data:image/jpeg;base64,$profileImageData";
                        echo "
                        <tr>
                            <td>
                                <div class='td-content'>
                                    <div class='td-left'>
                                        <img src='$profileImage' alt='Profile Image' class='profile-image'>
                                        <div class='td-name'>
                                            <h3 id='username' name='Username'>" . htmlspecialchars($row['Username']) . "</h3>
                                            <h5 id='fullname' name='Fullname'>" . htmlspecialchars($fullname) . "</h5>
                                            <h5 id='position-name' name='Position'>(<span id='position'>Position</span>&nbsp;:&nbsp;<span id='type'>" . htmlspecialchars($row['Role']) . "</span>)</h5>
                                        </div>
                                    </div>
                                    <div class='td-right'>
                                        <h3 id='date'>Created on&nbsp;<span id='date-created'>" . htmlspecialchars($dateCreated) . "</span></h3>
                                        <div class='td-btn'>";



                                           if ($row['Status'] == 1) {
                                            echo " <form action='AcceptDenyAcc.php' method='post' target='iframe-dashboard'>
                                            <input type='hidden' name='ID' value=".htmlspecialchars($row['ID'])." >
                                            <button id='accept-btn' name='action' value='Accept' onclick="."Accept()".">ACCEPT</button>
                                            <button id='decline-btn' name='action' value='Deny' >DECLINE</button>";
                                           } else {
                                           echo "<button id='decline-btn' name='action' value='Inactive' > DEACTIVATE </button>";
                                           };

                                            // Conditional rendering based on UserType
                                            if ($row['UserType'] == "Admin") {
                                                echo "
                                                <a href='AdminViewMore.php?id=" . htmlspecialchars($row['ID']) . "'>
                                                    <button type='button' popovertarget='view-more-container' id='view-btn' data-id='" . htmlspecialchars($row['ID']) . "'>VIEW MORE</button>
                                                </a>";
                                            } else {
                                                echo "
                                                <a href='DriverViewMore.php?id=" . htmlspecialchars($row['ID']) . "'>
                                                    <button type='button'  popovertarget='view-more-container' id='view-btn' data-id='" . htmlspecialchars($row['ID']) . "'>VIEW MORE</button>
                                                </a>";
                                            }
                                            
                        
                        echo "</form>
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


