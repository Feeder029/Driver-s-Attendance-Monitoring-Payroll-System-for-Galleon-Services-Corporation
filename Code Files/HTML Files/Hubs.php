<?php
    // Database connection details
    $db_server = "127.0.0.1";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll4.0";
    $conn = "";

    // Create connection
    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);

    
    //join query
    $sql = "
        SELECT
            r.HUBR_ID,
            d.hub_Name,
            a.HADD_Barangay,
            a.HADD_City,
            a.HADD_Province, 
            a.HADD_ZipCode, 
            r.HUBR_Rate
        FROM
            hub_rate r
        JOIN
            hub d ON r.HUBR_HubID = d.hub_ID
        JOIN
            hub_address a ON d.hub_AddressID = a.HADD_ID
            
    ";
    $result = $conn->query($sql);
    
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Hubs.css?v=1.4">
    <script src="../JS Files/Hubs.js?v=1.2"></script>
        <!--JQuery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>HUBS</title>
</head>
<body>
    
<div class="navbar">
        <nav>
            <h3>HUBS LIST</h3>
            <div class="hub-btn">
                <button onclick="printTable()">Print Table</button>
                <button id="add-hub-btn" popovertarget="add-hub-container">Add Hub</button>
            </div>
            <div class="navbar-input">
                <div class="search-bar">
                    <i class='bx bx-search'></i>
                    <input type="search" name="search" id="search" placeholder="Search">
                    </div>
                </div>
            </div>     
        </nav>
    </div>

    <div class="table-container">
        <table>
        <tr>
            <th>&nbsp;Hub ID &nbsp;</th>
            <th>&nbsp;Hub Name&nbsp;</th>
            <th>&nbsp;Hub Address&nbsp;</th>
            <th>&nbsp;Salary Rate&nbsp;</th>
            <th class="actions">Actions</th> <!-- Add class 'actions' -->

        </tr>
        <?php
                if ($result && $result->num_rows > 0) {
                    // Fetch and display each row from the result set
                    while ($row = $result->fetch_assoc()) {
                        $address = trim($row['HADD_Barangay'] . ', ' . $row['HADD_City'] . ', ' . $row['HADD_Province'] . ', ' . $row['HADD_ZipCode']);
                        echo "                          
                            <tr>
                                <td>" . htmlspecialchars($row['HUBR_ID']) . "</td>
                                <td>" . htmlspecialchars($row['hub_Name']) . "</td>
                                <td>" . htmlspecialchars($address) . "</td>
                                <td>₱ " . htmlspecialchars($row['HUBR_Rate']) . "</td>
                                <td>
                                    <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                                       <input type='hidden' name='hub_id' value='" . htmlspecialchars($row['HUBR_ID']) . "'>
                                        <button type='submit' name='edit_hub'>Edit</button>
                                    </form>
                                </td>

                            </tr>";
                        }
                    } else {
                        echo "<tr><td>No data found</td></tr>";
                    }
            ?>
        </table>
    </div>

    <!-- <div class="hub-btn">
    
        <button onclick="printTable()">Print Table</button>
        <button id="add-hub-btn" popovertarget="add-hub-container" style="display: none;">ADD HUB</button>
    
    </div> -->

    <div popover id="add-hub-container">
        <h2>Add Hub</h2> <!-- Heading added -->
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="text" id="hub-name" name="name" placeholder="Hub Name">
            
            <select id="barangay" name="barangay">
            </select>
            <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
            
            <select id="city" name="city">
            </select>
            <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>

            <select id="province" name="province">
            </select>
            <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
            
            <input type="text" id="hub-zipcode" name="zipcode" placeholder="Hub ZipCode">
            <input type="text" id="hub-rate" name="rate" placeholder="Hub Rate">                            
            
            <!-- Button Section -->
            <div class="form-buttons">
                <button type="submit" id="submit-hub">Submit</button>
                <button type="button" id="cancel-hub">Cancel</button>
            </div>
        </form>
    </div>

    <div class="popover-container" style="display:<?php echo isset($_POST['edit_hub']) ? 'block' : 'none'; ?>;">
        <?php
        if (isset($_POST['edit_hub'])) {
            $hub_id = $_POST['hub_id'];
            
            // Get the data for the hub_id from the database
            $sql = "SELECT r.HUBR_ID, d.hub_Name, a.HADD_Barangay, a.HADD_City, a.HADD_Province, a.HADD_ZipCode, r.HUBR_Rate
                    FROM hub_rate r
                    JOIN hub d ON r.HUBR_HubID = d.hub_ID
                    JOIN hub_address a ON d.hub_AddressID = a.HADD_ID
                    WHERE r.HUBR_ID = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, 'i', $hub_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $HUBR_ID, $hub_Name, $HADD_Barangay, $HADD_City, $HADD_Province, $HADD_ZipCode, $HUBR_Rate);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
            }
        }
        ?>

        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="hub_id" value="<?php echo htmlspecialchars($hub_id); ?>">
        
            <label for="hub-name">Hub Name:</label>
            <input type="text" id="hub-name" name="name" value="<?php echo htmlspecialchars($hub_Name); ?>"placeholder="Hub Name">
        
            <label for="hub-barangay">Hub Barangay:</label>
            <input type="text" id="hub-barangay" name="barangay" value="<?php echo htmlspecialchars($HADD_Barangay); ?>" placeholder="Hub Barangay">
        
            <label for="hub-city">Hub City:</label>
            <input type="text" id="hub-city" name="city" value="<?php echo htmlspecialchars($HADD_City); ?>" placeholder="Hub City">
        
            <label for="hub-province">Hub Province:</label>
            <input type="text" id="hub-province" name="province" value="<?php echo htmlspecialchars($HADD_Province); ?>" placeholder="Hub Province">
        
            <label for="hub-zipcode">Hub ZipCode:</label>
            <input type="text" id="hub-zipcode" name="zipcode" value="<?php echo htmlspecialchars($HADD_ZipCode); ?>" placeholder="Hub ZipCode">
        
            <label for="hub-rate">Hub Rate:</label>
            <input type="text" id="hub-rate" name="rate" value="<?php echo htmlspecialchars($HUBR_Rate); ?>" placeholder="Hub Rate">
        
            <button type="submit" name="update_hub">Update</button>
            <button type="submit" name="close_popover">Close</button>
        </form>
    </div>

    <script src="ph-address-selector.js"></script>
