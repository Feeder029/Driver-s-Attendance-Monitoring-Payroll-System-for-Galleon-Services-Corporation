<?php
include("employee_profile.php");

// Connection for the Contacts Form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Initialize variables for non-image fields
    $PagibigNo = htmlspecialchars($_POST['PagibigNo']);
    $PhilHealthNo = htmlspecialchars($_POST['PhilHealthNo']);
    $SSSNo = htmlspecialchars($_POST['SSSNo']);

    // Prepare image variables as NULL initially (they will update conditionally)
    $BrgyClearanceQuery = "";
    $PoliceClearanceQuery = "";
    $NBIClearanceQuery = "";

    // Conditionally process Barangay Clearance image if a new file is uploaded
    if (isset($_FILES['Brgy']) && $_FILES['Brgy']['error'] == UPLOAD_ERR_OK && $_FILES['Brgy']['size'] > 0) {
        $BrgyClearance = mysqli_real_escape_string($conn, file_get_contents($_FILES['Brgy']['tmp_name']));
        $BrgyClearanceQuery = ", a.`DI_BrgyClearanceImg` = '$BrgyClearance'";
    }

    // Conditionally process Police Clearance image if a new file is uploaded
    if (isset($_FILES['Pol']) && $_FILES['Pol']['error'] == UPLOAD_ERR_OK && $_FILES['Pol']['size'] > 0) {
        $PoliceClearance = mysqli_real_escape_string($conn, file_get_contents($_FILES['Pol']['tmp_name']));
        $PoliceClearanceQuery = ", a.`DI_PoliceClearanceImg` = '$PoliceClearance'";
    }

    // Conditionally process NBI Clearance image if a new file is uploaded
    if (isset($_FILES['NBI']) && $_FILES['NBI']['error'] == UPLOAD_ERR_OK && $_FILES['NBI']['size'] > 0) {
        $NBIClearance = mysqli_real_escape_string($conn, file_get_contents($_FILES['NBI']['tmp_name']));
        $NBIClearanceQuery = ", a.`DI_NBIClearanceImg` = '$NBIClearance'";
    }

    // Call the update function with conditional image update queries
    Gov_Update($conn, $DriverID, $PhilHealthNo, $SSSNo, $PagibigNo, $BrgyClearanceQuery, $PoliceClearanceQuery, $NBIClearanceQuery);
    header(header: "Location: EMP_INDEX.PHP"); // Refresh for updated one!
    exit();
}

// Function to update government information with conditional image fields
function Gov_Update($conn, $DriverID, $PhilHealthNo, $SSSNo, $PagibigNo, $BrgyClearanceQuery, $PoliceClearanceQuery, $NBIClearanceQuery) {
    // Build the SQL query, appending image updates only if files were provided
    $GovQuery = "UPDATE driver_information a
    JOIN government_information h ON a.`DI_GovInfoID` = h.`GOV_ID`
    SET
        h.`GOV_PhilHealthNo` = '$PhilHealthNo',
        h.`GOV_SSSNo` = '$SSSNo',
        h.`GOV_PagibigNo` = '$PagibigNo'
        $BrgyClearanceQuery
        $PoliceClearanceQuery
        $NBIClearanceQuery
    WHERE DI_ID = $DriverID;";

    $result = mysqli_query($conn, $GovQuery);

    if (!$result) {
        echo "Update failed: " . mysqli_error($conn);
    } else {
        echo "Driver information updated successfully.";
    }
}

mysqli_close($conn);
?>
