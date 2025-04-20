<?php

class FileandsignController extends BaseController {
  public function __construct()
  {
    parent::__construct();
    $session = Session::get('admin_details');
    $user_id = $session['id'];
    if (empty($user_id)){
        Redirect::to('/login')->send();
    }
  }
  
  public function fileandsign()
  {
    $data['heading']  = "FILE AND SIGN ";
    $data['title']    = "File & Sign";
    $admin_s          = Session::get('admin_details');
    $user_id          = $admin_s['id'];
    $group_id         = $admin_s['group_id'];
    $groupUserId      = $admin_s['group_users'];
    
    return View::make('fileandsign.fileandsign', $data);
  }

  public function file_share()
  {
    $doc = array();
    $session          = Session::get('admin_details');
    $user_id          = $session['id'];
    $groupUserId      = $session['group_users'];

    $data['heading']  = "FILE SHARE";
    $data['title']    = "File Share";
    $data['portal']   = "main";

    $data['client_details'] = Client::getClientNameAndId();
    
    //echo "<pre>";print_r($data['documents']);die;

    return View::make('Invitedclient/files/index', $data);
  }

}
