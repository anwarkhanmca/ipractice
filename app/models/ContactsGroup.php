<?php
class ContactsGroup extends Eloquent {

	public static function getContacttype($step_id)
	{
		$type = "";
		if($step_id == 1){
			$type = "org";
		}else if($step_id == 2){
			$type = "ind";
		}else if($step_id == 3){
			$type = "staff";
		}else if($step_id == 4){
			$type = "other";
		}
		return $type;
	}

	public static function getContactsGroupByGroupId($step_id)
	{
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];
		
		$details = ContactsGroup::whereIn("user_id", $groupUserId)->where("group_id", "=", $step_id)->get();
		if(isset($details) && count($details) >0)
		{
			foreach ($details as $key => $value) {
				$data[$key]['groups_contact_id'] 	= $value->groups_contact_id;
				$data[$key]['user_id'] 				= $value->user_id;
				$data[$key]['client_id'] 			= $value->client_id;
				$data[$key]['group_id'] 			= $value->group_id;
				$data[$key]['contact_type'] 		= $value->contact_type;
				$data[$key]['created'] 				= $value->created;
			}
		}
		return $data;
	}

	public static function countByGroupId($group_id)
	{
		$session 		= Session::get('admin_details');
		$groupUserId 	= $session['group_users'];

		$count = ContactsGroup::whereIn("user_id", $groupUserId)->where("group_id", "=", $group_id)->get()->count();
		return $count;
	}

}
