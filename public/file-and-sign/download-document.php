<?php include('connect.php'); 

if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://mpm.digiopia.in/login");
}
if(isset($_REQUEST['difs']) && $_REQUEST['difs'] > 0)
{
	echo $Oid = $_REQUEST['Oid'];
	echo $user_id = $_SESSION['admin_details']['id'];
	if($user_id === Oid) {
		echo "<h4>Something went to wrong!</h4>";
		exit;
	}
	
	$d_id = $_REQUEST['difs'];
	$d_name = $_REQUEST['doc_name'];
	$q = "select * from document_image WHERE doc_id=$d_id ORDER BY id";
	$res = mysql_query($q);
	$total_page = mysql_num_rows($res);
	$jpg_files = "";
	if(mysql_num_rows($res) > 0) {
		while($f = mysql_fetch_array($res))
		{
			$jpg_files .= ' ds_files/jpg_files/'.$f['image_name']; 
		}
		echo $jpg_files;
		$pdf_file = 'ds_files/pdf_files/'.$d_name.'.pdf';
		
		$location   = "convert -density 300";
		$convert   = $location . " " . $jpg_files . " -compress Zip " . $pdf_file;
		echo '<br/>';
		echo $convert;
		exec($convert." 2>&1", $array);
		
		$history_arr['event'] = "Download document";
		$history_arr['user'] = $_SESSION['admin_details']['email'];
		$history_arr['ip_address'] = $ip_address;
		$history_arr['doc_id'] = $d_id;
		ins_rec('document_history', $history_arr);
		
		header('location:'.$SITE_URL.'ds_files/pdf_files/'.$d_name.'.pdf');
		
		exit();
	}	
    	//header('location:manage-document.php');
}



