<?php
class NotificationFrequency extends Eloquent {

 public $timestamps = false;

 public static function getDetails($service_id, $client_id)
  {
  	$data = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $details = NotificationFrequency::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->get();
    
    return NotificationFrequency::getArray($details);
  }

  public static function getDetailsByServiceAndClientId($service_id, $client_id, $position)
  {
    $data = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $details = NotificationFrequency::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->where("notification_type",$position)->first();
    
    return NotificationFrequency::getSingleArray($details);
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
        $data[$key]['repeat_day']       = $value['repeat_day'];
        $data[$key]['first_send_date']  = $value['first_send_date'];
        $data[$key]['next_send_date']   = $value['next_send_date'];
        $data[$key]['stop_reminder']    = $value['stop_reminder'];
        $data[$key]['resp_email']       = $value['resp_email'];
        $data[$key]['subject']          = $value['subject'];
        $data[$key]['message']          = $value['message'];
        $data[$key]['notification_type']= $value['notification_type'];
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
      $data['repeat_day']         = $value['repeat_day'];
      $data['first_send_date']    = $value['first_send_date'];
      $data['next_send_date']     = $value['next_send_date'];
      $data['stop_reminder']      = $value['stop_reminder'];
      $data['resp_email']         = $value['resp_email'];
      $data['subject']            = $value['subject'];
      $data['message']            = $value['message'];
      $data['notification_type']  = $value['notification_type'];
      $data['created']            = $value['created'];
    }
    return $data;
  }

  public static function getCountByClientAndServiceId($client_id, $service_id, $n_type)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $d = array();
    $JobCount  = NotificationFrequency::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->where("notification_type", $n_type)->count();
    //Common::last_query();
    return $JobCount;
  }

  public static function getRecipientEmail($service_id, $client_id)
  {
    $data = array();
    //$session        = Session::get('admin_details');
    //$user_id        = $session['id'];
    //$groupUserId    = $session['group_users'];

    $details = DB::table('notification_frequencies as nf')
      ->join('task_notifications as tn', function ($join) {
        $join->on('nf.service_id', '=', 'tn.service_id')
              ->On('nf.client_id', '=','tn.client_id');
      })
      ->where("nf.service_id", $service_id)
      ->where("nf.client_id", $client_id)
      ->where("tn.is_enable", 1)
      ->select('nf.resp_email')->first();
    //Common::last_query();
    
    if(isset($details->resp_email) && $details->resp_email != '' ){
      $data[] = $details->resp_email;
    }
    return $data;
  }


}
