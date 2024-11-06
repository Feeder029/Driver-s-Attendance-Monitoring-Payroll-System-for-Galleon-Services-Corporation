<?php
    include("employee_profile.php");


 // Connection for the Contacts Form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Initialize variables based on what is in the textboxes for the section account
    $Email = htmlspecialchars($_POST['Email']);
    $ContactNo = htmlspecialchars($_POST['Contact']);

    Contact_Update($conn, $DriverID, $Email,$ContactNo);

    header(header: "Location: EMP_INDEX.PHP"); // Refresh for updated one!
    exit();
}

//Function for update in Contacts Details
function Contact_Update($conn, $DriverID, $Email, $ContactNo) {
    $UpdateContact = "
    UPDATE driver_information 
    SET DI_ContactNo = ?, DI_Email = ? 
    WHERE DI_ID = ?";

    $UpdateQuery = mysqli_prepare($conn, $UpdateContact);
    
    if ($UpdateQuery) {
        mysqli_stmt_bind_param($UpdateQuery, "ssi", $ContactNo, $Email, $DriverID);

        if (mysqli_stmt_execute($UpdateQuery)) {
            echo "Contact information updated successfully.";
        } else {
            echo "Update failed: " . mysqli_stmt_error($UpdateQuery);
        }
        mysqli_stmt_close($UpdateQuery);
    } else {
        echo "Statement preparation failed: " . mysqli_error($conn);
    }
}
