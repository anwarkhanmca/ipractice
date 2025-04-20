<?php
class TermsConditionFile extends Eloquent {

	public $timestamps = false;

	public static function getFileName()
    {
        $session      = Session::get('admin_details');
        $groupUserId  = $session['group_users'];
    	$file_name = '';
        $data = TermsConditionFile::whereId("user_id", $groupUserId)->select("file_name")->first();
        if(isset($data['file_name']) && $data['file_name'] != ''){
        	$file_name = $data['file_name'];
		}
		return $file_name;
    }

    public static function getTermsAndConditions()
    {
        $session      = Session::get('admin_details');
        $groupUserId  = $session['group_users'];
        $data = array();
        $details = TermsConditionFile::whereIn("user_id", $groupUserId)->first();
        if(isset($details) && count($details) >0){
            $data['tc_file_id'] = $details->tc_file_id;
            $data['user_id']    = $details->user_id;
            $data['user_name']  = User::getStaffNameById($details->user_id);
            $data['file_name']  = $details->file_name;
            $data['description']= $details->description;
            $data['created']    = $details->created;
            $data['added_date'] = date('d-m-Y H:i:s', strtotime($details->created));
            $data['updated']    = date('d-m-Y H:i:s', strtotime($details->updated));
        }
        return $data;
    }

    public static function getTermsAndConditionsPreview($groupUserId)
    {
        $data = array();
        $details = TermsConditionFile::whereIn("user_id", $groupUserId)->first();
        if(isset($details) && count($details) >0){
            $data['tc_file_id'] = $details->tc_file_id;
            $data['user_id']    = $details->user_id;
            $data['user_name']  = User::getStaffNameById($details->user_id);
            $data['file_name']  = $details->file_name;
            $data['description']= $details->description;
            $data['created']    = $details->created;
            $data['added_date'] = date('d-m-Y H:i:s', strtotime($details->created));
            $data['updated']    = date('d-m-Y H:i:s', strtotime($details->updated));
        }
        return $data;
    }

}
