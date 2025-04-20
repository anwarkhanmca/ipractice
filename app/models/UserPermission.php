<?php
class UserPermission extends Eloquent {

	public $timestamps = false;
	public static function getUserPermission()
	{
		$data 			= array();
		$session 		= Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId    = $session['group_users'];

        $details = UserPermission::where('user_id', '=', $user_id)->get();
        $vr = $ecsl = $sa = $bk = $ct = $pds = $it = $ma = $car = 0;
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		if(isset($value->permission_id) && $value->permission_id == 1){
        			$vr = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 2){
        			$ecsl = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 3){
        			$sa = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 4){
        			$bk = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 5){
        			$ct = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 6){
        			$pds = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 7){
        			$it = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 8){
        			$ma = 1;
        		}
        		if(isset($value->permission_id) && $value->permission_id == 9){
        			$car = 1;
        		}
        	}
        }
        $data['vr'] 	= $vr;
        $data['ecsl'] 	= $ecsl;
        $data['sa'] 	= $sa;
        $data['bk'] 	= $bk;
        $data['ct'] 	= $ct;
        $data['pds'] 	= $pds;
        $data['it'] 	= $it;
        $data['ma'] 	= $ma;
        $data['car'] 	= $car;

        return $data;

	}
}
