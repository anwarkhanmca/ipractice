<?php
class StepsFieldsStaff extends Eloquent {
	public $timestamps = false;

	public static function updateField($field_name, $staff_id, $field_value)
	{
		$session    = Session::get('admin_details');
        $user_id    = $session['id'];
		$staffs = StepsFieldsStaff::where('staff_id', '=', $staff_id)->where('field_name', '=', $field_name)->first();
        if(isset($staffs) && count($staffs)>0){
            $stp['field_value'] = $field_value;
            StepsFieldsStaff::where('field_id', '=', $staffs['field_id'])->update($stp);
        }else{
        	$data['user_id'] 		= $user_id;
        	$data['staff_id'] 		= $staff_id;
        	$data['step_id'] 		= 3;
        	$data['field_name'] 	= $field_name;
        	$data['field_value'] 	= $field_value;
        	$data['created'] 		= date('Y-m-d H:i:s');
        	StepsFieldsStaff::insert($data);
        }
	}

  public static function getDataByStaffIdAndField($staff_id, $field_name)
  {
      $value = "";
      $client_details = StepsFieldsStaff::where('staff_id', '=', $staff_id)->where('field_name', '=', $field_name)->select("field_value")->first();
      if(isset($client_details) && count($client_details) >0){
          $value = $client_details['field_value'];
      }
      return $value;
  }

  public static function storeUpdatingStaffData($postData)
  { 
    $arrData    = array();
    $admin_s    = Session::get('admin_details');

    $user_id   = $postData['user_id'];

    $addData['user_id']     = $user_id;
    $addData['client_id']   = '0';
    $addData['client_type'] = 'staff';
    $addData['is_read']     = 'N';
    $store_id = DataStore::insertGetId($addData);

    $title = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'title');
    if($postData['title'] != $title)
      $arrData[] = Common::save_client(0,1,'title',$title,$postData['title'],$store_id,'Title');

