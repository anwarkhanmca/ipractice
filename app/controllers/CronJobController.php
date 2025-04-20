<?php
class CronJobController extends BaseController 
{
  public function jobs_email_client()
  {
    $service_id = 9;
    $details = JobsAutosendEmail::get();
    if(isset($details) && count($details) > 0){
      foreach ($details as $key => $value) {
        $service_id     = $value->service_id;
        $group_id       = Common::getGroupId($value->user_id);
        $groupUserId    = Common::getUserIdByGroupId($group_id);
        $client_details = StepsFieldsClient::whereIn("user_id", $groupUserId)->where('field_name', "next_ret_due")->get();
        //echo $this->last_query();die;
        $auto_send = JobsAutosendEmail::getJobsAutosendEmailByServiceId($service_id);
        if(isset($client_details) && count($client_details) >0){
          foreach ($client_details as $key => $client_value) {
            $client_id = $client_value->client_id;
            $crons = JobsCronjob::getJobsCronjobDetails($client_id, $service_id);

          }
        }
      }
    }
  }

    public function send_bookkeeping_to_task()
    {
      //mail('anwarkhanmca786@gmail.com', 'Book keeping', 'Test=>'.date('d-m-Y H:i:s'));
      $details = JobsAccDetail::where('repeat_day', '!=', '')->where('first_due_date', '!=', '0000-00-00')->get();
      if(isset($details) && count($details) > 0){
        foreach ($details as $key => $value) {
          $today      = date('Y-m-d');
          //$today      = '2016-01-07';
          $send_day   = $value->next_send_date;
          //$send_day   = '2016-01-05';
          $check      = $this->getDateDiffer($today, $send_day);
          //echo $send_day;die;
          if($check >= 0){
            $data["user_id"]    = $value->user_id;
            $data["client_id"]  = $value->client_id;
            $data["service_id"] = 4;
            $data["status"]     = 'Y';
            $data["created"]    = date('Y-m-d H:i:s');
            JobsManage::insert($data);

            $next_date['next_send_date'] = date('Y-m-d', strtotime('+'.$value->repeat_day.' days', strtotime($value->next_send_date)));

            JobsAccDetail::where('acc_id', $value->acc_id)->update($next_date); 
          }
            
        }
      }
    }

    public static function getDateDiffer($start_date, $end_date)
    {
      $diff   = strtotime($start_date) - strtotime($end_date);
      $days   = round($diff/86400);
      
      return $days;
    }

    public function send_vat_totask()
    {
      $today = date('M');
      $service_id = 1;
      //echo $today;die;

      $details = StepsFieldsClient::where('field_name', 'vat_stagger')->select('field_value as vat_stagger', 'client_id')->get()->toArray();
      //echo $this->last_query();die;
      
      $days = AutosendTask::getDaysByServiceId( $service_id, 'J' );
      if(isset($days) && $days != 0){
        foreach ($details as $key => $value) {
          $client_id      = $value['client_id'];
          $vat_stagger    = $value['vat_stagger'];
          $clients = ClientService::getClientIdByServiceId($service_id);
          if(in_array($client_id, $clients)){//echo $client_id."<br>";
            $this->autosend_vat($client_id, $vat_stagger);
          }
        }
      }
        
    }

