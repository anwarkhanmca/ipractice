<?php
//use DB;
class Todolistnewtask  extends Eloquent{
	
	public $timestamps = false;

	public static function getAllDetails($user_id)
	{
		$data = array();
		$task_details = DB::select(DB::raw("SELECT * FROM todolistnewtasks WHERE `status`<>'close' AND (user_id=".$user_id." OR staff_id=".$user_id.") AND status != 'allocate_job'" ));
        //Common::last_query();die;
       
    if (!empty($task_details)) {
      foreach ($task_details as $key => $val) {
          $data[$key]['todolistnewtasks_id'] = $val->todolistnewtasks_id;
          $data[$key]['staff_name'] 	= User::getStaffNameById($val->staff_id);
          $data[$key]['client_name'] 	= Client::getClientNameByClientId($val->rel_client_id);

          $data[$key]['urgent'] 		= $val->urgent;
          $data[$key]['taskdate']     =(isset($val->taskdate) && $val->taskdate!='0000-00-00')?$val->taskdate:"";
          $data[$key]['task_time']    = (isset($val->task_time) && $val->task_time!='00:00:00')?$val->task_time:"";
          $data[$key]['taskname'] 	= $val->taskname;
          $data[$key]['notes'] 		= $val->notes;
          $data[$key]['activities']   = $val->activities;
          $data[$key]['add_file'] 	= $val->add_file;
          $data[$key]['status'] 		= $val->status;
          $data[$key]['created'] 		= $val->created;
          $data[$key]['showin_tab'] 	= Todolistnewtask::getShowIn($data[$key]['taskdate'], $data[$key]['task_time']);
          $data[$key]['task_type'] 	= "todo";
      }
    }
    return $data;
	}

  public static function getDetailsById($id)
  {
    $data = array();
    $task_details = DB::select(DB::raw("SELECT * FROM todolistnewtasks WHERE todolistnewtasks_id='".$id."'"));
   //echo $this->last_query();die;
   
    if (!empty($task_details)) {
      foreach ($task_details as $key => $val) {
        $data['todolistnewtasks_id'] = $val->todolistnewtasks_id;
        $data['staff_name']     = User::getStaffNameById($val->staff_id);
        $data['client_name']    = Client::getClientNameByClientId($val->rel_client_id);
        $data['user_id']        = $val->user_id;
        $data['group_id']       = $val->group_id;
        $data['proposal_id']    = $val->proposal_id;
        $data['added_from']     = $val->added_from;
        $data['urgent']         = $val->urgent;

        $data['is_billable']    = $val->is_billable;
        $data['taskname']       = $val->taskname;
        $data['taskdate']= (isset($val->taskdate) && $val->taskdate !='0000-00-00')?$val->taskdate:"";
        $data['task_time']=(isset($val->task_time) && $val->task_time!='00:00:00')?$val->task_time:"";

        $data['rel_client_id']  = $val->rel_client_id;
        $data['staff_id']       = $val->staff_id;
        $data['notes']          = $val->notes;
        $data['activities']     = $val->activities;
        $data['amount']         = $val->amount;
        $data['add_file']       = $val->add_file;
        $data['status']         = $val->status;
        $data['created']        = $val->created;
        $data['showin_tab']     = Todolistnewtask::getShowIn($data['taskdate'], $data['task_time']);
      }
    }
    return $data;
  }

