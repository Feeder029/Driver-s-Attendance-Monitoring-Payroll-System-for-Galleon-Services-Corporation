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

    $stmt = $conn->prepare($UpdateContact);
    $stmt->bind_param("sss",$ContactNo,$Email,$DriverID);
    $stmt->execute(); //Execute the Query
}
