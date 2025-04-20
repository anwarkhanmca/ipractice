<?php
 
class JtableController extends BaseController {
	public $user_id;
	public $groupUserId; 

	public function __construct()
	{
		parent::__construct();
		$session    		= Session::get('admin_details');
      	$this->user_id    	= $session['id'];
      	$this->groupUserId  = $session['group_users'];
          $this->group_id     = $session['group_id'];
      	//echo $this->user_id.'kk';die;
      	if(empty($this->user_id)){
      		return Redirect::to('/login')->send();
      	}
	}

	public function action()
	{
		$data 			= array();
		$action 		= Input::get('action');	
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		switch ($action) {
			case 'manageRenewalContainer':
				$postData = Input::all();
				$data = $this->manageRenewalContainer( $postData );
				print json_encode($data);
				break;
			case 'recurringContracts':
				$postData = Input::all();
				$data = $this->recurringContracts( $postData );
				print json_encode($data);
				break;
			case 'wipTable':
				$postData = Input::all();
				$data = $this->wipTable( $postData );
				print json_encode($data);
				break;
      case 'todoPendingTable':
        $postData = Input::all();
        $data = $this->todoPendingTable( $postData );
        echo json_encode($data);
        break;
      case 'tasksFirstTable':
        $postData = Input::all();
        $data = $this->tasksFirstTable( $postData );
        echo json_encode($data);
        break;
      case 'tasksSecondTable':
        $postData = Input::all();
        $data = $this->tasksSecondTable( $postData );
        echo json_encode($data);
        break;
      case 'tasksThirdTable':
        $postData = Input::all();
        $data = $this->tasksThirdTable( $postData );
        echo json_encode($data);
        break;
      case 'clientLists':
        $postData = Input::all();
        $data = $this->clientLists( $postData );
        echo json_encode($data);
        break;

      // Client list allocation
      case 'clientAllocationLists':
        $postData = Input::all();
        $data = $this->clientAllocationLists( $postData );
        echo json_encode($data);
        break;
      case 'getHeading':
        $postData = Input::all();
        $data = 'aaa';
        echo json_encode($data);
        break;

      case 'userLists':
        $postData = Input::all();
        $data = $this->userLists( $postData );
        echo json_encode($data);
        break;

      case 'actHstryLists':
        $postData = Input::all();
        $data = $this->actHstryLists( $postData );
        echo json_encode($data);
        break;

      case 'proposalLists':
        $postData = Input::all();
        $data = $this->proposalLists( $postData );
        echo json_encode($data);
        break;
			
			default:
				# code...
				break;
		}

	}

  public function proposalLists($postData)
  { 
    $m = array();
    $sendData['start']        = $_GET['jtStartIndex'];
    $sendData['limit']        = $_GET['jtPageSize'];
    $sendData['sorting']      = $_GET['jtSorting'];
    $sendData['search']       = isset($_POST["search"])?trim($_POST['search']):'';
    $sendData['page_open']    = isset($_POST["page_open"])?trim($_POST['page_open']):'';

    $details = CrmProposal::proposalLists($sendData);
    //echo "<pre>";print_r($details);die;
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $crm_proposal_id          = $v['crm_proposal_id'];
        $cpt = !empty($v['proposal_title'])?strtoupper(strtolower($v['proposal_title'])):'';

        $m[$i]['key']             = $i;
        $m[$i]['crm_proposal_id'] = $crm_proposal_id;
        $m[$i]['proposalID']      = $v['proposalID'];
        $m[$i]['prospect_name']   = !empty($v['prospect_name'])?$v['prospect_name']:'';
        $m[$i]['proposal_title']  = !empty($v['proposal_title'])?$v['proposal_title']:'';
        $m[$i]['caps_title']      = $cpt;
        $m[$i]['amount']          = !empty($v['amount'])?$v['amount']:'0.00';
        $m[$i]['date']            = $v['created'];
        $m[$i]['save_type']       = $v['save_type'];
        $m[$i]['status']          = CrmProposal::getFullStatus($v['save_type']);
        $m[$i]['is_signed']       = $v['is_signed'];
        $m[$i]['is_rejected']     = $v['is_rejected'];

        $m[$i]['entrpt_crm_prop_id'] = Crypt::encrypt($crm_proposal_id);
        $m[$i]['unread_count']    = CrmProposalComment::getUnreadCount($crm_proposal_id);
        $m[$i]['gross_fees']      = CrmProposalTable::getProposalAmountByProposalId($v['proposalID']);

      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;

  }

