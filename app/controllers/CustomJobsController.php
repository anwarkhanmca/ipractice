<?php
class CustomJobsController extends BaseController {
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

	public function index($service_id, $page_open, $staff_id, $field1, $field2)
    {
      ini_set('memory_limit', '-1');
      $admin_s          = Session::get('admin_details');
      $user_id          = $admin_s['id'];
      $groupUserId      = $admin_s['group_users'];
      $clientId         = array();
      $data             = array();
      $company_details  = array();

      $heading                    = Service::getNameServiceId($service_id);
      $data['heading']            = '<span id="taskTitleSpan">'.$heading.'</span> <a href="javascript:void(0)" class="openEditJobPop"><img src="/img/edit_icon.png"></a>';
      $data['page_name']          = 'tasks';
      $data['goto_url']           = "/custom-tasks/".$service_id;
      $data['title']              = ucfirst(strtolower($heading));
      $data['previous_page']      = '<a href="/jobs-dashboard">Task Manager</a>';
      $data['service_id']         = $service_id;
      $data['staff_id']           = base64_decode($staff_id);
      $data['page_open']          = base64_decode($page_open);
      $data['encode_page_open']   = $page_open;
      $data['encode_staff_id']    = $staff_id;
      $data['step_id']            = JobsStep::getStepId($service_id, $data['page_open']);

      //echo $data['staff_id'];die;

      /* custom field section */
      if($data['page_open'] == '1'){
          CustomTasksTableHeading::manageCustomTaskTableHeading($service_id, $field1, $field2);
      }else{
        $headings = CustomTasksTableHeading::getDetailsByServiceId( $service_id );
        $field1 = (isset($headings['field1']) && $headings['field1']!='')?$headings['field1']:'none';
        $field2 = (isset($headings['field2']) && $headings['field2']!='')?$headings['field2']:'none';
      }
      $data['field1']             = $field1;
      $data['field2']             = $field2;
      $data['headfield1']         = Common::getCorrectFieldName($field1);
      $data['headfield2']         = Common::getCorrectFieldName($field2);
      //echo $data['headfield1'];die;
      /* custom field section */

      $filter = JobsStaffFilter::getFilteredStaffByServiceId( $service_id );
      if(isset($filter['filtered_staff_id']) && $filter['filtered_staff_id']!=""){
          $staff_id   = $filter['filtered_staff_id'];
      }else{
          $staff_id   = "all";
      }

      $all_count = 0;
      $task_count = 0;
      if($data['page_open'] != '2'){
        $company_details = $this->getAllClientByServiceId($service_id,$staff_id,$data['page_open']);
      }
      //echo "<pre>";print_r($company_details);die;
      if(isset($company_details) && count($company_details) >0){
        foreach ($company_details as $key => $details) {
          $all_count += 1;
          $clientId[] = $details['client_id'];
          if(isset($details['manage_task']) && $details['manage_task'] == "Y"){
            $task_count ++;
          }

          $field1value = StepsFieldsClient::getAddressIdByClientId($details['client_id'], $field1);
          $company_details[$key]['field1_value'] = $field1value;
          $field2value = StepsFieldsClient::getAddressIdByClientId($details['client_id'], $field2);
          $company_details[$key]['field2_value'] = $field2value;

          $deadlinedate = JobsAccDetail::getDeadlineDateByClientId($details['client_id'],$service_id);
          if($deadlinedate == ''){
            $company_details[$key]['count_down'] = '-';
          }else{
            $company_details[$key]['count_down'] = JobsAccDetail::getCountDown($deadlinedate);
          }
        }
      }
      $data['company_details'] = $company_details;

      if($data['page_open'] == 'completed'){
        //$data['completed']  = JobsCompletedTask::getCompletedTask( $service_id, $staff_id );
        $data['completed'] = JobStatus::getCompletedTaskByServiceId( $service_id, $service_id, $clientId );
        $data['old_services']  = Service::where("status", "old")->orderBy("service_name")->get();
        $data['new_services']  = Service::where("status", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
      }

      $data['staff_id']       = $staff_id;
      $data['staff_details']  = User::getAllStaffDetails();
      $data['jobs_steps']     = JobsStep::getAllJobSteps( $service_id );
      
      $data['Job_status']     = JobStatus::getJobStatusByServiceId($service_id, $clientId);
      $data['table_heading']  = TaskTableHeading::getHeadingName($service_id);

      $data['field_names']    = Common::getFieldName('org');
      $data['allClients']     = Client::getClientNameAndId();
      $data['headings']       = AllocationHeading::getHeadingByCurrentUserId();


      /////////////// New Added ////////////////
      if($data['page_open'] == 2){
        $clientId               = JobsManage::getClientIdByServiceId($service_id);
        $Job_status             = JobStatus::getJobStatusByServiceId($service_id, $clientId);
        $data['all_count']      = JobsManage::getJobCountByServiceId($service_id);
        $data['not_started_count']  = $data['all_count'] - count($Job_status);
      }
      if($data['page_open'] == 3){
        $data['old_services']   = Service::where("status","old")->orderBy("service_name")->get();
        $data['new_services']   = Service::where("status","new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
      }

    	//echo "<pre>";print_r($data['company_details']);die;
    	return View::make('jobs.custom_tasks.index', $data);
	  }

    public function get_all_clients()
    {
        $data = array();
        $client_type    = Input::get('client_type');
        $service_id     = Input::get('service_id');
        $search_value   = Input::get('search_value');

        $client_details = Client::getAllClientsByType($client_type, $search_value);

        //print_r($client_details);die;
        if(isset($client_details) && count($client_details) >0){
            foreach ($client_details as $key => $value) {
                $serviceId = ClientService::checkServiceIdByClientId($value['client_id'], $service_id);
                //echo $this->last_query();
                if($serviceId != ''){
                    unset($client_details[$key]);
                }
            }
        }

        $data['client_details'] = $client_details;
        //print_r($client_details);die;
        echo json_encode($data);
        exit;
    }

    public function allClientByServiceId( $service_id, $staff_id, $page_open )
    {
        $fa    = array();
        $details        = array();
        $client_details = array();
        $filter_details = array();

        $clients    = JobsManage::getClientIdByServiceId($service_id);
        //print_r($clients);die;
        $manage_ids = JobsManage::getManageIdByServiceId($service_id);
        if(isset($clients) && count($clients) >0){
          foreach ($clients as $key => $client_id) {
            $details[$key] = Common::clientDetailsById($client_id);
          }
        }

        $client_details = Client::getClientFilterByStaffId($details, $service_id, $staff_id);

        if(isset($client_details) && count($client_details) >0){
          $i = 0;
          foreach ($client_details as $k => $client_row) {
            if($client_row['is_deleted'] == 'N' && $client_row['is_archive'] == 'N'){
              $fa[$k]  = $client_details[$k];
              $client_id              = $client_row['client_id'];
              $fa[$k]['client_name']  = Client::getClientNameByClientId($client_id);

              $manages = JobsManage::getDetailsByManageId($manage_ids[$i]);
              $fa[$k]['job_manage_id'] = $manages['job_manage_id'];
              $fa[$k]['manage_task']   = $manages['status'];
              $fa[$k]['job_due_date']  = $manages['created'];
              $fa[$k]['return_date']   = $manages['return_date'];
              $fa[$k]['period_end']    = $manages['period_end'];

              $step_name = JobStatus::getStatusNameByClientId($client_id, $service_id);
              $fa[$k]['status_name']   = $step_name;

              $fa[$k]['reminders']  = TaskNotification::getColourStatus($client_id,$service_id,'1');
              $fa[$k]['taskstatus'] = TaskNotification::getColourStatus($client_id,$service_id,'2');

              $fa[$k]['tasksadded'] = Todolistnewtask::getTaskByRelationClientId($client_id,'tasks');
            }
          $i++;
          }
        }

        return $fa;
    }
    
    public function getAllClientByServiceId( $service_id, $staff_id, $page_open )
    {
      $fa    = array();
      $details        = array();
      $client_details = array();
      $filter_details = array();

      $clients    = ClientService::getClientIdByServiceId($service_id);
      //print_r($clients);die;
      //$manage_ids = JobsManage::getManageIdByServiceId($service_id);
      if(isset($clients) && count($clients) >0){
        foreach ($clients as $key => $client_id) {
          $details[$key] = Common::clientDetailsById($client_id);
        }
      }

      $client_details = Client::getClientFilterByStaffId($details, $service_id, $staff_id);
      //print_r($client_details);die;
      if(isset($client_details) && count($client_details) >0){
        $i = 0;
        foreach ($client_details as $k => $client_row) {
          if($client_row['is_deleted'] == 'N' && $client_row['is_archive'] == 'N'){
            $fa[$k]  = $client_details[$k];
            $client_id                = $client_row['client_id'];
            $fa[$k]['client_name']  = Client::getClientNameByClientId($client_id);
            
            $fa[$k]['manage_task']  = JobsManage::getTaskManagement($client_id, $service_id);

            $manages = JobsManage::getAllDetails($client_id, $service_id);
            if(isset($manages['job_manage_id'])){
                $fa[$k]['job_manage_id'] = $manages['job_manage_id'];
            }else{
                $fa[$k]['job_manage_id'] = 0;
            }

            $fa[$k]['status_name']  = JobStatus::getStatusNameByClientId($client_id, $service_id);
            $fa[$k]['status_id']    = JobStatus::getStatusIdByClientId($client_id, $service_id, 'N');

            $acc_details = JobsAccDetail::getDetailsByClientAndServiceId($client_id, $service_id);
            $fa[$k]['jobs_acc_details'] = $acc_details;

            $fa[$k]['reminders']    = TaskNotification::getColourStatus($client_id,$service_id,'1');
            $fa[$k]['taskstatus']   = TaskNotification::getColourStatus($client_id,$service_id,'2');
            $fa[$k]['tasksadded']   = Todolistnewtask::getTaskByRelationClientId($client_id,'tasks');
          }
        $i++;
        }
      }
      //echo "<pre>";print_r($client_details);die;
      return $fa;
    }
    
    public function client_details_by_tab($final_array, $page_open, $service_id)
    {
        $filter_details = array();
        $step_id = JobsStep::getStepId($service_id, $page_open);//echo $step_id;die;
        if(isset($final_array) && count($final_array) >0){
            foreach ($final_array as $key => $value) {
                if($page_open == 1){
                    $filter_details[$key]  = $final_array[$key];
                }else if($page_open == 2){
                    $task_status = JobsManage::getTaskManagement($value['client_id'], $service_id);
                    if(isset($task_status) && $task_status == 'Y'){
                        $filter_details[$key]  = $final_array[$key];
                    }
                }else if($page_open == 'completed'){
                    $filter_details = array();
                }else{
                    $statuses = JobStatus::detailsByServiceClientStatusId($service_id, $step_id, $value['client_id']);
                    //echo $this->last_query();
                    if(isset($statuses) && count($statuses) >0){
                        $filter_details[$key]  = $final_array[$key];
                    }
                }
            }
        }
        return $filter_details;
    }

    /*public function client_details_by_tab($final_array, $page_open, $service_id)
    {
        $filter_details = array();
        $step_id = JobsStep::getStepId($service_id, $page_open);
        if(isset($final_array) && count($final_array) >0){
            foreach ($final_array as $key => $value) {
                if(isset($value['manage_task']) && $value['manage_task'] == "Y"){
                    if($page_open == 1){
                        $filter_details[$key]  = $final_array[$key];
                    }else if($page_open == 2){
                        if(!isset($value['job_status'][$value['job_manage_id']]['status_id'])){
                            $filter_details[$key]  = $final_array[$key];
                        }
                        
                    }else if($page_open == 'completed'){
                        $filter_details = array();
                    }else{
                        if(isset($value['job_status'][$value['job_manage_id']]['status_id']) && $value['job_status'][$value['job_manage_id']]['status_id'] == $step_id){
                            $filter_details[$key]  = $final_array[$key];
                        }
                    }
                }
            }
        }
        return $filter_details;
    }*/

    public function get_ajax_datatable()
    {
        $input = Input::get();

        $service_id = $input['service_id'];
        $page_open  = $input['page_open'];
        $staff_id   = base64_decode($input['staff_id']);
        $length     = $input['length'];
        $start      = $input['start'];
        $draw       = $input['draw'];

        $searchString = "'" . str_replace(",", "','", $input['search']['value'])."'";

        $data       = array();
        $jobs_steps = array();
        $jobs_steps = JobsStep::getAllJobSteps( $service_id );
        
        //$result = $this->allClientByServiceId($service_id, $staff_id, $page_open);
        $result = $this->getAllClientByServiceId($service_id, $staff_id, $page_open);

        $results = $this->client_details_by_tab($result, $page_open, $service_id);
        //echo "<pre>";print_r($results);die;

        if (isset($length)) {
            $start  = (isset($start) ? $start : 0);
            $data   = array_slice($results, $start, $length);
        }

        foreach ($data as $details) {
            $new_row    = array();

/* 0 */     $new_row[]  = $details['client_id'];
            $new_row[]  = $details['client_name'];
            $new_row[]  = '';
            $new_row[]  = TaskTableHeading::getHeadingName($service_id);;
            $new_row[]  = (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != '')?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):'';
            $new_row[]  = '';
            //$new_row[]  = $jobs_steps;
            $new_row[]  = isset($details['job_manage_id'])?$details['job_manage_id']:'';
            $new_row[]  = (isset($details['allocated_staffs']) && $details['allocated_staffs'] != "")?$details['allocated_staffs']:'';
            
/* 9 */     $new_row[]  = isset($details['status_id'])?$details['status_id']:2;
            $new_row[]  = isset($details['manage_task'])?$details['manage_task']:'N';
            $new_row[]  = isset($details['type'])?$details['type']:'';

            
            $return_array[] = $new_row;
        }

        //print_r($return_array);die;

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

    public function custom_task_action()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];

        $input          = Input::get();
        $action         = $input['action'];
        $last_id        = 0;
        
        if($action == 'delete'){
            $where['client_id']     = $input['client_id'];
            $where['service_id']    = $input['service_id'];
            $page_open              = $input['page_open'];
            //if(isset($page_open) && $page_open == 1){
                ClientService::where($where)->delete();
            //}
            JobsManage::where($where)->delete();
            JobStatus::where($where)->delete();

        }else if($action == 'delete_completed'){
            JobsCompletedTask::where('task_id', '=', $input['task_id'])->delete();
        }else if($action == 'add_heading'){
            $heading_id = $input['heading_id'];

            $data['user_id']        = $user_id;
            $data['service_id']     = $input['service_id'];
            $data['step_id']        = $input['step_id'];
            $data['heading']        = $input['heading'];
            $data['field_type']     = $input['field_type'];
            $data['select_option']  = $input['select_option'];
            if($heading_id == 0){
                $data['created']    = date('Y-m-d H:i:s');
                $last_id = TaskTableHeading::insertGetId($data);
            }else{
                TaskTableHeading::where('heading_id', '=', $heading_id)->update($data);
                $last_id = $heading_id;
            }
        }
        echo $last_id;
        
    }
    
