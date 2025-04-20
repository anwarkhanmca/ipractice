<?php
class CrmRenewal extends Eloquent {

	public $timestamps = false;

	public static function getCrmRenewalByClientId($client_id)
	{
		$data = array();
		$session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
		$details = CrmRenewal::whereIn('user_id', $groupUserId)->where('client_id', '=', $client_id)->get();
		//Common::last_query();die;
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['renewal_id'] 	= $value['renewal_id'];
				$data[$key]['user_id'] 		= $value['user_id'];
				$data[$key]['user_name'] 	= User::getStaffNameById($value['user_id']);
				$data[$key]['client_id'] 	= $value['client_id'];
				$data[$key]['title'] 		= $value['title'];
				$data[$key]['notes'] 		= $value['notes'];
				$data[$key]['added_from'] 	= $value['added_from'];
				$data[$key]['date']			= date('d-m-Y', strtotime($value['date']));
				$data[$key]['time'] 		= $value['time'];
				$data[$key]['created'] 		= $value['created'];
			}
			
		}
		//print_r($details);die;
		return $data;
	}

	public static function getCrmRenewalByRenewalId($renewal_id)
	{
		$data = array();
		$value = CrmRenewal::where('renewal_id', '=', $renewal_id)->first();
		//Common::last_query();die;
		if(isset($value) && count($value) >0){
			$data['renewal_id'] 	= $value['renewal_id'];
			$data['user_id'] 		= $value['user_id'];
			$data['user_name'] 		= User::getStaffNameById($value['user_id']);
			$data['client_id'] 		= $value['client_id'];
			$data['title'] 			= $value['title'];
			$data['notes'] 			= $value['notes'];
			$data['added_from'] 	= $value['added_from'];
			$data['date']			= date('d-m-Y', strtotime($value['date']));
			$data['time'] 			= $value['time'];
			$data['created'] 		= $value['created'];
		}
		//print_r($value);die;
		return $data;
	}

	public static function countCrmRenewalByClientId($client_id)
	{
		$session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
		$count = CrmRenewal::whereIn('user_id', $groupUserId)->where('client_id', '=', $client_id)->first()->count();
		
		return $count;
	}

	public static function getCrmClientDetails($page_open)
    {
        $data   = array();
        $tab21  = array();
        $tab22  = array();
        $tab3   = array();

        $tab21 = App::make('CrmController')->getTabTwoOneDetails($page_open);
        $tab22 = App::make('CrmController')->getTabTwoTwoDetails($page_open);
        $data = array_merge($tab21['client_details'], $tab22['client_details']);
        //echo "<pre>";print_r($data);die;
        return array_values($data);
    }

}