	public static function getJobsDetails($service_id, $user_id)
	{
		$data = array();
		$jobs_details = Client::getAssignedClientDetails($service_id, $user_id);
		//echo "<pre>";print_r($jobs_details);echo "</pre>";die;
       	//Common::last_query();//die;
       
        if (!empty($jobs_details)) {
          foreach ($jobs_details as $key => $val) {
            if(isset($val['ch_manage_task']) && $val['ch_manage_task'] == "Y"){
              if(isset($val['is_show_todo']) && $val['is_show_todo'] != "N"){
        		if(isset($val['jobs_notes']['job_start_date']) && $val['jobs_notes']['job_start_date'] != ""){
        			$start_date = explode(' ', $val['jobs_notes']['job_start_date']);
        			$data[$key]['taskdate'] 	= $start_date[0];
        			$data[$key]['task_time'] 	= $start_date[1];
        		}else{
        			$data[$key]['taskdate'] 	= "";
        			$data[$key]['task_time'] 	= "";
        		}
            	
            	//print_r($start_date);die;
                $data[$key]['todolistnewtasks_id'] 	= $val['client_id'];
                $data[$key]['staff_name'] 	= $val['allocated_staffs'][0]['staff_name'];
                $data[$key]['client_name'] 	= (isset($val['client_type']) && $val['client_type'] == "org")?$val['business_name']:$val['client_name'];
				$data[$key]['urgent'] 		= "No";
                $data[$key]['taskname'] 	= "CH Annual Return";
                $data[$key]['notes'] 		= (isset($val['jobs_notes']['notes']) && $val['jobs_notes']['notes'] != "")?$val['jobs_notes']['notes']:'';
                $data[$key]['add_file'] 	= "";

                if(isset($val['job_status'][$service_id]['status_id']) && $val['job_status'][$service_id]['status_id'] != ""){
                	$data[$key]['status'] 	= JobsStep::getStepNameByStepId($val['job_status'][$service_id]['status_id']);
                }else{
                	$data[$key]['status'] 	= "Not Started";
                }
                if(isset($val['job_status'][$service_id]['created']) && $val['job_status'][$service_id]['created'] != ""){
                	$data[$key]['created'] 	= $val['job_status'][$service_id]['created'];
                }else{
                	$data[$key]['created'] 	= "";
                }

                $data[$key]['showin_tab'] 	= Todolistnewtask::getShowIn($data[$key]['taskdate'], $data[$key]['task_time']);
                $data[$key]['task_type'] 	= "jobs";
	          }
	        }
          }
        }
        return $data;
	}

	public static function getShowIn($date, $time)
	{//echo date('Y-m-d');die;
		$showin = 1;
		$inthirtyday = "";
		if($date != ""){
			$task_date       = $date;
			$insevenday 	 = date('Y-m-d', strtotime('+7 days'));
			$inthirtyday 	 = date('Y-m-d', strtotime('+30 days'));
			$inthreemonths 	 = date('Y-m-d', strtotime('+3 months'));
			$insixmonths 	 = date('Y-m-d', strtotime('+6 months'));

			if($task_date == date('Y-m-d') || $task_date == ""){
				$showin = 1;
			}
			if($task_date < $insevenday && $task_date > date('Y-m-d')){
				$showin = 2;
			}
			if($task_date >= $insevenday && $task_date < $inthirtyday){
				$showin = 3;
			}
			if($task_date >= $inthirtyday && $task_date < $inthreemonths){
				$showin = 4;
			}
			if($task_date >= $inthreemonths && $task_date < $insixmonths){
				$showin = 5;
			}
			if($task_date >= $insixmonths){
				$showin = 6;
			}
		}
		return $showin;
	}

	public static function getCloseTaskDetails($user_id)
	{
		$data = array();
		$closetask_details = DB::select(DB::raw("SELECT * FROM todolistnewtasks WHERE `status`='close' AND (user_id=".$user_id." OR staff_id=".$user_id.") AND status != 'allocate_job'" ));
      
  	if (!empty($closetask_details)) {
      foreach ($closetask_details as $key => $val) {
          
        $data[$key]['todolistnewtasks_id'] = $val->todolistnewtasks_id;
        $data[$key]['staff_detail'] = User::where("user_id", $val->staff_id)->select("user_id", "fname", "lname")->first();
        $data[$key]['client_detail'] = StepsFieldsClient::where("client_id", $val->rel_client_id)->where(function ($query){
        $query->where("field_name","business_name")->orWhere("field_name","client_name"); })->first();
        
        $data[$key]['urgent']       = $val->urgent;
        $data[$key]['taskdate']     = $val->taskdate;
        $data[$key]['task_time']    = $val->task_time;
        $data[$key]['taskname']     = $val->taskname;
        $data[$key]['notes']        = $val->notes;
        $data[$key]['activities']   = $val->activities;
        $data[$key]['add_file']     = $val->add_file;
        $data[$key]['status']       = $val->status;
        $data[$key]['created']      = $val->created;
      }
    } 
    return $data;

	}

  public static function getTaskByRelationClientId($client_id, $added_from)
  {
    $value = 0;
    $details = Todolistnewtask::where("rel_client_id", $client_id)->where('added_from', $added_from)->first();
    if(isset($details) && count($details) >0){
        $value = 1;
    }

    return $value;
  }

