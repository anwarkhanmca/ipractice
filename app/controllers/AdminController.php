<?php

class AdminController extends BaseController {

	public function signup() {
		$data['title'] = "i-Practice | Signup";

		$data['coun'] = Country::where("country_id", "!=", 1)->orderBy('country_name')->
		get();
		// $data['coun'] 		= Country::select('country_name')->get();
		return View::make('admin/signup', $data);
	}


	public function signup_process() {
		if ($this->isPostRequest()) {
			$postData = Input::all();
			$messages = array(
				'fname.required' => 'Please enter your name',
				'email.required' => 'Please enter your email/username',
				'password.required' => 'Please enter your password',
				'confirmation_password.required' => 'Please enter confirmation password',
				'confirmation_password.matchpassword' => "confirmation password doesn't match");

			//print_r($messages);die();
			$rules = array(
				'fname' => 'required|alpha',
				'email' => 'required|email',
				'password' => 'required',
				'confirmation_password' => 'required|same:password'
				);
			$validator = Validator::make($postData, $rules, $messages);

			if ($validator->fails()) {
			 return Redirect::to('/admin-signup')->withInput(Request::except('password'))->withErrors($validator);
                
            // return Redirect::back()->withErrors($validator)->withInput();
			//	return Redirect::to('/admin-signup')->withErrors($validator)->withInput();
			} else {
				$insert_data['fname'] 			= $postData['fname'];
				$insert_data['lname'] 			= $postData['lname'];
				$insert_data['email'] 			= $postData['email'];
				$insert_data['password'] 		= md5($postData['password']);
				$insert_data['phone'] 			= $postData['phone'];
				$insert_data['website'] 		= $postData['website'];
				$insert_data['country'] 		= $postData['country'];
				$insert_data['user_type'] 		= "R";

				$email_check = User::where('email', $postData['email'])->first();
				//echo $this->last_query();die;
				if (isset($email_check) && count($email_check) > 0) {
					Session::flash('error_msg', 'This email is already exists, Please signup with another email');
					return Redirect::to('/admin-signup');
				}

				$last_id = User::insertGetId($insert_data);

				$pd_data['user_id'] 		= $last_id;
				$pd_data['display_name'] 	= $postData['practice_name'];
				PracticeDetail::insertGetId($pd_data);

				$insert_data['link'] = url()."/admin/activation/".base64_encode($last_id);
				
				$this->send_registration($insert_data);
				Session::flash('message', 'You have successfully registered');
				Session::flash('email', $insert_data['email']);
			}

			return Redirect::to('/admin-signup');
		}
	}

	private function send_registration($data) {
		Mail::send('emails.registration', $data, function ($message) use ($data) {
			$message->from('abel02@icloud.com', 'i-Practice');
			$message->to($data['email'], $data['fname'] . ' ' . $data['lname'])->subject("Welcome to i-Practice");

		});
	}

	public function login() 
	{
		//echo date('Y-m-d H:i');
		//die('anwar');
		$data['title'] = "i-Practice | Login";
		return View::make('admin/login', $data);

	}

