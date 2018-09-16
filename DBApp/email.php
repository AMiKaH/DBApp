<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer();


$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = '587';
$mail->isHTML(true);
$mail->Username = '***@gmail.com';
$mail->Password = '********';



$mail->SetFrom('****@gmail.com');
$mail->Subject = 'Test';
$mail->Body = 'Sample';
$mail->AddAddress('****@yahoo.com');


$mail->SMTPDebug  = 3;

if(!$mail->Send()){
    echo "Mailer error: " . $mail->ErrorInfo;
} else {
    echo "Message Sent";
}






?>