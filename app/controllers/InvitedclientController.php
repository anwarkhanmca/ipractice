<?php

class InvitedclientController extends BaseController {
	public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)){
            Redirect::to('/login')->send();
        }
    }

	public function Invitedclient_dashboard() {
	    $session 	= Session::get('admin_details');
		$user_id 	= $session['id'];
		$user_type 	= $session['user_type'];
		if(!isset($user_id) && $user_id == ""){
			return Redirect::to('/');
		}else if(isset($user_type) && $user_type != "C"){
			return Redirect::to('/dashboard');
		}

		$data['heading'] 		= "DASHBOARD";
		$data['title'] 			= "Client Portal";
		$data['client_id'] 		= $session['client_id'];
		$value = $data['client_id']."="."function";
		//$data['relation_list'] 	= App::make("UserController")->get_relation_client($value);
		//$data['relation_list'] 	= $this->all_relation_client_details($user_id);
        
        $data['relation_list'] 	= Client::getRelationClient();
        //$data['relation_list'] 	= Client::getInvitedClient($user_id);

        //echo "<pre>";print_r($data);die;
        
        return View::make('Invitedclient.Invitedclient', $data);
	}

	function all_relation_client_details($user_id)
	{

		$details = array();
		if( isset($user_id) && $user_id != "" )
		{
			$clients = DB::table('user_related_companies as urc')->where("urc.user_id", $user_id)
			->join('clients as c', 'c.client_id', "=", 'urc.client_id')
        	->join('steps_fields_clients as sfc', 'sfc.client_id', '=', 'c.client_id')
        	->where('sfc.field_name', '=', 'business_name')
        	->where("c.type", "=", "org")
        	->select('c.client_id', 'sfc.field_value as client_name', 'urc.related_company_id', 'urc.status')->get();
        	//echo $this->last_query();die;
            
           // print_r($clients);die();
        	if( isset($clients) && count($clients) >0 ){
	        	foreach ($clients as $key => $value) {
	        		$details[$key]['related_company_id'] 	= $value->related_company_id;
	        		$details[$key]['client_id'] 			= $value->client_id;
	        		$details[$key]['client_name'] 			= $value->client_name;
	        		$details[$key]['status'] 				= $value->status;
	        	}
	        	
	        }
		}

		return $details;
	}
    
    
    public function my_details(){
        //die('yes');
        $admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
        $data['heading'] = "Invitedclient";
		$data['title'] = "Invitedclient";
        
        
        $client_ids = Client::where("type", "=", "org")->where('user_id', '=', $user_id)->select("client_id")->get();
        $data1 = array();
        foreach($client_ids as $key=>$client_id){
             
       $data1[$key] = StepsFieldsClient::where('client_id', '=', $client_id->client_id)->where('field_name', '=', 'business_name')->select("field_value")->first();
             
            }
       $data['b_name']= $data1;
       
       $data['rel_types'] 	= RelationshipType::where("show_status", "=", "individual")->orderBy("relation_type_id")->get();

        $data['titles'] 		= Title::orderBy("title_id")->get();
       	$data['marital_status'] = MaritalStatus::orderBy("marital_status_id")->get();
        $data['countries'] 			= Country::orderBy('country_name')->get();
        $data['tax_office'] 	= TaxOfficeAddress::select("parent_id", "office_id", "office_name")->get();
		$data['tax_office_by_id'] 	= TaxOfficeAddress::where("office_id", "=", 1)->first();
   	    $data['steps'] 				= Step::where("status", "=", "old")->orderBy("step_id")->get();
        //echo "<pre>";print_r($data['b_name'][0]['field_value']);die;
		return View::make('Invitedclient.add_Invitedclient', $data);
    } 
    
    
    
   public function insert_invitedclient_client()
   {
    	$postData = Input::all();
        $arrData = array();
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];
        
   
    
	    $client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'ind')) ;
	   
	    //################ GENERAL SECTION START #################//
	    
	    $step_id = 1;
	    $client_name = "";
		if (!empty($postData['title'])) {
			$client_name.=$postData['title']." ";
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'title', $postData['title']);
		}
                
		if (!empty($postData['fname'])) {
			$client_name.=$postData['fname']." ";
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'fname', $postData['fname']);
		}
        
		if (!empty($postData['mname'])) {
			$client_name.=$postData['mname']." ";
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'mname', $postData['mname']);
		}
        
		if (!empty($postData['lname'])) {
			$client_name.=$postData['lname'];
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'lname', $postData['lname']);
		}
        
		$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'client_name', trim($client_name));

		if (!empty($postData['gender'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'gender', $postData['gender']);
		}
		if (!empty($postData['dob'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'dob', $postData['dob']);
		}
		if (!empty($postData['marital_status'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'marital_status', $postData['marital_status']);
		}
		if (!empty($postData['spouse_dob'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'spouse_dob', $postData['spouse_dob']);
		}
		if (!empty($postData['nationality'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'nationality', $postData['nationality']);
		}
		if (!empty($postData['occupation'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'occupation', $postData['occupation']);
		}
        
       
//################ GENERAL SECTION END #################//
//################ TAX SECTION START #################//
		$step_id = 2;
		if (!empty($postData['ni_number'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ni_number', $postData['ni_number']);
		}
		if (!empty($postData['tax_reference'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_reference', $postData['tax_reference']);
		}
		if (!empty($postData['other_office_id'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_office_id', $postData['other_office_id']);
		} else {
			if (!empty($postData['tax_office_id'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_office_id', $postData['tax_office_id']);
			}
		}
		if (!empty($postData['tax_address'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_address', $postData['tax_address']);
		}
		if (!empty($postData['tax_zipcode'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_zipcode', $postData['tax_zipcode']);
		}
		if (!empty($postData['tax_telephone'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_telephone', $postData['tax_telephone']);
		}
		if (!empty($postData['tax_region'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_region', $postData['tax_region']);
		}
        
//################ TAX INFORMATION SECTION END #################//
    
//################ CONTACT INFORMATION SECTION START #################//
		$step_id = 3;
		if (!empty($postData['res_addr_line1'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_addr_line1', $postData['res_addr_line1']);
		}
		if (!empty($postData['res_addr_line2'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_addr_line2', $postData['res_addr_line2']);
		}
		if (!empty($postData['res_city'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_city', $postData['res_city']);
		}
		if (!empty($postData['res_county'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_county', $postData['res_county']);
		}
		if (!empty($postData['res_postcode'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_postcode', $postData['res_postcode']);
		}
		if (!empty($postData['res_country'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_country', $postData['res_country']);
		}
		if (!empty($postData['serv_addr_line1'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_addr_line1', $postData['serv_addr_line1']);
		}
		if (!empty($postData['serv_addr_line2'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_addr_line2', $postData['serv_addr_line2']);
		}
		if (!empty($postData['serv_city'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_city', $postData['serv_city']);
		}
		if (!empty($postData['serv_county'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_county', $postData['serv_county']);
		}

		if (!empty($postData['serv_postcode'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_postcode', $postData['serv_postcode']);
		}
		if (!empty($postData['serv_country'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_country', $postData['serv_country']);
		}
		if (!empty($postData['serv_tele_code'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_tele_code', $postData['serv_tele_code']);
		}
		if (!empty($postData['serv_telephone'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_telephone', $postData['serv_telephone']);
		}
		if (!empty($postData['serv_mobile_code'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_mobile_code', $postData['serv_mobile_code']);

		}
		if (!empty($postData['serv_mobile'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_mobile', $postData['serv_mobile']);

		}
		if (!empty($postData['serv_email'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_email', $postData['serv_email']);
		}
		if (!empty($postData['serv_website'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_website', $postData['serv_website']);
		}
		if (!empty($postData['serv_skype'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_skype', $postData['serv_skype']);
		}
//################ CONTACT INFORMATION SECTION END #################//



//############# RELATIONSHIP START ###################//
		if (!empty($postData['app_hidd_array'])) {
			$relData = array();
			$app_hidd_array = explode(",", $postData['app_hidd_array']); //print_r($app_hidd_array);
			foreach ($app_hidd_array as $row) {
				$rel_row = explode("mpm", $row);
				$app_date = explode("-", $rel_row['1']);
				$relData[] = array(
					'client_id' => $client_id,
					'appointment_with' => $rel_row['0'],
					'appointment_date' => $app_date[2]."-".$app_date[1]."-".$app_date[0],
					'relationship_type_id' => $rel_row['2'],
				);
			}
			ClientRelationship::insert($relData);

		}
//#############RELATIONSHIP END ###################//
		
	StepsFieldsClient::insert($arrData);
    
    return Redirect::to('/invitedclient-details');
    
        
    
}
   
	public function save_client($user_id, $client_id, $step_id, $field_name, $field_value) {
		$data = array();
		$data['user_id'] = $user_id;
		$data['client_id'] = $client_id;
		$data['step_id'] = $step_id;
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		return $data;
		//OrganisationClient::insert($data);
	}
    
    
    
    public function relationship(){
        
        $admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];
        
        $data['heading'] = "Invitedclient rel";
		$data['title'] = "Invitedclient rel";
        
        
        
        $first = DB::table('organisation_types')->where("client_type", "=", "all")->where("status", "=", "old")->where("user_id", "=", 0);
		$data['org_types'] = OrganisationType::where("client_type", "=", "org")->where("status", "=", "new")->whereIn("user_id", $groupUserId)->union($first)->orderBy("organisation_id")->get();
        $data['reg_address'] 	= RegisteredAddress::get();
        
        
        $data['rel_types'] 		= RelationshipType::orderBy("relation_type_id")->get();
        $data['tax_office'] 	= TaxOfficeAddress::select("parent_id", "office_id", "office_name")->get();

		$first_serv = DB::table('services')->where("status", "=", "old")->where("user_id", "=", 0);
		$data['services'] 		= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->union($first_serv)->orderBy("service_id")->get();
        $data['countries'] 		= Country::orderBy('country_name')->get();
		$data['field_types'] 	= FieldType::get();
        $first_vat = DB::table('vat_schemes')->where("status", "=", "old")->where("user_id", "=", 0);
		$data['vat_schemes'] 	= VatScheme::where("status", "=", "new")->whereIn("user_id", $groupUserId)->union($first_vat)->orderBy("vat_scheme_id")->get();
		
		return View::make('Invitedclient.add_relationship_client', $data);
        
    }
    
    
    public function insert_relationship_client(){
        
        //die('invitedclient-relationship');
        
        $postData = Input::all();
		$data = array();
		$arrData = array();
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];

		$client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'org'));
        
        
            //echo "<pre>";print_r($postData);die();
        
        //#############BUSINESS INFORMATION START###################//
		$step_id = 1;
	
		if (!empty($postData['business_type'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'business_type', $postData['business_type']);
		}
		if (!empty($postData['business_name'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'business_name', $postData['business_name']);
		}
		if (!empty($postData['registration_number'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'registration_number', $postData['registration_number']);
		}
		if (!empty($postData['incorporation_date'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'incorporation_date', $postData['incorporation_date']);
		}
		if (!empty($postData['registered_in'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'registered_in', $postData['registered_in']);
		}
		if (!empty($postData['business_desc'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'business_desc', $postData['business_desc']);
		}

		if(isset($postData['ann_ret_check']) && $postData['ann_ret_check'] != ""){
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ann_ret_check', $postData['ann_ret_check']);

			if (!empty($postData['made_up_date'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'made_up_date', $postData['made_up_date']);
			}
			if (!empty($postData['next_ret_due'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'next_ret_due', $postData['next_ret_due']);
			}
			if (!empty($postData['ch_auth_code'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ch_auth_code', $postData['ch_auth_code']);
			}
		}

		if(isset($postData['yearend_acc_check']) && $postData['yearend_acc_check'] != ""){
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'yearend_acc_check', $postData['yearend_acc_check']);

			if (!empty($postData['acc_ref_day'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'acc_ref_day', $postData['acc_ref_day']);
			}
			if (!empty($postData['acc_ref_month'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'acc_ref_month', $postData['acc_ref_month']);
			}
			if (!empty($postData['last_acc_madeup_date'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'last_acc_madeup_date', $postData['last_acc_madeup_date']);
			}
			if (!empty($postData['next_acc_due'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'next_acc_due', $postData['next_acc_due']);
			}
		}
//#############BUSINESS INFORMATION END###################//
            
            
            //#############TAX INFORMATION START###################//
		$step_id = 2;
		if (isset($postData['reg_for_vat']) && $postData['reg_for_vat'] != "") {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'reg_for_vat', $postData['reg_for_vat']);

			if (!empty($postData['effective_date'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'effective_date', $postData['effective_date']);
			}
			if (!empty($postData['vat_number'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'vat_number', $postData['vat_number']);
			}
			if (!empty($postData['vat_scheme_type'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'vat_scheme_type', $postData['vat_scheme_type']);
			}
			if (!empty($postData['vat_scheme'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'vat_scheme', $postData['vat_scheme']);
			}
			if (!empty($postData['ret_frequency'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ret_frequency', $postData['ret_frequency']);
			}
			if (!empty($postData['vat_stagger'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'vat_stagger', $postData['vat_stagger']);
			}
		}

		if (!empty($postData['ec_scale_list'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ec_scale_list', $postData['ec_scale_list']);
		}

		if (!empty($postData['tax_div'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_div', $postData['tax_div']);

			if (!empty($postData['tax_reference'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_reference', $postData['tax_reference']);
			}
			if (!empty($postData['tax_reference_type'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_reference_type', $postData['tax_reference_type']);
			}
			if (!empty($postData['other_office_id'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_office_id', $postData['other_office_id']);
			} else {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_office_id', $postData['tax_office_id']);
			}
			if (!empty($postData['tax_address'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_address', $postData['tax_address']);
			}
			if (!empty($postData['tax_zipcode'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_zipcode', $postData['tax_zipcode']);
			}
			if (!empty($postData['tax_telephone'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_telephone', $postData['tax_telephone']);
			}
		}

		if (!empty($postData['paye_reg'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'paye_reg', $postData['paye_reg']);

			if (!empty($postData['cis_registered'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'cis_registered', $postData['cis_registered']);
			}

			if (!empty($postData['acc_office_ref'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'acc_office_ref', $postData['acc_office_ref']);
			}
			if (!empty($postData['paye_reference'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'paye_reference', $postData['paye_reference']);
			}
			if (!empty($postData['paye_district'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'paye_district', $postData['paye_district']);
			}
			if (!empty($postData['employer_office'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'employer_office', $postData['employer_office']);
			}
			if (!empty($postData['employer_postcode'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'employer_postcode', $postData['employer_postcode']);
			}
			if (!empty($postData['employer_telephone'])) {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'employer_telephone', $postData['employer_telephone']);
			}
		}

//#############TAX INFORMATION END###################//
            
            
            
            //#############CONTACT INFORMATION START###################//
		$step_id 	= 3;
		$array 	 	= array("trad", "reg", "corres", "banker", "oldacc", "auditors", "solicitors");
		foreach($array as $key=>$val){//echo $postData['cont_'.$val.'_addr'];die;
			if (isset($postData['cont_'.$val.'_addr']) && $postData['cont_'.$val.'_addr'] != "") {
				$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'cont_'.$val.'_addr', $postData['cont_'.$val.'_addr']);
				if (isset($postData[$val.'_name_check']) && $postData[$val.'_name_check'] != "") {
					$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_name_check', $postData[$val.'_name_check']);

					if (!empty($postData[$val.'_cont_name'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_name', $postData[$val.'_cont_name']);
					}
					if (!empty($postData[$val.'_cont_tele_code'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_tele_code', $postData[$val.'_cont_tele_code']);
					}
					if (!empty($postData[$val.'_cont_telephone'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_telephone', $postData[$val.'_cont_telephone']);
					}
					if (!empty($postData[$val.'_cont_mobile_code'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_mobile_code', $postData[$val.'_cont_mobile_code']);
					}
					if (!empty($postData[$val.'_cont_mobile'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_mobile', $postData[$val.'_cont_mobile']);
					}
					if (!empty($postData[$val.'_cont_email'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_email', $postData[$val.'_cont_email']);
					}
					if (!empty($postData[$val.'_cont_website'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_website', $postData[$val.'_cont_website']);
					}
					if (!empty($postData[$val.'_cont_skype'])) {
						$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_skype', $postData[$val.'_cont_skype']);
					}

				}

				if (!empty($postData[$val.'_cont_addr_line1'])) {
					$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_addr_line1', $postData[$val.'_cont_addr_line1']);
				}
				if (!empty($postData[$val.'_cont_addr_line2'])) {
					$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_addr_line2', $postData[$val.'_cont_addr_line2']);
				}
				if (!empty($postData[$val.'_cont_city'])) {
					$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_city', $postData[$val.'_cont_city']);
				}
				if (!empty($postData[$val.'_cont_county'])) {
					$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_county', $postData[$val.'_cont_county']);
				}
				if (!empty($postData[$val.'_cont_postcode'])) {
					$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_postcode', $postData[$val.'_cont_postcode']);
				}
				if (!empty($postData[$val.'_cont_country'])) {
					$arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_cont_country', $postData[$val.'_cont_country']);
				}

			}
		}

//############# CONTACT INFORMATION END ###################//


//############# RELATIONSHIP START ###################//
		if (!empty($postData['app_hidd_array'])) {
			$relData = array();
			$app_hidd_array = explode(",", $postData['app_hidd_array']); //print_r($app_hidd_array);
			foreach ($app_hidd_array as $row) {
				$rel_row = explode("mpm", $row);
				$relData[] = array(
					'client_id' => $client_id,
					'appointment_with' => $rel_row['0'],
					'appointment_date' => date("Y-m-d H:i:s", strtotime($rel_row['1'])),
					'relationship_type_id' => $rel_row['2'],
				);
			}
			ClientRelationship::insert($relData);

		}
//#############RELATIONSHIP END ###################//

//############# OTHERS INFORMATION START ###################//
		$step_id = 5;
		if (!empty($postData['bank_name'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_name', $postData['bank_name']);
		}
		if (!empty($postData['bank_short_code'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_short_code', $postData['bank_short_code']);
		}
		if (!empty($postData['bank_acc_no'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_acc_no', $postData['bank_acc_no']);
		}
		if (!empty($postData['bank_mark_source'])) {
			$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_mark_source', $postData['bank_mark_source']);
		}
//############# OTHERS INFORMATION END ###################//
        StepsFieldsClient::insert($arrData);
        
         return Redirect::to('/invitedclient-relationship');
        
        echo "<pre>"; print_r($arrData);die();
        
        
        
    }
    
    
    
    
    
    
    public function search_invited_client() {
        //die('search_invited_client');
		$data = array();
		$admin_s = Session::get('admin_details'); // session
		//$user_id = $admin_s['id']; //session user id
		$user_id = 10;
		$postData = Input::all();
        
		//$search_value = $postData['search_value'];

		echo $client_ids = Client::where("type", "=", "org")->where('user_id', '=', $user_id)->select("client_id")->get();
        
        foreach($client_ids as $key=>$client_id){
                //$data['b_name']=$client_id; die();
            //echo $client_id;
           echo $data['b_name'] = StepsFieldsClient::where('client_id', '=', $client_id->client_id)->where('field_name', '=', 'business_name')->select("field_value")->get(); 
            echo $this->last_query();
        }
       
		
	//die; 
    }
    
    
    public function tsxreturninfromation($client_id, $type_id,$page_open, $tax_year)
    {
      $session 	= Session::get('admin_details');
			$user_id 	= $session['id'];
			$user_type 	= $session['user_type'];
      $groupUserId = $session['group_users'];

      $data['client_id'] 			= $client_id;        
      $data['encoded_page_name'] 	= $type_id;
      $data['page_name'] 			= base64_decode($type_id);
      $data['page_open'] 			= $page_open;
      $data['TAXYEAR'] 			= str_replace('-', '/', $tax_year);
			$data['heading'] 			= "TAX RETURN INFORMATION";
			//$data['client_id'] 			= $session['client_id'];
			$value = $data['client_id']."="."function";
        
      if(isset($user_type) && $user_type == "C"){
        $data['previous_page'] = '<a href="/client-portal">Client Portal</a>';
				$data['title']          = "Tax Return";
      }else{
        $data['previous_page'] = '<a href="/jobs-dashboard">Task Management</a>';
        $data['sub_url'] = '<a href="/jobs/7/'.base64_encode('1').'/'.base64_encode('all').'">Income Tax Returns</a>';
        $data['title']          = "View data";
      }
        
        
			$data['rel_types'] 	= RelationshipType::where("show_status", "=", "individual")->orderBy("relation_type_id")->get();
	
    	$data['marital_status'] = MaritalStatus::orderBy("marital_status_id")->get();
			$data['titles'] 				= Title::orderBy("title_id")->get();
			$data['tax_office'] = TaxOfficeAddress::select("parent_id", "office_id", "office_name")->get();
			$data['tax_office_by_id'] 	= TaxOfficeAddress::where("office_id", "=", 1)->first();
			$data['steps'] 							= Step::where("status", "old")->orderBy("step_id")->get();
			$data['substep'] 						= Step::whereIn("user_id", $groupUserId)->where("client_type", "ind")->where("parent_id", 1)->orderBy("step_id")->get();//echo $this->last_query();
			//$data['responsible_staff'] 	= $this->get_responsible_staff();
			$data['countries'] 			= Country::orderBy('country_name')->get();
			$data['nationalities'] 	= Nationality::get();
			$data['field_types'] 		= FieldType::get();
			//$data['cont_address'] 		= $this->get_contact_address();

			//$data['allClients'] 		= $this->get_all_clients();

			$data['old_services'] 	= Service::where("status", "old")->where("client_type", "ind")->orderBy("service_name")->get();
			$data['new_services'] 	= Service::where("status", "new")->where("client_type", "ind")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
        
        //$data['old_clienttax'] 	= Clienttaxreturn::where("status", "=", "old")->select("*")->get();
		
      $clienttaxpdf 	= Clienttaxpdf::where("client_id", "=", $client_id)->select("*")->get();
      
      //echo '<pre>';print_r($clienttaxpdf);die;
      
      
       
      if (!empty($clienttaxpdf)) {
          foreach ($clienttaxpdf as $key => $val) {
				$data2[$key]['clienttaxpdf_id'] = $val['clienttaxpdf_id'];
                $data2[$key]['client_id'] = $val['client_id'];
                $data2[$key]['level'] = $val['level'];
                $data2[$key]['file'] = $val['file'];
                $data2[$key]['created'] = $val['created'];
            }
            //echo $val;die();
            if (!empty($data2)) {
                $data['clienttax_pdf'] = $data2;
            }
        }
        
        
       $steps_fields_users = StepsFieldsAddedUser::whereIn("user_id", $groupUserId)->where("substep_id", "=", '0')->where("client_type", "=", "ind")->get();
		foreach ($steps_fields_users as $key => $steps_fields_row) {
			$steps_fields_users[$key]->select_option = explode(",", $steps_fields_row->select_option);
		}
		$data['steps_fields_users'] = $steps_fields_users;

		//###########User added section and sub section start##########//
		$steps = array();
		$subsections = Step::whereIn("user_id", $groupUserId)->where("status", "=", "new")->get();
		//echo $this->last_query();die;
		foreach ($subsections as $key => $val) {
			if (isset($val->status) && $val->status == "new") {
				$steps[$key]['step_id'] 	= $val->step_id;
				$steps[$key]['parent_id'] 	= $val->parent_id;
				$steps[$key]['short_code'] 	= $val->short_code;
				$steps[$key]['title'] 		= $val->title;
				$steps[$key]['status'] 		= $val->status;
			}

		}
		$data['subsections'] = $this->buildtree($steps, "ind");
        
        $data['relationship'] = Common::get_relationship_client($client_id);
		//echo $this->last_query();die;
		$data['acting'] = Common::get_acting_client($client_id);
		$data['acting_dropdown'] = $this->get_acting_dropdown($data['relationship'], $data['acting']);

		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->
			select("field_id", "field_name", "field_value")->get();

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

		$data['services_id'] 	= Client::getServicesIdByClient($client_id);
		$data['taxreturn_year']	= Common::AjaxGetTaxyear();
        

		if($page_open == 2 || $page_open == 21 || $page_open == 22){
			$data['checklist'] = TaxReturnChecklist::detailsByTaxYearAndServiceId($data['TAXYEAR'], 7, $client_id);
		}
        if($page_open == 22){
			//$data['client_files'] = ClientFile::detailsByClientId($client_id);
            $data['client_docs'] = Clienttaxpdf::getDocumentByClientId($client_id);
		}
        $data['checklist_docs'] = TaxReturnChecklist::detailsByTaxYear($data['TAXYEAR'], 7);
        
		//###########User added section and sub section start##########//

		//echo "<pre>";print_r($data['checklist']);die;
		//echo $this->last_query();die;
        
        return View::make('Invitedclient.taxreturn', $data);
    }
    
	public function get_responsible_staff()
	{
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

		$resp_staff 	= User::whereIn("user_id", $groupUserId)->where("client_id", "=", 0)->select('fname', 'lname', 'user_id')->get();
		foreach ($resp_staff as $key => $value) {
			$data[$key]['user_id'] 	= $value->user_id;
			$data[$key]['fname'] 	= isset($value->fname)?$value->fname:"";
			$data[$key]['lname'] 	= isset($value->lname)?$value->lname:"";
			
		}

		return $data;
	}
    
   
	public function get_contact_address() {
		$client_data = array();

		$admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id']; //session user id
		$groupUserId = $admin_s['group_users'];

        if(isset($groupUserId)){
			$client_ids = Client::select("client_id")->where('is_deleted', '=', "N")->where("type", "=", "ind")->whereIn('user_id', $groupUserId)->get();
        }

		
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];

		$client_ids = Client::where('is_deleted', '=', "N")->where('type', '=', "ind")->whereIn('user_id', $groupUserId)->select("client_id")->get();

		$i = 0;
		if (isset($client_ids)) {
			foreach($client_ids as $key=>$client_id) {
			$client_details = StepsFieldsClient::where('client_id', '=', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();
             
             	$client_data[$i]['client_id'] = $client_id->client_id;
				//echo $this->last_query();//die;

				if (isset($client_details) && count($client_details) > 0) {
				    foreach ($client_details as $client_row) {
						if(isset($client_row['field_name']) && $client_row['field_name'] == "res_addr_line1"){
					       $client_data[$i]['res_addr_line1'] = $client_row['field_value'];
                        }
                        if(isset($client_row['field_name']) && $client_row['field_name'] == "serv_addr_line1"){
					       $client_data[$i]['serv_addr_line1'] = $client_row['field_value'];
                        }
                       
					}
				}
                $i++;
			}
		}
		//echo "<pre>";print_r($client_data);die;
		return $client_data;
	}
    
	public function get_all_clients() {
		$client_details = array();
		$clients = array();

		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];
		
		$search_value = Input::get("search_value");
		$client_ids = Client::whereIn('user_id', $groupUserId)->where('is_deleted', '=', "N")->where("is_archive", "=", "N")->where("type", "!=", "non")->select("client_id")->get();
		//echo $this->last_query();die;
		if(isset($client_ids) && count($client_ids) >0 ){
			foreach($client_ids as $key=>$client_id){
				$clients[$key]['client_id']	= $client_id->client_id;
			}
		}
		//echo $this->last_query();die;
		$org_client = $this->getOrgClient($clients, $search_value);
		$ind_client = $this->getIndClient($clients, $search_value);
		//$chd_client = $this->getChdClient($clients, $search_value);
		$client_details = array_merge($org_client, $ind_client);//print_r($client_details);die;
		//$client_details = $this->getUniqueArray($client_details);

		/*========================Short By Create Time Portion==============================*/
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $value){
			$client_name[]  = strtolower($value['client_name']); //Creates $volume, $edition, $name and $type arrays.
			} 
			array_multisort($client_name, SORT_ASC, $client_details);
		}
		
		//print_r($client_details);die;
		/*=======================Short By Create Time Portion===============================*/

		return $client_details;
		exit();
	}

    function getOrgClient($client_ids, $search_value)
	{
		$clients = array();
		//$client_name = StepsFieldsClient::where("field_value", "like", '%' . $search_value . '%')->where('field_name', '=', 'business_name')->whereIn('client_id', $client_ids)->select("field_value", "client_id")->get();
		$client_name = StepsFieldsClient::where('field_name', '=', 'business_name')->whereIn('client_id', $client_ids)->select("field_value", "client_id")->get();

		if(isset($client_name) && count($client_name) >0 ){
			foreach($client_name as $key=>$name){
				$clients[$key]['client_id']		= $name->client_id;
				$clients[$key]['client_name']	= $name->field_value;
			}
		}
		//echo $this->last_query();die;
		return $clients;
	}
	function getIndClient($client_ids, $search_value)
	{
		$clients = array();
		//$client_name = StepsFieldsClient::where("field_value", "like", '%' . $search_value . '%')->where('field_name', '=', 'client_name')->whereIn('client_id', $client_ids)->select("field_value", "client_id")->get();
		$client_name = StepsFieldsClient::where('field_name', '=', 'client_name')->whereIn('client_id', $client_ids)->select("field_value", "client_id")->get();

		if(isset($client_name) && count($client_name) >0 ){
			foreach($client_name as $key=>$name){
				$clients[$key]['client_id']		= $name->client_id;
				$clients[$key]['client_name']	= $name->field_value;
			}
		}
		//echo $this->last_query();die;
		return $clients;
	}
    public function buildtree($steps, $client_type) 
    {
		$branch = array();
		foreach ($steps as $element) {
			$children = StepsFieldsAddedUser::where("substep_id", "=", $element['step_id'])->where("client_type", "=", $client_type)->get();
			foreach ($children as $key => $steps_fields_row) {
				$children[$key]->select_option = explode(",", $steps_fields_row->select_option);
			}
			if (isset($children) && count($children) > 0) {
				foreach ($children as $key => $row) {
					$element['children'][$key]['field_id'] 		= $row->field_id;
					$element['children'][$key]['user_id'] 		= $row->user_id;
					$element['children'][$key]['step_id'] 		= $row->step_id;
					$element['children'][$key]['field_type'] 	= $row->field_type;
					$element['children'][$key]['field_name'] 	= $row->field_name;
					$element['children'][$key]['field_value'] 	= $row->field_value;
					$element['children'][$key]['select_option'] = $row->select_option;
					$element['children'][$key]['client_type'] 	= $row->client_type;
				}
				$branch[] = $element;
			}

		}
		return $branch;
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
    
    
    public function pdfclientupload()
    {
    	$arrData 	= array();
        $file_data 	= array();

    	$session 	= Session::get('admin_details');
		$user_id 	= $session['id'];
		$user_type 	= $session['user_type'];
		$client_id	= $session['client_id'];

        $input 		= Input::all();
        $action		= $input['action'];
        $service_id	= $input['service_id'];
        $tax_year	= $input['tax_year'];

        $data['user_id']        = $user_id;
        $data['service_id']     = $service_id;
        $data['tax_year']       = $tax_year;

        $details = TaxReturnChecklist::detailsByTaxYearAndServiceId($tax_year, $service_id, $client_id);
        if(isset($details) && count($details) >0){
            $last_id = $details['checklist_id'];
        }else{
            $data['created']    = date('Y-m-d H:i:s');
            $data['client_id']  = $client_id;
            $last_id = TaxReturnChecklist::insertGetId($data);
        }

        if($action == 'upload'){
        	$Name = '';
            //////////////////file upload start//////////////////
            if (Input::hasFile('add_pdffile')) {
                $file = Input::file('add_pdffile');
                $destinationPath = 'uploads/client_doc/';
                $Name = Input::file('add_pdffile')->getClientOriginalName();
                $fileName = $Name;
                $result = Input::file('add_pdffile')->move($destinationPath, $fileName);

                $doc_data['client_id']  	= $client_id;
                $doc_data['file']  			= $fileName;
                $doc_data['checklist_id']   = $last_id;
                $doc_data['created']   		= date('Y-m-d H:i:s');
                Clienttaxpdf::insertGetId($doc_data);
            }
            /////////////////file upload end////////////////////
        }       
    
    	$arrData['id'] 			= $last_id;
    	$arrData['file_name'] 	= $Name;
    	$arrData['client_id'] 	= $client_id;
    	$arrData['tax_year']    = $tax_year;

        echo json_encode($arrData);
		die;
    }
    
    public function pdfclientdelete()
    {
        $delid = Input::get("delid");       
        if (Request::ajax()) {
            $clienttaxpdf_id = Clienttaxpdf::where("clienttaxpdf_id","=",$delid)->delete();
            echo $delid;
        }
    }
    
    
    
    public function notessave(){
        
        $notes_data=array();
        $level = Input::get("level");
        $note = Input::get("note");
        $session 	= Session::get('admin_details');
        $user_id 	= $session['id'];
        $user_type 	= $session['user_type'];
        $client_id		= $session['client_id'];

        $notes_data['client_id'] = $client_id;
        $notes_data['note'] = $note;
        $notes_data['level'] = $level;
            
        $clienttaxnote_id = Clienttaxnote::insertGetId($notes_data);
        echo $clienttaxnote_id;die();        
        
    }


    public function ajax_client_details()
    {
    	$data = array();
    	$session = Session::get('admin_details');
		$user_id = $session['client_id'];

		$client_id = Input::get("client_id");
		$data['client_details'] 		= Common::clientDetailsById($client_id);
		$data['logged_client_details'] 	= Common::clientDetailsById($user_id);

		$acc_details = JobsAccDetail::getDetailsByClientId($client_id);
        $data['client_details']['jobs_acc_details'] = $acc_details;

        $filling_online = '31/01/'. date('Y', strtotime('+1 year'));
        $data['client_details']['incometax_deadline'] = Common::getDayCount($filling_online);
        $data['client_details']['business_deadline'] = Common::getDayCount($filling_online);

        if(isset($data['client_details']['type']) && $data['client_details']['type'] == 'ind'){
        	$btaxdue = 'N/A';
        	$bdeadline = 'N/A';
        }else{
        	if(isset($data['client_details']['next_acc_due']) && $data['client_details']['next_acc_due'] != ""){
				$btaxdue1 	= $data['client_details']['next_acc_due'];
        		//$btaxdue2 	= date("d-m-Y", strtotime("+9 month", strtotime($btaxdue1)));
        		$btaxdue 	= date("d/m/Y", strtotime("+1 day", strtotime($btaxdue1)));

        		$bdeadline = Common::getDayCount($btaxdue);
        	}else{
        		$btaxdue = 'N/A';
        		$bdeadline = 'N/A';
        	}
        }
        $data['client_details']['business_deadline'] 	= $btaxdue;
        $data['client_details']['bdeadline'] 			= $bdeadline;

		//echo "<pre>";print_r($data);
		echo View::make("Invitedclient.ajax_organisation_details", $data);
    }

    public function get_taxreturn_details()
    {
        $data = array();
        $input          = Input::get();
        $service_id     = $input['service_id'];
        $tax_year       = $input['tax_year'];
        $data['details'] = TaxReturnChecklist::detailsByTaxYearAndServiceId($tax_year, $service_id);

        echo json_encode($data);
        exit;
    }

    public function update_checklist()
    {
        $data 			= array();
        $session 		= Session::get('admin_details');
		$user_id 		= $session['id'];

        $input          = Input::get();
        $service_id     = $input['service_id'];
        $client_id      = $input['client_id'];
        $field_name     = $input['field_name'];
        $field_value    = $input['field_value'];
        $checklist_id   = $input['checklist_id'];
        $tax_year   	= $input['tax_year'];

        $data[$field_name] = $field_value;
        $details = TaxReturnChecklist::detailsByTaxYearAndServiceId($tax_year, $service_id, $client_id);
        if(isset($details) && count($details) >0){
        	TaxReturnChecklist::where('checklist_id', '=', $checklist_id)->update($data);
        }else{
        	$data['user_id'] 	= $user_id;
            $data['client_id'] 	= $client_id;
        	$data['service_id'] = $service_id;
        	$data['tax_year'] 	= $tax_year;
        	$data['created'] 	= date('Y-m-d H:i:s');
        	TaxReturnChecklist::insert($data);
        }

        echo json_encode($data);
        exit;
    }

    public function save_messages()
    {
        $data = array();
        $session 		= Session::get('admin_details');
		$user_id 		= $session['id'];

        $input          = Input::get();
        $service_id     = $input['service_id'];
        $tax_year       = $input['tax_year'];
        $reply_id       = $input['reply_id'];
        $client_id      = $input['client_id'];
        
        $to_user_id = User::getUserIdByClientId($client_id);

        $details = TaxReturnChecklist::detailsByTaxYearAndServiceId($tax_year, $service_id, $client_id);
        if(isset($details) && count($details) >0){
        	$last_id = $details['checklist_id'];
        }else{
        	$data['user_id'] 	= $user_id;
            $data['client_id'] 	= $client_id;
        	$data['service_id'] = $service_id;
        	$data['tax_year'] 	= $tax_year;
        	$data['created'] 	= date('Y-m-d H:i:s');
        	$last_id = TaxReturnChecklist::insertGetId($data);
        }

        $msgData['checklist_id'] 	= $last_id;
        $msgData['service_id'] 		= $service_id;
        $msgData['from_user_id'] 	= $user_id;
        $msgData['to_user_id'] 		= $to_user_id;
        $msgData['subject'] 		= $input['subject'];
        $msgData['message'] 		= $input['message'];
        $msgData['reply_id'] 		= $input['reply_id'];
        $msgData['created'] 		= date('Y-m-d H:i:s');
        
        $message_id = TaxreturnMessage::insertGetId($msgData);
        $msgData['created']     = date('M d, Y', strtotime($msgData['created']));
        
        $value = TaxreturnMessage::getDetailsByMessageId($message_id);
        if(isset($value['reply_id']) && $value['reply_id'] =='0'){
            $msgData['message_id']  = $message_id;
        }else{
            $msgData['message_id']  = $value['reply_id'];
        }
        
        $details = User::where("user_id", "=", $user_id)->select("fname", "lname", "client_id")->first();
        if(isset($details['client_id']) && $details['client_id'] == '0'){
            $from_name = User::getStaffNameById($user_id);
        }else{
            $from_name = Client::getClientNameByClientId($details['client_id']);
        }
        $msgData['from_bladge'] 	= Client::get_initial_badge($from_name);
        
        echo json_encode($msgData);
        exit;
    }

    public function action_messages()
    {
    	$input          = Input::get();
        $message_id     = $input['message_id'];
        $action     	= $input['action'];
        if($action == 'delete'){
        	TaxreturnMessage::where('message_id', '=', $message_id)->delete();
        }
        
        echo 1;
    }
    
    

}