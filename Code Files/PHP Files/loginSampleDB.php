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