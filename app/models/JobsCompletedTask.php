<?php
class JobsCompletedTask  extends Eloquent{
	
	public $timestamps = false;
	public static function getTaskByClientAndServiceId($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobsCompletedTask::whereIn("user_id", $groupUserId)->where("client_id","=", $client_id)->where("service_id","=", $service_id)->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['task_id'] 		= $JobStatus['jobs_notes_id'];
			$status_data['client_id'] 		= $JobStatus['client_id'];
			$status_data['service_id'] 		= $JobStatus['service_id'];
			$status_data['job_manage_id'] 	= $JobStatus['job_manage_id'];
			$status_data['user_id'] 		= $JobStatus['user_id'];
			$status_data['date'] 			= $JobStatus['date'];
			$status_data['created'] 		= $JobStatus['created'];
		}
		return $status_data;
	}

	public static function saveCompletedTask($client_id, $service_id, $status_id, $manage_id)
	{
		$status_data = array();
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $steps = JobsStep::whereIn("user_id", $groupUserId)->where('job_id', $service_id)->where('short_name', 'filed')->select('step_id')->first();


    if(isset($steps['step_id']) && $steps['step_id'] == $status_id){
			$status_data['client_id'] 		= $client_id;
			$status_data['job_manage_id'] = $manage_id;
			$status_data['service_id'] 		= $service_id;
			$status_data['user_id'] 			= $user_id;
			$status_data['date'] 					= date("d-m-Y");
			JobsCompletedTask::insert($status_data);

			$task_name 		= Service::getNameServiceId( $service_id );
			$job_name 		= JobsManage::getJobNameByManageId($manage_id, $service_id, $client_id);
			$last_status  = JobStatus::statusNameByJobManageId($manage_id);

			$addData['user_id'] 		= $user_id;
			$addData['client_id'] 	= $client_id;
			$addData['client_type'] = 'tasks';
			$addData['is_read'] 		= 'N';
			$addData['notes'] 			= $task_name.' for '.$job_name.' '.$last_status;
			$addData['job_name'] 		= $job_name;
			$addData['client_name'] = Client::getClientNameByClientId($client_id);
			$addData['created'] 		= date('Y-m-d H:i:s');
			$store_id = DataStore::insertGetId($addData);
		}
		return $status_data;
	}

	public static function customCompletedTask($client_id, $service_id, $status_id, $manage_id)
	{
		$status_data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        if($status_id != 'completed'){
        	JobStatus::where('job_status_id', '=', $status_id)->delete();
        }
        
        $status_data['user_id'] 		= $user_id;
        $status_data['client_id'] 		= $client_id;
        $status_data['service_id'] 		= $service_id;
		$status_data['job_manage_id'] 	= $manage_id;
		$status_data['date'] 			= date("d-m-Y");
		$status_data['created'] 		= date("Y-m-d H:i:s");
		JobsCompletedTask::insert($status_data);

		return $status_data;
	}

	public static function getCompletionDate($client_id, $service_id)
	{
		$created = '';
		$tasks = JobsCompletedTask::getTaskByClientAndServiceId($client_id, $service_id);
		if(isset($tasks['created']) && $tasks['created'] != "0000-00-00 00:00:00"){
			$created = $tasks['created'];
		}
		return $created;
	}

	public static function getCompletedTask($service_id, $staff_id)
	{
		$details = array();
		//$clients    = JobsManage::getCompletedClientIdByServiceId($service_id);
		$completedata = JobsCompletedTask::where('service_id', '=', $service_id)->get();
        
        if(isset($completedata) && count($completedata) >0){
            foreach ($completedata as $key => $value) {
            	$client_id = $value['client_id'];

                $details[$key]['task_id'] 		= $value['task_id'];
                $details[$key]['client_id'] 	= $client_id;
                $details[$key]['client_name'] 	= Client::getClientNameByClientId($client_id);

                $details[$key]['date'] 			= $value['date'];
                $details[$key]['created'] 		= $value['created'];
            }
        }
        return $details;
	}
	

}
