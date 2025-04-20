<?php
function getGroupUsers(){
    $data = array();
    $session = CrmGraph::get_session();
    foreach($session['group_users'] as $key=>$value){
        $data[$key] = $value['user_id'];
    }
    //echo "<pre>";print_r($data);die;
    return implode(',', $data);
}

function getRoundValue($value, $myltiply)
{
    /*if($value >= 1000){
        $value = round($value, -3);
    }else if($value < 1000 && $value >=100){
        $value = round($value, -2);
    }else{
        $value = round($value, -1);
    }*/
    $div_val = $value/$myltiply;
    return number_format($div_val, 2, '.', '');
}

function getnoofclients()
{
    $groupUserId = CrmGraph::getGroupUserId();//print_r($groupUserId);die;
    $data = array(array(array("Org",0),array("Indi",0)));
    $data_sql = "select IF(ct.type='ind', 'Indi', 'Org') type, count(c.client_id) as total from client_types ct, clients c where c.type=ct.type and c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.") group by c.type order by c.type asc"; 
    //echo $data_sql;die;
    //$data_sql = "select IF(ct.type='ind', 'Indi', 'Org') type, count(c.client_id) as total from client_types ct  left outer join clients c on  c.type=ct.type  where c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.") group by c.type order by c.type asc";
    //echo $data_sql;die;
    $data_qry = mysql_query($data_sql);
    $i = 0;
    while($data_row = mysql_fetch_array($data_qry)){
        $data[0][$i][0] = (string)$data_row['type'];
        $data[0][$i][1] = (int)$data_row['total'];
        $i++;
    }
    return $data;
}

function getWonLostGraph()
{
    $groupUserId = CrmGraph::getGroupUserId();
    $data = array(array(array("Won",0),array("Lost",0)));
    
    $data_sql = "select  IF(clt.tab_name='WON', 'Won', 'Lost') type, COALESCE(sum(cast(replace(cl.quoted_value, ',', '') as decimal(18,2))),0) total from crm_leads_tabs clt left outer join crm_leads_statuses cls on clt.tab_id=cls.leads_tab_id left outer join crm_leads cl on cl.leads_id=cls.leads_id where clt.`is_graph`='CRMG' and cl.user_id IN (".$groupUserId.") group by cls.leads_tab_id order by clt.tab_name desc";
    $data_qry = mysql_query($data_sql);

    //if(isset($data_row) && count($data_row) >1 && $data_row['total'] != '0.00'){
    $i = 0;
    while($data_row = mysql_fetch_array($data_qry)){
        $data[0][$i][0] = (string)$data_row['type'];
        $data[0][$i][1] = (int)$data_row['total'];
        $i++;
    }
    //}
   //echo "<pre>"; print_r($data);
    return $data;
}

function getAverageMeterData($client_type, $fee_type, $status)
{
    $groupUserId    = CrmGraph::getGroupUserId();
    
    $data           = array();
    $avg_org_value  = array();
    $avg_org_mtr    = array();
    $myltiply       = 1000;
    
    $sql = mysql_query("select client_id from clients where type = '".$client_type."' and is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N' and user_id IN (".$groupUserId.")");
    
    
    $num = mysql_num_rows($sql);
    $total_annual   = 0;
    $height_amount  = 0;
    while($row = mysql_fetch_array($sql))
    {
        $acc_qry = mysql_query("SELECT billing_amount from crm_acc_details where client_id = '".$row['client_id']."'");
        $acc_details = mysql_fetch_assoc($acc_qry);
        if(isset($acc_details['billing_amount']) && $acc_details['billing_amount']!=""){
            /*if($fee_type == 'yearly'){
                $amount = str_replace(',','', $acc_details['billing_amount']);
            }else{
                $monthly_amount = str_replace(',','', $acc_details['billing_amount']);
                $amount = $monthly_amount/12;
            }*/
            $amount = str_replace(',','', $acc_details['billing_amount']);
            $total_annual += (int)$amount;
            if($amount >$height_amount){
                $height_amount = $amount;
            }
        }
    }
    
    $total_annual   = getRoundValue($total_annual, $myltiply);
    $height_amount  = getRoundValue($height_amount, $myltiply);
    
    if($status == 'A'){
        $avg_org_value[0][0]    = (int)round($total_annual/$num);
        $avg_org_mtr[0]         = (int)round($height_amount*0.25);
        $avg_org_mtr[1]         = (int)round($height_amount*0.5);
        $avg_org_mtr[2]         = (int)round($height_amount*0.75);
        $avg_org_mtr[3]         = (int)round($height_amount);
    }else{
        $avg_org_value[0][0]    = (int)round($total_annual);
        $avg_org_mtr[0]         = (int)round($total_annual*0.5);
        $avg_org_mtr[1]         = (int)round($total_annual);
        $avg_org_mtr[2]         = (int)round($total_annual*1.5);
        $avg_org_mtr[3]         = (int)round($total_annual*2);
    }

    $data['avg_value'] = $avg_org_value;
    $data['avg_range'] = $avg_org_mtr;
    //echo "<pre>";print_r($data);die;
    return $data;
}

