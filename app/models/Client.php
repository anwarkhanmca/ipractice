<?php
class Client extends Eloquent {

	public $timestamps = false;

	public static function getAllClientId()
	{
    $clients        = array();
		$session        = Session::get('admin_details');
  	$user_id        = $session['id'];
  	$groupUserId    = $session['group_users'];

		$client_ids = Client::whereIn('user_id', $groupUserId)->where('is_deleted', "N")
			->where("type", "!=", "chd")->where("is_archive", "N")->where("is_relation_add", "N")
			->select("client_id")->get();
    if (isset($client_ids) && count($client_ids) > 0) {
      foreach ($client_ids as $key => $client_id) {
        $clients[$key] = $client_id->client_id;
      }
    }
    return $clients;
	}

	public static function getAllOrgClientDetails()
	{
		$client_data = array();
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$client_ids = Client::where("is_deleted","N")->where("type","org")->where("is_archive","N")->where("is_relation_add","N")->whereIn("user_id",$groupUserId)->orderBy("client_id","DESC")->get();
		//Common::last_query();die;
		$i = 0;
		if (isset($client_ids) && count($client_ids) > 0) {
			foreach ($client_ids as $client_id) {
				$client_details = StepsFieldsClient::where('client_id', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();
                //Common::last_query();
				$client_data[$i]['client_id'] 			= $client_id->client_id;
				$client_data[$i]['client_type'] 		= "org";
				$client_data[$i]['show_archive'] 		= $client_id->show_archive;
				$client_data[$i]['crm_leads_id'] 		= $client_id->crm_leads_id;
				$client_data[$i]['crm_contact_type']	= $client_id->crm_contact_type;
				$client_data[$i]['is_show_todo']		= $client_id->is_show_todo;
				$client_data[$i]['isshow_crm_invoice']	= $client_id->isshow_crm_invoice;
				$client_data[$i]['created']				= $client_id->created;
				$client_data[$i]['is_deleted']			= $client_id->is_deleted;
				$client_data[$i]['is_archive']			= $client_id->is_archive;

				// ############### GET MANAGE TASK START ################## //
				$jobs = JobsManage::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id->client_id)->first();
				//Common::last_query();
		    	if(isset($jobs) && count($jobs) >0){
		    		$client_data[$i]['ch_manage_task'] 	= $jobs['status'];
		    		$client_data[$i]['job_start_date'] 	= $jobs['created'];
		    	}else{
		    		$client_data[$i]['ch_manage_task'] 	= "N";
		    		$client_data[$i]['job_start_date'] 	= "";
		    	}
				// ############### GET MANAGE TASK END ################## //

				// ############### GET CLIENT LIST ALLOCATION START ################## //
				$list = ClientListAllocation::where("client_id", "=", $client_id->client_id)->get();
				if(isset($list) && count($list) >0){
					foreach ($list as $key => $row) {
						$client_data[$i]['allocation'][$row['service_id']]['service_id'] = $row['service_id'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id1'] = $row['staff_id1'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id2'] = $row['staff_id2'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id3'] = $row['staff_id3'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id4'] = $row['staff_id4'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id5'] = $row['staff_id5'];
					}
				}
				// ############### GET CLIENT LIST ALLOCATION END ################## //

				// ############### GET JOB STATUS START ################## //
				$JobStatus = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "N")->where("client_id", $client_id->client_id)->get();
				//print_r($JobStatus);die;
				if(isset($JobStatus) && count($JobStatus) >0){
					foreach ($JobStatus as $key => $status_row) {
						$service_id = $status_row['service_id'];
						$client_data[$i]['job_status'][$service_id]['job_status_id'] = $status_row['job_status_id'];
						$client_data[$i]['job_status'][$service_id]['client_id'] = $status_row['client_id'];
						$client_data[$i]['job_status'][$service_id]['service_id'] = $status_row['service_id'];
						$client_data[$i]['job_status'][$service_id]['status_id'] = $status_row['status_id'];
						$client_data[$i]['job_status'][$service_id]['created'] = $status_row['created'];
					}//print_r($client_data);//die;
				}
				// ############### GET JOB STATUS END ################## //

				// ############### GET OTHER SERVICES START ################## //
				$client_data[$i]['services_id'] 	=   Client::getServicesIdByClient($client_id->client_id);
				// ############### GET OTHER SERVICES END ################## //


				// ############### GET VAT SCHEME USER START ################## //
				$service = Common::get_services_client($client_id->client_id);
				if(isset($service) && count($service) > 0){
					foreach ($service as $key => $value) {
						if(isset($value['service_name']) && $value['service_name'] == "VAT"){
							//$client_data[$i]['vat_staff_name'] 	= $value['name'];
							$client_data[$i]['vat_staff_name'] 	= $value['service_name'];
						}
					}
				}
				//print_r($service);
				// ############### GET VAT SCHEME USER END ################## //

				if (isset($client_details) && count($client_details) > 0) {
					$corres_address = "";
					$res_address		= "";
          $year_end       = "";
					foreach ($client_details as $client_row) {

						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_acc_due"){ 
							$client_data[$i]['deadacc_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}
						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_ret_due"){
							$client_data[$i]['deadret_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}
            if (isset($client_row['field_name']) && $client_row['field_name'] == "acc_ref_day"){
							$year_end .= $client_row->field_value."-";
						}
						if (isset($client_row['field_name']) && $client_row['field_name'] == "acc_ref_month"){
							$client_data[$i]['ref_month'] = App::make('ChdataController')->getMonthNameShort($client_row->field_value);
              $year_end .= $client_data[$i]['ref_month'];
						}

						if (isset($client_row['field_name']) && $client_row['field_name'] == "business_type") 
						{
							$business_type = OrganisationType::where('organisation_id', $client_row->field_value)->first();
							$client_data[$i][$client_row['field_name']] = $business_type['name'];
						} else {
							$client_data[$i][$client_row['field_name']] = $client_row->field_value;
						}

						if (isset($client_row['field_name']) && $client_row['field_name'] == "vat_scheme_type") 
						{
							$VatScheme = VatScheme::where('vat_scheme_id', $client_row->field_value)->first();
							$client_data[$i]['vat_scheme_name'] = $VatScheme['vat_scheme_name'];
						}

						// ############### GET CORRESPONDENSE ADDRESS START ################## //
						if (isset($client_row['field_name']) && $client_row['field_name'] == "corres_address") {
							$corres_address = ClientAddress::getDetailsById( $client_row->field_value );
							$client_data[$i]['corres_address']	= $corres_address;
						}
						// ############### GET CORRESPONDENSE ADDRESS END ################## //

						// ############### GET REGISTERED ADDRESS START ################## //
						if (isset($client_row['field_name']) && $client_row['field_name'] == "reg_address") {
							$reg_address = ClientAddress::getDetailsById( $client_row->field_value );
							$client_data[$i]['registered_address']	= $reg_address;
						}
						// ############### GET REGISTERED ADDRESS END ################## //
                        
					}
					
					$client_data[$i]['year_end'] = $year_end;
					$i++;
				}

				//echo $this->last_query();die;
			}
           // die;
		}
		//print_r($client_data);die;
		return $client_data;
	}

	public static function getAllIndClientDetails()
	{
		$client_data 		= array();
		$srvsData 			= array();
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 		= $session['group_users'];

		$client_ids = Client::where("is_deleted", "N")->where("type", "ind")->where("is_archive", "N")->where("is_relation_add", "N")->whereIn("user_id", $groupUserId)->get();
		//echo $this->last_query();die;
		$i = 0;
		if (isset($client_ids) && count($client_ids) > 0) {
			foreach ($client_ids as $client_id) {
				$client_details = StepsFieldsClient::where('client_id', '=', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();
				
                $client_data[$i]['client_id'] 			= $client_id->client_id;
                $client_data[$i]['client_type'] 		= "ind";
                $client_data[$i]['show_archive'] 		= $client_id->show_archive;
                $client_data[$i]['crm_leads_id'] 		= $client_id->crm_leads_id;
                $client_data[$i]['crm_contact_type']	= $client_id->crm_contact_type;
                $client_data[$i]['is_show_todo']		= $client_id->is_show_todo;
                $client_data[$i]['isshow_crm_invoice']	= $client_id->isshow_crm_invoice;
                $client_data[$i]['created']				= $client_id->created;
                $client_data[$i]['is_deleted']			= $client_id->is_deleted;
				$client_data[$i]['is_archive']			= $client_id->is_archive;

                // ############### GET CLIENT LIST ALLOCATION START ################## //
				$list = ClientListAllocation::where("client_id", "=", $client_id->client_id)->get();
				if(isset($list) && count($list) >0){
					foreach ($list as $key => $row) {
						$client_data[$i]['allocation'][$row['service_id']]['service_id'] = $row['service_id'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id1'] = $row['staff_id1'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id2'] = $row['staff_id2'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id3'] = $row['staff_id3'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id4'] = $row['staff_id4'];
						$client_data[$i]['allocation'][$row['service_id']]['staff_id5'] = $row['staff_id5'];
					}
				}
				// ############### GET CLIENT LIST ALLOCATION END ################## //

				$client_data[$i]['services_id'] 	=   Client::getServicesIdByClient($client_id->client_id);

				if (isset($client_details) && count($client_details) > 0) {
					$serv_address = "";
					$res_address = "";
					foreach ($client_details as $client_row) {
						//get staff name start
						if (!empty($client_row['field_name']) && $client_row['field_name'] == "resp_staff") {
							$staff_name = User::where('user_id', '=', $client_row->field_value)->select("fname", "lname")->first();
							//echo $this->last_query();die;
							$client_data[$i]['staff_name'] = strtoupper(substr($staff_name['fname'], 0, 1)) . " " . strtoupper(substr($staff_name['lname'], 0, 1));
						}
						//get staff name end

						$client_data[$i]['relationship']= Common::get_relationship_client($client_id->client_id);
						//get business name end


						if (isset($client_row['field_name']) && $client_row['field_name'] == "res_address") {
                $res_address = ClientAddress::getFullAddress($client_row->field_value);
            }	
            if (isset($client_row['field_name']) && $client_row['field_name'] == "serv_address") {
                $serv_address = ClientAddress::getFullAddress($client_row->field_value);
            }	


						if (isset($client_row['field_name']) && $client_row['field_name'] == "business_type") {
							$business_type = OrganisationType::where('organisation_id', '=', $client_row->field_value)->first();
							$client_data[$i][$client_row['field_name']] = $business_type['name'];
						} else {
							$client_data[$i][$client_row['field_name']] = $client_row->field_value;
						}

					}

					$client_data[$i]['serv_address'] 	= $serv_address;
					$client_data[$i]['address'] 			= $res_address;
					$i++;
				}

				

			}
		}
		//echo "<pre>";print_r($client_data);die;
		return $client_data;
	}

	public static function getAllClientDetails()
	{
		$data = array();
		$allOrgClient = Client::getAllOrgClientDetails();
		$allIndClient = Client::getAllIndClientDetails();
		$data = array_merge($allOrgClient, $allIndClient);
		return array_values($data);
	}

	public static function allServicesIdByClientId($client_id, $contact_type)
	{
		$data = array();
		$clientServicesId 	= Client::getServicesIdByClient($client_id);
		$proposalServicesId = CrmProposalService::getServicesIdByClient($client_id, $contact_type);

		$data = array_merge($clientServicesId,$proposalServicesId);
		return array_unique ($data);
	}

	public static function getServicesIdByClient($client_id)
	{
		$data = array();
		$services = ClientService::where("client_id", $client_id)->get();
		if(isset($services) && count($services) >0){
			foreach ($services as $key => $value) {
				$data[$key] = $value->service_id;
			}
		}
		return $data;
	}

	public static function getSessionUserIds()
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
		if(isset($groupUserId) && count($groupUserId) >0){
			foreach ($groupUserId as $key => $value) {
				$data[$key] = $value['user_id'];
			}
		}
		return $data;
	}


	public static function getUnassignedClientDetails($service_id)
	{
		$client_details = array();
		$client_array = array();

		$client_details = Client::getAllOrgClientDetails();
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $details) {
				if((isset($details['services_id']) && in_array($service_id, $details['services_id']))){

					$alloc_clients = ClientListAllocation::where("client_id", "=", $details['client_id'])->where("service_id", "=", $service_id)->first();

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
		}
		//print_r($client_details);die;
		return array_values($client_array);
	}


	public static function getAssignedClientDetails($service_id, $staff_id)
	{
		$client_array = array();
		$client_details = Client::getAllOrgClientDetails();
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $details) {
				$alloc_clients = ClientListAllocation::where("client_id", $details['client_id'])->where("service_id", $service_id)->first();

				if(isset($alloc_clients) && count($alloc_clients) >0){
					if($alloc_clients['staff_id1'] == $staff_id || $alloc_clients['staff_id2'] == $staff_id || $alloc_clients['staff_id3'] == $staff_id || $alloc_clients['staff_id4'] == $staff_id || $alloc_clients['staff_id5'] == $staff_id ){
						$client_array[$key] = $client_details[$key];

						$client_array[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
						$client_array[$key]['allocated_staffs'] = ClientListAllocation::getAllocatedStaff($details['client_id'], $service_id);
					}
				}

			}
		}

		return array_values($client_array);
	}

	public static function getClientByServiceId( $service_id )
	{
		$client_array = array();
		$client_details = Client::getAllOrgClientDetails();
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $details) {
				if((isset($details['services_id']) && in_array($service_id, $details['services_id']))){
					$client_array[$key] = $client_details[$key];
					$client_array[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
					$client_array[$key]['allocated_staffs'] = ClientListAllocation::getAllocatedStaff($details['client_id'], $service_id);
					$client_array[$key]['jobs_start_days'] = JobsStartDate::getJobStartDaysByServiceId($service_id);
				}
			}
		}
		//print_r($client_array);die;
		return array_values($client_array);
	}