  public function actHstryLists($postData)
  { 
    $m = array();
    $sendData['start']        = $_GET['jtStartIndex'];
    $sendData['limit']        = $_GET['jtPageSize'];
    $sendData['sorting']      = $_GET['jtSorting'];
    $sendData['search']       = isset($_POST["search"])?trim($_POST['search']):'';
    $sendData['client_id']    = isset($_POST["client_id"])?trim($_POST['client_id']):'';

    $details = DataStore::actHstryLists($sendData);
    //echo "<pre>";print_r($details);die;
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $store_id  = $v['store_id'];
        $m[$i]['key']          = $i;
        $m[$i]['store_id']     = $store_id;
        $m[$i]['client_id']    = $v['client_id'];
        $m[$i]['client_name']  = $v['client_name'];
        $m[$i]['staff_name']   = $v['staff_name'];
        $m[$i]['date_time']    = !empty($v['date_time'])?$v['date_time']:'';
        $m[$i]['client_type']  = ($v['client_type']=='ind' || $v['client_type']=='org')?'Client Details':ucfirst($v['client_type']);
        $m[$i]['job_name']     = $v['job_name'];
        $m[$i]['added_from']   = $v['added_from'];
        $m[$i]['notes']        = $v['notes'];
      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;

  }

  public function userLists($postData)
  { 
    $m = array();
    $sendData['start']        = $_GET['jtStartIndex'];
    $sendData['limit']        = $_GET['jtPageSize'];
    $sendData['sorting']      = $_GET['jtSorting'];
    $sendData['search']       = isset($_POST["search"])?trim($_POST['search']):'';

    $details = User::userLists($sendData);
    //echo "<pre>";print_r($details);die;
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $user_id  = $v['user_id'];
        $m[$i]['key']                 = $i;
        $m[$i]['user_id']             = $user_id;
        $m[$i]['staff_name']          = $v['staff_name'];
        $m[$i]['position_name']       = !empty($v['position_name'])?$v['position_name']:'';
        $m[$i]['start_date']          = !empty($v['start_date'])?$v['start_date']:'';
        $m[$i]['ni_number']           = !empty($v['ni_number'])?$v['ni_number']:'';
        $m[$i]['dob']                 = !empty($v['dob'])?$v['dob']:'';
        $m[$i]['department_name']     = !empty($v['department_name'])?$v['department_name']:'';
        $m[$i]['address']             = !empty($v['address'])?$v['address']:'';
        $m[$i]['staff_encode']        = base64_encode('staff_encode');
        $m[$i]['show_archive']        = !empty($v['show_archive'])?$v['show_archive']:'';
      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;

  }

  public function clientAllocationLists($postData)
  {
    $m = array();
    $sendData['client_type']  = $_GET['client_type'];

    $sendData['start']        = $_GET['jtStartIndex'];
    $sendData['limit']        = $_GET['jtPageSize'];
    $sendData['sorting']      = $_GET['jtSorting'];
    $sendData['search']       = isset($_POST["search"])?trim($_POST['search']):'';
    $sendData['service_id']   = isset($_POST["service_id"])?trim($_POST['service_id']):'0';

    $details = ClientService::clientAllocationLists($sendData);
    //echo "<pre>";print_r($details);die;
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $client_id    = $v['client_id'];
        $service_id   = $v['service_id'];
        $services     = Client::getServicesIdByClient($client_id);

        $as = ClientListAllocation::withStaffNameByClientService($client_id, $service_id);
        $dc = (isset($services) && in_array($service_id, $services))?'':'disable_click';
        
        $m[$i]['key']                 = $i;
        $m[$i]['client_id']           = $client_id;
        $m[$i]['service_id']          = $service_id;
        $m[$i]['client_type']         = $v['type'];
        $m[$i]['client_name']         = $v['client_name'];
        $m[$i]['business_type']       = !empty($v['business_type'])?$v['business_type']:'';
        $m[$i]['org_client']          = base64_encode('org_client');
        $m[$i]['ind_client']          = base64_encode('ind_client');
        $m[$i]['services']            = $services;
        $m[$i]['allocationStaff']     = $as;
        $m[$i]['disable_click']       = $dc;

      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;

  }

