<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
    public function __construct() {       
        View::share('left_class', "collapse-left");
        View::share('right_class', "strech");
        $user_id        = "";
        $user_type      = "";
        $name           = "";
        $email          = "";
        $display_name   = "";
        $practice_logo  = "";
        $dashboard_url  = "";
        $user_access    = "";
        $short_name     = "";
        $profile_photo  = "";

        $admin_s = Session::get('admin_details');
        //echo "<pre>";print_r($admin_s);die;
        if(isset($admin_s) && count($admin_s) >0 ){
            $user_id    = $admin_s['id'];
            $user_type  = $admin_s['user_type'];//echo $admin_s['user_type'];die;
            $name       = $admin_s['fname']." ".$admin_s['lname'];
            $email      = $admin_s['email'];
            $short_name = substr($admin_s['fname'], 0, 1).substr($admin_s['lname'], 0, 1);

            $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);
            $practice_details = PracticeDetail::whereIn("user_id", $groupUserId)->first();

            if($admin_s['user_type'] == "C"){
                $display_name = $practice_details['display_name']." Client Portal";
            }else{
                $display_name = $practice_details['display_name'];
            }
            
            if (File::exists("colorextract/images/".$practice_details['practice_logo']) && $practice_details['practice_logo'] != ""){
                $practice_logo = "<img src='/colorextract/images/".$practice_details['practice_logo']."' class='browse_img' width='150'>";
            }else{
                $practice_logo = "";
            }
            

            $user_access = Common::getUserAccess($admin_s['id']);
            

            if(isset($admin_s['user_type']) && $admin_s['user_type'] == "C"){
                $dashboard_url = '/client-portal';
            }else{
                $dashboard_url = '/dashboard';
            }

            /* ============= Profile Image ========== */
            $files = ClientFile::where('client_id', "=", $user_id)->first();
            if (isset($files['profile_photo']) && $files['profile_photo'] != '') {
                $profile_photo = $files['profile_photo'];
            }
            
            
        }
        View::share('id', $user_id);
        View::share('user_type', $user_type);
        View::share('admin_name', $name);
        View::share('logged_email', $email);
        View::share('practice_name', $display_name);
        View::share('practice_logo', $practice_logo);
        View::share('dashboard_url', $dashboard_url);
        View::share('manage_user', $user_access);
        View::share('short_name', $short_name);
        View::share('profile_photo', $profile_photo);
        View::share('notesMaxLength', 8000);
        View::share('noticeMaxLength', 10000);

        $details = DataStore::getNotificationDetails();
        View::share('store_datas', $details);

        $unread_count = DataStore::getUnreadNotificationCount();
        View::share('unread_count', $unread_count);

        $notifications = NotificationManage::getNotificationView();
        View::share('notifications', $notifications);
        //echo "<pre>";print_r($details);die;
    }

	protected function setupLayout(){
        if ( ! is_null($this->layout)){
            $this->layout = View::make($this->layout);
        }
    }
    
    protected function isPostRequest(){
        //return Input::server('REQUEST_METHOD') === "POST";
        return Request::isMethod('POST');
    }
    
    function last_query() {
        $queries = DB::getQueryLog();
        $sql = end($queries);

        if( ! empty($sql['bindings']))
        {
            $pdo = DB::getPdo();
            foreach($sql['bindings'] as $binding)
            {
                $sql['query'] = preg_replace('/\?/', $pdo->quote($binding), $sql['query'], 1);
            }
        }   

        return $sql['query'];
    }

    public function requestClientData(){
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['user_id'];

        $details = DataStore::whereIn('user_id', $user_id)->get();
        return $details;
    }

}
