<?php
class ContactEmailTemplate  extends Eloquent{
	
	public $timestamps = false;

	
	public static function getEmailTemplate()
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = ContactEmailTemplate::whereIn("uid", $groupUserId)->get();
        
        return ContactEmailTemplate::getArray($details);
	}

	public static function getEmailTemplateById($id)
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = ContactEmailTemplate::where("id", "=", $id)->first()->toArray();
        
        return $details;
	}

	public static function getEmailTemplateByServiceId($service_id)
	{
		$data = array();
		$details = EmailTemplate::where("template_type_id", "=", $service_id)->get();
		if (isset($details) && count($details) > 0) {
			foreach ($details as $key => $template_row) {
				$data[$key]['email_template_id'] 	= $template_row->email_template_id;
				$data[$key]['user_id'] 				= $template_row->user_id;
				$data[$key]['template_type_id'] 	= $template_row->template_type_id;
				$data[$key]['name'] 				= $template_row->name;
				$data[$key]['title'] 				= $template_row->title;
				$data[$key]['message'] 				= $template_row->message;
				$data[$key]['file'] 				= $template_row->file;
				$data[$key]['created'] 				= $template_row->created;
				$data[$key]['modified'] 			= $template_row->modified;
			}
		}
		return $data;
	}

	public static function getArray($details)
	{
		$data = array();
		if (isset($details) && count($details) > 0) {
			foreach ($details as $key => $template_row) {
				$data[$key]['id'] 			= $template_row->id;
				$data[$key]['name'] 		= $template_row->name;
				$data[$key]['type'] 		= $template_row->type;
				$data[$key]['subject'] 		= $template_row->subject;
				$data[$key]['created'] 		= $template_row->created;
				$data[$key]['modified'] 	= $template_row->modified;
				$data[$key]['uid'] 			= $template_row->uid;
				$data[$key]['user_name']    = User::getStaffNameById($template_row->uid);
			}
		}
		return $data;
	}

	public static function saveAsTemplateDetails($postData)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $insrtData['uid']   	= $user_id;
        $insrtData['subject']   = $postData['subject'];
        $insrtData['created']   = date('Y-m-d H:i:s');

        $insert_id 	= ContactEmailTemplate::insertGetId($insrtData);
        if(isset($insert_id) && $insert_id >= 0 ){
			$filepath 	= 'email_templates/'.$insert_id.'.txt';
			File::put($filepath,$postData['content']);
		}
        
        return $insert_id;
    }

	
}
