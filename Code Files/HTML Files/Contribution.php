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

        $result = $conn->query($sql); 
        $result2 = $conn->query($sql2);
    
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
                            <input type="text" placeholder="Percentage">
                            <button>Apply</button>
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
    </div>
    
</body>
</html>