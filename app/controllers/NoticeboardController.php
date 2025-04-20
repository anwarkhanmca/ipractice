<?php
//opcache_reset ();
//Cache::forget('user_list');

class NoticeboardController extends BaseController{
    public function __construct()
    {
        parent::__construct();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        if (empty($user_id)) {
            Redirect::to('/login')->send();
        }
        if (isset($session['user_type']) && $session['user_type'] == "C") {
            Redirect::to('/client-portal')->send();
        }
    }

    public function notice_board($page_open)
    {
        $data['heading']    = "E - BOARD";
        $data['title']      = "E - Board";
        $admin_s            = Session::get('admin_details');
        $user_id            = $admin_s['id'];
        $group_id           = $admin_s['group_id'];
        
        $groupUserId        = $admin_s['group_users'];
        $data['page_open']  = $page_open;


        /*
        $data['attach'] = DB::table('users')->whereIn("users.user_id", $groupUserId)->
        join('noticefonts', 'users.user_id', '=', 'noticefonts.user_id')->select('users.user_id',
        'users.fname', 'users.lname', 'noticefonts.file', 'noticefonts.noticefont_id')->
        get();
        */
        //echo $this->last_query();die();

 
        $data['user'] = User::whereIn("user_id", $groupUserId)->select("fname", "lname",
            "user_id")->get();


        $arr = array();
        foreach ($data['user'] as $key => $val) {

            $arr[$key]['user_id'] = $data['user'][$key]->user_id;
            $arr[$key]['fname'] = $this->getInitials($data['user'][$key]->fname);
            $arr[$key]['lname'] = $data['user'][$key]->lname;


        }

        $data['username'] = $arr;

        //echo "<pre>";print_r($data['username']);die();

        $data['font'] = Noticefont::whereIn("user_id", $groupUserId)->where("board_no","=", "1")->select("noticefont_id", "sort_id", "user_id", "board_no", "message",
            "message_subject", "checkbox", "file", "created")->orderBy('sort_id', 'DESC')->
            take(8)->get();


        //echo $data['font'];die();

        $data['font2'] = Noticefont::whereIn("user_id", $groupUserId)->where("board_no","=", "2")->select("noticefont_id", "sort_id", "user_id", "board_no", "message",
            "message_subject", "checkbox", "file", "created")->orderBy('sort_id', 'DESC')->
            take(8)->get();

        $data['userfullname'] = User::where("user_id", $user_id)->select("fname",
            "lname")->first();


        $data['excel'] = Noticeexcel::whereIn("user_id", $groupUserId)->select("*")->get();

        $arr = array();
        foreach ($data['excel'] as $key => $val) {
            $arr[$key]['file'] = $data['excel'][$key]->file;
            $arr[$key]['noticeexcel_id'] = $data['excel'][$key]->noticeexcel_id;
            $arr[$key]['file_type'] = $data['excel'][$key]->file_type;
        }
        $data['file_name']=$arr;
       
       //echo '<pre>';print_r($data['file_name']);
        //die();

        $data['excel'] = Noticeexcel::where("group_id", $group_id)->where("file_type",
            "=", "E")->select("noticeexcel_id", "level", "user_id", "file")->get();

        //  echo '<pre>';print_r($data['excel']);die();


        $arrfile = array();
        foreach ($data['excel'] as $key => $val) {

            $arrfile[$val->level]['file'] = $val->file;
            $arrfile[$val->level]['level'] = $val->level;
            $arrfile[$val->level]['noticeexcel_id'] = $val->noticeexcel_id;
            $arrfile[$val->level]['user_id'] = $val->user_id;

        }
        $data['all_excel'] = $arrfile;


        $data['pdf'] = Noticeexcel::where("group_id", $group_id)->where("file_type", "=","P")->select("noticeexcel_id", "level", "user_id", "file")->get();
        //echo $this->last_query();die();

          //echo '<pre>';print_r($data['pdf']);die();


        $arrpdffile = array();
        foreach ($data['pdf'] as $key => $val) {
            

            $arrpdffile[$key]['file'] = $val->file;
           // $arrpdffile[$val->level]['level'] = $val->level;
            $arrpdffile[$key]['noticeexcel_id'] = $val->noticeexcel_id;
            $arrpdffile[$key]['user_id'] = $val->user_id;

        }
        $data['all_pdf'] = $arrpdffile;

        //echo "<pre>";print_r($data['che']);die();
        $data['group_id']= $group_id;

        $data['staff_details'] = User::getAllStaffName();

        if($page_open == 3){
            $old_types  = HolidayType::getHolidayTypes('O');
            $new_types  = HolidayType::getHolidayTypes('N');
            $calender_type = array_merge($old_types, $new_types);
            $data['holiday_types']    = array_values($calender_type);
        }

        $details  = HolidayDetail::getHolidayDetails();
        if(isset($details['holiday_date']) && $details['holiday_date'] != ""){
            $start_date = explode('-', $details['holiday_date']);
            $data['start_date'] = $start_date[0].'-'.$start_date[1].'-'.date('Y');
        }else{
            $data['start_date'] = "new";
        }
        
        return View::make('notice.noticeboard', $data);

    }