	public function login_process() {
		$postData = Input::all();
		$messages = array(
			"userid.required" => "Please enter your userid",
			"password.required" => "Please enter your password",
		);
		//print_r($messages);die();

		$rules = array(
			"userid" => "required",
			"password" => "required",
		);
		// print_r($rules);die();
		$validator = Validator::make($postData, $rules, $messages);

		if ($validator->fails()) {

			return Redirect::to('/')->withErrors($validator)->withInput();
		} else {

		$admin = User::where('email', $postData['userid'])->where('password', md5($postData['password']))->first();
			//echo $this->last_query();die;
			if (isset($admin) && count($admin) > 0) {
				//############### Check user status ##############//
				if($admin['status'] == "I"){
					Session::flash('message', 'You are inactive user, Please contact the Firm');
					return Redirect::to('/login');
				}
				if($admin['show_archive'] == "Y" && $admin['user_type'] != "C" && $admin['user_type'] != "A"){
					Session::flash('message', 'Access denied - Please contact the Firm');
					return Redirect::to('/login');
				}
				//############### Check user status ##############//

				//############### Check user free time limit start ##############//
				if($admin['user_type'] == "R"){
					$cirrentTime = time();
					$timeInFuture = date('Y-m-d H:i:s', strtotime($admin['created']) + 45*86400);
					if($cirrentTime > strtotime($timeInFuture)){
						Session::flash('message', 'Your free trial login is over, Please subscribe now.');
						return Redirect::to('/login');
					}
					
				}
                
        /* =============== Update Invitation Status ================== */
        $uptdata['invitation_status'] = 'N';
        User::where('user_id', $admin['user_id'])->update($uptdata);
                
				//############### Check user free time limit end ##############//
				if(isset($admin['user_type']) && $admin['user_type'] == "C"){
					$client_name = Common::clientDetailsById($admin['client_id']);
					if($client_name['show_archive'] == "Y"){
						Session::flash('message', 'Access denied - Please contact the Firm');
						return Redirect::to('/login');
					}
            //print_r($client_name);die;
          if (isset($client_name['fname']) && $client_name['fname'] != "") {
            $admin['fname'] 		= $client_name['fname'];
          }
          if (isset($client_name['lname']) && $client_name['lname'] != "") {
           	$admin['lname'] 		= $client_name['lname'];
          }
				}


				$lgprsc = $this->activationLoginProcess($admin['user_id']);
				return Redirect::to($lgprsc);
				/*$arr['id'] 					= $admin['user_id'];
				$arr['client_id'] 			= $admin['client_id'];
				$arr['related_company_id'] 	= $admin['related_company_id'];
				$arr['fname'] 				= $admin['fname'];
				$arr['lname'] 				= $admin['lname'];
				$arr['email'] 				= $admin['email'];
				$arr['user_type'] 			= $admin['user_type'];
				$arr['status'] 				= $admin['status'];
				$arr['parent_id'] 			= $admin['parent_id'];
				$arr['group_id'] 			= Common::getGroupId($admin['user_id']);
				$arr['group_users'] 		= Common::getUserIdByGroupId($arr['group_id']);
				
				Session::put('admin_details', $arr);

				 ================ leads_tab_manages tables check ================= 
				LeadsTabManage::checkData($arr['group_id']);
				JobsStep::checkJobsStepsData($arr['group_id']);

				LoginDetail::insert(array('login_date'=>date("Y-m-d H:i:s"), 'user_id'=>$admin['user_id']));
                
                	if($admin['user_type'] == "A"){
                    	return Redirect::to('/admin');
                    }else if($admin['user_type'] == "C"){
                    	return Redirect::to('/client-portal');
                    }else{
				        return Redirect::to('/dashboard');
                    }*/
                
			} else {
				Session::flash('message', 'Your username/password doesn`t match');
				return Redirect::to('/login');
			}
		}
		

		

	}

	/*public function login_process() {
		if ($this->isPostRequest()) {
			$postData = Input::all();
			$messages = array(
				"userid.required" => "Please enter your userid",
				"password.required" => "Please enter your password",
			);
			//print_r($messages);die();

			$rules = array(
				"userid" => "required",
				"password" => "required",
			);
			// print_r($rules);die();
			$validator = Validator::make($postData, $rules, $messages);

			if ($validator->fails()) {

				return Redirect::to('/')->withErrors($validator)->withInput();
			} else {

				$admin = Admin::where('email_address', $postData['userid'])->where('password',
					md5($postData['password']))->first();

				if (isset($admin) && count($admin) > 0) {

					$arr['id'] = $admin->id;
					$arr['first_name'] = $admin->first_name;
					$arr['last_name'] = $admin->last_name;
					$arr['practice_name'] = $admin->practice_name;
					$arr['email_address'] = $admin->email_address;
					$arr['phone'] = $admin->phone;
					$arr['website'] = $admin->website;
					$arr['country'] = $admin->country;

					Session::put('admin_details', $arr);
					return Redirect::to('/dashboard');
				} else {
					Session::flash('message', 'Your username/password doesn`t match');
				}
			}
		}

		return Redirect::to('/');

	}*/

	public function logout() {
		session_start();
		$base_url = url();
		
		Session::flush();
        Session::regenerate();
        unset($_SESSION['admin_details']);
        //session_destroy();
		return Redirect::to($base_url.'/login');
		//return Redirect::to($base_url.'/esigns/auth/logout');
	}

	public function forgot_password() {
		$data['title'] = "i-Practice | Forget Password";
		return View::make('admin/password', $data);

	}

