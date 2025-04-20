<?php
//opcache_reset ();
//Cache::forget('user_list');

class QuotesController extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)){
            Redirect::to('/login')->send();
        }
    }
	
	public function quotes(){
		$data['title'] = 'Quotes';
		$data['previous_page'] = '<a href="crm/MTE=/YWxs">CRM</a>';
		$data['heading'] = "QUOTES";
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];
        $data['old_services'] 	= Service::where("status", "=", "old")->orderBy("service_name")->get();
        $data['new_services'] 	= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
        
    return View::make('crm.new_quotes', $data);
    
    }
    
    
    
    
    public function quotefilefile_upload()
    {
       // echo 'file';
        //die('fsfsf');
        $postData = Input::all();
        $arrData = array();
        $file_data = array();
        
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $group_id = $admin_s['group_id'];
        $groupUserId = $admin_s['group_users'];
        
        


            $path = 'uploads/' . $group_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $path = 'uploads/' . $group_id . '/quote/';
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
     
      //  die();
        
        if (Input::hasFile('add_pdffile1')) {
        if (Input::file('add_pdffile1')) {
                $file_type = "P";
                //die('pdfdfdf');
                $file = Input::file('add_pdffile1');
                $destinationPath = 'uploads/' . $group_id . '/quote/';
                $fileName = Input::file('add_pdffile1')->getClientOriginalName();


                $messages = array("add_pdffile1.required" => "add_file1 subject");
                $rules = array('add_pdffile1' => 'required|max:10000|mimes:pdf');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper Pdf File only</font>');
                } else {

                    $result = Input::file('add_pdffile1')->move($destinationPath, $fileName);
                }


            }
            }
           echo 'uploads/' . $group_id . '/quote/'.$fileName;
          // echo ;
            //echo 'move';
       // echo '<pr>'; print_r($postData);

    }
}
