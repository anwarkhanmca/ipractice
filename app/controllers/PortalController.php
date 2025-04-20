<?php
//opcache_reset ();
//Cache::forget('user_list');

class PortalController extends BaseController{
    public function __construct()
    {
        parent::__construct();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        if (empty($user_id)) {
            Redirect::to('/login')->send();
        }
        if (isset($session['user_type']) && $session['user_type'] == "C") {
            Redirect::to('/client-portal')->send();
        }
    }
    
     public function adminportal(){
        
        $data['heading'] = "Admin Portal";
		$data['title'] = "Admin Portal";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];
        //die('adadad');
        return View::make('adminprotal', $data);
    }

}
