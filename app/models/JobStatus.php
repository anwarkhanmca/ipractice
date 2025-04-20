<?php
class JobStatus extends Eloquent {

	public $timestamps = false;

	public static function getAllJobStatus()
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("is_completed","=", "N")->get();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$status_data[$key]['job_status_id'] = $row['job_status_id'];
				$status_data[$key]['client_id'] 		= $row['client_id'];
				$status_data[$key]['service_id'] 		= $row['service_id'];
				$status_data[$key]['status_id'] 		= $row['status_id'];
				$status_data[$key]['job_manage_id'] = $row['job_manage_id'];
			}
		}
		return $status_data;
	}

	public static function getJobStatusByServiceId($service_id, $clientId)
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->whereIn("client_id", $clientId)->where("service_id", $service_id)->where("is_completed", "N")->get();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$status_data[$key]['job_status_id'] = $row['job_status_id'];
				$status_data[$key]['client_id'] 		= $row['client_id'];
				$status_data[$key]['service_id'] 		= $row['service_id'];
				$status_data[$key]['status_id'] 		= $row['status_id'];
				$status_data[$key]['job_manage_id'] = $row['job_manage_id'];
			}
		}
		return $status_data;
	}

	public static function getCompletedJobStatusByClientId($service_id, $client_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", "=", $service_id)->where("is_completed","=", "Y")->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['job_status_id'] 	= $JobStatus['job_status_id'];
			$status_data['user_id'] 		= $JobStatus['user_id'];
			$status_data['client_id'] 		= $JobStatus['client_id'];
			$status_data['service_id'] 		= $JobStatus['service_id'];
			$status_data['status_id'] 		= $JobStatus['status_id'];
			$status_data['job_manage_id'] 	= $row['job_manage_id'];
			$status_data['notes'] 			= $JobStatus['notes'];
			$status_data['is_completed'] 	= $JobStatus['is_completed'];
			$status_data['created'] 		= $JobStatus['created']; 
		}
		return $status_data;
	}

	public static function getJobStatusByStatusId($service_id, $status_id, $clientId)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->whereIn("client_id", $clientId)->where("service_id","=",$service_id)->where("is_completed","=", "N")->where("status_id","=",$status_id)->get();
		//Common::last_query();die;
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$status_data[$key]['job_status_id'] = $row['job_status_id'];
				$status_data[$key]['client_id'] 	= $row['client_id'];
				$status_data[$key]['service_id'] 	= $row['service_id'];
				$status_data[$key]['status_id'] 	= $row['status_id'];
				$status_data[$key]['job_manage_id'] = $row['job_manage_id'];
			}
		}
		return $status_data;
	}

	public static function getCompletedTaskByServiceId( $service_id, $status_id, $clientId )
	{
		$clients 		= array();
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$client_data = array();
		$JobStatus= JobsCompletedTask::whereIn("user_id",$groupUserId)->where("service_id",$service_id)->get();
		//Common::last_query();die;
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$client_data[$key] = Common::clientDetailsById( $row->client_id );
				
				$client_data[$key]['jobs_notes']['notes'] = $row->notes;
				$client_data[$key]['job_status'][$service_id]['filling_date'] = $row->filling_date;
				
				$client_data[$key]['completed_tasks']['task_id'] = $row->task_id;
				$client_data[$key]['completed_tasks']['date'] = $row->date;
				$client_data[$key]['completed_tasks']['job_manage_id'] = $row->job_manage_id;
				$client_data[$key]['completed_tasks']['last_return_date'] = StepsFieldsClient::getLastReturnDateByClientId($row['client_id']);
				$client_data[$key]['completed_tasks']['last_acc_madeup_date'] = StepsFieldsClient::getLastAccDateByClientId($row['client_id']); 
				$acc_details = JobsAccDetail::getDetailsByClientId($row['client_id']);
                //echo $this->last_query();

        $manages = JobsManage::getAllDetails($row['client_id'], $service_id);
        if(isset($manages['job_manage_id'])){
            $client_data[$key]['job_manage_id'] = $manages['job_manage_id'];
            $return_date = JobsManage::getReturnDateByManageId($manages['job_manage_id']);
            $client_data[$key]['return_date'] = $return_date;
        }else{
            $client_data[$key]['job_manage_id'] = 0;
        }
        if(isset($manages['status']) && $manages['status'] == 'Y'){
            $client_data[$key]['manage_task'] = 'Y';
        }else{
            $client_data[$key]['manage_task'] = 'N';
        }
        if(isset($manages['created'])){
            $client_data[$key]['job_due_date'] = $manages['created'];
        }else{
            $client_data[$key]['job_due_date'] = '';
        }
        /*if(isset($manages['return_date'])){
            $client_data[$key]['return_date'] = $manages['return_date'];
        }else{
            $client_data[$key]['return_date'] = '';
        }*/
        if(isset($manages['period_end'])){
            $client_data[$key]['period_end'] = $manages['period_end'];
        }
        $client_data[$key]['jobs_acc_details'] 	= $acc_details;

        $timesheet_check = TimeSheetReport::checkTimeSheet($row['client_id'], $service_id, $row->task_id);
        $client_data[$key]['timesheet_check'] 	= $timesheet_check;
			}
		}

		
		//$clients = array_merge($client_array, $client_data);

		//echo "<pre>";print_r($client_data);echo "</pre>";die;
		return array_values($client_data);
	}

	/*public static function getCompletedTaskByServiceId( $service_id, $status_id, $clientId )
	{
		$clients 		= array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$client_array = array();
		$client_details = Client::getClientByServiceId( $service_id );
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $details) {
				
				if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y"){
        			if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == 10){
        				//echo $details['job_status'][$service_id]['status_id'];
						$client_array[$key] = $client_details[$key];
						$client_array[$key]['completed_tasks'] = JobsCompletedTask::getTaskByClientAndServiceId($details['client_id'], $service_id);
						$client_array[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
					}
				}
				
			}
		}

		$client_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("service_id","=",$service_id)->where("is_completed","=", "Y")->where("status_id","=",$status_id)->get();
		//Common::last_query();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$client_data[$key] = Common::clientDetailsById( $row['client_id'] );
				$client_data[$key]['completed_tasks'] = JobsCompletedTask::getTaskByClientAndServiceId($row['client_id'], $service_id);
				$client_data[$key]['job_status'][$service_id] = JobStatus::getCompletedJobStatusByClientId($service_id, $row['client_id']);
				$client_data[$key]['jobs_notes'] = JobsNote::getCompletedTaskNotes($row['client_id'], $service_id);
			}
		}

		
		$clients = array_merge($client_array, $client_data);

		//echo "<pre>";print_r($clients);echo "</pre>";die;
		return array_values($clients);
	}*/

	public static function getStatusNameByClientId($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$name = 'Not Started';
		$details = DB::table('job_statuses as js')
      ->where("js.service_id", "=", $service_id)
      ->where("js.client_id", "=", $client_id)
      ->join('jobs_steps as jstps', 'jstps.step_id', '=', 'js.status_id')
      ->whereIn("js.user_id", $groupUserId)
      ->select('jstps.title', 'js.is_completed')
      ->first();

    if(isset($details->is_completed) && $details->is_completed == 'Y'){
    	$name = 'Completed';
    }else if(isset($details->is_completed) && $details->is_completed == 'N'){
    	$name = $details->title;
    }

    return $name;
	}
    
  public static function getStatusIdByClientId($client_id, $service_id, $is_completed)
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

		$status_id = 2;
		$details = JobStatus::whereIn("user_id", $groupUserId)->where("service_id", "=", $service_id)->where("client_id","=", $client_id)->where("is_completed","=", $is_completed)->first();

        if(isset($details['status_id']) && $details['status_id'] != ''){
        	$status_id = $details['status_id'];
        }else if(isset($details->is_completed) && $details->is_completed == 'N'){
        	$status_id = 2;
        }

        return $status_id;
	}

	public static function detailsByServiceClientStatusId($service_id, $status_id, $client_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("status_id", $status_id)->where("service_id", $service_id)->where("client_id", $client_id)->get();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$status_data[$key]['job_status_id'] = $row['job_status_id'];
				$status_data[$key]['client_id'] 		= $row['client_id'];
				$status_data[$key]['service_id'] 		= $row['service_id'];
				$status_data[$key]['status_id'] 		= $row['status_id'];
				$status_data[$key]['job_manage_id'] = $row['job_manage_id'];
			}
		}
		return $status_data;
	}

	public static function statusNameByJobManageId($job_manage_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$name = 'Not Started';
		$details = DB::table('job_statuses as js')
      ->where("js.job_manage_id", $job_manage_id)
      ->join('jobs_steps as jstps', 'jstps.step_id', '=', 'js.status_id')
      ->whereIn("js.user_id", $groupUserId)
      ->select('jstps.title', 'js.is_completed')
      ->first();
    //Common::last_query();//die;

    if(isset($details->is_completed) && $details->is_completed == 'Y'){
    	$name = 'Completed';
    }else if(isset($details->is_completed) && $details->is_completed == 'N'){
    	$name = $details->title;
    }else if(isset($details->title) && $details->title != ''){
    	$name = $details->title;
    }

    return $name;
	}

	public static function statusNameByClientAndStatusId($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$name = 'Not Started';
		$details = DB::table('job_statuses as js')
      ->where("js.client_id", $client_id)->where("js.service_id", $service_id)
      ->join('jobs_steps as jstps', 'jstps.step_id', '=', 'js.status_id')
      ->whereIn("js.user_id", $groupUserId)
      ->select('jstps.title', 'js.is_completed')
      ->first();
    //Common::last_query();die;
    if(isset($details->is_completed) && $details->is_completed == 'Y'){
    	$name = 'Completed';
    }else if(isset($details->is_completed) && $details->is_completed == 'N'){
    	$name = $details->title;
    }

    $dtls = JobsManage::getFieldValue('user_id', $service_id, $client_id);
    return ($dtls == '')?'':$name;
	}

	public static function getStatusIdByJobManageId($job_manage_id)
	{
		$details = JobStatus::where("job_manage_id",$job_manage_id)->first();
		$status_id = 2;
    if(isset($details['status_id']) && $details['status_id'] != ''){
    	$status_id = $details['status_id']; 
    }

    return $status_id;
	}

	public static function getJobStatusIdByJobManageId($job_manage_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$details = JobStatus::whereIn("user_id",$groupUserId)->where("job_manage_id",$job_manage_id)->select('job_status_id')->first();
		$job_status_id = 0;
    if(isset($details['job_status_id']) && $details['job_status_id'] != ''){
    	$job_status_id = $details['job_status_id']; 
    }

    return $job_status_id;
	}

	public static function getIsCompletedByJobManageId($job_manage_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$details = JobStatus::whereIn("user_id",$groupUserId)->where("job_manage_id",$job_manage_id)->select('is_completed')->first();
		$is_completed = 'N';
    if(isset($details['is_completed']) && $details['is_completed'] != ''){
    	$is_completed = $details['is_completed']; 
    }

    return $is_completed;
	}

	public static function getDeadline($client_id,$service_id,$manage_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $deadMonth = '';
    if($service_id == 1){
    	$ret_freq      = StepsFieldsClient::getFieldValueByClientId($client_id, 'ret_frequency');
    	$ret_frequency = strtolower($ret_freq);

    	$return 		= JobsManage::getReturnDateByManageId($manage_id);
  		$retDate 		= explode('-', $return);
  		$deadMonth 	= JobStatus::getDeadlineMonth($retDate[0], $service_id, $ret_frequency);
    }
    if($service_id == 2){
    	$ecsl_freq     = StepsFieldsClient::getFieldValueByClientId($client_id, 'ecsl_freq');
    	$ecsl_frequency = strtolower($ecsl_freq);

    	$return 		= JobsManage::getReturnDateByManageId($manage_id);
  		$retDate 		= explode('-', $return);
  		$deadMonth 	= JobStatus::getDeadlineMonth($retDate[0], $service_id, $ecsl_frequency);
    }
    if($service_id == 5){
  		$date = JobsManage::getFieldValueByManageId('next_made_up_to', $manage_id);
  		$deadMonth = !empty($date)?date( 'd-m-Y', strtotime('+1 year', strtotime($date)) ):'';
  	}
  	if($service_id == 6){
  		$date = JobsAccDetail::getFieldValueByClientId('completion_date', $client_id, $service_id);
  		$deadMonth = !empty($date)?date( 'd-m-Y', strtotime($date)):'';
  	}
    if($service_id == 7){
    	$return 		= JobsManage::getReturnDateByManageId($manage_id);
  		$retDate 		= explode('/', $return);
  		$deadMonth = '31-01-20'.($retDate[1]+1);
    }
    if($service_id == 8){
  		$d = JobsNote::getFieldValueByManageId('due_date', $manage_id);
  		$m = JobsManage::getFieldValueByManageId('job_name', $manage_id);
  		$deadMonth = $d.'-'.$m.'-'.date('Y');
  	}
  	if($service_id == 9){
  		$date = StepsFieldsClient::getFieldValueByClientId($client_id, 'next_ret_due');
  		$deadMonth = !empty($date)?date('d-m-Y', strtotime($date)):'';
  	}

    return $deadMonth;
  }

  public static function getDeadlineMonth($month, $service_id, $ret_frequency)
  {

		$retMnth = '';
  	$month = strtolower($month);
  	if($month == 'jan'){
			if($service_id == 1){
  			$m = 'March';
  			$d = cal_days_in_month(CAL_GREGORIAN,3,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,2,date('Y'));
  			$m = 'February';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
		}else if($month == 'feb'){
  		if($service_id == 1){
  			$m = 'April';
  			$d = cal_days_in_month(CAL_GREGORIAN,4,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,3,date('Y'));
  			$m = 'March';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'mar'){
  		if($service_id == 1){
  			$m = 'May';
  			$d = cal_days_in_month(CAL_GREGORIAN,5,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,4,date('Y'));
  			$m = 'April';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'apr'){
  		if($service_id == 1){
  			$m = 'June';
  			$d = cal_days_in_month(CAL_GREGORIAN,6,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,5,date('Y'));
  			$m = 'May';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'may'){
  		if($service_id == 1){
  			$m = 'July';
  			$d = cal_days_in_month(CAL_GREGORIAN,7,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,6,date('Y'));
  			$m = 'June';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'jun'){
  		if($service_id == 1){
  			$m = 'August';
  			$d = cal_days_in_month(CAL_GREGORIAN,8,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,7,date('Y'));
  			$m = 'July';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'jul'){
  		if($service_id == 1){
  			$m = 'September';
  			$d = cal_days_in_month(CAL_GREGORIAN,9,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,8,date('Y'));
  			$m = 'August';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'aug'){
  		if($service_id == 1){
  			$m = 'October';
  			$d = cal_days_in_month(CAL_GREGORIAN,10,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,9,date('Y'));
  			$m = 'September';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'sep'){
  		if($service_id == 1){
  			$m = 'November';
  			$d = cal_days_in_month(CAL_GREGORIAN,11,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,10,date('Y'));
  			$m = 'October';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'oct'){
  		if($service_id == 1){
  			$m = 'December';
  			$d = cal_days_in_month(CAL_GREGORIAN,12,date('Y'));
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.date('Y'):'07-'.$m.'-'.date('Y');
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,11,date('Y'));
  			$m = 'November';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'nov'){
  		if($service_id == 1){
  			$m = 'January';
  			$y = date('Y', strtotime('+1 year'));
  			$d = cal_days_in_month(CAL_GREGORIAN,1,$y);
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.$y:'07-'.$m.'-'.$y;
  		}
  		if($service_id == 2){
  			$d = cal_days_in_month(CAL_GREGORIAN,12,date('Y'));
  			$m = 'December';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.date('Y'):'14-'.$m.'-'.date('Y');
  		}
  	}else if($month == 'dec'){
  		if($service_id == 1){
  			$m = 'February';
  			$y = date('Y', strtotime('+1 year'));
  			$d = cal_days_in_month(CAL_GREGORIAN,2,$y);
  			$retMnth = ($ret_frequency == 'yearly')?$d.'-'.$m.'-'.$y:'07-'.$m.'-'.$y;
  		}
  		if($service_id == 2){
  			$y = date('Y', strtotime('+1 year'));
  			$d = cal_days_in_month(CAL_GREGORIAN,1,$y);
  			$m = 'January';
  			$retMnth = ($ret_frequency == 'annually')?$d.'-'.$m.'-'.$y:'07-'.$m.'-'.$y;
  		}
  	}


  	return $retMnth;
  }

	public static function sendNotificationToClient($manage_id,$new_status_id,$service_id,$client_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $group_id 			= $session['group_id'];
    $user_id 				= $session['id'];

		$old_status_id 	= JobStatus::getStatusIdByJobManageId($manage_id);
		if($service_id >9){
			$DEADLINE 		= JobsAccDetail::getFieldValueByClientId('deadline_date',$client_id,$service_id);
			$data['DEADLINE'] = !empty($DEADLINE)?date('d-m-Y', strtotime($DEADLINE)):'';
		}else{
			$data['DEADLINE'] = JobStatus::getDeadline($client_id,$service_id,$manage_id);
		}

		$data['SERVICENAME'] 		= Service::getNameServiceId($service_id);  
		$data['ACTIONDATE']			= date('d-m-Y');
		//$data['JOBNAME']				= JobsManage::getReturnDateByManageId($manage_id);
		$data['JOBNAME']				= JobsManage::getJobNameByManageId($manage_id,$service_id,$client_id);
		$data['OLDSTATUSNAME'] 	= JobsStep::getStepNameByStepId($old_status_id);
		$data['NEWSTATUSNAME'] 	= JobsStep::getStepNameByStepId($new_status_id);
		$data['STAFFUSERNAME'] 	= $session['fname'].' '.$session['lname'];
		$data['PRACTICENAME'] 	= PracticeDetail::get_practice_name($group_id);
		$data['CLIENTNAME'] 		= Client::getClientNameByClientId($client_id);

		$emails 		= JobsEmail::getEmailByClientAndServiceId($client_id, $service_id);
		$checkTick 	= TaskNotification::checkTickbox($client_id, $service_id, 2);
		//echo $checkTick;die;
		$data['senderEmail'] 	= Config::get('constant.ADMINEMAIL');
		if(!empty($emails) && $checkTick >0){
			array_push($emails,$session['email']);
			$data['email'] 	= $emails;

			Mail::send('emails.task_status_change', $data, function ($message) use ($data) {
				$message->subject($data['SERVICENAME']."- Status Update -".$data['CLIENTNAME']);
				$message->from($data['senderEmail'], $data['PRACTICENAME']);
				$message->to($data['email']);
			});
		}		
	}
	

	
}
