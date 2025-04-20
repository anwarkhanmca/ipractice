<?php
class ProposalActivity  extends Eloquent{
	
	public $timestamps = false;
	public static function getDataByServiceAndPropServId($service_id, $prop_serv_id, $type)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

		if($type == 'T'){
			$details = ProposalActivity::whereIn('user_id', $groupUserId)->where('service_id','=',$service_id)->where('service_type','=',$type)->get();//Common::last_query();
		}else{
			$details = ProposalActivity::whereIn('user_id', $groupUserId)->where('prop_serv_id','=',$prop_serv_id)->where('service_type','=',$type)->get();
		}
		
		return ProposalActivity::getArray($details);
	}

    public static function getDataByServiceId($service_id)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details =ProposalActivity::whereIn('user_id',$groupUserId)->where('service_id',$service_id)->get();
        
        return ProposalActivity::getArray($details);
    }

    public static function getBaseFeeById($id)
    {
        $base_fee = 0;
        $details = ProposalActivity::where('activity_id',$id)->select('base_fee')->first();
        if(isset($details->base_fee) && $details->base_fee != ''){
            $base_fee = $details->base_fee;
        }
        return $base_fee;
    }

    public static function getActivityNameByActivityIds( $actIds )
    {
        $data = array();
        $ids = explode(',', $actIds);
        $i = 0;
        if(isset($ids) && count($ids) >0){
            foreach ($ids as $k => $v) {
                $details = ProposalActivity::where('activity_id',$v)->select('name')->first();
                if(isset($details->name) && $details->name != '' ){
                    $data[$i] = $details->name;
                    $i++;
                }
            }
        }
        
        return $data;
    }

	public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
            	$data[$key]["activity_id"]     	= $value->activity_id;
            	$data[$key]["user_id"]         	= $value->user_id;
                $data[$key]["service_id"]      	= $value->service_id;
                $data[$key]["prop_serv_id"]     = $value->prop_serv_id;
                $data[$key]["name"]    			= $value->name;
                $data[$key]["base_fee"]         = $value->base_fee;
                $data[$key]["service_type"]     = $value->service_type;
                $data[$key]["is_archive"]       = $value->is_archive;
                $data[$key]["created"]          = $value->created;
            }
        }
        return $data;
    }

}
