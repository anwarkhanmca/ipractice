<?php
include('../file-and-sign/include/config.inc.php');
$action = $_POST['action'];
if($action == 'crm_graph_table_delete'){
    $client_id = $_POST['client_id'];
    $table_name = $_POST['table_name'];
    $field_name = "crm_".$table_name."_graph_table";
    mysql_query("update clients set ".$field_name." = 'N' where client_id = '".$client_id."'");
    echo 1;
}
?>