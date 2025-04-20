<?php session_start(); ob_start();
include("include/db_function.php");
include("include/config.inc.php");
include("include/function.php");
include("include/sendmail.php");

$session_id = session_id();

//$ADMINMAIL=get_single_value (ADMIN,'admin_email','1=1');
//$PAYPALMAIL=get_single_value (ADMIN,'paypal_email','1=1');

$cur_page_arr = explode("/",$_SERVER['PHP_SELF']);
$cur_page = $cur_page_arr[count($cur_page_arr)-1];

$ip_address = get_client_ip();
if($ip_address == '::1') {
	$ip_address = '103.7.80.71';
}
$From_EmailAddress = "hr@inertwebs.in";		
?>