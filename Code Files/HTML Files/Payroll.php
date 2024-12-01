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

     //payroll table
    $sql = "
        SELECT
            di.DI_ID,
            CONCAT(dn.DN_FName,' ', dn.DN_MName,' ', dn.DN_LName,' ', dn.DN_Suffix) AS DRIVER_NAME,
            hubr.HUBR_Rate,
            asum.ASUM_RegularDay,
            asum.ASUM_SpecialHoliday,
            asum.ASUM_RegularHoliday,
            alw.ALW_Amount AS ALLOWANCE,
            ROUND((con.CON_TOTPhilhealthContribution), 2) AS PHILHEALTH_CONTRIBUTION,
            ROUND((con.CON_SSSContribution), 2) AS SSS_CONTRIBUTION,
            ROUND((con.CON_TOTPagibigCOntribution), 2) AS PAGIBIG_CONTRIBUTION,
            ROUND((con.CON_TotalAmount), 2) AS TOTAL_AMOUNT
        FROM
            basic_pay bp
        JOIN
            attendance_summary asum ON bp.BP_AttendanceSumID = asum.ASUM_ID
        JOIN
            hub_rate hubr ON bp.BP_HubRateID = hubr.HUBR_ID
        JOIN
            allowance alw ON bp.BP_AllowanceID = alw.ALW_ID
        JOIN
            driver_information di ON asum.ASUM_DriverID = di.DI_ID
        JOIN
            driver_name dn ON di.DI_NameID = dn.DN_ID
        JOIN
            payroll pay ON bp.BP_ID = pay.PAY_BasicPayID
        JOIN
            contribution con ON pay.PAY_ContributionID = con.CON_ID
        ";

    //payslip table
    $sql2 = "
        SELECT
            d.DI_ID,
            CONCAT(n.DN_FName, ' ', n.DN_MName, ' ', n.DN_LName, ' ', n.DN_Suffix) AS DRIVER_NAME,
            d.GCash_No,
            ROUND(p.PAY_TotalAmount, 3) AS NET_PAY
        FROM
            driver_information d
        JOIN
            driver_name n ON d.DI_NameID = n.DN_ID
        LEFT JOIN
            payroll p ON d.DI_ID = p.PAY_DriverID
        JOIN
            account a ON d.DI_AccountID = a.ACC_ID
        JOIN
            account_status s ON a.ACC_StatusID = s.ACCS_ID
        WHERE
            s.ACCS_Status = 'Active';
    ";

    //payslip
    $sql3 = "
        SELECT
            DATE_FORMAT(NOW(), '%m-%d-%Y') AS date,
            CONCAT(dn.DN_FName, dn.DN_MName, dn.DN_LName, dn.DN_Suffix) AS DRIVER_NAME,
            di.DI_ID AS DRIVER_ID,
            di.Gcash_No AS GCASH,
            h.Hub_Name AS HUB_NAME,
            dut.DUT_UnitType AS UNIT_TYPE,
            asum.ASUM_RegularDay AS REG_DAY,
            (asum.ASUM_RegularDay * hubr.HUBR_Rate) AS TOT_REG_AMOUNT,
            asum.ASUM_SpecialHoliday AS SPECH_DAY,
            (asum.ASUM_SpecialHoliday * hubr.HUBR_Rate) AS TOT_SPECH_AMOUNT,
            asum.ASUM_RegularHoliday AS REGH_DAY,
            (asum.ASUM_RegularHoliday * hubr.HUBR_Rate) AS TOT_REGH_AMOUNT,
            alw.ALW_Amount AS ALLOWANCE,
            bp.BP_TotalAmount AS GROSS_PAY,
            con.CON_TOTPhilhealthContribution AS PHILHEALTH_CONTRIBUTION,
            con.CON_SSSContribution AS SSS_CONTRIBUTION,
            con.CON_TOTPagibigCOntribution AS PAGIBIG_CONTRIBUTION,
            con.CON_TotalAmount AS TOTAL_DEDUCTIONS,
            pay.PAY_TotalAmount AS NET_PAY
        FROM	
            payroll pay
        JOIN
            driver_information di ON pay.PAY_DriverID = di.DI_ID
        JOIN
            driver_name dn ON di.DI_NameID = dn.DN_ID
        JOIN
            driver_unit_type dut ON di.DI_UnitTypeID = dut.DUT_ID
        JOIN
            basic_pay bp ON pay.PAY_BasicPayID = bp.BP_ID
        JOIN
            attendance_summary asum ON bp.BP_AttendanceSumID = asum.ASUM_ID
        JOIN
            hub h ON di.DI_HubAssignedID = h.Hub_ID
        RIGHT JOIN
            hub_rate hubr ON h.Hub_ID = hubr.HUBR_HubID
        JOIN
            contribution con ON pay.PAY_ContributionID = con.CON_ID
        JOIN
            allowance alw ON bp.BP_AllowanceID = alw.ALW_ID";


    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Payroll.css?v=1.8">
    <script src="../JS Files/Payroll.js?v=1.6"></script>
    <title>PAYROLL</title>
