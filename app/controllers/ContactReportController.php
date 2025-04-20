<?php
class ContactReportController extends BaseController {
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
	
	public function save_details()
	{
		$data           = array();
        $clientId       = array();
        $client_data    = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $data['user_id']        = 0;
        $data['msg_type']       = Input::get("msg_type");
        $data['email']          = Input::get("field_email");
        $data['name']           = Input::get("field_name");
        $data['phone']          = Input::get("field_phone");
        $data['subject']        = Input::get("field_subject");
        $data['description']    = Input::get("field_desc");

        $last_id = ContactReport::insertGetId($data);

        if ($last_id) {
            if (Input::hasFile('add_file')) {
                $file           = Input::file('add_file');
                $destination    = "uploads/reports";
                $fileName       = Input::file('add_file')->getClientOriginalName();

                $fileName       = $last_id . $fileName;
                $result         = Input::file('add_file')->move($destination, $fileName);

                $file_data['file'] = $fileName;
                ContactReport::where("report_id", "=", $last_id)->update($file_data);
            }
        }
    echo $last_id;     
		
	}

	

}
