<?php
class LeadSource extends Eloquent {

	public $timestamps = false;
	public static function getAllLeadSource()
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
    	$i = 0;
		$data_old = LeadSource::where("status", "=", "old")->get();
		if(isset($data_old) && count($data_old) >0){
			foreach ($data_old as $key => $details) {
				$data[$i]['source_id'] 		= $details->source_id;
				$data[$i]['user_id'] 		= $details->user_id;
				$data[$i]['source_name'] 	= $details->source_name;
				$data[$i]['status'] 		= $details->status;
				$data[$i]['is_show'] 		= $details->is_show;
				$i++;
			}
		}
		$data_new = LeadSource::whereIn('user_id', $groupUserId)->where("status", "=", "new")->get();
		if(isset($data_new) && count($data_new) >0){
			foreach ($data_new as $key => $details) {
				$data[$i]['source_id'] 		= $details->source_id;
				$data[$i]['user_id'] 		= $details->user_id;
				$data[$i]['source_name'] 	= $details->source_name;
				$data[$i]['status'] 		= $details->status;
				$data[$i]['is_show'] 		= $details->is_show;
			}
		}
		//print_r($data);die;
		return $data;
    }

	public static function getOldLeadSource()
    {
    	$data = array();
		$data = LeadSource::where("status", "=", "old")->get();
		if(isset($data) && count($data) >0){
			foreach ($data as $i => $details) {
				$data[$i]['source_id'] 		= $details->source_id;
				$data[$i]['user_id'] 		= $details->user_id;
				$data[$i]['source_name'] 	= $details->source_name;
				$data[$i]['status'] 		= $details->status;
				$data[$i]['is_show'] 		= $details->is_show;
			}
		}
		//print_r($data);die;
		return $data;
    }

    public static function getNewLeadSource()
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$data = LeadSource::whereIn('user_id', $groupUserId)->where("status", "=", "new")->get();
		if(isset($data) && count($data) >0){
			foreach ($data as $i => $details) {
				$data[$i]['source_id'] 		= $details->source_id;
				$data[$i]['user_id'] 		= $details->user_id;
				$data[$i]['source_name'] 	= $details->source_name;
				$data[$i]['status'] 		= $details->status;
				$data[$i]['is_show'] 		= $details->is_show;
			}
		}
		//print_r($data);die;
		return $data;
    }

    public static function getLeadSourceName($source_id)
    {
    	$data = LeadSource::where("source_id", "=", $source_id)->select('source_name')->first();
		return $data['source_name'];
    }



}
