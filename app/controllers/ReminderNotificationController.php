<?php
class ReminderNotificationController extends BaseController {
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
	
	public function index($page_open)
	{
		$data               = array();
        $session            = Session::get('admin_details');
        $user_id            = $session['id'];
        $groupUserId        = $session['group_users'];
        $data['previous_page']    = "<a href='/settings-dashboard'>Settings</a>";
        $data['heading']    = "REMINDERS & NOTIFICATIONS";
        $data['title']      = "Reminders & Notifications";
        $data['goto_url']   = "/reminder-notification";
        $data['page_open']  = $page_open;
        $data['tab_no']     = $this->getTabNo($data['page_open']); 
        
        switch ($data['tab_no']) {
            case '1':
                $data['details']    = $this->getTabOneDetails($data['page_open']);
                break;
            case '2':
                $data['details']   = $this->getTabTwoDetails($data['page_open']);
                break;            
            case '3':
                $data['details']   = $this->getTabThreeDetails($data['page_open']);
                break;
        }
		
        //echo "<pre>";print_r($data['tab_details']);die;
        return View::make('settings.reminder_notification.index', $data);
	}
    
    public function getTabOneDetails($page_open)
    {
        $data = array();
        $data['services']   = Service::getAllServices();
        $data['users']      = User::getAllStaffName();  
        
        return $data;
    }
    
    public function getTabTwoDetails($page_open)
    {
        $data = array();
        $data['services']   = Service::getAllServices();
        $data['users']      = User::getAllStaffName();  
        
        return $data;
    }
    
    public function getTabThreeDetails($page_open)
    {
        $data = array();
        $data['users']  = User::getAllStaffName();
            
        return $data;
    }

    public function getTabNo($page_open)
    {
        $tab_no = 1;
        if($page_open == 1 || $page_open == 11){
            $tab_no = 1;
        }
        if($page_open == 2 || $page_open == 21 || $page_open == 22){
            $tab_no = 2;
        }
        if($page_open == 3 || $page_open == 31 || $page_open == 32){
            $tab_no = 3;
        }

        return $tab_no;
    }
    
    public function view_template()
    {
        return View::make('settings.reminder_notification.template.tabone');
    }
    
    public function template_action()
    {
      $data   = array();
      $session       = Session::get('admin_details');
      $user_id       = $session['id'];
      $groupUserId   = $session['group_users'];
      $group_id      = $session['group_id'];
      //print_r($session);
      
      $input  = Input::get();
      $action = $input['action'];
      
      if($action == 'get'){
          $service_id             = $input['service_id'];
          $data['details']        = ReminderTemplate::getTemplate();
          $data['services']       = Service::getNameServiceId( $service_id );
          $data['practices']      = PracticeDetail::getPracticeDetails($group_id);
          $data['statuses']       = JobsStep::getAllJobSteps($service_id);
      }else if($action == 'addNotificationType'){
        $service_id   = $input['service_id'];
        $client_id    = $input['client_id'];
        $click_type   = $input['click_type'];
        $is_enable    = $input['is_enable'];
        
        $datainsrt['user_id']           = $user_id;
        $datainsrt['client_id']         = $client_id;
        $datainsrt['service_id']        = $service_id;
        $datainsrt['is_notification']   = 'T';
        $datainsrt['is_enable']         = $is_enable;
        
        $details = TaskNotification::getColourStatus($client_id, $service_id, $is_enable);
        //Common::last_query();die;
        if($click_type == 'check'){
          if(isset($details) && count($details) >0){
            TaskNotification::where('id', $details['id'])->update($datainsrt);
          }else{
            $datainsrt['created']   = date('Y-m-d H:i:s');
            TaskNotification::insert($datainsrt);
          }
        }else{
          //TaskNotification::where('id', '=', $details['id'])->delete();
        }
        if(isset($details) && count($details) >0 && $click_type != 'check'){
          TaskNotification::where('id', $details['id'])->delete();
        }
      }else if($action == 'addReminder'){
        $service_id     = $input['service_id'];
        $value          = $input['value'];
        $click_type     = $input['click_type'];
        
        $datainsrt['user_id']       = $user_id;
        $datainsrt['service_id']    = $service_id;
        if($value == '1'){
          if($click_type == 'check'){
            $datainsrt['deadline']    = 'Y';
          }else{
            $datainsrt['deadline']    = 'N';
          }
        }else{
          if($click_type == 'check'){
            $datainsrt['taskstatus']      = 'Y';
          }else{
            $datainsrt['taskstatus']    = 'N';
          }
        }
            
        $details = TaskClientReminder::getDetailsByServiceId($service_id);
        if(isset($details) && count($details) >0){
          TaskClientReminder::where('id', '=', $details['id'])->update($datainsrt);
        }else{
          $datainsrt['created']   = date('Y-m-d H:i:s');
          TaskClientReminder::insert($datainsrt);
        }
      }else if($action == 'getGlobalReminder'){
        $service_id    = $input['service_id'];
        $data['details']   = TaskClientReminder::getDetailsByServiceId($service_id);
      }else if($action == 'getNotificationFreq'){
        $client_id     = $input['client_id'];
        $service_id    = $input['service_id'];
        $event         = $input['event'];
        if($event == 'save'){
          $next_send_date = date("Y-m-d",strtotime("+ ".$input['repeat_day']." days"));
          $freq_id                        = $input['freq_id'];
          $frqdata['user_id']             = $user_id;
          $frqdata['client_id']           = $client_id;
          $frqdata['service_id']          = $service_id;
          $frqdata['repeat_day']          = $input['repeat_day'];
          $frqdata['first_send_date']     = date('Y-m-d');
          $frqdata['next_send_date']      = $next_send_date;
          $frqdata['stop_reminder']       = $input['stop_reminder'];
          $frqdata['resp_email']          = $input['resp_email'];
          $frqdata['subject']             = $input['subject'];
          $frqdata['message']             = $input['message'];
          $frqdata['notification_type']   = $input['position'];
          //print_r($frqdata);die;

          $msgCount = NotificationFrequency::getCountByClientAndServiceId($client_id,$service_id,1);
          if(isset($msgCount) && $msgCount >0){
            NotificationFrequency::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->update($frqdata);
          }else{
            $frqdata['created'] = date('Y-m-d H:i:s');
            NotificationFrequency::insert($frqdata);
          }
        }
        if($event == 'delete'){
          $where['client_id']   = $client_id;
          $where['service_id']  = $service_id;
          NotificationFrequency::whereIn("user_id", $groupUserId)->where($where)->delete();
          $where['is_enable']  = 1;
          TaskNotification::whereIn("user_id", $groupUserId)->where($where)->delete();
        }else{
        $dtls = $emails = array();
        if($input['position'] == 2){
          $emails  = JobsEmail::getDetailsByClientAndServiceId($client_id, $service_id);
        }else{
          $dtls = NotificationFrequency::getDetailsByServiceAndClientId($service_id,$client_id,1);
        }
        $data['details']  = $dtls;
        $data['emails']   = $emails;
        }
      }else{
        $id = $input['id'];
        $data['subject']    = $input['subject'];
        $data['content']    = $input['template_message'];
        $data['reminder_template_id']   = $id;
        ReminderTemplate::where('reminder_template_id', $id)->update($data);
      }
        echo json_encode($data);
    }
    


}
