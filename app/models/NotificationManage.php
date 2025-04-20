<?php
class NotificationManage extends Eloquent {

	public $timestamps = false;

	public static function getNotificationView()
  {
    $data = array();
    $session      = Session::get('admin_details');
    $user_id      = $session['id'];

    $dtls = NotificationManage::where("user_id", $user_id)->get();
    if(isset($dtls) && count($dtls) >0 ){
      foreach ($dtls as $k => $v) {
        $data[$k] = $v->type;
      }
    }
    return $data;
  }

}
