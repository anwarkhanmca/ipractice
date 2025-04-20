<?php
class JobsManageStatus extends Eloquent {

	public $timestamps = false;

    public static function getAllStatus()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $renewals = JobsManageStatus::whereIn("user_id", $groupUserId)->get();
        $data = JobsManageStatus::getArray($renewals);
        return $data;
    }

    public static function getDetailsByStatusId($status_id)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $renewals = JobsManageStatus::whereIn("user_id", $groupUserId)->where('status_id', '=', $status_id)->get();
        $data = JobsManageStatus::getArray($renewals);
        return $data;
    }

    public static function getDetailsByClientId($client_id)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $renewals = JobsManageStatus::whereIn("user_id", $groupUserId)->where('client_id', '=', $client_id)->first();
        $data = JobsManageStatus::getSingleArray($renewals);
        return $data;
    }

    public static function getSingleArray($renewals)
    {
        $data = array();
        if(isset($renewals) && count($renewals) > 0){
            $data['jobs_manage_id']   = $renewals->jobs_manage_id;
            $data['user_id']          = $renewals->user_id;
            $data['client_id']        = $renewals->client_id;
            $data['status_id']        = $renewals->status_id;
            $data['created']          = $renewals->created;
        }
        return $data;
    }

    public static function getArray($renewals)
    {
        $data = array();
        if(isset($renewals) && count($renewals) > 0){
            foreach ($renewals as $key => $value) {
                $data[$key]['jobs_manage_id']   = $value->jobs_manage_id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['client_id']        = $value->client_id;
                $data[$key]['status_id']        = $value->status_id;
                $data[$key]['created']          = $value->created;
            }
        }
        return $data;
    }

    

}
