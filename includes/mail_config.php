<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOTP($email, $otp)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rakshitsharma8178@gmail.com';
        $mail->Password   = 'ohczkephwbkoqvgn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->SMTPDebug = 2; // ADD THIS
        $mail->Debugoutput = 'html';

        $mail->setFrom('rakshitsharma8178@gmail.com', 'Patola Fashion Boutique');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Test OTP';
        $mail->Body = "OTP: $otp";

        $mail->send();
        return true;

    } catch (Exception $e) {
        echo $mail->ErrorInfo; // SHOW REAL ERROR
        return false;
    }
}