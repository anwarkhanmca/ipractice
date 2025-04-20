<?php
class CrmColorDetect extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $details = CrmColorDetect::whereIn("user_id", $groupUserId)->get();

        return CrmColorDetect::getArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['auto_detect_id']   = $value->auto_detect_id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['color_code']       = $value->color_code;
                $data[$key]['percentage']       = $value->percentage;
                $data[$key]['created']          = $value->created;
            }
        }
        return $data;
    }

}