    public function autosend_vat($client_id, $vat_stagger)
    {
      $service_id     = 1;
      $current        = date('M');
      //echo $today;die;
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $data["status"]         = "Y";
      $data["user_id"]        = $user_id;
      $data["service_id"]     = $service_id;

      $value = StepsFieldsClient::where('field_name', 'ret_frequency')->select('field_value as frequency')->where('client_id', $client_id)->first();
         //echo $value['frequency'];//die;
      if(isset($value['frequency']) && $value['frequency'] != ""){
        $frequency = $value['frequency'];

        if($frequency == 'monthly'){
          $past_data      = $this->getLastMonth();
          $last_month     = substr($past_data['month'], 0, 3);
          $last_year      = substr($past_data['year'], 2, 2);
          $return_date    = $last_month.'-'.$last_year;

          $data["client_id"]      = $client_id;
          $data["return_date"]    = $return_date;
          JobsManage::insert($data);
        }else if($frequency == 'yearly'){
          $last   = date('M', strtotime('-1 month', time()));
          $lower  = strtolower($last);
          if(isset($vat_stagger) && $vat_stagger == $lower){
            if($current == 'Jan'){
                $year = date('y', strtotime("-1 year", time()));
            }else{
                $year = date('y');
            }
            //echo $lower.", ".$vat_stagger;
            $return_date    = ucwords($lower).'-'.$year;

            $data["client_id"]      = $client_id;
            $data["return_date"]    = $return_date;
            JobsManage::insert($data);
          }
        }elseif($frequency == 'quarterly'){
          $last   = date('M', strtotime('-1 month', time()));
          $lower  = strtolower($last);
          
          if($current == 'Jan'){
            $year = date('y', strtotime("-1 year", time()));
          }else{
            $year = date('y');
          }
          if(isset($vat_stagger) && $vat_stagger != ''){
            $vat_stagger    = strtolower($vat_stagger);
            $stagger        = explode('-', $vat_stagger);
            $short_month    = ucwords($stagger[0]);
            $return_date    = ucwords($lower).'-'.$year;
            if($lower=='mar' || $lower=='jun' || $lower=='sep' || $lower=='dec'){
              if($vat_stagger == 'mar-jun-sept-dec'){
                $data["client_id"]      = $client_id;
                $data["return_date"]    = $return_date;
                JobsManage::insert($data);
              }
            }
            if($lower=='jan' || $lower=='apr' || $lower=='jul' || $lower=='oct'){
              if($vat_stagger == 'jan-april-jul-oct'){
                $data["client_id"]      = $client_id;
                $data["return_date"]    = $return_date;
                JobsManage::insert($data);
              }
            }
            if($lower=='feb' || $lower=='may' || $lower=='aug' || $lower=='nov'){
              if($vat_stagger == 'feb-may-aug-nov'){
                $return_date            = ucwords($lower).'-'.$year;
                $data["client_id"]      = $client_id;
                $data["return_date"]    = $return_date;
                JobsManage::insert($data);
              }
            }
          }
        }
      }
    }

    public function getLastMonth()
    {
      $data = array();
      $curr = date('M');//echo $curr;die;

      if($curr == 'Jan'){//die('last');
        $data['month']  = 'December';
        $data['year']   = date('Y', strtotime("-1 year", time()));
      }else if($curr == 'Feb'){
        $data['month']  = 'January';
        $data['year']   = date('Y');
      }else if($curr == 'Mar'){
        $data['month']  = 'February';
        $data['year']   = date('Y');
      }else if($curr == 'Apr'){
        $data['month']  = 'March';
        $data['year']   = date('Y');
      }else if($curr == 'May'){
        $data['month']  = 'April';
        $data['year']   = date('Y');
      }else if($curr == 'Jun'){
        $data['month']  = 'May';
        $data['year']   = date('Y');
      }else if($curr == 'Jul'){
        $data['month']  = 'June';
        $data['year']   = date('Y');
      }else if($curr == 'Aug'){
        $data['month']  = 'July';
        $data['year']   = date('Y');
      }else if($curr == 'Sep'){
        $data['month']  = 'August';
        $data['year']   = date('Y');
      }else if($curr == 'Oct'){
        $data['month']  = 'September';
        $data['year']   = date('Y');
      }else if($curr == 'Nov'){
        $data['month']  = 'October';
        $data['year']   = date('Y');
      }else if($curr == 'Dec'){
        $data['month']  = 'November';
        $data['year']   = date('Y');
      }
      return $data;
    }