    $fname = User::getDataByStaffIdAndField($user_id, 'fname');
    if($postData['fname'] != $fname)
      $arrData[] = Common::save_client(0,1,'fname',$fname,$postData['fname'],$store_id,'First Name');
    //echo 'F:'.$fname.', L:'.$postData['fname'];die;
    $mname = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'mname');
    if($postData['mname'] != $mname)
      $arrData[] = Common::save_client(0,1,'mname',$mname,$postData['mname'],$store_id,'Middle Name');

    $lname = User::getDataByStaffIdAndField($user_id, 'lname');
    if($postData['lname'] != $lname)
      $arrData[] = Common::save_client(0,1,'lname',$lname,$postData['lname'],$store_id,'Last Name');

    $dob = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'dob');
    if($postData['dob'] != $dob)
      $arrData[] = Common::save_client(0,1,'dob',$dob,$postData['dob'],$store_id,'Date of Birth');

    $nationality = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'nationality');
    if($postData['nationality'] != $nationality){
      $prev_name  = Nationality::getNationalityNameById($nationality);
      $new_name   = Nationality::getNationalityNameById($postData['nationality']);

      $arrData[] =Common::save_client(0,1,'nationality',$prev_name,$new_name,$store_id,'Nationality');
    }

    $marital_status = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'marital_status');
    if($postData['marital_status'] != $marital_status){
      $prev_marit = MaritalStatus::getMeritalNameById($marital_status);
      $new_marit  = MaritalStatus::getMeritalNameById($postData['marital_status']);
      $arrData[]  = Common::save_client(0,1,'marital_status',$prev_marit,$new_marit,$store_id,'Marital Status');
    }

    $ni_number = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'ni_number');
    if($postData['ni_number'] != $ni_number)
        $arrData[] = Common::save_client(0,1,'ni_number',$ni_number,$postData['ni_number'],$store_id,'NI Number');

    $res_addr_line1 = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'res_addr_line1');
    if($postData['address1'] != $res_addr_line1)
        $arrData[] = Common::save_client(0,1,'res_addr_line1',$res_addr_line1,$postData['address1'],$store_id,'Address Line 1');

    $res_postcode = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'res_postcode');
    if($postData['address_postcode'] != $res_postcode)
        $arrData[] = Common::save_client(0,1,'res_postcode', $res_postcode, $postData['address_postcode'],$store_id,'Post Code');

    $serv_mobile = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'serv_mobile');
    if($postData['serv_mobile'] != $serv_mobile)
      $arrData[] = Common::save_client(0,1,'serv_mobile',$serv_mobile,$postData['serv_mobile'],$store_id,'Mobile Number');

    $bank_name = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'bank_name');
    if($postData['bank_name'] != $bank_name)
      $arrData[] = Common::save_client(0,1,'bank_name',$bank_name,$postData['bank_name'],$store_id,'Bank Name');

    $short_code = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'short_code');
    if($postData['short_code'] != $short_code)
      $arrData[] = Common::save_client(0,1,'short_code',$short_code,$postData['short_code'],$store_id,'Sort Code');

    $acc_no = StepsFieldsStaff::getDataByStaffIdAndField($user_id, 'acc_no');
    if($postData['acc_no'] != $acc_no)
      $arrData[] = Common::save_client(0,1,'acc_no',$acc_no,$postData['acc_no'],$store_id,'Account Number');

    if(!empty($arrData)){
      ClientDataStore::insert($arrData);
    }
    /* Email send notifications */
    $HOSTNAME = Config::get('constant.HOSTNAME');
    if($HOSTNAME != 'eweb.ipractice.com'){
      StepsFieldsStaff::sendNotification( $user_id, $store_id );
    }
  }

  public static function sendNotification($staff_id, $store_id)
  {
    $emails = array();
    $session        = Session::get('admin_details');
    //$groupUserId    = $session['group_users'];
    $user_id        = $session['id'];
    $group_id       = $session['group_id'];
    $groupUserId    = Client::getSessionUserIds();

    $emails = User::getStaffManagementAccessEmail();
    //$emails = array('anwarkhanmca786@gmail.com');
    //echo "<pre>";print_r($emails);die;
    $data['email']        = array_unique($emails);
    $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
    $data['STAFFNAME']    = User::getStaffNameById($staff_id);
    $data['details']      = DataStore::getDetailsByStoreId($store_id);
    $data['USERNAME']     = User::getStaffNameById($user_id);
    //echo "<pre>";print_r($data['details']);die;

    Mail::send('emails.staff_details_change', $data, function ($message) use ($data) {
      $message->subject('Notifications for '.$data['STAFFNAME']);
      $message->from($data['senderEmail']);
      $message->to($data['email']);
    });

  }

  public static function staffNameQuery()
  {
    $fields = " CONCAT(u.fname, ' ', u.lname) ";
    return $fields;
  }

  public static function staffFieldQuery($field_name)
  { 
    $fields = " (select field_value from steps_fields_staffs where field_name='".$field_name."' and staff_id=u.user_id group by staff_id) ";
    return $fields;
  }

  public static function staffAddressQuery($type)
  {
    $fields = " (select CONCAT(
      (select field_value from steps_fields_staffs where field_name='".$type."_addr_line1' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='".$type."_addr_line2' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='".$type."_city' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='".$type."_county' and staff_id=u.user_id group by staff_id), ' ',
      (select field_value from steps_fields_staffs where field_name='".$type."_postcode' and staff_id=u.user_id group by staff_id)
    )) ";
    return $fields;
  }

  public static function staffPositionQuery()
  { 
    $fields = " (select p.name from positions as p where p.position_id=(select field_value from steps_fields_staffs where field_name='position_type' and staff_id=u.user_id group by staff_id) ) ";
    return $fields;
  }

  public static function staffDepartmentQuery()
  { 
    $fields = " (select d.name from departments as d where d.department_id=(select field_value from steps_fields_staffs where field_name='department' and staff_id=u.user_id group by staff_id) ) ";
    return $fields;
  }
	

}
