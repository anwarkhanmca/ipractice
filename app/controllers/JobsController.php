<?php
class JobsController extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        if (!isset($user_id)) {
            Redirect::to('/login')->send();
        }
        if (isset($session['user_type']) && $session['user_type'] == "C") {
            Redirect::to('/client-portal')->send();
        }
    }

    public function index($service_id, $page_open, $staff_id){
        //echo $d=cal_days_in_month(CAL_GREGORIAN,2,2017);die;
        $data           = array();
        $clientId       = array();
        $client_data    = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $data['company_details']    = array();

        $data['goto_url']           = "/jobs/".$service_id;
        $data['heading']            = Service::getHeadingName($service_id);
        $data['page_name']          = 'tasks';
        $data['title']              = ucfirst(strtolower($data['heading']));
        $data['previous_page']      = '<a href="/jobs-dashboard">Task Manager</a>';
        $data['service_id']         = $service_id;
        $data['staff_id']           = base64_decode($staff_id);
        $data['page_open']          = base64_decode($page_open);
        $data['encode_page_open']   = $page_open;
        $data['encode_staff_id']    = $staff_id;
        $data['step_id']            = $this->getStepId($service_id, $data['page_open']);
        $data['outer_tabs']         = $this->getOuterTab($service_id);
        $data['logged_user_id']     = $user_id;

        $filter = JobsStaffFilter::getFilteredStaffByServiceId( $service_id );
        if(isset($filter['filtered_staff_id']) && $filter['filtered_staff_id']!=""){
          $staff_id   = $filter['filtered_staff_id'];
        }else{
          $staff_id   = "all";
        }
        $data['staff_id']       = $staff_id;
        $data['staff_details']  = User::getAllStaffDetails();

        if($data['page_open'] != 3){
          $serv = array(1,2,3,4,5,6,7,8,9);
          if( in_array($service_id, $serv) && $data['page_open'] == 1 ){
            //echo 'a';
          }else{
            $serv1 = array(1,3,5,7);
            if( !in_array($service_id, $serv1) && $data['page_open'] == 2 ){
              $data['company_details'] = $this->allClientByService($service_id, $staff_id, $data['page_open']);
            }
          }

          //echo "<pre>";print_r($data['company_details']);die;
          $data['autosend'] = AutosendTask::getDetailsByServiceId( $service_id, 'J' );
          
          /*if($service_id == 7 && $data['page_open'] == 1){//15-06-2017 commented
            $ind_details  = $this->allClientByService( 10, 'all', $data['page_open'] );
            $result = array_merge($data['company_details'], $ind_details);
            $data['company_details'] = array_values($result);
          }*/
          
          $all_count = 0;
          if(isset($data['company_details']) && count($data['company_details']) >0){
            foreach ($data['company_details'] as $key => $details) {
              if(isset($details['manage_task']) && $details['manage_task'] == "Y"){
                $all_count += 1;
                $clientId[] = $details['client_id'];
              }
            }
          }
          $data['all_count']  = $all_count;
        }

        
        if($data['page_open'] == 1){ 
            $data['months']         = Common::get_months();
            $data['headings']       = AllocationHeading::getHeadingByCurrentUserId();
        }else if($data['page_open'] == 3){
          if( $service_id == 7){
            $step_id = JobsStep::getLastStepId($service_id);
            //echo $step_id;die;
            $data['completed_task'] = JobStatus::getCompletedTaskByServiceId( $service_id, $step_id, $clientId );
          }
          $data['old_services']   = Service::where("status","old")->orderBy("service_name")->get();
          $data['new_services']   = Service::where("status","new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
        }else{
          $data['Job_status']         = JobStatus::getJobStatusByServiceId($service_id, $clientId);
          $data['not_started_count']  = $all_count - count($data['Job_status']);
          $data['jobs_start_days']    = JobsStartDate::getJobStartDaysByServiceId($service_id);
          $data['email_templates']    = EmailTemplate::getEmailTemplateByServiceId($service_id);
          $data['email_clients']      = JobsAutosendEmail::getJobsAutosendEmailByServiceId($service_id);

          ///////////////////////////////
          $clientId               = JobsManage::getClientIdByServiceId($service_id);
          $Job_status             = JobStatus::getJobStatusByServiceId($service_id, $clientId);
          $data['all_count']      = JobsManage::getJobCountByServiceId($service_id);
          $data['not_started_count']  = $data['all_count'] - count($Job_status);
        }
        
        $data['client_users']   = User::getInvitedClientId();
        $data['allClients']     = Client::getClientNameAndId();
        $data['jobs_steps']     = JobsStep::getAllJobSteps( $service_id );
         
        //echo "<pre>";print_r($data['jobs_steps']);die;
        return View::make('jobs.index', $data);
    }

    public function get_ajax_data(){
        $service_id = Input::get('service_id');
        $page_open  = base64_decode(Input::get('page_open'));
        $staff_id   = base64_decode(Input::get('staff_id'));
        $length     = Input::get('length');
        $start      = Input::get('start');
        $draw       = Input::get('draw');

        $data       = array();
        
        $results = $this->allClientByService($service_id, $staff_id, $page_open);

        if (isset($length)) {
            $start  = (isset($start) ? $start : 0);
            $data   = array_slice($results, $start, $length);
        }

        foreach ($data as $details) {
            $new_row    = array();
            $ref_day    = isset($details['acc_ref_day'])?$details['acc_ref_day']:'';
            $ref_month  = isset($details['ref_month'])?$details['ref_month']:'';

            $new_row[]  = $details['client_id'];
            $new_row[]  = $details['business_name'];
            $new_row[]  = $ref_day.'-'.$ref_month;
            /*$new_row[]  = (isset($details['contact_persons']) && $details['contact_persons'] != "")?$details['contact_persons']:'';*/
            $new_row[]  = (isset($details['vat_stagger']) && $details['vat_stagger'] != "")?$details['vat_stagger']:'';
            $new_row[]  = $this->getBookkeepingStatus($details['client_id'], $service_id);
            $new_row[]  = (isset($details['jobs_notes']['frequency']) && $details['jobs_notes']['frequency'] != "")?$details['jobs_notes']['frequency']:'';
            $new_row[]  = (isset($details['jobs_notes']['due_date']) && $details['jobs_notes']['due_date'] != '')?$details['jobs_notes']['due_date']:'';
            $new_row[]  = $details['manage_task'];
            $new_row[]  = (isset($details['allocated_staffs']) && $details['allocated_staffs'] != "")?$details['allocated_staffs']:'';
            
            $return_array[] = $new_row;
        }
        //echo "<pre>";print_r($return_array);die;

        if (count($data) == 0) {
            echo '{
                "draw": ' . (isset($draw) ? $draw : '1') . ',
                "recordsTotal": "'.count($results).'",
                "recordsFiltered": "0",
                "data": []
            }';
        } else {
            $return_assoc = array(
                'data'              => $return_array,
                'draw'              => (isset($draw) ? $draw : '1'),
                'recordsTotal'      => count($results),
                'recordsFiltered'   => count($results)
            );
            print_r(json_encode($return_assoc));die;
        }
        /* ============================= */
    }

    public function getBookkeepingStatus($client_id, $service_id)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $JobStatus = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "=", "N")->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->orderBy('job_status_id', 'DESC')->take(4)->get();
        //echo $this->last_query();
        if(isset($JobStatus) && count($JobStatus) >0){
            foreach ($JobStatus as $key => $row) {
                $data[$key]['status_id']   = $row->status_id;
                $data[$key]['client_id']   = $row->client_id;
                $data[$key]['service_id']  = $row->service_id;
                $data[$key]['status_name'] = JobsStep::getStepNameByStepId($row->status_id);
                $data[$key]['created']     = date('d-m-Y', strtotime($row->created));
            }
        }
        //print_r($data);die;
        return $data;
    }

    public function getStepId($service_id, $page_open)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        switch ($page_open) {
            case '23':
                $limit = '0';
                break;
            case '24':
                $limit = '1';
                break;
            case '25':
                $limit = '2';
                break;
            case '26':
                $limit = '3';
                break;
            case '27':
                $limit = '4';
                break;
            case '28':
                $limit = '5';
                break;
            case '29':
                $limit = '6';
                break;
            case '210':
                $limit = '7';
                break;
            default:
                $limit = '';
                break;
        }
        if($limit == ""){
            $step_id = 0;
        }else{
            $steps = JobsStep::whereIn("user_id", $groupUserId)->where('job_id', '=', $service_id)->select('step_id')->orderBy('step_id', 'asc')->skip($limit)->take(1)->first();
            $step_id = $steps['step_id'];
        }
        //echo $this->last_query();die;
        return $step_id;
    }

    public function allClientByService( $service_id, $staff_id, $page_open )
    {
        $data           = array();
        $details        = array();
        $client_array   = array();
        $client_details = array();
        $final_array    = array();

        if(($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id == 6 || $service_id == 7 || $service_id == 8 || $service_id == 9) && $page_open != 1 && $page_open != 3){
            $clients    = JobsManage::getClientIdByServiceId($service_id);
            $manage_ids = JobsManage::getManageIdByServiceId($service_id);
        }else{
            $clients    = ClientService::getClientIdByServiceId($service_id);
        }
        
        
        //echo "<pre>";print_r($clients);die;
        if(isset($clients) && count($clients) >0){
            foreach ($clients as $key => $client_id) {
                $client_details[$key] = Common::clientDetailsById($client_id);
            }
        }
        //echo "<pre>";print_r($client_details);die;
        if($staff_id == "all"){
            if(isset($client_details) && count($client_details) >0){
                foreach ($client_details as $key => $details) {
                    $client_details[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
                    $client_details[$key]['allocated_staffs'] = ClientListAllocation::getAllocatedStaff($details['client_id'], $service_id);
                    $client_details[$key]['jobs_start_days'] = JobsStartDate::getJobStartDaysByServiceId($service_id);
                }
            }
        }else if($staff_id == "none"){
            if(isset($client_details) && count($client_details) >0){
                foreach ($client_details as $key => $details) {
                    $alloc_clients = ClientListAllocation::where("client_id", $details['client_id'])->where("service_id", $service_id)->first();

                    if(isset($alloc_clients) && count($alloc_clients) >0){
                        if($alloc_clients['staff_id1'] != 0 || $alloc_clients['staff_id2'] != 0 || $alloc_clients['staff_id3'] != 0 || $alloc_clients['staff_id4'] != 0 || $alloc_clients['staff_id5'] != 0 ){
                            unset($client_details[$key]);
                        }else{
                            $client_array[$key] = $client_details[$key];
                            $client_array[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
                            $client_array[$key]['allocated_staffs'] = ClientListAllocation::getAllocatedStaff($details['client_id'], $service_id);
                        }
                    }else{
                        $client_array[$key] = $client_details[$key];
                        $client_array[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
                        $client_array[$key]['allocated_staffs'] = ClientListAllocation::getAllocatedStaff($details['client_id'], $service_id);
                    }
                }
            }
            $client_details = array_values($client_array);
        }else{
            if(isset($client_details) && count($client_details) >0){
                foreach ($client_details as $key => $details) {
                    $alloc_clients = ClientListAllocation::where("client_id", "=", $details['client_id'])->where("service_id", "=", $service_id)->first();

                    if(isset($alloc_clients) && count($alloc_clients) >0){
                        if($alloc_clients['staff_id1'] == $staff_id || $alloc_clients['staff_id2'] == $staff_id || $alloc_clients['staff_id3'] == $staff_id || $alloc_clients['staff_id4'] == $staff_id || $alloc_clients['staff_id5'] == $staff_id ){
                            $client_array[$key] = $client_details[$key];

                            $client_array[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
                            $client_array[$key]['allocated_staffs'] = ClientListAllocation::getAllocatedStaff($details['client_id'], $service_id);
                        }
                    }

                }
            }
            $client_details = array_values($client_array);
        }

        //echo "<pre>";print_r($client_details);die;
        if(isset($client_details) && count($client_details) >0){
            $i = 0;
            foreach ($client_details as $key => $client_row) {
                if($client_row['is_deleted'] == 'N' && $client_row['is_archive'] == 'N'){
                    $final_array[$key]  = $client_details[$key];
                    $client_id          = $client_row['client_id'];
                    $count              = isset($client_row['deadacc_count'])?$client_row['deadacc_count']:'0';

                    /*==============AUTO SEND START================*/
                    if($page_open == 1 && $service_id != 2 && $service_id != 4 && $service_id != 6 && $service_id != 7 && $service_id != 8 && $service_id != 9){
                        if($service_id == 1){

                        }else{
                            $days  = AutosendTask::getDaysByServiceId( $service_id, 'J' );

                            if((isset($count) && ($count <= $days) && $days != 0)){
                                JobsManage::updateJobManage($client_id, $service_id);
                            }
                            //echo $days;die;
                        }
                    }
                    /*==============AUTO SEND END================*/
                    
                    if(($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id == 6 || $service_id == 7 || $service_id == 8 || $service_id == 9) && $page_open != 1 && $page_open != 3){
                        $manages = JobsManage::getDetailsByManageId($manage_ids[$i]);
                        $final_array[$key]['job_manage_id'] = $manages['job_manage_id'];
                        $final_array[$key]['manage_task']   = $manages['status'];
                        $final_array[$key]['job_due_date']  = $manages['created'];
                        $final_array[$key]['return_date']   = $manages['return_date'];
                        $final_array[$key]['period_end']    = $manages['period_end'];
                        $i++;
                    }else{
                        $manages = JobsManage::getAllDetails($client_id, $service_id);
                        if(isset($manages['job_manage_id'])){
                            $final_array[$key]['job_manage_id'] = $manages['job_manage_id'];
                        }else{
                            $final_array[$key]['job_manage_id'] = 0;
                        }
                        if(isset($manages['status']) && $manages['status'] == 'Y'){
                            $final_array[$key]['manage_task'] = 'Y';
                            $final_array[$key]['ch_manage_task'] = 'Y';
                        }else{
                            $final_array[$key]['manage_task'] = 'N';
                            $final_array[$key]['ch_manage_task'] = 'N';
                        }
                        if(isset($manages['created'])){
                            $final_array[$key]['job_due_date'] = $manages['created'];
                        }else{
                            $final_array[$key]['job_due_date'] = '';
                        }
                        if(isset($manages['return_date'])){
                            $final_array[$key]['return_date'] = $manages['return_date'];
                        }else{
                            $final_array[$key]['return_date'] = '';
                        }
                        if(isset($manages['period_end'])){
                            $final_array[$key]['period_end'] = $manages['period_end'];
                        }else{
                            $final_array[$key]['period_end'] = '';
                        }
                    }
                    
                    $contact_persons = ContactAddress::get_all_contacts($client_id);
                    $final_array[$key]['contact_persons'] = $contact_persons;

                    $sign_off_date = CrmAccDetail::get_sign_off_date($client_id);
                    $final_array[$key]['sign_off_date'] = $sign_off_date;

                    $acc_details = JobsAccDetail::getDetailsByClientId($client_id);
                    //echo $this->last_query();
                    $final_array[$key]['jobs_acc_details'] = $acc_details;
                    
                    
                    $final_array[$key]['reminders']  = TaskNotification::getColourStatus( $client_id, $service_id, '1' );
                    $final_array[$key]['taskstatus'] = TaskNotification::getColourStatus( $client_id, $service_id, '2' );

                    $final_array[$key]['tasksadded'] = Todolistnewtask::getTaskByRelationClientId($client_id, 'tasks');
                }
            }
        }

        //echo "<pre>";print_r(array_values($final_array));die;
        return array_values($final_array);
    }

    public function getHeadingName($service_id)
    {
        switch ($service_id){
            case 1:
                return 'VAT';
                break;
            case 2:
                return 'EC SALES LIST';
                break;
            case 3:
                return 'ACCOUNTS';
                break;
            case 4:
                return 'BOOKKEEPING';
                break;
            case 5:
                return 'CORPORATION TAX';
                break;
            case 6:
                return 'AUDITS';
                break;
            case 7:
                return 'INCOME TAX RETURNS';
                break;
            case 8:
                return 'MANAGEMENT ACCOUNTS';
                break;
            case 9:
                return 'CONFIRMATION STATEMENT';
                break;
            
        }
    }

    public function getOuterTab($service_id)
    {
        switch ($service_id){
            case 1:
                return 'VAT RETURNS';
                break;
            case 2:
                return 'ECSL';
                break;
            case 3:
                return 'ACCOUNTS';
                break;
            case 4:
                return 'BOOKKEEPING';
                break;
            case 5:
                return 'CORPORATION TAX';
                break;
            case 6:
                return 'AUDITS';
                break;
            case 7:
                return 'INCOME TAX RETURNS';
                break;
            case 8:
                return 'MANAGEMENT ACCOUNTS';
                break;
            case 9:
                return 'ANNUAL RETURNS';
                break;
            
        }
    }
	
	public function dashboard()
  {
		$data['title']        = 'Task Manager';
		$data['heading']      = "TASK MANAGER";
    $data['permission']   = UserPermission::getUserPermission();

		//$data['custom_tasks']      = Service::getCustomTasks('org');
    $data['custom_tasks']      = Service::getAllCustomTasks();
    //echo "<pre>";print_r($data['custom_tasks']);die;
    $data['custom_checklist']  = CustomChecklist::getAllCustomChecklist();
    return View::make('jobs.dashboard', $data);
	}

	public function send_manage_task(){
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

  	$service_id     = Input::get("service_id");
  	$client_id      = Input::get("client_id");
    $client_type    = Client::getClientTypeByClientId($client_id);
    if($client_type == 'ind'){
      $service_id   = 10;
    }

  	$jobs = JobsManage::getAllDetails($client_id, $service_id);

    $data["status"]   = "Y";
    $field_name       = 'next_made_up_to';
    if($service_id == 5){
      $data["next_made_up_to"] = JobsManage::getFieldValue($field_name, 3, $client_id);
      //Common::last_query();die;
    }
    if($service_id == 3){
      $data["next_made_up_to"] = StepsFieldsClient::getFieldValueByClientId($client_id, $field_name);
    }
    //echo $data["next_made_up_to"];die;        
    if(isset($jobs) && count($jobs) >0){
  		JobsManage::where("job_manage_id", $jobs['job_manage_id'])->update($data);
  		$last_id = $jobs['job_manage_id'];
    }else{
      $data["user_id"]    = $user_id;
  		$data["service_id"] = $service_id;
  		$data["client_id"] 	= $client_id;
  		$last_id = JobsManage::insertGetId($data);

      JobsManage::updateJobStartDate($client_id, $service_id, $last_id);
  	}

    /* ========= Email Start ========== */
    JobsEmail::sendEmail($client_id, $service_id, $last_id);
    /* ========= Email End ========== */ 

    echo $last_id;
  }

  public function send_job_to_task(){
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $service_id     = Input::get("service_id");
      $client_id      = Input::get("client_id");

      $jobs = JobsManage::getAllDetails($client_id, $service_id);
      //echo count($jobs);die;
      $data["status"] = "Y";
      if(isset($jobs) && count($jobs) >0){
          JobsManage::where("job_manage_id", $jobs['job_manage_id'])->update($data);
          $last_id = $jobs['job_manage_id'];
      }else{
          $data["user_id"]    = $user_id;
          $data["service_id"] = $service_id;
          $data["client_id"]  = $client_id;
          $last_id = JobsManage::insertGetId($data);

          JobsManage::updateJobStartDate($client_id, $service_id, $last_id);
      }

      /* ========= Email Start ========== */
      JobsEmail::sendEmail($client_id, $service_id, $last_id);
      /* ========= Email End ========== */ 

      echo $last_id;
  }

  public function update_staff_filter()
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

  	$staff_id      = base64_decode(Input::get("staff_id"));	
  	$service_id    = Input::get("service_id");

    $staff_filter = JobsStaffFilter::getFilteredStaffByServiceId($service_id);
    if(isset($staff_filter) && count($staff_filter) >0){
        $ud['filtered_staff_id'] = $staff_id;
        JobsStaffFilter::where('staff_filter_id',$staff_filter['staff_filter_id'])->update($ud);
        //echo $this->last_query();die;
        $last_id = $staff_filter['staff_filter_id'];
    }else{
        $insert_data['user_id']             = $user_id;
        $insert_data['service_id']          = $service_id;
        $insert_data['filtered_staff_id']   = $staff_id;
        $last_id = JobsStaffFilter::insertGetId($insert_data);
    }

  	echo $last_id;
  }

  public function send_global_task()
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $group_id       = $session['group_id'];
    $groupUserId    = $session['group_users'];

    $client_array   = array();
    $update_data    = array();
    $dead_line      = Input::get("dead_line");
    $service_id     = Input::get("service_id");
    if($service_id != 2){
      $data['company_details'] = Client::getClientByServiceId( $service_id );
      //print_r($data['company_details']);
      $all_count = 0;
      $i = 0;
      if(isset($data['company_details']) && count($data['company_details']) >0){
        foreach ($data['company_details'] as $key => $details) {
          if(isset($details['deadacc_count']) && $details['deadacc_count'] <= $dead_line){
            $jobs = JobsManage::getAllDetails($details['client_id'], $service_id);
            $job_data["status"]     = "Y";
            $job_data["user_id"]    = $user_id;
            $job_data["service_id"] = $service_id;
            $job_data["client_id"]  = $details['client_id'];
            //$job_data["created"]    = date("Y-m-d H:i:s");
            if(isset($jobs) && count($jobs) >0){
                JobsManage::where("job_manage_id", $jobs['job_manage_id'])->update($job_data);
                $last_id = $jobs['job_manage_id'];
            }else{
                $last_id = JobsManage::insertGetId($job_data);
            }
            $client_array[$i]['client_id'] = $details['client_id'];
            $i++;
          }
        }
      }
    }
      
    $autosend = AutosendTask::getDetailsByServiceId( $service_id, 'J' );
    $autoData["user_id"]      = $user_id;
    $autoData["group_id"]     = $group_id;
    $autoData['days']         = $dead_line;
    $autoData['service_id']   = $service_id;
    if(isset($autosend) && count($autosend) >0 ){
        AutosendTask::where('autosend_id', $autosend['autosend_id'])->update($autoData);
    }else{
        $autoData['purpose']   = 'J';
        AutosendTask::insert($autoData);
    }
    
    echo json_encode($client_array);
  }


  public function delete_completed_task()
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $client_id  = Input::get("client_id");
    $service_id = Input::get("service_id");
    $task_id    = Input::get("task_id");
    $manage_id  = Input::get("manage_id");

    JobsCompletedTask::where('task_id', $task_id)->delete();

    JobsManage::where("job_manage_id", $manage_id)->delete();

    JobStatus::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->where("client_id", $client_id)->where("job_manage_id", $manage_id)->delete();

    JobsNote::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->delete();
    echo 1;
  }

  public function delete_single_task()
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $client_id  = Input::get("client_id");
    $service_id = Input::get("service_id");
    $manage_id  = Input::get("manage_id");

    $client_type = Client::getClientTypeByClientId($client_id);
    if($client_type == 'ind'){
        $service_id = 10;
    }

    $jobs = JobsManage::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->where("client_id", $client_id)->first();
    if(isset($jobs) && count($jobs) > 0){
        $job_data['filling_date'] =  $jobs['created'];
        JobsCompletedTask::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->where("client_id", $client_id)->update($job_data);
    }

    if($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id == 6 || $service_id == 7 || $service_id == 8){
        
        JobsManage::where("job_manage_id", $manage_id)->delete();
        JobStatus::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->where("client_id", $client_id)->where("job_manage_id", $manage_id)->delete();
    }else{
        JobsManage::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->where("client_id", $client_id)->delete();
        JobStatus::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->where("client_id", $client_id)->delete();
    }
    
    
    $notes = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->first();
    if(isset($notes) && count($notes) > 0){
        $update_data['notes'] =  $notes['notes'];
        JobsCompletedTask::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->where("client_id", $client_id)->update($update_data);
    }

    JobsNote::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->delete();

    
    $taskStatus = JobsManage::getTasksStatusByServiceId($service_id);

    /* ===== delete status name from corporation tasks client details tab ==== */
    JobsCtStatusName::deleteJobStatus($client_id, $service_id);

    echo json_encode($taskStatus);
  }

  /*public function delete_single_task()
  {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $client_id  = Input::get("client_id");
      $service_id = Input::get("service_id");
      $tab        = Input::get("tab");


      $jobs = JobsManage::whereIn("user_id", $groupUserId)->where("service_id", "=", $service_id)->where("client_id", "=", $client_id)->first();
      if(isset($jobs) && count($jobs) >0){
          $del_data['status'] = "N";
          JobsManage::where("job_manage_id", "=", $jobs['job_manage_id'])->update($del_data);
      }

      $job_status = JobStatus::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->where("status_id", "=", 10)->first();
      if( isset($job_status) && count($job_status) >0){
          if($tab == 3){
              JobStatus::where("job_status_id", "=", $job_status['job_status_id'])->delete();
          }else{
              $notes = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();
              if(isset($notes) && count($notes) > 0){
                  $update_data['notes'] =  $notes['notes'];
                  JobsNote::where("jobs_notes_id", $notes['jobs_notes_id'])->update(array('notes'=>''));
              }
              $update_data['is_completed'] =  'Y';
              JobStatus::where("job_status_id", "=", $job_status['job_status_id'])->update($update_data);
          }
          
      }else{
          JobStatus::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("is_completed", "=", "N")->where("service_id", "=", $service_id)->delete();
      }

      

      echo 1;
  }*/

  public function change_job_status()
  { 
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $client_id  = Input::get("client_id");
    $service_id = Input::get("service_id");
    $status_id  = Input::get("status_id");
    $manage_id  = Input::get("manage_id");

    //JobsCompletedTask::saveCompletedTask($client_id,$service_id,$status_id,$manage_id);

    if($service_id==1 || $service_id==2 || $service_id==4 || $service_id==6 || $service_id==7 || $service_id==8){
      $qry = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "N")->where("client_id", $client_id)->where("service_id", $service_id)->where("job_manage_id", $manage_id)->first();
    }else{
      $qry = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "N")->where("client_id", $client_id)->where("service_id", $service_id)->first();
    }
    //Common::last_query();die;

    //Email notification to client and staff user
    JobStatus::sendNotificationToClient($manage_id, $status_id, $service_id, $client_id);

    if(isset($qry) && count($qry) >0){
      $updateData['status_id']    = $status_id;
      JobStatus::where("job_status_id", $qry["job_status_id"])->update($updateData);
      $last_id = $qry["job_status_id"];
    }else{
      $data['user_id']        = $user_id;
      $data['client_id']      = $client_id;
      $data['service_id']     = $service_id;
      $data['status_id']      = $status_id;
      $data['job_manage_id']  = $manage_id;
      $last_id = JobStatus::insertGetId($data);
    }
    JobsCompletedTask::saveCompletedTask($client_id,$service_id,$status_id,$manage_id);
    
    /* =========getting steps and count for each steps============ */  
    $taskStatus = JobsManage::getTasksStatusByServiceId($service_id);

    /* ===== save accounts tasks name to show in corporation tax client details tab ======= */ 
    JobsCtStatusName::saveJobStatus($client_id, $service_id, $status_id);

    /* ========= Deadline date change for custom tasks ============ */ 
    $short_name = JobsStep::getShortNameByStepId($status_id);
    if($short_name == 'filed'){
      JobsAccDetail::updateCustomDeadline($client_id, $service_id);
    }


    echo json_encode($taskStatus);
  }

    public function show_jobs_notes()
    {
      $data = array();
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $client_id      = Input::get("client_id");
      $service_id     = Input::get("service_id");
      $tab            = Input::get("tab");
      $job_status_id  = Input::get("job_status_id");
      $manage_id      = Input::get("manage_id");

        $notes = JobsNote::whereIn("user_id", $groupUserId)->where("job_manage_id", $manage_id)->where("client_id", $client_id)->where("service_id", $service_id)->first();

        if(isset($notes) && count($notes) >0){
          $data['notes'] = $notes['notes'];
        }
        //Common::last_query();

        if( (!isset($data['notes']) || $data['notes'] == "") && $tab == 3){
            $JobStatus  = JobsCompletedTask::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();
            if(isset($JobStatus) && count($JobStatus) >0){
                $data['notes'] = $JobStatus['notes'];
            }
            //echo $this->last_query();
        }
        echo json_encode($data);
    }

    public function save_jobs_notes()
    {
      $data = array();
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];
      $type           = Input::get("type");

      $client_id  = Input::get("client_id");
      $manage_id  = Input::get("manage_id");
      $service_id = Input::get("service_id");

      $notes = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("job_manage_id", $manage_id)->where("service_id", $service_id)->first();

      if($type == "note"){
          $data['notes']     = Input::get("notes");
      }else if($type == "frequency"){
          $data['frequency'] = Input::get("value");
      }else if($type == "due_date"){
          $data['due_date']  = Input::get("value");
      }else{
        $days   = JobsStartDate::getJobStartDaysByServiceId( $service_id );
        $start  = Input::get("job_start_date"); 
        //$data['job_start_date'] = date('Y-m-d H:i:s', strtotime('-'.$days.' days', strtotime($start)));
        $data['job_start_date'] = date('Y-m-d H:i:s', strtotime($start) );

        //$data["job_start_date"] = date('Y-m-d H:i:s', strtotime("+".$days." days")); 
      }
      //echo $data['job_start_date'];

      if(isset($notes) && count($notes) >0){
          JobsNote::where("jobs_notes_id", $notes['jobs_notes_id'])->update($data);
          $last_id = $notes['jobs_notes_id'];
      }else{
          $data['client_id']      = $client_id;
          $data['job_manage_id']  = $manage_id;
          $data['service_id']     = $service_id;
          $data['user_id']        = $user_id;
          $last_id = JobsNote::insertGetId($data);
      }
      //echo "<pre>";print_r($data);die;
      echo $last_id;exit;
    }

    public function save_made_up_date()
    {
      $data = array();
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $client_id  = Input::get("client_id");
      $service_id = Input::get("service_id");
      $field_name = Input::get("field_name");
      $step_id    = Input::get("step_id");

      $client_details = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', $field_name)->select("field_value")->first();

      $data['field_value']   = Input::get("date");
      if(isset($client_details["field_value"]) && $client_details["field_value"] != ""){
        StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', $field_name)->update($data);
      }else{
        $data['user_id']        = $user_id;
        $data['client_id']      = $client_id;
        $data['step_id']        = $step_id;
        $data['field_name']     = $field_name;
        
        StepsFieldsClient::insertGetId($data);
      }
      //echo $this->last_query();
      echo $client_id;exit;
    }

  public function sync_jobs_clients()
  {
    $data = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $client_ids  = Input::get("client_ids");
    //$service_id = Input::get("service_id");

    if(isset($client_ids) && count($client_ids) > 0){
      foreach ($client_ids as $key => $client_id) {
        $company_number = Client::getCompanyNumberByClientId($client_id);
        $value = $company_number."=function";
        if(isset($company_number) && $company_number != "")
          $client_id = App::make("ChdataController")->import_company_details($value);
      }
    }
    return $client_id;
  }
    

    public function save_start_days(){
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $service_id     = Input::get("service_id");
      $days = JobsStartDate::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->first();

      $data["days"] = Input::get("days");
      if(isset($days) && count($days) >0){
        JobsStartDate::where("start_date_id", $days['start_date_id'])->update($data);
        $last_id = $days['start_date_id'];
      }else{
        $data["user_id"]    = $user_id;
        $data["service_id"] = $service_id;
        $last_id = JobsStartDate::insertGetId($data);
      }

      echo $last_id;
    }

    public function save_email_client_days(){
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $data['template_id']    = Input::get("template_id");
        $data['days']           = Input::get("days");
        $data['deadline']       = Input::get("deadline");
        $data['remind_days']    = Input::get("remind_days");
        $service_id             = Input::get("service_id");

        $days = JobsAutosendEmail::whereIn("user_id", $groupUserId)->where("service_id", "=", $service_id)->first();

        if(isset($days) && count($days) >0){
            JobsAutosendEmail::where("autosend_id", "=", $days['autosend_id'])->update($data);
            $last_id = $days['autosend_id'];
        }else{
            $data["user_id"]    = $user_id;
            $data["service_id"] = $service_id;
            $last_id = JobsAutosendEmail::insertGetId($data);
        }

        echo $last_id;
    }

    public function get_all_contacts()
    {
        $data = array();
        $contact_name   = array();
        $relation_name  = array();
        $result         = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id      = Input::get("client_id");
        $template_id    = Input::get("template_id");

        $contact_name   = Client::getContactNameByClientId( $client_id );
        $relation_name  = Client::getRelationNameByClientId( $client_id );

        $data['contact'] = array_merge($contact_name, $relation_name);
        $data['details'] = JobsEmailClient::getJobsEmailClient($client_id, $template_id);

        echo json_encode($data);
        exit;
    }

    public function save_jobs_email()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $goto_url          = Input::get("goto_url");
        $encode_page_open  = Input::get("encode_page_open");
        $encode_staff_id   = Input::get("encode_staff_id");

        $client_id                  = Input::get("template_client_id");
        $data['repeat_days']        = Input::get("repeat_days");
        $data['template_id']        = Input::get("template_id");
        $data['template_name']      = Input::get("template_name");
        $data['template_subject']   = Input::get("template_subject");
        $data['template_message']   = Input::get("template_message");
        $emails                     = Input::get("email");
        if(isset($emails))
            $data['email']          = implode(',', $emails);
        else
            $data['email']          = "";
        $data['created']            = date('Y-m-d H:i:s');
        //print_r($data['email']);die;
        $details = JobsEmailClient::whereIn('user_id', $groupUserId)->where('client_id', '=', $client_id)->first();
        if(isset($details) && count($details) >0){
            JobsEmailClient::where('email_client_id', '=', $details['email_client_id'])->update($data);
            $pd_id = $details['email_client_id'];
        }else{
            $data['user_id']            = $user_id;
            $data['client_id']          = $client_id;
            $pd_id = JobsEmailClient::insertGetId($data);
        }
        
        if ($pd_id) {
            //////////////////file upload start//////////////////
            if (Input::hasFile('template_file')) {
                $file = Input::file('template_file');
                $destinationPath = "uploads/emailTemplates/";
                $fileName = Input::file('template_file')->getClientOriginalName();
                
                $fileName = $pd_id.$fileName;
                $result = Input::file('template_file')->move($destinationPath, $fileName);

                $file_data['attachment'] = $fileName;
                JobsEmailClient::where("email_client_id", "=", $pd_id)->update($file_data);

            }
            /////////////////file upload end////////////////////
            Session::flash('success', 'New email template has been added.');
        }

        if(isset($emails) && count($emails) >0){
            foreach ($emails as $key => $value) {
                $data['email'] = $value;
                $this->send_template($data);
            }
        }
        
        //echo $goto_url.'/'.$encode_page_open.'/'.$encode_staff_id;
        return Redirect::to($goto_url.'/'.$encode_page_open.'/'.$encode_staff_id);
    }

    private function send_template($data) {
        Mail::send('emails.email_template', $data, function ($message) use ($data) {
            $message->from('abel02@icloud.com', 'i-Practice');
            $message->to($data['email'], $data['template_name'])->subject("Welcome to i-Practice");
        });
    }

    public function get_account_details()
    {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $group_id       = $session['group_id'];

      $client_id  = Input::get("client_id");
      $service_id = Input::get("service_id");
      $data = JobsAccDetail::getDetailsByClientAndServiceId($client_id, $service_id);
      if($client_id == 0){
        $d = AutosendTask::where('group_id', $group_id)->where('service_id', $service_id)->select('deadline_date', 'job_name')->first();
        if(isset($d['deadline_date']) && $d['deadline_date']!='0000-00-00'){
          $data['deadline_date'] = date('d-m-Y', strtotime($d['deadline_date']));
        }
        if(isset($d['job_name']) && $d['job_name']!=''){
          $data['job_name'] = $d['job_name'];
        }
      }
      //Common::last_query();die;
      //echo "<pre>";print_r($data);die;
      echo json_encode($data);
    }

    public function ajax_tax_return_period()
    {
      $data       = array();
      $client_id  = Input::get("client_id");
      $action     = Input::get("action");

      if($action == 'TRP'){
        $details    = Common::clientDetailsById($client_id);
        if(isset($details['last_acc_madeup_date']) && $details['last_acc_madeup_date'] != ''){
          $end    = date('d-m-Y', strtotime($details['last_acc_madeup_date']));
          $start  = date('d-m-Y', strtotime('-1 year', strtotime($end)));
          $data['start_date'] = date('d-m-Y', strtotime('+1 day', strtotime($start)));
          $data['end_date']   = $end;
        }else if(isset($details['incorporation_date']) && $details['incorporation_date']!=''){
          $start  = date('d-m-Y', strtotime($details['incorporation_date']));
          $end    = date('d-m-Y', strtotime('+1 year', strtotime($start)));
          $data['start_date'] = $start;
          $data['end_date']   = date('d-m-Y', strtotime('-1 day', strtotime($end)));
        }else{
          $data['start_date'] = '';
          $data['end_date']   = '';
        }
      }else if($action == 'getNextAccountDue'){
        $expDate = StepsFieldsClient::getFieldValueByClientId($client_id, 'next_acc_due');
        if(!empty($expDate)){
          $exp = explode('-', $expDate);
          if( strlen($exp[0]) > 2){
            $expDate = $exp[2].'-'.$exp[1].'-'.$exp[0];
          }
        }
        $data['next_acc_due'] = $expDate;
      }else{
        $details    = JobsAccDetail::getDetailsByClientId($client_id);
        if (isset($details['roll_fwd_start']) && $details['roll_fwd_start'] != ""){
          $start  = $details['roll_fwd_start'];
          $end    = $details['roll_fwd_end'];
          $data['start_date'] = date('d-m-Y', strtotime('+1 year', strtotime($start)));
          $data['end_date']   = date('d-m-Y', strtotime('+1 year', strtotime($end))); 
        }else{
          $data['start_date'] = '';
          $data['end_date']   = '';
        }
      }
      
      echo json_encode($data);
    }

    public function save_account_details()
    {
        $jobs_details    = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id      = Input::get('client_id');
        $service_id     = Input::get('service_id');
        $data_type      = Input::get('data_type');
        $action         = Input::get('action');
        $text           = Input::get('text');

        if($action == 'TRP'){
            $enddate = Input::get('end_date');
            $data['tax_return_start']   = date('Y-m-d', strtotime($text));
            $data['tax_return_end']     = date('Y-m-d', strtotime($enddate));
            $data['roll_fwd_start']     = date('Y-m-d', strtotime($text));
            $data['roll_fwd_end']       = date('Y-m-d', strtotime($enddate));
        }else if($action == 'AUDITS'){
            $completion_date = Input::get('completion_date');
            $data['completion_date']    = date('Y-m-d', strtotime($completion_date));
        }else{
            $enddate = Input::get('end_date');
            $data['roll_fwd_start']     = date('Y-m-d', strtotime($text));
            $data['roll_fwd_end']       = date('Y-m-d', strtotime($enddate));
        }

        $details  = JobsAccDetail::getDetailsByClientAndServiceId($client_id, $service_id);
        if (isset($details) && count($details) >0) {
            JobsAccDetail::whereIn("user_id",$groupUserId)->where('client_id', $client_id)->where('service_id', $service_id)->update($data); 
        }else{
            $data['user_id']    = $user_id;
            $data['client_id']  = $client_id;
            $data['service_id'] = $service_id;
            $data['created']    = date('Y-m-d H:i:s');
            JobsAccDetail::insert($data);
        }
        

        $jobs_details = JobsAccDetail::getDetailsByClientAndServiceId($client_id, $service_id);
        echo json_encode($jobs_details);
    }

    public function save_job_account_details()
    {
      $jobs_details     = array();
      $session          = Session::get('admin_details');
      $user_id          = $session['id'];
      $group_id         = $session['group_id'];
      $groupUserId      = $session['group_users'];

      $client_id        = Input::get('client_id');
      $service_id       = Input::get('service_id');
      $action           = Input::get('action');
      $field_name       = Input::get('field_name');

      if($field_name == 'deadline_date'){
          $DeadlineDate     = Input::get('DeadlineDate');
          $data['deadline_date']    = date('Y-m-d', strtotime($DeadlineDate));
          $data['job_frequency']    = Input::get('job_frequency');;
      }
      if($field_name == 'job_name'){
          $data['job_name'] = Input::get('job_name');
      }

      if($client_id == 0){
        $company_details  = App::make('CustomJobsController')->getAllClientByServiceId($service_id, "all", 1);
        if(isset($company_details) && count($company_details) >0){
          foreach ($company_details as $key => $details) {
            $client_id  = $details['client_id'];
            $deadline   = JobsAccDetail::getDeadlineDateByClientId($client_id, $service_id);
            if (isset($deadline) && $deadline != "") {
              JobsAccDetail::whereIn("user_id",$groupUserId)->where('client_id', $client_id)->where('service_id', $service_id)->update($data); 
            }else{
              $data['user_id']    = $user_id;
              $data['client_id']  = $client_id;
              $data['service_id'] = $service_id;
              $data['created']    = date('Y-m-d H:i:s');
              JobsAccDetail::insert($data);
            }
          }
        }
        /* ============== Heading settings icon popup value save ================= */
        $autoData["user_id"]      = $user_id;
        $autoData["group_id"]     = $group_id;
        $autoData[$field_name]    = $data[$field_name];
        $autoData['service_id']   = $service_id;
        $autosend = AutosendTask::getDetailsByServiceId( $service_id, 'J' );
        if(isset($autosend) && count($autosend) >0 ){
          AutosendTask::where('autosend_id', $autosend['autosend_id'])->update($autoData);
        }else{
          $autoData['purpose']   = 'J';
          AutosendTask::insert($autoData);
        }

      }else{
        $deadline  = JobsAccDetail::getDeadlineDateByClientId($client_id, $service_id);
        if (isset($deadline) && $deadline != "") {
          JobsAccDetail::whereIn("user_id",$groupUserId)->where('client_id', $client_id)->where('service_id', $service_id)->update($data); 
        }else{
          $data['user_id']    = $user_id;
          $data['client_id']  = $client_id;
          $data['service_id'] = $service_id;
          $data['created']    = date('Y-m-d H:i:s');
          JobsAccDetail::insert($data);
        }
      }

      $jobs_details = JobsAccDetail::getDetailsByClientAndServiceId($client_id, $service_id);
      echo json_encode($jobs_details);
    }

    public function save_bookkeeping()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id      = Input::get('client_id');
        $service_id     = Input::get('service_id');
        $repeat_day     = Input::get('repeat_day');
        $first_due_date = Input::get('first_due_date');
        $hrs_wk         = Input::get('hrs_wk');
        $end_date_opt   = Input::get('end_date_opt');

        $data['repeat_day']       = Input::get('repeat_day');
        $data['hrs_wk']           = Input::get('hrs_wk');
        $data['first_due_date']   = date('Y-m-d', strtotime($first_due_date));
        if($end_date_opt != ""){
            $data['end_date_opt'] = date('Y-m-d', strtotime($end_date_opt));
        }

        /* =========== Next send date =========== */
        $data['next_send_date']   = $data['first_due_date'];
        /* =========== Next send date =========== */
        
        //$details   = JobsAccDetail::getDetailsByClientId($client_id);
        $details   = JobsAccDetail::getDetailsByClientAndServiceId($client_id, $service_id);
        if (isset($details) && count($details) >0) {
            JobsAccDetail::where('acc_id', $details['acc_id'])->update($data); 
        }else{
            $data['user_id']    = $user_id;
            $data['client_id']  = $client_id;
            $data['service_id'] = $service_id;
            $data['created']    = date('Y-m-d H:i:s');
            JobsAccDetail::insert($data);
        }

        /* ======== For Auto Send to Task Management ======= */
        App::make('CronJobController')->send_bookkeeping_to_task();

        $jobs_details = JobsAccDetail::getDetailsByClientAndServiceId($client_id, $service_id);
        echo json_encode($jobs_details);
    }

    public function delete_job_freq()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $client_id      = Input::get('client_id');

        $data['repeat_day']       = '';
        $data['hrs_wk']           = '';
        $data['first_due_date']   = '0000-00-00';
        $data['end_date_opt']     = '0000-00-00';
        $data['next_send_date']   = '0000-00-00';
        JobsAccDetail::whereIn("user_id",$groupUserId)->where('client_id',$client_id)->update($data); 
        echo 1;
    }

    public function ajax_vat_stagger()
    {
        $data = array();
        $past_data      = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $client_id      = Input::get('client_id');
        $service_id     = Input::get('service_id');

        if($service_id == 8){
            $details = JobsNote::getNotesByClientAndServiceId($client_id, $service_id);
            $details['vat_stagger'] = isset($details['frequency'])?$details['frequency']:'';
        }else{
            $details = Common::clientDetailsById($client_id);
        }

        if($service_id == 2){
          if(isset($details['ecsl_freq']) && $details['ecsl_freq'] == 'monthly'){
            $full_text  = 'MONTHLY';
            $months     = array('January','February','March','April','May','June','July','August','September','October','November','December');
          }else if(isset($details['ecsl_freq']) && $details['ecsl_freq'] == 'annually'){
              $full_text  = 'YEARLY';
              $months     = array('January','February','March','April','May','June','July','August','September','October','November','December');
          }else if(isset($details['ecsl_freq']) && $details['ecsl_freq'] == 'quarterly'){
              $full_text  = 'Mar-Jun-Sept-Dec';
              $months     = array('March', 'June', 'September', 'December');
          }else{
              $full_text  = '';
              $months     = array();
          }
        }else{
          if(isset($details['vat_stagger']) && $details['vat_stagger'] != 'Choose One' && $details['vat_stagger'] != ''){
            $stagger = explode('-', $details['vat_stagger']);
            $short_month    = ucwords(strtolower($stagger[0]));
            $current_month = date('m');
            if($short_month == 'Jan'){
              $full_text  = 'Jan-April-Jul-Oct';
              $months     = array('January', 'April', 'July', 'October');
            }else if($short_month == 'Feb'){
              $full_text  = 'Feb-May-Aug-Nov';
              $months     = array('February', 'May', 'August', 'November');
            }else if($short_month == 'Mar'){
              $full_text  = 'Mar-Jun-Sept-Dec';
              $months     = array('March', 'June', 'September', 'December');
            }else if($short_month == 'Monthly' || $short_month == 'monthly'){
              $full_text  = 'Monthly';
              $months     = array('January','February','March','April','May','June','July','August','September','October','November','December');
            }

            if($service_id == 1){
              if($details['ret_frequency'] == 'yearly'){
                $full_text  = 'Yearly';
                $months     = array($details['vat_stagger']);
              }
            }

            $past_data  = $this->getMostRecentPastMonth($short_month);
          }else{
            $full_text  = '';
            $months     = array();
          }
        }
        $data['full_text']  = $full_text;
        $data['months']     = $months;
        $data['past_data']  = $past_data;
        echo json_encode($data);
        exit;
    }
    
    public function jobsdownload($service_id, $page_open, $staff_id,$type){
        
        
        $data           = array();
        $clientId       = array();
        $client_data    = array();
        $t                          = time();
        $time                       = date("Y-m-d H:i:s", $t);
        $pieces                     = explode(" ", $time);
        $data['cdate']              = $pieces[0];
        $data['ctime']              = $pieces[1];
        $today                      = date("j F  Y");
        $data['today']              = $today;
        $time                       = date(" G:i:s ");
        $data['time']               = $time;
        $data['company_details']    = array();

        $data['goto_url']           = "/jobs/".$service_id;
        $data['heading']            = $this->getHeadingName($service_id);
        $data['title']              = ucfirst(strtolower($data['heading']));
        $data['previous_page']      = '<a href="/jobs-dashboard">Task Manager</a>';
        $data['service_id']         = $service_id;
        $data['staff_id']           = base64_decode($staff_id);
        $data['page_open']          = base64_decode($page_open);
        $data['encode_page_open']   = $page_open;
        $data['encode_staff_id']    = $staff_id;
        $data['step_id']            = $this->getStepId($service_id, $data['page_open']);
        $data['outer_tabs']         = $this->getOuterTab($service_id);
        
        $filter = JobsStaffFilter::getFilteredStaffByServiceId( $service_id );
        if(isset($filter['filtered_staff_id']) && $filter['filtered_staff_id']!=""){
            $staff_id   = $filter['filtered_staff_id'];
        }else{
            $staff_id   = "all";
        }
        $data['staff_id']       = $staff_id;
        $data['staff_details']  = User::getAllStaffDetails();

        if($service_id != 8){
            $data['company_details'] = $this->allClientByService($service_id, $staff_id, $data['page_open']);
        }
        
        $data['autosend'] = AutosendTask::getDetailsByServiceId( $service_id, 'J' );
        
        if($service_id == 7){
            $ind_details  = $this->allClientByService( 10, 'all', $data['page_open'] );
            $result = array_merge($data['company_details'], $ind_details);
            $data['company_details'] = array_values($result);
        }
        
        $all_count = 0;
        if(isset($data['company_details']) && count($data['company_details']) >0){
            foreach ($data['company_details'] as $key => $details) {
                if(isset($details['manage_task']) && $details['manage_task'] == "Y"){
                    $all_count += 1;
                    $clientId[] = $details['client_id'];
                }
                
            }
        }
        $data['all_count']  = $all_count;
        
        if($data['page_open'] == 1){
            $data['months'] = Common::get_months();
        }else if($data['page_open'] == 3){
            $step_id = JobsStep::getLastStepId($service_id);
            $data['completed_task'] = JobStatus::getCompletedTaskByServiceId( $service_id, $step_id, $clientId );
        }else{
            $data['jobs_steps']  = JobsStep::getAllJobSteps( $service_id );
            $data['Job_status']  = JobStatus::getJobStatusByServiceId($service_id, $clientId);
            $data['not_started_count'] = $all_count - count($data['Job_status']);
            $data['jobs_start_days']= JobsStartDate::getJobStartDaysByServiceId($service_id);
            $data['email_templates']= EmailTemplate::getEmailTemplateByServiceId($service_id);
            $data['email_clients']  = JobsAutosendEmail::getJobsAutosendEmailByServiceId($service_id);
        }
        
        if($type=='pdf'){
            $pdf = PDF::loadView('jobs.jobspdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            return $pdf->download('Jobs.pdf');
        }
        else{
            $viewToLoad = 'jobs/jobsexcel';
            ///////////  Start Generate and store excel file ////////////////////////////
            Excel::create('jobsexcel', function ($excel)use ($data, $viewToLoad)
            {
                $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
                {
                    $sheet->loadView($viewToLoad)->with($data); }
                )->save(); }
            );
            $filepath = storage_path() . '/exports/jobsexcel.xls';
            $fileName = 'jobs.xls';
            $headers = array('Content-Type: application/vnd.ms-excel', );
    
            return Response::download($filepath, $fileName, $headers);
            exit;
        }
        
            
           
        
         
        //echo "<pre>";print_r($data['company_details']);echo "</pre>";die;
        //return View::make('jobs.jobspdf', $data);
    
        
    }

    public function getMostRecentPastMonth($month)
    {
        $data = array();
        $curr = date('M');
        if($month == 'Jan'){
            if($curr == 'Nov' || $curr == 'Dec' || $curr == 'Jan'){
                $data['month']  = 'October';
                if($curr == 'Jan'){
                    $data['year']   = date('Y', strtotime("-1 year", time()));
                }else{
                    $data['year']   = date('Y');
                }
                
            }else if($curr == 'Feb' || $curr == 'Mar' || $curr == 'Apr'){
                $data['month']  = 'January';
                $data['year']   = date('Y');
            }else if($curr == 'May' || $curr == 'Jun' || $curr == 'Jul'){
                $data['month']  = 'April';
                $data['year']   = date('Y');
            }
            else if($curr == 'Aug' || $curr == 'Sep' || $curr == 'Oct'){
                $data['month']  = 'July';
                $data['year']   = date('Y');
            }
        }else if($month == 'Feb'){
            if($curr == 'Dec' || $curr == 'Jan' || $curr == 'Feb'){
                $data['month']  = 'November';
                if($curr == 'Dec'){
                    $data['year']   = date('Y');
                }else{
                    $data['year']   = date('Y', strtotime("-1 year", time()));
                }
            }else if($curr == 'Mar' || $curr == 'Apr' || $curr == 'May'){
                $data['month']  = 'February';
                $data['year']   = date('Y');
            }else if($curr == 'Jun' || $curr == 'Jul' || $curr == 'Aug'){
                $data['month']  = 'May';
                $data['year']   = date('Y');
            }
            else if($curr == 'Sep' || $curr == 'Oct' || $curr == 'Nov'){
                $data['month']  = 'August';
                $data['year']   = date('Y');
            }
        }else if($month == 'Mar'){
            if($curr == 'Jan' || $curr == 'Feb' || $curr == 'Mar'){
                $data['month']  = 'December';
                $data['year']   = date('Y', strtotime("-1 year", time()));
            }else if($curr == 'Apr' || $curr == 'May' || $curr == 'Jun'){
                $data['month']  = 'March';
                $data['year']   = date('Y');
            }else if($curr == 'Jul' || $curr == 'Aug' || $curr == 'Sep'){
                $data['month']  = 'June';
                $data['year']   = date('Y');
            }
            else if($curr == 'Oct' || $curr == 'Nov' || $curr == 'Dec'){
                $data['month']  = 'September';
                $data['year']   = date('Y');
            }
        }else if($month == 'Monthly'){
            if($curr == 'Jan'){
                $data['month']  = 'December';
                $data['year']   = date('Y', strtotime("-1 year", time()));
            }else if($curr == 'Feb'){
                $data['month']  = 'January';
                $data['year']   = date('Y');
            }else if($curr == 'Mar'){
                $data['month']  = 'February';
                $data['year']   = date('Y');
            }else if($curr == 'Apr'){
                $data['month']  = 'March';
                $data['year']   = date('Y');
            }else if($curr == 'May'){
                $data['month']  = 'April';
                $data['year']   = date('Y');
            }else if($curr == 'Jun'){
                $data['month']  = 'May';
                $data['year']   = date('Y');
            }else if($curr == 'Jul'){
                $data['month']  = 'June';
                $data['year']   = date('Y');
            }else if($curr == 'Aug'){
                $data['month']  = 'July';
                $data['year']   = date('Y');
            }else if($curr == 'Sep'){
                $data['month']  = 'August';
                $data['year']   = date('Y');
            }else if($curr == 'Oct'){
                $data['month']  = 'September';
                $data['year']   = date('Y');
            }else if($curr == 'Nov'){
                $data['month']  = 'October';
                $data['year']   = date('Y');
            }else if($curr == 'Dec'){
                $data['month']  = 'November';
                $data['year']   = date('Y');
            }
        }

        return $data;
    }

    public function send_jobs_to_task()
    {
      $ret_data = array();
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $group_id       = $session['group_id'];
      $groupUserId    = $session['group_users'];

      $service_id     = Input::get("service_id");
      $client_id      = Input::get("client_id");
      $last_month     = substr(Input::get("last_month"), 0, 3);
      $full_text      = Input::get("full_text");
      $stagger        = explode('-', $full_text);
      $job_name       = Input::get("last_month");

      if(isset($stagger) && count($stagger) >1){
        $short_month    = ucwords(strtolower($stagger[0]));
        $past_data      = $this->getMostRecentPastMonth($short_month);

        $last_year      = substr($past_data['year'], 2, 2);
        $return_date    = $last_month.'-'.$last_year;
      }else{
        $full_text = strtolower($full_text);
        if($full_text == 'monthly' || $full_text == 'yearly'){
            $last_year      = date('y');
            $return_date    = $last_month.'-'.$last_year;
        }else{
            $return_date    = $full_text;
        }
      }

      $data["status"]         = "Y";
      $data["user_id"]        = $user_id;
      $data["service_id"]     = $service_id;
      $data["client_id"]      = $client_id;
      $data["return_date"]    = $return_date;
      $data["job_name"]       = $job_name;
      $last_id = JobsManage::insertGetId($data);

      JobsManage::updateJobStartDate($client_id, $service_id, $last_id);

      /* ========= Email Start ========== */
      JobsEmail::sendEmail($client_id, $service_id, $last_id);
      /* ========= Email End ========== */ 
      
      echo json_encode($data);
      exit;

    }

    public function check_already_sent()
    {
        $ret_data = array();
        $service_id     = Input::get("service_id");
        $client_id      = Input::get("client_id");
        
        $last_month     = substr(Input::get("last_month"), 0, 3);
        $full_text      = Input::get("full_text");
        $stagger        = explode('-', $full_text);

        if(isset($stagger) && count($stagger) >1){
          $short_month    = ucwords(strtolower($stagger[0]));
          $past_data      = $this->getMostRecentPastMonth($short_month);

          //$last_month     = substr($past_data['month'], 0, 3);
          $last_year      = substr($past_data['year'], 2, 2);
          $return_date    = $last_month.'-'.$last_year;
        }else{
          $return_date    = $full_text;
        }
        
        $jobs = JobsManage::getDetails($client_id, $service_id, $return_date);
        //echo $this->last_query();die;
        if(isset($jobs) && count($jobs) >0){
            $ret_data['return_value'] = 1;
        }else{
            $ret_data['return_value'] = 0;
        }

        echo json_encode($ret_data);
        exit;
    }

    public function ajax_get_taxyear()
    {
        /*$data = array();
        $last_one   = date('Y', strtotime('-1 year', time()));
        $last_two   = date('Y', strtotime('-2 year', time()));
        $last_three = date('Y', strtotime('-3 year', time()));
        $last_four  = date('Y', strtotime('-4 year', time()));

        $last_year[0] = $last_one.'/'.date('y');
        $last_year[1] = $last_two.'/'.substr($last_one, 2,2);
        $last_year[2] = $last_three.'/'.substr($last_two, 2,2);
        $last_year[3] = $last_four.'/'.substr($last_three, 2,2);*/
        
        $last_year = Common::AjaxGetTaxyear();
        $data['year'] = $last_year;
        echo json_encode($data);
        exit;
    }

    public function save_taxyear()
    {
      $data       = array();
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $service_id     = Input::get("service_id");
      $tax_year       = Input::get("tax_year");
      $client_array   = Input::get("client_array");
      if(isset($client_array) && count($client_array) >0){
        foreach ($client_array as $key => $client_id) {
          $client_type = Client::getClientTypeByClientId($client_id);
          if($client_type == 'ind'){
              $service_id = 10;
          }
          $data["status"]         = "Y";
          $data["user_id"]        = $user_id;
          $data["service_id"]     = $service_id;
          $data["client_id"]      = $client_id;
          $data["return_date"]    = $tax_year;
          $data["created"]        = date('Y-m-d H:i:s');
          //$insrtData[] = $data;
          $last_id = JobsManage::insertGetId($data);

          /* ========= Email Start ========== */
          JobsEmail::sendEmail($client_id, $service_id, $last_id);
          /* ========= Email End ========== */ 
        }
      }
      //print_r($insrtData);
      //JobsManage::insert($insrtData);

      //JobsManage::updateJobStartDate($client_id, $service_id);

      
      
      echo json_encode($data);
      exit;
    }

    public function send_audits_job()
    {
        $data       = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $service_id     = Input::get("service_id");
        $client_id      = Input::get("client_id");
        $period_end     = Input::get("period_end");

        $insrtData["status"]         = "Y";
        $insrtData["user_id"]        = $user_id;
        $insrtData["service_id"]     = $service_id;
        $insrtData["client_id"]      = $client_id;
        $insrtData["period_end"]     = date('Y-m-d', strtotime($period_end));
        $insrtData["created"]        = date('Y-m-d H:i:s');
        JobsManage::insert($insrtData);

        echo json_encode($insrtData);
        exit;
    }


    public function save_task_name()
    {
        $data       = array();
        //$stepdata   = array();

        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $group_id       = $session['group_id'];

        $tasks_name     = Input::get("tasks_name");
        $client_type    = Input::get("client_type");
        $ordering       = Service::getLastOrderId('org');

        $insrtData["user_id"]       = $user_id;
        $insrtData["client_type"]   = $client_type;
        $insrtData["client_id"]     = 0;
        $insrtData["service_name"]  = $tasks_name;
        $insrtData["ordering"]      = $ordering+1;
        $insrtData["status"]        = 'new';
        $last_id = Service::insertGetId($insrtData);
        $insrtData["service_id"]    = $last_id;

        for($i=0; $i<8; $i++){
            $j = $i+1;
            $stepdata[$i]['user_id']        = $user_id;
            $stepdata[$i]['group_id']       = $group_id;
            $stepdata[$i]['job_id']         = $last_id;
            $stepdata[$i]['shorting_id']    = $j;
            $stepdata[$i]['title']          = ($j==8)?'Filed':"status ".$j;
            $stepdata[$i]['status']         = 'S';
            $stepdata[$i]['step_type']      = '';
            $stepdata[$i]['short_name']     = ($j==8)?'filed':'';
            $stepdata[$i]['created']        = date('Y-m-d H:i:s');
        }
        //print_r($stepdata);;die;
        JobsStep::insert($stepdata);

        $insrtData['url'] ='/custom-tasks/'.$last_id.'/'.base64_encode('1').'/'.base64_encode('all').'/none/none';
        echo json_encode($insrtData);
        exit;
    }

    public function ajax_taxreturn_details()
    {
        $input          = Input::get();
        $service_id     = $input['service_id'];
           
        $last_year = Common::AjaxGetTaxyear();
        $data['year'] = $last_year;

        //$data['details'] = TaxReturnChecklist::getDetailsByServiceId($service_id);
        //$data['details'] = TaxReturnChecklist::detailsByTaxYearAndServiceId($service_id);

        echo json_encode($data);
        exit;
    }

    public function get_taxreturn()
    {
        $data = array();
        $input          = Input::get();
        $service_id     = $input['service_id'];
        $tax_year       = $input['tax_year'];
        $data['details'] = TaxReturnChecklist::detailsByTaxYear($tax_year, $service_id);

        echo json_encode($data);
        exit;
    }

    public function action_taxreturn_details()
    {
        $input          = Input::get();
        $document_id    = $input['document_id'];
        $action         = $input['action'];

        if($action == 'delete_document'){
            TaxReturnDocument::where('document_id', $document_id)->delete();
        }
        
        echo $document_id;
        exit;
    }

    public function save_taxreturn_checklist()
    {
      $session          = Session::get('admin_details');
      $user_id          = $session['id'];
      $input            = Input::get();
      $action           = $input['action'];

      //$checklist_id   = $input['checklist_id'];
      $service_id       = $input['service_id'];
      //$goto_url       = $input['goto_url'];
      $tax_year         = $input['tax_year'];
      //$encode_page_open   = $input['encode_page_open'];
      //$encode_staff_id    = $input['encode_staff_id'];

      $data['user_id']        = $user_id;
      $data['service_id']     = $service_id;
      $data['tax_year']       = $tax_year;
      $data['remind_days']    = $input['remind_days'];

      $details = TaxReturnChecklist::detailsByTaxYear($tax_year, $service_id);
      if(isset($details) && count($details) >0){
        TaxReturnChecklist::where('checklist_id', '=', $details['checklist_id'])->update($data);
        $last_id = $details['checklist_id'];
      }else{
        $data['created']    = date('Y-m-d H:i:s');
        $last_id = TaxReturnChecklist::insertGetId($data);
      }

      if($action == 'upload'){
          //////////////////file upload start//////////////////
        if (Input::hasFile('tax_document')) {
          $file = Input::file('tax_document');
          $destinationPath = 'uploads/tax_return_doc/';
          $Name = Input::file('tax_document')->getClientOriginalName();
          $fileName = $Name;
          $result = Input::file('tax_document')->move($destinationPath, $fileName);

          $doc_data['document_name']  = $fileName;
          $doc_data['checklist_id']   = $last_id;
          TaxReturnDocument::insertGetId($doc_data);
        }
          /////////////////file upload end////////////////////
      }       
  
      echo $last_id;
      //return Redirect::to($goto_url.'/'.$encode_page_open.'/'.$encode_staff_id);
    }
    
    public function notification_modal()
    {
      $data       = array();
      $session    = Session::get('admin_details');
      $user_id    = $session['id'];
      
      $related    = array();
      $input      = Input::get();
      $action     = $input['action'];
      $service_id = $input['service_id'];
      $client_id  = $input['client_id'];
          
      if($action == 'getData'){
        $relations = Client::getRelationClientByClientId($client_id);
        if(isset($relations) && count($relations) >0){
          $i = 0;
          foreach ($relations as $key => $v) {
            if(isset($v['client_type']) && $v['client_type'] == 'ind'){
              $related[$i]['client_id']    = $v['client_id'];
              $related[$i]['client_type']  = $v['client_type'];
              $related[$i]['client_name']  = $v['client_name'];
              $related[$i]['client_email'] = Client::getEmail($v['client_id'], $v['client_type']);
              $i++;
            }
          }
        }
          
        $data['reminders']  = TaskNotification::getColourStatus( $client_id, $service_id, '1' );
        $data['taskstatus'] = TaskNotification::getColourStatus( $client_id, $service_id, '2' );

        $data['emailCount'] = JobsEmail::getCountByClientAndServiceId($client_id, $service_id);
        $data['msgCount']   = NotificationFrequency::getCountByClientAndServiceId($client_id, $service_id, 1);
            
      }else if($action == 'saveEmail'){
        $client_id      = $input['client_id'];
        $client_email   = $input['client_email'];
        $email_type     = $input['email_type'];
        
        if($email_type == 'normal'){
          $edtdata['field_value'] = $client_email;
          $details = StepsFieldsClient::where('client_id', $client_id)->where('field_name', 'res_email')->first();
          if(isset($details) && count($details) >0){
            StepsFieldsClient::where('client_id', $client_id)->where('field_name', 'res_email')->update($edtdata);
          }else{
            $edtdata['user_id']     = $user_id;
            $edtdata['client_id']   = $client_id;
            $edtdata['step_id']   = 3;
            $edtdata['field_name']  = 'res_email';
            $edtdata['created']   = date('Y-m-d H:i:s');
            StepsFieldsClient::insert($edtdata);
          }
        }else{
          $edtdata['email'] = $client_email;
          $details = NotificationEmail::getDetailsByServiceId( $client_id, $service_id );
          if(isset($details) && count($details) >0){
            NotificationEmail::where('id', $details['id'])->update($edtdata);
          }else{
            $edtdata['user_id']     = $user_id;
            $edtdata['client_id']   = $client_id;
            $edtdata['service_id']  = $service_id;
            $edtdata['created']   = date('Y-m-d H:i:s');
            NotificationEmail::insert($edtdata);
          }
        }
      }
        
      $data['relations']      = $related;
      $data['heading']        = Client::getClientNameByClientId($client_id);
      $data['other_email']    = NotificationEmail::getNotificationEmail($client_id, $service_id);
      $data['job_steps']      = JobsStep::getAllJobSteps($service_id);
      $data['freq_details']   = NotificationFrequency::getDetails($service_id, $client_id);
      
      echo json_encode($data);
    }


    public function delete_client_from_tasks()
    {
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];

      $input          = Input::get();
      $client_id      = $input['client_id'];
      $client_type    = $input['client_type'];
      $service_id     = $input['service_id'];

      ClientService::where('client_id', $client_id)->where('service_id', $service_id)->delete();
      ClientListAllocation::whereIn("user_id", $groupUserId)->where('client_id', $client_id)->where('service_id', $service_id)->delete();
      echo 1;
    }


    public function ajax_tasks_table_data()
    {
      $input          = Input::get();
      $page_open      = $input['tab_no'];
      $staff_id       = $input['staff_id'];
      $service_id     = $input['service_id'];
      $data           = array();
      $clientId       = array();
      $client_data    = array();
      $data['company_details']    = array();

      $data['goto_url']           = "/jobs/".$service_id;
      $data['heading']            = $this->getHeadingName($service_id);
      $data['title']              = ucfirst(strtolower($data['heading']));
      $data['previous_page']      = '<a href="/jobs-dashboard">Task Manager</a>';
      $data['service_id']         = $service_id;
      $data['staff_id']           = base64_decode($staff_id);
      $data['page_open']          = base64_decode($page_open);
      $data['encode_page_open']   = $page_open;
      $data['encode_staff_id']    = $staff_id;
      $data['step_id']            = $this->getStepId($service_id, $data['page_open']);
      $data['outer_tabs']         = $this->getOuterTab($service_id);

      $filter = JobsStaffFilter::getFilteredStaffByServiceId( $service_id );
      if(isset($filter['filtered_staff_id']) && $filter['filtered_staff_id']!=""){
        $staff_id   = $filter['filtered_staff_id'];
      }else{
        $staff_id   = "all";
      }
      $data['staff_id']       = $staff_id;
      $data['staff_details']  = User::getAllStaffDetails();

      if($service_id == 8 && $data['page_open'] == 1){
          
      }else{
        $data['company_details'] = $this->allClientByService($service_id, $staff_id, $data['page_open']);
      }
      
      $data['autosend'] = AutosendTask::getDetailsByServiceId( $service_id, 'J' );
        
      if($service_id == 7 && $data['page_open'] == 1){
        $ind_details  = $this->allClientByService( 10, 'all', $data['page_open'] );
        $result = array_merge($data['company_details'], $ind_details);
        $data['company_details'] = array_values($result);
      }

      $all_count = 0;
      if(isset($data['company_details']) && count($data['company_details']) >0){
        foreach ($data['company_details'] as $key => $details) {
          if(isset($details['manage_task']) && $details['manage_task'] == "Y"){
            $all_count += 1;
            $clientId[] = $details['client_id'];
          }
            
        }
      }
      $data['all_count']  = $all_count;
        
      if($data['page_open'] == 1){
          $data['months'] = Common::get_months();
      }else if($data['page_open'] == 3){
          $step_id = JobsStep::getLastStepId($service_id);
          $data['completed_task'] = JobStatus::getCompletedTaskByServiceId( $service_id, $step_id, $clientId );
      }else{
          $data['jobs_steps']         = JobsStep::getAllJobSteps( $service_id );
          $data['Job_status']         = JobStatus::getJobStatusByServiceId($service_id, $clientId);
          $data['not_started_count']  = $all_count - count($data['Job_status']);
          $data['jobs_start_days']    = JobsStartDate::getJobStartDaysByServiceId($service_id);
          $data['email_templates']    = EmailTemplate::getEmailTemplateByServiceId($service_id);
          $data['email_clients']      = JobsAutosendEmail::getJobsAutosendEmailByServiceId($service_id);
      }
      
      $data['client_users'] = User::getInvitedClientId();
      
      
      //print_r($data);die;
      echo View::make('jobs.includes.second_tab', $data);
    }


    public function tasks_action()
    {
      $data   = array();
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $input          = Input::get();
      //$task_name      = $input['task_name'];
      $client_id      = $input['client_id'];
      $action         = $input['action'];
      $service_id     = $input['service_id'];
      $manage_id      = $input['manage_id'];

      if($action == 'getClientById'){
        $data = Common::clientDetailsById($client_id);
        //$notes = JobsNote::getNotesByClientAndServiceId($client_id, $service_id);
        $notes = JobsNote::getJobsNoteByJobManageId($manage_id);
        $data['jobs_notes'] = $notes;

        if(isset($notes['job_start_date']) && $notes['job_start_date'] != ""){
          $data['job_start_date'] = date('d-m-Y', strtotime($notes['job_start_date']));
          $data['job_start_time'] = date('H:i', strtotime($notes['job_start_date']));
        }else{
          $data['job_start_date'] = date('d-m-Y');
          $data['job_start_time'] = date('H:i');
        }
      }else if($action == 'getChaserDetails'){
        $data['details']    = JobsChaserEmail::getDetailsByJobManageId($manage_id);
        $data['res_email']  = Client::getEmail($client_id, 'ind');
      }else if($action == 'saveChaserDetails'){
        $id = JobsChaserEmail::saveChaserDetails($input);
        $data['details'] = JobsChaserEmail::getDetailsById($id);
      }

      echo json_encode($data);
      exit;
    }

    public function tasks_email()
    {
      $session      = Session::get('admin_details');
      $groupUserId  = $session['group_users'];

      $action       = Input::get("action");
      $service_id   = Input::get("service_id");
      $client_id    = Input::get("client_id");

      if($action == 'add'){
        $data['email']        = Input::get("email");
        $data['user_id']      = $session['id'];
        $data['service_id']   = $service_id;
        $data['client_id']    = $client_id;
        $data['created']      = date('Y-m-d H:i:s');
        $data['id'] = JobsEmail::insertGetId($data);
      }
      if($action == 'delete'){
        $id = Input::get("id");
        JobsEmail::where('id', $id)->delete();
        $data['id'] = $id;
      }
      $data['msgCount']=NotificationFrequency::getCountByClientAndServiceId($client_id,$service_id,1);
      if($data['msgCount'] <= 0){
        TaskNotification::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->delete();
      }
      echo json_encode($data);
      exit();
    }
    

}
