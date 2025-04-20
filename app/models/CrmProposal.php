<?php
class CrmProposal  extends Eloquent{
	
	public $timestamps = false;
	public $user_id;
	public $groupUserId;

	public function __construct()
	{
		parent::__construct();
		$session            = Session::get('admin_details');
    	$this->user_id      = $session['id'];
    	$this->groupUserId  = $session['group_users'];
	}

	public static function getAllDetails()
  {
  	$session    	= Session::get('admin_details');
  	$user_id    	= $session['id'];
  	$groupUserId    = $session['group_users'];

  	$data = CrmProposal::whereIn('user_id',$groupUserId)->get();
	return CrmProposal::getArray($data);
  }

  public static function getUserIdByCrmProposalId($crm_proposal_id)
  {
      $details = CrmProposal::where('crm_proposal_id',$crm_proposal_id)->first();
      $ids = json_decode($details);
      $user_id = 0;
      //Common::last_query();echo "<pre>";print_r($details)."gg";die;
      if(isset($ids->user_id) && $ids->user_id != ''){
          $user_id = $ids->user_id;
      }
      return $user_id;
  }

  public static function getColumnByCrmProposalId($column, $crm_proposal_id)
  {
      $details = CrmProposal::where('crm_proposal_id', $crm_proposal_id)->select($column)->first();
      $value = '';
      if(isset($details[$column]) && $details[$column] != ''){
          $value = $details[$column];
      }
      return $value;
  }

