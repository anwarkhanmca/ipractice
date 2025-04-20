<?php
class TodoListController extends BaseController {
	public function __construct()
	{ 
		parent::__construct();
    $session 		       = Session::get('admin_details');//print_r($session);
		$this->user_id 		 = $session['id'];
		$this->user_type	 = $session['user_type'];
		$this->groupUserId = $session['group_users'];
		$this->group_id 	 = $session['group_id'];
    $this->todo_email  = $session['todo_email'];
		if (empty($this->user_id)) {
			Redirect::to('/login')->send();
		}
		if (isset($this->user_type) && $this->user_type == "C") {
			Redirect::to('/client-portal')->send();
		}
	}
	
	public function index($page_open) 
	{

    //echo strtolower('Email').base64_encode(141).'@i-practice.co.uk';die;
   	$data 	            = array();
   	$task_report 	      = array();
   	$jobs_report 	      = array();
    $data['goto_url']	  = "/todo-list";
		$data['page_open']  = base64_decode($page_open);
		$data['tab_no']     = $this->getTabNo($data['page_open']);
		$data['user_id'] 	  = $this->user_id;
		$data['group_id']	  = $this->group_id;
    $data['todo_email'] = $this->todo_email;
		$data['heading'] 	  = "TO DO LIST";
		$data['title']      = "To Do List";
    $data['added_from'] = "todo";
		$data['previous_page'] 	= '<a href="/staff-profile">Staff Profile</a>';

    //$data['allClients'] 	= App::make("HomeController")->get_all_clients();
    $data['staff_details'] 	= User::getAllStaffDetails();
    
    if($data['page_open'] == 2){
    	$data['closetask_report'] = Todolistnewtask::getCloseTaskDetails($this->user_id);
    }else{
    	/*$task_report = Todolistnewtask::getAllDetails($this->user_id);
        $jobs_report = Todolistnewtask::getJobsDetails(9, $this->user_id);
        $data['task_report'] = array_merge($task_report, $jobs_report);*/
        $data['timelines'] = Todolistnewtask::getTimeLines();
    }
    
    $data['allClients'] = Client::getClientNameAndId();

    //echo '<pre>';print_r($data['timelines']);die();
    return View::make("staff.profile.to_list", $data); 
	}

	public function getTabNo($page_open)
	{
		switch ($page_open) {
			case '11':
				return 1;break;
			case '12':
				return 2;break;
			case '13':
				return 3;break;
			case '14':
				return 4;break;
			case '15':
				return 5;break;
			case '16':
				return 6;break;
			default:
				return 1;
				break;
		}
	}

  public function savetask()
  { 
    $postData 		  = Input::all();//echo $postData['added_from'];die;
    $edit_data      = array();
    $session_data 	= Session::get('admin_details');
    $user_id 		    = $this->user_id;
    $groupUserId 	  = $this->groupUserId;
    $group_id 		  = $this->group_id;
    
    $page_open		= Input::get('page_open');
    $tab_no			  = base64_encode($page_open);
    
    $task_data['user_id']	  = $user_id;
    $task_data['group_id']	= $group_id;
    $task_id = $postData['editrowid'];
    
    if(isset($postData['editurgent']) && $postData['editurgent'] != ""){
        $edit_data['urgent'] = $postData['editurgent'];
    }
    if(isset($postData['is_billable']) && $postData['is_billable'] != ""){
        $edit_data['is_billable'] = $postData['is_billable'];
    }
    if (isset($postData['edittaskname']) && $postData['edittaskname'] != ""){
        $edit_data['taskname'] = $postData['edittaskname'];
    }
    if(isset($postData['edittaskdate']) && !empty($postData['edittaskdate'])){
        $edit_data['taskdate'] = date('Y-m-d', strtotime($postData['edittaskdate']));
    }
    if(isset($postData['edittask_time']) && !empty($postData['edittask_time'])) {
        $task_time = str_replace(' ', '', $postData['edittask_time']);
        $edit_data['task_time'] = $task_time.':00';
    }
    if(isset($postData['rel_client_id_edit']) && $postData['rel_client_id_edit'] != ""){
        $edit_data['rel_client_id'] = $postData['rel_client_id_edit'];
    }
    if (isset($postData['staff_id_edit']) && !empty($postData['staff_id_edit'])) {
        $edit_data['staff_id'] = $postData['staff_id_edit'];
    }else{
        $edit_data['staff_id'] = $user_id;
    }
    if (isset($postData['editnotes']) && !empty($postData['editnotes'])) {
        $edit_data['notes'] = $postData['editnotes'];
    }
    if (isset($postData['amount']) && !empty($postData['amount'])) {
        $edit_data['amount'] = $postData['amount'];
    }
    if (isset($postData['editattacment']) && !empty($postData['editattacment'])) {
        $edit_data['add_file'] = $postData['editattacment'];
    }
    if (isset($postData['added_from']) && $postData['added_from'] != '') {
        $edit_data['added_from'] = $postData['added_from'];
    }

    //echo "<pre>";print_r($edit_data);die;
    if($task_id == 0){
    	$edit_data['user_id']  = $user_id;
    	$edit_data['group_id'] = $group_id;
    	$edit_data['status']   = "not_started";
    	$task_id = Todolistnewtask::insertGetId($edit_data);
    }else{
      $status = Todolistnewtask::getJobStatusById($task_id);
      if($status == 'allocate_job'){
        $edit_data['status'] = 'not_started';
      }
      Todolistnewtask::where("todolistnewtasks_id", $task_id)->update($edit_data);
    }
      

   	if(Input::hasFile('add_file_edit')) {
      $file = Input::file('add_file_edit');
      $destinationPath = "uploads/todolist/".$group_id;
      $fileName = Input::file('add_file_edit')->getClientOriginalName();

      $fileName = $task_id . $fileName;
      $result = Input::file('add_file_edit')->move($destinationPath, $fileName);

      $fileedit_data['add_file'] = $fileName;
      Todolistnewtask::where("todolistnewtasks_id", $task_id)->update($fileedit_data);
    }

    /* Notification Section */
    Todolistnewtask::sendNotification($task_id);

    echo $task_id;
   	//return Redirect::to('/todo-list/'.$tab_no);
      
  }

