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
    <link rel="stylesheet" href="../CSS Files/loginSignup.css">
    <!-- <script src="../JS Files/loginSignup.js" defer></script> -->
    <title>Login & Sign up</title>
</head>
<body>

    <section>       
        <div class="container">         
            <div class="inputs">
                <div class="title">
                <h3>LOGIN</h3>
                </div> 
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="loginform">
                    <input type="text" name="username" id="usernameTB" placeholder="Username">
                    <input type="password" name="password" id="passwordTB" placeholder="Password">
                    
                    <button type="submit" id="loginBTN">LOGIN</button>
                </form>                      
            </div>
                 
        </div>
    </section>


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