<?php
class StaffdataController extends BaseController
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

  public function staff_data()
  {
    $session          = Session::get('admin_details');
    $user_id          = $session['id'];
    $user_type        = $session['user_type'];
    $groupUserId      = $session['group_users'];
    $data['heading']  = "STAFF LIST";
    $data['title']    = "Staff List";
    $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';

    if (!isset($user_id) && $user_id == "") {
      return Redirect::to('/');
    } else if (isset($user_type) && $user_type == "C") {
      return Redirect::to('/invitedclient-dashboard');
    }

    /*$data['staff_details'] = $this->getAllStaffDetails();

    if (isset($data['staff_details']) && count($data['staff_details']) > 0) {

      foreach ($data['staff_details'] as $key => $add) {
        $address = null;

        if (isset($add['step_data']['res_addr_line1'])) {
          $add['step_data']['res_addr_line1'];
        }

        if (isset($add['step_data']['res_addr_line1'])) {
          $address .= $add['step_data']['res_addr_line1'] . ", ";
        }

        if (isset($add['step_data']['res_addr_line2'])) {
          $address .= $add['step_data']['res_addr_line2'] . ", ";
        }

        if (isset($add['step_data']['res_city'])) {
          $address .= $add['step_data']['res_city'] . ", ";
        }

        if (isset($add['step_data']['res_county'])) {
          $address .= $add['step_data']['res_county'] . ", ";
        }
        if (isset($add['step_data']['res_postcode'])) {
          $address .= $add['step_data']['res_postcode'];
        }

        $data['staff_details'][$key]['fulladdress'] = $address;
      }
    }*/
    //echo '<pre>';print_r($data['staff_details']);die();

    return View::make('staff.staffdata.staff_data', $data);

  }

  public function getAllStaffDetails()
  {
    $details      = array();
    $step_data    = array();
    $session      = Session::get('admin_details');
    $user_id      = $session['id'];
    $user_type    = $session['user_type'];
    $groupUserId  = $session['group_users'];

    $staff=User::whereIn("user_id",$groupUserId)->where("is_archive","N")->where("client_id",0)->get();
    //echo $this->last_query();die;
    if (isset($staff) && count($staff) > 0) {
      foreach ($staff as $key => $value) {
        $details[$key]['user_id']       = $value->user_id;
        $details[$key]['parent_id']     = $value->parent_id;
        $details[$key]['group_id']      = $value->group_id;
        $details[$key]['client_id']     = $value->client_id;
        $details[$key]['fname']         = $value->fname;
        $details[$key]['lname']         = $value->lname;
        $details[$key]['email']         = $value->email;
        $details[$key]['password']      = $value->password;
        $details[$key]['phone']         = $value->phone;
        $details[$key]['website']       = $value->website;
        $details[$key]['country']       = $value->country;
        $details[$key]['user_type']     = $value->user_type;
        $details[$key]['status']        = $value->status;
        $details[$key]['is_archive']    = $value->is_archive;
        $details[$key]['show_archive']  = $value->show_archive;
        $details[$key]['created']       = $value->created;

        $fields = StepsFieldsStaff::where("staff_id", $value->user_id)->get();

        if (isset($fields) && count($fields) > 0) {
          foreach ($fields as $value) {
            $step_data[$value['field_name']] = $value->field_value;
          }
        }

        $details[$key]['step_data'] = $step_data;

        if (isset($details[$key]['step_data']['department']) && count($details[$key]['step_data']['department']) > 0) {
          $fields_staffid = Department::where("department_id", $details[$key]['step_data']['department'])->select('name')->first();
          $details[$key]['department_name'] = $fields_staffid['name'];
        }

        if (isset($details[$key]['step_data']['position_type']) && count($details[$key]['step_data']['position_type']) >0) {
          $fields_Position = Position::where("position_id", $details[$key]['step_data']['position_type'])->select('name')->first();

          $details[$key]['position_name'] = $fields_Position['name'];
        }

        $details[$key]['ent_days'] = StaffHoliday::getEntitlementDays($value->user_id);


        //$holidayDetails  = HolidayDetail::getHolidayDetailsByUserId($value->user_id);
        $holidayDetails  = HolidayDetail::getHolidayDetails();
        if(isset($holidayDetails['holiday_date']) && $holidayDetails['holiday_date'] != ""){
          $start = $holidayDetails['holiday_date'];
          $holidays = App::make('StaffholidaysController')->getHolidayStaffDetails(1, $start);

          if(isset($holidays) && count($holidays) >0){
            foreach($holidays as $i => $valueh) {
              if(isset($valueh['user_id']) && $valueh['user_id'] == $details[$key]['user_id']){
                $datah['current_days_taken']  = $valueh['current_days_taken'];
                $datah['holiday_days_taken']  = $valueh['holiday_days_taken'];
                $datah['total_leave']         = $valueh['total_leave'];
                $datah['user_id']             = $details[$key]['user_id'];
              }
            }
          }

          $details[$key]['holidays'] = $datah;
        }else{
          $details[$key]['holidays'] = array();
        }
      }
      //print_r($value->user_id);die();
    }

    return $details;
  }

  public function archive_staff()
  {
    Session::put('show_staff_archive', 'Y');

    $users_id = Input::get("users_id");
    $status = Input::get("status");
    //print_r($users_id);die;
    foreach ($users_id as $user_id) {
      if ($status == "Archive") {
        User::where('user_id', $user_id)->update(array("is_archive" => "Y", "show_archive" => "Y"));
      } else {
        User::where('user_id', $user_id)->update(array("is_archive" => "N", "show_archive" => "N"));
      }

      //echo $this->last_query();die;
    }
  }

  public function show_archive_staff()
  {
    $session = Session::get('admin_details');
    $user_id = $session['id'];
    $groupUserId = $session['group_users'];

    $is_archive = Input::get("is_archive");
    if ($is_archive == "Y") {
      Session::put('show_staff_archive', 'Y');
    } else {
      Session::put('show_staff_archive', 'N');
    }

    $affected = User::whereIn("user_id", $groupUserId)->where("show_archive", "Y")->update(array("is_archive" => $is_archive));
    echo $affected;
    //echo $this->last_query();die;
  }


  public function staffpdf($search)
  {
    $session = Session::get('admin_details');
    $user_id = $session['id'];
    $user_type = $session['user_type'];
    $groupUserId = $session['group_users'];

    if (!isset($user_id) && $user_id == "") {
      return Redirect::to('/');
    } else
      if (isset($user_type) && $user_type == "C") {
        return Redirect::to('/invitedclient-dashboard');
      }
    $data = array();
    $t = time();
    $time = date("Y-m-d H:i:s", $t);
    $pieces = explode(" ", $time);
    $data['cdate'] = $pieces[0];

    $data['ctime'] = $pieces[1];

    $today = date("j F  Y");
    $data['today'] = $today;

    $time = date(" G:i:s ");
    $data['time'] = $time;
     $temp = $newvardump = array();
    $final_arr          = array();
    $staff_details= array();
    $data['heading'] = "";
    $data['title'] = "Staff List";
    $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';


       if ($search == "NONE") {
        $staff_details = $this->getAllStaffDetails();
         $address = "";
        if (isset($staff_details) && count($staff_details) > 0) {

        foreach ($staff_details as $key => $add) {


            if (isset($add['step_data']['res_addr_line1'])) {
                $add['step_data']['res_addr_line1'];
            }


            if (isset($add['step_data']['res_addr_line1'])) {
                $address .= $add['step_data']['res_addr_line1'] . ", ";
            }

            if (isset($add['step_data']['res_addr_line2'])) {
                $address .= $add['step_data']['res_addr_line2'] . ", ";
            }

            if (isset($add['step_data']['res_city'])) {
                $address .= $add['step_data']['res_city'] . ", ";
            }

            if (isset($add['step_data']['res_county'])) {
                $address .= $add['step_data']['res_county'] . ", ";
            }
            if (isset($add['step_data']['res_postcode'])) {
                $address .= $add['step_data']['res_postcode'];
            }


            $staff_details[$key]['fulladdress'] = $address;
        }
    }
        
        
    } else {
      $searchvalue = strtolower($search);
      $staff_details = $this->getAllStaffDetails();
    

    $address = "";

    if (isset($staff_details) && count($staff_details) > 0) {

      foreach ($staff_details as $key => $add) {


        if (isset($add['step_data']['res_addr_line1'])) {
            $add['step_data']['res_addr_line1'];
        }


        if (isset($add['step_data']['res_addr_line1'])) {
            $address .= $add['step_data']['res_addr_line1'] . ", ";
        }

        if (isset($add['step_data']['res_addr_line2'])) {
            $address .= $add['step_data']['res_addr_line2'] . ", ";
        }

        if (isset($add['step_data']['res_city'])) {
            $address .= $add['step_data']['res_city'] . ", ";
        }

        if (isset($add['step_data']['res_county'])) {
            $address .= $add['step_data']['res_county'] . ", ";
        }
        if (isset($add['step_data']['res_postcode'])) {
            $address .= $add['step_data']['res_postcode'];
        }


        $staff_details[$key]['fulladdress'] = $address;
      }
    }
        
      //  echo '<pre>';print_r($staff_details);die();
        
        
       //$satff_details =$data['staff_details'];

        if (isset($staff_details) && count($staff_details) > 0) {
            foreach ($staff_details as $key => $value) {
              

                $filterdata = array();
                
                if (isset($value['user_id']) && $value['user_id'] != "") {
                        $filterdata['user_id'] = $value['user_id'];
                    }
                if (isset($value['fname']) && $value['fname'] != "") {
                        $filterdata['fname'] = $value['fname'];
                    }
                if (isset($value['position_name']) && $value['position_name'] != "") {
                        $filterdata['position_name'] = $value['position_name'];
                    }
                if (isset($value['created']) && $value['created'] != "") {
                        $filterdata['created'] = $value['created'];
                    }
                if (isset($value['department_name']) && $value['department_name'] != "") {
                        $filterdata['department_name'] = $value['department_name'];
                    }
                  if (isset($value['fulladdress']) && $value['fulladdress'] != "") {
                        $filterdata['fulladdress'] = $value['fulladdress'];
                    }  
                    
                    //echo '<pre>';print_r($filterdata);//die();
                    
                    //  $value = $this->arraytolower($value);
                   $temp = $this->search_array($filterdata, $searchvalue, $final_arr);

                    if (isset($temp) && count($temp) > 0) {
                        $newvardump[$key] = $staff_details[$key];
                    } 
            }
           // die();
        }
        $staff_details = array_values($newvardump);
    }
    $data['staff_details'] = $staff_details;
            // echo '<pre>';print_r($data['staff_details']);die();
    $pdf = PDF::loadView('staff/staffdata/staffdatapdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
    return $pdf->download('staff_list.pdf');

        // return View::make('staff.staffdata.staff_data', $data);


  }



  function search_array($value, $searchvalue, $final_arr)
  {   
    //echo '<pre>';print_r($value);die();        
    $arr = $value;
  
    foreach ($value as $key => $val) {
      if (!stristr($val, $searchvalue) === false) {
        if (count($final_arr) > 0) {
          foreach ($final_arr as $keyF => $eachF) {
            if ($eachF['user_id'] != $value['user_id']) {
              array_push($final_arr, $arr);
            }
          }
        } else {
          array_push($final_arr, $arr);
        }
      }
    }
    return $final_arr;
  }
  public function staffexcel()
  {
    $session      = Session::get('admin_details');
    $user_id      = $session['id'];
    $user_type    = $session['user_type'];
    $groupUserId  = $session['group_users'];

    if (!isset($user_id) && $user_id == "") {
      return Redirect::to('/');
    } else
    if (isset($user_type) && $user_type == "C") {
      return Redirect::to('/invitedclient-dashboard');
    }

    $data['heading']  = "";
    $data['title']    = "Staff List";
    $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';

    $data['staff_details'] = $this->getAllStaffDetails();


    $address = "";

    if (isset($data['staff_details']) && count($data['staff_details']) > 0) {
      foreach ($data['staff_details'] as $key => $add) {
        if(isset($add['step_data']['res_addr_line1'])) {
          $add['step_data']['res_addr_line1'];
        }
        if(isset($add['step_data']['res_addr_line1'])) {
          $address .= $add['step_data']['res_addr_line1'] . ", ";
        }

        if (isset($add['step_data']['res_addr_line2'])) {
          $address .= $add['step_data']['res_addr_line2'] . ", ";
        }

        if (isset($add['step_data']['res_city'])) {
          $address .= $add['step_data']['res_city'] . ", ";
        }

        if (isset($add['step_data']['res_county'])) {
          $address .= $add['step_data']['res_county'] . ", ";
        }
        if (isset($add['step_data']['res_postcode'])) {
          $address .= $add['step_data']['res_postcode'];
        }

        $data['staff_details'][$key]['fulladdress'] = $address;
      }
    }

    ///////////  Start Generate and store excel file ////////////////////////////
    /*ob_clean();
    $viewToLoad = 'staff/staffdata/staffdataexcel';
    Excel::create('staff_list', function ($excel) use ($data, $viewToLoad) {
      $excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad){
        $sheet->loadView($viewToLoad)->with($data); 
      }); 
    })->export('xls');*/

    /*$filepath = storage_path() . '/exports/staff_list.xls';//echo $filepath;die;
    $fileName = 'staff_list.xls';
    $headers = array('Content-Type: application/vnd.ms-excel');

    return Response::download($filepath, $fileName, $headers);*/
    exit;
  }


}
