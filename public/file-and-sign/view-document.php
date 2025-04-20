<?php include('connect.php'); 

if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://mpm.digiopia.in/login");
}
if(isset($_REQUEST['difs']) && $_REQUEST['difs'] > 0)
{
	$Oid = $_REQUEST['Oid'];
	$user_id = $_SESSION['admin_details']['id'];
	if($user_id === Oid) {
		echo "<h4>Something went to wrong!</h4>";
		exit;
	}
	
	$d_id = $_REQUEST['difs'];
	$d_name = $_REQUEST['doc_name'];
		
	header('location:'.$SITE_URL.'ds_files/'.$d_name.'.pdf');
	exit();
}	
//header('location:manage-document.php');



