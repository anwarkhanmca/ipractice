<?php
class AllocationHeading  extends Eloquent{
	
	public $timestamps = false;
	public static function getOldHeading()
  {
  	$array = array();
		$details = AllocationHeading::where("status", 'O')->get();
		return AllocationHeading::getArray($details);
  }

  public static function getHeadingNameById($id)
  {
  	$heading = '';
  	$details = AllocationHeading::where('alloc_head_id', $id)->select('heading')->first();
    if(isset($details->heading) && $details->heading != ''){
        $heading = $details->heading;
    }
    return $heading;
  }

  public static function getHeadingByCurrentUserId()
  {
  	$array = array();
  	$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

		$details = AllocationHeading::whereIn("user_id", $groupUserId)->get();
		return AllocationHeading::getArray($details);
  }

  public static function checkHeading()
  {
  	$array = array();
  	$session 		= Session::get('admin_details');
	$user_id 		= $session['id'];
	$groupUserId 	= $session['group_users'];

	$count = AllocationHeading::whereIn("user_id", $groupUserId)->count();
	return $count;
  }

  public static function getArray($details)
	{
		$data = array();

		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$heading = explode('/', $value['heading']);
				$data[$key]['alloc_head_id'] 	= $value['alloc_head_id'];
				$data[$key]['user_id'] 			= $value['user_id'];
				$data[$key]['client_id'] 		= $value['client_id'];
				$data[$key]['service_id'] 		= $value['service_id'];
				$data[$key]['heading'] 			= $value['heading'];
				$data[$key]['tableHeading'] 	= trim($heading[0]);
				$data[$key]['status'] 			= $value['status'];
				$data[$key]['created'] 			= $value['created'];
			}
		}
		return $data;
	}

}
