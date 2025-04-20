<?php
class Country extends Eloquent {

	public $timestamps = false;

	public static function getAllCountry()
	{
		$data = array();
		$details = Country::orderBy('country_name')->get();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['country_id'] 	= $value['country_id'];
				$data[$key]['country_code'] = $value['country_code'];
				$data[$key]['country'] 		= $value['country'];
				$data[$key]['country_name'] = $value['country_name'];
				$data[$key]['iso3'] 		= $value['iso3'];
				$data[$key]['numcode'] 		= $value['numcode'];
				$data[$key]['phone_code'] 	= $value['phone_code'];
			}
			
		}
		return $data;
	}

	public static function getCountryNameByCountryId($country_id)
	{
		$country_name = "";
		$details = Country::where('country_id', '=', $country_id)->first();
		if(isset($details['country_name']) && $details['country_name'] != ""){
			$country_name = $details['country_name'];
		}
		return $country_name;
	}

	public static function getCountryIdByName($country_name)
	{
		$country_id = "";
		$details = Country::where('country_name', $country_name)->first();
		if(isset($details['country_id']) && $details['country_id'] != ""){
			$country_id = $details['country_id'];
		}
		return $country_id;
	}

	public static function getCountryIdByShortName($country_code)
	{
		$country_code = strtoupper(strtolower($country_code));
		$country_id = "";
		$details = Country::where('country_code', $country_code)->first();
		if(isset($details['country_id']) && $details['country_id'] != ""){
			$country_id = $details['country_id'];
		}
		return $country_id;
	}

}
