<?php include ('connect.php'); 

if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://mpm.digiopia.in/login");
}
$user_id = $_SESSION['admin_details']['id'];
$d_id = $_REQUEST['difs'];
$owner_id = $_REQUEST['Oid'];
if($user_id != $owner_id) {
	header("Location:$SITE_URL");
}

$history_arr['event'] = "Open document";
$history_arr['user'] = $_SESSION['admin_details']['email'];
$history_arr['ip_address'] = $ip_address;
$history_arr['doc_id'] = $d_id;
ins_rec('document_history', $history_arr);

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
		<script src="kinetic-js/kinetic-v5.1.0.js" type="text/javascript"></script>
		<style>
		.doc_img.current {
			border:solid 2px #428bca!important;
		}
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
						<?php //include('menu.php'); ?>
						<script type="text/javascript">
						$(document).ready( function() { 
							$("#show_addbutton").click(function () {
								$('#_My_Text_Date').hide();
								$('#newtext').show();
								$('#addbutton').show();
								$('#addDate').hide();
								$('#_My_Text_Date').fadeIn('slow');
							});
							$("#show_addDate").click(function () {
								$('#_My_Text_Date').hide();
								$('#newtext').hide();
								$('#addbutton').hide();
								$('#addDate').show();
								$('#_My_Text_Date').fadeIn('slow');
							});
							$("#_close").click(function(){
								$('#_My_Text_Date').fadeOut('slow');
							});
						});
						</script> 
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
												<div class="panel panel-default">
													<style>
													#sticky {
														padding: 0.5ex;
														width: 100%;
														background-color: #3C8DBC;
														color: #fff;
														font-size: 2em;
														text-align:center;
														margin:0;
													}
													#sticky.stick {
														position: fixed;
														top: 0;
														z-index: 10000;
														margin:0;
														right:0;
													}
													.top_bts ul li {
														margin-bottom:0;
													}
													</style>
													<script type="text/javascript">
													function sticky_relocate() {
														var window_top = $(window).scrollTop();
														var div_top = $('#sticky-anchor').offset().top;
														if (window_top > div_top) {
															$('#sticky').addClass('stick');
														} else {
															$('#sticky').removeClass('stick');
														}
													}
													
													$(function () {
														$(window).scroll(sticky_relocate);
														sticky_relocate();
													});
													</script>
													<div id="sticky-anchor"></div>
													<div class="panel-heading" id="sticky">
														<div class="row">
															<div class="top_bts">
																<ul>
																	<input id="page" type="hidden" value="1" class="form-control">
																	<li>
																		<a href="<?php echo $SITE_URL; ?>sign_pad/" class="btn btn-default sign_now">
																			<i class="fa fa-pencil-square-o"></i> My Signature
																		</a>
																		<button id="addImage" class="col-md-12 btn btn-primary" style="display:none;">Add this Image</button>
																		<input id="signature_img_data" type="hidden" value="" class="form-control">
																	</li>
																	<li>
																	  <button id="show_addbutton" class="btn btn-default"><i class="fa fa-file-text-o"></i> My Text</button>
																	</li>
																	<li>
																	  <button id="show_addDate" class="btn btn-default"><i class="fa fa-trash-o fa-clock-o"></i> Today's Date</button>
																	</li>
																	<li>
																	  <button id="add_text_field" class="btn btn-default"><i class="glyphicon glyphicon-check"></i> Add Check</button>
																	</li>
																	<!--<li>
																		<input id="newtext" type="text" value="please insert text" class="form-control">
																	</li>
																	<li>
																		<select name="f_color" id="f_color" class="form-control">
																			<option value="black"> --- Select Font Color --- </option>
																			<option value="black">Black</option>
																			<option value="red">Red</option>
																			<option value="green">Green</option>
																			<option value="blue">Blue</option>
																			<option value="yellow">Yellow</option>
																			<option value="purple">Purple</option>
																		</select>
																	</li>
																	<li>
																		<select name="f_size" id="f_size" class="form-control">
																			<option value="10"> --- Select Font Size --- </option>
																			<?php for($i=10; $i<=100; $i=$i+2) { ?>
																			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																			<?php } ?>
																		</select>
																	</li>-->
																	
																	<div class="clearfix"></div>
																</ul>
															</div>
															<div class="right_side" style="margin-right:20px;">
																<a href="<?=$SITE_URL?>" class="btn btn-default">
																	<i class="glyphicon glyphicon-remove"></i>
																</a>
															</div>
															<div class="right_side">
																<!-- Save document -->
																<div class="col-md-12" style="margin-top:5px;">
																	<button id="save_as_image" class="col-md-12 btn btn-default">
																		<i class="glyphicon glyphicon-ok "></i>
																	</button>
																	<img id="save_as_image_loader" src="images/ajax-loader1.gif" style="display:none;padding:0 20px;" />
																	<span id="save_as_image_msg" style="color:#FFFFFF; display:none; font-size: 16px;">
																		Your document has been saved successfully!
																	</span>
																</div>
																<!-- Save document -->
															</div>
															<div class="top_bts" id="_My_Text_Date" style="display:none; width:100%;">
																<ul>
																	<li>
																		<input id="newtext" type="text" value="please insert text" class="form-control">
																	</li>
																	<li>
																		<select name="f_color" id="f_color" class="form-control">
																			<option value="black"> --- Select Font Color --- </option>
																			<option value="black">Black</option>
																			<option value="red">Red</option>
																			<option value="green">Green</option>
																			<option value="blue">Blue</option>
																			<option value="yellow">Yellow</option>
																			<option value="purple">Purple</option>
																		</select>
																	</li>
																	<li>
																		<select name="f_size" id="f_size" class="form-control">
																			<option value="10"> --- Select Font Size --- </option>
																			<?php for($i=10; $i<=100; $i=$i+2) { ?>
																			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																			<?php } ?>
																		</select>
																	</li>
																	<li id="_Text_btn">
																	  <button id="addbutton" class="btn btn-default"><i class="fa fa-file-text-o"></i> Add Text</button>
																	</li>
																	<li id="_Date_btn">
																	  <button id="addDate" class="btn btn-default"><i class="fa fa-trash-o fa-clock-o"></i> Add Date</button>
																	</li>
																	<li id="_Date_btn">
																	  <button id="_close" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i></button>
																	</li>
																	<div class="clearfix"></div>
																</ul>
															</div>	
														</div>
													</div>
													<div class="panel-body">
														<div class="table-responsive">
																<?php
																$q = "select * from document_image WHERE doc_id=$d_id ORDER BY id";
																$res = mysql_query($q);
																$total_page = mysql_num_rows($res);
																if(mysql_num_rows($res) > 0) {
																	$page = 1;
																	while($f = mysql_fetch_array($res))
																	{ ?>
																	<style>
																	#doc_image_<?php echo $page; ?> {
																		border:solid 1px #ccc;
																		margin-top: 10px;
																		width:1240px;
																		margin:0 auto;
																		box-sizing:content-box;
																		padding:3px;
																		overflow: scroll;
    																	overflow-y: hidden;
																	}
																	</style>
																	<input type="hidden" id="width_<?php echo $page; ?>">
																	<input type="hidden" id="height_<?php echo $page; ?>">
																	<script type="text/javascript">
																		$(document).ready( function() { 
																			/**************** CONFIG *****************/
																			$('#spinner').show(); $('.wrapper').css('opacity','0.5');
																			var chk_img_<?php echo $page; ?> = new Image();
																			chk_img_<?php echo $page; ?>.onload = function() {
																				$('#width_<?php echo $page; ?>').val(this.width);
																				$('#height_<?php echo $page; ?>').val(this.height);
																			}
																			chk_img_<?php echo $page; ?>.src = '<?php echo 'ds_files/jpg_files/'.$f['image_name']; ?>';
																		});
																		$(window).load( function() { 
																			var canvas_w = $('#width_<?php echo $page; ?>').val();
																			var canvas_h = $('#height_<?php echo $page; ?>').val();  
																			console.log(canvas_w + 'x' + canvas_h);
																			//$('#doc_image_<?php echo $page; ?>').css('width',canvas_w);
																			$('#doc_image_<?php echo $page; ?>').css('height',canvas_h);
																			/**************** CONFIG *****************/
																			/**************** ADD STAGE *****************/
																			var stage = new Kinetic.Stage({
																				container: 'doc_image_<?php echo $page; ?>',
																				width: canvas_w,
																				height: canvas_h
																			});
																			/**************** ADD STAGE *****************/
																			
																			/**************** ADD LAYER *****************/
																			var layer = new Kinetic.Layer();
																			stage.add(layer);
																			
																			var image = new Image();
																			image.onload = function () {
																				var image1 = new Kinetic.Image({
																					x: 0,
																					y: 0,
																					width: canvas_w,
																					height: canvas_h,
																					quality: 1,
																					image: image,
																				});
																				layer.add(image1);
																				layer.draw();
																				if('<?php echo $page; ?>' == '<?php echo $total_page; ?>') {
																					$('#spinner').hide(); $('.wrapper').css('opacity','1');
																				}
																			}
																			image.src = "<?php echo 'ds_files/jpg_files/'.$f['image_name']; ?>";
																			/**************** ADD LAYER *****************/
																			
																			/**************** ADD TEXT *****************/
																			$("#addbutton").click(function () {
																				// simple label
																				var page = $('#page').val();
																				if(page == '<?php echo $page; ?>') {
																					var f_color = $('#f_color').val();
																					var f_size = $('#f_size').val();
																					
																					var label1 = new Kinetic.Label({
																						x: 20,
																						y: 20,
																						draggable: true,
																					});
																				
																					label1.add(new Kinetic.Tag({
																						fill: 'transparent',
																						//stroke: '#333',
																						//lineJoin: 'round',
																						//strokeWidth: 1,
																						//dash: [ 1, 1 ],
																						//dashEnabled: true,
																						//shadowColor: 'black',
																					}));
																					
																					label1.add(new Kinetic.Text({
																						text: $("#newtext").val(),
																						fontFamily: 'Verdana',
																						fontSize: f_size,
																						padding: 10,
																						fill: f_color
																					}));
																					layer.add(label1);
																					layer.draw();
																				
																					label1.on("dblclick",function(){
																						if(confirm('Are you sure to delete this text?')) {
																							this.remove();
																							layer.draw();
																						}
																					});
																					
																					label1.on('mouseover', function() {
																						document.body.style.cursor = 'move';
																					});
																					
																					label1.on('mouseout', function() {
																						document.body.style.cursor = 'default';
																					});
																					
																				}
																			});
																			/**************** ADD TEXT *****************/
																			
																			/**************** ADD SIGNATURE *****************/
																			$("#addImage").click(function () {
																				var page = $('#page').val();
																				if(page == '<?php echo $page; ?>') {
																					//alert(page);
																					var img_src = $('#signature_img_data').val();
							
																					if(img_src != '') {
																						var label_img = new Kinetic.Label({
																							x: 20,
																							y: 20,
																							draggable: true,
																						});
																						
																						var image = new Image();
																						image.onload = function () {
																							var image_sig = new Kinetic.Image({
																								x: 0,
																								y: 0,
																								width: 200,
																								height: 100,
																								quality: 1,
																								image: image,
																								draggable: true,
																							});
																							label_img.add(image_sig);
																							layer.add(label_img);
																							layer.draw();
																						}
																						image.src = img_src;
																						
																						label_img.on("dblclick",function(){
																							if(confirm('Are you sure to delete this Signature?')) {
																								this.remove();
																								layer.draw();
																							}
																						});
																						
																						label_img.on('mouseover', function() {
																							document.body.style.cursor = 'move';
																						});
																						
																						label_img.on('mouseout', function() {
																							document.body.style.cursor = 'default';
																						});
																					}
																				}
																			});
																			/**************** ADD SIGNATURE *****************/
																			
																			/**************** ADD DATE *****************/
																			$("#addDate").click(function () {
																				// simple label
																				var page = $('#page').val();
																				if(page == '<?php echo $page; ?>') {
																					var f_color = $('#f_color').val();
																					var f_size = $('#f_size').val();
																					
																					var label_date = new Kinetic.Label({
																						x: 20,
																						y: 20,
																						draggable: true,
																					});
																				
																					label_date.add(new Kinetic.Tag({
																						fill: 'transparent',
																					}));
																					
																					label_date.add(new Kinetic.Text({
																						text: "<?php echo date('d/m/Y'); ?>",
																						fontFamily: 'Verdana',
																						fontSize: f_size,
																						padding: 10,
																						fill: f_color
																					}));
																					layer.add(label_date);
																					layer.draw();
																				
																					/*label_date.on("dblclick",function(){
																						if(confirm('Are you sure to delete this Date?')) {
																							this.remove();
																							layer.draw();
																						}
																					});*/
																					
																					var touchtime = 0;
																					label_date.on('click', function() {
																						if(touchtime == 0) {
																							//set first click
																							touchtime = new Date().getTime();
																						} else {
																							//compare first click to this click and see 
																							//if they occurred within double click threshold
																							if(((new Date().getTime())-touchtime) < 800) {
																								//double click occurred //alert("double clicked");
																								if(confirm('Are you sure to delete this Date?')) {
																									this.remove();
																									layer.draw();
																								}
																								touchtime = 0;
																							} else {
																								//not a double click so set as a new first click
																								touchtime = new Date().getTime();
																							}
																						} 
																					});
																					
																					label_date.on('mouseover', function() {
																						document.body.style.cursor = 'move';
																					});
																					
																					label_date.on('mouseout', function() {
																						document.body.style.cursor = 'default';
																					});
																					
																					label_date.on("dragend", function() {
																					   var points = this.getPosition();
																					   //alert(points.x + ',' + points.y);
																					});  
																					
																				}
																			});
																			/**************** ADD DATE *****************/
																			
																			/**************** FIELD LAYER *****************/
																			var FieldLayer = new Kinetic.Layer();
																			stage.add(FieldLayer);
																			/**************** FIELD LAYER *****************/
																			
																			/**************** TEXT FIELD *****************/
																			$("#add_text_field").click(function () {
																				// simple label
																				var page = $('#page').val();
																				if(page == '<?php echo $page; ?>') {
																					var f_color = $('#f_color').val();
																					var f_size = $('#f_size').val();
																					
																					/*var txt_field = new Kinetic.Label({
																						x: 20,
																						y: 20,
																						draggable: true,
																						id : "text_field",
																						name : "text_field"
																					});
																				
																					txt_field.add(new Kinetic.Tag({
																						fill: '#428BCA',
																						stroke: '#333',
																						//lineJoin: 'round',
																						strokeWidth: 1,
																						dash: [ 2, 2 ],
																						//dashEnabled: true,
																						//shadowColor: 'black',
																					}));
																					
																					txt_field.add(new Kinetic.Text({
																						text: "TEXT FIELD",
																						fontFamily: 'Verdana',
																						fontSize: f_size,
																						padding: 10,
																						fill: f_color
																					}));*/
																					
																					var label_tick = new Kinetic.Label({
																						x: 20,
																						y: 20,
																						draggable: true,
																						scale : true
																					});
																					
																					var image = new Image();
																					image.onload = function () {
																						var image_tick = new Kinetic.Image({
																							x: 0,
																							y: 0,
																							width: 24,
																							height: 24,
																							quality: 1,
																							image: image,
																							draggable: true,
																						});
																						label_tick.add(image_tick);
																						FieldLayer.add(label_tick);
																						FieldLayer.draw();
																					}
																					image.src = "<?php echo 'images/checkmark.png'; ?>";
																					
																					
																					//FieldLayer.add(txt_field);
																					//FieldLayer.draw();
																					
																					
																					label_tick.on("dblclick",function(){
																						if(confirm('Are you sure to delete this checkbox?')) {
																							this.remove();
																							FieldLayer.draw();		
																						}
																					});
																					
																					
																					label_tick.on('mouseover', function() {
																						document.body.style.cursor = 'move';
																					});
																					
																					label_tick.on('mouseout', function() {
																						document.body.style.cursor = 'default';
																					});
																					
																					/*var obj_preval = $('#object').val();
																					txt_field.on("dragend", function() {
																					   var points = this.getPosition();
																					   $('#object').val(obj_preval + "("+points.x + ',' + points.y+")");
																					});*/
																					
																				}
																			});
																			/**************** TEXT FIELD *****************/
																			
																			$("#doc_image_<?php echo $page; ?>").on('click touchstart',function () {
																				$(".doc_img").removeClass('current');
																				$(this).addClass('current');
																				$('#page').val('<?php echo $page; ?>');
																			});
																			
																			
																			$("#save_as_image").click(function() {
																				//FieldLayer.destroy();
																				$('#save_as_image_loader').show();
																				$(this).hide();
																				stage.toDataURL({
																				//mimeType: "image/jpeg",
																				quality: 100,
																				callback: function(dataUrl) {
																					$.post(
																						"ajax_image.php", 
																						{ 
																							data : dataUrl, 
																							name : "<?php echo 'ds_files/jpg_files/'.$f['image_name']; ?>",
																							d_id : "<?php echo $d_id ?>",
																							page : "<?php echo $page; ?>",
																							total_page : "<?php echo $total_page; ?>",
																							user : "<?php echo $_SESSION['admin_details']['email']; ?>"
																						},
																						function(data_<?php echo $page; ?>) { 
																						//console.log(data_<?php echo $page; ?>); alert("Your Design Was Saved To The Server"); 
																							//alert('<?php echo $page; ?>');
																							if('<?php echo $page; ?>' == '<?php echo $total_page; ?>') {
																								$('#save_as_image_loader').hide();
																								$('#save_as_image_msg').fadeIn('slow').delay(2000).fadeOut('slow');
																								setTimeout(function() {
																									window.location.href="<?=$SITE_URL?>";
																								}, 2000);
																								//$('#save_as_image').show();
																							}	
																						}
																					); 
																				}
																				}); 
																			});
																					
																		});
																	</script>
																	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
																		<thead>
																			<tr>
																				<th style="text-align:center;">Page <?php echo $page. ' of ' .$total_page; ?></th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr class="odd gradeX">
																				<td>
																					<div id="doc_image_<?php echo $page; ?>" class="doc_img <?php if($page==1){ echo 'current';}?>">
																					</div>
																				</td>
																			</tr>
																		</tbody>
																	</table>	
																	<?php $page++; } 
																}
																else { ?>
																<table class="table table-striped table-bordered table-hover" id="dataTables-example">
																	<thead>
																		<tr>
																			<th>Page 1</th>
																		</tr>
																	</thead>
																</table>
																<?php } ?>
															
														</div>
													</div>
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
					var c_width = "30%";
					var c_height = "55%";
				}
				else {
					var c_width = "100%";
					var c_height = "55%";
				}
				$(".sign_now").colorbox({width:c_width, height:c_height, iframe:true, overlayClose: false, fixed:true, onClosed: function () {
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
</body>
</html>