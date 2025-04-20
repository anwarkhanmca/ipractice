<?php
class VatReturnsController extends BaseController {
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
	
	public function index($service_id, $page_open, $staff_id)
	{
		$data           = array();
        $clientId       = array();
        $client_data    = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $data['goto_url']           = "/jobs/".$service_id;
        $data['heading']            = Service::getNameServiceId($service_id);
        $data['title']              = ucfirst(strtolower($data['heading']));
        $data['previous_page']      = '<a href="/jobs-dashboard">Jobs</a>';
        $data['service_id']         = $service_id;
        $data['staff_id']           = base64_decode($staff_id);
        $data['page_open']          = base64_decode($page_open);
        $data['encode_page_open']   = $page_open;
        $data['encode_staff_id']    = $staff_id;
        
        $staff_filter = JobsStaffFilter::getFilteredStaffByServiceId( $service_id );
        if(isset($staff_filter['filtered_staff_id']) && $staff_filter['filtered_staff_id']!=""){
            $data['staff_id']   = $staff_filter['filtered_staff_id'];
        }else{
            $data['staff_id']   = "all";
        }

        if($data['staff_id'] == "all"){
            $data['company_details'] = Client::getClientByServiceId( $service_id );
        }else if($data['staff_id'] == "none"){
            $data['company_details'] = Client::getUnassignedClientDetails( $service_id );
        }else{
            $data['company_details'] = Client::getAssignedClientDetails( $service_id, $data['staff_id']);
        }
        
        $data['autosend'] = AutosendTask::getDetailsByServiceId( $service_id );

        $all_count = 0;
        if(isset($data['company_details']) && count($data['company_details']) >0){
            foreach ($data['company_details'] as $key => $details) {
                if(isset($data['autosend']) && count($data['autosend']) >0 ){
                    if((isset($details['deadret_count']) && $details['deadret_count'] <= $data['autosend']['days'])){
                        JobsManage::updateJobManage($details['client_id'], $service_id);
                        $data['company_details'][$key]['ch_manage_task'] = "Y";
                    }
                }
                
                if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y"){
                    $all_count+=1;
                    $clientId[] = $details['client_id'];
                }
            }
        }
        //print_r($clientId);print_r($groupUserId);die;
        $data['all_count']          = $all_count;
        
        $data['jobs_steps']     = JobsStep::getAllJobSteps( $service_id );
        $data['Job_status']     = JobStatus::getJobStatusByServiceId($service_id, $clientId);
        $data['not_started_count']  = $all_count - count($data['Job_status']);
        $data['staff_details']  = User::getAllStaffDetails(); 
        $data['jobs_start_days']= JobsStartDate::getJobStartDaysByServiceId( $service_id );
        $data['email_templates']= EmailTemplate::getEmailTemplateByServiceId( $service_id );
        $data['email_clients'] = JobsAutosendEmail::getJobsAutosendEmailByServiceId($service_id);
        $data['completed_task'] = JobStatus::getCompletedTaskByServiceId( $service_id, 10, $clientId );
		

		//echo "<prev>".print_r($data['client_details']);die;
		return View::make('jobs.vat_returns.index', $data);
	}

	public function manage_tasks(){
		$data['title'] = 'Manage Deadlines';
		$data['previous_page'] = '<a href="/vat-returns">Vat Returns</a>';
		$data['heading'] = "VAT - Manage Deadlines";
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}

		//$data['client_details'] = Client::getAllOrgClientDetails();
		

		//echo "<prev>".print_r($data['client_details']);die;
		return View::make('jobs.vat_returns.manage_tasks', $data);
	}

    

}
