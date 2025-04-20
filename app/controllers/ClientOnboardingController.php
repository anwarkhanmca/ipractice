<?php
class ClientOnboardingController extends BaseController {
  public function __construct()
  {
    parent::__construct();
    $session = Session::get('admin_details');
    $user_id = $session['id'];
    if (empty($user_id)){
      Redirect::to('/login')->send();
    }
  }

	public function index() {
		$client_data 		  = array();
		$data['heading'] 	= "CLIENT - ONBOARDING";
		$data['title'] 		= "Onboarding Clients List";
		$admin_s 			    = Session::get('admin_details'); // session
		$user_id 			    = $admin_s['id']; //session user id
		$groupUserId      = Common::getUserIdByGroupId($admin_s['group_id']);

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		
		$client_ids = Client::where("is_deleted", "=", "N")->where("is_archive", "=", "N")->where("is_onboard", "=", "Y")->where("is_relation_add", "=", "N")->whereIn("user_id", $groupUserId)->select("client_id", "created","show_archive")->orderBy("client_id", "DESC")->get();
		//echo $this->last_query();die;
		$i = 0;
		if (isset($client_ids) && count($client_ids) > 0) {
			foreach ($client_ids as $client_id) {
				$client_details = StepsFieldsClient::where('client_id', '=', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();
				$client_data[$i]['client_id'] = $client_id->client_id;
				$client_data[$i]['show_archive'] 	= $client_id->show_archive;
                $client_data[$i]['created'] 	= $client_id->created;
				$appointment_name = ClientRelationship::where('client_id', '=', $client_id->client_id)->select("appointment_with")->first();
				//echo $this->last_query();//die;
				$relation_name = StepsFieldsClient::where('client_id', '=', $appointment_name['appointment_with'])->where('field_name', '=', "name")->select("field_value")->first();

				if (isset($client_details) && count($client_details) > 0) {
					$corres_address = "";
					foreach ($client_details as $client_row) {
						//get business name start
						if (!empty($relation_name['field_value'])) {
							$client_data[$i]['staff_name'] = $relation_name['field_value'];
						}

						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_acc_due"){
							$client_data[$i]['deadacc_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}
						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_ret_due"){
							$client_data[$i]['deadret_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}
						if (isset($client_row['field_name']) && $client_row['field_name'] == "acc_ref_month"){
							$client_data[$i]['ref_month'] = App::make('ChdataController')->getMonthNameShort($client_row->field_value);
						}

						if (isset($client_row['field_name']) && $client_row['field_name'] == "business_type") 
						{
							$business_type = OrganisationType::where('organisation_id', '=', $client_row->field_value)->first();
							$client_data[$i][$client_row['field_name']] = $business_type['name'];
						} else {
							$client_data[$i][$client_row['field_name']] = $client_row->field_value;
						}

						// ############### GET CORRESPONDENSE ADDRESS START ################## //
						if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_addr_line1"){
							$corres_address .= $client_row->field_value.", ";
						}
						if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_addr_line2"){
							$corres_address .= $client_row->field_value.", ";
						}
						if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_county"){
							$corres_address .= $client_row->field_value.", ";
						}
						// ############### GET CORRESPONDENSE ADDRESS END ################## //
                        
                        
                           
       				$sql = "SELECT ((SELECT COUNT(*) FROM client_task_dates WHERE client_id = $client_id->client_id AND user_id = $user_id AND status = 'D') /(SELECT COUNT(*) FROM client_task_dates WHERE client_id = '$client_id->client_id' AND user_id = $user_id)) * 100 AS avg FROM `client_task_dates` WHERE client_id = $client_id->client_id GROUP BY client_id";
         
			        $result = DB::select(DB::raw($sql));
				        if(isset($result[0]->avg)) {
				            $client_data[$i]['avg'] = number_format($result[0]->avg,2);  
				            if(number_format($result[0]->avg)=="0.00"){
				                $client_data[$i]['avg'] = '0';
				            }
				        } else {
				            $client_data[$i]['avg'] = '0';
				        }      
        
      				}
                    //die();                    
					$client_data[$i]['corres_address'] = substr($corres_address, 0 ,-2);

					$i++;
				}

            }
		}

		$data['client_details'] 	= $client_data;
		$data['client_fields'] 		= ClientField::where("field_type", "=", "org")->get();
		$data['staff_details'] 		= User::whereIn("user_id", $groupUserId)->where("client_id","=", 0)->select("user_id", "fname", "lname")->get();
        $data['allClients'] 		= App::make('HomeController')->get_all_clients();
    	$data['old_postion_types'] 	= Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "old")->orderBy("name")->get();
		$data['new_postion_types'] 	= Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();

