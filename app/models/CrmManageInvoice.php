<?php
class CrmManageInvoice  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;
	public static function getAllDetails()
  	{
  		$data 			= 'N';
		$session        = Session::get('admin_details');
		$user_id        = $session['id'];
		$groupUserId    = $session['group_users'];

		$details    = CrmManageInvoice::whereIn("user_id", $groupUserId)->get();
		$data       = CrmInvoiceDebit::getArray($details);
      	return $data;
  	}

  	public static function getDetailsByInvoiceNumber($inv_no)
  	{
  		$data 			= array();
		$session        = Session::get('admin_details');
		$user_id        = $session['id'];
		$groupUserId    = $session['group_users'];

		$details    = CrmManageInvoice::whereIn("user_id", $groupUserId)->where('invoice_number', '=', $inv_no)->first();
		$data       = CrmManageInvoice::getSingleArray($details);
      	return $data;
  	}

  	public static function getAllInvoiceNumber()
  	{
  		$data 			= array();
		$session        = Session::get('admin_details');
		$user_id        = $session['id'];
		$groupUserId    = $session['group_users'];

		$details    = CrmManageInvoice::whereIn("user_id", $groupUserId)->select('invoice_number')->get();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key] = $value->invoice_number;
			}
			
		}
      	return $data;
  	}

  	public static function checkIsSend($inv_no)
  	{
  		$data 			= 'N';
		$session        = Session::get('admin_details');
		$user_id        = $session['id'];
		$groupUserId    = $session['group_users'];

		$details    = CrmManageInvoice::whereIn("user_id", $groupUserId)->where('invoice_number', '=', $inv_no)->first();
		if(isset($details) && count($details) >0){
			$data = 'Y';
		}
		return $data;
  	}	


  	public static function getArray($details)
    {
      $data = array();
      if(isset($details) && count($details) >0){
        foreach ($details as $k => $val) {
		  $data[$k]['manage_id']  	   = isset($val->manage_id)?$val->manage_id:'';
		  $data[$k]['user_id']         = isset($val->user_id)?$val->user_id:'';
		  $data[$k]['invoice_number']  = isset($val->invoice_number)?$val->invoice_number:'';
		  $data[$k]['collection_date'] = (isset($val->collection_date) && $val->collection_date != "0000-00-00")?date('d-m-Y', strtotime($val->collection_date)):'';
		  $data[$k]['amount']    	   = isset($val->amount)?$val->amount:'';
		  $data['created']        	   = date('d-m-Y', strtotime($val->created));
        }
	  }
    return $data;
    }

    public static function getSingleArray($val)
    {
	    $data = array();
	    if(isset($val) && count($val) >0){
			$data['manage_id']  	= isset($val->manage_id)?$val->manage_id:'';
			$data['user_id']        = isset($val->user_id)?$val->user_id:'';
			$data['invoice_number'] = isset($val->invoice_number)?$val->invoice_number:'';
			$data['collection_date']= (isset($val->collection_date) && $val->collection_date != "0000-00-00")?date('d-m-Y', strtotime($val->collection_date)):'';
			$data['amount']    		= isset($val->amount)?$val->amount:'';
			$data['created']        = date('d-m-Y', strtotime($val->created));
	    }
	    return $data;
    }

}
