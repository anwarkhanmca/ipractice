<?php
class Common extends Eloquent {

	public $timestamps = false;

	public static function get_ip_address()
	{
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	 
	    return $ipaddress;
	}
	
	private function getApiKey()
	{
		$API_KEY = "hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj";
		return $API_KEY;
	}
	public static function last_query() {
        $queries = DB::getQueryLog();
        $sql = end($queries);

        if( ! empty($sql['bindings']))
        {
            $pdo = DB::getPdo();
            foreach($sql['bindings'] as $binding)
            {
                $sql['query'] = preg_replace('/\?/', $pdo->quote($binding), $sql['query'], 1);
            }
        }   

        echo $sql['query'];
    }
	public static function getGroupId($user_id)
	{
		$users	= User::where('user_id', '=', $user_id)->select("parent_id")->first();
    	if (isset($users) && count($users) >0 && $users['parent_id'] !=0) { 
    		$user_id = Common::getGroupId($users['parent_id']);   
		}
    	return $user_id;
	}

	public static function getUserIdByGroupId($group_id)
	{
		$groupUserId = array();
		$users = User::where("group_id", "=", $group_id)->select("user_id")->get();
		if(isset($users) && count($users) >0 ){
			foreach($users as $key=>$user_id){
				$groupUserId[$key]['user_id']	= $user_id->user_id;
			}
		}
		
		return $groupUserId;
	}

	public static function getUserAccess($user_id)
	{
		$user_access = UserAccess::where("user_id", $user_id)->where("access_id", 5)->first();
    if(isset($user_access) && count($user_access) > 0){
        $return = 'Y';
    }else{
        $return = 'N';
    }

    return $return;
	}

	public static function getCompanyDetails($int)
	{
		$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://data.companieshouse.gov.uk/doc/company/'.$int.'.json'); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, '10');
    
    $result = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    switch($status)
    {
      case '200':
        return json_decode($result);
        break;
      
      default:
        return false;
        break;
    }
	}

	public static function getCompanyData($int)
	{
		$jsontoken = shell_exec("curl -XGET -u hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj: https://api.companieshouse.gov.uk/company/".$int);
		return json_decode($jsontoken);
	}

	public static function getOfficerDetails($int)
	{
		$jsontoken = shell_exec("curl -XGET -u hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj: https://api.companieshouse.gov.uk/company/".$int."/officers");
		return json_decode($jsontoken);
	}

	public static function getFillingHistory($int)
	{
		$jsontoken = shell_exec("curl -XGET -u hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj: https://api.companieshouse.gov.uk/company/".$int."/filing-history");
		return json_decode($jsontoken);
	}

	public static function getRegisteredOffice($int)
	{
		$jsontoken = shell_exec("curl -XGET -u hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj: https://api.companieshouse.gov.uk/company/".$int."/registered-office-address");
		return json_decode($jsontoken);
	}

	public static function getCharges($int)
	{
		$jsontoken = shell_exec("curl -XGET -u hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj: https://api.companieshouse.gov.uk/company/".$int."/charges");
		return json_decode($jsontoken);
	}

	public static function getInsolvency($int)
	{
		$jsontoken = shell_exec("curl -XGET -u hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj: https://api.companieshouse.gov.uk/company/".$int."/insolvency");
		return json_decode($jsontoken);
	}

	public static function getSearchCompany($value)
	{//&items_per_page=5&start_index=2
		$jsontoken = shell_exec("curl -XGET -u hYeDtvCEXMaqkoQnzPv29P8HccoBGmQoyt6fhjqj: https://api.companieshouse.gov.uk/search?q=".$value);
		return json_decode($jsontoken);
	}

	public static function getDayCount($from)
	{
		//$from = str_replace("/", "-", $from);
		$arr = explode('/', $from);
		$days = 0;
		if( $from != "" ){
			$date1 = $arr[2].'-'.$arr[1].'-'.$arr[0];
			$date2 = date("Y-m-d");
			//echo $date2;die;

			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = round($diff/86400);
		}
		
		return $days;
	}

	public static function getDaysDifference($date1, $date2)
	{
		$diff = abs(strtotime($date2) - strtotime($date1));
		$days = round($diff/86400);
		return $days;
	}

	public static function dayDifference($date1, $date2)
	{
		$diff 	= strtotime($date1) - strtotime($date2);
		$days 	= round($diff/86400);
		return $days;
	}

	public static function getSettingsProposalId()
	{
		return 99999;
	}

	public static function clientDetailsById_2($client_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
		$client_data = array();

		$clients = Client::where('client_id', '=', $client_id)->first();
		$client_data['is_archive'] 				= $clients['is_archive'];
		$client_data['show_archive'] 			= $clients['show_archive'];
		$client_data['is_relation_add'] 		= $clients['is_relation_add'];
		$client_data['type'] 					= $clients['type'];
		$client_data['user_id'] 				= 'ind';
		$client_data['is_deleted'] 				= $clients['is_deleted'];
		$client_data['crm_leads_id'] 			= $clients['crm_leads_id'];
		$client_data['crm_contact_type']		= $clients['crm_contact_type'];
		$client_data['is_show_todo']			= $clients['is_show_todo'];
		$client_data['isshow_crm_invoice']	    = $clients['isshow_crm_invoice'];
		$client_data['created']					= $clients['created'];


		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->select("field_id", "field_name", "field_value")->get();

		$client_data['client_id'] 		= $client_id;

		// ############### GET MANAGE TASK START ################## //
		/*$jobs = JobsManage::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->first();
    	if(isset($jobs) && count($jobs) >0){
    		$client_data['ch_manage_task'] 	= $jobs['status'];
    	}else{
    		$client_data['ch_manage_task'] 	= "N";
    	}*/
    	$client_data['ch_manage_task'] 	= "N";
		// ############### GET MANAGE TASK END ################## //

		// ############### GET CLIENT LIST ALLOCATION START ################## //
		$list = ClientListAllocation::where("client_id", "=", $client_id)->get();
		if(isset($list) && count($list) >0){
		  foreach ($list as $key => $row) {
			$client_data['allocation'][$row['service_id']]['service_id'] = $row['service_id'];
			$client_data['allocation'][$row['service_id']]['staff_id1'] = $row['staff_id1'];
			$client_data['allocation'][$row['service_id']]['staff_id2'] = $row['staff_id2'];
			$client_data['allocation'][$row['service_id']]['staff_id3'] = $row['staff_id3'];
			$client_data['allocation'][$row['service_id']]['staff_id4'] = $row['staff_id4'];
			$client_data['allocation'][$row['service_id']]['staff_id5'] = $row['staff_id5'];
		  }
		}
		// ############### GET CLIENT LIST ALLOCATION END ################## //

		// ############### GET JOB STATUS START ################## //
		$JobStatus = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "=", "N")->where("client_id", "=", $client_id)->get();
		//print_r($JobStatus);die;
		if(isset($JobStatus) && count($JobStatus) >0){
		  foreach ($JobStatus as $key => $row) {
			$service_id = $row['service_id'];
			$manage_id 	= $row['job_manage_id'];
			if($service_id == 1 || $service_id == 2 || $service_id == 7 || $service_id == 8){
				$client_data['job_status'][$manage_id]['job_status_id']  = $row['job_status_id'];
				$client_data['job_status'][$manage_id]['client_id'] 	 = $row['client_id'];
				$client_data['job_status'][$manage_id]['service_id'] 	 = $row['service_id'];
				$client_data['job_status'][$manage_id]['status_id'] 	 = $row['status_id'];
				$client_data['job_status'][$manage_id]['job_manage_id']  = $manage_id;
				$client_data['job_status'][$manage_id]['created'] 		 = $row['created'];
			}else{
				$client_data['job_status'][$service_id]['job_status_id'] = $row['job_status_id'];
				$client_data['job_status'][$service_id]['client_id'] 	 = $row['client_id'];
				$client_data['job_status'][$service_id]['service_id'] 	 = $row['service_id'];
				$client_data['job_status'][$service_id]['job_manage_id'] = $row['job_manage_id'];
				$client_data['job_status'][$service_id]['created'] 		 = $row['created'];
			}
			$client_data['job_status'][$manage_id]['status_id'] 	 = $row['status_id'];
			
		  }
		}
		// ############### GET JOB STATUS END ################## //

