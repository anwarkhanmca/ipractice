<?php
//echo round(10400, -3);
//$p_i = array(array(166)); ;print_r($p_i);

/* ========= Database Connection Start ========= */
include('../../../file-and-sign/include/config.inc.php');
include('../../../../app/library/CrmGraph.php');
$crm_obj = new CrmGraph;
$session = CrmGraph::get_session();
include('../../functions.php');

/* ========= Database Connection End ========= */
?>

<?php include('../../sales_code.php')?>

<!DOCTYPE html>
<html>
	<head>
		<script src="../../lib/js/jquery.min.js"></script>
		<script src="../../lib/js/chartphp.js"></script>
		<link rel="stylesheet" href="../../lib/js/chartphp.css">	
        <style>
            /* white color data labels */
            .outer_div{width: 100%; float: left; margin-bottom: 30px;}
            .jqplot-point-label{color:white;}
            .jqplot-data-label{color:white;} 
            .graph_box{float: left; width:24%; margin-right: 5px;}
            .graph_big{float: left; width:73%; margin-right: 5px;}
            .table_box{float: left; width:49%; margin-right: 5px;}
            .table{border: 1px solid #ccc; width: 100%}
            .table th{text-align: left; background-color: #ADD8E6; color: #ffffff; padding: 5px;font-style: italic;}
            .table thead td{background-color: #3c8dbc; color: #ffffff; font-weight: bold; text-align: center; ;font-style: italic;}
            .table tbody td{text-align: left; border-bottom: 1px solid #ccc; font-size: 12px; padding-left: 6px;}
            .table > tbody > tr:last-child > td { border-bottom: 0;}
            /*#c3 .jqplot-yaxis{display: none!important;}*/
        </style>
        <script type="text/javascript">
        $(document).ready(function(){
           $('.delete_client').on('click', function(){
               var client_id = $(this).data('client_id');
               var table_name = $(this).data('table_name');
               //alert(table_name+"="+client_id)
               if(confirm('Do you want to delete the client from table'))
               {
                $.ajax({
                   type : 'post',
                   url : '../../../ajax/graph_table_action.php',
                   data : {'client_id' : client_id, 'table_name': table_name, 'action':'delete'},
                   success : function(resp){
                      window.location.reload();
                   }
                });
               }
           });
        });      
        </script>
	</head>
	
	<body>
		<div class="outer_div">
            <div class="graph_box"><?php echo $out_wonlost; ?></div>
			<div class="graph_box"><?php echo $out_3; ?></div>
			<div class="graph_box"><?php echo $out_pipeline; ?></div>
			<div class="graph_box">
                <table class="table" style="margin-top: 70px;">
                    <thead>
                    <tr>
                        <td colspan="2" style="font-style: normal;">KEY</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td style="text-align: center;">123</td>
                        <td>Anwar Khan</td>
                    </tr>
                   <?php 
                   if(isset($asc_client['table_array']) && count($asc_client['table_array']) >0){
                       //$data = array_reverse($desc_client['table_array']);
                       foreach (array_reverse($asc_client['table_array']) as $key=>$value){
                   ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $value['client_no'];?></td>
                        <td><?php echo (strlen($value['client_name'])>40)?substr($value['client_name'], 0, 37).'...':$value['client_name'];?></td>
                    </tr>
                   <?php }}?> 
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="outer_div">
            <div class="graph_box"><?php echo $out_conversion_rate; ?></div>
			<div class="graph_box"><?php echo $out_deal_age; ?></div>
			<div class="graph_box"><?php echo $out_hotwarm; ?></div>
            <div class="graph_box">
                <table class="table" style="margin-top: 70px;">
                    <thead>
                    <tr>
                        <td colspan="2" style="font-style: normal;">KEY</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td style="text-align: center;">123</td>
                        <td>Anwar Khan</td>
                    </tr>
                   <?php 
                   if(isset($asc_client['table_array']) && count($asc_client['table_array']) >0){
                       //$data = array_reverse($desc_client['table_array']);
                       foreach (array_reverse($asc_client['table_array']) as $key=>$value){
                   ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $value['client_no'];?></td>
                        <td><?php echo (strlen($value['client_name'])>40)?substr($value['client_name'], 0, 37).'...':$value['client_name'];?></td>
                    </tr>
                   <?php }}?> 
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="outer_div">
			<div class="graph_big"><?php echo $oldopen_opp_out; ?></div>
            <div class="graph_box">
                <table class="table" style="margin-top: 70px;">
                    <thead>
                    <tr>
                        <td colspan="2" style="font-style: normal;">KEY</td>
                    </tr>
                    </thead>
                    <tbody>
                   <?php 
                   $details    = getOldestOpportunity();
                   if(isset($details['table_array']) && count($details['table_array']) >0){
                       //$data = array_reverse($desc_client['table_array']);
                       foreach ($details['table_array'] as $key=>$value){
                   ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $value['client_no'];?></td>
                        <td><?php echo (strlen($value['client_name'])>40)?substr($value['client_name'], 0, 37).'...':$value['client_name'];?></td>
                    </tr>
                   <?php }}?> 
                    </tbody>
                </table>
            </div>
		</div>
        
        <div class="outer_div">
			<div class="graph_big"><?php echo $close_opp_out; ?></div>
            <div class="graph_box">
                <table class="table" style="margin-top: 70px;">
                    <thead>
                    <tr>
                        <td colspan="2" style="font-style: normal;">KEY</td>
                    </tr>
                    </thead>
                    <tbody>
                   <?php 
                   if(isset($asc_client['table_array']) && count($asc_client['table_array']) >0){
                       //$data = array_reverse($desc_client['table_array']);
                       foreach (array_reverse($asc_client['table_array']) as $key=>$value){
                   ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $value['client_no'];?></td>
                        <td><?php echo (strlen($value['client_name'])>40)?substr($value['client_name'], 0, 37).'...':$value['client_name'];?></td>
                    </tr>
                   <?php }}?> 
                    </tbody>
                </table>
            </div>
		</div>
        
        <div class="outer_div">
			<div class="graph_big"><?php echo $open_opp_out; ?></div>
            <div class="graph_box">
                <table class="table" style="margin-top: 70px;">
                    <thead>
                    <tr>
                        <td colspan="2" style="font-style: normal;">KEY</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $details    = getTopAmountOpportunity();
                    if(isset($details['table_array']) && count($details['table_array']) >0){
                       foreach ($details['table_array'] as $key=>$value){?>
                    <tr>
                        <td style="text-align: center;"><?php echo $value['client_no'];?></td>
                        <td><?php echo (strlen($value['client_name'])>40)?substr($value['client_name'], 0, 37).'...':$value['client_name'];?></td>
                    </tr>
                   <?php }}?> 
                   </tbody>
                </table>
            </div>
		</div>
        
        <div class="outer_div"><!-- Pie Chart -->
            <div class="table_box"><?php echo $deals_won_out; ?></div>
            <div class="table_box"><?php echo $deals_lost_out; ?></div>
        </div>
        
	</body>
</html>