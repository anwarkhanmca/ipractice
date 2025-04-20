<?php
class CrmAccDetail extends Eloquent {

	public $timestamps = false;
	public static function getDetailsByClientId($client_id)
	{
		$data = array();
		$session = Session::get('admin_details');
    $user_id = $session['id'];
    $groupUserId = $session['group_users'];

		$v = CrmAccDetail::whereIn("user_id", $groupUserId)->where('client_id', $client_id)->first();
		if(isset($v) && count($v) >0){
			$data['acc_id'] 		= $v['acc_id'];
			$data['twitter'] 		= $v['twitter'];
			$data['fax'] 				= $v['fax'];
			$data['engagement_date']= ($v['engagement_date'] != '0000-00-00')?date('d-m-Y', strtotime($v['engagement_date'])):'';
			$data['payment_method'] = $v['payment_method'];
			$data['billing_cycle'] 	= $v['billing_cycle'];
			$data['industry_id'] 		= $v['industry_id'];
			$data['lead_source_id'] = $v['lead_source_id'];
			$data['contact_id'] 		= $v['contact_id'];
			$data['startdate']=($v['startdate']!='0000-00-00')?date('d-m-Y',strtotime($v['startdate'])):'';
			$data['enddate'] 		= ($v['enddate']!= '0000-00-00')?date('d-m-Y', strtotime($v['enddate'])):'';
			$data['billing_amount'] = $v['billing_amount'];
			$data['monthly_amount'] = number_format(str_replace(',', '', $v['billing_amount'])/12, 2);
			$data['is_invoiced'] 		= $v['is_invoiced'];
			$data['sign_off_date'] 	= $v['sign_off_date'];
			$data['created'] 				= $v['created'];
			$data['count_down'] 		= CrmAccDetail::getCountDown($v['enddate']);
		}
		return $data;
	}

	public static function getDetailsByClientAndServiceId($client_id, $service_id)
	{
		$data = array();
		$session = Session::get('admin_details');
    $user_id = $session['id'];
    $groupUserId = $session['group_users'];

		$v = CrmAccDetail::whereIn("user_id", $groupUserId)->where('client_id', $client_id)->where('service_id', $service_id)->first();
		if(isset($v) && count($v) >0){
			$data['acc_id'] 		= $v['acc_id'];
			$data['twitter'] 		= $v['twitter'];
			$data['fax'] 				= $v['fax'];
			$data['engagement_date']= ($v['engagement_date'] != '0000-00-00')?date('d-m-Y', strtotime($v['engagement_date'])):'';
			$data['payment_method'] = $v['payment_method'];
			$data['billing_cycle'] 	= $v['billing_cycle'];
			$data['industry_id'] 		= $v['industry_id'];
			$data['lead_source_id'] = $v['lead_source_id'];
			$data['contact_id'] 		= $v['contact_id'];
			$data['startdate']=($v['startdate']!='0000-00-00')?date('d-m-Y',strtotime($v['startdate'])):'';
			$data['enddate'] 		= ($v['enddate']!= '0000-00-00')?date('d-m-Y', strtotime($v['enddate'])):'';
			$data['billing_amount'] = $v['billing_amount'];
			$data['monthly_amount'] = number_format(str_replace(',', '', $v['billing_amount'])/12, 2);
			$data['is_invoiced'] 		= $v['is_invoiced'];
			$data['sign_off_date'] 	= $v['sign_off_date'];
			$data['created'] 				= $v['created'];
			$data['count_down'] 		= CrmAccDetail::getCountDown($v['enddate']);
		}
		return $data;
	}

	public static function get_sign_off_date($client_id)
	{
		$sign_off_date = "";
		$session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];

