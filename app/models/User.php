<?php
class User extends Eloquent {

	public $timestamps = false;
	public static function getStaffNameById($staff_id)
	{
		$details = User::where("user_id", $staff_id)->select("fname", "lname", "client_id")->first();
		$name = "";
		if(!empty($details['fname'])){
			$name.=$details['fname'];
		}
		if(!empty($details['lname'])){
			$name.=" ".$details['lname'];
		}

    if(isset($details->client_id) && $details->client_id != 0){
      $name = Client::getClientNameByClientId($details->client_id);
    }

		return ucwords(strtolower($name));
	}
    
  public static function getUserIdByClientId($client_id)
	{
		$details = User::where("client_id", $client_id)->select("user_id")->first();
		$user_id = 0;
		if(!empty($details['user_id'])){
			$user_id = $details['user_id'];
		}
		return $user_id;
	}

  public static function getStaffManagementAccessEmail()
  {
    $emails = array();
    $groupUserId    = Client::getSessionUserIds();

    $sql = "SELECT ua.user_id, u.email, CONCAT(u.fname, ' ', u.lname) as name FROM user_accesses as ua join users as u ON u.user_id = ua.user_id where u.user_id IN (".implode(',', $groupUserId).") AND ua.access_id = '4'";
    //echo $sql;die;
    $details = DB::select(DB::raw( $sql ));
    $i = 0;
    foreach ($details as $k => $v) {
      if(!empty($v->email)){
        $emails[$i] = $v->email;
        $i++;
      }
    }
    return $emails;
  }

  public static function getTodoEmailByUserId($user_id)
  {
      $details = User::where("user_id", $user_id)->select("todo_email")->first();
      $todo_email = '';
      if(!empty($details['todo_email'])){
          $todo_email = $details['todo_email'];
      }
      return $todo_email;
  }

  public static function getEmailByUserId($user_id)
  {
    $details = User::where("user_id", $user_id)->select("email")->first();
    $email = '';
    if(!empty($details['email'])){
      $email = $details['email'];
    }
    return $email;
  }

  public static function getAllEmail()
  {
    $data         = array();
    $session      = Session::get('admin_details');
    $group_id     = $session['group_id'];

    $details = User::where("group_id", $group_id)->select("email")->get();
    if(isset($details) && count($details) >0){
      foreach ($details as $key => $value) {
        $data[$key] = $value->email;
      }
    }
    return $data;
  }

  public static function getGroupIdByUserId($user_id)
  {
    $details = User::where("user_id", $user_id)->select("group_id")->first();
    $group_id = $user_id;
    if(isset($details->group_id) && $details->group_id != '0'){
        $group_id = $details->group_id;
    }
    return $group_id;
  }

  public static function getUserIdByGroupId($group_id)
  {
    $data       = array();
    $details    = User::where("group_id", $group_id)->select("user_id")->get();
    if(isset($details) && count($details) >0){
      foreach ($details as $key => $value) {
        $data[$key] = $value->user_id;
      }
    }
    return $data;
  }

  public static function getJobTitleByUserId($staff_id)
  {
    $staffs = StepsFieldsStaff::where('field_name', 'position_type')->where('staff_id', $staff_id)->select('field_value')->first();
    $job_title = "";
    if(isset($staffs['field_value']) && $staffs['field_value'] != ""){
      $job_title = Position::getNameByPositionId($staffs['field_value']);
    }
    return $job_title;
  }

  public static function getFirstNameByUserId($user_id)
  {
    $staffs = User::where('user_id', $user_id)->select('fname')->first();
    $fname = "";
    if(isset($staffs['fname']) && $staffs['fname'] != ""){
      $fname = $staffs['fname'];
    }
    return $fname;
  }
  public static function getDataByFieldAndUserId($field_name, $staff_id)
  {
    $staffs = StepsFieldsStaff::where('field_name', $field_name)->where('staff_id', $staff_id)->select('field_value')->first();
    $title = "";
    if(isset($staffs['field_value']) && $staffs['field_value'] != ""){
      $title = $staffs['field_value'];
    }
    return $title;
  }

