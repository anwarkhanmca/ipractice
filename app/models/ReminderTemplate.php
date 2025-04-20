<?php
class ReminderTemplate extends Eloquent {

	public $timestamps = false;

	public static function getTemplate()
    {
    	$details = ReminderTemplate::first();
        if(isset($details) && count($details) >0){
        	$data['reminder_template_id'] = $details['reminder_template_id'];
            $data['user_id']                = $details['user_id'];
            $data['subject']                = $details['subject'];
            $data['content']                = $details['content'];
            $data['type']                   = $details['type'];
            $data['created']                = $details['created'];
		}
		return $data;
    }

}
