<?php
class CrmInvoiceAutosend extends Eloquent {

	public $timestamps = false;

	public static function getDetailsByContactId( $contact_id )
    {
    	$details = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $data = CrmInvoiceAutosend::whereIn("user_id", $groupUserId)->where("contact_id", '=', $contact_id)->first();
        if(isset($data) && count($data) >0){
        	$details = $data;
		}
		return $details;
    }

    public static function CheckAutosendByContactId( $contact_id )
    {
        $details = 0;
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $data = CrmInvoiceAutosend::whereIn("user_id", $groupUserId)->where("contact_id", '=', $contact_id)->first();
        if(isset($data) && count($data) >0){
            $details = 1;
        }
        return $details;
    }

}
