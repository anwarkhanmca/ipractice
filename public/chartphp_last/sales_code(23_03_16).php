<?php
include("../../lib/inc/chartphp_dist.php");

/* ========= Sales Pipeline ========= */
$pipeline       = new chartphp();
//$pipeline->data = getnoofclients();
$pipeline->data = array(array(array('Heavy Industry', 12),array('Retail', 9), array('Light Industry', 14), array('Out of home', 16),array('Commuting', 7)));
$pipeline->chart_type   = "funnel"; 
$pipeline->title        = "Sales Pipeline";   
$out_pipeline           = $pipeline->render('c1');

/* ========= Deals Won vs. Deals Lost ========= */
$wonlost = new chartphp();
$wonlost->data = getWonLostGraph();
$wonlost->chart_type = "bar"; 
$wonlost->color = "yellow";
$wonlost->title = "Deals Won vs. Deals Lost";  
$wonlost->options["axes"]["yaxis"]["tickOptions"]["prefix"] = '£'; 
$out_wonlost = $wonlost->render('c2');

/* ========= Deals Won vs. Deals Lost ========= */
$p = new chartphp();
$p->data = array(array(array("Won",157),array("Lost",104)));
$p->chart_type = "bar"; 
$p->title = "Deals Won vs. Deals Lost";  
$out_3 = $p->render('c3');

/* ========= Sales Lead - What v Warm v Cold ========= */
$hotwarm = new chartphp(); 
$hotwarm->data = array(array(array('a',6), array('b',8), array('c',14), array('d',20)));
$hotwarm->chart_type = "donut"; 
$hotwarm->title = "Sales Lead - What v Warm v Cold"; 
$out_hotwarm = $hotwarm->render('c4'); 

/* ========= Conversion Rate ========= */
$conversion_rate             = new chartphp(); 
$conversion_rate->data       = array(array(266)); 
$conversion_rate->intervals  = array(200,300,400,600); 
$conversion_rate->chart_type = "meter"; 
$conversion_rate->title      = "Conversion Rate"; 
$out_conversion_rate         = $conversion_rate->render('c5');

/* ========= Average Deal Age ========= */
$deal_age             = new chartphp(); 
$deal_age->data       = array(array(266)); 
$deal_age->intervals  = array(200,300,400,600); 
$deal_age->chart_type = "meter"; 
$deal_age->title      = "Conversion Rate"; 
$out_deal_age         = $deal_age->render('c6');

/* ========= Top 10 Oldest Open Opportunities ========= */
$oldopen_opp             = new chartphp(); 
$details                 = getOldestOpportunity();
$oldopen_opp->data       = $details['graph_array'];
$oldopen_opp->chart_type = "bar-stacked"; 
$oldopen_opp->title      = "Top 10 Oldest Open Opportunities"; 
$oldopen_opp->direction  = "horizontal";
$oldopen_opp_out         = $oldopen_opp->render('c7');

/* ========= Top 10 Closed Opportunities ========= */
$close_opp             = new chartphp(); 
$close_opp->data       = array(array(array(200,1), array(180,2), array(160,3), array(140,4), array(120,5), array(100,6), array(80,7), array(60,8), array(40,9), array(20,10))); 
$close_opp->chart_type = "bar-stacked"; 
$close_opp->title      = "Top 10 Closed Opportunities"; 
$close_opp->direction  = "horizontal";
$close_opp_out         = $close_opp->render('c8');

/* ========= Top 10 Open Opportunities ========= */
$open_opp             = new chartphp(); 
$opendetails          = getTopAmountOpportunity();
$open_opp->data       = $opendetails['graph_array'];
//$open_opp->data       = array(array(array(0,1), array(0,2), array(0,3),array(0,4), array(0,5), array(0,6), array(0,7), array(0,8),array(0,9), array(0,10))); 
$open_opp->chart_type = "bar-stacked"; 
$open_opp->title      = "Top 10 Open Opportunities"; 
$open_opp->direction  = "horizontal";
$open_opp_out         = $open_opp->render('c9');

/* ========= DEALS WON BY DEAL WONERS ========= */
$deals_won = new chartphp(); 
$deals_won->data = array(array(array('Org Client', 12),array('Ind Client', 9), array('User', 14), array('Admin', 16),array('CRM', 7), array('Dashboard', 9)));
//eals_won->data = getReferralSource();
$deals_won->chart_type = "pie"; 
$deals_won->title = "DEALS WON BY DEAL WONERS";
$deals_won_out = $deals_won->render('c10');

$deals_lost = new chartphp(); 
$deals_lost->data = array(array(array('Org Client', 12),array('Ind Client', 9), array('User', 14), array('Admin', 16),array('CRM', 7), array('Dashboard', 9)));
//$deals_lost->data = getIndustryGraph();
$deals_lost->chart_type = "pie"; 
$deals_lost->title = "DEALS LOST BY DEAL WONERS"; 
$deals_lost_out = $deals_lost->render('c11');


?>