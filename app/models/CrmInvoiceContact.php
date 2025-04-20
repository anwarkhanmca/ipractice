<?php
class CrmInvoiceContact extends Eloquent 
{
  public $timestamps = false;
	public static function getAllRecords()
  {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $details    = CrmInvoiceContact::whereIn("user_id", $groupUserId)->get();
      //echo Common::last_query();die;
      $data       = CrmInvoiceContact::getArray($details);
      return $data;
  }

  public static function getDetailsByClientId($client_id)
  {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $details    = CrmInvoiceContact::whereIn("user_id", $groupUserId)->where('client_id', '=', $client_id)->first();
      //echo Common::last_query();die;
      $data       = CrmInvoiceContact::getSingleArray($details);
      return $data;
  }

  public static function getSingleArray($val)
  {
    $data = array();
    if(isset($val) && count($val) >0){
      $data['crm_contact_id']    = isset($val->crm_contact_id)?$val->crm_contact_id:'';
      $data['user_id']           = isset($val->user_id)?$val->user_id:'';
      $data['client_id']         = isset($val->client_id)?$val->client_id:'';
      $data['cont_client_id']    = isset($val->cont_client_id)?$val->cont_client_id:'';
      $data['cont_addr_type']    = isset($val->cont_addr_type)?$val->cont_addr_type:'';
      $data['created']           = date('d-m-Y', strtotime($val->created));
    }
    return $data;
  }

  public static function getArray($details)
  {
    $data = array();
    if(isset($details) && count($details) >0){
      foreach ($details as $k => $val) {
        $data[$k]['crm_contact_id']   = isset($val->crm_contact_id)?$val->crm_contact_id:'';
        $data[$k]['user_id']          = isset($val->user_id)?$val->user_id:'';
        $data[$k]['client_id']        = isset($val->client_id)?$val->client_id:'';
        $data[$k]['cont_client_id']   = isset($val->cont_client_id)?$val->cont_client_id:'';
        $data[$k]['cont_addr_type'] = isset($val->cont_addr_type)?$val->cont_addr_type:'';
        $data[$k]['created']          = date('d-m-Y', strtotime($val->created));
      }
    }
    return $data;
  }
}
