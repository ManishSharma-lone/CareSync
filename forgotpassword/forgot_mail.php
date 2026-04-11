<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

// echo "Mail script started";

function sendResetEmail($email,$link){

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'caresyncbbsr@gmail.com';
$mail->Password = 'eptjochajicisedu';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('caresyncbbsr@gmail.com','Care Sync Hospital');
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject = 'Password Reset';
$mail->Body = "Click here to reset password: <a href='$link'>Reset Password</a>";

$mail->send();
}

?>