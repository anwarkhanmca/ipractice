<!DOCTYPE html>
<html>
<head>
	<title>Document sign request</title>
</head>
<body>
	Hello <b>{{$mail['recep_name']}},</b> <br>

	you have the following documents for signature. <br>
	<h2>{{$mail['title']}}</h2><br>
	<p>{{$mail['desc']}}</p><br>
	<?php $i = 0; ?>
	@foreach($mail['recep_link'] as $link) 
	<h3>Document # <?php echo ++$i; ?></h3> <br>
	<p>Please click the following link to sign the doc. </p>

	<a href="{{$link}}">Click to sign!</a> <br>

	or click this : <a href="{{$link}}">{{$link}}</a><br>

	@endforeach

	<br>Your passcode will be <br>
		
		<h2>{{$mail['recep_passcode']}}</h2> 

	<br> Thank you. 
</body>
</html>

