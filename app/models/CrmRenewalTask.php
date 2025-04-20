<?php
class CrmRenewalTask extends Eloquent {

	public $timestamps = false;

	public static function getCrmTaskByClientId($client_id)
	{
		$data = array();
		$session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
		$details = CrmRenewalTask::whereIn('user_id', $groupUserId)->where('client_id', '=', $client_id)->get();
		//Common::last_query();die;
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['task_id'] 		= $value['task_id'];
				$data[$key]['user_id'] 		= $value['user_id'];
				$data[$key]['user_name'] 	= User::getStaffNameById($value['user_id']);
				$data[$key]['client_id'] 	= $value['client_id'];
				$data[$key]['task_name'] 	= $value['task_name'];
				$data[$key]['task_date']	= date('d-m-Y', strtotime($value['task_date']));
				$data[$key]['task_time'] 	= $value['task_time'];
				$data[$key]['created'] 		= $value['created'];
			}
			
		}
		//print_r($details);die;
		return $data;
	}

	public static function getCrmTaskByRenewalId($task_id)
	{
		$data = array();
		$value = CrmRenewalTask::where('task_id', '=', $task_id)->first();
		//Common::last_query();die;
		if(isset($value) && count($value) >0){
			$data['task_id'] 		= $value['task_id'];
			$data['user_id'] 		= $value['user_id'];
			$data['user_name'] 		= User::getStaffNameById($value['user_id']);
			$data['client_id'] 		= $value['client_id'];
			$data['task_name'] 		= $value['task_name'];
			$data['task_date']		= date('d-m-Y', strtotime($value['task_date']));
			$data['task_time'] 		= $value['task_time'];
			$data['created'] 		= $value['created'];
		}
		//print_r($value);die;
		return $data;
	}

	public static function countCrmTaskByClientId($client_id)
	{
		$session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
		$count = CrmRenewalTask::whereIn('user_id', $groupUserId)->where('client_id', '=', $client_id)->first()->count();
		
		return $count;
	}

}
