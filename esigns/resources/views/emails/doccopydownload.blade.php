<!DOCTYPE html>
<html>
<head>
	<title>Declined to sign the document</title>
</head>
<body>
	Hello sir, <br>

	<h2>Here are your downloadable copies.</h2> <br>
	<?php $i = 0; ?>
	@foreach($mail['link'] as $link)
	<b>Document # <?php echo ++$i; ?></b> <a href="{{$link}}" download> Click to download!</a> <br>
	@endforeach
	<br> Thank you. 
</body>
</html>