<?php
class ClientListAllocationController extends BaseController {
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
	
	public function index($service_id, $client_type)
	{
		$client_type = base64_decode($client_type);
		$data['client_type'] 	= $client_type;
		$data['service_id']		= $service_id;
		$data['client_id']		= $service_id;

		//echo $client_type;die;
		$data['title'] = 'Client List Allocation';
		$data['previous_page'] = '<a href="/settings-dashboard">Settings</a>';
		$data['heading'] 		= "CLIENT LIST ALLOCATION";
		$data['page_name'] 	= "client_list_allocation";

		$admin_s 			= Session::get('admin_details');
		$user_id 			= $admin_s['id'];
		$groupUserId 	= $admin_s['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}

		$data['staff_details'] 	= User::getAllStaffName();
		$data['old_services'] 	= Service::where("status", "old")->orderBy("service_name")->get();
		$data['new_services'] 	= Service::where("status", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();

		/*if($data['client_type'] == "org"){
			if($data['service_id'] == 0){
				$data['client_details'] = array();
			}else{
				$data['client_details'] 	=   Client::getAllOrgClientDetails();
			}
			
		}else{
			$data['client_details'] 	=   Client::getAllIndClientDetails();
		}

		if(isset($data['client_details']) && count($data['client_details']) >0){
			foreach ($data['client_details'] as $key => $value) {
			  $staffs =	ClientListAllocation::withStaffNameByClientService($value['client_id'],$service_id);
			  $data['client_details'][$key]['allocationStaff'] = $staffs;
			}
		}*/

		/*========= Allocation Heading Section ========== */
		$count = AllocationHeading::checkHeading();
		if($count <= 0){
			$headings = AllocationHeadingDefault::getHeadings();
			$dtInsrt['user_id'] 	= $user_id;
			$dtInsrt['client_id'] 	= 0;
			$dtInsrt['service_id'] 	= $service_id;
			$dtInsrt['status'] 		= 'old';
			$dtInsrt['created'] 	= date('Y-m-d H:i:s');
			foreach ($headings as $key => $value) {
				$dtInsrt['heading'] = $value['heading_name'];
				AllocationHeading::insert($dtInsrt);
			}
		}
		/*========== Allocation Heading Section ========= */
		$data['headings'] = AllocationHeading::getHeadingByCurrentUserId();
		$data['allocationStaff'] = ClientListAllocation::withStaffNameByClientService(8, $service_id);

		//echo "<pre>";print_r($data['client_details']);die;
		return View::make('settings.client_list_allication.index', $data);
	}

	public function action()
	{
		$data 				= array();
		$action 			= Input::get('action');	
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId  = $session['group_users'];

		switch ($action) {
			case 'getClientLists':
				$postData = Input::all();
				$client_type 	= $postData['client_type'];
				$service_id		= $postData['service_id'];

				//$data['clients'] 		= $this->getClientDetails( $postData );
				$data['lists'] 			= $this->getClientLists( $postData );
				$data['service_id'] = $service_id;
				//echo "<pre>";print_r($data['lists']);die;
				echo View::make("settings.client_list_allication.allocation_list", $data);
				break;
			case 'clientAddToList':
				$postData = Input::all();
				$data['last_id'] = $this->saveClientServices( $postData );
				echo json_encode($data);
				break;
			case 'removeAllocCheck':
				$postData = Input::all();
				$this->deleteClientServices( $postData );
				//$data['clients'] 		= $this->getClientDetails( $postData );
				$data['lists'] 			= $this->getClientLists( $postData );
				$data['service_id'] = $postData['service_id'];
				echo View::make("settings.client_list_allication.allocation_list", $data);
				break;
			default:
				# code...
				break;
		}

	}

	public function deleteClientServices( $postData )
	{
		$client_id 	= $postData['client_id'];
		$service_id = $postData['service_id'];
		ClientService::where('client_id',$client_id)->where('service_id',$service_id)->delete();
		ClientListAllocation::where('client_id',$client_id)->where('service_id',$service_id)->delete();
	}

	public function saveClientServices( $postData )
	{
		$client_type 	= $postData['client_type'];
		$service_id		= $postData['service_id'];
		$client_id		= $postData['client_id'];
		$check = ClientService::checkServiceIdByClientId($client_id, $service_id);
		$last_id = 0;
		if($check == ''){
			$inData['client_id'] 	= $client_id;
			$inData['service_id'] = $service_id;
			$inData['created'] 		= date('Y-m-d H:i:s');
			$last_id = ClientService::insertGetId($inData);
		}
		return $last_id;
	}

	public function getClientDetails( $postData )
	{
		$client_type 	= $postData['client_type'];
		$service_id		= $postData['service_id'];
		$clients 			= Client::getClientListByServiceId( $service_id, $client_type );

		if(isset($clients) && count($clients) >0){
			foreach ($clients as $k => $v) {
			  $staffs =	ClientListAllocation::withStaffNameByClientService($v['client_id'], $service_id);
			  $clients[$k]['allocationStaff'] = $staffs;
			  $clients[$k]['services_id'] 		= Client::getServicesIdByClient( $v['client_id'] );
			}
		}
		return $clients;
	}

	public function getClientLists( $postData )
	{
		$data = array();
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 	= $session['group_users'];

		$client_type 	= $postData['client_type'];
		$service_id		= $postData['service_id'];

		$clients 		= Client::getClientNameAndIdByType($client_type);
		$clientIds 	= ClientService::getClientIdByServiceId($service_id);
		//echo "<pre>";print_r($clients);die;
		if(isset($clients) && count($clients)>0){
			foreach ($clients as $k => $v) {
				if(!in_array($v['client_id'], $clientIds)){
					$data[$k] = $v;
				}
			}
		}
		return $data;
	}

	public function search_allocation_clients()
	{
		$admin_s 			= Session::get('admin_details');
		$user_id 			= $admin_s['id'];
		$groupUserId 	= $admin_s['group_users'];

		$data = array();
		$data['client_type'] 	= Input::get("client_type");
		$data['service_id']		= Input::get("service_id");

		if($data['client_type'] == "org"){
			$data['org_client_details'] 	=   Client::getAllOrgClientDetails();
		}else{
			$data['ind_client_details'] 	=   Client::getAllIndClientDetails();
		}
		$data['staff_details'] 	= User::whereIn("user_id", $groupUserId)->where("client_id", 0)->select("user_id", "fname", "lname")->get();

		//echo View::make("settings.client_list_allication.ajax_org_allocation", $data);

		echo View::make("settings.client_list_allication.search_allocation_list", $data);
	}

	public function allocationClientsByService()
	{
	  $client_type = base64_encode(Input::get('type'));
        
		if(Input::get('type') == "org"){
			$service_id = Input::get("org_service_id");
		}else{
			$service_id = Input::get("ind_service_id");
		}

		return Redirect::to('/client-list-allocation/'.$service_id.'/'.$client_type);
	}

	public function save_bulk_allocation()
	{
		$insrtdata 		= $clientIds = $staffIds = array();
		$staff_id			= Input::get("staff_id");
		$column				= Input::get("column");
		$service_id		= Input::get("service_id");
		$client_type	= Input::get("client_type");
		$client_array	= Input::get("client_array");
		$save_type		= Input::get("save_type");

		array_push($staffIds, $staff_id);
		if(isset($client_array) && count($client_array) >0){
			foreach ($client_array as $client_id) {
				array_push($clientIds, $client_id);

				$l = ClientListAllocation::where("client_id",$client_id)->where("service_id",$service_id)->first();
				if(isset($l) && count($l) >0){
					$ud['staff_id'.$column] = $staff_id;
					ClientListAllocation::where("client_allocation_id",$l['client_allocation_id'])->update($ud);
				}else{
					$allocData[] = array(
						'client_type' 			=> $client_type,
						'client_id' 				=> $client_id,
						'service_id' 				=> $service_id,
						'staff_id'.$column 	=> $staff_id,
					);
				}
			}
			if(isset($allocData) && count($allocData) >0){
				ClientListAllocation::insert($allocData);
			}
		}

		

		echo 1;

	}

	public function save_manual_staff()
	{
		$insrtdata = array();
		$staff_id		= Input::get("staff_id");
		$column			= Input::get("column");
		$service_id		= Input::get("service_id");
		$client_type	= Input::get("client_type");
		$client_id		= Input::get("client_id");

		$list = ClientListAllocation::where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();
		if(isset($list) && count($list) >0){
			$updateData['staff_id'.$column] = $staff_id;
			ClientListAllocation::where("client_allocation_id", "=", $list['client_allocation_id'])->update($updateData);
		}else{
			$allocData[] = array(
				'client_type' 		=> $client_type,
				'client_id' 		=> $client_id,
				'service_id' 		=> $service_id,
				'staff_id'.$column 	=> $staff_id,
			);
			ClientListAllocation::insert($allocData);
		}

		echo 1;

	}

	public function edit_service_id()
	{
		$data = array();
		$admin_s 		= Session::get('admin_details');
		$user_id 		= $admin_s['id'];
		$groupUserId 	= $admin_s['group_users'];

		$action_type	= Input::get("action_type");
		$service_id		= Input::get("service_id");
		$client_id		= Input::get("client_id");
		if($action_type == "add"){
			$servData[] = array(
				'client_id' 		=> $client_id,
				'service_id' 		=> $service_id,
			);
			ClientService::insert($servData);
		}else if($action_type == "custom_add"){
			$servData[] = array(
				'client_id' 		=> $client_id,
				'service_id' 		=> $service_id,
			);
			ClientService::insert($servData);
			//JobsManage::jobSendToTask($client_id, $service_id);
			$headings = CustomTasksTableHeading::getDetailsByServiceId( $service_id );
            $field1 = (isset($headings['field1']) && $headings['field1'] != '')?$headings['field1']:'none';
            $field2 = (isset($headings['field2']) && $headings['field2'] != '')?$headings['field2']:'none';

            $data['field1_value'] = StepsFieldsClient::getAddressIdByClientId($client_id, $field1);
            $data['field2_value'] = StepsFieldsClient::getAddressIdByClientId($client_id, $field2);
			
		}else{
			ClientService::where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->delete();

			ClientListAllocation::whereIn('user_id', $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->delete();
		}

		$data['details'] = Common::clientDetailsById($client_id);
		//echo "<pre>";print_r($data);die();
		echo json_encode($data);
	}

  public function pdfclistallocation($service_id, $client_type)
  {
        
    $data= array();
		$data['client_type'] 	= $client_type;
		$data['service_id']		= $service_id;
        $t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;
        //print_r($data);die();
        
		$data['title'] = 'Client List Allocation';
		$data['previous_page'] = '<a href="/settings-dashboard">Settings</a>';
		$data['heading'] = "CLIENT LIST ALLOCATION";

		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}

		$data['staff_details'] 	= User::whereIn("user_id", $groupUserId)->where("client_id", "=", 0)->select("user_id", "fname", "lname")->get();
		$data['old_services'] 	= Service::where("status", "=", "old")->orderBy("service_name")->get();
		$data['new_services'] 	= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();

		if($data['client_type'] == "org"){    
			if($data['service_id'] == 0){
				$data['org_client_details'] = array();
			}else{
				$data['org_client_details'] 	=   Client::getAllOrgClientDetails();
			}
			
		}else{
			$data['ind_client_details'] 	=   Client::getAllIndClientDetails();
		}
  
		//echo "<pre>";print_r($data['org_client_details']);die;
        if($data['client_type'] == "org"){
            $pdf = PDF::loadView('settings.client_list_allication.orgpdfclistallocation', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
		return $pdf->download('orgpdfclistallocation.pdf');
		//return View::make('settings.client_list_allication.orgpdfclistallocation', $data);
	       }
           else{
            
            $pdf = PDF::loadView('settings.client_list_allication.indpdfclistallocation', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
		return $pdf->download('indpdfclistallocation.pdf');
            //return View::make('', $data);
           }
    
    
    
  }
    
    
  public function excelclistallocation($service_id, $client_type)
  {
        
    $data= array();
		$data['client_type'] 	= $client_type;
		$data['service_id']		= $service_id;
        $t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;
        //print_r($data);die();
        
		$data['title'] = 'Client List Allocation';
		$data['previous_page'] = '<a href="/settings-dashboard">Settings</a>';
		$data['heading'] = "CLIENT LIST ALLOCATION";

		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}

		$data['staff_details'] 	= User::whereIn("user_id", $groupUserId)->where("client_id", "=", 0)->select("user_id", "fname", "lname")->get();
		$data['old_services'] 	= Service::where("status", "=", "old")->orderBy("service_name")->get();
		$data['new_services'] 	= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();

		if($data['client_type'] == "org"){    
			if($data['service_id'] == 0){
				$data['org_client_details'] = array();
			}else{
				$data['org_client_details'] 	=   Client::getAllOrgClientDetails();
			}
			
		}else{
			$data['ind_client_details'] 	=   Client::getAllIndClientDetails();
		}
  
		//echo "<pre>";print_r($data['org_client_details']);die;
        if($data['client_type'] == "org"){
            
            
            $viewToLoad = 'settings.client_list_allication.orgexcelclistallocation';
			///////////  Start Generate and store excel file ////////////////////////////
			Excel::create('orgcLIENTcISTaLLOCATION', function ($excel) use ($data, $viewToLoad) {

				$excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad) {
					$sheet->loadView($viewToLoad)->with($data);
				})->save();

			});
        
        //
        
	   
		$filepath = storage_path() . '/exports/orgcLIENTcISTaLLOCATION.xls';
		$fileName = 'orgcLIENTcISTaLLOCATION.xls';
		$headers = array(
			'Content-Type: application/vnd.ms-excel',
		);

		return Response::download($filepath, $fileName, $headers);
		exit;
            
           }
           else{
            
            
            
            
            $viewToLoad = 'settings.client_list_allication.indexcelclistallocation';
			///////////  Start Generate and store excel file ////////////////////////////
			Excel::create('indexcelclistallocation', function ($excel) use ($data, $viewToLoad) {

				$excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad) {
					$sheet->loadView($viewToLoad)->with($data);
				})->save();

			});
        
        //
        
	   
		$filepath = storage_path() . '/exports/indexcelclistallocation.xls';
		$fileName = 'indexcelclistallocation.xls';
		$headers = array(
			'Content-Type: application/vnd.ms-excel',
		);

		return Response::download($filepath, $fileName, $headers);
		exit;
            
    	}
  }

  public function get_client_allocation()
  {
  	$data = array();
  	$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 	= $session['group_users'];

		$action			= Input::get("action");
	

		if($action == 'getAllocation'){
			$service_id		= Input::get("service_id");
			$client_id		= Input::get("client_id");

			$data['client_name'] 	= Client::getClientNameByClientId( $client_id );
			$data['client_type'] 	= Client::getClientTypeByClientId( $client_id );
			$data['service_name'] = Service::getNameServiceId( $service_id );
			$data['details']			= ClientListAllocation::staffByClientService($client_id, $service_id);
			//Common::last_query();die;
			$data['staffs'] 			= User::getAllStaffName();

			echo json_encode($data);
			exit;
		}

		if($action == 'getHeading'){
			$service_id		= Input::get("service_id");
			$client_id		= Input::get("client_id");

			$headings = AllocationHeading::getHeadingByCurrentUserId();
			$data['headings'] = $headings;
			echo json_encode($data);
			exit;
		}

		if($action == 'saveHeading'){
			$gtData['heading']	= Input::get("heading_name");
			$step_id	= Input::get("step_id");
			$headings = AllocationHeading::where('alloc_head_id', '=', $step_id)->update($gtData);
			$data['headings'] = $gtData['heading'];
			echo json_encode($data);
			exit;
		}

		if($action == 'deleteAlloc'){
			$id	= Input::get("id");

			$headings = ClientListAllocation::where('client_allocation_id', '=', $id)->delete();
			$data['id'] = $id;
			echo json_encode($data);
			exit;
		}

  }

  public function save_client_allocation()
	{
		$data 			= array();
		$insrtdata 	= $staffIds = array();
		$session_data   = Session::get('admin_details');
    $groupUserId    = $session_data['group_users'];
    $user_id 				= $session_data['id'];

    $edit_id 		= Input::get("edit_id");
    $input_type = Input::get("input_type");

		$insrtData['service_id'] 	= Input::get("staff_service_id");
		$insrtData['client_id']		= Input::get("staff_client_id");
		$insrtData['client_type'] = Input::get("staff_client_type");
		$insrtData['user_id'] 		= $user_id;

		$client_id 	= $insrtData['client_id'];
		$service_id = $insrtData['service_id'];

		$staff_id1 	= Input::get("staff_id1");
		$staff_id2 	= Input::get("staff_id2");
		$staff_id3 	= Input::get("staff_id3");
		$staff_id4 	= Input::get("staff_id4");
		$staff_id5 	= Input::get("staff_id5");
		
		$staff1_hrs = Input::get("staff1_hrs");
		$staff2_hrs = Input::get("staff2_hrs");
		$staff3_hrs = Input::get("staff3_hrs");
		$staff4_hrs = Input::get("staff4_hrs");
		$staff5_hrs = Input::get("staff5_hrs");

		$list = ClientListAllocation::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->first();
    if(isset($list) && count($list) >0){
			ClientListAllocation::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->delete();
		}

		for ($i = 0; $i < count($staff_id1); $i++) {
      $insrtData['staff_id1']       = $staff_id1[$i];
      $insrtData['staff_id2']      	= $staff_id2[$i];
      $insrtData['staff_id3']    		= $staff_id3[$i];
      $insrtData['staff_id4']      	= $staff_id4[$i];
      $insrtData['staff_id5']    		= $staff_id5[$i];

      $insrtData['staff_hrs1']    	= $staff1_hrs[$i];
      $insrtData['staff_hrs2']    	= $staff2_hrs[$i];
      $insrtData['staff_hrs3']    	= $staff3_hrs[$i];
      $insrtData['staff_hrs4']    	= $staff4_hrs[$i];
      $insrtData['staff_hrs5']    	= $staff5_hrs[$i];
      $insrtData['created']    	 	 	= date('Y-m-d H:i:s');

      array_push($staffIds, $staff_id1[$i]);
      array_push($staffIds, $staff_id2[$i]);
      array_push($staffIds, $staff_id3[$i]);
      array_push($staffIds, $staff_id4[$i]);
      array_push($staffIds, $staff_id5[$i]);

      ClientListAllocation::insertGetId($insrtData);
		}

		$data['allocationStaff'] = ClientListAllocation::withStaffNameByClientService($client_id, $service_id);

		if($input_type == 'notify'){
			$staffs = array_filter( array_unique($staffIds) );//echo "<pre>";print_r($staffs);die;
			ClientListAllocation::sendEditNotification($client_id, $staffs, $service_id);
		}

		echo json_encode($data);

	}

	public function save_bulk_client_allocation()
	{
		$data 			= array();
		$insrtdata 	= $clientIds = $staffIds = array();

		$session_data   = Session::get('admin_details');
    $groupUserId    = $session_data['group_users'];
    $user_id 				= $session_data['id'];

    $postData 			= Input::all();

    $staff_id 		= $postData['staff_id'];
		$column_no 		= $postData['column_no'];
		$service_id 	= $postData['service_id'];
		$clients 			= $postData['clients'];
		$save_type		= $postData['save_type'];

		$insrtData['service_id'] 					= $service_id;
		$insrtData['client_type'] 				= $postData['client_type'];
		$insrtData['user_id'] 						= $user_id;
		$insrtData['staff_id'.$column_no] = $staff_id;
		$insrtData['created']  						= date('Y-m-d H:i:s');

		//print_r($clients);die;
		array_push($staffIds, $staff_id);

		if(isset($clients) && count($clients) >0){
			foreach ($clients as $key => $client_id) {
				array_push($clientIds, $client_id);

				$insrtData['client_id']	= $client_id;

				$list = ClientListAllocation::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->where('staff_id'.$column_no, $staff_id)->first();
		        if(isset($list) && count($list) > 0){
					ClientListAllocation::insert($insrtData);
				}else{
					$list1 = ClientListAllocation::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->first();
					if(isset($list1) && count($list1) > 0){
						$updateData['staff_id'.$column_no] = $staff_id;
					ClientListAllocation::where("client_allocation_id", $list1['client_allocation_id'])->update($updateData);
					}else{
						ClientListAllocation::insert($insrtData);
					}
				}
			}

			$data['allocationStaff'] = ClientListAllocation::withStaffNameByClientService($client_id, $service_id);

			//echo "<pre>";print_r($clientIds);die;
			/* Notification Section */
			if($save_type == 'SN'){
				ClientListAllocation::sendNotification($clientIds, $staffIds, $service_id, $column_no);
			}

			echo json_encode($data);
			
		}
		


	}



}
