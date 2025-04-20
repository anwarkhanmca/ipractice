<?php
class ChecklistController extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        /*if (empty($user_id)){
            Redirect::to('/login')->send();
        }*/
    }

	public function index($check_id) {
		$client_data 		= array();
		
		$data['title'] 		= "Checklist";
        $data['sub_url']    = "<a href='/jobs-dashboard'>Taskmanagement</a>";
        $data['check_id'] 	= $check_id;
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 		= $session['group_users'];

		$customlist         = CustomChecklist::getAllChecklistById( $check_id );
        $heading            = strtoupper(strtolower(trim($customlist['custom_name'])));
        $data['heading']    = '<span id="taskTitleSpan">'.$heading.'</span> <a href="javascript:void(0)" class="openEditJobPop"><img src="/img/edit_icon.png"></a>';
        $data['checkDetails']   = $this->getCheckListDetails( $check_id );
        $data['customlist']     = $customlist;
        
        //echo "<pre>";print_r($data['checkDetails']);die;
		return View::make('checklist/checklist', $data);
	}

	public function getCheckListDetails($check_id) {
        $data = array();
        $details = ChecklistTable::getChecklistByCheckId( $check_id );
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$details[$key]['staff_name']  = User::getStaffNameById($value['user_id']);
                $details[$key]['percentage']  = ChecklistTable::getPercentageCompleted($value['checklist_id']);
        	}
        }
        return $details;
    }
    
    public function add_checklist() {
		$rt_data = array();
		$session_data = Session::get('admin_details');
		$user_id = $session_data['id'];

        $data['custom_check_id']    = Input::get("custom_check_id");
		$data['name']               = Input::get("type_name");
		$data['user_id']            = $user_id;
		$data['status']             = "new";
        $data['created']            = date('Y-m-d H:i:s');
		$insert_id = ChecklistTable::insertGetId($data);
		$data['last_id'] = $insert_id;

		echo json_encode($data);
		exit();
	}
    
    public function ajax_check_details()
    {
    	$data      = array();
        $task_data = array();
    	$session 		= Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId 	= $session['group_users'];
        $data['admin_name']     = $session['fname'].' '.$session['lname'];
        $data['logged_email']   = $session['email'];
        $data['title']          = "On-Boarding Checklist";
        
        $checklist_id   = Input::get('checklist_id');
        
        $data['tableData']  = ChecklistTable::getChecklistById( $checklist_id );
        $data['check_list'] = $this->getOnboardingPopupDetails( $data['tableData']['custom_check_id'], $checklist_id );

        //echo "<pre>";print_r($data['check_list']);//die;
        echo View::make('checklist.ajax_checklist_item', $data);

	}
    
    public function getOnboardingPopupDetails( $custom_check_id, $checklist_id )
    {
        $data = array();
        $check_list = Checklist::getAllChecklistByCheckId( $custom_check_id );
        if(isset($check_list) && count($check_list) >0){
            foreach ($check_list as $key=>$value) {
                $check_list[$key]['task_details'] = OnboardingChecklist::getAllDetailsByChecklistId( $value['checklist_id'], $checklist_id );
                //echo $this->last_query();
            }
        }
        return $check_list;
    }
    
    public function insert_onboarding()
    {
        $data 		  = array();
        $session 	  = Session::get('admin_details');
        $user_id 	  = $session['id'];
        $groupUserId  = $session['group_users'];

        $send_data = array();
        
        $input = Input::get();
        $custom_checklist_id    = $input['custom_checklist_id'];
        $table_checklist_id     = $input['popchecklist_id'];
        $global_notes           = $input['global_notes'];
        $reminddays             = $input['reminddays'];
        
        //OnboardingChecklist::where('table_checklist_id', '=', $table_checklist_id)->delete();
        //print_r($addto_task); die();
        if(isset($input['addto_task']) && count($input['addto_task']) >0){
            $addto_task   = $input['addto_task'];
            $status 	  = Input::get('status');
            $owner 		  = Input::get('owner');
            $taskdate     = Input::get('new_task_date');
            $notes        = Input::get('message');

            $attachment   = Input::get('attachment');
            $attach_hidd  = Input::get('attach_hidd');
            //print_r($attachment);die;
            foreach($addto_task as $key=>$value){
                $data['task_owner_email']   = $owner[$key];
                $data['status']             = $status[$key];
                $data['notes']              = $notes[$key];


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
                    $data['task_date']   = date('Y-m-d H:i:s', strtotime($taskdate[$key]));
                }
                
                $details = OnboardingChecklist::whereIn("user_id", $groupUserId)->where('checklist_id', '=', $value)->where('table_checklist_id', '=', $table_checklist_id)->first();
                
                if(isset($details) && count($details) >0){
                    OnboardingChecklist::where('onboarding_checklist_id', '=', $details['onboarding_checklist_id'])->update($data);
                    $insert_id = $details['onboarding_checklist_id'];
                }else{
                    $data['user_id']                = $user_id;
                    $data['checklist_id']           = $value;
                    $data['table_checklist_id']     = $table_checklist_id;
                    $data['created']                = date('Y-m-d H:i:s');
                    $insert_id = OnboardingChecklist::insertGetId($data);
                }


                /* ================== Email Send =================== */
                if(isset($taskdate[$key]) && $taskdate[$key] != ""){
                    $today = date('Y-m-d');
                    $dayDiffer = Common::dayDifference($taskdate[$key], $today);
                    //echo $dayDiffer;
                    if($dayDiffer <= 0){//echo '<='.$insert_id;
                        $link = base64_encode($insert_id);
                        $send_data['email']         = $owner[$key];
                        $send_data['link']          = url()."/checklist/status-view/".$link;
                        $send_data['notes']         = isset($notes[$key])?$notes[$key]:'';
                        $send_data['attachment']    = url()."/uploads/checklist_files/".$fileName;

                        $details = ChecklistTable::getChecklistById( $table_checklist_id );
                        if(isset($details['name'])  && $details['name'] != ""){
                            $send_data['subject']  = $details['name'];
                        }else{
                            $send_data['subject']  = '';
                        }

                        $custName = Checklist::getChecklistByCheckId( $addto_task[$key] );
                        if(isset($custName['name'])  && $custName['name'] != ""){
                            $send_data['check_name']  = $custName['name'];
                        }else{
                            $send_data['check_name']  = '';
                        }
                        

                        $this->send_email($send_data);

                        $sndDate['email_send_date'] = date('Y-m-d');
                        OnboardingChecklist::where('onboarding_checklist_id', '=', $insert_id)->update($sndDate);
                    }
                }
                //die;

            }
        }
        
        $tdata['reminddays']    = $reminddays;
        $tdata['notes']         = $global_notes;
        ChecklistTable::where('checklist_id', '=', $table_checklist_id)->update($tdata);

        return Redirect::to('/checklist-details/'.$custom_checklist_id);
    }
    
    public function add_task_date()
    {
        $checklist_id       = Input::get("checklist_id");
        $popchecklist_id    = Input::get("popchecklist_id");echo $popchecklist_id.", ".$checklist_id;
        
        $task_date = date("Y-m-d", strtotime(Input::get("calender_date")));
        $task_time = str_replace(' ', '', Input::get("calender_time"));;
        $date = $task_date." ".$task_time.":00";

        OnboardingChecklist::where('checklist_id', '=', $checklist_id)->where('table_checklist_id', '=', $popchecklist_id)->update(array('task_date'=>$date));
        //return Redirect::to('/onboard');
        echo $checklist_id;
        exit();
    }


    public function send_email($data) {
        $session    = Session::get('admin_details');
        $user_id    = $session['id'];
        $group_id   = $session['group_id'];

        //$data['practice_name'] = PracticeDetail::get_practice_name($group_id);
        //echo "<pre>";print_r($data);die;
        Mail::send('emails.custom_checklist', $data, function ($message) use ($data) {
            $message->from('hello@ipractice.co.uk', 'i-Practice');
            $message->to($data['email'])->subject($data['subject']);
        });
    }

    public function status_view($id) { 
        $data   = array();
        $id     = base64_decode($id);
        $data   = OnboardingChecklist::getDetailsById( $id );
        //echo "<pre>";print_r($data);die;
        return View::make('checklist.checklist_activation', $data);
    }

    public function update_status() {
        $data = array();
        $postData = Input::all();
        $id = $postData['onboard_check_id'];

        $data['status'] = $postData['status'];
        OnboardingChecklist::where('onboarding_checklist_id','=',$id)->update($data);
        Session::flash('message', 'Status has been updated');
        //echo $data['onboard_check_id'];die;
        return Redirect::to('/checklist/status-view/'.base64_encode($id));
    }
    
    public function save_check_details() {
        $data = array();
        $postData = Input::all();
        $id = $postData['check_id'];

        $data['custom_name'] = $postData['check_name'];
        CustomChecklist::where('custom_check_id','=',$id)->update($data);
        echo json_encode($data);
        exit;
    }
    
    

}