    public function send_jobs_to_task()
    {
      $ret_data = array();
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];
      $input = Input::get();
      
      $service_id   = $input['service_id'];
      $page_open    = $input['page_open'];
      $client_id    = $input['client_id'];
      
      //$step_id = JobsStep::getStepId($service_id, $page_open);
      
      $data["status"]         = "Y";
      $data["user_id"]        = $user_id;
      $data["service_id"]     = $service_id;
      $data["client_id"]      = $client_id;
      //$data["return_date"]    = $return_date;
      $last_id = JobsManage::jobSendToTask($client_id, $service_id);

      JobsManage::updateJobStartDate($client_id, $service_id, $last_id);

      /* ========= Email Start ========== */
      JobsEmail::sendEmail($client_id, $service_id, $last_id);
      /* ========= Email End ========== */ 
      
      echo json_encode($ret_data);
      exit;

    }

    public function delete_task_name()
    {
        $input          = Input::get();
        $service_id     = $input['service_id'];
        $action         = $input['action'];

        $where['service_id'] = $service_id;
        Service::where($where)->delete();
        JobsManage::where($where)->delete();
        JobStatus::where($where)->delete();
        ClientService::where($where)->delete();
        JobsStep::where('job_id', '=', $service_id)->delete();

        echo json_encode($where);
        exit;
    }

    public function change_task_status()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get("client_id");
        $service_id = Input::get("service_id");
        $status_id  = Input::get("status_id");
        $manage_id  = Input::get("manage_id");

        $qry = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "=", "N")->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();

        if($status_id == 'completed'){
            $last_id = 0;
            if(isset($qry) && count($qry) >0){
                $status_id = $qry["job_status_id"];
                $last_id = $qry["job_status_id"];
            }
            JobsCompletedTask::customCompletedTask($client_id,$service_id,$status_id,$manage_id);
        }else{
            if(isset($qry) && count($qry) >0){
                $updateData['status_id']        = $status_id;
                JobStatus::where("job_status_id", "=", $qry["job_status_id"])->update($updateData);
                $last_id = $qry["job_status_id"];
            }else{
                $data['user_id']        = $user_id;
                $data['client_id']      = $client_id;
                $data['service_id']     = $service_id;
                $data['status_id']      = $status_id;
                $data['job_manage_id']  = $manage_id;
                $last_id = JobStatus::insertGetId($data);
            }
        }
        
        echo $last_id;
    }

    public function download($service_id, $page_open, $staff_id, $type)
    {
        $staff_id           = base64_decode($staff_id);
        $page_open          = base64_decode($page_open);

        $results = $this->allClientByServiceId($service_id, $staff_id, $page_open);
        $data['company_details'] = $results;

        if($type == 'pdf'){
            $pdf = PDF::loadView('jobs.custom_tasks.pdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            return $pdf->download('jobs.pdf');
        }
        else{
            $viewToLoad = 'jobs.custom_tasks.pdf';
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
    }

    public function task_details_by_id()
    {
        $data = array();
        $service_id = Input::get('service_id');
        $service_name = Service::getNameServiceId( $service_id );
        $data['service_name'] = $service_name;

        echo json_encode($data);
        exit;
    }

    public function save_task_details()
    {
        $data = array();
        $service_id     = Input::get('service_id');
        $service_name   = Input::get('service_name');

        $data['service_name'] = $service_name;
        Service::where('service_id', '=', $service_id)->update($data);
        echo json_encode($data);
        exit;
    }

    
    

}
