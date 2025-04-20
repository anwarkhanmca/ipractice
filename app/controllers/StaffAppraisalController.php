<?php
class StaffAppraisalController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)) {
            Redirect::to('/login')->send();
        }
        if (isset($session['user_type']) && $session['user_type'] == "C") {
            Redirect::to('/client-portal')->send();
        }
    }

    public function index($tab_no, $page_open)
    {
        $step_data  = array();
        $appriasals = array();

        $data['page_open']      = base64_decode($page_open);
        $data['encoded_page_open'] = $page_open;
        $data['title']          = 'Staff Appraisal';
        if($data['page_open'] == 'staff'){
            $data['previous_page']  ='<a href="/staff-management">Staff Management</a>';
        }else{
            $data['previous_page']  ='<a href="/staff-profile">Staff Profile</a>';
        }
        
        $data['heading']        = "Staff Appraisal";
        $admin_s                = Session::get('admin_details');
        $user_id                = $admin_s['id'];
        $groupUserId            = $admin_s['group_users'];
        $data['tab_no']         = base64_decode($tab_no);
        $data['encoded_no']     = $tab_no;
        $data['user_id']        = $user_id;
        $data['previous_roll']  = StaffAppraisal::getDetailsByStaffId($user_id);

        

        if($data['tab_no'] == 1){
            $data['username']           = User::getStaffDetailsById($user_id);
            $data['staff_details']      = User::getAllStaffDetails();
            $data['CompetencyLevel']    = CompetencyLevel::getAllDetails();
            $data['position_name']      = Position::getPositionByUserId($user_id);

            $data['staff_tasks'] = Stafftask::getAllDetails();
        /*$data['new_services'] = Stafftask::where('staff_id', '=', $staff_id)->where("status","=", "new")->where("for_task", "=", "per")->orderBy("name")->get();
        $data['comold_services'] = Stafftask::where('staff_id', '=', $staff_id)->where("status","=", "old")->where("for_task", "=", "com")->orderBy("name")->get();
        $data['comnew_services'] = Stafftask::where('staff_id', '=', $staff_id)->where("status","=", "new")->where("for_task", "=", "com")->orderBy("name")->get();*/
            //$data['previous_roll']      = StaffAppraisal::getAllDetails();
        }else{
            $prev_app    = StaffAppraisal::getAllDetails();
            if(isset($prev_app) && count($prev_app) >0){
                foreach ($prev_app as $key => $value) {
                    $staffs = User::getStaffDetailsById($value['staff_id']);
                    if(isset($staffs['step_data']) && count($staffs['step_data']) >0){
                        $prev_app[$key]['start_date'] = isset($staffs['step_data']['start_date'])?$staffs['step_data']['start_date']:'';
                        if(isset($staffs['step_data']['department'])){
                            $prev_app[$key]['department'] = Department:: getDepartmentById($staffs['step_data']['department']);
                        }
                        if(isset($staffs['step_data']['position_type'])){
                            $prev_app[$key]['job_title'] = Position:: getNameByPositionId($staffs['step_data']['position_type']);
                        }
                    }
                }
            }
            $data['prev_appriasals'] = $prev_app;
        }
        
        
        //$test = StaffAppraisalSign::getDetailsByAppraisalId(16);
        //echo "<prev>".print_r($test);die;
        return View::make('staff.staff_appraisal.index', $data);
    }

    public function getjobforappraisee()
    {
        $step_data = array();
        $admin_s   = Session::get('admin_details');
        $user_id   = $admin_s['id'];

        $staff_id = Input::get("satffid");
        $data['old_services'] = Stafftask::where('staff_id', '=', $staff_id)->where("status","=", "old")->where("for_task", "=", "per")->orderBy("name")->get();
        $data['new_services'] = Stafftask::where('staff_id', '=', $staff_id)->where("status","=", "new")->where("for_task", "=", "per")->orderBy("name")->get();
        $data['comold_services'] = Stafftask::where('staff_id', '=', $staff_id)->where("status","=", "old")->where("for_task", "=", "com")->orderBy("name")->get();
        $data['comnew_services'] = Stafftask::where('staff_id', '=', $staff_id)->where("status","=", "new")->where("for_task", "=", "com")->orderBy("name")->get();

        $data['staff_tasks']        = Stafftask::getAllDetails();
        $data['CompetencyLevel']    = CompetencyLevel::getAllDetails();

        $data['appraisee']       = User::getStaffNameById($staff_id);
        $data['appraisee_title'] = User::getJobTitleByUserId($staff_id);
        $data['appraiser']       = User::getStaffNameById($user_id);
        $data['appraiser_title'] = User::getJobTitleByUserId($user_id);
        $data['dateofmeeting']   = date('d-m-Y');
        $data['timeofmeeting']   = date('H : i');
        
        echo View::make('staff.staff_appraisal.taskper', $data);
    }

    public function get_previous_roll()
    {
        $admin_s   = Session::get('admin_details');
        $user_id   = $admin_s['id'];
        $staff_id  = Input::get("staff_id");

        $appraiser_id1  = Input::get("appraiser1");
        $appraiser_id2  = Input::get("appraiser2");

        $data['previous_roll']      = StaffAppraisal::getDetailsByStaffId($staff_id);
        $data['appraisee']          = User::getStaffNameById($staff_id);
        $data['appraisee_title']    = User::getJobTitleByUserId($staff_id);
        //$data['appraiser1']         = User::getStaffNameById($appraiser_id1);
        $data['appraiser_title1']   = User::getJobTitleByUserId($appraiser_id1);
        //$data['appraiser2']         = User::getStaffNameById($appraiser_id2);
        $data['appraiser_title2']   = User::getJobTitleByUserId($appraiser_id2);
        $data['logged_appr_name']   = User::getStaffNameById($user_id);
        $data['dateofmeeting']      = date('d-m-Y');
        $data['timeofmeeting']      = date('H : i');


        echo json_encode($data);
    }

    public function addnewtergetobject()
    {

        $admin_s    = Session::get('admin_details');
        $user_id    = $admin_s['id'];

        $newterget  = Input::get("newtergetobject_name");
        $tabname    = Input::get("tab_name");
        $staffid    = Input::get("staffdropdown");

        $data['name']       = $newterget;
        $data['user_id']    = $user_id;
        $data['staff_id']   = $staffid;
        $data['for_task']   = $tabname;
        $data['status']     = "new";

        $insert_id          = Stafftask::insertGetId($data);
        echo $insert_id;
        exit();
    }


    public function deladdnewtergetobject()
    {
        $admin_s    = Session::get('admin_details');
        $user_id    = $admin_s['id'];
        $del_id     = Input::get("field_id");
        $stafftasks_id = Stafftask::where("stafftasks_id", "=", $del_id)->delete();
        echo $stafftasks_id;
    }

    public function save_appraisal()
    {
        $sd_data = array();
        $ot_data = array();

        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $groupUserId    = $admin_s['group_users'];
        $tab_no     = Input::get("encoded_tab");
        $page_open  = Input::get("encoded_page_open");
        $action     = Input::get("action");
        $sign_id    = Input::get("staff_sign_id");

        $data['user_id']            = $user_id;
        $data['staff_id']           = Input::get("str_staff");
        $data['appraiser1']         = Input::get("appraiser1");
        $data['appraiser2']         = Input::get("appraiser2");

        $data['meeting_date']       = date('Y-m-d', strtotime(Input::get("dateofmeeting")));
        $data['meeting_time']       = str_replace(' ', '', Input::get("timeofmeeting"));
        $data['appraisee_comment']  = Input::get("appraisee_comment");
        $data['appraiser_comment']  = Input::get("appraiser_comment");
        $data['last_perform_id']    = Input::get("last_perform_id");
        if($action == 'edit'){
            $last_id     = Input::get("appraisal_id");
            StaffAppraisal::where('appraisal_id', '=', $last_id)->update($data);
            //StaffAppraisalSign::where('staff_appraisal_id', '=', $last_id)->delete();
        }else{
            $data['date_time']          = date('Y-m-d H:i:s');
            $data['created']            = date('Y-m-d H:i:s');
            $last_id = StaffAppraisal::insertGetId($data);    
        }

        if($sign_id != '0'){
            $sgnData['staff_appraisal_id'] = $last_id;
            StaffAppraisalSign::whereIn('user_id',$groupUserId)->where('sign_id', '=', $sign_id)->update($sgnData);
        }
        

        /* ============== ObjectiveTarget Start ============= */
        $newtarget          = Input::get("newtarget");
        $completion_date    = Input::get("completion_date");
        $perform_notes      = Input::get("perform_notes");
        $measured_notes     = Input::get("measured_notes");

        if(isset($newtarget) && count($newtarget) >0){
            foreach ($newtarget as $key => $value) {
                if(isset($value) && $value != "")
                {
                   $ot_data[$key]['user_id']          = $user_id;
                   $ot_data[$key]['appraisal_id']     = $last_id;
                   $ot_data[$key]['staff_task_id']    = $value;
                   $ot_data[$key]['perform_notes']    = $perform_notes[$key];
                   $ot_data[$key]['measured_notes']   = $measured_notes[$key];
                   $ot_data[$key]['completion_date']  = isset($completion_date[$key])?date('Y-m-d', strtotime($completion_date[$key])):'';
                   $ot_data[$key]['created']          = date('Y-m-d H:i:s');
                }
            }
            if(!empty($ot_data)){
                ObjectiveTarget::insert($ot_data);
            }
        }
        /* ============== ObjectiveTarget End ============= */

        /* ============== SkillDevelopment Start ============= */
        $competency_skill   = Input::get("competency_skill");
        $competency_level   = Input::get("competency_level");
        $prev_competency    = Input::get("prev_competency");
        $cur_competency     = Input::get("cur_competency");
        $supporting_notes   = Input::get("supporting_notes");
//print_r($supporting_notes);
        if(isset($competency_skill) && count($competency_skill) >0){
            $i = 0;
            foreach ($competency_skill as $key => $value) {
                if(isset($supporting_notes[$key]) && $supporting_notes[$key] != "")
                {
                   $sd_data[$i]['user_id']          = $user_id;
                   $sd_data[$i]['appraisal_id']     = $last_id;
                   $sd_data[$i]['staff_task_id']    = $value;
                   $sd_data[$i]['required_level']   = $competency_level[$key];
                   $sd_data[$i]['previous_level']   = $prev_competency[$key];
                   $sd_data[$i]['current_level']    = $cur_competency[$key];
                   $sd_data[$i]['supporting_notes'] = $supporting_notes[$key];
                   $sd_data[$i]['created']          = date('Y-m-d H:i:s');

                   $i++;
                }
            }
            //echo "<pre>";print_r($sd_data);die;
            if(!empty($sd_data)){
                SkillDevelopment::insert($sd_data);
            }
        }
        /* ============== SkillDevelopment End ============= */

        return Redirect::to('/staff-appraisal/'.$tab_no.'/'.$page_open);
    }

    public function delete_appraisal()
    {
        $appraisal_id   = Input::get("appraisal_id");
        $action         = Input::get("action");

        if($action == 'D'){
            StaffAppraisal::where("appraisal_id", "=", $appraisal_id)->delete();
            ObjectiveTarget::where("appraisal_id", "=", $appraisal_id)->delete();
            SkillDevelopment::where("appraisal_id", "=", $appraisal_id)->delete();
        }else{
            $up_data['is_archive'] = $action;
            StaffAppraisal::where("appraisal_id", "=", $appraisal_id)->update($up_data);
        }
        

        $data['text'] = 1;
        echo json_encode($data);
    }

    public function ajax_appraisal_details()
    {
        $data = array();
        $admin_s    = Session::get('admin_details');
        $user_id    = $admin_s['id'];

        $appraisal_id    = Input::get("appraisal_id");
        $staff_id        = Input::get("staff_id");
        $action          = Input::get("action");

        $data['details']    = StaffAppraisal::getDetailsByAppraisalId($appraisal_id);
        //$data['objectives'] = ObjectiveTarget::getDetailsByAppraisalId($appraisal_id);
        $data['objectives'] = $this->allObjectivesByAppraisalId($appraisal_id);

        //$data['skills']     = SkillDevelopment::getDetailsByAppraisalId($appraisal_id);
        $data['skills']     = $this->getSkillByAppraisalId($appraisal_id);

        $data['staffSign']  = StaffAppraisalSign::getDetailsByAppraisalId($appraisal_id, 'S');
        $data['profileSign'] = StaffAppraisalSign::getDetailsByAppraisalId($appraisal_id, 'P');
        $data['staff_tasks'] = Stafftask::getAllDetails();
        $data['CompetencyLevel'] = CompetencyLevel::getAllDetails();


        if($action == 'E'){
            //$data['details']    = StaffAppraisal::getDetailsByAppraisalId($appraisal_id);
            //$data['objectives'] = ObjectiveTarget::getDetailsByAppraisalId($appraisal_id);
            //$data['skills']     = SkillDevelopment::getDetailsByAppraisalId($appraisal_id);
            
            

            $data['details']['appraisee']       = User::getStaffNameById($staff_id);
            $data['details']['appraisee_title'] = User::getJobTitleByUserId($staff_id);
            /*$data['details']['appraiser']       = User::getStaffNameById($user_id);
            $data['details']['appraiser_title'] = User::getJobTitleByUserId($user_id);*/
            $data['details']['dateofmeeting']   = date('d-m-Y');
            $data['details']['timeofmeeting']   = date('H : i');

            //print_r( $data['staff_tasks'] );die;
        }else{//echo "Anwar";die;
            //$data['p_details']    = StaffAppraisal::getDetailsByAppraisalId($appraisal_id);
            //print_r($data['p_details']);die;
            $data['p_objectives'] = ObjectiveTarget::getDetailsByAppraisalId($appraisal_id);
            $data['p_skills']     = SkillDevelopment::getDetailsByAppraisalId($appraisal_id);
            if(isset($data['p_details']['last_perform_id']) && $data['p_details']['last_perform_id'] != '0'){
              $appraisal_id = $data['p_details']['last_perform_id'];
              $staff_id     = $data['p_details']['staff_id'];

              $data['details']    = StaffAppraisal::getDetailsByAppraisalId($appraisal_id);
              $data['objectives'] = $this->allObjectivesByAppraisalId($appraisal_id);
              
              //$data['skills']     = SkillDevelopment::getDetailsByAppraisalId($appraisal_id);
              $data['skills']     = $this->getSkillByAppraisalId($appraisal_id);
                
              $data['details']['appraisee']       = User::getStaffNameById($staff_id);
              $data['details']['appraisee_title'] = User::getJobTitleByUserId($staff_id);

              /*$data['details']['appraiser']       = User::getStaffNameById($user_id);
              $data['details']['appraiser_title'] = User::getJobTitleByUserId($user_id);
              $data['details']['appraiser_title1'] = User::getJobTitleByUserId( $data['details']['appraiser1'] );
              $data['details']['appraiser_title2'] = User::getJobTitleByUserId( $data['details']['appraiser2'] );*/

              $data['details']['dateofmeeting']   = $data['details']['meeting_date'];
              $data['details']['timeofmeeting']   = $data['details']['meeting_time'];
            }
        }

        $data['details']['appraiser_title1'] = User::getJobTitleByUserId( $data['details']['appraiser1'] );
        $data['details']['appraiser_title2'] = User::getJobTitleByUserId( $data['details']['appraiser2'] );
        
        
        //print_r( $data['objectives'] );die;
        echo json_encode($data);
    }

    public function allObjectivesByAppraisalId($appraisal_id){
        $data           = array();
        $objectives1    = array();
        $objectives2    = array();

        $objectives1    = ObjectiveTarget::getDetailsByAppraisalId($appraisal_id);
        $last_perform_id    = StaffAppraisal::getLastPerformId($appraisal_id);
        if($last_perform_id != '0'){
            $objectives2    = ObjectiveTarget::getDetailsByAppraisalId($last_perform_id);
        }

        $data = array_merge($objectives1, $objectives2);
        return $data;
    }

    public function getSkillByAppraisalId($appraisal_id){
        $data           = array();
        $objectives1    = array();
        $objectives2    = array();

        $objectives1    = SkillDevelopment::getDetailsByAppraisalId($appraisal_id);
        //echo $last_perform_id;die;
        $last_perform_id    = StaffAppraisal::getLastPerformId($appraisal_id);
        if($last_perform_id != '0'){
            $objectives2    = SkillDevelopment::getDetailsByAppraisalId($last_perform_id);
        }

        $data = array_merge($objectives1, $objectives2);
        return $data;
    }

    public function get_appraisal_notes()
    {
        $data = array();
        $field_name     = Input::get("field_name");
        $table_id       = Input::get("table_id");
        $type           = Input::get("type");

        if($type == 'O'){
            $data = ObjectiveTarget::getDetailsByTargetId($table_id);
        }else{
            $data = SkillDevelopment::getDetailsBySkillId($table_id);
        }

        echo json_encode($data);
    }

    public function save_appraisal_notes()
    {
        $data = array();
        $field_name     = Input::get("field_name");
        $table_id       = Input::get("table_id");
        $type           = Input::get("type");
        $text           = Input::get("text");

        $data[$field_name] = $text;
        if($type == 'O'){
            $data = ObjectiveTarget::where('target_id', '=', $table_id)->update($data);
        }else{
            $data = SkillDevelopment::where('skill_dev_id', '=', $table_id)->update($data);
        }

        echo json_encode($data);
    }

    public function ajax_delete_objective()
    {
        $action         = Input::get("action");

        if($action == 'OT'){
            $target_id   = Input::get("target_id");
            ObjectiveTarget::where("target_id", "=", $target_id)->delete();
        }else{
            $skill_id   = Input::get("skill_id");
            SkillDevelopment::where("skill_dev_id", "=", $skill_id)->delete();
        }
        
        $data['text'] = 'delete';
        echo json_encode($data);
    }

    function save_appraisal_sign()
    {
        $data       = array();
        $admin_s    = Session::get('admin_details');
        $user_id    = $admin_s['id'];

        $page_type      = Input::get('page_type');
        $appraisal_id   = Input::get('pop_appraisal_id');

        $data['staff_appraisal_id'] = $appraisal_id;
        $data['user_id']            = $user_id;
        $data['page_type']          = ($page_type == 'staff')?'S':'P';
        $data['created']            = date('Y-m-d H:i:s');

        $data['last_id']    = StaffAppraisalSign::insertGetId($data);
        $data['date']       = date('d-m-Y');
        $data['time']       = date('H:i');
        $data['staff_name'] = User::getStaffNameById($user_id);

        echo json_encode($data);
    }

}
