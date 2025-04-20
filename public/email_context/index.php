<?php
//consumer key and consumer secret
function getDateFormat($time)
{
	$ret_date = 0;
	$current_time = time();
	$remain_time = $current_time-$time;
	if($remain_time < 5*60*60){
		$ret_date = date('h:i a', $remain_time);
	}else{
		$ret_date = date('M d', $remain_time);
	}
	return $ret_date;
}

include_once("class.contextio.php");
//anwarkhanmca786@gmail.com
//$contextIO = new ContextIO('cm04ldfm','WW7OBfIpAv9o5nZk');

//crm@i-practice.co.uk
$contextIO = new ContextIO('2hxdun0e','4QirZCfQdO4nW52Z');
$accountId = '590db2b4045cd73f2450e3c2';

// list your accounts //
$r = $contextIO->listAccounts();
foreach ($r->getData() as $account) {
	//echo "ID : ".$account['id'] . "<br>Email : " . join(", ", $account['email_addresses']) . "<br><br>";
	//ID : 56cefd300eeeb190598b4567
	//Email : ipracticeuk@gmail.com
	if (is_null($accountId)) {
		$accountId = $account['id'];
	}
}

if (is_null($accountId)) {
	die;
}

// Print the subject line of the last 10 emails sent to with bill@widgets.com
$args = array('folder'=>'Inbox', 'include_flags'=>1, 'include_thread_size'=>1, 'include_body'=>1, 'limit'=>10);



//$args = array('to'=>'crm@i-practice.co.uk', 'limit'=>10);
//$args = array('to'=>'anwarkalemee786@yahoo.com', 'limit'=>10);
$r = $contextIO->listMessages($accountId, $args);

$data = array();
foreach ($r->getData() as $key=>$message) {
	$data[$key]['from_name'] = isset($message['addresses']['from']['name'])?$message['addresses']['from']['name']:'';
	$data[$key]['from_email']= isset($message['addresses']['from']['email'])?$message['addresses']['from']['email']:'';
	$data[$key]['to_email']  = isset($message['addresses']['to'][0]['email'])?$message['addresses']['to'][0]['email']:'';
	$data[$key]['subject'] 	 = isset($message['subject'])?$message['subject']:'';
	$data[$key]['send_date'] = $message['date'];
	$data[$key]['date'] 	 = getDateFormat($message['date']);
	$data[$key]['body'] 	 = isset($message['body'][0]['content'])?$message['body'][0]['content']:'';
	$data[$key]['files'] 	 = isset($message['files'])?$message['files']:'';
}

//echo "<pre>";print_r($r->getData());die;
echo json_encode($data);

?>