	public function password_send() {

		$usr_data = array();
		$postData = Input::all();

		$usr_data['email'] = $postData['userid'];
		$admin = User::where('email', $usr_data['email'])->first();

		if (isset($admin) && count($admin) >0 ) {
			$usr_data['newpass'] = str_random(8);
			$data = array('password' => md5($usr_data['newpass']));
			User::where('email', '=', $usr_data['email'])->update($data);

			$this->send_mail($usr_data);
			Session::flash('message', 'The new password has been sent to your email.');
			
		} else {
			Session::flash('message_error', 'Please enter your valid username');
		}
		return Redirect::to('/forgot-password');

	}

	private function send_mail($data) {
		Mail::send('emails.password_admin', $data, function ($message) use ($data) {
			$message->from('abel02@icloud.com', 'i-Practice'); $message->to($data['email'])->
			subject("New Password Created");}
		);
	}
	public function adminprofile() {

		$admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id']; //session user id

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		$data['title'] = "Profile";
		$data['heading'] = "";
		$admin_s = Session::get('admin_details');
		$adminid = $admin_s['id'];

		$data['admin_details'] = User::where('user_id', $adminid)->first();
		$country = Country::where('country_id', $data['admin_details']['country'])->first();
		$data['admin_details']['country'] = $country['country_name'];

		return View::make('admin/profile', $data);
	}

	public function change_password() {
		$admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id']; //session user id
		//print_r($admin_s);

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		$data['title'] 		= "Edit Password";
		$data['heading'] 	= "EDIT PASSWORD";
		$data['client_id'] 	= $admin_s['client_id'];;

		return View::make('admin/change_password', $data);
	}

	public function new_pass() {

		$admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id']; //session user id

		if (empty($user_id)) {
			return Redirect::to('/');
		}

		$usr_data = array();
		$postData = Input::all();
		$admin_s = Session::get('admin_details');
		$adminid = $admin_s['id'];

		$messages = array(
			"old_password.required" => "Please enter your Old Password",
			"new_password.required" => "Please enter your New Password",
			"conform_password.required" => "Please enter your confirm_password",
		);

		$rules = array(
			'old_password' => 'required',
			'new_password' => 'required',
			'conform_password' => 'required|same:new_password',
		);
		$validator = Validator::make($postData, $rules, $messages);

		if ($validator->fails()) {
			return Redirect::to('/change-password')->withErrors($validator)->withInput();
		} else {
			$usr_data['password'] = md5($postData['old_password']);
			$admin = User::where('password', $usr_data['password'])->first();
			if (isset($admin) && count($admin) >0 ) {
				$data = array('password' => md5($postData['new_password']));
				User::where('user_id', '=', $adminid)->update($data);
				Session::flash('message_su', 'Successfully update your password');
			} else {
				Session::flash('message', 'Please enter valid old password');
			}

		}
		return Redirect::to('/change-password');

	}

	public function profile_edit() {
		$data['title'] = "Edit - Profile";
		$data['heading'] = "";
		$data['coun'] = Country::where("country_id", "!=", 1)->orderBy('country_name')->
		get();
		$admin_s = Session::get('admin_details');

		$data['admin_details'] = User::where('user_id', $admin_s['id'])->first();
		return View::make('admin/profile_edit', $data);
	}

	public function profile_update() {
		$admin_s = Session::get('admin_details');

		$usr_data = array();
		$postData = Input::all();
		//print_r($postData);die();
		$data = array(
			'fname' 	=> $postData['fname'],
			'lname' 	=> $postData['lname'],
			'website' 	=> $postData['website'],
			'phone' 	=> $postData['phone'],
			'country' 	=> $postData['country']
		);

		User::where('user_id', '=', $admin_s['id'])->update($data);
		//die('update');
		return Redirect::to('/admin-profile');
	}

