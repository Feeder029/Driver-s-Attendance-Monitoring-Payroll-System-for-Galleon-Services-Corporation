<?php

    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll3.0";

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
    SELECT *
    FROM (
        SELECT
            b.ACC_Username AS Username,
            b.ACC_Password AS Password,
            b.ACC_DateCreated AS DateCreated,
            b.ACC_AcountStatID AS Status,
            b.ACC_ID as ID,
            n.AN_FName AS FirstName,
            n.AN_MName AS MiddleName,
            n.AN_LName AS LastName,
            n.AN_Suffix AS Suffix,
            r.ARL_Role AS Role,
            NULL AS Age,
            i.AI_Contact AS Contact,
            i.AI_Email AS Email,
            NULL AS Gender,
            NULL AS DOB,
            NULL AS LicenseImg,
            NULL AS BrgyClearanceImg,
            NULL AS PoliceClearanceImg,
            NULL AS NBIClearanceImg,
            NULL AS GCashNo,
            NULL AS GCashName,
            i.AI_ProfileImg AS ProfileImage,
            NULL AS HouseNo,
            NULL AS LotNo,
            NULL AS Street,
            NULL AS Barangay,
            NULL AS City,
            NULL AS Province,
            NULL AS ZipCode,
            NULL AS UnitType,
            NULL AS HubAssigned,
            NULL AS PhilHealthNo,
            NULL AS SSSNo,
            NULL AS PagibigNo,
            'Admin' AS UserType
        FROM
            admin_information i
        JOIN
            account b ON i.AI_AccountID = b.ACC_ID
        JOIN
            admin_name n ON i.AI_AdminNameID = n.AN_ID
        JOIN
            admin_role r ON i.AI_AdminPositionID = r.ARL_ID
        UNION
        SELECT
            b.ACC_Username AS Username,
            b.ACC_Password AS Password,
            b.ACC_DateCreated AS DateCreated,
            b.ACC_AcountStatID AS Status,
            b.ACC_ID as ID,
            c.DN_FName AS FirstName,
            c.DN_MName AS MiddleName,
            c.DN_LName AS LastName,
            c.DN_Suffix AS Suffix,
            'Driver' AS Role,
            a.DI_Age AS Age,
            a.DI_ContactNo AS Contact,
            a.DI_Email AS Email,
            a.DI_Gender AS Gender,
            a.DI_DOB AS DOB,
            a.DI_LicenseImg AS LicenseImg,
            a.DI_BrgyClearanceImg AS BrgyClearanceImg,
            a.DI_PoliceClearanceImg AS PoliceClearanceImg,
            a.DI_NBIClearanceImg AS NBIClearanceImg,
            a.Gcash_No AS GCashNo,
            a.GCash_Name AS GCashName,
            a.DI_ProfileImage AS ProfileImage,
            d.DA_HouseNo AS HouseNo,
            d.DA_LotNo AS LotNo,
            d.DA_Street AS Street,
            d.DA_Barangay AS Barangay,
            d.DA_City AS City,
            d.DA_Province AS Province,
            d.DA_ZipCode AS ZipCode,
            e.DUT_UnitType AS UnitType,
            g.HASS_Name AS HubAssigned,
            h.GOV_PhilHealthNo AS PhilHealthNo,
            h.GOV_SSSNo AS SSSNo,
            h.GOV_PagibigNo AS PagibigNo,
            'Driver' AS UserType
        FROM
            driver_information a
        JOIN
            account b ON a.DI_AccountID = b.ACC_ID
        JOIN
            driver_name c ON a.DI_NameID = c.DN_ID
        JOIN
            driver_address d ON a.DI_AddressID = d.DA_ID
        JOIN
            driver_unit_type e ON a.DI_UnitTypeID = e.DUT_ID
        JOIN
            hub_assigned g ON a.DI_HubAssignedID = g.HASS_ID
        JOIN
            government_information h ON a.DI_GovInfoID = h.GOV_ID
    ) AS subquery
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
    



