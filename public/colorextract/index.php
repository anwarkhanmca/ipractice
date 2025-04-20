<?php
$delta = 24;
$reduce_brightness = true;
$reduce_gradients = true;
$num_results = 20;

include_once("colors.inc.php");
$ex=new GetMostCommonColors();
$colors=$ex->Get_Color("test.jpg", $num_results, $reduce_brightness, $reduce_gradients, $delta);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>Image Color Extraction</title>
	<style type="text/css">
		* {margin: 0; padding: 0}
		body {text-align: center;}
		form, div#wrap {margin: 10px auto; text-align: left; position: relative; width: 500px;}
		fieldset {padding: 20px; border: solid #999 2px;}
		img {width: 200px;}
		table {border: solid #000 1px; border-collapse: collapse;}
		td {border: solid #000 1px; padding: 2px 5px; white-space: nowrap;}
		br {width: 100%; height: 1px; clear: both; }
	</style>
</head>
<body>
<div id="wrap">
<form action="#" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Upload Your Own Image</legend>
<input type="file" name="imgFile" />
<input type="submit" name="action" value="Process" />
</fieldset>
</form>
<?php
// was any file uploaded?
if ( isset( $_FILES['imgFile']['tmp_name'] ) && strlen( $_FILES['imgFile']['tmp_name'] ) > 0 )
{
	// move image to a writable directory
	if (! move_uploaded_file($_FILES['imgFile']['tmp_name'], 'images/'.$_FILES['imgFile']['name']))
	{
		die("Error moving uploaded file to images directory");
	}
	$colors=$ex->Get_Color( 'images/'.$_FILES['imgFile']['name'], $num_results, $reduce_brightness, $reduce_gradients, $delta);
?>
<table>
<tr><td>Color</td><td>Color Code</td><td>Percentage</td><td rowspan="<?php echo (($num_results > 0)?($num_results+1):22500);?>"><img src="<?='images/'.$_FILES['imgFile']['name']?>" alt="test image" /></td></tr>
<?php
foreach ( $colors as $hex => $count )
{
	if ( $count > 0 )
	{
		echo "<tr><td style=\"background-color:#".$hex.";\"></td><td>".$hex."</td><td>$count</td></tr>";
	}
}
?>
</table>
<br />
<?php
}
?>

<?php
$colors=$ex->Get_Color("images/test.jpg", $num_results, $reduce_brightness, $reduce_gradients, $delta);
?>
<table>
<tr><td>Color</td><td>Color Code</td><td>Percentage</td><td rowspan="<?php echo (($num_results > 0)?($num_results+1):22500);?>"><img src="images/test.jpg" alt="test image" /></td></tr>
<?php
foreach ( $colors as $hex => $count )
{
	if ( $count > 0 )
	{
		echo "<tr><td style=\"background-color:#".$hex.";\"></td><td>".$hex."</td><td>$count</td></tr>";
	}
}
?>
</table>


</div>
</body>
</html>
