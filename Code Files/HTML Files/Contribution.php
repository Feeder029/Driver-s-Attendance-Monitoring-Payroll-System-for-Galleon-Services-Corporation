<?php
    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll4.0";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());

    //join query

    //INSERT 
    $sql = "
        INSERT INTO contribution
            (CON_GovInfoID, CON_EEPhilHealthContribution, CON_ERPhilhealthContribution, CON_TOTPhilHealthContribution, CON_EEPagibigContribution, CON_ERPagibigContribution, CON_TOTPagibigContribution, CON_EESSSContribution, CON_ERSSSContribution, CON_SSSContribution, CON_TotalAmount)
        SELECT
            gi.GOV_ID AS GI_GovInfoID,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100) AS PHIL_TOTAL_EMPLOYEE,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100) AS PHIL_TOTAL_EMPLOYER,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100)) AS PHIL_TOTAL_CONTRIBUTION,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100) AS PBIG_TOTAL_EMPLOYEE,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100) AS PBIG_TOTAL_EMPLOYER,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100)) AS PBIG_TOTAL_CONTRIBUTION,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100) AS SSS_TOTAL_EMPLOYEE,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100) AS SSS_TOTAL_EMPLOYER,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100)) AS SSS_TOTAL_CONTRIBUTION,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100)) +
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100)) +
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100)) AS TOTAL_CONTRIBUTION
        FROM
            basic_pay b
        JOIN
            hub_rate r ON b.BP_HubRateID = r.HUBR_ID
        RIGHT JOIN
            allowance a ON b.BP_AllowanceID = a.ALW_ID
        RIGHT JOIN
            attendance_summary s ON b.BP_AttendanceSumID = s.ASUM_ID
        LEFT JOIN
            hub h ON r.HUBR_HubID = h.Hub_ID
        RIGHT JOIN
            driver_information d ON h.Hub_ID = d.DI_HubAssignedID
        RIGHT JOIN
            driver_name n ON d.DI_NameID = n.DN_ID
        RIGHT JOIN
            government_information gi ON d.DI_GovInfoID = gi.GOV_ID
        RIGHT JOIN
            philhealth p ON gi.GOV_PhilHealthNo = p.PHI_No
        RIGHT JOIN
            pagibig pb ON gi.GOV_PagibigNo = pb.PBIG_No
        RIGHT JOIN
            sss sss ON gi.GOV_SSSNo = sss.SSS_No
        LEFT JOIN
            sss_contribution_rate scr ON sss.SSSCR_ID = scr.SSSCR_ID
        WHERE
            NOT EXISTS (
                SELECT 1
                FROM contribution c
                WHERE c.CON_GovInfoID = gi.GOV_ID
            )";

    //view philhealth
    $sql2 = "
        SELECT
            NOW() AS date,
            d.DI_ID AS DRIVER_ID,
            CONCAT(n.DN_FName, ' ', n.DN_MName, ' ', n.DN_LName, ' ', n.DN_Suffix) AS DRIVER_NAME, 
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) AS TOTAL_PAY,  -- For display
            gi.GOV_ID AS GI_GovInfoID, 
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100) AS PHIL_TOTAL_EMPLOYEE,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100) AS PHIL_TOTAL_EMPLOYER,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100)) AS PHIL_TOTAL_CONTRIBUTION,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100) AS PBIG_TOTAL_EMPLOYEE,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100) AS PBIG_TOTAL_EMPLOYER,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100)) AS PBIG_TOTAL_CONTRIBUTION,
                ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100) AS SSS_TOTAL_EMPLOYEE,
            ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100) AS SSS_TOTAL_EMPLOYER,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100)) AS SSS_TOTAL_CONTRIBUTION,
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100)) +
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100)) +
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100)) + 
            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100)) AS TOTAL_CONTRIBUTION
        FROM
            basic_pay b
        JOIN
            hub_rate r ON b.BP_HubRateID = r.HUBR_ID
        RIGHT JOIN
            allowance a ON b.BP_AllowanceID = a.ALW_ID
        RIGHT JOIN
            attendance_summary s ON b.BP_AttendanceSumID = s.ASUM_ID
        LEFT JOIN
            hub h ON r.HUBR_HubID = h.Hub_ID
        RIGHT JOIN
            driver_information d ON h.Hub_ID = d.DI_HubAssignedID
        RIGHT JOIN
            driver_name n ON d.DI_NameID = n.DN_ID
        RIGHT JOIN
            government_information gi ON d.DI_GovInfoID = gi.GOV_ID
        RIGHT JOIN
            philhealth p ON gi.GOV_PhilHealthNo = p.PHI_No
        RIGHT JOIN
            pagibig pb ON gi.GOV_PagibigNo = pb.PBIG_No
        RIGHT JOIN
            sss sss ON gi.GOV_SSSNo = sss.SSS_No
        LEFT JOIN
            sss_contribution_rate scr ON sss.SSSCR_ID = scr.SSSCR_ID";

    //view pagibig
    $sql3="
        SELECT
                NOW() AS date,
                d.DI_ID AS DRIVER_ID,
                CONCAT(n.DN_FName, ' ', n.DN_MName, ' ', n.DN_LName, ' ', n.DN_Suffix) AS DRIVER_NAME, 
                ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) AS TOTAL_PAY,  -- For display
                gi.GOV_ID AS GI_GovInfoID, 
                ROUND(((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100), 3) AS PHIL_TOTAL_EMPLOYEE,
                ROUND(((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100), 3) AS PHIL_TOTAL_EMPLOYER,
                ROUND((((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100)) + 
                (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100)), 3) AS PHIL_TOTAL_CONTRIBUTION
            FROM
                basic_pay b
            JOIN
                hub_rate r ON b.BP_HubRateID = r.HUBR_ID
            RIGHT JOIN
                allowance a ON b.BP_AllowanceID = a.ALW_ID
            RIGHT JOIN
                attendance_summary s ON b.BP_AttendanceSumID = s.ASUM_ID
            LEFT JOIN
                hub h ON r.HUBR_HubID = h.Hub_ID
            RIGHT JOIN
                driver_information d ON h.Hub_ID = d.DI_HubAssignedID
            RIGHT JOIN
                driver_name n ON d.DI_NameID = n.DN_ID
            RIGHT JOIN
                government_information gi ON d.DI_GovInfoID = gi.GOV_ID
            RIGHT JOIN
                philhealth p ON gi.GOV_PhilHealthNo = p.PHI_No";

        //view sss
        $sql4="
            SELECT
                NOW() AS date,
                d.DI_ID AS DRIVER_ID,
                CONCAT(n.DN_FName, ' ', n.DN_MName, ' ', n.DN_LName, ' ', n.DN_Suffix) AS DRIVER_NAME, 
                ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) AS TOTAL_PAY,  -- For display
                gi.GOV_ID AS GI_GovInfoID, 
                ROUND(((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100), 3) AS PBIG_TOTAL_EMPLOYEE,
                ROUND(((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100), 3)AS PBIG_TOTAL_EMPLOYER,
                ROUND((((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100)) + 
                (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100)), 3) AS PBIG_TOTAL_CONTRIBUTION
            FROM
                basic_pay b
            JOIN
                hub_rate r ON b.BP_HubRateID = r.HUBR_ID
            RIGHT JOIN
                allowance a ON b.BP_AllowanceID = a.ALW_ID
            RIGHT JOIN
                attendance_summary s ON b.BP_AttendanceSumID = s.ASUM_ID
            LEFT JOIN
                hub h ON r.HUBR_HubID = h.Hub_ID
            RIGHT JOIN
                driver_information d ON h.Hub_ID = d.DI_HubAssignedID
            RIGHT JOIN
                driver_name n ON d.DI_NameID = n.DN_ID
            RIGHT JOIN
                government_information gi ON d.DI_GovInfoID = gi.GOV_ID
            RIGHT JOIN
                pagibig pb ON gi.GOV_PagibigNo = pb.PBIG_No";

        //view sss
        $sql5="
            SELECT
                NOW() AS date,
                d.DI_ID AS DRIVER_ID,
                CONCAT(n.DN_FName, ' ', n.DN_MName, ' ', n.DN_LName, ' ', n.DN_Suffix) AS DRIVER_NAME, 
                ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) AS TOTAL_PAY,  -- For display
                gi.GOV_ID AS GI_GovInfoID, 
                ROUND(((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100), 3) AS SSS_TOTAL_EMPLOYEE,
                ROUND(((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100), 3) AS SSS_TOTAL_EMPLOYER,
                ROUND((((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100)) + 
                (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100)), 3) AS SSS_TOTAL_CONTRIBUTION
            FROM
                basic_pay b
            JOIN
                hub_rate r ON b.BP_HubRateID = r.HUBR_ID
            RIGHT JOIN
                allowance a ON b.BP_AllowanceID = a.ALW_ID
            RIGHT JOIN
                attendance_summary s ON b.BP_AttendanceSumID = s.ASUM_ID
            LEFT JOIN
                hub h ON r.HUBR_HubID = h.Hub_ID
            RIGHT JOIN
                driver_information d ON h.Hub_ID = d.DI_HubAssignedID
            RIGHT JOIN
                driver_name n ON d.DI_NameID = n.DN_ID
            RIGHT JOIN
                government_information gi ON d.DI_GovInfoID = gi.GOV_ID
            RIGHT JOIN
                sss sss ON gi.GOV_SSSNo = sss.SSS_No
            LEFT JOIN
                sss_contribution_rate scr ON sss.SSSCR_ID = scr.SSSCR_ID";

        $sql6="
        UPDATE contribution AS c
            JOIN payroll pay ON c.CON_ID = pay.PAY_ContributionID
            JOIN basic_pay b ON pay.PAY_BasicPayID = b.BP_ID
            JOIN hub_rate r ON b.BP_HubRateID = r.HUBR_ID
            RIGHT JOIN allowance a ON b.BP_AllowanceID = a.ALW_ID
            RIGHT JOIN attendance_summary s ON b.BP_AttendanceSumID = s.ASUM_ID
            LEFT JOIN hub h ON r.HUBR_HubID = h.Hub_ID
            RIGHT JOIN driver_information d ON h.Hub_ID = d.DI_HubAssignedID
            RIGHT JOIN driver_name n ON d.DI_NameID = n.DN_ID
            RIGHT JOIN government_information gi ON d.DI_GovInfoID = gi.GOV_ID
            RIGHT JOIN philhealth p ON gi.GOV_PhilHealthNo = p.PHI_No
            RIGHT JOIN pagibig pb ON gi.GOV_PagibigNo = pb.PBIG_No
            RIGHT JOIN sss sss ON gi.GOV_SSSNo = sss.SSS_No
            LEFT JOIN sss_contribution_rate scr ON sss.SSSCR_ID = scr.SSSCR_ID
            SET 
                c.CON_ID = @CON_ID,
                c.CON_GovInfoID = @GovInfoID,
                c.CON_EEPhilHealthContribution = ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100),
                c.CON_ERPhilHealthContribution = ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100),
                c.CON_TOTPhilhealthContribution = (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_EEPercent / 100)) + 
                                                (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (p.PHI_ERPercent / 100)),
                c.CON_EEPagibigContribution = ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100),
                c.CON_ERPagibigContribution = ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100),
                c.CON_TOTPagibigContribution = (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_EEPercent / 100)) + 
                                            (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (pb.PBIG_ERPercent / 100)),
                c.CON_EESSSContribution = ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100),
                c.CON_ERSSSContribution = ((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100),
                c.CON_SSSContribution = (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_EEPer / 100)) + 
                                        (((r.HUBR_Rate * s.ASUM_OverallAttendance) + a.ALW_Amount) * (scr.SSSCR_ERPer / 100)),
                c.CON_TotalAmount = c.CON_TOTPhilHealthContribution + c.CON_TOTPagibigContribution + c.CON_SSSContribution
            WHERE c.CON_GovInfoID = @GovInfoID;
            ";

        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        $result3 = $conn->query($sql3); 
        $result4 = $conn->query($sql4); 
        $result5 = $conn->query($sql5); 

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply'])) {
            // Get the percentage value from the input
            $activeTab = $_POST['active_tab'];
            $percentage = $_POST['percentage'];
        
            // Validate and sanitize the input
            if (!is_numeric($percentage) || $percentage < 0 || $percentage > 100) {
                echo "Invalid percentage value. Please enter a number between 0 and 100.";
            } else {
                // Update the database (example: updating the PHI_ERPercent in the philhealth table)
                $update_sql = "";
                $update_sql2 = $sql6;
                switch ($activeTab) {
                    case "philhealth":
                        $update_sql = 'UPDATE philhealth SET PHI_EEPercent = ?, PHI_ERPercent = ?';
                        break;
                    case "pagibig":
                        $update_sql = 'UPDATE pagibig SET PBIG_EEPercent = ?, PBIG_ERPercent = ?';
                        break;
                    case "sss":
                        $update_sql = 'UPDATE sss_contribution_rate SET SSSCR_EEPer = ?, SSSCR_ERPer = ?';
                        break;
                }
        
                $stmt = $conn->prepare($update_sql);
                if ($stmt) {
                    // Bind the percentage as a double to both columns
                    $stmt->bind_param("dd", $percentage, $percentage);
        
                    if ($stmt->execute()) {
                        echo "Percentage updated successfully!";
                        if ($conn->query($update_sql2)) {
                            echo "Contribution table updated successfully!";
                            echo "<script>window.location.href = window.location.href;</script>";
                        } else {
                            echo "Error updating contribution table: " . $conn->error;
                        }
                        
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
                            <input type="hidden" name="active_tab" id="active-tab" value="philhealth">
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
                    if ($result3 && $result3->num_rows > 0) {
                        // Fetch and display each row from the result set
                        while ($row = $result3->fetch_assoc()) {               
                            echo "
                                <tr>
                                    <td>". htmlspecialchars($row['date']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_ID']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['PHIL_TOTAL_EMPLOYEE']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['PHIL_TOTAL_EMPLOYER']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['PHIL_TOTAL_CONTRIBUTION']) . "</td>
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
                    if ($result4 && $result4->num_rows > 0) {
                        // Fetch and display each row from the result set
                        while ($row = $result4->fetch_assoc()) {               
                            echo "
                                <tr>
                                    <td>". htmlspecialchars($row['date']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_ID']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['PBIG_TOTAL_EMPLOYEE']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['PBIG_TOTAL_EMPLOYER']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['PBIG_TOTAL_CONTRIBUTION']) . "</td>
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
                    if ($result5 && $result5->num_rows > 0) {
                        // Fetch and display each row from the result set
                        while ($row = $result5->fetch_assoc()) {               
                            echo "
                                <tr>
                                    <td>". htmlspecialchars($row['date']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_ID']) . "</td>
                                    <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['SSS_TOTAL_EMPLOYEE']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['SSS_TOTAL_EMPLOYER']) . "</td>
                                    <td>₱ ". htmlspecialchars($row['SSS_TOTAL_CONTRIBUTION']) . "</td>
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
