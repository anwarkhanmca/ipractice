<?php include ('connect.php'); 
if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://mpm.digiopia.in/login");
}
$user_id = $_SESSION['admin_details']['id'];

if(isset($_REQUEST['delid']))
{
    $delid = $_REQUEST['delid'];

    $que = mysql_query("delete from documents where id='$delid'") or die(mysql_error());

    header("location:$SITE_URL");
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
			<form>
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
												<div class="right_side">
													<a class="btn btn-primary" href="upload-document.php"><i class="fa fa-upload"></i> UPLOAD DOCUMENT</a>
													<p>&nbsp;</p>
												</div>
												<div class="clearfix"></div>
												<div class="clearfix"></div>
									
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
														
														$sel_doc = "select * from documents WHERE user_id=$user_id AND doc_status=1 LIMIT $start, $limit";
														$res_doc = mysql_query($sel_doc);
														if(mysql_num_rows($res_doc) > 0) { ?>
															<tr>
																<td width="10%" align="center"><strong>Date</strong></td>
																<td width="30%" align="center"><strong>Document Name</strong></td>
																<!--<td width="15%" align="center"><strong>Modified</strong></td>-->
																<td width="15%" align="center"><strong>Sign a Document</strong></td>
																<!--<td width="15%" align="center"><strong>Send for Signature</strong></td>-->
																<td width="20%" align="center"><strong>Action</strong></td>
																<td width="10%" align="center"><strong>Delete</strong></td>
															</tr>
														<?php while($row_doc = mysql_fetch_array($res_doc)) { 
														$doc_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row_doc['doc_name']);
														?>
															<tr>
																<td align="center"><?=date('d/m/Y', strtotime($row_doc['a_date']))?></td>
																<td align="center"><?=$doc_name?></td>
																<!--<td align="center"><?=date('d/m/Y h:i:s A', strtotime($row_doc['m_date']))?></td>-->
																<td align="center">
																	<a href="<?=$SITE_URL?>sign-a-document.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>" class="btn btn-default">
																	<i class="fa fa-pencil"></i>&nbsp;&nbsp;Sign
																	</a>
																</td>
																<!--<td align="center">
																	<a href="<?=$SITE_URL?>send-document.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>&doc_name=<?=$doc_name?>" class="btn btn-default send_now">
																		<i class="glyphicon glyphicon-send"></i>&nbsp;&nbsp;Send
																	</a>
																</td>-->
																<td align="center">
																
																<div class="btn-group">
																	<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" aria-expanded="false">
																		More&nbsp;&nbsp;<span class="caret"></span>
																	</button>
																	<ul class="dropdown-menu" style="text-align:left;">
																		<li><a href="download-document.php?data=<?=$session_id?>&difs=<?=$row_doc['id']?>&Oid=<?=$row_doc['user_id']?>&doc_name=<?=$doc_name?>" target="_blank"><i class="fa fa-download"></i> Download</a></li>
																		<li><a href="#"><i class="fa fa-copy"></i> Send Copy</a></li>
																	</ul>
																</div>
																
																</td>
																<td align="center"><a href="<?=$SITE_URL?>index.php?delid=<?=$row_doc['id']?>"><img src="images/cross.png" width="15"></a></td>
															</tr>
														<?php }
														} 
														else { ?>
															<tr>
																<td colspan="6" align="center"><strong>There are no document invited yet.</strong></td>
															</tr>
														<?php } ?>	
																
													</tbody>
												</table>
												<div class="closeand_download">
													<?php								
													$rows=mysql_num_rows(mysql_query("select * from documents WHERE user_id=$user_id AND doc_status=1"));
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
        
</body></html>