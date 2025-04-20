<?php

class ClientController extends BaseController {
	public function __construct()
  {
      parent::__construct();
      $session = Session::get('admin_details');
      $user_id = $session['id'];
      if (empty($user_id)){
          Redirect::to('/login')->send();
      }
  }

  public function action()
	{
		$data 				= array();
		$action 			= Input::get('action');	
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId  = $session['group_users'];
		$postData 		= Input::all();

		switch ($action) {
			case 'getContactById':
				$contact_id 	= $postData['contact_id'];
				$address_type = $postData['address_type'];
				if($address_type == 'C'){
					$data['details'] = ContactAddress::getContactDetailsById( $contact_id );
				}else{
					$data['details'] = Common::clientDetailsById( $contact_id );
				}
				echo json_encode($data);
				break;

			default:
				# code...
				break;
		}

	}

	public function edit_ind_client($client_id, $type_id) 
	{
		
		$session 				= Session::get('admin_details');
		$user_id 				= $session['id'];
		$groupUserId 			= $session['group_users'];
		$data['logged_user_id'] = $user_id;
		$data['user_type'] 		= $session['user_type'];
		$data['client_id'] 		= $client_id;
		$data['heading'] 		= "";
		$data['page_name'] 		= base64_decode($type_id);

		if ($data['user_type'] != "C") {
			$data['title'] 			= "Edit Client";
			$data['previous_page'] 	= '<a href="/individual-clients">Individual Client List</a>';
		} else {
			$data['title'] 			= "Edit User";
			$data['previous_page'] 	= '<a href="/client-portal">Client Portal</a>';
		}
		if (empty($user_id)) {
			return Redirect::to('/');
		}

		$data['rel_types'] = RelationshipType::where("show_status", "individual")->orderBy("relation_type_id")->get();
		$data['marital_status'] 	= MaritalStatus::getDetails();
		$data['titles'] 			= Title::orderBy("title_id")->get();
		$data['tax_office'] 		= TaxOfficeAddress::select("parent_id", "office_id", "office_name")->get();
		$data['tax_office_by_id'] 	= TaxOfficeAddress::where("office_id", "=", 1)->first();
		$data['steps'] 				= Step::where("status", "=", "old")->orderBy("step_id")->get();
		$data['substep'] 			= Step::whereIn("user_id", $groupUserId)->where("client_type", "ind")->where("parent_id", 1)->orderBy("step_id")->get();
		$data['responsible_staff'] 	= App::make('HomeController')->get_responsible_staff();
		$data['countries'] 			= Country::orderBy('country_name')->get();
		$data['nationalities'] 		= Nationality::get();
		$data['field_types'] 		= FieldType::get();
		$data['ethnic_origin'] 		= EthnicOrigin::getDetails();
		$data['staff_details'] 		= User::getAllStaffDetails();
		//$data['cont_address'] = App::make('HomeController')->get_contact_address();
		
		//$data['allIndClients'] 	 	= App::make("HomeController")->get_all_ind_clients();
		$data['allClients'] 	= App::make("HomeController")->get_all_clients();
		$data['old_services'] 	= Service::where("status", "old")->where("client_type",
			"ind")->orderBy("service_name")->get();
		$data['new_services'] 	= Service::where("status", "new")->where("client_type", "ind")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();

		$steps_fields_users 	= StepsFieldsAddedUser::whereIn("user_id", $groupUserId)->
			where("substep_id", '0')->where("client_type", "ind")->get();
		foreach ($steps_fields_users as $key => $steps_fields_row) {
			$steps_fields_users[$key]->select_option = explode(",", $steps_fields_row->select_option);
		}
		$data['steps_fields_users'] = $steps_fields_users;

		//###########User added section and sub section start##########//
		$steps = array();
		$subsections = Step::whereIn("user_id", $groupUserId)->where("status", "=","new")->get();
		//echo $this->last_query();die;
		foreach ($subsections as $key => $val) {
			if (isset($val->status) && $val->status == "new") {
				$steps[$key]['step_id'] 		= $val->step_id;
				$steps[$key]['parent_id'] 	= $val->parent_id;
				$steps[$key]['short_code'] 	= $val->short_code;
				$steps[$key]['title'] 			= $val->title;
				$steps[$key]['status'] 			= $val->status;
			}

		}
		$data['subsections'] 	= App::make('HomeController')->buildtree($steps, "ind");
		//###########User added section and sub section start##########//

		$data['relationship'] 	= Common::get_relationship_client($client_id);
		//echo $this->last_query();die;
		$data['acting'] = Common::get_acting_client($client_id);
		$data['acting_dropdown'] = $this->get_acting_dropdown($data['relationship'], $data['acting']);

		$client_details = StepsFieldsClient::where('client_id', $client_id)->select("field_id", "field_name", "field_value")->get();

		$client_data['client_id'] = $client_id;

		if (isset($client_details) && count($client_details) > 0) {
			foreach ($client_details as $client_row) {
				if (isset($client_row->field_name) && $client_row->field_name == "client_name") {
					$client_data['initial_badge'] = $this->get_initial_badge($client_row->field_value);
				}
				$client_data[$client_row['field_name']] = $client_row->field_value;
			}
		}

		$data['client_details'] = $client_data;
		//echo '<pre>';print_r($data['client_details']);die();
		/* ############# client exists / not in the user table section start ############### */
		$users = User::where("client_id", $client_id)->select("user_id", "user_type")->first();
		$data['user_id'] = "";
		$data['relation_list'] = array();
		if (isset($users) && count($users) > 0) {
			$data['user_id'] = $users['user_id'];

			if (isset($users['user_type']) && $users['user_type'] == "C") {
				$data['relation_list'] = App::make("InvitedclientController")->
					all_relation_client_details($users['user_id']);
			}

			$data['photo'] = ClientFile::where('client_id',$data['user_id'])->select('profile_photo')->first();
      }
		// ############# client exists / not in the user table section end ############### //

		// ============= Get files start ========== //
		$data['files'] = ClientFile::where("client_id", $client_id)->first();
		//print_r($data['files']);die;
		// ============= Get files end ========== //

		//$data['services_id'] = Client::getServicesIdByClient($client_id);
		$data['services_id'] = Client::allServicesIdByClientId($client_id, 'c_ind');


		$data['allServices'] = $this->get_all_services('ind', $client_id);
		//############# Get client data end ################//
		$country 		= trim('Ghana');
		$country_id 	= Country::getCountryIdByName($country);
			//echo $country_id ;die;
		if($data['page_name'] == 'ind_client'){
			$data['cont_address'] = ClientAddress::getAllDetails();
		}else{
			$data['cont_address'] = ClientAddress::getAddressForClientPortal($client_id, 'ind');
		}
		//echo $data['page_name'];die;

		$data['headings'] = AllocationHeading::getHeadingByCurrentUserId();

		$data['acc_details']    = CrmAccDetail::getDetailsByClientId($client_id);
		$data['renewalServices']= ClientService::getServicesByClient($client_id);


		return View::make('home.individual.edit_individual_client', $data);

	}

	public function edit_org_client($client_id, $type_id) 
	{
		ini_set('memory_limit', '-1');
		$data['heading'] = "";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];
		$data['page_name'] = base64_decode($type_id);
		$data['encode_page_name'] = $type_id;
		$data['type'] = 'other';
		//print_r($data['page_name']);die();
		if ($data['user_type'] != "C") {
			$data['title'] = "Edit Client";
			$data['previous_page'] = '<a href="/organisation-clients">Organisation Client List</a>';
		} else {
			$data['title'] = "Edit Client";
			$data['previous_page'] = '<a href="/client-portal">Client Portal</a>';
		}

		if (empty($user_id)) {
			return Redirect::to('/'); 
		}

		$data['old_org_types'] = OrganisationType::where("client_type", "all")->orderBy("name")->get();
		$data['new_org_types'] = OrganisationType::where("client_type", "org")->
			whereIn("user_id", $groupUserId)->where("status", "new")->orderBy("name")->get();

		$data['rel_types'] 		= RelationshipType::orderBy("relation_type_id")->get();
		$data['titles'] 			= Title::orderBy("title_id")->get();
		$data['steps'] 				= Step::where("status", "old")->orderBy("step_id")->get();
		$data['substep'] 			= Step::where("client_type", "org")->where("parent_id", 1)->whereIn("user_id", $groupUserId)->orderBy("step_id")->get();
		//$data['staff_details']= User::whereIn("user_id", $groupUserId)->where("client_id", 0)->select("user_id", "fname", "lname")->get();
		$data['tax_office'] 	= TaxOfficeAddress::select("parent_id","office_id","office_name")->get();

		$first_serv = DB::table('services')->where("status", "old")->where("user_id", 0);
		$data['services'] = Service::where("status", "new")->whereIn("user_id", $groupUserId)->
			union($first_serv)->orderBy("service_id")->get();

		$data['old_services'] = Service::where("status", "old")->where("client_type", "org")->orderBy("service_name")->get();
		$data['new_services'] = Service::where("status", "new")->where("client_type", "org")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();

		$data['countries'] 		= Country::orderBy('country_name')->get();
		$data['field_types'] 	= FieldType::get();

		$data['old_vat_schemes'] = VatScheme::where("status", "old")->orderBy("vat_scheme_name")->get();
		$data['new_vat_schemes'] = VatScheme::where("status", "new")->whereIn("user_id",
			$groupUserId)->orderBy("vat_scheme_name")->get();
		//echo $this->last_query();die;
		$data['allClients'] 	= App::make("HomeController")->get_all_clients();

		//print_r($data['cont_address'] );die();

		$data['reg_address'] 	= RegisteredAddress::orderBy("reg_id")->get();

		$steps_fields_users 	= StepsFieldsAddedUser::whereIn("user_id", $groupUserId)->
			where("substep_id", '0')->where("client_type", "org")->get();
		foreach ($steps_fields_users as $key => $steps_fields_row) {
			$steps_fields_users[$key]->select_option = explode(",", $steps_fields_row->select_option);
		}
		$data['steps_fields_users'] = $steps_fields_users;

