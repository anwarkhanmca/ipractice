<?php
class TaskClientReminder extends Eloquent {

	public $timestamps = false;

	public static function getDetailsByServiceId( $service_id )
    {
    	$data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
        $details = TaskClientReminder::whereIn('user_id', $groupUserId)->where("service_id", '=', $service_id)->first();
        if(isset($details) && count($details) >0){
            $data['id']            = $details->id;
            $data['user_id']       = $details->user_id;
            $data['service_id']    = $details->service_id;
            $data['deadline']      = $details->deadline;
            $data['taskstatus']    = $details->taskstatus;
            $data['created']       = $details->created;
		}
		return $data;
    }

}
