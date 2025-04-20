<?php
class ObjectiveTarget extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $details        = ObjectiveTarget::whereIn("user_id", $groupUserId)->get();

        return ObjectiveTarget::getArray($details);
    }

    public static function getDetailsByAppraisalId($appraisal_id)
    {
        $details = ObjectiveTarget::where("appraisal_id", '=', $appraisal_id)->get();
        return ObjectiveTarget::getArray($details);
    }

    public static function getDetailsByTargetId($target_id)
    {
        $details = ObjectiveTarget::where("target_id", '=', $target_id)->first();
        return ObjectiveTarget::getSingleArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $details) {
                $data[$key]['target_id']         = $details->target_id;
                $data[$key]['user_id']           = $details->user_id;
                $data[$key]['appraisal_id']      = $details->appraisal_id;
                $data[$key]['last_perform_id']   = StaffAppraisal::getLastPerformId($details->appraisal_id);
                $data[$key]['staff_task_id']     = $details->staff_task_id;
                $data[$key]['task_name']         = Stafftask::getNameByTaskId($details->staff_task_id);
                $data[$key]['perform_notes']     = $details->perform_notes;
                $data[$key]['measured_notes']    = $details->measured_notes;
                $data[$key]['completion_date']   = (isset($details->completion_date) && $details->completion_date != '0000-00-00')?date('d-m-Y', strtotime($details->completion_date)):'';
                $data[$key]['supporting_evidence']   = $details->supporting_evidence;
                $data[$key]['created']           = $details->created;
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['target_id']         = $details->target_id;
            $data['user_id']           = $details->user_id;
            $data['appraisal_id']      = $details->appraisal_id;
            $data['last_perform_id']   = StaffAppraisal::getLastPerformId($details->appraisal_id);
            $data['staff_task_id']     = $details->staff_task_id;
            $data['task_name']         = Stafftask::getNameByTaskId($details->staff_task_id);
            $data['perform_notes']     = $details->perform_notes;
            $data['measured_notes']    = $details->measured_notes;
            $data['completion_date']   = (isset($details->completion_date) && $details->completion_date != '0000-00-00')?date('d-m-Y', strtotime($details->completion_date)):'';
            $data['supporting_evidence']   = $details->supporting_evidence;
            $data['created']           = $details->created;
        }
        return $data;
    }

}
