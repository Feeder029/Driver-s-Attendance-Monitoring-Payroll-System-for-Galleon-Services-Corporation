<?php

require '../DatabaseConnection/Database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve hidden inputs
    $AccID = $_POST['ID'];
    echo $AccID;

    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'Accept':
            echo "Accept";
            Accept($conn, $AccID);
            break;
        case 'Deny':
            echo "Deny";
            Deny($conn, $AccID);
            break;
        default:
            echo "No valid action selected.";
    }

    header('Location: Accounts.php'); // You can adjust this path if needed
}

function Accept($conn, $AccID) {

    $sql = "UPDATE account SET ACC_StatusID = 2 WHERE ACC_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $AccID);
    if (!$stmt->execute()) {
        die("Statement execution failed: " . $stmt->error);
    } else {
        echo "Working";
    }
    
    $stmt->close();
}

function Deny($conn, $AccID) {
    $sql = "UPDATE account SET ACC_StatusID = 3 WHERE ACC_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $AccID);
    if (!$stmt->execute()) {
        die("Statement execution failed: " . $stmt->error);
    } else {
        echo "Working";       
    }
    
    $stmt->close();
}
?>