<?php session_start();
include("config.inc.php");
include("function.php");
include("sendmail.php");
include("tablename.php");
include("db_function.php");
include("paging.php");
//include("class.function.php");
require("../twitter/twitteroauth.php");
require('../config/twconfig.php');

require('../facebook/facebook.php');
require('../config/fbconfig.php');

$prs_pageing = new get_pageing();

$to_cur_date = date("Y-m-d H:m:s");	
$session_id = session_id();
$cur_page_arr = explode("/",$_SERVER['PHP_SELF']);
$cur_page = $cur_page_arr[count($cur_page_arr)-1];

/*admin email*/
$admquery = "select * from admin";
$resulta = mysql_query($admquery);
if(!$resulta)
	echo mysql_error();
if(mysql_num_rows($resulta) > 0)
{
	$rowa = mysql_fetch_array($resulta);
	$infomail = $rowa['admin_email']; 		
}
?>