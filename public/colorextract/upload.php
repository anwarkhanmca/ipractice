<?php
//echo "aa";die;
include('../file-and-sign/include/config.inc.php');
$delta 				= 24;
$reduce_brightness 	= true;
$reduce_gradients 	= true;
$num_results 		= 20;

$user_id 		= $_REQUEST['user_id'];
$group_id 		= $_REQUEST['group_id'];
$added_from 	= $_REQUEST['added_from'];

$file_name 	= $_FILES['imgFile']['name'];
$path   = implode('/', explode('/', getcwd(), -1));

//print_r($users);die;
include_once("colors.inc.php");
$ex 	= new GetMostCommonColors();
//$colors=$ex->Get_Color("test.jpg", $num_results, $reduce_brightness, $reduce_gradients, $delta);


// was any file uploaded?
if ( isset( $_FILES['imgFile']['tmp_name'] ) && strlen( $_FILES['imgFile']['tmp_name'] ) > 0 )
{
	// move image to a writable directory
	if (! move_uploaded_file($_FILES['imgFile']['tmp_name'], 'images/'.basename($file_name)))
	{
		die("Error moving uploaded file to images directory");
	}
	$colors=$ex->Get_Color( 'images/'.$file_name, $num_results, $reduce_brightness, $reduce_gradients, $delta);
?>
<thead>
	<tr>
	    <td>Image</td>
	    <td>Percentage</td>
	    <td style="width: 10%; text-align: center;">Colour</td>
	    <td style="width:10%; text-align: center;">Use</td>
	</tr>
</thead>
<tbody>
<?php
$i = 1;
$max_color = 0;

$upsql="delete from crm_color_detects where user_id in (select user_id from users where group_id='".$group_id."')";//echo $upsql;//die;
mysql_query($upsql);

foreach ( $colors as $hex => $count )
{
	if ( $count > 0 )
	{
		if($hex != 'ffffff'){
			$sql = "insert into crm_color_detects set 
				user_id='".$user_id."',
				color_code = '".$hex."',
				percentage = '".$count."',
				created = '".date('Y-m-d H:i:s')."'
			";
			//echo $sql;
			mysql_query($sql);

			if($i == 1){
				$max_color 	= $count;
				$max_code 	= $hex;
				echo "<tr><td rowspan='20'><img src='/colorextract/images/".$file_name."' alt='test image' width='80'></td><td>$count</td><td style=\"background-color:#".$hex.";\" align='center'></td><td align='center'><input type='radio' class='selectRadioColor' name='colRadio' value=\"#".$hex."\" checked></td></tr>";
			}else{
				echo "<tr><td>$count</td><td style=\"background-color:#".$hex.";\" align='center'></td><td align='center'><input type='radio' class='selectRadioColor' name='colRadio' value=\"#".$hex."\"></td></tr>";
			}
			$i++;
		}
	}
}

}

$set = '';
if($added_from == 'practice'){
	$set = "practice_logo = '".$file_name."', use_color = 'A', crm_auto_color = '#".$max_code."', ";
}

$set .= "crm_branding_logo = '".$file_name."'";

$upData = "update practice_details set ".$set." where user_id in (select user_id from users where group_id='".$group_id."')";
//echo $upData;
mysql_query($upData);

?>
</tbody>
anwar
<?php echo '#'.$max_code;?>
anwar
<?= $file_name;?>

