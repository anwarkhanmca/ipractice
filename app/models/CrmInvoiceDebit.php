<?php
class CrmInvoiceDebit extends Eloquent 
{
  public $timestamps = false;
	public static function getAllRecords()
  {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];

      $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('is_deleted', '!=', 'Y')->get();
      //echo Common::last_query();die;
      $data       = CrmInvoiceDebit::getArray($details);
      return $data;
  }

  public static function invoice_by_contactid($contact_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('ContactID', '=', $contact_id)->where('is_deleted', '!=', 'Y')->get();
    $data       = CrmInvoiceDebit::getArray($details);
    return $data;
  }

  public static function name_by_invoiceid($invoice_id)
  {
      $name = "";
      $details    = CrmInvoiceDebit::where('crm_invoice_id', '=', $invoice_id)->where('is_deleted', '!=', 'Y')->first();
      $data       = CrmInvoiceDebit::getSingleArray($details);
      if(isset($data['Name']) && $data['Name'] != "")
        $name = $data['Name'];
      return $name;
  }

  public static function InvoiceByContactAndInvoiceNo($contact_id, $invoice_no)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    $data     = array();
    $details  = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('ContactID', '=', $contact_id)->where('InvoiceNumber', '=', $invoice_no)->first();
    $data     = CrmInvoiceDebit::getSingleArray($details);
    return $data;
  }

  public static function name_by_contactid($contact_id)
  {
    $name = "";
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('ContactID', '=', $contact_id)->where('is_deleted', '!=', 'Y')->first();
    $data       = CrmInvoiceDebit::getSingleArray($details);
    if(isset($data['Name']) && $data['Name'] != "")
      $name = $data['Name'];
    return $name;
  }

  public static function details_by_Mergedid($merged_id)
  {
    $data = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('merged_client_id', '=', $merged_id)->where('is_deleted', '!=', 'Y')->first();
    $data       = CrmInvoiceDebit::getSingleArray($details);
    return $data;
  }

  public static function invoice_by_id($id)
  {
      $details    = CrmInvoiceDebit::where('crm_invoice_id', '=', $id)->where('is_deleted', '!=', 'Y')->first();
      $data       = CrmInvoiceDebit::getSingleArray($details);
      return $data;
  }

  public static function invoice_groupby_contactid()
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    $details = CrmInvoiceDebit::groupBy('ContactID')->whereIn("user_id", $groupUserId)->where('is_deleted', '!=', 'Y')->get();
    //echo Common::last_query();die;
    $data       = CrmInvoiceDebit::getArray($details);
    return $data;
  }

  public static function AutocollectByContactId($contact_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $auto_collect = 'N';
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('ContactID', '=', $contact_id)->where('is_deleted', '!=', 'Y')->first();
    $data       = CrmInvoiceDebit::getSingleArray($details);
    if(isset($data) && count($data) >0){
        $auto_collect = $data['auto_collect'];
    }
    return $auto_collect;
  }

  public static function totalCollected($contact_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $total      = 0;
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('ContactID', '=', $contact_id)->where('is_deleted', '!=', 'Y')->get();
    $data       = CrmInvoiceDebit::getArray($details);
    if(isset($data) && count($data) >0){
        foreach ($data as $key => $value) {
            $total += $value['ToBeCollected'];
        }
    }
    return $total;
  }

  public static function totalAmount($contact_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $total      = 0;
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('ContactID', '=', $contact_id)->where('is_deleted', '!=', 'Y')->get();
    $data       = CrmInvoiceDebit::getArray($details);
    if(isset($data) && count($data) >0){
        foreach ($data as $key => $value) {
            $total += $value['AmountDue'];
        }
    }
    return $total;
  }

  public static function contactIdByMergeId($client_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $contact_id = 0;
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->where('merged_client_id', '=', $client_id)->where('is_deleted', '!=', 'Y')->first();
    $data       = CrmInvoiceDebit::getSingleArray($details);
    if(isset($data) && count($data) >0){
        $contact_id = $data['ContactID'];
    }
    return $contact_id;
  }

  public static function detailsByMergeClientId($client_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    
    $contact_id = 0;
    $details    = CrmInvoiceDebit::groupBy('ContactID')->whereIn("user_id", $groupUserId)->where('merged_client_id', '=', $client_id)->where('is_deleted', '!=', 'Y')->first();
    $data       = CrmInvoiceDebit::getSingleArray($details);
    return $data;
  }

  public static function getToBeCollected($inv_nos)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    
    $details    = CrmInvoiceDebit::whereIn("user_id", $groupUserId)->whereIn("InvoiceNumber", $inv_nos)->where('is_deleted', '!=', 'Y')->get();
    $data       = CrmInvoiceDebit::getArray($details);
    return $data;
  }

  public static function getSingleArray($val)
  {
    $data = array();
    if(isset($val) && count($val) >0){
      $data['crm_invoice_id']  = isset($val->crm_invoice_id)?$val->crm_invoice_id:'';
      $data['ContactID']       = isset($val->ContactID)?$val->ContactID:'';
      $data['user_id']         = isset($val->user_id)?$val->user_id:'';
      $data['merged_client_id']= isset($val->merged_client_id)?$val->merged_client_id:'';
      $data['Name']            = isset($val->Name)?$val->Name:'';
      $data['Date']            = isset($val->Date)?date('d-m-Y', strtotime($val->Date)):'';
      $data['DueDate']         = isset($val->DueDate)?date('d-m-Y', strtotime($val->DueDate)):'';
      $data['BrandingThemeID'] = isset($val->BrandingThemeID)?$val->BrandingThemeID:'';
      $data['Status']          = isset($val->Status)?$val->Status:'';
      $data['LineAmountTypes'] = isset($val->LineAmountTypes)?$val->LineAmountTypes:'';
      $data['SubTotal']        = isset($val->SubTotal)?$val->SubTotal:'0';
      $data['TotalTax']        = isset($val->TotalTax)?$val->TotalTax:'0';
      $data['Total']           = isset($val->Total)?$val->Total:'0';
      $data['UpdatedDateUTC']  = isset($val->UpdatedDateUTC)?$val->UpdatedDateUTC:'';
      $data['CurrencyCode']    = isset($val->CurrencyCode)?$val->CurrencyCode:'';
      $data['Type']            = isset($val->Type)?$val->Type:'';
      $data['InvoiceID']       = isset($val->InvoiceID)?$val->InvoiceID:'';
      $data['InvoiceNumber']   = isset($val->InvoiceNumber)?$val->InvoiceNumber:'';
      $data['Reference']       = isset($val->Reference)?$val->Reference:'';
      $data['AmountDue']       = isset($val->AmountDue)?$val->AmountDue:'0';
      $data['AmountPaid']      = isset($val->AmountPaid)?$val->AmountPaid:'0';
      $data['AmountCredited']  = isset($val->AmountCredited)?$val->AmountCredited:'0';
      $data['SentToContact']   = isset($val->SentToContact)?$val->SentToContact:'';
      $data['CurrencyRate']    = isset($val->CurrencyRate)?$val->CurrencyRate:'';
      $data['HasAttachments']  = isset($val->HasAttachments)?$val->HasAttachments:'';
      $data['ToBeCollected']   = isset($val->ToBeCollected)?$val->ToBeCollected:'0';
      $data['collection_date'] = (isset($val->collection_date) && $val->collection_date != "0000-00-00")?date('d-m-Y', strtotime($val->collection_date)):'';
      $data['EmailAddress']    = isset($val->EmailAddress)?$val->EmailAddress:'';
      $data['auto_collect']    = isset($val->auto_collect)?$val->auto_collect:'N';
      $data['is_deleted']      = isset($val->is_deleted)?$val->is_deleted:'N';
      $data['created']         = date('d-m-Y', strtotime($val->created));
    }
    return $data;
  }

  public static function getArray($details)
  {
    $data = array();
    if(isset($details) && count($details) >0){
      foreach ($details as $k => $val) {
        $data[$k]['crm_invoice_id']  = isset($val->crm_invoice_id)?$val->crm_invoice_id:'';
        $data[$k]['ContactID']       = isset($val->ContactID)?$val->ContactID:'';
        $data[$k]['user_id']         = isset($val->user_id)?$val->user_id:'';
        $data[$k]['merged_client_id']= isset($val->merged_client_id)?$val->merged_client_id:'';
        $data[$k]['Name']            = isset($val->Name)?$val->Name:'';
        $data[$k]['Date']            = isset($val->Date)?date('d-m-Y', strtotime($val->Date)):'';
        $data[$k]['DueDate']         = isset($val->DueDate)?date('d-m-Y', strtotime($val->DueDate)):'';
        $data[$k]['BrandingThemeID'] = isset($val->BrandingThemeID)?$val->BrandingThemeID:'';
        $data[$k]['Status']          = isset($val->Status)?$val->Status:'';
        $data[$k]['LineAmountTypes'] = isset($val->LineAmountTypes)?$val->LineAmountTypes:'';
        $data[$k]['SubTotal']        = isset($val->SubTotal)?$val->SubTotal:'0';
        $data[$k]['TotalTax']        = isset($val->TotalTax)?$val->TotalTax:'0';
        $data[$k]['Total']           = isset($val->Total)?$val->Total:'';
        $data[$k]['UpdatedDateUTC']  = isset($val->UpdatedDateUTC)?$val->UpdatedDateUTC:'';
        $data[$k]['CurrencyCode']    = isset($val->CurrencyCode)?$val->CurrencyCode:'';
        $data[$k]['Type']            = isset($val->Type)?$val->Type:'';
        $data[$k]['InvoiceID']       = isset($val->InvoiceID)?$val->InvoiceID:'';
        $data[$k]['InvoiceNumber']   = isset($val->InvoiceNumber)?$val->InvoiceNumber:'';
        $data[$k]['Reference']       = isset($val->Reference)?$val->Reference:'';
        $data[$k]['AmountDue']       = isset($val->AmountDue)?$val->AmountDue:'0';
        $data[$k]['AmountPaid']      = isset($val->AmountPaid)?$val->AmountPaid:'0';
        $data[$k]['AmountCredited']  = isset($val->AmountCredited)?$val->AmountCredited:'0';
        $data[$k]['SentToContact']   = isset($val->SentToContact)?$val->SentToContact:'';
        $data[$k]['CurrencyRate']    = isset($val->CurrencyRate)?$val->CurrencyRate:'';
        $data[$k]['HasAttachments']  = isset($val->HasAttachments)?$val->HasAttachments:'';
        $data[$k]['ToBeCollected']   = isset($val->ToBeCollected)?$val->ToBeCollected:'0';
        $data[$k]['collection_date'] = (isset($val->collection_date) && $val->collection_date != "0000-00-00")?date('d-m-Y', strtotime($val->collection_date)):'';
        $data[$k]['EmailAddress']    = isset($val->EmailAddress)?$val->EmailAddress:'';
        $data[$k]['auto_collect']    = isset($val->auto_collect)?$val->auto_collect:'N';
        $data[$k]['is_deleted']      = isset($val->is_deleted)?$val->is_deleted:'N';
        $data[$k]['created']         = date('d-m-Y', strtotime($val->created));
      }
    }
    return $data;
  }
}
