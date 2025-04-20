<?php
class JobsManage extends Eloquent {

	public $timestamps = false;
  public static function getAllDetails($client_id, $service_id)
  {
    $data = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $jobs_status = JobsManage::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->where('client_id', $client_id)->first();
    //echo Common::last_query();
    if(isset($jobs_status) && count($jobs_status) >0){
      $data['job_manage_id']  = $jobs_status['job_manage_id'];
      $data["user_id"]        = $jobs_status['user_id'];
      $data["service_id"]     = $jobs_status['service_id'];
      $data["client_id"]      = $jobs_status['client_id'];
      $data["status"]         = $jobs_status['status'];
      $data["return_date"]    = $jobs_status['return_date'];
      $data["job_name"]       = $jobs_status['job_name'];
      $data["period_end"]     = date('d-m-Y', strtotime($jobs_status['period_end']));
      $data["created"]        = date('d-m-Y', strtotime($jobs_status['created']));
    }
    return $data;
  }

  public static function getDetails($client_id, $service_id, $return_date)
  {
    $data = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $jobs_status = JobsManage::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->where('client_id', $client_id)->where('return_date', $return_date)->first();
    //echo Common::last_query();
    if(isset($jobs_status) && count($jobs_status) >0){
      $data['job_manage_id']  = $jobs_status['job_manage_id'];
      $data["user_id"]        = $jobs_status['user_id'];
      $data["service_id"]     = $jobs_status['service_id'];
      $data["client_id"]      = $jobs_status['client_id'];
      $data["status"]         = $jobs_status['status'];
      $data["return_date"]    = $jobs_status['return_date'];
      $data["job_name"]       = $jobs_status['job_name'];
      $data["period_end"]     = date('d-m-Y', strtotime($jobs_status['period_end']));
      $data["created"]        = date('d-m-Y', strtotime($jobs_status['created']));
    }
    return $data;
  }

	public static function updateJobManage($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

		$jobs = JobsManage::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->first();
    $job_data["status"] = "Y";

    if(isset($jobs) && count($jobs) >0){
      JobsManage::where("job_manage_id", $jobs['job_manage_id'])->update($job_data);
      $last_id = $jobs['job_manage_id'];
    }else{
      $job_data["user_id"]    = $user_id;
      $job_data["service_id"] = $service_id;
      $job_data["client_id"]  = $client_id;
      $last_id = JobsManage::insertGetId($job_data);

      /* =============== UPDATE JOB START DATE =============== */
      JobsManage::updateJobStartDate($client_id, $service_id, $last_id);
      /* =============== UPDATE JOB START DATE =============== */

    }

    return $last_id;
	}

  public static function updateJobStartDate($client_id, $service_id, $job_manage_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    /*$days=JobsStartDate::whereIn("user_id", $groupUserId)->where("service_id", $service_id)->first();
    if(isset($days['days']) && $days['days'] != ""){
        $data["job_start_date"]    = date('Y-m-d H:i:s', strtotime("+".$days['days']." days"));
    }else{
        $data["job_start_date"]    = date("Y-m-d H:i:s");
    }*/
    $days = JobsStartDate::getJobStartDaysByServiceId( $service_id );
    $data["job_start_date"] = date('Y-m-d H:i:s', strtotime("+".$days." days"));
    
    //$starts_date = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->first();
    $starts_date = JobsNote::getJobsNoteByJobManageId($job_manage_id);

    if(isset($starts_date) && count($starts_date) >0){
      JobsNote::where("jobs_notes_id", $starts_date['jobs_notes_id'])->update($data);
      $last_id = $starts_date['jobs_notes_id'];
    }else{
      $sdata = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->where("job_manage_id", 0)->first();
      $data["frequency"]  = isset($sdata['frequency'])?$sdata['frequency']:'';
      $data["due_date"]   = isset($sdata['due_date'])?$sdata['due_date']:'';

      $data['client_id']      = $client_id;
      $data['service_id']     = $service_id;
      $data['job_manage_id']  = $job_manage_id;
      $data['user_id']        = $user_id;
      $last_id = JobsNote::insertGetId($data);
    }

  }

  public static function getTaskManagement($client_id, $service_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $jobs_status = JobsManage::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->where('client_id', $client_id)->first();
    //echo Common::last_query();
    if(isset($jobs_status['status']) && $jobs_status['status'] == "Y"){
      $status = 'Y';
    }else{
      $status = 'N';
    }
    return $status;
  }

