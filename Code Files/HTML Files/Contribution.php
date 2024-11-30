<?php
    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll4.0";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());

    //join query

    //philhealth
    $sql = "
        SELECT
            DATE_FORMAT(NOW(), '%Y-%m-%d') AS date,
            d.DI_ID,
            CONCAT(n.DN_FName, n.DN_MName, n.DN_LName, n.DN_Suffix) AS DRIVER_NAME,
            p.PHI_ERPercent,
            p.PHI_EEPercent,
            p.PHI_ERPercent + p.PHI_EEPercent AS PHIL_TOT_PER,
			c.CON_TOTPhilhealthContribution
        FROM
            government_information g
        JOIN
            driver_information d ON g.GOV_ID = d.DI_GovInfoID
        JOIN
            driver_name n ON d.DI_NameID = n.DN_ID
        JOIN
            philhealth p ON g.GOV_PhilHealthNo = p.PHI_No
        LEFT JOIN	
        	contribution c ON g.GOV_ID = c.CON_GovInfoID
        
    ";

    //pagibig
    $sql2 = "
        SELECT
                DATE_FORMAT(NOW(), '%Y-%m-%d') AS date,
                d.DI_ID,
                CONCAT(n.DN_FName, n.DN_MName, n.DN_LName, n.DN_Suffix) AS DRIVER_NAME,
                p.PBIG_ERPercent,
                p.PBIG_EEPercent,
                p.PBIG_ERPercent + p.PBIG_EEPercent AS PBIG_TOT_PER,
                c.CON_TOTPagibigContribution
            FROM
                government_information g
            JOIN
                driver_information d ON g.GOV_ID = d.DI_GovInfoID
            JOIN
                driver_name n ON d.DI_NameID = n.DN_ID
            JOIN
                pagibig p ON g.GOV_PagibigNo = p.PBIG_No
            LEFT JOIN	
                contribution c ON g.GOV_ID = c.CON_GovInfoID";

        //sss
        $sql3 = "
        SELECT
            DATE_FORMAT(NOW(), '%Y-%m-%d') AS date,
            di.DI_ID,
            CONCAT(dn.DN_FName, dn.DN_MName, dn.DN_LName, dn.DN_Suffix) AS DRIVER_NAME,
            scr.SSSCR_EEPer,
            scr.SSSCR_ERPer,
            scr.SSSCR_EEPer + scr.SSSCR_ERPer AS SSS_TotPer,
            con.CON_SSSContribution
        FROM
            government_information gi
        JOIN
            driver_information di ON gi.GOV_ID = di.DI_GovInfoID
        JOIN
            driver_name dn ON di.DI_NameID = dn.DN_ID
        LEFT JOIN
            contribution con ON gi.GOV_ID = con.CON_GovInfoID
        JOIN
            sss sss ON gi.GOV_SSSNo = sss.SSS_No
        JOIN
            sss_contribution_rate scr ON sss.SSSCR_ID = scr.SSSCR_ID";

        $result = $conn->query($sql); 
        $result2 = $conn->query($sql2);
        $result3 = $conn->query($sql3);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply'])) {
            // Get the percentage value from the input
            $percentage = $_POST['percentage'];
        
            // Validate and sanitize the input
            if (!is_numeric($percentage) || $percentage < 0 || $percentage > 100) {
                echo "Invalid percentage value. Please enter a number between 0 and 100.";
            } else {
                // Update the database (example: updating the `PHI_ERPercent` in the `philhealth` table)
                $update_sql = "
                    UPDATE philhealth
                    SET PHI_EEPercent = ?, PHI_ERPercent = ?
                ";
        
                $stmt = $conn->prepare($update_sql);
                if ($stmt) {
                    // Bind the percentage as a double to both columns
                    $stmt->bind_param("dd", $percentage, $percentage);
        
                    if ($stmt->execute()) {
                        echo "Percentage updated successfully!";
                        echo "<script>window.location.href = window.location.href;</script>";
                        exit;
                    } else {
                        echo "Error updating percentage: " . $stmt->error;
                    }
        
                    $stmt->close();
                } else {
                    echo "Error preparing the query: " . $conn->error;
                }
            }
        }
        
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Contribution.css?v=1.5">
    <script src="../JS Files/Contribution.js?v=1.1"></script>
    <title>CONTRIBUTION</title>
