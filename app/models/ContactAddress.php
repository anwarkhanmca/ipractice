<?php
class ContactAddress extends Eloquent {

	public $timestamps = false;

	public static function getAllContactDetails()
	{
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];
		$contact_details = ContactAddress::whereIn("user_id", $groupUserId)->get();
		if(isset($contact_details) && count($contact_details) >0){
			foreach ($contact_details as $key => $d) {
				$c_name = $d->contact_title.' '.$d->contact_fname.' '.$d->contact_mname.' '.$d->contact_lname;

				$data[$key]['contact_id'] 		= $d->contact_id;
				$data[$key]['user_id'] 				= $d->user_id;
				$data[$key]['client_id'] 			= $d->client_id;
				$data[$key]['contact_type'] 	= $d->contact_type;
				$data[$key]['contact_title'] 	= $d->contact_title;
				$data[$key]['contact_fname'] 	= $d->contact_fname;
				$data[$key]['contact_mname'] 	= $d->contact_mname;
				$data[$key]['contact_lname'] 	= $d->contact_lname;
				$data[$key]['contact_name'] 	= $c_name;
				$data[$key]['telephone'] 			= $d->telephone;
				$data[$key]['mobile'] 				= $d->mobile;
		    $data[$key]['email'] 					= $d->email;
		    $data[$key]['website'] 				= $d->website;
		    $data[$key]['position'] 			= $d->position;
		    $data[$key]['address_id'] 		= $d->address_id;
		    $data[$key]['change_contact'] = $d->change_contact;
				$data[$key]['address'] 				= ClientAddress::getFullAddress($d->address_id);
	    	if(isset($d->contact_type) && $d->contact_type == "company_name"){
	    		$data[$key]['name'] 		= Client::getClientNameByClientId($d->client_id);
	    	}else{
	    		$data[$key]['name'] 		= $c_name;
	    	}
			}
		}
		//	echo'<pre>';	print_r($data);die();
		return $data;
	}

	public static function getAllContactNameAndId()
	{
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];
		$contact_details = ContactAddress::whereIn("user_id", $groupUserId)->select('contact_id','contact_title','contact_fname','contact_mname','contact_lname')->get();
		if(isset($contact_details) && count($contact_details) >0){
			foreach ($contact_details as $key => $d) {
				$data[$key]['contact_id'] 	= $d->contact_id;
				$data[$key]['contact_name'] = $d->contact_title.' '.$d->contact_fname.' '.$d->contact_mname.' '.$d->contact_lname;
				$data[$key]['position'] 		= $d->position;
			}
		}
		return $data;
	}

	public static function getContactNameAndIdByClientId( $client_id )
	{
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];
		$contact_details = ContactAddress::whereIn("user_id", $groupUserId)->where('client_id', $client_id)->select('contact_id','contact_title','contact_fname','contact_mname','contact_lname', 'position')->get();
		if(isset($contact_details) && count($contact_details) >0){
			foreach ($contact_details as $key => $d) {
				$data[$key]['contact_id'] 	= $d->contact_id;
				$data[$key]['contact_name'] = $d->contact_title.' '.$d->contact_fname.' '.$d->contact_mname.' '.$d->contact_lname;
				$data[$key]['position'] 		= $d->position;
			}
		}
		return $data;
	}

	public static function getContactDetailsById($contact_id)
	{
		$data = array();
		$d = ContactAddress::where("contact_id", $contact_id)->first();
		if(isset($d) && count($d) >0){
			$c_name = $d->contact_title.' '.$d->contact_fname.' '.$d->contact_mname.' '.$d->contact_lname;

			$data['contact_id'] 			= $d->contact_id;
			$data['user_id'] 					= $d->user_id;
			$data['client_id'] 				= $d->client_id;
			$data['contact_type'] 		= $d->contact_type;
			$data['contact_title'] 		= $d->contact_title;
			$data['contact_fname'] 		= $d->contact_fname;
			$data['contact_mname'] 		= $d->contact_mname;
			$data['contact_lname'] 		= $d->contact_lname;
			$data['contact_name'] 		= $c_name;
			$data['telephone'] 				= $d->telephone;
			$data['mobile'] 					= $d->mobile;
    	$data['email'] 						= $d->email;
    	$data['website'] 					= $d->website;
    	$data['position'] 				= $d->position;
    	$data['company_name'] 		= $d->company_name;
			$data['address_id'] 			= $d->address_id;
			$data['change_contact'] 	= $d->change_contact;
			$data['address'] 					= ClientAddress::getFullAddress($d->address_id);
    	if(isset($d->contact_type) && $d->contact_type == "company_name"){
    		$data['name'] 				= Client::getClientNameByClientId($d->client_id);
    	}else{
    		$data['name'] 				= $c_name;
    	}
			
		}
		//print_r($data);
		return $data;
	}

	public static function getContactNameById($contact_id)
	{
		$contact_name = '';
		$d = ContactAddress::where("contact_id", $contact_id)->select('contact_title','contact_fname','contact_mname','contact_lname')->first();
		if(isset($d) && count($d)>0){
			$contact_name 	= $d->contact_title.' '.$d->contact_fname.' '.$d->contact_mname.' '.$d->contact_lname;
		}
		return $contact_name;
	}

	public static function getEmailByContactId($contact_id)
	{
		$email = '';
		$d = ContactAddress::where("contact_id", $contact_id)->select('email')->first();
		if(isset($d->email) && $d->email != ''){
			$email 	= $d->email;
		}
		return $email;
	}

	public static function getCompanyNameById($contact_id)
	{
		$company_name = '';
		$details1 = ContactAddress::where("contact_id", $contact_id)->select('client_id')->first();
		if(isset($details1->client_id) && $details1->client_id != '0'){
			$company_name 	= Client::getClientNameByClientId($details1->client_id);
		}
		return $company_name;
	}

	public static function getContactAddressByType($client_id, $type)
	{ 
		$data = array();
		$details = Common::clientDetailsById($client_id);
		if(isset($details) && count($details) >0){
			if($type == "tax_office"){

				if(isset($details['tax_address']) && $details['tax_address'] != ""){
					$data['address'] = $details['tax_address'];
				}else{
					$data['address'] = "";
				}
				if(isset($details['tax_telephone']) && $details['tax_telephone'] != ""){
					$data['telephone'] = $details['tax_telephone'];
				}else{
					$data['telephone'] = "";
				}
				$data['contact_person'] = "";
				$data['mobile'] 		= "";
				$data['email'] 			= "";

			}else if($type == "paye_emp"){

				if(isset($details['employer_office']) && $details['employer_office'] != ""){
					$data['address'] = $details['employer_office'];
				}else{
					$data['address'] = "";
				}
				if(isset($details['employer_telephone']) && $details['employer_telephone'] != ""){
					$data['telephone'] = $details['employer_telephone'];
				}else{
					$data['telephone'] = "";
				}
				$data['contact_person'] = "";
				$data['mobile'] 		= "";
				$data['email'] 			= "";

			}else{
				$address = "";
				if($type == 'trad' || $type == 'reg' || $type == 'corres'){
					$data['contact_person']=StepsFieldsClient::getFieldValueByClientId($client_id,'person_name');
					$data['telephone']=StepsFieldsClient::getFieldValueByClientId($client_id,'contacttelephone');
					$data['mobile'] = StepsFieldsClient::getFieldValueByClientId($client_id,'contactmobile');
					$data['email'] = StepsFieldsClient::getFieldValueByClientId($client_id,'contactemail');
				}else{
					$data['contact_person']=StepsFieldsClient::getFieldValueByClientId($client_id,$type.'_cont_name');
					$data['telephone']=StepsFieldsClient::getFieldValueByClientId($client_id,$type.'_cont_telephone');
					$data['mobile'] = StepsFieldsClient::getFieldValueByClientId($client_id,$type.'_cont_mobile');
					$data['email'] = StepsFieldsClient::getFieldValueByClientId($client_id,$type.'_cont_email');
				}
				//Common::last_query();
				//echo "<pre>";print_r($data);die;

				if(isset($details[$type.'_address']) && $details[$type.'_address'] != "")
					$address = ClientAddress::getFullAddress($details[$type.'_address']);

				$data['address'] = $address;
			
			}
		}
		return $data;
	}

	public static function getAllContactAddress()
	{
		$address_data = array();

		$org_details = Client::getAllOrgClientDetails();
		$ind_details = Client::getAllIndClientDetails();
		$contact_details = ContactAddress::getAllContactDetails();
		$i = 0;
		if(isset($org_details) && count($org_details) >0){
			foreach ($org_details as $key => $value) {
				$array = array("trad", "corres", "reg", "bankers", "old_acc", "auditors", "solicitors");
				
				foreach($array as $row){
					if(isset($value[$row.'_cont_addr_line1']) && $value[$row.'_cont_addr_line1'] != ""){
						$address_data[$i]['address'] 		= $value[$row.'_cont_addr_line1'];
						$address_data[$i]['type'] 			= $row;
						$address_data[$i]['client_id'] 	= $value['client_id'];
						$i++;
					}
				}

			}
		}

		if(isset($ind_details) && count($ind_details) >0){
			foreach ($ind_details as $key => $value) {
				if(isset($value['serv_addr_line1']) && $value['serv_addr_line1'] != ""){
					$address_data[$i]['address'] = $value['serv_addr_line1'];
					$address_data[$i]['type'] = "serv";
					$address_data[$i]['client_id'] = $value['client_id'];
					$i++;
				}
				if(isset($value['res_addr_line1']) && $value['res_addr_line1'] != ""){
					$address_data[$i]['address'] = $value['res_addr_line1'];
					$address_data[$i]['type'] = "res";
					$address_data[$i]['client_id'] = $value['client_id'];
					$i++;
				}

			}
		}

		if(isset($contact_details) && count($contact_details) >0){
			foreach ($contact_details as $key => $value) {
				if(isset($value['addr_line1']) && $value['addr_line1'] != ""){
					$address_data[$i]['address'] 	= $value['addr_line1'];
					$address_data[$i]['type'] 		= "other";
					$address_data[$i]['client_id'] 	= $value['contact_id'];
					$i++;
				}
				

			}
		}

		return $address_data;
		//$data['cont_address'] 	= App::make('HomeController')->get_orgcontact_address();

	}

	public static function getGroupContactDetails($step_id)
	{
		$contacts = array();

		$details = ContactsGroup::getContactsGroupByGroupId($step_id);
		$count = 0;
		if(isset($details) && count($details) >0)
		{
			foreach ($details as $key => $value) {
				if(isset($value['contact_type']) && $value['contact_type'] == "org"){
					$client_row = Common::clientDetailsById($value['client_id']);
					if(isset($client_row) && count($client_row) >0){
						$contacts[$count] = ContactAddress::getContactAddressByType($client_row['client_id'], "corres");
						$contacts[$count]['client_id']		= $client_row['client_id'];
						$contacts[$count]['client_name']	= isset($client_row['business_name'])?$client_row['business_name']:"";
						$contacts[$count]['client_type']	= "org";

						$count++;
					}
				}

				if(isset($value['contact_type']) && $value['contact_type'] == "ind"){
					$client_row = Common::clientDetailsById($value['client_id']);
					if(isset($client_row) && count($client_row) >0){
						$contacts[$count]['client_id']		= $client_row['client_id'];
						$contacts[$count]['client_name']	= isset($client_row['client_name'])?$client_row['client_name']:"";
						$contacts[$count]['client_type']	= "ind";
						$contacts[$count]['contact_person']	= "";
						$contacts[$count]['telephone']		= isset($client_row['serv_telephone'])?$client_row['serv_telephone']:"";
						$contacts[$count]['mobile']			= isset($client_row['serv_mobile'])?$client_row['serv_mobile']:"";
						$contacts[$count]['email']			= isset($client_row['serv_email'])?$client_row['serv_email']:"";
						$contacts[$count]['address']		= ContactAddress::getResidentialAddress($client_row);

						$count++;
					}
				}

				if(isset($value['contact_type']) && $value['contact_type'] == "staff"){
					$staff_row = User::getStaffDetailsById($value['client_id']);
					if(isset($staff_row) && count($staff_row) >0){
						$contacts[$count]['client_id']		= $staff_row['user_id'];
						$contacts[$count]['client_name']	= $staff_row['fname']." ".$staff_row['lname'];
						$contacts[$count]['client_type']	= "staff";
						$contacts[$count]['contact_person']	= "";
						$contacts[$count]['telephone']		= isset($staff_row['res_telephone'])?$staff_row['res_telephone']:"";
						$contacts[$count]['mobile']			= isset($staff_row['res_mobile'])?$staff_row['res_mobile']:"";
						$contacts[$count]['email']			= isset($staff_row['res_email'])?$staff_row['res_email']:"";
						$contacts[$count]['address']		= isset($staff_row['res_address'])?$staff_row['res_address']:"";

						$count++;
					}
				}

				if(isset($value['contact_type']) && $value['contact_type'] == "other"){
					$other_row = ContactAddress::getContactDetailsById($value['client_id']);
					if(isset($other_row) && count($other_row) >0){
						$contacts[$count]['client_id']		= $other_row['contact_id'];
						$contacts[$count]['client_name']	= $other_row['name'];
						$contacts[$count]['client_type']	= "other";
						$contacts[$count]['contact_person']	= isset($other_row['contact_person'])?$other_row['contact_person']:"";;
						$contacts[$count]['telephone']		= isset($other_row['telephone'])?$other_row['telephone']:"";
						$contacts[$count]['mobile']			= isset($other_row['mobile'])?$other_row['mobile']:"";
						$contacts[$count]['email']			= isset($other_row['email'])?$other_row['email']:"";
						$contacts[$count]['address']		= isset($other_row['address'])?$other_row['address']:"";

						$count++;
					}
				}


			}
		}

		return $contacts;
	}

	public static function getResidentialAddress($client_row)
	{
		$address = "";
		if(isset($client_row['res_addr_line1']) && $client_row['res_addr_line1'] != ""){
			$address .= $client_row['res_addr_line1'].", ";
		}
		if(isset($client_row['res_addr_line2']) && $client_row['res_addr_line2'] != ""){
			$address .= $client_row['res_addr_line2'].", ";
		}
		if(isset($client_row['res_city']) && $client_row['res_city'] != ""){
			$address .= $client_row['res_city'].", ";
		}
		if(isset($client_row['res_county']) && $client_row['res_county'] != ""){
			$address .= $client_row['res_county'].", ";
		}
		if(isset($client_row['res_postcode']) && $client_row['res_postcode'] != ""){
			$address .= $client_row['res_postcode'].", ";
		}
		return substr($address, 0, -2);

	}

	public static function getClientContactAddress($client_id, $type)
	{
		$data = array();
		$details = Common::clientDetailsById($client_id);
		if(isset($details) && count($details) >0){
			if($type == "res" || $type == "serv"){
				$data['contact_fname'] = isset($details['fname'])?$details['fname']:'';
				$data['contact_lname'] = isset($details['lname'])?$details['lname']:'';

				if(isset($details[$type.'_tele_code']) && $details[$type.'_tele_code'] != ""){
					$data['telephone_code'] = $details[$type.'_tele_code'];
				}else{
					$data['telephone_code'] = "";
				}
				if(isset($details[$type.'_telephone']) && $details[$type.'_telephone'] != ""){
					$data['telephone'] = $details[$type.'_telephone'];
				}else{
					$data['telephone'] = "";
				}
				if(isset($details[$type.'_mobile_code']) && $details[$type.'_mobile_code'] != ""){
					$data['mobile_code'] = $details[$type.'_mobile_code'];
				}else{
					$data['mobile_code'] = "";
				}
				if(isset($details[$type.'_mobile']) && $details[$type.'_mobile'] != ""){
					$data['mobile'] = $details[$type.'_mobile'];
				}else{
					$data['mobile'] = "";
				}
				if(isset($details[$type.'_email']) && $details[$type.'_email'] != ""){
					$data['email'] = $details[$type.'_email'];
				}else{
					$data['email'] = "";
				}
				if(isset($details[$type.'_skype']) && $details[$type.'_skype'] != ""){
					$data['skype'] = $details[$type.'_skype'];
				}else{
					$data['skype'] = "";
				}
				if(isset($details[$type.'_website']) && $details[$type.'_website'] != ""){
					$data['website'] = $details[$type.'_website'];
				}else{
					$data['website'] = "";
				}

				if(isset($details[$type.'_addr_line1']) && $details[$type.'_addr_line1'] != ""){
					$data['address1'] = $details[$type.'_addr_line1'];
				}else{
					$data['address1'] = "";
				}
				if(isset($details[$type.'_addr_line2']) && $details[$type.'_addr_line2'] != ""){
					$data['address2'] = $details[$type.'_addr_line2'];
				}else{
					$data['address2'] = "";
				}
				if(isset($details[$type.'_city']) && $details[$type.'_city'] != ""){
					$data['city'] = $details[$type.'_city'];
				}else{
					$data['city'] = "";
				}
				if(isset($details[$type.'_county']) && $details[$type.'_county'] != ""){
					$data['county'] = $details[$type.'_county'];
				}else{
					$data['county'] = "";
				}
				if(isset($details[$type.'_postcode']) && $details[$type.'_postcode'] != ""){
					$data['postcode'] = $details[$type.'_postcode'];
				}else{
					$data['postcode'] = "";
				}
				if(isset($details[$type.'_country']) && $details[$type.'_country'] != ""){
					$data['country'] = $details[$type.'_country'];
				}else{
					$data['country'] = "";
				}

			}else{
				if(isset($details[$type.'_cont_name']) && $details[$type.'_cont_name'] != ""){
					$data['contact_name'] = $details[$type.'_cont_name'];
					$name = explode(' ', $data['contact_name']);
					$data['contact_lname'] = $name[count($name)-1];
					$data['contact_fname'] = $name[count($name)-2];
				}else{
					$data['contact_name'] = "";
				}
				if(isset($details[$type.'_cont_tele_code']) && $details[$type.'_cont_tele_code'] != ""){
					$data['telephone_code'] = $details[$type.'_cont_tele_code'];
				}else{
					$data['telephone_code'] = "";
				}
				if(isset($details[$type.'_cont_telephone']) && $details[$type.'_cont_telephone'] != ""){
					$data['telephone'] = $details[$type.'_cont_telephone'];
				}else{
					$data['telephone'] = "";
				}
				if(isset($details[$type.'_cont_mobile_code']) && $details[$type.'_cont_mobile_code'] != ""){
					$data['mobile_code'] = $details[$type.'_cont_mobile_code'];
				}else{
					$data['mobile_code'] = "";
				}
				if(isset($details[$type.'_cont_mobile']) && $details[$type.'_cont_mobile'] != ""){
					$data['mobile'] = $details[$type.'_cont_mobile'];
				}else{
					$data['mobile'] = "";
				}
				if(isset($details[$type.'_cont_email']) && $details[$type.'_cont_email'] != ""){
					$data['email'] = $details[$type.'_cont_email'];
				}else{
					$data['email'] = "";
				}
				if(isset($details[$type.'_cont_skype']) && $details[$type.'_cont_skype'] != ""){
					$data['skype'] = $details[$type.'_cont_skype'];
				}else{
					$data['skype'] = "";
				}
				if(isset($details[$type.'_cont_website']) && $details[$type.'_cont_website'] != ""){
					$data['website'] = $details[$type.'_cont_website'];
				}else{
					$data['website'] = "";
				}

				if(isset($details[$type.'_cont_addr_line1']) && $details[$type.'_cont_addr_line1'] != ""){
					$data['address1'] = $details[$type.'_cont_addr_line1'];
				}else{
					$data['address1'] = "";
				}
				if(isset($details[$type.'_cont_addr_line2']) && $details[$type.'_cont_addr_line2'] != ""){
					$data['address2'] = $details[$type.'_cont_addr_line2'];
				}else{
					$data['address2'] = "";
				}
				if(isset($details[$type.'_cont_city']) && $details[$type.'_cont_city'] != ""){
					$data['city'] = $details[$type.'_cont_city'];
				}else{
					$data['city'] = "";
				}
				if(isset($details[$type.'_cont_county']) && $details[$type.'_cont_county'] != ""){
					$data['county'] = $details[$type.'_cont_county'];
				}else{
					$data['county'] = "";
				}
				if(isset($details[$type.'_cont_postcode']) && $details[$type.'_cont_postcode'] != ""){
					$data['postcode'] = $details[$type.'_cont_postcode'];
				}else{
					$data['postcode'] = "";
				}
				if(isset($details[$type.'_cont_country']) && $details[$type.'_cont_country'] != ""){
					$data['country'] = $details[$type.'_cont_country'];
				}else{
					$data['country'] = "";
				}
				
			
			}
		}
		return $data;
	}

	public static function get_all_contacts($client_id)
  {
      $data = array();
      $contact_name   = array();
      $relation_name  = array();
      $contact_name   = Client::getContactNameByClientId( $client_id );
      $relation_name  = Client::getRelationNameByClientId( $client_id );
      $data = array_merge($contact_name, $relation_name);
      //print_r($data['contact']);die;
      return $data;
      exit;
  }

  public static function getAllContactListByClientId( $client_id )
	{
		$data = array();
		$contacts 			= ContactAddress::getContactNameAndIdByClientId($client_id);
		$relationship 	= Common::get_relationship_client($client_id);
		$i = 0;
		if(isset($contacts) && count($contacts) >0){
			foreach ($contacts as $k => $v) {
				$data[$i]['item_id'] 	= $v['contact_id'];
				$data[$i]['item_name'] 	= $v['contact_name'];
				$data[$i]['item_type'] 	= 'C';
				$i++;
			}
		}
		if(isset($relationship) && count($relationship) >0){
			foreach ($relationship as $k => $v) {
				$data[$i]['item_id'] 	= $v['client_id'];
				$data[$i]['item_name'] 	= $v['name'];
				$data[$i]['item_type'] 	= 'R';
				$i++;
			}
		}
		return $data;
	}

	public static function getOrgClientContacts($page_number, $item_per_page, $address_type)
	{
		$data = array();
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $total_records = Client::countClientByType('org');
    $total_pages = ceil($total_records/$item_per_page);

    $page_position = (($page_number-1) * $item_per_page);

		$od = Client::select('client_id', 'type')->where("is_deleted","N")->where("type","org")->where("is_archive","N")->where("is_relation_add", "N")->whereIn("user_id", $groupUserId)->orderBy("client_id", "DESC")->take($item_per_page)->skip($page_position)->get()->toArray();
		if (isset($od) && count($od) > 0) {
			$oc = 0;
			foreach ($od as $k => $v) {
				$od[$k]['other_details'] = ContactAddress::getContactAddressByType($v['client_id'],$address_type);
				$od[$k]['notes'] 		 = ContactsNote::getNotes($v['client_id'], 'org');
				$od[$k]['client_name']   = Client::getClientNameByClientId($v['client_id']);
				$oc++;
			}
		}

		$data['details'] 	= $od;
		$data['pagination'] = Common::paginate_function($item_per_page,$page_number,$total_records,$total_pages);

		return $data;
	}
	public static function getClientContacts($start, $limit, $address_type, $client_type)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $total_records = Client::countClientByType($client_type);

		$od = Client::select('client_id')->where("is_deleted","N")->where("type",$client_type)->where("is_archive","N")->where("is_relation_add", "N")->whereIn("user_id", $groupUserId)->take($limit)->skip($start)->get()->toArray();
		//Common::last_query();
		if (isset($od) && count($od) > 0) {
			foreach ($od as $k => $v) {
				$od[$k] = ContactAddress::getContactAddressByType($v['client_id'],$address_type);
				$od[$k]['notes'] 		 	= ContactsNote::getNotes($v['client_id'], $client_type);
				$od[$k]['client_name']   	= Client::getClientNameByClientId($v['client_id']);
				$od[$k]['client_id'] 		= $v['client_id'];
				$od[$k]['type'] 			= $client_type;
			}
		}

		$data['details'] 		= $od;
		$data['total_records'] 	= $total_records;

		return $data;
	}

	public static function orgClientContacts($start,$limit,$addr_type,$client_type,$sorting,$search)
	{ 
		$data = array();
		$sort = explode(' ', $sorting);

		$groupUserId    = Client::getSessionUserIds();

    $where = "where c.is_deleted='N' and c.type='".$client_type."' and c.is_archive='N' and c.is_relation_add='N' and c.user_id IN ('".implode(',', $groupUserId)."')";
        
		$client_name  	= StepsFieldsClient::clientNameQuery();

		if($addr_type == 'trad' || $addr_type == 'reg' || $addr_type == 'corres'){
			$contact_person = StepsFieldsClient::clientFieldQuery('person_name');
			$telephone 			= StepsFieldsClient::clientFieldQuery('contacttelephone');
			$mobile 				= StepsFieldsClient::clientFieldQuery('contactmobile');
			$email 					= StepsFieldsClient::clientFieldQuery('contactemail');
		}else{
			$contact_person = StepsFieldsClient::clientFieldQuery($addr_type.'_cont_name');
			$telephone 			= StepsFieldsClient::clientFieldQuery($addr_type.'_cont_telephone');
			$mobile 				= StepsFieldsClient::clientFieldQuery($addr_type.'_cont_mobile');
			$email 					= StepsFieldsClient::clientFieldQuery($addr_type.'_cont_email');
		}

		$res_telephone 	= StepsFieldsClient::clientFieldQuery($addr_type.'_telephone');
		$res_mobile 		= StepsFieldsClient::clientFieldQuery($addr_type.'_mobile');
		$res_email 			= StepsFieldsClient::clientFieldQuery($addr_type.'_email');

    /*$contact_person = "(select field_value from steps_fields_clients where field_name='".$addr_type."_cont_name' and client_id=c.client_id)";
    $telephone = "(select field_value from steps_fields_clients where field_name='".$addr_type."_cont_telephone' and client_id=c.client_id)";
    $mobile = "(select field_value from steps_fields_clients where field_name='".$addr_type."__cont_mobile' and client_id=c.client_id)";
    $email = "(select field_value from steps_fields_clients where field_name='".$addr_type."_cont_email' and client_id=c.client_id)";*/

    $address = "(select CONCAT(ca.address1,' ',ca.address2,' ',ca.city,' ',ca.county,' ',ca.postcode,' ',IF (ca.country >0, (select country_name from countries as cnt where cnt.country_id = ca.country), '') ) from client_addresses ca where ca.address_id=(select field_value from steps_fields_clients where field_name='".$addr_type."_address' and client_id=c.client_id))";
    $serv_address = "(select CONCAT(ca.address1,' ',ca.address2,' ',ca.city,' ',ca.county,' ',ca.postcode,' ',IF (ca.country >0, (select country_name from countries as cnt where cnt.country_id = ca.country), '') ) from client_addresses ca where ca.address_id=(select field_value from steps_fields_clients where field_name='serv_address' and client_id=c.client_id))";

    $header_sort = '';
    if($sort[0] == 'client_name'){
			$header_sort = $client_name.' '.$sort[1];
		}else if($sort[0] == 'contact_person'){
			$header_sort = $contact_person.' '.$sort[1];
		}else if($sort[0] == 'telephone'){
			$header_sort = $telephone.' '.$sort[1];
		}else if($sort[0] == 'mobile'){
			$header_sort = $mobile.' '.$sort[1];
		}else if($sort[0] == 'email'){
			$header_sort = $email.' '.$sort[1];
		}else if($sort[0] == 'address'){
			$header_sort = $address.' '.$sort[1];
		}else if($sort[0] == 'res_telephone'){
			$header_sort = $res_telephone.' '.$sort[1];
		}else if($sort[0] == 'res_mobile'){
			$header_sort = $res_mobile.' '.$sort[1];
		}else if($sort[0] == 'res_email'){
			$header_sort = $res_email.' '.$sort[1];
		}

		if(isset($search) && $search != ''){
			$where .= " AND (".$client_name." LIKE '%".$search."%' OR ";
			if($client_type == 'org'){
				$where .= $contact_person." LIKE '%".$search."%' OR ";
				$where .= $telephone." LIKE '%".$search."%' OR ";
				$where .= $mobile." LIKE '%".$search."%' OR ";
				$where .= $email." LIKE '%".$search."%' OR ";
			}
			if($client_type == 'ind'){
				$where .= $res_telephone." LIKE '%".$search."%' OR ";
				$where .= $res_mobile." LIKE '%".$search."%' OR ";
				$where .= $res_email." LIKE '%".$search."%' OR ";
				$where .= $serv_address." LIKE '%".$search."%' OR ";
			}
			$where .= $address." LIKE '%".$search."%' ) ";
		}

		$select = "select c.client_id, c.type, cn.notes, 
  		".$client_name." as client_name,
  		".$contact_person." as contact_person,
  		".$telephone." as telephone,
  		".$mobile." as mobile,
  		".$email." as email,
  		".$res_telephone." as res_telephone,
  		".$res_mobile." as res_mobile,
  		".$res_email." as res_email,
  		".$serv_address." as serv_address,
  		".$address." as address
  	";

    $query = " FROM clients c LEFT JOIN contacts_notes cn ON cn.client_id=c.client_id ";
    
    $query .= $where." order by ".$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

    //============== total count section ==============
    $total_select = "select count(c.client_id) as count";
    $total_qry 		= $total_select.$query;
    $totalVal 		= DB::select($total_qry);
    $total 				= json_decode(json_encode($totalVal), true);

    $data['details'] 			= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];//Client::countClientByType($client_type);

		return $data;
	}

	public static function nameQuery()
  {
    $fields = " CONCAT(ca.contact_title, ' ', ca.contact_fname, ' ', ca.contact_mname, ' ', ca.contact_lname) ";
    return $fields;
  }
  public static function fieldQuery($field_name)
  { 
    $fields = " (select field_value from steps_fields_staffs where field_name='".$field_name."' and staff_id=u.user_id group by staff_id) ";
    return $fields;
  }

	public static function get_tab_others($sendData)
  {
    $start        = $sendData['start'];
    $limit        = $sendData['limit'];
    $sorting      = $sendData['sorting'];
    $search       = $sendData['search'];
    $tab_id       = $sendData['tab_id'];

    $data =  $od  = array();

    $sort         = explode(' ', $sorting);
    $groupUserId  = Client::getSessionUserIds();

    $header_sort  = '';
    $where = " where ca.user_id IN (".implode(',', $groupUserId).") ";

    $contact_name   = ContactAddress::nameQuery();
    $address = " (select concat(cla.address1, ', ', cla.address2, ', ', cla.city, ', ', cla.county, ', ', cla.postcode, ', ', IF(cla.country >0, (select country_name from countries as cnt where cnt.country_id = cla.country), '') ) from client_addresses as cla where cla.address_id=ca.address_id) ";

    $name = " IF(ca.contact_type = 'company_name', 
    	(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=ca.client_id group by client_id),
    	".$contact_name."

    ) ";


    if($sort[0] == 'name'){
      $header_sort = " order by ".$name.' '.$sort[1];
    }else if($sort[0] == 'contact_name'){
      $header_sort = " order by ".$contact_name.' '.$sort[1];
    }else if($sort[0] == 'telephone'){
      $header_sort = " order by ca.telephone ".$sort[1];
    }else if($sort[0] == 'mobile'){
      $header_sort = " order by ca.mobile ".$sort[1];
    }else if($sort[0] == 'email'){
      $header_sort = ' order by ca.email '.$sort[1];
    }

    if(isset($search) && $search != ''){
      $where .= " AND (";
      $where .= " ca.telephone LIKE '%".$search."%' OR ";
      $where .= " ca.mobile LIKE '%".$search."%' OR ";
      $where .= " ca.email LIKE '%".$search."%' OR ";
      $where .= $address." LIKE '%".$search."%' OR ";
      $where .= $contact_name." LIKE '%".$search."%') ";
    }

    $select = "select ca.contact_id, ca.telephone, ca.mobile, ca.email,
      ".$name." as name,
      ".$contact_name." as contact_name,
      ".$address." as address
    ";

    $query = " FROM contact_addresses ca ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

    //============== total count section ==============
    $total_qry    = "select count(ca.contact_id) as count ".$query;
    $totalVal     = DB::select($total_qry);
    $total        = json_decode(json_encode($totalVal), true);

    $data['details']      = json_decode(json_encode($od), true);
    $data['TotalRecord']  = $total[0]['count'];

    return $data;

  }








}
