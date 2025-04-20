<?php
//opcache_reset ();
//Cache::forget('user_list');

class StaffholidaysController extends BaseController
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

    public function staff_holidays($type, $tab_open, $start_date)
    {
        $holiday_type = 1;
        if (base64_decode($type) == 'profile') {
            $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        } else {
            $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }
        $data['staff_type'] = base64_decode($type);
        $data['heading']    = "HOLIDAYS/TIME OFF ";
        $data['title']      = "Staff Holidays";
        $start = base64_decode($start_date);
        $data['start_date'] = $start;
        if($start_date != "new"){
          $data['roll_back'] = date('d-m-Y',strtotime('-1 year',strtotime($start)));
          $data['roll_fwd']  = date('d-m-Y', strtotime('+1 year', strtotime($start)));
          $data['end_date']  = date('d-m-Y',strtotime('-1 day',strtotime($data['roll_fwd'])));
        }else{
          $data['roll_back'] = "";
          $data['roll_fwd']  = "";
          $data['end_date']  = "";
        }

        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type']  = $session['user_type'];
        $groupUserId        = $session['group_users'];
        $data['page_open']  = $tab_open;
        $data['logged_id']  = $user_id;
        //print_r($groupUserId);die();
        if ($tab_open == "1" && $data['staff_type'] == "staff") {
            /*$awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                "=", "Awaiting Approval")->orWhere('state', '=', 'Request Withdrawn')->orderBy('holidayrequest_id',
                'DESC')->get();*/

            $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where(function ($q) {
                $q->where("state", "=", "Awaiting Approval")->orWhere('state', '=', 'Request Withdrawn')->orWhere('state', '=', 'Approved')->orWhere('state', '=', 'Declined');
            })->orderBy('holidayrequest_id', 'DESC')->get();


        } else if ($tab_open == "2" && $data['staff_type'] == "staff") {
            $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                "=", "Approved")->orderBy('holidayrequest_id', 'DESC')->select("*")->get();
        } else if ($tab_open == "3" && $data['staff_type'] == "staff") {
            $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                "=", "Declined")->orderBy('holidayrequest_id', 'DESC')->select("*")->get();
        }

        if ($tab_open == "4" && $data['staff_type'] == "staff") {
            $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                "=", "Approved")->orWhere('state', '=', 'Declined')->orderBy('holidayrequest_id',
                'DESC')->get();
        }
        //echo $this->last_query();die;

        if (!empty($awating_staff)) {
            foreach ($awating_staff as $key => $val) {

                $data2[$key]['holidayrequest_id'] = $val['holidayrequest_id'];
                $data2[$key]['staff_detail'] = User::where("user_id", "=", $val['staff'])->
                    select("user_id", "fname", "lname")->first();
                $data2[$key]['stafftype']   = $val['stafftype'];
                $data2[$key]['staff']       = $val['staff'];
                $data2[$key]['date']        = date('d-m-Y', strtotime($val['date']));
                $data2[$key]['duration']    = $val['duration'];
                $data2[$key]['requesttype'] = $val['requesttype'];
                $data2[$key]['type_name'] = HolidayType::getTypeNameById($val['requesttype']);
                $data2[$key]['notes']       = $val['notes'];
                $data2[$key]['state']       = $val['state'];
                $data2[$key]['archive']     = $val['archive'];
                $data2[$key]['created']     = date("d-m-Y", strtotime($val['created']));

            }
            //echo $val;die();
            if (!empty($data2)) {
                $data['awating_staff'] = $data2;
            }
        }

        $data['profilesection'] = DB::table('holidayrequests')->where('user_id', '=', $user_id)->orWhere(function ($query)
        {
            $session = Session::get('admin_details'); 
            $user_id = $session['id']; 
            $query->where('staff', '=', $user_id); 
        })->orderBy('holidayrequest_id', 'DESC')->get();
        
        if(isset($data['profilesection']) && count($data['profilesection']) >0){
            foreach($data['profilesection'] as $key=>$val){
                $data['profilesection'][$key]->type_name = HolidayType::getTypeNameById($val->requesttype);
            }
        }

        
        $data['staff_details']      = User::getAllStaffName();
        $data['old_holiday_types']  = HolidayType::getHolidayTypes('O');
        $data['new_holiday_types']  = HolidayType::getHolidayTypes('N');
        $data['holiday_details']    = HolidayDetail::getHolidayDetails();
        
        $data['months']         = Month::getMonthDetails();
        $data['settings']       = $this->getHolidayStaffDetails($holiday_type, $start);
        $data['colors']         = Color::getAllDetails();

        //if($tab_open == 5){
            $data['full_months']    = Common::get_full_months();
            $calender_type = array_merge($data['old_holiday_types'], $data['new_holiday_types']);
            $data['holiday_types']    = array_values($calender_type);
        //}
        
        //echo '<pre>'; print_r($data['profilesection']);die();

        return View::make('staff.staffholidays.staff_holidays', $data);

    }

    public function getHolidayStaffDetails($type_id, $holiday_start)
    {
        $details    = User::getAllStaffDetails();
        $data       = array();
        
        if(isset($details) && count($details) >0){
          foreach ($details as $key => $value) {
            $remaining          = 0;
            $current_days_taken = 0;
            $holiday_taken      = 0;
            $last_year_leave    = 0;

            $data[$key]     = $value;
            $user_id        = $value['user_id'];

            $staff_holiday  = StaffHoliday::staffHolidayByStaffId($user_id);
            $data[$key]['staff_holiday'] = $staff_holiday;

            if(isset($value['step_data']['start_date']) && isset($staff_holiday['ent_days'])){
                /* Current Holiday Year pop up ======== */
                $holiday_date = HolidayDetail::getHolidayDate();
                if(isset($holiday_date) && $holiday_date == $holiday_start){
                    $holiday_taken = $staff_holiday['days_taken'];
                }

                $remaining = $this->getDaysRemaining($value['step_data']['start_date'], $staff_holiday['ent_days'], $holiday_start);
                
                $current_days_taken = Holidayrequest::countLeaveByStateAndId('Approved', $user_id, $type_id, $holiday_start);
                $remaining -= ($current_days_taken+$holiday_taken);

                /* ==========Last year leave =======*/
                $last_year_leave = PastLeaveDetail::getPastLeave($user_id, $holiday_start);

                
                //echo $this->last_query();
            }
            $data[$key]['remaining']            = number_format($remaining, 2, '.', '');
            $data[$key]['current_days_taken']   = $current_days_taken+$holiday_taken;
            $data[$key]['holiday_days_taken']   = isset($current_days_taken)?$current_days_taken:0;
            $data[$key]['last_year_leave']      = number_format($last_year_leave, 2, '.', '');
            $total_leave = $remaining + $last_year_leave;
            $data[$key]['total_leave']          = number_format($total_leave, 2, '.', '');
            //echo $data[$key]['remaining'];die;
          }
        }
        //echo "<pre>";print_r($data);die;
        return $data;
    }

    /*public function getHolidayStaffDetails($type_id)
    {
        $details    = User::getAllStaffDetails();
        $data       = array();
        
        if(isset($details) && count($details) >0){
          foreach ($details as $key => $value) {
            $remaining          = 0;
            $current_days_taken = 0;
            $last_year_leave    = 0;

            $data[$key] = $value;
            $user_id     = $value['user_id'];

            $staff_holiday = StaffHoliday::staffHolidayByStaffId($value['user_id']);
            $data[$key]['staff_holiday'] = $staff_holiday;

            if(isset($value['step_data']['start_date']) && isset($staff_holiday['ent_days'])){
                $remaining = $this->getDaysRemaining($value['step_data']['start_date'], $staff_holiday['ent_days']);
                $opening_days_taken = $staff_holiday['days_taken'];
                $current_days_taken = Holidayrequest::countLeaveByStateAndId('Approved', $user_id, $type_id);
                $remaining -= ($opening_days_taken + $current_days_taken);

                $hol_detls  = HolidayDetail::getHolidayDetails();
                //echo $this->last_query();die;
                if(isset($hol_detls['holiday_date']) && $hol_detls['holiday_date'] !=''){
                    $start = date('Y-m-d', strtotime('-1 year', strtotime($hol_detls['holiday_date'])));
                    $end = date('Y-m-d', strtotime('-1 year', strtotime($hol_detls['holiday_end'])));
                    $past_lv = Holidayrequest::countLeaveByDateRange($start, $end, $user_id);
                    //echo $past_lv;die;//echo $this->last_query();die;
                    if(isset($past_lv) && $past_lv != 'N')
                        $last_year_leave = $staff_holiday['ent_days']-$past_lv;
                }
                
            }
            $data[$key]['remaining'] = number_format($remaining+$last_year_leave, 2, '.', '');
            $data[$key]['current_days_taken']   = $current_days_taken;
            $data[$key]['last_year_leave']      = $last_year_leave;
            //echo $data[$key]['remaining'];die;
          }
        }
        return $data;
    }*/


  public function staffholidaysrequest()
  {

    $session    = Session::get('admin_details');
    $user_id    = $session['id'];
    //$data['user_type'] = $session['user_type'];
    $groupUserId = $session['group_users'];
    $group_id   = $session['group_id'];

    $data1      = $data = array();
    $stafftype  = Input::get("stafftype");
    $state      = 'Awaiting Approval';
    $start_date = base64_encode(Input::get("start_date"));

    $staff                  = Input::get("staff");
    $data1['date']          = Input::get("date");
    $data1['duration']      = Input::get("duration");
    $data1['requesttype']   = Input::get("requesttype");
    $data1['notes']         = Input::get("notes");

    for ($i = 0; $i < count($data1['date']); $i++) {
      $data[$i]['stafftype']  = $stafftype;
      $data[$i]['state']      = $state;
      $data[$i]['user_id']    = $user_id;
      $data[$i]['group_id']   = $group_id;
      if ($staff != "0") {
          $data[$i]['staff']  = $staff;
      } else {
          $data[$i]['staff']  = $user_id;
      }
      $data[$i]['date']       = date("Y-m-d", strtotime($data1['date'][$i]));
      $data[$i]['duration']   = $data1['duration'][$i];
      $data[$i]['requesttype']= $data1['requesttype'][$i];
      $data[$i]['notes']      = str_replace("'", "`", $data1['notes'][$i]);
      
      $insert_id[$i] = Holidayrequest::insertGetId($data[$i]);

      $data[$i]['type_name']  = HolidayType::getTypeNameById( $data1['requesttype'][$i] );
      $data[$i]['staff_name'] = User::getStaffNameById($data[$i]['staff']);

      /* Email send notifications */
      $HOSTNAME = Config::get('constant.HOSTNAME');
      if($HOSTNAME != 'eweb.ipractice.com'){
        Holidayrequest::sendNotification( $data[$i], $staff );
      }
    }

    if ($stafftype == "staff") {
        return Redirect::to('/staff-holidays/c3RhZmY=/1/'.$start_date);
    } else if ($stafftype == "profile") {
        return Redirect::to('staff-holidays/cHJvZmlsZQ==/1/'.$start_date);
    }

  }

  public function statechange()
  {
    $statename          = Input::get("statename");
    $holidayrequest_id  = Input::get('holidayrequest_id');
    $data['state']      = $statename;
    $data_archive       = array();
    if (Request::ajax()) {
      if ($statename == "delete") { 
        Holidayrequest::where("holidayrequest_id", $holidayrequest_id)->delete();
      } elseif ($statename == "archive" || $statename == "unarchive") {

        if ($statename == "archive") {
            $data_archive['archive'] = "archive";
        } else {
            $data_archive['archive'] = "unarchive";
        }
        Holidayrequest::where("holidayrequest_id", $holidayrequest_id)->update($data_archive);
      } else {
        $old_state = Holidayrequest::getStateNameById($holidayrequest_id);
        $data['approved_date'] = date('Y-m-d');
        Holidayrequest::where("holidayrequest_id", $holidayrequest_id)->update($data);
        /* Email send notifications */
        $HOSTNAME = Config::get('constant.HOSTNAME');
        if($HOSTNAME != 'eweb.ipractice.com'){
          if($statename=='Approved' || $statename=='Declined' || $statename=='Awaiting Approval'){
            Holidayrequest::sendStateChangeNotification( $holidayrequest_id, $old_state );
          }
        }
      }

      echo $holidayrequest_id;
    }

  }

    public function getrequestdetails()
    {

        $holidayrequest_id = Input::get('holidayrequest_id');

        $Holidayrequestdetails = Holidayrequest::where("holidayrequest_id", "=", $holidayrequest_id)->
            first();

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($Holidayrequestdetails);
        exit;


    }


    public function editstaffholidaysrequest()
    {

        $postData = Input::all();
        //echo "<pre>";
        //print_r($postData);
        //die();
        $tmpl_data= array();

        if (isset($postData['staff']) && !empty($postData['staff'])) {
            $tmpl_data['staff'] = $postData['staff'];
        }
        if (isset($postData['date']) && !empty($postData['date'])) {
            $tmpl_data['date'] = date('Y-m-d', strtotime($postData['date']));
        }

        if (isset($postData['duration']) && !empty($postData['duration'])) {
            $tmpl_data['duration'] = $postData['duration'];
        }
        if (isset($postData['requesttype']) && !empty($postData['requesttype'])) {
            $tmpl_data['requesttype'] = $postData['requesttype'];
        }

        if (isset($postData['notes']) && !empty($postData['notes'])) {
            $tmpl_data['notes'] = $postData['notes'];
        }
        $holidayrequest_id=$postData['editid'];
        //echo '<pre>';print_r($tmpl_data);die();
        
         Holidayrequest::where("holidayrequest_id", "=", $holidayrequest_id)->update($tmpl_data);
          return Redirect::to('/staff-holidays/c3RhZmY=/1/'.base64_encode($postData['start_date']));  
    }
    
    
    public function holidaypdf($type, $tab_open,$filetype){
        //echo $filetype;
        //echo $tab_open; 
      //  die();
         $t                  = time();
        $time               = date("Y-m-d H:i:s", $t);
        $pieces             = explode(" ", $time);
        $data['cdate']      = $pieces[0];
        $data['ctime']      = $pieces[1];
        $today              = date("j F  Y");
        $data['today']      = $today;
        $time               = date(" G:i:s ");
        $data['time']       = $time;
        $data['staff_type'] = base64_decode($type);
        $data['heading'] = "HOLIDAYS/TIME OFF ";
        $data['title'] = "Staff Holidays";

        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type'] = $session['user_type'];
        $groupUserId = $session['group_users'];
        $data['page_open'] = $tab_open;
        //print_r($groupUserId);die();
        if ($tab_open == "1" && $data['staff_type'] == "staff") {
            $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                "=", "Awaiting Approval")->orWhere('state', '=', 'Request Withdrawn')->orderBy('holidayrequest_id',
                'DESC')->select("*")->get();


        } else
            if ($tab_open == "2" && $data['staff_type'] == "staff") {
                $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                    "=", "Approved")->orderBy('holidayrequest_id', 'DESC')->select("*")->get();
            } else
                if ($tab_open == "3" && $data['staff_type'] == "staff") {
                    $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                        "=", "Declined")->orderBy('holidayrequest_id', 'DESC')->select("*")->get();
                }

        if ($tab_open == "4" && $data['staff_type'] == "staff") {
            $awating_staff = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                "=", "Approved")->orWhere('state', '=', 'Declined')->orderBy('holidayrequest_id',
                'DESC')->select("*")->get();


        }

        if (!empty($awating_staff)) {
            foreach ($awating_staff as $key => $val) {

                $data2[$key]['holidayrequest_id'] = $val['holidayrequest_id'];
                $data2[$key]['staff_detail'] = User::where("user_id", "=", $val['staff'])->
                    select("user_id", "fname", "lname")->first();
                $data2[$key]['stafftype']   = $val['stafftype'];
                $data2[$key]['staff']       = $val['staff'];
                $data2[$key]['date']        = date('d-m-Y', strtotime($val['date']));
                $data2[$key]['duration']    = $val['duration'];
                $data2[$key]['requesttype'] = $val['requesttype'];
                $data2[$key]['notes']       = $val['notes'];
                $data2[$key]['state']       = $val['state'];
                $data2[$key]['archive']     = $val['archive'];
                $data2[$key]['created']     = date("d-m-Y", strtotime($val['created']));

            }
            //echo $val;die();
            if (!empty($data2)) {
                $data['awating_staff'] = $data2;
            }
        }



        $data['profilesection'] = DB::table('holidayrequests')->where('user_id', '=', $user_id)->
            orWhere(function ($query)
        {
            $session = Session::get('admin_details'); $user_id = $session['id']; $query->
                where('staff', '=', $user_id); }
        )->orderBy('holidayrequest_id', 'DESC')->get();

       

        $data['staff_details'] = User::whereIn("user_id", $groupUserId)->where("client_id",
            "=", 0)->select("user_id", "fname", "lname")->get();


             if($data['page_open']==1)
                    $file_name="AWATING APPROVAL";
                    
                        
                         if($data['page_open']==2)
                    $file_name="APPROVED";
              
                    if($data['page_open']==3)
                   $file_name="DECLINED";
             
                    if($data['page_open']==4)
                    $file_name="ARCHIVE";
                  
                   if($data['page_open']==5)
                   $file_name="HOLIDAY PLANNER";
                  
                  //;echo '<pre>';print_r($data['awating_staff']);die();
       if($filetype=="pdf")
       {
        $pdf = PDF::loadView('staff/staffholidays/pdfholidays', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            return $pdf->download($file_name.'.pdf');
            
       }
       else{
          $viewToLoad = 'staff/staffholidays/excelholidays';
            ///////////  Start Generate and store excel file ////////////////////////////
            Excel::create('Organisation_clients_list', function ($excel)use ($data, $viewToLoad)
            {
                $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
                {
                    $sheet->loadView($viewToLoad)->with($data); }
                )->save(); }
            );
            $filepath = storage_path() . '/exports/Organisation_clients_list.xls';
            $fileName = $file_name.'.xls';
            $headers = array('Content-Type: application/vnd.ms-excel', );
    
            return Response::download($filepath, $fileName, $headers);
            exit;
       }
         
    }
    
    
    /*public function save_holiday()
    {
        $session    = Session::get('admin_details');
        $user_id    = $session['id'];
        $type       = base64_encode(Input::get('type'));
        $page_open  = Input::get('page_open');
        $roll_over  = Input::get('allow_rollover');
        if(isset($roll_over) && $roll_over != ""){
            $roll_over = 'Y';
        }else{
            $roll_over = 'N';
        }

        $data['user_id']            = $user_id;
        $data['holiday_day']        = Input::get('holiday_day');
        $data['holiday_month']      = Input::get('holiday_month');
        $data['allow_rollover']     = $roll_over;
        $data['timeoff_type_id']    = Input::get('timeoff_type_id');
        $details = HolidayDetail::getHolidayDetails();
        if(isset($details) && count($details) >0){
            HolidayDetail::where('holiday_id', '=', $details['holiday_id'])->update($data);
        }else{
            HolidayDetail::insert($data);
        }
        
        return Redirect::to('/staff-holidays/'.$type.'/'.$page_open);
    }*/

    public function save_holiday()
    {
        $session            = Session::get('admin_details');
        $user_id            = $session['id'];
        $groupUserId        = $session['group_users'];
        $field_name         = Input::get('field_name');
        $field_value        = Input::get('field_value');
        $data['user_id']    = $user_id;

        if(isset($field_name) && $field_name == "holiday_date" || $field_name == "roll_date"){
            $data["holiday_date"]      = date('Y-m-d', strtotime($field_value));
            $holiday_end    = date('Y-m-d', strtotime('+1 year', strtotime($field_value)));
            $data['holiday_end'] = date('Y-m-d',strtotime('-1 day',strtotime($holiday_end)));

            if($field_name == "roll_date"){
                $pld['user_id']     = $user_id;
                $pld['start_date']  = date('Y-m-d', strtotime('-1 years', strtotime($field_value)));
                $pld['end_date']    = date('Y-m-d', strtotime('-1 years', strtotime($data['holiday_end'])));
                
                
                PastLeaveDetail::insert($pld);
            }

            $stf_data['days_taken'] = 0;
            StaffHoliday::whereIn("user_id", $groupUserId)->update($stf_data);
        }else{
            $data[$field_name]   = $field_value;
        }

        $holiday_id = HolidayDetail::getHolidayId();
        if(isset($holiday_id) && $holiday_id != ""){
            HolidayDetail::where('holiday_id', '=', $holiday_id)->update($data);
        }else{
            $data['created'] = date('Y-m-d H:i:s');
            HolidayDetail::insert($data);
        }
        $final_details = HolidayDetail::getHolidayDetails();
        $final_details['encode_start_date'] = base64_encode($final_details['holiday_date']);
        echo json_encode($final_details);
        exit;
    }

    public function save_staff_holiday()
    {
        $remaining = 0;
        $session    = Session::get('admin_details');
        $user_id    = $session['id'];
        $action     = Input::get('action');

        $data['staff_id']      = Input::get('staff_id');
        $data['user_id']       = $user_id;
        $start_date            = Input::get('start_date');
        $days_taken            = Input::get('days_taken');
        $holiday_start         = Input::get('holiday_start');
        $holiday_type          = 1;

        if($action == '1'){//start_date
            StepsFieldsStaff::updateField('start_date', $data['staff_id'], $start_date);
            $data['ent_days']  = Input::get('ent_days');
            $remaining = $this->getDaysRemaining($start_date, $data['ent_days'], $holiday_start);
        }else{
            $data['notes']     = Input::get('notes');
        }
        
        $details = StaffHoliday::staffHolidayByStaffId($data['staff_id']);
        if(isset($details) && count($details) >0){
            $id = $details['staff_holiday_id'];
            StaffHoliday::where('staff_holiday_id', '=', $id)->update($data);
        }else{
            StaffHoliday::insert($data);
        }
        
        $current_days = Holidayrequest::countLeaveByStateAndId('Approved', $data['staff_id'], $holiday_type, $holiday_start);
        $total_days_taken           = $days_taken+$current_days;
        $data['remaining']          = number_format($remaining-$total_days_taken, 2, '.', '');
        $data['current_days_taken'] = $current_days;
        $data['start_date']         = $start_date;
        echo json_encode($data);
    }

    public function getDaysRemaining($start_date, $ent_days, $holiday_start)
    {//echo $start_date;
        $remaining      = 0;
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = HolidayDetail::getHolidayDetails();
        
        if(isset($details) && count($details) >0){
            $start          = date('d-m-Y', strtotime($holiday_start));
            $holiday_end    = date('d-m-Y', strtotime('+1 year', strtotime($holiday_start)));
            $end            = date('d-m-Y', strtotime('-1 day', strtotime($holiday_end)));
            
            $start_check    = Common::dayDifference($start_date, $start);
            

            if($start_check >= 0){//$start > $start_date
                $days   = Common::getDaysDifference($end, $start_date);
            }else{//die('e');
                $days = Common::getDaysDifference($start, $end);
            }

            $divided_by = Common::getDaysDifference($start, $end);
            $remaining  = $ent_days*$days/$divided_by;
        }//echo $remaining;
        return number_format($remaining, 2, '.', '');
    }

    /*public function getDaysRemaining($start_date, $ent_days)
    {
        $remaining      = 0;
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = HolidayDetail::getHolidayDetails();
        //$check_date = Common::getDaysDifference($start_date, $date);
        if(isset($details) && count($details) >0){
            $day        = $details['holiday_day'];
            $month      = $details['holiday_month'];
            //$date       = $day.'-'.$month.'-'.date('Y', strtotime('+1 years'));
            $date       = $day.'-'.$month.'-'.date('Y');
            $check_day  = Common::dayDifference($date, $start_date);
            if($check_day >0){//die('w');
                $next_date = ($day-1).'-'.$month.'-'.date('Y', strtotime('+1 years'));
                $days   = Common::getDaysDifference($next_date, $date);
                $date2  = ($day+1).'-'.$month.'-'.date('Y', strtotime('-1 years'));
            }else{//die('e');
                $date   = $day.'-'.$month.'-'.date('Y', strtotime('+1 years'));
                $days   = Common::getDaysDifference($start_date, $date);
                $date2  = ($day-1).'-'.$month.'-'.date('Y', strtotime('+1 years'));
            }

            $prev_day   = $day.'-'.$month.'-'.date('Y');
            $div_count  = Common::getDaysDifference($date2, $prev_day);
            $remaining  = ($ent_days*$days)/($div_count+1);
        }//echo $div_count;
        return number_format($remaining, 2, '.', '');
    }*/

    public function save_holiday_type()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $data['name']       = Input::get('name'); 
        $data['color']      = Input::get('color');       
        $data['user_id']    = $user_id;
        $data['status']     = 'N';
        $data['is_show']    = 'Y';
        $data['created']    = date('Y-m-d');
        $last_id = HolidayType::insertGetId($data);
        $final_details = HolidayType::getHolidayTypesById($last_id);
        echo json_encode($final_details);
        exit;
    }

    public function delete_holiday_type()
    {
        $session      = Session::get('admin_details');
        $user_id      = $session['id'];
        $type_id      = Input::get('type_id');        
        $sql = HolidayType::where('type_id', '=', $type_id)->delete();
        echo $sql;
    }

    
    public function get_holiday_details()
    {//ajax call from the header dropdown
        $data       = array();
        $staff_id   = Input::get('staff_id');
        $type_id    = Input::get('type_id');
        $start_date = Input::get('start_date');
        $details = $this->getHolidayStaffDetails($type_id, $start_date);
        if(isset($details) && count($details) >0){
            foreach($details as $key => $value) {
                if(isset($value['user_id']) && $value['user_id'] == $staff_id){
                    $data['current_days_taken'] = $value['current_days_taken'];
                    $data['holiday_days_taken'] = $value['holiday_days_taken'];
                    $data['total_leave']        = $value['total_leave'];
                }
            }
        }
       //print_r($details);
        echo json_encode($data);
    }

    /*public function get_holiday_details()
    {//ajax call from the header dropdown
        $data      = array();
        $days_remain = "";
        $staff_id  = Input::get('staff_id');
        $type_id   = Input::get('type_id');
        $holidays  = Holidayrequest::leaveByTypeAndId($type_id, $staff_id, 'Approved');

        $data['current_days_taken'] = $holidays;
        if($type_id == 1){
            $ent_days = StaffHoliday::getEntitlementDays($staff_id);
            $days_remain = $ent_days-$holidays;
        }
        $data['days_remain'] = $days_remain;
       
        echo json_encode($data);
    }*/

    public function save_confirm_rollover()
    {
        $data           = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $staff_type     = Input::get('staff_type');
        $action         = Input::get('action');
        $staffs         = User::getAllStaffName();
        
        if($action == 'roll_fwd'){
            $position   = 'inner';
            $start_date = Input::get('start_date');
            $data['start_date'] = date('Y-m-d', strtotime('+1 year', strtotime($start_date)));
            $end_date   = date('Y-m-d', strtotime('+1 year', strtotime($data['start_date'])));
            $data['end_date']   = date('Y-m-d', strtotime('-1 day', strtotime($end_date)));

            if(isset($staffs) && count($staffs) >0){
                foreach ($staffs as $key => $value) {
                    $data['user_id']     = $value['user_id'];
                    $data['total_leave'] = Input::get('days_taken_'.$value['user_id']);
                    $details = PastLeaveDetail::leavesByStaffAndDate($value['user_id'], $data['start_date']);
                    if(isset($details) && count($details) >0){
                        $id = $details['past_leave_id'];
                        PastLeaveDetail::where('past_leave_id', '=', $id)->update($data);
                    }else{
                        $data['created'] = date('Y-m-d H:i:s');
                        PastLeaveDetail::insert($data);
                    }
                }
            }
        }else{
            $position   = Input::get('position');
            $start_date = Input::get('pop_holiday_date');
            $data['start_date'] = $start_date;
            $hd_data['holiday_date'] = date('Y-m-d', strtotime($start_date));
            $holiday_end  = date('Y-m-d', strtotime('+1 year', strtotime($start_date)));
            $hd_data['holiday_end'] = date('Y-m-d', strtotime('-1 day', strtotime($holiday_end)));

            $holiday_id = HolidayDetail::getHolidayId();
            if(isset($holiday_id) && $holiday_id != ""){
                HolidayDetail::where('holiday_id', '=', $holiday_id)->update($hd_data);
            }else{
                $hd_data['user_id'] = $user_id;
                $hd_data['created'] = date('Y-m-d H:i:s');
                HolidayDetail::insert($hd_data);
            }

            /* ====== Days taken update ======== */
            if(isset($staffs) && count($staffs) >0){
                foreach ($staffs as $key => $value) {
                    $staff_id = $value['user_id'];
                    $shdata['days_taken']  = Input::get('days_taken_'.$staff_id);
                    $details = StaffHoliday::staffHolidayByStaffId($staff_id);
                    if(isset($details) && count($details) >0){
                        $id = $details['staff_holiday_id'];
                        StaffHoliday::where('staff_holiday_id', '=', $id)->update($shdata);
                    }else{
                        $shdata['user_id']   = $user_id;
                        $shdata['staff_id']   = $staff_id;
                        $shdata['created']    = date('Y-m-d H:i:s');
                        StaffHoliday::insert($shdata);
                    }

                    /* ========== Delete past leave ======== */
                    PastLeaveDetail::where('user_id', '=', $staff_id)->delete();
                }
            }

        }
        if($position == 'inner'){
            $tab_no = 6;
        }else{
            $tab_no = 1;
        }
        
        //echo $this->last_query();die;
        $url_start = date('d-m-Y', strtotime($data['start_date']));
        return Redirect::to('/staff-holidays/'.base64_encode($staff_type).'/'.$tab_no.'/'.base64_encode($url_start));
        //echo json_encode($data);
    }
    
    public function get_staff_holiday()
    {
        $details        = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $start_date = date('Y-m-d', strtotime(Input::get('start_date')));
        $details['staff_holiday']       = StaffHoliday::getAllDetails();
        $details['holiday_details']     = HolidayDetail::getHolidayDetails();
        echo json_encode($details);
        exit;
    }

    public function get_confirm_rollover()
    {
        $holiday_type   = 1;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $staff_type = Input::get('staff_type');
        $start_date = base64_decode(Input::get('start_date'));

        $start_date = date('Y-m-d', strtotime($start_date));

        $details  = $this->getHolidayStaffDetails($holiday_type, $start_date);
        //print_r($details);
        echo json_encode($details);
        exit;
    }

    public function goto_rollfwd($staff_type, $start_date)
    {
        return Redirect::to('/staff-holidays/'.$staff_type.'/6/'.base64_encode($start_date));
    }

    /*public function search_holiday()
    {
        $data       = array();
        $details    = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $start_date = Input::get('start_date');
        $end_date   = Input::get('end_date');
        $staffs   = Input::get('staff_id');

        $start  = date('Y-m-d', strtotime($start_date));
        $end    = date('Y-m-d', strtotime($end_date));

        $data['search_date'] = date('F d, Y', strtotime($start_date)).' - to - '.date('F d, Y', strtotime($end_date));

        $staff_array = array();
        if(isset($staffs) && count($staffs) >0){
            foreach ($staffs as $k => $staff_id) {
                $staff_array[$k]['staff_name'] = User::getStaffNameById($staff_id);


                $details = Holidayrequest::searchDetails($start, $end, $staff_id);
                //echo $this->last_query();
                if(isset($details) && count($details) >0){
                    foreach ($details as $key => $value) {
                        if(isset($value['date']) && $value['date'] != ''){
                            $details[$key]['date_show'] = date('l, F d, Y', strtotime($value['date']));
                        }
                    }
                }
                $staff_array[$k]['events'] = $details;
            }
            
        }

        $data['staff_details'] = $staff_array;
        echo "<pre>";print_r($data);die;
        echo View::make('staff.staffholidays.ajax.ajax_event_holiday', $data);
        exit;

    }*/

    public function search_holiday()
    {
        $data       = array();
        $details    = array();
        $array      = array();
        $events     = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $start_date = Input::get('start_date');
        $end_date   = Input::get('end_date');
        $staffs   = Input::get('staff_id');

        $start  = date('Y-m-d', strtotime($start_date));
        $end    = date('Y-m-d', strtotime($end_date));

        $data['search_date'] = date('F d, Y', strtotime($start_date)).' - to - '.date('F d, Y', strtotime($end_date));

        $groupByDate = Holidayrequest::getGroupByDate($start, $end);

        $i = 0;$j = 0;
        $array[$i][$j] = 'Dates';
        $j++;
        if(isset($staffs) && count($staffs) >0){
            foreach ($staffs as $k => $staff_id) {
                $array[$i][$j] = User::getStaffNameById($staff_id);
                $j++;
            }
        }
        $i++;
        if(isset($groupByDate) && count($groupByDate) >0){
            foreach ($groupByDate as $key => $value) {
                $array[$i][0] = date('l, F d, Y', strtotime($value['date']));
                $j = 1;
                $action = 0;
                if(isset($staffs) && count($staffs) >0){
                    foreach ($staffs as $k => $staff_id) {
                        if(isset($value['state']) && $value['state'] == 'Approved'){
                            $events = Holidayrequest::getEventsByUserIdAndDate($staff_id, $value['date']);

                            //$course = Cpd::getDetailsByUserAndDate($staff_id, $value['date']);
                            //array_push($events, $course);
                            
                            //echo "<pre>";print_r($events);//die;
                            $array[$i][$j] = $events;
                            if(isset($events) && count($events)>0){
                                $action = 1;
                            }
                            //echo $this->last_query();
                            $j++;
                        }
                    }
                }
                if($action == 1)
                    $i++;
                else 
                    unset($array[$i]);
            }
        }
        
        //$course = Cpd::getDetailsByUserAndDate(46, '2016-06-30');
        //echo $this->last_query();
        $data['staff_details'] = (array)$array;
        //echo "<pre>";print_r($array);die;
        echo View::make('staff.staffholidays.ajax.ajax_event_holiday', $data)->render();
        exit;

    }

    public function get_who_else_is_off()
    {
        $events         = array();
        $array          = array();
        $heading        = array();
        $data           = array();
        //$session        = Session::get('admin_details');
        //$groupUserId    = $session['group_users'];

        $date       = Input::get('date');
        $stafftype  = Input::get('stafftype');
        $staff_name = Input::get('staff_name');

        $main_date = date('Y-m-d', strtotime($date));
        $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($main_date)));
        $next_date = date('Y-m-d', strtotime('+1 day', strtotime($main_date)));

        $heading['prev_date'] = date('l, F d, Y', strtotime($prev_date));
        $heading['main_date'] = date('l, F d, Y', strtotime($main_date));
        $heading['next_date'] = date('l, F d, Y', strtotime($next_date));

        $data['heading']      = $heading;

        $groupByStaff = Holidayrequest::getGroupByStaff($prev_date, $next_date);
        $i = 0;
        if(isset($groupByStaff) && count($groupByStaff) >0){
            foreach ($groupByStaff as $key => $value) {
                if($value['state'] == 'Approved' ){
                    $array[$i]['staff_name'] = $value['staff_name'];

                    $prev_events = Holidayrequest::getEventsByUserIdAndDate($value['staff'], $prev_date);
                    $array[$i]['prev_events'] = $prev_events;

                    $main_events = Holidayrequest::getEventsByUserIdAndDate($value['staff'], $main_date);
                    $array[$i]['main_events'] = $main_events;

                    $next_events = Holidayrequest::getEventsByUserIdAndDate($value['staff'], $next_date);
                    $array[$i]['next_events'] = $next_events;

                    $i++;
                }
            }
        }

        $data['events'] = $array;

        //echo "<pre>";print_r($data['events']);die;

        echo View::make('staff.staffholidays.ajax.who_else_is_off', $data)->render();
        exit;
    }

    public function get_check_task_deadlines()
    {
        $data = array();


        $data['services'] = Service::getServicesByType( 'org' );
        echo View::make('staff.staffholidays.ajax.check_task_deadlines', $data)->render();
        exit;   
    }

    public function show_tasks()
    {
        $data       = array();
        $clientId   = array();

        $staff_id   = Input::get('staff_id');
        $service_id = Input::get('service_id');
        $status     = Input::get('status');

        $data['service_id']      = $service_id;
        $data['staff_id']        = $staff_id;
        $data['status']          = $status;
        $data['page_open']       = 21;
        $data['heading']         = App::make('JobsController')->getHeadingName($service_id);
        $data['title']           = ucfirst(strtolower($data['heading']));

        $data['company_details'] = App::make('JobsController')->allClientByService($service_id, $staff_id, '21');

        if(isset($data['company_details']) && count($data['company_details']) >0){
            foreach ($data['company_details'] as $key => $details) {
                if($service_id == 9){
                    if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y"){
                        $clientId[] = $details['client_id'];
                        $data['company_details'][$key]['manage_task'] = $details['ch_manage_task'];
                    }
                }else{
                    if(isset($details['manage_task']) && $details['manage_task'] == "Y"){
                        $clientId[] = $details['client_id'];
                    }
                }
                
                
            }
        }
        $data['jobs_steps']      = JobsStep::getAllJobSteps( $service_id );
        $data['Job_status']      = JobStatus::getJobStatusByServiceId($service_id, $clientId);


        //echo "<pre>";print_r($data);die;
        echo View::make('staff.staffholidays.ajax.show_task_data', $data)->render();
        exit; 
    }

    
    
}