  public function ajax_save_task()
  {
    $service_id     = 9;
    $groupUserId    = $this->groupUserId;
    $user_id        = $this->user_id;

  	$calender_date 	= Input::get('calender_date');
  	$calender_time 	= Input::get('calender_time');
  	$task_type 		= Input::get('task_type');
  	$task_id 		= Input::get('task_id');

      $data['taskdate']   = date('Y-m-d', strtotime($calender_date));
      $task_time          = str_replace(' ', '', $calender_time);
      $data['task_time']  = $task_time.":00";

      if($task_type == "todo"){
      	Todolistnewtask::where("todolistnewtasks_id", "=", $task_id)->update($data);
      }else{
          $notes = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $task_id)->where("service_id", "=", $service_id)->first();
          $jobs_data['job_start_date'] = $data['taskdate']." ".$data['task_time']; 

          if(isset($notes) && count($notes) >0){
              JobsNote::where("jobs_notes_id", "=", $notes['jobs_notes_id'])->update($jobs_data);
              $last_id = $notes['jobs_notes_id'];
          }else{
              $jobs_data['client_id']  = $task_id;
              $jobs_data['service_id'] = $service_id;
              $jobs_data['user_id']    = $user_id;
              $last_id = JobsNote::insertGetId($jobs_data);
          }
      }
  	echo $task_id;
  }

  public function ajax_delete_task()
  {
    $task_type      = Input::get('task_type');
    $task_id        = Input::get('task_id');

    if($task_type == "todo"){
      $data['is_deleted']  = "Y";
      Todolistnewtask::where("todolistnewtasks_id", $task_id)->update($data);
    }if($task_type == "close"){
      Todolistnewtask::where("todolistnewtasks_id", $task_id)->delete();
    }else{
      $data['is_show_todo']  = "N";
      Client::where('client_id', $task_id)->update($data);
    }
    //Common::last_query();die;
    echo $task_id;
  }

  public function pdfpendingtask($page_open)
  {
    $data 	        = array();
   	$task_report 	= array();
   	$jobs_report 	= array();
    $t      = time();
  	$time   = date("Y-m-d H:i:s", $t);
  	$pieces = explode(" ", $time);
  	$data['cdate']  = $pieces[0];

  	$data['ctime']  = $pieces[1];

  	$today  = date("j F  Y");
  	$data['today']  = $today;

  	$time   = date(" G:i:s ");
  	$data['time']   = $time;
    $data['goto_url']	= "/todo-list";
      
    $data['page_open'] 	= base64_decode($page_open);
  	$data['tab_no'] 	= $this->getTabNo($data['page_open']);
        //echo $data['page_open'];die();
  	$data['user_id'] 	= $this->user_id;
  	$data['group_id']	= $this->group_id;
        //print_r($data);die();
  	$data['heading'] 	= "TO DO LIST";
  	$data['title'] 		= "To Do List";
  	$data['previous_page'] 	= '<a href="/staff-profile">Staff Profile</a>';

    $data['allClients'] 	= App::make("HomeController")->get_all_clients();
    $data['staff_details'] 	= User::getAllStaffDetails();
    
    if($data['page_open'] == 2){
    	$data['closetask_report'] =Todolistnewtask::getCloseTaskDetails($this->user_id);
    }else{
    	$task_report = Todolistnewtask::getAllDetails($this->user_id);
        $jobs_report = Todolistnewtask::getJobsDetails(9, $this->user_id);
        $data['task_report'] = array_merge($task_report, $jobs_report);
    }

    if($data['page_open'] == 2){
      $pdf = PDF::loadView('staff.profile.pdfclosingingtask', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
      return $pdf->download('Closedtask.pdf');
    }else{
      $pdf = PDF::loadView('staff.profile.pdfpendingtask', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
      return $pdf->download('Pendingtask.pdf');
    }
  }
  
  public function excelpendingtask($page_open)
  {
    $data 	        = array();
   	$task_report 	= array();
   	$jobs_report 	= array();
    $t      = time();
  	$time   = date("Y-m-d H:i:s", $t);
  	$pieces = explode(" ", $time);
  	$data['cdate'] = $pieces[0];

  	$data['ctime'] = $pieces[1];

  	$today = date("j F  Y");
  	$data['today'] = $today;

  	$time = date(" G:i:s ");
  	$data['time'] = $time;
    $data['goto_url']	= "/todo-list";
  	$data['page_open'] 	= base64_decode($page_open);
  	$data['tab_no'] 	= $this->getTabNo($data['page_open']);
  	$data['user_id'] 	= $this->user_id;
  	$data['group_id']	= $this->group_id;
        //print_r($data);die();
  	$data['heading'] 	= "TO DO LIST";
  	$data['title'] 		= "To Do List";
  	$data['previous_page'] 	= '<a href="/staff-profile">Staff Profile</a>';

    $data['allClients'] 	= App::make("HomeController")->get_all_clients();
    $data['staff_details'] 	= User::getAllStaffDetails();
      
    if($data['page_open'] == 2){
    	$data['closetask_report'] =Todolistnewtask::getCloseTaskDetails($this->user_id);
    }else{
    	$task_report = Todolistnewtask::getAllDetails($this->user_id);
      $jobs_report = Todolistnewtask::getJobsDetails(9, $this->user_id);
      $data['task_report'] = array_merge($task_report, $jobs_report);
    }
      
    if($data['page_open'] == 2){
    	$viewToLoad = 'staff.profile.exceclosedtask';
  		///////////  Start Generate and store excel file ////////////////////////////
  		Excel::create('Closedtask', function ($excel) use ($data, $viewToLoad) {

  			$excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad) {
  				$sheet->loadView($viewToLoad)->with($data);
  			})->save();

  		});
    
      //
      
   
    	$filepath = storage_path() . '/exports/Closedtask.xls';
    	$fileName = 'Closedtask.xls';
    	$headers = array(
    		'Content-Type: application/vnd.ms-excel',
    	);

    	return Response::download($filepath, $fileName, $headers);
    	exit;
    
    }else{
          
    	$viewToLoad = 'staff.profile.excelpendingtask';
  		///////////  Start Generate and store excel file ////////////////////////////
  		Excel::create('Pendingtask', function ($excel) use ($data, $viewToLoad) {

  			$excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad) {
  				$sheet->loadView($viewToLoad)->with($data);
  			})->save();

  		});
      
      //
      
   
    	$filepath = storage_path() . '/exports/Pendingtask.xls';
    	$fileName = 'Pendingtask.xls';
    	$headers = array(
    		'Content-Type: application/vnd.ms-excel',
    	);

    	return Response::download($filepath, $fileName, $headers);
    	exit;
    
    }
      
  }

    public function action()
    {
        $data           = array();
        $action         = Input::get('action'); 
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        switch ($action) {
            case 'getTodoEmail':
                $data['details'] = $this->getTodoEmail();
                echo json_encode($data);
                break;
            case 'viewSentEmail':
                $count = Todolistnewtask::where(function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)->orWhere('staff_id', $user_id);
                })->where('is_viewed', 'N')->count();

                if($count >0 ){
                    Todolistnewtask::where('user_id', $user_id)->update(array('is_viewed'=>'Y'));
                }
                $data['is_viewed'] = $count;
                echo json_encode($data);
                break;
            default:
                # code...
                break;
        }

    }

    public function getTodoEmail()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $details = User::whereIn('user_id', $groupUserId)->select('user_id', 'todo_email')->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $k => $v) {
                $data[$k]['user_id']    = $v->user_id;
                $data[$k]['user_name']  = User::getStaffNameById($v->user_id);
                $data[$k]['todo_email'] = $v->todo_email;
            }
        }
        return $data;
    }

}
