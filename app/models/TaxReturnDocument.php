<?php
class TaxReturnDocument  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;
	public static function getDocument($checklist_id)
	{
		$data = array();
		$details = TaxReturnDocument::where('checklist_id', '=', $checklist_id)->get();
		if(isset($details) && count($details) >0){
	        foreach ($details as $key => $value) {
	        	$data[$key]['document_id'] 		= $value->document_id;
				$data[$key]['checklist_id'] 	= $value->checklist_id;
				$data[$key]['document_name'] 	= $value->document_name;
        	}
		}
		return $data;
	}

}
