<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT PASSWORD</title>
    <link rel="stylesheet" href="../CSS Files/ForgotPassword.css">
</head>
<body>


    <div class="container">
    <form action="send-password-reset.php" method="post">

    <h1> RESET PASSWORD </h1>
    <hr class="line">
    <p class="desc"> Please enter the email address associated with your account. Well send you an email with a link to reset your password.</p>

    <div class="containers">
    <Label for="Email" id="emaillabel">EMAIL ADDRESS:</Label>
    <input type="email" name="Email" id="Email" class="textbox_email">
    <button class="buttons"> Submit </button>
    </div>

    </form>
    </div>

    
</body>
</html>