  public function clientLists($postData)
  { 
    $m = array();
    $sendData['client_type']  = $_GET['client_type'];

    $sendData['start']        = $_GET['jtStartIndex'];
    $sendData['limit']        = $_GET['jtPageSize'];
    $sendData['sorting']      = $_GET['jtSorting'];
    $sendData['search']       = isset($_POST["search"])?trim($_POST['search']):'';

    $details = Client::clientLists($sendData);
    //echo "<pre>";print_r($details);die;
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $client_id  = $v['client_id'];
        $vs = (isset($v['vat_stagger']) && $v['vat_stagger']!='Choose One')?$v['vat_stagger']:'';

        $m[$i]['key']                 = $i;
        $m[$i]['client_id']           = $client_id;
        $m[$i]['client_type']         = $v['type'];
        $m[$i]['client_name']         = $v['client_name'];
        $m[$i]['business_type']       = !empty($v['business_type'])?$v['business_type']:'';
        $m[$i]['registration_number'] =!empty($v['registration_number'])?$v['registration_number']:'';
        $m[$i]['year_end']            = !empty($v['year_end'])?$v['year_end']:'';
        $m[$i]['deadacc_count']       = !empty($v['deadacc_count'])?$v['deadacc_count']:'';
        $m[$i]['deadret_count']       = !empty($v['deadret_count'])?$v['deadret_count']:'';
        $m[$i]['tax_reference']       = !empty($v['tax_reference'])?$v['tax_reference']:'';
        $m[$i]['vat_number']          = !empty($v['vat_number'])?$v['vat_number']:'';
        $m[$i]['vat_stagger']         = $vs;
        $m[$i]['address']             = ClientAddress::getClientAddress($client_id, $v['type']);
        $m[$i]['org_client']          = base64_encode('org_client');
        $m[$i]['ind_client']          = base64_encode('ind_client');
        $m[$i]['utrsamllbox']         = !empty($v['utrsamllbox'])?$v['utrsamllbox']:'';
        $m[$i]['show_archive']        = !empty($v['show_archive'])?$v['show_archive']:'';

        $m[$i]['dob']                 = !empty($v['dob'])?$v['dob']:'';
        $m[$i]['relationship']        = Common::get_relationship_client($client_id);
        $m[$i]['ni_number']           = !empty($v['ni_number'])?$v['ni_number']:'';
        $m[$i]['invitation_status']   = User::getInvitationStatus($client_id);

      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;

  }

  public function tasksThirdTable($postData)
  {
    $m = array();
    $sendData['service_id'] = $_GET['service_id'];
    $sendData['page_open']  = $_GET["page_open"];

    $sendData['start']      = $_GET['jtStartIndex'];
    $sendData['limit']      = $_GET['jtPageSize'];
    $sendData['sorting']    = $_GET['jtSorting'];
    $sendData['search']     = isset($_POST["search"])?trim($_POST['search']):'';

    $details = JobsAccDetail::tasksThirdTable($sendData);

    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $task_id          = $v['task_id'];
        $client_id        = $v['client_id'];
        $service_id       = $sendData['service_id'];

        $timesheet_check      = TimeSheetReport::checkTimeSheet($client_id,$service_id,$task_id);
        $last_acc_madeup_date = !empty($v['last_acc_madeup_date'])?$v['last_acc_madeup_date']:'';

        $tax_reference_type = !empty($v['tax_reference_type'])?$v['tax_reference_type']:'';

        $m[$i]['key']                 = $i;
        $m[$i]['client_id']           = $v['client_id'];
        $m[$i]['client_type']         = $v['type'];
        $m[$i]['service_id']          = $service_id;
        $m[$i]['task_id']             = $v['task_id'];
        $m[$i]['job_manage_id']       = $v['job_manage_id'];
        $m[$i]['registration_number'] =!empty($v['registration_number'])?$v['registration_number']:'';
        $m[$i]['client_name']         = $v['client_name'];
        $m[$i]['vat_number']          = !empty($v['vat_number'])?$v['vat_number']:'';
        $m[$i]['ret_frequency']       = !empty($v['ret_frequency'])?ucwords($v['ret_frequency']):'';
        $m[$i]['filling_date']        = !empty($v['filling_date'])?$v['filling_date']:'';
        $m[$i]['return_date']         = !empty($v['return_date'])?$v['return_date']:'';
        $m[$i]['next_return']         = !empty($v['next_return'])?$v['next_return']:'';
        $m[$i]['notes']               = JobsNote::getNotesByJobManageId($v['job_manage_id']);
        $m[$i]['timesheet_check']     = $timesheet_check;
        $m[$i]['last_acc_madeup_date']= $last_acc_madeup_date;
        $m[$i]['job_status_id']       = JobStatus::getJobStatusIdByJobManageId($v['job_manage_id']);
        $m[$i]['is_completed']        = JobStatus::getIsCompletedByJobManageId($v['job_manage_id']);
        $m[$i]['completion_date']     = !empty($v['date'])?$v['date']:'';
        $m[$i]['job_due_date']        = !empty($v['job_due_date'])?$v['job_due_date']:'';
        $m[$i]['ct_reference']        = !empty($v['ct_reference'])?$v['ct_reference']:'';
        $m[$i]['tax_reference_type']  = $tax_reference_type;
        $m[$i]['tax_return']          = !empty($v['tax_return'])?$v['tax_return']:'';
        $m[$i]['tax_return_start']    = !empty($v['tax_return_start'])?$v['tax_return_start']:'';
        $m[$i]['period_end']          = !empty($v['period_end'])?$v['period_end']:'';
        $m[$i]['completion']          = !empty($v['completion'])?$v['completion']:'';
        $m[$i]['made_up_date']        = !empty($v['made_up_date'])?$v['made_up_date']:'';
        $m[$i]['ecsl_freq']           = !empty($v['ecsl_freq'])?ucwords($v['ecsl_freq']):'';
        $m[$i]['ni_number']           = !empty($v['ni_number'])?ucwords($v['ni_number']):'';
      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;
  }

