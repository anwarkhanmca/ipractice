<?php
class PracticeDetail  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;

	public static function get_practice_name($group_id)
	{
		$name = "";
		$groupUserId    = Common::getUserIdByGroupId($group_id);
        $details 		= PracticeDetail::whereIn("user_id", $groupUserId)->first();
        if(isset($details['display_name']) && $details['display_name'] != ""){
        	$name = $details['display_name'];
        }
		return $name;
	}
    
    public static function getPracticeDetails($groupUserId)
	{
		$details = PracticeDetail::whereIn("user_id", $groupUserId)->first();
        
		return PracticeDetail::getSingleArray($details);
	}

    public static function getPracticeDetailsData()
    {
        $session = Session::get('admin_details');
        $groupUserId        = $session['group_users'];
        
        $details        = PracticeDetail::whereIn("user_id", $groupUserId)->first();
        
        return PracticeDetail::getSingleArray($details);
    }

    public static function getPracticeDetailsPreview($groupUserId)
    {
        $details = PracticeDetail::whereIn("user_id", $groupUserId)->first();
        return PracticeDetail::getSingleArray($details);
    }

    public static function getPracticeDetailsByUserId( $user_id )
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        
        $details        = PracticeDetail::whereIn("user_id", $groupUserId)->first();
        
        return PracticeDetail::getSingleArray($details);
    }
    
    
  public static function getSingleArray($value)
  {
    $data = array();
    if(isset($value) && count($value) >0){
      $data["practice_id"]      = $value['practice_id'];
      $data["user_id"]          = $value['user_id'];
      $data["practice_logo"]    = $value['practice_logo'];
      $data["crm_branding_logo"]= $value['crm_branding_logo'];
      $data["display_name"]     = $value['display_name'];
      $data["legal_name"]       = $value['legal_name'];
      $data["registration_no"]  = $value['registration_no'];
      $data["telephone_no"]     = $value['telephone_no'];
      $data["fax_no"]           = $value['fax_no'];
      $data["mobile_no"]        = $value['mobile_no'];
      $data["practiceemail"]    = $value['practiceemail'];
      $data["practicewebsite"]  = $value['practicewebsite'];
      $data["crm_manual_color"] =!empty($value['crm_manual_color'])?$value['crm_manual_color']:'#0866C6';
      $data["crm_auto_color"]   = $value['crm_auto_color'];
      $data["use_color"]        = $value['use_color'];
      $data["phyAddr"]          = PracticeAddress::getAddress($value['practice_id'], 'physical');
    }
    return $data;
  }

  public static function getBrandingColor($groupUserId)
  {
      $details  = PracticeDetail::whereIn("user_id", $groupUserId)->select('use_color', 'crm_auto_color', 'crm_manual_color')->first();
      if(isset($details->use_color) && $details->use_color == 'A'){
          $color = $details->crm_auto_color;
      }else if(isset($details->use_color) && $details->use_color == 'M'){
          $color = $details->crm_manual_color;
      }else{
          $color = '#12A5F4';
      }
      return $color;
  }

  public static function getBrandingLogo($groupUserId)
  {
    $details  = PracticeDetail::whereIn("user_id", $groupUserId)->select('practice_logo','crm_branding_logo')->first();
    $logo = '';
    if(isset($details->crm_branding_logo) && $details->crm_branding_logo != ''){
      $logo = $details->crm_branding_logo;
    }
    return $logo;
  }

  public static function getAddressByType($type)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $pd = PracticeDetail::whereIn("user_id", $groupUserId)->select('practice_id')->first();

    $pa = PracticeAddress::where("practice_id", $pd['practice_id'])->where('type', $type)->first();

    $fullphyaddress = "";
    if (!empty($pa['address_line1']) ){
      $fullphyaddress .= $pa['address_line1'].',';
    }
    if (!empty($pa['address_line2']) ){
        $fullphyaddress .= $pa['address_line2'].',';
    }
    if (isset($pa['city']) ){
        $fullphyaddress .= $pa['city'].',';
    }
    if (isset($pa['state']) ){
        $fullphyaddress .= $pa['state'];
    }
    return $fullphyaddress;
  }

    

    

    public static function getGeneralPlaceHolder()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $a = array();
        $d = PracticeDetail::whereIn("user_id", $groupUserId)->first();
        $type = OrganisationType::where("organisation_id", "=", $d->organisation_type_id)->first();

        $a['p_display_name']    = !empty($d['display_name'])?$d['display_name']:'';
        $a['p_legal_name']      = !empty($d['legal_name'])?$d['legal_name']:'';
        $a['p_reg_number']      = !empty($d['registration_no'])?$d['registration_no']:'';
        $a['p_org_type']        = $type['name'];
        $a['p_agentId_paye']    = (isset($d['agentpaye']) && $d['agentpaye']!='')?$d['agentpaye']:'';
        $a['p_agentId_vat']     = (isset($d['agentsa']) && $d['agentsa']!='')?$d['agentsa']:'';
        $a['p_agentId_ct']      = (isset($d['agentct']) && $d['agentct']!='')?$d['agentct']:'';
        $a['p_telephone']       = !empty($d['telephone_no'])?$d['telephone_no']:'';
        $a['p_fax']             = !empty($d['fax_no'])?$d['fax_no']:'';
        $a['p_mobile']          = !empty($d['mobile_no'])?$d['mobile_no']:'';
        $a['p_email']           = !empty($d['practiceemail'])?$d['practiceemail']:'';
        $a['p_website']         = !empty($d['practicewebsite'])?$d['practicewebsite']:'';
        $a['p_skype']           = !empty($d['practiceskype'])?$d['practiceskype']:'';


        $addresses = PracticeAddress::where("practice_id", $d['practice_id'])->get();
        foreach ($addresses as $pa_row) {
            $country_name = Country::getCountryNameByCountryId($pa_row->country_id);
            $address = $pa_row->address_line1.'<br>'.$pa_row->address_line2.'<br>'.$pa_row->city.'<br>'.$pa_row->state.'<br>'.$pa_row->zip.'<br>'.$country_name;
            if ($pa_row->type == "registered") {
                $a['p_reg_ofc_line1']   = $pa_row->address_line1;
                $a['p_reg_ofc_line2']   = $pa_row->address_line2;
                $a['p_reg_office_addr'] = trim($address);
                $a['p_reg_ofc_town']    = $pa_row->city;
                $a['p_reg_ofc_region']  = $pa_row->state;
                $a['p_reg_postcode']    = $pa_row->zip;
                $a['p_reg_country']     = $country_name;
            }
            if ($pa_row->type == "physical") {
                $a['p_corres_addr1']    = $pa_row->address_line1;
                $a['p_corres_addr2']    = $pa_row->address_line2;
                $a['p_corres_addr']     = trim($address);
                $a['p_coress_town']     = $pa_row->city;
                $a['p_corres_region']   = $pa_row->state;
                $a['p_corres_postcode'] = $pa_row->zip;
                $a['p_corres_country']  = $country_name;
            }
        }

        return $a;

    }

}