    public function getInitials($name)
    {
        $init = '';
        $name = explode(' ', $name);
        foreach ($name as $part)
            $init .= strtoupper(substr($part, 0, 1));
        return $init;
    }


    public function index_template()
    {

        //die('gjkgkgk');

        $data['heading'] = "NOTICE BOARD";
        $data['title'] = "Notice Board";
        //$data['practice_logo'] = "Notice BOARD";
        //$data['practice_name'] = "Notice BOARD";
        $session = Session::get('admin_details');
        $groupUserId = $session['group_users'];
        //$data['admin_name'] = "Notice BOARD";
        $data['user_id'] = $session['id'];


        $data['user'] = User::select("fname", "lname")->get();
        $arr = array();
        foreach ($data['user'] as $key => $val) {

            $arr[$key]['fname'] = $this->getInitials($data['user'][$key]->fname);
            $arr[$key]['lname'] = $this->getInitials($data['user'][$key]->lname);

        }

        $data['username'] = $arr;


        return View::make('notice.noticeboard', $data);
        //echo '<pre>';
        //print_r($data['user'][0]->fname);
        //die();


    }


    public function insert_noticeboard()
    {


        $postData = Input::all();
        $arrData = array();

        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];


        //################  #################//
        $step_id = 1;
        if (!empty($postData['ni_number'])) {
            $arrData[] = $this->save_notice($user_id, $step_id, 'ni_number', $postData['ni_number']);
        }