function getTopTenClient($short_type, $client_type)
{
    $groupUserId = CrmGraph::getGroupUserId();
    $data = array();
    $table_array = array();
    $graph_array = array();
    $final_array = array();
    $graph_array = array(array(array(0,1), array(0,2), array(0,3), array(0,4), array(0,5), array(0,6), array(0,7), array(0,8), array(0,9), array(0,10)));
    
    $sql = mysql_query("select cad.client_id, cast(replace(cad.billing_amount, ',', '') as decimal(18,2)) amount from crm_acc_details cad, clients c where cad.billing_amount != '0.00' and cad.billing_amount != '' and c.client_id = cad.client_id and c.type = '".$client_type."' and c.user_id IN (".$groupUserId.") order by cast(replace(cad.billing_amount, ',', '') as decimal(18,2)) ".$short_type." limit 10");
    $i = 0;
    while($row = mysql_fetch_array($sql)){
        $data[$i]['client_id']  = $row['client_id'];
        $data[$i]['amount']     = $row['amount'];
        
        $amount[$i]  = $row['amount'];
        $i++;
    }

    if($short_type == 'ASC'){
        array_multisort($amount, SORT_DESC, $data);
    }else{
        array_multisort($amount, SORT_ASC, $data);
    }
    
    $j = 0;
    foreach ($data as $key=>$value){
        $graph_array[0][$j][0] = round($value['amount']);
        $graph_array[0][$j][1] = $j+1;
        
        $table_array[$j]['client_id']   = $value['client_id'];
        $table_array[$j]['client_name'] = getClientNameByClientId($value['client_id']);
        $table_array[$j]['client_no']   = $j+1;

        $j++;
    }
    
    $final_array['graph_array'] = $graph_array;
    $final_array['table_array'] = $table_array;
    
    //echo "<pre>";print_r($graph_array);
    return $final_array;
}

function getClientNameByClientId($client_id)
{
    $type = getClientTypeByClientId($client_id);
    if($type == 'org'){
        $name = 'business_name';
    }
    if($type == 'ind'){
        $name = 'client_name';
    }
    
    $sql = "select sfc.field_value from steps_fields_clients sfc where sfc.field_name = '".$name."' and sfc.client_id = '".$client_id."'";
    $qry = mysql_query($sql);
    $row = mysql_fetch_assoc($qry);
    return ucwords(strtolower($row['field_value']));
}

function getClientTypeByClientId($client_id)
{
    $acc_qry = mysql_query("SELECT type from clients where client_id = '".$client_id."'");
    $acc_details = mysql_fetch_assoc($acc_qry);
    return $acc_details['type'];
}

function getAnnualFeeByClientId($client_id)
{
    $acc_qry = mysql_query("SELECT billing_amount from crm_acc_details where client_id = '".$client_id."'");
    $acc_details = mysql_fetch_assoc($acc_qry);
    return $acc_details['billing_amount'];
}

function getArrtitionRate($client_type)
{
    $rate = array();
    $groupUserId = CrmGraph::getGroupUserId();
    
    $sql_client = "SELECT COUNT( c.client_id ) AS count from clients c where c.type='".$client_type."' and  c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.")";
    $client = mysql_fetch_assoc(mysql_query($sql_client));
    $total_client = $client['count'];

    
    $del1_sql = "SELECT COUNT( c.client_id ) AS count from clients c where c.type='".$client_type."' and c.is_deleted = 'Y' and c.deleted_reason = '1' and c.user_id IN (".$groupUserId.")";
     $del1_row = mysql_fetch_assoc(mysql_query($del1_sql));
     $del1_count = $del1_row['count'];
     
     $del2_sql = "SELECT COUNT( c.client_id ) AS count from clients c where c.type='".$client_type."' and c.is_deleted = 'Y' and c.deleted_reason = '2' and c.user_id IN (".$groupUserId.")";
     $del2_row = mysql_fetch_assoc(mysql_query($del2_sql));
     $del2_count = $del2_row['count'];
     
     $rate[0][0] = round(($del1_count*100)/($total_client+$del1_count+$del2_count));
     //echo $del1_count;die;
     return $rate;
}

