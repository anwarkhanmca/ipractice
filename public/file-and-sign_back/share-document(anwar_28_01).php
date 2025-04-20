<?php 
include ('connect.php'); 
include('../../app/library/FileAndSign.php');

if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://mpm.digiopia.in/login");
}
$user_id = $_SESSION['admin_details']['id'];

if(isset($_REQUEST['delid']))
{
    $delid = $_REQUEST['delid'];

    $que = mysql_query("update documents set signed_doc_status=0 where id='$delid'") or die(mysql_error());

    header("location:".$SITE_URL."signed-signature.php");
}

if(isset($_REQUEST['save']) && $_REQUEST['save'] != ""){print_r($_FILES['files']);die;
	$files 		= $_FILES['document']['name'];
	$client_id 	= $_REQUEST['client_id'];
	$uploaddir 	= '../uploads/client_doc/'.$files;
	move_uploaded_file($_FILES['document']['tmp_name'], $uploaddir);

	$que = mysql_query("insert into file_signs set user_id='".$user_id."', client_id='".$client_id."', document='".$files."', created='".date('Y-m-d H:i:s')."'") or die(mysql_error());

    header("location:".$SITE_URL."share-document.php");
	//echo $files;die;
}
?>
<!DOCTYPE html>
<html style="min-height: 813px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>i-Practice | File &amp; Sign</title>
<!--          -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- bootstrap 3.0.2 -->
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
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
.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>



<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="http://danielm.herokuapp.com/demos/dnd/css/uploader.css" rel="stylesheet" />
<link rel="stylesheet" href="http://danielm.herokuapp.com/demos/dnd/css/demo.css" rel="stylesheet" />




</head>
<body class="skin-blue pace-done" style="min-height: 813px;">
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
					<!-- <a href="/practice-details" id="image_preview"></a> -->
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
<input type="hidden" id="user_type" value="R">
	<div class="tabarea">
	<div class="nav-tabs-custom">
	<?php include('menu.php'); ?>

<div class="tab-content">

<div id="tab_1" >
	<!--table area-->
	<div class="box-body table-responsive">
		<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
			<div class="row">
				<div class="col-xs-6"></div>
				<div class="col-xs-6"></div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="col_m2">
						<div class="col_m2">
<?php $clients = FileAndSign::getAllClients();?>
<form method="post" action="" name="my_form" id="my_form" enctype="multipart/form-data">
<table width="100%">
<tr>
	<td width="8%" align="left">Select Client:</td>
	<td width="17%" align="left">
		<input type="hidden" name="client_id" id="client_id">
		<div style="position:relative;">
			<input type="text" class="form-control text_box1" name="client_name" id="client_name" placeholder="Select Client">
			<div id="search_client">
				<!-- <ul class="search_content">
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
				</ul> -->
			</div>
		</div>
		<!-- <select class="form-control newdropdown" name="client_id" id="client_id">
			<option>-------- Select Client --------</option>
			<?php 
			if(isset($clients) && count($clients) >0){
				foreach($clients as $key=>$row){?>
					<option value="<?php echo $row['client_id'];?>"><?php echo $row['client_name'];?></option>
			<?php } }?>
		</select> -->
	</td>
	<td width="12%" align="left">&nbsp;</td>
	<td width="17%" align="left">
		<!-- <input type="hidden" name="file_id" id="file_id">
		<div style="position:relative;">
			<input type="text" class="form-control text_box1" name="document_name" id="document_name" placeholder="View or Search Documents">
			<div id="search_file">
				<ul class="search_content">
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">ewf  wefwef</a></li>
					<li><a href="#">qwdqw  wefwef</a></li>
				</ul>
			</div>
		</div> -->

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
		<div id="drag-and-drop-zone" class="uploader">
            <div>Drag &amp; Drop Images Here</div>
            <div class="or">-or-</div>
            <div class="browser">
              <label>
                <span>Select Files</span>
                <input type="file" name="files[]" multiple="multiple" title='Select Files'>
              </label>
            </div>
        </div>
		<!-- <div class="bfd-dropfield">                    
			<div class="bfd-dropfield-inner" style="height: 100px; width:350px;">Drop files here or
			<div class="upload_pic" style="margin-top: 0px;margin-left: 115px;">
			           	<span class="btn btn-default btn-file p_details">
			           	    Select Files<input type="file" name="document" id="document">
			           	</span>
			           </div>           
			</div>                
		</div>                
		<div class="container-fluid bfd-files"></div> -->
	</td>
	<td colspan="2">
		<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Uploads</h3>
            </div>
            <div class="panel-body demo-panel-files" id='demo-files'>
              <span class="demo-note">No Files have been selected/droped yet...</span>
            </div>
          </div>
	</td>
</tr>

<tr>
	<td>
		<input type="submit" class="btn btn-info" name="save" value="Save"></button>
	</td>
	<td colspan="3">
		
	</td>
</tr>
</table>
</form>
<div style="height:500px; width:900px; margin: auto">
	<iframe id="showdocument" width="900"  height="500" src=""></iframe>
</div>


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
        

        <!-- Content End -->
		<!--Footer Start-->  
        <!-- jQuery 2.0.2 -->
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
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
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
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
		<script src="/js/fileandsign.js" type="text/javascript"></script>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->

    <script type="text/javascript" src="http://danielm.herokuapp.com/demos/dnd/js/demo.min.js"></script>
    <script type="text/javascript" src="http://danielm.herokuapp.com/demos/dnd/js/dmuploader.min.js"></script>

    <script type="text/javascript">
      $('#drag-and-drop-zone').dmUploader({
        url: 'upload.php',
        //dataType: 'json',
        enctype: 'multipart/form-data',
        allowedTypes: 'pdf/*',
        onInit: function(){
          $.danidemo.addLog('#demo-debug', 'default', 'Plugin initialized correctly');
        },
        onBeforeUpload: function(id){
          $.danidemo.addLog('#demo-debug', 'default', 'Starting the upload of #' + id);

          $.danidemo.updateFileStatus(id, 'default', 'Uploading...');
        },
        onNewFile: function(id, file){
          $.danidemo.addFile('#demo-files', id, file);console.log(file);
        },
        onComplete: function(){
          $.danidemo.addLog('#demo-debug', 'default', 'All pending tranfers completed');
        },
        onUploadProgress: function(id, percent){
          var percentStr = percent + '%';

          $.danidemo.updateFileProgress(id, percentStr);
        },
        onUploadSuccess: function(id, data){
          $.danidemo.addLog('#demo-debug', 'success', 'Upload of file #' + id + ' completed');

          $.danidemo.addLog('#demo-debug', 'info', 'Server Response for file #' + id + ': ' + JSON.stringify(data));

          $.danidemo.updateFileStatus(id, 'success', 'Upload Complete');

          $.danidemo.updateFileProgress(id, '100%');
        },
        onUploadError: function(id, message){
          $.danidemo.updateFileStatus(id, 'error', message);

          $.danidemo.addLog('#demo-debug', 'error', 'Failed to Upload file #' + id + ': ' + message);
        },
        onFileTypeError: function(file){
          $.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: must be an image');
        },
        onFileSizeError: function(file){
          $.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: size excess limit');
        },
        onFallbackMode: function(message){
          $.danidemo.addLog('#demo-debug', 'info', 'Browser not supported(do something else here!): ' + message);
        }
      });
    </script>
     
</body>
</html>