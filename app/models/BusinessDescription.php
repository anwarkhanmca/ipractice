<?php
class BusinessDescription  extends Eloquent{
	
	public $timestamps = false;
	public static function getAllDetails()
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $details = BusinessDescription::orderBy("description")->get();
    return BusinessDescription::getArray($details);
  }

  public static function getArray($details)
  {
    $data = array();
    if(isset($details) && count($details) >0){
      foreach ($details as $key => $value) {
        $data[$key]['id']           = $value->id;
        $data[$key]['description']  = $value->description;
        $data[$key]['industry']     = $value->industry;
        $data[$key]['code']         = $value->code;
        $data[$key]['short_desc']   = $value->short_desc;
      }
    }
    return $data;
  }

  public static function getDescByClientId($client_id)
  {
    $deac = '';
    $code = StepsFieldsClient::getFieldValueByClientId($client_id, 'business_desc');
    if(isset($code) && $code != ''){
      $deac = BusinessDescription::getDescByCode($code);
    }
    //Common::last_query();die;
    return $deac;
  }

  public static function getDescByCode($code)
  {
    $desc = 0;
    $details = BusinessDescription::where('code', $code)->select('description')->first();
    if(isset($details->description) && $details->description != ''){
      $desc = $details->description;
    }
    return $desc;
  }

  


}