  public function tasksSecondTable($postData)
  {
    $m = array();
    $sendData['service_id'] = $_GET['service_id'];
    $sendData['page_open']  = $_GET["page_open"];

    $sendData['start']      = $_GET['jtStartIndex'];
    $sendData['limit']      = $_GET['jtPageSize'];
    $sendData['sorting']    = $_GET['jtSorting'];
    $sendData['search']     = isset($_POST["search"])?trim($_POST['search']):'';
    $sendData['status_id']  = isset($_POST["status_id"])?trim($_POST['status_id']):1;

    $sendData['field1']     = isset($_GET["field1"])?trim($_GET['field1']):'none';
    $sendData['field2']     = isset($_GET["field2"])?trim($_GET['field2']):'none';

    $details = JobsAccDetail::tasksSecondTable($sendData);

    //echo "<pre>";print_r($details);die;
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $client_id       = $v['client_id'];
        $service_id      = $sendData['service_id'];
        $job_manage_id   = $v['job_manage_id'];

        $ed  = !empty($v['effective_date'])?date('d-m-Y',strtotime($v['effective_date'])):'';
        $jsd = !empty($v['job_start_date'])?date('d-m-Y H:i',strtotime($v['job_start_date'])):date('d-m-Y H:i');
        $nrd  = !empty($v['next_ret_due'])?date('d-m-Y',strtotime($v['next_ret_due'])):'';

        $tasksadded      = Todolistnewtask::getTaskByRelationClientId($client_id, 'tasks');
        $status_name     = JobStatus::statusNameByJobManageId($job_manage_id);
        $incorp_date     = !empty($v['incorporation_date'])?date('d-m-Y',strtotime($v['incorporation_date'])):'';
        $next_acc_due    = !empty($v['next_acc_due'])?date('d-m-Y',strtotime($v['next_acc_due'])):'';
        $next_made_up_to = !empty($v['next_made_up_to'])?date('d-m-Y', strtotime($v['next_made_up_to'])):'';
        $accounts_date  = !empty($v['accounts_date'])?$v['accounts_date']:'';
        $return_status  = JobStatus::statusNameByClientAndStatusId($client_id, 3);
        
        $deadline_date  = !empty($v['deadline_date'])?date('d-m-Y',strtotime($v['deadline_date'])):'';
        $completion_date = (!empty($v['completion_date']) && ($v['completion_date']!='0000-00-00'))?date('d-m-Y', strtotime($v['completion_date'])):'';
        $completion_days = !empty($v['completion_days'])?$v['completion_days']:'';

        $m[$i]['key']                 = $i;
        $m[$i]['client_id']           = $v['client_id'];
        $m[$i]['client_type']         = $v['type'];
        $m[$i]['service_id']          = $service_id;
        $m[$i]['job_manage_id']       = $job_manage_id;
        $m[$i]['effective_date']      = $ed;
        $m[$i]['client_name']         = $v['client_name'];
        $m[$i]['vat_scheme']          = !empty($v['vat_scheme'])?$v['vat_scheme']:'';
        $m[$i]['vat_stagger']         = !empty($v['vat_stagger'])?$v['vat_stagger']:'';
        $m[$i]['ret_frequency']       = !empty($v['ret_frequency'])?$v['ret_frequency']:'';
        $m[$i]['manage_task']         = !empty($v['manage_task'])?$v['manage_task']:'N';

        $m[$i]['reminders']           = TaskNotification::getColourStatus($client_id,$service_id,'1');
        $m[$i]['taskstatus']          = TaskNotification::getColourStatus($client_id,$service_id,'2');

        $m[$i]['job_start_date']      = $jsd;
        $m[$i]['job_start_plus']      = date("Y-m-d H:i:s",strtotime('+1 hour',strtotime($jsd)));
        $m[$i]['jobs_steps']          = JobsStep::getAllJobSteps( $service_id );
        $m[$i]['tasksadded']          = $tasksadded;
        $m[$i]['status_name']         = (strlen($status_name) >20)?strtoupper(strtolower(substr($status_name, 0, 20))).'...':strtoupper(strtolower($status_name));
        $m[$i]['return_date']         = !empty($v['return_date'])?$v['return_date']:'';
        $m[$i]['e_reminders']         = !empty($v['e_reminders'])?$v['e_reminders']:0;
        $m[$i]['status_id']           = JobStatus::getStatusIdByJobManageId($job_manage_id);
        $m[$i]['notes']               = JobsNote::getNotesByJobManageId($job_manage_id);
        $m[$i]['incorporation_date']  = $incorp_date;
        $m[$i]['year_end']            = !empty($v['year_end'])?$v['year_end']:'';
        $m[$i]['deadacc_count']       = !empty($v['deadacc_count'])?$v['deadacc_count']:'';
        $m[$i]['next_acc_due']        = $next_acc_due;
        $m[$i]['next_made_up_to']     = $next_made_up_to;
        $m[$i]['accounts_date']       = $accounts_date;
        $m[$i]['return_due_date']     = !empty($v['return_due_date'])?$v['return_due_date']:'';
        $m[$i]['ct_count_down']       = !empty($v['ct_count_down'])?$v['ct_count_down']:'';
        $m[$i]['return_status']       = (strlen($return_status) >20)?strtoupper(strtolower(substr($return_status, 0, 20))).'...':strtoupper(strtolower($return_status));
        $m[$i]['client_portal']       = base64_encode('client_portal');
        $m[$i]['org_client']          = base64_encode('org_client');
        $m[$i]['client_users']        = User::getInvitedClientId();
        $m[$i]['job_due_date']        = !empty($v['job_due_date'])?$v['job_due_date']:'';
        $m[$i]['next_return']         = !empty($v['next_return'])?$v['next_return']:'';
        $m[$i]['deadline']            = JobStatus::getDeadline($client_id,$service_id,$job_manage_id);

        $m[$i]['deadline_date']       = $deadline_date;
        $m[$i]['count_down']          = !empty($v['count_down'])?$v['count_down']:'';
        $m[$i]['field1_value']        = !empty($v['field1_value'])?$v['field1_value']:'';
        $m[$i]['field2_value']        = !empty($v['field2_value'])?$v['field2_value']:'';
        $m[$i]['job_name']            = !empty($v['job_name'])?$v['job_name'].'-'.date('Y'):'';
        $m[$i]['ecsl_freq']           = !empty($v['ecsl_freq'])?ucfirst($v['ecsl_freq']):'';
        $m[$i]['completion_date']     = $completion_date;
        $m[$i]['completion_days']     = $completion_days;
        $m[$i]['period_end']          = !empty($v['period_end'])?ucfirst($v['period_end']):'';
        $m[$i]['ch_auth_code']        = !empty($v['ch_auth_code'])?$v['ch_auth_code']:'';
        $m[$i]['next_ret_due']        = $nrd;
        $m[$i]['deadret_count']       = !empty($v['deadret_count'])?$v['deadret_count']:'';
        $m[$i]['cust_job_name']       = !empty($v['cust_job_name'])?$v['cust_job_name']:'';
        
      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;
  }