    public function jobsend_auto($client_id, $vat_stagger)
    {
      $data           = array();
      $service_id     = 1;
      $return_date    = "";
      $details = StepsFieldsClient::where('field_name', 'ret_frequency')->select('field_value as frequency')->where('client_id', $client_id)->first();
      //print_r($details);die;
      if(isset($details['frequency']) && $details['frequency']  == 'monthly'){
        $frequency      = ucwords(strtolower($details['frequency']));
        $stagger        = explode('-', $vat_stagger);
        $short_month    = ucwords(strtolower($stagger[0]));
        $past_data      = $this->getMostRecentPastMonth($short_month, $frequency);

        $last_month     = substr($past_data['month'], 0, 3);
        $last_year      = substr($past_data['year'], 2, 2);
        $return_date    = $last_month.'-'.$last_year;
      }else if(isset($details['frequency']) && $details['frequency']  == 'yearly'){
        $frequency      = ucwords(strtolower($details['frequency']));
        $stagger        = explode('-', $vat_stagger);
        $short_month    = ucwords(strtolower($stagger[0]));
        $past_data      = $this->getMostRecentPastMonth($short_month, $frequency);
      }else if(isset($details['frequency']) && $details['frequency']  == 'quarterly'){
        $frequency      = $details['frequency'];
        $stagger        = explode('-', $vat_stagger);
        $short_month    = ucwords(strtolower($stagger[0]));
        $past_data      = $this->getMostRecentPastMonth($short_month, $frequency);

        $last_month     = substr($past_data['month'], 0, 3);
        $last_year      = substr($past_data['year'], 2, 2);
        $return_date    = $last_month.'-'.$last_year;
      }

      $data["status"]         = "Y";
      $data["user_id"]        = 0;
      $data["service_id"]     = $service_id;
      $data["client_id"]      = $client_id;
      $data["return_date"]    = $return_date;
      if($return_date != ""){
        JobsManage::insert($data);
      }
    }

    public function getMostRecentPastMonth($month, $frequency)
    {
      $data = array();
      $curr = date('M');

      if($frequency == 'quarterly'){
        $data['month']  = 'Dec';
        $data['year']   = date('y', strtotime("-1 year", time()));
      }else if($frequency == 'Monthly' || $frequency == 'Yearly'){//MOnthly
        if($curr == 'Jan'){
          $data['month']  = 'December';
          $data['year']   = date('Y', strtotime("-1 year", time()));
        }else if($curr == 'Feb'){
          $data['month']  = 'January';
          $data['year']   = date('Y');
        }else if($curr == 'Mar'){
          $data['month']  = 'February';
          $data['year']   = date('Y');
        }else if($curr == 'Apr'){
          $data['month']  = 'March';
          $data['year']   = date('Y');
        }else if($curr == 'May'){
          $data['month']  = 'April';
          $data['year']   = date('Y');
        }else if($curr == 'Jun'){
          $data['month']  = 'May';
          $data['year']   = date('Y');
        }else if($curr == 'Jul'){
          $data['month']  = 'June';
          $data['year']   = date('Y');
        }else if($curr == 'Aug'){
          $data['month']  = 'July';
          $data['year']   = date('Y');
        }else if($curr == 'Sep'){
          $data['month']  = 'August';
          $data['year']   = date('Y');
        }else if($curr == 'Oct'){
          $data['month']  = 'September';
          $data['year']   = date('Y');
        }else if($curr == 'Nov'){
          $data['month']  = 'October';
          $data['year']   = date('Y');
        }else if($curr == 'Dec'){
          $data['month']  = 'November';
          $data['year']   = date('Y');
        }
      }

      return $data;
    }


    /*public function auto_email_send()
    {
        mail("anwarkhanmca786@gmail.com","Cron Test custom checklist", 'custom checklist');
        //mail("abel02@icloud.com","Cron Test custom checklist", 'custom checklist');

        $send_data = array();
        $details  = OnboardingChecklist::where('status', '!=', 'D')->where('task_owner_email', '!=', '')->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $k => $row) {
                $task_date = date('Y-m-d', strtotime($row->task_date));
                if(isset($row->email_send_date) && $row->email_send_date != "0000-00-00"){
                    $checklist_id = $row->table_checklist_id;
                    $dtlsChk = ChecklistTable::getChecklistById( $checklist_id );
                    $remndDay = isset($dtlsChk['reminddays'])?$dtlsChk['reminddays']:'0';
                    $nxtDay =  date('Y-m-d', strtotime($remndDay." days", strtotime($row->email_send_date)));
                }else{
                    $nxtDay = date('Y-m-d', strtotime($row->task_date));
                }   

                if($nxtDay == date('Y-m-d')){
                    $send_data['email']     = $row->task_owner_email;
                    $link = base64_encode($row->onboarding_checklist_id);
                    $send_data['link']          = url()."/checklist/status-view/".$link;
                    $send_data['notes']         = $row->notes;
                    $send_data['attachment']    = $row->attachment;

                    $details = ChecklistTable::getChecklistById( $row->table_checklist_id );
                    if(isset($details['name'])  && $details['name'] != ""){
                        $send_data['subject']  = $details['name'];
                    }else{
                        $send_data['subject']  = '';
                    }

                    if(isset($details['checklist_id']) && $details['checklist_id'] != ""){
                        $custName = Checklist::getChecklistByCheckId( $details['checklist_id'] );
                        if(isset($custName['name'])  && $custName['name'] != ""){
                            $send_data['check_name']  = $custName['name'];
                        }else{
                            $send_data['check_name']  = '';
                        }
                    }

                    App::make('ChecklistController')->send_email($send_data);

                    $sndDate['email_send_date'] = date('Y-m-d');
                    OnboardingChecklist::where('onboarding_checklist_id', '=', $row->onboarding_checklist_id)->update($sndDate);
                }

            }
        }
    }*/

