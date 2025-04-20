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

	$('#clear').click(function() {
		var myCanvas = document.getElementById("canvas");
		var ctx = myCanvas.getContext('2d');
		ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
		$('#signature_img_data', window.parent.document).val("");
		$('#canvas_box').hide();
		$('#file_box').show();
		$('#file-input').val("");
		$('#json').addClass("disabled");
	});
	
	$('#json').click(function() {
		//alert($('#sig').signature('toJSON'));
		//var dataUrl = $('#sig').signature('toJSON');
		var canvasBox = document.getElementById('canvas');
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
			<a href="index.php" class="col-md-12 btn btn-info"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;&nbsp;Draw</a> 
			<button class="col-md-12 btn btn-info active"><i class="glyphicon glyphicon-upload"></i>&nbsp;&nbsp;&nbsp;Upload</button>
		</p>
	</div>
	<div class="col-md-12 col-sd-12 col-xs-12">
		<div class="kbw-signature" id="canvas_box">
			<canvas id="canvas" width="398px" height="198px"></canvas>
		</div>
		<div class="kbw-signature" id="file_box">
			<input class="form-control" type="file" id="file-input" style="margin:82px 20px; width:90%;">
		</div>
		<script>
		$(document).ready( function() {
			$('#canvas_box').hide();
		});
		$(function() {
			$('#file-input').change(function(e) {
				$('#canvas_box').show();
				$('#file_box').hide();
				$('#json').removeClass("disabled");
				var file = e.target.files[0],
					imageType = /image.*/;
		
				if (!file.type.match(imageType)) {
					alert("Sorry! The filetype or extension is invalid. allowed only image file!");
					$('#canvas_box').hide();
					$('#file_box').show();
					$('#file-input').val("");
					$('#json').addClass("disabled");
					return false;
				}	
		
				var reader = new FileReader();
				reader.onload = fileOnload;
				reader.readAsDataURL(file);        
			});
		
			function fileOnload(e) {
				var $img = $('<img>', { src: e.target.result });
				var canvas = $('#canvas')[0];
				var context = canvas.getContext('2d');
		
				$img.load(function() {
					context.drawImage(this, 0, 0, 398, 198);
				});
			}
		});
		</script>
	</div>	
	<div class="col-md-12 col-sd-12 col-xs-12">
		<p style="clear: both; margin-top:10px;">
			<button id="clear" class="col-md-12 btn btn-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;&nbsp;Clear</button> 
			<button id="json" class="col-md-12 btn btn-success disabled"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Done</button>
		</p>
	</div>
</body>
</html>
