<?php
class JobsNote extends Eloquent {

	public $timestamps = false;
	public static function getNotesByClientAndServiceId($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobsNote::whereIn("user_id", $groupUserId)->where("client_id","=", $client_id)->where("service_id","=", $service_id)->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['jobs_notes_id'] 	= $JobStatus['jobs_notes_id'];
			$status_data['user_id'] 		= $JobStatus['user_id'];
			$status_data['client_id'] 		= $JobStatus['client_id'];
			$status_data['service_id'] 		= $JobStatus['service_id'];
			$status_data['notes'] 			= $JobStatus['notes'];
			$status_data['frequency'] 		= $JobStatus['frequency'];
			$status_data['due_date']		= $JobStatus['due_date'];  
			$status_data['job_start_date']	= $JobStatus['job_start_date'];
			$status_data['created'] 		= $JobStatus['created'];
		}
		return $status_data;
	}

	public static function getJobsNoteByJobManageId($job_manage_id)
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobsNote::whereIn("user_id",$groupUserId)->where("job_manage_id", $job_manage_id)->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['jobs_notes_id'] 	= $JobStatus['jobs_notes_id'];
			$status_data['user_id'] 				= $JobStatus['user_id'];
			$status_data['client_id'] 			= $JobStatus['client_id'];
			$status_data['service_id'] 			= $JobStatus['service_id'];
			$status_data['notes'] 					= $JobStatus['notes'];
			$status_data['frequency'] 			= $JobStatus['frequency'];
			$status_data['due_date']				= $JobStatus['due_date'];  
			$status_data['job_start_date']	= $JobStatus['job_start_date'];
			$status_data['created'] 				= $JobStatus['created'];
		}
		return $status_data;
	}

	public static function getCompletedTaskNotes($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus		= JobStatus::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->where("is_completed", "Y")->where("status_id", 10)->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['job_status_id'] 	= $JobStatus['job_status_id'];
			$status_data['user_id'] 		= $JobStatus['user_id'];
			$status_data['client_id'] 		= $JobStatus['client_id'];
			$status_data['service_id'] 		= $JobStatus['service_id'];
			$status_data['status_id']		= $JobStatus['status_id'];
			$status_data['notes'] 			= $JobStatus['notes'];
			$status_data['is_completed']	= $JobStatus['is_completed'];
			$status_data['created'] 		= $JobStatus['created'];
		}
		return $status_data;
	}

	public static function getNotesByJobManageId($job_manage_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$dtls = JobsNote::whereIn("user_id",$groupUserId)->where("job_manage_id",$job_manage_id)->select('notes')->first();
		$notes = '';
    if(isset($dtls['notes']) && $dtls['notes'] != ''){
    	$notes = $dtls['notes'];
    }

    return $notes;
	}

	public static function getFieldValueByManageId($field_name, $manage_id)
  {
    $dtls = JobsNote::where('job_manage_id', $manage_id)->select($field_name)->first();
    $data = "";
    if(isset($dtls[$field_name]) && $dtls[$field_name] != '' && $dtls[$field_name] != '0000-00-00'){
      $data = $dtls[$field_name];
    }
    return $data;
  }

	public static function clientJobNoteQuery($field_name)
	{ 
		$field = "jn.".$field_name;
		$fields = " (select ".$field." from jobs_notes as jn where jn.job_manage_id=jm.job_manage_id) ";
		return $fields;
	}

	public static function clientFieldQuery($field_name, $service_id)
	{
		$fields = " ( SELECT ".$field_name." FROM jobs_notes as jn WHERE jn.client_id=c.client_id AND jn.service_id = '".$service_id."' group by client_id ) ";
		return $fields;
	}

}