    public function auto_email_send()
    {
      //mail("anwarkhanmca786@gmail.com","Cron Test custom checklist", 'custom checklist');
      //mail("abel02@icloud.com","Cron Test custom checklist", 'custom checklist');

      $send_data = array();
      $dtls = OnboardingChecklist::where('status','!=','D')->where('task_owner_email','!=','')->get();
      if(isset($dtls) && count($dtls) >0){
        foreach ($dtls as $k => $row) {
          $nxtDay = date('Y-m-d', strtotime($row->task_date));
          if(isset($row->email_send_date) && $row->email_send_date != "0000-00-00"){
            $dtlsChk    = ChecklistTable::getChecklistById( $row->table_checklist_id );
            $remndDay   = isset($dtlsChk['reminddays'])?$dtlsChk['reminddays']:0;
            $nxtDay     = date('Y-m-d',strtotime($remndDay." days",strtotime($row->email_send_date)));
          } 


          $today = date('Y-m-d');
          $dayDiffer = Common::dayDifference($nxtDay, $today);
          //echo $dayDiffer."<br>";
          if($dayDiffer <= 0){//echo $row->table_checklist_id."<br>";
            $link = base64_encode($row->onboarding_checklist_id);

            $send_data['email']         = $row->task_owner_email;
            $send_data['link']          = url()."/checklist/status-view/".$link;
            $send_data['notes']         = $row->notes;
            $send_data['attachment']    = url()."/uploads/checklist_files/".$row->attachment;

            $details1 = ChecklistTable::getChecklistById( $row->table_checklist_id );
            if(isset($details1['name'])  && $details1['name'] != ""){
                $send_data['subject']  = $details1['name'];
            }else{
                $send_data['subject']  = '';
            }

            $custName = Checklist::getChecklistByCheckId( $row->checklist_id );
            if(isset($custName['name'])  && $custName['name'] != ""){
                $send_data['check_name']  = $custName['name'];
            }else{
                $send_data['check_name']  = '';
            }                  

            App::make('ChecklistController')->send_email($send_data);

            $sndDate['email_send_date'] = date('Y-m-d');
            OnboardingChecklist::where('onboarding_checklist_id',$row->onboarding_checklist_id)->update($sndDate);
          }
            //die;
        }
      }
    }


    public function cron_test()
    { //echo die('test');
      $msg = "This is cron job test email";
      mail("anwarkhanmca786@gmail.com","Cron Test",$msg);
      //mail("abel02@icloud.com","Cron Test",$msg);
    }


