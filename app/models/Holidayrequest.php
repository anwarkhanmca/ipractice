<?php
class Holidayrequest  extends Eloquent{
	
	//protected $table = 'practice_details';
	public $timestamps = false;
	public static function getStaffByState($state)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $details        = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
            "=", $state)->orderBy('holidayrequest_id', 'DESC')->get();
    
    return Holidayrequest::getArray($details);
  }

  public static function getDetailsById($id)
  {
    $details  = Holidayrequest::where("holidayrequest_id", $id)->first();
    
    return Holidayrequest::getSingleArray($details);
  }

  public static function getStaffByStateAndId($state, $staff_id)
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];
    $details        = Holidayrequest::whereIn("user_id", $groupUserId)->where("state", $state)->where("staff", $staff_id)->orderBy('holidayrequest_id', 'ESC')->get();
      
    return Holidayrequest::getArray($details);
  }

    public static function countStaffByState($state)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $count          = Holidayrequest::whereIn("user_id", $groupUserId)->where("state",
                "=", $state)->get()->count();
        
        return $count;
    }

    public static function countStaffByStateAndId($state, $staff_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $count          = Holidayrequest::whereIn("user_id", $groupUserId)->where("state", "=", $state)->where("staff", "=", $staff_id)->get()->count();
        
        return $count;
    }

    public static function countLeaveByStateAndId($state, $staff_id, $type_id, $holiday_start)
    {
        $total_day = 0;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        
        if(isset($holiday_start) && $holiday_start != ''){
            $start          = date('Y-m-d', strtotime($holiday_start));
            $holiday_end    = date('Y-m-d', strtotime('+1 year', strtotime($holiday_start)));
            $end            = date('Y-m-d', strtotime('-1 day', strtotime($holiday_end)));
        }else{
            $start          = date('Y-m-d');
            $end            = date('Y-m-d');
        }

        $query = Holidayrequest::where(function ($query) use ($start, $end){
            $query->where('date', '>=', $start);
            $query->where('date', '<=', $end);
        });
        
        $details  = $query->whereIn("user_id", $groupUserId)->where("state", "=", $state)->where("staff", "=", $staff_id)->where("requesttype", "=", $type_id)->get();
        //print_r($details);die;
        if(isset($details) && count($details) >0){
          foreach ($details as $key => $val) {
            if(isset($val->duration) && $val->duration == 'Full Day'){
                $total_day += 1;
            }else{
                $total_day += 0.5;
            }
          }
        }//Common::last_query();die;
        //echo $total_day;die;
        return $total_day;
    }

    /*public static function countLeaveByStateAndId($state, $staff_id, $type_id)
    {
    	$total_day = 0;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $holidays       = HolidayDetail::getHolidayDetails();
    	if(isset($holidays['holiday_date']) && $holidays['holiday_date'] != ''){
    		$start 			= date('Y-m-d', strtotime($holidays['holiday_date']));
    		$end 			= date('Y-m-d', strtotime($holidays['holiday_end']));
    	}else{
    		$start 			= date('Y-m-d');
    		$end 			= date('Y-m-d');
    	}

    	$query = Holidayrequest::where(function ($query) use ($start, $end){
    		$query->where('date', '>=', $start);
    		$query->where('date', '<=', $end);
		});
		
		$details  = $query->whereIn("user_id", $groupUserId)->where("state", "=", $state)->where("staff", "=", $staff_id)->where("requesttype", "=", $type_id)->get();
		//print_r($details);die;
		if(isset($details) && count($details) >0){
          foreach ($details as $key => $val) {
        	if(isset($val->duration) && $val->duration == 'Full Day'){
        		$total_day += 1;
        	}else{
        		$total_day += 0.5;
        	}
          }
        }//Common::last_query();die;
        //echo $total_day;die;
        return $total_day;
    }*/

    public static function countPastLeave($state, $staff_id, $type_id)
    {
        $total_day = 0;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $holidays       = HolidayDetail::getHolidayDetails();
        if(isset($holidays['holiday_date']) && $holidays['holiday_date'] != ''){
            $start = date('Y-m-d',strtotime('-1 year',strtotime($holidays['holiday_date'])));
            $end   = date('Y-m-d',strtotime('-1 year',strtotime($holidays['holiday_end'])));
        }else{
            $start          = date('Y-m-d');
            $end            = date('Y-m-d');
        }

        $query = Holidayrequest::where(function ($query) use ($start, $end){
            $query->where('date', '>=', $start);
            $query->where('date', '<=', $end);
        });
        
        $details  = $query->whereIn("user_id", $groupUserId)->where("state", "=", $state)->where("staff", "=", $staff_id)->where("requesttype", "=", $type_id)->get();
        //print_r($details);die;
        if(isset($details) && count($details) >0){
          foreach ($details as $key => $val) {
            if(isset($val->duration) && $val->duration == 'Full Day'){
                $total_day += 1;
            }else{
                $total_day += 0.5;
            }
          }
        }//Common::last_query();die;
        //echo $total_day;die;
        return $total_day;
    }

    public static function countLeaveByDateRange($start, $end, $staff_id)
    {
        $total_day = 0;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $prev = PastLeaveDetail::where('start_date', '=', $start)->where('end_date', '=', $end)->first();
        if(isset($prev) && count($prev)>0){
            $query = Holidayrequest::where(function ($query) use ($start, $end){
                $query->where('date', '>=', $start);
                $query->where('date', '<=', $end);
            });
            
            $details  = $query->whereIn("user_id", $groupUserId)->where("state", "=", 'Approved')->where("staff", "=", $staff_id)->where("requesttype", "=", 1)->get();
            //print_r($details);die;
            if(isset($details) && count($details) >0){
              foreach ($details as $key => $val) {
                if(isset($val->duration) && $val->duration == 'Full Day'){
                    $total_day += 1;
                }else{
                    $total_day += 0.5;
                }
              }
            }
        }else{
            $total_day = 0;
        }

        //Common::last_query();die;
        //echo $total_day;die;
        return $total_day;
    }

    public static function leaveByTypeAndId($type_id, $staff_id, $state)
    {
    	$total_day = 0;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $holidays  = HolidayDetail::getHolidayDetails();
    	if(isset($holidays['holiday_date']) && $holidays['holiday_date'] != ''){
    		$start 			= date('Y-m-d', strtotime($holidays['holiday_date']));
    		$end 			= date('Y-m-d', strtotime($holidays['holiday_end']));
    	}else{
    		$start 			= date('Y-m-d');
    		$end 			= date('Y-m-d');
    	}

    	$query = Holidayrequest::where(function ($query) use ($start, $end){
    		$query->where('date', '>=', $start);
    		$query->where('date', '<=', $end);
		});
		
		$details  = $query->whereIn("user_id", $groupUserId)->where("state", $state)->where("requesttype", $type_id)->where("staff", $staff_id)->get();
		
		if(isset($details) && count($details) >0){
          foreach ($details as $key => $val) {
        	if(isset($val->duration) && $val->duration == 'Full Day'){
        		$total_day += 1;
        	}else{
        		$total_day += 0.5;
        	}
          }
        }
        return $total_day;
    }

  public static function searchDetails($start, $end, $staff_id)
  {
      $data = array();
      
      $details = Holidayrequest::where('staff','=',$staff_id)->whereBetween('date', array($start, $end))->get();

      $details1 = Holidayrequest::getArray($details);
      $details2 = Cpd::where('user_id', '=', $staff_id)->whereBetween('course_date', array($start, $end))->get();

      $i = 0;
      if(isset($details1) && count($details1) >0){
          foreach ($details1 as $key => $value1) {
              $data[$i]['id']           = $value1['holidayrequest_id'];
              $data[$i]['type']         = 'HR';
              $data[$i]['color_code']   = $value1['color_code'];
              $data[$i]['type_name']    = $value1['type_name'];
              $data[$i]['date']         = $value1['date'];
              $data[$i]['duration']     = $value1['duration'];
              $data[$i]['notes']        = $value1['notes'];

              $i++;
          }
      }

      if(isset($details2) && count($details2) >0){
          foreach ($details2 as $key => $value2) {
              $data[$i]['id']           = $value2->cpd_id;
              $data[$i]['type']         = 'CPD';
              $data[$i]['color_code']   = '228B22';
              $data[$i]['type_name']    = $value2->course_name;
              $data[$i]['date']         = $value2->course_date;
              $data[$i]['duration']     = 'Course';
              $data[$i]['notes']        = $value2->notes;

              $i++;
          }
      }

      return $data;
      
  }

  public static function getGroupByDate($start, $end)
  {
      $data = array();
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];
      
      $details = Holidayrequest::whereIn("user_id", $groupUserId)->whereBetween('date', array($start, $end))->groupBy('date')->orderBy('date', 'asc')->get();

      $data = Holidayrequest::getArray($details);

      return $data;
      
  }

  public static function getStateNameById($id)
  {
    $details = Holidayrequest::where("holidayrequest_id", $id)->select("state")->first();
    $state = '';
    if(!empty($details['state'])){
      $state = $details['state'];
    }
    return $state;
  }

  public static function getGroupByStaff($start, $end)
  {
    $data = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = Holidayrequest::whereIn("user_id", $groupUserId)->whereBetween('date', array($start, $end))->groupBy('staff')->orderBy('date', 'asc')->get();

    $data = Holidayrequest::getArray($details);

    return $data;
      
  }

  public static function getEventsByUserIdAndDate($staff_id, $date)
  {
    $data = array();
    $date = date('Y-m-d', strtotime($date));
    $details = Holidayrequest::where("staff", $staff_id)->where('date', $date)->where('state', 'Approved')->get();

    $data = Holidayrequest::getArray($details);
    /*if(isset($details) && count($details) >0){
        foreach ($details as $key => $val) {
            $data[$key]['type_name'] = HolidayType::getTypeNameById($val->requesttype);
        }
    }*/


    return $data;
    
  }

  public static function sendNotification($details, $staff_id)
  {
    $emails = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $group_id       = $session['group_id'];
    $groupUserId    = Client::getSessionUserIds();

    $emails = User::getStaffManagementAccessEmail();
    if($staff_id != '' && $staff_id != '0'){
      $email  = User::getEmailByUserId($staff_id);
      array_push($emails, $email);
    }

    //$emails = array('anwarkhanmca786@gmail.com');
    
    $data['email']        = array_unique($emails);
    //echo "<pre>";print_r($data['email']);die;
    $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
    //$data['STAFFNAME']    = User::getStaffNameById($staff_id);
    $data['STAFFNAME']    = $details['staff_name'];
    $data['value']        = $details;
    $data['USERNAME']     = User::getStaffNameById($user_id);
    //echo "<pre>";print_r($data['details']);die;

    Mail::send('emails.new_request', $data, function ($message) use ($data) {
      $message->subject('Time off request - '.$data['STAFFNAME']);
      $message->from($data['senderEmail']);
      $message->to($data['email']);
    });

  }

  public static function sendStateChangeNotification($holi_id, $old_state)
  {
    $details = Holidayrequest::getDetailsById($holi_id);
    $emails = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $group_id       = $session['group_id'];
    $groupUserId    = Client::getSessionUserIds();

    $email1 = User::getEmailByUserId($user_id);
    array_push($emails, $email1);
    if(isset($details['staff']) && $details['staff'] > 0){
      $email  = User::getEmailByUserId($details['staff']);
      array_push($emails, $email);
    }

    //$emails = array('anwarkhanmca786@gmail.com');
    $data['email']        = array_unique($emails);
    //echo "<pre>";print_r($data['email']);die;
    $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
    $data['value']        = $details;
    $data['old_state']    = $old_state;
    $data['USERNAME']     = User::getStaffNameById($user_id);
    $data['FNAME']        = User::getFirstNameByUserId($details['staff']);
    //echo "<pre>";print_r($data['details']);die;

    Mail::send('emails.change_holiday_status', $data, function ($message) use ($data) {
      $message->subject('Time off request -Status update - '.$data['value']['staff_name']); 
      $message->from($data['senderEmail']);
      $message->to($data['email']);
    });
  }
  

  public static function getArray($details)
  {
    $data = array();
    if(isset($details) && count($details) >0){
      foreach ($details as $key => $val) {
        $data[$key]['holidayrequest_id'] = $val->holidayrequest_id;
        $data[$key]['staff_name'] 	= User::getStaffNameById($val->staff);
        $data[$key]['stafftype'] 	= isset($val->stafftype)?$val->stafftype:'';
        $data[$key]['staff'] 		= isset($val->staff)?$val->staff:'';
        $data[$key]['date'] 		= date('d-m-Y', strtotime($val->date));
        $data[$key]['duration'] 	= isset($val->duration)?$val->duration:'';
        $data[$key]['requesttype']  = $val->requesttype;
        $data[$key]['type_name']    = HolidayType::getTypeNameById($val->requesttype);
        $data[$key]['color_code']   = HolidayType::getColorCodeById($val->requesttype);
        $data[$key]['notes'] 		= isset($val->notes)?$val->notes:'';
        $data[$key]['state'] 		= $val->state;
        $data[$key]['approved_date']= $val->approved_date;
        $data[$key]['archive'] 		= $val->archive;
        $data[$key]['created'] 		= date("d-m-Y", strtotime($val->created));
        $data[$key]['date_show']    = date('l, F d, Y', strtotime($val->date));
      }
    }
    return $data;
  }

    public static function getSingleArray($val)
    {
        $data = array();
        if(isset($val) && count($val) >0){
            $data['holidayrequest_id'] = $val->holidayrequest_id;
            $data['staff_name'] 	= User::getStaffNameById($val->staff);
            $data['stafftype'] 		= $val->stafftype;
            $data['staff'] 			= $val->staff;
            $data['date'] 			= $val->date;
            $data['duration'] 		= $val->duration;
            $data['requesttype']  	= $val->requesttype;
            $data['type_name']      = HolidayType::getTypeNameById($val->requesttype);
            $data['color_code']     = HolidayType::getColorCodeById($val->requesttype);
            $data['notes'] 			= $val->notes;
            $data['state'] 			= $val->state;
            $data['approved_date']  = $val->approved_date;
            $data['archive'] 		= $val->archive;
            $data['created'] 		= date("d-m-Y", strtotime($val->created));
            $data['date_show']      = date('l, F d, Y', strtotime($val->date));
        }
        return $data;
    }
	

}
