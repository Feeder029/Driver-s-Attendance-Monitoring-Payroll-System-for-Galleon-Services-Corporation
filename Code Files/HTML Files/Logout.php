<?php
session_start();
session_unset();   // Unset all session variables
session_destroy(); // Destroy the session
header("Location: ../LoginSignup/INDEX.HTML"); // Redirect to login page
exit();
?>