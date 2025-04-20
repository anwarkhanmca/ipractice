<?php
//use DB;
class TimeSheetReport  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;

	public static function getDetailsByEntryType($entry_type, $limit)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        if($limit == 0){
        	$details = TimeSheetReport::whereIn("user_id", $groupUserId)->where('entry_type', '=', $entry_type)->orderBy("created","desc")->get();
        }else{
        	$details = TimeSheetReport::whereIn("user_id", $groupUserId)->where('entry_type', '=', $entry_type)->orderBy("created","desc")->take($limit)->get();
        }
        
        
        return TimeSheetReport::getArray($details);
    }

    public static function checkTimeSheet($client_id, $service_id, $completed_id)
    { 
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = TimeSheetReport::whereIn("user_id", $groupUserId)->where('tasks_client_id', $client_id)->where('service_id', $service_id)->where('completed_task_id', $completed_id)->first();
        $value = 'N';
        if(isset($details) && count($details) >0){
            $value = 'Y';
        }
        return $value;
    }

    public static function getByClientIdAndServiceId( $client_id, $service_id )
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = TimeSheetReport::whereIn("user_id", $groupUserId)->where('tasks_client_id', '=', $client_id)->where('service_id', '=', $service_id)->get();
        
        return TimeSheetReport::getArray($details);
    }


	public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]["timesheet_id"]     = $value->timesheet_id;
                $data[$key]["user_id"]         	= $value->user_id;
                $data[$key]["staff_id"]     	= $value->staff_id;
                $data[$key]['staff_name'] 		= User::getStaffNameById($value->staff_id);
                $data[$key]["rel_client_id"]    = $value->rel_client_id;
                $data[$key]['client_name'] 		= Client::getClientNameByClientId($value->rel_client_id);
                $data[$key]["vat_scheme_type"]  = $value->vat_scheme_type;
                if($value->entry_type == 'T'){
                	$data[$key]["scheme_name"]  = Service::getNameServiceId( $value->vat_scheme_type );
                }else{
                	$data[$key]["scheme_name"]  = ExpenseType::getNameByExpenseId( $value->vat_scheme_type );
                }
                $data[$key]["hrs"]        		= $value->hrs;
                $data[$key]["notes"]          	= $value->notes;
                $data[$key]["entry_type"]       = $value->entry_type;
                $data[$key]["attachment"]       = $value->attachment;
                $data[$key]["created_date"] 	= date("d-m-Y", strtotime($value->created_date));
            }
        }
        return $data;
    }
	

}