</body>
</html>

<?php
    if ($conn) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['update_hub'])) {
                // Update logic
                $hub_id = $_POST['hub_id'];
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
                $barangay = filter_input(INPUT_POST, 'barangay', FILTER_SANITIZE_SPECIAL_CHARS);
                $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
                $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_SPECIAL_CHARS);
                $zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_SPECIAL_CHARS);
                $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_SPECIAL_CHARS);
        
                $sql = "UPDATE hub_rate r
               JOIN hub d ON r.HUBR_HubID = d.Hub_ID
               JOIN hub_address a ON d.hub_AddressID = a.HADD_ID
               SET d.hub_Name = ?, a.HADD_Barangay = ?, a.HADD_City = ?, a.HADD_Province = ?, a.HADD_ZipCode = ?, r.HUBR_Rate = ?
               WHERE r.HUBR_ID = ?";
            
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'ssssssi', $name, $barangay, $city, $province, $zipcode, $rate, $hub_id);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<script>alert('Hub updated successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                    } else {
                        echo "Error updating record: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }

                
            } elseif (isset($_POST['name']) && !isset($_POST['hub_id'])) {
                // Insert logic
                $name  = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                $barangay  = filter_input(INPUT_POST, "barangay_text", FILTER_SANITIZE_SPECIAL_CHARS);
                $city  = filter_input(INPUT_POST, "city_text", FILTER_SANITIZE_SPECIAL_CHARS);
                $province  = filter_input(INPUT_POST, "province_text", FILTER_SANITIZE_SPECIAL_CHARS);
                $zipcode  = filter_input(INPUT_POST, "zipcode", FILTER_SANITIZE_SPECIAL_CHARS);
                $rate  = filter_input(INPUT_POST, "rate", FILTER_SANITIZE_SPECIAL_CHARS);
        
                if (empty($name) || empty($barangay) || empty($city) || empty($province) || empty($zipcode) || empty($rate)) {
                    echo "<script type='text/javascript'>alert('EMPTY FIELDS');</script>";
                } else {
                    $sql1 = "INSERT INTO hub_address (HADD_Barangay, HADD_City, HADD_Province, HADD_ZipCode) VALUES ('$barangay', '$city', '$province', '$zipcode')";
                    if (mysqli_query($conn, $sql1)) {
                        $hubaddressId = mysqli_insert_id($conn);
        
                        $sql2 = "INSERT INTO hub (hub_AddressID, hub_Name) VALUES ('$hubaddressId', '$name')";
                        if (mysqli_query($conn, $sql2)) {
                            $nameId = mysqli_insert_id($conn);
        
                            $sql3 = "INSERT INTO hub_rate (HUBR_HubID, HUBR_Rate) VALUES ('$nameId', '$rate')";
                            mysqli_query($conn, $sql3);
        
                            echo "<script type='text/javascript'>alert('ADD HUB SUCCESSFULLY');</script>";
                        } else {
                            echo "<script type='text/javascript'>alert('Error inserting into Hub Rate: " . mysqli_error($conn) . "');</script>";
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Error inserting into hub assigned name: " . mysqli_error($conn) . "');</script>";
                    }
                }
            }
        }
        

        if (isset($_POST['delete_hub']) && isset($_POST['hub_id'])) {
                $hub_id = $_POST['hub_id'];

                // First, get the hub_ID and HADD_ID that are related to the HUBR_ID from hub_rate
                $get_hub_info_sql = "SELECT HUBR_HubID FROM hub_rate WHERE HUBR_ID = ?";
                if ($stmt = mysqli_prepare($conn, $get_hub_info_sql)) {
                    mysqli_stmt_bind_param($stmt, 'i', $hub_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $hub_id);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                    // If we have the HUBR_HubID then proceed
                    if ($hub_id) {
                        // Get the associated hub_AddressID for deletion from hub
                        $get_address_id_sql = "SELECT hub_AddressID FROM hub WHERE hub_ID = ?";
                        if ($stmt = mysqli_prepare($conn, $get_address_id_sql)) {
                            mysqli_stmt_bind_param($stmt, 'i', $hub_id);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $address_id);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);

                            // Delete from hub_rate
                            $sql1 = "DELETE FROM hub_rate WHERE HUBR_HubID = ?";
                            if ($stmt = mysqli_prepare($conn, $sql1)) {
                                mysqli_stmt_bind_param($stmt, 'i', $hub_id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                            }

                            // Delete from hub
                            $sql2 = "DELETE FROM hub WHERE hub_ID = ?";
                            if ($stmt = mysqli_prepare($conn, $sql2)) {
                                mysqli_stmt_bind_param($stmt, 'i', $hub_id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                            }

                            // Delete from hub_address
                            $sql3 = "DELETE FROM hub_address WHERE HADD_ID = ?";
                            if ($stmt = mysqli_prepare($conn, $sql3)) {
                                mysqli_stmt_bind_param($stmt, 'i', $address_id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                            }

                            echo "<script type='text/javascript'>alert('Hub deleted successfully');</script>";
                        }
                    }
                }
            }

        
        
        
        mysqli_close($conn);
    }
    else {
        die("Connection failed: " . mysqli_connect_error());
    }
?>