<?php
class CrmProposalActivity  extends Eloquent{
	public $timestamps = false;
    public static function getProposalActivityNotesById($id)
    {
        $notes = '';
        $details = CrmProposalActivity::where('p_activity_id', $id)->select('notes')->first();
        if(isset($details->notes) && $details->notes != ''){
            $notes = $details->notes;
        }
        return $notes;
    }

    public static function getFlexFeesById($id)
    {
        $flex_fees = 0;
        $details = CrmProposalActivity::where('p_activity_id', $id)->select('flex_fees')->first();
        if(isset($details->flex_fees) && $details->flex_fees != ''){
            $flex_fees = $details->flex_fees;
        }
        return $flex_fees;
    }

    public static function getFeesById($id)
    {
        $fees = 0;
        $details = CrmProposalActivity::where('p_activity_id', $id)->select('fees')->first();
        if(isset($details->fees) && $details->fees != ''){
            $fees = $details->fees;
        }
        return $fees;
    }

    public static function getPServiceIdByPActivityId($p_activity_id)
    {
        $p_service_id = 0;
        $details = CrmProposalActivity::where('p_activity_id',$p_activity_id)->select('p_service_id')->first();
        if(isset($details->p_service_id) && $details->p_service_id != ''){
            $p_service_id = $details->p_service_id;
        }
        return $p_service_id;
    }
    public static function getTotalHrsAndFeesByPServiceId($p_service_id)
    {
        $data = array();
        $data['fees'] = DB::table('crm_proposal_activities')->where('p_service_id',$p_service_id)->sum('fees');
        return $data;
    }

    public static function getPreviewFeesByPServiceId($pServId)
    {
        $fees =CrmProposalActivity::where('p_service_id',$pServId)->where('activity_option','!=',3)->sum('fees');

        return $fees;
    }

	public static function getActitiesByPropServiceId($p_service_id, $groupUserId)
	{
        /*$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];*/
        
		$details = DB::table('crm_proposal_activities as cpa')->whereIn('cpa.user_id', $groupUserId)
	        ->where('cpa.p_service_id', '=', $p_service_id)
	        ->leftJoin('proposal_activities as pa', 'pa.activity_id', '=', 'cpa.activity_id')
	        ->select('cpa.*', 'pa.name','pa.base_fee')->orderBy('cpa.sorting', 'asc')
	        ->get();
        //Common::last_query();die;
		return CrmProposalActivity::getArray($details);
	}

	public static function checkTable( $p_service_id, $activity_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = CrmProposalActivity::whereIn('user_id', $groupUserId)->where('p_service_id', $p_service_id)->where('activity_id', $activity_id)->first();
        $count = 0;
        if(isset($details) && count($details) >0 ){
        	$count = 1;
        }
        return $count;
	}

    public static function getActivityIdByProposalServiceId( $p_service_id, $groupUserId )
    {
        $data = array();

        $details=CrmProposalActivity::whereIn('user_id',$groupUserId)->where('p_service_id',$p_service_id)->get();
        if(isset($details) && count($details) >0 ){
            $i = 0;
            foreach ($details as $k => $v) {
                $data[$i] = $v->activity_id;
                $i++;
            }
        }
        return $data;
    }

    

	/*public static function checkAlreadyAdded( $service_id, $proposal_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
        $details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
	        ->where('cpt.proposal_id', '=', $proposal_id)
	        ->leftJoin('crm_proposal_services as cps', 'cpt.id', '=', 'cps.p_table_id')
	        ->where('cps.service_id', '=', $service_id)
	        ->select('cpt.id')->first();
	    //Common::last_query();//die;

        $count = 0;
        if(isset($details) && count($details) >0 ){
        	$count = count($details);
        }
        return $count;
	}*/

    public static function getDetailsById($id)
    {
        $details = CrmProposalActivity::where('p_activity_id', $id)->first();
        return CrmProposalActivity::getSingleArray($details);
    }

	public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data["p_activity_id"]      = $value->p_activity_id;
            $data["user_id"]            = $value->user_id;
            $data["p_service_id"]       = $value->p_service_id;
            $data["activity_id"]    	= $value->activity_id;
            $data["activity_option"]    = $value->activity_option;
            $data["notes"]              = $value->notes;
            $data["sorting"]        	= $value->sorting;
            $data["flex_fees"]          = ($value->flex_fees != '0')?$value->flex_fees:'100';
            $data["fees"]               = ($value->fees != '0.00')?$value->fees:'';
            $data["is_show_fees"]       = $value->is_show_fees;
            $data["created"] 			= $value->created;
            $data["name"]               = $value->name;
        }
        return $data;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]["p_activity_id"]    = $value->p_activity_id;
                $data[$key]["user_id"]          = $value->user_id;
                $data[$key]["p_service_id"]     = $value->p_service_id;
                $data[$key]["activity_id"]      = $value->activity_id;
                $data[$key]["activity_option"]  = $value->activity_option;
                $data[$key]["notes"]            = $value->notes;
                $data[$key]["sorting"]          = $value->sorting;
                $data[$key]["flex_fees"]        = ($value->flex_fees != '0')?$value->flex_fees:'100';
                //$data[$key]["hrs"]              = ($value->hrs != '0.00')?$value->hrs:'';
                $data[$key]["fees"]             = ($value->fees != '0.00')?$value->fees:'';
                //$data[$key]["base_fee"]         = ($value->base_fee != '0.00')?$value->base_fee:'';
                $data[$key]["is_show_fees"]     = $value->is_show_fees;
                $data[$key]["created"]          = $value->created;
                $data[$key]["name"]             = $value->name;
                //$data[$key]["activities"]         = ProposalActivity::getDataByServiceAndPropServId($value->activity_id, '0', 'T');
            }
        }
        return $data;
    }

}