</head>
<body>
    <div class="navbar">
        <nav>

            <h3>CONTRIBUTION LIST</h3>

            <div class="navbar-input">
                <div class="category-btn">
                    <input type="radio" id="philhealth" name="category" value="philhealth" onclick="toggleTable('philhealth')" />
                    <label for="philhealth">PhilHealth</label>

                    <input type="radio" id="pagibig" name="category" value="pagibig" onclick="toggleTable('pagibig')" />
                    <label for="pagibig">Pag-IBIG</label>

                    <input type="radio" id="sss" name="category" value="sss" onclick="toggleTable('sss')" />
                    <label for="sss">SSS</label>
                </div>

                
                <div class="container">
                    <div class="text-box">
                        <select>
                            <option value="" disabled selected>Hub</option>
                            <option value="hub1">Lower</option>
                            <option value="hub2">Upper</option>
                            <option value="hub3">East</option>
                            <option value="hub3">West</option>
                        </select>
                    <div class="percentage">
                        <form method="POST">
                            <input type="text" placeholder="Percentage" name="percentage" required id="philhealth-percentage">
                            <!-- <input type="text" placeholder="Percentage" name="percentage" required id="pagibig-percentage" style="display: none;">
                            <input type="text" placeholder="Percentage" name="percentage" required id="sss-percentage" style="display: none;"> -->
                            <button type="submit" name="apply">Apply</button>
                        </form>
                    </div>
                    </div>
                    
                    <div class="btns">
                        <button onclick="printTable()">Print</button>
                        <a href="Payroll.php"><button>Generate</button></a>
                    </div>
                </div>

                
            </div>     
        </nav>
    </div>


    <div class="table-container">
        <div class="philhealth-table">

            <table>
                <tr>
                    <th>DATE</th>
                    <th>DRIVER ID</th>
                    <th>DRIVER NAME</th>
                    <th>EMPLOYEE SHARE</th>
                    <th>EMPLOYER SHARE</th>
                    <th>TOTAL CONTRIBUTION</th>
                </tr>
                <?php
                    if ($result && $result->num_rows > 0) {
                        // Fetch and display each row from the result set
                        while ($row = $result->fetch_assoc()) {               
                            echo "
                                <tr>
                                    <td>". htmlspecialchars($row['date']) . "</td>
                                    <td>". htmlspecialchars($row['DI_ID']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                                    <td>". htmlspecialchars($row['PHI_ERPercent']) . "</td>
                                    <td>". htmlspecialchars($row['PHI_EEPercent']) . "</td>
                                    <td>". htmlspecialchars($row['CON_TOTPhilhealthContribution']) . "</td>
                                </tr>
                                ";
                        }
                    }
                    ?>
            </table>                  
        </div>

        <div class="pagibig-table">

            <table>
                <tr>
                    <th>DATE</th>
                    <th>DRIVER ID</th>
                    <th>DRIVER NAME</th>
                    <th>EMPLOYEE SHARE</th>
                    <th>EMPLOYER SHARE</th>
                    <th>TOTAL CONTRIBUTION</th>
                </tr>
                <?php
                    if ($result2 && $result2->num_rows > 0) {
                        // Fetch and display each row from the result set
                        while ($row = $result2->fetch_assoc()) {               
                            echo "
                                <tr>
                                    <td>". htmlspecialchars($row['date']) . "</td>
                                    <td>". htmlspecialchars($row['DI_ID']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                                    <td>". htmlspecialchars($row['PBIG_ERPercent']) . "</td>
                                    <td>". htmlspecialchars($row['PBIG_EEPercent']) . "</td>
                                    <td>". htmlspecialchars($row['CON_TOTPagibigContribution']) . "</td>
                                </tr>
                                ";
                        }
                    }
                    ?>
            </table>                  
        </div>

        <div class="sss-table">

            <table>
                <tr>
                    <th>DATE</th>
                    <th>DRIVER ID</th>
                    <th>DRIVER NAME</th>
                    <th>EMPLOYEE SHARE</th>
                    <th>EMPLOYER SHARE</th>
                    <th>TOTAL CONTRIBUTION</th>
                </tr>
                <?php
                    if ($result3 && $result3->num_rows > 0) {
                        // Fetch and display each row from the result set
                        while ($row = $result3->fetch_assoc()) {               
                            echo "
                                <tr>
                                    <td>". htmlspecialchars($row['date']) . "</td>
                                    <td>". htmlspecialchars($row['DI_ID']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                                    <td>". htmlspecialchars($row['SSSCR_ERPer']) . "</td>
                                    <td>". htmlspecialchars($row['SSSCR_EEPer']) . "</td>
                                    <td>". htmlspecialchars($row['CON_SSSContribution']) . "</td>
                                </tr>
                                ";
                        }
                    }
                    ?>
            </table>                  
        </div>
    </div>
    
</body>
</html>
