<?php
class JobsEmail extends Eloquent {

	public $timestamps = false;

	public static function getIdByEmail( $email )
  {
  	$id = '';
      $data = JobsEmail::where("email",$email)->select("id")->first();
      if(isset($data['id']) && $data['id'] != ''){
      	$id = $data['id'];
	}
	return $id;
  }

  public static function getEmailById( $id )
  {
    $email = '';
    $data = JobsEmail::where("id", $id)->select("email")->first();
    if(isset($data['email']) && $data['email'] != ''){
      $email = $data['email'];
    }
    return $email;
  }

  public static function getEmailByClientAndServiceId($client_id, $service_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $data   = array();
    $emails = JobsEmail::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->select("email")->get();
    if(isset($emails) && count($emails) >0){
      foreach ($emails as $k => $v) {
        $data[$k] = $v->email;
      }
    }
    return $data;
  }

  public static function getCountByClientAndServiceId($client_id, $service_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $d = array();
    $JobCount  = JobsEmail::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->count();
    return $JobCount;
  }

  public static function getDetailsByClientAndServiceId($client_id, $service_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $d = array();
    $JobStatus  = JobsEmail::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->get();
    if(isset($JobStatus) && count($JobStatus) >0){
      foreach ($JobStatus as $key => $v) {
        $d[$key]['id']          = $v['id'];
        $d[$key]['user_id']     = $v['user_id'];
        $d[$key]['client_id']   = $v['client_id'];
        $d[$key]['service_id']  = $v['service_id'];
        $d[$key]['email']       = $v['email'];
        $d[$key]['created']     = $v['created'];
      }
    }
    return $d;
  }

  public static function sendEmail($client_id, $service_id, $job_manage_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $group_id       = $session['group_id'];

    $emails = NotificationFrequency::getRecipientEmail($service_id, $client_id);
    //echo "<pre>";print_r($emails);die;
    if(!empty($emails)){
      array_push($emails,$session['email']);
      $data['email']        = $emails;
      $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
      $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
      
      $dtls = NotificationFrequency::getDetailsByServiceAndClientId($service_id,$client_id,1);
      $data['subject']  = $dtls['subject'];
      $data['content']  = $dtls['message'];
      //echo "<pre>";print_r($data['email']);die;
      Mail::send('emails.task_send', $data, function ($message) use ($data) {
        $message->subject($data['subject']);
        $message->from($data['senderEmail'], $data['PRACTICENAME']);
        $message->to($data['email']);
      });

      /* ======== E-Reminders column in tasks tab ======== */
      JobsManage::increaseERemindersValue($job_manage_id);
    }  
  }


}
