<?php
class PaypalSetting extends Eloquent {

	public $timestamps = false;

	public static function getDetails()
    {
    	$details   = PaypalSetting::first();
        $data      = PaypalSetting::getSingleArray($details);
        return $data;
    }


    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) > 0){
            $data['paypal_id']          = $details->paypal_id;
            $data['server']             = $details->server;
            $data['email']              = $details->email;
            $data['perclient_price']    = $details->perclient_price;
        }
        return $data;
    }

}