function getLatestClients($client_type, $table_type)
{
    $groupUserId = CrmGraph::getGroupUserId();
    $data = array();
    if($table_type == 'won'){
        $sql = "select client_id, deleted_date, created, deleted_reason from clients where type = '".$client_type."' and crm_won_graph_table = 'Y' and is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N' and user_id IN (".$groupUserId.") order by client_id desc limit 10";
    }else{
        $sql = "select client_id, deleted_date, created, deleted_reason from clients where type = '".$client_type."' and crm_lost_graph_table = 'Y' and (is_archive = 'Y' || is_deleted = 'Y') and is_relation_add = 'N' and user_id IN (".$groupUserId.") order by client_id desc limit 10";
    }
    
    $qry = mysql_query($sql);
    $i = 0;
    while($row = mysql_fetch_array($qry)){
        if($table_type == 'won'){
            $date = date('d-m-Y', strtotime($row['created']));
        }else{
            $date = date('d-m-Y', strtotime($row['deleted_date']));
        }
        $data[$i]['client_id']      = $row['client_id'];
        $data[$i]['client_name']    = getClientNameByClientId($row['client_id']);
        $data[$i]['amount']         = getAnnualFeeByClientId($row['client_id']);
        $data[$i]['created']        = $date;
        $data[$i]['reason']         = getDeletedReason($row['deleted_reason']);
        
        $i++;
    }
    return $data;
}

function getDeletedReason($reason_id)
{
    $value = "";
    if($reason_id == 1){
        $value = "Found a new Accounant";
    }else if($reason_id == 2){
        $value = "Involuntory Attrition";
    }else if($reason_id == 3){
        $value = "Other";
    }
    return $value;
}


function clientContractRenewalsDue($client_type)
{
    $groupUserId    = CrmGraph::getGroupUserId();
    $data           = array();
    
    
    $sql = mysql_query("select client_id from clients where (type = 'ind' || type = 'org') and is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N'  and crm_renewal_graph_table = 'Y' and user_id IN (".$groupUserId.")");
    $num = mysql_num_rows($sql);
    $i = 0;
    while($row = mysql_fetch_array($sql))
    {
        $ren_sql = mysql_query("select status from renewals_manages where client_id = '".$row['client_id']."'");
        $renewals = mysql_fetch_assoc($ren_sql);
        if(isset($renewals['status']) && $renewals['status'] == "Y"){
            $startdate = getStartDateByClientId($row['client_id']);
            $count_down = getCountDown($startdate);
            if(isset($count_down) && $count_down <= 90 && $count_down != '0'){
                $data[$i]['client_id']      = $row['client_id'];
                $data[$i]['client_name']    = getClientNameByClientId($row['client_id']);
                $data[$i]['start_date']     = $startdate;
                $data[$i]['count_down']     = $count_down;
                $i++;
            }
            
        }
    }
    
    /* ============ Array Sorting ================ */
    $count_down = array();
    if(isset($data) && count($data) >0){
        foreach($data as $key=>$value){
            $count_down[$key]  = (int)$value['count_down'];
        }
        array_multisort($count_down, SORT_ASC, $data);
    }
    //echo "<pre>";print_r($data);die;
    return $data;
}

function getStartDateByClientId($client_id)
{//echo "SELECT startdate from crm_acc_details where client_id = '".$client_id."'";
    $acc_qry = mysql_query("SELECT startdate from crm_acc_details where client_id = '".$client_id."'");
    $acc_details = mysql_fetch_assoc($acc_qry);
    return $acc_details['startdate'];
}

function getCountDown($startdate)
{
    $renwaldate = date('d-m-Y');
    $today 		= date('d-m-Y');
    if(isset($startdate) && $startdate != ""){
        $renwaldate = date("d-m-Y", strtotime('+365 days', strtotime($startdate)));
    }
    $diff = strtotime($renwaldate) - strtotime($today);
    $days = round($diff/86400);

    return $days;
}

