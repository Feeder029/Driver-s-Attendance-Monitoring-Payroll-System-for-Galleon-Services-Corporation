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
        $mail->Body = <<<END
        CLICK <a href="http://localhost/Driver-s-Attendance-Monitoring-Payroll-System-for-Galleon-Services-Corporation/Code%20Files/LoginSignup/ResetPassword.php?token=$token">here</a>
        to reset your password.
        END;
        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