  public static function getUserEmailByCrmProposalId($crm_proposal_id)
  {
      $user_id  = CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);
      $email = User::getEmailByUserId($user_id);
      return $email;
  }

  public static function getProposalIdByCrmProposalId($crm_proposal_id)
  {
      $details = CrmProposal::where('crm_proposal_id',$crm_proposal_id)->first();
      $ids = json_decode($details);
      $proposalID = 0;
      //Common::last_query();echo "<pre>";print_r($details)."gg";die;
      if(isset($ids->proposalID) && $ids->proposalID != ''){
          $proposalID = $ids->proposalID;
      }
      return $proposalID;
  }

  public static function getProposalById( $crm_proposal_id )
  {
      $data = CrmProposal::where('crm_proposal_id', $crm_proposal_id)->first();
      return CrmProposal::getSingleArray($data);
  }

  public static function updateByCrmProposalId( $data, $crm_proposal_id )
  {
      CrmProposal::where('crm_proposal_id', $crm_proposal_id)->update($data);
  }

  public static function getSenderByCrmProposalId($crm_proposal_id)
  {
      $name = '';
      $details = CrmProposal::getProposalById( $crm_proposal_id );
      if(isset($details['contact_type']) && ($details['contact_type']=='p_org' || $details['contact_type']=='c_org')){
          $name = !empty($details['contact_name'])?$details['contact_name']:'';
      }else{
          if(isset($details['contact_type']) && $details['contact_type'] != ''){
              $cont_type = explode('_', $details['contact_type']);
              if($cont_type[0] == 'p'){
                  $name = CrmLead::getProspectNameByLeadsId($details['prospect_id']);
              }else if($cont_type[0] == 'c'){
                  $name = Client::getClientNameByClientId($details['prospect_id']);
              }
          }
      }

      $healthy    = array("Mr", "Mrs", "Miss" ,"Dr");
      $yummy      = array('', '', '', '');
      $newphrase  = str_replace($healthy, $yummy, $name);

      return trim($newphrase);
  }

  public static function getDetailsBySaveType($save_type)
  {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $data = CrmProposal::whereIn('user_id',$groupUserId)->where("save_type",$save_type)->get();
      return CrmProposal::getArray($data);
  }

  public static function getWonProposal()
  {
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];

      $data = CrmProposal::whereIn('user_id',$groupUserId)->where("save_type",'A')
          ->orWhere('save_type','MA')->get();
      return CrmProposal::getArray($data);
  }

  public static function checkProposalByProposalId($proposalID)
  {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $details = CrmProposal::whereIn('user_id', $groupUserId)->select('crm_proposal_id')->where('proposalID', '=', $proposalID)->first();
      $crm_proposal_id = 0;
      if(isset($details) && count($details) >0){
          $crm_proposal_id = $details->crm_proposal_id;
      }
      return $crm_proposal_id;
  }

  public static function getContactTypeById($id)
  {
      $details = CrmProposal::where('crm_proposal_id', $id)->select('contact_type')->first();
      $contact_type = '';
      if(isset($details->contact_type) && $details->contact_type != ''){
          $contact_type = $details->contact_type;
      }
      return $contact_type;
  }

  public static function getSaveTypeById($id)
  {
      $details = CrmProposal::where('crm_proposal_id', $id)->select('save_type')->first();
      $save_type = 'D';
      if(isset($details->save_type) && $details->save_type != ''){
          $save_type = $details->save_type;
      }
      return $save_type;
  }

  public static function getIdByProposalId($proposal_id)
  {
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];

      $details = CrmProposal::whereIn('user_id', $groupUserId)->where('proposalID', $proposal_id)->select('crm_proposal_id')->first();
      $crm_proposal_id = '';
      if(isset($details->crm_proposal_id) && $details->crm_proposal_id != ''){
          $crm_proposal_id = $details->crm_proposal_id;
      }
      return $crm_proposal_id;
  }

  public static function getDetailsByProposalId($proposalID, $groupUserId)
  {
      $details = CrmProposal::whereIn('user_id', $groupUserId)->where('proposalID', $proposalID)->first();
      return CrmProposal::getSingleArray($details);
  }

  public static function getNewProposalId()
  {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $details = CrmProposal::whereIn('user_id', $groupUserId)->select('crm_proposal_id')->orderBy('crm_proposal_id','DESC')->limit(1)->first();
      if(isset($details->crm_proposal_id) && ($details->crm_proposal_id!='0' && $details->crm_proposal_id!='')){
          $proposal_id = $details->crm_proposal_id + 100001;
      }else{
          $proposal_id = 100001;
      }
      return $proposal_id;
  }

  public static function getSingleArray($v)
  {
      $data = array();
      if(isset($v) && count($v) > 0){
          $data['crm_proposal_id']    = $v->crm_proposal_id;
          $data['entrpt_crm_prop_id'] = Crypt::encrypt($v->crm_proposal_id);
          $data['proposalID']         = $v->proposalID;
          $data['user_id']            = $v->user_id;
          $data['contact_type']       = $v->contact_type;
          $data['prospect_id']        = $v->prospect_id;
          $data['contact_id']         = $v->contact_id;
          $data['contact_name']       = $v->contact_name;
          $data['template_name']      = $v->template_name;
          $data['validity']           = $v->validity;
          $data['proposal_title']     = $v->proposal_title;
          $data['start_date']         = $v->start_date;
          $data['save_type']          = $v->save_type;
          $data['status']             = CrmProposal::getFullStatus($v->save_type);
          $data['is_signed']          = $v->is_signed;
          $data['is_rejected']        = $v->is_rejected;
          $data['brand_color']        = $v->brand_color;
          $data['brand_logo']         = $v->brand_logo;
          $data['end_date']           = $v->end_date;
          $data['created']            = $v->created;

          $data['prospect_name']  = CrmProposal::getProspectName($v->contact_type, $v->prospect_id);
          $data['unread_count']   = CrmProposalComment::getUnreadCount($v->crm_proposal_id);
          $data['fees']           = CrmProposalTable::getFeesByProposalId($v->proposalID);
          //$data['gross_fees']     = CrmProposalTable::getGrossFeesByProposalId($v->proposalID);
          $data['gross_fees']     = CrmProposalTable::getProposalAmountByProposalId($v->proposalID);
      }
      return $data;
  }

  public static function getArray($details)
  {
  	$data = array();
  	if(isset($details) && count($details) > 0){
  		foreach ($details as $k => $v) {
        if($v->proposalID != 99999){
    			$data[$k]['crm_proposal_id'] 	   = $v->crm_proposal_id;
          $data[$k]['entrpt_crm_prop_id']  = Crypt::encrypt($v->crm_proposal_id);
          $data[$k]['proposalID']          = $v->proposalID;
    			$data[$k]['user_id']             = $v->user_id;
    			$data[$k]['contact_type'] 		   = $v->contact_type;
    			$data[$k]['prospect_id'] 		     = $v->prospect_id;
    			$data[$k]['contact_id'] 		     = $v->contact_id;
          $data[$k]['contact_name']        = $v->contact_name;
          $data[$k]['template_name']       = $v->template_name;
    			$data[$k]['validity'] 			     = $v->validity;
    			$data[$k]['proposal_title'] 	   = $v->proposal_title;
    			$data[$k]['start_date'] 		     = $v->start_date;
    			$data[$k]['save_type'] 			     = $v->save_type;
          $data[$k]['status']              = CrmProposal::getFullStatus($v->save_type);
          $data[$k]['is_signed']           = $v->is_signed;
          $data[$k]['is_rejected']         = $v->is_rejected;
          $data[$k]['brand_color']         = $v->brand_color;
          $data[$k]['brand_logo']          = $v->brand_logo;
    			$data[$k]['end_date'] 			     = $v->end_date;
    			$data[$k]['created'] 			       = $v->created;

    			$data[$k]['prospect_name']= CrmProposal::getProspectName($v->contact_type, $v->prospect_id);
          $data[$k]['unread_count'] = CrmProposalComment::getUnreadCount($v->crm_proposal_id);
          $data[$k]['fees']         = CrmProposalTable::getFeesByProposalId($v->proposalID);
          //$data[$k]['gross_fees']     = CrmProposalTable::getGrossFeesByProposalId($v->proposalID);
          $data[$k]['gross_fees']   = CrmProposalTable::getProposalAmountByProposalId($v->proposalID);
        }
  		}
  	}
  	return $data;
  }

  public static function getFullStatus($status)
  {
      $name = '';
      if($status == 'NS'){
          $name = 'Not Started';
      }elseif($status == 'D'){
          $name = 'Draft';
      }else if($status == 'F'){
          $name = 'Final';
      }else if($status == 'T'){
          $name = 'Template';
      }else if($status == 'E'){
          $name = 'Sent';
      }else if($status == 'V'){
          $name = 'Viewed';
      }else if($status == 'A' || $status == 'MA'){
          $name = 'Accepted';
      }else if($status == 'L' || $status == 'ML'){
          $name = 'Lost';
      }else if($status == 'R'){
          $name = 'Revoked';
      }else if($status == 'C'){
          $name = 'Copy';
      }else if($status == 'Edit'){
          $name = 'Edit';
      }
      return $name;
  }

  public static function getProspectName($c_type, $p_id)
  {
  	$name = '';
  	$cont_type = explode('_', $c_type);
  	if($cont_type[0] == 'p'){
  		$name = CrmLead::getAllByClientTypeAndLeadId($cont_type[1], $p_id);
  	}else if($cont_type[0] == 'c'){
  		$name = Client::getClientNameByClientId($p_id);
  	}
  	return $name;
  }

  public static function getSaveType($p_id)
  {
      $type = '';
      if($p_id != '0'){
          $detls = CrmProposal::where("crm_proposal_id","=",$p_id)->select('save_type')->first();
          $type = $detls['save_type'];
      }
      return $type;
  }

  public static function deleteProposal($proposal_id, $crm_proposal_id)
  {
      CrmProposal::where("crm_proposal_id", $crm_proposal_id)->delete();
      CrmProposalAttachment::where('proposal_id', $proposal_id )->delete();
      CrmProposalComment::where('crm_proposal_id', $crm_proposal_id )->delete();
      CrmProposalCoverletter::where('proposal_id', $proposal_id )->delete();
      CrmProposalGrandTotal::where('proposal_id', $proposal_id )->delete();
      CrmProposalHistory::where('proposal_id', $proposal_id )->delete();
      CrmProposalSentEmail::where('crm_proposal_id', $crm_proposal_id )->delete();
      CrmProposalServicesTable::where('proposal_id', $proposal_id )->delete();
      CrmProposalSign::where('crm_proposal_id', $crm_proposal_id )->delete();
      CrmProposalTerm::where('proposal_id', $proposal_id )->delete();
      //CrmTableHeading::where('proposal_id', $proposal_id )->delete();
      RenewalsManage::where('proposal_id', $proposal_id )->delete();

      $tables  = CrmProposalTable::where('proposal_id', $proposal_id )->get()->toArray();
      CrmProposalTable::where('proposal_id', $proposal_id )->delete();
      foreach ($tables as $t) 
      {
          $services   = CrmProposalService::where('p_table_id', $t['id'] )->get()->toArray();
          CrmProposalService::where('p_table_id', $t['id'] )->delete();
          foreach ($services as $s) 
          {
              $activity   = CrmProposalActivity::where('p_service_id', $s['p_service_id'] )->get()->toArray();
              foreach ($activity as $a) 
              {
                  CrmProposalActivity::where('p_service_id', $a['p_service_id'] )->delete();
                  CrmProposalServiceFee::where('p_service_id',$a['p_service_id'])->where('proposal_id',$proposal_id )->delete();
              }

              
          }
      }
      return $proposal_id;
  }

  public static function getProposalSendingEmail($crm_proposal_id)
  {
      $email = '';
      $details = CrmProposal::getProposalById($crm_proposal_id);
      if(isset($details['contact_type']) && $details['contact_type'] == 'c_ind'){
          $email = StepsFieldsClient::getFieldValueByClientId($details['prospect_id'], 'res_email');
      }else if(isset($details['contact_type']) && $details['contact_type'] == 'c_org'){
          $contacts  = explode('_', $details['contact_id']);
          if(isset($contacts[1]) && $contacts[1] == 'C'){
              $email = ContactAddress::getEmailByContactId($contacts[0]);
          }
          if(isset($contacts[1]) && $contacts[1] == 'R'){
              $email = StepsFieldsClient::getFieldValueByClientId($contacts[0], 'res_email');
          }
      }else if(isset($details['contact_type']) && $details['contact_type'] == 'p_ind'){
          $email = CrmLead::getEmailByLeadsId($details['prospect_id']);
      }else if(isset($details['contact_type']) && $details['contact_type'] == 'p_org'){
          $email = CrmLead::getEmailByLeadsId($details['contact_id']);
      }
      //echo "<pre>";print_r($details); 
      //Common::last_query();

      return $email;
  }

  public static function getFirstDropById($crm_proposal_id)
  {
      $name = '';
      $details = CrmProposal::where('crm_proposal_id',$crm_proposal_id)->select('contact_type')->first();
      if(isset($details->contact_type) && $details->contact_type == 'c_ind'){
          $name = 'Client - Individual';
      }else if(isset($details->contact_type) && $details->contact_type == 'c_org'){
          $name = 'Client - Organisation';
      }else if(isset($details->contact_type) && $details->contact_type == 'p_ind'){
          $name = 'Prospect - Individual';
      }else if(isset($details->contact_type) && $details->contact_type == 'p_org'){
          $name = 'Prospect - Organisation';
      }else{
          $name = 'Template';
      }
      //echo "<pre>";print_r($details); 
      //Common::last_query();

      return $name;
  }

  public static function getSecondDropById($crm_proposal_id)
  {
      $name = '';
      $details = CrmProposal::where('crm_proposal_id',$crm_proposal_id)->select('contact_type', 'prospect_id')->first();
      if(isset($details->contact_type) && $details->contact_type != ''){
          $name = CrmProposal::getProspectName($details->contact_type, $details->prospect_id);
      }
      //echo "<pre>";print_r($details); 
      //Common::last_query();

      return $name;
  }

  public static function getPreviewBrandingColor($groupUserId, $crm_proposal_id)
  {
      //$proposals = CrmProposal::getProposalById( $crm_proposal_id );
      $ps  = CrmProposal::where("crm_proposal_id",$crm_proposal_id)->select('save_type','brand_color')->first();
      if(isset($ps->save_type) && ($ps->save_type == 'E' || $ps->save_type == 'A' || $ps->save_type == 'MA' || $ps->save_type == 'L' || $ps->save_type == 'ML')){
          $color = $ps->brand_color;
      }else{
          $color = PracticeDetail::getBrandingColor( $groupUserId );
      }
      return $color;
  }

  public static function getPreviewBrandingLogo($groupUserId, $crm_proposal_id)
  {
      //$proposals = CrmProposal::getProposalById( $crm_proposal_id );
      $ps = CrmProposal::where("crm_proposal_id",$crm_proposal_id)->select('save_type','brand_logo')->first();
      if(isset($ps->save_type) && ($ps->save_type == 'E' || $ps->save_type == 'A' || $ps->save_type == 'MA' || $ps->save_type == 'L' || $ps->save_type == 'ML')){
          $logo = $ps->brand_logo;
      }else{
          $logo = PracticeDetail::getBrandingLogo( $groupUserId );
      }
      return $logo;
  }

  public static function getCountDown($enddate)
  {
      $renwaldate = date('Y-m-d');
      $today      = date('Y-m-d');
      if(isset($enddate) && $enddate != ""){
          $renwaldate = date("Y-m-d", strtotime($enddate));
      }
      $diff = strtotime($renwaldate) - time();
      $days = round($diff/86400);
      
      return $days;
  }

  public static function getClientAnnualFees($type)
  {
      $toal_annual    = 0;
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];

      $clients = Client::where("is_deleted", "N")->where("type", $type)->where("is_archive", "N")->where("is_relation_add", "N")->whereIn("user_id", $groupUserId)->select('client_id')->get();

      if(isset($clients) && count($clients) >0){
          foreach ($clients as $k => $v) {
              $toal_annual += CrmProposal::getAnnualFeesByClientId($v->client_id);
          }
      }

      return $toal_annual;
  }

  public static function getAnnualFeesByClientId($client_id)
  {
      $fees = 0;
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];
      /*$acc_details = CrmAccDetail::getDetailsByClientId($client_id);
      if(isset($acc_details['billing_amount']) && $acc_details['billing_amount']!=""){
          $fees += str_replace(',','', $acc_details['billing_amount']);
      }*/

      $contracts = CrmProposal::recurringProposalByClientId($client_id);
      if(isset($contracts) && count($contracts) >0){
          foreach ($contracts as $k => $v) {
              //$gross_fees  = CrmProposalTable::getProposalAmountByProposalId($v['proposal_id']);
              $annual_fee = CrmProposalTable::getRecurAmntByProposalId($v['proposal_id'], $groupUserId);
              $fees += str_replace(',', '', $annual_fee);
          }
      }
      return $fees;
  }

  public static function recurringProposalByClientId($client_id)
  {
      $data = array();
      $groupUserId    = Client::getSessionUserIds();

      $countDown = "DATEDIFF( cp.end_date, NOW())";

      $where = " cp.prospect_id='".$client_id."' 
          AND (cp.contact_type='c_org' OR cp.contact_type='c_ind')
          AND (cp.save_type='A' OR cp.save_type='MA') 
          AND cp.proposalID IN (select proposal_id FROM crm_proposal_tables cpts 
                  WHERE cpts.package_type='R' group by cpts.proposal_id)
          AND cp.user_id IN ('".implode(',', $groupUserId)."')";

      $sql = "select cp.crm_proposal_id, 
          cp.proposalID as proposal_id, 
          cp.start_date,
          cp.end_date,
          ".$countDown." as count_down,
          cp.proposal_title

          FROM crm_proposals cp LEFT JOIN renewals_manages rm ON 
          (cp.proposalID = rm.proposal_id and cp.prospect_id = rm.client_id)

          WHERE rm.manage_id is NULL AND ".$where;
      //echo $sql;die;
      $od = DB::select($sql);
      $details = json_decode(json_encode($od), true);
      $positive = $negative = $renpos = $renneg = array();
      if(isset($details) && count($details) >0){
          $i = 0;
          foreach ($details as $k => $v) {
              $renewals = RenewalsManage::getRenewalsByProposalAndClientId($v['proposal_id'], $client_id);
              if(isset($renewals) && $renewals == 'Y'){
                  if(isset($v['count_down']) && $v['count_down'] >= 0){
                      $renpos[$i] = $v;
                  }
                  if(isset($v['count_down']) && $v['count_down'] < 0){
                      $renneg[$i] = $v;
                  }
              }else{
                  if(isset($v['count_down']) && $v['count_down'] >= 0){
                      $positive[$i] = $v;
                  }
                  if(isset($v['count_down']) && $v['count_down'] < 0){
                      $negative[$i] = $v;
                  }
              }
              $i++;
          }
      }
      //echo "<pre>";print_r($negative);die;

      if(isset($positive) && count($positive) >0){
          foreach ($positive as $k => $v) {
           $posCount[$k] = strtolower($v['count_down']);
          }
          array_multisort($posCount, SORT_ASC, $positive);
      }

      if(isset($negative) && count($negative) >0){
          foreach ($negative as $k => $v) {
           $negCount[$k] = strtolower($v['count_down']);
          }
          array_multisort($negCount, SORT_DESC, $negative);
      }

      if(isset($renpos) && count($renpos) >0){
          foreach ($renpos as $k => $v) {
           $renposCount[$k] = strtolower($v['count_down']);
          }
          array_multisort($renposCount, SORT_ASC, $renpos);
      }

      if(isset($renneg) && count($renneg) >0){
          foreach ($renneg as $k => $v) {
           $rennegCount[$k] = strtolower($v['count_down']);
          }
          array_multisort($rennegCount, SORT_ASC, $renneg);
      }

      //echo "<pre>";print_r($positive);die;
      $mergeArray = array_merge($positive, $negative, $renpos, $renneg);
      $data = array_values($mergeArray);

      //echo "<pre>";print_r($data);die;
      return $data;
  }

  public static function proposalLists($sendData)
  {
    $start              = $sendData['start'];
    $limit              = $sendData['limit'];
    $sorting            = $sendData['sorting'];
    $search             = $sendData['search'];
    $page_open          = $sendData['page_open'];

    $data =  $od        = array();
    $sort               = explode(' ', $sorting);
    $groupUserId        = Client::getSessionUserIds();

    $header_sort    = '';

    $where = " WHERE cp.user_id IN('".implode(',',$groupUserId)."') ";

    $client_name = " (select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=cp.client_id group by client_id) ";

    $lead_name = " (SELECT IF(cl.client_type='org', cl.prospect_name , CONCAT(cl.prospect_title,' ',cl.prospect_fname, ' ', cl.prospect_lname) ) from crm_leads as cl where cl.leads_id=cp.prospect_id) ";

    $prospect_name = " (SELECT IF(cp.contact_type='c_ind' OR cp.contact_type='c_org', ".$client_name.", ".$lead_name." ) ) ";

    if($sort[0] == 'date'){
      $header_sort = " order by cp.crm_proposal_id ".$sort[1];
    }else if($sort[0] == 'proposalID'){
      $header_sort = " order by cp.proposalID ".$sort[1];
    }else if($sort[0] == 'proposal_title'){
      $header_sort = " order by cp.proposal_title ".$sort[1];
    }else if($sort[0] == 'prospect_name'){
      $header_sort = " order by ".$prospect_name." ".$sort[1];
    }else if($sort[0] == 'amount'){
      $header_sort = " order by ".$amount." ".$sort[1];
    }

    if(isset($search) && $search != ''){
      $where .= " AND (cp.proposalID LIKE '%".$search."%' OR ";
      $where .= " cp.proposal_title LIKE '%".$search."%' OR ";
      $where .= $prospect_name." LIKE '%".$search."%' OR ";
      $where .= " DATE_FORMAT(cp.created,'%d-%m-%Y') LIKE '%".$search."%' ) ";
    }
    
    $select = "SELECT cp.crm_proposal_id, cp.proposalID, save_type, is_rejected, proposal_title,
      DATE_FORMAT(cp.created,'%d-%m-%Y %H:%i:%s') as created, is_signed,
      ".$prospect_name." as prospect_name
    ";

    $query = " FROM crm_proposals cp ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

        //============== total count section ==============
    $total_qry          = "SELECT count(cp.crm_proposal_id) as count ".$query;
    $totalVal           = DB::select($total_qry);
    $total              = json_decode(json_encode($totalVal), true);

    $data['details']    = json_decode(json_encode($od), true);
    $data['TotalRecord']= $total[0]['count'];

    return $data;
  }


    

}
