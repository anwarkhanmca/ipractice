<?php
class ChAnnualReturnController extends BaseController {
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

	public function index($service_id, $page_open, $staff_id){
		$data           = array();
        $clientId       = array();
        $client_data    = array();
        $data['company_details']    = array();

		$data['goto_url']			= "/ch-annual-return/".$service_id;
		$data['heading']            = App::make('JobsController')->getHeadingName($service_id);
        $data['title']              = ucfirst(strtolower($data['heading']));
        $data['previous_page']      = '<a href="/jobs-dashboard">Task Manager</a>';
        $data['service_id']         = $service_id;
        $data['staff_id']           = base64_decode($staff_id);
        $data['page_open']          = base64_decode($page_open);
        $data['encode_page_open']   = $page_open;
        $data['encode_staff_id']    = $staff_id;
        $data['step_id']            = App::make('JobsController')->getStepId($service_id, $data['page_open']);
        $data['outer_tabs']         = App::make('JobsController')->getOuterTab($service_id);
		
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 		= $session['group_users'];

		$filter = JobsStaffFilter::getFilteredStaffByServiceId( $service_id );
        if(isset($filter['filtered_staff_id']) && $filter['filtered_staff_id']!=""){
            $staff_id   = $filter['filtered_staff_id'];
        }else{
            $staff_id   = "all";
        }
        $data['staff_id']       = $staff_id;
        $data['staff_details']  = User::getAllStaffDetails();


		$data['company_details'] = App::make('JobsController')->allClientByService($service_id, $staff_id, $data['page_open']);
		
		$all_count = 0;
		if(isset($data['company_details']) && count($data['company_details']) >0){
			foreach ($data['company_details'] as $key => $details) {
				//if($data['page_open'] == 21){
					$autosend = AutosendTask::whereIn("user_id", $groupUserId)->where('service_id', '=', $data['service_id'])->first();
					if(isset($autosend) && count($autosend) >0 ){
						if((isset($details['deadret_count']) && $details['deadret_count'] <= $autosend['days'])){
							JobsManage::updateJobManage($details['client_id'], $service_id);
							$data['company_details'][$key]['ch_manage_task'] = "Y";
						}
					}
				//}
				
				if(isset($details['ch_manage_task']) && $details['ch_manage_task']== "Y"){
					$all_count+=1;
					$clientId[] = $details['client_id'];
				}
				
			}
		}
		//print_r($clientId);print_r($groupUserId);die;
		$data['all_count'] = $all_count;

		$data['jobs_steps'] = JobsStep::getAllJobSteps( $service_id );
		if(isset($data['jobs_steps']) && count($data['jobs_steps']) >0){
			foreach ($data['jobs_steps'] as $key => $row) {
				$jobs_steps = JobStatus::getJobStatusByStatusId($data['service_id'], $row['step_id'], $clientId);
				$data['jobs_steps'][$key]['count'] = count($jobs_steps);
			}
		}
		$data['Job_status'] 	= JobStatus::getJobStatusByServiceId($data['service_id'], $clientId);
		$data['not_started_count'] = $all_count - count($data['Job_status']);
		$data['staff_details'] 	= User::whereIn("user_id", $groupUserId)->where("client_id", "=", 0)->select("user_id", "fname", "lname")->get(); 

		$data['completed_task'] = JobStatus::getCompletedTaskByServiceId( $data['service_id'], 10, $clientId );

		$data['autosend'] = AutosendTask::whereIn("user_id", $groupUserId)->where('service_id', '=', $data['service_id'])->first();

		$data['jobs_start_days'] = JobsStartDate::getJobStartDaysByServiceId( $data['service_id'] );
		$data['email_clients'] = JobsAutosendEmail::getJobsAutosendEmailByServiceId( $data['service_id'] );

		

		$data['email_templates'] = EmailTemplate::getEmailTemplateByServiceId( $data['service_id'] );
		//echo "<pre>";print_r($data['company_details']);die;
		return View::make('ch_data.channual_return_list', $data);
	}
    
