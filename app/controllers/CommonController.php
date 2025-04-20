<?php
class CommonController extends BaseController {
	public function __construct()
	{
		parent::__construct();
    $session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login')->send();
		}
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}
	}
	
	public function action()
  {
    $data         = array();
    $session      = Session::get('admin_details');
    $user_id      = $session['id'];
    $groupUserId  = $session['group_users'];
    $postData     = Input::all();

    switch ($postData['action']) {
      case 'manageNotification':
        $type     = $postData['type'];
        $position = $postData['position'];
        if($position == 'checked'){
          NotificationManage::where('user_id', $user_id)->where('type', $type)->delete();
        }else{
          $dInt['user_id']  = $user_id;
          $dInt['type']     = $type;
          $data['last_id'] = NotificationManage::insertGetId($dInt);
        }
        
        echo json_encode($data);
        break;
      
      default:
        # code...
        break;
    }

  }


    

}