  public static function getClientIdByServiceId($service_id)
  {
    $data   = array();
    $result = array();

    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    //echo "<pre>";print_r($groupUserId);die;
    
    $service = JobsManage::whereIn('user_id', $groupUserId)->where("service_id", $service_id)->select('client_id')->orderBy('job_manage_id', 'DESC')->get();
    if(isset($service) && count($service) >0 )
    {
      foreach ($service as $key => $row) {
        $data[$key] = $row->client_id;
      }
    }

    if($service_id == 7){
      $service1 = JobsManage::whereIn('user_id', $groupUserId)->where("service_id",10)->select('client_id')->orderBy('job_manage_id', 'DESC')->get();
      if(isset($service1) && count($service1) >0 )
      {
        foreach ($service1 as $key => $row1) {
          $result[$key] = $row1->client_id;
        }
      }
      $merge_data = array_merge($data, $result);
      $data = array_values($merge_data);
    }
    //print_r($data);die;
    return $data;
  }

  public static function getManageIdByServiceId($service_id)
  {
    $data   = array();
    $result = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    
    $service = JobsManage::whereIn('user_id', $groupUserId)->where("service_id", $service_id)->select('job_manage_id')->orderBy('job_manage_id', 'DESC')->get();
    if(isset($service) && count($service) >0 )
    {
      foreach ($service as $key => $row) {
        $data[$key] = $row->job_manage_id;
      }
    }

    if($service_id == 7){
      $service1 = JobsManage::whereIn('user_id', $groupUserId)->where("service_id",10)->select('job_manage_id')->orderBy('job_manage_id', 'DESC')->get();
      if(isset($service1) && count($service1) >0 )
      {
        foreach ($service1 as $key => $row1) {
          $result[$key] = $row1->job_manage_id;
        }
      }
      $merge_data = array_merge($data, $result);
      $data = array_values($merge_data);
    }
    //print_r($data);die;
    return $data;
  }

  public static function getCompletedClientIdByServiceId($service_id)
  {
    $data   = array();
    $result = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    
    $service = JobsCompletedTask::whereIn('user_id', $groupUserId)->where("service_id", $service_id)->select('client_id')->orderBy('task_id', 'DESC')->get();
    if(isset($service) && count($service) >0 )
    {
      foreach ($service as $key => $row) {
        $data[$key] = $row->client_id;
      }
    }

    //print_r($data);die;
    return $data;
  }

  public static function getDetailsByManageId($manage_id)
  {
    $data = array();
    $jobs_status = JobsManage::where('job_manage_id', $manage_id)->first();
    //echo Common::last_query();
    if(isset($jobs_status) && count($jobs_status) >0){
      $data['job_manage_id']  = $jobs_status['job_manage_id'];
      $data["user_id"]        = $jobs_status['user_id'];
      $data["service_id"]     = $jobs_status['service_id'];
      $data["client_id"]      = $jobs_status['client_id'];
      $data["status"]         = $jobs_status['status'];
      $data["return_date"]    = $jobs_status['return_date'];
      $data["period_end"]     = date('d-m-Y', strtotime($jobs_status['period_end']));
      $data["created"]        = date('d-m-Y', strtotime($jobs_status['created']));
    }
    return $data;
  }

  public static function jobSendToTask($client_id, $service_id)
  {
    $admin_s      = Session::get('admin_details');
    $user_id      = $admin_s['id'];

    $jobs = JobsManage::getAllDetails($client_id, $service_id);

    $data["status"]  = "Y";        
    if(isset($jobs) && count($jobs) >0){
      JobsManage::where("job_manage_id", $jobs['job_manage_id'])->update($data);
      $last_id = $jobs['job_manage_id'];
    }else{
      $data["user_id"]    = $user_id;
      $data["service_id"] = $service_id;
      $data["client_id"]  = $client_id;
      $last_id = JobsManage::insertGetId($data);

      JobsManage::updateJobStartDate($client_id, $service_id, $last_id);
    }
    return $last_id;
  }

  public static function getReturnDateByManageId($manage_id)
  {
    $return_date = '';
    $jobs_status = JobsManage::where('job_manage_id', $manage_id)->select('return_date')->first();
    //echo Common::last_query();
    if(isset($jobs_status['return_date']) && $jobs_status['return_date'] != ''){
      $return_date = $jobs_status['return_date'];
    }
    return $return_date;
  }

  public static function getJobCountByServiceId($service_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    if($service_id == 7){
      $c = JobsManage::whereIn('user_id',$groupUserId)->whereIn('service_id', [7,10])->count();
    }else{
      $c = JobsManage::whereIn('user_id',$groupUserId)->where('service_id',$service_id)->count();
    }
    return $c;
  }

