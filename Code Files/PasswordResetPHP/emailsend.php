<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//Function to send an Email
function SendEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        $Server_Address = "localhost";
        // $mail->SMTPDebug = 2; // Enable verbose debug output

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'systemdev.3rdyear@gmail.com'; // Sending Email
        $mail->Password = 'cznyuirgsdpfybzb'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;


        // Set no-reply email address
        $mail->setFrom('noreply@example.com', 'No Reply'); // No-reply email address
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "GALLEON SERVICES DRIVERS ACCOUNT PASSWORD RESET";

        $emailDesign = file_get_contents('../EmailDesigns/EmailDesign.html');

        // Replace the placeholder with the actual reset link
        $resetLink = "http://$Server_Address/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/PasswordResetPHP/ResetPassword.php?token=$token";
        $emailBody = str_replace('{reset_link}', $resetLink, $emailDesign);


        $mail->Body = $emailBody;
        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
