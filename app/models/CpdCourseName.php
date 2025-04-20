<?php
class CpdCourseName extends Eloquent {

	public $timestamps = false;

	public static function getAllCourseName()
    {
        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $groupUserId    = $admin_s['group_users'];

        $details = CpdCourseName::WhereIn('user_id',$groupUserId)->get();
        
		return CpdCourseName::getArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['cname_id']         = $value->cname_id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['course_name']      = $value->course_name;
                $data[$key]['created']          = $value->created;
            }
        }
        return $data;
    }

    public static function getCourseNameById($cname_id)
    {
        $cname = "";
        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $groupUserId    = $admin_s['group_users'];
        
        $details = CpdCourseName::Where('cname_id', '=', $cname_id)->first();
        if(isset($details['course_name']) && $details['course_name'] != ""){
            $cname = $details['course_name'];
        }
        return $cname;
    }

}