  public function tasksFirstTable($postData)
  {
    $m = array();
    $sendData['service_id'] = $_GET['service_id'];
    $sendData['page_open']  = $_GET["page_open"];

    $sendData['start']      = $_GET['jtStartIndex'];
    $sendData['limit']      = $_GET['jtPageSize'];
    $sendData['sorting']    = $_GET['jtSorting'];
    $sendData['search']     = isset($_POST["search"])?trim($_POST['search']):'';

    if($sendData['page_open'] == 1){
      $details = JobsAccDetail::tasksFirstTable($sendData);
    }else if($sendData['page_open'] == 2){
      $details = JobsAccDetail::tasksSecondTable($sendData);
    }

    //echo "<pre>";print_r($details);die;
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $client_id       = $v['client_id'];
        $service_id      = $sendData['service_id'];

        $vct             = isset($v['vat_scheme_type'])?$v['vat_scheme_type']:"";
        $incorp_date     = !empty($v['incorporation_date'])?date('d-m-Y', strtotime($v['incorporation_date'])):'';
        $reg_no          = !empty($v['registration_number'])?$v['registration_number']:'';
        $last_acc_date   = !empty($v['last_acc_madeup_date'])?date('d-m-Y', strtotime($v['last_acc_madeup_date'])):'';
        $vat_stagger     = (isset($v['vat_stagger']) && $v['vat_stagger']!='Choose One')?$v['vat_stagger']:'';
        $next_acc_due    = !empty($v['next_acc_due'])?date('d-m-Y', strtotime($v['next_acc_due'])):'';
        $next_made_up_to = !empty($v['next_made_up_to'])?date('d-m-Y', strtotime($v['next_made_up_to'])):'';

        $acc_ref_day      = !empty($v['acc_ref_day'])?$v['acc_ref_day']:'';
        $acc_ref_month    = !empty($v['acc_ref_month'])?$v['acc_ref_month']:'';
        $separator        = (!empty($v['acc_ref_day']) && !empty($v['acc_ref_month']) )?'-':'';
        $completion_date  = (!empty($v['completion_date']) && ($v['completion_date'] != '0000-00-00'))?date('d-m-Y', strtotime($v['completion_date'])):'';
        $completion_days    = !empty($v['completion_days'])?$v['completion_days']:'';

        $tax_reference      = !empty($v['tax_reference'])?$v['tax_reference']:'';
        $tax_reference_type = !empty($v['tax_reference_type'])?$v['tax_reference_type']:'';
        $allocated_staffs   = ClientListAllocation::getAllocatedStaff($client_id, $service_id);
        //$accounts_date      = JobsManage::getFieldValue('next_made_up_to',3,$client_id);
        $accounts_date      = !empty($v['accounts_date'])?$v['accounts_date']:'';
        $return_status      = JobStatus::statusNameByClientAndStatusId($client_id, 3);

        //echo $return_status;die;

        $m[$i]['key']                 = $i;
        $m[$i]['client_id']           = $v['client_id'];
        $m[$i]['client_type']         = $v['type'];
        $m[$i]['service_id']          = $service_id;
        $m[$i]['effective_date']      = !empty($v['effective_date'])?date('d-m-Y', strtotime($v['effective_date'])):'';
        $m[$i]['client_name']         = $v['client_name'];
        $m[$i]['vat_scheme_type']     = $vct;
        $m[$i]['vat_scheme']          = !empty($v['vat_scheme'])?$v['vat_scheme']:'';
        $m[$i]['vat_number']          = !empty($v['vat_number'])?$v['vat_number']:'';
        $m[$i]['vat_stagger']         = $vat_stagger;
        $m[$i]['ret_frequency']       = !empty($v['ret_frequency'])?$v['ret_frequency']:'';
        $m[$i]['ecsl_freq']           = !empty($v['ecsl_freq'])?$v['ecsl_freq']:'';
        $m[$i]['manage_task']         = !empty($v['manage_task'])?$v['manage_task']:'N';
        $m[$i]['allocated_staffs']    = $allocated_staffs;
        $m[$i]['reminders']           = TaskNotification::getColourStatus($client_id,$service_id,'1');
        $m[$i]['taskstatus']          = TaskNotification::getColourStatus($client_id,$service_id,'2');

        $m[$i]['incorporation_date']  = $incorp_date;
        $m[$i]['registration_number'] = $reg_no;
        $m[$i]['year_end']            = !empty($v['year_end'])?$v['year_end']:'';
        $m[$i]['ch_auth_code']        = !empty($v['ch_auth_code'])?$v['ch_auth_code']:'';
        $m[$i]['last_acc_madeup_date']= $last_acc_date;
        $m[$i]['next_acc_due']        = $next_acc_due;
        $m[$i]['next_made_up_to']     = $next_made_up_to;
        $m[$i]['sign_off_date']       = !empty($v['sign_off_date'])?date('d-m-Y', strtotime($v['sign_off_date'])):'';
        $m[$i]['deadacc_count']       = !empty($v['deadacc_count'])?$v['deadacc_count']:'';
        $m[$i]['completion_date']     = $completion_date;
        $m[$i]['completion_days']     = $completion_days;
        $m[$i]['repeat_day']          = !empty($v['repeat_day'])?$v['repeat_day']:'';
        $m[$i]['hrs_wk']              = !empty($v['hrs_wk'])?$v['hrs_wk']:'';

        $m[$i]['made_up_date']        = !empty($v['made_up_date'])?$v['made_up_date']:'';
        $m[$i]['next_return']         = !empty($v['next_return'])?$v['next_return']:'';
        $m[$i]['next_ret_due']        = !empty($v['next_ret_due'])?$v['next_ret_due']:'';
        $m[$i]['deadret_count']       = !empty($v['deadret_count'])?$v['deadret_count']:'';

        $m[$i]['tax_reference']       = $tax_reference;
        $m[$i]['tax_reference_type']  = $tax_reference_type;
        $m[$i]['roll_fwd_start']      = !empty($v['roll_fwd_start'])?$v['roll_fwd_start']:'';
        $m[$i]['roll_fwd_end']        = !empty($v['roll_fwd_end'])?$v['roll_fwd_end']:'';
        $m[$i]['roll_fwd_date']       = !empty($v['roll_fwd_date'])?$v['roll_fwd_date']:'';
        $m[$i]['roll_count']          = !empty($v['roll_count'])?$v['roll_count']:'';
        $m[$i]['accounts_date']       = $accounts_date;
        $m[$i]['return_due_date']     = !empty($v['return_due_date'])?$v['return_due_date']:'';
        $m[$i]['ct_count_down']       = !empty($v['ct_count_down'])?$v['ct_count_down']:'';
        $m[$i]['return_status']       = (strlen($return_status) >20)?strtoupper(strtolower(substr($return_status, 0, 20))).'...':strtoupper(strtolower($return_status));
        $m[$i]['client_portal']       = base64_encode('client_portal');
        $m[$i]['client_users']        = User::getInvitedClientId();
        $m[$i]['address']             = ClientAddress::getClientAddress($client_id, $v['type']);
        $m[$i]['relationship']        = Common::get_relationship_client($client_id);
        $m[$i]['ni_number']           = !empty($v['ni_number'])?ucwords($v['ni_number']):'';
        $m[$i]['frequency']           = !empty($v['frequency'])?ucwords($v['frequency']):'';
        $m[$i]['due_date']            = !empty($v['due_date'])?ucwords($v['due_date']):'';
        $m[$i]['book_status']         = JobsManage::bookKeepingStatus($client_id);

      }
    }

    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;
  }

	public function recurringContracts($postData)
	{
		$rows           = array();
        $data           = $m = array();
        $sendData['start']   	= $_GET['jtStartIndex'];
        $sendData['limit']   	= $_GET['jtPageSize'];
        $sendData['sorting'] 	= $_GET['jtSorting'];
        $sendData['client_id'] 	= $_GET['client_id'];
        $sendData['table_type'] = $_GET["table_type"];

        $sendData['search']    	= isset($_POST["search"])?trim($_POST['search']):'';

        $details = CrmAccDetail::recurringContracts($sendData);

        //echo "<pre>";print_r($postData);die;
        if(isset($details['details']) && count($details['details']) >0){
            foreach($details['details'] as $i=>$v){
                $client_id      = $sendData['client_id'];
                $proposal_id    = $v['proposal_id'];
            	$save_type  = CrmProposal::getFullStatus($v['save_type']);
                $annual_fee = isset($v['annual_fee'])?number_format(str_replace(',','', $v['annual_fee']),2):'';
                $renewals   = RenewalsManage::getRenewalsByProposalAndClientId($proposal_id, $client_id);

                $m[$i]['key']               = $i;
                $m[$i]['proposal_id']       = $v['proposal_id'];
                $m[$i]['signed_date']       = $v['signed_date'];
                $m[$i]['proposal_title']    = isset($v['proposal_title'])?$v['proposal_title']:'';
                $m[$i]['annual_fee']        = $annual_fee;
                $m[$i]['startdate']         = !empty($v['startdate'])?date('d-m-Y',strtotime($v['startdate'])):'';
                $m[$i]['enddate']           = !empty($v['enddate'])?date('d-m-Y', strtotime($v['enddate']) ):'';
                $m[$i]['save_type']    	    = strtoupper(strtolower($save_type));
                $m[$i]['count_down']        = $v['count_down'];
                $m[$i]['manage_renewals']   = $renewals;
                $m[$i]['is_rejected']       = $v['is_rejected'];
                $m[$i]['entrpt_crm_prop_id']= Crypt::encrypt($v['crm_proposal_id']);
                $m[$i]['crm_proposal_id']   = $v['crm_proposal_id'];
                $m[$i]['prospect_name']     = CrmProposal::getProspectName($v['contact_type'], $v['prospect_id']);
            }
        }

        //echo "<pre>";print_r($m);die;
        
        $jTableResult = array();
        $jTableResult['Result']             = "OK";
        $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
        $jTableResult['Records']            = $m;
		
		return $jTableResult;
	}


	public function manageRenewalContainer($postData)
	{
    $rows           = array();
    $data           = $m = array();
    $start          = $_GET['jtStartIndex'];
    $limit          = $_GET['jtPageSize'];
    $sorting        = $_GET['jtSorting'];
    $sort           = explode(' ', $sorting);

    $search    		= isset($_POST["search"])?trim($_POST['search']):'';
    $save_type    	= isset($_POST["save_type"])?trim($_POST['save_type']):'';

    $details = CrmAccDetail::manageRenewalContainer($start,$limit,$sorting,$search,$save_type);

    //echo "<pre>";print_r($postData);die;
    if(isset($details['details']) && count($details['details']) >0){
        foreach($details['details'] as $i=>$v){
        	$status = CrmProposal::getFullStatus($v['status']);

            $m[$i]['key']           = $i;
            $m[$i]['manage_id']     = $v['manage_id'];
            $m[$i]['client_id']     = $v['client_id'];
            $m[$i]['is_archive']    = $v['is_archive'];
            $m[$i]['client_name']   = isset($v['client_name'])?$v['client_name']:'';
            $m[$i]['type']          = $v['type'];
		        $m[$i]['contracts'] 	= '';
		        $m[$i]['proposal_id']   = empty($v['proposal_id'])?'N/A':$v['proposal_id'];
            $m[$i]['annual_fee']    = $v['annual_fee'];
            $m[$i]['startdate']     = !empty($v['startdate'])?date('d-m-Y', strtotime($v['startdate']) ):'';
            $m[$i]['enddate']       = !empty($v['enddate'])?date('d-m-Y', strtotime($v['enddate']) ):'';
            $m[$i]['status']    	= strtoupper(strtolower($status));
            $m[$i]['contract']    	= empty($v['contract'])?'N/A':$v['contract'];
        }
    }

    //echo "<pre>";print_r($m);die;
    
    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
		
	  return $jTableResult;
	}

  public function todoPendingTable($postData)
  {
    $rows       = array();
    $data       = $m = array();
    $sendData['start']      = $_GET['jtStartIndex'];
    $sendData['limit']      = $_GET['jtPageSize'];
    $sendData['sorting']    = $_GET['jtSorting'];
    $sendData['search']     = isset($_POST["search"])?trim($_POST['search']):'';
    $sendData['timeline']   = $_POST['timeline'];

    $statusDrop = array('not_started'=>'Not Started','in_progress'=>'In Progress','completed'=>'Completed','close'=>'Close');

    /*$task_report = Todolistnewtask::getAllDetails($this->user_id);
    $jobs_report = Todolistnewtask::getJobsDetails(9, $this->user_id);
    $details['details'] = array_merge($task_report, $jobs_report);*/
    $details = Todolistnewtask::todoPendingTable($sendData);
    
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $m[$i]['key']           = $i;
        $m[$i]['group_id']      = $this->group_id;
        $m[$i]['id']            = !empty($v['id'])?$v['id']:'0';
        $m[$i]['created']       = $v['created'];
        $m[$i]['client_name']   = isset($v['client_name'])?$v['client_name']:'';
        $m[$i]['service_name']  = $v['service_name'];
        $m[$i]['staff_name']    = $v['staff_name'];
        $m[$i]['attachment']    = !empty($v['attachment'])?$v['attachment']:'';
        $m[$i]['timeline']      = Todolistnewtask::getTimeLineByValue($sendData['timeline']);
        $m[$i]['status']        = ucwords( $v['status'] );
        $m[$i]['notes']         = !empty($v['notes'])?$v['notes']:'';
        $m[$i]['statusDrop']    = $statusDrop;
      }
    }
    //echo "<pre>";print_r($details);die;
    
    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
    
    return $jTableResult;
  }

	public function wipTable($postData)
	{
		$rows       = array();
    $data       = $m = array();
    $sendData['start']      = $_GET['jtStartIndex'];
    $sendData['limit']      = $_GET['jtPageSize'];
    $sendData['sorting']    = $_GET['jtSorting'];
    $sendData['search']     = isset($_POST["search"])?trim($_POST['search']):'';

    $details = CrmAccDetail::wipTable($sendData);
    
    if(isset($details['details']) && count($details['details']) >0){
      foreach($details['details'] as $i=>$v){
        $m[$i]['key']           = $i;
        $m[$i]['id']            = $v['id'];
        $m[$i]['created']       = $v['created'];
        $m[$i]['client_name']   = isset($v['client_name'])?$v['client_name']:'';
        $m[$i]['service_name']  = $v['service_name'];
        $m[$i]['proposal_id']   = !empty($v['proposal_id'])?$v['proposal_id']:'N/A';
        $m[$i]['staff_name']    = $v['staff_name'];
        $m[$i]['amount']        = $v['amount'];
        $m[$i]['comp_date']     = $v['comp_date'];
        $m[$i]['status']        = ucwords( str_replace('_', ' ', $v['status']) );
        $m[$i]['notes']         = !empty($v['notes'])?$v['notes']:'';
      }
    }
        //echo "<pre>";print_r($m);die;
        
    $jTableResult = array();
    $jTableResult['Result']             = "OK";
    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
    $jTableResult['Records']            = $m;
		
		return $jTableResult;
	}

	


}	