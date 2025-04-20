<?php 
include ('connect.php');
include('../../app/library/FileAndSign.php');

$_SESSION['admin_details'] = FileAndSign::get_session();
/*$_SESSION['admin_details'] = 
		array(
			"id" => 1,
            "client_id" => 0,
            "related_company_id" => "", 
            "fname" => "Developer",
            "lname" => "Test",
            "email" => "crystalinfoway@gmail.com",
            "user_type" => "S",
            "status" => "A",
            "parent_id" => 0,
            "group_id" => 1
        );*/
//echo '<pre>';print_r($_SESSION);die;
//unset($_SESSION['admin_details']);

if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://i-practice.co.uk/login");
}
$user_id = $_SESSION['admin_details']['id'];
//echo $user_id;die;

if(isset($_REQUEST['delid']))
{
    $delid = $_REQUEST['delid'];

    $que = mysql_query("update documents set unsign_doc_status=0 where id='$delid'") or die(mysql_error());

    header("location:$SITE_URL");
}
?>
<!DOCTYPE html>
<html style="min-height: 813px;">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>i-Practice | File &amp; Sign</title>
    <!--          -->
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
    <link href="/css/mps_style.css" rel="stylesheet" type="text/css">
    <link href="css/checkbox.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="icon" type="image/png" href="http://mpm.digiopia.in/img/favicon.ico">
	<style type="text/css">
		.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}
		.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
	
		div#spinner
		{
		    display:none;
			width:100px;
		    height: 100px;
		    position: fixed;
		    top: 50%;
		    left: 50%;
		    background:url(images/ajax-loader1.gif) no-repeat center #fff;
		    text-align:center;
		    padding:10px;
		    font:normal 16px Tahoma, Geneva, sans-serif;
		    background-color:#3C8DBC;
		    margin-left: -50px;
		    margin-top: -50px;
		    z-index:2;
		    overflow: auto;
			border-radius: 5px;
		}
	</style>
</head>
	<div id="spinner"></div>
	
	<body class="skin-blue pace-done">
	<div class="pace  pace-inactive">
		<div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
  			<div class="pace-progress-inner"></div>
		</div>
		<div class="pace-activity"></div>
	</div>
    <link href="css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    
	<!--Header Start-->  
	<?php include('header.php'); ?>
	<!--Header End-->    
    <script type="text/javascript">
		function conf_del() {
			if(confirm('Are you sure to delete this file?')) {
				return true;
			}
			else {
				return false;
			}
		}
	</script>    
    <!-- Content Start -->
