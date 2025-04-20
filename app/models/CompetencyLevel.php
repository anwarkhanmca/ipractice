<?php
class CompetencyLevel extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $details        = CompetencyLevel::where("type", "=", "O")->where("status", "=", "Y")->get();

        if(isset($details) && count($details) >0){
            foreach ($details as $key => $details) {
                $data[$key]['level_id']     = $details->level_id;
                $data[$key]['name']         = $details->name;
                $data[$key]['type']         = $details->type;
                $data[$key]['status']       = $details->status;
                $data[$key]['created']      = $details->created;
            }
        }
        //echo "<pre>";print_r($data);echo "</pre>";die;
        return $data;
    }

    public static function getNameByLevelId($level_id)
    {
        $name = "";
        $details = CompetencyLevel::where("level_id", "=", $level_id)->first();

        if(isset($details['name']) && count($details['name'] != "")){
            $name = $details['name'];
        }
        return $name;
    }

}
