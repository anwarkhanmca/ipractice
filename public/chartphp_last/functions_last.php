<?php
//include('../../../../app/library/CrmGraph.php');

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
    $data = array();
    $data_sql = "select IF(ct.type='ind', 'Indi', 'Org') type, count(c.client_id) as total from client_types ct, clients c where c.type=ct.type and c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' group by c.type order by c.type asc"; 
    $data_qry = mysql_query($data_sql);
    $i = 0;
    while($data_row = mysql_fetch_array($data_qry)){
        $data[0][$i][0] = $data_row['type'];
        $data[0][$i][1] = $data_row['total'];
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
    
    //echo "<pre>";print_r($data);die;
    return $new_array;
}
?>