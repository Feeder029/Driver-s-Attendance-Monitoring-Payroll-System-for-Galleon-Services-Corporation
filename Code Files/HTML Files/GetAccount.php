<?php

    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll4.0";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = isset($_POST['input']) ? $_POST['input'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 'btn-all';
        $option = isset($_POST['option']) ? $_POST['option'] : 'all';
    
        // Build status filter
        $statusFilter = "";
        if ($status === 'btn-active') {
            $statusFilter = "Status = 2";
        } elseif ($status === 'btn-pending') {
            $statusFilter = "Status = 1";
        } elseif ($status === 'btn-all') {
            $statusFilter = "Status < 3";
        }
    
        // Build type filter
        $typeFilter = "";
        if ($option === 'admin') {
            $typeFilter = "AND UserType LIKE 'Admin'";
        } elseif ($option === 'driver') {
            $typeFilter = "AND UserType LIKE 'Driver'";
        }
    
        // Build search filter
        $searchFilter = "";
        if (!empty($input)) {
            $searchFilter = "AND (Username LIKE '%$input%' OR
                                 FirstName LIKE '%$input%' OR
                                 LastName LIKE '%$input%' OR
                                 Suffix LIKE '%$input%' OR
                                 MiddleName LIKE '%$input%')";
        }
    
        // Pass combined filters to GETTABLE
        GETTABLE($conn, $searchFilter, $statusFilter, $typeFilter);
    }
    
function START($conn) {
    $Search = "";
    $Status = "Status < 3";
    $Type = "";
    GETTABLE($conn,$Search,$Status,$Type );
}


function GETTABLE($conn,$Search,$Status,$Type) {
    //join query
    $sql = "
    SELECT * FROM Account_Info
    WHERE
    $Status
    $Type
    $Search 


 ORDER BY Status ASC, DateCreated DESC;";

 $result = $conn->query($sql);   

 SHOWTABLE($result);
}

function SHOWTABLE($result ){
    echo"<table class='table-accounts'>";
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


                               echo " <form action='AcceptDenyAcc.php' method='post' target='iframe-dashboard'>
                               <input type='hidden' name='ID' value=".htmlspecialchars($row['ID'])." >";
                               if ($row['Status'] == 1) {
                                echo "
                                <button id='accept-btn' name='action' value='Accept' onclick="."Accept()".">ACCEPT</button>
                                <button id='decline-btn' name='action' value='Deny' >DECLINE</button>";
                               } else {
                               echo "<button id='decline-btn' name='action' value='Deny' > DEACTIVATE </button>";
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
    echo "</table>";
}



?>
    



