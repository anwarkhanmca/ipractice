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

function getRoundValue($value)
{
    if($value >= 1000){
        $value = round($value, -3);
    }else if($value < 1000 && $value >=100){
        $value = round($value, -2);
    }else{
        $value = round($value, -1);
    }
    return $value;
}

function getnoofclients()
{
    $groupUserId = getGroupUsers();
    $data = array(array(array("Org",0),array("Indi",0)));
    $data_sql = "select IF(ct.type='ind', 'Indi', 'Org') type, count(c.client_id) as total from client_types ct, clients c where c.type=ct.type and c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' and c.user_id IN (".$groupUserId.") group by c.type order by c.type asc"; 
    
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
    $data1 = array(array(array("Won",0),array("Lost",0)));
    $data_sql = "select  IF(clt.tab_name='WON', 'Won', 'Lost') type, COALESCE(sum(cast(replace(cl.quoted_value, ',', '') as decimal(18,2))),0) total from crm_leads_tabs clt left outer join crm_leads_statuses cls on clt.tab_id=cls.leads_tab_id left outer join crm_leads cl on cl.leads_id=cls.leads_id where clt.`is_graph`='CRMG' group by cls.leads_tab_id order by clt.tab_name desc";
    $data_qry = mysql_query($data_sql);

//if(isset($data_row) && count($data_row) >1 && $data_row['total'] != '0.00'){
    $i = 0;
    while($data_row = mysql_fetch_array($data_qry)){
        $data1[0][$i][0] = (string)$data_row['type'];
        $data1[0][$i][1] = (int)$data_row['total'];
        $i++;
    }
//}
   //echo "<pre>"; print_r($data);
    return $data1;
}

function getAverageMeterData($client_type, $fee_type)
{
    $data = array();
    $sql = mysql_query("select client_id from clients where type = '".$client_type."' and is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N'");
    $num = mysql_num_rows($sql);
    $total_annual   = 0;
    $height_amount  = 0;
    while($row = mysql_fetch_array($sql))
    {
        $acc_qry = mysql_query("SELECT billing_amount from crm_acc_details where client_id = '".$row['client_id']."'");
        $acc_details = mysql_fetch_assoc($acc_qry);
        if(isset($acc_details['billing_amount']) && $acc_details['billing_amount']!=""){
            if($fee_type == 'yearly'){
                $amount = str_replace(',','', $acc_details['billing_amount']);
            }else{
                $monthly_amount = str_replace(',','', $acc_details['billing_amount']);
                $amount = $monthly_amount/12;
            }
            
            $total_annual += $amount;
            if($amount >$height_amount){
                $height_amount = $amount;
            }
        }

    }
    
    /*if($fee_type == 'yearly'){
        $total_annual   = round($total_annual);
    }else{
        $total_annual   = round($total_annual/12);
    }*/
    $height_amount  = round($height_amount);

    $avg_org_value[0][0]    = round($total_annual/$num);
    $avg_org_mtr[0]         = round($height_amount/4);
    $avg_org_mtr[1]         = round($height_amount/2);
    $avg_org_mtr[2]         = round($height_amount*0.75);
    $avg_org_mtr[3]         = round($height_amount);
    
    $data['avg_value'] = $avg_org_value;
    $data['avg_range'] = $avg_org_mtr;
    return $data;
}

