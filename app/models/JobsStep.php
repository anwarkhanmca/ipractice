<?php
class JobsStep extends Eloquent {

	public $timestamps = false;

	public static function getAllJobSteps($service_id)
	{
		$step_data 		= array();
		$session 			= Session::get('admin_details'); // session
		$user_id 			= $session['id'];
		$groupUserId  = $session['group_users'];
		$group_id 		= $session['group_id'];

		$JobStep	= JobsStep::where('group_id', $group_id)->where('job_id', $service_id)->orderBy("shorting_id")->get();
		//Common::last_query();
		if(isset($JobStep) && count($JobStep) >0){
			foreach ($JobStep as $key => $row) {
				$step_data[$key]['step_id'] 		= $row['step_id'];
				$step_data[$key]['user_id'] 		= $row['user_id'];
				$step_data[$key]['group_id'] 		= $row['group_id'];
				$step_data[$key]['job_id'] 			= $row['job_id'];
				$step_data[$key]['shorting_id'] = $row['shorting_id'];
				$step_data[$key]['title'] 			= $row['title'];
				$step_data[$key]['status'] 			= $row['status'];
				$step_data[$key]['step_type'] 	= $row['step_type'];
				$step_data[$key]['short_name'] 	= $row['short_name'];
				$step_data[$key]['created'] 		= $row['created'];
				$step_data[$key]['count'] 			= JobsStep::getStepCountByStepId($service_id,$row['step_id']);
			}
		}
		return $step_data;
	}

	public static function getAllJobStepsByGroupId($service_id)
	{
		$step_data = array();
		$session 		= Session::get('admin_details'); // session
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];
		$group_id 		= $session['group_id'];

		$JobStep	= JobsStep::where('group_id', $group_id)->orderBy("shorting_id")->get();
		//Common::last_query();
		if(isset($JobStep) && count($JobStep) >0){
			foreach ($JobStep as $key => $row) {
				$step_data[$key]['step_id'] 		= $row['step_id'];
				$step_data[$key]['user_id'] 		= $row['user_id'];
				$step_data[$key]['group_id'] 		= $row['group_id'];
				$step_data[$key]['job_id'] 			= $row['job_id'];
				$step_data[$key]['shorting_id'] = $row['shorting_id'];
				$step_data[$key]['title'] 			= $row['title'];
				$step_data[$key]['status'] 			= $row['status'];
				$step_data[$key]['step_type'] 	= $row['step_type'];
				$step_data[$key]['short_name'] 	= $row['short_name'];
				$step_data[$key]['created'] 		= $row['created'];
				$step_data[$key]['count'] 			= JobsStep::getStepCountByStepId($service_id,$row['step_id']);
			}
		}
		return $step_data;
	}

	public static function getStepNameByStepId($step_id)
	{
		$step_name = "Not Started";
		$JobStep	= JobsStep::where('step_id', $step_id)->select('title')->first();
		if(isset($JobStep['title']) && $JobStep['title'] != ""){
			$step_name = $JobStep['title'];
		}
		return $step_name;
	}

	public static function getShortNameByStepId($step_id)
	{
		$step_name = "Not Started";
		$JobStep	= JobsStep::where('step_id', $step_id)->select('short_name')->first();
		if(isset($JobStep['short_name']) && $JobStep['short_name'] != ""){
			$step_name = $JobStep['short_name'];
		}
		return $step_name;
	}

	public static function getStepCountByStepId($service_id, $step_id)
	{ 
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    if($service_id == 7){
      $count = JobStatus::whereIn('user_id',$groupUserId)->where('status_id', $step_id)->whereIn('service_id', [7,10])->count();
    }else{
      $count = JobStatus::whereIn("user_id", $groupUserId)->where('status_id', $step_id)->where('service_id', $service_id)->count();
    }
		return $count;
	}

	public static function getLastStepId($service_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
        
		$step_id = 0;
		$JobStep	= JobsStep::whereIn("user_id", $groupUserId)->where('job_id', $service_id)->select('step_id')->orderBy('step_id', 'desc')->first();
		if(isset($JobStep['step_id']) && $JobStep['step_id'] != ""){
			$step_id = $JobStep['step_id'];
		}
		return $step_id;
	}

	public static function getStepId($service_id, $page_open)
	{
		$step_id = $page_open;
		if($page_open >2){
			$limit = $page_open-3;
			$steps = JobsStep::where('job_id', $service_id)->select('step_id')->orderBy('step_id', 'asc')->skip($limit)->take(1)->first();
        $step_id = $steps['step_id'];
		}
		return $step_id;
		
	}

	public static function checkJobsStepsData($group_id)
    {
    	$data = array();
    	$session 		= Session::get('admin_details'); // session
			$user_id 		= $session['id'];

    	$leads_data = JobsStep::getAllJobStepsByGroupId($group_id);
    	if(empty($leads_data)){
			for ($i=1; $i < 10; $i++) {
				$key = 0;
				for ($j=1; $j <= 8; $j++) {//1,2,3,5,7,9=>filed
					$data[$key]['user_id'] 		= $user_id;
					$data[$key]['group_id'] 	= $group_id;
					$data[$key]['job_id'] 		= $i;
					$data[$key]['shorting_id'] 	= $j;
					$data[$key]['title'] 		= ($j==8)?'Filed':"status ".$j;
					$data[$key]['status'] 		= 'S';
					$data[$key]['step_type'] 	= '';
					$data[$key]['short_name'] 	= ($j==8)?'filed':'';
					$data[$key]['created'] 		= date('Y-m-d H:i:s');
					$key ++;
				}
				JobsStep::insert($data);
			}
			
		}
		return $data;
    }

	

}
