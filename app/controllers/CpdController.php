<?php
//opcache_reset ();
//Cache::forget('user_list');

class CpdController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)) {
            Redirect::to('/login')->send();
        }
        if (isset($session['user_type']) && $session['user_type'] == "C") {
            Redirect::to('/client-portal')->send();
        }
    }

    public function cpd_and_courses($type, $page)
    {
        //echo $type;
        // echo $page;
        //die();
        $data['heading'] = "CPD & COURSES";
        $data['title'] = "Cpd & Courses";
        if (base64_decode($type) == 'profile') {
            $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        } else {
            $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }
        $data['staff_type'] = base64_decode($type);

        $data['goto_url'] = '/cpd-and-courses';
        $data['type'] = $type;
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];
        $group_id = $admin_s['group_id'];

        $data['page_open']  = $page;
        $data['user_id']    = $user_id;
        $data['staff_details'] = User::getAllStaffDetails();

        /*if($page == 1){
            $data['course_report'] = Cpd::getAllDetails();
        }
        echo '<pre>';print_r($data['course_report']);die;*/

        $task_details=Cpd::WhereIn('user_id',$groupUserId)->select("*")->get();
        
        // echo $task_details->attendees;die();

        $data2 = array();
        if (!empty($task_details)) {
            foreach ($task_details as $key => $val) {

                $data2[$key]['cpd_id'] = $val->cpd_id;
                $data2[$key]['course_name'] = CpdCourseName::getCourseNameById($val->course_name);
                $data2[$key]['course_date'] = $val->course_date;
                $data2[$key]['course_time'] = $val->course_time;
                $data2[$key]['course_duration'] = $val->course_duration;

                $data2[$key]['notes']       = $val->notes;
                $data2[$key]['is_booked']   = $val->is_booked;
                $data2[$key]['is_log']      = $val->is_log;
                $data2[$key]['is_tracker']  = $val->is_tracker;
                $data2[$key]['user_id']     = unserialize($val->attendees);

                if (isset($val->attendees) && $val->attendees != "") {
                    $attendees = unserialize($val->attendees);
                    $userdetails = User::select("fname", "lname")->WhereIn("user_id", $attendees)->
                        get();

                    //echo '<pre>';print_r($userdetails);

                    $temp = array();
                    foreach ($userdetails as $indexkey => $username) {

                        $temp[$indexkey]['name'] = $username->fname . " " . $username->lname;
                    }
                    $data2[$key]['attendees'] = $temp;

                }

                $data2[$key]['created'] = $val->created;
                $data2[$key]['add_file'] = $val->file;
            }
            //die();


            if (!empty($data2)) {
                $data['course_report'] = $data2;
            }
        }

        //echo '<pre>';print_r($data['course_report']);die();
        //for profile
        $data3 = array();
        $profiletask_details = DB::select(DB::raw("SELECT * FROM cpds WHERE`attendees`!='' "));
        //echo '<pre>'; print_r($profiletask_details);die();
        if (!empty($profiletask_details)) {
            foreach ($profiletask_details as $key => $val) {
                if (isset($val->attendees) && $val->attendees != "") {
                    $attendees = unserialize($val->attendees);
                    // echo '<pre>';
                    // print_r($attendees);
                }

                if (in_array($user_id, $attendees)) {

                    $data3[$key]['cpd_id'] = $val->cpd_id;
                    $data3[$key]['course_name'] = CpdCourseName::getCourseNameById($val->course_name);
                    $data3[$key]['course_date'] = $val->course_date;
                    $data3[$key]['course_time'] = $val->course_time;
                    $data3[$key]['course_duration'] = $val->course_duration;

                    $data3[$key]['notes']       = $val->notes;
                    $data3[$key]['is_booked']   = $val->is_booked;
                    $data3[$key]['is_log']      = $val->is_log;
                    $data3[$key]['is_tracker']  = $val->is_tracker;

                    $data3[$key]['created'] = $val->created;
                    $data3[$key]['add_file'] = $val->file;
                    if (isset($val->attendees) && $val->attendees != "") {
                        $attendees = unserialize($val->attendees);
                        $userdetails = User::select("fname", "lname")->WhereIn("user_id", $attendees)->get();

                        $temp1 = array();
                        foreach ($userdetails as $indexkey => $username) {
                            $temp1[$indexkey]['name'] = $username->fname . " " . $username->lname;
                        }
                        $data3[$key]['attendees'] = $temp1;
                    }
                }

           }

            if (!empty($data3)) {
                $data['profcourse_report'] = $data3;
            }

       }


       $data['courses_name'] = CpdCourseName::getAllCourseName();

        //echo '<pre>';print_r($data['profcourse_report']);die();
        return View::make('staff.cpd.cpd_and_courses', $data);

    }


    public function insertcpd()
    {
        $data       = array();
        $postData   = Input::all();

        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $groupUserId    = $admin_s['group_users'];//
        $group_id       = $admin_s['group_id'];

        $page_open  = $postData['page_open'];
        $type       = $postData['type'];

        //$data['groupid']=$group_id;
        $data['user_id'] = $user_id;
        if (isset($postData['coursename'])) {
            $data['course_name'] = $postData['coursename'];
        }

        if (isset($postData['coursedate']) && $postData['coursedate'] != "") {
            $data['course_date'] = date('Y-m-d', strtotime($postData['coursedate']));
        }
        if (isset($postData['coursetime']) && $postData['coursetime'] != "") {
            $data['course_time'] = str_replace(' ', '', $postData['coursetime']).':00';
        }

        if (isset($postData['courseduration']) && $postData['courseduration'] != "") {
            $data['course_duration'] = $postData['courseduration'];
        }
        if (isset($postData['coursenotes']) && $postData['coursenotes'] != "") {
            $data['notes'] = $postData['coursenotes'];
        }

        if (isset($postData['satff']) && $postData['satff'] != "") {
            $data['attendees'] = serialize($postData['satff']);
        }


        //echo '<pre>';print_r($data);die();
        $course_id = Cpd::insertGetId($data);
        if ($course_id) {
            if (Input::hasFile('add_file')) {
                $file           = Input::file('add_file');
                $destination    = "uploads/cpd";
                $fileName       = Input::file('add_file')->getClientOriginalName();

                $fileName       = $course_id . $fileName;
                $result         = Input::file('add_file')->move($destination, $fileName);

                $file_data['file'] = $fileName;
                Cpd::where("cpd_id", "=", $course_id)->update($file_data);
            }
        }


        //return Redirect::to('/cpd-and-courses/'.$type.'/'.$page_open);
        echo $course_id;die();
    }

    public function getcpdnotes()
    {
        $cpd_id = Input::get('cpdid');
        $cpdnotes = Cpd::where("cpd_id", "=", $cpd_id)->select("notes")->first();
        if ($cpdnotes != "") {
            echo $cpdnotes['notes'];
            die();
        }
    }

    public function delcourses()
    {
        $users = array();
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        $cpddelid   = Input::get('cpddelid');
        $field_name = Input::get('field_name');

        if($field_name == 'is_tracker' || $field_name == 'is_log'){
            $value = Cpd::getDetailsByCpdId($cpddelid);
            if(isset($value['user_id']) && count($value['user_id']) >0){
                foreach ($value['user_id'] as $key => $userId) {
                   if($user_id != $userId){
                        $users[$key] = $userId;
                   }
                }
            }
            //print_r($value);die;
            $updata['attendees'] = !empty($users)?serialize($users):'';
        }else{
            $updata[$field_name] = 'N';
        }
        
        $cpddelid = Cpd::where("cpd_id", "=", $cpddelid)->update($updata);
        echo $cpddelid;
    }

    public function getcourses()
    {

        $cpd_id = Input::get('cpdid');

        $cpdnotes = Cpd::where("cpd_id", "=", $cpd_id)->select("cpd_id", "notes",
            "user_id", "course_name", "course_date", "course_time", "course_duration",
            "notes", "file", "attendees", "created")->first();
        //$cpdnotes = Cpd::getDetailsByCpdId($cpd_id);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($cpdnotes);
        exit;
    }

    public function pdfbookedcourses()
    {

        //die('adafafaf');


        //echo $type;
        // echo $page;
        //die();
        /* 	$data['heading'] = "CPD & COURSES";
        $data['title'] = "Cpd & Courses";
        if(base64_decode($type) == 'profile'){
        $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        }else{
        $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }
        $data['staff_type'] = base64_decode($type);
        
        $data['goto_url'] ='/cpd-and-courses';
        $data['type'] =$type; */
        $t = time();
        $time = date("Y-m-d H:i:s", $t);
        $pieces = explode(" ", $time);
        $data['cdate'] = $pieces[0];

        $data['ctime'] = $pieces[1];

        $today = date("j F  Y");
        $data['today'] = $today;

        $time = date(" G:i:s ");
        $data['time'] = $time;
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        // $data['page_open']=$page;
        //$data['staff_details'] 	= User::getAllStaffDetails();

        $task_details = DB::select(DB::raw("SELECT * FROM cpds WHERE `user_id`='$user_id'"));
        // print_r($task_details);die();
        $data2 = array();
        if (!empty($task_details)) {
            foreach ($task_details as $key => $val) {

                $data2[$key]['cpd_id'] = $val->cpd_id;
                //$data2[$key]['staff_detail'] = User::where("user_id", "=", $val->user_)->select("user_id", "fname", "lname")->first();
                /* $data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val->rel_client_id)->
                where(function ($query)
                {
                $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                "client_name"); }
                )->first(); */
                $data2[$key]['course_name'] = $val->course_name;
                $data2[$key]['course_date'] = $val->course_date;
                $data2[$key]['course_time'] = $val->course_time;
                $data2[$key]['course_duration'] = $val->course_duration;

                $data2[$key]['notes'] = $val->notes;
                $data2[$key]['attendees'] = $val->attendees;
                $data2[$key]['created'] = $val->created;
                $data2[$key]['add_file'] = $val->file;

                $data2[$key]['user_name'] = User::select('fname', 'lname')->where("user_id", "=",
                    $val->attendees)->first();

            }


            if (!empty($data2)) {
                $data['course_report'] = $data2;
            }

            /* foreach ($data['course_report'] as $key => $val) {
            
            $atten=User::select('fname','lname')->where("user_id","=",$val['attendees'])->first();
            
            
            print_r($atten['fname']);
            } */

        }


        //die();


        //echo '<pre>';print_r($data['course_report']);die();

        // return View::make('staff.cpd.pdfbookedcourses',$data);

        $pdf = PDF::loadView('staff.cpd.pdfbookedcourses', $data)->setPaper('a4')->
            setOrientation('landscape')->setWarnings(false);
        return $pdf->download('Cpdbookedcourses.pdf');


    }

    public function excelbookedcourses()
    {

        $t = time();
        $time = date("Y-m-d H:i:s", $t);
        $pieces = explode(" ", $time);
        $data['cdate'] = $pieces[0];

        $data['ctime'] = $pieces[1];

        $today = date("j F  Y");
        $data['today'] = $today;

        $time = date(" G:i:s ");
        $data['time'] = $time;
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        // $data['page_open']=$page;
        //$data['staff_details'] 	= User::getAllStaffDetails();

        $task_details = DB::select(DB::raw("SELECT * FROM cpds WHERE `user_id`='$user_id'"));
        // print_r($task_details);die();
        $data2 = array();
        if (!empty($task_details)) {
            foreach ($task_details as $key => $val) {

                $data2[$key]['cpd_id']      = $val->cpd_id;
                $data2[$key]['course_name'] = $val->course_name;
                $data2[$key]['course_date'] = $val->course_date;
                $data2[$key]['course_time'] = $val->course_time;
                $data2[$key]['course_duration'] = $val->course_duration;

                $data2[$key]['notes']       = $val->notes;
                $data2[$key]['attendees']   = $val->attendees;
                $data2[$key]['created']     = $val->created;
                $data2[$key]['add_file']    = $val->file;

                $data2[$key]['user_name'] = User::select('fname', 'lname')->where("user_id", "=",
                    $val->attendees)->first();
            }


            if (!empty($data2)) {
                $data['course_report'] = $data2;
            }


        }

        $viewToLoad = 'staff.cpd.excelbookedcourses';
        ///////////  Start Generate and store excel file ////////////////////////////
        Excel::create('Bookedcourses', function ($excel)use ($data, $viewToLoad)
        {
            $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
            {
                $sheet->loadView($viewToLoad)->with($data); }
            )->save(); }
        );

        $filepath = storage_path() . '/exports/Bookedcourses.xls';
        $fileName = 'Bookedcourses.xls';
        $headers = array('Content-Type: application/vnd.ms-excel', );

        return Response::download($filepath, $fileName, $headers);
        exit;

    }
    
    
    
    public function editcpd()
    {
        $postData = Input::all();
    //echo '<pre>';print_r($postData);die();
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];
        $group_id = $admin_s['group_id'];    
        
        $edit_id=$postData['edit_id'];
        $data= array();
        if (isset($postData['editcoursename'])) {
            $data['course_name'] = $postData['editcoursename'];
        }
        
        if (isset($postData['editcoursedate']) && $postData['editcoursedate'] != "") {
            $data['course_date'] = date('Y-m-d', strtotime($postData['editcoursedate']));
        }

        if (isset($postData['editcoursetime']) && $postData['editcoursetime'] != "") {
            $data['course_time'] = $postData['editcoursetime'];
        }

        if (isset($postData['editcourseduration']) && $postData['editcourseduration'] != "") {
            $data['course_duration'] = $postData['editcourseduration'];
        }

        if (isset($postData['editcoursenotes']) && $postData['editcoursenotes'] != "") {
            $data['notes'] = $postData['editcoursenotes'];
        }

        if (isset($postData['attendeeschecked']) && $postData['attendeeschecked'] != "") {
            $arr = $postData['attendeeschecked'];
            $arrattendees = serialize($arr);
            $data['attendees'] = $arrattendees;
        }else{
            $data['attendees'] = "";
        }
        
        Cpd::where("cpd_id", "=", $edit_id)->update($data);
       
        if (Input::hasFile('edit_file')) {
            $file = Input::file('edit_file');
            $destinationPath = "uploads/cpd";
            $fileName = Input::file('edit_file')->getClientOriginalName();

            $fileName = $edit_id . $fileName;
            $result = Input::file('edit_file')->move($destinationPath, $fileName);

            $file_data['file'] = $fileName;
            Cpd::where("cpd_id", "=", $edit_id)->update($file_data);
        }
            
        return Redirect::to('/cpd-and-courses/c3RhZmY=/1');
    }


    public function add_course_name()
    {
        $admin_s = Session::get('admin_details');

        $data['user_id']        = $admin_s['id'];
        $data['course_name']    = Input::get('course_name');
        $last_id = CpdCourseName::insertGetId($data);
        echo $last_id;
    }

    public function delete_course_name()
    {
        $field_id   = Input::get('field_id');
        CpdCourseName::where('cname_id', '=', $field_id)->delete();
        echo $field_id;
    }





}
