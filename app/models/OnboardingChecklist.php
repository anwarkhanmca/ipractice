<?php
class OnboardingChecklist extends Eloquent{
	
	public $timestamps = false;
    
    public static function getDetailsById( $id )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details        = OnboardingChecklist::where('onboarding_checklist_id', '=', $id)->first();
        
        return OnboardingChecklist::getSingleArray($details);
    }
    
    public static function getAllDetailsByChecklistId( $checklist_id, $table_checklist_id )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $details        = OnboardingChecklist::whereIn("user_id", $groupUserId)->where('table_checklist_id', '=', $table_checklist_id)->where('checklist_id', '=', $checklist_id)->first();
        
        return OnboardingChecklist::getSingleArray($details);
    }
    
    public static function getTotalCountByChecklistId( $checklist_id )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $count          = OnboardingChecklist::whereIn("user_id", $groupUserId)->where('table_checklist_id','=',$checklist_id)->count();
        
        return $count;
    }

    public static function getDetailsByTableChecklistId( $table_checklist_id )
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = OnboardingChecklist::whereIn("user_id", $groupUserId)->where('table_checklist_id','=',$table_checklist_id)->get();
        
        return OnboardingChecklist::getArray($details);
    }
    
    public static function getCountByStatus( $checklist_id, $status )
    {
        $session 		= Session::get('admin_details');
        $groupUserId 	= $session['group_users'];
        $count          = OnboardingChecklist::whereIn("user_id", $groupUserId)->where('status', '=', $status)->where('table_checklist_id', '=', $checklist_id)->count();
        
        return $count;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$data[$key]['onboarding_checklist_id']  = $value->onboarding_checklist_id;
                $data[$key]['user_id']                  = $value->user_id;
                $data[$key]['checklist_id']             = $value->checklist_id;
        		$data[$key]['task_owner_email']         = $value->task_owner_email;
                $data[$key]['attachment']               = $value->attachment;
        		$data[$key]['task_date']                = $value->task_date;
        		$data[$key]['notes']                    = $value->notes;
                $data[$key]['status']                   = $value->status;
                $data[$key]['created']                  = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        	}
        }
        return $data;
    }
    
    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
        	$data['onboarding_checklist_id']  = $value->onboarding_checklist_id;
            $data['user_id']                  = $value->user_id;
            $data['checklist_id']             = $value->checklist_id;
            $data['task_owner_email']         = $value->task_owner_email;
            $data['attachment']               = $value->attachment;
            $data['task_date']                = ($value->task_date != '0000-00-00')?date('d-m-Y', strtotime($value->task_date)):'';
            $data['notes']                    = $value->notes;
            $data['status']                   = $value->status;
            $data['created']                  = ($value->created != '0000-00-00')?date('d-m-Y', strtotime($value->created)):'';
        }
        return $data;
    }


}
