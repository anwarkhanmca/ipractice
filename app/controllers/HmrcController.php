<?php
class HmrcController extends BaseController {
	public function __construct() {
		parent::__construct();
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login')->send();
		}
		
	}
	

	public function hmrc() {
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}

		$data['heading'] = "HMRC";
		$data['title'] = "HMRC";
		/*if (base64_decode($type) == 'profile') {
		$data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
		} else {
		$data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
		}
		$data['staff_type'] = base64_decode($type);*/

		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];

		return View::make('hmrc.hmrc', $data);
	}

	/*public function authorisations($page_open) 
	{
		$client_data 	= array();
		$clienttype 	= array();
		$data['heading'] 		= "FORMS";
		$data['title'] 			= "Forms";
        $data['page_open']		= $page_open;
		$data['previous_page'] 	= '<a href="/hmrc">HMRC</a>';

		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$data['user_type'] 	= $session['user_type'];
		$groupUserId 		= $session['group_users'];

		//$data['allClients'] 	 	= App::make("HomeController")->get_all_clients();
        
        $data['titles'] = Title::orderBy("title_id")->get();
		$client_details = Client::getAllClientDetails();
		
       // echo $this->last_query();die();
		//echo '<pre>';print_r($client_details);die();
		if (isset($client_details) && count($client_details) > 0) {
			foreach ($client_details as $key => $client_row) {
				$client_data[$key]['client_id'] = $client_row['client_id'];
				if(isset($client_row['client_type']) && $client_row['client_type'] == "org"){
					$client_data[$key]['client_name'] = $client_row['business_name'];
					$client_data[$key]['contact_type'] = "Business";
					$client_data[$key]['client_url'] = "/client/edit-org-client/".$client_row['client_id']."/".base64_encode('org_client');
					$client_data[$key]['email'] = isset($client_row['corres_cont_email']) ? $client_row['corres_cont_email']:"";
					$client_data[$key]['telephone'] = isset($client_row['corres_cont_telephone'])?$client_row['corres_cont_telephone']:"";
					$client_data[$key]['mobile'] = isset($client_row['corres_cont_mobile']) ? $client_row['corres_cont_mobile']:"";
					$client_data[$key]['corres_address'] = isset($client_row['corres_address'])?$client_row['corres_address']:"";
					$client_data[$key]['contact_name'] = $this->getContactNameDropdown($client_row);

					$client_data[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'Business');
				}else if(isset($client_row['client_type']) && $client_row['client_type']=="ind"){
					$client_data[$key]['client_name'] = $client_row['client_name'];
					$client_data[$key]['contact_type'] = "Individual";
					$client_data[$key]['client_url'] = "/client/edit-ind-client/" . $client_row['client_id'] ."/" . base64_encode('ind_client');
					$client_data[$key]['email'] = isset($client_row['serv_email']) ? $client_row['serv_email'] :"";
					$client_data[$key]['telephone'] = isset($client_row['serv_telephone']) ? $client_row['serv_telephone'] :"";
					$client_data[$key]['mobile'] = isset($client_row['serv_mobile']) ? $client_row['serv_mobile'] :"";
					$client_data[$key]['corres_address'] = isset($client_row['address']) ? $client_row['address'] :"";
					$client_data[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'],'Individual');
				}

			}

		}
            
        $data['client_details'] = $client_data;

		foreach ($data['client_details'] as $value) {
			$clienttype[] = $value['client_name'];
		}
		array_multisort($clienttype, SORT_ASC, $data['client_details']);
		
  		$data['username'] = User::where("user_id","=", $user_id)->select("fname", "lname","user_id","email")->first();
        //echo '<pre>';print_r($data['username']['fname']);die();
		$data["practice_details"] = PracticeDetail::whereIn("user_id", $groupUserId)->first();

		//echo $this->last_query();die;
		if (isset($data["practice_details"]) && count($data["practice_details"]) > 0) {
			$data["practice_details"]['telephone_no'] = $data["practice_details"]['telephone_no'];
			$data["practice_details"]['fax_no'] = $data["practice_details"]['fax_no'];
			$data["practice_details"]['mobile_no'] = $data["practice_details"]['mobile_no'];

			$practice_addresses = PracticeAddress::where("practice_id", "=", $data["practice_details"]['practice_id'])->get();
            
			foreach ($practice_addresses as $pa_row) {
				if ($pa_row->type == "registered") {
					$data["practice_address"]['reg_address_id'] 	= $pa_row->address_id;
					$data["practice_address"]['reg_practice_id'] 	= $pa_row->practice_id;
					$data["practice_address"]['reg_type'] 			= $pa_row->type;
					$data["practice_address"]['reg_attention'] 		= $pa_row->attention;
					$data["practice_address"]['reg_street_address'] = $pa_row->street_address;
					$data["practice_address"]['reg_city'] 			= $pa_row->city;
					$data["practice_address"]['reg_state'] 			= $pa_row->state;
					$data["practice_address"]['reg_zip'] 			= $pa_row->zip;
					$data["practice_address"]['reg_country_id'] 	= $pa_row->country_id;
				}
				if ($pa_row->type == "physical") {
					$data["practice_address"]['phy_address_id'] 	= $pa_row->address_id;
					$data["practice_address"]['phy_practice_id'] 	= $pa_row->practice_id;
					$data["practice_address"]['phy_type'] 			= $pa_row->type;
					$data["practice_address"]['phy_attention'] 		= $pa_row->attention;
					$data["practice_address"]['phy_street_address'] = $pa_row->street_address;
					$data["practice_address"]['phy_city'] 			= $pa_row->city;
					$data["practice_address"]['phy_state'] 			= $pa_row->state;
					$data["practice_address"]['phy_zip'] 			= $pa_row->zip;
					$data["practice_address"]['phy_country_id'] 	= $pa_row->country_id;
				}
			}

			if (isset($data["practice_address"])){
				$data["ch_logins"] = ChLogin::getDetailsByPracticeId($data["practice_details"]['practice_id']);
				$reg_countries= Country::where("country_id", "=", $data['practice_address']['phy_country_id'])->select("country_name")->first();

				// echo '<pre>';print_r($data["practice_address"]);die();
				$data['phy_country_name']=$reg_countries['country_name'];
			}

		}
        
        $fullphyaddress = "";
        
        if (isset($data['practice_address']['phy_street_address']) ){
            $fullphyaddress=$data['practice_address']['phy_street_address'].',';
        }
        if (isset($data['practice_address']['phy_city']) ){
            $fullphyaddress .=$data['practice_address']['phy_city'].',';
        }
        if (isset($data['practice_address']['phy_state']) ){
            $fullphyaddress .=$data['practice_address']['phy_state'].',';
        }
         
        //echo '<pre>';print_r($fullphyaddress);die();
        
        $data['pysicaladdress'] = $fullphyaddress;
        
		$AllIndclient_details 	= Client::getAllIndClientDetails();
		if(count($AllIndclient_details)>0){
			$data['indclient']		= $AllIndclient_details;
			foreach ($data['indclient'] as $value) {
				$clientindtype[] = $value['client_name'];
			}
			array_multisort($clientindtype, SORT_ASC, $data['indclient']);
		}else{
			$data['indclient'] = array();
		}
		
		
  		$Allorgclient_details = Client::getAllOrgClientDetails();
		if(count($Allorgclient_details)>0){
			$data['orgclient']=$Allorgclient_details;
			$clientorgype = array();
			foreach ($data['orgclient'] as $value) {
				$clientorgype[] = $value['business_name'];
			}
			array_multisort($clientorgype, SORT_ASC, $data['orgclient']);
		}else{
			$data['orgclient'] = array();
		}
        

		$data["practices"] = PracticeDetail::getPracticeDetailsData();

        //echo '<pre>';print_r($data['practice_address']);die();
       return View::make('hmrc.authorisations', $data);
	}*/

	public function authorisations($page_open) 
	{
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}

		$client_data 	= $dc = $clienttype = array();
		$data['heading'] 				= "FORMS";
		$data['title'] 					= "Forms";
    $data['page_open']			= $page_open;
		$data['previous_page'] 	= '<a href="/onboard">Onboarding</a>';

		$session 						= Session::get('admin_details');
		$user_id 						= $session['id'];
		$data['user_type'] 	= $session['user_type'];
		$groupUserId 				= $session['group_users'];

		$data['titles'] 				= Title::orderBy("title_id")->get();
		$data['client_details'] = Client::getClientNameAndId();

		/*foreach ($data['client_details'] as $value) {
			$clienttype[] = $value['client_name'];
		}
		array_multisort($clienttype, SORT_ASC, $data['client_details']);*/
		
  	$data['username'] = User::where("user_id", $user_id)->select("fname", "lname","user_id","email")->first();
		$data["practice_details"] = PracticeDetail::whereIn("user_id", $groupUserId)->first();

		//echo $this->last_query();die;
		if (isset($data["practice_details"]) && count($data["practice_details"]) > 0) {
			$data["practice_details"]['telephone_no'] = $data["practice_details"]['telephone_no'];
			$data["practice_details"]['fax_no'] 			= $data["practice_details"]['fax_no'];
			$data["practice_details"]['mobile_no'] 		= $data["practice_details"]['mobile_no'];

			$practice_addresses = PracticeAddress::where("practice_id", $data["practice_details"]['practice_id'])->get();
            
			foreach ($practice_addresses as $pa_row) {
				$country_name = Country::getCountryNameByCountryId($pa_row->country_id);
				$address = $pa_row->address_line1.' '.$pa_row->address_line2;
				if ($pa_row->type == "registered") {
					$data["practice_address"]['reg_address_id'] 	= $pa_row->address_id;
					$data["practice_address"]['reg_practice_id'] 	= $pa_row->practice_id;
					$data["practice_address"]['reg_type'] 				= $pa_row->type;
					$data["practice_address"]['reg_attention'] 		= $pa_row->attention;
					$data["practice_address"]['reg_address1'] 		= $pa_row->address_line1;
					$data["practice_address"]['reg_address2'] 		= $pa_row->address_line2;
					$data["practice_address"]['reg_city'] 				= $pa_row->city;
					$data["practice_address"]['reg_state'] 				= $pa_row->state;
					$data["practice_address"]['reg_zip'] 					= $pa_row->zip;
					$data["practice_address"]['reg_country_id'] 	= $pa_row->country_id;
					$data["practice_address"]['reg_country_name'] = $country_name;
				}
				if ($pa_row->type == "physical") {
					$data["practice_address"]['phy_address_id'] 	= $pa_row->address_id;
					$data["practice_address"]['phy_practice_id'] 	= $pa_row->practice_id;
					$data["practice_address"]['phy_type'] 				= $pa_row->type;
					$data["practice_address"]['phy_attention'] 		= $pa_row->attention;
					$data["practice_address"]['phy_address1'] 		= $pa_row->address_line1;
					$data["practice_address"]['phy_address2'] 		= $pa_row->address_line2;
					$data["practice_address"]['phy_city'] 				= $pa_row->city;
					$data["practice_address"]['phy_state'] 				= $pa_row->state;
					$data["practice_address"]['phy_zip'] 					= $pa_row->zip;
					$data["practice_address"]['phy_country_id'] 	= $pa_row->country_id;
					$data["practice_address"]['phy_country_name'] = $country_name;
				}
			}

			if (isset($data["practice_address"])){
				$data["ch_logins"]=ChLogin::getDetailsByPracticeId($data["practice_details"]['practice_id']);
				$country = Country::getCountryNameByCountryId($data['practice_address']['phy_country_id']);
				$data['phy_country_name'] = $country;
			}

		}
        
    /*$fullphyaddress = "";
    
    if (isset($data['practice_address']['phy_address1']) ){
        $fullphyaddress .= $data['practice_address']['phy_address1'].',';
    }
    if (isset($data['practice_address']['phy_address2']) ){
        $fullphyaddress .= $data['practice_address']['phy_address2'].',';
    }
    if (isset($data['practice_address']['phy_city']) ){
        $fullphyaddress .= $data['practice_address']['phy_city'].',';
    }
    if (isset($data['practice_address']['phy_state']) ){
        $fullphyaddress .= $data['practice_address']['phy_state'];
    }
    $data['pysicaladdress'] = $fullphyaddress;*/
        
		/*$AllIndclient_details 	= Client::getAllIndClientDetails();
		if(count($AllIndclient_details)>0){
			$data['indclient']		= $AllIndclient_details;
			foreach ($data['indclient'] as $value) {
				$clientindtype[] = $value['client_name'];
			}
			array_multisort($clientindtype, SORT_ASC, $data['indclient']);
		}else{
			$data['indclient'] = array();
		}*/
		
		
  	/*$Allorgclient_details = Client::getAllOrgClientDetails();
		if(count($Allorgclient_details)>0){
			$data['orgclient']=$Allorgclient_details;
			$clientorgype = array();
			foreach ($data['orgclient'] as $value) {
				$clientorgype[] = $value['business_name'];
			}
			array_multisort($clientorgype, SORT_ASC, $data['orgclient']);
		}else{
			$data['orgclient'] = array();
		}*/

		$orgclient = Client::getClientNameAndIdByType('org');
		if(isset($orgclient) && count($orgclient) >0){
			foreach ($orgclient as $k => $v) {
				$bt = StepsFieldsClient::getFieldValueByClientId($v['client_id'], 'business_type');
				$dc[$k]['client_id'] 			= $v['client_id'];
				$dc[$k]['business_type'] 	= OrganisationType::getNameById($bt);
				$dc[$k]['business_name'] 	= $v['client_name'];
			}
		}
    
    $data["pysicaladdress"] 	= PracticeDetail::getAddressByType('physical');  
		$data['indclient'] 				= Client::getClientNameAndIdByType('ind');
		$data['orgclient'] 				= $dc;
		$data["practices"] 				= PracticeDetail::getPracticeDetailsData();

    //echo '<pre>';print_r($data);die();
    return View::make('hmrc.authorisations', $data);
	}

	public function generate_form($client_id)
	{
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 	= $session['group_users'];
		if (isset($session['user_type']) && $session['user_type'] != "C") {
			Redirect::to('/dashboard')->send();
		}

		$data['heading'] 				= "FORM 64-8 (AGENT AUTHORISATION)";
		$data['title'] 					= "Generate Forms";
    $data['client_id']			= $client_id;
    $link 									= '/client/edit-ind-client/'.$client_id.'/'.base64_encode('ind_client');
		$data['previous_page'] 	= '<a href="'.$link.'">Edit User</a>';

		$data['relationship'] 		= Common::get_relationship_client($client_id);
		$data['indclient'] 				= Client::getClientNameAndIdByType('ind');
		$data['orgclient'] 				= Client::getClientNameAndIdByType('org');
		$data["practices"] 				= PracticeDetail::getPracticeDetailsData();
		$data["pysicaladdress"] 	= PracticeDetail::getAddressByType('physical');
		$data["practice_details"] = PracticeDetail::whereIn("user_id", $groupUserId)->first();
		$data["practice_address"] = PracticeAddress::getPracticeAddress();

		//echo "<pre>";print_r($data["practice_address"]);die;
		return View::make('hmrc.generate_form', $data);
	}

	public function getFormData()
	{
		require_once('fpdf/fpdf.php'); 
		require_once('fpdi/fpdi.php');
		$pdf = new FPDI();
		$pdf->AddPage();
    $FormData = Input::all();     
				
   	/***************Form2****************************/
    if(isset($FormData['table_clientID2']) && $FormData['table_clientID2'] != NULL){
			$payereferencesamll = str_split($FormData['tab2payereferencesamll']);
			$payereference 			= str_split($FormData['tab2payereference']);

			$accountofficereferencesmall 	= str_split($FormData['tab2accountofficereferencesmall']);
			$accountofficereference 			= str_split($FormData['tab2accountofficereference']);

			$first_chr = $accountofficereference[0];
			if(!is_numeric($first_chr))
				$check_char =  array_shift($accountofficereference);

			$Agent_post_code = str_split($FormData['postcode_tab2']);

			$Today_date  = str_split(@date('dmY'));

			$Client_details = Common::clientDetailsById($FormData['table_clientID2']);

			$post_split =  explode(" ", $FormData['tab2postcode']);
			$client_post_code_1 = str_split($post_split[0]);
			if (array_key_exists('1', $post_split)){
				$client_post_code_2 = str_split($post_split[1]);
				rsort($client_post_code_2);
			}
			$Agent_govt_gateway_identifier = str_split($FormData['agent_govt_gateway_identifier_tab2']);

			$Agent_paye_id = str_split($FormData['paye_agent_ID_tab2']);
			$Govt_agent_identification_id = str_split($FormData['paye_agent_ID_tab2']);

			$agent_address =  explode(',', $FormData['agent_address_tab2']);

			$employer_address =  explode(',', $FormData['tab2address']);

				
			$pdf-> setSourceFile('forms-pdf/fbi2.pdf');
    
			$tplIdx = $pdf->importPage(1);
			$pdf->useTemplate($tplIdx,0,0,0);
			$pdf->SetFont('Arial','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->setFillColor(255,255,255); 
			/*-----------Employer PAYE reference---------------------*/
			$pdf->SetXY(16,40);
			$pdf->Write(0, @$payereferencesamll[0]);
			$pdf->SetXY(22,40);
			$pdf->Write(0, @$payereferencesamll[1]);
			$pdf->SetXY(28,40);
			$pdf->Write(0, @$payereferencesamll[2]);
			
			$pdf->SetXY(39,40);
			$pdf->Write(0, @$payereference[0]);
			$pdf->SetXY(44,40);
			$pdf->Write(0, @$payereference[1]);
			$pdf->SetXY(50,40);
			$pdf->Write(0, @$payereference[2]);
			$pdf->SetXY(56,40);
			$pdf->Write(0, @$payereference[3]);
			$pdf->SetXY(61,40);
			$pdf->Write(0, @$payereference[4]);
			$pdf->SetXY(66,40);
			$pdf->Write(0, @$payereference[5]);
			$pdf->SetXY(72,40);
			$pdf->Write(0, @$payereference[6]);
			$pdf->SetXY(77,40);
			$pdf->Write(0, @$payereference[7]);
			$pdf->SetXY(82,40);
			$pdf->Write(0, @$payereference[8]);
			$pdf->SetXY(88,40);
			$pdf->Write(0, @$payereference[9]);
			
		/*-----------Accounts Office reference---------------------*/
			$pdf->SetXY(111,40);
			$pdf->Write(0, @$accountofficereferencesmall[0]);
			$pdf->SetXY(117,40);
			$pdf->Write(0, @$accountofficereferencesmall[1]);
			$pdf->SetXY(121,40);
			$pdf->Write(0, @$accountofficereferencesmall[2]);
			
			$pdf->SetXY(135,40);
			$pdf->Write(0, @$check_char);
				
			$pdf->SetXY(143,40);
			$pdf->Write(0, @$accountofficereference[0]);
			$pdf->SetXY(149,40);
			$pdf->Write(0, @$accountofficereference[1]);
			$pdf->SetXY(154,40);
			$pdf->Write(0, @$accountofficereference[2]);
			$pdf->SetXY(160,40);
			$pdf->Write(0, @$accountofficereference[3]);
			$pdf->SetXY(165,40);
			$pdf->Write(0, @$accountofficereference[4]);
			$pdf->SetXY(170,40);
			$pdf->Write(0, @$accountofficereference[5]);
			$pdf->SetXY(176,40);
			$pdf->Write(0, @$accountofficereference[6]);
			$pdf->SetXY(181,40);
			$pdf->Write(0, @$accountofficereference[7]);
			
      /*-----------CLIENT NAME---------------------*/
			$pdf->SetXY(17,70);
			$pdf->Cell(70,0, @$FormData['res_tab2'],0,1,'L',1);
				
			/*-----------AGENT'S NAME---------------------*/
			$pdf->SetXY(17,96);
			$pdf->MultiCell(70,5, @$FormData['agent_name_tab2']);
				
			/*-----------CLIENT'S ONLINE SERVICES---------------------*/
			if (array_key_exists('paye_online_services', $FormData)) 
				$pdf->Image('forms-pdf/seat-checked.png',90, 122, '', '');
				
			/*-----------Construction Industry Scheme---------------------*/
			if (array_key_exists('industry_scheme', $FormData)) 
				$pdf->Image('forms-pdf/seat-checked.png',90, 146, '', '');
			
			/*-----------AGENT'S DETAIL'S---------------------*/
			$pdf->SetXY(111,79);
			$pdf->Cell(70,5, @$agent_address[0]);
			$pdf->SetXY(111,84);
			$pdf->Cell(70,5, @$agent_address[1]);
			$pdf->SetXY(111,90);
			$pdf->Cell(70,5, @$agent_address[2]);
			
			$pdf->SetXY(111,108);
			$pdf->Write(0, @$Agent_post_code[0]);
			$pdf->SetXY(117,108);
			$pdf->Write(0, @$Agent_post_code[1]);
			$pdf->SetXY(122,108);
			$pdf->Write(0, @$Agent_post_code[2]);
			$pdf->SetXY(128,108);
			$pdf->Write(0, @$Agent_post_code[3]);
			$pdf->SetXY(136,108);
			$pdf->Write(0, @$Agent_post_code[4]);
			$pdf->SetXY(142,108);
			$pdf->Write(0, @$Agent_post_code[5]);
			$pdf->SetXY(147,108);
			$pdf->Write(0, @$Agent_post_code[6]);
			$pdf->SetXY(152,108);
			$pdf->Write(0, @$Agent_post_code[6]);
				
			$pdf->SetXY(111,122);
			$pdf->Cell(70,0, @$FormData['agent_contact_name_tab2']);
			$pdf->SetXY(111,136);
			$pdf->Cell(70,0, @$FormData['tel_nub_tab2']);
			$pdf->SetXY(111,151);
			$pdf->Cell(70,0, @$FormData['fax_nbr_tab2']);
			$pdf->SetXY(111,165);
			$pdf->Cell(70,0, @$FormData['agent_email_tab2']);
			
			$pdf->SetXY(111,179);
			$pdf->Write(0, @$Agent_paye_id[0]);
			$pdf->SetXY(117,179);
			$pdf->Write(0, @$Agent_paye_id[1]);
			$pdf->SetXY(122,179);
			$pdf->Write(0, @$Agent_paye_id[2]);
			$pdf->SetXY(128,179);
			$pdf->Write(0, @$Agent_paye_id[3]);
			$pdf->SetXY(133,179);
			$pdf->Write(0, @$Agent_paye_id[4]);
			$pdf->SetXY(139,179);
			$pdf->Write(0, @$Agent_paye_id[5]);
			
			$pdf->SetXY(111,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[0]);
			$pdf->SetXY(117,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[1]);
			$pdf->SetXY(122,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[2]);
			$pdf->SetXY(128,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[3]);
			$pdf->SetXY(133,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[4]);
			$pdf->SetXY(139,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[5]);
			$pdf->SetXY(145,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[6]);
			$pdf->SetXY(150,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[7]);
			$pdf->SetXY(155,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[8]);
			$pdf->SetXY(161,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[9]);
			$pdf->SetXY(166,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[10]);
			$pdf->SetXY(172,198);
			$pdf->Write(0, @$Agent_govt_gateway_identifier[11]);
			
			$pdf->SetXY(111,241);
			$pdf->Write(0, @$Today_date[0]);
			$pdf->SetXY(117,241);
			$pdf->Write(0, @$Today_date[1]);
			$pdf->SetXY(125,241);
			$pdf->Write(0, @$Today_date[2]);
			$pdf->SetXY(130,241);
			$pdf->Write(0, @$Today_date[3]);
			$pdf->SetXY(139,241);
			$pdf->Write(0, @$Today_date[4]);
			$pdf->SetXY(144,241);
			$pdf->Write(0, @$Today_date[5]);
			$pdf->SetXY(149,241);
			$pdf->Write(0, @$Today_date[6]);
			$pdf->SetXY(155,241);
			$pdf->Write(0, @$Today_date[7]);
				
			/*-----------Employer/contractor details---------------------*/
				
				$pdf->SetXY(17,182);
				$pdf->Cell(70,0, $FormData['file_name']);
				$pdf->SetXY(17,202);
				$pdf->Cell(70,0, @$employer_address[0]);
				$pdf->SetXY(17,208);
				$pdf->Cell(70,0, @$employer_address[1]);
				$pdf->SetXY(17,213);
				$pdf->Cell(70,0, @$employer_address[2]);
				
				$pdf->SetXY(17,228);
				$pdf->Cell(0,0,@$client_post_code_1[0]);
				$pdf->SetXY(22,228);
				$pdf->Cell(0,0, @$client_post_code_1[1]);
				$pdf->SetXY(28,228);
				$pdf->Cell(0,0,@$client_post_code_1[2]);
				$pdf->SetXY(33,228);
				$pdf->Cell(0,0, @$client_post_code_1[3]);
				
				$pdf->SetXY(42,228);
				$pdf->Cell(0,0, @$client_post_code_2[3]);
				$pdf->SetXY(47,228);
				$pdf->Cell(0,0,@$client_post_code_2[2]);
				$pdf->SetXY(52,228);
				$pdf->Cell(0,0, @$client_post_code_2[1]);
				$pdf->SetXY(58,228);
				$pdf->Cell(0,0,@$client_post_code_2[0]);
				
				$pdf->Image('forms-pdf/seat-checked.png',70, 236, '', '');	
					
			$pdf->Output("FBI-2_".$FormData['file_name'].'.pdf', 'D'); 
			Exit;
		   }  

	       /************************* Form 1 **********************************/
			 if($FormData['client_id'] != ''){ 
                   		 
			  // $client_details = Client::getAllOrgClientDetails();
			  //$relayth_data = Common::get_relationship_client($FormData['responsible_person']);				
				$clientdtl = Common::clientDetailsById($FormData['client_id']);
				//echo "<pre>"; print_r($clientdtl);die;
				if (array_key_exists('registration_number', $clientdtl))
				$compnay_res_no = str_split($clientdtl['registration_number']);
				
				$individual_number = str_split($FormData['tab1selfninumber']);
				
				$individual_utr_number = str_split($FormData['tab1selfutr']);
				
				$tax_intance_number = isset($FormData['tab1indnum']) ? str_split($FormData['tab1indnum']) : '';
				
				$corporationtaxreference = str_split($FormData['corporationtaxreference']); 
				 $Agent_code = '';
			    if (array_key_exists('selfassessmentid', $FormData))
			         $Agent_code .=  $FormData['sa_agent_id']."; ";
				if (array_key_exists('corporation_tax', $FormData))
					 $Agent_code .=  $FormData['ct_agent_id'].'; ';
				if (array_key_exists('paye_scheme', $FormData))
					 $Agent_code .=  $FormData['paye_agent_id'].'; ';
				 
				 $client_vat = str_split($FormData['vat_number']);
				 
				 $Client_address  = @$FormData['tab1address']; 
				 $Client_address = explode(',', $Client_address);
				 
				 $Agent_addres = @$FormData['agent_address'];
				 $Agent_addres = explode(',', $Agent_addres);
				 
				 if ($clientdtl['type'] == 'ind'){
				 	 $Iclient = (array_key_exists('client_id', $FormData))? @$FormData['compnay_name'] : '' ;
				 	 $Ofclient = (array_key_exists('client_id', $FormData))? '' : '' ;
				 }
				 else{
					 //$Iclient = (array_key_exists('res_person', $FormData))? @$FormData['res_person'] : @$FormData['tab1indname'] ;
					 $Iclient = (array_key_exists('res_person', $FormData))? @$FormData['res_person'] : '' ;
					 if(@$FormData['selfassessment'] == 'Individual')
					 	$Ofclient = (array_key_exists('client_id', $FormData))? @$FormData['compnay_name'] : '' ;
					 else
					 	$Ofclient = (array_key_exists('client_id', $FormData))? @$FormData['compnay_name'] : '' ;
				 }
				 
				 //require_once('fpdf/fpdf.php'); 
				//require_once('fpdi/fpdi.php'); 
				
				
				$pdf-> setSourceFile('forms-pdf/64-8.pdf');

				$tplIdx = $pdf->importPage(1);

				$pdf->useTemplate($tplIdx,0,0,0);
				$pdf->SetFont('Arial','',7);
				$pdf->SetTextColor(0,0,0);
				$pdf->setFillColor(255,255,255); 
				$pdf->SetXY(18,60);
				$pdf->Cell(80,4, @$Iclient,0,1,'L',1);
				$pdf->SetXY(20,73);
				//if (!array_key_exists('selfassessmentid', $FormData))
				$pdf->Cell(80,3, $Ofclient,0,1,'L',1);
				//$pdf->SetXY(20,80);
				//$pdf->Write(0, $clientdtl['business_name']);
				$pdf->SetXY(16,90);
				$pdf->Cell(80,4, @$FormData['name_agent'],0,1,'L',1);
				//$pdf->Write(0, $FormData['name_agent']);
				$pdf->SetXY(23,141);
				$pdf->Write(0, @date('d M Y'));	
			
				$pdf->SetXY(16,160);
				$pdf->Cell(70,0, @$Client_address[0]);
				$pdf->SetXY(16,166);
				$pdf->Cell(70,0, @$Client_address[1]);
				$pdf->SetXY(16,172);
				$pdf->Cell(70,0, @$Client_address[2]);
				
				
				$pdf->SetXY(28,178);
				$pdf->Write(0, @$FormData['tab1postcode']);
				$pdf->SetXY(35,184);
				$pdf->Write(0, @$FormData['tab1telephonenumber']);

				$pdf->SetXY(16,206);
				$pdf->Cell(70,0, @$Agent_addres[0]);
				$pdf->SetXY(16,212);
				$pdf->Cell(70,0, @$Agent_addres[1]);
				$pdf->SetXY(16,218);
				$pdf->Cell(70,0, @$Agent_addres[2]);
				
				$pdf->SetXY(27,224);
				$pdf->Write(0, @$FormData['agent_post_code']);
				$pdf->SetXY(34,230);
				$pdf->Write(0, @$FormData['agent_tel_no']);
				$pdf->SetXY(16,242);
				
				$pdf->Write(0,substr_replace(@$Agent_code ,"",-2));
				$pdf->SetXY(36,248);
				$pdf->Write(0, @$FormData['reference']);

				 if (array_key_exists('selfassessmentid', $FormData)) {
					$pdf->Image('forms-pdf/seat-checked.png',176, 42, '', '');
					$pdf->SetXY(182,42);
					$pdf->Cell(15,4, @$FormData['selfassessment'],1,0,'L',1);
					$pdf->SetXY(113,62);
					if (array_key_exists('0', $individual_number))
					$pdf->Write(0, @$individual_number[0]);
					$pdf->SetXY(118,62);
					if (array_key_exists('1', $individual_number))
					$pdf->Write(0, @$individual_number[1]);
					$pdf->SetXY(126,62);
					if (array_key_exists('2', $individual_number))
					$pdf->Write(0, @$individual_number[2]);
					$pdf->SetXY(131,62);
					if (array_key_exists('3', $individual_number))
					$pdf->Write(0, @$individual_number[3]);
					$pdf->SetXY(140,62);
					if (array_key_exists('4', $individual_number))
					$pdf->Write(0, @$individual_number[4]);
					$pdf->SetXY(145,62);
					if (array_key_exists('5', $individual_number))
					$pdf->Write(0, @$individual_number[5]);
					$pdf->SetXY(153,62);
					if (array_key_exists('6', $individual_number))
					$pdf->Write(0, $individual_number[6]);
					$pdf->SetXY(158,62);
					if (array_key_exists('7', $individual_number))
					$pdf->Write(0, @$individual_number[7]);
					$pdf->SetXY(167,62);
					if (array_key_exists('8', $individual_number))
					$pdf->Write(0, @$individual_number[8]);
				
					$pdf->SetXY(113,77);
					if (array_key_exists('0', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[0]);
					$pdf->SetXY(118,77);
					if (array_key_exists('1', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[1]);
					$pdf->SetXY(124,77);
					if (array_key_exists('2', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[2]);
					$pdf->SetXY(129,77);
					if (array_key_exists('3', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[3]);
					$pdf->SetXY(135,77);
					if (array_key_exists('4', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[4]);
					$pdf->SetXY(140,77);
					if (array_key_exists('5', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[5]);
					$pdf->SetXY(146,77);
					if (array_key_exists('6', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[6]);
					$pdf->SetXY(151,77);
					if (array_key_exists('7', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[7]);
					$pdf->SetXY(156,77);
					if (array_key_exists('8', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[8]);
					$pdf->SetXY(162,77);
					if (array_key_exists('9', $individual_utr_number))
					$pdf->Write(0, @$individual_utr_number[9]);
					
					if (array_key_exists('client_self', $FormData))
						 $pdf->Image('forms-pdf/seat-checked.png',192, 60, '', '');

					if (array_key_exists('client_utr', $FormData))
						$pdf->Image('forms-pdf/seat-checked.png',192, 75, '', '');
					
					if (array_key_exists('account_statement', $FormData))
						$pdf->Image('forms-pdf/seat-checked.png',192, 86, '', '');
					
				}
				
						/*--Tax credits--*/
				if (array_key_exists('tax_credits', $FormData))
				{
					$pdf->Image('forms-pdf/seat-checked.png',131, 104, '', '');
					$pdf->SetXY(113,138);
					$pdf->Write(0, @$FormData['tab1indname']);
					/*$pdf->SetXY(113,119);
					$pdf->Write(0, @$tax_intance_number[0]);
					$pdf->SetXY(118,119);
					$pdf->Write(0, @$tax_intance_number[1]);
					$pdf->SetXY(126,119);
					$pdf->Write(0, @$tax_intance_number[2]);
					$pdf->SetXY(132,119);
					$pdf->Write(0, @$tax_intance_number[3]);
					$pdf->SetXY(140,119);
					$pdf->Write(0, @$tax_intance_number[4]);
					$pdf->SetXY(145,119);
					$pdf->Write(0, @$tax_intance_number[5]);
					$pdf->SetXY(154,119);
					$pdf->Write(0, @$tax_intance_number[6]);
					$pdf->SetXY(159,119);
					$pdf->Write(0, @$tax_intance_number[7]);
					$pdf->SetXY(167,119);
					$pdf->Write(0, @$tax_intance_number[8]);*/
					
					$pdf->SetXY(113,169);
					$pdf->Write(0, @$tax_intance_number[0]);
					$pdf->SetXY(118,169);
					$pdf->Write(0, @$tax_intance_number[1]);
					$pdf->SetXY(126,169);
					$pdf->Write(0, @$tax_intance_number[2]);
					$pdf->SetXY(132,169);
					$pdf->Write(0, @$tax_intance_number[3]);
					$pdf->SetXY(140,169);
					$pdf->Write(0, @$tax_intance_number[4]);
					$pdf->SetXY(145,169);
					$pdf->Write(0, @$tax_intance_number[5]);
					$pdf->SetXY(154,169);
					$pdf->Write(0, @$tax_intance_number[6]);
					$pdf->SetXY(159,169);
					$pdf->Write(0, @$tax_intance_number[7]);
					$pdf->SetXY(167,169);
					$pdf->Write(0, @$tax_intance_number[8]);
				}
				
				/*---corporation_tax--*/
				if (array_key_exists('corporation_tax', $FormData))
				{
					$pdf->Image('forms-pdf/seat-checked.png',138, 184, '', '');
					$pdf->SetXY(113,198);
					$pdf->Cell(70,0, @$compnay_res_no[0]);
					$pdf->SetXY(118,198);
					$pdf->Cell(70,0, @$compnay_res_no[1]);
					$pdf->SetXY(124,198);
					$pdf->Cell(70,0, @$compnay_res_no[2]);
					$pdf->SetXY(129,198);
					$pdf->Cell(70,0, @$compnay_res_no[3]);
					$pdf->SetXY(135,198);
					$pdf->Cell(70,0, @$compnay_res_no[4]);
					$pdf->SetXY(141,198);
					$pdf->Cell(70,0, @$compnay_res_no[5]);
					$pdf->SetXY(146,198);
					$pdf->Cell(70,0, @$compnay_res_no[6]);
					$pdf->SetXY(151,198);
					$pdf->Cell(70,0, @$compnay_res_no[7]);
					
			        $pdf->SetXY(113,212);
					$pdf->Write(0, @$corporationtaxreference[0]);
					$pdf->SetXY(118,212);
					$pdf->Write(0, @$corporationtaxreference[1]);
					$pdf->SetXY(124,212);
					$pdf->Write(0, @$corporationtaxreference[2]);
					$pdf->SetXY(129,212);
					$pdf->Write(0, @$corporationtaxreference[3]);
					$pdf->SetXY(135,212);
					$pdf->Write(0, @$corporationtaxreference[4]);
					$pdf->SetXY(141,212);
					$pdf->Write(0, @$corporationtaxreference[5]);
					$pdf->SetXY(146,212);
					$pdf->Write(0, @$corporationtaxreference[6]);
					$pdf->SetXY(151,212);
					$pdf->Write(0, @$corporationtaxreference[7]);
					$pdf->SetXY(157,212);
					$pdf->Write(0, @$corporationtaxreference[8]);
					$pdf->SetXY(162,212);
					$pdf->Write(0, @$corporationtaxreference[9]);
				
				}
				
				/*----paye_scheme-----*/
				if (array_key_exists('paye_scheme', $FormData))
				{
					$pdf->Image('forms-pdf/seat-checked.png',149, 237, '', '');
					$pdf->SetXY(114,250);
					$pdf->Write(0, @$FormData['payereferencesamll']." / ".$FormData['payereference']);	
				}
				
				/*---vat--*/
				if (array_key_exists('vat', $FormData))
				{
					$pdf->Image('forms-pdf/seat-checked.png',120, 263, '', '');
					$pdf->SetXY(113,276.9);
					$pdf->Write(0, @$client_vat[0]);
					$pdf->SetXY(118,276.9);
					$pdf->Write(0, @$client_vat[1]);
					$pdf->SetXY(124,276.9);
					$pdf->Write(0, @$client_vat[2]);
					$pdf->SetXY(129,276.9);
					$pdf->Write(0, @$client_vat[3]);
					$pdf->SetXY(135,276.9);
					$pdf->Write(0, @$client_vat[4]);
					$pdf->SetXY(141,276.9);
					$pdf->Write(0, @$client_vat[5]);
					$pdf->SetXY(146,276.9);
					$pdf->Write(0, @$client_vat[6]);
					$pdf->SetXY(151,276.9);
					$pdf->Write(0, @$client_vat[7]);
					$pdf->SetXY(157,276.9);
					$pdf->Write(0, @$client_vat[8]);
					if (array_key_exists('registered_vat', $FormData))
					   $pdf->Image('forms-pdf/seat-checked.png',192, 276, '', '');
				}
				$pdf->Output('64-8_'.$FormData['compnay_name'].'.pdf', 'D');
				exit;
			 }
	
			
			/*************************Form 3****************************/
		   if($FormData['client_id_tab3'] != NULL){
			
			   $vat_nmbr = str_split($FormData['vat_number_tab3']);
			   
			   $Business_Address = @$FormData['tab3_address'];
			   $Business_Address = explode(',', $Business_Address);
			  
			   
			   // echo '<pre>';
			   // print_r($FormData);
			   // echo '</pre>';
			   // Exit;
				$pdf = new FPDI();
				$pdf-> setSourceFile('forms-pdf/vat484.pdf');
					$pdf->AddPage();
					$tplIdx = $pdf->importPage(1);
					$pdf->useTemplate($tplIdx,0,0,0);
				
				$pdf->SetFont('Arial','',7);
				$pdf->SetTextColor(0,0,0);
				$pdf->setFillColor(255,255,255); 
				/*-----------Vat Number---------------------*/
				$pdf->SetXY(111,45);	
				$pdf->Cell(0,0, @$vat_nmbr[0]);
				$pdf->SetXY(116,45);	
				$pdf->Cell(0,0, @$vat_nmbr[1]);
				$pdf->SetXY(122,45);	
				$pdf->Cell(0,0, @$vat_nmbr[2]);
				$pdf->SetXY(130,45);	
				$pdf->Cell(0,0, @$vat_nmbr[3]);
				$pdf->SetXY(136,45);	
				$pdf->Cell(0,0, @$vat_nmbr[4]);
				$pdf->SetXY(141,45);	
				$pdf->Cell(0,0, @$vat_nmbr[5]);
				$pdf->SetXY(146,45);	
				$pdf->Cell(0,0, @$vat_nmbr[6]);
				$pdf->SetXY(155,45);	
				$pdf->Cell(0,0, @$vat_nmbr[7]);
				$pdf->SetXY(160,45);	
				$pdf->Cell(0,0, @$vat_nmbr[8]);
			
				
				$pdf->SetXY(111,60);	
				$pdf->Cell(0,0, @$FormData['res_tab3']);
				   
				$pdf->SetXY(111,84);	
				$pdf->Cell(0,0, @$FormData['position_tab3']);
				
		    /*-----------What do you want to tell us about--------------------*/

			    if (array_key_exists('tab3_ch_vatreturndate', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',145, 115, '', '');
			
				if (array_key_exists('tab3_trnsfr_business', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',145, 124, '', '');
				
				/*-----------Changes to trading address---------------------*/
			if (array_key_exists('tab3_ch_trading_address', $FormData)){
				$clientDetails = $this->getclientdetails($FormData['client_id_tab3']);
				$Business_Address = $clientDetails['TAddress']['address'];
			   	$Business_Address = explode(',', $Business_Address);
				
				$pdf->Image('forms-pdf/seat-checked.png',64, 115, '', '');
				//$pdf->SetXY(17,167);	
				//if ($FormData['business_tab3'] == 'Partnership' || $FormData['business_tab3'] == 'Sole traders')
				//$pdf->Cell(0,0, @$FormData['client_nametab3']);
			
				//$pdf->SetXY(17,203);
				//if ($FormData['business_tab3'] == 'Company' || $FormData['business_tab3'] == 'LLP' )
				//$pdf->Cell(0,0, @$FormData['client_nametab3']);
				
			   $pdf->SetXY(111,166);	
			   $pdf->Cell(0,0, @$Business_Address[0]);
			   $pdf->SetXY(111,172);	
			   $pdf->Cell(0,0, @$Business_Address[1]);
			   $pdf->SetXY(111,178);	
			   $pdf->Cell(0,0, @$Business_Address[2]);
			   $pdf->SetXY(111,184);	
			   $pdf->Cell(0,0, @$Business_Address[3]);
			   
			   $pdf->SetXY(122,189);	
			   $pdf->Cell(0,0, @$FormData['tab3_postcode']);
			   
			   $pdf->SetXY(121,204);	
			   $pdf->Cell(0,0, @$FormData['tab3_telnumber']);
			   
			   $pdf->SetXY(118,210);	
			   $pdf->Cell(0,0, @$FormData['tab3_faxnumber']);
			   
			   $pdf->SetXY(119,224);	
			   $pdf->Cell(0,0, @$FormData['tab3_businessemail']);
			} 
			/*-----------Changes to business contact details---------------------*/
			if (array_key_exists('tab3_ch_business_contact_dtl', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',64, 115, '', '');
				$pdf->SetXY(17,167);	
				if ($FormData['business_tab3'] == 'Partnership' || $FormData['business_tab3'] == 'Sole traders')
				    $pdf->Cell(0,0, @$FormData['client_nametab3']);
			
				$pdf->SetXY(17,203);
				if ($FormData['business_tab3'] == 'Company' || $FormData['business_tab3'] == 'LLP' )
				     $pdf->Cell(0,0, @$FormData['client_nametab3']);
				
			   /*$pdf->SetXY(111,166);	
			   $pdf->Cell(0,0, @$Business_Address[0]);
			   $pdf->SetXY(111,172);	
			   $pdf->Cell(0,0, @$Business_Address[1]);
			   $pdf->SetXY(111,178);	
			   $pdf->Cell(0,0, @$Business_Address[2]);
			   $pdf->SetXY(111,184);	
			   $pdf->Cell(0,0, @$Business_Address[3]);
			   
			   $pdf->SetXY(122,189);	
			   $pdf->Cell(0,0, @$FormData['tab3_postcode']);
			   
			   $pdf->SetXY(121,204);	
			   $pdf->Cell(0,0, @$FormData['tab3_telnumber']);
			   
			   $pdf->SetXY(118,210);	
			   $pdf->Cell(0,0, @$FormData['tab3_faxnumber']);
			   
			   $pdf->SetXY(119,224);	
			   $pdf->Cell(0,0, @$FormData['tab3_businessemail']);*/
			} 
            /*-----------Change bank details---------------------*/		
			if (array_key_exists('tab3_ch_bankdtl', $FormData)){
			   $pdf->Image('forms-pdf/seat-checked.png',64, 124, '', '');
               $pdf->SetXY(112,251);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_name']);

			   $pdf->SetXY(111,264);	
			   $pdf->Cell(0,0, @$FormData['tab3_sortcode1']);
			   $pdf->SetXY(116,264);	
			   $pdf->Cell(0,0, @$FormData['tab3_sortcode2']);
			   $pdf->SetXY(128,264);	
			   $pdf->Cell(0,0, @$FormData['tab3_sortcode3']);
			   $pdf->SetXY(133,264);	
			   $pdf->Cell(0,0, @$FormData['tab3_sortcode4']);
			   $pdf->SetXY(144,264);	
			   $pdf->Cell(0,0, @$FormData['tab3_sortcode5']);
			   $pdf->SetXY(150,264);	
			   $pdf->Cell(0,0, @$FormData['tab3_sortcode6']);
			   
			   $pdf->SetXY(111,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr1']);
			   $pdf->SetXY(117,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr2']);
			   $pdf->SetXY(122,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr3']);
			   $pdf->SetXY(128,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr4']);
			   $pdf->SetXY(133,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr5']);
			   $pdf->SetXY(139,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr6']);
			   $pdf->SetXY(144,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr7']);
			   $pdf->SetXY(150,276.9);	
			   $pdf->Cell(0,0, @$FormData['tab3_acc_nbr8']);
			}

		/*************************Form 3 page-2****************************/
					
				$pdf->AddPage();
				$tplIdx = $pdf->importPage(2);
				$pdf->useTemplate($tplIdx,0,0,0);	 
				$date = str_split($FormData['tab3_trnsfr_bus_date']);
				
				$Today_date = str_split(date('dmY'));
				
			   
			   /*-----------Vat Number at top---------------------*/
				$pdf->SetXY(144,14);
				$pdf->Cell(0,0, @$vat_nmbr[0]);
				$pdf->SetXY(149,14);	
				$pdf->Cell(0,0, @$vat_nmbr[1]);
				$pdf->SetXY(155,14);	
				$pdf->Cell(0,0, @$vat_nmbr[2]);
				$pdf->SetXY(163,14);	
				$pdf->Cell(0,0, @$vat_nmbr[3]);
				$pdf->SetXY(169,14);	
				$pdf->Cell(0,0, @$vat_nmbr[4]);
				$pdf->SetXY(174,14);	
				$pdf->Cell(0,0, @$vat_nmbr[5]);
				$pdf->SetXY(179,14);	
				$pdf->Cell(0,0, @$vat_nmbr[6]);
				$pdf->SetXY(188,14);	
				$pdf->Cell(0,0, @$vat_nmbr[7]);
				$pdf->SetXY(193,14);	
				$pdf->Cell(0,0, @$vat_nmbr[8]);
			   
				if(array_key_exists('tab3_ch_vatreturndate', $FormData)){
					if (array_key_exists('tab3_vatsager1', $FormData) )
						$pdf->Image('forms-pdf/seat-checked.png',72, 38, '', '');

					if (array_key_exists('tab3_vatsager3', $FormData))
						$pdf->Image('forms-pdf/seat-checked.png',72, 47, '', '');

					if (array_key_exists('tab3_vatsager2', $FormData))
						$pdf->Image('forms-pdf/seat-checked.png',72, 56, '', '');

					if (array_key_exists('tab3_vatsager4', $FormData))
						$pdf->Image('forms-pdf/seat-checked.png',160, 38, '', '');
				}
				/*-----------------Transfer of the business---------------------*/	
				if (array_key_exists('tab3_trnsfr_business', $FormData)){
			
					$pdf->SetXY(16,89);	
					$pdf->Cell(0,0, @$FormData['tab3_trnsfr_bus_name']);
					
					if ( @$FormData['tab3_company_business'] == 'Individual')
						$pdf->Image('forms-pdf/seat-checked.png',131, 87, '', '');
					
					if ( @$FormData['tab3_company_business'] == 'Company')
						$pdf->Image('forms-pdf/seat-checked.png',161, 87, '', '');
					
					$pdf->SetXY(111,103);	
					$pdf->Cell(0,0, @$date[0]);
					$pdf->SetXY(116,103);	
					$pdf->Cell(0,0, @$date[1]);
					
					$pdf->SetXY(125 ,103);	
					$pdf->Cell(0,0, @$date[3]);
					$pdf->SetXY(130,103);	
					$pdf->Cell(0,0, @$date[4]);
					
					$pdf->SetXY(138,103);	
					$pdf->Cell(0,0, @$date[6]);
					$pdf->SetXY(144,103);	
					$pdf->Cell(0,0, @$date[7]);
					$pdf->SetXY(149,103);	
					$pdf->Cell(0,0, @$date[8]);
					$pdf->SetXY(155,103);	
					$pdf->Cell(0,0, @$date[9]);
					
					if (array_key_exists('vat_no', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',118	, 120, '', '');
					
					if (array_key_exists('vat_yes', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',136	, 120, '', '');
					
					$pdf->SetXY(16,103);	
					$pdf->Cell(0,0, @$FormData['tab3_address_bar1']);
					$pdf->SetXY(16,109);	
					$pdf->Cell(0,0, @$FormData['tab3_address_bar2']);
					$pdf->SetXY(16,115);	
					$pdf->Cell(0,0, @$FormData['tab3_address_bar3']);
					$pdf->SetXY(16,121);	
					$pdf->Cell(0,0, @$FormData['tab3_address_bar4']);
					$pdf->SetXY(27,127);	
					$pdf->Cell(0,0, @$FormData['tab3_business_postcode']);
					
					$pdf->SetXY(16,145);	
					$pdf->MultiCell(180,3,@$FormData['tab3_other_ch']);
					
					$pdf->SetXY(17, 261);	
					$pdf->Cell(0,0, @$Today_date[0]);
					$pdf->SetXY(22, 261);	
					$pdf->Cell(0,0, @$Today_date[1]);
					
					$pdf->SetXY(30, 261);	
					$pdf->Cell(0,0, @$Today_date[2]);
					$pdf->SetXY(35, 261);	
					$pdf->Cell(0,0, @$Today_date[3]);
					
					$pdf->SetXY(44, 261);	
					$pdf->Cell(0,0, @$Today_date[4]);
					$pdf->SetXY(49, 261);	
					$pdf->Cell(0,0, @$Today_date[5]);
					$pdf->SetXY(55, 261);	
					$pdf->Cell(0,0, @$Today_date[6]);
					$pdf->SetXY(60, 261);	
					$pdf->Cell(0,0, @$Today_date[7]);
				}
					
					
			/*-----------------Declaration---------------------*/		
				
				$pdf->SetXY(111,240);
				$pdf->Cell(0,0, @$FormData['tab3_decname']);
				$pdf->SetXY(111,265);
				$pdf->Cell(0,0, @$FormData['tab3_decposition']);
           /* if ($FormData['tab3_declaration'] == 'agent'){
			    $pdf->Cell(0,0, @$FormData['tab3_decname']);
				$pdf->Cell(0,0, @$FormData['tab3_decposition']);
			}
				
				//$pdf->SetXY(111,265);
            if ($FormData['tab3_declaration'] == 'client'){
				$pdf->Cell(0,0, @$FormData['tab3_decname']);				
			    $pdf->Cell(0,0, @$FormData['tab3_decposition']);
			}*/
				
			$pdf->Output('VAT_484_'.$FormData['compnay_name'].'.pdf', 'D'); 
			Exit;
		   }  
		  /*************************Form 4 page-1****************************/ 
		   if($FormData['client_name_tab4'] != NULL){
			   			   
			   $Address = @$FormData['tab4_resaddress'];
			   $Address = explode(',', $Address);
			   
			   $dob = str_split(trim($FormData['DOB']));
			   
			   $ni_number = str_split(trim($FormData['ni_number_tab4']));
			   
			   $pdf = new FPDI();
				$pdf-> setSourceFile('forms-pdf/sa401-static.pdf');
					$pdf->AddPage();
					$tplIdx = $pdf->importPage(1);
					$pdf->useTemplate($tplIdx,0,0,0);
				
				$pdf->SetFont('Arial','',7);
				$pdf->SetTextColor(0,0,0);
				$pdf->setFillColor(255,255,255);
				
			/*-----------------About you---------------------*/
				$pdf->SetXY(22, 164);	
			    $pdf->Cell(0,0, @$FormData['title']);
                $pdf->SetXY(22, 183);	
			    $pdf->Cell(0,0, @$FormData['l_name']);
                $pdf->SetXY(22, 201);	
			    $pdf->Cell(0,0, @$FormData['f_name']);	
				
				$pdf->SetXY(22, 217);	
			    $pdf->Cell(0,0, @$Address[0]);
				$pdf->SetXY(22, 223);	
			    $pdf->Cell(0,0, @$Address[1]);
				$pdf->SetXY(22, 229);	
			    $pdf->Cell(0,0, @$Address[2]);
				
				$pdf->SetXY(72, 234.6);	
			    $pdf->Cell(0,0, @$FormData['tab4_postcide']);
				
				$pdf->SetXY(22, 253);	
			    $pdf->Cell(0,0, @$FormData['tab4telephone']);
				
				$pdf->SetXY(23, 271);	
			    $pdf->Cell(0,0, @$dob[0]);
				$pdf->SetXY(28, 271);	
			    $pdf->Cell(0,0, @$dob[1]);
				$pdf->SetXY(36, 271);	
			    $pdf->Cell(0,0, @$dob[3]);
				$pdf->SetXY(41, 271);	
			    $pdf->Cell(0,0, @$dob[4]);
				
				$pdf->SetXY(50, 271);	
			    $pdf->Cell(0,0, @$dob[6]);
				$pdf->SetXY(54, 271);	
			    $pdf->Cell(0,0, @$dob[7]);
				$pdf->SetXY(60, 271);	
			    $pdf->Cell(0,0, @$dob[8]);
				$pdf->SetXY(65, 271);	
			    $pdf->Cell(0,0, @$dob[9]);
				
				$pdf->SetXY(117, 164);	
			    $pdf->Cell(0,0, @$ni_number[0]);
				$pdf->SetXY(122, 164);	
			    $pdf->Cell(0,0, @$ni_number[1]);
				$pdf->SetXY(131, 164);	
			    $pdf->Cell(0,0, @$ni_number[2]);
				$pdf->SetXY(136, 164);	
			    $pdf->Cell(0,0, @$ni_number[3]);
				$pdf->SetXY(144, 164);	
			    $pdf->Cell(0,0, @$ni_number[4]);
				$pdf->SetXY(149, 164);	
			    $pdf->Cell(0,0, @$ni_number[5]);
				$pdf->SetXY(157, 164);	
			    $pdf->Cell(0,0, @$ni_number[6]);
				$pdf->SetXY(162, 164);	
			    $pdf->Cell(0,0, @$ni_number[7]);
				$pdf->SetXY(170, 164);	
			    $pdf->Cell(0,0, @$ni_number[8]);
				
				$pdf->SetXY(117,213);	
			    $pdf->MultiCell(73,3,@$FormData['insurance_nbr_tab4']);
				
				if (array_key_exists('UK_resident_tab4', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',149, 257, '', '');
				
				/*************************Form 4 page-2****************************/
				
				$pdf->AddPage();
					$tplIdx = $pdf->importPage(2);
					$pdf->useTemplate($tplIdx,0,0,0);
					
					$self_emp_date = str_split(trim($FormData['self_emp_date']));
					
					$utr = str_split(trim($FormData['resputr_tab4'])) ;
					  
					$partnership_address = $FormData['partnership_address_tab4'];
					$partnership_address = explode(',', $partnership_address);
					
					$join_date = str_split($FormData['partnership_date_tab4']);
					
					$Partnership_utr = str_split($FormData['Partnership_utr_tab4']);
					
				    $registration_nbr = str_split($FormData['tab4_registration_nbr']);
					
					$Today_date = str_split(trim(date('dmY')));
				
				if (array_key_exists('non_EU_tab4', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',54, 44, '', '');	
				
				if (array_key_exists('nominated_Partnership', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',149, 44, '', '');
					
				if (array_key_exists('UK_tab4', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',93, 54, '', '');

				$pdf->SetXY(117, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[0]);
				$pdf->SetXY(122, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[1]);
				$pdf->SetXY(131, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[3]);
				$pdf->SetXY(136, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[4]);
				$pdf->SetXY(144, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[6]);
				$pdf->SetXY(149, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[7]);
				$pdf->SetXY(154, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[8]);
				$pdf->SetXY(159, 65);	
			    $pdf->Cell(0,0, @$self_emp_date[9]);
				
				$pdf->SetXY(23, 81);	
			    $pdf->Cell(0,0, @$utr[0]);
				$pdf->SetXY(28, 81);	
			    $pdf->Cell(0,0, @$utr[1]);
				$pdf->SetXY(33, 81);	
			    $pdf->Cell(0,0, @$utr[2]);
				$pdf->SetXY(38, 81);	
			    $pdf->Cell(0,0, @$utr[3]);
				$pdf->SetXY(43, 81);	
			    $pdf->Cell(0,0, @$utr[4]);
				$pdf->SetXY(51, 81);	
			    $pdf->Cell(0,0, @$utr[5]);
				$pdf->SetXY(56, 81);	
			    $pdf->Cell(0,0, @$utr[6]);
				$pdf->SetXY(61, 81);	
			    $pdf->Cell(0,0, @$utr[7]);
				$pdf->SetXY(66, 81);	
			    $pdf->Cell(0,0, @$utr[8]);
				$pdf->SetXY(71, 81);	
			    $pdf->Cell(0,0, @$utr[9]);
				
		/*---------------------About the partnership you have joined------------------*/		
				$pdf->SetXY(22, 113);	
			    $pdf->Cell(0,0, @$FormData['client_sel_name_tab4']);
				
				$pdf->SetXY(22, 131);	
			    $pdf->Cell(0,0, @$partnership_address[0]);
				$pdf->SetXY(22, 137);	
			    $pdf->Cell(0,0, @$partnership_address[1]);
				$pdf->SetXY(22, 143);	
			    $pdf->Cell(0,0, @$partnership_address[2]);
				
				$pdf->SetXY(72, 149);	
			    $pdf->Cell(0,0, @$FormData['partnership_postcode_tab4']);
				
				$pdf->SetXY(22, 177);	
			    $pdf->Cell(0,0, @$FormData['nature_trade_tab4']);
				
				$pdf->SetXY(23, 200);	
			    $pdf->Cell(0,0, @$join_date[0]);
				$pdf->SetXY(28, 200);	
			    $pdf->Cell(0,0, @$join_date[1]);
				
				$pdf->SetXY(36, 200);	
			    $pdf->Cell(0,0, @$join_date[3]);
				$pdf->SetXY(41, 200);	
			    $pdf->Cell(0,0, @$join_date[4]);
				
				$pdf->SetXY(50, 200);	
			    $pdf->Cell(0,0, @$join_date[6]);
				$pdf->SetXY(54, 200);	
			    $pdf->Cell(0,0, @$join_date[7]);
				$pdf->SetXY(59, 200);	
			    $pdf->Cell(0,0, @$join_date[8]);
				$pdf->SetXY(64, 200);	
			    $pdf->Cell(0,0, @$join_date[9]);
				
				$pdf->SetXY(117, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[0]);
				$pdf->SetXY(122, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[1]);
				$pdf->SetXY(127, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[2]);
				$pdf->SetXY(132, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[3]);
				$pdf->SetXY(137, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[4]);
				
				$pdf->SetXY(145, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[5]);
				$pdf->SetXY(150, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[6]);
				$pdf->SetXY(155, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[7]);
				$pdf->SetXY(160, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[8]);
				$pdf->SetXY(165, 117);	
			    $pdf->Cell(0,0, @$Partnership_utr[9]);
				
				$pdf->SetXY(120, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[0]);
				$pdf->SetXY(125, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[1]);
				$pdf->SetXY(130, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[2]);
				$pdf->SetXY(135, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[3]);
				$pdf->SetXY(140, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[4]);
				$pdf->SetXY(145, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[5]);
				$pdf->SetXY(150, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[6]);
				$pdf->SetXY(155, 171);	
			    $pdf->Cell(0,0, @$registration_nbr[7]);
			
			    if (array_key_exists('intitled_partnership', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',187, 183, '', '');
				
				if (array_key_exists('partnership_engaged_tab4', $FormData))
					$pdf->Image('forms-pdf/seat-checked.png',187, 205, '', '');
				
			    $pdf->SetXY(109, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[0]);
				$pdf->SetXY(113, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[1]);
				
				$pdf->SetXY(121, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[2]);
				$pdf->SetXY(126, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[3]);
				
				$pdf->SetXY(135, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[4]);
				$pdf->SetXY(140, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[5]);
				$pdf->SetXY(145, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[6]);
				$pdf->SetXY(150, 276.9);	
			    $pdf->Cell(0,0, @$Today_date[7]);
				
				//$pdf->Output($FormData['client_sel_name_tab4'].'.pdf', 'D');
				$pdf->Output('SA_401_'.$FormData['compnay_name'].'.pdf', 'D');
			   exit;
		   }
		   
		/*************************Form 5 page****************************/   
		   
		    if($FormData['client_name_tab5'] != NULL){
			
		        $Address_business = explode(',', $FormData['tab5_address']);
				
				$pdf = new FPDI();
				$pdf-> setSourceFile('forms-pdf/vat600.pdf');
					$pdf->AddPage();
					$tplIdx = $pdf->importPage(1);
					$pdf->useTemplate($tplIdx,0,0,0);
				
				$pdf->SetFont('Arial','',7);
				$pdf->SetTextColor(0,0,0);
				$pdf->setFillColor(255,255,255); 
		/*--------------------------About the business--------------------------*/
				$pdf->SetXY(17, 65);	
			    $pdf->Cell(0,0, @$FormData['client_sel_name_tab5']);
				
				$pdf->SetXY(17, 87);	
			    $pdf->Cell(0,0, @$Address_business[0]);
				$pdf->SetXY(17, 92);	
			    $pdf->Cell(0,0, @$Address_business[1]);
				$pdf->SetXY(17, 97);	
			    $pdf->Cell(0,0, @$Address_business[2]);
				
				$pdf->SetXY(31, 109);	
			    $pdf->Cell(0,0, @$FormData['tab5_postcode']);
				
				$pdf->SetXY(111, 65);	
			    $pdf->Cell(0,0, @$FormData['tab5_tel_nbr']);
				
				$pdf->SetXY(111, 82);	
			    $pdf->Cell(0,0, @$FormData['vat_number_tab5']);
		/*----------------------------Flat Rate Scheme (FRS)-----------------------*/		
				$pdf->SetXY(16,150);	
			    $pdf->MultiCell(84,3,@$FormData['naturetrade_tab5']);
				
				$pdf->SetXY(17, 186);	
			    $pdf->Cell(0,0, @$FormData['rate_trade_tab5']);
				
				$pdf->SetXY(111, 153);	
			    $pdf->Cell(0,0, @$FormData['reason_date_tab5']);
				
				$pdf->SetXY(111,165);	
			    $pdf->MultiCell(84,3,@$FormData['reason_tab5']);
				
		/*----------------------------------Declaration-------------------------------*/		
				$pdf->SetXY(16, 243);	
			    $pdf->Cell(0,0, @$FormData['res_person']);
				
				$pdf->SetXY(16, 259);	
			    $pdf->Cell(0,0, @$FormData['status_proprietor_tab5']);
				
				$pdf->SetXY(111, 247);	
			    $pdf->Cell(0,0, @date('d M Y'));
				
				//$pdf->Output('FORM_VAT_600FRS.pdf', 'D');
				$pdf->Output("VAT_600FRS_".$FormData['client_sel_name_tab5'].".pdf", 'D');
			   exit;
			}	
			/*************************Form 6 page-1****************************/
		   if($FormData['selected_client_tab6'] != NULL){
			
                $DateOfChange = str_split(trim($FormData['date_change']));
				
				$NiNumber = str_split(trim($FormData['tab6_ninumber']));
				
				$DateOfBirth = str_split(trim($FormData['tab6_dob']));
				
				$Address = explode(',', $FormData['tab6_address']);
				
				$Utr = str_split(trim($FormData['tab6utr']));
				
				$PostCode = str_split(trim($FormData['tab6_postcode']));
				
				
				
				$pdf = new FPDI();
				$pdf-> setSourceFile('forms-pdf/SA1.pdf');
					$pdf->AddPage();
					$tplIdx = $pdf->importPage(1);
					$pdf->useTemplate($tplIdx,0,0,0);
				
				$pdf->SetFont('Arial','',7);
				$pdf->SetTextColor(0,0,0);
				$pdf->setFillColor(255,255,255); 
				
		/*----------------------------------About you----------------------------------*/	
                $pdf->SetXY(22,101);	
			    $pdf->Cell(0,0,@$FormData['title']);	
				
				$pdf->SetXY(22,119);	
			    $pdf->Cell(0,0,@$FormData['tab6_lname']);
				
				$pdf->SetXY(22,136);	
			    $pdf->Cell(0,0,$FormData['tab6fname'].' '.@$FormData['tab6_mname']);
				
				$pdf->SetXY(22,154);	
			    $pdf->Cell(0,0,@$FormData['p_surname']);
				
				$pdf->SetXY(23, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[0]);
				$pdf->SetXY(28, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[1]);
				
				$pdf->SetXY(36, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[3]);
				$pdf->SetXY(41, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[4]);
				
				$pdf->SetXY(50, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[6]);
				$pdf->SetXY(55, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[7]);
				$pdf->SetXY(60, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[8]);
				$pdf->SetXY(66, 171.6);	
			    $pdf->Cell(0,0, @$DateOfChange[9]);
				
				$pdf->SetXY(23, 190);	
			    $pdf->Cell(0,0, @$NiNumber[0]);
				$pdf->SetXY(28, 190);	
			    $pdf->Cell(0,0, @$NiNumber[1]);
				$pdf->SetXY(36, 190);	
			    $pdf->Cell(0,0, @$NiNumber[2]);
				$pdf->SetXY(42, 190);	
			    $pdf->Cell(0,0, @$NiNumber[3]);
				$pdf->SetXY(50, 190);	
			    $pdf->Cell(0,0, @$NiNumber[4]);
				$pdf->SetXY(56, 190);	
			    $pdf->Cell(0,0, @$NiNumber[5]);
				$pdf->SetXY(63, 190);	
			    $pdf->Cell(0,0, @$NiNumber[6]);
				$pdf->SetXY(69, 190);	
			    $pdf->Cell(0,0, @$NiNumber[7]);
				$pdf->SetXY(77, 190);	
			    $pdf->Cell(0,0, @$NiNumber[8]);
				
                $pdf->SetXY(117, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[0]);
				$pdf->SetXY(122, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[1]);
				$pdf->SetXY(131, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[3]);
				$pdf->SetXY(136, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[4]);
				$pdf->SetXY(144, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[6]);
				$pdf->SetXY(149, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[7]);
				$pdf->SetXY(154, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[8]);
				$pdf->SetXY(160, 101);	
			    $pdf->Cell(0,0, @$DateOfBirth[9]);
				
				$pdf->SetXY(117, 132);	
			    $pdf->Cell(0,0, @$Utr[0]);
				$pdf->SetXY(123, 132);	
			    $pdf->Cell(0,0, @$Utr[1]);
				$pdf->SetXY(128, 132);	
			    $pdf->Cell(0,0, @$Utr[2]);
				$pdf->SetXY(134, 132);	
			    $pdf->Cell(0,0, @$Utr[3]);
				$pdf->SetXY(139, 132);	
			    $pdf->Cell(0,0, @$Utr[4]);
				$pdf->SetXY(147, 132);	
			    $pdf->Cell(0,0, @$Utr[5]);
				$pdf->SetXY(153, 132);	
			    $pdf->Cell(0,0, @$Utr[6]);
				$pdf->SetXY(158, 132);	
			    $pdf->Cell(0,0, @$Utr[7]);
				$pdf->SetXY(163, 132);	
			    $pdf->Cell(0,0, @$Utr[8]);
				$pdf->SetXY(169, 132);	
			    $pdf->Cell(0,0, @$Utr[9]);
				
				$pdf->SetXY(117, 150);	
			    $pdf->Cell(0,0, @$Address[0]);
				$pdf->SetXY(117, 156);	
			    $pdf->Cell(0,0, @$Address[1]);
				$pdf->SetXY(117, 162);	
			    $pdf->Cell(0,0, @$Address[2]);
				$pdf->SetXY(117, 168);	
			    $pdf->Cell(0,0, @$Address[3]);
				$pdf->SetXY(117, 174);	
			    $pdf->Cell(0,0, @$Address[3]);
				
				$pdf->SetXY(117, 191);	
			    $pdf->Cell(0,0, @$PostCode[0]);
				$pdf->SetXY(123, 191);	
			    $pdf->Cell(0,0, @$PostCode[1]);
				$pdf->SetXY(128, 191);	
			    $pdf->Cell(0,0, @$PostCode[2]);
				$pdf->SetXY(134, 191);	
			    $pdf->Cell(0,0, @$PostCode[3]);
				$pdf->SetXY(142, 191);	
			    $pdf->Cell(0,0, @$PostCode[4]);
				$pdf->SetXY(147, 191);	
			    $pdf->Cell(0,0, @$PostCode[5]);
				$pdf->SetXY(153, 191);	
			    $pdf->Cell(0,0, @$PostCode[6]);
				$pdf->SetXY(158, 191);	
			    $pdf->Cell(0,0, @$PostCode[7]);
				
				$pdf->SetXY(117, 209);	
			    $pdf->Cell(0,0, @$FormData['tab6_tel_nbr']);
				
				$pdf->SetXY(22, 230);	
			    $pdf->MultiCell(77,6, @$FormData['nin_reason']);
				
        /********************************Form 6 page-2 ***********************************/
				$pdf->AddPage();
				$tplIdx = $pdf->importPage(2);
				$pdf->useTemplate($tplIdx,0,0,0);
				
				$date1 = str_split(trim($FormData['date1']));
				
				$date2 = str_split(trim($FormData['date2']));
				
				$date3 = str_split(trim($FormData['date3']));
				
				$date4 = str_split(trim($FormData['date4']));
				
				$date5 = str_split(trim($FormData['date5']));
				
				$date6 = str_split(trim($FormData['date6']));
				
				$date7 = str_split(trim($FormData['date7']));
				
				$year_ending = str_split(trim($FormData['tax_year_ending']));
				
				$RegistrationDate = str_split(trim($FormData['registration_date']));
				
				$Toady_date = str_split(trim(date('dmY')));
				
				
				if (array_key_exists('cmpny_director', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 48, '', '');
					
					$pdf->SetXY(142, 50);	
					$pdf->Cell(0,0, @$date1[0]);
					$pdf->SetXY(147, 50);	
					$pdf->Cell(0,0, @$date1[1]);
					
					$pdf->SetXY(155, 50);	
					$pdf->Cell(0,0, @$date1[3]);
					$pdf->SetXY(161, 50);	
					$pdf->Cell(0,0, @$date1[4]);
					
					$pdf->SetXY(169, 50);	
					$pdf->Cell(0,0, @$date1[6]);
					$pdf->SetXY(174, 50);	
					$pdf->Cell(0,0, @$date1[7]);
					$pdf->SetXY(180, 50);	
					$pdf->Cell(0,0, @$date1[8]);
					$pdf->SetXY(185, 50);	
					$pdf->Cell(0,0, @$date1[9]);	
				}
				if (array_key_exists('getting_income', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 58, '', '');
					
					$pdf->SetXY(142, 60);	
					$pdf->Cell(0,0, @$date2[0]);
					$pdf->SetXY(147, 60);	
					$pdf->Cell(0,0, @$date2[1]);
					
					$pdf->SetXY(155, 60);	
					$pdf->Cell(0,0, @$date2[3]);
					$pdf->SetXY(161, 60);	
					$pdf->Cell(0,0, @$date2[4]);
					
					$pdf->SetXY(169, 60);	
					$pdf->Cell(0,0, @$date2[6]);
					$pdf->SetXY(174, 60);	
					$pdf->Cell(0,0, @$date2[7]);
					$pdf->SetXY(180, 60);	
					$pdf->Cell(0,0, @$date2[8]);
					$pdf->SetXY(185, 60);	
					$pdf->Cell(0,0, @$date2[9]);	
				}
				if (array_key_exists('taxable_income', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 68, '', '');
					
					$pdf->SetXY(142, 70);	
					$pdf->Cell(0,0, @$date3[0]);
					$pdf->SetXY(147, 70);	
					$pdf->Cell(0,0, @$date3[1]);
					
					$pdf->SetXY(155, 70);	
					$pdf->Cell(0,0, @$date3[3]);
					$pdf->SetXY(161, 70);	
					$pdf->Cell(0,0, @$date3[4]);
					
					$pdf->SetXY(169, 70);	
					$pdf->Cell(0,0, @$date3[6]);
					$pdf->SetXY(174, 70);	
					$pdf->Cell(0,0, @$date3[7]);
					$pdf->SetXY(180, 70);	
					$pdf->Cell(0,0, @$date3[8]);
					$pdf->SetXY(185, 70);	
					$pdf->Cell(0,0, @$date3[9]);	
				}
				if (array_key_exists('annual_trust_income', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 78, '', '');
					
					$pdf->SetXY(142, 80);	
					$pdf->Cell(0,0, @$date4[0]);
					$pdf->SetXY(147, 80);	
					$pdf->Cell(0,0, @$date4[1]);
					
					$pdf->SetXY(155, 80);	
					$pdf->Cell(0,0, @$date4[3]);
					$pdf->SetXY(161, 80);	
					$pdf->Cell(0,0, @$date4[4]);
					
					$pdf->SetXY(169, 80);	
					$pdf->Cell(0,0, @$date4[6]);
					$pdf->SetXY(174, 80);	
					$pdf->Cell(0,0, @$date4[7]);
					$pdf->SetXY(180, 80);	
					$pdf->Cell(0,0, @$date4[8]);
					$pdf->SetXY(185, 80);	
					$pdf->Cell(0,0, @$date4[9]);	
				}
				if (array_key_exists('annual_income', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 88, '', '');
					
					$pdf->SetXY(142, 90);	
					$pdf->Cell(0,0, @$date5[0]);
					$pdf->SetXY(147, 90);	
					$pdf->Cell(0,0, @$date5[1]);
					
					$pdf->SetXY(155, 90);	
					$pdf->Cell(0,0, @$date5[3]);
					$pdf->SetXY(161, 90);	
					$pdf->Cell(0,0, @$date5[4]);
					
					$pdf->SetXY(169, 90);	
					$pdf->Cell(0,0, @$date5[6]);
					$pdf->SetXY(174, 90);	
					$pdf->Cell(0,0, @$date5[7]);
					$pdf->SetXY(180, 90);	
					$pdf->Cell(0,0, @$date5[8]);
					$pdf->SetXY(185, 90);	
					$pdf->Cell(0,0, @$date5[9]);	
				}
				if (array_key_exists('untaxed_income', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 103, '', '');
					
					$pdf->SetXY(142, 105);	
					$pdf->Cell(0,0, @$date6[0]);
					$pdf->SetXY(147, 105);	
					$pdf->Cell(0,0, @$date6[1]);
					
					$pdf->SetXY(155, 105);	
					$pdf->Cell(0,0, @$date6[3]);
					$pdf->SetXY(161, 105);	
					$pdf->Cell(0,0, @$date6[4]);
					
					$pdf->SetXY(169, 105);	
					$pdf->Cell(0,0, @$date6[6]);
					$pdf->SetXY(174, 105);	
					$pdf->Cell(0,0, @$date6[7]);
					$pdf->SetXY(180, 105);	
					$pdf->Cell(0,0, @$date6[8]);
					$pdf->SetXY(185, 105);	
					$pdf->Cell(0,0, @$date6[9]);	
				}
				if (array_key_exists('benefit_payments', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 118, '', '');
					
					$pdf->SetXY(142, 120);	
					$pdf->Cell(0,0, @$date7[0]);
					$pdf->SetXY(147, 120);	
					$pdf->Cell(0,0, @$date7[1]);
					
					$pdf->SetXY(155, 120);	
					$pdf->Cell(0,0, @$date7[3]);
					$pdf->SetXY(161, 120);	
					$pdf->Cell(0,0, @$date7[4]);
					
					$pdf->SetXY(169, 120);	
					$pdf->Cell(0,0, @$date7[6]);
					$pdf->SetXY(174, 120);	
					$pdf->Cell(0,0, @$date7[7]);
					$pdf->SetXY(180, 120);	
					$pdf->Cell(0,0, @$date7[8]);
					$pdf->SetXY(185, 120);	
					$pdf->Cell(0,0, @$date7[9]);	
				}
				if (array_key_exists('capital_tax_pay', $FormData)){
					$pdf->Image('forms-pdf/seat-checked.png',128, 133, '', '');
					
					$pdf->SetXY(168, 134);	
					$pdf->Cell(0,0, @$year_ending[0]);
					$pdf->SetXY(174, 134);	
					$pdf->Cell(0,0, @$year_ending[1]);
					$pdf->SetXY(180, 134);	
					$pdf->Cell(0,0, @$year_ending[2]);
					$pdf->SetXY(185, 134);	
					$pdf->Cell(0,0, @$year_ending[3]);	
				}
				
				$pdf->SetXY(22, 150);	
			    $pdf->MultiCell(168,6, @$FormData['other_reason']);
				
				$pdf->SetXY(23, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[0]);
				$pdf->SetXY(28, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[1]);
				
				$pdf->SetXY(36, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[3]);
				$pdf->SetXY(42, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[4]);
				
				$pdf->SetXY(50, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[6]);
				$pdf->SetXY(56, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[7]);
				$pdf->SetXY(61, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[8]);
				$pdf->SetXY(67, 197);	
			    $pdf->Cell(0,0, @$RegistrationDate[9]);
				
				$pdf->SetXY(117, 262);	
			    $pdf->Cell(0,0, @$Toady_date[0]);
				$pdf->SetXY(122, 262);	
			    $pdf->Cell(0,0, @$Toady_date[1]);
				$pdf->SetXY(131, 262);	
			    $pdf->Cell(0,0, @$Toady_date[2]);
				$pdf->SetXY(136, 262);	
			    $pdf->Cell(0,0, @$Toady_date[3]);
				$pdf->SetXY(144, 262);	
			    $pdf->Cell(0,0, @$Toady_date[4]);
				$pdf->SetXY(149, 262);	
			    $pdf->Cell(0,0, @$Toady_date[5]);
				$pdf->SetXY(154, 262);	
			    $pdf->Cell(0,0, @$Toady_date[6]);
				$pdf->SetXY(160, 262);	
			    $pdf->Cell(0,0, @$Toady_date[7]);
				
				//$pdf_name="SA1_".$FormData['tab6fname']."_".$FormData['tab6_lname'];
				$pdf->Output("SA1_".$FormData['tab6fname']."_".$FormData['tab6_lname'].".pdf", 'D');
				//$pdf->Output('','D');
			   exit;
		   }
			
	}
    
  public function getContactNameDropdown($details) {
		$data = array();
		if (isset($details) && count($details) > 0) {
			$i = 0;
			if (isset($details['trad_cont_name']) && $details['trad_cont_name'] != "") {
				$data[$i]['name'] = $details['trad_cont_name'];
				$i++;
			}
			if (isset($details['reg_cont_name']) && $details['reg_cont_name'] != "") {
				$data[$i]['name'] = $details['reg_cont_name'];
				$i++;
			}
			if (isset($details['corres_cont_name']) && $details['corres_cont_name'] != "") {
				$data[$i]['name'] = $details['corres_cont_name'];
				$i++;
			}
			if (isset($details['banker_cont_name']) && $details['banker_cont_name'] != "") {
				$data[$i]['name'] = $details['banker_cont_name'];
				$i++;
			}
			if (isset($details['oldacc_cont_name']) && $details['oldacc_cont_name'] != "") {
				$data[$i]['name'] = $details['oldacc_cont_name'];
				$i++;
			}
			if (isset($details['auditors_cont_name']) && $details['auditors_cont_name'] !=
				"") {
				$data[$i]['name'] = $details['auditors_cont_name'];
				$i++;
			}
			if (isset($details['solicitors_cont_name']) && $details['solicitors_cont_name'] !=
				"") {
				$data[$i]['name'] = $details['solicitors_cont_name'];
				$i++;
			}

			$rel_data = Common::get_relationship_client($details['client_id']);
			if (isset($rel_data) && count($rel_data) > 0) {
				foreach ($rel_data as $key => $value) {
					$data[$i]['name'] = $value['name'];
					$i++;
				}
			}
		}

		return $data;
	}


  public function getclientdetails($clientID = null)
  {
		if($clientID != null){
			$client_id = $clientID;
			$clientdetails = Common::clientDetailsById($client_id);
			return $clientdetails;
		}
	   
	  $client_id = Input::get("client_id");
		
		$clientdetails = Common::clientDetailsById($client_id);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($clientdetails);
		exit;
  }
	public function getresponsibleperson() 
	{
		$client_id 		= Input::get("client_id");
		$client_type 	= Client::where("client_id", $client_id)->select("type")->first();

		//if ($client_type['type'] == "org") {
			$relayth_data = Common::get_relationship_client($client_id);
      echo View::make('hmrc.rsponce')->with('relayth_data', $relayth_data);
		//}

	}

	public function emails() 
	{
		$data['heading'] = "STRUCTURED EMAILS";
		$data['title'] = "Hmrc Structured Emails";
		$data['previous_page'] = '<a href="/organisation-clients">Client list</a>';
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];

		return View::make('hmrc.emails', $data);
	}

	public function tool() 
	{
		$data['heading'] 	= "TOOL & CALCULATORS";
		$data['title'] 		= "Hmrc Calculators";
		$data['previous_page'] = '<a href="/organisation-clients">Client list</a>';
		$session 						= Session::get('admin_details');
		$user_id 						= $session['id'];
		$data['user_type'] 	= $session['user_type'];
		$groupUserId 				= $session['group_users'];

		return View::make('hmrc.tool', $data);
	}

	public function taxrates() 
	{
		$data['heading'] 	= "TAX RATES & THRESHOLDS";
		$data['title'] 		= "Tax Rates & Thresholds";
		//$data['previous_page'] = '<a href="/hmrc">Tax Rates & Thresholds</a>';
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];

		return View::make('hmrc.taxrates', $data);
	}

	public function technicalupdates( $button='policy' ) 
	{ 
		$data['heading'] 				= "TECHNICAL UPDATES";
		$data['title'] 					= "Technical Updates";
		$data['previous_page'] 	= '<a href="/knowledgebase">Inhouse knowlege</a>';
		$session 						= Session::get('admin_details');
		$user_id 						= $session['id'];
		$data['user_type'] 	= $session['user_type'];
		$groupUserId 				= $session['group_users'];
		$data['button'] 		= $button;

		return View::make('hmrc.technicalupdates', $data);
	}

  public function hmrcrevenue()
  {
    return View::make('hmrc.hmrcrevenue');
  }
    
  public function getindclientdetails()
  {
    $client_id = Input::get("client_id");
		if (Request::ajax()) {
			$client_details=Common::clientDetailsById($client_id);
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($client_details);
      exit;
    }
  }
    
  public function testperson()
  {
    $data['heading'] 		= "FORMS";
		$data['title'] 			= "Forms";
    $data['page_open']	= "1";
		$data['previous_page'] = '<a href="/hmrc">HMRC</a>';

		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$data['user_type'] = $session['user_type'];
		$groupUserId = $session['group_users'];

		//$data['allClients'] 	 	= App::make("HomeController")->get_all_clients();


		$client_details = Client::getAllOrgClientDetails();

		//echo '<pre>';print_r($client_details);die();
		if (isset($client_details) && count($client_details) > 0) {
			foreach ($client_details as $key => $client_row) {
				$client_data[$key]['client_id'] = $client_row['client_id'];
				if (isset($client_row['client_type']) && $client_row['client_type'] == "org") {

					$client_data[$key]['client_name'] = $client_row['business_name'];

					$client_data[$key]['contact_type'] = "Business";
					$client_data[$key]['client_url'] = "/client/edit-org-client/" . $client_row['client_id'] .
					"/" . base64_encode('org_client');
					$client_data[$key]['email'] = isset($client_row['corres_cont_email']) ? $client_row['corres_cont_email'] :
					"";
					$client_data[$key]['telephone'] = isset($client_row['corres_cont_telephone']) ?
					$client_row['corres_cont_telephone'] : "";
					$client_data[$key]['mobile'] = isset($client_row['corres_cont_mobile']) ? $client_row['corres_cont_mobile'] :
					"";
					$client_data[$key]['corres_address'] = isset($client_row['corres_address']) ? $client_row['corres_address'] :
					"";

					$client_data[$key]['contact_name'] = $this->getContactNameDropdown($client_row);

					$client_data[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'],
						'Business');
				} else
				if (isset($client_row['client_type']) && $client_row['client_type'] == "ind") {
					$client_data[$key]['client_name'] = $client_row['client_name'];
					$client_data[$key]['contact_type'] = "Individual";
					$client_data[$key]['client_url'] = "/client/edit-ind-client/" . $client_row['client_id'] .
					"/" . base64_encode('ind_client');
					$client_data[$key]['email'] = isset($client_row['serv_email']) ? $client_row['serv_email'] :
					"";
					$client_data[$key]['telephone'] = isset($client_row['serv_telephone']) ? $client_row['serv_telephone'] :
					"";
					$client_data[$key]['mobile'] = isset($client_row['serv_mobile']) ? $client_row['serv_mobile'] :
					"";
					$client_data[$key]['corres_address'] = isset($client_row['address']) ? $client_row['address'] :
					"";
					$client_data[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'],
						'Individual');
				}

			}

		}
            
    $data['client_details'] = $client_data;

		// echo '<pre>';print_r($data['client_details']);die();
		foreach ($data['client_details'] as $value) {
			$clienttype[] = $value['client_name'];
		}
		array_multisort($clienttype, SORT_ASC, $data['client_details']);
        
  	return View::make('hmrc.bkupauthorisations', $data);
	}
     
  public function relationbetween()
  {
    $appwith = Input::get("appwith");
    $c_id = Input::get("c_id");
		if (Request::ajax()) {

			$reltypeone =ClientRelationship::where("client_id",$c_id)->where("appointment_with",$appwith)->select("relationship_type_id")->first();

			$reltypetow =ClientRelationship::where("appointment_with",$c_id)->where("client_id",$appwith)->select("relationship_type_id")->first();

			if($reltypeone['relationship_type_id'] !=""){
    		$relationship_typename=RelationshipType::where("relation_type_id","=",$reltypeone['relationship_type_id'])->select("relation_type")->first();
        header('Content-Type: application/json; charset=utf-8');
				echo json_encode($relationship_typename);
			}
			else{
    		$relationship_typename=RelationshipType::where("relation_type_id","=",$reltypetow['relationship_type_id'])->select("relation_type")->first();
        header('Content-Type: application/json; charset=utf-8');
				echo json_encode($relationship_typename);
			}
    	exit;
  	}
	}
     
  public function pdfload($pdfload)
  {//https://stackoverflow.com/questions/4679756/show-a-pdf-files-in-users-browser-via-php-perl
  	if($pdfload == 'policy'){
  		$url ="http://pdf.fivefilters.org/makepdf.php?v=2.5&url=https%3A%2F%2Fwww.gov.uk%2Fgovernment%2Fpublications.atom%3Fdepartments%255B%255D%3Dhm-revenue-customs%26publication_filter_option%3Dpolicy-papers%26topics%255B%255D%3Dtax-and-revenue&mode=multi-story&output=pdf&template=A4&title=NEWS+FOR+AGENTS+%26+ADVISORS&order=desc&date=true&images=true&api_key=&sub=i-PRACTICE+NEWS";
  	}else if($pdfload == 'guidance'){
  		$url ="http://pdf.fivefilters.org/makepdf.php?v=2.5&url=https%3A%2F%2Fwww.gov.uk%2Fgovernment%2Fpublications.atom%3Fkeywords%3DTAX%26publication_filter_option%3Dguidance%26topics%255B%255D%3Dtax-and-revenue%26departments%255B%255D%3Dhm-revenue-customs%26publication_filter_option%3Dguidance%26topics%255B%255D%3Dtax-and-revenue&mode=multi-story&output=pdf&template=A4&title=NEWS+FOR+AGENTS+%26+ADVISORS&order=desc&date=true&images=true&api_key=&sub=i-PRACTICE+NEWS";
  	}else if($pdfload == 'agent'){
  		$url = "http://pdf.fivefilters.org/makepdf.php?v=2.5&url=https%3A%2F%2Fwww.gov.uk%2Fgovernment%2Fpublications.atom%3Fkeywords=agents%3D%26publication_filter_option%3Dguidance%26topics%255B%255D%3Dtax-and-revenue%26departments%255B%255D%3Dhm-revenue-customs%26publication_filter_option%3Dguidance%26topics%255B%255D%3Dtax-and-revenue&mode=multi-story&output=pdf&template=A4&title=NEWS+FOR+AGENTS+%26+ADVISORS&order=desc&date=true&images=true&api_key=&sub=i-PRACTICE+NEWS";
  	}
  	
    $content = file_get_contents($url);

    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($content));
    header('Content-Disposition: inline; filename="YourFileName.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    ini_set('zlib.output_compression','0');

    die($content);
  }
     
     
    
     
     
}