<div class="wrapper row-offcanvas row-offcanvas-left" style="min-height: 667px;"> 
	<!-- Left side column. contains the logo and sidebar -->
	<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side  strech">
		<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="col-4">
			<h1>FILE AND SIGN </h1>
		</div>
		<div class="col-4 logo_con">
			<img src="/practice_logo/<?php echo $result['practice_logo'];?>" class='browse_img'>
			<!-- <a href="/practice-details" id="image_preview">
				
			</a> -->
		</div>

		<div class="home_right">
			<ol class="breadcrumb ">
				<li><a href="/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
				<li class="active">File &amp; Sign</li>
			</ol>
		</div>

		<div class="clearfix"></div>
	</section>
			<!-- Main content -->
            
	<section class="content">
		<form>
			<div class="tabarea">
				<div class="nav-tabs-custom">
	<?php include('menu.php'); ?>

	<div class="span12">
	<div class="tab-content">
	<div id="tab_1" >
	<!--table area-->
	<div class="box-body table-responsive">
	<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
	<div class="row">
	<div class="col-xs-6"></div>
	<div class="col-xs-6"></div>
	</div>
	<div class="row" style="margin:0;">
	<div class="col-xs-12">
	<div class="right_side" >
	<a class="btn btn-primary" href="upload-document.php"><i class="fa fa-upload"></i>  UPLOAD DOCUMENT</a>
	<p>&nbsp;</p>
	</div>

	<div class="right_side" style="margin-right: 10px;">
	<a class="btn btn-primary send_now" href="send-multiple-document.php"><i class="glyphicon glyphicon-send"></i> SEND MULTIPLE DOCUMENT</a>
	<p>&nbsp;</p>
	</div>

	<div class="clearfix"></div>
	<div class="clearfix"></div>
	<?php if(isset($_REQUEST['document']) && $_REQUEST['document']!='') { ?>
	<div class="alert alert-success" style="margin:0;">
	<strong>Document "<?=$_REQUEST['document']?>" has been ready for signature.</strong>
	</div>
	<?php } ?>
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

	$sel_doc = "select * from documents WHERE user_id=$user_id AND (doc_status=0 OR doc_status=1) AND unsign_doc_status=1 ORDER BY id DESC  LIMIT $start, $limit";
	$res_doc = mysql_query($sel_doc);
	if(mysql_num_rows($res_doc) > 0) { ?>
	<tr>
		<td width="10%" align="center"><strong>Date</strong></td>
		<td width="30%" align="center"><strong>Document Name</strong></td>
		<!--<td width="15%" align="center"><strong>Modified</strong></td>-->
		<td width="15%" align="center"><strong>Sign a Document</strong></td>
		<td width="15%" align="center"><strong>Send for Signature</strong></td>
		<td width="20%" align="center"><strong>Action</strong></td>
		<td width="10%" align="center"><strong>Status</strong></td>
	</tr>
	<?php while($row_doc = mysql_fetch_array($res_doc)) { 
	$doc_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row_doc['doc_name']);
	?>
	<tr>
		<td align="center"><?=date('d/m/Y', strtotime($row_doc['a_date']))?></td>
		<td align="center">
			<a href="view-document.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>&doc_name=<?=$doc_name?>" target="_blank">
			<?=$doc_name?>
			</a>
		</td>
		<!--<td align="center"><?=date('d/m/Y h:i:s A', strtotime($row_doc['m_date']))?></td>-->
		<td align="center">
			<a href="<?=$SITE_URL?>sign-a-document.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>" class="btn btn-default <?=(isset($_REQUEST['difs']))?'disabled':'';?> <?=($row_doc['status']==0)?'disabled':'';?>">
			<i class="fa fa-pencil"></i>&nbsp;&nbsp;Sign
			</a>
		</td>
		<td align="center">
			<a href="<?=$SITE_URL?>send-document.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>&doc_name=<?=$doc_name?>" class="btn btn-default send_now <?=(isset($_REQUEST['difs']))?'disabled':'';?> <?=($row_doc['status']==0)?'disabled':'';?>">
				<i class="glyphicon glyphicon-send"></i>&nbsp;&nbsp;Send
			</a>
		</td>
		<td align="center">
		
		<div class="btn-group">
			<button data-toggle="dropdown" class="btn btn-default dropdown-toggle <?=(isset($_REQUEST['difs']))?'disabled':'';?> <?=($row_doc['status']==0)?'disabled':'';?>" aria-expanded="false">
				More&nbsp;&nbsp;<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="text-align:left;">
				<li><a href="download-document.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>&doc_name=<?=$doc_name?>" target="_blank"><i class="fa fa-download"></i> Download</a></li>
				
				<li><a href="<?=$SITE_URL?>send-document-copy.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>&doc_name=<?=$doc_name?>" class="send_now"><i class="fa fa-copy"></i> Send Copy</a></li>
				
				<li><a href="<?=$SITE_URL?>document-history.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>&doc_name=<?=$doc_name?>" class="view_history"><i class="glyphicon glyphicon-list-alt"></i> History</a></li>
				
				<li><a href="<?=$SITE_URL?>index.php?delid=<?=$row_doc['id']?>" onClick="return conf_del();">
					<i class="glyphicon glyphicon-remove"></i> Delete</a>
				</li>
			</ul>
		</div>
		
		</td>
		<td align="center">
			<?=($row_doc['status']==0)?'Pending':'Complete';?>
		</td>
	</tr>
	<?php }
	} 
	else { ?>
	<tr>
		<td colspan="6" align="center"><strong>There are no document uploaded yet.</strong></td>
	</tr>
	<?php } ?>	
		
	</tbody>
	</table>
	<div class="closeand_download">
	<?php								
	$rows=mysql_num_rows(mysql_query("select * from documents WHERE user_id=$user_id AND (doc_status=0 OR doc_status=1) AND unsign_doc_status=1 ORDER BY id DESC"));
	if($rows > $limit) {
	$total=ceil($rows/$limit); ?>
	<div class="col-md-12 col-sm-12">
	<div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate" style="text-align:center;">
	<ul class="pagination">
		<li class="paginate_button previous <?php if($page <= 1) { ?> disabled <?php } ?>" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous">
			<a <?php if($page!=1) { ?> href="?page=<?php echo $page-1; ?> <?php } ?>">Previous</a>
		</li>
		<?php  
		
		for($i=1; $i<=$total; $i++) { ?>
		<li class="paginate_button <?php if($page==$i) { ?> active <?php } ?>" aria-controls="dataTables-example" tabindex="0">
			<a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
		</li>
		<?php } ?>
		
		<li class="paginate_button next <?php if($page==$total) { ?> disabled <?php } ?>" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next">
			<a <?php if($page!=$total) { ?> href="?page=<?php echo $page+1; ?>" <?php } ?> >Next</a>
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
	</div>
	<!--end table-->
	</div>
	</div>

	</div>
	</div>
	</form>
	</section>
            
            
           </div> 
			<!-- /.content -->
            
            
            
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
        

        <!-- Content End -->
		<!--Footer Start-->  
        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
		<link href="colorbox/colorbox.css" rel="stylesheet" />
		<script src="colorbox/jquery.colorbox.js"></script>
		<script type="text/javascript">
		//jQuery.noConflict();(function( $ ) {	
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				var Wwidth = $(window).width();
				if(Wwidth > 768) {
					var c_width = "60%";
				}
				else {
					var c_width = "100%";
				}
				$(".send_now").colorbox({width:c_width, height:"90%", iframe:true, overlayClose: false, fixed:true});
				//=== History ===//
				if(Wwidth > 768) {
					var c1_width = "90%";
				}
				else {
					var c1_width = "100%";
				}
				$(".view_history").colorbox({width:c1_width, height:"90%", iframe:true, overlayClose: false, fixed:true});
				//=== History ===//				
				$('#cboxOverlay').css({ 'background': 'none',  'background-color': '#000', 'opacity':0.6, 'cursor': 'pointer' });
				//Example of preserving a JavaScript event for inline calls.
			});
			
		//})(jQuery);	
		</script>		
        <!--<script src="http://mpm.digiopia.in/js/jquery.min.js"></script>-->
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
        <script src="js/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="js/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="js/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/icheck.min.js" type="text/javascript"></script>
      	<!-- AdminLTE App -->
        <script src="js/app.js" type="text/javascript"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="http://mpm.digiopia.in/js/AdminLTE/dashboard.js" type="text/javascript"></script> -->
        <!-- Add By User -->
        <script type="text/javascript" src="js/jquery.autoSuggest.js"></script> 
        <!-- Add By User -->
        <!--Footer End-->  
		<script src="js/fileandsign.js" type="text/javascript"></script>
		<!-- <script src="http://mpm.digiopia.in/js/onboard.js" type="text/javascript"></script> -->
		<script src="js/clients.js" type="text/javascript"></script>
		<!-- DATA TABES SCRIPT -->
		<script src="js/jquery.dataTables.js" type="text/javascript"></script>
		<script src="js/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- Time picker script -->
		<script src="js/timepicki.js"></script>
		<!-- Time picker script -->
		<link rel="stylesheet" href="css/jquery-ui.css">
		<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		<!-- Date picker script -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Date picker script -->
		<!-- page script -->
