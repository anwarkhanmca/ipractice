<?php
class TaskTableHeading  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;
	public static function getHeadingName($service_id)
	{
		$details 	= array();
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

		$value = TaskTableHeading::whereIn("user_id", $groupUserId)->where('service_id', '=', $service_id)->first();
		
		if(isset($value) && count($value) >0){
        	$details['heading_id'] 		= $value->heading_id;
            $details['user_id'] 		= $value->user_id;
            $details['service_id'] 		= $value->service_id;
            $details['step_id'] 		= $value->step_id;
            $details['heading'] 		= $value->heading;
            $details['field_type'] 		= $value->field_type;
            $details['select_option'] 	= $value->select_option;
            $details['created'] 		= $value->created;
        }
        //print_r($details);die;
        return $details;
	}

}
