<?php
class StaffmanagementController extends BaseController {
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
    
  public function staff_management()
  {
    $data['heading'] 	= "STAFF MANAGEMENT";
		$data['title'] 		= "Staff Management";

		$details  = HolidayDetail::getHolidayDetails();
		if(isset($details['holiday_date']) && $details['holiday_date'] != ""){
			$start_date = explode('-', $details['holiday_date']);
			$data['start_date'] = $start_date[0].'-'.$start_date[1].'-'.date('Y');
		}else{
			$data['start_date'] = "new";
		}
    
    return View::make('staff.staffmanagement',$data);
  }





}