		// ############### GET OTHER SERVICES START ################## //
		$client_data['services_id'] 	=   Client::getServicesIdByClient($client_id);
		//print_r($client_data[$i]['services']);die;
		// ############### GET OTHER SERVICES END ################## //

		// ############### GET VAT SCHEME USER START ################## //
		$service = Common::get_services_client($client_id);
		if(isset($service) && count($service) > 0){
			foreach ($service as $key => $value) {
				if(isset($value['service_name']) && $value['service_name'] == "VAT"){
					//$client_data[$i]['vat_staff_name'] 	= $value['name'];
					$client_data['vat_staff_name'] 	= $value['service_name'];
				}
			}
		}
		//print_r($service);
		// ############### GET VAT SCHEME USER END ################## //

		$app_name = ClientRelationship::where('client_id', '=', $client_id)->select("appointment_with")->first();
		//echo $this->last_query();//die;
		if(isset($app_name['appointment_with']) && $app_name['appointment_with'] != ""){
			$relation_name = StepsFieldsClient::where('client_id', '=', $app_name['appointment_with'])->where('field_name', '=', "business_name")->select("field_value")->first();
		}

		if (isset($client_details) && count($client_details) > 0) {
			$address = "";
			$TAddress = "";
			
			foreach ($client_details as $client_row) {
				//get staff name start
				if (isset($client_row['field_name']) && $client_row['field_name'] == "resp_staff") {
					$staff_name = User::getStaffNameById($client_row->field_value);
					$staff_name = User::where('user_id', '=', $client_row->field_value)->select("fname", "lname")->first();
					//echo $this->last_query();die;

					$client_data['staff_name'] = strtoupper($staff_name);
				}
				//get staff name end

				//get business name start
				if(isset($relation_name['field_value']) && $relation_name['field_value']!=''){
					$client_data['business_name'] = $relation_name['field_value'];
				}
				//get business name end 
				
				if(isset($client_row['field_name']) && $client_row['field_name'] == "serv_postcode"){
					$client_data['tab6serv_postcode'] = $client_row->field_value;
				}

				//get residencial address
				if (isset($client_row['field_name']) && $client_row['field_name'] == "res_addr_line1") {
					$address .= $client_row->field_value.", ";
				}	
				if (isset($client_row['field_name']) && $client_row['field_name'] == "res_addr_line2") {
					$address .= $client_row->field_value.", ";
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "res_city") {
					$address .= $client_row->field_value.", ";
				}	
				if (isset($client_row['field_name']) && $client_row['field_name'] == "res_county") {
					$address .= $client_row->field_value.", ";
				}	
				if (isset($client_row['field_name']) && $client_row['field_name'] == "res_postcode") {
					$address .= $client_row->field_value.", ";
				}			
				
				//get trade address
				if (isset($client_row['field_name']) && $client_row['field_name'] == "trad_cont_addr_line1") {
					$TAddress['address'][] = $client_row->field_value;
				}	
				if (isset($client_row['field_name']) && $client_row['field_name'] == "trad_cont_addr_line2") {
					$TAddress['address'][] = $client_row->field_value;
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "trad_cont_city") {
					$TAddress['address'][] = $client_row->field_value;
				}	
				if (isset($client_row['field_name']) && $client_row['field_name'] == "trad_cont_country") {
					$TAddress['country'][] = $client_row->field_value;
				}	
				if (isset($client_row['field_name']) && $client_row['field_name'] == "trad_cont_postcode") {
					$TAddress['postcode'][] = $client_row->field_value;
				}
				
				if (isset($client_row['field_name']) && $client_row['field_name'] == "next_acc_due"){
					$client_data['deadacc_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "next_ret_due"){
					$client_data['deadret_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
				}

				if (isset($client_row['field_name']) && $client_row['field_name'] == "acc_ref_month"){
					$client_data['ref_month'] = Common::getMonthNameShort($client_row->field_value);
				}

				if (isset($client_row['field_name']) && $client_row['field_name'] == "business_type") {
					$client_data['business_type_id']= $client_row->field_value;
					$business_type = OrganisationType::where('organisation_id', '=', $client_row->field_value)->first();
					$client_data[$client_row['field_name']] = $business_type['name'];
				} else {
					$client_data[$client_row['field_name']] = $client_row->field_value;
				}

				if (isset($client_row['field_name']) && $client_row['field_name'] == "vat_scheme_type") {
					$business_type = VatScheme::where('vat_scheme_id', '=', $client_row->field_value)->first();
					$client_data[$client_row['field_name']]=$business_type['vat_scheme_name'];
				}

			}

			$client_data['address'] = substr($address, 0, -2);
			$client_data['TAddress'] = $TAddress;
			$client_data['TAddress']['address'] = isset ($TAddress['address']) ? implode(',',$TAddress['address']) : '';
			
		}


		return $client_data;
	} 
	
	public static function clientDetailsById($client_id)
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
        
		$client_data = array();

		$clients = Client::where('client_id', $client_id)->first();
		$client_data['is_archive'] 				= $clients['is_archive'];
		$client_data['show_archive'] 			= $clients['show_archive'];
		$client_data['is_relation_add'] 		= $clients['is_relation_add'];
		$client_data['type'] 					= $clients['type'];
		$client_data['user_id'] 				= $clients['user_id'];
		$client_data['is_deleted'] 				= $clients['is_deleted'];
		$client_data['crm_leads_id'] 			= $clients['crm_leads_id'];
		$client_data['crm_contact_type']		= $clients['crm_contact_type'];
		$client_data['is_show_todo']			= $clients['is_show_todo'];
		$client_data['isshow_crm_invoice']	    = $clients['isshow_crm_invoice'];
		$client_data['created']					= $clients['created'];


		$client_details = StepsFieldsClient::where('client_id', $client_id)->select("field_id", "field_name", "field_value")->get();

		$client_data['client_id'] 		= $client_id;

		// ############### GET MANAGE TASK START ################## //
		/*$jobs = JobsManage::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->first();
    	if(isset($jobs) && count($jobs) >0){
    		$client_data['ch_manage_task'] 	= $jobs['status'];
    	}else{
    		$client_data['ch_manage_task'] 	= "N";
    	}*/
    	$client_data['ch_manage_task'] 	= "N";
		// ############### GET MANAGE TASK END ################## //

		// ############### GET CLIENT LIST ALLOCATION START ################## //
		$list = ClientListAllocation::where("client_id", "=", $client_id)->get();
		if(isset($list) && count($list) >0){
		  foreach ($list as $key => $row) {
			$client_data['allocation'][$row['service_id']]['service_id'] = $row['service_id'];
			$client_data['allocation'][$row['service_id']]['staff_id1'] = $row['staff_id1'];
			$client_data['allocation'][$row['service_id']]['staff_id2'] = $row['staff_id2'];
			$client_data['allocation'][$row['service_id']]['staff_id3'] = $row['staff_id3'];
			$client_data['allocation'][$row['service_id']]['staff_id4'] = $row['staff_id4'];
			$client_data['allocation'][$row['service_id']]['staff_id5'] = $row['staff_id5'];
		  }
		}
		// ############### GET CLIENT LIST ALLOCATION END ################## //

		// ############### GET JOB STATUS START ################## //
		$JobStatus = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "N")->where("client_id", $client_id)->get();
		//print_r($JobStatus);die;
		if(isset($JobStatus) && count($JobStatus) >0){
		  foreach ($JobStatus as $key => $row) {
			$service_id = $row['service_id'];
			$manage_id 	= $row['job_manage_id'];
			if($service_id == 1 || $service_id == 2 || $service_id == 7 || $service_id == 8){
				$client_data['job_status'][$manage_id]['job_status_id']  = $row['job_status_id'];
				$client_data['job_status'][$manage_id]['client_id'] 	 = $row['client_id'];
				$client_data['job_status'][$manage_id]['service_id'] 	 = $row['service_id'];
				$client_data['job_status'][$manage_id]['status_id'] 	 = $row['status_id'];
				$client_data['job_status'][$manage_id]['job_manage_id']  = $manage_id;
				$client_data['job_status'][$manage_id]['created'] 		 = $row['created'];
			}else{
				$client_data['job_status'][$service_id]['job_status_id'] = $row['job_status_id'];
				$client_data['job_status'][$service_id]['client_id'] 	 = $row['client_id'];
				$client_data['job_status'][$service_id]['service_id'] 	 = $row['service_id'];
				$client_data['job_status'][$service_id]['job_manage_id'] = $row['job_manage_id'];
				$client_data['job_status'][$service_id]['created'] 		 = $row['created'];
			}
			$client_data['job_status'][$manage_id]['status_id'] 	 = $row['status_id'];
			
		  }
		}
		// ############### GET JOB STATUS END ################## //

