<?php
class JobsEmailClient extends Eloquent {

	public $timestamps = false;

	public static function getJobsEmailClient($client_id, $template_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = JobsEmailClient::whereIn('user_id', $groupUserId)->where('template_id', '=', $template_id)->where('client_id', '=', $client_id)->first();
		if(isset($details) && count($details) >0){
			$data['email_client_id'] 	= $details['email_client_id'];
			$data['user_id'] 			= $details['user_id'];
			$data['client_id'] 			= $details['client_id'];
			$data['repeat_days'] 		= $details['repeat_days'];
			$data['template_id'] 		= $details['template_id'];
			$data['template_name'] 		= $details['template_name'];
			$data['template_subject'] 	= $details['template_subject'];
			$data['template_message'] 	= $details['template_message'];
			$data['attachment'] 		= $details['attachment'];
			$data['email'] 				= explode(',', $details['email']);
			$data['created'] 			= $details['created'];
		}
		return $data;
		exit;
	}

}