<?php if(isset($_REQUEST['difs']) && isset($_REQUEST['convert'])) {		 ?>
<script type="text/javascript">
	$('#spinner').show(); $('.wrapper').css('opacity','0.5');
	setTimeout(function() { window.location = 'pdf-to-image.php?difs=<?=$_REQUEST['difs'];?>';  }, 1000);
</script>        
<?php } ?>
</body></html>
<?php /*
if(isset($_REQUEST['difs']) && is_numeric($_REQUEST['difs'])) {
echo $doc_id = $_REQUEST['difs'];
ini_set('max_execution_time', 0);
$pdf_dir = "ds_files/";
$image_dir = "ds_files/jpg_files/";
ini_set("display_errors",1);
$document_arr = single_row("documents","*","id=$doc_id");
print_r($document_arr);	
	if($document_arr['status']==0) {
		$NewDocName = $document_arr['doc_name'];
		$DocName    = preg_replace("/\.[^.\s]{3,4}$/", "", $NewDocName);
		
		$location   = "convert -density 300  -background white -flatten";
		$Doc_Name       = $pdf_dir. $NewDocName;
		$num = count_pages($Doc_Name);
		$RandomNum   = time();
		$ImageName     = $image_dir.$DocName.'-'.$RandomNum;
		$image_name     = $DocName.'-'.$RandomNum;
		
		for($i = 0; $i<$num;$i++)
		{
			$ImageName1 = "";
			$image_name1 = "";
			$j = $i+1;
			$ImageName1 = $ImageName."-".$j.".jpg";
			$image_name1 = $image_name."-".$j.".jpg";
			
			$convert   = $location . " " . $Doc_Name."[".$i."]" . " " . $ImageName1;
			//echo $convert;
			exec($convert);
			$status = 1;
			$image_query="insert into document_image (image_name, doc_id, status) values('$image_name1','$doc_id','$status')"; 
			mysql_query($image_query) or die(mysql_error());
		}
		$message="0";
		$doc_query="UPDATE documents SET status = 1 WHERE id = $doc_id"; 
		mysql_query($doc_query) or die(mysql_error());
		header("location:$SITE_URL");
	}	
}		
*/ ?>