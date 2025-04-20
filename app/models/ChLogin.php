<?php
class ChLogin extends Eloquent {

	public $timestamps = false;
	public static function getDetails()
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = ChLogin::whereIn("user_id", $groupUserId)->first();
        if(isset($details) && count($details) >0 )
        {
    		$data['ch_login_id'] 	= $details['ch_login_id'];
    		$data['user_id'] 		= $details['user_id'];
    		$data['practice_id'] 	= $details['practice_id'];
    		$data['email'] 			= $details['email'];
    		$data['password'] 		= $details['password'];
    		$data['presenter_id'] 	= $details['presenter_id'];
    		$data['auth_code'] 		= $details['auth_code'];
    		$data['created'] 		= $details['created'];
        }
        return $data;
	}

	public static function getDetailsByPracticeId($practice_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = ChLogin::where('practice_id', '=', $practice_id)->whereIn("user_id", $groupUserId)->first();//print_r($details);die;
        if(isset($details) && count($details) >0 )
        {
    		$data['ch_login_id'] 	= $details['ch_login_id'];
    		$data['user_id'] 		= $details['user_id'];
    		$data['practice_id'] 	= $details['practice_id'];
    		$data['email'] 			= $details['email'];
    		$data['password'] 		= $details['password'];
    		$data['presenter_id'] 	= $details['presenter_id'];
    		$data['auth_code'] 		= $details['auth_code'];
    		$data['created'] 		= $details['created'];
        }
        return $data;
	}

}