	public function activation($user_id) {
		$user_id = base64_decode($user_id);
		$data['status'] 	= "A";
		$data['group_id'] 	= $user_id;
		
		$user = User::where("user_id", $user_id)->select("created", "status", "fname")->first();
		$data['todo_email'] = strtolower($user->fname).base64_encode($user_id).'.todolist@i-practice.co.uk';
		
		if(isset($user) && count($user) > 0){
			$cirrentTime = time();
			$timeInFuture = date('Y-m-d H:i:s', strtotime($user['created']) + 86400);
			
			if($cirrentTime > strtotime($timeInFuture)){
				User::where("user_id", "=", $user_id)->delete();
				Session::flash("message", "Your activation time is over. Please register again");
			}else{
				if($user['status'] == "A"){
					Session::flash("message", "Your are activated user. Please log in");
				}else{
					//$permission_list = Permission::get();//print_r($data['permission_list']);die;
					$permission_list = Service::getOldOrgService();
					if (isset($permission_list) && count($permission_list) > 0) {
						foreach ($permission_list as $value) {
							$usrp_data['user_id'] 		= $user_id;
							$usrp_data['permission_id'] = $value['service_id'];
							UserPermission::insert($usrp_data);
						}
					}

					$access_list = Access::get();
					if (!empty($access_list) && count($access_list) > 0) {
						foreach ($access_list as $value) {
							$usracc_data['user_id'] = $user_id;
							$usracc_data['access_id'] = $value->access_id;
							UserAccess::insert($usracc_data);
						}
					}
					User::where("user_id", $user_id)->update($data);

					$lgprsc = $this->activationLoginProcess($user_id);
					return Redirect::to($lgprsc);
				}
				
			}
		}
		
		
		return Redirect::to('/');
	}

	public function activationLoginProcess($user_id)
	{	

		$admin = User::where('user_id', $user_id)->first();

		$arr['id'] 									= $admin['user_id'];
		$arr['client_id'] 					= $admin['client_id'];
		$arr['related_company_id'] 	= $admin['related_company_id'];
		$arr['email'] 							= $admin['email'];
		$arr['todo_email'] 					= $admin['todo_email'];
		$arr['user_type'] 					= $admin['user_type'];
		$arr['status'] 							= $admin['status'];
		$arr['parent_id'] 					= $admin['parent_id'];
		$arr['group_id'] 						= Common::getGroupId($admin['user_id']);
		$arr['group_users'] 				= Common::getUserIdByGroupId($arr['group_id']);

		if(isset($admin['user_type']) && $admin['user_type'] == "C"){
			$client_name = Common::clientDetailsById($admin['client_id']);
			if (isset($client_name['fname']) && $client_name['fname'] != "") {
          $arr['fname'] 		= $client_name['fname'];
      }
      if (isset($client_name['lname']) && $client_name['lname'] != "") {
         	$arr['lname'] 		= $client_name['lname'];
      }
		}else{
			$arr['fname'] 				= $admin['fname'];
			$arr['lname'] 				= $admin['lname'];
		}

		
		Session::put('admin_details', $arr);//print_r($arr);

		/* ================ leads_tab_manages tables check ================= */
		LeadsTabManage::checkData($arr['group_id']);
		JobsStep::checkJobsStepsData($arr['group_id']);

		LoginDetail::insert(array('login_date'=>date("Y-m-d H:i:s"), 'user_id'=>$admin['user_id']));
        
  	if($admin['user_type'] == "A"){
    	$ret_val = '/admin/1';
    }else if($admin['user_type'] == "C"){
    	$ret_val = '/client-portal';
    }else{
      $ret_val = '/dashboard';
    }
    return $ret_val;
	}
    
    public function invited_login($userId) {
        $user_id = base64_decode($userId);
		$data['title'] = "i-Practice | Login";
        $admin_s = User::getStaffDetailsById($user_id);


        $dataTE['todo_email']=strtolower($admin_s['fname']).base64_encode($user_id).'.todolist@i-practice.co.uk';
        User::where("user_id", $user_id)->update($dataTE);

        
        $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);
        $practice_details = PracticeDetail::whereIn("user_id", $groupUserId)->first();
        if($admin_s['user_type'] == "C"){
            $display_name = $practice_details['display_name']." Client Portal";
        }else{
            $display_name = $practice_details['display_name'];
        }

        if (File::exists("practice_logo/".$practice_details['practice_logo']) && $practice_details['practice_logo'] != ""){
            $practice_logo = "<img src='/practice_logo/".$practice_details['practice_logo']."' class='browse_img'>";
        }else{
            $practice_logo = "";
        }
        $data['display_name'] = $display_name;
        $data['practice_logo'] = $practice_logo;
        
        
		return View::make('admin/login', $data);

	}
    

}

