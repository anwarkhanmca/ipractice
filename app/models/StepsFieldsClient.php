<?php
class StepsFieldsClient  extends Eloquent{
	
	public $timestamps = false;
	public static function update_step_field_client($details, $client_id)
  {
    $admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

  	$name = "";
  	$step_id = 3;
    if (isset($details['contact_title'])) {
			$name .= $details['contact_title'];
		}
		if (isset($details['contact_fname'])) {
			$name .= " ".$details['contact_fname'];
		}
		if (isset($details['contact_lname'])) {
			$name .= " ".$details['contact_lname'];
		}
		$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'corres_cont_name', $name);
		$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'cont_corres_addr', 'corres');
		$arrData[] = Client::save_client($user_id,$client_id,$step_id,'corres_name_check','corres_cont');

		if (isset($details['phone'])) {
			$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'corres_cont_telephone', $details['phone']);
		}
		if (isset($details['mobile'])) {
			$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'corres_cont_mobile', $details['mobile']);
		}
		if (isset($details['email'])) {
			$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'corres_cont_email', $details['email']);
		}
		if (isset($details['website'])) {
			$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'corres_cont_website', $details['website']);
		}
		if(isset($d['address_id']) && $d['address_id'] >0) {
			$arrData[] = Client::save_client($user_id,$client_id, $step_id, 'corres_address',$d['address_id']);
		}

		$address1 = $postcode = "";
		$address = array();
		if (isset($details['street'])) {
			$address1 = $details['street'];
			$address['address1'] = $address1;
		}
		if (isset($details['city'])) {
			$address['city'] = $details['city'];
		}
		if (isset($details['county'])) {
			$address['county'] = $details['county'];
		}
		if (isset($details['postal_code'])) {
			$postcode = $details['postal_code'];
			$address['postcode'] = $postcode;
		}
		if (isset($details['country_id'])) {
			$address['country'] = $details['country_id'];
		}

		$inserted = StepsFieldsClient::insert($arrData);

		Client::saveAddress($address, 'corres', $client_id, $address1, $postcode);
		
		return $inserted;
  }

  public static function update_ind_client($d, $client_id)
  {
  	//echo "<pre>";print_r($d);die;
  	$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

  	$name = "";
  	$step_id = 3;
  	if (isset($d['prospect_title'])) {
  		StepsFieldsClient::deleteField($client_id, 'title');
			$arrData[] = Client::save_client($user_id, $client_id, 1, 'title', $d['prospect_title']);
		}
		if (isset($d['prospect_fname'])) {
			$name .= " ".$d['prospect_fname'];
			StepsFieldsClient::deleteField($client_id, 'fname');
			$arrData[] = Client::save_client($user_id, $client_id, 1, 'fname', $d['prospect_fname']);
		}
		if (isset($d['prospect_mname'])) {
			$name .= " ".$d['prospect_mname'];
			StepsFieldsClient::deleteField($client_id, 'mname');
			$arrData[] = Client::save_client($user_id, $client_id, 1, 'mname', $d['prospect_mname']);
		}
		if (isset($d['prospect_lname'])) {
			$name .= " ".$d['prospect_lname'];
			StepsFieldsClient::deleteField($client_id, 'lname');
			$arrData[] = Client::save_client($user_id, $client_id, 1, 'lname', $d['prospect_lname']);
		}
		StepsFieldsClient::deleteField($client_id, 'client_name');
		$arrData[] = Client::save_client($user_id, $client_id, 1, 'client_name', $name);

		if (isset($d['phone'])) {
			StepsFieldsClient::deleteField($client_id, 'res_telephone');
			$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'res_telephone', $d['phone']);
		}
		if (isset($d['mobile'])) {
			StepsFieldsClient::deleteField($client_id, 'res_mobile');
			$arrData[] = Client::save_client($user_id,$client_id, $step_id,'res_mobile',$d['mobile']);
		}
		if (isset($d['email'])) {
			StepsFieldsClient::deleteField($client_id, 'res_email');
			$arrData[] = Client::save_client($user_id, $client_id, $step_id,'res_email', $d['email']);
		}
		if (isset($d['website'])) {
			StepsFieldsClient::deleteField($client_id, 'res_website');
			$arrData[] = Client::save_client($user_id, $client_id, $step_id, 'res_website', $d['website']);
		}
		if(isset($d['address_id']) && $d['address_id'] >0) {
			StepsFieldsClient::deleteField($client_id, 'res_address');
			$arrData[] = Client::save_client($user_id,$client_id, $step_id, 'res_address',$d['address_id']);
		}
		if(isset($d['position']) && $d['position'] != '') {
			StepsFieldsClient::deleteField($client_id, 'position');
			$arrData[] = Client::save_client($user_id,$client_id, $step_id, 'position',$d['position']);
		}

		$inserted = StepsFieldsClient::insert($arrData);
		return $inserted;
	}

	public static function update_org_client($d, $client_id)
  { 
  	//echo "<pre>";print_r($d);die;
  	$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

  	$name = "";
  	$step_id = 1;
  	//$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'corres_name_check', 'corres_cont');
  	if(isset($d['address_id']) && $d['address_id'] >0) {
			$arrData[] = Client::save_client($user_id,$client_id,3,'corres_address',$d['address_id']);
			$arrData[] = Client::save_client($user_id, $client_id, 3, 'cont_corres_addr','corres');
		}
  	if(isset($d['business_type'])) {
			$arrData[]=Client::save_client($user_id,$client_id,1,'business_type',$d['business_type']);
		}
		if (isset($d['prospect_name'])) {
			$arrData[]=Client::save_client($user_id,$client_id,1,'business_name',$d['prospect_name']);
		}

		/*if (isset($d['phone'])) {
			$arrData[] = Client::save_client($user_id, $client_id, 3, 'contacttelephone',$d['phone']); 
		}
		if (isset($d['mobile'])) {
			$arrData[] = Client::save_client($user_id, $client_id, 3, 'contactmobile',$d['mobile']);
		}
		if (isset($d['email'])) {
			$arrData[] = Client::save_client($user_id, $client_id, 3, 'contactemail',$d['email']);
		}*/
		if (isset($d['website'])) {
			$arrData[] = Client::save_client($user_id, $client_id, 3, 'contactwebsite',$d['website']);
		}
		if (isset($d['contact_person'])) {
			if(isset($d['person_type']) && $d['person_type'] == 'R'){
				$person = $d['contact_person'].'_'.$d['person_type'];
				$arrData[]=Client::save_client($user_id, $client_id, 3,'primary_contacts',$person);
				$arrData[]=Client::save_client($user_id, $client_id, 3,'contact_person',$d['contact_person']);
				$arrData[]=Client::save_client($user_id, $client_id, 3,'person_type',$d['person_type']);
        $person_name  = Client::getClientNameByClientId($d['contact_person']);
        $arrData[] 		= Client::save_client($user_id, $client_id, 3, 'person_name', $person_name);

        $dataRel['client_id'] 						= $client_id;
				$dataRel['relationship_type_id'] 	= 1;
        $dataRel['appointment_with'] 			= $d['contact_person'];
        ClientRelationship::insertGetId($dataRel);
      }
      if(isset($d['person_type']) && $d['person_type'] == 'C' && !empty($d['contact_person'])){
        $person_name  = ContactAddress::getContactNameById($d['contact_person']);
        $arrData[] 		= Client::save_client($user_id, $client_id, 3,'person_name',$person_name);

        $conDtls 	= ContactAddress::where('contact_id', $d['contact_person'] )->get()->toArray();
	      foreach ($conDtls as $sf) 
	      {
	      	unset($sf['contact_id']);
	      	$sf['client_id'] = $client_id;
	        $contact_id = ContactAddress::insertGetId($sf);

	        $person = $contact_id.'_'.$d['person_type'];
					$arrData[]=Client::save_client($user_id, $client_id, 3,'primary_contacts',$person);
					$arrData[]=Client::save_client($user_id, $client_id, 3,'contact_person',$contact_id);
					$arrData[]=Client::save_client($user_id, $client_id, 3,'person_type',$d['person_type']);
				}
			}

      /* Acting/Non Acting */
      if(isset($d['add_contact']) && $d['add_contact'] == 'N'){
      	if(isset($d['contact_type']) && $d['contact_type'] == 'A'){
      		$indClnt['user_id']     = $user_id;
          $indClnt['type']        = 'ind';
          $indClnt['chd_type']    = 'ind';
					$ind_client_id = Client::insertGetId($indClnt);
					$indDtls['prospect_title'] 	= $d['contact_title'];
					$indDtls['prospect_fname'] 	= $d['contact_fname'];
					$indDtls['prospect_mname'] 	= $d['contact_mname'];
					$indDtls['prospect_lname'] 	= $d['contact_lname'];
					$indDtls['phone'] 					= $d['phone'];
					$indDtls['mobile'] 					= $d['mobile'];
					$indDtls['email'] 					= $d['email'];
					//$indDtls['website'] 				= $d['website'];
					$indDtls['address_id'] 			= $d['address_id'];
      		StepsFieldsClient::update_ind_client($indDtls, $ind_client_id);

      		$rtarr['relation_type'] = $d['position'];
      		$rtarr['show_status'] 	= 'individual';
      		$id = RelationshipType::insertGetId($rtarr);
      		$dataRel['client_id'] 						= $client_id;
					$dataRel['relationship_type_id'] 	= $id;
	        $dataRel['appointment_with'] 			= $ind_client_id;
	        ClientRelationship::insertGetId($dataRel);
      	}
      	if(isset($d['contact_type']) && $d['contact_type'] == 'NA'){
      		$indDtls['user_id']     		= $user_id;
      		$indDtls['client_id']     	= $client_id;
      		$indDtls['contact_type'] 		= 'contact_name';
					$indDtls['contact_title'] 	= $d['contact_title'];
					$indDtls['contact_fname'] 	= $d['contact_fname'];
					$indDtls['contact_mname'] 	= $d['contact_mname'];
					$indDtls['contact_lname'] 	= $d['contact_lname'];
					$indDtls['telephone'] 			= $d['phone'];
					$indDtls['mobile'] 					= $d['mobile'];
					$indDtls['email'] 					= $d['email'];
					$indDtls['website'] 				= $d['website'];
					$indDtls['position'] 				= $d['position'];
					$indDtls['address_id'] 			= $d['address_id'];
					$indDtls['added_from'] 			= 'onboarding';
      		ContactAddress::insertGetId($indDtls);
      	}
      }


			
		}
		//echo "<pre>";print_r($arrData);die;
		$inserted = StepsFieldsClient::insert($arrData);
		return $inserted;
	}

	public static function getLastReturnDateByClientId($client_id)
	{
		$date = date('d-m-Y');
		$client_details = StepsFieldsClient::where('client_id', $client_id)->where('field_name', 'next_ret_due')->select("field_value")->first();
		if(isset($client_details->field_value) && $client_details->field_value != ''){
			$value = $client_details['field_value'];
			$date = date('d-m-Y', strtotime($value.' -28 days'));
		}
		return $date;
	}

	public static function getLastAccDateByClientId($client_id)
	{
		$value = "";
		//$date = date('d-m-Y');
		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', 'last_acc_madeup_date')->select("field_value")->first();
		if(isset($client_details) && count($client_details) >0){
			$value = $client_details['field_value'];
			//$date = date('d-m-Y', strtotime($value.' -28 days'));
		}
		return $value;
	}

	public static function getAddressIdByClientId($client_id, $field_name)
	{
		$value 		= '';
		$smallval 	= '';
		$client_details = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', $field_name)->select("field_value")->first();
		if(isset($client_details) && count($client_details) >0){
			$value = $client_details['field_value'];
		}

		if( $field_name == 'res' || $field_name == 'serv' || $field_name == 'trad' || $field_name == 'corres' || $field_name == 'reg'){
			$address = ClientAddress::getAddressByClientIdAndType($client_id, $field_name);
			$value = (isset($address['fullAddress']) && $address['fullAddress'] != '')?$address['fullAddress']:'';
		}

		if($field_name == 'paye_reference'){
			$field_details = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', 'samllpayeref')->select("field_value")->first();
			if(isset($field_details) && count($field_details) >0){
				$smallval = $field_details['field_value'].'/';
			}
			$value = $smallval.$value;
		}

		if($field_name == 'acc_office_ref'){
			$field_details = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', 'samllaccofcref')->select("field_value")->first();
			if(isset($field_details) && count($field_details) >0){
				$smallval = $field_details['field_value'].'P';
			}
			$value = $smallval.$value;
		}

		return $value;
	}

	public static function storeUpdatingData($postData)
	{
		$arrData = array();
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

		
		$client_id 	= $postData['client_id'];

		$addData['user_id'] 		= $user_id;
		$addData['client_id'] 	= $client_id;
		$addData['client_type'] = 'ind';
		$addData['is_read'] 		= 'N';
		$addData['added_from'] 	= $postData['added_from'];
		$store_id = DataStore::insertGetId($addData);
		
		$s 	= 1;
    $title = StepsFieldsClient::getAddressIdByClientId($client_id, 'title');
  	if($postData['title'] != $title)
    	$arrData[] = Common::save_client($client_id,$s,'title',$title,$postData['title'],$store_id,'Title');

		$fname = StepsFieldsClient::getAddressIdByClientId($client_id, 'fname');
  	if($postData['fname'] != $fname)
    	$arrData[] = Common::save_client($client_id,$s,'fname',$fname,$postData['fname'],$store_id,'First Name');

    	$mname = StepsFieldsClient::getAddressIdByClientId($client_id, 'mname');
    	if($postData['mname'] != $mname)
        	$arrData[] = Common::save_client($client_id, $s, 'mname', $mname, $postData['mname'], $store_id, 'Middle Name');

        $lname = StepsFieldsClient::getAddressIdByClientId($client_id, 'lname');
    	if($postData['lname'] != $lname)
        	$arrData[] = Common::save_client($client_id, $s, 'lname', $lname, $postData['lname'], $store_id, 'Last Name');

        $gender = StepsFieldsClient::getAddressIdByClientId($client_id, 'gender');
    	if($postData['gender'] != $gender)
        	$arrData[] = Common::save_client($client_id, $s, 'gender', $gender, $postData['gender'], $store_id, 'Gender');

		$dob = StepsFieldsClient::getAddressIdByClientId($client_id, 'dob');
    	if($postData['dob'] != $dob)
        	$arrData[] = Common::save_client($client_id, $s, 'dob', $mname, $postData['dob'], $store_id, 'Date of Birth');

        $marital_status = StepsFieldsClient::getAddressIdByClientId($client_id, 'marital_status');
    	if($postData['marital_status'] != $marital_status)
        	$arrData[] = Common::save_client($client_id, $s, 'marital_status', $lname, $postData['marital_status'], $store_id, 'Marital Status');

        $spouse_dob = StepsFieldsClient::getAddressIdByClientId($client_id, 'spouse_dob');
    	if($postData['title'] != $title)
        	$arrData[] = Common::save_client($client_id, $s, 'spouse_dob', $spouse_dob, $postData['spouse_dob'], $store_id, 'Spouse Date of Birth');

    	$country = StepsFieldsClient::getAddressIdByClientId($client_id, 'country');
    	if($postData['country'] != $country){
    		$prev 		= Country::getCountryNameByCountryId($country);
    		$updated 	= Country::getCountryNameByCountryId($postData['country']);

        	$arrData[] = Common::save_client($client_id, $s, 'country', $prev, $updated, $store_id, 'Country');
    	}

		$occupation = StepsFieldsClient::getAddressIdByClientId($client_id, 'occupation');
  	if($postData['occupation'] != $occupation)
      	$arrData[] = Common::save_client($client_id, $s, 'occupation', $occupation, $postData['occupation'], $store_id, 'Occupation');

  	$nationality = StepsFieldsClient::getAddressIdByClientId($client_id, 'nationality');
  	if($postData['nationality'] != $nationality){
  		$prev_n = Nationality::getNationalityNameById( $nationality );
  		$new_n 	= Nationality::getNationalityNameById( $postData['nationality'] );

        	$arrData[] = Common::save_client($client_id, $s, 'nationality', $prev_n, $new_n, $store_id, 'Nationality');
    	}

        $s 	= 2;
        $ni_number = StepsFieldsClient::getAddressIdByClientId($client_id, 'ni_number');
    	if($postData['ni_number'] != $ni_number)
        	$arrData[] = Common::save_client($client_id, $s, 'ni_number', $ni_number, $postData['ni_number'], $store_id, 'NI Number');

    	$tax_reference = StepsFieldsClient::getAddressIdByClientId($client_id, 'tax_reference');
    	if($postData['tax_reference'] != $tax_reference)
        	$arrData[] = Common::save_client($client_id, $s, 'tax_reference', $tax_reference, $postData['tax_reference'], $store_id, 'Tax Reference');

    	$tax_office_id = StepsFieldsClient::getAddressIdByClientId($client_id, 'tax_office_id');
    	if($postData['tax_office_id'] != $tax_office_id)
        	$arrData[] = Common::save_client($client_id, $s, 'tax_office_id', $tax_office_id, $postData['tax_office_id'], $store_id, 'Tax Office Address');

        $s 	= 3;
        $array = array( "Service Address"=>"serv", "Residential Address"=>"res");
        foreach ($array as $key => $val) {
        	$address = StepsFieldsClient::getAddressIdByClientId($client_id, $val.'_address');
        	if(empty($address) || $address == 0){
        		if(isset($postData[$val.'_address']) && $postData[$val.'_address'] != ""){
        			$new_addr 	= ClientAddress::getFullAddress($postData[$val.'_address']);
    				$arrData[] = Common::save_client($client_id, $s, $val.'_address', "Null", $new_addr, $store_id, $key);
        		}
        	}else{
        		if(isset($postData[$val.'_address']) && $postData[$val.'_address'] != ""){
        			$prev_addr 	= ClientAddress::getFullAddress($address);
        			$new_addr 	= ClientAddress::getFullAddress($postData[$val.'_address']);
    				$arrData[] = Common::save_client($client_id, $s, $val.'_address', $prev_addr, $new_addr, $store_id, $key);
        		}else{
        			$prev_addr 	= ClientAddress::getFullAddress($address);
    				$arrData[] = Common::save_client($client_id, $s, $val.'_address', $prev_addr, 'Null', $store_id, $key);
        		}
        	}
        	
        }
        /*$serv_address = StepsFieldsClient::getAddressIdByClientId($client_id, 'serv_address');
    	if($postData['serv_address'] != $serv_address)
        	$arrData[] = Common::save_client($client_id, $s, 'serv_address', $serv_address, $postData['serv_address'], $store_id, 'Service Address');

        $res_address = StepsFieldsClient::getAddressIdByClientId($client_id, 'res_address');
    	if($postData['res_address'] != $res_address)
        	$arrData[] = Common::save_client($client_id, $s, 'res_address', $res_address, $postData['res_address'], $store_id, 'Residential Address');*/

        $res_telephone = StepsFieldsClient::getAddressIdByClientId($client_id, 'res_telephone');
    	if($postData['res_telephone'] != $res_telephone)
        	$arrData[] = Common::save_client($client_id, $s, 'res_telephone', $res_telephone, $postData['res_telephone'], $store_id, 'Residential Telephone');

        $res_mobile = StepsFieldsClient::getAddressIdByClientId($client_id, 'res_mobile');
    	if($postData['res_mobile'] != $res_mobile)
        	$arrData[] = Common::save_client($client_id, $s, 'res_mobile', $res_mobile, $postData['res_mobile'], $store_id, 'Residential Mobile');

        $res_email = StepsFieldsClient::getAddressIdByClientId($client_id, 'res_email');
    	if($postData['res_email'] != $res_email)
        	$arrData[] = Common::save_client($client_id, $s, 'res_email', $res_email, $postData['res_email'], $store_id, 'Email');

        $res_website = StepsFieldsClient::getAddressIdByClientId($client_id, 'res_website');
    	if($postData['res_website'] != $res_website)
        	$arrData[] = Common::save_client($client_id, $s, 'res_website', $res_website, $postData['res_website'], $store_id, 'Website');

        $res_skype = StepsFieldsClient::getAddressIdByClientId($client_id, 'res_skype');
    	if($postData['res_skype'] != $res_skype)
        	$arrData[] = Common::save_client($client_id, $s, 'res_skype', $res_skype, $postData['res_skype'], $store_id, 'Skype');

		ClientDataStore::insert($arrData);

		/* email notification for update */
		StepsFieldsClient::sendNotification($client_id, $store_id, 'ind');

	}

	public static function deleteField($client_id, $field_name)
	{
		StepsFieldsClient::where('client_id',$client_id)->where('field_name',$field_name)->delete();
	}

	public static function sendNotification($client_id, $store_id, $client_type)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $user_id 				= $session['id'];
    $group_id 			= $session['group_id'];

    $emails = User::getAllEmail();
    if($client_type == 'ind'){
    	$client_email = Client::getEmailAddress($client_id, 'res_email');
    }
    if($client_type == 'org'){
    	$client_email = Client::getEmailAddress($client_id, 'contactemail');
    }

    if(!empty($client_email)){
    	array_push($emails, $client_email);
    }
    //echo "<pre>";print_r($emails);die;
    $data['email'] 				= array_unique($emails);
    $data['senderEmail'] 	= Config::get('constant.ADMINEMAIL');
    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
		$data['CLIENTNAME'] 	= Client::getClientNameByClientId($client_id);
    $data['details'] 			= DataStore::getDetailsByStoreId($store_id);
    $data['USERNAME'] 		= User::getStaffNameById($user_id);
    //echo "<pre>";print_r($data['details']);die;

    Mail::send('emails.client_details_change', $data, function ($message) use ($data) {
			$message->subject('Notifications for '.$data['CLIENTNAME']);
			$message->from($data['senderEmail']);
			$message->to($data['email']);
		});

	}

	public static function storeUpdatingOrgData($postData)
	{ 
		$arrData 	= array();
		$admin_s 	= Session::get('admin_details');
		$user_id 	= $admin_s['id'];
		$HOSTNAME = Config::get('constant.HOSTNAME');

		
		$client_id 	= $postData['client_id'];

		$addData['user_id'] 		= $user_id;
		$addData['client_id'] 	= $client_id;
		$addData['client_type'] = 'org';
		$addData['is_read'] 		= 'N';
		$addData['added_from'] 	= $postData['added_from'];
		$store_id = DataStore::insertGetId($addData);

		$s 	= 1;
    $contacttelephone = StepsFieldsClient::getAddressIdByClientId($client_id, 'contacttelephone');
  	if($postData['contacttelephone'] != $contacttelephone)
    	$arrData[] = Common::save_client($client_id,$s,'contacttelephone',$contacttelephone,$postData['contacttelephone'],$store_id,'Telephone');

    $contactmobile = StepsFieldsClient::getAddressIdByClientId($client_id, 'contactmobile');
  	if($postData['contactmobile'] != $contactmobile)
    	$arrData[] = Common::save_client($client_id,$s,'contactmobile',$contactmobile,$postData['contactmobile'],$store_id,'Mobile');

   	$contactfax = StepsFieldsClient::getAddressIdByClientId($client_id, 'contactfax');
  	if($postData['contactfax'] != $contactfax)
    	$arrData[] = Common::save_client($client_id,$s,'contactfax',$contactfax,$postData['contactfax'],$store_id,'Fax');

    $contactemail = StepsFieldsClient::getAddressIdByClientId($client_id, 'contactemail');
  	if($postData['contactemail'] != $contactemail)
  		$arrData[] = Common::save_client($client_id,$s,'contactemail',$contactemail,$postData['contactemail'],$store_id,'Email');

    	$contactwebsite = StepsFieldsClient::getAddressIdByClientId($client_id, 'contactwebsite');
  	if($postData['contactwebsite'] != $contactwebsite)
        	$arrData[] = Common::save_client($client_id,$s,'contactwebsite',$contactwebsite,$postData['contactwebsite'],$store_id,'Website');

        $array = array( "Trading Address"=>"trad", "Registered Office Address"=>"reg", "Correspondence Address"=>"corres", "Bankers"=>"banker", "Auditors"=>"auditors", "Solicitors"=>"solicitors");
        foreach ($array as $key => $val) {
        	$address = StepsFieldsClient::getAddressIdByClientId($client_id, $val.'_address');
        	if(empty($address) || $address == 0){
        		if(isset($postData[$val.'_address']) && $postData[$val.'_address'] != ""){
        			$new_addr 	= ClientAddress::getFullAddress($postData[$val.'_address']);
    				$arrData[] = Common::save_client($client_id, $s, $val.'_address', "Null", $new_addr, $store_id, $key);
        		}
        	}else{
        		if(isset($postData[$val.'_address']) && $postData[$val.'_address'] != ""){
        			$prev_addr 	= ClientAddress::getFullAddress($address);
        			$new_addr 	= ClientAddress::getFullAddress($postData[$val.'_address']);
    				$arrData[] = Common::save_client($client_id, $s, $val.'_address', $prev_addr, $new_addr, $store_id, $key);
        		}else{
        			$prev_addr 	= ClientAddress::getFullAddress($address);
    				$arrData[] = Common::save_client($client_id, $s, $val.'_address', $prev_addr, 'Null', $store_id, $key);
        		}
        	}
        	
        }

        $bank_name = StepsFieldsClient::getAddressIdByClientId($client_id, 'bank_name');
    	if($postData['bank_name'] != $bank_name)
        	$arrData[] = Common::save_client($client_id,$s,'bank_name',$bank_name,$postData['bank_name'],$store_id,'Bank Name');

        $bank_short_code = StepsFieldsClient::getAddressIdByClientId($client_id, 'bank_short_code');
    	if($postData['bank_short_code'] != $bank_short_code)
        	$arrData[] = Common::save_client($client_id,$s,'bank_short_code',$bank_short_code,$postData['bank_short_code'],$store_id,'Sort Code');

        $bank_acc_no = StepsFieldsClient::getAddressIdByClientId($client_id, 'bank_acc_no');
    	if($postData['bank_acc_no'] != $bank_acc_no)
        	$arrData[] = Common::save_client($client_id,$s,'bank_acc_no',$bank_acc_no,$postData['bank_acc_no'],$store_id,'Account Number');


        /* ===================== Tax Information ======================= */
        $effective_date = StepsFieldsClient::getAddressIdByClientId($client_id, 'effective_date');
    	if($postData['effective_date'] != $effective_date)
        	$arrData[] = Common::save_client($client_id,$s,'effective_date',$effective_date,$postData['effective_date'],$store_id,'Effective Date of Registration');

        $vat_number = StepsFieldsClient::getAddressIdByClientId($client_id, 'vat_number');
    	if($postData['vat_number'] != $vat_number)
        	$arrData[] = Common::save_client($client_id,$s,'vat_number',$vat_number,$postData['vat_number'],$store_id,'Vat Number');

        $vat_scheme_type = StepsFieldsClient::getAddressIdByClientId($client_id, 'vat_scheme_type');
    	if($postData['vat_scheme_type'] != $vat_scheme_type){
    		$prev_scm 	= "";
    		$new_scm 	= "";
    		if($vat_scheme_type != ""){
    			$prev_scm = VatScheme::getNameById( $vat_scheme_type );
    		}
    		if($postData['vat_scheme_type'] != ""){
    			$new_scm = VatScheme::getNameById( $postData['vat_scheme_type'] );
    		}
        	$arrData[] = Common::save_client($client_id,$s,'vat_scheme_type',$prev_scm,$new_scm,$store_id,'Vat Scheme Type');
    	}

    	$vat_scheme = StepsFieldsClient::getAddressIdByClientId($client_id, 'vat_scheme');
    	if(isset($postData['vat_scheme']) && $postData['vat_scheme'] != $vat_scheme)
        	$arrData[] = Common::save_client($client_id,$s,'vat_scheme',$vat_scheme,$postData['vat_scheme'],$store_id,'Vat Scheme');

        $ret_frequency = StepsFieldsClient::getAddressIdByClientId($client_id, 'ret_frequency');
    	if(isset($postData['ret_frequency']) && $postData['ret_frequency'] != $ret_frequency)
        	$arrData[] = Common::save_client($client_id,$s,'ret_frequency',$ret_frequency,$postData['ret_frequency'],$store_id,'Return Frequency');

        $vat_stagger = StepsFieldsClient::getAddressIdByClientId($client_id, 'vat_stagger');
    	if(isset($postData['vat_stagger']) && $postData['vat_stagger'] != $vat_stagger)
        	$arrData[] = Common::save_client($client_id,$s,'vat_stagger',$vat_stagger,$postData['vat_stagger'],$store_id,'Vat Stagger');

        $ecsl_freq = StepsFieldsClient::getAddressIdByClientId($client_id, 'ecsl_freq');
    	if(isset($postData['ecsl_freq']) && $postData['ecsl_freq'] != $ecsl_freq)
        	$arrData[] = Common::save_client($client_id,$s,'ecsl_freq',$ecsl_freq,$postData['ecsl_freq'],$store_id,'EC Sales List');

        $samllaccofcref = StepsFieldsClient::getAddressIdByClientId($client_id, 'samllaccofcref');
        $acc_office_ref = StepsFieldsClient::getAddressIdByClientId($client_id, 'acc_office_ref');
        $old_off_ref = $samllaccofcref.'P'.$acc_office_ref;
		$new_off_ref = $postData['samllaccofcref'].'P'.$postData['acc_office_ref'];
		if($old_off_ref != $new_off_ref){
			if($old_off_ref == 'P')$old_off_ref = 'Null';
			if($new_off_ref == 'P')$new_off_ref = 'Null';
        	$arrData[] = Common::save_client($client_id,$s,'acc_office_ref',$old_off_ref,$new_off_ref,$store_id,'Account Office Reference');
		}

    $samllpayeref = StepsFieldsClient::getAddressIdByClientId($client_id, 'samllpayeref');
    $paye_reference = StepsFieldsClient::getAddressIdByClientId($client_id, 'paye_reference');
    $old_paye_ref = $samllpayeref.'/'.$paye_reference;
		$new_paye_ref = $postData['samllpayeref'].'/'.$postData['paye_reference'];
		if($old_paye_ref != $new_paye_ref){
			if($old_paye_ref == '/')$old_paye_ref = 'Null';
			if($new_paye_ref == '/')$new_paye_ref = 'Null';
      	$arrData[] = Common::save_client($client_id,$s,'acc_office_ref',$old_paye_ref,$new_paye_ref,$store_id,'PAYE Reference');
		}

    $hmrc_login_details = StepsFieldsClient::getAddressIdByClientId($client_id, 'hmrc_login_details');
  	if($postData['hmrc_login_details'] != $hmrc_login_details)
    	$arrData[] = Common::save_client($client_id,$s,'hmrc_login_details',$hmrc_login_details,$postData['hmrc_login_details'],$store_id,'HMRC Log-in Details');


		ClientDataStore::insert($arrData);
		if($HOSTNAME != 'eweb.ipractice.com'){
			StepsFieldsClient::sendNotification($client_id, $store_id, 'org');
		}
	}

	public static function updateField($client_id, $field_name, $field_value, $step_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
  	$user_id    		= $session['id'];
  	$groupUserId    = $session['group_users'];

		StepsFieldsClient::whereIn('user_id', $groupUserId)->where('client_id', $client_id)
				->where("field_name", $field_name)->where("step_id", $step_id)->delete();

    $data['user_id'] 			= $user_id;
    $data['client_id'] 		= $client_id;
    $data['step_id'] 			= $step_id;
    $data['field_name'] 	= $field_name;
    $data['field_value'] 	= $field_value;
    $data['created'] 			= date('Y-m-d H:i:s');
    StepsFieldsClient::insert($data);
	}

	public static function getFieldValueByClientId($client_id, $field_name)
	{
		$field_value    = '';
		$session        = Session::get('admin_details');
  	$groupUserId    = $session['group_users'];

		$details = StepsFieldsClient::whereIn('user_id', $groupUserId)->where('client_id', $client_id)
			->where("field_name", $field_name)->select("field_value")->first();

		if(isset($details['field_value']) && $details['field_value'] !=''){
      $field_value = $details['field_value'];
    }
    return $field_value;
	}

	public static function clientFieldQuery($field_name)
	{ 
		if($field_name == 'vat_scheme_type'){
			$fields = " (select vs.vat_scheme_name from vat_schemes as vs where vs.vat_scheme_id=(select field_value from steps_fields_clients where field_name='vat_scheme_type' and client_id=c.client_id group by client_id) ) ";
		}else{
			$fields = " (select field_value from steps_fields_clients where field_name='".$field_name."' and client_id=c.client_id group by client_id) ";
		}
		return $fields;
	}

	public static function clientNameQuery()
	{
		$fields = " (select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=c.client_id group by client_id) ";
		return $fields;
	}

	public static function deadCountQuery($field_name)
	{ 
		$fields = " ( SELECT DATEDIFF( STR_TO_DATE(field_value,'%Y-%m-%d'), CURDATE() ) FROM steps_fields_clients WHERE field_name = '".$field_name."' AND client_id=c.client_id group by client_id ) ";
		return $fields;
	}

	public static function yearEndQuery()
	{
		//$year_end = " (SELECT GROUP_CONCAT(field_value SEPARATOR '-') AS year_end FROM steps_fields_clients WHERE field_name IN ('acc_ref_day','acc_ref_month') AND client_id=c.client_id group by client_id) ";
		$fields = " ( SELECT CONCAT( (select field_value from steps_fields_clients where field_name='acc_ref_day' and client_id=c.client_id group by client_id) , '-', (select m.short_name from months as m join steps_fields_clients sfc where m.month_id = sfc.field_value and sfc.field_name='acc_ref_month' and sfc.client_id=c.client_id group by sfc.client_id) ) ) ";
		return $fields;
	}

	public static function businessTypeQuery()
	{
		$fields = " (select ot.name from organisation_types as ot where ot.organisation_id=(select field_value from steps_fields_clients where field_name='business_type' and client_id=c.client_id group by client_id) ) ";
		return $fields;
	}

	public static function nextReturnQuery()
	{ //next_ret_due
		$fields = " ( SELECT IF(field_value='','',DATE_FORMAT( DATE_SUB(field_value, INTERVAL 14 DAY), '%d-%m-%Y' ) ) FROM steps_fields_clients WHERE field_name='next_ret_due' and client_id=c.client_id group by client_id ) ";
    return $fields;
	}



}