  public static function getNotesById($id)
  {
    $service = Todolistnewtask::where("todolistnewtasks_id", $id)->select('notes')->first();
    $notes = '';
    if(isset($service['notes']) && $service['notes'] != "" ){
        $notes = $service['notes'];
    }
    return $notes;
  }

  public static function getJobStatusById($id)
  {
    $service = Todolistnewtask::where("todolistnewtasks_id", $id)->select('status')->first();
    $status = '';
    if(isset($service['status']) && $service['status'] != "" ){
        $status = $service['status'];
    }
    return $status;
  }

  public static function saveProposalServicesToWip($proposalId, $groupUserId)
  {
      $group_users = array();
      if(isset($groupUserId) && count($groupUserId) >0){
          foreach ($groupUserId as $key => $value) {
              $group_users[$key] = $value['user_id'];
          }
      }

      $query = "SELECT 
          cps.p_service_id,
          cps.fees as amount, 
          s.service_name, 
          cp.proposalID as proposal_id,
          cp.prospect_id as client_id,
          cp.contact_type, 
          cp.user_id
              FROM crm_proposal_services as cps  
              LEFT JOIN services as s ON cps.service_id = s.service_id  
              JOIN crm_proposal_tables as cpt ON cps.p_table_id = cpt.id  
              JOIN crm_proposals as cp ON cpt.proposal_id = cp.proposalID  
              WHERE cps.user_id IN ('".implode(',', $group_users)."') 
                  AND (cp.save_type='A' OR cp.save_type='MA') 
                  AND (cp.contact_type='c_org' OR cp.contact_type='c_ind' OR cp.contact_type='p_org' OR cp.contact_type='p_ind') 
                  AND cpt.package_type = 'F'
                  AND cp.proposalID = '".$proposalId."'";
      //echo $query;//die;
      $details = DB::select(DB::raw($query));
      //echo "<pre>";print_r($details);die;
      if(isset($details) && count($details) >0){
          $i = 0;
          foreach ($details as $k => $v) {
              $activities=CrmProposalActivity::getActivityIdByProposalServiceId($v->p_service_id,$groupUserId);
              $d[$i]['user_id']       = $v->user_id;
              $d[$i]['proposal_id']   = $v->proposal_id;
              $d[$i]['added_from']    = 'wip';
              $d[$i]['taskname']      = $v->service_name;
              $d[$i]['is_billable']   = 'Y';
              $d[$i]['rel_client_id'] = $v->client_id;
              $d[$i]['amount']        = $v->amount;
              $d[$i]['status']        = 'allocate_job';
              $d[$i]['notes']         = Todolistnewtask::getActivities($v->p_service_id, $groupUserId);
              $d[$i]['activities']    = implode(',', $activities);

              $i++;
          }
      }
      if(!empty($d)){
          Todolistnewtask::insert($d);
      }
  }

  public static function getActivities($p_service_id, $groupUserId)
  {
      $details = CrmProposalActivity::getActitiesByPropServiceId($p_service_id, $groupUserId);
      $notes = '<div class="actsubcontOthr">';
      $notes .= '<div class="actsubcontTl">This service includes :-</div>';
      $notes .= '<ul class="actsubsub">';

      if(isset($details) && count($details) >0){
          foreach ($details as $k => $vsa) {
              if($vsa['activity_option'] == 1){
                  $notes .= '<li>';
                  $notes .= '<div class="actsubimg"><img src="/img/black_right.png"></div>';
                  $notes .= '<div class="lileft">'.$vsa['name'].'</div>';
                  $notes .= '</li>';
              }
          }
      }

      $notes .= '</ul></div>';
      return $notes;
  }

  public static function getTimeLineByValue($value)
  {
      $text = '';
      if($value == 1){
          $text = 'Due Today';
      }else if($value == 2){
          $text = 'Due in 7 Days';
      }else if($value == 3){
          $text = 'Due in 30 Days';
      }else if($value == 4){
          $text = 'Due in 3 Months';
      }else if($value == 5){
          $text = 'Due in 6 Months';
      }else if($value == 6){
          $text = 'Due After 6 Months';
      }else if($value == 7){
          $text = 'Over Due';
      }

      return $text;
  }

