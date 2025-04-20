<?php
class TaxReturnChecklist  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;
	
	public static function getDetailsByServiceId($service_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = TaxReturnChecklist::whereIn("user_id", $groupUserId)->where('service_id', '=', $service_id)->get();
        if(isset($details) && count($details) >0){
	        foreach ($details as $key => $value) {
	        	$data[$key]['checklist_id'] = $value->checklist_id;
				$data[$key]['user_id'] 		= $value->user_id;
				$data[$key]['service_id'] 	= $value->service_id;
				$data[$key]['tax_year'] 	= $value->tax_year;
				$data[$key]['tax_document'] = $value->tax_document;
				$data[$key]['remind_days'] 	= $value->remind_days;
				$data[$key]['is_reminder'] 	= $value->is_reminder;
				$data[$key]['created'] 		= $value->created;
        	}
		}
		//print_r($data);die;
		return $data;
	}

	public static function detailsByTaxYearAndServiceId($tax_year, $service_id, $client_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = TaxReturnChecklist::whereIn("user_id", $groupUserId)->where('service_id', '=', $service_id)->where('client_id', '=', $client_id)->where('tax_year', '=', $tax_year)->first();
		if(isset($details) && count($details) >0){
			$data['checklist_id'] 	= $details->checklist_id;
			$data['user_id'] 		= $details->user_id;
            $data['client_id'] 		= $details->client_id;
			$data['service_id'] 	= $details->service_id;
			$data['tax_year'] 		= $details->tax_year;
			$data['tax_document'] 	= $details->tax_document;
			$data['remind_days'] 	= $details->remind_days;
			$data['documents'] 		= TaxReturnDocument::getDocument($details->checklist_id);
			$data['client_docs'] 	= Clienttaxpdf::getDocument($details->checklist_id);
			$data['messages'] 		= TaxreturnMessage::getMessage($details->checklist_id, $client_id);
			$data['is_reminder'] 	= $details->is_reminder;
			$data['created'] 		= $details->created;
		}
		//print_r($data);die;
		return $data;
	}
    
    public static function detailsByTaxYear($tax_year, $service_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = TaxReturnChecklist::whereIn("user_id", $groupUserId)->where('service_id', '=', $service_id)->where('tax_year', '=', $tax_year)->first();
		if(isset($details) && count($details) >0){
			$data['checklist_id'] 	= $details->checklist_id;
			$data['user_id'] 		= $details->user_id;
            $data['client_id'] 		= $details->client_id;
			$data['service_id'] 	= $details->service_id;
			$data['tax_year'] 		= $details->tax_year;
			$data['tax_document'] 	= $details->tax_document;
			$data['remind_days'] 	= $details->remind_days;
			$data['documents'] 		= TaxReturnDocument::getDocument($details->checklist_id);
			$data['client_docs'] 	= Clienttaxpdf::getDocument($details->checklist_id);
			//$data['messages'] 		= TaxreturnMessage::getMessage($details->checklist_id, $client_id);
			$data['is_reminder'] 	= $details->is_reminder;
			$data['created'] 		= $details->created;
		}
		//print_r($data);die;
		return $data;
	}

}
