<?php
class EthnicOrigin  extends Eloquent{
	
	public $timestamps = false;
	public static function getDetails()
	{
		$data = array();
		$details = EthnicOrigin::get();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $details1) {
				$data[$key]['ethnic_id'] 	= $details1->ethnic_id;
				$data[$key]['ethnic_name'] 	= $details1->ethnic_name;
			}
		}
		return $data;
	}

	public static function getNameById()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $ret_value = "";
        $details        = EthnicOrigin::select('ethnic_name')->first();
        if(isset($details['ethnic_name']) && $details['ethnic_name'] != "")
            $ret_value = $details['ethnic_name'];
        return $ret_value;
    }
	

}