		$value = CrmAccDetail::whereIn("user_id", $groupUserId)->where('client_id', '=', $client_id)->select('sign_off_date')->first();
		if(isset($value['sign_off_date']) && $value['sign_off_date'] != ''){
			$sign_off_date 		= $value['sign_off_date'];
		}
		return $sign_off_date;
	}

	public static function getCountDown($enddate)
	{
		$renwaldate = date('d-m-Y');
		$today 		= date('d-m-Y');
		if(isset($enddate) && $enddate != ""){
			$renwaldate = $enddate;
		}
		$diff = strtotime($renwaldate) - strtotime($today);
		$days = round($diff/86400);
		
		return $days;
	}

	public static function getTabTwoOneDetails($page_open)
    {
        $data           = array();
        $final_array    = array();
        $toal_annual    = "";
        $service_id     = 0;

        $client_details = Client::getAllOrgClientDetails();
        if(isset($client_details) && count($client_details) >0){
          foreach ($client_details as $key => $client_row) {
            if($client_row['is_deleted'] == 'N' && $client_row['is_archive'] == 'N'){
              $final_array[$key]  = $client_row;
              $acc_details = CrmAccDetail::getDetailsByClientId($client_row['client_id']);
              $final_array[$key]['accounts'] = $acc_details;
              if(isset($acc_details['billing_amount']) && $acc_details['billing_amount']!=""){
                    $toal_annual += str_replace(',','', $acc_details['billing_amount']);
                }
            }
          }
        }

        if(isset($final_array) && count($final_array) >0){
          foreach ($final_array as $key => $value) {
            /*==============AUTO SEND START================*/
            if($page_open == 2){
                $days  = AutosendTask::getDaysByServiceId( $service_id, 'C' );
                if(isset($value['accounts']['count_down']) && $value['accounts']['count_down']<=$days){
                    RenewalsManage::updateRenewalsManage($value['client_id']);
                }
            }
            /*==============AUTO SEND END================*/
            $final_array[$key]['manage_renewals'] = RenewalsManage::getManageRenewalsByClientId($value['client_id']);
          }
        }

        $data['annual_ammount'] = $toal_annual;
        $data['client_details'] = array_values($final_array);
        //echo "<pre>";print_r($data['client_details']);die;
        return $data;
    }

    public static function getOrgAnnualAmmount($type)
    {
        $toal_annual    = 0;
        $session = Session::get('admin_details');
        $groupUserId = $session['group_users'];

        $clients = Client::where("is_deleted", "N")->where("type", $type)->where("is_archive", "N")->where("is_relation_add", "N")->whereIn("user_id", $groupUserId)->select('client_id')->get();

        if(isset($clients) && count($clients) >0){
          foreach ($clients as $key => $client_row) {
              $acc_details = CrmAccDetail::getDetailsByClientId($client_row->client_id);
              if(isset($acc_details['billing_amount']) && $acc_details['billing_amount']!=""){
                    $toal_annual += str_replace(',','', $acc_details['billing_amount']);
                }
          }
        }

        return $toal_annual;
    }

    public static function getBillingAmmountByClientId($client_id)
    {
    	$total_annual 	= 0;
    	$session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];

    	$details = CrmAccDetail::whereIn("user_id", $groupUserId)->where('client_id', $client_id)
    			->select('billing_amount')->first();
    	if(isset($details['billing_amount']) && $details['billing_amount']!=""){
            $total_annual = str_replace(',','', $details['billing_amount']);
        }
        return $total_annual;
    }

    public static function annualFeeByProposalAndClientId($client_id, $proposal_id)
    {
        $recurring   	= CrmProposalTable::getProposalAmountByProposalId($proposal_id);
        $billing 	 	= CrmAccDetail::getBillingAmmountByClientId($client_id);
        $total 			= $recurring + $billing;
        return $total;
    }

  public static function getOrganisationTab($start,$limit,$page_open,$client_type,$sorting,$search_text)
  {
    $data = array();

    $sort = explode(' ', $sorting);
		$groupUserId    = Client::getSessionUserIds();

		$propQry = "( select count(*) as count from crm_proposals cp 
			
			WHERE cp.prospect_id=c.client_id
            AND (cp.contact_type='c_org' OR cp.contact_type='c_ind')
            AND (cp.save_type='A' OR cp.save_type='MA') 
            AND cp.proposalID IN (select proposal_id FROM crm_proposal_tables cpts 
                    WHERE cpts.package_type='R' group by cpts.proposal_id)
            AND cp.user_id IN ('".implode(',', $groupUserId)."') )";

        $countDown 		= "DATEDIFF( cp.end_date, NOW())";
        $cp_where = "from crm_proposals cp LEFT JOIN renewals_manages rm ON (cp.proposalID = rm.proposal_id and cp.prospect_id = rm.client_id)
			WHERE rm.manage_id is NULL AND ".$countDown." >=0 and cp.prospect_id=c.client_id
			AND cp.proposalID IN (select proposal_id FROM crm_proposal_tables cpts 
                    WHERE cpts.package_type='R' group by cpts.proposal_id) order by ".$countDown." ASC limit 1";

        $count_down1 	= "(select ".$countDown." as count_down ".$cp_where.")";
        $count_down2 	= "( IF(cad.enddate='0000-00-00', 0, DATEDIFF( cad.enddate, NOW())) )";
		$count_down 	= "IF(".$propQry.", ".$count_down1.", ".$count_down2.")";

		$startdate1 	= "(select DATE_FORMAT(cp.start_date,'%d-%m-%Y') as start_date ".$cp_where.")";
        $startdate2 	= "( IF(cad.startdate='0000-00-00', '', DATE_FORMAT(cad.startdate,'%d-%m-%Y')) )";
		$startdate 		= "IF(".$propQry.", ".$startdate1.", ".$startdate2.")";

		$enddate1 		= "(select DATE_FORMAT(cp.end_date,'%d-%m-%Y') as end_date ".$cp_where.")";
        $enddate2 		= "( IF(cad.enddate='0000-00-00', '', DATE_FORMAT(cad.enddate,'%d-%m-%Y')) )";
		$enddate 		= "IF(".$propQry.", ".$enddate1.", ".$enddate2.")";

		$annual_fee1 	= "(select IF(cp.recurring_amount='', 0, ROUND(REPLACE(cp.recurring_amount, ',', ''),2)) as annual_fee ".$cp_where.")";
        $annual_fee2 	= "( ROUND(REPLACE(cad.billing_amount, ',', ''), 2) )";
		$annual_fee 	= "IF(".$propQry.", ".$annual_fee1.", ".$annual_fee2.")";

		$monthly_fee1 	= "(select IF(cp.recurring_amount='', 0, ROUND(REPLACE(cp.recurring_amount, ',', '')/12,2)) as monthly_fee ".$cp_where.")";
        $monthly_fee2 	= "( IF(cad.billing_amount='', 0, ROUND(REPLACE(cad.billing_amount, ',', '')/12,2)) )";
		$monthly_fee 	= "IF(".$propQry.", ".$monthly_fee1.", ".$monthly_fee2.")";

        
        $where = "where c.is_deleted='N' and c.type='".$client_type."' and c.is_archive='N' and c.is_relation_add='N' and c.user_id IN ('".implode(',', $groupUserId)."')";
        
		$client_name  = "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=c.client_id group by client_id)";

		$engagement_date ="IF(cad.engagement_date='0000-00-00', '', DATE_FORMAT(cad.engagement_date,'%d-%m-%Y'))";


		$header_sort = '';
        if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'count_down'){
			$header_sort = "  ORDER BY ".$count_down." IS NULL, ".$count_down." ".$sort[1];
		}else if($sort[0] == 'annual_fee'){
			$header_sort =  " order by ".$annual_fee.' '.$sort[1];
		}else if($sort[0] == 'monthly_fee'){
			$header_sort = " order by ".$monthly_fee.' '.$sort[1];
		}else if($sort[0] == 'startdate'){
			$header_sort = " order by ".$startdate.' '.$sort[1];
		}else if($sort[0] == 'enddate'){
			$header_sort = " order by ".$enddate.' '.$sort[1];
		}else if($sort[0] == 'engagement_date'){
			$header_sort = " order by ".$engagement_date.' '.$sort[1];
		}

		if(isset($search_text) && $search_text != ''){
			$where .= " AND (".$client_name." LIKE '%".$search_text."%' OR ";
			$where .= $count_down." LIKE '%".$search_text."%' OR ";
			$where .= $annual_fee." LIKE '%".$search_text."%' OR ";
			$where .= $startdate." LIKE '%".$search_text."%' OR ";
			$where .= $enddate." LIKE '%".$search_text."%' OR ";
			$where .= $engagement_date." LIKE '%".$search_text."%' OR ";
			$where .= $monthly_fee." LIKE '%".$search_text."%' ) ";
		}

		$select = "select c.client_id,c.type, c.crm_leads_id, DATE_FORMAT(c.created,'%d-%m-%Y') as created, 
			".$client_name." as client_name,
			".$startdate." as startdate,
			".$enddate." as enddate,
			".$engagement_date." as engagement_date,
			".$annual_fee." as annual_fee,
			".$monthly_fee." as monthly_fee,
    		".$count_down." as count_down

    		";

        $query = " FROM clients c LEFT JOIN crm_acc_details cad ON cad.client_id=c.client_id ";
        
        $query .= $where.$header_sort;
        $sql_limit = $select.$query." limit ".$start.", ".$limit;
        //echo $sql_limit;die;
        $od = DB::select($sql_limit);

		//============== total count section ==============
        $total_select 	= "select count(c.client_id) as count";
        $total_qry 		= $total_select.$query;
        $totalVal 		= DB::select($total_qry);
        $total 			= json_decode(json_encode($totalVal), true);

		$data['details'] 		= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];
        return $data;
    }


    public static function manageRenewalContainer($start,$limit,$sorting,$search,$save_type)
    {
      $data = array();

      $sort 			= explode(' ', $sorting);
			$groupUserId    = Client::getSessionUserIds();

			$header_sort = '';
			$where = " WHERE rm.client_id=c.client_id AND rm.is_delete !='Y' AND rm.user_id IN ('".implode(',', $groupUserId)."') ";


			$client_name  	= "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=rm.client_id group by client_id)";

			$startdate 		= "IF(rm.startdate='0000-00-00', '', DATE_FORMAT(rm.startdate,'%d-%m-%Y'))";
			$enddate 			= "IF(rm.enddate='0000-00-00', '', DATE_FORMAT(rm.enddate,'%d-%m-%Y'))";
			$annual_fee 	= "IF(rm.annual_fee='', 0, FORMAT(REPLACE(rm.annual_fee, ',', ''),2))";
			$proposal_id 	= "IF(rm.crm_proposal_id ='0', '', (select proposalID from crm_proposals where crm_proposal_id = rm.crm_proposal_id) )";
			$status 			= "IF(rm.crm_proposal_id ='0', (select save_type from renewals_manages where manage_id=rm.manage_id), (select save_type from crm_proposals where crm_proposal_id = rm.crm_proposal_id) )";
			$contract 		= "IF(rm.crm_proposal_id ='0', '', (select proposal_title from crm_proposals where crm_proposal_id = rm.crm_proposal_id) )";

      if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'annual_fee'){
			$header_sort =  " order by ".$annual_fee.' '.$sort[1];
		}else if($sort[0] == 'startdate'){
			$header_sort = " order by ".$startdate.' '.$sort[1];
		}else if($sort[0] == 'enddate'){
			$header_sort = " order by ".$enddate.' '.$sort[1];
		}else if($sort[0] == 'proposal_id'){
			$header_sort = " order by ".$proposal_id.' '.$sort[1];
		}else if($sort[0] == 'contract'){
			$header_sort = " order by ".$contract.' '.$sort[1];
		}

		if(isset($search) && $search != ''){
			$where .= " AND (".$client_name." LIKE '%".$search."%' OR ";
			$where .= $annual_fee." LIKE '%".$search."%' OR ";
			$where .= $startdate." LIKE '%".$search."%' OR ";
			$where .= $proposal_id." LIKE '%".$search."%' OR ";
			$where .= $contract." LIKE '%".$search."%' OR ";
			$where .= $enddate." LIKE '%".$search."%' ) ";
		}

		if(isset($save_type) && !empty($save_type) && $save_type != 'SA'){
			if($save_type == 'A'){
	            $whereS = "( ".$status." = 'A' OR ". $status." = 'MA') ";
	        }else if($save_type == 'L'){
	            $whereS = "( ". $status." = 'L' OR ". $status." = 'ML') ";
	        }else{
	            $whereS = $status." = '".$save_type."'";
	        }
			$where .= " AND ".$whereS." AND rm.is_archive != 'Y' ";
		}else if($save_type == 'SA'){
			$where .= " AND rm.is_archive = 'Y' ";
		}else{
			$where .= " AND rm.is_archive != 'Y' ";
		}

		$select = "SELECT 
			rm.manage_id, rm.client_id, rm.is_archive, c.type,  
			".$client_name." as client_name,
			".$startdate." as startdate,
			".$enddate." as enddate,
			".$annual_fee." as annual_fee,
			".$proposal_id." as proposal_id,
			".$status." as status,
			".$contract." as contract
		";

		$query = " FROM renewals_manages as rm JOIN clients c";
        
        $query .= $where.$header_sort;
        $sql_limit = $select.$query." limit ".$start.", ".$limit; 
        //echo $sql_limit;die;
        $od = DB::select($sql_limit);


		//============== total count section ==============
        $total_select 	= "SELECT count(*) as count FROM renewals_manages as rm JOIN clients c ".$where;
        $total_qry 		= $total_select;
        //echo $total_qry;die;
        $totalVal 		= DB::select($total_qry);
        $total 			= json_decode(json_encode($totalVal), true);

		$data['details'] 		= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];
		return $data;
	}


	public static function recurringContracts($sendData)
    {
    	$start 		= $sendData['start'];
    	$limit 		= $sendData['limit'];
    	$sorting 	= $sendData['sorting'];
    	$search 	= $sendData['search'];
    	$table_type = $sendData['table_type'];
    	$client_id  = $sendData['client_id'];

    	//$renewals   = RenewalsManage::getRenewalsByProposalAndClientId($proposal_id, $client_id);

    	$data = $od = array();

        $sort 			= explode(' ', $sorting);
		$groupUserId    = Client::getSessionUserIds();

		$header_sort = '';

		$where = " WHERE cp.user_id IN ('".implode(',', $groupUserId)."') ";
		if($table_type == 'recurring'){
			$where .= " AND cp.proposalID IN (select proposal_id FROM crm_proposal_tables cpts 
        			WHERE cpts.package_type='R' group by cpts.proposal_id) ";
        	$annual_fee = "( select IF(cp.recurring_amount='',0,ROUND(REPLACE(cp.recurring_amount,',',''),2)) ) ";
		}
		if($table_type == 'nonrecurring'){
			$where .= " AND cp.proposalID IN (select proposal_id FROM crm_proposal_tables cpts 
        			WHERE cpts.package_type='F' group by cpts.proposal_id) ";
        	$annual_fee = "( select IF(cp.nonrecurr_amount='',0,ROUND(REPLACE(cp.nonrecurr_amount,',',''),2)) ) ";
		}
        $where .= "AND (cp.save_type='A' OR cp.save_type='MA') 
        	AND (cp.contact_type='c_org' OR cp.contact_type='c_ind')
        	AND cp.prospect_id='".$client_id."' ";

        $signed_date 	= "IF(cp.signed_date='0000-00-00', '', DATE_FORMAT(cp.signed_date,'%d-%m-%Y'))";
		$startdate 		= "IF(cp.start_date='0000-00-00', '', DATE_FORMAT(cp.start_date,'%d-%m-%Y'))";
		$enddate 		= "IF(cp.end_date='0000-00-00', '', DATE_FORMAT(cp.end_date,'%d-%m-%Y'))";
		$count_down 	= "DATEDIFF( cp.end_date, NOW())";

		$sort_date  = "IF(cp.end_date='0000-00-00', '', UNIX_TIMESTAMP(cp.end_date))";

		$renewals = " (select status from renewals_manages as rm where rm.client_id = '".$client_id."' AND rm.proposal_id = cp.proposalID) ";

		$status = " IF(".$count_down." > '90', 'LIVE',
					  IF(".$renewals." = 'Y', 'FRENEWED',
					    IF(".$count_down." >= '0', 'RENEW', 'EXPIRED')
					  )
					) ";

		/*$status = " (
		    CASE 
		    	WHEN ".$renewals." = 'Y' THEN 'C'
		    	CASE
		        WHEN ".$count_down." < '0' THEN 'D'
		        WHEN ".$count_down." > '90' THEN 'B'
		        ELSE 'A'
		    END) ";*/

        if($sort[0] == 'status'){
			$header_sort = " order by ".$status.' '.$sort[1];
		}else if($sort[0] == 'annual_fee'){
			$header_sort =  " order by ".$annual_fee.' '.$sort[1];
		}else if($sort[0] == 'startdate'){
			$header_sort = " order by ".$startdate.' '.$sort[1];
		}else if($sort[0] == 'enddate'){
			$header_sort = " order by ".$enddate.' '.$sort[1];
		}else if($sort[0] == 'proposal_title'){
			$header_sort = " order by cp.proposal_title ".$sort[1];
		}else if($sort[0] == 'proposal_id'){
			$header_sort = " order by cp.proposalID ".$sort[1];
		}

		if(isset($search) && $search != ''){
			$where .= " AND (cp.proposal_title LIKE '%".$search."%' OR ";
			$where .= $annual_fee." LIKE '%".$search."%' OR ";
			$where .= $signed_date." LIKE '%".$search."%' OR ";
			$where .= $startdate." LIKE '%".$search."%' OR ";
			$where .= " cp.proposalID LIKE '%".$search."%' OR ";
			$where .= $status." LIKE '%".$search."%' OR ";
			$where .= " cp.save_type LIKE '%".$search."%' OR ";
			$where .= $enddate." LIKE '%".$search."%' ) ";
		}

		$select = "SELECT cp.crm_proposal_id, cp.is_rejected, cp.contact_type, cp.prospect_id,
			cp.proposalID as proposal_id, cp.proposal_title, cp.save_type,
			".$signed_date." as signed_date,
			".$startdate." as startdate,
			".$enddate." as enddate,
			".$annual_fee." as annual_fee,
			".$count_down." as count_down,
			".$sort_date." as sort_date,
			".$status." as status
		";

		$query = " FROM crm_proposals as cp ";
        
        $query .= $where.$header_sort;
        $sql_limit = $select.$query." limit ".$start.", ".$limit; 
        //echo $sql_limit;die;
        $od = DB::select($sql_limit);


		//============== total count section ==============
        $total_select 	= "SELECT count(*) as count FROM crm_proposals as cp ".$where;	

        $total_qry 		= $total_select;
        //echo $total_qry;die;
        $totalVal 		= DB::select($total_qry);
        $total 			= json_decode(json_encode($totalVal), true);

		$data['details'] 		= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];
		return $data;

    }


    /*public static function wipTable($sendData)
    {
    	$start 		= $sendData['start'];
    	$limit 		= $sendData['limit'];
    	$sorting 	= $sendData['sorting'];
    	$search 	= $sendData['search'];

    	$data = $od = array();

        $sort 			= explode(' ', $sorting);
		$groupUserId    = Client::getSessionUserIds();

		$header_sort = '';

		$where = " WHERE cps.user_id IN ('".implode(',', $groupUserId)."') ";
		$where .= " AND (cp.save_type='A' OR cp.save_type='MA') AND (cp.contact_type='c_org' OR cp.contact_type='c_ind') AND cpt.package_type = 'F' ";//


        $client_name  = "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=cp.prospect_id group by client_id)";

        if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'service_name'){
			$header_sort =  " order by s.service_name ".$sort[1];
		}else if($sort[0] == 'amount'){
			$header_sort = " order by cps.fees ".$sort[1];
		}else if($sort[0] == 'proposal_id'){
			$header_sort = " order by cp.proposalID ".$sort[1];
		}
		if(isset($search) && $search != ''){
			$where .= " AND (".$client_name." LIKE '%".$search."%'";
			$where .= " OR s.service_name LIKE '%".$search."%'";
			$where .= " OR cps.fees LIKE '%".$search."%' ";
			$where .= " OR cp.proposalID LIKE '%".$search."%'";

 			$where .= " ) ";
		}

		$select = "SELECT 
			cps.p_service_id as id,
			cps.fees amount, 
			s.service_name, 
			cp.proposalID as proposal_id,

			".$client_name." as client_name
		";

		$query = " FROM crm_proposal_services as cps ";
		$query .= " LEFT JOIN services as s ON cps.service_id = s.service_id ";
		$query .= " JOIN crm_proposal_tables as cpt ON cps.p_table_id = cpt.id ";
		$query .= " JOIN crm_proposals as cp ON cpt.proposal_id = cp.proposalID ";
        
        $query .= $where.$header_sort;
        $sql_limit = $select.$query." limit ".$start.", ".$limit; 
        //echo $sql_limit;die;
        $od = DB::select($sql_limit);


		//============== total count section ==============
        $total_select 	= "SELECT count(*) as count ".$query;	

        $total_qry 		= $total_select;
        //echo $total_qry;die;
        $totalVal 		= DB::select($total_qry);
        $total 			= json_decode(json_encode($totalVal), true);

		$data['details'] 		= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];
		return $data;

	}*/
	public static function wipTable($sendData)
  {
  	$start 		= $sendData['start'];
  	$limit 		= $sendData['limit'];
  	$sorting 	= $sendData['sorting'];
  	$search 	= $sendData['search'];

  	$data = $od = array();

    $sort 				= explode(' ', $sorting);
		$groupUserId  = Client::getSessionUserIds();

		$header_sort = '';

		$where 	= " WHERE tl.user_id IN ('".implode(',', $groupUserId)."') ";
		$where .= " AND tl.is_billable = 'Y' ";


    $client_name  = "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=tl.rel_client_id group by client_id)"; 

    $amount = " IF(tl.amount='', 0, ROUND(REPLACE(tl.amount, ',', ''),2)) ";

    $staff_name  = "(select CONCAT(fname, ' ', lname) as staff_name from users where user_id=tl.staff_id)";

    $comp_date1 	= "IF(tl.taskdate='0000-00-00', '', DATE_FORMAT(tl.taskdate,'%d-%m-%Y'))";
    $comp_time1 	= "IF(tl.task_time='00:00:00', '', DATE_FORMAT(tl.task_time,'%H:%i'))";
    $comp_date  	= " CONCAT( ".$comp_date1.", ' ', ".$comp_time1.") ";
    $created 		= "DATE_FORMAT(tl.created,'%Y-%m-%d')";
    $created_date 	= "DATE_FORMAT(tl.created,'%d-%m-%Y')";

    if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'service_name'){
			$header_sort =  " order by tl.taskname ".$sort[1];
		}else if($sort[0] == 'amount'){
			$header_sort = " order by ".$amount.' '.$sort[1];
		}else if($sort[0] == 'created'){
			$header_sort = " order by ".$created.' '.$sort[1];
		}else if($sort[0] == 'proposal_id'){
			$header_sort = " order by tl.proposal_id ".$sort[1];
		}else if($sort[0] == 'staff_name'){
			$header_sort = " order by ".$staff_name.' '.$sort[1];
		}else if($sort[0] == 'status'){
			$header_sort = " order by tl.status ".$sort[1];
		}
		if(isset($search) && $search != ''){
			$where .= " AND (".$client_name." LIKE '%".$search."%' ";
			$where .= " OR tl.taskname LIKE '%".$search."%' ";
			$where .= " OR ".$amount." LIKE '%".$search."%'";
			$where .= " OR ".$created_date." LIKE '%".$search."%'";
			$where .= " OR tl.proposal_id LIKE '%".$search."%' ";
			$where .= " OR ".$staff_name." LIKE '%".$search."%'";
			$where .= " OR ".$comp_date." LIKE '%".$search."%'";
			$where .= " OR tl.status LIKE '%".$search."%' ";
 			$where .= " ) ";
		}

		$select = "SELECT 
			tl.todolistnewtasks_id as id, tl.proposal_id, tl.taskname as service_name, tl.notes,
			tl.taskdate, tl.status,
			".$amount." as amount,
			".$created_date." as created,
			".$comp_date." as comp_date,
			".$staff_name." as staff_name,
			".$client_name." as client_name
		";

		$query = " FROM todolistnewtasks as tl ";
        
    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit; 
    //echo $sql_limit;die;
    $od = DB::select( DB::raw($sql_limit) );


		//============== total count section ==============
    $total_select 	= "SELECT count(*) as count ".$query;	

    $total_qry 		= $total_select;
    //echo $total_qry;die;
    $totalVal 		= DB::select($total_qry);
    $total 				= json_decode(json_encode($totalVal), true);

		$data['details'] 			= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];
		return $data;

	}

	public static function clientFieldQuery($field_name)
	{
		$fields = " ( SELECT ".$field_name." FROM crm_acc_details cad WHERE cad.client_id=c.client_id group by client_id ) ";
		return $fields;
	}

}
