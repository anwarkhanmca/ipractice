<?php
class AddressType extends Eloquent {

	public static function getAllAddressDetails()
	{
		$data = array();
		$contact_details = AddressType::get();
		if(isset($contact_details) && count($contact_details) >0){
			foreach ($contact_details as $key => $details1) {
				$data[$key]['address_id'] 	= $details1->address_id;
				$data[$key]['short_name'] 	= $details1->short_name;
				$data[$key]['title'] 		= $details1->title;
				$data[$key]['created'] 		= $details1->created;
			}
		}
		//print_r($data);
		return $data;
	}

}
