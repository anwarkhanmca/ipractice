<?php
class ChecklistTable extends Eloquent{
	
	public $timestamps = false;
    
    public static function getChecklistById( $checklist_id )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details        = ChecklistTable::where('checklist_id', '=', $checklist_id)->first();
        
        return ChecklistTable::getSingleArray($details);
    }
    
    public static function getChecklistByCheckId( $custom_check_id )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details        = ChecklistTable::whereIn("user_id", $groupUserId)->where('custom_check_id', '=', $custom_check_id)->orderBy('checklist_id', 'desc')->get();
        
        return ChecklistTable::getArray($details);
    }

    public static function getAllChecklist()
    {
    	$data = array();
    	$session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details = ChecklistTable::whereIn("user_id", $groupUserId)->get();
        return ChecklistTable::getArray($details);
    }
    
    public static function getPercentageCompleted($checklist_id)
    {
        $done_count = OnboardingChecklist::getCountByStatus( $checklist_id, 'D' );
        $all_count  = OnboardingChecklist::getTotalCountByChecklistId( $checklist_id );
        if($all_count == 0){
            $average = 0;
        }else{
            $average = ($done_count*100)/$all_count;
        }
        return number_format($average, 2);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$data[$key]['checklist_id']     = $value->checklist_id;
                $data[$key]['custom_check_id'] 	= $value->custom_check_id;
        		$data[$key]['user_id']          = $value->user_id;
        		$data[$key]['name']             = $value->name;
        		$data[$key]['status']           = $value->status;
                $data[$key]['reminddays']       = $value->reminddays;
        		$data[$key]['notes']            = $value->notes;
                $data[$key]['created']          = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        	}
        }
        return $data;
    }
    
    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
        	$data['checklist_id']     = $value->checklist_id;
            $data['custom_check_id']  = $value->custom_check_id;
            $data['user_id']          = $value->user_id;
            $data['name']             = $value->name;
            $data['status']           = $value->status;
            $data['reminddays']       = (isset($value->reminddays) && $value->reminddays !='0')?$value->reminddays:'0';
        	$data['notes']            = $value->notes;
            $data['created']          = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        }
        return $data;
    }


}
