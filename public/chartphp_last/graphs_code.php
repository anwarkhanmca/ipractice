<?php
$yearly_ind        = getAverageMeterData('ind', 'yearly');
$avg_ind_value     = $yearly_ind['avg_value'];
$avg_ind_mtr       = $yearly_ind['avg_range'];

$monthly_ind       = getAverageMeterData('ind', 'monthly');
$ind_monthly_value = $monthly_ind['avg_value'];
$ind_monthly_mtr   = $monthly_ind['avg_range'];


$yearly_org       = getAverageMeterData('org', 'yearly');
$avg_org_value    = $yearly_org['avg_value'];
$avg_org_mtr      = $yearly_org['avg_range'];

$monthly_org       = getAverageMeterData('org', 'monthly');
$org_monthly_value = $monthly_org['avg_value'];
$org_monthly_mtr   = $monthly_org['avg_range'];

include("../../lib/inc/chartphp_dist.php");

/* ========= One ========= */
$p = new chartphp();
//$p->data = getnoofclients();
$p->data = array(array(array("Org",157),array("Indi",104)));
//$p->data_sql = "select IF(ct.type='ind', 'Indi', 'Org'), count(c.client_id) as total from client_types ct, clients c where c.type=ct.type and c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' group by c.type order by c.type asc"; 
$p->chart_type = "bar"; 
$p->color = "#ADD8E6";
$p->title = "Number of Clients";   
$out1 = $p->render('c1');

/* ========= Two ========= */
$p2 = new chartphp();
$p2->data = getWonLostGraph();
$p2->chart_type = "bar"; 
$p2->color = "yellow";
$p2->title = "Deals Won v Lost (All time)";  
$p2->options["axes"]["yaxis"]["tickOptions"]["prefix"] = '£'; 
$out2 = $p2->render('c2');

/* ========= Three ========= */
$artition_org_m             = new chartphp();
$artition_org_m->data       = array(array(266));
$artition_org_m->intervals  = array(200,300,400,600);
$artition_org_m->chart_type = "meter"; 
$artition_org_m->title      = "Artition Rate - Organisation Clients"; 
$artition_org_mtr           = $artition_org_m->render('c3');

/* ========= Four ========= */
$growth_org             = new chartphp(); 
$growth_org->data       = array(array(266)); 
$growth_org->intervals  = array(200,300,400,600); 
$growth_org->chart_type = "meter"; 
$growth_org->title      = "Growth Rate - Organisation Clients"; 
$growth_org_mtr         = $growth_org->render('c4');

/* ========= Average Yearly Fees Individual Clients Start ========= */
$yearly_ind_m             = new chartphp(); 
$yearly_ind_m->data       = $avg_ind_value;
$yearly_ind_m->intervals  = $avg_ind_mtr;
$yearly_ind_m->chart_type = "meter"; 
$yearly_ind_m->title      = "Average Yearly Fee - Individual Clients"; 
$yearly_ind_mtr           = $yearly_ind_m->render('c5');

/* ========= Average Monthly Fees Individual Clients Start ========= */
$monthly_ind_m             = new chartphp(); 
$monthly_ind_m->data       = $ind_monthly_value;
$monthly_ind_m->intervals  = $ind_monthly_mtr;
$monthly_ind_m->chart_type = "meter"; 
$monthly_ind_m->title      = "Average Monthly Fee - Individual Clients"; 
$monthly_ind_mtr           = $monthly_ind_m->render('c6');

/* ========= Average Yearly Fees Organisation Clients Start ========= */
$yearly_org_m             = new chartphp(); 
$yearly_org_m->data       = $avg_org_value;
$yearly_org_m->intervals  = $avg_org_mtr;
$yearly_org_m->chart_type = "meter"; 
$yearly_org_m->title      = "Average Yearly Fee - Organisation Clients"; 
$yearly_org_mtr           = $yearly_org_m->render('c7');

/* ========= Average Monthly Fees Organisation Clients Start ========= */
$monthly_org_m             = new chartphp(); 
$monthly_org_m->data       = array(array(281));
$monthly_org_m->intervals  = array(417, 834, 1250, 1667); 
$monthly_org_m->chart_type = "meter"; 
$monthly_org_m->title      = "Average Monthly Fee - Organisation Clients"; 
$monthly_org_mtr           = $monthly_org_m->render('c8');


$asc_client = getTopTenClient('ASC', 'org');
$p3 = new chartphp();
//$p3->data = array(array(array(200,1), array(180,2), array(160,3), array(140,4), array(120,5), array(100,6), array(80,7), array(60,8), array(40,9), array(20,10)));
$p3->data = $asc_client['graph_array'];			
$p3->chart_type = "bar-stacked";
$p3->title = "TOP 10 LOWEST FEES (£)"; 
//$p3->options["axes"]["xaxis"]["tickOptions"]["prefix"] = '£'; 
$p3->x_data_type = "number"; 
$p3->direction = "horizontal";
$out3 = $p3->render('c9');

/* ========= Four ========= */
$desc_client = getTopTenClient('DESC', 'org');
$p4 = new chartphp();
/*$p4->data = array(
	array(
		array(20,1), array(40,2), array(60,3), array(80,4), array(100,5), array(120,6), array(140,7), array(160,8), array(180,9), array(200,10)
		)
	);*/
$p4->data = $desc_client['graph_array'];					
$p4->chart_type = "bar-stacked";
$p4->title = "TOP 10 HIGHEST FEES (£)";
//$p4->options["axes"]["xaxis"]["tickOptions"]["prefix"] = '£'; 
$p4->direction = "horizontal";
$p4->export = false;
$out4 = $p4->render('c10');

/* ========= Five ========= */
$p11 = new chartphp(); 
$p11->data = array(array(array('Org Client', 12),array('Ind Client', 9), array('User', 14), array('Admin', 16),array('CRM', 7), array('Dashboard', 9)));
$p11->chart_type = "pie"; 
$p11->title = "Referral Source"; 
$referal_sourse = $p11->render('c11'); 

$p12 = new chartphp(); 
$p12->data = array(array(array('Org Client', 12),array('Ind Client', 9), array('User', 14), array('Admin', 16),array('CRM', 7), array('Dashboard', 9)));
$p12->chart_type = "pie"; 
$p12->title = "Industry types"; 
$industry_type = $p12->render('c12'); 

?>