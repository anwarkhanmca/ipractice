<?php
class ContactsNote extends Eloquent {

	public $timestamps = false;

	public static function getNotes($client_id, $contact_type)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $notes_array = ContactsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("contact_type", "=", $contact_type)->first();

        $notes = "";
        if(isset($notes_array) && count($notes_array) > 0){
            $notes = $notes_array['notes'];
        }
        return $notes;
	}
}
