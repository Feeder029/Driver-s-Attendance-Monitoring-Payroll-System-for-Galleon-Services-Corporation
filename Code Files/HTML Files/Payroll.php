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
            hub d ON r.HUBR_HubID = d.hub_D
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
    <link rel="stylesheet" href="../CSS Files/Payroll.css?v=1.5">
    <script src="../JS Files/Payroll.js?v=1.3"></script>
    <title>PAYROLL</title>
</head>
<body>
    <div class="navbar">
        <nav>
            <h3>PAYROLL</h3>
            <div class="left">
               

                
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
                    <input type="text" id="hub" placeholder="HUB">
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
            <tr>
                <td>77522</td>
                <td>Queen Prom</td>
                <td>₱ 442.32</td>
                <td>12</td>
                <td>3</td>
                <td>1</td>
                <td>₱ 1000.00</td>
                <td>₱ 112.81</td>
                <td>₱ 35.18</td>
                <td>₱ 91.11</td>
                <td>₱ 1239.10</td>
            </tr>
            <tr>
                <td>93045</td>
                <td>Marcus Abba Ponto Jr</td>
                <td>₱ 500.99</td>
                <td>21</td>
                <td>2</td>
                <td>4</td>
                <td>₱ 1000.00</td>
                <td>₱ 316.25</td>
                <td>₱ 123.04</td>
                <td>₱ 63.11</td>
                <td>₱ 1502.40</td>
            </tr>
            <tr>
                <td>1053</td>
                <td>Baxter Berry Adele</td>
                <td>₱ 500.99</td>
                <td>27</td>
                <td>6</td>
                <td>2</td>
                <td>₱ 1000.00</td>
                <td>₱ 392.75</td>
                <td>₱ 210.24</td>
                <td>₱ 121.99</td>
                <td>₱ 1724.98</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Jhon Macaspac Lucas</td>
                <td>₱ 625.99</td>
                <td>31</td>
                <td>2</td>
                <td>4</td>
                <td>₱ 1200.00</td>
                <td>₱ 216.89</td>
                <td>₱ 123.45</td>
                <td>₱ 171.05</td>
                <td>₱ 1711.39</td>
            </tr>
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
                </table>
            </div>
        </div>

        <div class="payslip-right">
            <div class="payslip-slip">
                <div class="payslip-head">
                    <h2>GALLEON SERVICES <br> CORPORATION</h2>
                    <h3>DATE - DATE</h3>
                    <h2>--------------------------------------------------</h2>
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
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </table>                                                        
                            </div>
                        
                            <div class="earning-right">
                                <div class="earning-data">
                                    <h4>REGULAR DAY: </h4>
                                    <h4>SPECIAL HOLIDAY: </h4>
                                    <h4>REGULAR HOLIDAY: </h4>
                                    <h4>ALLOWANCE: </h4>
                                    <h4>TOTAL GROSS PAY: </h4>
                                </div>                                                 
                            </div>
                        </div>
                        <h3>--------------------------------------------------------------</h3>
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
                        <h3>--------------------------------------------------------------</h3>
                    </div>

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

                </div>
            </div>

        </div>
        <div class="right-payslip-btn">
            <button>PRINT</button>
            <button>SEND</button>
        </div>
    </div>



    <div class="payroll-btn">
    
        <button onclick="printTable()">Print Table</button>
        <button onclick="togglePayslip('payslip')">Create Payslip</button>
        <button>Delete</button>
        <button>Edit</button>
    
    </div>
</body>
</html>