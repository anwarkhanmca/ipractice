<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>i-Practice | File &amp; Sign</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="/css/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- fullCalendar -->
    <link href="/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="/css/mps_style.css" rel="stylesheet" type="text/css" />

    <link href="/css/checkbox.css" rel="stylesheet" type="text/css" />

    <!-- COLOR BOX CSS -->
    <link href="/file-and-sign/colorbox/colorbox.css" rel="stylesheet" type="text/css" />

	<link rel="icon" type="image/png" href="/img/favicon.ico" />
    <style type="text/css">
.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}
.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
</head>
<?php 
include ('connect.php'); 
include('../../app/library/FileAndSign.php');
$session = FileAndSign::get_session();
$user_id = $session['id'];

if(!isset($user_id) && $user_id=="") {
	echo "Logout!";
	header("Location:i-practice.co.uk/login");
}


if(isset($_REQUEST['delid']))
{
    $delid = $_REQUEST['delid'];

    $que = mysql_query("update documents set signed_doc_status=0 where id='$delid'") or die(mysql_error());

    header("location:".$SITE_URL."signed-signature.php");
}

if(isset($_REQUEST['save']) && $_REQUEST['save'] != ""){
	$client_id 	= $_REQUEST['client_id'];
	$doc_name = $_POST['hid_doc_name'];
	$files = explode(',', $doc_name);
	//print_r($files);die;
	if($client_id != ''){
		foreach ($files as $key => $value) {
			$que = mysql_query("insert into file_signs set user_id='".$user_id."', client_id='".$client_id."', document='".$value."', created='".date('Y-m-d H:i:s')."'") or die(mysql_error());
		}
	}

	/*$files 		= $_FILES['files']['name'][0];//echo $files;die;
	
	$uploaddir 	= '../uploads/client_doc/'.$files;
	move_uploaded_file($_FILES['files']['tmp_name'][0], $uploaddir);*/

	

    header("location:".$SITE_URL."share-document.php");
	//echo $files;die;
}

$users = array();
if(isset($session['group_users']) && count($session['group_users']) >0){
	foreach ($session['group_users'] as $k => $v) {
		$users[$k] = $v['user_id'];
	}
}


$qry = "select * from practice_details where user_id in ('".implode(',',$users)."')";
$practice_details = mysql_fetch_assoc( mysql_query($qry) );
//echo $qry;die;
//echo "<pre>";print_r($practice_details);die;
?>

<body class="skin-blue" style="margin-top: -19px;"><!--  pace-done-->    
    
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
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<!-- Right side column. Contains the navbar and content of the page -->
		<aside class="right-side  strech">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="col-4">
					<h1>FILE SHARE </h1>
				</div>
				<div class="col-4 logo_con">
					<?php 
					if(file_exists("../colorextract/images/".$practice_details['practice_logo']) && $practice_details['practice_logo'] != ""){
						echo "<img src='/colorextract/images/".$practice_details['practice_logo']."' class='browse_img' width='150'>";
					}?>
				</div>

				<div class="home_right">
					<ol class="breadcrumb ">
						<li><a href="/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
						<li class="active">File Share</li>
					</ol>
				</div>

				<div class="clearfix"></div>
			</section>
			<!-- Main content -->
<section class="content">
<input type="hidden" id="user_type" value="R">
<input type="hidden" name="client_id" id="client_id" value="">

	<!-- <div style="position:relative;"><a href="JavaScript:void(0)" class="upload_new">Upload New Document</a></div>
	<div class="" style="width:40%; margin: 5px 455px;">
		<div style="position:relative; width:210px;">
			<input type="text" class="form-control text_box1 pull-left" name="client_name" id="client_name" placeholder="Select Client">
			<div id="search_client">
				<ul class="search_content">
					<li>sfdsdfsdf</li>
				</ul>
			</div>
		</div>
		
		<div class="j_selectbox3">
		    <span>View or Search Documents</span>
		    <div class="select_icon" id="select_icon"></div>
		    <div class="clr"></div>
		    <div class="open_toggle" style="display: none;">
		      <ul class="document_ul">
		       <li>sfdsdfsdf</li> 
		       <li>sfdsdfsdf</li>
		       <li>sfdsdfsdf</li>
		      </ul>
		    </div>
		</div>
		<div class="clearfix"></div>
	</div> -->


	<div class="tabarea">
	<div class=""><!-- nav-tabs-custom-->
	<?php //include('menu.php'); ?>

<div class="tab-content">

<div id="tab_1" >
	<!--table area-->
	<div class="box-body">
		<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
			<div class="row">
				<div class="col-xs-6"></div>
				<div class="col-xs-6"></div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="col_m2">
						<div class="col_m2">