  public static function getTasksStatusByServiceId($service_id)
  {
    $clientId               = JobsManage::getClientIdByServiceId($service_id);
    $Job_status             = JobStatus::getJobStatusByServiceId($service_id, $clientId);

    $data['jobs_steps']     = JobsStep::getAllJobSteps( $service_id );
    $data['all_count']      = JobsManage::getJobCountByServiceId($service_id);
    $data['not_started_count']  = $data['all_count'] - count($Job_status);

    return $data;
  }

  public static function increaseERemindersValue($job_manage_id)
  {
    JobsManage::where('job_manage_id', $job_manage_id)->update( array('e_reminders' => DB::raw('e_reminders + 1')) );
  }

  public static function AccountDateQuery($field_name, $service_id)
  {
    $fields = " ( SELECT IF(".$field_name."='0000-00-00','',DATE_FORMAT(".$field_name.",'%d-%m-%Y') ) FROM jobs_manages WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
    return $fields;
  }

  public static function getFieldValue($field_name, $service_id, $client_id)
  {
    $dtls = JobsManage::where('service_id', $service_id)->where('client_id', $client_id)->select($field_name)->first();
    $data = "";
    if(isset($dtls[$field_name]) && $dtls[$field_name] != '' && $dtls[$field_name] != '0000-00-00'){
      $data = $dtls[$field_name];
    }
    return $data;
  }

  public static function getFieldValueByManageId($field_name, $manage_id)
  {
    $dtls = JobsManage::where('job_manage_id', $manage_id)->select($field_name)->first();
    $data = "";
    if(isset($dtls[$field_name]) && $dtls[$field_name] != '' && $dtls[$field_name] != '0000-00-00'){
      $data = $dtls[$field_name];
    }
    return $data;
  }

  public static function bookKeepingStatus($client_id)
  {
    $data = array();
    $d = JobsManage::where('service_id',4)->where('client_id',$client_id)
          ->select('created', 'job_manage_id')->get();
    if(isset($d) && count($d)>0 ){
      foreach ($d as $k => $v) {
        $data[$k]['job_due_date'] = date('d-m-Y', strtotime($v->created));
        $data[$k]['status_name']  = JobStatus::statusNameByJobManageId($v->job_manage_id);
      }
    }
    return $data;
  }

  public static function ReturnDueDateQuery($service_id)
  {
    $fields = " ( SELECT IF(next_made_up_to='0000-00-00','',DATE_FORMAT(DATE_ADD(next_made_up_to, INTERVAL 1 YEAR),'%d-%m-%Y') ) FROM jobs_manages WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
    return $fields;
  }

  public static function CtCountDownQuery($service_id)
  {
    $first = " ( SELECT IF(next_made_up_to='0000-00-00','',DATE_FORMAT(DATE_ADD(next_made_up_to, INTERVAL 1 YEAR),'%Y-%m-%d') ) FROM jobs_manages WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";

    $fields = " ( SELECT IF(next_made_up_to='0000-00-00', '', DATEDIFF( ".$first." ,CURDATE() ) ) FROM jobs_manages WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";

    return $fields;
  }

  public static function getJobNameByManageId($manage_id, $service_id, $client_id)
  {
    $job_name = '';
    if($service_id == 1 || $service_id == 2){
      $job_name = JobsManage::getReturnDateByManageId($manage_id);
    }else if($service_id == 3 || $service_id == 5){
      $data       = JobsManage::getFieldValueByManageId('next_made_up_to', $manage_id);
      $job_name   = !empty($data)?date('d-m-Y', strtotime($data)):'';
    }else if($service_id == 4){
      $data       = JobsManage::getFieldValueByManageId('created', $manage_id);
      $job_name   = !empty($data)?date('d-m-Y', strtotime($data)):'';
    }else if($service_id == 6){
      $data       = JobsManage::getFieldValueByManageId('period_end', $manage_id);
      $job_name   = !empty($data)?date('d-m-Y', strtotime($data)):'';
    }else if($service_id == 7){
      $data       = JobsManage::getFieldValueByManageId('return_date', $manage_id);
      //$job_name   = !empty($data)?date('d-m-Y', strtotime($data)):'';
      $job_name   = $data;
    }else if($service_id == 8){
      $data       = JobsManage::getFieldValueByManageId('job_name', $manage_id);
      $job_name   = !empty($data)?$data.'-'.date('Y'):'';
    }else if($service_id == 9){
      //$data       = StepsFieldsClient::getLastReturnDateByClientId($client_id);
      $data       = StepsFieldsClient::getFieldValueByClientId($client_id, 'next_ret_due');
      $job_name   = !empty($data)?date( 'd-m-Y', strtotime('-14 days', strtotime($data)) ):'';
    }else if($service_id > 9){
      $job_name   = JobsAccDetail::getFieldValueByClientId('job_name', $client_id, $service_id);
    }

    return $job_name;
  }


}
