<?php
class LeadsTabManage extends Eloquent {

	public $timestamps = false;
	
	public static function getAllTabDetails()
    {
    	$data = array();
    	$session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];

		$leads_data = LeadsTabManage::whereIn("user_id", $groupUserId)->get();
		if(isset($leads_data) && count($leads_data) >0){
			foreach ($leads_data as $i => $details) {
				$data[$i]['tab_manage_id'] 	= $details->tab_manage_id;
				$data[$i]['tab_id'] 		= $details->tab_id;
				$data[$i]['user_id'] 		= $details->user_id;
				$data[$i]['tab_name'] 		= $details->tab_name;
				$data[$i]['color_code'] 	= $details->color_code;
				$data[$i]['status'] 		= $details->status;
				$data[$i]['is_show'] 		= $details->is_show;
				$data[$i]['count'] 			= CrmLeadsStatus::leadsStatusCount( $details->tab_id );
				$data[$i]['table_value'] 	= CrmLead::getTotalQuotedValue( $details->tab_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function getAllTabDetailsByUserId($group_id)
    {
    	$data = array();
    	$leads_data = LeadsTabManage::where("user_id", '=', $group_id)->get();
		if(isset($leads_data) && count($leads_data) >0){
			foreach ($leads_data as $i => $details) {
				$data[$i]['tab_manage_id'] 	= $details->tab_manage_id;
				$data[$i]['tab_id'] 		= $details->tab_id;
				$data[$i]['user_id'] 		= $details->user_id;
				$data[$i]['tab_name'] 		= $details->tab_name;
				$data[$i]['color_code'] 	= $details->color_code;
				$data[$i]['status'] 		= $details->status;
				$data[$i]['is_show'] 		= $details->is_show;
				$data[$i]['count'] 			= CrmLeadsStatus::leadsStatusCount( $details->tab_id );
				$data[$i]['table_value'] 	= CrmLead::getTotalQuotedValue( $details->tab_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function checkData($group_id)
    {
    	$data = array();
    	$leads_data = LeadsTabManage::getAllTabDetailsByUserId($group_id);
    	if(empty($leads_data)){
			$details = CrmLeadsTab::getAllTabDetails();
			if(isset($details) && count($details) >0){
				foreach ($details as $key => $value) {
					$data[$key]['tab_id'] 		= $value['tab_id'];
					$data[$key]['user_id'] 		= $group_id;
					$data[$key]['tab_name'] 	= $value['tab_name'];
					$data[$key]['color_code'] 	= $value['color_code'];
					$data[$key]['status'] 		= $value['status'];
					$data[$key]['is_show'] 		= $value['is_show'];
					$data[$key]['is_graph'] 	= $value['is_graph'];
				}
				LeadsTabManage::insert($data);
			}
		}
		return $data;
    }


}
