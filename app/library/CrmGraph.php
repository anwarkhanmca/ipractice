<?php
session_start();
$_SESSION['user_id'] = $_REQUEST['user_id'];

class CrmGraph {
    public static function getArray($query)
    {
        $data = array();
        $qry = mysql_query($query);
        $i = 0;
        while($row = mysql_fetch_array($qry)){
            $data[] = $row;
            $i++;
        }
        return $data;
    }
    
    public static function getSingleArray($query)
    {
        $data = array();
        $qry = mysql_query($query);
        while($row = mysql_fetch_assoc($qry)){
            $data = $row;
        }
        return $data;
    }
    
    public static function get_session() {
        return $_SESSION['user_id'];
    }
    
    public static function getGroupUserId() {
        $data = array();
        $query = "select group_id from users where user_id = '".$_SESSION['user_id']."'";
        $array = CrmGraph::getSingleArray($query);
        if(isset($array['group_id']) && $array['group_id'] != '0'){
            $group_sql = "select user_id from users where group_id = '".$array['group_id']."'";
            $groups = CrmGraph::getArray($group_sql);
            if(isset($groups) && count($groups) >0){
                foreach($groups as $key=>$value){
                    $data[$key] = $value['user_id'];
                }
            }
        }else{
            $data[$key] = $_SESSION['user_id'];
        }
        //print_r($data);die;
        //$session = Session::get('admin_details');
        return implode(',', $data);
    }

    public static function getOrgClientsCount($type)
    {
        $groupUserId 	= CrmGraph::getGroupUserId();
        $sql = "select count(*) as count from clients where is_deleted='N' and type = 'org' and is_archive = 'N' and is_relation_add = 'N' and user_id in (".$groupUserId.")";//echo $sql;die;
        $qry = mysql_query($sql);
        $row = mysql_fetch_assoc($qry);
        
        return $row['count'];
    }
    
    public static function getIndustryNameById($industry_id)
    {
    	//$name = IndustryList::getIndustryNameById($industry_id);
    	//return $name;
        $query = "select industry_name from industry_lists where industry_id = '".$industry_id."'";
        $details = CrmGraph::getSingleArray($query);
        
        return $details['industry_name'];
    }
    
    public static function getLeadSourceName($source_id)
    {
    	//$name = LeadSource::getLeadSourceName($source_id);
    	//return $name;
        $query = "select source_name from lead_sources where source_id = '".$source_id."'";
        $details = CrmGraph::getSingleArray($query);
        
        return $details['source_name'];
    }
    
    public static function getAllOpportunity()
    {
        $groupUserId 	= CrmGraph::getGroupUserId();
        
    	$query = "select leads_id, quoted_value, prospect_name, date, client_type, prospect_title, prospect_fname, prospect_lname from crm_leads where leads_type = 'O' and is_deleted = 'N' and is_archive = 'N' and user_id in (".$groupUserId.")";
        $details = CrmGraph::getArray($query);
        return $details;
    }
    
    public static function getAllOpportunityDetails()
    {
        $data = array();
        $groupUserId 	= CrmGraph::getGroupUserId();
        
    	$query = "select leads_id, quoted_value, prospect_name, date, client_type, prospect_title, prospect_fname, prospect_lname, deal_owner from crm_leads where leads_type = 'O' and is_deleted = 'N' and user_id in (".$groupUserId.")";
        $sql = mysql_query($query);
        $i = 0;
        while($value = mysql_fetch_array($sql)){
            $data[$i]['leads_id']       = $value['leads_id'];
            $data[$i]['quoted_value']   = str_replace(",", "", $value['quoted_value']);
            $data[$i]['prospect_name']  = $value['prospect_name'];
            $data[$i]['date']           = $value['date'];
            $data[$i]['deal_owner']     = $value['deal_owner'];
            $data[$i]['client_type']    = $value['client_type'];
            $data[$i]['prospect_title'] = $value['prospect_title'];
            $data[$i]['prospect_fname'] = $value['prospect_fname'];
            $data[$i]['prospect_lname'] = $value['prospect_lname'];
            $lead_status = CrmGraph::getTabIdByLeadId($value['leads_id']);
            $data[$i]['lead_status']    = $lead_status;
            
            $date1 = date('Y-m-d', strtotime($value['date']));
            if(isset($lead_status) && ($lead_status != 8 && $lead_status != 9 && $lead_status != 10)){
                $data[$i]['deal_age'] = CrmGraph::getAgeCount($date1, date('Y-m-d'));
            }else{
                $status = CrmGraph::getDetailsByLeadsId($value['leads_id']);
                $date2  = date('Y-m-d', strtotime($status['created']));
                $date   = CrmGraph::getAgeCount($date1, $date2);
                $data[$i]['deal_age'] = $date;
            }
            
            $i++;
        }
        return $data;
    }
    
