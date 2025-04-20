<?php
//Cache::forget('template_list');
//use Excel;

class EmailSettingsController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	    $session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login')->send();
		}
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}
	}

	public function index() {
		$data['heading'] = " EMAIL & LETTER TEMPLATES";

		$session = Session::get('admin_details');
		$groupUserId = $session['group_users'];
		$user_id 		= $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login');
		}

		/*if (Cache::has('template_list')) {
			$data = Cache::get('template_list');
		} else {*/
			$data['title'] = "Email & Letter Templates";
			$data['previous_page'] = '<a href="/settings-dashboard">Settings</a>';
			$data['template_types'] 	= TemplateType::orderBy("template_type_name", "ASC")->get();
		//	$data['email_templates'] 	= EmailTemplate::orderBy("email_template_id", "DESC")->get();
           
            $data['old_services'] 	= Service::where("status", "=", "old")->orderBy("service_name")->get();
            $data['new_services'] 	= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
	//	echo '<pre>';print_r($data['old_services']);die();
        	$data['email_templates'] = DB::table('email_templates')
				->join('template_types', 'email_templates.template_type_id', '=', 'template_types.template_type_id')
				->select('email_templates.*', 'template_types.template_type_name')->whereIn("user_id", $groupUserId)->orderBy("email_template_id", "Desc")->get();
			//Cache::put('template_list', $data, 10);

		//}

		//echo $this->last_query();die;
		//echo "<pre>";print_r($data);die;
		return View::make("email_settings.index", $data);
	}

	public function show_edit_template() {
		$template_id = Input::get("template_id");
		if (Request::ajax()) {
			/*if(Cache::has('emailTemplates')){
			$emailTemplates 	= Cache::get('emailTemplates');
			}else{
			$emailTemplates 	= EmailTemplate::where("email_template_id", $template_id)->first();
			Cache::put('emailTemplates', $emailTemplates, 10);
			}*/
			$emailTemplates = EmailTemplate::where("email_template_id", $template_id)->first();

			//echo "<pre>";print_r($emailTemplates);die;
			//echo View::make("email_settings.edit_template", $data);
			echo json_encode($emailTemplates);
		}
	}

	public function get_edit_template_type() {
		$tmpl_typ_id = Input::get("tmpl_typ_id");
		if (Request::ajax()) {
			/*if (Cache::has('get_edit_template_type')) {
				$template_types = Cache::get('get_edit_template_type');
			} else {*/
				$template_types['template_types'] = TemplateType::orderBy("template_type_name", "ASC")->get();
				$template_types['template_type_id'] = $tmpl_typ_id;
				/*Cache::put('get_edit_template_type', $template_types, 10);
			}*/

			echo View::make("email_settings.template_type", $template_types);
		}
	}

	public function get_template() {
		$template_id = Input::get("template_id");
		if (Request::ajax()) {
			if (Cache::has('get_template')) {
				$template = Cache::get('get_template');
			} else {
				$template = Template::where("template_type_id", $template_id)->first();
				Cache::put('get_template', $template, 10);
			}
			//echo $this->last_query();die;
			if (!empty($template) && count($template) > 0) {
				echo json_encode($template);
			} else {
				echo json_encode("fail");
			}

		}
	}

	public function add_email_template() {
		$tmpl_data = array();
		$postData = Input::all();
		$session = Session::get('admin_details');

		$tmpl_data['user_id'] 			= $session['id'];
		$tmpl_data['name'] 				= $postData['add_name'];
		$tmpl_data['template_type_id'] 	= $postData['add_template_type'];
		$tmpl_data['title'] 			= $postData['add_title'];
		$tmpl_data['message'] 			= $postData['add_message'];
		$tmpl_data['created'] 			= date("Y-m-d H:i:s");
		$pd_id = EmailTemplate::insertGetId($tmpl_data);
		if ($pd_id) {
			//////////////////file upload start//////////////////
			if (Input::hasFile('add_file')) {
				$file = Input::file('add_file');
				$destinationPath = "uploads/emailTemplates/";
				$fileName = Input::file('add_file')->getClientOriginalName();
                
				$fileName = $pd_id.$fileName;
				$result = Input::file('add_file')->move($destinationPath, $fileName);

				$file_data['file'] = $fileName;
				EmailTemplate::where("email_template_id", "=", $pd_id)->update($file_data);

			}
			/////////////////file upload end////////////////////
			Session::flash('success', 'New email template has been added.');
		} else {
			Session::flash('error', 'There are some error to add new email template.');
		}

		Cache::flush();
		return Redirect::to('/email-settings');

	}

	public function edit_email_template() {
		$tmpl_data = array();
		$postData = Input::all();

		$tmpl_data['name'] = $postData['edit_name'];
		$tmpl_data['template_type_id'] = $postData['edit_template_type'];
		$tmpl_data['title'] = $postData['edit_title'];
		$tmpl_data['message'] = $postData['edit_message'];
		$tmpl_data['modified'] = date("Y-m-d H:i:s");
		$update = EmailTemplate::where("email_template_id", "=", $postData['edit_email_template_id'])->update($tmpl_data);
		//echo $this->last_query();die;
		if ($update) {
			//////////////////file upload start//////////////////
			if (Input::hasFile('edit_file')) {
				$file = Input::file('edit_file');
				$destinationPath = "uploads/emailTemplates/";
				$fileName = Input::file('edit_file')->getClientOriginalName();
				$fileName = $postData['edit_email_template_id'].$fileName;
				$result = Input::file('edit_file')->move($destinationPath, $fileName);

				$file_data['file'] = $fileName;
				EmailTemplate::where("email_template_id", "=", $postData['edit_email_template_id'])->update($file_data);

				### delete the previous image if exists ###
				$prevPath = "uploads/emailTemplates/" . $postData['hidd_file'];
				if ($postData['hidd_file'] != "") {
					if (file_exists($prevPath)) {
						unlink($prevPath);
					}
				}
				### delete the previous image if exists ###

			}
			/////////////////file upload end////////////////////
			Session::flash('success', 'Email template successfully updated.');
		} else {
			Session::flash('error', 'There are some error to update email template.');
		}

		Cache::flush();
		return Redirect::to('/email-settings');

	}

	public function delete_email_template() {
		$tmpl_data = array();
		$eml_tmpl_id = Input::get('eml_tmpl_id');
		if (Request::ajax()) {
			$del = EmailTemplate::where("email_template_id", "=", $eml_tmpl_id)->delete();
			if ($del) {
				$msg = "success";
				Session::flash('success', 'Email template has been deleted successfully.');
				Cache::flush();
			} else {
				$msg = "fail";
				Session::flash('error', 'There are some error to delete this email template.');
			}
			echo $msg;
			exit;
		}

	}

	public function delete_attach_file() {
		$tmpl_data = array();
		$eml_tmpl_id = Input::get('eml_tmpl_id');
		$file = Input::get('file');
		if (Request::ajax()) {
			$del = EmailTemplate::where("email_template_id", "=", $eml_tmpl_id)->update(array('file'=>''));
			if ($del) {
				$msg = "success";
				unlink('uploads/emailTemplates/'.$file);
				Session::flash('success', 'Attached file has been deleted successfully.');
				Cache::flush();
			} else {
				$msg = "fail";
				Session::flash('error', 'There are some error to delete this file.');
			}
			echo $msg;
			exit;
		}

	}
   

	

}
