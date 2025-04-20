<?php include('../connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>jQuery UI Signature Basics</title>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/south-street/jquery-ui.css" rel="stylesheet">
<link href="lib/jquery.signature.css" rel="stylesheet">

	<!-- bootstrap 3.0.2 -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- font Awesome -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

<style>
.kbw-signature { width: 400px; height: 200px; }
</style>
<!--[if IE]>
<script src="excanvas.js"></script>
<![endif]--><script src="lib/excanvas.js"></script>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
<script src="lib/jquery.signature.js"></script>
<script>
$(function() {
		$('#sig').signature({
			background: 'transparent',
			color: '#145394',
			thickness: 2,
		});
	
	$('#clear').click(function() {
		$('#sig').signature('clear');
		$('#signature_img_data', window.parent.document).val("");
	});
	
	$('#json').click(function() {
		//alert($('#sig').signature('toJSON'));
		//var dataUrl = $('#sig').signature('toJSON');
		var canvasBox = document.getElementById('SignaturePad');
		var dataUrl = canvasBox.toDataURL("image/png", 1);
		console.log(dataUrl);
		$('#signature_img_data', window.parent.document).val(dataUrl);
		parent.$.colorbox.close(); return false;
		$.noConflict(true);
		parent.jQuery.colorbox.close(); return false;
	});
	
	
	$('#svg').click(function() {
		alert($('#sig').signature('toSVG'));
		var svgOutput = window.open('data:image/svg+xml,' + $('#sig').signature('toSVG'));
		svgOutput.document.close();
		return false;
	});
});
</script>
</head>
<body>
	<div class="col-md-12 col-sd-12 col-xs-12">
		<p style="clear: both;">
			<button class="col-md-12 btn btn-info active"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;&nbsp;Draw</button> 
			<a href="upload-signature.php" class="col-md-12 btn btn-info active"><i class="glyphicon glyphicon-upload"></i>&nbsp;&nbsp;&nbsp;Upload</a>
		</p>
	</div>
	<div class="col-md-12 col-sd-12 col-xs-12">
		<div id="sig"></div>
		<p style="clear: both; margin-top:10px;">
			<button id="clear" class="col-md-12 btn btn-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;&nbsp;Clear</button> 
			<button id="json" class="col-md-12 btn btn-success"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Done</button>
		</p>
	</div>
</body>
</html>
