<?php
class JobsChaserEmail extends Eloquent {

 public $timestamps = false;

 public static function getDetails($service_id, $client_id)
  {
  	$data = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $details = JobsChaserEmail::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->get();
    
    return JobsChaserEmail::getArray($details);
  }

  public static function getDetailsByServiceAndClientId($service_id, $client_id)
  {
    $data = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $details = JobsChaserEmail::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->first();
    
    return JobsChaserEmail::getSingleArray($details);
  }

  public static function getDetailsById($id)
  {
    $details = JobsChaserEmail::where("id", $id)->first();
    return JobsChaserEmail::getSingleArray($details);
  }

  public static function getDetailsByJobManageId($job_manage_id)
  {
    $data = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = JobsChaserEmail::where("job_manage_id", $job_manage_id)->first();
    
    return JobsChaserEmail::getSingleArray($details);
  }


  public static function getArray($details)
  {
    $data = array();
    if(isset($details) && count($details) >0){
      foreach ($details as $key => $value) {
        $data[$key]['id']               = $value['id'];
        $data[$key]['user_id']          = $value['user_id'];
        $data[$key]['client_id']        = $value['client_id'];
        $data[$key]['service_id']       = $value['service_id'];
        $data[$key]['job_manage_id']    = $value['job_manage_id'];
        $data[$key]['repeat_day']       = $value['repeat_day'];
        $data[$key]['first_send_date']  = $value['first_send_date'];
        $data[$key]['next_send_date']   = $value['next_send_date'];
        $data[$key]['stop_date']        = date('d-m-Y', strtotime($value['stop_date']));
        $data[$key]['resp_email']       = $value['resp_email'];
        $data[$key]['subject']          = $value['subject'];
        $data[$key]['message']          = $value['message'];
        $data[$key]['created']          = $value['created'];
      }
    }
    return $data;
  }

  public static function getSingleArray($value)
  {
    $data = array();
    if(isset($value) && count($value) >0){
      $data['id']                 = $value['id'];
      $data['user_id']            = $value['user_id'];
      $data['client_id']          = $value['client_id'];
      $data['service_id']         = $value['service_id'];
      $data['job_manage_id']      = $value['job_manage_id'];
      $data['repeat_day']         = $value['repeat_day'];
      $data['first_send_date']    = $value['first_send_date'];
      $data['next_send_date']     = $value['next_send_date'];
      $data['stop_date']          = date('d-m-Y', strtotime($value['stop_date']));
      $data['resp_email']         = $value['resp_email'];
      $data['subject']            = $value['subject'];
      $data['message']            = $value['message'];
      $data['created']            = $value['created'];
    }
    return $data;
  }

  public static function getCountByClientAndServiceId($client_id, $service_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $d = array();
    $JobCount  = JobsChaserEmail::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->count();
    //Common::last_query();
    return $JobCount;
  }

  public static function getRecipientEmail($job_manage_id)
  {
    $data = array();

    $details = JobsChaserEmail::where("job_manage_id",$job_manage_id)->select("resp_email")->first();
    
    if(isset($details->resp_email) && $details->resp_email != '' ){
      $data[] = $details->resp_email;
    }
    return $data;
  }

  public static function saveChaserDetails($input)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    $userEmail      = $session['email'];

    $chaser_id = $input['chaser_id'];
    $next_send_date = date("Y-m-d",strtotime("+ ".$input['repeat_day']." days"));

    $chsData['user_id']         = $user_id;
    $chsData['client_id']       = $input['client_id'];
    $chsData['service_id']      = $input['service_id'];
    $chsData['job_manage_id']   = $input['manage_id'];
    $chsData['repeat_day']      = $input['repeat_day'];
    $chsData['first_send_date'] = date('Y-m-d');
    $chsData['next_send_date']  = $next_send_date;
    $chsData['stop_date']       = date('Y-m-d', strtotime($input['stop_date']));
    $chsData['resp_email']      = $input['resp_email'];
    $chsData['subject']         = $input['subject'];
    $chsData['message']         = $input['message'];

    if($chaser_id >0){
      JobsChaserEmail::where('id', $chaser_id)->update($chsData);
    }else{
      $chsData['created'] = date('Y-m-d');
      $chaser_id = JobsChaserEmail::insertGetId($chsData);
    }

    /* ========= Email send ========= */
    JobsChaserEmail::sendEmail($chaser_id, $user_id, $userEmail);

    return $chaser_id;
  }

  public static function sendEmail($chaser_id, $user_id, $userEmail)
  {
    /* ========= Email Start ========== */
    $details = JobsChaserEmail::getDetailsById($chaser_id);
    //Common::last_query();
    //echo "<pre>";print_r($details);die;
    if(isset($details['resp_email']) && !empty($details['resp_email'])){
      $emails = explode(';', str_replace(' ', '', $details['resp_email']) );
      if(isset($userEmail) && !empty($userEmail)){
        array_push($emails, $userEmail);
      }
      $data['email']  = $emails;
      //echo "<pre>";print_r($emails);die;

      $group_id = User::getGroupIdByUserId($user_id);
      $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
      $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
      
      $data['subject']  = $details['subject'];
      $data['content']  = $details['message'];
      //echo "<pre>";print_r($data);die;
      Mail::send('emails.task_send', $data, function ($message) use ($data) {
        $message->subject($data['subject']);
        $message->from($data['senderEmail'], $data['PRACTICENAME']);
        $message->to($data['email']);
      });
    }  
    /* ========= Email End ========== */ 

  }
  


}
