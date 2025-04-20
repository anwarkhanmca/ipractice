<?php
class CrmLeadsStatus extends Eloquent {

	public $timestamps = false;

	public static function leadsStatusCount( $tab_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $stattus_count = CrmLeadsStatus::whereIn("user_id", $groupUserId)->where("leads_tab_id", "=", $tab_id)->get()->count();
        /*if($tab_id == 12){
        	$stattus_count = CrmLead::whereIn("user_id", $groupUserId)->where('is_invoiced', '=', 'Y')->get()->count();
        }else{
        	$stattus_count = CrmLeadsStatus::whereIn("user_id", $groupUserId)->where("leads_tab_id", "=", $tab_id)->get()->count();
        }*/
		
		return $stattus_count;
	}

	public static function leadsStatusByTabId( $tab_id )
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
		$stattus = CrmLeadsStatus::whereIn("user_id", $groupUserId)->where("leads_tab_id", "=", $tab_id)->get();
		if(isset($stattus) && count($stattus) >0){
			foreach ($stattus as $i => $details) {
				$data[$i]['leads_status_id'] 	= $details->leads_status_id;
				$data[$i]['leads_tab_id'] 		= $details->leads_tab_id;
				$data[$i]['user_id'] 			= $details->user_id;
				$data[$i]['leads_id'] 			= $details->leads_id;
				$data[$i]['likely'] 			= $details->created;
			}
		}
		return $data;
	}

	public static function getDetailsByLeadsId( $leads_id )
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = CrmLeadsStatus::whereIn("user_id", $groupUserId)->where("leads_id", "=", $leads_id)->first();
		if(isset($details) && count($details) >0){
			$data['leads_status_id'] 	= $details->leads_status_id;
			$data['user_id'] 			= $details->user_id;
			$data['leads_id'] 			= $details->leads_id;
			$data['leads_tab_id'] 		= $details->leads_tab_id;
			$data['likely'] 			= $details->created;
		}
		return $data;
	}

	public static function getTabIdByLeadsId( $leads_id )
	{
		$tab_id = 0;
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        if($leads_id != 0){
			$details = CrmLeadsStatus::whereIn("user_id", $groupUserId)->where("leads_id", $leads_id)->first();
			if(isset($details['leads_tab_id']) && $details['leads_tab_id'] != ""){
				$tab_id 	= $details->leads_tab_id;
			}
		}
		return $tab_id;
	}

	public static function getLeadsIdByTabId( $tab_id )
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$stattus = CrmLeadsStatus::whereIn("user_id", $groupUserId)->where("leads_tab_id", "=", $tab_id)->first();
		if(isset($stattus) && count($stattus) >0){
			foreach ($stattus as $i => $details) {
				$data[$i]['leads_id'] 	= $details->leads_id;
			}
		}
		return $data;
	}

	

}