function getOnboardingClient()
{
    $user_id = CrmGraph::get_session();
    //$client_ids = Client::where("is_deleted", "=", "N")->where("is_archive", "=", "N")->where("is_onboard", "=", "Y")->where("is_relation_add", "=", "N")->whereIn("user_id", $groupUserId)->select("client_id", "created","show_archive")->orderBy("client_id", "DESC")->get();
    $groupUserId = CrmGraph::getGroupUserId();
    $data = array();
    $new_array = array();
    $sql = mysql_query("select client_id, created from clients where is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N' and is_onboard = 'Y' and crm_onboarding_graph_table = 'Y' and user_id IN (".$groupUserId.")");
    $num = mysql_num_rows($sql);
    $i = 0;
    while($row = mysql_fetch_array($sql))
    {
        $data[$i]['client_id']      = $row['client_id'];
        $data[$i]['client_name']    = getClientNameByClientId($row['client_id']);
        $data[$i]['created']        = $row['created'];
        
        $sql_sub = "SELECT ((SELECT COUNT(*) FROM client_task_dates WHERE client_id = '".$row['client_id']."' AND user_id = '".$user_id."' AND status = 'D') /(SELECT COUNT(*) FROM client_task_dates WHERE client_id = '".$row['client_id']."' AND user_id = '".$user_id."')) * 100 AS avg FROM `client_task_dates` WHERE client_id = '".$row['client_id']."' GROUP BY client_id";
        $result = mysql_fetch_assoc(mysql_query($sql_sub));
        if(isset($result['avg'])) {
            $data[$i]['avg'] = number_format($result['avg'],2);  
            if(number_format($result['avg'])=="0.00"){
                $data[$i]['avg'] = '0';
            }
        } else {
            $data[$i]['avg'] = '0';
        } 
        
        $avg[$i]  = $data[$i]['avg'];
        $i++;
    }
    
    array_multisort($avg, SORT_ASC, $data);
    //$new_array = array_slice($data, 0, 10);
    
    return $data;
}

function getReferralSource()
{
    $data = array(array(array()));
    $groupUserId = CrmGraph::getGroupUserId();
    
    $org_count = CrmGraph::getOrgClientsCount('org');
    
    $data_sql = "SELECT count(cad.lead_source_id) as total, cad.lead_source_id from crm_acc_details cad where cad.lead_source_id != '0' AND cad.lead_source_id != '11' and cad.user_id IN (".$groupUserId.") GROUP BY cad.lead_source_id";
    $data_qry = mysql_query($data_sql);
    $i = 0;
    $total = 0;
    while($data_row = mysql_fetch_array($data_qry)){
        $data[0][$i][0] = CrmGraph::getLeadSourceName($data_row['lead_source_id']);
        $data[0][$i][1] = (int)$data_row['total'];
        $total += $data_row['total'];
        $i++;
    }
    $data[0][$i][0] = 'Others';
    $data[0][$i][1] = (int)($org_count - $total);
    //echo "<pre>";print_r($data);die;
    return $data;
}

/*function getIndustryGraph()
{
  $data           = array(array(array()));
  $groupUserId    = CrmGraph::getGroupUserId();
  $org_count      = CrmGraph::getOrgClientsCount('org');
  
  $data_sql = "SELECT count(cad.industry_id) as total, cad.industry_id from crm_acc_details cad where cad.industry_id != '0' and cad.user_id IN (".$groupUserId.") GROUP BY cad.industry_id";
  $data_qry = mysql_query($data_sql);
  $i = 0;
  $total = 0;
  while($data_row = mysql_fetch_array($data_qry)){
      $data[0][$i][0] = CrmGraph::getIndustryNameById($data_row['industry_id']);
      $data[0][$i][1] = (int)$data_row['total'];
      $total += $data_row['total'];
      $i++;
  }
  $data[0][$i][0] = 'Others';
  $data[0][$i][1] = (int)($org_count - $total);
  //echo "<pre>";print_r($data);die;
  return $data;
}*/

