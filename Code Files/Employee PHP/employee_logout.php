<?php
session_start(); // Start session if not already started

// Destroy all session variables
session_unset();
session_destroy();

// Send a response back to the JavaScript
http_response_code(200); // Success
exit();
