<?php
class Clienttaxpdf  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;
	public static function getDocument($checklist_id)
	{
		$data = array();
		$details = Clienttaxpdf::where('checklist_id', '=', $checklist_id)->get();
		if(isset($details) && count($details) >0){
	        foreach ($details as $key => $value) {
	        	$data[$key]['clienttaxpdf_id'] 	= $value->clienttaxpdf_id;
	        	$data[$key]['client_id'] 		= $value->client_id;
				$data[$key]['checklist_id'] 	= $value->checklist_id;
				$data[$key]['file'] 			= $value->file;
				$data[$key]['created'] 			= $value->created;
        	}
		}
		//Common::last_query();die;
		return $data;
	}
    
    public static function getDocumentByClientId($client_id)
	{
		$data = array();
		$details = Clienttaxpdf::where('client_id', '=', $client_id)->get();
		if(isset($details) && count($details) >0){
	        foreach ($details as $key => $value) {
	        	$data[$key]['clienttaxpdf_id'] 	= $value->clienttaxpdf_id;
	        	$data[$key]['client_id'] 		= $value->client_id;
				$data[$key]['checklist_id'] 	= $value->checklist_id;
				$data[$key]['file'] 			= $value->file;
				$data[$key]['created'] 			= $value->created;
        	}
		}
		//Common::last_query();die;
		return $data;
	}
	

}