function getIndustryGraph()
{
  $data           = array(array(array()));
  $groupUserId    = CrmGraph::getGroupUserId();
  $org_count      = CrmGraph::getOrgClientsCount('org');

  $total = $j = 0;
  
  $data_sql = "SELECT industry from business_descriptions bd GROUP BY industry";
  $data_qry = mysql_query($data_sql);
  while($row = mysql_fetch_array($data_qry)){
    $data1 = array();
    $sql1 = "SELECT code from business_descriptions bd where industry='".$row['industry']."'";
    $qry1 = mysql_query($sql1);
    $i = 0;
    while($row1 = mysql_fetch_array($qry1)){
      $data1[$i] = $row1['code'];
      $i++;
    }

    if(!empty($data1)){
      $sql2 = " select count(c.client_id) as num from clients as c, steps_fields_clients as sfc WHERE c.user_id IN ('".$groupUserId."') AND c.is_deleted='N' AND c.type='org' AND c.is_archive='N' AND c.is_relation_add='N' and sfc.client_id = c.client_id and sfc.field_name='business_desc' and sfc.field_value IN(".implode(',', $data1).") ";
      //echo $sql2;
      $qry2 = mysql_query($sql2);
      $row2 = mysql_fetch_assoc($qry2);
      if($row2['num'] >0){
        $data[0][$j][0] =(strlen($row['industry'])>70)?substr($row['industry'],0,70):$row['industry'];
        $data[0][$j][1] = (int)$row2['num'];
        $total += $row2['num'];
        $j++;
      }
    }
    
  }

  $data[0][$j][0] = 'Others';
  $data[0][$j][1] = (int)($org_count - $total);
  //echo "<pre>";print_r($data);die;
  return $data;
}

function getDateArray()
{
  $data = array();
  $currMonth = date('m');
  $currYear = date('Y');
  $currDate = $currYear."-".$currMonth."-01";
  
  $data[0] = $currDate;
  for($i=1; $i<12; $i++){
      $data[$i] = date('Y-m-d', strtotime('-'.$i.' month', strtotime($currDate)));
  }
  return $data;
}

function growthChartByClientType($client_type)
{
    //$client_type = 'ind';
    $data = array();
    $groupUserId = CrmGraph::getGroupUserId();
    $date = getDateArray();
    //echo "<pre>";print_r($date);die;

    /* ================== total client before 12th of the month ================== */
    $where = " c.type='".$client_type."' and c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.") ";

    $lastDate   = explode('-', $date[9]);
    $month      = $lastDate[count($lastDate)-2];
    $year       = $lastDate[count($lastDate)-3];
    $innerQry = "SELECT client_id from clients WHERE MONTH( created ) = '".$month."' AND YEAR( created ) = '".$year."' ORDER BY client_id ASC limit 1";
    $BfrCount = "SELECT COUNT( c.client_id ) AS count from clients c where ".$where." and c.client_id < (".$innerQry.") ";
    $clientCnt = mysql_fetch_assoc(mysql_query($BfrCount));
    $tot_start = $clientCnt['count'];
    //echo $tot_start;
    /* ================== total client before 12th of the month ================== */

    
    $sql_client = "SELECT COUNT( c.client_id ) AS count from clients c where c.type='".$client_type."' and c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.")";
    $client = mysql_fetch_assoc(mysql_query($sql_client));
    $total_client = $client['count'];
    //echo $sql_client;die;

    $data_sql = "SELECT COUNT( c.client_id ) AS total, DATE_FORMAT( m.merge_date, '%b' ) AS month, DATE_FORMAT( m.merge_date, '%c' ) AS month_numeric
        FROM (
            SELECT '".$date[0]."' AS merge_date
            UNION SELECT '".$date[1]."' AS merge_date
            UNION SELECT '".$date[2]."' AS merge_date
            UNION SELECT '".$date[3]."' AS merge_date
            UNION SELECT '".$date[4]."' AS merge_date
            UNION SELECT '".$date[5]."' AS merge_date
            UNION SELECT '".$date[6]."' AS merge_date
            UNION SELECT '".$date[7]."' AS merge_date
            UNION SELECT '".$date[8]."' AS merge_date
            UNION SELECT '".$date[9]."' AS merge_date
            
            ) AS m
        LEFT JOIN clients c ON MONTH( m.merge_date ) = MONTH( c.created )
        AND YEAR( m.merge_date ) = YEAR( c.created ) and c.type='".$client_type."' and  c.is_archive = 'N' and c.is_relation_add = 'N' and c.user_id IN (".$groupUserId.") GROUP BY m.merge_date order by m.merge_date desc";
    //echo $data_sql;die;
        
    $data_qry = mysql_query($data_sql);
    $i = 0;
    $total = 0;
    while($data_row = mysql_fetch_array($data_qry)){
        $data[$i]['month']          = $data_row['month'];
        $data[$i]['total']          = (int)$data_row['total'];
        $data[$i]['month_numeric']  = $data_row['month_numeric'];
        //$data[$i]['total'] = (int)$data_row['total']-(int)$row_mon['number'];
        $total += $data[$i]['total'];
        $i++;
    }
    $details = array_reverse($data);
    //echo "<pre>";print_r($details);die;
    //$tot_start = 0;
    if(isset($details) && count($details) >0){
        foreach ($details as $key=>$value){
            //$sql_mon = "select count(*) as number from clients where DATE_FORMAT( deleted_date, '%c' )='".$value['month_numeric']."' and is_deleted = 'Y' and user_id IN (".$groupUserId.") and type='".$client_type."'";
            $sql_mon = "select count(*) as number from clients where MONTH(deleted_date)='".$value['month_numeric']."' and is_deleted = 'Y' and user_id IN (".$groupUserId.") and type='".$client_type."'";
            //echo $sql_mon;
            $row_mon = mysql_fetch_assoc(mysql_query($sql_mon));
        
            $data1[$key]['month'] = $value['month'];
            //echo $value['total'];
            if($i > 0){
                $total = (int)$value['total']-(int)$row_mon['number'];
                $tot_start += $total;
            }
            //echo $tot_start.'=';
            $data1[$key]['total'] = (int)($tot_start);
        }
    }
    //echo "<pre>";print_r(array_reverse($data));die;
    return array_reverse($data1);
}

