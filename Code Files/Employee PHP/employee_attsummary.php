<?php

include("employee_profile.php");
$DateStart = date('Y-m-d'); // Format: YYYY-MM-DD
$DateEnd = date('Y-m-d'); // Format: YYYY-MM-DD

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $StartDate = $_POST['DateFrom'];
    $EndDate = $_POST['DateTo'];
    DateSearchQuery($conn,$StartDate,$EndDate,$DriverID );
}


function DateSearchQuery($conn,$StartDate,$EndDate,$DriverID){
    $SummarySQL = "SELECT
    a.ATT_DriverID,
    COUNT(a.ATT_DriverID) AS Trips,
    SUM(b.DEL_ParcelCarried) AS TotalParcelsCarried,
    SUM(b.DEL_ParcelDelivered) AS TotalParcelsDelivered,
    SUM(b.DEL_ParcelReturned) AS TotalParcelsReturned
FROM
    attendance a
JOIN delivery_information b ON a.ATT_DeliveryID = b.DEL_ID
JOIN attendance_date_type c ON a.`ADT_ID` = c.`ADT_ID`
WHERE
    a.ATT_DriverID = $DriverID 
    AND c.ATT_Date BETWEEN '$StartDate' AND '$EndDate'
GROUP BY
    a.ATT_DriverID";

$AttSummary = mysqli_query($conn, $SummarySQL);

if (!$AttSummary) {
    die("Query failed: " . mysqli_error($conn));
}

$Attendance = [
    "Trips" => 0,
    "CRD" => 0,
    "DVD" => 0,
    "RTD" => 0
];

if (mysqli_num_rows($AttSummary) > 0) {
    while ($row = mysqli_fetch_assoc($AttSummary)) {
        $Attendance = [
            "Trips" => $row["Trips"],
            "CRD" => $row["TotalParcelsCarried"],
            "DVD" => $row["TotalParcelsDelivered"],
            "RTD" => $row["TotalParcelsReturned"]
        ];
    }
}

ShowStats($Attendance);
}

function ShowStats($Attendance){
    echo " <div class='stat'>
                <span id='days-with-trips' class='stat-value'>".htmlspecialchars($Attendance['Trips'])."</span>
                <label>Days with Trips</label>
            </div>
            <div class='stat'>
                <span id='packages-carried' class='stat-value'>".htmlspecialchars($Attendance['CRD'])."</span>
                <label>Packages Carried</label>
            </div>
            <div class='stat'>
                <span id='packages-delivered' class='stat-value'>".htmlspecialchars($Attendance['DVD'])."</span>
                <label>Packages Delivered</label>
            </div>
            <div class='stat'>
                <span id='packages-returned' class='stat-value'>".htmlspecialchars($Attendance['RTD'])."</span>
                <label>Packages Returned</label>
            </div>";
}
?>