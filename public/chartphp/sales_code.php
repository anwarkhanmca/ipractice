<?php
include("../../lib/inc/chartphp_dist.php");

/* ========= Sales Pipeline ========= */
$pip_data = getSalesPipeLine();
$pipeline       = new chartphp();
$pipeline->data = $pip_data['graph_array'];
//$pipeline->data = array(array(array('Heavy Industry', 12),array('Retail', 9), array('Light Industry', 14), array('Out of home', 16),array('Commuting', 7)));
$pipeline->chart_type   = "funnel"; 
$pipeline->title        = "Sales Pipeline";   
$out_pipeline           = $pipeline->render('c1');

/* ========= Deals Won vs. Deals Lost ========= */
$wonlost = new chartphp();
$wonlost->data = getWonLostGraph();
$wonlost->chart_type = "bar"; 
$wonlost->color = "yellow";
$wonlost->title = "Won v Lost - Deal Amount";  
$wonlost->options["axes"]["yaxis"]["tickOptions"]["prefix"] = '£'; 
$out_wonlost = $wonlost->render('c2');

/* ========= Won v Lost - Deal Count ========= */
$dealcount = new chartphp();
//$dealcount->data = array(array(array("Won",157),array("Lost",104)));
$dealcount->data = getWonLostDealCount();
$dealcount->chart_type = "bar"; 
$dealcount->title = "Won v Lost - Deal Count";  
$out_3 = $dealcount->render('c3');

/* ========= Sales Lead - What v Warm v Cold ========= */
$sales_data = getSalesLeadGraph();
$hotwarm = new chartphp(); 
//$hotwarm->data = array(array(array('a',6), array('b',8), array('c',14)));
$hotwarm->data = $sales_data['graph_array'];
$hotwarm->chart_type = "donut"; 
//$hotwarm->title = "Sales Lead - Hot v Warm v Cold"; 
$hotwarm->title = "Sales Lead"; 
$out_hotwarm = $hotwarm->render('c4'); 

/* ========= Conversion Rate ========= */
$conversions = getConversionRate();
$conversion_rate             = new chartphp(); 
$conversion_rate->data       = $conversions; 
$conversion_rate->intervals  = array(10,20,30,40,50,60,70,80,90,100); 
$conversion_rate->chart_type = "meter"; 
$conversion_rate->title      = "Deal Conversion Rate (%)"; 
$out_conversion_rate         = $conversion_rate->render('c5');

/* ========= Average Deal Age ========= */
$avgdeals = getAverageClosedDeals();
$deal_age             = new chartphp(); 
//$deal_age->data       = array(array(266)); 
$deal_age->data       = $avgdeals['pointing']; 
$deal_age->intervals  = $avgdeals['interval']; 
$deal_age->chart_type = "meter"; 
$deal_age->title      = "Average Deal Age - Closed Deals"; 
$out_deal_age         = $deal_age->render('c6');

/* ========= Top 10 Oldest Open Opportunities ========= */
$oldopen_opp             = new chartphp(); 
$details                 = getOldestOpportunity();
$oldopen_opp->data       = $details['graph_array'];
$oldopen_opp->chart_type = "bar-stacked"; 
$oldopen_opp->title      = "Top 10 oldest Opportunities"; 
$oldopen_opp->direction  = "horizontal";
$oldopen_opp_out         = $oldopen_opp->render('c7');

/* ========= Top 10 Closed Opportunities ========= */
$closedetails          = getCloseOpportunity();
$close_opp             = new chartphp(); 
//$close_opp->data       = array(array(array(200,1), array(180,2), array(160,3), array(140,4), array(120,5), array(100,6), array(80,7), array(60,8), array(40,9), array(20,10))); 
$close_opp->data       = $closedetails['graph_array'];
$close_opp->chart_type = "bar-stacked"; 
$close_opp->title      = "Top 10 Closed Opportunities"; 
$close_opp->direction  = "horizontal";
$close_opp_out         = $close_opp->render('c8');

/* ========= Top 10 Open Opportunities ========= */
$open_opp             = new chartphp(); 
$opendetails          = getTopAmountOpportunity();//print_r($opendetails);die;
$open_opp->data       = $opendetails['graph_array'];
//$open_opp->data       = array(array(array(0,1), array(0,2), array(0,3),array(0,4), array(0,5), array(0,6), array(0,7), array(0,8),array(0,9),array(0,10))); 
$open_opp->chart_type = "bar-stacked"; 
$open_opp->title      = "Top 10 Open Opportunities"; 
$open_opp->direction  = "horizontal";
$open_opp_out         = $open_opp->render('c9');

/* ========= Deals Won - by Deals Owners ========= */
$deals_won = new chartphp(); 
//$deals_won->data = array(array(array('Org Client', 12),array('Ind Client', 9), array('User', 14), array('Admin', 16), array('Dashboard', 9)));
$deals_won->data = getDealsWonLostByOwners(8);
$deals_won->chart_type = "pie"; 
$deals_won->title = "Deals Won - by Deals Owners";
$deals_won_out = $deals_won->render('c10');

/* ========= Deals Lost - by Deals Owners ========= */
$deals_lost = new chartphp(); 
//$deals_lost->data = array(array(array('Org Client', 12),array('Ind Client', 9), array('Admin', 16),array('CRM', 7), array('Dashboard', 9)));
$deals_lost->data = getDealsWonLostByOwners(9);//print_r($deals_lost->data);
$deals_lost->chart_type = "pie"; 
$deals_lost->title = "Deals Lost - by Deals Owners"; 
$deals_lost_out = $deals_lost->render('c11');


?>