function getTopTenClient($short_type, $client_type)
{
    $data = array();
    $table_array = array();
    $graph_array = array();
    $final_array = array();
    
    $sql = mysql_query("select cad.client_id, cast(replace(cad.billing_amount, ',', '') as decimal(18,2)) amount from crm_acc_details cad, clients c where cad.billing_amount != '0.00' and cad.billing_amount != '' and c.client_id = cad.client_id and c.type = '".$client_type."' order by cast(replace(cad.billing_amount, ',', '') as decimal(18,2)) ".$short_type." limit 10");
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
    
    //echo "<pre>";print_r($final_array);
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

function getLatestClients($client_type, $table_type)
{
    $data = array();
    if($table_type == 'won'){
        $sql = "select client_id, created from clients where type = '".$client_type."' and crm_won_graph_table = 'Y' and is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N' order by client_id desc limit 10";
    }else{
        $sql = "select client_id, created from clients where type = '".$client_type."' and crm_lost_graph_table = 'Y' and (is_archive = 'Y' || is_deleted = 'Y') and is_relation_add = 'N' order by client_id desc limit 10";
    }
    
    $qry = mysql_query($sql);
    $i = 0;
    while($row = mysql_fetch_array($qry)){
        $data[$i]['client_id']      = $row['client_id'];
        $data[$i]['client_name']    = getClientNameByClientId($row['client_id']);
        $data[$i]['amount']         = getAnnualFeeByClientId($row['client_id']);
        $data[$i]['created']        = date('d-m-Y', strtotime($row['created']));
        
        $i++;
    }
    return $data;
}


function clientContractRenewalsDue($client_type)
{
    $data = array();
    $sql = mysql_query("select client_id from clients where (type = 'ind' || type = 'org') and is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N'");
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
    //$client_ids = Client::where("is_deleted", "=", "N")->where("is_archive", "=", "N")->where("is_onboard", "=", "Y")->where("is_relation_add", "=", "N")->whereIn("user_id", $groupUserId)->select("client_id", "created","show_archive")->orderBy("client_id", "DESC")->get();
    $data = array();
    $new_array = array();
    $sql = mysql_query("select client_id, created from clients where is_archive = 'N' and is_relation_add = 'N' and is_deleted = 'N' and is_onboard = 'Y'");
    $num = mysql_num_rows($sql);
    $i = 0;
    while($row = mysql_fetch_array($sql))
    {
        $data[$i]['client_id']      = $row['client_id'];
        $data[$i]['client_name']    = getClientNameByClientId($row['client_id']);
        $data[$i]['created']        = $row['created'];
        
        $sql_sub = "SELECT ((SELECT COUNT(*) FROM client_task_dates WHERE client_id = '".$row['client_id']."' AND user_id = 46 AND status = 'D') /(SELECT COUNT(*) FROM client_task_dates WHERE client_id = '".$row['client_id']."' AND user_id = 46)) * 100 AS avg FROM `client_task_dates` WHERE client_id = '".$row['client_id']."' GROUP BY client_id";
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
    $new_array = array_slice($data, 0, 10);
    
    return $new_array;
}

function getReferralSource()
{
    $data = array();
    $org_count = CrmGraph::getOrgClientsCount('org');
    
    $data_sql = "SELECT count(cad.lead_source_id) as total, cad.lead_source_id from crm_acc_details cad where cad.lead_source_id != '0' AND cad.lead_source_id != '11' GROUP BY cad.lead_source_id";
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

function getIndustryGraph()
{
    $data = array();
    $org_count = CrmGraph::getOrgClientsCount('org');
    $data_sql = "SELECT count(cad.industry_id) as total, cad.industry_id from crm_acc_details cad where cad.industry_id != '0' GROUP BY cad.industry_id";
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
    $groupUserId = getGroupUsers();
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
    //echo $data_sql;
        
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
}


function growthChart()
{
    $data2  = array(array(array("Jan",0),array("Feb",0),array("Mar",0),array("Apr",0),array("May",0),array("Jun",0),array("Jul",0),array("Aug",0),array("Sep",0),array("Oct",0)), array(array("Jan",0),array("Feb",0),array("Mar",0),array("Apr",0),array("May",0),array("Jun",0),array("Jul",0),array("Aug",0),array("Sep",0),array("Oct",0)));
    
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
    $data  = array(array(array(200,10), array(180,9), array(160,8), array(140,7), array(120,6), array(100,5), array(80,4), array(60,3), array(40,2))); 
    $details = CrmGraph::getOldestOpportunity();
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

function getTopAmountOpportunity()
{
    $final_array = array();
    $details = CrmGraph::getOldestOpportunity();
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
?>