  public static function getStaffDetailsById($user_id)
  {
    $details 		= array();
    $step_data 		= array();
    $session 		= Session::get('admin_details');
    //$user_id 		= $session['id'];
    $user_type 		= $session['user_type'];
    $groupUserId 	= $session['group_users'];

    $value = User::where("user_id", $user_id)->first();
    //echo $this->last_query();die;
    if (isset($value) && count($value) > 0) {
      $details['user_id'] 	= $value->user_id;
      $details['parent_id']   = $value->parent_id;
      $details['group_id']    = $value->group_id;
      $details['client_id']   = $value->client_id;
      $details['fname'] 	    = $value->fname;
      $details['lname'] 	    = $value->lname;
      $details['email'] 	    = $value->email;
      $details['password'] 	= $value->password;
      $details['phone']       = $value->phone;
      $details['website'] 	= $value->website;
      $details['country'] 	= $value->country;
      $details['user_type']   = $value->user_type;
      $details['status'] 	    = $value->status;
      $details['created'] 	= $value->created;

      $fields = StepsFieldsStaff::where("staff_id", $value->user_id)->get();
      if (isset($fields) && count($fields) > 0) {
        $address = "";
        $res_address = "";
        $maritStatus = $country_name = $nationality_name = $dept_name = $res_country_name = $position_name = $ethik_name = $body_name = '';
        foreach ($fields as $value) {
            	
        	if (isset($value['field_name']) && $value['field_name'] == 'res_addr_line1'){
              $res_address .= $value->field_value . ", ";
          }

          if (isset($value['field_name']) && $value['field_name'] == 'res_addr_line2'){
              $res_address .= $value->field_value . ", ";
          }

          if (isset($value['field_name']) && $value['field_name'] == 'res_city'){
              $address .= $value->field_value. ", ";
              $res_address .= $value->field_value. ", ";
          }

          if (isset($value['field_name']) && $value['field_name'] == 'res_county'){
              //$address .= $value->field_value . ", ";
              $res_address .= $value->field_value . ", ";
          }
          if (isset($value['field_name']) && $value['field_name'] == 'res_postcode'){
              $res_address .= $value->field_value.", ";
          }
          if (isset($value['field_name']) && $value['field_name'] == 'marital_status'){
              $maritStatus = MaritalStatus::getMeritalNameById($value->field_value);
          }
          if (isset($value['field_name']) && $value['field_name'] == 'country'){
              $country_name = Country::getCountryNameByCountryId($value->field_value);
          }
          if (isset($value['field_name']) && $value['field_name'] == 'nationality'){
              $nationality_name = Nationality::getNationalityNameById($value->field_value);
          }
          if (isset($value['field_name']) && $value['field_name'] == 'department'){
              $dept_name = Department::getDepartmentById($value->field_value);
          }
          if (isset($value['field_name']) && $value['field_name'] == 'res_country'){
              $res_country_name = Country::getCountryNameByCountryId($value->field_value);
          }
          if (isset($value['field_name']) && $value['field_name'] == 'position_type'){
              $position_name = Position::getNameByPositionId($value->field_value);
          }
          if (isset($value['field_name']) && $value['field_name'] == 'ethnic_origin'){
              $ethik_name = EthnicOrigin::getNameById($value->field_value);
          }
          if (isset($value['field_name']) && $value['field_name'] == 'professional_body'){
              $body_name = ProfessionalBody::getNameById($value->field_value);
          }
                


          $step_data['address']               = substr($address, 0, -2);
          $step_data['reg_address']           = substr($res_address, 0, -2);
          $step_data[$value['field_name']]    = $value->field_value;
          $step_data['maritStatus']           = $maritStatus;
          $step_data['country_name']          = $country_name;
          $step_data['nation_name']           = $nationality_name;
          $step_data['dept_name']             = $dept_name;
          $step_data['res_country_name']      = $res_country_name;
          $step_data['position_name']         = $position_name;
          $step_data['ethik_name']            = $ethik_name;
          $step_data['body_name']             = $body_name;
        }
      }

      $details['step_data'] = $step_data;
            
    
    }

    return $details;
  }

