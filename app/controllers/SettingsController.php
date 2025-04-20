<?php

class SettingsController extends BaseController {
	public function __construct()
	{
		parent::__construct();
	    $session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login')->send();
		}
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}
	}

	public function index() {
		$admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id']; //session user id

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		$data['heading'] 	= "SETTINGS";
		$data['title'] 		= "Settings Dashboard";
    $groupUserId 		= $admin_s['group_users'];
    
    $data['access'] 	= UserAccess::getUserAccess();
    
    $data['old_postion_types'] = Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "old")->orderBy("name")->get();
		$data['new_postion_types'] = Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();
        
    $data['custom_checklist']  = CustomChecklist::getAllCustomChecklist();
        
		return View::make('settings.index', $data);
	}

}
