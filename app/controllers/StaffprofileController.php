<?php
class StaffprofileController extends BaseController {
	public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)){
            Redirect::to('/login')->send();
        }
    }

	public function dashboard() {
		$session = Session::get('admin_details');
		$data['user_id'] = $session['id'];
		$data['user_type'] = $session['user_type'];
		$data['heading'] = "STAFF PROFILE";
		$data['title'] = "Staff Profile";

		if (!isset($data['user_id']) && $data['user_id'] == "") {
			return Redirect::to('/');
		} else
		if (isset($data['user_type']) && $data['user_type'] == "C") {
			return Redirect::to('/invitedclient-dashboard');
		}

		$details  = HolidayDetail::getHolidayDetails();
		if(isset($details['holiday_date']) && $details['holiday_date'] != ""){
			$start_date = explode('-', $details['holiday_date']);
			$data['start_date'] = $start_date[0].'-'.$start_date[1].'-'.date('Y');
		}else{
			$data['start_date'] = "new";
		}

		return View::make('staff.profile.profiledashboard', $data);
	}

	public function my_details($user_id, $type_id) 
	{ 
		$data 				= array();
		$data['page_name'] 	= base64_decode($type_id);
		$session 			= Session::get('admin_details');
		$data['user_id'] 	= $session['id'];
		$data['user_type'] 	= $session['user_type'];
		$groupUserId 		= $session['group_users'];
		$groupUsers 		= Common::getGroupUser();
		if(!in_array($user_id, $groupUsers)){
			Redirect::to('/admin-logout')->send();
		}
		//echo "<pre>";print_r($groupUsers);die;

		//echo $data['page_name'];die;

		$data['heading'] 	= "";
		$data['title'] 		= "My Details";

		if ($data['page_name'] == "profile") {
			$data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
		} else {
			$data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
		}

		$data['titles'] = Title::orderBy("title_id")->get();
		$data['marital_status'] = MaritalStatus::orderBy("marital_status_id")->get();
		$data['countries'] = Country::orderBy('country_name')->get();
		$data['nationalities'] = Nationality::get();

		$data['old_postion_types'] = Position::whereIn("user_id", $groupUserId)->where("status", "=", "old")->orderBy("name")->get();
		$data['new_postion_types'] = Position::whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();

		$data['old_department_types'] = Department::whereIn("user_id", $groupUserId)->where("status", "=", "old")->orderBy("name")->get();
		$data['new_department_types'] = Department::whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();

		if (!isset($data['user_id']) && $data['user_id'] == "") {
			return Redirect::to('/');
		} else
		if (isset($data['user_type']) && $data['user_type'] == "C") {
			return Redirect::to('/invitedclient-dashboard');
		}

		$data['staff_id'] 			= $user_id;
		$data['staff_details'] 	= $this->userDetailsByUserId($user_id);
		$data['ethnic_origin'] 	= EthnicOrigin::getDetails();

		/* ============= Profile Image ========== */
    $files = ClientFile::where('client_id', "=", $user_id)->first();
    if (isset($files['profile_photo']) && $files['profile_photo'] != '') {
        $data['photo'] = $files['profile_photo'];
    }

    $data['body_details'] = ProfessionalBody::getDetails();

		//echo '<pre>';print_r($data['staff_details']);die;
		return View::make("staff.profile.my_details", $data);
	}

	public function userDetailsByUserId($user_id) {

		$data = array();
		$step_data = array();

		$details = User::where("user_id", "=", $user_id)->first();
		//die();

		if (isset($details) && count($details) > 0) {
			//echo 'adadada';
			$fname = "";
			$lname = "";
			if (isset($details['fname']) && $details['fname'] != "") {
				$fname .= $details['fname'];
			}
			if (isset($details['lname']) && $details['lname'] != "") {
				$lname .= $details['lname'];
			}
			$staff_name = $fname . " " . $lname;
			$data['initial_badge'] = App::make('ClientController')->get_initial_badge($staff_name);
			$data['staff_name'] = $staff_name;
			$data['parent_id'] = $details['parent_id'];
			$data['group_id'] = $details['group_id'];
			$data['client_id'] = $details['client_id'];
			$data['email'] = $details['email'];
			$data['password'] = $details['password'];
			$data['phone'] = $details['phone'];
			$data['user_type'] = $details['user_type'];
			$data['status'] = $details['status'];
			$data['website'] = $details['website'];
			$data['fname'] = $details['fname'];
			$data['lname'] = $details['lname'];
			$data['country'] = $details['country'];
			$data['created'] = $details['created'];
			$data['ent_days'] = StaffHoliday::getEntitlementDays($user_id);

			$fields = StepsFieldsStaff::where("staff_id", "=", $user_id)->get();
			// echo $this->last_query();
			//die();
			if (isset($fields) && count($fields) > 0) {
				foreach ($fields as $value) {

					$step_data[$value['field_name']] = $value->field_value;
				}
			}

			$data['step_data'] = $step_data;
		}
		 //echo '<pre>';print_r($step_data);die();

		$step_ids = array();

		$fields_staffid = StepsFieldsStaff::where("staff_id", "=", $user_id)->where("field_name",
			"=", "stafffile1")->orWhere("field_name", "=", "stafffile2")->orWhere("field_name",
			"=", "stafffile3")->orWhere("field_name", "=", "stafffile4")->select('field_id',
			'field_name')->get();

		//echo $this->last_query();
		foreach ($fields_staffid as $value) {

			$step_ids[$value['field_name']] = $value->field_id;

		}

		$data['step_staffids'] = $step_ids;

		$step_profids = array();
		$fields_profid = StepsFieldsStaff::where("staff_id", "=", $user_id)->where("field_name",
			"=", "profilefile1")->orWhere("field_name", "=", "profilefile2")->orWhere("field_name",
			"=", "profilefile3")->orWhere("field_name", "=", "profilefile4")->select('field_id',
			'field_name')->get();

		//echo $this->last_query();
		foreach ($fields_profid as $value) {

			$step_profids[$value['field_name']] = $value->field_id;

		}
		$data['step_profids'] = $step_profids;

		return $data;
	}

	public function user_details_process()
	{  
		$data 		= array();
		$userData = array();
		$arrData 	= array();

		$session 	= Session::get('admin_details');
		$user_id 	= $session['id'];
		

		$postData = Input::all();

		/*===================================*/
		$data['ent_days'] = !empty($postData['holiday_entitlement'])?$postData['holiday_entitlement']:'';
		StaffHoliday::where('staff_id', $postData['staff_id'])->update($data);
		/*===================================*/
		$data['user_id'] 		= $session['id'];
		$data['user_type'] 	= $session['user_type'];
		StepsFieldsStaff::storeUpdatingStaffData($postData);

		// update for user table
		if (!empty($postData['fname'])) {
			$userData['fname'] = $postData['fname'];
		}
		if (!empty($postData['lname'])) {
			$userData['lname'] = $postData['lname'];
		}
		if (!empty($postData['email'])) {
			$userData['email'] = $postData['email'];
		}

		$userprof_update = User::where("user_id", $postData['staff_id'])->update($userData);

		$staff_id = $postData['staff_id'];

		$result = StepsFieldsStaff::where("staff_id", $staff_id)->get();

		StepsFieldsStaff::where("staff_id", $staff_id)->where("field_name", "!=",
			"stafffile1")->where("field_name", "!=", "stafffile2")->where("field_name",
			"!=", "stafffile3")->where("field_name", "!=", "stafffile4")->where("field_name", "!=",
			"profilefile1")->where("field_name", "!=", "profilefile2")->where("field_name",
			"!=", "profilefile3")->where("field_name", "!=", "profilefile4")->delete();
		//echo $this->last_query();die;
		//################ GENERAL SECTION START #################//

		$step_id = 1;
		if (!empty($postData['title'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'title', $postData['title']);
		}
		if (!empty($postData['mname'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'mname', $postData['mname']);
		}

		if (!empty($postData['gender'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'gender', $postData['gender']);
		}
		if (!empty($postData['dob'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'dob', $postData['dob']);
		}
		if (!empty($postData['marital_status'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'marital_status',
				$postData['marital_status']);
		}

		if (!empty($postData['nationality'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'nationality', $postData['nationality']);
		}

		if (!empty($postData['country'])) {
			$arrData[] = $this->save_profile($user_id,$staff_id,$step_id,'country',$postData['country']);
		}
		if (!empty($postData['position_type'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'position_type', $postData['position_type']);
		}
		if (!empty($postData['ni_number'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'ni_number', $postData['ni_number']);
		}
		if (!empty($postData['ethnic_origin'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'ethnic_origin', $postData['ethnic_origin']);
		}
		if (!empty($postData['tax_reference'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'tax_reference',
				$postData['tax_reference']);
		}

		if (!empty($postData['professional_body'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'professional_body', $postData['professional_body']);
		}

		if (!empty($postData['student_number'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'student_number',
				$postData['student_number']);
		}

		//echo '<pre>';print_r($arrData);die();
		//################ GENERAL SECTION START #################//

		//################ Contact info START #################//
		$step_id = 2;
		if (!empty($postData['address1'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'res_addr_line1', $postData['address1']);
		}

		if (!empty($postData['address2'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'res_addr_line2',
				$postData['address2']);
		}
		if (!empty($postData['address_city'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'res_city', $postData['address_city']);
		}

		if (!empty($postData['address_county'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'res_county', $postData['address_county']);
		}

		if (!empty($postData['address_postcode'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'res_postcode',
				$postData['address_postcode']);
		}

		if (!empty($postData['address_country'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'res_country', $postData['address_country']);
		}

		if (!empty($postData['serv_tele_code'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'serv_tele_code',
				$postData['serv_tele_code']);
		}
		if (!empty($postData['serv_telephone'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'serv_telephone',
				$postData['serv_telephone']);
		}

		if (!empty($postData['serv_mobile_code'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id,
				'serv_mobile_code', $postData['serv_mobile_code']);
		}

		if (!empty($postData['serv_mobile'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'serv_mobile', $postData['serv_mobile']);
		}
		if (!empty($postData['skype'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'skype', $postData['skype']);
		}

		if (!empty($postData['emer_name'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'emer_name', $postData['emer_name']);
		}
		if (!empty($postData['emer_telephone'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'emer_telephone',
				$postData['emer_telephone']);
		}
		if (!empty($postData['emer_mobile'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'emer_mobile', $postData['emer_mobile']);
		}

		//echo '<pre>';print_r($arrData);die();
		//################ Contact Info START #################//

		//################ emp START #################//
		$step_id = 3;
		if (!empty($postData['start_date'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'start_date', $postData['start_date']);
		}

		if (!empty($postData['holiday_entitlement'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id,
				'holiday_entitlement', $postData['holiday_entitlement']);
		}

		if (!empty($postData['salary'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'salary', $postData['salary']);
		}

		if (!empty($postData['department'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'department', $postData['department']);
		}
		if (!empty($postData['res_country'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'res_country', $postData['res_country']);
		}

		if (!empty($postData['qualifications'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'qualifications',
				$postData['qualifications']);
		}

		if (!empty($postData['end_date'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'end_date',
				$postData['end_date']);
		}

		//################ Emp START #################//

		//################ Other START #################//
		$step_id = 4;
		if (!empty($postData['bank_name'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'bank_name', $postData['bank_name']);
		}

		if (!empty($postData['short_code'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'short_code', $postData['short_code']);
		}

		if (!empty($postData['acc_no'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'acc_no', $postData['acc_no']);
		}

		if (!empty($postData['note'])) {
			$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'note', $postData['note']);
		}

		//################ Other START #################//

		// ################# File upload in the other section start ############### //
		for ($i = 1; $i <= 4; $i++) {
			if (($postData['page_name']) == "staff") {
				if (Input::hasFile('stafffile' . $i)) {
					$file = Input::file('stafffile' . $i);
					$destinationPath = "uploads/stafffile/";
					$fileName = Input::file('stafffile' . $i)->getClientOriginalName();

					$result = Input::file('stafffile' . $i)->move($destinationPath, $fileName);

					$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'stafffile' . $i,
						$fileName);

					//ClientFile::where("client_file_id", "=", $client_file_id)->update($file_data);

					### delete the previous image if exists ###
					/*  if (isset($file_details['stafffile' . $i]) && $file_details['stafffile' . $i] !=
					"") {
					$prevPath = "uploads/stafffile/" . $file_details['stafffile' . $i];
					if (file_exists($prevPath)) {
					unlink($prevPath);
					}
					} */

					### delete the previous image if exists ###
				} else {
					if (isset($postData['oldstafffile' . $i]) && $postData['oldstafffile' . $i] != "") {
						$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'stafffile' . $i,
							$postData['oldstafffile' . $i]);
					}
				}

			} else {
				if (Input::hasFile('profilefile' . $i)) {
					$file = Input::file('profilefile' . $i);
					$destinationPath = "uploads/profilefile/";
					$fileName = Input::file('profilefile' . $i)->getClientOriginalName();
					//$fileName = $fileName;
					$result = Input::file('profilefile' . $i)->move($destinationPath, $fileName);

					$file_data['profilefile' . $i] = $fileName;

					$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'profilefile' .
						$i, $fileName);

					//ClientFile::where("client_file_id", "=", $client_file_id)->update($file_data);

					### delete the previous image if exists ###
					/*  if (isset($file_details['profilefile' . $j]) && $file_details['profilefile' . $j] !=
					"") {
					$prevPath = "uploads/profilefile/" . $file_details['profilefile' . $j];
					if (file_exists($prevPath)) {
					unlink($prevPath);
					}
					} */

					### delete the previous image if exists ###

				} else {
					if (isset($postData['oldprofilefile' . $i]) && $postData['oldprofilefile' . $i] != "") {
						$arrData[] = $this->save_profile($user_id, $staff_id, $step_id, 'profilefile' . $i, $postData['oldprofilefile' . $i]);
					}
				}
			}

		}

		$file_details = ClientFile::where('client_id', "=", $staff_id)->first();
    if (isset($file_details) && count($file_details) > 0) {
        $client_file_id = $file_details['client_file_id'];
    } else {
        $file_data['client_id'] = $staff_id;
        $client_file_id = ClientFile::insertGetId($file_data);
    }
		if($user_id == $staff_id){
      if (Input::hasFile('profile_photo')) {
        $file = Input::file('profile_photo');
        $destinationPath = "uploads/profile_photo/";
        $fileName   = Input::file('profile_photo')->getClientOriginalName();
        $fileName   = time().'_'.$fileName;
        $result     = Input::file('profile_photo')->move($destinationPath,$fileName);

        $file_data['profile_photo'] = $fileName;
        ClientFile::where("client_file_id","=",$client_file_id)->update($file_data);

        ### delete the previous image if exists ###
        if(isset($file_details['profile_photo'])&&$file_details['profile_photo']!='')
        {
          $prevPath = "uploads/profile_photo/" . $file_details['profile_photo'];
          if (file_exists($prevPath)) {
            unlink($prevPath);
          }
        }

        ### delete the previous image if exists ###
      } else {
				if(isset($postData['old_profile_photo']) && $postData['old_profile_photo'] != ""){
					$arrData[] = $this->save_profile($user_id, $staff_id, 1, 'profile_photo', $postData['old_profile_photo']);
				}
			}
    }
		// ################# File upload in the other section end ############### //

		StepsFieldsStaff::insert($arrData);

		if (isset($postData['photo_save'])) {
			return Redirect::to('/my-details/'.$staff_id.'/'.base64_encode($postData['page_name']));
		}else{
			if($postData['page_name'] == 'profile'){
				return Redirect::to('/staff-profile');
			}else{
				return Redirect::to('/staff-details');
			}
		}
		
	}

	public function save_profile($user_id, $staff_id, $step_id, $field_name, $field_value) 
	{
		$data = array();
		$data['user_id'] = $user_id;
		$data['staff_id'] = $staff_id;
		$data['step_id'] = $step_id;
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		return $data;
		//OrganisationClient::insert($data);
	}

	public function delete_stafffile() {
		$user_id 		= Input::get("del_id");
		$field_name = StepsFieldsStaff::where("field_id", "=", $user_id)->select('field_name')->first();

		echo $field_name['field_name'];

		StepsFieldsStaff::where("field_id", $user_id)->delete();

	}
	public function add_position_type() {
		$session_data = Session::get('admin_details');

		$data['name'] = Input::get("org_name");
		$data['user_id'] = $session_data['id'];
		$data['status'] = "new";
		$insert_id = Position::insertGetId($data);
		echo $insert_id;exit();
		//return Redirect::to('/organisation/add-client');

	}

	public function add_department_type() {
		$session_data = Session::get('admin_details');

		$data['name'] = Input::get("dept_name");
		$data['user_id'] = $session_data['id'];
		$data['status'] = "new";
		$insert_id = Department::insertGetId($data);
		echo $insert_id;exit();
		//return Redirect::to('/organisation/add-client');

	}

	public function delete_position_type() {
		$field_id = Input::get("field_id");
		if (Request::ajax()) {
			$data = Position::where("position_id", $field_id)->delete();
			echo $data;
		}
	}

	public function delete_department_type() {
		$field_id = Input::get("field_id");
		if (Request::ajax()) {
			$data = Department::where("department_id", "=", $field_id)->delete();
			echo $data;
		}
	}
	public function getstaffholidays() {
		$staff_id = Input::get("client_id");
		if (Request::ajax()) {
			$data = StepsFieldsStaff::where("staff_id", "=", $staff_id)->where("field_name", "=", "holiday_entitlement")->select('field_value')->first();
			echo $data;
		}
	}

	public function to_list($page_open) 
	{
	   
    $data = array();
    $data['goto_url']	= "/profile/to-list";
		$data['page_open'] 	= $page_open; //base64_decode($page_open);
		$session = Session::get('admin_details');
		$data['user_id'] = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];
		$group_id = $session['group_id']; 
		$data['group_id']=$group_id;
		$data['heading'] = "TO DO LIST"; 
		$data['title'] = "To Do List";
		$data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
    $data['allClients'] = App::make("HomeController")->get_all_clients();
    $data['staff_details'] = User::whereIn("user_id", $groupUserId)->where("client_id", 0)->select("user_id", "fname", "lname")->get();
		if (!isset($data['user_id']) && $data['user_id'] == "") {
			return Redirect::to('/');
		} else
		if (isset($data['user_type']) && $data['user_type'] == "C") {
			return Redirect::to('/invitedclient-dashboard');
		}
/*
    $task_details = Todolistnewtask::where('user_id', '=', $data['user_id'])->where('status', '<>' , 'close')->select("todolistnewtasks_id", "user_id", "group_id","urgent", "taskname", "taskdate","task_time", "rel_client_id","staff_id", "notes","add_file","status","created")->get(); */
    
    //$task_details = Todolistnewtask::select("todolistnewtasks_id", "user_id", "group_id","urgent", "taskname", "taskdate","task_time", "rel_client_id","staff_id", "notes","add_file","status","created")->where('status', '<>' , 'close')->where('user_id', '=', $data['user_id'])->orWhere('staff_id', $data['user_id'])->get();
    
        
    $task_details = DB::select(DB::raw("SELECT * FROM todolistnewtasks WHERE `status`<>'close' AND (user_id=".$data['user_id']." OR staff_id=".$data['user_id'].")" ));
       
       // echo '<pre>';print_r($task_details);die();
        
        //$data['task_report'] = $task_details;
     
    $data2 = array();
    if (!empty($task_details)) {
      foreach ($task_details as $key => $val) {
          
        $data2[$key]['todolistnewtasks_id'] = $val->todolistnewtasks_id;
        $data2[$key]['staff_detail'] = User::where("user_id", "=", $val->staff_id)->select("user_id", "fname", "lname")->first();
        $data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", $val->rel_client_id)->where(function ($query){
        	$query->where("field_name", "business_name")->orWhere("field_name", "client_name");
      	})->first();
        $data2[$key]['urgent'] = $val->urgent;
        $data2[$key]['taskdate'] = $val->taskdate;
        $data2[$key]['task_time'] = $val->task_time;
        $data2[$key]['taskname'] = $val->taskname;
        
        $data2[$key]['notes'] = $val->notes;
        $data2[$key]['add_file'] = $val->add_file;
        $data2[$key]['status'] = $val->status;
        $data2[$key]['created'] = $val->created;
      }
      
      
      if (!empty($data2)) {
        $data['task_report'] = $data2;
      }
    }
       
    $closetask_details = DB::select(DB::raw("SELECT * FROM todolistnewtasks WHERE `status`='close' AND (user_id=".$data['user_id']." OR staff_id=".$data['user_id'].")" ));
      
    $data3 = array();
    if (!empty($closetask_details)) {
      foreach ($closetask_details as $key => $val) {
          
        $data3[$key]['todolistnewtasks_id'] = $val->todolistnewtasks_id;
        $data3[$key]['staff_detail'] = User::where("user_id", $val->staff_id)->select("user_id", "fname", "lname")->first();
        $data3[$key]['client_detail'] = StepsFieldsClient::where("client_id", $val->rel_client_id)->
          where(function ($query){
            $query->where("field_name", "business_name")->orWhere("field_name", "client_name"); 
        })->first();
        $data3[$key]['urgent'] = $val->urgent;
        $data3[$key]['taskdate'] = $val->taskdate;
        $data3[$key]['task_time'] = $val->task_time;
        $data3[$key]['taskname'] = $val->taskname;
          
        $data3[$key]['notes'] = $val->notes;
        $data3[$key]['add_file'] = $val->add_file;
        $data3[$key]['status'] = $val->status;
        $data3[$key]['created'] = $val->created;
      }
            
            
      if (!empty($data3)) {
        $data['closetask_report'] = $data3;
      }
    } 
        
    return View::make("staff.profile.to_list", $data);
	}
    
    
    
    
    
    
  public function pdfmy_details($user_id, $type_id)
  {
    $admin_s = Session::get('admin_details');
		$groupUserId = $admin_s['group_users'];

		$data = array();
    $t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;
		$data['page_name'] = base64_decode($type_id);
		$session = Session::get('admin_details');
		$data['user_id'] = $session['id'];
		$data['user_type'] = $session['user_type'];
		$data['heading'] = "";
		$data['title'] = "My Details";
		if ($data['page_name'] == "profile") {
			$data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
		} else {
			$data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
		}

		$data['titles'] = Title::orderBy("title_id")->get();
		$data['marital_status'] = MaritalStatus::orderBy("marital_status_id")->get();
		$data['countries'] = Country::orderBy('country_name')->get();
		$data['nationalities'] = Nationality::get();

		$data['old_postion_types'] = Position::whereIn("user_id", $groupUserId)->where("status", "old")->orderBy("name")->get();
		$data['new_postion_types'] = Position::whereIn("user_id", $groupUserId)->where("status", "new")->orderBy("name")->get();

		$data['old_department_types'] = Department::whereIn("user_id", $groupUserId)->where("status", "old")->orderBy("name")->get();
		$data['new_department_types'] = Department::whereIn("user_id", $groupUserId)->where("status", "new")->orderBy("name")->get();

		if (!isset($data['user_id']) && $data['user_id'] == "") {
			return Redirect::to('/');
		} else
		if (isset($data['user_type']) && $data['user_type'] == "C") {
			return Redirect::to('/invitedclient-dashboard');
		}

		$data['staff_id'] = $user_id;
		$data['staff_details'] = $this->userDetailsByUserId($user_id);

		if (isset($data['staff_details']['step_data']['country']) && count($data['staff_details']['step_data']['country']) > 0) {
			$country = Country::where("country_id", $data['staff_details']['step_data']['country'])->select('country_name')->first();
			$data['staffcountry'] = $country->country_name;
		}
        
        
    if (isset($data['staff_details']['step_data']['res_country']) && count($data['staff_details']['step_data']['res_country']) > 0) {
			$residential_country= Country::where("country_id", "=", $data['staff_details']['step_data']['res_country'])->select('country_name')->first();
			$data['residentialcountry'] = $residential_country->country_name;
		}
        
    if (isset($data['staff_details']['step_data']['marital_status']) && count($data['staff_details']['step_data']['marital_status']) > 0) {
			$marital = MaritalStatus::where("marital_status_id", "=", $data['staff_details']['step_data']['marital_status'])->select('status_name')->first();
			$data['maritalstatus'] = $marital->status_name;
		}
        
        
        
    if (isset($data['staff_details']['step_data']['nationality']) && count($data['staff_details']['step_data']['nationality']) > 0) {
		            
   		$nationalityname = Nationality::where('nationality_id', $data['staff_details']['step_data']['nationality'])->select("nationality_name")->first();
			$data['nationalityname'] = $nationalityname->nationality_name;
		}
        
        
    if (isset($data['staff_details']['step_data']['position_type']) && count($data['staff_details']['step_data']['position_type']) > 0) {
		            
   		$jobposition = Position::where("position_id", "=", $data['staff_details']['step_data']['position_type'])->select("name")->first();
			$data['positionname'] = $jobposition->name;
		}
    
    if (isset($data['staff_details']['step_data']['department']) && count($data['staff_details']['step_data']['department']) > 0) {
		            
   		$departmentname = Department::where("department_id", "=", $data['staff_details']['step_data']['department'])->select("name")->first();
			$data['deptname'] = $departmentname->name;
		}
        
		$pdf = PDF::loadView('staff/profile/pdfmydetails', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		$output = $pdf->output();

		$dom_pdf = $pdf->getDomPDF();

		$canvas = $dom_pdf->get_canvas();
		//echo $canvas->get_page_number();die;

		if (isset($canvas)) {

			$canvas->page_script('
        if ($PAGE_NUM > 1) {
            $PAGE_NUM=$PAGE_NUM-1;
            $PAGE_COUNT=$PAGE_COUNT-1;
            $font = Font_Metrics::get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 10;

            $pageText1 =  " Page " ;
            $y1 = $pdf->get_height() - 35;
            $x1 = $pdf->get_width() - 80- Font_Metrics::get_text_width($pageText1, $font, $size);
            $pdf->text($x1, $y1, $pageText1, $font, $size,array(0, 0, 255));

            $pageText = $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = $pdf->get_height() - 35;
            $x = $pdf->get_width() - 50 - Font_Metrics::get_text_width($pageText, $font, $size);
            $pdf->text($x, $y, $pageText, $font, $size,array(0, 0, 255));
        }
    	');
		}
        
        
        $clientname=str_replace(' ', '_', $data['staff_details']['staff_name']);
		return $pdf->download($clientname . '.pdf');
        
        
        
		//return View::make("staff.profile.pdfmy_details", $data);
	
        
    }
    
    
    
  public function todolistnewtask()
  {
    $postData 	= Input::all();
    $task_data 	= array();
    $tab_no		= base64_encode("11");

    $session_data = Session::get('admin_details');
    $user_id = $session_data['id'];
    $data['user_type'] = $session_data['user_type'];
		$groupUserId = $session_data['group_users']; 
     
		$group_id = $session_data['group_id'];     
        
    $task_data['user_id']=$user_id;
    $task_data['group_id']=$group_id;
    
    $task_data['status']="not_started";
    
    if (isset($postData['urgent']) && !empty($postData['urgent'])) {
      $task_data['urgent'] = $postData['urgent'];
    }
    
    if (isset($postData['taskname']) && !empty($postData['taskname'])) {
      $task_data['taskname'] = $postData['taskname'];
    }
		if (isset($postData['taskdate']) && !empty($postData['taskdate'])) {
      $task_data['taskdate'] = date('Y-m-d', strtotime($postData['taskdate']));
    }
    if (isset($postData['task_time']) && !empty($postData['task_time'])) {
      $task_time = str_replace(' ', '', $postData['task_time']);
      $task_data['task_time'] = $task_time.':00';
    }
    /* if (isset($postData['task_time']) && !empty($postData['task_time'])) {
        $task_data['task_time'] = $postData['task_time'];
    }
    */
    if (isset($postData['rel_client_id']) && !empty($postData['rel_client_id'])) {
      $task_data['rel_client_id'] = $postData['rel_client_id'];
    }
    if (isset($postData['staff_id']) && !empty($postData['staff_id'])) {
      $task_data['staff_id'] = $postData['staff_id'];
    }
		if (isset($postData['notes']) && !empty($postData['notes'])) {
      $task_data['notes'] = $postData['notes'];
    }
            
    $todolistnewtasks_id = Todolistnewtask::insertGetId($task_data);
            
    if ($todolistnewtasks_id) {
      //////////////////file upload start//////////////////
      if (Input::hasFile('add_file')) {
        $file = Input::file('add_file');
        $destinationPath = "uploads/todolist/".$group_id;
        $fileName = Input::file('add_file')->getClientOriginalName();

        $fileName = $todolistnewtasks_id . $fileName;
        $result = Input::file('add_file')->move($destinationPath, $fileName);

        $file_data['add_file'] = $fileName;
        Todolistnewtask::where("todolistnewtasks_id", "=", $todolistnewtasks_id)->update($file_data);

      }
      /////////////////file upload end////////////////////

    }
    //echo $todolistnewtasks_id; die();
    return Redirect::to('/todo-list/'.$tab_no);
          
  }
    
    
    
    
    
  public function deletetask($dele_id)
  {
    $affected = Todolistnewtask::where('todolistnewtasks_id', $dele_id)->delete();
    return Redirect::to('profile/to-list/1');
  }
  
    
    
  public function viewtasknotes()
  {
    $tasknotesid = Input::get("tasknotesid");
    if (Request::ajax()) {
			$t = Todolistnewtask::where("todolistnewtasks_id",$tasknotesid)->select('notes')->first();
      echo $t['notes'];die();
    }
  }
    
	public function statuschange()
	{
    $statusid = Input::get("statusid");
    $status = Input::get("status");
    $data['status']=$status;
    
    if (Request::ajax()) {
			$tasknotes = Todolistnewtask::where("todolistnewtasks_id", $statusid)->update($data);
      echo $statusid;die();
    }
	}
   
  public function gettaskdetais(){
    
    $edittasknotesid = Input::get("edittasknotesid");
    if (Request::ajax()) {
		$tasknotes = Todolistnewtask::getDetailsById($edittasknotesid);
	    header('Content-Type: application/json; charset=utf-8');
	    echo json_encode($tasknotes);
	    exit();
	}
    
  }

  public function delete_profile_photo()
  {
  	$staff_id = Input::get("staff_id");
  	$file_details = ClientFile::where('client_id', "=", $staff_id)->first();
  	$data['profile_photo'] = '';
  	ClientFile::where('client_id', "=", $staff_id)->update($data);

  	if(isset($file_details['profile_photo']) && $file_details['profile_photo'] != ''){
  		$prevPath = "uploads/profile_photo/" . $file_details['profile_photo'];
	    if (file_exists($prevPath)) {
	        unlink($prevPath);
	    }
  	}
  	
  	echo 1;
  }

  public function save_profile_photo()
  {
  	$staff_id = Input::get("staff_id");
  	$data['profile_photo'] = Input::get("photo");

  	ClientFile::where('client_id', "=", $staff_id)->update($data);
  	
  	echo 1;
  }

  public function add_professional_body()
  {
  	$session = Session::get('admin_details');

	$data['name'] 		= Input::get("body_name");
	$data['user_id'] 	= $session['id'];
	$data['status'] 	= "S";
	$insert_id = ProfessionalBody::insertGetId($data);
	echo $insert_id;
	exit();
  }

  public function delete_professional_body()
  {
  	$field_id	= Input::get("field_id");
  	ProfessionalBody::where('p_body_id', '=', $field_id)->delete();
  	echo $field_id;
  }

  



}