<?php //$clients = FileAndSign::getAllClients();?>
<form method="post" action="" name="my_form" id="my_form" enctype="multipart/form-data">
	<div class="search_area">
		<!--<div style="position:relative; width:210px;">
			<input type="text" class="form-control text_box1 pull-left" name="client_name" id="client_name" placeholder="Select Client">
			<div id="search_client">
				
			</div>
		</div>-->
        
        <div class="j_selectbox_big">
		    <span id="showClientName">Select Client</span>
		    <div class="select_icon" id="select_icon_type"></div>
		    <div class="clr"></div>
            <div class="open_dropdown open_client_drop" style="display:none;">
              <input type='text' class="email_top search_text" id='client_name'/>
		      <ul class="document_ul" id="search_client">
		       <?php
               $file_obj = new FileAndSign();
               $client_details = $file_obj->getAllClients();//print_r($details);die;
               if(isset($client_details) && count($client_details) >0){
                   foreach ($client_details as $key => $value) {
               ?>
                  <li><a href='javascript:void(0)' class='putClientName' data-client_name='<?php echo $value['client_name']?>' data-client_id='<?php echo $value['client_id']?>'><?php echo $value['client_name']?></a></li>
               <?php }  }?>
		      </ul>
		    </div>
		</div>
        
        <!--<div style="position: relative; width:210px;">
           <div class="nt_selectbox">
              <span>Select 1 or more clients</span>
              <div class="icon avoid-clicks" id="select_icon"></div>
              <div class="clr"></div>
              <div class="open_toggle" style="top:23px;">
                <input type='text' class="email_top search_text" id='search_text'/>
                <ul class="document_ul" id="clients_list">
                  
                </ul>
              </div>
          </div>
        </div>-->
		
		<div class="j_selectbox_big">
		    <span>View or Search Documents</span>
		    <div class="select_icon" id="select_icon"></div>
		    <div class="clr"></div>
		    <div class="open_toggle" style="display: none;">
		      <ul class="document_ul" id="document_ul">
		       <!-- <li>sfdsdfsdf</li> 
		       <li>sfdsdfsdf</li>
		       <li>sfdsdfsdf</li> -->
		      </ul>
		    </div>
		</div>

		<div class="upload_a"><a href="JavaScript:void(0)" class="upload_new">Upload New Document</a></div>
		<div class="clearfix"></div>
	</div>

<div class="frame_box">

<div id="content" class="avoid-clicks">
    <input type="file" name="files[]" id="filer_input2" multiple="multiple">
</div>

<div class="showdocument" style="display:none;"> 
	<iframe id="showdocument" width="100%" height="500" src=""></iframe> 
</div> 

	 <!--<input type="submit" class="btn btn-info" name="save" value="Save"></button>   


<div class="col-xs-8">
	<iframe id="showdocument" width="100%" height="400" src=""></iframe>

</div>-->
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<!--<table width="100%">
<tr>
	<td width="8%" align="left">Select Client:</td>
	<td width="17%" align="left">
		<input type="hidden" name="client_id" id="client_id">
		<div style="position:relative;">
			<input type="text" class="form-control text_box1" name="client_name" id="client_name" placeholder="Select Client">
			<div id="search_client">
				
			</div>
		</div>
	
	</td>
	<td width="12%" align="left">&nbsp;</td>
	<td width="17%" align="left">
		

		<div class="j_selectbox3">
		    <span>View or Search Documents</span>
		    <div class="select_icon" id="select_icon"></div>
		    <div class="clr"></div>
		    <div class="open_toggle" style="display: none;">
		      <ul class="document_ul">
		        
		      </ul>
		    </div>
		</div>
	</td>
	<td width="46%" align="left">&nbsp;</td>
</tr>

<tr>
	<td colspan="2">
		<div id="content">
	        <input type="file" name="files[]" id="filer_input2" multiple="multiple">
	    </div>
		
	</td>
	<td colspan="2">
		
	</td>
</tr>

<tr>
	<td>
		<input type="submit" class="btn btn-info" name="save" value="Save"></button>
	</td>
	<td colspan="3">
		
	</td>
</tr>
</table>-->
</form>



						</div>
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

			</section>
			<!-- /.content -->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
        
<?php include('../../app/views/contact_report/contact.blade.php');?>


        <!-- Content End -->
		<!--Footer Start-->  
        <!-- jQuery 2.0.2 -->
        <!-- <script src="https://code.jquery.com/jquery-1.10.1.min.js"></script> -->
        <script src="../js/jquery-1.11.0.min.js"></script>
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
        <script src="../js/bootstrap.min.js"></script>
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
		<script src="/js/fileandsign.js" type="text/javascript"></script>

		<script type="text/javascript" src="../js/contact_message.js"></script>

		

	<link href="css/jquery.filer.css" type="text/css" rel="stylesheet" />
	<link href="css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

	<!--jQuery-->
	<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>-->
	<script type="text/javascript" src="js/jquery.filer.min.js?v=1.0.5"></script>
	<script type="text/javascript" src="js/custom.js?v=1.0.5"></script>

	<script type="text/javascript" src="../js/jquery.form.js"></script> 
     
</body>
</html>