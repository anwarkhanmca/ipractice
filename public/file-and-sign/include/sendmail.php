<?php

	function HtmlMailSend($to,$subject,$mailcontent,$from)
	{
		include_once('PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer;
		return $mail->HtmlMailSend($to,$subject,$mailcontent,$from);
	}
	
	function SimpleMailSend($to,$subject,$mailcontent1,$from)
	{
		include_once('PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer;
		return $mail->SimpleMailSend($to,$subject,$mailcontent1,$from);
	}	
	
	function SendMail($to,$subject,$mailcontent,$from)
	{
		$array = split("@",$from,2);
		$SERVER_NAME = $array[1];
		$username =$array[0];
		$fromnew = "From: $username@$SERVER_NAME\nReply-To:$username@$SERVER_NAME\nX-Mailer: PHP";
		@mail($to,$subject,$mailcontent,$fromnew);
	}
  
    function SendHTMLMail($to,$subject,$mailcontent,$from1)
	{
			
			$limite = "_parties_".md5 (uniqid (rand()));
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: $from1\r\n";
			@mail($to,$subject,$mailcontent,$headers);
	}
	
	function SendHTMLMailWITHFile($toAddress, $toName, $subject, $Mailcontent, $attachment, $fromAddress, $fromName) {
		include_once('PHPMailer/class.phpmailer.php');
		
		$mail = new PHPMailer();
		$mail->IsSendmail(); 
		$msg = $Mailcontent;
		$body = '<html><body><p>' . $msg . '</p></body></html>'; //msg contents
		$body = preg_replace("[\\\]", '', $body);
		$mail->AddReplyTo($fromAddress, $fromName);
		$mail->SetFrom($fromAddress, $fromName);
		$mail->AddAddress($toAddress, $toName);
		$mail->Subject = $subject;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->AddAttachment($attachment);      // attachment
		return $mail->Send();
	}
	
	function SendHTMLMailWITHMultipleFile($toAddress, $toName, $subject, $Mailcontent, $attachment_arr, $fromAddress, $fromName) {
		include_once('PHPMailer/class.phpmailer.php');
		
		$mail = new PHPMailer();
		$mail->IsSendmail(); 
		$msg = $Mailcontent;
		$body = '<html><body><p>' . $msg . '</p></body></html>'; //msg contents
		$body = preg_replace("[\\\]", '', $body);
		$mail->AddReplyTo($fromAddress, $fromName);
		$mail->SetFrom($fromAddress, $fromName);
		$mail->AddAddress($toAddress, $toName);
		$mail->Subject = $subject;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($body);
		if(count($attachment_arr) > 0) {
			foreach($attachment_arr as $attachment) {
				$mail->AddAttachment($attachment);      // attachment
			}
		}
		return $mail->Send();
	}
?>