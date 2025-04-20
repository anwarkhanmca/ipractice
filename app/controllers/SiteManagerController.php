<?php
class SiteManagerController extends BaseController {
  public function __construct()
  {
    parent::__construct();
    $session    = Session::get('admin_details');
    $user_id    = $session['id'];
    //print_r($session);//die('end');
    if (empty($session['user_type']) || $session['user_type'] != "A") {
      Session::flash('message', 'You can`t access admin portal');
      Redirect::to('/login')->send();
    }
  }
  
  public function index($page_open){
    $session    = Session::get('admin_details');

    $data = array();
    $data['page_open'] = $page_open;

    $users = User::getAllUserDetails();
    $details = array();
    $i = 0;
    if(isset($users) && count($users) >0){
      foreach ($users as $key => $value) {
        if(isset($value['parent_id']) && $value['parent_id'] == '0'){
          $details[$i] = $value;

          $name = PracticeDetail::get_practice_name($value['group_id']);
          $details[$i]['practice_name'] = $name;

          $details[$i]['groupStaffs']   = User::getGroupStaffByGroupId( $value['group_id'], 'S' );
          $details[$i]['groupclients']  = User::getGroupStaffByGroupId( $value['group_id'], 'C' );

          $i++;
        }
      }
    }

    $data['users'] = $details;

    /*$data['users'] = User::getAllUserDetails();
    if(isset($data['users']) && count($data['users']) >0){
      foreach ($data['users'] as $key => $value) {
        $name = PracticeDetail::get_practice_name($value['group_id']);
        $data['users'][$key]['practice_name'] = $name;
      }
    }*/

    $data['paypal_details']   = PaypalSetting::getDetails();

    if($page_open == 4 || $page_open == 5 || $page_open == 6){
      if($page_open == 4){
        $msg_type = 'R';
      }else if($page_open == 5){
        $msg_type = 'S';
      }else{
        $msg_type = 'C';
      }
      $data['contact_reports']  = ContactReport::getFullDetailsByType($msg_type);
    }
    //echo "<pre>";print_r($data['contact_reports']);   
    return View::make("site_manager.admin",$data);
  }

  public function delete_user(){
    $user_id = Input::get('user_id');
    User::where('user_id', '=', $user_id)->delete();
    StepsFieldsStaff::where('staff_id', '=', $user_id)->delete();
    echo $user_id;
  }

  public function save_paypal_settings()
  {
    $data = array();
    $updtdata['server']   = Input::get('server');
    $updtdata['email']    = Input::get('email');
    $updtdata['perclient_price']  = Input::get('price');
    $updtdata['created']  = date('Y-m-d H:i:s');
    $sql = PaypalSetting::where('paypal_id', '=', 1)->update($updtdata);
    if($sql){
      $data['msg'] = 'success';
    }else{
      $data['msg'] = 'error';
    }
    echo json_encode($data);
    die;
  }

  public function delete_contact_report()
  {
    $report_id =  Input::get('report_id');
    ContactReport::where('report_id', '=', $report_id)->delete();
    echo $report_id;
    //echo $this->last_query();
  }

  public function get_contact_report()
  {
    $report_id =  Input::get('report_id');
    $details = ContactReport::getDetailsById($report_id);

    $updata['is_view'] = 'Y';
    ContactReport::where('report_id', '=', $report_id)->update($updata);
    echo json_encode($details);
    //echo $this->last_query();
  }

}
