<?php
//echo date('d-m-Y H:i:s', '1494057148');die;

include('../../app/library/ContextEmail.php');
include('../file-and-sign/connect.php');

//$session = ContextEmail::get_session();
//$user_id = $session['id'];
//echo '<pre>';print_r($session);die;

//consumer key and consumer secret
function getDateFormat($time)
{
	$ret_date = 0;
	$current_time = time();
	$remain_time = $current_time-$time;
	if($remain_time < 5*60*60){
		$ret_date = date('h:i:s', $remain_time);
	}else{
		$ret_date = date('M d', $remain_time);
	}
	return $ret_date;
}

include_once("class.contextio.php");

//anwarkhanmca786@gmail.com
//$contextIO = new ContextIO('cm04ldfm','WW7OBfIpAv9o5nZk');

//crm@i-practice.co.uk/manager02
$contextIO = new ContextIO('2hxdun0e','4QirZCfQdO4nW52Z');
//$contextIO = new ContextIO('phcohugq','t5TyjNSdGDFJIZRK');
//$accountId = null;
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

$d = array();
foreach ($r->getData() as $k=>$m) {
	$d[$k]['from_name'] 	= isset($m['addresses']['from']['name'])?$m['addresses']['from']['name']:'';
	$d[$k]['from_email'] 	= isset($m['addresses']['from']['email'])?$m['addresses']['from']['email']:'';
	$d[$k]['to_email']  	= isset($m['addresses']['to'][0]['email'])?$m['addresses']['to'][0]['email']:'';
	$d[$k]['subject'] 	 	= isset($m['subject'])?$m['subject']:'';
	$d[$k]['sent_time'] 	= $m['date'];
	$d[$k]['taskdate'] 		= date('Y-m-d', $m['date']);
	$d[$k]['task_time'] 	= date('H:i:s', $m['date']);
	$d[$k]['body'] 	 		= isset($m['body'][0]['content'])?$m['body'][0]['content']:'';
	$d[$k]['files'] 	 	= isset($m['files'])?$m['files']:'';
}

//echo "<pre>";print_r($r->getData());//die;
//echo "<pre>";print_r($d);die;

$count = ContextEmail::saveDataTodoList($d);
//$data['is_viewed'] = $count;
//echo json_encode($data);
echo $count;
exit;
//die('End');
//echo json_encode($d);

?>
