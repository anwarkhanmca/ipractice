<?php
class ContactReport extends Eloquent {

	public $timestamps = false;

	public static function getFullDetails()
    {
        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $groupUserId    = $admin_s['group_users'];

        $details = ContactReport::get();

        //Common::last_query();die;
        $data = ContactReport::getArray($details);
		return $data;
    }

    public static function getFullDetailsByType($msg_type)
    {
        $details = ContactReport::where('msg_type', '=', $msg_type)->get();

        //Common::last_query();die;
        $data = ContactReport::getArray($details);
        return $data;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['report_id']    = $value->report_id;
                $data[$key]['user_id']      = $value->user_id;
                $data[$key]['email']        = $value->email;
                $data[$key]['name']         = $value->name;
                $data[$key]['phone']        = $value->phone;
                $data[$key]['subject']      = $value->subject;
                $data[$key]['description']  = $value->description;
                $data[$key]['file']         = $value->file;
                $data[$key]['msg_type']     = $value->msg_type;
                $data[$key]['is_view']      = $value->is_view;
                $data[$key]['created']      = date('d-m-Y', strtotime($value->created));
            }
        }
        return $data;
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data['report_id']    = $value->report_id;
            $data['user_id']      = $value->user_id;
            $data['email']        = $value->email;
            $data['name']         = $value->name;
            $data['phone']        = $value->phone;
            $data['subject']      = $value->subject;
            $data['description']  = $value->description;
            $data['file']         = $value->file;
            $data['msg_type']     = $value->msg_type;
            $data['is_view']      = $value->is_view;
            $data['created']      = date('d-m-Y', strtotime($value->created));
        }
        return $data;
    }

    public static function getDetailsById($report_id)
    {
        $cname = "";
        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $groupUserId    = $admin_s['group_users'];
        
        $details = ContactReport::Where('report_id', '=', $report_id)->first();
        $data = ContactReport::getSingleArray($details);
        return $data;
    }

}