</head>
<body>
    <div class="navbar">
        <nav>
            <h3>PAYROLL</h3>
            <div class="left">  
                <div class="payroll-btn">
                    <button id="createPayslipBtn"  onclick="togglePayslip('payslip')">Create Payslip</button>
                    <button id="sendBtn" style="display: none;">Send</button>
                    <button onclick="printTable()">Print Table</button>                
                    
                </div>              
            </div>
            <div class="right">
                <div class="pay">
                    <label for="payperiod">PAY PERIOD:</label>
                    <input type="date" name="payperiod1" id="">
                    <label for="">TO</label>
                    <input type="date" name="payperiod2" id="">
                </div>
                
                <div class="low-right">
                    <input type="text" id="allowance" placeholder="ALLOWANCE">
                                  
                    <select>
                        <option value="" disabled selected>Hub</option>
                        <option value="hub1">Lower</option>
                        <option value="hub2">Upper</option>
                        <option value="hub3">East</option>
                        <option value="hub3">West</option>
                    </select>
                    <input type="button" value="CANCEL" id="cancelBtn" style="display: none;" onclick="togglePayslip('cancel')">  
                </div>
            </div>

            
        </nav>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>Driver ID</th>
                <th>Name</th>
                <th>Salary Rate</th>
                <th>Regular Day</th>
                <th>Special Holiday</th>
                <th>Regular Holiday</th>
                <th>Allowance</th>
                <th>Philhealth CONTRIBUTION</th>
                <th>SSS CONTRIBUTION</th>
                <th>Pagibig CONTRIBUTION</th>
                <th>Total</th>
            </tr>
            <?php
                if ($result && $result->num_rows > 0) {
                    // Fetch and display each row from the result set
                    while ($row = $result->fetch_assoc()) {               
                        echo "
                        <tr>
                            <td>". htmlspecialchars($row['DI_ID']) . "</td>
                            <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                            <td>₱ ". htmlspecialchars($row['HUBR_Rate']) . "</td>
                            <td>". htmlspecialchars($row['ASUM_RegularDay']) . "</td>
                            <td>". htmlspecialchars($row['ASUM_SpecialHoliday']) . "</td>
                            <td>". htmlspecialchars($row['ASUM_RegularHoliday']) . "</td>
                            <td>₱ ". htmlspecialchars($row['ALLOWANCE']) . "</td>
                            <td>₱ ". htmlspecialchars($row['PHILHEALTH_CONTRIBUTION']) . "</td>
                            <td>₱ ". htmlspecialchars($row['SSS_CONTRIBUTION']) . "</td>
                            <td>₱ ". htmlspecialchars($row['PAGIBIG_CONTRIBUTION']) . "</td>
                            <td>₱ ". htmlspecialchars($row['TOTAL_AMOUNT']) . "</td>
                        </tr>
                        ";
                    }
                }
            ?>
            
        </table>
    </div>

    <div class="payslip-container">
        <div class="payslip-left">   
            <div class="payslip-table">
                <table>
                    <tr>
                        <th>DRIVER ID</th>
                        <th>NAME</th>
                        <th>GCASH NUMBER</th>
                        <th>NET PAY</th>
                    </tr>
                    <?php
                        if ($result3 && $result3->num_rows > 0) {
                            // Fetch and display each row from the result set
                            while ($row = $result3->fetch_assoc()) {               
                                echo "
                                    <tr onclick='updatePayslipData(" . 
                                        $row['DRIVER_ID'] . ", \"" . addslashes($row['DRIVER_NAME']) . "\", \"" . $row['GCASH'] . "\", " . $row['NET_PAY'] . ", \"" . 
                                        addslashes($row['UNIT_TYPE']) . "\", " . 
                                        $row['REG_DAY'] . ", " . 
                                        $row['SPECH_DAY'] . ", " . 
                                        $row['REGH_DAY'] . ", " . 
                                        $row['TOT_REG_AMOUNT'] . ", " . 
                                        $row['TOT_SPECH_AMOUNT'] . ", " . 
                                        $row['TOT_REGH_AMOUNT'] . ", " . 
                                        $row['ALLOWANCE'] . ", " . 
                                        $row['GROSS_PAY'] . ", " . 
                                        $row['SSS_CONTRIBUTION'] . ", " . 
                                        $row['PHILHEALTH_CONTRIBUTION'] . ", " . 
                                        $row['PAGIBIG_CONTRIBUTION'] . ", " . 
                                        $row['TOTAL_DEDUCTIONS'] . ", \"" . 
                                        addslashes($row['HUB_NAME']) . "\")'>
                                        <td>". htmlspecialchars($row['DRIVER_ID']) . "</td>
                                        <td>". htmlspecialchars($row['DRIVER_NAME']) . "</td>
                                        <td>". htmlspecialchars($row['GCASH']) . "</td>
                                        <td>₱ ". htmlspecialchars($row['NET_PAY']) . "</td>
                                    </tr>
                                ";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>

        <div class="payslip-right">
            <div class="payslip-slip">
                <div class="payslip-head">
                    <h2>GALLEON SERVICES <br> CORPORATION</h2>
                    <h3>DATE - DATE</h3>
                    <h3 id="divider">-----------------------------------------------------------------------------</h3>
                </div>

                <div class="payslip-driver">  
                    <div class="driver-head">
                        <div class="driver-data">
                            <h4>NAME: </h4>
                            <h4>DRIVER ID: </h4>
                            <h4>HUB: </h4>
                            <h4>UNIT TYPE: </h4>
                        </div>
                       
                    </div>
                    <h3 id="divider">----------------------------------------------------------------</h3>
                </div>

                <div class="payslip-earnings">  
                    <div class="earning-head">
                        <h2>EARNINGS</h2>
                        <div class="earning-category">
                            <div class="earning-left">

                            <table id="earning-table">
                                <tr>
                                    <th>DAYS</th>
                                    <th>AMOUNT</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>                                                        
                            </div>
                        
                            <div class="earning-right">
                                <div class="earning-data">
                                    <h4>REGULAR DAY: </h4>
                                    <h4>SPECIAL HOLIDAY: </h4>
                                    <h4>REGULAR HOLIDAY: </h4>
                                    <h4>ALLOWANCE:</h4>
                                    <h4>TOTAL GROSS PAY:</h4>
                                </div>                                                 
                            </div>
                        </div>
                        <h3 id="divider">--------------------------------------------------------------</h3>
                    </div>

                </div>

                <div class="payslip-deductions">  
                    <div class="deductions-head">
                        <h2>DEDUCTIONS</h2>
                        <div class="deductions-data">
                            <h4>SSS: </h4>
                            <h4>PHILHEALTH: </h4>
                            <h4>PAGIBIG: </h4>
                            <h4>TOTAL DEDUCTIONS: </h4>
                            <h4>NET PAY: </h4>
                        </div>  
                        
                    </div>

                </div>

                
            </div>

        </div>
    </div>

</body>
</html>