<?php
class EmailTemplate  extends Eloquent{
	
	public $timestamps = false;

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

	
}