/*function growthChartByClientType($client_type)
{
    $groupUserId = CrmGraph::getGroupUserId();
    $date = getDateArray();
    
    $sql_client = "SELECT COUNT( c.client_id ) AS count from clients c where c.type='".$client_type."' and  c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.")";
    $client = mysql_fetch_assoc(mysql_query($sql_client));
    $total_client = $client['count'];

    $data_sql = "SELECT COUNT( c.client_id ) AS total, DATE_FORMAT( m.merge_date, '%b' ) AS month
        FROM (
            SELECT '".$date[0]."' AS merge_date
            UNION SELECT '".$date[1]."' AS merge_date
            UNION SELECT '".$date[2]."' AS merge_date
            UNION SELECT '".$date[3]."' AS merge_date
            UNION SELECT '".$date[4]."' AS merge_date
            UNION SELECT '".$date[5]."' AS merge_date
            UNION SELECT '".$date[6]."' AS merge_date
            UNION SELECT '".$date[7]."' AS merge_date
            UNION SELECT '".$date[8]."' AS merge_date
            UNION SELECT '".$date[9]."' AS merge_date
            UNION SELECT '".$date[10]."' AS merge_date
            UNION SELECT '".$date[11]."' AS merge_date
            ) AS m
        LEFT JOIN clients c ON MONTH( m.merge_date ) = MONTH( c.created )
        AND YEAR( m.merge_date ) = YEAR( c.created ) and c.type='".$client_type."' and  c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.") GROUP BY m.merge_date order by m.merge_date desc";
    //echo $data_sql;die;
        
    $data_qry = mysql_query($data_sql);
    $i = 0;
    $total = 0;
    while($data_row = mysql_fetch_array($data_qry)){
        $data[$i]['month'] = $data_row['month'];
        $data[$i]['total'] = (int)$data_row['total'];
        $total += $data[$i]['total'];
        $i++;
    }
    //echo $total;die;
    $remain = 0;
    if($total_client >= $total){
        $remain = $total_client-$total;
    }

    if(isset($data) && count($data) >0){
        $tot = $remain;
        foreach (array_reverse($data) as $key=>$value){
            $tot += $value['total'];

            $data1[$key]['month'] = $value['month'];
            $data1[$key]['total'] = (int)($tot);
        }
    }

    return array_reverse($data1);
}*/


function growthChart()
{
  $data2  = array(
    array(array("Jan",0),array("Feb",0),array("Mar",0),array("Apr",0),array("May",0),array("Jun",0),array("Jul",0),array("Aug",0),array("Sep",0),array("Oct",0)), 
    array(array("Jan",0),array("Feb",0),array("Mar",0),array("Apr",0),array("May",0),array("Jun",0),array("Jul",0),array("Aug",0),array("Sep",0),array("Oct",0)));
  
  $data_org = growthChartByClientType('org');
  if(isset($data_org) && count($data_org) >0){
    foreach ($data_org as $key=>$value){
      $data2[0][$key][0] = $value['month'];
      $data2[0][$key][1] = (int)$value['total'];
    }
  }

  $data_ind = growthChartByClientType('ind');
  if(isset($data_ind) && count($data_ind) >0){
    foreach ($data_ind as $key=>$value){
      $data2[1][$key][0] = $value['month'];
      $data2[1][$key][1] = (int)$value['total'];
    }
  }
  //echo "<pre>";print_r($data2);die;
  return $data2;
}

