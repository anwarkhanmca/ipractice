<?php
class JobsAutosendEmail extends Eloquent {

	public $timestamps = false;
	public static function getJobsAutosendEmailByServiceId( $service_id )
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = JobsAutosendEmail::whereIn("user_id", $groupUserId)->where("service_id", "=", $service_id)->first();
		if(isset($details) && count($details) >0){
			$data['autosend_id'] 	= $details->autosend_id;
			$data['user_id'] 		= $details->user_id;
			$data['service_id'] 	= $details->service_id;
			$data['template_id'] 	= $details->template_id;
			$data['days'] 			= $details->days;
			$data['deadline'] 		= $details->deadline;
			$data['remind_days'] 	= $details->remind_days;
			$data['created'] 		= $details->created;
		}
		
		//print_r($data);
		return $data;
	}

	

}
