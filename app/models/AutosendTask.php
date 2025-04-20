<?php
class AutosendTask extends Eloquent {

	public $timestamps = false;

	public static function getDetailsByServiceId( $service_id, $purpose )
	{
		$data = array();
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$details = AutosendTask::whereIn("user_id", $groupUserId)->where('service_id', $service_id)->where('purpose', $purpose)->first();
		if(isset($details) && count($details) >0){
			$data['autosend_id'] 	= $details->autosend_id;
			$data['user_id'] 			= $details->user_id;
			$data['service_id'] 	= $details->service_id;
			$data['days'] 				= $details->days;
			$data['staff_filter'] = $details->staff_filter;
			$data['created'] 			= $details->created;
		}
		//print_r($data);die;
		return $data;
	}

	public static function getDaysByServiceId( $service_id, $purpose )
	{
		$data = 0;
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$details = AutosendTask::whereIn("user_id", $groupUserId)->where('service_id', $service_id)->where('purpose', $purpose)->first();
		if(isset($details->days) && $details->days != ""){
			$data 	= $details->days;
		}
		//echo $data;
		return $data;
	}

	public static function checkAutoSendByServiceId( $service_id, $purpose )
	{
		$count = AutosendTask::where('service_id', $service_id)->where('purpose', $purpose)->count();
		return $count;
	}

	public static function getCronDetailsByServiceId( $service_id, $purpose )
	{
		$data = array();
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$details = AutosendTask::where('service_id', $service_id)->where('purpose', $purpose)->where('days', 1)->get();
		if(isset($details) && count($details) >0){
			foreach ($details as $k => $v){
				$data[$k]['autosend_id'] 	= $v->autosend_id;
				$data[$k]['user_id'] 			= $v->user_id;
				$data[$k]['group_id'] 		= $v->group_id;
				$data[$k]['service_id'] 	= $v->service_id;
				$data[$k]['days'] 				= $v->days;
				$data[$k]['staff_filter'] = $v->staff_filter;
				$data[$k]['created'] 			= $v->created;
			}
		}
		//print_r($data);die;
		return $data;
	}

}
