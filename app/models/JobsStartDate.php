<?php
class JobsStartDate extends Eloquent {

	public $timestamps = false;
	public static function getJobStartDaysByServiceId( $service_id )
	{
		$data = array();
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$dtls = JobsStartDate::whereIn("user_id",$groupUserId)->where("service_id",$service_id)->first();
		$days = 0;
		if(isset($dtls->days) && $dtls->days != ""){
			$days 	= $dtls->days;
		}
		
		return $days;
	}

	public static function getJobStartDetailsByServiceId( $service_id )
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = JobsStartDate::whereIn("user_id", $groupUserId)->where("service_id", "=", $service_id)->first();
		if(isset($details) && count($details) >0){
			$data['start_date_id'] 	= $details->start_date_id;
			$data['user_id'] 		= $details->user_id;
			$data['client_id'] 		= $details->client_id;
			$data['service_id'] 	= $details->service_id;
			$data['days'] 			= $details->days;
			$data['created'] 		= $details->created;
		}
		
		//print_r($data);
		return $data;
	}

}
