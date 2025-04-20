<?php
class MaritalStatus  extends Eloquent{
	
	public $timestamps = false;
	public static function getDetails()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
        $data = array();
    	$details = MaritalStatus::get();
        if(isset($details) && count($details)){
            foreach ($details as $key => $value) {
            	$data[$key]['marital_status_id'] 	= $value->marital_status_id;
            	$data[$key]['status_name'] 		= $value->status_name;
            }
        }
        return $data;
    }

    public static function getMeritalIdByName($name)
    {
        $id = '';
    	$details = MaritalStatus::where('status_name', '=', $name)->first();
        if(isset($details) && count($details)){
            $id 	= $details['marital_status_id'];
        }
        return $id;
    }

    public static function getMeritalNameById($id)
    {
        $status_name = '';
        $details = MaritalStatus::where('marital_status_id', '=', $id)->first();
        if(isset($details) && count($details)){
            $status_name     = $details['status_name'];
        }
        return $status_name;
    }
	

}
