<?php include ('connect.php'); 

ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

if(isset($_REQUEST['difs']) && is_numeric($_REQUEST['difs'])) {
//if($_REQUEST['difs'] == 1550) { sleep(1000); }
echo $doc_id = $_REQUEST['difs'];
ini_set('max_execution_time', 0);
$pdf_dir = "ds_files/";
$image_dir = "ds_files/jpg_files/";
ini_set("display_errors",1);
$document_arr = single_row("documents","*","id=$doc_id");
print_r($document_arr);	
	if($document_arr['status']==0) {
		$NewDocName = $document_arr['doc_name'];
		$DocName    = preg_replace("/\.[^.\s]{3,4}$/", "", $NewDocName);
		
		$location   = "convert -density 250  -background white -flatten";
		$Doc_Name       = $pdf_dir. $NewDocName;
		$num = count_pages($Doc_Name);
		$RandomNum   = time();
		$ImageName     = $image_dir.$DocName.'-'.$RandomNum;
		$image_name     = $DocName.'-'.$RandomNum;
		
		for($i = 0; $i<$num;$i++)
		{
			$ImageName1 = "";
			$image_name1 = "";
			$j = $i+1;
			$ImageName1 = $ImageName."-".$j.".jpg";
			$image_name1 = $image_name."-".$j.".jpg";
			
			$convert   = $location . " " . $Doc_Name."[".$i."]" . " " . $ImageName1;
			//echo $convert;
			
			//$ver1 = exec('/usr/bin/gs -dNOPAUSE -r250 -dDownScaleFactor=3 -dBATCH -sDEVICE=jpeg -dJPEGQ=50 -sOutputFile="'.$ImageName1.'" -dFirstPage='.$j.' -dLastPage='.$j.'  "'.$Doc_Name.'" 2>&1');
			//var_dump($ver1);
			exec($convert);
			$status = 1;
			$image_query="insert into document_image (image_name, doc_id, status) values('$image_name1','$doc_id','$status')"; 
			mysql_query($image_query) or die(mysql_error());
		}
		$message="0";
		
		$doc_query="UPDATE documents SET status = 1 WHERE id = $doc_id"; 
		mysql_query($doc_query) or die(mysql_error());
		header("location:".$SITE_URL."index.php?document=".$DocName);
	}	
}		
?>