<?php include('connect.php');
$user_id = $_SESSION['admin_details']['id'];
$user_email = $_SESSION['admin_details']['email'];
$d_id = $_REQUEST['difs'];
$owner_id = $_REQUEST['Oid'];
$doc_name = $_REQUEST['doc_name'];
if($user_id != $owner_id) {
	echo $user_id .'<br/>';
	echo $owner_id;
	echo '<h1>Something went to wrong!<h1>'; die();
}
$invite_msg = "";
if(isset($_POST['submit']))
{
	if(isset($_REQUEST['difs']) && $_REQUEST['difs'] > 0)
	{
		$d_id = $_REQUEST['difs'];
		$d_name = $_REQUEST['doc_name'];
		if(!file_exists('ds_files/pdf_files/'.$d_name.'pdf')) {
			$q = "select * from document_image WHERE doc_id=$d_id ORDER BY id";
			$res = mysql_query($q);
			$total_page = mysql_num_rows($res);
			$jpg_files = "";
			if(mysql_num_rows($res) > 0) {
				while($f = mysql_fetch_array($res))
				{
					$jpg_files .= ' ds_files/jpg_files/'.$f['image_name']; 
				}
				
				$pdf_file = 'ds_files/pdf_files/'.$d_name.'.pdf';
				
				$location   = "convert -density 300";
				$convert   = $location . " " . $jpg_files . " " . $pdf_file;
				exec($convert." 2>&1", $array);
			}
		}
		else {
			$pdf_file = 'ds_files/pdf_files/'.$d_name.'.pdf';
		}		
	}
	extract($_POST);
			$subject = $subject;
			$toAddress = $to_email;
			$fromAddress = $From_EmailAddress;
			$fromName = "i-Practice";
			$attachment = $pdf_file;	 
		    $mailcontent = '
			<style>
			  .bodrtab
			  {
					border:1px solid #333333;
			  }
			  td {
				font-family: Arial;
				font-size: 12px;
				color: 363636;
				}
			 .txt-14 {
				font-family: Arial;
				font-size: 14px;										
				font-weight: bolder;
				color: #FFFFFF;
				}
			</style>
			<table width="80%"  style="border:1px solid #333333;background-color:#FFFFFF" cellspacing="4" cellpadding="4" >
			<tr bgcolor="#FFF">
			<td style="background-color:#3C8DBC"><img src="'.$SITE_URL.'images/logo.png"></td>
			</tr>
				<tr>
					<td align="center">'.$message.'</td>
				</tr>
				<tr>
					<td height="20" >&nbsp;</td>
				</tr>
				
				<tr>
					<td><strong>&nbsp;</strong></td>
				</tr>
				
				<tr>
					<td><strong>Thank You,</strong></td>
				</tr>
	
				<tr>
					<td><strong>i-Practice Team.</strong></td>
				</tr>
			
				</table>';
				//echo $to."<br>".$subject."<br>".$mailcontent."<br>".$from; exit;
				//echo $toAddress."<br>".$subject."<br>".$mailcontent."<br>".$fromAddress; exit;
				
				//echo $attachment= 'ds_files/pdf_files/'.$d_name.'.pdf';
				
				$mail = SendHTMLMailWITHFile($toAddress, $toName, $subject, $mailcontent, $attachment, $fromAddress, $fromName);
				if(!$mail) {
				    echo '<h1>Something went to wrong!<h1>'; die();
				    //echo 'Message was not sent.';
				    //echo 'Mailer error: ' . $mail->ErrorInfo;
				} else {
				    $invite_msg = "success";
						$history_arr['event'] = "Email document";
						$history_arr['user'] = $_SESSION['admin_details']['email'];
						$history_arr['ip_address'] = $ip_address;
						$history_arr['doc_id'] = $d_id;
						ins_rec('document_history', $history_arr);
				    //echo 'Message has been sent.';
				}
				//$error2= "Thank you for contacting us. We will respond as soon as possible.";

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>i-Practice | File &amp; Sign</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- bootstrap 3.0.2 -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!-- font Awesome -->
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Ionicons -->
<link href="css/ionicons.min.css" rel="stylesheet" type="text/css">
<!-- Morris chart -->
<link href="css/morris.css" rel="stylesheet" type="text/css">
<!-- jvectormap -->
<link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
<!-- fullCalendar -->
<link href="css/fullcalendar.css" rel="stylesheet" type="text/css">
<!-- Daterange picker -->
<link href="css/daterangepicker-bs3.css" rel="stylesheet" type="text/css">
<!-- bootstrap wysihtml5 - text editor -->
<link href="css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css">
<!-- Theme style -->
<link href="css/AdminLTE.css" rel="stylesheet" type="text/css">
<link href="css/mps_style.css" rel="stylesheet" type="text/css">
<link href="css/checkbox.css" rel="stylesheet" type="text/css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<link rel="icon" type="image/png" href="http://mpm.digiopia.in/img/favicon.ico">
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
	function valid_form(th) {
		
		if(th.to_email.value=='')
		{
			alert('Please enter email address');
			th.to_email.focus();
			return false;
		}
		var x=document.forms["send_doc"]["to_email"].value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
			alert("Enter valid email address");
			th.to_email.focus();
			return false;
		}
		if(th.subject.value=='')
		{
			alert('Please enter email subject');
			th.subject.focus();
			return false;
		}
		if(th.message.value=='')
		{
			alert('Please enter your message');
			th.message.focus();
			return false;
		}
		
		return true;
	}
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>

<body>
	<div class="row">
		<?php
		if($invite_msg=="success") { ?>
		<div class="alert alert-info" style="margin:50px 20px;">
			<strong>Email has been send sucessfully!</strong>
		</div>
		<script type="text/javascript">
		$(document).ready( function(){	
			setTimeout(function() {
				parent.$.colorbox.close(); return false;
			}, 3000);
			//$.noConflict(true);
			//parent.jQuery.colorbox.close(); return false;
		});
		
		</script>
		<?php exit(); }  ?>
		<div class="alert alert-info" style="margin:0;">
			<strong>SEND DOCUMENT COPY</strong>
		</div>
		<div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 30px;">
			<form role="form" name="send_doc"  action="" method="post" enctype="multipart/form-data" onSubmit="return valid_form(this);">
				<input type="hidden" name="user_id" value="">
				<div class="form-group">
					<label>Email to</label>
					<input type="text" name="to_email" class="form-control" placeholder="example@email.com">
				</div>
				
				<div class="form-group">
					<label>Subject</label>
					<input type="text" name="subject" class="form-control" value="<?=$user_email?> Send Document">
				</div>
				
				<div class="form-group">
					<label>Message</label>
					<textarea name="message" class="form-control" cols="20" rows="10"><?=$user_email?> sent you the attached document "<?=$doc_name?>".</textarea>
				</div>
				
				<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;&nbsp;SEND</button>
			</form>
		</div>	
	</div>
</body>
</html>