function getOldestOpportunity()
{
    $final_array = array();
    $graph_array  = array(array(array(0,10), array(0,9), array(0,8), array(0,7), array(0,6), array(0,5), array(0,4), array(0,3), array(0,2), array(0,1))); 
    $details = CrmGraph::getOldestOpportunity();//echo "<pre>";print_r($details);die;
    foreach($details as $key=>$value){
        $deal_age[$key]  = $value['deal_age'];
    }

    array_multisort($deal_age, SORT_DESC, $details);
    $data_array = array_slice($details, 0, 10);
    
    if(isset($data_array) && count($data_array) >0){
        $j = count($data_array);
        $k = 0;
        foreach ($data_array as $key=>$value){
            $graph_array[0][$k][0] = (int)$value['deal_age'];
            $graph_array[0][$k][1] = $j;

            $table_array[$k]['leads_id']   = $value['leads_id'];
            $table_array[$k]['client_name'] = $value['client_name'];
            $table_array[$k]['client_no']   = $j;

            $j--;$k++;
        }
    }
    
    $final_array['graph_array'] = $graph_array;
    $final_array['table_array'] = $table_array;
    
    //echo "<pre>";print_r($final_array);die;
    return $final_array;
}

function getAmountOpportunityArray($details)
{
    $final_array = array();
    $graph_array  = array(array(array(0,10), array(0,9), array(0,8), array(0,7), array(0,6), array(0,5), array(0,4), array(0,3), array(0,2), array(0,1)));
    
    foreach($details as $key=>$value){
        $amount[$key]  = (int)$value['quoted_value'];
    }
    array_multisort($amount, SORT_DESC, $details);
    $data_array = array_slice($details, 0, 10);
    
    if(isset($data_array) && count($data_array) >0){
        $j = count($data_array);
        $k = 0;
        foreach ($data_array as $key=>$value){
            $graph_array[0][$k][0] = $value['quoted_value'];
            $graph_array[0][$k][1] = $j;

            $table_array[$k]['leads_id']    = $value['leads_id'];
            $table_array[$k]['client_name'] = $value['client_name'];
            $table_array[$k]['client_no']   = $j;

            $j--;$k++;
        }
    }
    
    $final_array['graph_array'] = $graph_array;
    $final_array['table_array'] = $table_array;
    
    //echo "<pre>";print_r($final_array);die;
    return $final_array;
}

function getTopAmountOpportunity()
{
    $details    = array();
    $data       = array();
    
    $details    = CrmGraph::getOldestOpportunity();
    $data       = getAmountOpportunityArray($details);
    return $data;
    
}

function getCloseOpportunity()
{
    $details    = array();
    $data       = array();
    
    $details    = CrmGraph::getCloseOpportunity();
    $data       = getAmountOpportunityArray($details);
    return $data;
    
}

function getWonLostDealCount()
{
    $groupUserId = CrmGraph::getGroupUserId();
    $data = array();
    $won = $lost = 0;
    $details  = CrmGraph::getAllOpportunity();
    if(isset($details) && count($details) >0){
        foreach($details as $key=>$value){
            //$tab_id = CrmGraph::getTabIdByLeadId($value['leads_id']);
            $query_sub  = "select leads_tab_id from crm_leads_statuses where leads_id = '".$value['leads_id']."' and user_id in (".$groupUserId.")";
            //echo $query_sub."<br>";
            $sub        = CrmGraph::getSingleArray($query_sub);                
            if(isset($sub['leads_tab_id']) && ($sub['leads_tab_id'] == 8)){
                $won++;
            }
            if(isset($sub['leads_tab_id']) && ($sub['leads_tab_id'] == 9)){
                $lost++;
            }
        }
    }
    $data[0][0][0] = "Won";
    $data[0][0][1] = $won;
    
    $data[0][1][0] = "Lost";
    $data[0][1][1] = $lost;
    
    return $data;
}

