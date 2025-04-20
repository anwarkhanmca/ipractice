<?php
class RenewalsManage extends Eloquent {

	public $timestamps = false;
    public static function getDetailsByClientId($client_id)
    {
        $ret_value = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $renewals = RenewalsManage::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("status", "=", 'Y')->first();
        if(isset($renewals) && count($renewals) >0){
            $ret_value["manage_id"]      = $renewals['manage_id'];
            $ret_value["user_id"]        = $renewals['user_id'];
            $ret_value["client_id"]      = $renewals['client_id'];
            $ret_value["status"]         = $renewals['status'];
            $ret_value["created"]        = $renewals['created'];
        }
        return $ret_value;
    }

	public static function updateRenewalsManage($client_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$jobs = RenewalsManage::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->first();
        $job_data["status"]    = "Y";

        if(isset($jobs) && count($jobs) >0){
            RenewalsManage::where("manage_id", $jobs['manage_id'])->update($job_data);
            $last_id = $jobs['manage_id'];
        }else{
            $job_data["user_id"]    = $user_id;
            $job_data["client_id"]  = $client_id;
            $job_data["created"]    = date('Y-m-d H:i:s');
            $last_id = RenewalsManage::insertGetId($job_data);
        }

        return $last_id;
	}

    public static function getManageRenewalsByClientId($client_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $contracts = CrmProposal::recurringProposalByClientId($client_id);
        if(isset($contracts) && count($contracts) >0){
            $where['proposal_id'] = $contracts[0]['proposal_id'];
        }
        $where['client_id'] = $client_id;

        $renewals = RenewalsManage::whereIn("user_id", $groupUserId)->where($where)->first();
        if(isset($renewals['status']) && $renewals['status'] != ""){
            $ret_value = $renewals['status'];
        }else{
            $ret_value = 'N';
        }
        return $ret_value;
    }

    public static function getRenewalsByProposalAndClientId($proposal_id, $client_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $where['proposal_id']   = $proposal_id;
        $where['client_id']     = $client_id;

        $renewals = RenewalsManage::whereIn("user_id", $groupUserId)->where($where)->first();
        if(isset($renewals['status']) && $renewals['status'] != ""){
            $ret_value = $renewals['status'];
        }else{
            $ret_value = 'N';
        }
        return $ret_value;
    }

    public static function getAllCount()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $all_count = RenewalsManage::whereIn("user_id", $groupUserId)->where("is_delete", "!=", 'Y')->where("status", 'Y')->where("is_archive", "!=", 'Y')->count();
        //Common::last_query();die;
        return $all_count;
    }

    public static function countNotStarted()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $all_count = RenewalsManage::whereIn("user_id", $groupUserId)->where("status", 'Y')->get()->count();

        $other_count = RenewalManageStatus::whereIn("user_id", $groupUserId)->where('status_id', '!=', 2)->get()->count();
        return ($all_count-$other_count);
    }

    public static function countByStatusId($status_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $other_count = RenewalManageStatus::whereIn("user_id", $groupUserId)->where('status_id', $status_id)->get()->count();
        return $other_count;
    }

    public static function countArchive()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $other_count = RenewalsManage::whereIn("user_id", $groupUserId)->where('is_delete', '!=', 'Y')->where('save_type', 'SA')->where('is_archive', 'Y')->count();
        return $other_count;
    }

    public static function countBySaveType($save_type)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = Client::getSessionUserIds();

        $status         = "IF(rm.crm_proposal_id ='0', (select save_type from renewals_manages where manage_id=rm.manage_id), (select save_type from crm_proposals where crm_proposal_id = rm.crm_proposal_id) )";

        if($save_type == 'A'){
            $whereS = "( ".$status." = 'A' OR ". $status." = 'MA') ";
        }else if($save_type == 'L'){
            $whereS = "( ". $status." = 'L' OR ". $status." = 'ML') ";
        }else{
            $whereS = $status." = '".$save_type."'";
        }

        
        $where = " WHERE ".$whereS." AND rm.is_delete != 'Y' AND rm.is_archive != 'Y' AND rm.user_id IN ('".implode(',', $groupUserId)."') ";

        $select = "SELECT count(rm.manage_id) as count FROM renewals_manages as rm";
        
        $sql_limit = $select.$where; 
        //echo $sql_limit;die;
        $od = DB::select($sql_limit);

        return $od[0]->count;
    }

    public static function getAllStatus()
    {
        $array = array('NS'=>'Not Started','D'=>'Draft','F'=>'Final','E'=>'Sent','A'=>'Accepted','L'=>'Lost');
        $i = 0;
        foreach ($array as $k => $v) {
            $data[$i]['short_name']  = $k;
            $data[$i]['status']      = $v;
            $data[$i]['count']       = RenewalsManage::countBySaveType($k);
            $i++;
        }
        /*$data[$i]['short_name']  = 'SA';
        $data[$i]['status']      = 'Show Archived';
        $data[$i]['count']       = RenewalsManage::countArchive();*/

        //echo $sql_limit;die;

        return $data;
    }

}
