<?php include ('connect.php'); 

$d_id = $_REQUEST['difs'];
$owner_id = $_REQUEST['Oid'];
//echo $user_id;
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
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
		<script src="../js/kinetic-v5.1.0.js" type="text/javascript"></script>
		<style>
		.doc_img.current {
			border:solid 2px #428bca!important;
		}
		</style>			
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
	<header class="headermain">
		<div class="logo_controlar">
			<img src="images/logo.png">
		</div>
		<div class="clearfix"></div>    
	</header>        <!--Header End-->    
        
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
				
				<div class="clearfix"></div>
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="tabarea">
					<div class="nav-tabs-custom">
						<?php //include('menu.php'); ?>
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
											<div class="col-md-12">
												<!-- Advanced Tables -->
												<div class="panel panel-default" style="text-align:center;">
												<h1>Thank You! Your sign saved sucessfully.</h1>
												</div>
												<!--End Advanced Tables -->
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
        

        <!-- share doc-->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <form action="http://mpm.digiopia.in/fileandsign#" method="post">
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tbody><tr class="table_heading_bg">
    <td class="shared_t">SHARED FILES</td>
  </tr>
  <tr>
    <td valign="top">
    <table width="100%" class="table table-bordered">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="10%" align="center"><strong>Date</strong></td>
                                      <!--<td width="15%" align="center"><strong>Request Type</strong></td>-->
                                      <td width="10%" align="center"><strong>Document Name</strong></td>
                                      <td width="20%" align="center"><strong>Client Name</strong></td>
                                      <td width="20%" align="center"><strong>Client email</strong></td>
                                      <td width="15%" align="center"><strong>View and download</strong></td>
                                      <td width="10%" align="center"><strong>Share by</strong></td>
                                      <td width="10%" align="center"><strong>Delete</strong></td>
                                    </tr>
                                    <tr>
                                      <td align="center">08/09/2015</td>
                                      <td align="center">wfw werfwerf</td>
                                      <td align="center">R Sharma</td>
                                      <td align="center">sharma@appsbee.com</td>
                                      <td align="center"><a href="http://mpm.digiopia.in/fileandsign#">Link</a></td>
                                      <td align="center">R sharma</td>
                                      <td align="center"><a href="http://mpm.digiopia.in/fileandsign#"><img src="images/cross.png" width="15"></a></td>
                                    </tr>
                                    
                                   
                                  </tbody>
                                </table>
    </td>
  </tr>
</tbody></table>

          
          
          <div class="closeand_download">
<button class="close_btn1">Close</button>
<!-- <button class="download_btn1">Download</button> -->
 <div class="clearfix"></div>
</div>
        
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

     

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
			var c_width = "40%";
		}
		else {
			var c_width = "100%";
		}
		$(".sign_now").colorbox({width:"40%", height:"65%", iframe:true, overlayClose: false, fixed:true, onClosed: function () {
			$('#addImage').trigger('click');
		} });
		
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
<script type="text/javascript">

</script>
        
    
</body></html>