  public static function getAllStaffDetails()
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $user_type      = $session['user_type'];
    $groupUserId    = $session['group_users'];

    $staff = User::whereIn("user_id", $groupUserId)->where("client_id", 0)->get();
    //echo $this->last_query();die;
    return User::getArray($staff);
  }

  public static function getAllUserDetails()
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $user_type      = $session['user_type'];
    $groupUserId    = $session['group_users'];

    $staff = User::get();
    
    return User::getArray($staff);
  }

  public static function getArray($staff)
  {
    $details        = array();
    $step_data      = array();
    if (isset($staff) && count($staff) > 0) {
      foreach ($staff as $key => $value) {
        $details[$key]['user_id']   = $value->user_id;
        $details[$key]['parent_id'] = $value->parent_id;
        $details[$key]['group_id']  = $value->group_id;
        $details[$key]['client_id'] = $value->client_id;
        $details[$key]['fname']     = $value->fname;
        $details[$key]['lname']     = $value->lname;
        $details[$key]['email']     = $value->email;
        $details[$key]['password']  = $value->password;
        $details[$key]['phone']     = $value->phone;
        $details[$key]['website']   = $value->website;
        $details[$key]['country']   = $value->country;
        $details[$key]['user_type'] = $value->user_type;
        $details[$key]['status']    = $value->status;
        $details[$key]['created']   = $value->created;

        $fields = StepsFieldsStaff::where("staff_id", $value->user_id)->get();
        if (isset($fields) && count($fields) > 0) {
          $address = "";
          $res_address = "";
          foreach ($fields as $value) {
              
            if (isset($value['field_name']) && $value['field_name'] == 'res_addr_line1'){
                $res_address .= $value->field_value . ", ";
            }

            if (isset($value['field_name']) && $value['field_name'] == 'res_addr_line2'){
                $res_address .= $value->field_value . ", ";
            }

            if (isset($value['field_name']) && $value['field_name']=='res_city'){
                $address .= $value->field_value. ", ";
                $res_address .= $value->field_value. ", ";
            }

            if(isset($value['field_name']) && $value['field_name']=='res_county'){
                $res_address .= $value->field_value . ", ";
            }
            if(isset($value['field_name']) && $value['field_name']=='res_postcode'){
                $res_address .= $value->field_value.", ";
            }


            $step_data['address'] = substr($address, 0, -2);
            $step_data['reg_address'] = substr($res_address, 0, -2);
            $step_data[$value['field_name']] = $value->field_value;
          }
        }

        $details[$key]['step_data'] = $step_data;
            
      }
    }
    return $details;
  }

  public static function getAllStaffName()
  {
    $details        = array();
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $staff = User::whereIn("user_id", $groupUserId)->where("client_id", "=", 0)->get();
    if (isset($staff) && count($staff) > 0) {
      foreach ($staff as $key => $value) {
        $details[$key]['user_id']       = $value->user_id;
        $details[$key]['fname']         = $value->fname;
        $details[$key]['lname']         = $value->lname;
        $details[$key]['staff_name']    = $value->fname." ".$value->lname;
      }
    }
    //print_r($details);die();

    return $details;
  }
    
  public static function getInvitedClientId()
	{
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$details = User::whereIn("user_id",$groupUserId)->where("client_id","!=",'0')->select("client_id")->get();
		$data = array();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
        $data[$key] = $value['client_id'];
      }
		}
		return $data;
	}
    
  public static function validateEmail($email)
	{
		$details = User::where("email", $email)->select("email")->first();
		$value = 0;
		if(isset($details['email']) && $details['email'] != ""){
			$value = 1;
		}
		return $value;
	}
    
  public static function randPass($length, $strength=8) {
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength >= 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength >= 2) {
        $vowels .= "AEUY";
    }
    if ($strength >= 4) {
        $consonants .= '23456789';
    }
    if ($strength >= 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
      if ($alt == 1) {
          $password .= $consonants[(rand() % strlen($consonants))];
          $alt = 0;
      } else {
          $password .= $vowels[(rand() % strlen($vowels))];
          $alt = 1;
      }
    }
    return $password;
  }
    
  public static function getInvitationStatus($client_id)
	{
		$details = User::where("client_id", $client_id)->select("invitation_status")->first();
		$status = 'null';
		if(isset($details['invitation_status']) && $details['invitation_status'] != ""){
			$status = $details['invitation_status'];
		}
		return $status;
	}
    
    
  public static function getUserDetailsByClientId($client_id)
	{
    $data   = array();    
		$details = User::where("client_id", $client_id)->get();
    if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
        $data['user_id']    = $value['user_id'];
        $data['client_id']  = $value['client_id'];
        $data['email']      = $value['email'];
        $data['show_pass']  = $value['show_pass'];
      }
		}
        
		return $data;
	}
    
  public static function checkUserRelation($client_id, $user_id)
	{
    $data   = array();    
		$details = UserRelatedCompany::where("client_id", "=", $client_id)->where("user_id", "=", $user_id)->where("status", "=", 'A')->first();
    if(isset($details) && count($details) >0){
			$data['related_company_id'] = $details['related_company_id'];
      $data['client_id']          = $details['client_id'];
      $data['user_id']            = $details['user_id'];
      $data['status']             = $details['status'];
		}
        
		return $data;
	}
    
    
  public static function getDataByStaffIdAndField($user_id, $field_name)
  {
    $value = "";
    $client_details = User::where('user_id', $user_id)->select($field_name)->first();
    if(isset($client_details) && count($client_details) >0){
        $value = $client_details[$field_name];
    }
    return $value;
  }
    
  public static function getGroupStaffByGroupId($group_id, $user_type)
  {
    $data       = array();
    $staffs     = array();
    $clients    = array();

    if($user_type == 'S'){
      $details = User::where("group_id", "=", $group_id)->where('parent_id', '!=', '0')->where('client_id', '=', '0')->select("user_id")->get();
      if(isset($details) && count($details) >0){
        foreach ($details as $key => $value) {
          $staffs[$key] = User::getStaffDetailsById($value->user_id);
        }
      }
      return $staffs;
    }else{
      $details = User::where("group_id", "=", $group_id)->where('parent_id', '!=', '0')->where('client_id', '!=', '0')->select("user_id")->get();
      if(isset($details) && count($details) >0){
        foreach ($details as $key => $value) {
          $clients[$key] = User::getStaffDetailsById($value->user_id);
        }
      }
      return $clients;
    }
      
  }

  public static function getGeneralPlaceHolder($staff_id)
  {
    $a      = array();
    $fd     = User::getStaffDetailsById($staff_id);//echo "<pre>";print_r($fd);die;
    $d      = $fd['step_data'];
    $a['s_title']          = (isset($d['title']) && $d['title'] !='')?$d['title']:'';
    $a['s_fname']          = (isset($fd['fname']) && $fd['fname'] !='')?$fd['fname']:'';
    $a['s_mname']          = (isset($d['mname']) && $d['mname'] !='')?$d['mname']:'';
    $a['s_lname']          = (isset($fd['lname']) && $fd['lname'] !='')?$fd['lname']:'';
    $a['s_gender']         = (isset($d['gender']) && $d['gender'] !='')?$d['gender']:'';
    $a['s_dob']            = (isset($d['dob']) && $d['dob'] !='')?$d['dob']:'';
    $a['s_marital_status'] = (isset($d['maritStatus']) && $d['maritStatus']!='')?$d['maritStatus']:'';
    $a['s_nationality'] = (isset($d['nation_name']) && $d['nation_name'] !='')?$d['nation_name']:'';
    $a['s_country'] = (isset($d['country_name']) && $d['country_name'] !='')?$d['country_name']:'';
    $a['s_position']=(isset($d['position_name']) && $d['position_name'] !='')?$d['position_name']:'';
    $a['s_nino']            = (isset($d['ni_number']) && $d['ni_number'] !='')?$d['ni_number']:'';
    $a['s_ethik_origin']    = (isset($d['ethik_name']) && $d['ethik_name'] !='')?$d['ethik_name']:'';
    $a['s_prof_body']       = (isset($d['body_name']) && $d['body_name'] !='')?$d['body_name']:'';
    $a['s_membership']  =(isset($d['student_number']) && $d['student_number']!='')?$d['student_number']:'';
    $a['s_res_address1']=(isset($d['res_addr_line1']) && $d['res_addr_line1']!='')?$d['res_addr_line1']:'';
    $a['s_res_address2']=(isset($d['res_addr_line2']) && $d['res_addr_line2']!='')?$d['res_addr_line2']:'';
    $a['s_city']            = (isset($d['res_city']) && $d['res_city'] !='')?$d['res_city']:'';
    $a['s_county']          = (isset($d['res_county']) && $d['res_county'] !='')?$d['res_county']:'';
    $a['s_country']         = !empty($d['res_country_name'])?$d['res_country_name']:'';
    $a['s_postcode']        = (isset($d['res_postcode']) && $d['res_postcode'] !='')?$d['res_postcode']:'';
    $a['s_telephone']=(isset($d['res_telephone']) && $d['res_telephone'] !='')?$d['res_telephone']:'';
    $a['s_mobile']   = (isset($d['serv_mobile']) && $d['serv_mobile'] !='')?$d['serv_mobile']:'';
    $a['s_official_email']  = (isset($d['email']) && $d['email'] !='')?$d['email']:'';
    $a['s_personal_email']  = (isset($d['personal_email']) && $d['personal_email'] !='')?$d['personal_email']:'';
    $a['s_emergency_name']  = (isset($d['emer_name']) && $d['emer_name'] !='')?$d['emer_name']:'';
    $a['s_emer_tel']=(isset($d['emer_telephone']) && $d['emer_telephone']!='')?$d['emer_telephone']:'';
    $a['s_emergency_mob'] = (isset($d['emer_mobile']) && $d['emer_mobile'] !='')?$d['emer_mobile']:'';
    $a['s_emp_startdate'] = (isset($d['start_date']) && $d['start_date'] !='')?$d['start_date']:'';
    $a['s_holi_entlmnt']  = (isset($d['holiday_entitlement']) && $d['holiday_entitlement'] !='')?$d['holiday_entitlement']:'';
    $a['s_salary']          = (isset($d['salary']) && $d['salary'] !='')?$d['salary']:'';
    $a['s_qualification']   = (isset($d['qualifications']) && $d['qualifications']!='')?$d['qualifications']:'';
    $a['s_department']      = (isset($d['dept_name']) && $d['dept_name'] !='')?$d['dept_name']:'';
    $a['s_emp_enddate']     = (isset($d['end_date']) && $d['end_date'] !='')?$d['end_date']:'';
    $a['s_bank_name']       = (isset($d['bank_name']) && $d['bank_name'] !='')?$d['bank_name']:'';
    $a['s_bank_sortcode']   = (isset($d['short_code']) && $d['short_code'] !='')?$d['short_code']:'';
    $a['s_bank_acc_no']     = (isset($d['acc_no']) && $d['acc_no'] !='')?$d['acc_no']:'';
    //$a[''] = (isset($d['']) && $d[''] !='')?$d['']:'';

    return $a;
  }

  public static function get_tab_details($sendData)
  {  
    $start        = $sendData['start'];
    $limit        = $sendData['limit'];
    $sorting      = $sendData['sorting'];
    $search       = $sendData['search'];
    $tab_id       = $sendData['tab_id'];

    $data =  $od  = array();

    $sort         = explode(' ', $sorting);
    $groupUserId  = Client::getSessionUserIds();

    $header_sort  = '';
    $where = " where u.client_id='0' AND u.user_id IN (".implode(',', $groupUserId).") ";

    $staff_name   = StepsFieldsStaff::staffNameQuery();
    $telephone    = StepsFieldsStaff::staffFieldQuery('serv_telephone');
    $mobile       = StepsFieldsStaff::staffFieldQuery('serv_mobile');

    /*$reg_address = "(select CONCAT(
      (select field_value from steps_fields_staffs where field_name='res_addr_line1' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='res_addr_line2' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='res_city' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='res_county' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='res_postcode' and staff_id=u.user_id group by staff_id)
    ))";*/
    $address = StepsFieldsStaff::staffFieldQuery('res_city');

    if($sort[0] == 'staff_name'){
      $header_sort = " order by ".$staff_name.' '.$sort[1];
    }else if($sort[0] == 'telephone'){
      $header_sort = " order by ".$telephone.' '.$sort[1];
    }else if($sort[0] == 'mobile'){
      $header_sort = " order by ".$mobile.' '.$sort[1];
    }else if($sort[0] == 'email'){
      $header_sort = ' order by u.email '.$sort[1];
    }

    if(isset($search) && $search != ''){
      $where .= " AND (";
      $where .= $telephone." LIKE '%".$search."%' OR ";
      $where .= $mobile." LIKE '%".$search."%' OR ";
      $where .= " u.email LIKE '%".$search."%' OR ";
      $where .= $address." LIKE '%".$search."%' OR ";
      $where .= $staff_name." LIKE '%".$search."%') ";
    }

    $select = "select u.user_id, u.email,
      ".$staff_name." as staff_name,
      ".$telephone." as telephone,
      ".$mobile." as mobile,
      ".$address." as address
    ";

    $query = " FROM users u ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

    //============== total count section ==============
    $total_qry    = "select count(u.user_id) as count ".$query;
    $totalVal     = DB::select($total_qry);
    $total        = json_decode(json_encode($totalVal), true);

    $data['details']      = json_decode(json_encode($od), true);
    $data['TotalRecord']  = $total[0]['count'];

    return $data;

  }

  public static function userLists($sendData)
  {  
    $start        = $sendData['start'];
    $limit        = $sendData['limit'];
    $sorting      = $sendData['sorting'];
    $search       = $sendData['search'];
    $data =  $od  = array();

    $sort         = explode(' ', $sorting);
    $groupUserId  = Client::getSessionUserIds();

    $header_sort  = '';
    $where = " WHERE u.user_id IN (".implode(',', $groupUserId).") AND u.is_archive='N' AND u.client_id = '0' ";

    $staff_name           = StepsFieldsStaff::staffNameQuery();
    $start_date           = StepsFieldsStaff::staffFieldQuery('start_date');
    $dob                  = StepsFieldsStaff::staffFieldQuery('dob');
    $ni_number            = StepsFieldsStaff::staffFieldQuery('ni_number');
    $position_name        = StepsFieldsStaff::staffPositionQuery();
    $address              = StepsFieldsStaff::staffAddressQuery('res');
    $department_name      = StepsFieldsStaff::staffDepartmentQuery();

    if($sort[0] == 'staff_name'){
      $header_sort = " order by ".$staff_name.' '.$sort[1];
    }else if($sort[0] == 'ni_number'){
      $header_sort = " order by ".$ni_number.' '.$sort[1];
    }else if($sort[0] == 'position_name'){
      $header_sort = " order by ".$position_name.' '.$sort[1];
    }else if($sort[0] == 'department_name'){
      $header_sort = " order by ".$department_name.' '.$sort[1];
    }

    if(isset($search) && $search != ''){
      $where .= " AND (";
      $where .= $start_date." LIKE '%".$search."%' OR ";
      $where .= $dob." LIKE '%".$search."%' OR ";
      $where .= $ni_number." LIKE '%".$search."%' OR ";
      $where .= $position_name." LIKE '%".$search."%' OR ";
      $where .= $department_name." LIKE '%".$search."%' OR ";
      $where .= $address." LIKE '%".$search."%' OR ";

      $staff_name." LIKE '%".$search."%') ";
    }

    $select = "select u.user_id, u.show_archive,
      ".$staff_name." as staff_name,
      ".$position_name." as position_name,
      ".$department_name." as department_name,
      ".$start_date." as start_date,
      ".$ni_number." as ni_number,
      ".$dob." as dob,
      ".$address." as address
    ";

    $query = " FROM users u ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

    //============== total count section ==============
    $total_qry    = "select count(u.user_id) as count ".$query;
    $totalVal     = DB::select($total_qry);
    $total        = json_decode(json_encode($totalVal), true);

    $data['details']      = json_decode(json_encode($od), true);
    $data['TotalRecord']  = $total[0]['count'];

    return $data;

  }
    
}
