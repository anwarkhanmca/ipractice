<?php
class CrmLeadsTab extends Eloquent {

	public $timestamps = false;
	
	public static function getAllTabDetails()
    {
    	$data = array();
		$leads_data = CrmLeadsTab::get();
		if(isset($leads_data) && count($leads_data) >0){
			foreach ($leads_data as $i => $details) {
				$data[$i]['tab_id'] 		= $details->tab_id;
				$data[$i]['tab_name'] 		= $details->tab_name;
				$data[$i]['color_code'] 	= $details->color_code;
				$data[$i]['status'] 		= $details->status;
				$data[$i]['is_show'] 		= $details->is_show;
				$data[$i]['is_graph'] 		= $details->is_graph;
				$data[$i]['count'] 			= CrmLeadsStatus::leadsStatusCount( $details->tab_id );
				$data[$i]['table_value'] 	= CrmLead::getTotalQuotedValue( $details->tab_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }


}
