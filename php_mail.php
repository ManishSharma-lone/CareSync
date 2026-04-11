<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// echo "Mail script started";

function sendPatientMail($email,$name,$patient_code){

$mail = new PHPMailer(true);

try{
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'caresyncbbsr@gmail.com';
$mail->Password = 'eptjochajicisedu';

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->setFrom('caresyncbbsr@gmail.com','CareSync Hospital');

$mail->addAddress($email,$name);

$mail->isHTML(true);
$mail->Subject = "Patient Registration Successful";

$mail->Body = "
<h2>Welcome $name</h2>
<p>Thank you for registering with CareSync.</p>
<p>Your Patient ID is <b>$patient_code</b></p>
";

$mail->send();
// echo "Mail Sent Successfully";
}catch(Exception $e){

echo "Mailer Error: {$mail->ErrorInfo}";
}
}
?>