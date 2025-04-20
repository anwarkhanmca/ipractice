<?php
class OnboardAutosendDay extends Eloquent {

	public $timestamps = false;
	public static function get_onboard_autosend()
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = OnboardAutosendDay::whereIn('user_id', $groupUserId)->first();
        if(isset($details) && count($details) >0){
            $data['autosend_id'] 	= $details['autosend_id'];
            $data['user_id'] 		= $details['user_id'];
            $data['client_id']      = $details['client_id'];
            $data['days'] 			= $details['days'];
            $data['notes']          = $details['notes'];
            $data['created'] 		= $details['created'];
        }
        return $data;
	}

	public static function get_owner_autosend_days()
	{
		$days = "";
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = OnboardAutosendDay::whereIn('user_id', $groupUserId)->first();
        if(isset($details) && count($details) >0){
            $days	= $details['days'];
        }
        return $days;
	}

    public static function getDetailsByClientId($client_id)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = OnboardAutosendDay::whereIn('user_id',$groupUserId)->where('client_id','=',$client_id)->first();
        if(isset($details) && count($details) >0){
            $data['autosend_id']    = $details['autosend_id'];
            $data['user_id']        = $details['user_id'];
            $data['client_id']      = $details['client_id'];
            $data['days']           = $details['days'];
            $data['notes']          = $details['notes'];
            $data['created']        = $details['created'];
        }
        return $data;
    }



}