function getSalesPipeLine()
{
    $final_array = array();
    $table_array = array();
    $graph_array = array();
    
    $details = CrmGraph::getOpportunityTab('O');
    $all_total = 0;
    foreach($details as $key=>$value){
        $total = 0;
        if(isset($value['table_value']['total']) && $value['table_value']['total'] != ''){
            $total = round(str_replace(",", "", $value['table_value']['total']));
        }
        $details[$key]['total'] = $total;
        $all_total += $total;
        $amount[$key]  = $total;
    }
    array_multisort($amount, SORT_DESC, $details);
    //echo "<pre>";print_r($details);die;
    if(isset($details) && count($details) >0){
        $i = 0;
        foreach($details as $key=>$value){
            $graph_array[0][$i][0] = $value['tab_name'];
            $graph_array[0][$i][1] = (int)$value['total'];

            $table_array[$i]['tab_id']      = $value['tab_id'];
            $table_array[$i]['tab_name']    = $value['tab_name'];
            $table_array[$i]['total']       = (int)$value['total'];
            $table_array[$i]['percentage']  = number_format((($value['total']*100)/$all_total), 2, '.', '');
            $i++;
        }
    }
    
    $final_array['graph_array'] = $graph_array;
    $final_array['table_array'] = $table_array;
    //echo "<pre>";print_r($final_array);die;
    return $final_array;
}


function getSalesLeadGraph()
{
    $final_array = array();
    $table_array = array();
    $graph_array = array();
    
    $details = CrmGraph::getOpportunityTab('L');
    foreach($details as $key=>$value){
        $count[$key]  = $value['count'];
    }
    array_multisort($count, SORT_DESC, $details);
    
    if(isset($details) && count($details) >0){
        $i = 0;
        foreach($details as $key=>$value){
            $graph_array[0][$i][0] = $value['tab_name'];
            $graph_array[0][$i][1] = (int)$value['count'];

            $table_array[$i]['tab_id']      = $value['tab_id'];
            $table_array[$i]['tab_name']    = $value['tab_name'];
            $table_array[$i]['count']       = $value['count'];
            $i++;
        }
    }
    
    $final_array['graph_array'] = $graph_array;
    $final_array['table_array'] = $table_array;
    //echo "<pre>";print_r($final_array);die;
    return $final_array;
}

function getDealsWonLostByOwners($tab_id)
{
    $data = array(array(array()));
    $details  = CrmGraph::getGroupByOwnerId();
    $i = 0;
    if(isset($details) && count($details) >0){
        foreach ($details as $key => $value) {
            if($value['deal_owner'] != '0'){//echo $name;
                $name = CrmGraph::getUserNameById($value['deal_owner']);
                $data[0][$i][0] = ucwords(strtolower($name));
                $data[0][$i][1] = CrmGraph::getTotalAmmountByOwnerId($value['deal_owner'], $tab_id);
                $i++;
            }
        }
        $data[0][$i][0] = "Unassigned";
        $data[0][$i][1] = CrmGraph::getTotalAmmountByOwnerId('0', $tab_id);
    }
    //echo "<pre>";print_r($data);die;
    return $data;
}

function getConversionRate()
{
    $data = array();
    $details  = CrmGraph::getAllOpportunityDetails();
    if(isset($details) && count($details) >0){
        $won = $lost = 0;
        foreach($details as $key=>$value){
            if(isset($value['lead_status']) && $value['lead_status'] == 8){
                $won++;
            }
            if(isset($value['lead_status']) && $value['lead_status'] == 9){
                $lost++;
            }
        }
    }
    //echo $won."===".$lost;
    $convertion_rate = round((100*$won)/($won+$lost));
    $data[0][0] = $convertion_rate;
    return $data;
}

function getAverageClosedDeals()
{
    $pointing = array();
    $details  = CrmGraph::getAllOpportunityDetails();//print_r($details);die;
    if(isset($details) && count($details) >0){
        $allcount = $amount = $max_value = 0;
        foreach($details as $key=>$value){
            if(isset($value['lead_status']) && $value['lead_status'] == 8 || $value['lead_status'] == 9){
                $allcount++;
                $deal_age = (int)$value['deal_age'];
                $amount += $deal_age;
                if($deal_age >$max_value){
                    $max_value = $deal_age;
                }
            }
        }
    }
    //echo $amount."===".$allcount."====".$max_value;
    $pointing[0][0] = round($amount/$allcount);
    
    $interval[0] = round($max_value/4);
    $interval[1] = round($max_value/2);
    $interval[2] = round($max_value*3/4);
    $interval[3] = round($max_value);
    
    $final['pointing'] = $pointing;
    $final['interval'] = $interval;
    return $final;
}


?>