<?php
// remove first line above if you're not running these examples through PHP CLI


//https://context.io/docs/2.0/accounts/messages
include_once("class.contextio.php");

// see https://console.context.io/#settings to get your consumer key and consumer secret.
$contextIO = new ContextIO('cm04ldfm','WW7OBfIpAv9o5nZk');
//$contextIO = new ContextIO('2hxdun0e','4QirZCfQdO4nW52Z');
$accountId = null;

// list your accounts //
$r = $contextIO->listAccounts();
foreach ($r->getData() as $account) {
	echo "ID : ".$account['id'] . "<br>Email : " . join(", ", $account['email_addresses']) . "<br><br>";
	if (is_null($accountId)) {
		$accountId = $account['id'];//56b73867d7959b9a048b456b
	}
}

if (is_null($accountId)) {
	die;
}

// EXAMPLE 1
// Print the subject line of the last 20 emails sent to with bill@widgets.com
$args = array('to'=>'crm@i-practice.co.uk', 'limit'=>10);
echo "\nGetting last 10 messages exchanged with {$args['to']}<br><br>";
$r = $contextIO->listMessages($accountId, $args);
echo "<pre>";print_r($r->getData());die;
foreach ($r->getData() as $message) {
	echo "Subject: ".$message['subject']."<br><br>";
}

// EXAMPLE 2
// Download all versions of the last 2 attachments exchanged with bill@widgets.com
$saveToDir = dirname(__FILE__)."/".mt_rand(100,999);
mkdir($saveToDir);

$args = array('email'=>'anwarkhanmca786@gmail.com', 'limit'=>2);
echo "\nObtaining list of last two attachments exchanged with {$args['email']}<br><br>";
$r = $contextIO->listFiles($accountId, $args);
foreach ($r->getData() as $document) {
	echo "\nDownloading all versions of document \"".$document['file_name']."\"<br><br>";
	foreach ($document['occurrences'] as $attachment) {
		echo "Downloading attachment '".$attachment['file_name']."' to $saveToDir ... ";
		$contextIO->getFileContent($accountId, array('file_id'=>$attachment['fileId']), $saveToDir."/".$attachment['file_name']);
		echo "done\n";
	}
}

// EXAMPLE 3
// Download all attachments with a file name that matches 'creenshot'
$saveToDir = dirname(__FILE__)."/".mt_rand(100,999);
mkdir($saveToDir);

echo "\nDownloading all attachments matching 'creenshot'\n";
$args = array('file_name'=>'creenshot');
$r = $contextIO->listFiles($accountId, $args);
foreach ($r->getData() as $attachment) {
	echo "Downloading attachment '".$attachment['file_name']."' to $saveToDir ... ";
	$contextIO->getFileContent($accountId, array('file_id'=>$attachment['file_id']), $saveToDir."/".$attachment['file_name']);
	echo "done\n";
}

echo "\nall examples finished\n";
?>
