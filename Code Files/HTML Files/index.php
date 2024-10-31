<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "loginsample";
    $conn = "";

    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);

    if ($conn) {
        echo "Database connected successfully.";
    } else {
        die("Connection failed: " . mysqli_connect_error());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/Employee_Profile.css">
    <title>Document</title>
</head>
<body>

    <div class="sidebar">
        <div class="profile">
        <img src="/Pictures/Employee_BAse.jpeg" alt="Profile Picture" class="profile-pic">
        <h1 class="FN"> First Name</h1>
        <h2 class="LN"> Last Name</h2>
        <p class="role"> Place Hub Driver</p> 
        <!-- replace echo <?php ?> to get inputs from the database  -->
        </div>
    </div>  
    
</body>
</html>

<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST,"username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username) || empty($password)){
            echo "<script type='text/javascript'>alert('ENTER USERNAME OR PASSWORD');</script>";
        }
        else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password)
                    VALUES ('$username', '$password')";
            mysqli_query($conn, $sql);
            echo "<script type='text/javascript'>alert('LOGIN SUCCESSFULLY');</script>";
        }
    }

    mysqli_close($conn);
    
?>