        echo "<pre>";
        print_r($arrData);
        die();
    }


    public function save_notice($user_id, $step_id, $field_name, $field_value)
    {
        $data = array();
        $data['user_id'] = $user_id;
        $data['step_id'] = $step_id;
        $data['field_name'] = $field_name;
        $data['field_value'] = $field_value;
        return $data;

    }


    public function notice_template()
    {
        //print_r($_POST);die();
        $postData = Input::all();
        //echo "<pre>";
        //print_r($postData);die();

        $tmpl_data = array();

        $session = Session::get('admin_details');
        $groupUserId = $session['group_users'];

        $user_id = $session['id'];
        $session = Session::get('admin_details');
        $tmpl_data['user_id'] = $session['id'];
        $postData = Input::all();

        $messages = array("message_subject.required" => "Please enter  message subject", );

        $rules = array("message_subject" => "required", );

        $validator = Validator::make($postData, $rules, $messages);

        if ($validator->fails()) {

            return Redirect::to('/noticeboard')->withErrors($validator)->withInput();
        } else {

            $tmpl_data['board_no'] = $postData['board_no'];
            if (isset($postData['add_message']) && !empty($postData['add_message'])) {
                $tmpl_data['message'] = $postData['add_message'];
            }
            if (isset($postData['message_subject']) && !empty($postData['message_subject'])) {
                $tmpl_data['message_subject'] = $postData['message_subject'];
            }

            if (isset($postData['notifycheckadd']) && !empty($postData['notifycheckadd'])) {

                $arr = $postData['notifycheckadd'];

                $arrnotify = serialize($arr);
                //print_r($arrnotify);die();
                //$arrnotify = implode(",", $arr);
                $tmpl_data['checkbox'] = $arrnotify;
            }


            $tmpl_data['created'] = date("Y-m-d H:i:s");


            //echo '<pre>'; print_r($tmpl_data);die();
            $noticefont_id = Noticefont::insertGetId($tmpl_data);

            $sort_data = array();
            $sort_data['sort_id'] = $noticefont_id;
            $sortId_update = Noticefont::where("noticefont_id", $noticefont_id)->update($sort_data);


            if (isset($postData['notifycheckadd']) && !empty($postData['notifycheckadd'])) {

                $data['user_email'] = User::whereIn("user_id", $postData['notifycheckadd'])->select("email")->get();
                
                $arr = array();

                foreach ($data['user_email'] as $key => $val) {
                    $arr[$key] = $data['user_email'][$key]->email;
                    $tmpl_data['emailnotice'] = $arr[$key];
                    $this->send_notice($tmpl_data);
                }
            }


            /*if ($noticefont_id) {
                //////////////////file upload start//////////////////
                if (Input::hasFile('add_file')) {
                    $file = Input::file('add_file');
                    $destinationPath = "uploads/noticeTemplates/";
                    $fileName = Input::file('add_file')->getClientOriginalName();

                    $fileName = $noticefont_id . $fileName;
                    $result = Input::file('add_file')->move($destinationPath, $fileName);

                    $file_data['file'] = $fileName;
                    Noticefont::where("noticefont_id", "=", $noticefont_id)->update($file_data);

                }
                /////////////////file upload end////////////////////

            }*/

            if ($postData['board_no'] == 1) {
                
                $data['font'] = Noticefont::whereIn("user_id", $groupUserId)->where("noticefont_id",
                    "=", $noticefont_id)->where("board_no", "=", "1")->select("noticefont_id",
                    "sort_id", "user_id", "board_no", "message", "message_subject", "checkbox",
                    "file", "created")->first();

                $data['userfullname'] = User::where("user_id", $user_id)->select("fname",
                    "lname")->first();
                    
                    echo View::make('notice.font1', $data);
                    exit();

            }

            if ($postData['board_no'] == 2) {

                $data['font2'] = Noticefont::whereIn("user_id", $groupUserId)->where("noticefont_id",
                    "=", $noticefont_id)->where("board_no", "=", "2")->select("noticefont_id",
                    "sort_id", "user_id", "board_no", "message", "message_subject", "checkbox",
                    "file", "created")->first();

                $data['userfullname'] = User::where("user_id", $user_id)->select("fname",
                    "lname")->first();
                    
                    echo View::make('notice.font2', $data);


            }
            
            if ($postData['board_no'] == 1) {
                return Redirect::to('/noticeboard/1');  
            }
            
            else if ($postData['board_no'] == 2) {
                return Redirect::to('/noticeboard/2');  
            }
            

        }
    }


  private function send_notice($data)
  {
    $session    = Session::get('admin_details');
    $user_id    = $session['id'];
    $group_id   = $session['group_id'];

    $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
    $data['USERNAME']     = User::getStaffNameById($user_id);
    $data['NOTICETITLE']  = $data['message_subject'];

    Mail::send('emails.notice', $data, function ($message) use ($data){
      $message->from($data['senderEmail'], 'i-Practice Notice'); 
      $message->to($data['emailnotice'])->subject("Notification for New Noticeboard Post");
    });
  }


  public function edit_template($id)
  {
    $data['temp_details'] = Noticefont::where("noticefont_id", $id)->select("noticefont_id",
        "user_id", "typecatagory", "message", "message_subject", "checkbox", "file",
        "created")->get();
    print_r($id);
    die();
  }


  public function delete_template($id)
  {
    $affected = Noticefont::where('noticefont_id', '=', $id)->delete();
    return Redirect::to('/noticeboard/1');
  }


  public function delete_attachment($id)
  {
    $fileatt  = Noticefont::where("noticefont_id", $id)->select('file')->first();

    $file     = $fileatt->file;
    $del = Noticefont::where("noticefont_id", $id)->update(array('file' => ''));

    unlink('uploads/noticeTemplates/' . $file);

    //$affected = Noticefont::where('noticefont_id', '=', $id)->delete();
    return Redirect::to('/noticeboard/1');

  }


    public function show_edit_noticetemplate()
    {
        $noticefont_id = Input::get("noticefont_id");

        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];

        if (Request::ajax()) {

            $noticeTemplates = Noticefont::where("noticefont_id", $noticefont_id)->first();
            $noticeTemplates['group'] = $groupUserId;
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode($noticeTemplates);
            exit;
        }
    }


    public function edit_notice_template()
    {
        //die('sfwfwf');
        $tmpl_data = array();
        //echo "<pre>";
        $postData = Input::all();
        $session = Session::get('admin_details');
        $groupUserId = $session['group_users'];

        $chk = Noticefont::where("noticefont_id", "=", $postData['edit_notice_template_id'])->select("checkbox")->first();
        $data['check'] = $chk->checkbox;

        $mychkArray = explode(',', $data['check']);


        $tmpl_data['user_id'] = $session['id'];

        if (isset($postData['edit_message']) && !empty($postData['edit_message'])) {

            $tmpl_data['message'] = $postData['edit_message'];
        }


        $tmpl_data['message_subject'] = $postData['message_subject'];

        if (isset($postData['notifychecked']) && !empty($postData['notifychecked'])) {
            $arr = $postData['notifychecked'];
            $arrnotifyed = serialize($arr);

            $tmpl_data['checkbox'] = $arrnotifyed;
        } else {
            $tmpl_data['checkbox'] = "";

        }


        $tmpl_data['created'] = date("Y-m-d H:i:s");
        //print_r($tmpl_data);die();
        $update = Noticefont::where("noticefont_id", "=", $postData['edit_notice_template_id'])->
            update($tmpl_data);


        if (isset($postData['notifychecked']) && !empty($postData['notifychecked'])) {

            $data['user_email'] = User::whereIn("user_id", $postData['notifychecked'])->
                select("email")->get();
            //echo $this->last_query();die();
            // $tmpl_data['email']=$notice_email;

            $arr = array();

            foreach ($data['user_email'] as $key => $val) {
                $arr[$key] = $data['user_email'][$key]->email;
                $tmpl_data['emailnotice'] = $arr[$key];
                $this->send_notice($tmpl_data);
            }


        }


        //echo $this->last_query();die;
        /*if ($update) {
            //////////////////file upload start//////////////////
            if (Input::hasFile('edit_attach_file')) {
                $file = Input::file('edit_attach_file');
                $destinationPath = "uploads/noticeTemplates/";
                $fileName = Input::file('edit_attach_file')->getClientOriginalName();
                $fileName = $postData['edit_notice_template_id'] . $fileName;
                $result = Input::file('edit_attach_file')->move($destinationPath, $fileName);

                $file_data['file'] = $fileName;
                Noticefont::where("noticefont_id", "=", $postData['edit_notice_template_id'])->
                    update($file_data);

                ### delete the previous image if exists ###
                $prevPath = "uploads/noticeTemplates/" . $postData['hidd_file'];
                if ($postData['hidd_file'] != "") {
                    if (file_exists($prevPath)) {
                        unlink($prevPath);
                    }
                }
                ### delete the previous image if exists ###

            }
            /////////////////file upload end////////////////////

        }*/

        $chk = Noticefont::where("noticefont_id", "=", $postData['edit_notice_template_id'])->
            select("checkbox")->first();


        //SELECT * FROM `users` WHERE user_id IN (SELECT checkbox FROM `noticefonts` WHERE noticefont_id = '44')
        Cache::flush();
        //die('die');
        //return Redirect::to('/noticeboard/');
        
        if ($postData['editboard_no'] == 1) {
            return Redirect::to('/noticeboard/1');  
            }
        else if ($postData['editboard_no'] == 2) {
            return Redirect::to('/noticeboard/2');  
            }
        
        
        

    }


    public function excel_upload()
    {
        $postData   = Input::all();
        $arrData    = array();
        $file_data  = array();

        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $group_id       = $admin_s['group_id'];
        $groupUserId    = $admin_s['group_users'];


        if ($postData['file_type'] = "E") {


            $path = 'uploads/' . $group_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $path = 'uploads/' . $group_id . '/noticeExcel/';
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
        }

        if ($postData['file_type'] = "P") {
            $path = 'uploads/'.$group_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $path = 'uploads/'.$group_id.'/noticepdf/';
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
        }


        if (Input::hasFile('add_file1') || Input::hasFile('add_pdffile1')) {
            if (Input::file('add_file1')) {
                $file_type = "E";
                //die('exfsfsfsf');
                $file = Input::file('add_file1');
                $destinationPath = 'uploads/' . $group_id . '/noticeExcel/';
                $fileName = Input::file('add_file1')->getClientOriginalName();

                $messages = array("add_file1.required" => "add_file1 subject");
                $rules = array('add_file1' => 'required|max:10000|mimes:xls,xlsx');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper ecxel File only</font>');
                } else {

                    $result = Input::file('add_file1')->move($destinationPath, $fileName);
                }

            }

            if (Input::file('add_pdffile1')) {
                $file_type  = "P";
                $file       = Input::file('add_pdffile1');
                $destinationPath    = 'uploads/'.$group_id.'/noticepdf/';
                $fileName           = Input::file('add_pdffile1')->getClientOriginalName();

                $messages   = array("add_pdffile1.required" => "add_file1 subject");
                $rules      = array('add_pdffile1' => 'required|max:10000|mimes:pdf');
                $validator  = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper Pdf File only</font>');
                } else {

                    $result = Input::file('add_pdffile1')->move($destinationPath, $fileName);
                }


            }


            $file_data['user_id']   = $user_id;
            $file_data['group_id']  = $group_id;
            $file_data['file']      = $fileName;
            $file_data['level']     = 1;
            $file_data['file_type'] = $file_type;

            Noticeexcel::insert($file_data);


        } else if (Input::hasFile('add_file2') || Input::hasFile('add_pdffile2')) {

            if (Input::file('add_file2')) {
                $file_type = "E";
                //die('exfsfsfsf');
                $file = Input::file('add_file2');
                $destinationPath = 'uploads/' . $group_id . '/noticeExcel/';
                $fileName = Input::file('add_file2')->getClientOriginalName();

                $messages = array("add_file2.required" => "add_file2 subject");
                $rules = array('add_file2' => 'required|max:10000|mimes:xls,xlsx');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper ecxel File only</font>');
                } else {

                    $result = Input::file('add_file2')->move($destinationPath, $fileName);
                }


            }


            if (Input::file('add_pdffile2')) {
                $file_type = "P";
                //die('pdfdfdf');
                $file = Input::file('add_pdffile2');
                $destinationPath = 'uploads/' . $group_id . '/noticepdf/';
                $fileName = Input::file('add_pdffile2')->getClientOriginalName();


                $messages = array("add_pdffile2.required" => "add_pdffile2 subject");
                $rules = array('add_pdffile2' => 'required|max:10000|mimes:pdf');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper Pdf File only</font>');
                } else {

                    $result = Input::file('add_pdffile2')->move($destinationPath, $fileName);
                }


            }


            $file_data['user_id'] = $user_id;
            $file_data['group_id'] = $group_id;
            $file_data['file'] = $fileName;
            $file_data['level'] = 2;
            $file_data['file_type'] = $file_type;


            $chkfile = Noticeexcel::where("group_id", $group_id)->where("file_type", "=", $file_type)->
                where("level", "=", "2")->select("noticeexcel_id", "file")->first();


            if (isset($chkfile) && count($chkfile) > 0) {
                $noticeexcel_id = $chkfile['noticeexcel_id'];
                $file_name = $chkfile['file'];
                //$prevPath = './uploads/' . $group_id . '/noticeExcel/'. $file_name;

                // if (file_exists('uploads/' . $group_id . '/noticeExcel/'. $file_name)) {
                //       unlink('uploads/' . $group_id . '/noticeExcel/'. $file_name);
                //    }

                Noticeexcel::where("noticeexcel_id", "=", $noticeexcel_id)->update($file_data);

            } else {
                Noticeexcel::insert($file_data);
            }
        } else if (Input::hasFile('add_file3') || Input::hasFile('add_pdffile3')) {


            if (Input::file('add_file3')) {
                $file_type = "E";
                //die('exfsfsfsf');
                $file = Input::file('add_file3');
                $destinationPath = 'uploads/' . $group_id . '/noticeExcel/';
                $fileName = Input::file('add_file3')->getClientOriginalName();

                $messages = array("add_file3.required" => "add_file3 subject");
                $rules = array('add_file3' => 'required|max:10000|mimes:xls,xlsx');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper ecxel File only</font>');
                } else {

                    $result = Input::file('add_file3')->move($destinationPath, $fileName);
                }

            }

            if (Input::file('add_pdffile3')) {
                $file_type = "P";
                //die('pdfdfdf');
                $file = Input::file('add_pdffile3');
                $destinationPath = 'uploads/' . $group_id . '/noticepdf/';
                $fileName = Input::file('add_pdffile3')->getClientOriginalName();


                $messages = array("add_pdffile3.required" => "add_pdffile3 subject");
                $rules = array('add_pdffile3' => 'required|max:10000|mimes:pdf');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper Pdf File only</font>');
                } else {

                    $result = Input::file('add_pdffile3')->move($destinationPath, $fileName);
                }

            }

            $file_data['user_id'] = $user_id;
            $file_data['group_id'] = $group_id;
            $file_data['file'] = $fileName;
            $file_data['level'] = 3;
            $file_data['file_type'] = $file_type;

            $chkfile = Noticeexcel::where("user_id", $group_id)->where("file_type", "=", $file_type)->
                where("level", "=", "3")->select("noticeexcel_id", "file")->first();


            if (isset($chkfile) && count($chkfile) > 0) {
                $noticeexcel_id = $chkfile['noticeexcel_id'];
                $file_name = $chkfile['file'];
                // $prevPath = './uploads/' . $group_id . '/noticeExcel/'. $file_name;

                // if (file_exists('uploads/' . $group_id . '/noticeExcel/'. $file_name)) {
                //   unlink('uploads/' . $group_id . '/noticeExcel/'. $file_name);
                //}
                Noticeexcel::where("noticeexcel_id", "=", $noticeexcel_id)->update($file_data);

            } else {
                Noticeexcel::insert($file_data);
            }
        } elseif (Input::hasFile('add_file4') || Input::hasFile('add_pdffile4')) {


            if (Input::file('add_file4')) {
                $file_type = "E";
                //die('exfsfsfsf');
                $file = Input::file('add_file4');
                $destinationPath = 'uploads/' . $group_id . '/noticeExcel/';
                $fileName = Input::file('add_file4')->getClientOriginalName();

                $messages = array("add_file4.required" => "add_file4 subject");
                $rules = array('add_file4' => 'required|max:10000|mimes:xls,xlsx');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper ecxel File only</font>');
                } else {

                    $result = Input::file('add_file4')->move($destinationPath, $fileName);
                }


            }

            if (Input::file('add_pdffile4')) {
                $file_type = "P";
                //die('pdfdfdf');
                $file = Input::file('add_pdffile4');
                $destinationPath = 'uploads/' . $group_id . '/noticepdf/';
                $fileName = Input::file('add_pdffile4')->getClientOriginalName();


                $messages = array("add_pdffile4.required" => "add_pdffile4 subject");
                $rules = array('add_pdffile4' => 'required|max:10000|mimes:pdf');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper Pdf File only</font>');
                } else {

                    $result = Input::file('add_pdffile4')->move($destinationPath, $fileName);
                }

            }

            $file_data['user_id'] = $user_id;
            $file_data['group_id'] = $group_id;
            $file_data['file'] = $fileName;
            $file_data['level'] = 4;
            $file_data['file_type'] = $file_type;


            $chkfile = Noticeexcel::where("group_id", $group_id)->where("file_type", "=", $file_type)->
                where("level", "=", "4")->select("noticeexcel_id", "file")->first();


            if (isset($chkfile) && count($chkfile) > 0) {
                $noticeexcel_id = $chkfile['noticeexcel_id'];
                $file_name = $chkfile['file'];
                // $prevPath = './uploads/' . $group_id . '/noticeExcel/'. $file_name;

                // if (file_exists('uploads/' . $group_id . '/noticeExcel/'. $file_name)) {
                //     unlink('uploads/' . $group_id . '/noticeExcel/'. $file_name);
                // }
                Noticeexcel::where("noticeexcel_id", "=", $noticeexcel_id)->update($file_data);

            } else {
                Noticeexcel::insert($file_data);
            }

        }elseif (Input::hasFile('add_file5') || Input::hasFile('add_pdffile5')) {

            if (Input::file('add_file5')) {
                $file_type = "E";
                //die('exfsfsfsf');
                $file = Input::file('add_file5');
                $destinationPath = 'uploads/' . $group_id . '/noticeExcel/';
                $fileName = Input::file('add_file5')->getClientOriginalName();

                $messages = array("add_file5.required" => "add_file5 subject");
                $rules = array('add_file5' => 'required|max:10000|mimes:xls,xlsx');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper ecxel File only</font>');
                } else {

                    $result = Input::file('add_file5')->move($destinationPath, $fileName);
                }


            }


            if (Input::file('add_pdffile5')) {
                $file_type = "P";
                //die('pdfdfdf');
                $file = Input::file('add_pdffile5');
                $destinationPath = 'uploads/' . $group_id . '/noticepdf/';
                $fileName = Input::file('add_pdffile5')->getClientOriginalName();


                $messages = array("add_pdffile5.required" => "add_pdffile5 subject");
                $rules = array('add_pdffile5' => 'required|max:10000|mimes:pdf');
                $validator = Validator::make($postData, $rules, $messages);

                if ($validator->fails()) {

                    die('<font size="3" color="red">Upload Proper Pdf File only</font>');
                } else {

                    $result = Input::file('add_pdffile5')->move($destinationPath, $fileName);
                }

            }
            $file_data['user_id'] = $user_id;
            $file_data['group_id'] = $group_id;
            $file_data['file'] = $fileName;
            $file_data['level'] = 5;
            $file_data['file_type'] = $file_type;

            $chkfile = Noticeexcel::where("group_id", $group_id)->where("file_type", "=", $file_type)->
                where("level", "=", "5")->select("noticeexcel_id", "file")->first();

            if (isset($chkfile) && count($chkfile) > 0) {
                $noticeexcel_id = $chkfile['noticeexcel_id'];
                $file_name = $chkfile['file'];

                $file_name;

                Noticeexcel::where("noticeexcel_id", "=", $noticeexcel_id)->update($file_data);
            } else {
                Noticeexcel::insert($file_data);
            }
        }
        
        echo $fileName;

    }


    /*  public function excel_notice($user_id,$file_level,$file) {
    $data = array();
    $data['user_id'] = $user_id;
    $data['level'] = $file_level;
    $data['file'] = $file;
    return $data;
    
    }
    */


    public function pdf_upload()
    {

        $postData = Input::all();

        $arrData = array();
        $file_data = array();
        echo "<pre>";
        print_r($postData);
        exit;


    }


    public function swap_board1()
    {
        //print_r($_POST);

        $postData = Input::all();

        //echo $postData['order'];
        //die();

        $order = explode(",", $postData['order']);
        //print_r($order);


        foreach ($order as $o => $v) {
            $o++;
            Noticefont::where("noticefont_id", "=", $v)->update(array('sort_id' => $o));

        }
    }

    public function calenderview()
    {
        $data = array();
        return View::make('notice.calender', $data);
    }

    public function get_calender()
    {
        $data = array();
        $staff_details  = App::make('HomeController')->get_responsible_staff();
        if(isset($staff_details) && count($staff_details) >0){
            foreach ($staff_details as $key => $value) {
                $data[$key]['leave']      = "right_half";
                $data[$key]['leave_date'] = 10;
                $data[$key]['user_id']    = $value['user_id'];
                $data[$key]['name']       = $value['fname']." ".$value['lname'];
            }
        }
        
        echo json_encode($data);
    }
    
    public function viewfilenoticeboard()
    {   
        
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];
        $group_id = $admin_s['group_id'];  
        
        $fileid=Input::get("fileid");  

        $filepdf= Noticeexcel::where("noticeexcel_id","=",$fileid)->select('noticeexcel_id','file')->first();

         if($filepdf['file']){
            echo $path = '/uploads/' . $group_id . '/noticepdf/'.$filepdf['file']; 
         }
        
         die();
          
          
          
          
          $file = $path;
          $filename = $filepdf['file'];
          header('Content-type: application/pdf');
          header('Content-Disposition: inline; filename="' .$filename. '"');
          header('Content-Transfer-Encoding: binary');
          header('Accept-Ranges: bytes');
         
         echo @readfile($file); 
           
         //echo  @readfile($path);
            
// echo return Response::make(file_get_contents($path), 200, ['Content-Type' => 'application/pdf','Content-Disposition' => 'inline; '.$file['file']]);
                       
           
            //die();
                
                
                
    }
    
    public function calnderdemo(){
        $data['heading'] = "cal";
        $data['title'] = "calender";
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $group_id = $admin_s['group_id'];
        //print_r($user_id);die();
        $groupUserId = $admin_s['group_users'];
        
         return View::make('notice.calderdemo',$data);        
    }

    public function deletefilenoticeboard()
    {
        $admin_s    = Session::get('admin_details');
        $user_id    = $admin_s['id'];
        $group_id   = $admin_s['group_id'];

        $file_id    = Input::get("file_id");  
        Noticeexcel::where('noticeexcel_id', '=', $file_id)->delete();

        echo $file_id;
    }
    

}
