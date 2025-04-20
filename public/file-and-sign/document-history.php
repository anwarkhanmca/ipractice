<?php include('connect.php');
$user_id = $_SESSION['admin_details']['id'];
$user_email = $_SESSION['admin_details']['email'];
$d_id = $_REQUEST['difs'];
$owner_id = $_REQUEST['Oid'];
$doc_name = $_REQUEST['doc_name'];
if($user_id != $owner_id) {
	echo '<h1>Something went to wrong!<h1>'; die();
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
			<strong>DOCUMENT HISTORY</strong>
		</div>
		<div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 30px;">
			<div class="row">
				<div class="col-xs-12">
					<table width="100%" class="table table-bordered">
						<tbody>
							<?php
							$start=0;
							$limit=10;
							if(isset($_GET['page'])) {
								$page=$_GET['page'];
								$start=($page-1)*$limit;
							}
							else {
								$page=1;
							}
							
							$sel_doc = "select * from document_history WHERE doc_id=$d_id LIMIT $start, $limit";
							$res_doc = mysql_query($sel_doc);
							if(mysql_num_rows($res_doc) > 0) { ?>
								<tr>
									<td width="30%" align="center"><strong>Event</strong></td>
									<td width="20%" align="center"><strong>User</strong></td>
									<td width="20%" align="center"><strong>Time</strong></td>
									<td width="30%" align="center"><strong>IP Address</strong></td>
								</tr>
							<?php while($row_doc = mysql_fetch_array($res_doc)) { ?>
								<tr>
									<td align="center"><?=$row_doc['event'];?></td>
									<td align="center"><?=$row_doc['user'];?></td>
									<td align="center"><?=date('d/m/Y h:i:s A', strtotime($row_doc['time']))?></td>
									<td align="center"><?=$row_doc['ip_address'];?></td>
								</tr>
							<?php }
							} 
							else { ?>
								<tr>
									<td colspan="6" align="center"><strong>There are no document history found.</strong></td>
								</tr>
							<?php } ?>	
									
						</tbody>
					</table>
					<div class="col-md-12">
						<?php								
						$rows=mysql_num_rows(mysql_query("select * from document_history WHERE doc_id=$d_id"));
						if($rows > $limit) {
						$total=ceil($rows/$limit); ?>
						<div class="col-md-12 col-sm-12">
							<div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate" style="text-align:center;">
								<ul class="pagination">
									<li class="paginate_button previous <?php if($page <= 1) { ?> disabled <?php } ?>" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous">
										<a <?php if($page!=1) { ?> href="?page=<?php echo $page-1; ?>&data=<?=$session_id?>&difs=<?=$d_id?>&Oid=<?=$owner_id?>&doc_name=<?=$doc_name?>" <?php } ?>>Previous</a>
									</li>
									<?php  
									
									for($i=1; $i<=$total; $i++) { ?>
									<li class="paginate_button <?php if($page==$i) { ?> active <?php } ?>" aria-controls="dataTables-example" tabindex="0">
										<a href="?page=<?php echo $i; ?>&data=<?=$session_id?>&difs=<?=$d_id?>&Oid=<?=$owner_id?>&doc_name=<?=$doc_name?>"><?php echo $i; ?></a>
									</li>
									<?php } ?>
									
									<li class="paginate_button next <?php if($page==$total) { ?> disabled <?php } ?>" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next">
										<a <?php if($page!=$total) { ?> href="?page=<?php echo $page+1; ?>&data=<?=$session_id?>&difs=<?=$d_id?>&Oid=<?=$owner_id?>&doc_name=<?=$doc_name?>" <?php } ?> >Next</a>
									</li>
								</ul>
							</div>
						</div>
						<?php } ?>
						<div class="clearfix"></div>
					</div>
				</div>	
			</div>
		</div>	
	</div>
</body>
</html>
