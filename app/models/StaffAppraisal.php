<?php
class StaffAppraisal extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $details        = StaffAppraisal::whereIn("user_id", $groupUserId)->get();

        return StaffAppraisal::getArray($details);
    }

    public static function getDetailsByStaffId($staff_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = StaffAppraisal::whereIn("user_id", $groupUserId)->where('staff_id', '=', $staff_id)->get();

        return StaffAppraisal::getArray($details);
    }

    public static function getDetailsByAppraisalId($appraisal_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = StaffAppraisal::where('appraisal_id', '=', $appraisal_id)->first();

        return StaffAppraisal::getSingleArray($details);
    }

    public static function getLastPerformId($appraisal_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = StaffAppraisal::where('appraisal_id', '=', $appraisal_id)->select('last_perform_id')->first();
        
        return $details['last_perform_id'];
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $details) {
                $data[$key]['appraisal_id']       = $details->appraisal_id;
                $data[$key]['user_id']            = $details->user_id;
                $data[$key]['staff_id']           = $details->staff_id;
                $data[$key]['appraiser1']         = $details->appraiser1;
                $data[$key]['appraiser2']         = $details->appraiser2;
                $data[$key]['last_perform_id']    = $details->last_perform_id;
                $data[$key]['staff_name']         = User::getStaffNameById($details->staff_id);
                $data[$key]['meeting_date']       = isset($details->meeting_date)?date('d-m-Y', strtotime($details->meeting_date)):"";
                $data[$key]['meeting_time']       = $details->meeting_time;
                $data[$key]['appraisee_comment']  = $details->appraisee_comment;
                $data[$key]['appraiser_comment']  = $details->appraiser_comment;
                $data[$key]['appraisee_sign']     = $details->appraisee_sign;
                $data[$key]['appraiser_sign']     = $details->appraiser_sign;
                $data[$key]['date_time']          = $details->date_time;
                $data[$key]['is_archive']         = $details->is_archive;
                $data[$key]['created']            = $details->created;
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['appraisal_id']       = $details->appraisal_id;
            $data['user_id']            = $details->user_id;
            $data['staff_id']           = $details->staff_id;
            $data['appraiser1']         = $details->appraiser1;
            $data['appraiser2']         = $details->appraiser2;
            $data['last_perform_id']    = $details->last_perform_id;
            $data['staff_name']         = User::getStaffNameById($details->staff_id);
            $data['meeting_date']       = isset($details->meeting_date)?date('d-m-Y', strtotime($details->meeting_date)):"";
            $data['meeting_time']       = $details->meeting_time;
            $data['appraisee_comment']  = $details->appraisee_comment;
            $data['appraiser_comment']  = $details->appraiser_comment;
            $data['appraisee_sign']     = $details->appraisee_sign;
            $data['appraiser_sign']     = $details->appraiser_sign;
            $data['date_time']          = $details->date_time;
            $data['is_archive']         = $details->is_archive;
            $data['created']            = $details->created;
        }
        return $data;
    }

}
