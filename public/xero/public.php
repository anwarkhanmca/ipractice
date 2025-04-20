<?php
require 'lib/XeroOAuth.php';
define ( 'BASE_PATH', dirname(__FILE__) );
$base_url = "https://i-practice.co.uk/";
define ( "XRO_APP_TYPE", "Public" );
$useragent = "Xero-OAuth-PHP Public";
define ( "OAUTH_CALLBACK", $base_url."xero/index.php" );

include 'tests/testRunner.php';

$signatures = array (
	'consumer_key' => 'XJJ1BAOB3IBMEDLIVEDKJUI0ZCGR62',
	'shared_secret' => 'VPYYEYEGMF2J9M3D0WKLYOEDNTVUV4',
	'core_version' => '2.0',
	'payroll_version' => '1.0',
	'file_version' => '1.0' 
);

$XeroOAuth = new XeroOAuth ( array_merge ( array (
	'application_type' => XRO_APP_TYPE,
	'oauth_callback' => OAUTH_CALLBACK,
	'user_agent' => $useragent 
), $signatures ) );

$initialCheck = $XeroOAuth->diagnostics ();
$checkErrors = count ( $initialCheck );
if ($checkErrors > 0) {
	// you could handle any config errors here, or keep on truckin if you like to live dangerously
	foreach ( $initialCheck as $check ) {
		echo 'Error: ' . $check . PHP_EOL;
	}
} else {
	
	$here = XeroOAuth::php_self ();
	session_start ();
	$oauthSession = retrieveSession ();
	//echo "<pre>";print_r($oauthSession);die;
	/* ============= User defined section start ============= */
	/*if (isset($_REQUEST['method']) && $_REQUEST['method'] == "put" && $_REQUEST['invoice']== 1 ){
		include 'invoice.php';
	}else{
		include 'tests/tests.php';
	}*/
	include 'tests/tests.php';
	/* ============= User defined section end ============= */
	
	if (isset ( $_REQUEST ['oauth_verifier'] )) {
		$XeroOAuth->config ['access_token'] = $_SESSION['oauth']['oauth_token'];
		$XeroOAuth->config ['access_token_secret'] = $_SESSION['oauth']['oauth_token_secret'];
		
		$code = $XeroOAuth->request ( 'GET', $XeroOAuth->url ( 'AccessToken', '' ), array (
			'oauth_verifier' => $_REQUEST ['oauth_verifier'],
			'oauth_token' => $_REQUEST ['oauth_token'] 
		) );
		
		if ($XeroOAuth->response ['code'] == 200) {
			
			$response = $XeroOAuth->extract_params ( $XeroOAuth->response ['response'] );
			$session = persistSession ( $response );
			
			unset ( $_SESSION ['oauth'] );
			header ( "Location: {$here}" );
		} else {
			outputError ( $XeroOAuth );
		}
		// start the OAuth dance
	} elseif (isset ( $_REQUEST ['authenticate'] ) || isset ( $_REQUEST ['authorize'] )) {
		$params 	= array ( 'oauth_callback' => OAUTH_CALLBACK );
		$response 	= $XeroOAuth->request ( 'GET', $XeroOAuth->url ( 'RequestToken', '' ), $params, '', 'json' );
		
		if ($XeroOAuth->response ['code'] == 200) {
			$scope = "";
			// $scope = 'payroll.payrollcalendars,payroll.superfunds,payroll.payruns,payroll.payslip,payroll.employees,payroll.TaxDeclaration';
			if ($_REQUEST ['authenticate'] > 1)
				$scope = 'payroll.employees,payroll.payruns,payroll.timesheets';
			
			//print_r ( $XeroOAuth->extract_params ( $XeroOAuth->response ['response'] ) );
			$_SESSION ['oauth'] = $XeroOAuth->extract_params($XeroOAuth->response['response']);
			//print_r($_SESSION ['oauth']);
			$authurl = $XeroOAuth->url( "Authorize", '' )."?oauth_token={$_SESSION['oauth']['oauth_token']}&scope=".$scope;
			//echo '<p>To complete the OAuth flow follow this URL: <a href="' . $authurl . '">' . $authurl . '</a></p>';
			header ( "Location:".$authurl );
		} else {
			outputError ( $XeroOAuth );
		}
	}
	
	//testLinks ();
}

?>

