<?php
class Checklist extends Eloquent{
	
	public $timestamps = false;

	public static function getAllChecklistTypeById( $id )
    {
        return Checklist::select("*")->where("checklist_id", $id)->get();
    }
    
    public static function getAllChecklistByCheckId( $custom_check_id )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details        = Checklist::whereIn("user_id", $groupUserId)->where('custom_check_id', '=', $custom_check_id)->get();
        
        return Checklist::getArray($details);
    }

    public static function getChecklistByCheckId( $checklist_id )
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = Checklist::where('checklist_id', '=', $checklist_id)->first();
        
        return Checklist::getSingleArray($details);
    }

    public static function get_checklist_by_client_id( $client_id )
    {
    	$data = array();
    	$session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details = Checklist::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->get();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$data[$key]['checklist_id']     = $value->checklist_id;
        		$data[$key]['custom_check_id'] 	= $value->custom_check_id;
                $data[$key]['user_id']          = $value->user_id;
        		$data[$key]['client_id']        = $value->client_id;
        		$data[$key]['name']             = $value->name;
        		$data[$key]['status']           = $value->status;
                $data[$key]['created']          = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        	}
        }
        return $data;
    }

    public static function get_checklist()
    {
    	$data = array();
    	$session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details = Checklist::whereIn("user_id", $groupUserId)->get();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$data[$key]['checklist_id']     = $value->checklist_id;
                $data[$key]['custom_check_id'] 	= $value->custom_check_id;
        		$data[$key]['user_id']          = $value->user_id;
        		$data[$key]['client_id']        = $value->client_id;
        		$data[$key]['name']             = $value->name;
        		$data[$key]['status']           = $value->status;
                $data[$key]['created']          = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        	}
        }
        return $data;
    }
    
    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$data[$key]['checklist_id']     = $value->checklist_id;
                $data[$key]['custom_check_id'] 	= $value->custom_check_id;
        		$data[$key]['user_id']          = $value->user_id;
        		$data[$key]['client_id']        = $value->client_id;
        		$data[$key]['name']             = $value->name;
        		$data[$key]['status']           = $value->status;
                $data[$key]['created']          = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        	}
        }
        return $data;
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data['checklist_id']     = $value->checklist_id;
            $data['custom_check_id']  = $value->custom_check_id;
            $data['user_id']          = $value->user_id;
            $data['client_id']        = $value->client_id;
            $data['name']             = $value->name;
            $data['status']           = $value->status;
            $data['created']          = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        }
        return $data;
    }


}