		// ############### GET OTHER SERVICES START ################## //
		$client_data['services_id'] 	=   Client::getServicesIdByClient($client_id);
		//print_r($client_data[$i]['services']);die;
		// ############### GET OTHER SERVICES END ################## //

		// ############### GET VAT SCHEME USER START ################## //
		$service = Common::get_services_client($client_id);
		if(isset($service) && count($service) > 0){
			foreach ($service as $key => $value) {
				if(isset($value['service_name']) && $value['service_name'] == "VAT"){
					//$client_data[$i]['vat_staff_name'] 	= $value['name'];
					$client_data['vat_staff_name'] 	= $value['service_name'];
				}
			}
		}
		//print_r($service);
		// ############### GET VAT SCHEME USER END ################## //

		$app_name = ClientRelationship::where('client_id', '=', $client_id)->select("appointment_with")->first();
		//echo $this->last_query();//die;
		if(isset($app_name['appointment_with']) && $app_name['appointment_with'] != ""){
			$relation_name = StepsFieldsClient::where('client_id', '=', $app_name['appointment_with'])->where('field_name', '=', "business_name")->select("field_value")->first();
		}

		if (isset($client_details) && count($client_details) > 0) {
			$address = $serv_address = $res_address = $reg_address = $trad_address = $corres_address = $banker_address = $oldacc_address = $auditors_address = $solicitors_address = "";
			$TAddress = $residential_addr = $trading_addr = "";
			$tradAddress = array();
			
			foreach ($client_details as $client_row) {
				$client_data['spouse_dob'] = '';
				//get staff name start
				if (isset($client_row['field_name']) && $client_row['field_name'] == "resp_staff") {
					$staff_name = User::getStaffNameById($client_row->field_value);
					$staff_name = User::where('user_id', '=', $client_row->field_value)->select("fname", "lname")->first();
					//echo $this->last_query();die;

					$client_data['staff_name'] = strtoupper($staff_name);
				}
				//get staff name end

				//get business name start
				if(isset($relation_name['field_value']) && $relation_name['field_value']!=''){
					$client_data['business_name'] = $relation_name['field_value'];
				}
				//get business name end 
				
				if(isset($client_row['field_name']) && $client_row['field_name'] == "serv_postcode"){
					$client_data['tab6serv_postcode'] = $client_row->field_value;
				}			
				
				//get trade address
				if (isset($client_row['field_name']) && $client_row['field_name'] == "trad_address") {
					$tradAddress = ClientAddress::getDetailsById( $client_row->field_value );
					$TAddress['address'][]  = isset($tradAddress['address1'])?$tradAddress['address1']:'';
					$TAddress['address'][]  = isset($tradAddress['address2'])?$tradAddress['address2']:'';
					$TAddress['address'][]  = isset($tradAddress['city'])?$tradAddress['city']:'';
					$TAddress['address'][]  = isset($tradAddress['county'])?$tradAddress['county']:'';
					$TAddress['country'][]  = isset($tradAddress['country_name'])?$tradAddress['country_name']:'';
					$TAddress['postcode'][] = isset($tradAddress['postcode'])?$tradAddress['postcode']:'';
				}
				$client_data['trading_address']	= $tradAddress;
				
				if (isset($client_row['field_name']) && $client_row['field_name'] == "next_acc_due"){
					$client_data['deadacc_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "next_ret_due"){
					$client_data['deadret_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
				}

				if (isset($client_row['field_name']) && $client_row['field_name'] == "acc_ref_month"){
					$client_data['ref_month'] = Common::getMonthNameShort($client_row->field_value);
				}

				if (isset($client_row['field_name']) && $client_row['field_name'] == "business_type") {
					$client_data['business_type_id']= $client_row->field_value;
					$business_type = OrganisationType::where('organisation_id', '=', $client_row->field_value)->first();
					$client_data[$client_row['field_name']] = $business_type['name'];
				} else {
					$client_data[$client_row['field_name']] = $client_row->field_value;
				}

				if (isset($client_row['field_name']) && $client_row['field_name'] == "vat_scheme_type") {
					$business_type = VatScheme::where('vat_scheme_id', '=', $client_row->field_value)->first();
					$client_data[$client_row['field_name']]=$business_type['vat_scheme_name'];
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "serv_address") {
					$serv_address = ClientAddress::getFullAddress($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "res_address") {
					$res_address = ClientAddress::getFullAddress($client_row->field_value);
					$residential_addr = ClientAddress::getDetailsById($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "trad_address") {
					$trad_address = ClientAddress::getFullAddress( $client_row->field_value );
					$trading_addr = ClientAddress::getDetailsById( $client_row->field_value );
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "reg_address") {
					$reg_address = ClientAddress::getFullAddress( $client_row->field_value );
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "corres_address") {
					$corres_address = ClientAddress::getFullAddress($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "banker_address") {
					$banker_address = ClientAddress::getFullAddress($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "oldacc_address") {
					$oldacc_address = ClientAddress::getFullAddress($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "auditors_address") {
					$auditors_address = ClientAddress::getFullAddress($client_row->field_value);
				}
				if (isset($client_row['field_name']) && $client_row['field_name'] == "solicitors_address") {
					$solicitors_address = ClientAddress::getFullAddress($client_row->field_value);
				}

				if (isset($client_row['field_name']) && $client_row['field_name'] == "business_name") {
					$client_data['client_name']	= $client_row->field_value;
				}

			}

			$client_data['address'] = substr($address, 0, -2);
			$client_data['TAddress'] = $TAddress;
			$client_data['TAddress']['address'] = isset ($TAddress['address']) ? implode(',',$TAddress['address']) : '';
			$client_data['serv_addr']			= $serv_address;
			$client_data['res_addr']			= $res_address;
			$client_data['trad_addr']			= $trad_address;
			$client_data['reg_addr']			= $reg_address;
			$client_data['corres_addr']			= $corres_address;
			$client_data['banker_addr']			= $banker_address;
			$client_data['account_addr']		= $oldacc_address;
			$client_data['auditor_addr']		= $auditors_address;
			$client_data['solicitor_addr']		= $solicitors_address;
			$client_data['residential_address']	= $residential_addr;
			
		}


		return $client_data;
	}

	public static function get_acting_client($client_id)
	{
		$acting_client = array();
		$data 	= array();
		$data1 	= array();
		$data2 	= array();

		$acting_client1 = ClientActing::where("client_id", "=", $client_id)->get();
		
        if(isset($acting_client1) && count($acting_client1) >0 ){
        	foreach ($acting_client1 as $key => $row) {
        		$clientId =  $row->acting_client_id;
        		
        		$client_name = StepsFieldsClient::where("field_name", "=", 'business_name')->where("client_id", "=", $clientId)->first();
        		
        		if(isset($client_name) && count($client_name) >0 ){
        			$data1[$key]['name'] = $client_name['field_value'];
        		}else{
        			$client_details = StepsFieldsClient::where("step_id", "=", 1)->where("client_id", "=", $clientId)->get();
	        		
        			//echo $this->last_query();die;
        			if(isset($client_details) && count($client_details) >0 ){
        				$name = "";
        				foreach($client_details as $client_name){
        					if(isset($client_name->field_name) && $client_name->field_name == "client_name"){
	        					$name = $client_name->field_value;
	        					break;
	        				}
        					if(isset($client_name->field_name) && $client_name->field_name == "fname"){
	        					$name .= $client_name->field_value." ";
	        				}
	        				if(isset($client_name->field_name) && $client_name->field_name == "mname"){
	        					$name .= $client_name->field_value." ";
	        				}
	        				if(isset($client_name->field_name) && $client_name->field_name == "lname"){
	        					$name .= $client_name->field_value." ";
	        				}
        				
                        }
        				$data1[$key]['name'] = trim($name);
        				
        			}
        			
        		}
        		$data1[$key]['acting_id'] 			= $row->acting_id;
        		$data1[$key]['user_id'] 			= $row->user_id;
        		$data1[$key]['client_id'] 			= $row->client_id;
        		$data1[$key]['acting_client_id'] 	= $row->acting_client_id;

        		//######## get client type #########//
				$client_data = Client::where("client_id", "=", $row->acting_client_id)->first();
				if(isset($client_data) && count($client_data) >0){
					if($client_data['type'] == "ind"){
						$data1[$key]['link'] = "/client/edit-ind-client/".$row->acting_client_id.'/'.base64_encode('ind_client');
					}
					else if($client_data['type'] == "org"){
						$data1[$key]['link'] = "/client/edit-org-client/".$row->acting_client_id.'/'.base64_encode('org_client');
					}else if($client_data['type'] == "chd"){
						if($client_data['chd_type'] == "ind"){
							$data1[$key]['link'] = "/client/edit-ind-client/".$row->acting_client_id.'/'.base64_encode('ind_client');
						}
						else if($client_data['chd_type'] == "org"){
							$data1[$key]['link'] = "/client/edit-org-client/".$row->acting_client_id.'/'.base64_encode('org_client');
						}else{
							$data1[$key]['link'] = "";
						}
					}else{
						$data1[$key]['link'] = "";
					}
					
				}
				//######## get client type #########//

        	}
        }


        $acting_client2 = ClientActing::where("acting_client_id", "=", $client_id)->get();
        if(isset($acting_client2) && count($acting_client2) >0 ){
        	foreach ($acting_client2 as $key => $row) {
        		$clientId =  $row->client_id;
        		
        		$client_name = StepsFieldsClient::where("field_name", "=", 'business_name')->where("client_id", "=", $clientId)->first();
        		
        		if(isset($client_name) && count($client_name) >0 ){
        			$data2[$key]['name'] = $client_name['field_value'];
        		}else{
        			$client_details = StepsFieldsClient::where("step_id", "=", 1)->where("client_id", "=", $clientId)->get();
	        		
        			//echo $this->last_query();die;
        			if(isset($client_details) && count($client_details) >0 ){
        				$name = "";
        				foreach($client_details as $client_name){
        					if(isset($client_name->field_name) && $client_name->field_name == "client_name"){
	        					$name = $client_name->field_value;
	        					break;
	        				}
        					if(isset($client_name->field_name) && $client_name->field_name == "fname"){
	        					$name .= $client_name->field_value." ";
	        				}
	        				if(isset($client_name->field_name) && $client_name->field_name == "mname"){
	        					$name .= $client_name->field_value." ";
	        				}
	        				if(isset($client_name->field_name) && $client_name->field_name == "lname"){
	        					$name .= $client_name->field_value." ";
	        				}
        				
                        }
        				$data2[$key]['name'] = trim($name);
        				
        			}
        			
        		}
        		$data2[$key]['acting_id'] 			= $row->acting_id;
        		$data2[$key]['user_id'] 			= $row->user_id;
        		$data2[$key]['client_id'] 			= $row->acting_client_id;
        		$data2[$key]['acting_client_id'] 	= $row->client_id;

        		//######## get client type #########//
				$client_data = Client::where("client_id", "=", $row->client_id)->first();
				if(isset($client_data) && count($client_data) >0){
					if($client_data['type'] == "ind"){
						$data2[$key]['link'] = "/client/edit-ind-client/".$row->client_id.'/'.base64_encode('ind_client');
					}
					else if($client_data['type'] == "org"){
						$data2[$key]['link'] = "/client/edit-org-client/".$row->client_id.'/'.base64_encode('org_client');
					}else if($client_data['type'] == "chd"){
						if($client_data['chd_type'] == "ind"){
							$data2[$key]['link'] = "/client/edit-ind-client/".$row->client_id.'/'.base64_encode('ind_client');
						}
						else if($client_data['chd_type'] == "org"){
							$data2[$key]['link'] = "/client/edit-org-client/".$row->client_id.'/'.base64_encode('org_client');
						}else{
							$data2[$key]['link'] = "";
						}
					}else{
						$data2[$key]['link'] = "";
					}
					
				}
				//######## get client type #########//

        	}
        }

        $acting = array_merge($data1, $data2);//print_r($acting);die;
        $i = 0;
        foreach ($acting as $key => $value) {
        	if(isset($value['name']) && $value['name'] != ""){
        		$client_value = Client::where("is_deleted", "=", "N")->where("client_id", "=", $value['acting_client_id'])->first();
        		if(isset($client_value['is_archive']) && $client_value['is_archive'] == "N"){
        			$data[$i]['name'] 				= $value['name'];
	        		$data[$i]['acting_id'] 			= $value['acting_id'];
	        		$data[$i]['user_id'] 			= $value['user_id'];
	        		$data[$i]['client_id'] 			= $value['client_id'];
	        		$data[$i]['acting_client_id'] 	= $value['acting_client_id'];
	        		$data[$i]['link'] 				= $value['link'];
	        		$i++;
        		}
        		
        	}
        }
        return $data;
	}


	public static function get_relationship_client($client_id)
	{
		$data = array();
		$data1 = array();
		$data2 = array();

		$relationship1 = DB::table('client_relationships as cr')->where("cr.client_id", $client_id)
      ->join('relationship_types as rt', 'cr.relationship_type_id', '=', 'rt.relation_type_id')
      ->select('cr.client_relationship_id', 'rt.relation_type', 'cr.appointment_with as client_id', 'cr.acting')->get();//print_r($relationship1);die;
    //Common::last_query();die;

		if(isset($relationship1) && count($relationship1) >0 )
    {
    	foreach ($relationship1 as $key => $row) {
    		$client_name = StepsFieldsClient::where("field_name", 'business_name')->where("client_id", $row->client_id)->first();
    		if(isset($client_name) && count($client_name) >0 ){
    			$data1[$key]['name'] = $client_name['field_value'];
    		}else{
    			$client_details = StepsFieldsClient::where("step_id", 1)->where("client_id", $row->client_id)->get();
    			//echo $this->last_query();die;
    			if(isset($client_details) && count($client_details) >0 ){
    				$name = "";
    				foreach($client_details as $client_name){
    					if(isset($client_name->field_name) && $client_name->field_name == "client_name"){
      					$name = $client_name->field_value;
      					break;
      				}
    					if(isset($client_name->field_name) && $client_name->field_name == "fname"){
      					$name .= $client_name->field_value." ";
      				}
      				if(isset($client_name->field_name) && $client_name->field_name == "mname"){
      					$name .= $client_name->field_value." ";
      				}
      				if(isset($client_name->field_name) && $client_name->field_name == "lname"){
      					$name .= $client_name->field_value." ";
      				}
	    				
            }
    				$data1[$key]['name'] = trim($name);
    			}
    		}
   		  $data1[$key]['client_relationship_id'] 	= $row->client_relationship_id;
    		$data1[$key]['relation_type'] 					= $row->relation_type;
    		$data1[$key]['acting'] 									= $row->acting;
    		$data1[$key]['client_id'] 							= $row->client_id;

    		//######## get client type #########//
				$client_data = Client::where("client_id", "=", $row->client_id)->first();
				if(isset($client_data) && count($client_data) >0){
					if($client_data['type'] == "ind"){
						$data1[$key]['link'] = "/client/edit-ind-client/".$row->client_id.'/'.base64_encode('ind_client');
					}
					else if($client_data['type'] == "org"){
						$data1[$key]['link'] = "/client/edit-org-client/".$row->client_id.'/'.base64_encode('org_client');
					}else if($client_data['type'] == "chd"){
						if($client_data['chd_type'] == "ind"){
							$data1[$key]['link'] = "/client/edit-ind-client/".$row->client_id.'/'.base64_encode('ind_client');
						}
						else if($client_data['chd_type'] == "org"){
							$data1[$key]['link'] = "/client/edit-org-client/".$row->client_id.'/'.base64_encode('org_client');
						}else{
							$data1[$key]['link'] = "";
						}
					}else{
						$data1[$key]['link'] = "";
					}

					$data1[$key]['type'] 						= $client_data['type'];
					$data1[$key]['chd_type'] 				= $client_data['chd_type'];
					$data1[$key]['is_archive'] 			= $client_data['is_archive'];
					$data1[$key]['is_relation_add'] = $client_data['is_relation_add'];
					$data1[$key]['is_deleted'] 			= $client_data['is_deleted'];
					
				}
				//######## get client type #########//
    		
			}
    }


    $relationship2 = DB::table('client_relationships as cr')->where("cr.appointment_with",$client_id)
      ->join('relationship_types as rt', 'cr.relationship_type_id', '=', 'rt.relation_type_id')
      ->select('cr.client_relationship_id', 'rt.relation_type', 'cr.client_id', 'cr.acting')->get();

    if(isset($relationship2) && count($relationship2) >0 )
    {
    	foreach ($relationship2 as $key => $row) {
    		$client_name = StepsFieldsClient::where("field_name", 'business_name')->where("client_id", $row->client_id)->first();
    		if(isset($client_name) && count($client_name) >0 ){
    			$data2[$key]['name'] = $client_name['field_value'];
    		}else{
    			$client_details = StepsFieldsClient::where("step_id", 1)->where("client_id", $row->client_id)->get();
    			//echo $this->last_query();die;
    			if(isset($client_details) && count($client_details) >0 ){
    				$name = "";
    				foreach($client_details as $client_name){
    					if(isset($client_name->field_name) && $client_name->field_name == "client_name"){
      					$name = $client_name->field_value;
      					break;
      				}
    					if(isset($client_name->field_name) && $client_name->field_name == "fname"){
      					$name .= $client_name->field_value." ";
      				}
      				if(isset($client_name->field_name) && $client_name->field_name == "mname"){
      					$name .= $client_name->field_value." ";
      				}
      				if(isset($client_name->field_name) && $client_name->field_name == "lname"){
      					$name .= $client_name->field_value." ";
      				}
    				
                    }
    				$data2[$key]['name'] = trim($name);
    				
    			}
    			
    		}
	    	$data2[$key]['client_relationship_id'] 	= $row->client_relationship_id;
				$data2[$key]['relation_type'] 			= $row->relation_type;
				$data2[$key]['acting'] 					= $row->acting;
				$data2[$key]['client_id'] 				= $row->client_id;
			  		//######## get client type #########//
				$client_data = Client::where("client_id", "=", $row->client_id)->first();
				if(isset($client_data) && count($client_data) >0){
					if($client_data['type'] == "ind"){
						$data2[$key]['link'] = "/client/edit-ind-client/".$row->client_id.'/'.base64_encode('ind_client');
					}
					else if($client_data['type'] == "org"){
						$data2[$key]['link'] = "/client/edit-org-client/".$row->client_id.'/'.base64_encode('org_client');
					}else if($client_data['type'] == "chd"){
						if($client_data['chd_type'] == "ind"){
							$data2[$key]['link'] = "/client/edit-ind-client/".$row->client_id.'/'.base64_encode('ind_client');
						}
						else if($client_data['chd_type'] == "org"){
							$data2[$key]['link'] = "/client/edit-org-client/".$row->client_id.'/'.base64_encode('org_client');
						}else{
							$data2[$key]['link'] = "";
						}
					}else{
						$data2[$key]['link'] = "";
					}

					$data2[$key]['type'] 						= $client_data['type'];
					$data2[$key]['chd_type'] 				= $client_data['chd_type'];
					$data2[$key]['is_archive'] 			= $client_data['is_archive'];
					$data2[$key]['is_relation_add'] = $client_data['is_relation_add'];
					$data2[$key]['is_deleted'] 			= $client_data['is_deleted'];	
			
				}
				//######## get client type #########//
    		
			}
    }

    $relationship = array_merge($data1, $data2);
    $relationship = array_unique($relationship, SORT_REGULAR);//print_r($relationship);die;
    $i = 0;
    foreach ($relationship as $key => $value) {
    	if(isset($value['name']) && $value['name'] != ""){
    		
    		$data[$i]['name'] 					= $value['name'];
    		$data[$i]['client_relationship_id'] = $value['client_relationship_id'];
    		$data[$i]['relation_type'] 	= $value['relation_type'];
    		$data[$i]['acting'] 				= $value['acting'];
    		$data[$i]['client_id'] 			= $value['client_id'];
    		$data[$i]['link'] 					= isset($value['link'])?$value['link']:"";
    		$data[$i]['type'] 					= isset($value['type'])?$value['type']:"";
				$data[$i]['is_archive'] 		= isset($value['is_archive'])?$value['is_archive']:"";
				$data[$i]['is_relation_add']= isset($value['is_relation_add'])?$value['is_relation_add']:"";
				$data[$i]['is_deleted'] 		= isset($value['is_deleted'])?$value['is_deleted']:"";
    		$i++;
      	
    	}
    }//print_r($data);die;


    return $data;
	}

	public static function get_services_client($client_id)
	{
		$data2 = array();
		$service = DB::table('client_services as cs')->where("cs.client_id", "=", $client_id)
            ->join('services as s', 'cs.service_id', '=', 's.service_id')
            ->select('cs.*', 's.service_name')->get();
        if(isset($service) && count($service) >0 )
        {
        	foreach ($service as $key => $row) {
        		$data2[$key]['client_service_id'] 	= $row->client_service_id;
        		$data2[$key]['client_id'] 			= $row->client_id;
        		$data2[$key]['service_id'] 			= $row->service_id;
        		$data2[$key]['service_name'] 		= $row->service_name;
        	}
        }
        return $data2;
        exit;

	}

	public static function get_months()
	{
		$data = array( "01" => "JAN", "02" => "FEB", "03" => "MAR", "04" => "APR", "05" => "MAY", "06" => "JUN", "07" => "JUL", "08" => "AUG", "09" => "SEPT", "10" => "OCT", "11" => "NOV", "12" => "DEC");
		return $data;
	}

	public static function get_full_months()
	{
		$data = array( "01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
		return $data;
	}

	public static function getMonthNameShort($month)
    {
        switch ($month) {
            case '1':
                return "JAN";
                break;
            case '2':
                return "FEB";
                break;
            case '3':
                return "MAR";
                break;
            case '4':
                return "APR";
                break;
            case '5':
                return "MAY";
                break;
            case '6':
                return "JUN";
                break;
            case '7':
                return "JUL";
                break;
            case '8':
                return "AUG";
                break;
            case '9':
                return "SEPT";
                break;
            case '10':
                return "OCT";
                break;
            case '11':
                return "NOV";
                break;
            case '12':
                return "DEC";
                break;

            default:
                return $month;
                break;
        }
    }

    public static function AjaxGetTaxyear()
    {
        $data = array();
        $last_one   = date('Y', strtotime('-1 year', time()));
        $last_two   = date('Y', strtotime('-2 year', time()));
        $last_three = date('Y', strtotime('-3 year', time()));
        $last_four  = date('Y', strtotime('-4 year', time()));

        $last_year[0] = $last_one.'/'.date('y');
        $last_year[1] = $last_two.'/'.substr($last_one, 2,2);
        $last_year[2] = $last_three.'/'.substr($last_two, 2,2);
        $last_year[3] = $last_four.'/'.substr($last_three, 2,2);
        
        return $last_year;
    }

    public static function getClientNameByClientId($client_id)
	{
		$name = "";
        $fname = "";
        $lname = "";
		$field_name = "client_name";
		$client = Client::where('client_id', '=', $client_id)->select('type')->first();
		//echo $client['type'];die;
		if(isset($client['type']) && $client['type'] == 'org'){
			$details = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', $field_name)->select('field_value')->first();

			if(isset($details['field_value']) && $details['field_value'] != ''){
				$name 	= $details['field_value'];
			}
		}else if(isset($client['type']) && $client['type'] == 'ind'){
			$fname = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', 'fname')->select('field_value')->first();
			//echo Common::last_query();
            if(isset($fname['field_value']) && $fname['field_value'] != ''){
                $fname 	= $fname['field_value'];
            }

            $lname = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', 'lname')->select('field_value')->first();
            if(isset($lname['field_value']) && $lname['field_value'] != ''){
                $lname 	= $lname['field_value'];
            }
            $name = $fname." ".$lname;
		}
        
		
        
        
		//Common::last_query();
		return trim($name);
		exit;
	}

	public static function save_client($c_id,$step_id,$field_name,$prev_value,$updated_value,$store_id,$full_name)
    {
      $data = array();
      $admin_s = Session::get('admin_details'); // session

      $data['store_id'] 		= $store_id;
      $data['user_id'] 			= $admin_s['id'];
			$data['client_id'] 		= $c_id;
      $data['step_id'] 			= $step_id;
      $data['field_name'] 	= $field_name;
      $data['prev_value'] 	= $prev_value;
      $data['updated_value']= $updated_value;
      $data['full_name'] 		= $full_name;
      return $data;
        //OrganisationClient::insert($data);
    }

    public static function getGroupUser(){
    	$data = array();
    	$session 		= Session::get('admin_details');
		$groupUserId 	= $session['group_users'];
		if(isset($groupUserId) && count($groupUserId) >0){
			foreach ($groupUserId as $key => $value) {
				$data[$key] = $value['user_id'];
			}
		}
		return $data;
    }

    public static function getFieldName($client_type)
    {
        $data = array();
        //if($client_type == 'org'){
            $data['registration_number'] 	= 'CRN';
            $data['client_code'] 			= 'Client Code';
            $data['ch_auth_code'] 			= 'CH Authentication Code';
            $data['tax_reference'] 			= 'Tax Reference';
            $data['vat_number'] 			= 'Vat Number';
            $data['vat_stagger'] 			= 'Vat Stagger';
            $data['acc_office_ref'] 		= 'Acc Office Reference';
            $data['paye_reference'] 		= 'PAYE Reference';
            $data['effective_date'] 		= 'Effective Date of Registration';
            $data['vat_scheme_type'] 		= 'Vat Scheme';
            $data['ret_frequency'] 			= 'Return Frequency';
            $data['trad'] 					= 'Address - Trading';
            $data['corres'] 				= 'Address - Correspondence';
            $data['reg'] 					= 'Address - Registered office';
        //}else{
        	$data['client_code'] 	= 'Client Code';
            $data['dob'] 			= 'DOB';
            $data['occupation'] 	= 'Occupation';
            $data['ni_number'] 		= 'NI Number';
            $data['tax_reference'] 	= 'Tax Reference';
            $data['marital_status'] = 'Marital Status';
            $data['country'] 		= 'Country of Residence';
            $data['nationality'] 	= 'Nationality';
            $data['res'] 			= 'Address - Residential';
            $data['serv'] 			= 'Address -  Service';
            $data['res_email'] 		= 'Email';
            $data['res_website'] 	= 'Website';
            $data['res_skype'] 		= 'Skype';
        //}
        

        return $data;
    }

    public static function getCorrectFieldName($field_name)
    {
        $data = array();
        switch ($field_name) {
		    case 'client_code':
		        $name = 'Client Code'; break;
		    case 'registration_number':
		        $name = 'CRN'; break;
		    case 'ch_auth_code':
		        $name = 'CH Authentication Code'; break;
		    case 'tax_reference':
		        $name = 'Tax Reference'; break;
		    case 'vat_number':
		        $name = 'Vat Number'; break;
		    case 'vat_stagger':
		        $name = 'Vat Stagger'; break;
		    case 'acc_office_ref':
		        $name = 'Acc Office Reference'; break;
		    case 'paye_reference':
		        $name = 'PAYE Reference'; break;
		    case 'effective_date':
		        $name = 'Effective Date of Registration'; break;
		    case 'vat_scheme_type':
		        $name = 'Vat Scheme'; break;
		    case 'ret_frequency':
		        $name = 'Return Frequency'; break;
		    case 'trad':
		        $name = 'Address - Trading'; break;
		    case 'corres':
		        $name = 'Address - Correspondence'; break;
		    case 'reg':
		        $name = 'Address - Registered office'; break;

		    case 'dob':
		        $name = 'DOB'; break;
		    case 'occupation':
		        $name = 'Occupation'; break;
		    case 'ni_number':
		        $name = 'NI Number'; break;
		    case 'tax_reference':
		        $name = 'Tax Reference'; break;
		    case 'marital_status':
		        $name = 'Marital Status'; break;
		    case 'country':
		        $name = 'Country of Residence'; break;
		    case 'nationality':
		        $name = 'Nationality'; break;
		    case 'res':
		        $name = 'Address - Residential'; break;
		    case 'serv':
		        $name = 'Address -  Service'; break;
		    case 'res_email':
		        $name = 'Email'; break;
		    case 'res_website':
		        $name = 'Website'; break;
		    case 'res_skype':
		        $name = 'Skype'; break;
			default:
		        $name = 'none';
		}
		return $name;
    }

    public static function getGeneralPlaceHolder()
    {
    	$data = array();
    	$session 	= Session::get('admin_details');
        $user_id    = $session['id'];

    	$title = User::getDataByFieldAndUserId('title', $user_id);
        $data['todays_date']        = date('dS F, Y');
        $data['user_name']          = $title.' '.User::getStaffNameById($user_id);
        $data['user_qualification'] = User::getDataByFieldAndUserId('qualifications', $user_id);
        $data['user_position']      = User::getJobTitleByUserId($user_id);

    	return $data;
    }

    public static function clientDetailsByIdForPlaceHolder($client_id)
    {
    	$d = array();
    	$i = 'individual_';$spd = 'spouse_dob';
    	$ds 	  	  = Common::clientDetailsById($client_id);//echo "<pre>";print_r($ds);die;
    	$tax_address  = !empty($ds['tax_address'])?str_replace(',', '<br>', $ds['tax_address']):'';
    	$serv_addr2   = !empty($ds['serv_addr'])?str_replace(',', '<br>', $ds['serv_addr']):'';
    	$res_addr2    = !empty($ds['res_addr'])?str_replace(',', '<br>', $ds['res_addr']):'';
    	
    	$d[$i.'client_code'] 		= !empty($ds['client_code'])?$ds['client_code']:'';
    	$d[$i.'title'] 				= !empty($ds['title'])?$ds['title']:'';
    	$d[$i.'fname'] 				= !empty($ds['fname'])?$ds['fname']:'';
    	$d[$i.'mname'] 				= !empty($ds['mname'])?$ds['mname']:'';
    	$d[$i.'lname'] 				= !empty($ds['lname'])?$ds['lname']:'';
    	$d[$i.'gender'] 			= !empty($ds['gender'])?$ds['gender']:'';
    	$d[$i.'dob'] 				= !empty($ds['dob'])?date('dS F, Y', strtotime($ds['dob'])):'';
    	$d[$i.'marital_status'] 	= !empty($ds['marital_status'])?$ds['marital_status']:'';
    	$d[$i.'spouse_dob'] 		= !empty($ds[$spd])?date('dS F, Y', strtotime($ds[$spd])):'';
    	$d[$i.'country_recidence'] 	= !empty($ds['country_name'])?$ds['country_name']:'';
    	$d[$i.'occupation'] 		= !empty($ds['occupation'])?$ds['occupation']:'';
    	$d[$i.'nationality'] 		= !empty($ds['nationality_name'])?$ds['nationality_name']:'';
    	$d[$i.'ni_number'] 			= !empty($ds['ni_number'])?$ds['ni_number']:'';
    	$d[$i.'tax_reference'] 		= !empty($ds['tax_reference'])?$ds['tax_reference']:'';
    	$d[$i.'taxoffice_address'] 	= $tax_address;
    	$d[$i.'taxoffice_postcode'] = !empty($ds['tax_zipcode'])?$ds['tax_zipcode']:'';
    	$d[$i.'taxoffice_tel'] 		= !empty($ds['tax_telephone'])?$ds['tax_telephone']:'';
		$d[$i.'serv_addr'] 			= !empty($ds['serv_addr'])?$ds['serv_addr']:'';
		$d[$i.'serv_addr_2'] 		= $serv_addr2;
    	$d[$i.'res_addr'] 			= !empty($ds['res_addr'])?$ds['res_addr']:'';
    	$d[$i.'res_addr_2'] 		= $res_addr2;
    	$d[$i.'telephone'] 			= !empty($ds['res_telephone'])?$ds['res_telephone']:'';
    	$d[$i.'mobile'] 			= !empty($ds['res_mobile'])?$ds['res_mobile']:'';
    	$d[$i.'email'] 				= !empty($ds['res_email'])?$ds['res_email']:'';
    	$d[$i.'website'] 			= !empty($ds['res_website'])?$ds['res_website']:'';
    	$d[$i.'skype'] 				= !empty($ds['res_skype'])?$ds['res_skype']:'';

		return $d;
    }

    public static function orgClientDetailsForPlaceHolder($client_id)
    {
    	$a = array();
    	$d = Common::clientDetailsById($client_id);
    	$tax_addr2   = !empty($d['tax_address'])?str_replace(',', '<br>', $d['tax_address']):'';
    	$emp_addr2   = !empty($d['employer_office'])?str_replace(',', '<br>', $d['employer_office']):'';

    	$a['client_code'] 			= !empty($d['client_code'])?$d['client_code']:'';
    	$a['business_type'] 		= (isset($d['business_type']) && $d['business_type']!='')?$d['business_type']:'';
    	$a['business_name'] 		= (isset($d['business_name']) && $d['business_name']!='')?$d['business_name']:'';
    	$a['registration_number'] 	= (isset($d['registration_number']) && $d['registration_number']!='')?$d['registration_number']:'';
    	$a['incorporation_date'] 	= (isset($d['incorporation_date']) && $d['incorporation_date'] !='')?date('dS F, Y', strtotime($d['incorporation_date'])):'';
    	$a['registered_in'] 	= (isset($d['registered_in']) && $d['registered_in']!='')?$d['registered_in']:'';
    	$a['business_desc'] 	= (isset($d['business_desc']) && $d['business_desc']!='')?$d['business_desc']:'';
    	$a['made_up_date'] 		= (isset($d['made_up_date']) && $d['made_up_date'] !='')?date('dS F, Y', strtotime($d['made_up_date'])):'';
        $a['next_ret_due'] 		= (isset($d['next_ret_due']) && $d['next_ret_due'] !='')?date('dS F, Y', strtotime($d['next_ret_due'])):'';
    	$a['ch_auth_code'] 		= (isset($d['ch_auth_code']) && $d['ch_auth_code']!='')?$d['ch_auth_code']:'';
    	$a['acc_ref_day'] 		= (isset($d['acc_ref_day']) && $d['acc_ref_day']!='')?$d['acc_ref_day']:'';
    	$a['last_acc_madeup_date'] 	= (isset($d['last_acc_madeup_date']) && $d['last_acc_madeup_date'] !='')?date('dS F, Y', strtotime($d['last_acc_madeup_date'])):'';
    	$a['next_acc_due'] 			= (isset($d['next_acc_due']) && $d['next_acc_due'] !='')?date('dS F, Y', strtotime($d['next_acc_due'])):'';
    	$a['effective_date'] 		= (isset($d['effective_date']) && $d['effective_date'] !='')?date('dS F, Y', strtotime($d['effective_date'])):'';
    	$a['vat_number'] 			= (isset($d['vat_number']) && $d['vat_number']!='')?$d['vat_number']:'';
    	$a['vat_scheme_type'] 		= (isset($d['vat_scheme_type']) && $d['vat_scheme_type']!='')?$d['vat_scheme_type']:'';
    	$a['ret_frequency'] = (isset($d['ret_frequency']) && $d['ret_frequency']!='')?$d['ret_frequency']:'';
    	$a['vat_stagger'] 	= (isset($d['vat_stagger']) && $d['vat_stagger']!='')?$d['vat_stagger']:'';
    	$a['ecsl_freq'] 	= (isset($d['ecsl_freq']) && $d['ecsl_freq']!='')?$d['ecsl_freq']:'';
    	$a['tax_office_id'] = (isset($d['tax_office_id']) && $d['tax_office_id']!='')?$d['tax_office_id']:'';
    	$a['tax_reference'] = (isset($d['tax_reference']) && $d['tax_reference']!='')?$d['tax_reference']:'';
    	$a['tax_address'] 	= (isset($d['tax_address']) && $d['tax_address']!='')?$d['tax_address']:'';
    	$a['tax_address2'] 	= $tax_addr2;

    	$a['tax_zipcode'] 	= (isset($d['tax_zipcode']) && $d['tax_zipcode']!='')?$d['tax_zipcode']:'';
    	$a['tax_telephone'] = (isset($d['tax_telephone']) && $d['tax_telephone']!='')?$d['tax_telephone']:'';
    	$a['acc_office_ref'] 	= (isset($d['acc_office_ref']) && $d['acc_office_ref']!='')?$d['acc_office_ref']:'';
    	$a['paye_reference'] = (isset($d['paye_reference']) && $d['paye_reference']!='')?$d['paye_reference']:'';
    	$a['employer_office'] = (isset($d['employer_office']) && $d['employer_office']!='')?$d['employer_office']:'';
    	$a['employer_office2'] = $emp_addr2;

    	$a['employer_postcode']  = (isset($d['employer_postcode']) && $d['employer_postcode']!='')?$d['employer_postcode']:'';
    	$a['employer_telephone'] = (isset($d['employer_telephone']) && $d['employer_telephone']!='')?$d['employer_telephone']:'';
    	$a['hmrc_login_details'] = (isset($d['hmrc_login_details']) && $d['hmrc_login_details']!='')?$d['hmrc_login_details']:'';
    	$a['service_list'] 		 = !empty($d['service_list'])?$d['service_list']:'';


		$a['o_tel'] = (isset($d['contacttelephone']) && $d['contacttelephone']!='')?$d['contacttelephone']:'';
		$a['o_fax'] 	= (isset($d['contactfax']) && $d['contactfax']!='')?$d['contactfax']:'';
    	$a['o_email'] 	= (isset($d['contactemail']) && $d['contactemail']!='')?$d['contactemail']:'';
    	$a['o_website'] = (isset($d['contactwebsite']) && $d['contactwebsite']!='')?$d['contactwebsite']:'';


    	$variable = array('trad', 'reg', 'corres', 'auditor', 'account', 'solicitor');
		foreach ($variable as $key => $v) {
			$c = $v.'_cont_';
			$o = 'o_'.$v.'_';
			$a[$o.'name'] 		= (isset($d[$c.'name']) && $d[$c.'name']!='')?$d[$c.'name']:'';
	    	$a[$o.'tel']  		= (isset($d[$c.'telephone']) && $d[$c.'telephone']!='')?$d[$c.'telephone']:'';
	    	$a[$o.'email'] 		= (isset($d[$c.'email'])  && $d[$c.'email'] !='')?$d[$c.'email']: '';
	    	$a[$o.'mobile'] 	= (isset($d[$c.'mobile']) && $d[$c.'mobile']!='')?$d[$c.'mobile']:'';
	    	$a[$o.'skype'] 		= (isset($d[$c.'skype'])  && $d[$c.'skype'] !='')?$d[$c.'skype']: '';
	    	$a[$o.'addr'] 		= (isset($d[$v.'_addr'])  && $d[$v.'_addr'] !='')?$d[$v.'_addr']: '';
	    	$a[$o.'addr2'] 		= str_replace(',', '<br>', $a[$o.'addr']);
		}

    	//$a[''] = (isset($d['']) && $d['']!='')?$d['']:'';
		return $a;
    }


    public static function getArchiveArray($details, $is_archive)
    {
    	$data 	= array();
		if(isset($details) && count($details) >0){
			foreach ($details as $k => $v) {
				if($is_archive == 'hide'){
					if($v['is_archive'] == 'N')
						$data[$k] = $v;
				}else{
					$data[$k] = $v;
				}
			}
		}
		return $data;
    }

    public static function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
	    $pagination = '';
	    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
	        $pagination .= '<ul class="pagination1">';
	        
	        $right_links    = $current_page + 3; 
	        $previous       = $current_page - 3; //previous link 
	        $next           = $current_page + 1; //next link
	        $first_link     = true; //boolean var to decide our first link
	        
	        if($current_page > 1){
				$previous_link = ($previous==0)? 1: $previous;
	            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
	            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
	                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
	                    if($i > 0){
	                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
	                    }
	                }   
	            $first_link = false; //set first link to false
	        }
	        
	        if($first_link){ //if current active page is first link
	            $pagination .= '<li class="first active">'.$current_page.'</li>';
	        }elseif($current_page == $total_pages){ //if it's the last active link
	            $pagination .= '<li class="last active">'.$current_page.'</li>';
	        }else{ //regular current link
	            $pagination .= '<li class="active">'.$current_page.'</li>';
	        }
	                
	        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
	            if($i<=$total_pages){
	                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
	            }
	        }
	        if($current_page < $total_pages){ 
					$next_link = ($i > $total_pages) ? $total_pages : $i;
	                $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
	                $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
	        }
	        
	        $pagination .= '</ul>'; 
	    }
	    return $pagination; //return pagination links
	}


	public static function ClientNameById($client_id)
    {
    	$name = '';
		$qry  = "select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id='".$client_id."' group by client_id";
		$dtls = DB::select(DB::raw( $qry ));
		if (isset($dtls) && count($dtls) >0 && !empty($dtls)) {
            foreach ($dtls as $k => $v) {
            	if(isset($v->field_value) && $v->field_value != ''){
            		$name = $v->field_value;
            	}
            }
        }
        return $name;
	}

	


	
}
