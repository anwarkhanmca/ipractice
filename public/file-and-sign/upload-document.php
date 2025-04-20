<?php include ('connect.php'); 
if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://mpm.digiopia.in/login");
}
$user_id = $_SESSION['admin_details']['id'];
//echo $user_id;
$message = 0;
if(isset($_REQUEST['btn-upload']))
{
	/*if( ! ($_FILES['document_file']['error']))
	{
		$doc=time().'-'.$_FILES['document_file']['name'];
		if(copy($_FILES['document_file']['tmp_name'],"../ds-files/".$doc))
			$doc_name = $doc;
	}*/
	$user_id = $_POST['user_id'];
	$a_date = date('Y-m-d H:i:s');
	$status = 0;
	
	ini_set('max_execution_time', 0);
	$pdf_dir = "ds_files/";
	$image_dir = "ds_files/jpg_files/";
    ini_set("display_errors",1);
	if(isset($_FILES["document_file"]))
    {
        $RandomNum   = time();
        
        $DocName      = str_replace(' ','-',strtolower($_FILES['document_file']['name']));
        $DocType      = $_FILES['document_file']['type']; //"image/png", image/jpeg etc.
     
        $DocExt = substr($DocName, strrpos($DocName, '.'));
        $DocExt = str_replace('.','',$DocExt);
        if($DocExt != "pdf")
        {
            $message = "1";
        }
        else
        {
            $query="insert into documents (doc_name, user_id, a_date, status) values('$doc_name','$user_id', '$a_date','$status')"; 
			mysql_query($query) or die(mysql_error());
			$last_id = mysql_insert_id();
			
			$DocName      = preg_replace("/\.[^.\s]{3,4}$/", "", $DocName);
            $NewDocName = $DocName.'-'.$RandomNum.'.'.$DocExt;
         
            move_uploaded_file($_FILES["document_file"]["tmp_name"],$pdf_dir. $NewDocName);
        	
			$pdf_query="UPDATE documents SET doc_name = '$NewDocName' WHERE id = $last_id"; 
			mysql_query($pdf_query) or die(mysql_error());
			
            //$location   = "/usr/local/bin/convert";
			/*$location   = "convert -density 300  -background white -flatten";
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
				$image_query="insert into document_image (image_name, doc_id, status) values('$image_name1','$last_id','$status')"; 
				mysql_query($image_query) or die(mysql_error());
            }*/
            $message="0";
			
			$history_arr['event'] = "Upload document";
			$history_arr['user'] = $_SESSION['admin_details']['email'];
			$history_arr['ip_address'] = $ip_address;
			$history_arr['doc_id'] = $last_id;
			ins_rec('document_history', $history_arr);
        }
    }
	
	//die();
	if($message == 0) {
		header("location:".$SITE_URL."index.php?data=".$session_id."&difs=".$last_id."&convert=yes");
		exit;
	}
	
}

?>

<!DOCTYPE html>
<html style="min-height: 813px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
        <link href="css/mps_style.css" rel="stylesheet" type="text/css">
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
					<!-- <a href="/practice-details" id="image_preview">
					</a> -->
				</div>
				<div class="home_right">
					<ol class="breadcrumb ">
						<li><a href=""><i class="fa fa-home"></i> Dashboard</a></li>
						<li class="active">File &amp; Sign</li>
					</ol>
				</div>

				<div class="clearfix"></div>
			</section>
			<!-- Main content -->
			<section class="content">
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
												<div class="panel-body col-md-8" style="margin:0 auto; float:none;">
													<div class="table-responsive">
														<?php if($message == 1 ){ ?>
														<div class="alert alert-danger ">Sorry! the file type or extension is invalid. Allowed extensions are .pdf</div>
														<?php } ?>
														<form role="form"  action="" method="post" enctype="multipart/form-data" onSubmit="return valid_form(this);">
															<input type="hidden" name="user_id" value="<?=$user_id?>">
															<div class="form-group">
																<label>Upload File (file should be .pdf)</label>
																<input type="file" name="document_file" class="form-control">
															</div>
															
															<button type="submit" name="btn-upload" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;&nbsp;UPLOAD</button>
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
        
        <!-- Content End -->

        <!--Footer Start-->  
        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
		<script type="text/javascript">
			function valid_form(th) {
				if(th.user_id.value=='') {
					alert('Please select user!');
					th.user_id.focus();
					return false;
				}
				if(th.document_file.value=='') {
					alert('Please upload file!');
					th.document_file.focus();
					return false;
				}
				if(th.document_file.value!='') {
					var filename = th.document_file.value;
					var file_extension = filename.split('.').pop();
					var ext = file_extension.toLowerCase();
					
					if( !( ext == "pdf") ) {
						alert('Sorry! the file type or extension is invalid allowed extensions are .pdf');
						th.document_file.focus();
						th.document_file.value="";
						return false;
					}	
				}
				
				
				return true;
			}
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
</body>
</html>