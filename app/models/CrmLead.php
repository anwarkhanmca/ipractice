<?php
class CrmLead extends Eloquent {

	public $timestamps = false;
	
	public static function getAllOpportunity()
  {
  	$data = array();
  	$session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];
	  $crm_data 		= CrmLead::whereIn("user_id", $groupUserId)->where("leads_type", "O")->where("is_deleted", "N")->where("is_archive", "N")->get();

    return CrmLead::getArray($crm_data);
  }

  public static function getOpportunityByClientId($client_id)
  {
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
	  $crm_data 		= CrmLead::whereIn("user_id", $groupUserId)->where("existing_client", $client_id)->where("is_deleted", "N")->where("is_archive", "N")->get();
		//Common::last_query();
		$data = CrmLead::getArray($crm_data);
	
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
  }

  public static function getArray($crm_data)
  {
  	$data = array();
  	if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $key => $details) {
				$data[$key]['leads_id']       = $details->leads_id;
				$data[$key]['leads_type']     = $details->leads_type;
				$data[$key]['user_id']        = $details->user_id;
        $data[$key]['is_exists']      = $details->is_exists;
				$data[$key]['client_type']    = $details->client_type;
				$data[$key]['date']    		    = date('d-m-Y', strtotime($details->date));
				$data[$key]['deal_certainty'] = $details->deal_certainty;
				$data[$key]['existing_client']= $details->existing_client;
				$data[$key]['crm_proposal_id']= $details->crm_proposal_id;
        $data[$key]['deal_owner']     = User::getStaffNameById($details->deal_owner);
        $data[$key]['contact_person'] = $details->contact_person;
        $data[$key]['add_contact']    = $details->add_contact;
        $data[$key]['contact_type']   = $details->contact_type;
        $data[$key]['position']       = $details->position;
        $data[$key]['person_type']    = $details->person_type;
        $data[$key]['proposal_title'] = $details->proposal_title;
        $data[$key]['phone']          = $details->phone;
        $data[$key]['mobile']         = $details->mobile;
        $data[$key]['email']          = $details->email;
        $data[$key]['website']        = $details->website;
				$data[$key]['prospect_title'] = $details->prospect_title;
      	$data[$key]['prospect_fname'] = $details->prospect_fname;
      	$data[$key]['prospect_lname'] = $details->prospect_lname;
      	$data[$key]['business_type']  = $details->business_type;
        $data[$key]['prospect_name']  = $details->prospect_name;
        $data[$key]['contact_title']  = $details->contact_title;
        $data[$key]['contact_name']   = $details->contact_name;
        $data[$key]['contact_fname']  = $details->contact_fname;
        $data[$key]['contact_mname']  = $details->contact_mname;
        $data[$key]['contact_lname']  = $details->contact_lname;
				$data[$key]['annual_revenue'] = $details->annual_revenue;
        $data[$key]['quoted_value']   = $details->quoted_value;
        $data[$key]['lead_source']    = $details->lead_source;
        $data[$key]['source_name']	  = LeadSource::getLeadSourceName($details->lead_source);
        $data[$key]['industry']       = $details->industry;
        $data[$key]['street']         = $details->street;
        $data[$key]['city']           = $details->city;
        $data[$key]['county']         = $details->county;
        $data[$key]['postal_code']    = $details->postal_code;
        $data[$key]['country_id']     = $details->country_id;
        $data[$key]['address_id']     = ($details->address_id >0)?$details->address_id:'';
        $data[$key]['notes']          = $details->notes;
        $data[$key]['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
        $data[$key]['is_invoiced']    = $details->is_invoiced;
        $data[$key]['is_archive']     = $details->is_archive;
        $data[$key]['show_archive']   = $details->show_archive;
        $data[$key]['is_onboarding']  = $details->is_onboarding;
        $data[$key]['lead_status']    = CrmLeadsStatus::getTabIdByLeadsId( $details->leads_id );
        $data[$key]['tab_name'] 	    = CrmLead::getTabNameByLeadsId($details->leads_id);
        $data[$key]['proposalSvType'] = CrmProposal::getSaveType( $details->crm_proposal_id );
        $data[$key]['contactName']    = CrmLead::getContactNameByLeadsId( $details->leads_id );
			}
	  }
	  return $data;
  }

  public static function getAllLeads()
  {
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
	  $details 	= CrmLead::whereIn("user_id", $groupUserId)->where("leads_type", "L")->where("is_deleted", "N")->where("is_archive", "N")->get();

	  return CrmLead::getArray($details);
  }

  public static function getInvoiceLeadsDetails()
  {
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
		$details = CrmLead::whereIn("user_id", $groupUserId)->where("is_invoiced", "Y")->where("is_archive", "N")->get();
		return CrmLead::getArray($details);
  }

  public static function getDataWithDateRange($from_date, $to_date)
  {
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
	  $details = CrmLead::whereIn("user_id", $groupUserId)->whereBetween('date', array($from_date, $to_date))->where("is_deleted", "N")->where("close_date", "!=", "0000-00-00")->where("is_archive", "N")->get();
	  //Common::last_query();
	  return CrmLead::getArray($details);
  }

  public static function getDataWithDateRangeAndLeadsId($from_date, $to_date, $leads_id)
  {
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
	  $details = CrmLead::whereIn("user_id", $groupUserId)->whereBetween('date', array($from_date, $to_date))->where("is_deleted", "N")->where("is_archive", "N")->where("leads_id", $leads_id)->get();
	 //Common::last_query();
	  return CrmLead::getArray($details);
  }

  public static function getLeadsByLeadsId( $leads_id )
  {
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
		$details = CrmLead::where("leads_id", $leads_id)->where("is_deleted", "N")->where("is_archive", "N")->first();
	
  	//echo "<pre>";print_r($data);echo "</pre>";die;
  	return CrmLead::getSingleArray($details);
  }

  public static function getSingleArray($details)
  {
    $data = array();
    if(isset($details) && count($details) >0){
      $data['leads_id']       = $details->leads_id;
      $data['leads_type']     = $details->leads_type;
      $data['user_id']        = $details->user_id;
      $data['is_exists']      = $details->is_exists;
      $data['existing_client']= $details->existing_client;
      $data['crm_proposal_id']= $details->crm_proposal_id;
      $data['client_type']    = $details->client_type;
      $data['date']           = date('d-m-Y', strtotime($details->date));
      $data['deal_certainty'] = $details->deal_certainty;
      $data['deal_owner']     = $details->deal_owner;
      $data['contact_person'] = $details->contact_person;
      $data['add_contact']    = $details->add_contact;
      $data['contact_type']   = $details->contact_type;
      $data['position']       = $details->position;
      $data['person_type']    = $details->person_type;
      $data['proposal_title'] = $details->proposal_title;
      $data['phone']          = $details->phone;
      $data['mobile']         = $details->mobile;
      $data['email']          = $details->email;
      $data['website']        = $details->website;
      $data['prospect_title'] = $details->prospect_title;
      $data['prospect_fname'] = $details->prospect_fname;
      $data['prospect_mname'] = $details->prospect_mname;
      $data['prospect_lname'] = $details->prospect_lname;
      $data['business_type']  = $details->business_type;
      $data['prospect_name']  = $details->prospect_name;
      $data['contact_name']   = $details->contact_name;
      $data['contact_title']  = $details->contact_title;
      $data['contact_fname']  = $details->contact_fname;
      $data['contact_mname']  = $details->contact_mname;
      $data['contact_lname']  = $details->contact_lname;
      $data['annual_revenue'] = $details->annual_revenue;
      $data['quoted_value']   = $details->quoted_value;
      $data['lead_source']    = $details->lead_source;
      $data['source_name']    = LeadSource::getLeadSourceName($details->lead_source);
      $data['industry']       = $details->industry;
      $data['street']         = $details->street;
      $data['city']           = $details->city;
      $data['county']         = $details->county;
      $data['postal_code']    = $details->postal_code;
      $data['country_id']     = $details->country_id;
      $data['address_id']     = $details->address_id;
      $data['notes']          = $details->notes;
      $data['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
      $data['is_invoiced']    = $details->is_invoiced;
      $data['is_archive']     = $details->is_archive;
      $data['show_archive']   = $details->show_archive;
      $data['is_onboarding']  = $details->is_onboarding;
      $data['lead_status']    = CrmLeadsStatus::getTabIdByLeadsId( $details->leads_id );
      $data['tab_name']       = CrmLead::getTabNameByLeadsId( $details->leads_id );
      $data['proposalSvType'] = CrmProposal::getSaveType( $details->crm_proposal_id );
      $data['contactName']    = CrmLead::getContactNameByLeadsId( $details->leads_id );
    }
    return $data;
  }

  public static function getLeadsCount()
  {
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
	  $crm_count = CrmLead::whereIn("user_id", $groupUserId)->where("is_deleted", "N")->where("is_archive", "N")->get()->count();
	  return $crm_count;
  }

  public static function getTotalQuotedValue( $leads_tab_id )
  {
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
		$status_details = CrmLeadsStatus::leadsStatusByTabId($leads_tab_id);

		if(isset($status_details) && count($status_details) >0){
			$total    = 0;
      $average  = 0;
      $likely   = 0;
			foreach ($status_details as $key => $value) {
				$crn_lead = CrmLead::where("leads_id", "=", $value['leads_id'])->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->first();
				if(isset($crn_lead->quoted_value) && $crn_lead->quoted_value != ""){
					$quoted_value = str_replace(",", "", $crn_lead->quoted_value);
					$total += $quoted_value;
					$likely += ($crn_lead->deal_certainty*$quoted_value)/100;
				}
				$average = $total/count($status_details);
			}
			/*$data['total']     = number_format($total, 2, '.', '');
      $data['average']   = number_format($average, 2, '.', '');
      $data['likely']    = number_format($likely, 2, '.', '');*/
      $data['total']     	= number_format($total, 2);
      $data['average']   	= number_format($average, 2);
      $data['likely']    	= number_format($likely, 2);
    }

		return $data;
  }

  public static function getLeadsTypeByLeadsId($leads_id)
  {
  	$leads_type = CrmLead::where("leads_id", $leads_id)->select('leads_type')->first();
    return $leads_type['leads_type'];
  }

  public static function getLeadsIdByCrmProposalId($crm_proposal_id)
  {
  	$leads = CrmLead::where("crm_proposal_id", $crm_proposal_id)->select('leads_id')->first();
  	$leads_id = 0;
  	if(isset($leads->leads_id) && $leads->leads_id != ''){
  		$leads_id = $leads->leads_id;
  	}
    return $leads_id;
  }

  public static function getCrmProposalIdByLeadsId($leads_id)
  {
  	$leads = CrmLead::where("leads_id", $leads_id)->select('crm_proposal_id')->first();
  	$crm_proposal_id = 0;
  	if(isset($leads->crm_proposal_id) && $leads->crm_proposal_id != ''){
  		$crm_proposal_id = $leads->crm_proposal_id;
  	}
    return $crm_proposal_id;
  }

  public static function getContactNameByLeadsId($leads_id)
  {
    $name = '';
    $cname = array();

  	$l = CrmLead::where("leads_id", $leads_id)
      ->select('client_type', 'is_exists', 'contact_name', 'add_contact', 'contact_type', 'contact_title', 'contact_fname', 'contact_mname', 'contact_lname', 'contact_person')->first();

    if(isset($l->client_type) && $l->client_type == 'org'){
      if(isset($l->is_exists) && $l->is_exists == 'Y'){
        if(!empty($l->contact_name)){
          $cname = explode('_', $l->contact_name);
        }
      }
      if(isset($l->is_exists) && $l->is_exists == 'N'){
        if(!empty($l->add_contact) && $l->add_contact == 'N'){
          $name = $l->contact_title.' '.$l->contact_fname.' '.$l->contact_mname.' '.$l->contact_lname;
        }
        if(!empty($l->add_contact) && $l->add_contact == 'E'){
          $cname = explode('_', $l->contact_person);
        }
      }

      if(isset($cname) && !empty($cname) && count($cname) >0){
        if(isset($cname[1]) && $cname[1] == 'R'){
          $name = Client::getClientNameByClientId($cname[0]);
        }else{
          $name = ContactAddress::getContactNameById($cname[0]);
        }
      }
    }

    return $name;
  }

  public static function getProspectNameByLeadsId($leads_id)
  {
  	$leads = CrmLead::where("leads_id", $leads_id)->select('prospect_name', 'prospect_title', 'prospect_fname', 'prospect_lname')->first();
  	if(isset($leads['prospect_name']) && $leads['prospect_name'] != ''){
  		return $leads['prospect_name'];
  	}else{
  		return $leads['prospect_title'].' '.$leads['prospect_fname'].' '.$leads['prospect_lname'];
  	}
  }

  public static function getCompanyNumber($company_name)
	{
		$company_number = 0;
    $value = str_replace(" ", "+", $company_name);
    $compamy_details    = Common::getSearchCompany($value);
    if(isset($compamy_details->items) && count($compamy_details->items) >0 )
    {
      foreach ($compamy_details->items as $key => $value) {//return $company_name;die;
        //$company[$key]['company_name']      = $value->title;
        //$company[$key]['company_number']    = $value->company_number;
        $comp_name = str_replace("+", " ", $company_name);
        if(strtolower($company_name) == strtolower($value->title)){
        	$company_number = $value->company_number;
        }
      }
    }

    return $company_number;
	}

	public static function updateCrmLeadsStatus($client_id, $data)
	{
		$crm_leads = Client::where('client_id', $client_id)->select('crm_leads_id')->first();
		if(isset($crm_leads['crm_leads_id']) && $crm_leads['crm_leads_id'] != 0){
			CrmLead::where('leads_id', '=', $crm_leads['crm_leads_id'])->update($data);
		}
	}

	public static function getTabNameByLeadsId($leads_id)
	{
		$value = "";
		$details = DB::table('crm_leads_statuses as cls')->where("cls.leads_id", "=", $leads_id)
            ->join('crm_leads_tabs as clt', 'cls.leads_tab_id', '=', 'clt.tab_id')
            ->select('clt.tab_name')->first();
    if(isset($details->tab_name) && $details->tab_name != "" )
    {
    	$value = $details->tab_name;
    }
    return $value;
	}

	public static function getAllOpportunityByClientType($client_type)
  {//echo $client_type;die;
  	$data = array();
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
		$crm_data 		= CrmLead::whereIn("user_id", $groupUserId)->where("client_type", $client_type)->where("leads_type", "O")->where("is_deleted", "N")->where("is_archive", "N")->select('leads_id', 'client_type', 'prospect_name', 'prospect_title', 'prospect_fname', 'prospect_lname')->get();

  	if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $k => $d) {
				$lead_status    = CrmLeadsStatus::getTabIdByLeadsId( $d->leads_id );
				if(isset($lead_status) && ($lead_status != 8 && $lead_status != 9 && $lead_status != 10)){
					$data[$k]['leads_id']       	= $d->leads_id;
					$data[$k]['client_type']     	= $d->client_type;
					if($d->client_type == 'org'){
						$data[$k]['prospect_name']= $d->prospect_name;
					}else{
						$data[$k]['prospect_name']= $d->prospect_title.' '.$d->prospect_fname.' '.$d->prospect_lname;
					}
				}
			}
		}

		return $data;
  }

  public static function getAllByClientTypeAndLeadId($client_type, $leads_id)
  {
  	$name = '';
  	$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
		/*$d 		= CrmLead::where("leads_id", $leads_id)->where("client_type", "=", $client_type)->where("leads_type", "=", "O")->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->select('prospect_name', 'prospect_title', 'prospect_fname', 'prospect_lname', 'client_type')->first();*/
		$d 	= CrmLead::where("leads_id", $leads_id)->select('prospect_name', 'prospect_title', 'prospect_fname', 'prospect_lname', 'client_type')->first();
    	if(isset($d) && count($d) >0){
			if($d->client_type == 'org'){
				$name = $d->prospect_name;
			}else{
				$name = $d->prospect_title.' '.$d->prospect_fname.' '.$d->prospect_lname;
			}
		}

		return $name;
  }

  public static function getEmailByLeadsId($leads_id)
  {
  	$email = '';
	$details = CrmLead::where("leads_id", $leads_id)->select('email')->first();
	if(isset($details->email) && $details->email != ''){
		$email 	= $details->email;
	}
	return $email;
  }

  public static function getFullAddress($leads_id)
  {
    $address = "";
    if($leads_id != '0' && $leads_id != ""){
      $value = CrmLead::where("leads_id", $leads_id)->first();

      $country_name  = Country::getCountryNameByCountryId($value->country_id);
      $address .= (isset($value->street) && $value->street != '')?', '.$value->street:'';
      $address .= (isset($value->city) && $value->city != '')?', '.$value->city:'';
      $address .= (isset($value->county) && $value->county != '')?', '.$value->county:'';
      $address .= (isset($value->post_code) && $value->post_code != '')?', '.$value->post_code:'';
      $address .= (isset($country_name) && $country_name != '')?', '.$country_name:'';
    }
    
    return $address;
  }


}