  public static function todoPendingTable($sendData)
  { 
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];

      $start      = $sendData['start'];
      $limit      = $sendData['limit'];
      $sorting    = $sendData['sorting'];
      $search     = $sendData['search'];
      $timeline   = $sendData['timeline'];

      $data = $od = array();

      $sort           = explode(' ', $sorting);
      $groupUserId    = Client::getSessionUserIds();

      $header_sort = '';

      $where = " WHERE tl.is_deleted != 'Y' AND ";
      if($timeline == 1){
          $where .= " DATE(tl.taskdate) = CURDATE() AND ";
      }else if($timeline == 2){
          $where .= " DATE(tl.taskdate) > CURDATE() AND DATE(tl.taskdate) <= DATE(CURDATE()+7) AND ";
      }else if($timeline == 3){
          $where .= " DATE(tl.taskdate) > DATE(CURDATE()+7) AND DATE(tl.taskdate) <= DATE(DATE_ADD(tl.taskdate, INTERVAL 30 DAY)) AND ";
      }else if($timeline == 4){
          $where .= " DATE(tl.taskdate) > DATE(CURDATE()+30) AND DATE(tl.taskdate) <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND ";
      }else if($timeline == 5){
          $where .= " DATE(tl.taskdate) > DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND DATE(tl.taskdate) <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH) AND ";
      }else if($timeline == 6){
          $where .= " DATE(tl.taskdate) > DATE_ADD(CURDATE(), INTERVAL 6 MONTH) AND ";
      }else if($timeline == 7){
          $where .= " DATE(tl.taskdate) < CURDATE() AND ";
      }

      $where .= " `status`<>'close' AND (user_id=".$user_id." OR staff_id=".$user_id.") AND status != 'allocate_job' ";

      $client_name  = "(select field_value from steps_fields_clients where ( field_name='business_name' or field_name = 'client_name') and client_id=tl.rel_client_id group by client_id)"; 

      $amount = " IF(tl.amount='', 0, ROUND(REPLACE(tl.amount, ',', ''),2)) ";

      $staff_name  = "(select CONCAT(fname, ' ', lname) as staff_name from users where user_id=tl.staff_id)";

      $comp_date1     = "IF(tl.taskdate='0000-00-00', '', DATE_FORMAT(tl.taskdate,'%d-%m-%Y'))";
      $comp_time1     = "IF(tl.task_time='00:00:00', '', DATE_FORMAT(tl.task_time,'%H:%i'))";
      $comp_date      = " CONCAT( ".$comp_date1.", ' ', ".$comp_time1.") ";
      $created        = "DATE_FORMAT(tl.created,'%Y-%m-%d')";
      $created_date   = "DATE_FORMAT(tl.created,'%d-%m-%Y')";

      $status = " IF( tl.status='', '', REPLACE(tl.status, '_', ' ') ) ";

      if($sort[0] == 'client_name'){
          $header_sort = " order by ".$client_name.' '.$sort[1];
      }else if($sort[0] == 'service_name'){
          $header_sort =  " order by tl.taskname ".$sort[1];
      }else if($sort[0] == 'amount'){
          $header_sort = " order by ".$amount.' '.$sort[1];
      }else if($sort[0] == 'created'){
          $header_sort = " order by ".$created.' '.$sort[1];
      }else if($sort[0] == 'proposal_id'){
          $header_sort = " order by tl.proposal_id ".$sort[1];
      }else if($sort[0] == 'staff_name'){
          $header_sort = " order by ".$staff_name.' '.$sort[1];
      }else if($sort[0] == 'status'){
          $header_sort = " order by ".$status.' '.$sort[1];
      }
      if(isset($search) && $search != ''){
          $where .= " AND (".$client_name." LIKE '%".$search."%' ";
          $where .= " OR tl.taskname LIKE '%".$search."%' ";
          $where .= " OR ".$amount." LIKE '%".$search."%'";
          $where .= " OR ".$created_date." LIKE '%".$search."%'";
          $where .= " OR tl.proposal_id LIKE '%".$search."%' ";
          $where .= " OR ".$staff_name." LIKE '%".$search."%'";
          $where .= " OR ".$comp_date." LIKE '%".$search."%'";
          $where .= " OR ".$status." LIKE '%".$search."%' ";
          $where .= " ) ";
      }

