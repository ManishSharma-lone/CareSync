<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

echo "Mail script started";

function sendDoctorMail($email,$name,$patient_code,  $specialization){

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
$mail->Subject = "Doctor Registration Successful";

$mail->Body = "
<h2>Welcome Dr.$name</h2>
<p>You have been successfully added to CareSync Hospital.</p>
<p>Your Doctor ID is <b>$patient_code</b></p>
<p><b>Specialization:</b> $specialization</p>
";

$mail->send();

echo "Mail Sent Successfully";

}catch(Exception $e){

echo "Mailer Error: {$mail->ErrorInfo}";

}

}
?>