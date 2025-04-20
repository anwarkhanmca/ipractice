<?php
class CorporationTaxOffice extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
	{
		$data = array();
		$details = CorporationTaxOffice::get();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['corp_tax_id'] 	= $value->corp_tax_id;
				$data[$key]['office_name'] 	= $value->office_name;
				$data[$key]['address'] 		= $value->address;
				$data[$key]['zipcode'] 		= $value->zipcode;
				$data[$key]['telephone'] 	= $value->telephone;
				$data[$key]['fax'] 			= $value->fax;
			}
			
		}
		return $data;
	}

}
