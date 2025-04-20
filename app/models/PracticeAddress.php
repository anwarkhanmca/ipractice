<?php
class PracticeAddress  extends Eloquent{
	public $timestamps = false;
	
	public static function getAddress($practice_id, $type)
  {
  	$details = PracticeAddress::where("practice_id", $practice_id)->where("type", $type)->first();
  	return PracticeAddress::getSingleArray($details);
  }


  public static function getSingleArray($value)
  {
    $data = array();
    if(isset($value) && count($value) >0){
    	$data["address_id"]     = $value['address_id'];
      $data["practice_id"]    = $value['practice_id'];
      $data["type"]    		    = $value['type'];
      $data["attention"]      = $value['attention'];
      $data["street_address"] = $value['street_address'];
      $data["address_line1"]  = $value['address_line1'];
      $data["address_line2"]  = $value['address_line2'];
      $data["city"]     		  = $value['city'];
      $data["state"]          = $value['state'];
      $data["zip"]        	  = $value['zip'];
      $data["country_id"]    	= $value['country_id'];
      $data["country_name"]  	= Country::getCountryNameByCountryId($value['country_id']);
    }
    return $data;
  }
	
  public static function getPracticeAddress()
  {
    $data = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $pd = PracticeDetail::whereIn("user_id", $groupUserId)->select('practice_id')->first();

    $pa = PracticeAddress::where("practice_id", $pd['practice_id'])->get();
    if(isset($pa) && count($pa) >0){    
      foreach ($pa as $pa_row) {
        $country_name = Country::getCountryNameByCountryId($pa_row->country_id);
        if ($pa_row->type == "registered") {
          $data['reg_address_id']   = $pa_row->address_id;
          $data['reg_practice_id']  = $pa_row->practice_id;
          $data['reg_type']         = $pa_row->type;
          $data['reg_attention']    = $pa_row->attention;
          $data['reg_address1']     = $pa_row->address_line1;
          $data['reg_address2']     = $pa_row->address_line2;
          $data['reg_city']         = $pa_row->city;
          $data['reg_state']        = $pa_row->state;
          $data['reg_zip']          = $pa_row->zip;
          $data['reg_country_id']   = $pa_row->country_id;
          $data['reg_country_name'] = $country_name;
        }
        if ($pa_row->type == "physical") {
          $data['phy_address_id']   = $pa_row->address_id;
          $data['phy_practice_id']  = $pa_row->practice_id;
          $data['phy_type']         = $pa_row->type;
          $data['phy_attention']    = $pa_row->attention;
          $data['phy_address1']     = $pa_row->address_line1;
          $data['phy_address2']     = $pa_row->address_line2;
          $data['phy_city']         = $pa_row->city;
          $data['phy_state']        = $pa_row->state;
          $data['phy_zip']          = $pa_row->zip;
          $data['phy_country_id']   = $pa_row->country_id;
          $data['phy_country_name'] = $country_name;
        }
      }
    }

    return $data;
  }




}
