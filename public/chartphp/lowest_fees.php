<?php 
require_once("chartphp/lib/inc/chartphp_dist.php");

$p = new chartphp();
$p->data = array(
		array(
			array(200,1), array(400,2), array(600,3), array(800,4), array(1000,5), array(1200,6), array(1400,7), array(1600,8), array(1800,9), array(2000,10)
			)
		);
				
$p->chart_type = "bar-stacked";

// Common Options
$p->title = "Horizontal Bar Stacked";
//$p->xlabel = "My X Axis";
//$p->ylabel = "My Y Axis";
//$p->series_label = array('Q1','Q2','Q3');
$p->direction = "horizontal";
$p->export = false;
$out1 = $p->render('c1');
?>

<!DOCTYPE html>
<html>
	<head>
		<script src="http://mpm.com/chartphp/lib/js/jquery.min.js"></script>-->
		<script src="http://mpm.com/chartphp/lib/js/chartphp.js"></script>
		<link rel="stylesheet" href="http://mpm.com/chartphp/lib/js/chartphp.css">
	
	<style>
		/* white color data labels */
		.jqplot-point-label{color:white;}
	</style>
	</head>
	
	<body>
		<div style="width:40%; min-width:450px;">
			<?php echo $out1; ?>
		</div>
	</body>
</html>