    public function chdownload($service_id, $page_open, $staff_id,$type){
		$data 			            = array();
		$clientId 		            = array();
		$client_data 	            = array();
        $t                          = time();
        $time                       = date("Y-m-d H:i:s", $t);
        $pieces                     = explode(" ", $time);
        $data['cdate']              = $pieces[0];
        $data['ctime']              = $pieces[1];
        $today                      = date("j F  Y");
        $data['today']              = $today;
        $time                       = date(" G:i:s ");
        $data['time']               = $time;
		$data['goto_url']	        = "/ch-annual-return/".$service_id;
		$data['heading']            = Service::getNameServiceId($service_id);
        $data['title']              = ucfirst(strtolower($data['heading']));
		$data['previous_page'] = '<a href="/jobs-dashboard">Task Management</a>';
		$data['service_id'] = $service_id;
		$data['staff_id'] 	= base64_decode($staff_id);
		$data['page_open'] 	= base64_decode($page_open);
		$data['encode_page_open'] 	= $page_open;
		$data['encode_staff_id'] 	= $staff_id;
		
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 		= $session['group_users'];

		$staff_filter = JobsStaffFilter::getFilteredStaffByServiceId($data['service_id']);
		if(isset($staff_filter['filtered_staff_id']) && $staff_filter['filtered_staff_id'] != ""){
			$data['staff_id'] 	= $staff_filter['filtered_staff_id'];
		}else{
			$data['staff_id'] 	= "all";
		}


		if($data['staff_id'] == "all"){
			$data['company_details'] = Client::getClientByServiceId( $data['service_id'] );
		}else if($data['staff_id'] == "none"){
			$data['company_details'] = Client::getUnassignedClientDetails( $data['service_id'] );
		}else{
			$data['company_details'] = Client::getAssignedClientDetails($data['service_id'], $data['staff_id']);
		}
		
		$all_count = 0;
		if(isset($data['company_details']) && count($data['company_details']) >0){
			foreach ($data['company_details'] as $key => $details) {
				//if($data['page_open'] == 21){
					$autosend = AutosendTask::whereIn("user_id", $groupUserId)->where('service_id', '=', $data['service_id'])->first();
					if(isset($autosend) && count($autosend) >0 ){
						if((isset($details['deadret_count']) && $details['deadret_count'] <= $autosend['days'])){
							JobsManage::updateJobManage($details['client_id'], $service_id);
							$data['company_details'][$key]['ch_manage_task'] = "Y";
						}
					}
				//}
				
				if(isset($details['ch_manage_task']) && $details['ch_manage_task']== "Y"){
					$all_count+=1;
					$clientId[] = $details['client_id'];
				}
				
			}
		}
		//print_r($clientId);print_r($groupUserId);die;
		$data['all_count'] = $all_count;

		$data['jobs_steps'] = JobsStep::getAllJobSteps( $service_id );
		if(isset($data['jobs_steps']) && count($data['jobs_steps']) >0){
			foreach ($data['jobs_steps'] as $key => $row) {
				$jobs_steps = JobStatus::getJobStatusByStatusId($data['service_id'], $row['step_id'], $clientId);
				$data['jobs_steps'][$key]['count'] = count($jobs_steps);
			}
		}
		$data['Job_status'] 	= JobStatus::getJobStatusByServiceId($data['service_id'], $clientId);
		$data['not_started_count'] = $all_count - count($data['Job_status']);
		$data['staff_details'] 	= User::whereIn("user_id", $groupUserId)->where("client_id", "=", 0)->select("user_id", "fname", "lname")->get(); 

		$data['completed_task'] = JobStatus::getCompletedTaskByServiceId( $data['service_id'], 10, $clientId );

		$data['autosend'] = AutosendTask::whereIn("user_id", $groupUserId)->where('service_id', '=', $data['service_id'])->first();

		$data['jobs_start_days'] = JobsStartDate::getJobStartDaysByServiceId( $data['service_id'] );
		$data['email_clients'] = JobsAutosendEmail::getJobsAutosendEmailByServiceId( $data['service_id'] );

		

		$data['email_templates'] = EmailTemplate::getEmailTemplateByServiceId( $data['service_id'] );
		//echo "<pre>";print_r($data['completed_task']);die();
		//return View::make('ch_data.channual_return_list', $data);
        if($type=='pdf'){
            $pdf = PDF::loadView('ch_data.ch_datapdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            return $pdf->download('CH_ANNUAL_RETURNS.pdf');
        }
        else{
            $viewToLoad = 'ch_data/ch_dataexcel';
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

    

}