		//###########User added section and sub section start##########//
		$steps = array();
		$subsections = Step::whereIn("user_id", $groupUserId)->where("status", "new")->get();
		foreach ($subsections as $key => $val) {
			if (isset($val->status) && $val->status == "new") {
				$steps[$key]['step_id'] = $val->step_id;
				$steps[$key]['parent_id'] = $val->parent_id;
				$steps[$key]['short_code'] = $val->short_code;
				$steps[$key]['title'] = $val->title;
				$steps[$key]['status'] = $val->status;
			}

		}
		$data['subsections'] 			= App::make("HomeController")->buildtree($steps, "org");
		$data['relationship'] 		= Common::get_relationship_client($client_id);
		$data['acting'] 					= Common::get_acting_client($client_id);
		$data['acting_dropdown'] 	= $this->get_acting_dropdown($data['relationship'], $data['acting']);
		//print_r($data['relationship']);die;

		$client_details = StepsFieldsClient::where('client_id', $client_id)->
			select("field_id", "field_name", "field_value")->get();

		$client_data['client_id'] = $ContactCompany['client_id'] = $client_id;

		if (isset($client_details) && count($client_details) > 0) {
			foreach ($client_details as $client_row) {
				if (isset($client_row->field_name) && $client_row->field_name == "business_name") {
					$client_data['initial_badge'] = $this->get_initial_badge($client_row->field_value);
					$ContactCompany['client_name'] = $client_row->field_value;
				}
				$client_data[$client_row['field_name']] = $client_row->field_value;
			}
		}

		$data['months'] = array( 
			"01"=>"JAN", "02"=>"FEB", "03"=>"MAR",  "04"=>"APR", "05"=>"MAY", "06"=>"JUN", 
			"07"=>"JUL", "08"=>"AUG", "09"=>"SEPT", "10"=>"OCT", "11"=>"NOV", "12"=>"DEC"
		);

		$data['client_details'] = $client_data;

		//$data['services_table'] 	=   Common::get_services_client($client_id);
		$data['services_id'] = Client::allServicesIdByClientId($client_id, 'c_org');

		//Common::last_query();die;
		//print_r($data['services_id']);die;

		$data['org_notes'] = OrgNotes::where('client_id', $client_id)->select("orgnotes_id",
			"user_id", "client_id", "title", "textmessage", "created")->orderBy('created',
			'DESC')->get();

		$data['orgdtails_notes'] = OrgNotes::where('client_id', $client_id)->
			select("orgnotes_id", "user_id", "client_id", "title", "textmessage", "created")->
			orderBy('created', 'DESC')->first();

		$user = $data['orgdtails_notes']['user_id'];
		// die();

		$data['user'] = User::where("user_id", $user)->select("fname", "lname", "user_id")->first();
		$data['crm_renewals'] = CrmRenewal::getCrmRenewalByClientId($client_id);

		// echo '<pre>';print_r($data['orgdtails_notes']);die();
		//echo $this->last_query();die;
    $taxOfficeaddress = TaxOfficeAddress::where("parent_id","0")->select("office_id","office_name")->get();
         
		$income=array();
		$j=0;
		foreach($taxOfficeaddress as $key=>$valeuname){
		  $income[$j]['office_type']="I";
		  $income[$j]['office_id']=$valeuname['office_id'];
		  $income[$j]['office_name']=$valeuname['office_name'];
		  
		 $j++;
		 }
		// echo '<pre>';print_r($income);
           
    $corporation=array();
    $corporationtaxOffice = CorporationTaxOffice::select("corp_tax_id", "office_name")->get();
    
    foreach($corporationtaxOffice as $key=>$valeuname){
      $corporation[$j]['office_type']="C";
      $corporation[$j]['office_id']=$valeuname['corp_tax_id'];
      $corporation[$j]['office_name']=$valeuname['office_name'];
        
      $j++;
		}
       //echo '<pre>';print_r($corporation);
        
    $finalarry=array_merge($income,$corporation);
    
    $data['taxallofficeaddress']=$finalarry;


    $data['allServices'] = $this->get_all_services('org', $client_id);

    $data['fullAddress'] = Client::getAddressByAddressType();


    if($data['page_name'] == 'client_portal'){
			$data['cont_address'] = ClientAddress::getAddressForClientPortal($client_id, 'org');
		}else{
			$data['cont_address'] = ClientAddress::getAllAddressAndId();
			$data['contacts'] 		= ContactAddress::getContactNameAndIdByClientId($client_id);
		}

		$data['headings'] = AllocationHeading::getHeadingByCurrentUserId();

		$data['ContactCompany'][0] = $ContactCompany;

		$data['acc_details']    = CrmAccDetail::getDetailsByClientId($client_id);
		$data['renewalServices']= ClientService::getServicesByClient($client_id);
		$data['business'] 			= BusinessDescription::getAllDetails();

		/* get primary contact */
		//$person_type = getFieldValueByClientId($client_id, 'person_type');

		//echo '<pre>';print_r($data['contacts']);die;