    public function getDetailsByLeadsId($leads_id)
    {
        $data = array();
        $groupUserId 	= CrmGraph::getGroupUserId();
        $query_sub      = "select * from crm_leads_statuses where leads_id = '".$leads_id."' and user_id in (".$groupUserId.")";
        $sub = mysql_fetch_assoc(mysql_query($query_sub));
        $data['created'] = $sub['created'];
        
        return $data;
    }
    
    public static function getOldestOpportunity()
    {
        $data = array();
        $groupUserId 	= CrmGraph::getGroupUserId();
        
    	$details = CrmGraph::getAllOpportunity();
        
        if (isset($details) && count($details) > 0) {
            foreach ($details as $key => $value) {
                $query_sub  = "select leads_tab_id from crm_leads_statuses where leads_id = '".$value['leads_id']."' and user_id in (".$groupUserId.")";
                $sub        = CrmGraph::getSingleArray($query_sub);                
                if(isset($sub['leads_tab_id']) && ($sub['leads_tab_id'] != 8 && $sub['leads_tab_id'] != 9 && $sub['leads_tab_id'] != 10)){
                    $data[$key]['leads_id']     = $value['leads_id'];
                    $data[$key]['quoted_value'] = str_replace(",","",$value['quoted_value']);
                    if(isset($value['client_type']) && $value['client_type'] == "org"){
                        $data[$key]['client_name'] = $value['prospect_name'];
                    }else{
                        $data[$key]['client_name'] = $value['prospect_title']." ".$value['prospect_fname']." ".$value['prospect_lname'];
                    }
                    //echo $this->last_query();
                    if (isset($sub['leads_tab_id']) && ($sub['leads_tab_id'] == 8 || $sub['leads_tab_id'] == 9 || $sub['leads_tab_id'] == 10)) {
                        $date = explode(' ', $status['likely']);
                        $data[$key]['deal_age'] = CrmGraph::getDealAge($value['date'], $date[0]);
                    } else {
                        $data[$key]['deal_age'] = CrmGraph::getAgeCount($value['date'], date('Y-m-d'));
                    }                    
                }
            }
        }
        
    	return array_values($data);
    }
    
    public static function getCloseOpportunity()
    {
        $data = array();
        $groupUserId 	= CrmGraph::getGroupUserId();
        $details        = CrmGraph::getAllOpportunity();
        
        if (isset($details) && count($details) > 0) {
            foreach ($details as $key => $value) {
                $query_sub  = "select leads_tab_id from crm_leads_statuses where leads_id = '".$value['leads_id']."' and user_id in (".$groupUserId.")";
                $sub        = CrmGraph::getSingleArray($query_sub);                
                if(isset($sub['leads_tab_id']) && ($sub['leads_tab_id'] == 8)){
                    $data[$key]['leads_id']     = $value['leads_id'];
                    $data[$key]['quoted_value'] = str_replace(",","",$value['quoted_value']);
                    if(isset($value['client_type']) && $value['client_type'] == "org"){
                        $data[$key]['client_name'] = $value['prospect_name'];
                    }else{
                        $data[$key]['client_name'] = $value['prospect_title']." ".$value['prospect_fname']." ".$value['prospect_lname'];
                    }                 
                }
            }
        }
        
    	return array_values($data);
    }
    
    public function getTabIdByLeadId($leads_id)
    {
        $tab_id = 0;
        $groupUserId 	= CrmGraph::getGroupUserId();
        $query_sub  = "select leads_tab_id from crm_leads_statuses where leads_id = '".$leads_id."' and user_id in (".$groupUserId.")";
        $sub  = mysql_fetch_assoc(mysql_query($query_sub));
        if(isset($sub['leads_tab_id']) && $sub['leads_tab_id'] != ""){
            $tab_id = $sub['leads_tab_id'];
        }
        return $tab_id;
    }
    
    public function getAgeCount($from, $date2)
    {
        $days = 0;
        if ($from != "") {
            $date1 = $from;

            $diff = strtotime($date2) - strtotime($date1);
            $days = round($diff / 86400);
        }

        return $days;
    }

    public function getDealAge($date1, $date2)
    {
        $days = 0;
        $diff = strtotime($date2) - strtotime($date1);
        $days = round($diff / 86400);

        return $days;
    }
    
    public function getOpportunityTab($is_show)
    {
        $data = array();
        $groupUserId    = CrmGraph::getGroupUserId();
        //$query  = "select * from crm_leads_tabs where status = 'S' and is_show = '".$is_show."'";
        $query  = "select * from leads_tab_manages where status = 'S' and is_show = '".$is_show."' and user_id in (".$groupUserId.")";
        $sql  = mysql_query($query);
        $i = 0;
        while ($value = mysql_fetch_array($sql)){
            $data[$i]['tab_manage_id']  = $value['tab_manage_id'];
            $data[$i]['tab_id']         = $value['tab_id'];
            $data[$i]['user_id']        = $value['user_id'];
            $data[$i]['tab_name']       = $value['tab_name'];
            $data[$i]['color_code']     = $value['color_code'];
            $data[$i]['status']         = $value['status'];
            $data[$i]['is_show']        = $value['is_show'];
            $data[$i]['count']          = CrmGraph::leadsStatusCount( $value['tab_id'] );
            $data[$i]['table_value'] 	= CrmGraph::getTotalQuotedValue( $value['tab_id'] );
            $i++;
        }
        return $data;
    }
    