    public function task_reminder_message()
    {
      //$this->cron_test();

      $details = DB::table('jobs_manages as jm')
        ->leftJoin('task_notifications as tn', function ($join) {
          $join->on('jm.service_id', '=', 'tn.service_id')
                ->On('jm.client_id', '=','tn.client_id');
        })
        ->leftJoin('notification_frequencies as nf', function ($join) {
          $join->on('nf.service_id', '=', 'tn.service_id')
                ->On('nf.client_id', '=','tn.client_id');
        })
        ->where("tn.is_enable", 1)
        ->where('nf.first_send_date', '!=', date('Y-m-d'))
        ->where('nf.next_send_date', '=', date('Y-m-d'))
        ->select('jm.job_manage_id', 'jm.service_id', 'nf.*')
        ->get();
      //Common::last_query();die;

      if(isset($details) && count($details) >0 ){
        foreach ($details as $k => $v) {
          $client_id  = $v->client_id;
          $service_id = $v->service_id;
          $manage_id  = $v->job_manage_id;

          $status_id = JobStatus::getStatusIdByJobManageId($manage_id);
          if(isset($v->stop_reminder) && $v->stop_reminder > $status_id){
            $next_send_date = date("Y-m-d",strtotime("+ ".$v->repeat_day." days"));
            $nfData['first_send_date']  = date('Y-m-d');
            $nfData['next_send_date']   = $next_send_date;
            NotificationFrequency::where("client_id", $client_id)->where("service_id", $service_id)->update($nfData);

            /* ========= Email Start ========== */
            $data['email'] = NotificationFrequency::getRecipientEmail($service_id, $client_id);
            //echo "<pre>";print_r($data['email']);die;
            if(!empty($data['email'])){
              $group_id = User::getGroupIdByUserId($v->user_id);
              $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
              $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
              
              $data['subject']  = $v->subject;
              $data['content']  = $v->message;
              //echo "<pre>";print_r($data);die;
              Mail::send('emails.task_send', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->from($data['senderEmail'], $data['PRACTICENAME']);
                $message->to($data['email']);
              });

              /* ======== E-Reminders column in tasks tab ======== */
              JobsManage::increaseERemindersValue($manage_id);
            }  
            /* ========= Email End ========== */ 
          }
        }
      }
    }

    public function cron_chaser_email()
    {
      $details = DB::table('jobs_chaser_emails as jce')
        ->whereDate("jce.stop_date", '>=', date('Y-m-d'))
        ->where('jce.first_send_date', '!=', date('Y-m-d'))
        ->where('jce.next_send_date', '=', date('Y-m-d'))
        ->get();
      //Common::last_query();die;
      if(isset($details) && count($details) >0 ){
        foreach ($details as $k => $v) {
          $client_id  = $v->client_id;
          $service_id = $v->service_id;
          $manage_id  = $v->job_manage_id;
          $user_id    = $v->user_id;

          JobsChaserEmail::sendEmail($v->id, $user_id, '');

          $next_send_date = date("Y-m-d",strtotime("+ ".$v->repeat_day." days"));
          $nfData['first_send_date']  = date('Y-m-d');
          $nfData['next_send_date']   = $next_send_date;
          JobsChaserEmail::where("id", $v->id)->update($nfData);
        }
      }
    }

    public function cron_send_vat_totask()
    {
      $today = date('M');
      $service_id = 1;

      //echo $today;die;
      $details = AutosendTask::getCronDetailsByServiceId( $service_id, 'J' );
      if(isset($details) && count($details) >0){
        foreach ($details as $k => $v) {
          $group_id     = $v['group_id'];
          $groupUserId  = User::getUserIdByGroupId($group_id);

          $ret_frequency = StepsFieldsClient::clientFieldQuery('ret_frequency');

          $sql = "SELECT cs.client_id, sfc.field_value as vat_stagger, 
            ".$ret_frequency." as ret_frequency
            FROM client_services cs 
            JOIN clients c ON cs.client_id=c.client_id 
            JOIN steps_fields_clients sfc on sfc.client_id = c.client_id
            WHERE c.user_id IN ('".implode(',', $groupUserId)."') 
            AND cs.service_id='".$service_id."' 
            AND sfc.field_name = 'vat_stagger'
            AND sfc.field_value != 'Choose One'
          ";
          //echo $sql;die;
          $od = DB::select($sql);
          $clients = json_decode(json_encode($od), true);
          if(isset($clients) && count($clients) >0){
            foreach ($clients as $ck => $cv) {
              $client_id      = $cv['client_id'];
              $vat_stagger    = $cv['vat_stagger'];
              $ret_frequency  = $cv['ret_frequency'];
              $retData = $this->autoSendToTask($client_id,$service_id,$vat_stagger,$ret_frequency);
            }
          }

        }
      }
      die('End');
    }

    public function autoSendToTask($client_id,$service_id,$vat_stagger,$frequency)
    {
      $current  = date('M');
      $last_id  = 0;
      $data["status"]         = "Y";
      $data["user_id"]        = Client::getUserIdByClientId($client_id);
      $data["service_id"]     = $service_id;

      if(isset($frequency) && $frequency != ""){
        if($frequency == 'monthly'){
          $past_data      = $this->getLastMonth();
          $last_month     = substr($past_data['month'], 0, 3);
          $last_year      = substr($past_data['year'], 2, 2);
          $return_date    = $last_month.'-'.$last_year;

          $data["client_id"]      = $client_id;
          $data["return_date"]    = $return_date;
          $last_id = JobsManage::insertGetId($data);
        }else if($frequency == 'yearly'){
          $last   = date('M', strtotime('-1 month', time()));
          $lower  = strtolower($last);
          if(isset($vat_stagger) && $vat_stagger == $lower){
            if($current == 'Jan'){
                $year = date('y', strtotime("-1 year", time()));
            }else{
                $year = date('y');
            }
            //echo $lower.", ".$vat_stagger;
            $return_date    = ucwords($lower).'-'.$year;

            $data["client_id"]      = $client_id;
            $data["return_date"]    = $return_date;
            $last_id = JobsManage::insertGetId($data);
          }
        }elseif($frequency == 'quarterly'){
          //$last   = date('M', strtotime('-1 month', time()));
          $last   = date('M');
          $lower  = strtolower($last);
          
          if($current == 'Jan'){
            $year = date('y', strtotime("-1 year", time()));
          }else{
            $year = date('y');
          }
          if(isset($vat_stagger) && $vat_stagger != ''){
            $vat_stagger    = strtolower($vat_stagger);
            $stagger        = explode('-', $vat_stagger);
            $short_month    = ucwords($stagger[0]);

            $month          = date('M', strtotime('-1 month', time()));
            $return_date    = ucwords($month).'-'.$year;
            //echo $lower;
            if($lower=='mar' || $lower=='jun' || $lower=='sep' || $lower=='dec'){
              if($vat_stagger == 'feb-may-aug-nov'){//mar-jun-sept-dec
                $data["client_id"]      = $client_id;
                $data["return_date"]    = $return_date;
                $last_id = JobsManage::insertGetId($data);
              }
            }
            if($lower=='jan' || $lower=='apr' || $lower=='jul' || $lower=='oct'){
              if($vat_stagger == 'mar-jun-sept-dec'){//jan-april-jul-oct
                $data["client_id"]      = $client_id;
                $data["return_date"]    = $return_date;
                $last_id = JobsManage::insertGetId($data);
              }
            }
            if($lower=='feb' || $lower=='may' || $lower=='aug' || $lower=='nov'){
              if($vat_stagger == 'jan-april-jul-oct'){//feb-may-aug-nov
                $data["client_id"]      = $client_id;
                $data["return_date"]    = $return_date;
                $last_id = JobsManage::insertGetId($data);
              }
            }
          }
        }
      }

      if($last_id > 0){
        $this->sendEmail($service_id, $client_id, $last_id);
      }

    }

    public function sendEmail($service_id, $client_id, $last_id)
    {
      $user_id  = Client::getUserIdByClientId($client_id);
      $group_id = User::getGroupIdByUserId($user_id);
      $email    = User::getEmailByUserId($user_id);
      //echo $email;
      //Common::last_query();

      /* ========= Email Start ========== */
      $emails = NotificationFrequency::getRecipientEmail($service_id, $client_id);
      //echo "<pre>";print_r($emails);die;
      if(!empty($emails)){
        array_push($emails, $email);
        $data['email']        = $emails;
        $data['senderEmail']  = Config::get('constant.ADMINEMAIL');
        $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
        
        $dtls = NotificationFrequency::getDetailsByServiceAndClientId($service_id,$client_id,1);
        $data['subject']  = $dtls['subject'];
        $data['content']  = $dtls['message'];
        //echo "<pre>";print_r($data['email']);die;
        Mail::send('emails.task_send', $data, function ($message) use ($data) {
          $message->subject($data['subject']);
          $message->from($data['senderEmail'], $data['PRACTICENAME']);
          $message->to($data['email']);
        });

        /* ======== E-Reminders column in tasks tab ======== */
        JobsManage::increaseERemindersValue($last_id);
      }  
      /* ========= Email End ========== */ 
    }


}
