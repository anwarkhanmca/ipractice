<?php
include_once('PHPMailer/class.phpmailer.php');

$mail = new PHPMailer(); // defaults to using php mail
$mail->IsSendmail(); // telling the class to use SendMail transport
$msg = 'Message';
$body = '<html><body><p>' . $msg . '</p></body></html>'; //msg contents
$body = preg_replace("[\\\]", '', $body);
$mail->AddReplyTo('hr@inertwebs.in', "i-Practice");
$mail->SetFrom('hr@inertwebs.in', "i-Practice");
$mail->ReturnPath = 'sakir@crystalinfoway.com'; //bounce mail
$address = 'sakir@crystalinfoway.com'; //email recipient
$mail->AddAddress($address, "");
$mail->Subject = 'SUBJECT';
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->MsgHTML($body);
$mail->AddAttachment('../ds_files/2011-1447078314-1447669959.pdf');      // attachment
$mail->AddAttachment('../ds_files/64-8-1448099073.pdf');      // attachment
if(!$mail->Send()) {
    echo 'Message was not sent.';
    echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent.';
}

?>