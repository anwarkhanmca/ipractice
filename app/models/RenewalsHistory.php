<?php
class RenewalsHistory extends Eloquent {

	public $timestamps = false;
	public static function getDetailsByClient( $client_id )
    {
    	$data = array();
    	$details = RenewalsHistory::where("client_id", $client_id)->get();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$data[$key]['rnl_history_id'] 	= $value->rnl_history_id;
        		$data[$key]['client_id'] 		= $value->client_id;
        		$data[$key]['amount'] 			= $value->amount;
        		$data[$key]['start_date'] 		= $value->start_date;
        		$data[$key]['end_date'] 		= $value->end_date;
        		$data[$key]['created'] 			= $value->created;
        	}
        }
        return $data;
    }

}
