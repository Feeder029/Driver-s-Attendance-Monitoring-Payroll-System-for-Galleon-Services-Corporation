<?php

include("employee_profile.php");


// Connection for the Profile Picture Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && $_POST['id'] == 'profileform') {

    echo "PROFILEFORM";

    //If statement to see if the picture is uploaded
    if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
        //Get the Binary Data
        $profilePic = mysqli_real_escape_string($conn, file_get_contents($_FILES['profile']['tmp_name']));
    }

    Profile_PicUpdate($conn, $DriverID, $profilePic);
    header(header: "Location: employee_profiledes.php"); // Refresh for updated one!
    exit(); 

}


//Function for update in Profile Picture
function Profile_PicUpdate($conn, $DriverID, $image) {

    $sql = "UPDATE driver_information a
                JOIN account b ON a.`DI_AccountID` = b.`ACC_ID`
                SET b.`ACC_ProfilePicture` = '$image'
                WHERE a.DI_ID = $DriverID";
    
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            echo "Update failed: " . mysqli_error($conn);
        } else {
            echo "Profile picture updated successfully.";
        }
    }

?>