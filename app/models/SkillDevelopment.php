<?php
class SkillDevelopment extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $details        = SkillDevelopment::whereIn("user_id", $groupUserId)->get();

        return SkillDevelopment::getArray($details);
    }

    public static function getDetailsByAppraisalId($appraisal_id)
    {
        $details = SkillDevelopment::where("appraisal_id", '=', $appraisal_id)->get();
        return SkillDevelopment::getArray($details);
    }

    public static function getDetailsBySkillId($skill_id)
    {
        $details = SkillDevelopment::where("skill_dev_id", '=', $skill_id)->first();
        return SkillDevelopment::getSingleArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $details) {
                $data[$key]['skill_dev_id']      = $details->skill_dev_id;
                $data[$key]['user_id']           = $details->user_id;
                $data[$key]['appraisal_id']      = $details->appraisal_id;
                $data[$key]['last_perform_id']   = StaffAppraisal::getLastPerformId($details->appraisal_id);
                $data[$key]['staff_task_id']     = $details->staff_task_id;
                $data[$key]['task_name']         = Stafftask::getNameByTaskId($details->staff_task_id);
                $data[$key]['required_level']    = $details->required_level;
                $data[$key]['required_name']     = CompetencyLevel::getNameByLevelId($details->required_level);
                $data[$key]['previous_level']    = $details->previous_level;
                $data[$key]['previous_name']     = CompetencyLevel::getNameByLevelId($details->previous_level);
                $data[$key]['current_level']     = $details->current_level;
                $data[$key]['current_name']      = CompetencyLevel::getNameByLevelId($details->current_level);
                $data[$key]['supporting_notes']  = $details->supporting_notes;
                $data[$key]['developed_notes']   = $details->developed_notes;
                $data[$key]['created']           = $details->created;
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['skill_dev_id']      = $details->skill_dev_id;
            $data['user_id']           = $details->user_id;
            $data['appraisal_id']      = $details->appraisal_id;
            $data['last_perform_id']   = StaffAppraisal::getLastPerformId($details->appraisal_id);
            $data['staff_task_id']     = $details->staff_task_id;
            $data['task_name']         = Stafftask::getNameByTaskId($details->staff_task_id);
            $data['required_level']    = $details->required_level;
            $data['previous_level']    = $details->previous_level;
            $data['current_level']     = $details->current_level;
            $data['supporting_notes']  = $details->supporting_notes;
            $data['developed_notes']   = $details->developed_notes;
            $data['created']           = $details->created;
        }
        return $data;
    }

}
