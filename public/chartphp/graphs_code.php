<?php

//include("../../config.php"); 
include("../../lib/inc/chartphp_dist.php");

/* ========= One ========= */
$p = new chartphp();
$p->data = getnoofclients();
//$p->data = array(array(array("Org",157),array("Indi",104)));
//$p->data_sql = "select IF(ct.type='ind', 'Indi', 'Org'), count(c.client_id) as total from client_types ct, clients c where c.type=ct.type and c.is_archive = 'N' and c.is_relation_add = 'N' and c.is_deleted = 'N' group by c.type order by c.type asc"; 
$p->chart_type = "bar"; 
$p->color = "#ADD8E6";
$p->title = "Number of Clients";   
$out1 = $p->render('c1');

/* ========= Two ========= */

/* ========= Three ========= */
//$attrition_rate = 
$artition_org_m             = new chartphp();
//$artition_org_m->data       = array(array(26));
$artition_org_m->data       = getArrtitionRate('org');
$artition_org_m->intervals  = array(10,20,30,40, 50, 60, 70, 80, 90, 100);
$artition_org_m->chart_type = "meter"; 
$artition_org_m->title      = "Attrition rate (%) - Organisation Clients"; 
$artition_org_mtr           = $artition_org_m->render('c3');
//echo "<pre>";print_r($artition_org_m->data);die;

/* ========= Four ========= */
$growth_org             = new chartphp(); 
$growth_org->data       = growthChart();
$growth_org->chart_type = "line"; 
$growth_org->title      = "Growth Curve - Organisation v Individuals Clients"; 
$growth_org_out         = $growth_org->render('c4');
//echo "<pre>";print_r($growth_org->data);die;

/* ========= Total Yearly Fee - Individual Clients ========= */
$total_yearly_ind        = getAverageMeterData('ind', 'yearly', 'T');
$total_ind_m             = new chartphp(); 
$total_ind_m->data       = $total_yearly_ind['avg_value'];
$total_ind_m->intervals  = $total_yearly_ind['avg_range'];
$total_ind_m->chart_type = "meter"; 
$total_ind_m->title      = "Total Yearly Fee - Individual Clients (£'000)"; 
$total_ind_out           = $total_ind_m->render('c5');

/* ========= Average Yearly Fees Individual Clients Start ========= */
$avg_yearly_ind           = getAverageMeterData('ind', 'yearly', 'A');
$yearly_ind_m             = new chartphp(); 
$yearly_ind_m->data       = $avg_yearly_ind['avg_value'];
$yearly_ind_m->intervals  = $avg_yearly_ind['avg_range'];
$yearly_ind_m->chart_type = "meter"; 
$yearly_ind_m->title      = "Average Yearly Fee - Individual Clients (£'000)"; 
$avg_ind_out              = $yearly_ind_m->render('c6');


/* ========= Total Yearly Fee - Organisation Clients ========= */
$total_yearly_org          = getAverageMeterData('org', 'yearly', 'T');
$monthly_org_m             = new chartphp(); 
$monthly_org_m->data       = (array)$total_yearly_org['avg_value'];
$monthly_org_m->intervals  = (array)$total_yearly_org['avg_range'];
$monthly_org_m->chart_type = "meter"; 
$monthly_org_m->title      = "Total Yearly Fee - Organisation Clients (£'000)"; 
$monthly_org_mtr           = $monthly_org_m->render('c7');

/* ========= Average Yearly Fees Organisation Clients Start ========= */
$yearly_org               = getAverageMeterData('org', 'yearly', 'A');
$yearly_org_m             = new chartphp(); 
$yearly_org_m->data       = $yearly_org['avg_value'];
$yearly_org_m->intervals  = $yearly_org['avg_range'];
$yearly_org_m->chart_type = "meter"; 
$yearly_org_m->title      = "Average Yearly Fee - Organisation Clients (£'000)"; 
$yearly_org_mtr           = $yearly_org_m->render('c8');

//print_r($total_yearly_org);die;

$asc_client = getTopTenClient('ASC', 'org');
$p3 = new chartphp();
//$p3->data = array(array(array(200,1), array(180,2), array(160,3), array(140,4), array(120,5), array(100,6), array(80,7), array(60,8), array(40,9), array(20,10)));
$p3->data = $asc_client['graph_array'];			
$p3->chart_type = "bar-stacked";
$p3->title = "Top 10 Lowest Fees (£)"; 
//$p3->options["axes"]["xaxis"]["tickOptions"]["prefix"] = '£'; 
$p3->x_data_type = "number"; 
$p3->direction = "horizontal";
$out3 = $p3->render('c9');

/* ========= Four ========= */
$desc_client = getTopTenClient('DESC', 'org');
$p4 = new chartphp();
//$p4->data = array(array(array(20,1), array(40,2), array(60,3), array(80,4), array(100,5), array(120,6), array(140,7), array(160,8), array(180,9), array(200,10)));
$p4->data = $desc_client['graph_array'];					
$p4->chart_type = "bar-stacked";
$p4->title = "Top 10 Highest Fees (£)";
$p4->direction = "horizontal";
$p4->export = false;
$out4 = $p4->render('c10');

/* ========= Five ========= */
$p11 = new chartphp(); 
//$p11->data = array(array(array('Advertisement', 1),array('Employee Referral', 1), array('External Referral', 1), array('Partner', 1),array('Others', 5)));
$p11->data = getReferralSource();
$p11->chart_type = "pie"; 
$p11->title = "Referral Source"; 
$referal_sourse = $p11->render('c11');

$p12 = new chartphp(); 
//$p12->data = array(array(array('Org Client', 12),array('Ind Client', 9), array('User', 14), array('Admin', 16),array('CRM', 7), array('Dashboard', 9)));
//echo "<pre>";print_r($p12->data);die;
$p12->data = getIndustryGraph();
$p12->chart_type = "pie"; 
$p12->title = "Industries"; 
$industry_type = $p12->render('c12'); 

?>