		//$data['task_details'] = ClientTaskDate::get_task_details();

		$data['autosend_days'] = OnboardAutosendDay::get_owner_autosend_days();
		//echo "<pre>";print_r($data['old_postion_types']);die;

		return View::make('home.organisation.onboard', $data);
	}

	public function insert_onboarding()
    { 
        $data 		  = array();
        $session 	  = Session::get('admin_details');
        $user_id 	  = $session['id'];
        $groupUserId  = $session['group_users'];
        $addto_task   = Input::get('addto_task');
        $status 	  = Input::get('status');
        $owner 		  = Input::get('owner');
        $taskdate     = Input::get('new_task_date');
        $cid 		  = Input::get('cid'); 

        $message      = Input::get('message');
        $attachment   = Input::get('attachment');
        $attach_hidd  = Input::get('attach_hidd');
       
        //print_r($addto_task); die();
        if(isset($addto_task) && count($addto_task) >0){
            //ClientTaskDate::whereIn('user_id', $groupUserId)->where('client_id', '=', $cid)->delete();
            foreach($addto_task as $key=>$value){
                $data['task_owner_email']   = $owner[$key];
                $data['message']            = $message[$key];
                $data['status']             = $status[$key];

                /* =============== File Upload ================= */
                $fileName = '';
                if(Input::hasFile('attachment')){
                    foreach(Input::file("attachment") as $file) {
                        $fileName = $file->getClientOriginalName();
                        $file->move('./uploads/checklist_files/', $fileName);
                        $data['attachment']  = $fileName;
                    }
                }else{
                    $fileName = $attach_hidd[$key];
                    $data['attachment'] = $attach_hidd[$key];
                }

                if(isset($taskdate[$key])){
                    $data['taskdate']   = date('Y-m-d H:i:s', strtotime($taskdate[$key]));
                }
                $details = ClientTaskDate::where('client_id', '=', $cid)->where('check_list','=',$value)->first();
                if(isset($details) && count($details) >0){
                    ClientTaskDate::where('cleinttaskdate_id', '=', $details['cleinttaskdate_id'])->update($data);
                    $insert_id = $details['cleinttaskdate_id'];
                }else{
                    $data['user_id']    = $user_id;
                    $data['client_id']  = $cid;
                    $data['check_list'] = $value;
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $data['added_time'] = time();
                    $insert_id = ClientTaskDate::insertGetId($data);
                }

                /* ================== Email Send Start =================== */
                if(isset($taskdate[$key]) && $taskdate[$key] != ""){
                    $today      = date('Y-m-d');
                    $dayDiffer  = Common::dayDifference($taskdate[$key], $today);
                    //echo $dayDiffer;die;
                    if($dayDiffer <= 0){//echo '<='.$insert_id;
                        $link = base64_encode($insert_id);
                        $send_data['email']         = $owner[$key];
                        $send_data['link']          = url()."/checklist/status-view/".$link;
                        $send_data['notes']         = isset($message[$key])?$message[$key]:'';
                        $send_data['attachment']    = url()."/uploads/checklist_files/".$fileName;

                        $send_data['subject'] = Client::getClientNameByClientId($cid);

                        $custName = Checklist::getChecklistByCheckId( $addto_task[$key] );
                        if(isset($custName['name'])  && $custName['name'] != ""){
                            $send_data['check_name']  = $custName['name'];
                        }else{
                            $send_data['check_name']  = '';
                        }
                        

                        App::make('ChecklistController')->send_email($send_data);

                        $sndDate['email_send_date'] = date('Y-m-d');
                        ClientTaskDate::where('cleinttaskdate_id', '=', $insert_id)->update($sndDate);
                    }
                }
                /* ================== Email Send End =================== */
            }//foreach loop
        }

        /* Remind day section */
        $dtls = OnboardAutosendDay::getDetailsByClientId($cid);
        $rDayData['days']       = Input::get('reminddays'); 
        $rDayData['notes']      = Input::get('global_notes'); 
        if(isset($dtls) && count($dtls) >0){
            OnboardAutosendDay::where('autosend_id', '=', $dtls['autosend_id'])->update($rDayData);
        }else{
            $rDayData['client_id']  = $cid;
            $rDayData['user_id']    = $user_id;
            $rDayData['created']    = date('Y-m-d H:i:s');
            OnboardAutosendDay::insert($rDayData);
        }

        
        
        
        /* ========== Delete ============ */
        $details = Checklist::get_checklist();//print_r($details); die();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                if (!in_array($value['checklist_id'], $addto_task)) {//echo $value['checklist_id'];
                    ClientTaskDate::whereIn("user_id", $groupUserId)->where("client_id", $cid)->where("check_list", $value['checklist_id'])->delete();
                }
            }
        }
        /* ========== Delete ============ */

        $average = $this->getCompletedPercentage($cid);
        if(isset($average) && $average == '100'){
            $up_data['is_onboarding'] = 'C';
        }else{
            $up_data['is_onboarding'] = 'Y';
        }
        CrmLead::updateCrmLeadsStatus($cid, $up_data);
        //print_r($cid);
        return Redirect::to('/onboard');
    }

    public function get_owner_list($client_id)
    {
        $data  = array();
        $staff_details = User::getAllStaffDetails();
        $i = 0;
        foreach ($staff_details as $key => $staff) {
            $name = "";
            if (isset($staff['fname']) && $staff['fname'] != "") {
                $name .= $staff['fname'];
            }
            if (isset($staff['lname'])) {
                $name .= " ".$staff['lname'];
            }

            $data[$i]['owner_id'] = $staff['user_id'];
            $data[$i]['contact_type'] = "staff";
            $data[$i]['name'] = ucwords(strtolower($name));
            $i++;
        }

        $client_details = Common::clientDetailsById($client_id);
        foreach ($client_details as $key => $details) {
            if (isset($details['corres_cont_name']) && $details['corres_cont_name'] != "") {
                $data[$i]['owner_id'] = $client_id;
                $data[$i]['contact_type'] = "corres";
                $data[$i]['name'] = ucwords(strtolower($details['corres_cont_name']));
            }
            $i++;
        }
        $relayth_data = Common::get_relationship_client($client_id);
        if (isset($relayth_data) && count($relayth_data) > 0) {
            foreach ($relayth_data as $key => $value) {
                $data[$i]['owner_id']       = $value['client_id'];
                $data[$i]['contact_type']   = 'org';
                $data[$i]['name']           = ucwords(strtolower($value['name']));
                $i++;
            }

        }
        return $data;
    }

    public function ajax_task_details()
    {
    	$data      = array();
        $task_data = array();
    	$session 		= Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId 	= $session['group_users'];
        $client_id 		= Input::get('client_id');
        $data['admin_name']     = $session['fname'].' '.$session['lname'];
        $data['logged_email']   = $session['email'];
        $data['title']          = "On-Boarding Checklist";
        //print_r($session);die;
        $data['owner_list'] = $this->get_owner_list($client_id);
        
        $data['check_list']  = Checklist::get_checklist();
        if(isset($data['check_list']) && count($data['check_list']) >0){
            foreach ($data['check_list'] as $key => $value) {
                $data['check_list'][$key]['task_details'] = ClientTaskDate::get_task_by_client($client_id, $value['checklist_id']);
            }
        }

        //$data['autosend_days'] = OnboardAutosendDay::get_owner_autosend_days();
        $data['autosend_dtls'] = OnboardAutosendDay::getDetailsByClientId($client_id);
        //$data['check_list'] = $task_data;
        //print_r($data['check_list']);//die;
        echo View::make('onboard.task_list', $data);

	}
    
    public function pdfdownloadajax_task_details($client_id)
    {
        
    	$data      = array();
        $task_data = array();
        $temp = $newvardump = array();
        $final_arr = array();
        //echo $search; die;
        
		$client_data 		= array();
        $t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;
    	$session 		= Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId 	= $session['group_users'];
       // $client_id 		= Input::get('client_id');
        $data['admin_name']     = $session['fname'].' '.$session['lname'];
        $data['logged_email']   = $session['email'];
        $data['title']          = "On-Boarding Checklist";
        //print_r($session);die;
        $data['owner_list'] = $this->get_owner_list($client_id);
        // echo '<pre>'; print_r($data['owner_list']);die;
        $data['check_list']  = Checklist::get_checklist();
        if(isset($data['check_list']) && count($data['check_list']) >0){
            foreach ($data['check_list'] as $key => $value) {
                $data['check_list'][$key]['task_details'] = ClientTaskDate::get_task_by_client($client_id, $value['checklist_id']);
            
            if(isset($data['check_list'][$key]['task_details']['task_owner']) && $data['check_list'][$key]['task_details']['task_owner']){
              //  echo 'sfsfsdf';
              
              
              $woner = explode("_", $data['check_list'][$key]['task_details']['task_owner']);
              print_r($woner);
              //$wonerid=$woner['0'];
            //  $wonertype=$woner['1'];                            
            }
            
            
            }
            //die();
        }
        
        
        
        //$data['check_list']['']] = $task_data;
      //  echo '<pre>'; print_r($data['check_list'][$key]['task_details']['task_owner']);die();
        
      //echo '<pre>'; print_r($data['check_list']['3']['task_details']['task_owner']);die;
      
        $data['autosend_days'] = OnboardAutosendDay::get_owner_autosend_days();
       	$pdf = PDF::loadView('onboard.pdftask_list', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		$output = $pdf->output();

		$dom_pdf = $pdf->getDomPDF();

		$canvas = $dom_pdf->get_canvas();
		//echo $canvas->get_page_number();die;
             $bname="On_Boarding_Checklist";
		return $pdf->download($bname . '.pdf');
        

	}
    

	public function ajax_new_task()
    {
    	$data = array();
    	$details = array();
    	$session 		= Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId 	= $session['group_users'];
        $client_id 		= Input::get('client_id');

        $staff_details = User::getAllStaffDetails();
        $i = 0;
		foreach ($staff_details as $key => $staff) {
            $name = "";
            if (isset($staff['fname']) && $staff['fname'] != "") {
                $name .= $staff['fname'];
            }
			if (isset($staff['lname'])) {
                $name .= " ".$staff['lname'];
            }

            $data[$i]['owner_id'] = $staff['user_id'];
            $data[$i]['contact_type'] = "staff";
            $data[$i]['name'] = ucwords(strtolower($name));
            $i++;
		}

		$client_details = Common::clientDetailsById($client_id);
		foreach ($client_details as $key => $details) {
            if (isset($details['corres_cont_name']) && $details['corres_cont_name'] != "") {
                $data[$i]['owner_id'] = $client_id;
                $data[$i]['contact_type'] = "corres";
                $data[$i]['name'] = ucwords(strtolower($details['corres_cont_name']));
            }
			$i++;
        }
        $relayth_data = Common::get_relationship_client($client_id);
        if (isset($relayth_data) && count($relayth_data) > 0) {
            foreach ($relayth_data as $key => $value) {
                $data[$i]['owner_id']       = $value['client_id'];
                $data[$i]['contact_type']   = $value['client'];
                $data[$i]['name']           = ucwords(strtolower($value['name']));
                $i++;
            }

        }

        $details['owner_list'] 		= $data;
        $details['old_postion_types'] 	= Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "old")->orderBy("name")->get();
		$details['new_postion_types'] 	= Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();

        //print_r($data);die;
        echo View::make('onboard.add_new', $details);

	}

    public function delete_task_details()
    {
        $cleinttaskdate_id  = Input::get('cleinttaskdate_id');
        $ret = ClientTaskDate::where('cleinttaskdate_id', '=', $cleinttaskdate_id)->delete();
        echo $ret;
    }

    public function getCompletedPercentage($client_id)
    {
        
        //$sql = "SELECT ((SELECT COUNT(*) FROM client_task_dates WHERE client_id = $client_id AND user_id = $user_id AND status = 'D') /(SELECT COUNT(*) FROM client_task_dates WHERE client_id = '$client_id' AND user_id = $user_id)) * 100 AS avg FROM `client_task_dates` WHERE client_id = $client_id GROUP BY client_id";
        $task_count = ClientTaskDate::taskCountByClientId($client_id);//echo $task_count;die;
        $done_count = ClientTaskDate::doneCountByClientId($client_id);
        if($task_count != 0){
            $avg = $done_count*100/$task_count;
        }else{
            $avg = 0;
        }
        
       /* $result = DB::select(DB::raw($sql));
        if(isset($result[0]->avg)) {
            $avg = number_format($result[0]->avg,2);  
            if(number_format($result[0]->avg)=="0.00"){
                $avg = '0';
            }
        } else {
            $avg = '0';
        }*/
        return $avg;
    }

    public function delete_onboarding_clients()
    {
        $client_delete_id = Input::get("client_delete_id");
        foreach ($client_delete_id as $client_id) {
            $del_data['is_onboard'] = "N";
            Client::where('client_id', '=', $client_id)->update($del_data);
            ClientTaskDate::where('client_id', '=', $client_id)->delete();

            $up_data['is_onboarding'] = 'C';
            CrmLead::updateCrmLeadsStatus($client_id, $up_data);
        }
    }

    public function add_task_date()
    {
        $cleinttaskdate_id = Input::get("cleinttaskdate_id");
        $task_date = date("Y-m-d", strtotime(Input::get("calender_date")));
        $task_time = str_replace(' ', '', Input::get("calender_time"));;
        $date = $task_date." ".$task_time.":00";
        //$date = Input::get("calender_date");
        ClientTaskDate::where('cleinttaskdate_id', '=', $cleinttaskdate_id)->update(array('taskdate'=>$date));
        //return Redirect::to('/onboard');
        echo $cleinttaskdate_id;
        exit();
    }

    public function autosend_days()
    {
        $up_data        = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $remind_days = Input::get("remind_days");
        $up_data['days'] = $remind_days;
        $details = OnboardAutosendDay::get_onboard_autosend();
        if(isset($details) && count($details) >0){
            OnboardAutosendDay::where('autosend_id', '=', $details['autosend_id'])->update(array('days'=>$remind_days));
            $last_id = $details['autosend_id'];
        }else{
            $up_data['days'] = $remind_days;
            $up_data['user_id'] = $user_id;
            $up_data['created'] = date('Y-m-d H:i:s');
            $last_id = OnboardAutosendDay::insertGetId($up_data);
        }
        echo $last_id;
    }
    
    
    public function pdfindex($search, $type){
        
        $temp = $newvardump = array();
        $final_arr = array();
        //echo $search; die;
        
		$client_data 		= array();
        $t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;
		$data['heading'] 	= "CLIENT - ONBOARDING";
		$data['title'] 		= "Onboarding Clients List";
		$admin_s 			= Session::get('admin_details'); // session
		$user_id 			= $admin_s['id']; //session user id
		$groupUserId 		= Common::getUserIdByGroupId($admin_s['group_id']);

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		
		$client_ids = Client::where("is_deleted", "=", "N")->where("is_archive", "=", "N")->where("is_onboard", "=", "Y")->where("is_relation_add", "=", "N")->whereIn("user_id", $groupUserId)->select("client_id", "created","show_archive")->orderBy("client_id", "DESC")->get();
		//echo $this->last_query();die;
		$i = 0;
		if (isset($client_ids) && count($client_ids) > 0) {
			foreach ($client_ids as $client_id) {
				$client_details = StepsFieldsClient::where('client_id', '=', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();
				$client_data[$i]['client_id'] = $client_id->client_id;
				$client_data[$i]['show_archive'] 	= $client_id->show_archive;
                $client_data[$i]['created'] 	= $client_id->created;
				$appointment_name = ClientRelationship::where('client_id', '=', $client_id->client_id)->select("appointment_with")->first();
				//echo $this->last_query();//die;
				$relation_name = StepsFieldsClient::where('client_id', '=', $appointment_name['appointment_with'])->where('field_name', '=', "name")->select("field_value")->first();

				if (isset($client_details) && count($client_details) > 0) {
					$corres_address = "";
					foreach ($client_details as $client_row) {
						//get business name start
						if (!empty($relation_name['field_value'])) {
							$client_data[$i]['staff_name'] = $relation_name['field_value'];
						}

						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_acc_due"){
							$client_data[$i]['deadacc_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}
						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_ret_due"){
							$client_data[$i]['deadret_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}
						if (isset($client_row['field_name']) && $client_row['field_name'] == "acc_ref_month"){
							$client_data[$i]['ref_month'] = App::make('ChdataController')->getMonthNameShort($client_row->field_value);
						}

						if (isset($client_row['field_name']) && $client_row['field_name'] == "business_type") 
						{
							$business_type = OrganisationType::where('organisation_id', '=', $client_row->field_value)->first();
							$client_data[$i][$client_row['field_name']] = $business_type['name'];
						} else {
							$client_data[$i][$client_row['field_name']] = $client_row->field_value;
						}

						// ############### GET CORRESPONDENSE ADDRESS START ################## //
						if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_addr_line1"){
							$corres_address .= $client_row->field_value.", ";
						}
						if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_addr_line2"){
							$corres_address .= $client_row->field_value.", ";
						}
						if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_county"){
							$corres_address .= $client_row->field_value.", ";
						}
						// ############### GET CORRESPONDENSE ADDRESS END ################## //
                        
                        
                           
       				$sql = "SELECT ((SELECT COUNT(*) FROM client_task_dates WHERE client_id = $client_id->client_id AND user_id = $user_id AND status = 'D') /(SELECT COUNT(*) FROM client_task_dates WHERE client_id = '$client_id->client_id' AND user_id = $user_id)) * 100 AS avg FROM `client_task_dates` WHERE client_id = $client_id->client_id GROUP BY client_id";
         
			        $result = DB::select(DB::raw($sql));
				        if(isset($result[0]->avg)) {
				            $client_data[$i]['avg'] = number_format($result[0]->avg,2);  
				            if(number_format($result[0]->avg)=="0.00"){
				                $client_data[$i]['avg'] = '0';
				            }
				        } else {
				            $client_data[$i]['avg'] = '0';
				        }      
        
      				}
                    //die();                    
					$client_data[$i]['corres_address'] = substr($corres_address, 0 ,-2);

					$i++;
				}

            }
		}

		
        $data['client_details'] 	= $client_data;
        //echo "<pre>";print_r($data['client_details']);die;
		$data['client_fields'] 		= ClientField::where("field_type", "=", "org")->get();
		$data['staff_details'] 		= User::whereIn("user_id", $groupUserId)->where("client_id","=", 0)->select("user_id", "fname", "lname")->get();
        $data['allClients'] 		= App::make('HomeController')->get_all_clients();
    	$data['old_postion_types'] 	= Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "old")->orderBy("name")->get();
		$data['new_postion_types'] 	= Checklist::whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();

		//$data['task_details'] = ClientTaskDate::get_task_details();

		$data['autosend_days'] = OnboardAutosendDay::get_owner_autosend_days();
		
        /*
        
        
         if ($search == "NONE") {
            $data['client_details'] 	= $client_data;
            // echo 'if';die();
        } else {
            
            
            $searchvalue = strtolower($search);
            //echo $searchvalue;die();
        if (isset($client_data) && count($client_data) > 0) {
            

                foreach ($client_data as $key => $value) {
                    $filterdata = array();
                   
                   
                   if (isset($value['client_id']) && $value['client_id'] != "") {
                        $filterdata['client_id'] = $value['client_id'];
                    }
                    if (isset($value['created']) && $value['created'] != "") {
                        $filterdata['created'] = $value['created'];
                    }
                    if (isset($value['business_type']) && $value['business_type'] != "") {
                        $filterdata['business_type'] = $value['business_type'];
                    }
                     if (isset($value['client_name']) && $value['client_name'] != "") {
                        $filterdata['client_name'] = "Individual";
                    }
                    if (isset($value['business_name']) && $value['business_name'] != "") {
                        $filterdata['business_name'] = $value['business_name'];
                    }
                     if (isset($value['client_name']) && $value['client_name'] != "") {
                        $filterdata['client_name'] = $value['client_name'];
                    }
                    if (isset($value['corres_cont_telephone']) && $value['corres_cont_telephone'] != "") {
                        $filterdata['corres_cont_telephone'] = $value['corres_cont_telephone'];
                    }
                    if (isset($value['res_telephone']) && $value['res_telephone'] != "") {
                        $filterdata['res_telephone'] = $value['res_telephone'];
                    }
                   
                    if (isset($value['res_email']) && $value['res_email'] != "") {
                        $filterdata['res_email'] = $value['res_email'];
                    }
                    if (isset($value['corres_cont_email']) && $value['corres_cont_email'] != "") {
                        $filterdata['corres_cont_email'] = $value['corres_cont_email'];
                    }
                    
                    if (isset($value['corres_cont_mobile']) && $value['corres_cont_mobile'] != "") {
                        $filterdata['corres_cont_mobile'] = $value['corres_cont_mobile'];
                    }
                    if (isset($value['res_mobile']) && $value['res_mobile'] != "") {
                        $filterdata['res_mobile'] = $value['res_mobile'];
                    }
                   
                    $temp = $this->search_array($filterdata, $searchvalue, $final_arr);

                    if (isset($temp) && count($temp) > 0) {
                        $newvardump[$key] = $client_data[$key];
                    }
                }
            }
            $client_data = array_values($newvardump);
             $data['client_details'] = $client_data;
        }
        
       */
        
        if ($type == "pdf") {
        
       	$pdf = PDF::loadView('home/organisation/pdfonboard', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		$output = $pdf->output();

		$dom_pdf = $pdf->getDomPDF();

		$canvas = $dom_pdf->get_canvas();
		//echo $canvas->get_page_number();die;
             $bname="CLIENT_ONBOARDING";
		return $pdf->download($bname . '.pdf');
        }
        elseif ($type == "excel") {
            
        	$viewToLoad = 'home/organisation/excelonboard';
            ///////////  Start Generate and store excel file ////////////////////////////
            Excel::create('CLIENT_ONBOARDING', function ($excel)use ($data, $viewToLoad)
            {
                $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
                {
                    $sheet->loadView($viewToLoad)->with($data); }
                )->save(); }
            );
            $filepath = storage_path() . '/exports/CLIENT_ONBOARDING.xls';
            $fileName = 'CLIENT_ONBOARDING.xls';
            $headers = array('Content-Type: application/vnd.ms-excel', );
    
            return Response::download($filepath, $fileName, $headers);
            exit;
                        
        }
        
		//return View::make('home.organisation.onboard', $data);
	
    }
    
     function search_array($value, $searchvalue, $final_arr)
    {   
        //echo '<pre>';print_r($value);die();        
        $arr = $value;
       
     //  unset($value['services_id']);
      // unset($value['relationship']);
        //if (isset($value['allocation'])) {
      //      unset($value['allocation']);
        //}
        //echo '<pre>';print_r($value);die;
        foreach ($value as $key => $val) {
            if (!stristr($val, $searchvalue) === false) {
                if (count($final_arr) > 0) {
                    foreach ($final_arr as $keyF => $eachF) {
                        if ($eachF['client_id'] != $value['client_id']) {
                            array_push($final_arr, $arr);
                        }
                    }
                } else {
                    array_push($final_arr, $arr);
                }
            }
        }
        return $final_arr;
    }
    
    public function custom_checklist_action()
    {  
        $last_id = 0;
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $input = Input::get();
        $action = $input['action'];
        if($action == 'add'){
            $data['user_id']        = $user_id;
            $data['custom_name']    = $input['custom_name'];
            $data['created']        = date('Y-m-d H:i:s');
            $last_id = CustomChecklist::insertGetId($data);
            $data['custom_check_id']    = $last_id;
        }else if($action == 'delete'){
            $custom_check_id = $input['custom_check_id'];
            CustomChecklist::where('custom_check_id', '=', $custom_check_id)->delete($data);
            $data['custom_check_id']    = $last_id;
        }else if($action == 'getByCheckId'){
            $custom_check_id = $input['custom_check_id'];
            $data = Checklist::getAllChecklistByCheckId($custom_check_id);
        }else if($action == 'getChecklistTables'){
            $tablechecklist_id  = $input['tablechecklist_id'];
            $position           = $input['position'];
            if($position == 'table'){
                $data = ChecklistTable::getChecklistById($tablechecklist_id);
            }else{
                $data = OnboardingChecklist::getDetailsById($tablechecklist_id);
            }
        }else if($action == 'saveTablNnotes'){
            $tablechecklist_id  = $input['tablechecklist_id'];
            $data['notes']      = $input['notes'];
            $position           = $input['position'];
            if($position == 'table'){
                ChecklistTable::where('checklist_id', '=', $tablechecklist_id)->update($data);
            }else{
                OnboardingChecklist::where('onboarding_checklist_id', '=', $tablechecklist_id)->update($data);
            }
        }else if($action == 'deleteTableChecklist'){
            $checklist_ids  = $input['checklist_ids'];
            foreach($checklist_ids as $key=>$checklist_id){
                ChecklistTable::where('checklist_id', '=', $checklist_id)->delete();
                OnboardingChecklist::where('table_checklist_id', '=', $checklist_id)->delete();
            }
        }else if($action == 'getCountryIdByCountryName'){
            $country  = $input['country'];
            $data['country_id'] = Country::getCountryIdByName($country);
        }else if($action == 'getCountyByTown'){
            $town  = $input['town'];
            $data['county'] = Town::getCountyByTown($town);
        }
        //echo Common::last_query();
        //print_r($data);
        echo json_encode($data);
    }


}
