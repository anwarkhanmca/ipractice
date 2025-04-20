<?php
class CustomChecklist extends Eloquent{
	
	public $timestamps = false;

	public static function getAllChecklistById( $id )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details = CustomChecklist::whereIn("user_id", $groupUserId)->where('custom_check_id', '=', $id)->first();
        
        return CustomChecklist::getSingleArray($details);
    }
    
    public static function getAllCustomChecklist()
    {
    	$data = array();
    	$session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details = CustomChecklist::whereIn("user_id", $groupUserId)->get();
        return CustomChecklist::getArray($details);
    }
    
    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
        	$data['custom_check_id']  = $value->custom_check_id;
            $data['user_id']          = $value->user_id;
            $data['custom_name']      = $value->custom_name;
            $data['created']          = date('d-m-Y', strtotime($value->created));
        }
        return $data;
    }
    
    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$data[$key]['custom_check_id']  = $value->custom_check_id;
        		$data[$key]['user_id']          = $value->user_id;
        		$data[$key]['custom_name']      = $value->custom_name;
        		$data[$key]['created']          = date('d-m-Y', strtotime($value->created));
        	}
        }
        return $data;
    }


}
