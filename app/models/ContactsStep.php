<?php
class ContactsStep extends Eloquent {

	public $timestamps = false;

	public static function getAllSteps($org_count, $ind_count, $staff_count, $other_count,$groups_count)
	{
		$data1 = array();
		$data2 = array();
		$step_custom = array();
		$step_default = array();
		$contact_count = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];
		$contact_count['org'] 	= $org_count;
		$contact_count['ind'] 	= $ind_count;
		$contact_count['staff'] = $staff_count;
		$contact_count['other'] = $other_count;
        $contact_count['groups'] = $groups_count;

		$step_default = ContactsStep::where("user_id", "=", 0)->get();
		if(isset($step_default) && count($step_default) >0){
			foreach ($step_default as $key => $details1) {
				$data1[$key]['step_id'] 		= $details1->step_id;
				$data1[$key]['user_id'] 		= $details1->user_id;
				$data1[$key]['shorting_id'] 	= $details1->shorting_id;
				$data1[$key]['short_code'] 		= $details1->short_code;
				$data1[$key]['title'] 			= $details1->title;
				$data1[$key]['status'] 			= $details1->status;
				$data1[$key]['step_type'] 		= $details1->step_type;
				$data1[$key]['created'] 		= $details1->created;
				$data1[$key]['count'] 			= ContactsStep::count_contact($details1->short_code, $contact_count);
			}
		}

		$step_custom = ContactsStep::whereIn("user_id", $groupUserId)->get();
		if(isset($step_custom) && count($step_custom) >0){
			foreach ($step_custom as $key => $details2) {
				$data2[$key]['step_id'] 		= $details2->step_id;
				$data2[$key]['user_id'] 		= $details2->user_id;
				$data2[$key]['shorting_id'] 	= $details2->shorting_id;
				$data2[$key]['short_code'] 		= $details2->short_code;
				$data2[$key]['title'] 			= $details2->title;
				$data2[$key]['status'] 			= $details2->status;
				$data2[$key]['step_type'] 		= $details2->step_type;
				$data2[$key]['created'] 		= $details2->created;
				$data2[$key]['count'] 			= "";
			}
		}
		$data = array_merge($data1, $data2);
		//print_r($data);die;
		return array_values($data);
	}

	public static function count_contact($short_code, $contact_count)
	{
		$count = 0;
		if($short_code == "org"){
			$count = $contact_count['org'];
		}else{
			$count = "";
		}
		return $count;
	}

	public static function getAllNewGroupDetails()
	{
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

		$steps 	= ContactsStep::whereIn("user_id", $groupUserId)->where('step_type', '=', 'new')->get();
		$data 	= ContactsStep::getArray($steps);
		if(isset($data) && count($data) >0){
			foreach ($data as $key => $details) {
				$data[$key]['created_by'] = User::getStaffNameById($details['user_id']);
				$data[$key]['count'] 	= ContactsGroup::countByGroupId($details['step_id']);
			}
		}
		//print_r($data);die;
		return $data;
	}

	public static function getStepNameById($step_id)
	{
		$value = "";
		$data 	= ContactsStep::where("step_id", $step_id)->select('title')->first();
		if(isset($data['title']) && $data['title'] != ""){
			$value = $data['title'];
		}
		return $value;
	}

	public static function getArray($steps)
	{
		$data = array();
		if(isset($steps) && count($steps) >0){
			foreach ($steps as $key => $details2) {
				$data[$key]['step_id'] 		= $details2->step_id;
				$data[$key]['user_id'] 		= $details2->user_id;
				$data[$key]['shorting_id'] 	= $details2->shorting_id;
				$data[$key]['short_code'] 	= $details2->short_code;
				$data[$key]['title'] 		= $details2->title;
				$data[$key]['status'] 		= $details2->status;
				$data[$key]['step_type'] 	= $details2->step_type;
				$data[$key]['created'] 		= $details2->created;
			}
		}
		return $data;
	}

}
