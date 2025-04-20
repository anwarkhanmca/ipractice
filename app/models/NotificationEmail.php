<?php
class NotificationEmail extends Eloquent {

	public $timestamps = false;

	public static function getNotificationEmail( $client_id, $service_id )
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
        $email = "";
    	$details = NotificationEmail::whereIn("user_id", $groupUserId)->where("service_id", '=', $service_id)->where("client_id", '=', $client_id)->first();
        if(isset($details['email']) && $details['email'] != ""){
            $email = $details['email'];
        }
        return $email;
    }
    
    public static function getDetailsByServiceId( $client_id, $service_id )
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
        $details = NotificationEmail::whereIn("user_id", $groupUserId)->where("service_id", '=', $service_id)->where("client_id", '=', $client_id)->first();
        return NotificationEmail::getSingleArray( $details );
    }
    
    public static function getSingleArray( $value )
    {
    	$data = array();
        if(isset($value) && count($value) >0){
            $data['id']         = $value['id'];
            $data['user_id']    = $value['user_id'];
            $data['client_id']  = $value['client_id'];
            $data['service_id'] = $value['service_id'];
            $data['email']      = $value['email'];
            $data['created']    = $value['created'];
        }
        return $data;
    }
    
    
    
    
    
    
}
