<?php
class ContactsLettersEmailsController extends BaseController {
	public function __construct() 
	{
		parent::__construct();
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login')->send();
		}
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}
	}
	
	public function index($step_id, $address_type) 
	{
		$data 							= array();
		$org_data 					= array();
		$data['title'] 			= 'Contacts';
		$data['page_name'] 	= 'contact';
		$data['type'] 			= 'other';
		$data['step_id'] 		= $step_id;
		$data['address_type'] = base64_decode($address_type);
		$data['encoded_type'] = $address_type;
		$data['heading'] 			= "CONTACTS";
		$data['per_page'] 		= 2;

		$data['previous_page']= '<a href="/letters">Letters</a>';

		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 	= $session['group_users'];

		$org_count 		= 0;
		$ind_count 		= 0;
		$staff_count 	= 0;
		$other_count 	= 0;
    $groups_count	= 0;

		if ($step_id == 1) {
			//$details = ContactAddress::getOrgClientContacts(1,$data['per_page'],$data['address_type']);
			//$data['org_details'] 	= $details['details'];
			//$data['pagination'] 	= $details['pagination'];
		} else if ($step_id == 2) {
			/*$ind_details = Client::getAllIndClientDetails();
			if (isset($ind_details) && count($ind_details) > 0) {
				foreach ($ind_details as $key => $client_row) {
					$ind_details[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'ind');

					$ind_count++;
				}
				$data['ind_details'] = $ind_details;
			}*/
		} else if ($step_id == 3) {
			//$data['staff_details'] = User::getAllStaffDetails();
		} else if ($step_id == 4) {
			//$data['contact_details'] = ContactAddress::getAllContactDetails();
			$data['titles'] = Title::orderBy("title_id")->get();
			$data['ContactCompany'] = Client::getClientNameAndId();
		} else if ($step_id == 5) {
			$data['title'] 				= 'Contact Group';
			$data['heading'] 			= "CONTACT GROUP";
			$data['step_details'] = ContactsStep::getAllNewGroupDetails();
		} else {
			$data['title'] 				= 'Contact Group';
			$data['heading'] 			= "CONTACT GROUP";
			$data['step_name'] 		= ContactsStep::getStepNameById($step_id);
			$data['group_details']= ContactAddress::getGroupContactDetails($step_id);
		}

		$data['steps'] = ContactsStep::getAllSteps($org_count, $ind_count, $staff_count, $other_count,$groups_count);
		$data['countries'] 			= Country::orderBy('country_name')->get();
		$data['address_types'] 	= AddressType::getAllAddressDetails();
		//$data['all_address'] 	= ContactAddress::getAllContactAddress();
		$data['cont_address'] 	= ClientAddress::getAllAddressAndId();

    $step_name = ContactsStep::where("step_id", $step_id)->select("title")->first();
        //echo "<pre>";print_r($step_name['title']);die();
        
		return View::make('contacts_letters.index', $data);

	}

	public function pagination()
	{
		$page 		= Input::get('page');
		$page_name 	= Input::get('page_name');
		$per_page 	= Input::get('per_page');

		if($page_name == 'org'){
			$address_type 	= Input::get('address_type');
			$details = ContactAddress::getOrgClientContacts($page,$per_page,$address_type);
		}
		
		$data['org_details'] 	= !empty($details['details'])?$details['details']:array();
		$data['pagination'] 	= !empty($details['pagination'])?$details['pagination']:array();
		$data['address_types'] 	= AddressType::getAllAddressDetails();
		$data['address_type'] 	= $address_type;
		//echo "<pre>";print_r($data);die;
		echo View::make('contacts_letters/ajax/org_tab', $data);
		exit;
	}

	public function demo()
	{
		$client_type = Input::get("client_type");
		if($client_type == "org")
		{
			$data['client_details'] =   Client::getAllOrgClientDetails();
			//echo "<pre>";print_r($data['client_details']);die();
			$client_data=array();
			foreach($data['client_details'] as $key=>$item)
			{
				
				$client_data[$key][]=$item['client_id'];
				$client_data[$key][]=$item['client_type'];
				$client_data[$key][]=$item['business_name'];
				if(isset($item['corres_cont_email']))
					$client_data[$key][]=$item['corres_cont_email'];
				else
					$client_data[$key][]='na';
			}
			//echo json_encode($client_data);
			echo "<pre>";
			print_r($data['client_details']);
		}
		else if($client_type == "ind")
		{
			$data['client_details'] =   Client::getAllIndClientDetails();
			//echo "<pre>";print_r($data['client_details']);die();
			$client_data=array();
			foreach($data['client_details'] as $key=>$item)
			{
				
				$client_data[$key][]=$item['client_id'];
				$client_data[$key][]=$item['client_type'];
				$client_data[$key][]=$item['client_name'];
				if(isset($item['res_email']))
					$client_data[$key][]=$item['res_email'];
				else
					$client_data[$key][]='na';
			}
			echo json_encode($client_data);
		}
		else if($client_type == "staff"){
			$data['staff_details'] = User::getAllStaffDetails();
			//echo "<pre>";print_r($data['staff_details']);die();
			$staff=array();
			foreach($data['staff_details'] as $key=>$item)
			{
				$staff[$key][]=$item['user_id'];
				$staff[$key][]=$item['user_type'];
				$staff[$key][]=$item['fname']." ".$item['lname'];
				$staff[$key][]=$item['email'];
				if(isset($item['email']))
					$staff[$key][]=$item['email'];
				else
					$staff[$key][]='na';
			}
			echo json_encode($staff);
		}
		else if($client_type == "cg"){
			$step_id="5";
			$data['group_details'] = ContactAddress::getGroupContactDetails($step_id);
			echo "<pre>";print_r($data['group_details']);die();
		}
		else if($client_type == "other"){
			$data['contact_details'] = ContactAddress::getAllContactDetails();
			$other=array();
			foreach($data['contact_details'] as $key=>$item)
			{
				$other[$key][]=$item['contact_id'];
				$other[$key][]=$item['contact_type'];
				$other[$key][]=$item['name'];
				if(isset($item['email']))
					$other[$key][]=$item['email'];
				else
					$other[$key][]='na';
				
			}
			echo json_encode($other);
		}	
		
		//echo "<pre>";print_r($data['client_details']);die();
		
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
			if (isset($details['auditors_cont_name']) && $details['auditors_cont_name'] != "") {
				$data[$i]['name'] = $details['auditors_cont_name'];
				$i++;
			}
			if (isset($details['solicitors_cont_name']) && $details['solicitors_cont_name'] != "") {
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

	public function show_contacts_notes() {
		$data = array();
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		$client_id = Input::get("client_id");
		$contact_type = Input::get("contact_type");

		$notes = ContactsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("contact_type", "=", $contact_type)->first();

		if (isset($notes) && count($notes) > 0) {
			$data['notes'] = $notes['notes'];
		}
		echo json_encode($data);
	}

	public function save_contacts_notes() {
		$data = array();
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		$contact_type = Input::get("contact_type");
		$client_id = Input::get("client_id");

		$notes = ContactsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("contact_type", "=", $contact_type)->first();
		$data['notes'] = Input::get("notes");
		if (isset($notes) && count($notes) > 0) {
			ContactsNote::where("notes_id", "=", $notes['notes_id'])->update($data);
			$last_id = $notes['notes_id'];
		} else {
			$data['client_id'] = $client_id;
			$data['contact_type'] = $contact_type;
			$data['user_id'] = $user_id;
			$last_id = ContactsNote::insertGetId($data);
		}

		echo $last_id;exit;
	}

	public function send_letteremail() {
		$data['title'] 	= 'Emails/Letters';
		$url 			= '/contacts-letters-emails/1/'.base64_encode("corres");
		$data['previous_page'] = '<a href="'.$url.'">Contacts Letters & Emails</a>';
		$data['heading'] 	= "EMAILS/LETTERS";
		$admin_s 			= Session::get('admin_details');
		$user_id 			= $admin_s['id'];
		$groupUserId 		= $admin_s['group_users'];
        
		$data['template_types'] = TemplateType::get();
		
        $data['old_services'] 	= Service::where("status", "=", "old")->orderBy("service_name")->get();
            $data['new_services'] 	= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
		if (empty($user_id)) {
			return Redirect::to('/');
		}
		
		$data['ind_client_details'] = Client::getAllIndClientDetails();
		
		//echo "<pre>"; print_r($ind_details); die;
		
		//return View::make('contacts_letters.send_letteremail', $data);
		return View::make('letters.generate_letter', $data);
	}
	
	// Send Email with template
	public function send_letteremail_send() {
		$template=Input::get('template');
		$typeID=Input::get('typeID');
		$subject=Input::get('subject');
		$message_body=Input::get("message_body");
		
		$emails=Input::get("emails");
		$emails = explode(',',$emails);
		
		$vars =	App::make('EmailTemplateController')->placeholdersKV();
		$message_body = strtr($message_body, $vars);
		
		$mail = new \PHPMailer(true);
		try {
			$mail->SMTPDebug = 4;   
			$mail->isSMTP(); // tell to use smtp
			$mail->CharSet = "utf-8"; // set charset to utf8
			$mail->SMTPAuth = true;  // use smpt auth
			$mail->SMTPSecure = "ssl"; // tls/ssl
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 587; // most likely something different for you. This is the mailtrap.io port i use for testing. 
			$mail->Username = "test75741@gmail.com";
			$mail->Password = "plokijuh12345";
			$mail->setFrom("test75741@gmail.com", "Tester 75741");
			$mail->Subject = "Test";
			$mail->MsgHTML("This is a test");
			$mail->addAddress("testdemo198@gmail.com");
			$mail->send();
		} 
		catch (phpmailerException $e) {
			echo $e;
		} 
		catch (Exception $e) {
			echo $e;
		}
		
		//print_r($emails);
	}
	
	
	public function prepare_email_pdf_download() {
		$template=Input::get('template');
		$typeID=Input::get('typeID');
		$subject=Input::get('subject');
		$message_body=Input::get("message_body");
		
		$vars =	App::make('EmailTemplateController')->placeholdersKV();
		$message_body = strtr($message_body, $vars);
		
		Session::push('email-template', $template);
		Session::push('email-typeID', $typeID);
		Session::push('email-subject', $subject);
		Session::push('email-message_body', $message_body);
		
		return $message_body;
	}
	
	// Generate PDF with template
	public function generate_email($as) {
				
		$template=Session::get('email-template');
		$typeID=Session::get('email-typeID');
		$subject=Session::get('email-subject');
		$message_body=Session::get('email-message_body');
		
		$vars =	App::make('EmailTemplateController')->placeholdersKV();
		//$message_body = strtr($message_body, $vars);
		
		$data['template']=$template[0];
		$data['typeID']=$typeID[0];
		$data['subject']=$subject[0];
		$data['message_body']=$message_body[0];
		
		//echo "<pre>";print_r($data);
		if($as == "pdf")
		{
			$pdf = PDF::loadView('contacts_letters.emailHTML', $data);
			return $pdf->download('ContactsLetters_Emails.pdf');
		}
		if($as == "preview")
		{
			return View::make('contacts_letters.emailHTML', $data);
		}
		
	}

	public function save_contacts_group() {
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		$data['user_id'] = $user_id;
		$data['title'] = strtoupper(Input::get("group_name"));
		$data['short_code'] = strtolower(str_replace(" ", "_", $data['title']));
		$data['status'] = "S";
		$data['step_type'] = "new";
		$data['parent_step_id'] = Input::get("step_id");

		$last_id = ContactsStep::insertGetId($data);
		echo $last_id;exit;
	}

	public function insert_contact_details() 
	{
		$data 					= array();
		$session 				= Session::get('admin_details');
		$user_id 				= $session['id'];
		$groupUserId 		= $session['group_users'];
		$contact_id 		= Input::get("contact_id");
		$added_from 		= Input::get("AddedFrom");
		$tab_id 				= Input::get("tab_index");
		$address_type 	= Input::get("encoded_type");
		$change_contact = Input::get("change_contact");
		$client_id 			= Input::get("Company_id");
		$ref_client_id  = Input::get("reference_client_id");

		if($added_from == 'edit_org'){
			$data['contact_type'] 	= 'company_name';
		}else{
			$data['contact_type'] 	= Input::get("contact_type");
		}

		$data['user_id'] 				= $user_id;
		$data['contact_title'] 	= Input::get("contact_title");
		$data['contact_fname'] 	= Input::get("contact_fname");
		$data['contact_mname'] 	= Input::get("contact_mname");
		$data['contact_lname'] 	= Input::get("contact_lname");
		$data['telephone'] 			= Input::get("telephone");
		$data['mobile'] 				= Input::get("mobile");
		$data['email'] 					= Input::get("email");
		$data['position'] 			= Input::get("position");
		$data['address_id'] 		= Input::get("address");
		$data['reference_client_id'] = $ref_client_id;
		$data['added_from'] 		= $added_from;
		$data['change_contact'] = $change_contact;

		if(isset($change_contact) && $change_contact == 'Y'){
			if($contact_id >0){
				ContactAddress::where("contact_id", $contact_id)->delete();
			}
			
			$data['prospect_title'] = $data['contact_title'];
			$data['prospect_fname'] = $data['contact_fname'];
			$data['prospect_mname'] = $data['contact_mname'];
			$data['prospect_lname'] = $data['contact_lname'];
			$data['phone'] 					= $data['telephone'];
			$indClnt['user_id']     = $user_id;
      $indClnt['type']        = 'ind';
      $indClnt['chd_type']    = 'ind';
      if($ref_client_id > 0){
      	$ind_client_id = $ref_client_id;
      	$type_id = ClientRelationship::getTypeId($client_id, $ind_client_id);
      	$relTDa['relation_type'] = $data['position'];
      	RelationshipType::where('relation_type_id', $type_id)->update($relTDa);
      	$rel_id = ClientRelationship::getRelId($client_id, $ind_client_id);
      }else{
      	$ind_client_id = Client::insertGetId($indClnt);
      	$rtarr['relation_type'] = $data['position'];
	  		$rtarr['show_status'] 	= 'individual';
	  		$id = RelationshipType::insertGetId($rtarr);

	  		$dataRel['client_id'] 						= $client_id;
				$dataRel['relationship_type_id'] 	= $id;
	      $dataRel['appointment_with'] 			= $ind_client_id;
	      $rel_id = ClientRelationship::insertGetId($dataRel);
      }
			
			StepsFieldsClient::update_ind_client($data, $ind_client_id);

			$data['contact_id'] 		= $ind_client_id;
      $data['contact_name'] 	= Client::getClientNameByClientId($ind_client_id);
      $data['contact_type'] 	= 'R';
      $data['link'] = '/client/edit-ind-client/'.$ind_client_id.'/'.base64_encode('ind_client');
      $data['rel_id'] 				= $rel_id;
		}else{
			$data['client_id'] 	= $client_id;
			if($contact_id > 0) {
				ContactAddress::where("contact_id", $contact_id)->update($data);
			}else{
				$contact_id = ContactAddress::insertGetId($data);
			}

			if($added_from == 'contact'){
				$data['loadUrl'] = '/contacts-letters-emails/'.$tab_id.'/'.$address_type;
			}else{
				$data['contact_id']	  	= $contact_id;
				$data['contact_name'] 	= ContactAddress::getContactNameById($contact_id);
				$data['contact_type'] 	= 'C';
			}
		}
		echo json_encode($data);
	}

	public function search_address() {
		$data = array();
		$address_type = Input::get("address_type");
		$client_id = Input::get("client_id");
		$address = ContactAddress::getContactAddressByType($client_id, $address_type);

		echo json_encode($address);
	}

	public function save_edit_group() {
		$data = array();
		$step_id = Input::get('step_id');
		$data['short_code'] = strtolower(Input::get("group_name"));
		$data['title'] = Input::get("group_name");

		$sql = ContactsStep::where("step_id", "=", $step_id)->update($data);

		echo $sql;
		exit;
	}

	public function copy_to_group() {
		$step = array();
		$data = array();

		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

		$group_id 		= Input::get('group_id');
		$tab_id 		= Input::get('tab_id');
		$group_name 	= Input::get('group_name');
		$client_ids 	= explode(",", Input::get('client_ids'));
		$contact_type 	= ContactsGroup::getContacttype($tab_id);

		if (isset($group_name) && $group_name != "") {
			$step['user_id'] = $user_id;
			$step['parent_step_id'] = $tab_id;
			$step['short_code'] = str_replace(" ", "_", strtolower($group_name));
			$step['title'] = $group_name;
			$step['status'] = "S";
			$step['step_type'] = "new";
			$group_id = ContactsStep::insertGetId($step);
		}

		if (isset($group_id) && $group_id != "") {
			if (isset($client_ids) && count($client_ids) > 0) {
				foreach ($client_ids as $key => $client_id) {
					$details = ContactsGroup::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("group_id", "=", $group_id)->where("contact_type", "=", $contact_type)->select("groups_contact_id")->first();
					if ($details['groups_contact_id'] == "") {
						$data['user_id'] = $user_id;
						$data['client_id'] = $client_id;
						$data['group_id'] = $group_id;
						$data['contact_type'] = $contact_type;
						ContactsGroup::insert($data);
					}

				}
			}
		}
		//ContactsGroup
		//print_r($client_ids);
		echo 1;die;
	}

	public function delete_group() {
		$step_id = Input::get('step_id');
		$query = ContactsStep::where("step_id", "=", $step_id)->delete();
		if ($query) {
			echo 1;die;
		} else {
			echo 0;die;
		}
	}

	public function delete_from_group() {
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		$client_id = Input::get('client_id');
		$group_id = Input::get('tab_id');
		$contact_type = Input::get('contact_type');

		$query = ContactsGroup::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("group_id", "=", $group_id)->where("contact_type", "=", $contact_type)->delete();
		if ($query) {
			echo 1;die;
		} else {
			echo 0;die;
		}
	}

	public function show_contact_group() {
		$data = array();
		$contact_type = Input::get('contact_type');
		$contact = explode("_", $contact_type);
		if ($contact[0] == "other") {
			$address = ContactAddress::getContactDetailsById($contact[1]);
			if (isset($address) && count($address) > 0) {
				$data['address1'] = $address['addr_line1'];
				$data['address2'] = $address['addr_line2'];
				$data['city'] = $address['city'];
				$data['county'] = $address['county'];
				$data['postcode'] = $address['postcode'];
				$data['country'] = $address['country'];
			}

		} else {
			$data = ContactAddress::getClientContactAddress($contact[1], $contact[0]);
		}
		//print_r($data);die;
		echo json_encode($data);
		exit;

	}

	public function get_contact_details() {
		$address = array();
		$contact_type 	= Input::get('contact_type');
		$contact_id 	= Input::get('contact_id');
		$added_from 	= Input::get('added_from');

		$address = ContactAddress::getContactDetailsById($contact_id);
		if($added_from == 'edit_org'){
			$client_id 	= Input::get('client_id');
		}
		//print_r($data);die;
		echo json_encode($address);
		exit;

	}

	public function delete_contact_address() {
		$contact_id = Input::get('contact_id');
		$query = ContactAddress::where("contact_id", "=", $contact_id)->delete();
		if ($query) {
			echo 1;die;
		} else {
			echo 0;die;
		}
	}

	public function view_contact_address() {
		$contact_id = Input::get('contact_id');
		$details = ContactAddress::getContactDetailsById($contact_id);
		$data['address'] = $details;
		echo json_encode($data);
	}

	public function view_client_address() { 
		$data = array();
		$client_id = Input::get('client_id');
		$client_type = Client::getClientTypeByClientId($client_id);
		if($client_type == 'org'){
			$addr = 'corres';$ar = 'contact';
		}else{
			$addr = 'res';$ar = 'res_';
		}
		
		$address = Client::getAddressByClientIdAndType($client_id, $addr);
		$data['address'] = $address;
		$data['contact_name'] 	= Client::getClientNameByClientId($client_id);
		$data['contact_title'] 	= StepsFieldsClient::getFieldValueByClientId($client_id, 'title');
		$data['contact_fname'] 	= StepsFieldsClient::getFieldValueByClientId($client_id, 'fname');
		$data['contact_mname'] 	= StepsFieldsClient::getFieldValueByClientId($client_id, 'mname');
		$data['contact_lname'] 	= StepsFieldsClient::getFieldValueByClientId($client_id, 'lname');
		$data['email'] 			= StepsFieldsClient::getFieldValueByClientId($client_id, $ar.'email');
		$data['telephone'] 	= StepsFieldsClient::getFieldValueByClientId($client_id, $ar.'telephone');
		$data['mobile'] 		= StepsFieldsClient::getFieldValueByClientId($client_id, $ar.'mobile');
		$data['website'] 		= StepsFieldsClient::getFieldValueByClientId($client_id, $ar.'website');
		$data['position'] 	= StepsFieldsClient::getFieldValueByClientId($client_id, 'position');
		$data['skype'] 			= StepsFieldsClient::getFieldValueByClientId($client_id, $ar.'skype');
		echo json_encode($data);
	}



	public function cletab1pdf() {
		$step_id = "1";
		$address_type = "corres";
		$data = array();
		$org_data = array();
		$data['title'] = 'Contacts Letters & Emails';
		$data['step_id'] = $step_id;
		$data['address_type'] = base64_decode($address_type);
		$data['encoded_type'] = $address_type;
		$data['heading'] = "CONTACTS, LETTERS & EMAILS";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		$org_count = 0;
		$ind_count = 0;
		$staff_count = 0;
		$other_count = 0;

		if ($step_id == 1) {
			$org_details = Client::getAllOrgClientDetails();
			if (isset($org_details) && count($org_details) > 0) {
				foreach ($org_details as $key => $client_row) {
					//$org_details[$key]['contact_name'] 	= $this->getContactNameDropdown($client_row);
					$org_details[$key]['other_details'] = ContactAddress::getContactAddressByType($client_row['client_id'], $data['address_type']);
					$org_details[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'org');

					$org_count++;
				}
				$data['org_details'] = $org_details;
			}
		} else if ($step_id == 2) {
			$ind_details = Client::getAllIndClientDetails();
			if (isset($ind_details) && count($ind_details) > 0) {
				foreach ($ind_details as $key => $client_row) {
					$ind_details[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'ind');

					$ind_count++;
				}
				$data['ind_details'] = $ind_details;
			}
		} else if ($step_id == 3) {
			$data['staff_details'] = User::getAllStaffDetails();
		} else if ($step_id == 4) {
			$data['contact_details'] = ContactAddress::getAllContactDetails();
		} else {
			$data['group_details'] = ContactAddress::getGroupContactDetails($step_id);
		}

		$data['steps'] = ContactsStep::getAllSteps($org_count, $ind_count, $staff_count, $other_count);
		$data['countries'] = Country::orderBy('country_name')->get();
		$data['address_types'] = AddressType::getAllAddressDetails();
		$data['all_address'] = ContactAddress::getAllContactAddress();

		//echo "<pre>";print_r($data['group_details']);echo "</pre>";die;
		//	return View::make('contacts_letters.index', $data);

		$pdf = PDF::loadView('contacts_letters.tab1clelistpdf', $data);

		return $pdf->download('ContactsLetters_Emails.pdf');

	}
    
    
    
    public function pdfindex($step_id,$address_type){
        $data = array();
		$org_data = array();
        $final_arr = array();
        $t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;

		$data['title'] = 'Contacts Letters & Emails';
		$data['step_id'] = $step_id;
        $data['address_type']="corres";
		$data['address_type'] = base64_decode($address_type);
		$data['encoded_type'] = $address_type;
		$data['heading'] = "CONTACTS, LETTERS & EMAILS";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}
	


        $org_count 		= 0;
		$ind_count 		= 0;
		$staff_count 	= 0;
		$other_count 	= 0;
        $groups_count 	= 0;

		if ($step_id == 1) {
		  //$searchvalue="rose";
			$org_details = Client::getAllOrgClientDetails();
			if (isset($org_details) && count($org_details) > 0) {
				foreach ($org_details as $key => $client_row) {
					//$org_details[$key]['contact_name'] 	= $this->getContactNameDropdown($client_row);
					$org_details[$key]['other_details'] = ContactAddress::getContactAddressByType($client_row['client_id'], $data['address_type']);
					$org_details[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'org');

					$org_count++;
				}
			
            	$data['org_details'] = $org_details;
		    }
        } else if ($step_id == 2) {
			$ind_details = Client::getAllIndClientDetails();
			if (isset($ind_details) && count($ind_details) > 0) {
				foreach ($ind_details as $key => $client_row) {
					$ind_details[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'ind');

					$ind_count++;
				}
				$data['ind_details'] = $ind_details;
			}
		} else if ($step_id == 3) {
			$data['staff_details'] = User::getAllStaffDetails();
		} else if ($step_id == 4) {
			$data['contact_details'] = ContactAddress::getAllContactDetails();
		} else if ($step_id == 5) {
			$data['step_details'] = ContactsStep::getAllNewGroupDetails();
		} else {
			$data['step_name'] 		= ContactsStep::getStepNameById($step_id);
			$data['group_details'] 	= ContactAddress::getGroupContactDetails($step_id);
		}

		$data['steps'] = ContactsStep::getAllSteps($org_count, $ind_count, $staff_count, $other_count,$groups_count);
		$data['countries'] 		= Country::orderBy('country_name')->get();
		$data['address_types'] 	= AddressType::getAllAddressDetails();
		$data['all_address'] 	= ContactAddress::getAllContactAddress();

		//echo "<pre>";print_r($data['steps']);die();
        $step_name = ContactsStep::where("step_id","=",$step_id)->select("title")->first();
        
       // $data['step_title']=$step_name['title'];
		$pdffile_Name="";
        if($step_id==1){
            $pdffile_Name="CONTACT_ORGANISATIONS";
        }
        else if($step_id==2){
            $pdffile_Name="CONTACT_INDIVIDUALS";
        }
        else if($step_id==3){
            $pdffile_Name="CONTACTS_STAFF";
        }
       else if($step_id==4){
            $pdffile_Name="CONTACT_OTHERS";
        }
        else if($step_id==5){
            $pdffile_Name="CONTACT_GROUPS";
        }
        else{
            $pdffile_Name="CONTACT_".$data['step_name'];
        }
        	$pdf = PDF::loadView('contacts_letters/pdfindex', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		//$cover_pdf = PDF::loadView('home/organisation/orgcoverpdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
		$output = $pdf->output();
		$dom_pdf = $pdf->getDomPDF();

		$canvas = $dom_pdf->get_canvas();
		//echo $canvas->get_page_number();die;
             $bname="CONTACTS_LETTERS_EMAILS";
		return $pdf->download($pdffile_Name. '.pdf');die();
        
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

        $bname="CONTACTS_LETTERS_EMAILS";
		return $pdf->download($bname . '.pdf');
		//return View::make('contacts_letters.index', $data);

    }
    
    
    
    public function excelindex($step_id,$address_type)
    {
        $data = array();
		$org_data = array();
        $t = time();
		$time = date("Y-m-d H:i:s", $t);
		$pieces = explode(" ", $time);
		$data['cdate'] = $pieces[0];

		$data['ctime'] = $pieces[1];

		$today = date("j F  Y");
		$data['today'] = $today;

		$time = date(" G:i:s ");
		$data['time'] = $time;

		$data['title'] = 'Contacts Letters & Emails';
		$data['step_id'] = $step_id;
        $data['address_type']="corres";
		$data['address_type'] = base64_decode($address_type);
		$data['encoded_type'] = $address_type;
		$data['heading'] = "CONTACTS, LETTERS & EMAILS";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		$org_count = 0;
		$ind_count = 0;
		$staff_count = 0;
		$other_count = 0;

		if ($step_id == 1) {
			$org_details = Client::getAllOrgClientDetails();
			if (isset($org_details) && count($org_details) > 0) {
				foreach ($org_details as $key => $client_row) {
					//$org_details[$key]['contact_name'] 	= $this->getContactNameDropdown($client_row);
				
                	$org_details[$key]['other_details'] = ContactAddress::getContactAddressByType($client_row['client_id'], $data['address_type']);
				
                	$org_details[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'org');

					$org_count++;
				}
				$data['org_details'] = $org_details;
			}
		} 
        
        else if ($step_id == 2) {
			$ind_details = Client::getAllIndClientDetails();
			if (isset($ind_details) && count($ind_details) > 0) {
				foreach ($ind_details as $key => $client_row) {
					$ind_details[$key]['notes'] = ContactsNote::getNotes($client_row['client_id'], 'ind');

					$ind_count++;
				}
				$data['ind_details'] = $ind_details;
			}
		} else if ($step_id == 3) {
			$data['staff_details'] = User::getAllStaffDetails();
		} else if ($step_id == 4) {
			$data['contact_details'] = ContactAddress::getAllContactDetails();
		}else if ($step_id == 5) {
			$data['step_details'] = ContactsStep::getAllNewGroupDetails();
		}else {
            $data['step_name'] 		= ContactsStep::getStepNameById($step_id);
			$data['group_details'] 	= ContactAddress::getGroupContactDetails($step_id);
		}

	//	$data['steps'] = ContactsStep::getAllSteps($org_count, $ind_count, $staff_count, $other_count);
		$data['countries'] = Country::orderBy('country_name')->get();
		$data['address_types'] = AddressType::getAllAddressDetails();
		$data['all_address'] = ContactAddress::getAllContactAddress();
        
     //   $step_name=ContactsStep::where("step_id","=",$step_id)->select("title")->first();
        
        
       // $data['step_title']=$step_name['title'];
    $excelfile_Name="";
        if($step_id==1){
            $excelfile_Name="CONTACT_ORGANISATIONS";
        }
        else if($step_id==2){
            $excelfile_Name="CONTACT_INDIVIDUALS";
        }
        else if($step_id==3){
            $excelfile_Name="CONTACTS_STAFF";
        }
       else if($step_id==4){
            $excelfile_Name="CONTACT_OTHERS";
        }
        else if($step_id==5){
            $excelfile_Name="CONTACT_GROUPS";
        }
        else{
            $excelfile_Name="CONTACT_".$data['step_name'];
        }
        //echo $fileName ;die();
        $viewToLoad = 'contacts_letters/excelindex';
			///////////  Start Generate and store excel file ////////////////////////////
			Excel::create('excelInd', function ($excel) use ($data, $viewToLoad) {

				$excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad) {
					$sheet->loadView($viewToLoad)->with($data);
				})->save();

			});
        
        //
        
	   
		$filepath = storage_path() . '/exports/excelInd.xls';
		$fileName = $excelfile_Name.'.xls';
		$headers = array(
			'Content-Type: application/vnd.ms-excel',
		);

		return Response::download($filepath, $fileName, $headers);
		exit;
    }
    
    
    public function gettemplatename()
    {
        
      $template_id = Input::get("template_id");
      $session = Session::get('admin_details');
			$groupUserId = $session['group_users'];
			$user_id 		= $session['id'];
      $data = array();
      
      $data=EmailTemplate::where("template_type_id","=",$template_id)->where("user_id","=",$user_id)->select("email_template_id","name")->get();
      
      echo  View::make('contacts_letters.typenamedropdown')->with('data', $data);
    }

    public function massemail()
    {
      $data['heading'] = " Mass Email";
      $data['title'] = " Mass Email";
			$data['previous_page']= '<a href="/contacts-letters-emails/1/Y29ycmVz">Contacts Letters & Emails</a>';
			$session = Session::get('admin_details');
			$groupUserId = $session['group_users'];
			$user_id 		= $session['id'];
      $cliendetails=Client::getAllIndClientDetails();
      $cdata=array();
    	
    	return View::make("contacts_letters.massemail", $data);
    }
    

    public function get_contact_org()
    {
    	$rows 			= array();
    	$data 			= $matches = array();
			$start 			= $_GET['jtStartIndex'];
			$limit 			= $_GET['jtPageSize'];
			$sorting 		= $_GET['jtSorting'];
			$sort 			= explode(' ', $sorting);

			$search 		= isset($_POST["search"])?trim($_POST['search']):'';
			$addr_type 	= $_GET["address_type"];
			$type 			= $_GET["client_type"];

			$details = ContactAddress::orgClientContacts($start,$limit,$addr_type,$type,$sorting,$search);
			//echo "<pre>";print_r($details);die;
			if(isset($details['details']) && count($details['details']) >0){
				foreach($details['details'] as $i=>$v){
					$matches[$i]['key'] 						= $i;
					$matches[$i]['client_id'] 			= $v['client_id'];
					$matches[$i]['client_name'] 		= ($v['client_name'] != null)?$v['client_name']:'';
					$matches[$i]['type'] 						= $v['type'];
					$matches[$i]['contact_person'] 	= ($v['contact_person'] != null)?$v['contact_person']:'';
					$matches[$i]['telephone'] 			= ($v['telephone'] != null)?$v['telephone']:'';
					$matches[$i]['mobile'] 					= ($v['mobile'] != null)?$v['mobile']:'';
					$matches[$i]['email'] 					= ($v['email'] != null)?$v['email']:'';
					$matches[$i]['address'] 				= ($v['address'] != null)?$v['address']:'';
					$matches[$i]['notes'] 					= ($v['notes'] != null)?$v['notes']:'';
					$matches[$i]['address_types'] 	= AddressType::getAllAddressDetails();
					$matches[$i]['org_client'] 			= base64_encode('org_client');
					$matches[$i]['ind_client'] 			= base64_encode('ind_client');
					$matches[$i]['res_telephone'] 	= ($v['res_telephone'] != null)?$v['res_telephone']:'';
					$matches[$i]['res_mobile'] 			= ($v['res_mobile'] != null)?$v['res_mobile']:'';
					$matches[$i]['res_email'] 			= ($v['res_email'] != null)?$v['res_email']:'';
					$matches[$i]['serv_address'] 		= ($v['serv_address'] != null)?$v['serv_address']:'';
				}
			} 

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] 						= "OK";
			$jTableResult['TotalRecordCount'] 	= $details['TotalRecord'];
			$jTableResult['Records'] 						= $matches;
			print json_encode($jTableResult);
    }

    public function get_contact_tab()
    {
    	$m = array();
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
	        $m[$i]['key']                 = $i;
	        $m[$i]['client_id']           = $client_id;
	        $m[$i]['client_type']         = $v['type'];
	        $m[$i]['client_name']         = $v['client_name'];
	        $m[$i]['business_type']       = !empty($v['business_type'])?$v['business_type']:'';
	        $m[$i]['org_client']          = base64_encode('org_client');
	        $m[$i]['ind_client']          = base64_encode('ind_client');


	      }
	    }

	    $jTableResult = array();
	    $jTableResult['Result']             = "OK";
	    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
	    $jTableResult['Records']            = $m;
	    
	    return $jTableResult;
    }

    public function get_tab_details()
    {
    	$m = array();
	    $sendData['start']        = $_GET['jtStartIndex'];
	    $sendData['limit']        = $_GET['jtPageSize'];
	    $sendData['sorting']      = $_GET['jtSorting'];
	    $sendData['search']       = isset($_POST["search"])?trim($_POST['search']):'';
	    $sendData['tab_id']   		= isset($_POST["tab_id"])?trim($_POST['tab_id']):'0';

	    $details = User::get_tab_details($sendData);
	    if(isset($details['details']) && count($details['details']) >0){
	      foreach($details['details'] as $i=>$v){
	        $user_id    	= $v['user_id'];
	        $m[$i]['key']                 = $i;
	        $m[$i]['user_id']           	= $user_id;
	        $m[$i]['staff_name']         	= !empty($v['staff_name'])?$v['staff_name']:'';
	        $m[$i]['telephone']         	= !empty($v['telephone'])?$v['telephone']:'';
	        $m[$i]['mobile']         			= !empty($v['mobile'])?$v['mobile']:'';
	        $m[$i]['email']         			= !empty($v['email'])?$v['email']:'';
	        $m[$i]['address']         		= !empty($v['address'])?$v['address']:'';
	        $m[$i]['notes']         			= !empty($v['notes'])?$v['notes']:'';
	      }
	    }

	    $jTableResult = array();
	    $jTableResult['Result']             = "OK";
	    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
	    $jTableResult['Records']            = $m;
	    
	    return $jTableResult;
    }

    public function get_tab_others()
    {
    	$m = array();
	    $sendData['start']        = $_GET['jtStartIndex'];
	    $sendData['limit']        = $_GET['jtPageSize'];
	    $sendData['sorting']      = $_GET['jtSorting'];
	    $sendData['search']       = isset($_POST["search"])?trim($_POST['search']):'';
	    $sendData['tab_id']   		= isset($_POST["tab_id"])?trim($_POST['tab_id']):'0';

	    $details = ContactAddress::get_tab_others($sendData);
	    //echo "<pre>";print_r($details);die;
	    if(isset($details['details']) && count($details['details']) >0){
	      foreach($details['details'] as $i=>$v){
	        $contact_id    	= $v['contact_id'];
	        $m[$i]['key']                 = $i;
	        $m[$i]['contact_id']          = $contact_id;
	        $m[$i]['name']        				= !empty($v['name'])?$v['name']:'';
	        $m[$i]['contact_name']        = !empty($v['contact_name'])?$v['contact_name']:'';
	        $m[$i]['telephone']         	= !empty($v['telephone'])?$v['telephone']:'';
	        $m[$i]['mobile']         			= !empty($v['mobile'])?$v['mobile']:'';
	        $m[$i]['email']         			= !empty($v['email'])?$v['email']:'';
	        $m[$i]['address']         		= !empty($v['address'])?$v['address']:'';
	        $m[$i]['notes']         			= !empty($v['notes'])?$v['notes']:'';
	      }
	    }

	    $jTableResult = array();
	    $jTableResult['Result']             = "OK";
	    $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
	    $jTableResult['Records']            = $m;
	    
	    return $jTableResult;
    }
    

    public function get_contact_org1()
    {die('Anwar');
    	$rows 			= array();
		$address_type 	= $_POST["address_type"];

		$details = ContactAddress::getClientContacts(0, 1, $address_type, 'org');
		//echo "<pre>";print_r($details);die;
		if(isset($details['details']) && count($details['details']) >0){
			foreach($details['details'] as $i=>$v){
				$rows[$i]['key'] 			= $i;
				$rows[$i]['client_id'] 		= $v['client_id'];
				$rows[$i]['client_name'] 	= ($v['client_name']!= 'null')?$v['client_name']:'';
				$rows[$i]['type'] 			= ($v['type'] != 'null')?$v['type']:'';
				$rows[$i]['contact_person'] = ($v['contact_person'] != null)?$v['contact_person']:'';
				$rows[$i]['telephone'] 		= ($v['telephone']!= 'null')?$v['telephone']:'';
				$rows[$i]['mobile'] 		= !empty($v['mobile'])?$v['mobile']:'';
				$rows[$i]['email'] 			= !empty($v['email'])?$v['email']:'';
				$rows[$i]['address'] 		= !empty($v['address'])?$v['address']:'';
				$rows[$i]['notes'] 			= !empty($v['notes'])?$v['notes']:'';
				$rows[$i]['address_types'] 	= AddressType::getAllAddressDetails();
			}
		}

		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] 			= "OK";
		$jTableResult['Records'] 			= $rows;
		$jTableResult['TotalRecordCount'] 	= $details['total_records'];
		print json_encode($jTableResult);
    }

    public function get_contact_org2(){
        $address_type = Input::get('address_type');

        $length     = Input::get('length');
        $start      = Input::get('start');
        $draw       = Input::get('draw');
        
        $details 		= ContactAddress::getClientContacts($start, $length, $address_type, 'org');
        $results 		= $details['details'];
        $total_records 	= $details['total_records'];

        if (isset($length)) {
            $start  = (isset($start) ? $start : 0);
        }

        foreach ($results as $v) {
            $new_row    = array();

            $new_row[]  = $v['client_id'];
            $new_row[]  = $v['client_name'];
            $new_row[]  = AddressType::getAllAddressDetails();
            $new_row[]  = $v['contact_person'];
            $new_row[]  = $v['telephone'];
            $new_row[]  = $v['mobile'];
            $new_row[]  = $v['email'];
            $new_row[]  = $v['address'];
            $new_row[]  = $v['notes'];
            
            $return_array[] = $new_row;
        }

        if ($total_records == 0) {
            echo '{
                "draw": ' . (isset($draw) ? $draw : '1') . ',
                "recordsTotal": "'.$total_records.'",
                "recordsFiltered": "0",
                "data": []
            }';
        } else {
            $return_assoc = array(
                'data'              => $return_array,
                'draw'              => (isset($draw) ? $draw : '1'),
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records
            );
            print_r(json_encode($return_assoc));die;
        }
        /* ============================= */
    }


}
