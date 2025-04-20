<?php include('../connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>jQuery UI Signature Basics</title>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/south-street/jquery-ui.css" rel="stylesheet">
	<!-- bootstrap 3.0.2 -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- font Awesome -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<link href="lib/jquery.signaturepad.css" rel="stylesheet">
<style>
.sigWrapper.current { width:324px; height:155px; border:2px solid #31B0D5; border-radius:5px;}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="lib/jquery.signaturepad.js"></script>
<script>
	$(document).ready(function() {
	  $('.sigPad').signaturePad({drawOnly:true, clear : '#clearButton', bgColour : 'transparent'});
	});
</script>
<script>
$(function() {
	$('#save').click(function() {
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
		<div class="sigPad" style="padding:0;">
			<div class="sig sigWrapper">
			  <canvas id="SignaturePad" class="pad" width="320" height="150"></canvas>
			  <input type="hidden" name="output" class="output">
			</div>
			<p style="clear: both; margin-top:10px;">
				<a id="clearButton" class="col-md-12 btn btn-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;&nbsp;Clear</a> 
				<a id="save" class="col-md-12 btn btn-success"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Done</a>
			</p>
		</div>
	</div>
</body>
</html>
