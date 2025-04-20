<?php
class Stafftask  extends Eloquent{
	
	public $timestamps = false;

	public static function getAllStafftaskTypeById( $id )
    {
        return Stafftask::select("*")->where("stafftask_id", $id)->get();
    }

    public static function getAllDetails()
    {
        $data1 = array();
        $data2 = array();

        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $data1 = Stafftask::where('status', '=', 'old')->get();
        $details1 = Stafftask::getArray($data1);
        $data2 = Stafftask::whereIn("user_id",$groupUserId)->where('status','=','new')->get();
        $details2 = Stafftask::getArray($data2);

        $details = array_merge($details1, $details2);
        return array_values($details);
    }

    public static function getNameByTaskId($task_id)
    {
    	$name = "";
        $details = Stafftask::where("stafftasks_id", '=', $task_id)->select('name')->first();
        if(isset($details['name']) && $details['name'] != ""){
        	$name = $details['name'];
        }
        return $name;
    }

    public static function getDetailsByTaskId($task_id)
    {
        $details = Stafftask::where("stafftasks_id", '=', $task_id)->first();
        return Stafftask::getSingleArray($details);
    }

	public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['stafftasks_id']  = $value->stafftasks_id;
                $data[$key]['user_id']        = $value->user_id;
                $data[$key]['staff_id']       = $value->staff_id;
                $data[$key]['for_task']       = $value->for_task;
                $data[$key]['name']  		  = $value->name;
                $data[$key]['status']         = $value->status;
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['stafftasks_id']  = $details->stafftasks_id;
            $data['user_id']        = $details->user_id;
            $data['staff_id']       = $details->staff_id;
            $data['for_task']       = $details->for_task;
            $data['name']           = $details->name;
            $data['status']         = $details->status;
        }
        return $data;
    }

}
