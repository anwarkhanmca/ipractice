<?php include('connect.php');
$user_id = $_SESSION['admin_details']['id'];
$user_email = $_SESSION['admin_details']['email'];
$d_id = $_REQUEST['difs'];
$owner_id = $_REQUEST['Oid'];
$doc_name = $_REQUEST['doc_name'];
if($user_id != $owner_id) {
	echo '<h1>Something went to wrong!<h1>'; die();
}
$invite_msg = "";
if(isset($_POST['submit']))
{
	extract($_POST);
			$doc_link = $SITE_URL."document-sign.php?data=".$session_id."&&difs=".$d_id."&Oid=".$owner_id."&Signer=".$to_email;
			$subject= $subject;
			$to=$to_email;
			$from=$From_EmailAddress;	 
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
					<td align="center">
						<a style="padding:10px; background-color:#3C8DBC; color:#FFFFFF; text-decoration: none; border-radius:5px;" href="'.$doc_link.'" >Sign Document</a>
					</td>
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
				SendHTMLMail($to,$subject,$mailcontent,$from);
				$doc_arr['doc_status']=1;
				upd_rec("documents",$doc_arr,"id=$d_id");
				//die();
				
				$history_arr['event'] = "Invite signer";
				$history_arr['user'] = $_SESSION['admin_details']['email'];
				$history_arr['ip_address'] = $ip_address;
				$history_arr['doc_id'] = $d_id;
				ins_rec('document_history', $history_arr);
				//exit;
				$invite_msg = "success";
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

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="ckfinder/ckfinder.js"></script>

</head>

<body>
	<div class="row">
		<?php
		if($invite_msg=="success") { ?>
		<div class="alert alert-info" style="margin:50px 20px;">
			<strong>Invitation Email has been send sucessfully!</strong>
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
			<strong>SEND DOCUMENT FOR SIGNATURE</strong>
		</div>
		<div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 30px;">
			<form role="form" name="send_doc"  action="" method="post" enctype="multipart/form-data" onSubmit="return valid_form(this);">
				<input type="hidden" name="user_id" value="">
				<div class="form-group">
					<label style="float:left; width:100%!important">Email to 
						<div style="float:right">
							<div style="width:25px; float:left;">
							<input type="checkbox" id="checkbox1" style="height:20px; width:100%; margin:0;" onclick="window.location.href='<?=$SITE_URL?>send-document-multiple.php?data=<?=$session_id?>&difs=<?=$d_id?>&Oid=<?=$owner_id?>&doc_name=<?=$doc_name?>'" />
							</div>
							Tick if document requires multiple signaturies
						</div>
					</label>
					<input type="text" name="to_email" class="form-control" placeholder="example@email.com">
				</div>
				
				<div class="form-group">
					<label>Subject</label>
					<input type="text" name="subject" class="form-control" value="<?=$user_email?> Needs Your Signature">
				</div>
				
				<div class="form-group">
					<label>Message</label>
					<textarea name="message" class="form-control" cols="20" rows="10" id="editor1"><?=$user_email?> invited you to sign "<?=$doc_name?>".</textarea>
				</div>
				
				<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;&nbsp;SEND</button>
			</form>
		</div>	
	</div>
</body>
</html>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'editor1', {
	filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
	filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
	filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
CKFinder.setupCKEditor( editor, '../' );
</script>