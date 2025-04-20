<?php
class ClientFile extends Eloquent {

	public $timestamps = false;
	public static function detailsByClientId($client_id)
	{
		$data = array();

        $details = ClientFile::where("client_id", $client_id)->first();
		if(isset($details) && count($details) >0){
			$data['client_file_id'] = $details->client_file_id;
			$data['client_id'] 		= $details->client_id;
			$data['passport1'] 		= $details->passport1;
			$data['passport2'] 		= $details->passport2;
			$data['document1'] 		= $details->document1;
			$data['document2'] 		= $details->document2;
			$data['profile_photo'] 	= $details->profile_photo;
		}
		//print_r($data);die;
		return $data;
	}

}
