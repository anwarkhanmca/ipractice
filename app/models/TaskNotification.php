<?php
class TaskNotification extends Eloquent {

	public $timestamps = false;

	public static function getColourStatus( $client_id, $service_id, $is_enable )
  {
  	$data = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    
    $details = TaskNotification::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->where("is_enable", $is_enable)->get();
    if(isset($details) && count($details) >0){
    	foreach ($details as $key => $value) {
        $data['id']                 = $value->id;
        $data['user_id']            = $value->user_id;
        $data['client_id']          = $value->client_id;
        $data['service_id']         = $value->service_id;
        $data['is_notification']    = $value->is_notification;
        $data['is_enable']          = $value->is_enable;
        $data['created']            = $value->created;
      }
    }
	  return $data;
  }

  public static function checkTickbox( $client_id, $service_id, $is_enable )
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    
    $count = TaskNotification::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->where("is_enable", $is_enable)->count();
    return $count;
  }

}