		return View::make('home.organisation.edit_organisation_client', $data);
	}

	public function get_all_services($type, $client_id) 
	{
		$data = array();
		$services = Service::getAllServiceByType($type);
		if(isset($services) && count($services) >0){
			foreach ($services as $key => $value) {
				$data[$key] = $services[$key];
				$data[$key]['allocated_staffs'] = ClientListAllocation::getAllocatedStaff($client_id, $value['service_id']);
			}
		}
		return $data;
	}

	public function get_initial_badge($full_name) {
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

	public function get_country_code() {
		$country_id = Input::get("country_id");
		$country_code = Country::where("country_id", $country_id)->select("phone_code")->
			first();
		echo $country_code['phone_code'];
	}

	public function delete_user_field() {
		$field_id = Input::get("field_id");
		$affectedRows = StepsFieldsAddedUser::where('field_id', '=', $field_id)->delete();
		echo $affectedRows;
	}

	public function delete_section() {
		$step_id = Input::get("step_id");
		$affected = Step::where('step_id', '=', $step_id)->delete();
		if ($affected) {
			$affectedRows = StepsFieldsAddedUser::where('step_id', '=', $step_id)->delete();
			echo $affectedRows;
		}

	}

	public function delete_individual_client() {
    $session = Session::get('admin_details');
		$user_id = $session['id'];
        
		$client_delete_id   = Input::get("client_delete_id");
    $deleted_reason     = Input::get("deleted_type");
		//print_r($client_delete_id);die;
		foreach ($client_delete_id as $client_id) {
			$del_data['is_deleted']         = "Y";
      $del_data['deleted_reason']     = $deleted_reason;
      $del_data['deleted_date']       = date('Y-m-d H:i:s');
			Client::where('client_id', $client_id)->update($del_data);
            
      $del_client['user_id']          = $user_id;
      $del_client['client_id']        = $client_id;
      $del_client['created']          = date('Y-m-d H:i:s');
      DeletedClient::insert($del_client);

			/*Client::where('client_id', '=', $client_id)->delete();
			StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '!=', 'client_name')->where('field_name', '!=', 'title')->where('field_name', '!=', 'fname')->where('field_name', '!=', 'lname')->where('field_name', '!=', 'business_name')->delete();*/
		}
	}

	public function search_tax_address() {
		$field_type = Input::get("field_type");
		$data = array();
		if (Request::ajax()) {
			if ($field_type == "I") {
				$data = TaxOfficeAddress::where("parent_id", "==", "0")->select("office_id","office_name")->get();
			} elseif ($field_type == "C") {
				$data = CorporationTaxOffice::select("corp_tax_id as office_id", "office_name")->get();
			}
		}
		echo json_encode($data);
		exit;
	}

	public function add_business_type() {
		$session_data = Session::get('admin_details');

		$data['name'] = Input::get("org_name");
		$data['client_type'] = Input::get("client_type");
		$data['user_id'] = $session_data['id'];
		$data['status'] = "new";
		$insert_id = OrganisationType::insertGetId($data);
		echo $insert_id;
		exit();
		//return Redirect::to('/organisation/add-client');
	}

	public function delete_org_name() {
		$field_id = Input::get("field_id");
		if (Request::ajax()) {
			$data = OrganisationType::where("organisation_id", "=", $field_id)->delete();
			echo $data;
		}
	}

	public function add_vat_scheme() {
		$session_data = Session::get('admin_details');
		
		$data['service_name'] 	= Input::get("vat_scheme_name");
		$data['user_id'] 		= $session_data['id'];
		$data['status'] 		= "new";
		$data['added_from'] 	= Input::get("added_from");
		//echo $data['added_from'];die;
		$insert_id = Service::insertGetId($data);
		echo $insert_id;
		exit();

		//return Redirect::to('/organisation/add-client');
	}

	public function delete_vat_scheme() {
		$field_id = Input::get("field_id");
		if (Request::ajax()) {
			$data = Service::where("service_id", "=", $field_id)->delete();
			echo $data;
		}
	}

	public function get_oldcont_address() {
		//die('ddd');
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

		$groupUserId = $admin_s['group_users'];

		$client_id = Input::get("client_id");

		$client_data = array();
		if (Request::ajax()) {
			$client_ids = Client::where('is_deleted', '=', "N")->whereIn("user_id", $groupUserId)->
				where('type', '=', "ind")->where('client_id', '=', $client_id)->where('user_id',
				'=', $user_id)->select("client_id")->get();
			//echo $this->last_query();die;
			$i = 0;
			if (isset($client_ids) && count($client_ids) > 0) {
				foreach ($client_ids as $client_id) {
					$client_details = StepsFieldsClient::where('client_id', '=', $client_id->
							client_id)->select("field_id", "field_name", "field_value")->get();
					$client_data[$i]['client_id'] = $client_id->client_id;

					if (isset($client_details) && count($client_details) > 0) {
						foreach ($client_details as $client_row) {
							$client_data[$i][$client_row['field_name']] = $client_row['field_value'];
						}

						$i++;
					}
				}
			}
		}
		echo json_encode($client_data);
		exit;
	}

	public function get_orgoldcont_address() {
		$details 	= array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

		$address_id 	= Input::get("address_id");
		$type 	= Input::get("address_type");

		$address = ClientAddress::getDetailsById($address_id);
		if(isset($address) && count($address) >0){
			$details[$type.'_cont_addr_line1']  = $address['address1'];
			$details[$type.'_cont_addr_line2']  = $address['address2'];
			$details[$type.'_cont_city'] 		= $address['city'];
			$details[$type.'_cont_county'] 	    = $address['county'];
			$details[$type.'_cont_postcode'] 	= $address['postcode'];
			$details[$type.'_cont_country'] 	= $address['country'];
		}

		echo json_encode($details);
	}

	/*public function get_orgoldcont_address() {
		//die('orgort');
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

		$groupUserId = $admin_s['group_users'];

		$client_id = Input::get("client_id");

		$client_data = array();
		if (Request::ajax()) {
			$client_ids = Client::where('is_deleted', '=', "N")->whereIn("user_id", $groupUserId)->
				where('type', '=', "org")->where('client_id', '=', $client_id)->where('user_id',
				'=', $user_id)->select("client_id")->get();
			//echo $this->last_query();die;
			$i = 0;
			if (isset($client_ids) && count($client_ids) > 0) {
				foreach ($client_ids as $client_id) {
					$client_details = StepsFieldsClient::where('client_id', '=', $client_id->
							client_id)->select("field_id", "field_name", "field_value")->get();
					$client_data[$i]['client_id'] = $client_id->client_id;

					if (isset($client_details) && count($client_details) > 0) {
						foreach ($client_details as $client_row) {
							$client_data[$i][$client_row['field_name']] = $client_row['field_value'];
						}

						$i++;
					}
				}
			}
		}
		echo json_encode($client_data);
		exit;
	}*/

	public function add_services() {
		$data = array();
		$session_data = Session::get('admin_details');

		$data['service_name'] 	= Input::get("service_name");
		$data['client_type'] 	= Input::get("client_type");
		$data['client_id'] 		= Input::get("client_id");
		$data['user_id'] 		= $session_data['id'];
		$data['status'] 		= "new";
		$data['last_id'] = Service::insertGetId($data);
		$data['staff_details'] = App::make('HomeController')->get_responsible_staff();

		$clntsrvs['client_id'] 	= $data['client_id'];
		$clntsrvs['service_id'] = $data['last_id'];
		ClientService::insert($clntsrvs);

		echo json_encode($data);
		//echo $insert_id;
		exit();
		//return Redirect::to('/organisation/add-client');
	}

	public function delete_services() {
		$field_id = Input::get("field_id");
		if (Request::ajax()) {
			$data = Service::where("service_id", "=", $field_id)->delete();
			echo $data;
		}
	}

	public function delete_client_services() {
		$client_service_id = Input::get("client_service_id");
		if (Request::ajax()) {
			$data = ClientService::where("client_service_id", "=", $client_service_id)->
				delete();
			echo $data;
		}
	}

	public function insert_section() {
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];

		$data['title'] = Input::get("subsec_name");
		$data['parent_id'] = Input::get("parent_id");
		$data['user_id'] = $user_id;
		$data['short_code'] = strtolower(Input::get("subsec_name"));
		$data['status'] = "new";
		$data['client_type'] = Input::get("client_type");
		if (Request::ajax()) {
			Step::insert($data);
			$steps = Step::whereIn("user_id", $groupUserId)->where("client_type", $data['client_type'])->
				where("parent_id", $data['parent_id'])->where("status", "new")->get();
			echo json_encode($steps);
		}
	}

	public function get_subsection() {
		$admin_s = Session::get('admin_details');
		$groupUserId = $admin_s['group_users'];

		$step_id = Input::get("step_id");
		$client_type = Input::get("client_type");

		if (Request::ajax()) {
			$steps = Step::whereIn("user_id", $groupUserId)->where("client_type", "=", $client_type)->
				where("parent_id", "=", $step_id)->get();
			//echo $this->last_query();die;
			echo json_encode($steps);
		}
	}
 
	public function archive_client() {
		Session::put('show_archive', 'Y');

		$clients_id 	= Input::get("client_id");
		$status 		= Input::get("status");

		//print_r($clients_id);die;
		foreach ($clients_id as $client_id) {
			if ($status == "Archive") {
				$data['is_archive'] 	= 'Y';
				$data['show_archive'] 	= 'Y';
				$data['archive_reason'] = Input::get("archive_reason");
			} else {
				$data['is_archive'] 	= 'N';
				$data['show_archive'] 	= 'N';
				$data['archive_reason'] =  0;
			}
			Client::where('client_id', $client_id)->update($data);
			//echo $this->last_query();die;
		}
	}

	public function show_archive_client() {
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		$is_archive = Input::get("is_archive");
		if ($is_archive == "Y") {
			Session::put('show_archive', 'Y');
		} else {
			Session::put('show_archive', 'N');
		}

		$affected = Client::whereIn("user_id", $groupUserId)->where("show_archive", "Y")->update(array("is_archive" => $is_archive));
		//echo $this->last_query();die;
	}

	public function edit_relation_type() {
		$data['relation_type'] = Input::get("relation_type");
		$client_type = Input::get("client_type");
		if ($client_type == "org") {
			$data['relationship'] = RelationshipType::where("show_status", "individual")->
				orderBy("relation_type_id")->get();
		} else {
			$data['relationship'] = RelationshipType::orderBy("relation_type_id")->get();
		}

		echo View::make("home.relationship_types", $data);

	}

	public function delete_relationship() 
	{
		$resp = 0;
		$delete_index = Input::get("delete_index");
		$client_type 	= Input::get("client_type");
		$contact_type = Input::get("contact_type");
		if($contact_type == 'R'){
			$resp = ClientRelationship::where("client_relationship_id", $delete_index)->delete();
		}
		if($contact_type == 'C'){
			$resp = ContactAddress::where("contact_id", $delete_index)->delete();
		}
		echo $resp;
	}

	public function save_database_relationship() {
		$data = array();
		$type = "";
		$edit_id = Input::get("edit_id");
		$client_type = Input::get("client_type");
		$client_id = Input::get("client_id");
		$name = Input::get("name");
		$acting = Input::get("acting");
		$rel_type_id = Input::get("rel_type_id");
		$date = date("Y-m-d", strtotime(Input::get("app_date")));

		if (Input::get("rel_client_id") != "") {
			$data['appointment_with'] = Input::get("rel_client_id");
		}
		//$data['appointment_date'] = $date[2]."-".$date[1]."-".$date[0];
		$data['appointment_date'] = $date;
		$data['relationship_type_id'] = Input::get("rel_type_id");
		$data['acting'] = $acting;

		$resp = ClientRelationship::where("client_relationship_id", "=", $edit_id)->
			update($data);
		//echo $this->last_query();die;
		//if($resp){
		$relationship = RelationshipType::where("relation_type_id", "=", $data['relationship_type_id'])->
			first();
		$type = $relationship['relation_type'];

		//################# Change Officers Type Start #################//
		if ($client_type == "change") {
			if (strpos($type, 'Corporate') !== false) {
				$cl_data["type"] = "org";
				$getData = StepsFieldsClient::where("client_id", "=", $client_id)->where("field_name",
					"=", "client_name")->first();
				$clin_data['user_id'] = $getData['user_id'];
				$clin_data['client_id'] = $getData['client_id'];
				$clin_data['step_id'] = $getData['step_id'];
				$clin_data['field_name'] = "business_name";
				$clin_data['field_value'] = $getData['field_value'];

				$checkData = StepsFieldsClient::where("client_id", "=", $client_id)->where("field_name",
					"=", "business_name")->first();
				if (!isset($checkData)) {
					StepsFieldsClient::insert($clin_data);
				} else {
					StepsFieldsClient::where("client_id", "=", $client_id)->where("field_name", "=",
						"business_name")->update(array("field_value" => $name));
				}

			} else {
				$cl_data["type"] = "ind";
			}
		} else {
			$cl_data["type"] = "chd";
		}
		Client::where("client_id", "=", $client_id)->update($cl_data);
		//echo $this->last_query();die;
		//################# Change Officers Type End #################//

		//}
		//echo $this->last_query();die;
		echo $type;
	}

	public function delete_editservices() {
		//die('asfafa');
		//echo $client_id;
		$delete_id = Input::get("delete_id");
		$client_id = Input::get("client_id");

		$row = ClientService::where("client_service_id", "=", $delete_id)->delete();

		$str = '<table width="100%" class="table table-bordered table-hover dataTable" id="myServTable">
                  <input type="hidden" id="serv_hidd_array" name="serv_hidd_array" value="">
                    <tr>
                      <td align="center"><strong>Service</strong></td>
                      <td align="center"><strong>Staff</strong></td>
                      <td align="center"><strong>Action</strong></td>
                    </tr>';
		$arr = array();
		$arr['service'] = DB::table('client_services')->where("client_id", "=", $client_id)->
			get();

		foreach ($arr['service'] as $key => $service_row) {

			$arr['service'][$key]->servicedetails = DB::table('services')->where("service_id",
				"=", $service_row->service_id)->first();
			$arr['service'][$key]->staffcedetails = DB::table('users')->where("user_id", "=",
				$service_row->staff_id)->first();
		}
		$data['servicessss'] = $arr['service'];
		$arr = array();
		$arr1 = array();
		$i = 0;
		if (!empty($data['servicessss'])) {
			foreach ($data['servicessss'] as $key => $val) {

				$arr[$key] = $val->servicedetails;
				$arr1[$key] = $val->staffcedetails;
				$str .= '<tr id="added_service_tr' . $key . '">
            <td align="center">' . $arr[$key]->service_name . '</td>
            <td align="center">' . $arr1[$key]->fname . ' ' . $arr1[$key]->
					lname . '</td>
            <td align="center"><a href="javascript:void(0)" class="edit_service" data-edit_index="' .
				$key . '" id="' . $key .
				'"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" class="delete_client_service"  data-delete_index="' .
				$key . '" id="' . $val->client_service_id . '*' . $val->client_id .
				'"><i class="fa fa-trash-o fa-fw"></i><input type="hidden" value="' . $arr[$key]->
					service_id . '" id="stafftxt_id' . $key .
				'" name="stafftxt_id[]"><input type="hidden" value="' . $arr1[$key]->user_id .
				'" id="servicetxt_id' . $key . '" name="servicetxt_id[]"></td>
            </tr>';
				$i++;
			}
		}
		$str .= '</table>';
		//$str1 = count($data['servicessss']);
		echo $str;

	}

	public function save_acting_relationship() {
		$client_type = Input::get("client_type");
		$client_id = Input::get("client_id");
		$acting = Input::get("acting");
		$type = Input::get("rel_type");
		$edit_id = Input::get("edit_id");

		$data['acting'] = $acting;
		ClientRelationship::where("client_relationship_id", "=", $edit_id)->update($data);
		//################# Change Officers Type Start #################//
		if ($client_type == "change") {
			if (strpos($type, 'Corporate') !== false) {
				$cl_data["type"] = "org";
				$getData = StepsFieldsClient::where("client_id", "=", $client_id)->where("field_name",
					"=", "client_name")->first();
				$clin_data['user_id'] = $getData['user_id'];
				$clin_data['client_id'] = $getData['client_id'];
				$clin_data['step_id'] = $getData['step_id'];
				$clin_data['field_name'] = "business_name";
				$clin_data['field_value'] = $getData['field_value'];

				$checkData = StepsFieldsClient::where("client_id", "=", $client_id)->where("field_name",
					"=", "business_name")->first();
				if (!isset($checkData)) {
					StepsFieldsClient::insert($clin_data);
				}

			} else {
				$cl_data["type"] = "ind";
			}
		} else {
			$cl_data["type"] = "chd";
		}
		$success = Client::where("client_id", "=", $client_id)->update($cl_data);
		//echo $this->last_query();die;
		//################# Change Officers Type End #################//

		echo $success;
	}

	

	public function save_activity_notes() {
		$office_address = array();
		$office_id = Input::get("office_id");
		if (Request::ajax()) {
			$office_address = CorporationTaxOffice::where("corp_tax_id", "=", $office_id)->
				first();
			//echo $this->last_query();die;
		}

		echo json_encode($office_address);
		exit();
	}

	public function acting_relationship() {
		$return_data = array();
		$client_details = array();
		$acting_client_id = Input::get("acting_client_id");
		$client_details = Common::clientDetailsById($acting_client_id);

		if(isset($client_details['business_name']) && $client_details['business_name']!=
			"") {
			$name = $client_details['business_name'];
		} else {
			$name = $client_details['client_name'];
		}

		$client_data = Client::where("client_id", $acting_client_id)->first();
		//print_r($client_data['chd_type']);die;
		if (isset($client_data) && count($client_data) > 0) {
			if ($client_data['type'] == "ind") {
				$link = "/client/edit-ind-client/" . $acting_client_id;
			} else
			if ($client_data['type'] == "org") {
				$link = "/client/edit-org-client/" . $acting_client_id;
			} else
			if ($client_data['type'] == "chd") {
				if ($client_data['chd_type'] == "ind") {
					$link = "/client/edit-ind-client/" . $acting_client_id;
				} else
				if ($client_data['chd_type'] == "org") {
					$link = "/client/edit-org-client/" . $acting_client_id;
				}
			} else {
				$link = "";
			}

		}

		$return_data['name'] = $name;
		$return_data['link'] = $link;
		echo json_encode($return_data);
		exit();
	}

	public function add_to_client() {
		$session = Session::get('admin_details');
		$user_id = $session['id'];

		$type = Input::get("type");
		$relation_type = Input::get("relation_type");
		$relation_client_id = Input::get("client_id");

		$date_add['type'] = $type;
		$date_add['user_id'] = $user_id;
		$date_add['is_relation_add'] = "Y";
		$date_add['type'] = "non";

		$client_id = Client::insertGetId($date_add);

		$step_id = 1;
		if (isset($type) && $type == 'ind') {
			$title = Input::get("title");
			$fname = Input::get("fname");
			$mname = Input::get("mname");
			$lname = Input::get("lname");

			$client_name = "";
			if (isset($title) && $title != "") {
				$client_name .= $title . " ";
				$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, $step_id,
					'title', $title);
			}
			if (isset($fname) && $fname != "") {
				$client_name .= $fname . " ";
				$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, $step_id,
					'fname', $fname);
			}
			if (isset($mname) && $mname != "") {
				$client_name .= $mname . " ";
				$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, $step_id,
					'mname', $mname);
			}
			if (isset($lname) && $lname != "") {
				$client_name .= $lname;
				$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, $step_id,
					'lname', $lname);
			}
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, $step_id,
				'client_name', trim($client_name));
		}

		if (isset($type) && $type == 'org') {
			$name = Input::get("name");
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, $step_id,
				'business_name', $name);
		}

		// ############# RELATIONSHIP SECTION START ############## //
		$rel_client = ClientRelationship::where("client_id", $relation_client_id)->
			where("appointment_with", $client_id)->first();
		if (isset($rel_client) && count($rel_client) > 0) {
			$rel_data['relationship_type_id'] = $relation_type;
			ClientRelationship::where("client_id", $relation_client_id)->where("appointment_with", $client_id)->update($rel_data);
		} else {
			$rel_data['client_id'] = $relation_client_id;
			$rel_data['appointment_with'] = $client_id;
			$rel_data['relationship_type_id'] = $relation_type;
			ClientRelationship::insert($rel_data);
		}
		// ############# RELATIONSHIP SECTION END ############## //

		$query = StepsFieldsClient::insert($arrData);
		if ($query) {
			$ret_val = $client_id;
		} else {
			$ret_val = 0;
		}
		echo $ret_val;
		exit;

	}

	public function delete_acting() {
		$delete_index = Input::get("delete_index");
		$resp = ClientActing::where("acting_id", "=", $delete_index)->delete();
		echo $resp;
	}

	public function save_database_acting() {
		$acting_client_id = Input::get("acting_client_id");
		$acting_id = Input::get("acting_id");

		$data['acting_client_id'] = $acting_client_id;
		ClientActing::where("acting_id", "=", $acting_id)->update($data);

		$client_details = Common::clientDetailsById($acting_client_id);

		if (isset($client_details['business_name']) && $client_details['business_name'] !=
			"") {
			$name = $client_details['business_name'];
		} else {
			$name = $client_details['client_name'];
		}

		$return_data['name'] = $name;
		echo json_encode($return_data);
		exit();

	}

	public function get_name_and_type() {
		$data['allClients'] = App::make("HomeController")->get_all_clients();
		$data['rel_types'] = RelationshipType::orderBy("relation_type_id")->get();

		echo json_encode($data);
		exit();
	}

	public function delete_addtolist_client() {
		$client_id = Input::get("client_id");
		$client_details = Client::where("is_relation_add", "=", "Y")->where("client_id",
			"=", $client_id)->first();
		if (isset($client_details) && count($client_details) > 0) {
			Client::where("client_id", "=", $client_id)->delete();
		}
		echo 1;
	}

	public function get_acting_dropdown($relationship, $acting) {
		$acting_dropdown = array();
		if (isset($relationship) && count($relationship)) {
			foreach ($relationship as $key => $value) {
				$getValue = $this->is_in_array($acting, 'acting_client_id', $value['client_id']);
				if ($getValue == "yes") {
					$acting_dropdown[] = $value['client_id'];
				}
			}
		}
		return $acting_dropdown;
	}

	public function is_in_array($array, $key, $key_value) {
		$within_array = 'no';
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				$within_array = $this->is_in_array($v, $key, $key_value);
				if ($within_array == 'yes') {
					break;
				}
			} else {
				if ($v == $key_value && $k == $key) {
					$within_array = 'yes';
					break;
				}
			}
		}
		return $within_array;
	}

	public function save_officers_into_relation() { 
		$data = array();
		$company_number = Input::get("company_number");
		$key = Input::get("key");
		$relation_client_id = Input::get("client_id");

		// ################# INSERT CLIENT START ################### //
		$officers = Common::getOfficerDetails($company_number); //print_r($officers->items[$key]);die;
		if (isset($officers->items[$key]) && count($officers->items[$key]) > 0) {
			$officer = $officers->items[$key];

			if (strpos($officer->officer_role, 'corporate') !== false) {
				$name = str_replace(" ", "+", $officer->name);
				$details = Common::getSearchCompany($name);
				$company_number = $details->items[0]->company_number . "=function";

				$client_id = App::make('ChdataController')->import_company_details($company_number);
				$data['link'] = "/client/edit-org-client/" . $client_id;
				$data['goto_link'] = base64_encode("org_client");
			} else {
				$client_id = App::make('ChdataController')->checkClientExists($officer->name);
				if ($client_id != "") {
					App::make('ChdataController')->update_individual_client($officer, $client_id);
				} else {
					$client_id = App::make('ChdataController')->insert_individual_client($officer);
				}

				$data['link'] = "/client/edit-ind-client/" . $client_id;
				$data['goto_link'] = base64_encode("ind_client");
			}
			$data['client_id'] = $client_id;
			Client::where("client_id", $client_id)->update(array("is_relation_add"=>"Y", 'type'=>'non'));
			//$data['base_url'] = url();

			$relation = RelationshipType::where("relation_type", ucwords($officer->
					officer_role))->select("relation_type_id")->first();
			//echo $this->last_query();die;
			if (isset($relation['relation_type_id']) && $relation['relation_type_id'] != "") {
				$data['relation_type_id'] = $relation['relation_type_id'];
			} else {
				$data['relation_type_id'] = "";
			}

		}
		// ################# INSERT CLIENT END ################### //

		// ############# RELATIONSHIP SECTION START ############## //
		$relation = RelationshipType::where("relation_type", ucwords($officer->officer_role))->select("relation_type_id")->first();
		//echo $this->last_query();die;
		if (isset($relation['relation_type_id']) && $relation['relation_type_id'] != "") {
			$relation_type = $relation['relation_type_id'];
		} else {
			$relation_type = 0;
		}

		$rel_client = ClientRelationship::where("client_id", $relation_client_id)->
			where("appointment_with", $client_id)->first();
		if (isset($rel_client) && count($rel_client) > 0) {
			$rel_data['relationship_type_id'] = $relation_type;
			ClientRelationship::where("client_id", $relation_client_id)->where("appointment_with",
				$client_id)->update($rel_data);
			$relation_id = $rel_client['client_relationship_id'];
		} else {
			$rel_data['client_id'] = $relation_client_id;
			$rel_data['appointment_with'] = $client_id;
			$rel_data['relationship_type_id'] = $relation_type;
			$relation_id = ClientRelationship::insert($rel_data);
		}
		// ############# RELATIONSHIP SECTION END ############## //

		$data['appointment_name'] 	= $officer->name;
		$data['rel_client_id'] 			= $client_id;
		$data['relation_id'] 				= $relation_id;
		$data['relationship_type'] 	= ucwords($officer->officer_role);
		$data['client_type'] 				= Client::getClientTypeByClientId($client_id);

		echo json_encode($data);
		exit();
	}

	public function get_officers_client() {
		$data = array();
		$company_number = Input::get("company_number");
		$officers = Common::getOfficerDetails($company_number); //print_r($officers);die;
		if (isset($officers->items) && count($officers->items) > 0) {
			foreach ($officers->items as $key => $value) {
				if (!isset($value->resigned_on)) {
					$data[$key]['client_name'] = $value->name;
					$data[$key]['officer_role'] = $value->officer_role;
          $data[$key]['appointed_on'] = isset($value->appointed_on)?date('d-m-Y', strtotime($value->appointed_on)):'';
				}
			}
		}
		echo json_encode($data);
		exit();
	}

	public function client_details_by_client_id($value) {
		$session = Session::get('admin_details');
		$user_id = $session['client_id'];

		$data = array();
		$value = explode("=", $value);
		$client_id = $value[0];
		$calling_type = $value[1];
		$data['client_details'] = Common::clientDetailsById($client_id);
		$data['logged_client_details'] = Common::clientDetailsById($user_id);

		//echo '<pre>';print_r($data);die;
		if ($calling_type == "ajax") {
			echo View::make("Invitedclient.ajax_organisation_details", $data);
			//echo json_encode($client_details);
			exit;
		} else {
			return $data;
			exit;
		}
	}

	public function delete_files() {
		$client_id = Input::get('client_id');
		$column = Input::get('column');
		$path = Input::get('path');
		$file_name = ClientFile::where('client_id', "=", $client_id)->select($column)->
			first();

		$data[$column] = "";
		$sql = ClientFile::where('client_id', "=", $client_id)->update($data);
		if ($sql) {
			if (isset($file_name[$column]) && $file_name[$column] != "") {
				$prevPath = $path . $file_name[$column];
				if (file_exists($prevPath)) {
					unlink($prevPath);
				}
			}
		}
		echo $sql;
	}

	public function upload_other_files() {
		$column = Input::get('column');
		$client_id = Input::get('client_id');
		$data[$column] = Input::get('file_name');
		$sql = ClientFile::where('client_id', "=", $client_id)->update($data);
		$file_details = ClientFile::where('client_id', "=", $client_id)->select('client_file_id')->
			first();
		echo $file_details['client_file_id'];
	}

	public function onboard_client() {

		$clients_id = Input::get("client_id");
		//$status = Input::get("status");
		//print_r($clients_id);die;
		foreach ($clients_id as $client_id) {
			//	if($status == "Archive"){
			Client::where('client_id', '=', $client_id)->update(array("is_onboard" => "Y"));
			//	}else{
			//				Client::where('client_id', '=', $client_id)->update(array("is_archive"=>"N", "show_archive"=>"N"));
			//			}

			//echo $this->last_query();die;
		}
	}

	public function indonboard_client() {

		$clients_id = Input::get("client_id");
		//$status = Input::get("status");
		//	print_r($clients_id);die;
		foreach ($clients_id as $client_id) {
			//	if($status == "Archive"){
			Client::where('client_id', '=', $client_id)->update(array("is_onboard" => "Y"));
			//	}else{
			//				Client::where('client_id', '=', $client_id)->update(array("is_archive"=>"N", "show_archive"=>"N"));
			//			}

			//echo $this->last_query();die;
		}
	}

	public function indgetowner() {

		$data = array();
		$client_id = Input::get("client_id");

		$session = Session::get('admin_details');
		$user_id = $session['id'];
		//$data['user_type'] 	= $session['user_type'];
		//$data['client_id'] 	= $client_id;
		$groupUserId = $session['group_users'];

		$staff_details = User::whereIn("user_id", $groupUserId)->where("client_id", "=",
			0)->select("user_id", "fname", "lname")->get();

		$i = 0;

		foreach ($staff_details as $key => $staff) {
			$f_name = $l_name = "";
			if (isset($staff->fname)) {
				$f_name .= $staff->fname;
			}

			if (isset($staff->lname)) {
				$l_name .= " " . $staff->lname;
			}

			$staff_name = $f_name . $l_name;
			$data[$i]['contact_type'] = "staff";
			$data[$i]['name'] = ucwords(strtolower($staff_name));
			$i++;

		}

		//echo '<pre>';print_r($staff_details);die();

		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->
			select("field_id", "field_name", "field_value")->get();
		//$i=0;
		foreach ($client_details as $key => $details) {

			if (isset($details->field_name) && $details->field_name == "reg_cont_name") {

				$data[$i]['contact_type'] = "reg";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			if (isset($details->field_name) && $details->field_name == "trad_cont_name") {
				$data[$i]['contact_type'] = "trad";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}
			if (isset($details->field_name) && $details->field_name == "corres_cont_name") {
				$data[$i]['contact_type'] = "corres";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			if (isset($details->field_name) && $details->field_name == "banker_cont_name") {
				$data[$i]['contact_type'] = "banker";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}
			if (isset($details->field_name) && $details->field_name == "oldacc_cont_name") {
				$data[$i]['contact_type'] = "oldacc";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}
			if (isset($details->field_name) && $details->field_name == "auditors_cont_name") {
				$data[$i]['contact_type'] = "auditors";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			if (isset($details->field_name) && $details->field_name ==
				"solicitors_cont_name") {
				$data[$i]['contact_type'] = "solicitors";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			$i++;
		}

		$relayth_data = Common::get_relationship_client($client_id);

		//echo'<pre>';print_r($relayth_data);die();

		// $data=array();
		//$k=0;
		if (isset($relayth_data) && count($relayth_data) > 0) {
			foreach ($relayth_data as $key => $value) {
				$data[$i]['contact_type'] = "relation";
				$data[$i]['name'] = ucwords(strtolower($value['name']));
				$i++;
			}

		}
		// echo'<pre>';print_r($data);die();

		//

		// print_r($data);
		//print_r($data['name']);
		//die();
		//array_merge($a1,$a2)

		echo View::make('home.organisation.ownerdropdown', $data)->with('data', $data);
		//echo View::make('home.organisation.ownerdropdown',$data);

	}

	public function add_checklist() {
		$rt_data = array();
		$session_data = Session::get('admin_details');
		$user_id = $session_data['id'];

		$data['client_id']          = Input::get("client_id");
        $data['custom_check_id']    = Input::get("custom_check_id");
		$data['name']               = Input::get("type_name");
		$data['user_id']            = $user_id;
		$data['status']             = "new";
        $data['created']            = date('Y-m-d H:i:s');
		$insert_id = Checklist::insertGetId($data);
		$rt_data['last_id'] = $insert_id;
		$rt_data['owner_list'] = App::make('ClientOnboardingController')->get_owner_list($data['client_id']);
		echo json_encode($rt_data);
		exit();
		//return Redirect::to('/organisation/add-client');

	}
	public function indadd_checklist() {

		$session_data = Session::get('admin_details');
		$user_id = $session_data['id'];

		$data['client_id'] = Input::get("client_id");
		$data['name'] = Input::get("type_name");
		$data['user_id'] = $user_id;
		$data['status'] = "new";
		$insert_id = Indchecklist::insertGetId($data);
		echo $insert_id;
		exit();
		//return Redirect::to('/organisation/add-client');

	}

	public function delete_checklist() {

		$field_id = Input::get("field_id");
		if (Request::ajax()) {
			$data = Checklist::where("checklist_id", "=", $field_id)->delete();
			echo $data;
		}

	}

	public function getowner1() {

		$data = $update = array();
		$client_id = Input::get("client_id");

		$session = Session::get('admin_details');
		$user_id = $session['id'];
		//$data['user_type'] 	= $session['user_type'];
		//$data['client_id'] 	= $client_id;
		$groupUserId = $session['group_users'];

		$staff_details = User::whereIn("user_id", $groupUserId)->where("client_id", "=",
			0)->select("user_id", "fname", "lname")->get();

		$i = 0;

		foreach ($staff_details as $key => $staff) {
			$f_name = $l_name = "";
			if (isset($staff->fname)) {
				$f_name .= $staff->fname;
			}

			if (isset($staff->lname)) {
				$l_name .= " " . $staff->lname;
			}

			$staff_name = $f_name . $l_name;
			$data[$i]['owner_id'] = $staff->user_id;
			$data[$i]['contact_type'] = "staff";
			$data[$i]['name'] = ucwords(strtolower($staff_name));
			$i++;

		}

		//echo '<pre>';print_r($staff_details);die();

		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->
			select("field_id", "field_name", "field_value")->get();
		//echo $this->last_query();die;
		//$i=0;
		foreach ($client_details as $key => $details) {

			if (isset($details->field_name) && $details->field_name == "reg_cont_name") {
				$data[$i]['owner_id'] = $client_id;
				$data[$i]['contact_type'] = "reg";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			if (isset($details->field_name) && $details->field_name == "trad_cont_name") {
				$data[$i]['owner_id'] = $client_id;
				$data[$i]['contact_type'] = "trad";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}
			if (isset($details->field_name) && $details->field_name == "corres_cont_name") {
				$data[$i]['owner_id'] = $client_id;
				$data[$i]['contact_type'] = "corres";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			if (isset($details->field_name) && $details->field_name == "banker_cont_name") {
				$data[$i]['owner_id'] = $client_id;
				$data[$i]['contact_type'] = "banker";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}
			if (isset($details->field_name) && $details->field_name == "oldacc_cont_name") {
				$data[$i]['owner_id'] = $client_id;
				$data[$i]['contact_type'] = "oldacc";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}
			if (isset($details->field_name) && $details->field_name == "auditors_cont_name") {
				$data[$i]['owner_id'] = $client_id;
				$data[$i]['contact_type'] = "auditors";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			if (isset($details->field_name) && $details->field_name == "solicitors_cont_name") {
				$data[$i]['owner_id'] = $client_id;
				$data[$i]['contact_type'] = "solicitors";
				$data[$i]['name'] = ucwords(strtolower($details->field_value));
			}

			$i++;
		}

		$relayth_data = Common::get_relationship_client($client_id);

		//echo'<pre>';print_r($relayth_data);die();

		// $data=array();
		//$k=0;
		if (isset($relayth_data) && count($relayth_data) > 0) {
			foreach ($relayth_data as $key => $value) {
				$data[$i]['owner_id'] = $value['client_id'];
				$data[$i]['contact_type'] = $value['type'];
				$data[$i]['name'] = ucwords(strtolower($value['name']));
				$i++;
			}

		}
		//echo'<pre>';print_r($data);die();

		//

		$created = Client::where('client_id', '=', $client_id)->select('created')->first();

		//echo
		$date_g = $created['created'];
		//die();

		$update['client_id'] = $client_id;
		$update['taskdate'] = $date_g;
		$update['user_id'] = $user_id;

		$arraydata = array();
		$festchtask = ClientTaskDate::where('client_id', '=', $client_id)->select('cleinttaskdate_id', 'user_id', 'client_id', 'taskdate', 'cteatedtaskdate', 'check_list', 'task_owner', 'status')->get();

		if (isset($festchtask) && count($festchtask) > 0) {
			foreach ($festchtask as $festchtaskdata) {

				$arraydata['checklistname'] = Checklist::where('checklist_id', '=', $festchtaskdata['check_list'])->select('name')->first();

				//echo '<pre>';print_r($checklistname['name']);

				// $owner=$festchtask['task_owner'];
				$arraydata['taskowner'] = $festchtaskdata['task_owner'];
				$arraydata['status'] = $festchtaskdata['status'];
				// echo '<pre>';print_r($arraydata);
			}
			//die();

		}
		//echo '<pre>';print_r($festchtask);die();

		echo View::make('home.organisation.ownerdropdown', $data)->with('data', $data)->with('date_g', $date_g);

	}

	public function onboardsnotes() {

		$insert_id = "";
		$data = array();
		$session_data = Session::get('admin_details');
		$data['client_id'] = Input::get("client_id");
		$data['user_id'] = $session_data['id'];
		$data['notes'] = Input::get("notes");

		$getclientid = Onboardingnote::where("client_id", "=", $data['client_id'])->
			select('onboardingnotes_id', 'notes')->first();

		if ($getclientid['onboardingnotes_id']) {
			Onboardingnote::where("onboardingnotes_id", "=", $getclientid->
					onboardingnotes_id)->update($data);
		} else {
			$insert_id = Onboardingnote::insertGetId($data);

		}

		echo $insert_id;
		exit();

	}
	public function indonboardsnotes() {

		$insert_id = "";
		$data = array();
		$session_data = Session::get('admin_details');
		$data['client_id'] = Input::get("client_id");
		$data['user_id'] = $session_data['id'];
		$data['notes'] = Input::get("notes");

		$getclientid = Indonboardingnote::where("client_id", "=", $data['client_id'])->
			select('onboardingnotes_id', 'notes')->first();

		if ($getclientid['onboardingnotes_id']) {
			Indonboardingnote::where("onboardingnotes_id",$getclientid->onboardingnotes_id)->update($data);
		} else {
			$insert_id = Indonboardingnote::insertGetId($data);

		}

		echo $insert_id;
		exit();

	}

	//SELECT (SELECT COUNT(*) FROM cleinttaskdates WHERE client_id = 3 AND user_id = 21) as total , (SELECT COUNT(*) FROM cleinttaskdates WHERE client_id = 3 AND user_id = 21 AND status = "done") as done FROM `cleinttaskdates` WHERE client_id = 3 GROUP BY client_id

	public function getonboardsnotes() {

		$notes = "";
		$data['client_id'] = Input::get("client_id");

		$getclientid = Onboardingnote::where("client_id", "=", $data['client_id'])->
			select('onboardingnotes_id', 'notes')->first();

		$notes = $getclientid['notes'];
		echo $notes;
		exit();
	}
	public function indgetonboardsnotes() {

		$notes = "";
		$data['client_id'] = Input::get("client_id");

		$getclientid = Indonboardingnote::where("client_id", "=", $data['client_id'])->
			select('onboardingnotes_id', 'notes')->first();

		$notes = $getclientid['notes'];
		echo $notes;
		exit();
	}

	public function onboardsave() {
		$date = $data = $update = array();
		$data['client_id'] = Input::get("client_id");
		$data['date'] = Input::get("date");

		$created = Client::where("client_id", "=", $data['client_id'])->select('client_id',
			'created')->first();

		//echo $created['created'];die();

		$date = explode(" ", $created['created']);

		$new_created = $data['date'] . " " . $date[1];
		$update['created'] = $new_created;

		Client::where("client_id", "=", $data['client_id'])->update($update);
		echo $new_created;
		die();

	}

	// Onboardingnote

	public function indonboardsave() {
		$date = $data = $update = array();
		$data['client_id'] = Input::get("client_id");
		$data['date'] = Input::get("date");

		$created = Client::where("client_id", "=", $data['client_id'])->select('client_id',
			'created')->first();

		//echo $created['created'];die();

		$date = explode(" ", $created['created']);

		$new_created = $data['date'] . " " . $date[1];
		$update['created'] = $new_created;

		Client::where("client_id", "=", $data['client_id'])->update($update);
		echo $new_created;
		die();

	}

	public function indeditclientpdf($client_id) {

		$t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;

		$data['heading'] = "";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$data['client_id'] = $client_id;
		$groupUserId = $session['group_users'];
		// $data['page_name'] = base64_decode($type_id);
		//print_r($data['page_name']);die();
		if ($data['user_type'] != "C") {
			$data['title'] = "Edit Client";
			$data['previous_page'] =
			'<a href="/individual-clients">Individual Client List</a>';
		} else {
			$data['title'] = "Edit User";

			$data['previous_page'] = '<a href="/client-portal">Client Portal</a>';
			//$data['previous_page'] = '<a href="/invitedclient-dashboard">Client Portal</a>';
		}
		if (empty($user_id)) {
			return Redirect::to('/');
		}

		$data['rel_types'] = RelationshipType::where("show_status", "=", "individual")->
			orderBy("relation_type_id")->get();
		$data['marital_status'] = MaritalStatus::orderBy("marital_status_id")->get();
		$data['titles'] = Title::orderBy("title_id")->get();
		$data['tax_office'] = TaxOfficeAddress::select("parent_id", "office_id", "office_name")->get();
		$data['tax_office_by_id'] = TaxOfficeAddress::where("office_id", "=", 1)->first();
		$data['steps'] = Step::where("status", "=", "old")->orderBy("step_id")->get();
		$data['substep'] = Step::whereIn("user_id", $groupUserId)->where("client_type",
			"=", "ind")->where("parent_id", "=", 1)->orderBy("step_id")->get();
		$data['responsible_staff'] = App::make('HomeController')->get_responsible_staff();
		$data['countries'] = Country::orderBy('country_name')->get();
		$data['nationalities'] = Nationality::get();
		$data['field_types'] = FieldType::get();
		//$data['cont_address'] = App::make('HomeController')->get_contact_address();
		$data['cont_address'] = ClientAddress::getAllDetails();
		//$data['allIndClients'] 	 	= App::make("HomeController")->get_all_ind_clients();
		$data['allClients'] = App::make("HomeController")->get_all_clients();
		$data['old_services'] = Service::where("status", "=", "old")->where("client_type",
			"=", "ind")->orderBy("service_name")->get();
		$data['new_services'] = Service::where("status", "=", "new")->where("client_type",
			"=", "ind")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
		//print_r($data['new_services']);die;

		$steps_fields_users = StepsFieldsAddedUser::whereIn("user_id", $groupUserId)->
			where("substep_id", "=", '0')->where("client_type", "=", "ind")->get();
		foreach ($steps_fields_users as $key => $steps_fields_row) {
			$steps_fields_users[$key]->select_option = explode(",", $steps_fields_row->
					select_option);
		}
		$data['steps_fields_users'] = $steps_fields_users;

		//###########User added section and sub section start##########//
		$steps = array();
		$subsections = Step::whereIn("user_id", $groupUserId)->where("status", "=",
			"new")->get();
		//echo $this->last_query();die;
		foreach ($subsections as $key => $val) {
			if (isset($val->status) && $val->status == "new") {
				$steps[$key]['step_id'] = $val->step_id;
				$steps[$key]['parent_id'] = $val->parent_id;
				$steps[$key]['short_code'] = $val->short_code;
				$steps[$key]['title'] = $val->title;
				$steps[$key]['status'] = $val->status;
			}

		}
		$data['subsections'] = App::make('HomeController')->buildtree($steps, "ind");
		//###########User added section and sub section start##########//

		$data['relationship'] = Common::get_relationship_client($client_id);
		//echo $this->last_query();die;
		$data['acting'] = Common::get_acting_client($client_id);
		$data['acting_dropdown'] = $this->get_acting_dropdown($data['relationship'], $data['acting']);

		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->select("field_id", "field_name", "field_value")->get();

		//echo '<pre>';print_r($client_details);die();

		$client_data['client_id'] = $client_id;

		if (isset($client_details) && count($client_details) > 0) {
			foreach ($client_details as $client_row) {
				if (isset($client_row->field_name) && $client_row->field_name == "client_name") {
					$client_data['initial_badge'] = $this->get_initial_badge($client_row->field_value);
				}
				$client_data[$client_row['field_name']] = $client_row->field_value;
			}
		}

		$data['client_details'] = $client_data;

		$c_id = $data['client_details'];

		if (isset($c_id['title']) && count($c_id['title']) > 0) {
			$name = $c_id['title'] . " ";
		}

		if (isset($c_id['fname']) && count($c_id['fname']) > 0) {
			$name .= $c_id['fname'] . " ";
		}

		if (isset($c_id['mname']) && count($c_id['mname']) > 0) {
			$name .= $c_id['mname'] . " ";
		}

		if (isset($c_id['lname']) && count($c_id['lname']) > 0) {
			$name .= $c_id['lname'];
		}
		$full_name = $name;

		$data['client_name'] = $full_name;
		// print_r($full_name);die();
		// echo'<pre>'; print_r($c_id);die();

		if (isset($c_id['res_country']) && count($c_id['res_country']) > 0) {

			$rescoun = Country::where("country_id", "=", $c_id['res_country'])->select('country_name')->first();
			$data['rescon'] = $rescoun->country_name;
		}

		if (isset($c_id['res_country']) && count($c_id['res_country']) > 0) {
			$servecoun = Country::where("country_id", "=", $c_id['serv_country'])->select('country_name')->first();
			$data['servcon'] = $servecoun->country_name;
		}

		if (isset($c_id['country_id']) && count($c_id['country_id']) > 0) {
			$country = Country::where("country_id", "=", $c_id['country_id'])->select('country_name')->first();
			$data['countryname'] = $country->country_name;
		}

		if (isset($c_id['tax_office_id']) && count($c_id['tax_office_id']) > 0) {
			$tax = TaxOfficeAddress::where('office_id', '=', $c_id['tax_office_id'])->select("office_name")->first();
			$data['taxoffice_name'] = $tax->office_name;
		}

		if (isset($c_id['nationality_id']) && count($c_id['nationality_id']) > 0) {
			$nationalityname = Nationality::where('nationality_id', '=', $c_id['nationality_id'])->select("nationality_name")->first();
			$data['nationality_name'] = $nationalityname->nationality_name;
		}

		// echo'<pre>'; print_r($data);die();
		/* ############# client exists / not in the user table section start ############### */
		$users = User::where("client_id", "=", $client_id)->select("user_id",
			"user_type")->first();
		$data['user_id'] = "";
		$data['relation_list'] = array();
		if (isset($users) && count($users) > 0) {
			$data['user_id'] = $users['user_id'];

			if (isset($users['user_type']) && $users['user_type'] == "C") {
				$data['relation_list'] = App::make("InvitedclientController")->
					all_relation_client_details($users['user_id']);
			}
		}
		// ############# client exists / not in the user table section end ############### //

		// ============= Get files start ========== //
		$data['files'] = ClientFile::where("client_id", "=", $client_id)->first();
		//print_r($data['files']);die;
		// ============= Get files end ========== //

		$data['services_id'] = Client::getServicesIdByClient($client_id);

		//print_r($data['services_id']);die;
		//############# Get client data end ################//

		//return View::make('home.individual.edit_individual_client', $data);

		//echo '<pre>';print_r($data);die();

		$pdf = PDF::loadView('home/individual/indeditpdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		//echo '<pre>';print_r($pdf);die();

		//$this->load->view('');

		//$pdf.= View::make('home/individual/pdfheader');

		$output = $pdf->output();

		//$final_output =
		//echo "<pre>"; print_r( $output );die;
		$dom_pdf = $pdf->getDomPDF();

		$canvas = $dom_pdf->get_canvas();
		//echo $canvas->get_page_number();die;

		if (isset($canvas)) {

			$canvas->page_script('
                    if ($PAGE_NUM > 1) {
                        $PAGE_NUM=$PAGE_NUM-1;
                        $PAGE_COUNT=$PAGE_COUNT-1;
                        $font = Font_Metrics::get_font("Arial, Helvetica, sans-serif", "normal");
                        $size = 10;

                        $pageText1 =  " Page " ;
                        $y1 = $pdf->get_height() - 35;
                        $x1 = $pdf->get_width() - 80- Font_Metrics::get_text_width($pageText1, $font, $size);
                        $pdf->text($x1, $y1, $pageText1, $font, $size,array(0, 0, 255));

                        $pageText = $PAGE_NUM . " of " . $PAGE_COUNT;
                        $y = $pdf->get_height() - 35;
                        $x = $pdf->get_width() - 50 - Font_Metrics::get_text_width($pageText, $font, $size);
                        $pdf->text($x, $y, $pageText, $font, $size,array(0, 0, 255));
                    }
                ');
		}
		$cname = str_replace(' ', '_', $full_name);
		return $pdf->download($cname . '.pdf');

	}

	public function orgeditclientpdf($client_id) {

		$t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;

		$data['heading'] = "";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];
		//$data['page_name'] = base64_decode($type_id);
		//$data['encode_page_name'] = $type_id;
		//print_r($data['page_name']);die();
		if ($data['user_type'] != "C") {
			$data['title'] = "Edit Client";
			$data['previous_page'] =
			'<a href="/organisation-clients">Organisation Client List</a>';
		} else {
			$data['title'] = "Edit Client";
			$data['previous_page'] = '<a href="/client-portal">Client Portal</a>';
		}

		if (empty($user_id)) {
			return Redirect::to('/');
		}

		$data['old_org_types'] = OrganisationType::where("client_type", "=", "all")->
			orderBy("name")->get();
		$data['new_org_types'] = OrganisationType::where("client_type", "=", "org")->
			whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->
			get();

		$data['rel_types'] = RelationshipType::orderBy("relation_type_id")->get();
		$data['titles'] = Title::orderBy("title_id")->get();
		$data['steps'] = Step::where("status", "=", "old")->orderBy("step_id")->get();
		$data['substep'] = Step::where("client_type", "=", "org")->where("parent_id",
			"=", 1)->whereIn("user_id", $groupUserId)->orderBy("step_id")->get();
		$data['staff_details'] = User::whereIn("user_id", $groupUserId)->where("client_id",
			"=", 0)->select("user_id", "fname", "lname")->get();
		$data['tax_office'] = TaxOfficeAddress::select("parent_id", "office_id", "office_name")->get();

		$first_serv = DB::table('services')->where("status", "=", "old")->where("user_id",
			"=", 0);

		$data['services'] = Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->
			union($first_serv)->orderBy("service_id")->get();

		$data['old_services'] = Service::where("status", "=", "old")->where("client_type",
			"=", "org")->orderBy("service_name")->get();
		$data['new_services'] = Service::where("status", "=", "new")->where("client_type",
			"=", "org")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();

		$data['countries'] = Country::orderBy('country_name')->get();
		$data['field_types'] = FieldType::get();

		$data['old_vat_schemes'] = VatScheme::where("status", "=", "old")->orderBy("vat_scheme_name")->
			get();
		$data['new_vat_schemes'] = VatScheme::where("status", "=", "new")->whereIn("user_id",
			$groupUserId)->orderBy("vat_scheme_name")->get();
		//echo $this->last_query();die;
		//$data['cont_address'] 	 = App::make("HomeController")->getAllOrgContactAddress();
		$data['cont_address'] = App::make("HomeController")->get_orgcontact_address();
		$data['allClients'] = App::make("HomeController")->get_all_clients();

		//print_r($data['cont_address'] );die();

		$data['reg_address'] = RegisteredAddress::orderBy("reg_id")->get();

		$steps_fields_users = StepsFieldsAddedUser::whereIn("user_id", $groupUserId)->
			where("substep_id", "=", '0')->where("client_type", "=", "org")->get();
		foreach ($steps_fields_users as $key => $steps_fields_row) {
			$steps_fields_users[$key]->select_option = explode(",", $steps_fields_row->select_option);
		}
		$data['steps_fields_users'] = $steps_fields_users;

		//###########User added section and sub section start##########//
		$steps = array();
		$subsections = Step::whereIn("user_id", $groupUserId)->where("status", "=",
			"new")->get();
		foreach ($subsections as $key => $val) {
			if (isset($val->status) && $val->status == "new") {
				$steps[$key]['step_id'] = $val->step_id;
				$steps[$key]['parent_id'] = $val->parent_id;
				$steps[$key]['short_code'] = $val->short_code;
				$steps[$key]['title'] = $val->title;
				$steps[$key]['status'] = $val->status;
			}

		}
		$data['subsections'] = App::make("HomeController")->buildtree($steps, "org");
		//print_r($data['subsections']);die;

		$data['relationship'] = Common::get_relationship_client($client_id);
		$data['acting'] = Common::get_acting_client($client_id);
		$data['acting_dropdown'] = $this->get_acting_dropdown($data['relationship'], $data['acting']);
		//print_r($data['relationship']);die;

		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->
			select("field_id", "field_name", "field_value")->get();

		$client_data['client_id'] = $client_id;

		if (isset($client_details) && count($client_details) > 0) {
			foreach ($client_details as $client_row) {
				if (isset($client_row->field_name) && $client_row->field_name == "business_name") {
					$client_data['initial_badge'] = $this->get_initial_badge($client_row->
							field_value);
				}
				$client_data[$client_row['field_name']] = $client_row->field_value;
			}
		}

		$data['months'] = array(
			"01" => "JAN",
			"02" => "FEB",
			"03" => "MAR",
			"04" => "APR",
			"05" => "MAY",
			"06" => "JUN",
			"07" => "JUL",
			"08" => "AUG",
			"09" => "SEPT",
			"10" => "OCT",
			"11" => "NOV",
			"12" => "DEC");

		$data['client_details'] = $client_data;
		$o_id = $data['client_details'];
            
        

        if (isset($o_id['vat_scheme_type']) && count($o_id['vat_scheme_type']) > 0) {
			$vatscheme = VatScheme::where("vat_scheme_id", "=", $o_id['vat_scheme_type'])->select("vat_scheme_name")->first();
			$data['vat_scheme'] = $vatscheme->vat_scheme_name;

		}



		$bname = str_replace(' ', '_', $o_id['business_name']);

		//echo $bname; die();
		if (isset($o_id['business_type']) && count($o_id['business_type']) > 0) {
			$business_name = OrganisationType::where("organisation_id", "=", $o_id['business_type'])->select("name")->first();
			$data['businessname'] = $business_name->name;

		}

		// print_r($data['businessname']);die();

		if (isset($o_id['registered_in']) && count($o_id['registered_in']) > 0) {
			$business_name = RegisteredAddress::where("reg_id", "=", $o_id['registered_in'])->select("reg_name")->first();
			$data['regname'] = $business_name->reg_name;

		}

		if (isset($o_id['tax_office_id']) && count($o_id['tax_office_id']) > 0) {
			$tax = TaxOfficeAddress::where('office_id', '=', $o_id['tax_office_id'])->select("office_name")->first();
			$data['taxoffice_name'] = $tax->office_name;
		}

		if (isset($o_id['trad_cont_country']) && count($o_id['trad_cont_country']) > 0) {
			$country = Country::where("country_id", "=", $o_id['trad_cont_country'])->select('country_name')->first();
			$data['trad_country'] = $country->country_name;
		}

		if (isset($o_id['corres_cont_country']) && count($o_id['corres_cont_country']) > 0) {
			$country = Country::where("country_id", "=", $o_id['corres_cont_country'])->select('country_name')->first();
			$data['corres_country'] = $country->country_name;
		}

		if (isset($o_id['banker_cont_country']) && count($o_id['banker_cont_country']) > 0) {
			$country = Country::where("country_id", "=", $o_id['banker_cont_country'])->select('country_name')->first();
			$data['banker_country'] = $country->country_name;
		}
		if (isset($o_id['oldacc_cont_country']) && count($o_id['oldacc_cont_country']) > 0) {
			$country = Country::where("country_id", "=", $o_id['oldacc_cont_country'])->select('country_name')->first();
			$data['oldacc_country'] = $country->country_name;
		}

		if (isset($o_id['auditors_cont_country']) && count($o_id['auditors_cont_country']) > 0) {
			$country = Country::where("country_id", "=", $o_id['auditors_cont_country'])->select('country_name')->first();
			$data['auditors_country'] = $country->country_name;
		}

		if (isset($o_id['solicitors_cont_country']) && count($o_id['solicitors_cont_country']) > 0) {
			$country = Country::where("country_id", "=", $o_id['solicitors_cont_country'])->select('country_name')->first();
			$data['solicitors_country'] = $country->country_name;
		}

		//print_r($data['trad_county']);die();

		//$data['services_table'] 	=   Common::get_services_client($client_id);
		$data['services_id'] = Client::getServicesIdByClient($client_id);
		//echo $this->last_query();
		//print_r($data['services_id']);die;

		$data['org_notes'] = OrgNotes::where('client_id', '=', $client_id)->select("orgnotes_id",
			"user_id", "client_id", "title", "textmessage", "created")->orderBy('created',
			'DESC')->get();

		$data['orgdtails_notes'] = OrgNotes::where('client_id', '=', $client_id)->
			select("orgnotes_id", "user_id", "client_id", "title", "textmessage", "created")->
			orderBy('created', 'DESC')->first();

		$user = $data['orgdtails_notes']['user_id'];
		// die();

		$data['user'] = User::where("user_id", "=", $user)->select("fname", "lname",
			"user_id")->first();

		// echo '<pre>';print_r($data['orgdtails_notes']);die();
		//echo $this->last_query();die;

		$pdf = PDF::loadView('home/organisation/orgeditpdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		//$cover_pdf = PDF::loadView('home/organisation/orgcoverpdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		//$cover_output = $cover_pdf->output();
		$output = $pdf->output();

		//$final_output =
		//echo "<pre>"; print_r( $output );die;
		$dom_pdf = $pdf->getDomPDF();

		$canvas = $dom_pdf->get_canvas();
		//echo $canvas->get_page_number();die;

		if (isset($canvas)) {

			$canvas->page_script('
                    if ($PAGE_NUM > 1) {
                        $PAGE_NUM=$PAGE_NUM-1;
                        $PAGE_COUNT=$PAGE_COUNT-1;
                        $font = Font_Metrics::get_font("Arial, Helvetica, sans-serif", "normal");
                        $size = 10;

                        $pageText1 =  " Page " ;
                        $y1 = $pdf->get_height() - 35;
                        $x1 = $pdf->get_width() - 80- Font_Metrics::get_text_width($pageText1, $font, $size);
                        $pdf->text($x1, $y1, $pageText1, $font, $size,array(0, 0, 255));

                        $pageText = $PAGE_NUM . " of " . $PAGE_COUNT;
                        $y = $pdf->get_height() - 35;
                        $x = $pdf->get_width() - 50 - Font_Metrics::get_text_width($pageText, $font, $size);
                        $pdf->text($x, $y, $pageText, $font, $size,array(0, 0, 255));
                    }
                ');
		}

		// $canvas->page_text(700, 565, "{PAGE_NUM}", null, 10, array(0,0,255));

		//$font = Font_Metrics::get_font("calibri", "bold");
		// $canvas->page_text(72, 18, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
		//$font = Font_Metrics::get_font("calibri", "bold");
		//$canvas->page_text(700, 565, "Page - {PAGE_NUM}", $font, 10, array(0, 0, 0));
		//$pdf .= $cover_pdf;
		//echo "<pre>"; print_r($pdf); die;

		//$finalbname=  str_replace(' ', '_', $bname);

		return $pdf->download($bname . '.pdf');

	}

	public function ajax_client_details() {
		$client_id = Input::get('client_id');
		$client_details = Common::clientDetailsById($client_id);

		$details = ChLogin::getDetails();
		if(isset($details['email']) && $details['email'] != ""){
			$client_details['ch_username'] = $details['email'];
		}else{
			$client_details['ch_password'] = "";
		}
		if(isset($details['password']) && $details['password'] != ""){
			$client_details['ch_password'] = $details['password'];
		}else{
			$client_details['ch_password'] = "";
		}


		echo json_encode($client_details);
		exit;
	}

	public function ajax_chlogin_details() {
		$client_details = array();
		$details = ChLogin::getDetails();
		if(isset($details['email']) && $details['email'] != ""){
			$client_details['ch_username'] = $details['email'];
		}else{
			$client_details['ch_password'] = "";
		}
		if(isset($details['password']) && $details['password'] != ""){
			$client_details['ch_password'] = $details['password'];
		}else{
			$client_details['ch_password'] = "";
		}

		echo json_encode($client_details);
		exit;
	}

	public function all_org_clients() 
	{
		$data 		= array();
		$details 	= array();
		$client_type 	= Input::get('client_type');

		if($client_type == 'xero'){
			$invoice_id 	= Input::get('invoice_id');
			$contact_id 	= Input::get('contact_id');
			$client_details = Client::getAllOrgClientDetails();
			if(isset($client_details) && count($client_details) >0){
				foreach ($client_details as $key => $value) {
					$data[$key]['client_id'] 	= $value['client_id'];
					$data[$key]['client_name'] 	= $value['business_name'];
				}
			}
			/*================ Short By Client Name ==========*/
			foreach ($data as $value){
			$client_name[]  = $value['client_name'];
			} 
			array_multisort($client_name, SORT_ASC, $data);
			/*================ Short By Client Name ==============*/ 

			$details['clients'] 		=	$data;
			$details['inv_client'] 	= CrmInvoiceDebit::name_by_invoiceid($invoice_id);
		}else{
			$client_id 	= Input::get('client_id');
			$details['inv_client'] 	= Client::getClientNameByClientId($client_id);
			$details['invoices'] 		= CrmInvoiceDebit::details_by_Mergedid($client_id);
		}
		
		//echo $details['inv_client'];die;
		echo json_encode($details);
		exit;
	}

	public function open_message_pop()
	{
		$data = array();
		return View::make('home.include.activity_history_msg', $data);
	}
    
  public function invite_client_action()
	{
		$data = array();
    $input      = Input::get();
    $action     = $input['action'];
    $client_id  = $input['client_id'];
    
    if($action == "getDetails"){
      $client_type    = $input['client_type'];
      $send_type      = $input['send_type'];
      $data['email']          = Client::getEmail($client_id, $client_type);
      $data['client_name']    = Client::getClientNameByClientId($client_id);
      $data['relation']       = Client::getRelationClientByClientId($client_id);
    }
    
    echo json_encode($data);
	}


	public function save_client_address()
	{
		$data = array();
		$session = Session::get('admin_details');
    $user_id = $session['id'];

    $input      = Input::get();
    $address_id = $input['address_id'];
    $page_open 	= $input['address_page_open'];
    //$action     = $input['action'];
    //$link     	= $input['link'];

    $checkaddr1 	= substr($input['address1'], 0, 7);
    $checkpost  	= $input['address_postcode'];
    $checkAddr 		= ClientAddress::checkAddress($checkaddr1, $checkpost, 'main');

    $data['user_id']     	= $user_id;
    $data['client_id']    = $input['client_id'];
    $data['address_type'] = $input['address_type'];
    $data['address1']    	= $input['address1'];
    $data['address2']    	= $input['address2'];
    $data['city']        	= $input['address_city'];
    $data['county']      	= $input['address_county'];
    $data['postcode']    	= $input['address_postcode'];
    $data['country']     	= $input['address_country'];
    if($page_open == 'client_portal'){
    	$data['is_show_client']  = 'Y';
    }

    if($checkAddr == '0' || $address_id == $checkAddr){
    	if($address_id == 0 || $address_id == ""){
      	$address_id = ClientAddress::insertGetId($data);
      	$data['action']     = 'add';
      }else{
      	ClientAddress::where('address_id', $address_id)->update($data);
      	$data['action']     = 'edit';
      }
      
			$data['country_name']   = Country::getCountryNameByCountryId($input['address_country']);
	    $data['address_id']   = $address_id;
	    $data['message']     	= 'success';
    }else{
    	if($page_open == 'client_portal'){
      	$checkClntAddr 	= ClientAddress::checkAddress($checkaddr1, $checkpost, 'client');
      	if($checkClntAddr == 0){
      		$datacl['is_show_client']  = 'Y';
        	ClientAddress::where('address_id', $checkAddr)->update($datacl);
      		$data['action']     		= 'edit';
        	$data['country_name']   = Country::getCountryNameByCountryId($input['address_country']);
	        $data['address_id']     = $checkAddr;
	        $data['message']     		= 'success';
        }else{
        	$data['message']  = 'error';
        }
      }else{
      	$data['message']  	= 'error';
      }
    }
    
    //return Redirect::to($link);
    echo json_encode($data);
	}

	public function delete_client_address()
	{
		$input      = Input::get();
		$address_id	= $input['address_id'];
		ClientAddress::where('address_id', $address_id)->delete();
		echo 1;
	}

	public function gat_client_address_by_id()
	{
		$data 			= array();
		$input      = Input::get();
		$address_id	= $input['address_id'];
		$details 		= ClientAddress::getDetailsById($address_id);
		$data['address'] = $details;
		echo json_encode($data);
	}
    
	public function ajax_get_store_data()
	{
		$data = array();
		$store_id	= Input::get('store_id');
		DataStore::where('store_id', $store_id)->update(array('is_read'=>'Y'));
		$details 							= DataStore::getDetailsByStoreId($store_id);
		$data['details'] 			= $details;
		$data['unread_count'] = DataStore::getUnreadNotificationCount();

		echo json_encode($data);
	}

	public function store_data_action()
	{
		$data 		= array();
		$store_id	= Input::get('store_id');
		$action		= Input::get('action');

		if($action	== 'delete'){
			DataStore::where('store_id', $store_id)->delete();
			ClientDataStore::where('store_id', $store_id)->delete();
		}else if($action  == 'update'){
			DataStore::where('store_id', $store_id)->update(array('is_read'=>'Y'));
		}else if($action  == 'notes_update'){
			$notes = Input::get("notes");
			DataStore::where('store_id', $store_id)->update(array('notes'=>$notes));
		}
		$data['store_id'] 			= $store_id;
		$data['unread_count'] 	= DataStore::getUnreadNotificationCount();

		echo json_encode($data);
	}





}


