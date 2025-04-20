<?php
class CrmBillingAddress extends Eloquent {

	public $timestamps = false;

	public static function getDefaultContactAddress($client_id)
	{
		$data = array();
		$session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];

		$value = CrmBillingAddress::whereIn("user_id", $groupUserId)->where('client_id', '=', $client_id)->first();
		if(isset($value) && count($value) >0){
			$data['billing_id'] 	= $value['billing_id'];
			$data['address1'] 		= $value['address1'];
			$data['address2'] 		= $value['address2'];
			$data['city'] 			= $value['city'];
			$data['county'] 		= $value['county'];
			$data['country'] 		= $value['country'];
			$data['postcode'] 		= $value['postcode'];
			
		}
		return $data;
	}

}
