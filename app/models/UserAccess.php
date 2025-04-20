<?php
class UserAccess  extends Eloquent{
	
	public $timestamps = false;

	public static function getUserAccess()
	{
		$data 			= array();
		$session 		= Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId    = $session['group_users'];
        
        $details = UserAccess::where('user_id', '=', $user_id)->get();
        $crm = $tm = $ms = $sm = $mu = 0;
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		if(isset($value->access_id) && $value->access_id == 1){
        			$crm = 1;
        		}
        		if(isset($value->access_id) && $value->access_id == 2){
        			$tm = 1;
        		}
        		if(isset($value->access_id) && $value->access_id == 3){
        			$ms = 1;
        		}
        		if(isset($value->access_id) && $value->access_id == 4){
        			$sm = 1;
        		}
        		if(isset($value->access_id) && $value->access_id == 5){
        			$mu = 1;
        		}
        	}
        }
        $data['crm'] 	= $crm;
        $data['tm'] 	= $tm;
        $data['ms'] 	= $ms;
        $data['sm'] 	= $sm;
        $data['mu'] 	= $mu;

        return $data;
	}


}