	public static function getCompanyNumberByClientId( $client_id )
	{
		$number = "";
		$client_details = StepsFieldsClient::where('field_name', '=', "registration_number")->where('client_id', '=', $client_id)->select("field_value")->first();
		if(isset($client_details) && count($client_details) >0){
			$number = $client_details['field_value'];
		}
		return $number;
	}

	public static function getCorresAddressByClientId( $client_id )
	{
		$data = array();
		$client_details = StepsFieldsClient::where('client_id', $client_id)->select('field_name', 'field_value')->get();
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key=>$client_row) {
				if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_addr_line1"){
					$data['address1'] .= $client_row->field_value.", ";
				}
				if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_addr_line2"){
					$corres_address .= $client_row->field_value.", ";
				}
				if (isset($client_row->field_name) && $client_row->field_name == "corres_cont_county"){
					$corres_address .= $client_row->field_value.", ";
				}
			}
		}
		return $number;
	}

	public static function getContactNameByClientId( $client_id )
	{
		$data = array();
		$i = 0;
		$client_details = Common::clientDetailsById($client_id);
		if(isset($client_details) && count($client_details) >0){
			$variable = array('trad', 'reg', 'corres', 'banker', 'oldacc', 'auditors', 'solicitors');
			foreach ($variable as $key => $value) {
				if(isset($client_details[$value.'_cont_name']) && $client_details[$value.'_cont_name'] != ''){
					$data[$i]['client_id'] 		= $client_details['client_id'];
					$data[$i]['address_type'] 	= $value;
					$data[$i]['contact_name'] 	= $client_details[$value.'_cont_name'];
					$data[$i]['email'] 			= isset($client_details[$value.'_cont_email'])?$client_details[$value.'_cont_email']:'';
					$i++;
				}
			}
		}
		return $data;
		exit;
	}

	public static function getAddressByClientId( $client_id, $type )
	{ 
		$data = array();
		$i = 0;
		$details = Common::clientDetailsById($client_id);
		if(isset($details) && count($details) >0){
			if($type == 'res'){
				$data['email'] 		= isset($details['res_email'])?$details['res_email']:'';
				$data['telephone'] 	= isset($details['res_telephone'])?$details['res_telephone']:'';
			}else{
				$data['email'] = isset($details[$type.'_cont_email'])?$details[$type.'_cont_email']:'';	
				$data['telephone']=isset($details[$type.'_cont_telephone'])?$details[$type.'_cont_telephone']:'';
			}
			
		}
		return $data;
		exit;
	}

	public static function getRelationNameByClientId( $client_id )
	{
		$data = array();
		$i = 0;
		$client_details = Common::get_relationship_client($client_id);
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $value) {
				if(isset($value['name']) && $value['name'] != ''){
					$data[$i]['client_id'] 		= $value['client_id'];
					if(isset($value['type']) && $value['type'] == 'ind'){
						$data[$i]['address_type'] 	= 'res';
					}else{
						$data[$i]['address_type'] 	= 'corres';
					}
					$data[$i]['contact_name'] 	= $value['name'];
					$data[$i]['email'] 			= Client::getEmail($value['client_id'], $value['type']);
					$i++;
				}
			}
		}//print_r($data);die;
		return $data;
		exit;
	}

	public static function getEmail($client_id, $type)
	{
		$email = "";
		if($type == 'ind'){
			$field_name = 'res_email';
		}else{
			$field_name = 'corres_cont_email';
		}

		$details = StepsFieldsClient::where('client_id', $client_id)->where('field_name', $field_name)->select('field_value')->first();

		if(isset($details['field_value']) && $details['field_value'] != ''){
			$email 	= $details['field_value'];
		}
		//Common::last_query();
		return $email;
		exit;
	}

	public static function getEmailAddress($client_id, $field_name)
	{
		$email = '';
		$details = StepsFieldsClient::where('client_id', $client_id)->where('field_name', $field_name)->select('field_value')->first();

		if(isset($details['field_value']) && $details['field_value'] != ''){
			$email 	= $details['field_value'];
		}
		//Common::last_query();
		return $email;
	}

	public static function getClientNameByClientId($client_id)
	{
		$name = "";
        $title = "";
		$field_name = "client_name";
		$client = Client::where('client_id', $client_id)->select('type')->first();
		if(isset($client['type']) && $client['type'] == 'org'){
			$field_name = 'business_name';
		}else if(isset($client['type']) && $client['type'] == 'ind'){
			$titles = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', 'title')->select('field_value')->first();
            if(isset($titles['field_value']) && $titles['field_value'] != ''){
                $title 	= $titles['field_value'];
            }
		}
        
		$details = StepsFieldsClient::where('client_id', $client_id)->where('field_name', $field_name)->select('field_value')->first();

		if(isset($details['field_value']) && $details['field_value'] != ''){
			$name 	= $details['field_value'];
		}
        
        //echo $client['type'];
		//Common::last_query();//die;
		return trim($title." ".$name);
		exit;
	}

	public static function updateImportedClient($client_id, $details, $return)
	{
		//print_r($details);die;
		$admin_s 	= Session::get('admin_details');
        $user_id 	= $admin_s['id'];

		if(isset($details['Client Code']) && $details['Client Code']!=""){
			Client::updateQuery($client_id,'1','client_code',$details['Client Code']);
		}
		if(isset($details['CH Authentication Code']) && $details['CH Authentication Code']!=""){
		   Client::updateQuery($client_id,'1','ch_auth_code',$details['CH Authentication Code']);
		   Client::updateQuery($client_id, '1', 'ann_ret_check', 1);
		}
		if(isset($details['Tax Reference']) && $details['Tax Reference'] != ""){
			Client::updateQuery($client_id, '2', 'tax_reference', $details['Tax Reference']);
			Client::updateQuery($client_id, '2', 'tax_div', 1);
		}
		if(isset($details['Vat Number']) && $details['Vat Number'] != ""){
			Client::updateQuery($client_id, '2', 'vat_number', $details['Vat Number']);
			Client::updateQuery($client_id, '2', 'tax_div', 1);
		}
		if(isset($details['Vat Stagger']) && $details['Vat Stagger'] != ""){
			Client::updateQuery($client_id, '2', 'vat_stagger', $details['Vat Stagger']);
			Client::updateQuery($client_id, '2', 'tax_div', 1);
		}
		if(isset($details['Corres Addr1']) && $details['Corres Addr1'] != ""){
			$corresaddr['address1'] = $details['Corres Addr1'];
			//Client::updateQuery($client_id, '3', 'corres_cont_addr_line1', $details['Corres Addr1']);
			Client::updateQuery($client_id, '3', 'cont_corres_addr', 'corres');
		}
		if(isset($details['Corres Addr2']) && $details['Corres Addr2'] != ""){
			$corresaddr['address2'] = $details['Corres Addr2'];
			//Client::updateQuery($client_id, '3', 'corres_cont_addr_line2', $details['Corres Addr2']);
			Client::updateQuery($client_id, '3', 'cont_corres_addr', 'corres');
		}
		if(isset($details['City']) && $details['City'] != ""){
			$corresaddr['city'] = $details['City'];
			//Client::updateQuery($client_id, '3', 'corres_cont_city', $details['City']);
			Client::updateQuery($client_id, '3', 'cont_corres_addr', 'corres');
		}
		if(isset($details['County']) && $details['County'] != ""){
			$corresaddr['county'] = $details['County'];
			//Client::updateQuery($client_id, '3', 'corres_cont_county', $details['County']);
			Client::updateQuery($client_id, '3', 'cont_corres_addr', 'corres');
		}
		if(isset($details['Postcode']) && $details['Postcode'] != ""){
			$corresaddr['postcode'] = $details['Postcode'];
			//Client::updateQuery($client_id, '3', 'corres_cont_postcode', $details['Postcode']);
			Client::updateQuery($client_id, '3', 'cont_corres_addr', 'corres');
		}
		if(isset($details['Country']) && $details['Country'] != ""){
			$country_id = Country::getCountryIdByName($details['Country']);
			$corresaddr['country'] = $country_id;
			//Client::updateQuery($client_id, '3', 'corres_cont_country', $country_id);
			Client::updateQuery($client_id, '3', 'cont_corres_addr', 'corres');
		}
		if(isset($details['Corres Cont Name']) && $details['Corres Cont Name'] != ""){
			Client::updateQuery($client_id,'3','corres_cont_name',$details['Corres Cont Name']);
			Client::updateQuery($client_id, '3', 'cont_corres_addr', 'corres');
			Client::updateQuery($client_id, '3', 'corres_name_check', 'corres_cont');
		}
		if(isset($details['Acc Office Reference']) && $details['Acc Office Reference'] != ""){
			$officeref = explode("P", trim($details['Acc Office Reference']));
			Client::updateQuery($client_id, '2', 'samllaccofcref', $officeref[0]);
			Client::updateQuery($client_id, '2', 'acc_office_ref', $officeref[1]);

			Client::updateQuery($client_id, '2', 'paye_reg', 1);
		}
		if(isset($details['PAYE Reference']) && $details['PAYE Reference'] != ""){
			$payeref = explode("/", trim($details['PAYE Reference']));
			Client::updateQuery($client_id, '2', 'samllpayeref', $payeref[0]);
			Client::updateQuery($client_id, '2', 'paye_reference', $payeref[1]);

			Client::updateQuery($client_id, '2', 'paye_reg', 1);
		}
		if(isset($details['HMRC Log-in Details']) && $details['HMRC Log-in Details'] != ""){
			Client::updateQuery($client_id, '2', 'hmrc_login_details', $details['HMRC Log-in Details']);
		}
		if(isset($details['Bank Name']) && $details['Bank Name'] != ""){
			Client::updateQuery($client_id, '3', 'bank_name', $details['Bank Name']);
			Client::updateQuery($client_id, '3', 'cont_banker_addr', 'banker');
		}
		if(isset($details['Sort Code']) && $details['Sort Code'] != ""){
			Client::updateQuery($client_id, '3', 'bank_short_code', $details['Sort Code']);
			Client::updateQuery($client_id, '3', 'cont_banker_addr', 'banker');
		}
		if(isset($details['Account Number']) && $details['Account Number'] != ""){
			Client::updateQuery($client_id, '3', 'bank_acc_no', $details['Account Number']);
			Client::updateQuery($client_id, '3', 'cont_banker_addr', 'banker');
		}
		if(isset($details['Effective Date of Registration']) && $details['Effective Date of Registration']!=""){
			//echo $details['Effective Date of Registration']."<br>";
			Client::updateQuery($client_id, '2', 'effective_date', $details['Effective Date of Registration']);
			Client::updateQuery($client_id, '2', 'reg_for_vat', 1);
		}
		//echo Common::last_query();die;
		if(isset($details['Vat Scheme']) && $details['Vat Scheme'] != ""){
			$vat_scheme_id = VatScheme::getIdByName($details['Vat Scheme']);
			Client::updateQuery($client_id, '2', 'vat_scheme_type', $vat_scheme_id);
			Client::updateQuery($client_id, '2', 'reg_for_vat', 1);
		}
		if(isset($details['Cash or Accrual']) && $details['Cash or Accrual'] != ""){
			$vat_scheme = strtolower($details['Cash or Accrual']);
			Client::updateQuery($client_id, '2', 'vat_scheme', $vat_scheme);
			Client::updateQuery($client_id, '2', 'reg_for_vat', 1);
		}
		if(isset($details['Return Frequency']) && $details['Return Frequency'] != ""){
			$ret_frequency = strtolower($details['Return Frequency']);
			Client::updateQuery($client_id, '2', 'ret_frequency', $ret_frequency);
			Client::updateQuery($client_id, '2', 'reg_for_vat', 1);
		}
		if(isset($details['EC Sales List - Frequency']) && $details['EC Sales List - Frequency'] != ""){
			$ecsl_freq = strtolower($details['EC Sales List - Frequency']);
			Client::updateQuery($client_id, '2', 'ecsl_freq', $ecsl_freq);
			Client::updateQuery($client_id, '2', 'ec_scale_list', 'on');
			
		}
		if(isset($details['Tax Type']) && $details['Tax Type'] != ""){
			$tax_type = Client::getTaxType($details['Tax Type']);
			Client::updateQuery($client_id, '2', 'tax_reference_type', $tax_type);
			Client::updateQuery($client_id, '2', 'tax_div', 1);
		}

		/*========== Unincorporated ============ */
		if(isset($details['Business Type']) && $details['Business Type'] != ""){
			$org_id = OrganisationType::getIdByName($details['Business Type']);
			//echo $org_id;Common::last_query();die;
			Client::updateQuery($client_id, '1', 'business_type', $org_id);
		}
		if(isset($details['Business Name']) && $details['Business Name'] != ""){
			Client::updateQuery($client_id, '1', 'business_name', $details['Business Name']);
		}
		if(isset($details['Year End']) && $details['Year End'] != ""){
			$year_end = explode('-', $details['Year End']);
			if(isset($year_end[0]) && $year_end[0] != ''){
				Client::updateQuery($client_id, '1', 'acc_ref_day', $year_end[0]);
			}
			if(isset($year_end[1]) && $year_end[1] != ''){
				$month = Client::getMonthShort($year_end[1]);
				Client::updateQuery($client_id, '1', 'acc_ref_month', $month);
			}
			Client::updateQuery($client_id, '1', 'yearend_acc_check', 1);
		}


		if(isset($details['Tax District']) && $details['Tax District'] != ""){
			//$details['Tax District'] = '036';
			$crpDtls = CorporationTaxOffice::getAllDetails();
			if (isset($crpDtls) && count($crpDtls) >0 ) {
				foreach ($crpDtls as $key => $row) {
					$dtlsTax = explode(',', $row['office_name']);
					$taxDsrt = $dtlsTax[0];
					if($taxDsrt == $details['Tax District']){
						Client::updateQuery($client_id, '2', 'utrsamllbox', $taxDsrt);
						Client::updateQuery($client_id, '2', 'tax_div', 1);

						Client::updateQuery($client_id, '2', 'tax_office_id', 'C,'.$row['corp_tax_id']);
						//Client::updateQuery($client_id, '2', 'office_type', 'C');
						Client::updateQuery($client_id, '2', 'tax_address', $row['address']);
						Client::updateQuery($client_id, '2', 'tax_zipcode', $row['zipcode']);
						Client::updateQuery($client_id, '2', 'tax_telephone', $row['telephone']);
						break;
					}
				}
			}
		}


		/* ============= SERVICES START ============= */
		if($return == '4'){
			$type = 'ind';
		}else{
			$type = 'org';
		}
		
		//$services = Service::getAllServiceByType($type);//Common::last_query();
		$services = Service::getServicesByType( $type );
		if (isset($services) && count($services) > 0) {
            foreach ($services as $key=>$service_row) {
            	$service_id = ClientService::checkServiceIdByClientId($client_id, $service_row['service_id']);
            	//Common::last_query();
            	if($service_id == ""){
            		$servData['client_id'] 	= $client_id;
	                $servData['service_id'] = $service_row['service_id'];
	                ClientService::insert($servData);
            	}
            }
        }
        //Common::last_query();
        //echo $type;

        //############# SERVICES END ###################//

        /* ============= INDIVIDUAL CLIENT START ============= */
        $client_name 	= "";
        $address 		= array();

        if(isset($details['Title']) && $details['Title'] != ""){
        	Client::updateQuery($client_id, '1', 'title', $details['Title']);
		}
		if(isset($details['First Name']) && $details['First Name'] != ""){
        	$client_name .= $details['First Name']." ";
			Client::updateQuery($client_id, '1', 'fname', $details['First Name']);
		}
		if(isset($details['Middle Name']) && $details['Middle Name'] != ""){
			$client_name .= $details['Middle Name']." ";
			Client::updateQuery($client_id, '1', 'mname', $details['Middle Name']);
		}
		if(isset($details['Last Name']) && $details['Last Name'] != ""){
			$client_name .= $details['Last Name']." ";
			Client::updateQuery($client_id, '1', 'lname', $details['Last Name']);
		}
		Client::updateQuery($client_id, '1', "client_name", trim($client_name));

		if(isset($details['DOB']) && $details['DOB'] != ""){
			Client::updateQuery($client_id, '1', 'dob', $details['DOB']);
		}
		if(isset($details['Spouse DOB']) && $details['Spouse DOB'] != ""){
			Client::updateQuery($client_id, '1', 'spouse_dob', $details['Spouse DOB']);
		}
		if(isset($details['Occupation']) && $details['Occupation'] != ""){
			Client::updateQuery($client_id, '1', 'occupation', $details['Occupation']);
		}
		if(isset($details['NI Number']) && $details['NI Number'] != ""){
			Client::updateQuery($client_id, '1', 'ni_number', $details['NI Number']);
		}
		if(isset($details['Tax Office Address']) && $details['Tax Office Address'] != ""){
			Client::updateQuery($client_id,'2','tax_address',$details['Tax Office Address']);
		}
		if(isset($details['Tax Postcode']) && $details['Tax Postcode'] != ""){
			Client::updateQuery($client_id,'2','tax_zipcode',$details['Tax Postcode']);
		}
		if(isset($details['Tax Telephone']) && $details['Tax Telephone'] != ""){
			Client::updateQuery($client_id,'2','tax_telephone',$details['Tax Telephone']);
		}
		if(isset($details['Service Addr1']) && $details['Service Addr1'] != ""){
			$servaddr['address1'] = $details['Service Addr1'];
			//Client::updateQuery($client_id,'3','serv_addr_line1',$details['Service Addr1']);
		}
		if(isset($details['Service Addr2']) && $details['Service Addr2'] != ""){
			$servaddr['address2'] = $details['Service Addr2'];
			//Client::updateQuery($client_id,'3','serv_addr_line2',$details['Service Addr2']);
		}
		if(isset($details['Service City/Town']) && $details['Service City/Town'] != ""){
			$servaddr['city'] = $details['Service City/Town'];
			//Client::updateQuery($client_id,'3','serv_city',$details['Service City/Town']);
		}
		if(isset($details['Service County']) && $details['Service County'] != ""){
			$servaddr['county'] = $details['Service County'];
			//Client::updateQuery($client_id,'3','serv_county',$details['Service County']);
		}
		if(isset($details['Service Postcode']) && $details['Service Postcode'] != ""){
			$servaddr['postcode'] = $details['Service Postcode'];
			//Client::updateQuery($client_id,'3','serv_postcode',$details['Service Postcode']);
		}
		if(isset($details['Residential Addr1']) && $details['Residential Addr1'] != ""){
			$resaddr['address1'] = $details['Residential Addr1'];
		   //Client::updateQuery($client_id,'3','res_addr_line1',$details['Residential Addr1']);
		}
		if(isset($details['Residential Addr2']) && $details['Residential Addr2'] != ""){
			$resaddr['address2'] = $details['Residential Addr2'];
		   //Client::updateQuery($client_id,'3','res_addr_line2',$details['Residential Addr2']);
		}
		if(isset($details['Residential City/Town']) && $details['Residential City/Town']!=""){
			$resaddr['city'] = $details['Residential City/Town'];
			//Client::updateQuery($client_id,'3','res_city',$details['Residential City/Town']);
		}
		if(isset($details['Residential County']) && $details['Residential County'] != ""){
			$resaddr['county'] = $details['Residential County'];
			//Client::updateQuery($client_id,'3','res_county',$details['Residential County']);
		}
		if(isset($details['Residential Postcode']) && $details['Residential Postcode'] != ""){
			$resaddr['postcode'] = $details['Residential Postcode'];
		  //Client::updateQuery($client_id,'3','res_postcode',$details['Residential Postcode']);
		}
		if(isset($details['Residential Telephone']) && $details['Residential Telephone']!=""){
			Client::updateQuery($client_id,'3','res_telephone',$details['Residential Telephone']);
		}
		if(isset($details['Residential Mobile']) && $details['Residential Mobile'] != ""){
		  	Client::updateQuery($client_id,'3','res_mobile',$details['Residential Mobile']);
		}
		if(isset($details['Email']) && $details['Email'] != ""){
		  	Client::updateQuery($client_id,'3','res_email',$details['Email']);
		}
		if(isset($details['Website']) && $details['Website'] != ""){
		  	Client::updateQuery($client_id,'3','res_website',$details['Website']);
		}
		if(isset($details['Skype']) && $details['Skype'] != ""){
		  	Client::updateQuery($client_id,'3','res_skype',$details['Skype']);
		}

		if(isset($details['Marital Status']) && $details['Marital Status'] != ""){
			$status_name 	= strtolower(trim($details['Marital Status']));
			$status_id 		= MaritalStatus::getMeritalIdByName($status_name);
		  	Client::updateQuery($client_id,'1','marital_status',$status_id);
		}
		if(isset($details['Nationality']) && $details['Nationality'] != ""){
			$national 		= trim($details['Nationality']);
			$national_id 	= Nationality::getNationalityIdByName($national);
		  	Client::updateQuery($client_id,'1','nationality',$national_id);
		}
		//Common::last_query();
		if(isset($details['Country of Residence']) && $details['Country of Residence'] != ""){
			$country 		= trim($details['Country of Residence']);
			$country_id 	= Country::getCountryIdByName($country);
		  	Client::updateQuery($client_id,'1','country',$country_id);
		}

		if(isset($services) && count($services) >0){
            foreach ($services as $key => $value) {
                $srvsData[$key] = $value['service_id'];
            }
        }
		if (isset($srvsData) && count($srvsData) > 0) {
            Client::updateQuery($client_id, '5', 'other_services', serialize($srvsData));
        }

        if($type == 'ind'){
	        $servaddr['address_type'] 	= 'serv';
	        $servaddr['user_id'] 		= $user_id;
	        $servaddr['client_id'] 		= $client_id;
			$checkaddr1 	= substr($servaddr['address1'], 0, 7);
	        $checkpost  	= $servaddr['postcode'];
	        $checkAddr 		= ClientAddress::checkAddress($checkaddr1, $checkpost, 'main');
	        if($checkAddr == 0){
	        	$address_id = ClientAddress::insertGetId($servaddr);
	        	Client::updateQuery($client_id,'3','serv_address',$address_id);
	        }else{
	        	Client::updateQuery($client_id,'3','serv_address',$checkAddr);
	        }

	        $resaddr['address_type'] 	= 'res';
	        $resaddr['user_id'] 		= $user_id;
	        $resaddr['client_id'] 		= $client_id;
	        $checkaddr2 	= substr($resaddr['address1'], 0, 7);
	        $checkpost2  	= $resaddr['postcode'];
	        $checkAddr2 	= ClientAddress::checkAddress($checkaddr2, $checkpost2, 'main');
	        if($checkAddr2 == 0){
	        	$address_id = ClientAddress::insertGetId($resaddr);
	        	Client::updateQuery($client_id,'3','res_address',$address_id);
	        }else{
	        	Client::updateQuery($client_id,'3','res_address',$checkAddr2);
	        }
	    }else{
			$corresaddr['address_type'] 	= 'corres';
	        $corresaddr['user_id'] 			= $user_id;
	        $corresaddr['client_id'] 		= $client_id;
	        $checkaddr3 	= substr($corresaddr['address1'], 0, 7);
	        $checkpost3  	= $corresaddr['postcode'];
	        $checkAddr3 	= ClientAddress::checkAddress($checkaddr3, $checkpost3, 'main');
	        if($checkAddr3 == 0){
	        	$address_id = ClientAddress::insertGetId($corresaddr);
	        	Client::updateQuery($client_id,'3','corres_address',$address_id);
	        }else{
	        	Client::updateQuery($client_id,'3','corres_address',$checkAddr3);
	        }
	    }


		//Common::last_query();die;
        /* ============= INDIVIDUAL CLIENT END =============== */

	}

	public static function saveAddress($address, $address_type, $client_id, $address1, $postcode)
	{
		$session 	= Session::get('admin_details');
    $user_id 	= $session['id'];

		$address['address_type'] 	= $address_type;
    $address['user_id'] 			= $user_id;
    $address['client_id'] 		= $client_id;
    $checkaddr 		= substr($address1, 0, 7);
    $checkpost  	= $postcode;
    $checkAddr 	= ClientAddress::checkAddress($checkaddr, $checkpost, 'main');
    if($checkAddr == 0){
    	$address_id = ClientAddress::insertGetId($address);
    	Client::updateQuery($client_id,'3', $address_type.'_address',$address_id);
    }else{
    	$address_id = $checkAddr;
    	Client::updateQuery($client_id,'3', $address_type.'_address',$address_id);
    }
    return $address_id;
	}

	public static function getTaxType($name)
	{
		switch ($name) {
      case 'Income Tax':
        return "I";
        break;
      case 'Corporation Tax':
        return "C";
        break;
      case 'None':
        return "N";
        break;
      default:
        return 'N';
        break;
    }
	}

	public static function updateQuery($client_id, $step_id, $field_name, $field_value)
  {
  	$data 		= array();
  	$admin_s 	= Session::get('admin_details');
    $user_id 	= $admin_s['id'];

    $details = StepsFieldsClient::where("client_id", "=", $client_id)->where("user_id", "=", $user_id)->where("field_name", "=", $field_name)->select('field_id')->first();
    if(isset($details['field_id']) && $details['field_id'] != ""){
    	StepsFieldsClient::where("field_id", "=", $details['field_id'])->update(array("field_value" => $field_value));
    	$field_id = $details['field_id'];
    }else{
    	$data['user_id'] 	= $user_id;
    	$data['client_id'] 	= $client_id;
    	$data['step_id'] 	= $step_id;
    	$data['field_name'] = $field_name;
    	$data['field_value']= $field_value;
    	$field_id = StepsFieldsClient::insertGetId($data);
    }
    return $field_id;
  }

  public static function getMonthShort($month)
  {
      switch ($month) {
          case 'JAN':
              return "01";
              break;
          case 'FEB':
              return "02";
              break;
          case 'MAR':
              return "03";
              break;
          case 'APR':
              return "04";
              break;
          case 'MAY':
              return "05";
              break;
          case 'JUN':
              return "06";
              break;
          case 'JUL':
              return "07";
              break;
          case 'AUG':
              return "08";
              break;
          case 'SEPT':
              return "09";
              break;
          case 'OCT':
              return "10";
              break;
          case 'NOV':
              return "11";
              break;
          case 'DEC':
              return "12";
              break;

          default:
              return $month;
              break;
      }
  }

  public static function getClientTypeByClientId($client_id){
  	$client = Client::where('client_id', $client_id)->select('type')->first();
		if(isset($client['type']) && $client['type'] == 'org'){
			$type = 'org';
		}else{
			$type = 'ind';
		}
		return $type;
  }

  public static function getClientIdByEmail($email, $type)
	{
		$session        = Session::get('admin_details');
  	$user_id        = $session['id'];
  	$groupUserId    = $session['group_users'];

        $client_id = 0;
		if($type == 'ind'){
			$field_name = 'res_email';
		}else{
			//$field_name = 'corres_cont_email';
			$field_name = 'contactemail';
		}

		$details = StepsFieldsClient::whereIn("user_id", $groupUserId)->where('field_value', '=', $email)->where('field_name', '=', $field_name)->select('client_id')->first();

		if(isset($details['client_id']) && $details['client_id'] != ''){
			$client_id 	= $details['client_id'];
		}
		//Common::last_query();
		return $client_id;
		exit;
	}

	/*public static function getClientNameAndId()
	{
		$session        = Session::get('admin_details');
      	$user_id        = $session['id'];
      	$groupUserId    = $session['group_users'];
        $clients        = array();

		$client_ids = Client::whereIn('user_id', $groupUserId)->where('is_deleted', '=',
            "N")->where("type", "!=", "chd")->where("is_archive", "=", "N")->where("is_relation_add", "=", "N")->select("client_id")->get();
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $key => $client_id) {
                $clients[$key]['client_id'] = $client_id->client_id;
            }
        }
        //echo $this->last_query();die;
        $org_client = App::make('HomeController')->getOrgClient($clients, '');
        $ind_client = App::make('HomeController')->getIndClient($clients, '');
        //$chd_client = $this->getChdClient($clients, $search_value);
        $client_details = array_merge($org_client, $ind_client);
        return $client_details;
	}*/


	public static function getClientNameAndId()
	{
		$groupUserId    = Client::getSessionUserIds();

		$where = "where c.is_deleted='N' and c.is_archive='N' and c.is_relation_add='N' and c.user_id IN ('".implode(',', $groupUserId)."')";
        
		$client_name  = "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=c.client_id and field_value != 'NULL' group by client_id)";

		$query = "select c.client_id, ".$client_name." as client_name FROM clients c ".$where." order by ".$client_name." ASC";

    //echo $query;die;
    $od = DB::select( $query );

    $details = json_decode(json_encode($od), true);
    return $details;
	}

	public static function getClientNameAndIdByType($type)
	{
		$groupUserId    = Client::getSessionUserIds();

		$where = "where c.is_deleted='N' and c.is_archive='N' and c.is_relation_add='N' and c.user_id IN ('".implode(',', $groupUserId)."') and c.type='".$type."' ";
        
		$client_name  = "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=c.client_id and field_value != 'NULL' group by client_id)";

		$query = "select c.client_id, ".$client_name." as client_name, c.type FROM clients c ".$where." order by ".$client_name." ASC";

    //echo $query;die;
    $od = DB::select( $query );

    $details = json_decode(json_encode($od), true);
    return $details;
	}

	public static function getClientListByServiceId( $service_id, $type )
	{
		$groupUserId    = Client::getSessionUserIds();

		$where = "where c.is_deleted='N' and c.is_archive='N' and c.is_relation_add='N' and c.user_id IN ('".implode(',', $groupUserId)."') and c.type='".$type."' AND cs.service_id = ".$service_id;
        
		$client_name = "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=c.client_id and field_value != 'NULL' group by client_id)";
		$business_type = StepsFieldsClient::businessTypeQuery();

		$query = "select c.client_id, ".$client_name." as client_name, c.type, 
			".$business_type." as business_type FROM clients c 
			JOIN client_services cs ON cs.client_id=c.client_id
			".$where." order by ".$client_name." ASC";

    //echo $query;die;
    $od = DB::select( $query );

    $details = json_decode(json_encode($od), true);
    return $details;
	}


	public static function searchClientByName($searchvalue)
	{
		$data 					= array();
		$client_details = array();
		$final_arr 			= array();
		$newvardump 		= array();

		$details = Client::getClientNameAndId();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$value = App::make('HomeController')->arraytolower($value);
				$temp = App::make('HomeController')->search_array($value, $searchvalue, $final_arr);
				if (isset($temp) && count($temp) > 0) {
          $newvardump[$key] = $details[$key];
				}
			}
			$client_details = array_values($newvardump);
		}
		$data['client_details'] = $client_details;
    return $client_details;
	}

	public static function getRelationClientId( $client_id )
	{
		$data = array();
		$i = 0;
		$client_details = Common::get_relationship_client($client_id);
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $value) {
				if(isset($value['client_id']) && $value['client_id'] != ''){
					$data[$i] 		= $value['client_id'];
					$i++;
				}
			}
		}//print_r($data);die;
		return $data;
		exit;
	}
    
  public static function getRelationClient()
  {
    $data = array();
    $session        = Session::get('admin_details');
    $client_id      = $session['client_id'];

    $rel_client = Client::getRelationClientId($client_id);
    $i = 0;
    foreach ($rel_client as $key => $value) {
      $data[$i]['client_id'] 		= $value;
      $data[$i]['client_type'] 	= Client::getClientTypeByClientId($value);
      $data[$i]['client_name'] 	= Client::getClientNameByClientId($value);
      $i++;
    }
    
    return $data;
  }
    
  public static function getRelationClientByClientId($client_id)
  {
    $data = array();
    $rel_client = Client::getRelationClientId($client_id);
    $i = 0;
    foreach ($rel_client as $key => $value) {
      $data[$i]['client_id'] 		= $value;
      $data[$i]['client_type'] 	= Client::getClientTypeByClientId($value);
      $data[$i]['client_name'] 	= Client::getClientNameByClientId($value);
      $i++;
    }
    return $data;
  }

	public static function getAllClientsByType($client_type, $search_value)
  {
    $client_details = array();
    $clients = array();

    $admin_s 			= Session::get('admin_details');
    $user_id 			= $admin_s['id'];
    $groupUserId 	= $admin_s['group_users'];

    $client_ids = Client::where("is_deleted", "N")->where("type", $client_type)->where("is_archive", "N")->where("is_relation_add", "N")->whereIn("user_id", $groupUserId)->select("client_id")->get();

    if (isset($client_ids) && count($client_ids) > 0) {
      foreach ($client_ids as $key => $client_id) {
        $clients[$key]['client_id'] = $client_id->client_id;
      }
    }

    if($client_type == 'ind'){
    	$client_details = Client::getIndClient($clients, $search_value);
    }else{
    	$client_details = Client::getOrgClient($clients, $search_value);
    }

    /*========================Short By Client Name Portion==============================*/
    if (isset($client_details) && count($client_details) > 0) {
      foreach ($client_details as $value) {
        $client_name[] = strtolower($value['client_name']);
      }
      array_multisort($client_name, SORT_ASC, $client_details);
    }

    //print_r($client_details);die;
    /*=======================Short By Client Name Portion===============================*/

    return $client_details;
    exit();
  }

    public static function getOrgClient($client_ids, $search_value)
    {
        $clients = array();
        if($search_value == ""){
        	$client_name = StepsFieldsClient::whereIn('client_id', $client_ids)->where('field_name', '=', 'business_name')->select("field_value", "client_id")->get();
        }else{
        	$client_name = StepsFieldsClient::whereIn('client_id', $client_ids)->where("field_value", "like", '%' . $search_value . '%')->where('field_name', '=', 'business_name')->select("field_value", "client_id")->get();
        }
        
		if (isset($client_name) && count($client_name) > 0) {
            foreach ($client_name as $key => $name) {
                $clients[$key]['client_id']     = $name->client_id;
                $clients[$key]['client_name']   = $name->field_value;
                $clients[$key]['client_type']   = 'org';
            }
        }
        //echo Common::last_query();die;
        return $clients;
    }

    public static function getIndClient($client_ids, $search_value)
    {
        $clients = array();
        if($search_value == ""){
        	$client_name = StepsFieldsClient::where('field_name', '=', 'client_name')->
            whereIn('client_id', $client_ids)->select("field_value", "client_id")->get();
        }else{
       	 	$client_name = StepsFieldsClient::where("field_value", "like", '%' . $search_value . '%')->where('field_name', '=', 'client_name')->whereIn('client_id', $client_ids)->select("field_value", "client_id")->get();
       	}        

        if (isset($client_name) && count($client_name) > 0) {
            foreach ($client_name as $key => $name) {
                $clients[$key]['client_id']     = $name->client_id;
                $clients[$key]['client_name']   = $name->field_value;
                $clients[$key]['client_type']   = 'ind';
            }
        }
        //echo $this->last_query();die;
        return $clients;
    }

    public static function getClientFilterByStaffId($client_details, $service_id, $staff_id)
    {
    	$client_array = array();

    	if($staff_id == "all"){
            if(isset($client_details) && count($client_details) >0){
                foreach ($client_details as $key=>$details) {
                	$client_id 	= $details['client_id'];
                	$client_array[$key] = $client_details[$key];

                	$jnotes = JobsNote::getNotesByClientAndServiceId($client_id, $service_id);
                	$client_array[$key]['jobs_notes'] = $jnotes;

                	$staffs = ClientListAllocation::getAllocatedStaff($client_id, $service_id);
                    $client_array[$key]['allocated_staffs'] = $staffs;

                    $jobs_start_days = JobsStartDate::getJobStartDaysByServiceId($service_id);
                    $client_array[$key]['jobs_start_days'] = $jobs_start_days;
                }
            }
            $client_details = $client_array;
        }else if($staff_id == "none"){
            if(isset($client_details) && count($client_details) >0){
                foreach ($client_details as $key => $details) {
                	$client_id 	= $details['client_id'];
					$allocs 	= ClientListAllocation::staffByClientService($client_id, $service_id);

                    if(isset($allocs) && count($allocs) >0){
                        if($allocs['staff_id1'] != 0 || $allocs['staff_id2'] != 0 || $allocs['staff_id3'] != 0 || $allocs['staff_id4'] != 0 || $allocs['staff_id5'] != 0 ){
                            unset($client_details[$key]);
                        }else{
                            $client_array[$key] = $client_details[$key];

                            $jnotes = JobsNote::getNotesByClientAndServiceId($client_id, $service_id);
		                	$client_array[$key]['jobs_notes'] = $jnotes;

		                	$staffs = ClientListAllocation::getAllocatedStaff($client_id, $service_id);
		                    $client_array[$key]['allocated_staffs'] = $staffs;
                        }
                    }else{
                        $client_array[$key] = $client_details[$key];
                        $jnotes = JobsNote::getNotesByClientAndServiceId($client_id, $service_id);
	                	$client_array[$key]['jobs_notes'] = $jnotes;

	                	$staffs = ClientListAllocation::getAllocatedStaff($client_id, $service_id);
	                    $client_array[$key]['allocated_staffs'] = $staffs;
                    }
                }
            }
            $client_details = array_values($client_array);
        }if(isset($client_details) && count($client_details) >0){
          foreach ($client_details as $key => $details) {
            $client_id 	= $details['client_id'];
						$dtlsAllocs = ClientListAllocation::staffByClientService($client_id, $service_id);
						//echo "<pre>";print_r($dtlsAllocs);die;
            if(isset($dtlsAllocs) && !empty($dtlsAllocs) && count($dtlsAllocs) >0){
            	$allocs = $dtlsAllocs[0];
            	//echo $allocs['staff_id2'];die;
              if( $allocs['staff_id1']==$staff_id || $allocs['staff_id2']==$staff_id || 
              	$allocs['staff_id3']==$staff_id || $allocs['staff_id4']==$staff_id || 
              	$allocs['staff_id5']==$staff_id 
              ){
                $client_array[$key] = $client_details[$key];

                $jnotes = JobsNote::getNotesByClientAndServiceId($client_id, $service_id);
            		$client_array[$key]['jobs_notes'] = $jnotes;

            		$staffs = ClientListAllocation::getAllocatedStaff($client_id, $service_id);
              	$client_array[$key]['allocated_staffs'] = $staffs;


              }
            }

          }
          $client_details = array_values($client_array);
        }
        

        return $client_details;
    }
    
    public static function get_initial_badge($full_name) {
		$string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $full_name);
		//echo $string;die;
		$value = explode(" ", $string); //print_r($value);die;
		$initial_badge = "";
		for ($i = 0; $i < count($value); $i++) {
			if ($value[$i] != "" && strtolower($value[$i]) != "limited" && strtolower($value[$i]) !=
				"ltd" && strtolower($value[$i]) != "llp") {
				$initial_badge .= ucwords(substr(trim($value[$i]), 0, 1));
			}
		}
		return $initial_badge;
	}
    
  public static function getInvitedClient($user_id)
  {
      $data = array();
      $rel_client = UserRelatedCompany::getRelationClientId($user_id);
      $i = 0;
      foreach ($rel_client as $key => $value) {
          $data[$i]['client_id'] 		= $value;
          $data[$i]['client_type'] 	= Client::getClientTypeByClientId($value);
          $data[$i]['client_name'] 	= Client::getClientNameByClientId($value);
          $i++;
      }
      
      return $data;
  }

  public static function save_client($user_id, $client_id, $step_id, $field_name, $field_value)
  { 
    $data = array();
    $data['user_id'] = $user_id;
    $data['client_id'] = $client_id;
    $data['step_id'] = $step_id;
    $data['field_name'] = $field_name;
    $data['field_value'] = $field_value;
    return $data;
    //OrganisationClient::insert($data);
  }
    
  public static function getAddressByAddressType()
	{
		$data_array = array();
		$i = 0;
		$client_ids = Client::getAllClientId();
		if(isset($client_ids) && count($client_ids) >0){
			foreach ($client_ids as $key=>$client_id) {
				$details = Common::clientDetailsById($client_id);

				if(isset($details) && count($details) >0){
					$variable = array('trad', 'reg', 'corres', 'banker', 'oldacc', 'auditors', 'solicitors');
					
					foreach ($variable as $key => $value) {
						$fullAddress = "";
						if(isset($details[$value.'_cont_addr_line1']) &&$details[$value.'_cont_addr_line1']!=''){
							$fullAddress .= $details[$value.'_cont_addr_line1'].", ";
						}
						if(isset($details[$value.'_cont_addr_line2']) && $details[$value.'_cont_addr_line2'] != ''){
							$fullAddress .= $details[$value.'_cont_addr_line2'].", ";
						}
						if(isset($details[$value.'_cont_city']) && $details[$value.'_cont_city'] != ''){
							$fullAddress .= $details[$value.'_cont_city'].", ";
						}
						if(isset($details[$value.'_cont_county']) && $details[$value.'_cont_county'] != ''){
							$fullAddress .= $details[$value.'_cont_county'].", ";
						}
						if(isset($details[$value.'_cont_country']) && $details[$value.'_cont_country'] != ''){
							$fullAddress .= Country::getCountryNameByCountryId($details[$value.'_cont_country']).", ";
						}
						if(isset($details[$value.'_cont_postcode']) && $details[$value.'_cont_postcode'] != ''){
							$fullAddress .= $details[$value.'_cont_postcode'].", ";
						}

						if($fullAddress != ""){
							$data_array[$i]['client_id'] 	= $client_id;
							$data_array[$i]['client_type'] 	= $details['type'];
							$data_array[$i]['addresstype'] 	= $value;
							$data_array[$i]['fullAddress'] 	= substr(trim($fullAddress), 0, -1);
							$i++;
						}
					}
				}



			}
		}

		return $data_array;
	}

	public static function getAddressByClientIdAndType($client_id, $type)
	{
    $address        = array();
		$session        = Session::get('admin_details');
  	$user_id        = $session['id'];
  	$groupUserId    = $session['group_users'];

		$details = StepsFieldsClient::whereIn('user_id', $groupUserId)->where('client_id',
            $client_id)->where("field_name", $type."_address")->select("field_value")->first();
		//Common::last_query();die;
    if(isset($details['field_value']) && $details['field_value'] !=''){
        $address = ClientAddress::getDetailsById( $details['field_value'] );
    }
    return $address;
	}

	public static function countClientByType($type)
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

		$count = Client::where("is_deleted", "N")->where("type", $type)->where("is_archive", "N")->where("is_relation_add", "N")->whereIn("user_id", $groupUserId)->count();
		//Common::last_query();
		return $count;
	}

	public static function getUserIdByClientId($client_id)
	{
		$details = Client::where("client_id", $client_id)->select("user_id")->first();
		$user_id = 0;
		if(!empty($details['user_id'])){
			$user_id = $details['user_id'];
		}
		return $user_id;
	}

	public static function clientLists($sendData)
	{  
    $start 				= $sendData['start'];
  	$limit 				= $sendData['limit'];
  	$sorting 			= $sendData['sorting'];
  	$search 			= $sendData['search'];
  	$client_type  = $sendData['client_type'];
  	//$service_id 	= 10;
  	//echo $staff_id;die;
  	$data =  $od 	= array();

    $sort 				= explode(' ', $sorting);
		$groupUserId 	= Client::getSessionUserIds();

		$header_sort 	= '';
		$where = " WHERE c.user_id IN ('".implode(',', $groupUserId)."') AND c.is_deleted='N' AND c.type='".$client_type."' AND c.is_archive='N' AND c.is_relation_add='N' ";

		$client_name  				= StepsFieldsClient::clientNameQuery();
		$registration_number 	= StepsFieldsClient::clientFieldQuery('registration_number');
		$vat_number 					= StepsFieldsClient::clientFieldQuery('vat_number');
		$vat_stagger 					= StepsFieldsClient::clientFieldQuery('vat_stagger');
		$tax_reference 				= StepsFieldsClient::clientFieldQuery('tax_reference');
		$business_type 				= StepsFieldsClient::businessTypeQuery();
		$year_end 						= StepsFieldsClient::yearEndQuery();
		$utrsamllbox 					= StepsFieldsClient::clientFieldQuery('utrsamllbox');
		$deadacc_count 				= StepsFieldsClient::deadCountQuery('next_acc_due');
		$deadret_count 				= StepsFieldsClient::deadCountQuery('next_ret_due');

		$other_services 			= StepsFieldsClient::clientFieldQuery('other_services');
		$dob 									= StepsFieldsClient::clientFieldQuery('dob');
		$ni_number 						= StepsFieldsClient::clientFieldQuery('ni_number');

		if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'deadacc_count'){
			$header_sort = " ORDER BY CASE 
				WHEN ( ".$deadacc_count." <=0 && ".$deadacc_count." != 'NULL') THEN 1
				WHEN ( ".$deadacc_count." >0 && ".$deadacc_count." != 'NULL') THEN 2
			 	ELSE 3 END, ABS(".$deadacc_count.") ".$sort[1];
		}else if($sort[0] == 'deadret_count'){
			$header_sort = " order by ".$deadret_count.' '.$sort[1];
		}else if($sort[0] == 'ni_number'){
			$header_sort = " order by ".$ni_number.' '.$sort[1];
		}

		if(isset($search) && $search != ''){
			$where .= " AND (";
			if($client_type == 'org'){
				$where .= $business_type." LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' OR ";
				$where .= $year_end." LIKE '%".$search."%' OR ";
				$where .= $tax_reference." LIKE '%".$search."%' OR ";
				$where .= $vat_number." LIKE '%".$search."%' OR ";
				$where .= $vat_stagger." LIKE '%".$search."%' OR ";
				$where .= $deadacc_count." LIKE '%".$search."%' OR ";
				$where .= $deadret_count." LIKE '%".$search."%' OR ";
				$where .= $utrsamllbox." LIKE '%".$search."%' OR ";
			}
			if($client_type == 'ind'){
				$where .= $dob." LIKE '%".$search."%' OR ";
				$where .= $ni_number." LIKE '%".$search."%' OR ";
				$where .= $tax_reference." LIKE '%".$search."%' OR ";
			}
			$where .= $client_name." LIKE '%".$search."%') ";
		}

		$select = "select c.client_id, c.type, show_archive,
			".$business_type." as business_type,
			".$registration_number." as registration_number,
			".$client_name." as client_name,
			".$year_end." as year_end,
			".$tax_reference." as tax_reference,
			".$vat_number." as vat_number,
			".$vat_stagger." as vat_stagger,
			".$utrsamllbox." as utrsamllbox,
			".$deadacc_count." as deadacc_count,
			".$deadret_count." as deadret_count,

			".$other_services." as other_services,
			".$dob." as dob,
			".$ni_number." as ni_number

		";

		$query = " FROM clients c ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

		//============== total count section ==============
    $total_qry 		= "select count(c.client_id) as count ".$query;
    $totalVal 		= DB::select($total_qry);
    $total 				= json_decode(json_encode($totalVal), true);

		$data['details'] 			= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];

    return $data;

	}
    
    

}
