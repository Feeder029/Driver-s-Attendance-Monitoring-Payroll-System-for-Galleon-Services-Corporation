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
            DATE_FORMAT(NOW(), '%Y-%m-%d') AS date,
            d.DI_ID,
            CONCAT(n.DN_FName, n.DN_MName, n.DN_LName, n.DN_Suffix) AS DRIVER_NAME,
            p.PHI_ERPercent,
            p.PHI_EEPercent
        FROM
            government_information g
        JOIN
            driver_information d ON g.GOV_ID = d.DI_GovInfoID
        JOIN
            driver_name n ON d.DI_NameID = n.DN_ID
        JOIN
            philhealth p ON g.GOV_PhilHealthNo = p.PHI_No
        
    ";

   

        $result = $conn->query($sql); 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Contribution.css?v=1.3">
    <script src="../JS Files/Contribution.js"></script>
    <title>CONTRIBUTION</title>
</head>
<body>
    <div class="navbar">
        <nav>

            <h3>CONTRIBUTION LIST</h3>

            <div class="navbar-input">
                <div class="category-btn">
                    <button onclick="selectCategory('btn-all')" class="btn">
                        <span>PhilHealth</span>
                    </button>
                    <button onclick="selectCategory('btn-active')" class="btn">
                        <span>Pag-IBIG</span>
                    </button>
                    <button onclick="selectCategory('btn-pending')" class="btn">
                        <span>SSS</span>
                    </button>
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
                                ?
                            </tr>
                            ";
                    }
                }
                ?>
        </table>
    </div>
    
</body>
</html>