      $select = "SELECT 
          tl.todolistnewtasks_id as id, tl.proposal_id, tl.taskname as service_name, tl.notes,
          tl.taskdate, tl.add_file as attachment,
          ".$status." as status,
          ".$amount." as amount,
          ".$created_date." as created,
          ".$comp_date." as comp_date,
          ".$staff_name." as staff_name,
          ".$client_name." as client_name
      ";

      $query = " FROM todolistnewtasks as tl ";
      
      $query .= $where.$header_sort;
      $sql_limit = $select.$query." limit ".$start.", ".$limit; 
      //echo $sql_limit;die;
      $od = DB::select( DB::raw($sql_limit) );


      //============== total count section ==============
      $total_select   = "SELECT count(*) as count ".$query;   

      $total_qry      = $total_select;
      //echo $total_qry;die;
      $totalVal       = DB::select($total_qry);
      $total          = json_decode(json_encode($totalVal), true);

      $data['details']        = json_decode(json_encode($od), true);
      $data['TotalRecord']    = $total[0]['count'];
      return $data;
  }


  public static function getTimeLines()
  {
    $timelines = array('Due Today','Due in 7 Days','Due in 30 Days','Due in 3 Months','Due in 6 Months','Due After 6 Months','Over Due');
    foreach ($timelines as $k => $v) {
        $data[$k]['name']   = $v;
        $data[$k]['count']  = Todolistnewtask::getTimeLineCount($k+1);
    }
    return $data;
  }

  public static function getTimeLineCount($timeline)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];

    $where = " WHERE tl.is_deleted != 'Y' AND ";
    if($timeline == 1){
        $where .= " DATE(tl.taskdate) = CURDATE() AND ";
    }else if($timeline == 2){
        $where .= " DATE(tl.taskdate) > CURDATE() AND DATE(tl.taskdate) <= DATE(CURDATE()+7) AND ";
    }else if($timeline == 3){
        $where .= " DATE(tl.taskdate) > DATE(CURDATE()+7) AND DATE(tl.taskdate) <= DATE(DATE_ADD(tl.taskdate, INTERVAL 30 DAY)) AND ";
    }else if($timeline == 4){
        $where .= " DATE(tl.taskdate) > DATE(CURDATE()+30) AND DATE(tl.taskdate) <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND ";
    }else if($timeline == 5){
        $where .= " DATE(tl.taskdate) > DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND DATE(tl.taskdate) <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH) AND ";
    }else if($timeline == 6){
        $where .= " DATE(tl.taskdate) > DATE_ADD(CURDATE(), INTERVAL 6 MONTH) AND ";
    }else if($timeline == 7){
        $where .= " DATE(tl.taskdate) < CURDATE() AND ";
    }

    $where .= " `status`<>'close' AND (user_id=".$user_id." OR staff_id=".$user_id.") AND status != 'allocate_job' ";

    $query = "SELECT count(*) as count FROM todolistnewtasks as tl ".$where;

    //echo $query;die;
    $totalVal       = DB::select($query);
    $total          = json_decode(json_encode($totalVal), true);

    return $total[0]['count'];
  }

  public static function sendNotification($task_id)
  {
    $emails = $clients = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $group_id       = $session['group_id'];
    $email          = $session['email'];
    $groupUserId    = Client::getSessionUserIds();

    $details = Todolistnewtask::getDetailsById($task_id);

    array_push($emails, $email);
    $staff_id = 0;
    if(isset($details['staff_id']) && $details['staff_id'] >0){
      $staff_id = $details['staff_id'];
      $email2 = User::getEmailByUserId( $details['staff_id'] );
      array_push($emails, $email2);
    }

    $data['email']        = $emails;
    $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
    $data['details']      = $details;
    $data['STAFFNAME']    = User::getStaffNameById($staff_id);
    $data['USERNAME']     = User::getStaffNameById($user_id);
    //echo "<pre>";print_r($data['email']);die;

    Mail::send('emails.todo_list', $data, function ($message) use ($data) {
      $message->subject('New tasks notification - '.$data['details']['taskname']); 
      $message->from($data['senderEmail']);
      $message->to($data['email']);
    });
  }






}