    public function leadsStatusCount( $tab_id )
	{
		$groupUserId 	= CrmGraph::getGroupUserId();
        $query  = "select count(*) count from crm_leads_statuses where leads_tab_id = '".$tab_id."' and user_id in (".$groupUserId.")";
        $row  = mysql_fetch_assoc(mysql_query($query));
        
        return $row['count'];
	}
    
    public function leadsStatusByTabId( $tab_id )
	{
		$data = array();
		$groupUserId 	= CrmGraph::getGroupUserId();
        
		$query  = "select * from crm_leads_statuses where leads_tab_id = '".$tab_id."' and user_id in (".$groupUserId.")";
        $sql  = mysql_query($query);
        $i = 0;
        while ($details = mysql_fetch_array($sql)){
            $data[$i]['leads_status_id'] 	= $details['leads_status_id'];
            $data[$i]['leads_tab_id'] 		= $details['leads_tab_id'];
            $data[$i]['user_id'] 			= $details['user_id'];
            $data[$i]['leads_id'] 			= $details['leads_id'];
            $data[$i]['likely'] 			= $details['created'];
            $i++;
        }
		return $data;
	}
    
    public function getTotalQuotedValue( $tab_id )
    {
    	$data = array();
    	$groupUserId 	= CrmGraph::getGroupUserId();
		$status_details = CrmGraph::leadsStatusByTabId($tab_id);

		if(isset($status_details) && count($status_details) >0){
			$total    = 0;
	        $average  = 0;
	        $likely   = 0;
			foreach ($status_details as $key => $value) {
				//$crn_lead = CrmLead::where("leads_id", "=", $value['leads_id'])->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->first();
                $query  = "select * from crm_leads where leads_id = '".$value['leads_id']."' and is_deleted = 'N' and is_archive = 'N'";
                $sql  = mysql_query($query);
                $crn_lead = mysql_fetch_array($sql);
                
				if(isset($crn_lead['quoted_value']) && $crn_lead['quoted_value'] != ""){
					$quoted_value = str_replace(",", "", $crn_lead['quoted_value']);
					$total += $quoted_value;
					$likely += ($crn_lead['deal_certainty']*$quoted_value)/100;
				}
				$average = $total/count($status_details);
			}
			
            $data['total']     	= number_format($total, 2);
	        $data['average']   	= number_format($average, 2);
	        $data['likely']    	= number_format($likely, 2);
	    }

		return $data;
    }
    
    public function getGroupByOwnerId()
    {
        $data           = array();
        $groupUserId 	= CrmGraph::getGroupUserId();
        $sql = "select leads_id, deal_owner from crm_leads where user_id in (".$groupUserId.") and is_deleted = 'N' group by deal_owner";
        $qry = mysql_query($sql);
        $i = 0;
        while($value = mysql_fetch_array($qry)){
            $data[$i]['leads_id']   = $value['leads_id'];
            $data[$i]['deal_owner'] = $value['deal_owner'];
            $i++;
        }
        return $data;
    }
    
    public function getUserNameById($user_id)
    {
        $name = "";
        $sql = "select fname, lname from users where user_id = '".$user_id."'";
        $qry = mysql_query($sql);
        $row = mysql_fetch_assoc($qry);
        if(isset($row['fname']) && $row['fname'] != ""){
            $name .= $row['fname']." ";
        }
        if(isset($row['lname']) && $row['lname'] != ""){
            $name .= $row['lname'];
        }
        return $name;
    }
    
    public function getTotalAmmountByOwnerId($user_id, $tab_id)
    {//echo $tab_id;die;
        $groupUserId 	= CrmGraph::getGroupUserId();
        $sql = "select leads_id, quoted_value from crm_leads where deal_owner = '".$user_id."' and user_id in (".$groupUserId.")";
        $qry = mysql_query($sql);
        $total = 0;
        while($row = mysql_fetch_array($qry)){
            $query_sub  = "select leads_tab_id from crm_leads_statuses where leads_id = '".$row['leads_id']."' and user_id in (".$groupUserId.")";
            $sub  = mysql_fetch_assoc(mysql_query($query_sub));
            $tabId = $sub['leads_tab_id'];
            //$tabId = CrmGraph::getTabIdByLeadId($row['leads_id']);
            if($tabId == $tab_id){
                $quoted_value = str_replace(",", "", $row['quoted_value']);//echo $quoted_value."=====<br>";
                $total += round($quoted_value);
            }
        }//die;
        return $total;
    }

    
}
