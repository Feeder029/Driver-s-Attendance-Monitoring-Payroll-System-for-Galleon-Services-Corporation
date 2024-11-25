<?php
$AccID = htmlspecialchars($_GET['id']); // Sanitize the input

// Ensure $AccID is an integer
$AccID = (int)$AccID;

require '../DatabaseConnection/Database.php';

// Prepare the SQL statement
$AdminInfo = "SELECT
        a.ACC_Username AS Username,
        a.ACC_Password AS Password,
        a.ACC_DateCreated AS DateCreated,
        a.ACC_AcountStatID AS Status,
        a.ACC_ID as ID,
        n.AN_FName AS FirstName,
        n.AN_MName AS MiddleName,
        n.AN_LName AS LastName,
        n.AN_Suffix AS Suffix,
        r.ARL_Role AS Role,
        i.AI_Contact AS Contact,
        i.AI_Email AS Email,
        i.AI_ProfileImg AS ProfileImage
    FROM
        admin_information i
    JOIN
        account a ON i.AI_AccountID = a.ACC_ID
    JOIN
        admin_name n ON i.AI_AdminNameID = n.AN_ID
    JOIN
        admin_role r ON i.AI_AdminPositionID = r.ARL_ID
    WHERE a.ACC_ID = ?"; // Use table alias for clarity

$stmt = $conn->prepare($AdminInfo);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $AccID);
$stmt->execute();
$result = $stmt->get_result();

// Check if data exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("No data found for ID: $AccID");
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS Files/Accounts.css?v=1.5">
    <script src="../JS Files/Accounts.js"></script>
    <style>
        body{
            overflow-x: hidden; /* Disable scrolling on both */
        }
    </style>
</head>
<body>
    <?php
    $profileImageData = base64_encode($row['ProfileImage']);
    $profileImage = "data:image/jpeg;base64,$profileImageData";
    $dateCreated = date('M-d-y', strtotime($row['DateCreated']));
    $status = htmlspecialchars($row['Status']);

    echo "
    <div class='view-left'>
        <img src='$profileImage' alt='Profile Image' class='profile-image'>
        <button id='change-view-img'>CHANGE IMAGE</button>

        <div id='view-role'>
            <label for='view--role'>Role:</label>
            <select id='view-role-role' disabled>
                <option selected>" . htmlspecialchars($row['Role']) . "</option>
            </select>
        </div>

        <div id='account-status'>
            <label for='account-status'>Account Status:</label> <br>
            <input type='radio' name='status' value='Active' " . ($status == 2 ? "checked" : "") . "> ACTIVE <br>
            <input type='radio' name='status' value='Inactive' " . ($status == 3 ? "checked" : "") . "> INACTIVE <br>
            <input type='radio' name='status' value='Pending' " . ($status == 1 ? "checked" : "") . "> PENDING
        </div>

        <button onclick='DisableEnableInput()'>EDIT</button>
    </div>

    <div class='view-right'>
        <div class='view-space'>
            <button  popovertarget='view-more-container' popovertargetaction='hide' id='close-btn' onclick='closeView()'>CLOSE</button>
        </div>
        <div class='view-name'>
            <h2>NAME:</h2>
            <div class='field-group-1'>
                <input type='text' id='firstname' value='" . htmlspecialchars($row['FirstName']) . "' disabled>
                <h5 for='firstname'>FIRST NAME</h5>
            </div>
            <div class='field-group-1'>
                <input type='text' id='middlename' value='" . htmlspecialchars($row['MiddleName']) . "' disabled>
                <h5 for='middlename'>MIDDLE NAME</h5>
            </div>
            <div class='field-group-1'>
                <input type='text' id='lastname' value='" . htmlspecialchars($row['LastName']) . "' disabled>
                <h5 for='lastname'>LAST NAME</h5>
            </div>
            <div class='field-group-1'>
                <input type='text' id='suffix' value='" . htmlspecialchars($row['Suffix']) . "' disabled>
                <h5 for='suffix'>SUFFIX</h5>
            </div>
        </div>
        <div class='view-contact'>
            <h2>CONTACTS:</h2>
            <div class='field-group-2'>
                <input type='text' id='contact' value='" . htmlspecialchars($row['Contact']) . "' disabled>
                <h5 for='contact'>CONTACT NO</h5>
            </div>
            <div class='field-group-2'>
                <input type='text' id='email' value='" . htmlspecialchars($row['Email']) . "' disabled>
                <h5 for='email'>EMAIL</h5>
            </div>
        </div>
        <div class='view-account'>
            <h2>ACCOUNT:</h2>
            <div class='field-group-3'>
                <input type='text' id='user' value='" . htmlspecialchars($row['Username']) . "' disabled>
                <h5 for='user'>USERNAME</h5>
            </div>
            <div class='field-group-3'>
                <input type='text' id='pass' value='" . htmlspecialchars($row['Password']) . "' disabled>
                <h5 for='pass'>PASSWORD</h5>
            </div>
        </div>
        <div class='view-date'>
            <h2>ACCOUNT CREATED: &nbsp;</h2>
            <h2>" . htmlspecialchars($dateCreated) . "</h2>
        </div>
    </div>";
    ?>
    <script>
        function closeView() {
            window.history.back();
        }

    </script>
</body>
</html>
