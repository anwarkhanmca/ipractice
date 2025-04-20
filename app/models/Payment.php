<?php
class Payment extends Eloquent {

	public $timestamps = false;

	public static function getDetailsByUserId($user_id)
    {
    	$details   = Payment::where('user_id', '=', $user_id)->get();
        $data      = Payment::getArray($details);
        return $data;
    }


    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) > 0){
            foreach ($details as $key => $value) {
                $data[$key]['payment_id']         = $value->payment_id;
                $data[$key]['user_id']            = $value->user_id;
                $data[$key]['txn_id']             = $value->txn_id;
                $data[$key]['payment_gross']      = $value->payment_gross;
                $data[$key]['currency_code']      = $value->currency_code;
                $data[$key]['payment_status']     = $value->payment_status;
                $data[$key]['created']            = $value->created;
            }
            
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) > 0){
            $data['payment_id']         = $value->payment_id;
            $data['user_id']            = $value->user_id;
            $data['txn_id']             = $value->txn_id;
            $data['payment_gross']      = $value->payment_gross;
            $data['currency_code']      = $value->currency_code;
            $data['payment_status']     = $value->payment_status;
            $data['created']            = $value->created;
        }
        return $data;
    }

}
