<?php
class JobsStaffFilter extends Eloquent {

	public static function getFilteredStaffByServiceId($service_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$value = JobsStaffFilter::where("user_id", $user_id)->where('service_id', $service_id)->first();
		if(isset($value) && count($value) >0)
		{
			$data['staff_filter_id'] 	= $value->staff_filter_id;
			$data['user_id'] 			= $value->user_id;
			$data['service_id'] 		= $value->service_id;
			$data['filtered_staff_id'] 	= $value->filtered_staff_id;
			$data['created'] 			= $value->created;
		}
		return $data;
	}


	public static function getStaffIdByServiceId($service_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $staff_id = 'all';
    $details = JobsStaffFilter::where("user_id", $user_id)->where('service_id',$service_id)
    							->select('filtered_staff_id')->first();
    if(isset($details->filtered_staff_id) && $details->filtered_staff_id != ''){
        $staff_id = $details->filtered_staff_id;
    }
    return $staff_id;
  }

}
