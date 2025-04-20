<?php
//opcache_reset ();
//Cache::forget('user_list');
//use DB;
class TimesheetController extends BaseController
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

    public function time_sheet_reports($page_open, $type)
    {
        //die('staffmanagement');
        $data['heading'] = "TIMESHEET & EXPENSES";
        $data['title'] = "Time Sheet & Expenses Reports";
        if (base64_decode($type) == 'profile') {
            $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        } else {
            $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }
        $data['staff_type']     = base64_decode($type);
        $data['page_open']      = $page_open;
        $data['encode_type']    = $type;
        $data['goto_url']       = "/time-sheet-reports";

        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type'] = $session['user_type'];
        $groupUserId = $session['group_users'];

        $data['staff_details'] = User::getAllStaffName();
       
        $data['old_services'] 	= Service::where("status", "=", "old")->orderBy("service_name")->get();
		$data['new_services'] 	= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->where("added_from", "=", "timesheetreport")->orderBy("service_name")->get();
            
            
        $data['allClients'] = App::make("HomeController")->get_all_clients();

        if($page_open == 1){
            $report = TimeSheetReport::getDetailsByEntryType('T', 90);
        }else if($page_open == 2){
            $report = TimeSheetReport::getDetailsByEntryType('T', 0);
        }else if($page_open == 3){
            $report = TimeSheetReport::getDetailsByEntryType('E', 90);
        }else{
            $report = TimeSheetReport::getDetailsByEntryType('E', 0);
        }
        $data['report_details'] = $report;

        $data['expense_types'] = ExpenseType::getExpenseTypeByStatus('new');

        //echo '<pre>';print_r($data['report_details']);die();

        return View::make('staff.timesheet.time_sheet_reports', $data);

    }
    public function edit_time_sheet()
    {

        $data['heading'] = "TIME SHEET";
        $data['title'] = "Time Sheet Reports";
        /*if(base64_decode($type) == 'profile'){
        $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        }else{
        $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }*/
        $data['heading'] = "";
        $session_data = Session::get('admin_details');
        $data['user_type'] = $session_data['user_type'];
        $groupUserId = $session_data['group_users'];
        $data1 = array();
        //echo '<pre>';

        //print_r($session_data);

        $data1['staff_id'] = Input::get("staff_id");
        $data1['rel_client_id'] = Input::get("rel_client_id");
        $data1['vat_scheme_type'] = Input::get("vat_scheme_type");
        $data1['hrs'] = Input::get("hrs");
        $data1['notes'] = Input::get("notes");
        $data1['user_id'] = $session_data['id'];
        $data1['created_date'] = date('Y-m-d', strtotime(Input::get("date")));
        $editid = Input::get("editid");
        //echo '<pre>';
        //print_r($data1);
        //exit();
        $affected = TimeSheetReport::where("timesheet_id", "=", $editid)->update($data1);

        //echo $this->last_query();

        return Redirect::to('/time-sheet-reports/c3RhZmY=');
    }
    public function insert_time_sheet()
    {
        //$useDate = Input::all();print_r($useDate);die;
        $data['heading']    = "TIME SHEET";
        $data['title']      = "Time Sheet Reports";

        $session_data       = Session::get('admin_details');
        $data['user_type']  = $session_data['user_type'];
        $groupUserId        = $session_data['group_users'];
        $data1 = array();

        $entry_type         = Input::get("entry_type");
        $page_type_pop      = Input::get("page_type_pop");
        $edit_id            = Input::get("edit_id");

        $data1['staff_id']          = Input::get("staff_id");
        $data1['rel_client_id']     = Input::get("rel_client_id");
        if($entry_type == 'T'){
            $data1['vat_scheme_type']   = Input::get("vat_scheme_type");
        }else{
            $data1['vat_scheme_type']   = Input::get("expense_type");
        }
        $data1['hrs']               = Input::get("hrs");
        $data1['notes']             = Input::get("notes");
        $data1['user_id']           = $session_data['id'];
        $data1['created_date']      = Input::get("date");

        for ($i = 0; $i < count($data1['created_date']); $i++) {
            $insrtData['staff_id']           = $data1['staff_id'][$i];
            $insrtData['rel_client_id']      = $data1['rel_client_id'][$i];
            $insrtData['vat_scheme_type']    = $data1['vat_scheme_type'][$i];
            $insrtData['hrs']                = $data1['hrs'][$i];
            $insrtData['notes']              = $data1['notes'][$i];
            $insrtData['user_id']            = $session_data['id'];
            $insrtData['created_date']       = date("Y-m-d", strtotime($data1['created_date'][$i]));
            $insrtData['entry_type']         = $entry_type;
            $insrtData['service_id']         = Input::get("tasks_service_id");
            $insrtData['tasks_client_id']    = Input::get("tasks_client_id");
            $insrtData['completed_task_id']  = Input::get("completed_id");

            /* =============== File Upload ================= */
            $j = $i+1;
            if (Input::hasFile('attachment'.$j)) {
                $file           = Input::file('attachment'.$j);
                $destination    = "uploads/expense_files";
                $fileName       = Input::file('attachment'.$j)->getClientOriginalName();
                $fileName       = time().'-'.$fileName;

                Input::file('attachment'.$j)->move($destination, $fileName);

                $insrtData['attachment'] = $fileName;
            }

            if($edit_id == '0' || $edit_id == ''){
                $insrtData['created'] = date("Y-m-d H:i:s");
                TimeSheetReport::insertGetId($insrtData);
            }else{
                TimeSheetReport::where('timesheet_id', '=', $edit_id)->update($insrtData);
            }
            
        }

        if($page_type_pop == 'tasks'){
            echo 1;
        }else{
            if($entry_type == 'T'){
                return Redirect::to('/time-sheet-reports/1/'.base64_encode($page_type_pop));
            }else{
                return Redirect::to('/time-sheet-reports/3/'.base64_encode($page_type_pop));
            }
        }
    }

    public function timesheet_templates()
    {
        
       $timesheet_id = Input::get("timesheet_id"); 
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];


        if (Request::ajax()) {

            $timesheetTemplates = TimeSheetReport::where("timesheet_id", $timesheet_id)->first();
            $timesheetTemplates['group'] = $groupUserId;
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($timesheetTemplates);
            //echo 'aaaaa';
            exit();

        }


    }


    public function insertclient_time_sheet()
    {
        $ctr_data = array();
        $data_ctr = array();
        $data = array();
        $ctr_data['ctr_client'] = Input::get("ctr_client");
        $ctr_data['ctr_serv']   = Input::get("ctr_serv");
        $ctr_data['fromdate']   = date('Y-m-d', strtotime(Input::get("fromdpick2")));
        $ctr_data['todate']     = date('Y-m-d', strtotime(Input::get("todpick")));

        $form   = $ctr_data['fromdate'];
        $to     = $ctr_data['todate'];

        if ($ctr_data['ctr_serv'] != "") {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('vat_scheme_type',
                '=', $ctr_data['ctr_serv'])->where('entry_type', '=', 'T')->get();
        } else {
            
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('entry_type', '=', 'T')->get();
        }

        if (!empty($limitimesheet)) {
            foreach ($limitimesheet as $key => $val) {
                //echo 'gddhdhdhd';

                $data_ctr[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_ctr[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                    
                $data_ctr[$key]['old_service'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
               
                $data_ctr[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_ctr[$key]['hrs'] = $val['hrs'];
                $data_ctr[$key]['notes'] = $val['notes'];
                $data_ctr[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            if (!empty($data_ctr)) {
                $data['limitimesheet'] = $data_ctr;
            }
        }
        
        $client_timereport = $data['cfinal_array'] = array();
        if (isset($data['limitimesheet'])) {

            foreach ($data['limitimesheet'] as $eachR) {
                $temp = array();
                $temp['client_name'] = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                //$temp['service']  = $eachR{'old_vat_scheme'}->vat_scheme_name;

                $temp['hrs'] = $eachR['hrs'];


                $client_timereport[$eachR{'old_service'}->service_name][] = $temp;
            }
        }

        $data['cfinal_array'] = $client_timereport;

        //echo '<pre>'; print_r($postData);
        echo View::make('staff.timesheet.client_timereport')->with('cfinal_array', $data['cfinal_array']);

    }

    public function display_timesheet()
    {
        $ctr_data = array();
        $data_ctr = array();
        $data = array();
        $ctr_data['ctr_client'] = Input::get("ctr_client");
        $expense_id             = Input::get("ctr_expns");
        $ctr_data['fromdate']   = date('Y-m-d', strtotime(Input::get("fromdpick2")));
        $ctr_data['todate']     = date('Y-m-d', strtotime(Input::get("todpick")));
        // die();

        $expense_type = ExpenseType::getNameByExpenseId( $expense_id );

        $form = $ctr_data['fromdate'];
        $to = $ctr_data['todate'];

        if ($expense_id != "") {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('vat_scheme_type',
                '=', $expense_id)->where('entry_type', '=', 'E')->get();
        } else {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('entry_type', '=', 'E')->get();
        }

        $data['limitimesheet'] = TimeSheetReport::getArray($limitimesheet);
        
        $client_timereport = array();
        if (isset($data['limitimesheet'])) {
            foreach ($data['limitimesheet'] as $eachR) {
                $temp = array();
                $temp['client_name']    = $eachR['client_name'];
                $temp['staff_name']     = $eachR['staff_name'];
                $temp['scheme_name']    = $eachR['scheme_name'];
                $temp['date']           = $eachR['created_date'];
                $temp['hrs']            = $eachR['hrs'];

                $client_timereport[$expense_type][] = $temp;
            }
        }
        $data['scheme_name']   = $expense_type;
        $data['cfinal_array']  = $client_timereport;

        //echo '<pre>'; print_r($data);die;
        echo View::make('staff.timesheet.display_timereport')->with($data);

    }


    public function insertstaff_time_sheet()
    {

        $str_data = array();
        $data_str = array();
        $data = array();

        $str_data['str_staff']      = Input::get("str_staff");
        $str_data['str_client']     = Input::get("str_client");
        $str_data['strfromdate']    = date('Y-m-d', strtotime(Input::get("strdpick2")));
        $str_data['strtodate']      = date('Y-m-d', strtotime(Input::get("dpickclient")));


        $form = $str_data['strfromdate'];
        $to = $str_data['strtodate'];

        if ($str_data['str_client'] != "") {

            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $str_data['str_client'])->where('staff_id', '=', $str_data['str_staff'])->where('entry_type', '=', 'T')->get();

        } else {
            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('staff_id', '=', $str_data['str_staff'])->where('entry_type', '=', 'T')->get();
        }

        if (!empty($strlimitimesheet)) {
            foreach ($strlimitimesheet as $key => $val) {


                $data_str[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_str[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
             
                $data_str[$key]['old_service'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
               
                $data_str[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_str[$key]['hrs'] = $val['hrs'];
                $data_str[$key]['notes'] = $val['notes'];
                $data_str[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_str)) {
                $data['limitimesheetstr'] = $data_str;
                //echo '<pre>';
                //print_r($data);
            }
        }

        $staff_timereport = $data['final_array'] = $data['total'] = array();
        if (isset($data['limitimesheetstr'])) {

            foreach ($data['limitimesheetstr'] as $eachR) {
                $temp = array();
                //$temp['client_name']  = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{
                    'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                $temp['service'] = $eachR{'old_service'}->service_name;

                $temp['hrs'] = $eachR['hrs'];


                //$staff_timereport[$eachR{'client_detail'}->field_id][] = $temp;

                $staff_timereport[$eachR{'client_detail'}->field_value][] = $temp;


            }


        }

        $data['final_array'] = $staff_timereport;

        echo View::make('staff.timesheet.staff_timereport')->with('final_array', $data['final_array']);

    }

    public function editclient_time_sheet()
    {


        $ctr_id = Input::get("ctr_id");
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        // $groupUserId = $admin_s['group_users'];


        if (Request::ajax()) {

            $clienttimesheet = ClientTimeReport::where("ctr_id", $ctr_id)->first();
            //$timesheetTemplates['group'] = $groupUserId;
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($clienttimesheet);
            //echo 'aaaaa';
            exit();

        }


    }

    public function editclient_time_report()
    {

        $data['heading'] = "TIME SHEET";
        $data['title'] = "Time Sheet Reports";
        /*if(base64_decode($type) == 'profile'){
        $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        }else{
        $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }*/
        $data['heading'] = "";
        $session_data = Session::get('admin_details');
        $data['user_type'] = $session_data['user_type'];
        $groupUserId = $session_data['group_users'];

        $data_c = array();
        //echo '<pre>';

        //print_r($session_data);
        //ctredit_client
        $data_c['ctr_client'] = Input::get("ctredit_client");
        $data_c['ctr_serv'] = Input::get("ctredit_serv");
        //$data_c['vat_scheme_type'] 	= Input::get("vat_scheme_type");
        $data_c['fromdate'] = date('Y-m-d', strtotime(Input::get("editfromdpick")));
        $data_c['todate'] = date('Y-m-d', strtotime(Input::get("edittodpick")));
        $data_c['user_id'] = $session_data['id'];
        //$data1['created_date'] 		=  date('Y-m-d',strtotime(Input::get("date")));
        $editid = Input::get("editctrid");
        //echo '<pre>';
        //	print_r($data_c);
        //die();
        //exit();
        $affected = ClientTimeReport::where("ctr_id", "=", $editid)->update($data_c);

        //echo $this->last_query();die();

        return Redirect::to('/time-sheet-reports/c3RhZmY=');
    }


    public function fetcheditstaff_time_sheet()
    {


        $str_id = Input::get("str_id");
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        // $groupUserId = $admin_s['group_users'];


        if (Request::ajax()) {

            $stafftimesheet = StaffTimeReport::where("str_id", $str_id)->first();
            //$timesheetTemplates['group'] = $groupUserId;
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($stafftimesheet);
            //echo 'aaaaa';
            exit();

        }


    }

    public function editstaff_time_report()
    {


        //die('sdfafafaf');


        $data['heading'] = "TIME SHEET";
        $data['title'] = "Time Sheet Reports";
        /*if(base64_decode($type) == 'profile'){
        $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        }else{
        $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }*/
        $data['heading'] = "";
        $session_data = Session::get('admin_details');
        $data['user_type'] = $session_data['user_type'];
        $groupUserId = $session_data['group_users'];

        $data_s = array();
        //echo '<pre>';

        //print_r($session_data);
        //ctredit_client
        $data_s['str_client'] = Input::get("editstr_client");

        $data_s['str_staff'] = Input::get("editstr_staff");
        //$data_c['vat_scheme_type'] 	= Input::get("vat_scheme_type");
        $data_s['strfromdate'] = date('Y-m-d', strtotime(Input::get("editstrfromdate")));
        $data_s['strtodate'] = date('Y-m-d', strtotime(Input::get("editstrtodate")));
        $data_s['user_id'] = $session_data['id'];
        //$data1['created_date'] 		=  date('Y-m-d',strtotime(Input::get("date")));
        $editstrid = Input::get("editstrid");
        //echo '<pre>';
        //print_r($data_s);
        //die();
        //exit();
        $affected = StaffTimeReport::where("str_id", "=", $editstrid)->update($data_s);

        //echo $this->last_query();die();

        return Redirect::to('/time-sheet-reports/c3RhZmY=');


    }

    public function delete_time_report()
    {


        $del_id = Input::get("delid");
        //echo $del_id;die();
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        echo $timesheet_id = TimeSheetReport::where("timesheet_id", "=", $del_id)->delete();

        //return Redirect::to('/time-sheet-reports/c3RhZmY=');

    }

    public function view_timesheet_report($page_type, $report_type)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        if(base64_decode($report_type) == 'expense'){
            $data['heading']    = "CLIENT EXPENSES REPORT";
            $data['title']      = "Client Expenses Report";
        }else if(base64_decode($report_type) == 'client'){
            $data['heading']    = "CLIENT TIME REPORT";
            $data['title']      = "Client Time Report";
        }else if(base64_decode($report_type) == 'staff'){
            $data['heading']    = "STAFF TIME REPORT";
            $data['title']      = "Staff Time Report";
        }
        
        if (base64_decode($page_type) == 'profile') {
            $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        } else {
            $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        }
        $data['user_type']          = $session['user_type']; 
        $data['encode_page_type']   = $page_type; 
        $data['page_type']          = base64_decode($page_type); 
        $data['report_type']        = base64_decode($report_type); 
        $data['encode_report_type'] = $report_type;


        $data['allClients']     = App::make("HomeController")->get_all_clients();
        //$data['old_services']   = Service::where("status", "=", "old")->orderBy("service_name")->get();
        //$data['new_services']   = Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
        $data['expense_types'] = ExpenseType::getExpenseTypeByStatus('new');
        
        
        return View::make('staff.timesheet.view_timesheet_report', $data);
    }

    public function download_time_sheet($client_id, $expense_id, $fromdate, $todate, $download_type, $sheet_type)
    {
        ob_end_clean();
        ob_start();
        $ctr_data       = array();
        $data_ctr       = array();
        $data           = array();
        $data['from']   = $fromdate;
        $data['to']     = $todate;
        
        $time   = date("Y-m-d H:i:s");
        
        $pieces         = explode(" ", $time);
        $data['cdate']  = $pieces[0];
        $data['ctime']  = $pieces[1];
        
        $ctr_data['ctr_client'] = $client_id ;
        $ctr_data['fromdate']   = date('Y-m-d', strtotime($fromdate));
        $ctr_data['todate']     = date('Y-m-d', strtotime($todate));

        if($sheet_type == 'E'){
            $expense_type = ExpenseType::getNameByExpenseId( $expense_id );
        }
        
        $form   = $ctr_data['fromdate'];
        $to     = $ctr_data['todate'];

        if ($expense_id != "") {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('vat_scheme_type',
                '=', $expense_id)->where('entry_type', '=', $sheet_type)->get();
        } else {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('entry_type', '=',$sheet_type)->get();
        }

        $data['limitimesheet'] = TimeSheetReport::getArray($limitimesheet);

        $timereport  = array();
        if (isset($data['limitimesheet'])) {
            foreach ($data['limitimesheet'] as $eachR) {
                $temp = array();
                $temp['client_name']    = $eachR['client_name'];
                $temp['staff_name']     = $eachR['staff_name'];
                $temp['scheme_name']    = $eachR['scheme_name'];
                $temp['date']           = $eachR['created_date'];
                $temp['hrs']            = $eachR['hrs'];

                $timereport[$expense_type][] = $temp;
            }
        }

        $data['cname']          = isset($temp['client_name'])?$temp['client_name']:'';
        $data['cfinal_array']   = $timereport;

        $data['heading']        = "CLIENT EXPENSES REPORT";
        $data['expense_type']   = $expense_type;
        $data['download_type']  = $download_type;
        $data['sheet_type']     = $sheet_type ;

        //echo "<pre>";print_r($data);die;

        if (!empty($data['cfinal_array'])) {
            if($download_type == 'pdf'){

                $pdf = new \Clegginabox\PDFMerger\PDFMerger;
                $pdf->addPDF('uploads/expense_files/temporary/temporary.pdf', 'all');
                $pdf->addPDF('uploads/expense_files/temporary/temporary.pdf', 'all');
                $pdf->merge('download', 'uploads/expense_files/TEST2.pdf', 'P');
/*                $pdfFilePath = base_path('/public/uploads/expense_files/temporary/temporary.pdf');

                $pdf_merger->addPDF($pdfFilePath, 'all');
                $pdf_merger->addPDF(base_path('/public/uploads/expense_files/temporary/temporary.pdf', 'all'));
                $merged_file_name = "Proposal_attachments_merged.pdf"; //make it unique
                $pdf_merger->merge('file', base_path('/public/proposalPdf/'.$merged_file_name), 'P');*/
                


                /////////////////////////////////////////////////////

                $pdf = PDF::loadView('staff/timesheet/download_time_sheet', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
                $pdf->output();

                $pdf->save('uploads/expense_files/temporary/temporary.pdf');                

                $dom_pdf = $pdf->getDomPDF();
                $canvas = $dom_pdf ->get_canvas();
                $canvas->page_text(700, 30, "Page - {PAGE_NUM}", null, 10, array(0, 0, 0));
                
                return $pdf->download('Expense reports.pdf');
            }else{
                $viewToLoad = 'staff/timesheet/download_time_sheet';
                Excel::create('Expense reports', function ($excel) use ($data, $viewToLoad)
                {
                    $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
                    {
                        $sheet->loadView($viewToLoad)->with($data); }
                    )->save(); }
                );

                $filepath   = storage_path() . '/exports/Expense reports.xls';
                $fileName   = 'Expense reports.xls';
                $headers    = array('Content-Type: application/vnd.ms-excel', );
                return Response::download($filepath, $fileName, $headers);
            }
        }
    }


    public function client_timereport()
    {

        $data['heading'] = "CLIENT TIME REPORT";
        $data['title'] = "Client Time Report";
        //if (base64_decode($type) == 'profile') {
        //            $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        //        } else {
        $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        //        }
        //        $data['staff_type'] = base64_decode($type);
        //

        //$data['heading'] = "";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type'] = $session['user_type'];
        $groupUserId = $session['group_users'];
        //die('sddsdsd');

        $data['allClients'] = App::make("HomeController")->get_all_clients();
        
        //$data['old_vat_schemes'] = VatScheme::where("status", "=", "old")->orderBy("vat_scheme_name")->get();
        //$data['new_vat_schemes'] = VatScheme::where("status", "=", "new")->whereIn("user_id",$groupUserId)->orderBy("vat_scheme_name")->get();
      
        $data['old_services'] 	= Service::where("status", "=", "old")->orderBy("service_name")->get();
		$data['new_services'] 	= Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
        
        
        return View::make('staff.timesheet.client_report', $data);

    }

    public function staff_timereport()
    {

        $data['heading'] = "STAFF TIME REPORT";
        $data['title'] = "Staff Time Report";
        //if (base64_decode($type) == 'profile') {
        //            $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        //        } else {
        $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        //        }
        //        $data['staff_type'] = base64_decode($type);
        //

        // $data['heading'] = "";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type'] = $session['user_type'];
        $groupUserId = $session['group_users'];
        //die('sddsdsd');
        $data['staff_details'] = User::whereIn("user_id", $groupUserId)->where("client_id",
            "=", 0)->select("user_id", "fname", "lname")->get();
        $data['allClients'] = App::make("HomeController")->get_all_clients();
        $data['old_vat_schemes'] = VatScheme::where("status", "=", "old")->orderBy("vat_scheme_name")->
            get();
        $data['new_vat_schemes'] = VatScheme::where("status", "=", "new")->whereIn("user_id",
            $groupUserId)->orderBy("vat_scheme_name")->get();

        //die('stafftimereport');

        return View::make('staff.timesheet.staff_report', $data);
    }

    public function staffdemo()
    {

        $data['heading'] = "STAFF TIME REPORT";
        $data['title'] = "Staff Time Report";
        //if (base64_decode($type) == 'profile') {
        //            $data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
        //        } else {
        $data['previous_page'] = '<a href="/staff-management">Staff Management</a>';
        //        }
        //        $data['staff_type'] = base64_decode($type);
        //

        // $data['heading'] = "";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type'] = $session['user_type'];
        $groupUserId = $session['group_users'];
        return View::make('staff.timesheet.demo', $data);
    }


    public function timesheetpdf()
    {
        
        $data['heading'] = "TIME SHEET";
        $data['title'] = "Time Sheet Reports";
        
        $t= time();
        $time = date("Y-m-d H:i:s",$t);
        $pieces = explode(" ", $time);
        $data['cdate'] =     $pieces[0];
        $data['ctime']  =  $pieces[1];
        
        
        $data['heading'] = "";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type'] = $session['user_type'];
        $groupUserId = $session['group_users'];

        //print_r($groupUserId);die();

        $data['staff_details'] = User::whereIn("user_id", $groupUserId)->where("client_id",
            "=", 0)->select("user_id", "fname", "lname")->get();
        $data['old_vat_schemes'] = VatScheme::where("status", "=", "old")->orderBy("vat_scheme_name")->
            get();
        $data['new_vat_schemes'] = VatScheme::where("status", "=", "new")->whereIn("user_id",
            $groupUserId)->orderBy("vat_scheme_name")->get();

        $data['allClients'] = App::make("HomeController")->get_all_clients();


        $time_sheet_report = TimeSheetReport::whereIn("user_id", $groupUserId)->orderBy("created_date",
            "desc")->get();
        //echo $this->last_query();die();
        if (!empty($time_sheet_report)) {
            foreach ($time_sheet_report as $key => $val) {

                $data2[$key]['timesheet_id'] = $val['timesheet_id'];
                $data2[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                $data2[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->
                    select("vat_scheme_name")->first();
                
                $data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data2[$key]['hrs'] = $val['hrs'];
                $data2[$key]['notes'] = $val['notes'];
                $data2[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data2)) {
                $data['time_sheet_report'] = $data2;
            }
        }

        $time_sheet_reportlmt = TimeSheetReport::whereIn("user_id", $groupUserId)->
            orderBy("created_date", "desc")->take(90)->get();
        //echo $this->last_query();die();
        if (!empty($time_sheet_reportlmt)) {
            foreach ($time_sheet_reportlmt as $key => $val) {

                $data3[$key]['timesheet_id'] = $val['timesheet_id'];
                $data3[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                $data3[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->
                    select("vat_scheme_name")->first();
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data3[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data3[$key]['hrs'] = $val['hrs'];
                $data3[$key]['notes'] = $val['notes'];
                $data3[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data3)) {
                $data['time_sheet_reportlmt'] = $data3;
            }
        }


        $pdf = PDF::loadView('staff/timesheet/timesheetpdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            
            

        return $pdf->download('timesheetpdf.pdf');


    }


    public function timesheetexcel()
    {
        $data['heading'] = "TIME SHEET";
        $data['title'] = "Time Sheet Reports";

        $data['heading'] = "";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_type'] = $session['user_type'];
        $groupUserId = $session['group_users'];

        //print_r($groupUserId);die();

        $data['staff_details'] = User::whereIn("user_id", $groupUserId)->where("client_id",
            "=", 0)->select("user_id", "fname", "lname")->get();
        $data['old_vat_schemes'] = VatScheme::where("status", "=", "old")->orderBy("vat_scheme_name")->
            get();
        $data['new_vat_schemes'] = VatScheme::where("status", "=", "new")->whereIn("user_id",
            $groupUserId)->orderBy("vat_scheme_name")->get();

        $data['allClients'] = App::make("HomeController")->get_all_clients();


        $time_sheet_report = TimeSheetReport::whereIn("user_id", $groupUserId)->orderBy("created_date",
            "desc")->get();
        //echo $this->last_query();die();
        if (!empty($time_sheet_report)) {
            foreach ($time_sheet_report as $key => $val) {

                $data2[$key]['timesheet_id'] = $val['timesheet_id'];
                $data2[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                $data2[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->
                    select("vat_scheme_name")->first();
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data2[$key]['hrs'] = $val['hrs'];
                $data2[$key]['notes'] = $val['notes'];
                $data2[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data2)) {
                $data['time_sheet_report'] = $data2;
            }
        }

        $time_sheet_reportlmt = TimeSheetReport::whereIn("user_id", $groupUserId)->
            orderBy("created_date", "desc")->take(90)->get();
        //echo $this->last_query();die();
        if (!empty($time_sheet_reportlmt)) {
            foreach ($time_sheet_reportlmt as $key => $val) {

                $data3[$key]['timesheet_id'] = $val['timesheet_id'];
                $data3[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                $data3[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->
                    select("vat_scheme_name")->first();
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data3[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data3[$key]['hrs'] = $val['hrs'];
                $data3[$key]['notes'] = $val['notes'];
                $data3[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data3)) {
                $data['time_sheet_reportlmt'] = $data3;
            }
        }


        $viewToLoad = 'staff/timesheet/timesheetexcel';
        ///////////  Start Generate and store excel file ////////////////////////////
        Excel::create('timesheet_list', function ($excel)use ($data, $viewToLoad)
        {

            $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
            {
                $sheet->loadView($viewToLoad)->with($data); }
            )->save(); }
        );

        //


        $filepath = storage_path() . '/exports/timesheet_list.xls';
        $fileName = 'timesheet_list.xls';
        $headers = array('Content-Type: application/vnd.ms-excel', );

        return Response::download($filepath, $fileName, $headers);
        exit;


    }


    public function pdfclient_time_sheet($ctr_client,$ctr_serv,$fromdate,$todate)
    {
        
        $ctr_data       = array();
        $data_ctr       = array();
        $data           = array();
        $data['from']   = $fromdate;
        $data['to']     = $todate;
        $temp           = array();
        $t              = time();
        
        $time           = date("Y-m-d H:i:s",$t);
        $pieces         = explode(" ", $time);
        $data['cdate']  =     $pieces[0];
        $data['ctime']  =  $pieces[1];
        
        
        $ctr_data['ctr_client'] = $ctr_client ;
        $ctr_data['ctr_serv']   = $ctr_serv;
        $ctr_data['fromdate']   = date('Y-m-d', strtotime($fromdate));
        $ctr_data['todate']     = date('Y-m-d', strtotime($todate));
        

        $form   = $ctr_data['fromdate'];
        $to     = $ctr_data['todate'];

        if ($ctr_data['ctr_serv'] != "") {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->where('rel_client_id', '=', $ctr_data['ctr_client'])->where('vat_scheme_type','=', $ctr_data['ctr_serv'])->get();
        } else {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->where('rel_client_id', '=', $ctr_data['ctr_client'])->get();
        }
        //echo $this->last_query();
        //die();

        if (!empty($limitimesheet)) {
            foreach ($limitimesheet as $key => $val) {
                $data_ctr[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_ctr[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                $data_ctr[$key]['old_services'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
                
                $data_ctr[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_ctr[$key]['hrs'] = $val['hrs'];
                $data_ctr[$key]['notes'] = $val['notes'];
                $data_ctr[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_ctr)) {
                $data['limitimesheet'] = $data_ctr;
            }
        }

        $client_timereport = $data['cfinal_array'] = array();
        $client_name = "";
        if (isset($data['limitimesheet'])) {
            foreach ($data['limitimesheet'] as $eachR) {
                $temp = array();
                $client_name    = $eachR{'client_detail'}->field_value;

                $temp['client_name']    = $client_name;
                $temp['staff_name']     = $eachR{'staff_detail'}->fname." ".$eachR{'staff_detail'}->lname;
                $temp['date']           = $eachR['created_date'];
                $temp['hrs']            = $eachR['hrs'];
                $client_timereport[$eachR{'old_services'}->service_name][] = $temp;
            }
        }
        $data['cname']          = $client_name;
        $data['cfinal_array']   = $client_timereport;
        
        
        if (!empty($data['cfinal_array'])) {
            $pdf = PDF::loadView('staff/timesheet/pdfclienttimereport', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf ->get_canvas();
            $canvas->page_text(700, 10, "Page - {PAGE_NUM}", null, 10, array(0, 0, 0));
                
            return $pdf->download('Client_Time_Reportpdf.pdf');
        } else {
            return Redirect::to('/timesheet/client-timereport');
        }
        
        //echo View::make('staff.timesheet.client_timereport', $data);

    }
    
     public function excelclient_time_sheet($ctr_client,$ctr_serv,$fromdate,$todate)
    {
        
        $ctr_data = array();
        $data_ctr = array();
        $data = array();
        
        $ctr_data['ctr_client'] =$ctr_client ;
        $ctr_data['ctr_serv'] = $ctr_serv;
        $ctr_data['fromdate'] = date('Y-m-d', strtotime($fromdate));
        $ctr_data['todate'] = date('Y-m-d', strtotime($todate));


        $form = $ctr_data['fromdate'];
        $to = $ctr_data['todate'];

        if ($ctr_data['ctr_serv'] != "") {


            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('vat_scheme_type',
                '=', $ctr_data['ctr_serv'])->get();
        } else {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->get();
        }
        //echo $this->last_query();
        //die();

        if (!empty($limitimesheet)) {
            foreach ($limitimesheet as $key => $val) {
                $data_ctr[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_ctr[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                $data_ctr[$key]['old_services'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
                $data_ctr[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                $data_ctr[$key]['hrs'] = $val['hrs'];
                $data_ctr[$key]['notes'] = $val['notes'];
                $data_ctr[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_ctr)) {
                $data['limitimesheet'] = $data_ctr;
            }
        }

        $client_timereport = $data['cfinal_array'] = array();
        $client_name = "";
        if (isset($data['limitimesheet'])) {
            foreach ($data['limitimesheet'] as $eachR) {
                $temp = array();
                $client_name            = $eachR{'client_detail'}->field_value;
                $temp['client_name']    = $client_name;
                $temp['staff_name']     = $eachR{'staff_detail'}->fname . " " . $eachR{'staff_detail'}->lname;
                $temp['date']           = $eachR['created_date'];
                $temp['hrs']            = $eachR['hrs'];
                $client_timereport[$eachR{'old_services'}->service_name][] = $temp;

            }
        }
        $data['cname']          = $client_name;
        $data['cfinal_array']   = $client_timereport;

        if (!empty($data['cfinal_array'])) {
            $viewToLoad = 'staff/timesheet/excelclienttimereport';
            ///////////  Start Generate and store excel file ////////////////////////////
            Excel::create('clientftimesheet_list', function ($excel)use ($data, $viewToLoad)
            {
                $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
                {
                    $sheet->loadView($viewToLoad)->with($data); }
                )->save(); }
            );

            $filepath   = storage_path() . '/exports/clientftimesheet_list.xls';
            $fileName   = 'clientftimesheet_list.xls';
            $headers    = array('Content-Type: application/vnd.ms-excel', );

            return Response::download($filepath, $fileName, $headers);
            exit;
        } else {
            return Redirect::to('/timesheet/client-timereport');
        }

    }
    
           
    public function pdfclientnotstaff_time_sheet($ctr_client,$fromdate,$todate){
        $ctr_data = array();
        $data_ctr = array();
        $data = array();
        $data['from'] =$fromdate;
        $data['to']=$todate;
        
        $t= time();
            
        $time = date("Y-m-d H:i:s",$t);
        
        $pieces = explode(" ", $time);
        $data['cdate'] =     $pieces[0];
        $data['ctime']  =  $pieces[1];
        
        $ctr_data['ctr_client'] =$ctr_client ;
        $ctr_data['ctr_serv'] = "";
        $ctr_data['fromdate'] = date('Y-m-d', strtotime($fromdate));
        $ctr_data['todate'] = date('Y-m-d', strtotime($todate));


        $form = $ctr_data['fromdate'];
        $to = $ctr_data['todate'];

        if ($ctr_data['ctr_serv'] != "") {


            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('vat_scheme_type',
                '=', $ctr_data['ctr_serv'])->get();
        } else {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->get();
        }

        if (!empty($limitimesheet)) {
            foreach ($limitimesheet as $key => $val) {
                //echo 'gddhdhdhd';

                $data_ctr[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_ctr[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                //$data_ctr[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->select("vat_scheme_name")->first();
                $data_ctr[$key]['old_services'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
                
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data_ctr[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_ctr[$key]['hrs'] = $val['hrs'];
                $data_ctr[$key]['notes'] = $val['notes'];
                $data_ctr[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_ctr)) {
                $data['limitimesheet'] = $data_ctr;
            }
        }

        $client_timereport = $data['cfinal_array'] = array();
        if (isset($data['limitimesheet'])) {

            foreach ($data['limitimesheet'] as $eachR) {
                $temp = array();
                $temp['client_name'] = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{
                    'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                $temp['hrs'] = $eachR['hrs'];
                $client_timereport[$eachR{'old_services'}->service_name][] = $temp;

            }
        }
        $data['cname']= $temp['client_name'];
        $data['cfinal_array'] = $client_timereport;

        // echo View::make('staff.timesheet.client_timereport')->with('cfinal_array',$data['cfinal_array']);
        if (!empty($data['cfinal_array'])) {

            // return View::make('staff.timesheet.pdfclienttimereport', $data);


            $pdf = PDF::loadView('staff/timesheet/pdfclienttimereport', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            
             $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
                
                $canvas = $dom_pdf ->get_canvas();
               // $canvas->page_text(72, 18, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
                
                $canvas->page_text(700, 30, "Page - {PAGE_NUM}", null, 10, array(0, 0, 0));
           
           
            return $pdf->download('Client_Time_Reportpdf.pdf');
            // return Redirect::to('/timesheet/client-timereport');

        } else {
            //return Redirect::to('/timesheet/client-timereport');
        }
    }
    
    
    
    
    public function excelclientnotstaff_time_sheet($ctr_client,$fromdate,$todate){
        
        
        $ctr_data = array();
        $data_ctr = array();
        $data = array();
       

        $ctr_data['ctr_client'] =$ctr_client ;
        $ctr_data['ctr_serv'] = "";
        $ctr_data['fromdate'] = date('Y-m-d', strtotime($fromdate));
        $ctr_data['todate'] = date('Y-m-d', strtotime($todate));


        $form = $ctr_data['fromdate'];
        $to = $ctr_data['todate'];

        if ($ctr_data['ctr_serv'] != "") {


            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->where('vat_scheme_type',
                '=', $ctr_data['ctr_serv'])->get();
        } else {
            $limitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $ctr_data['ctr_client'])->get();
        }
        //echo $this->last_query();
        //die();

        if (!empty($limitimesheet)) {
            foreach ($limitimesheet as $key => $val) {
                //echo 'gddhdhdhd';

                $data_ctr[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_ctr[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                //$data_ctr[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->select("vat_scheme_name")->first();
                
                $data_ctr[$key]['old_services'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
                
                
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data_ctr[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_ctr[$key]['hrs'] = $val['hrs'];
                $data_ctr[$key]['notes'] = $val['notes'];
                $data_ctr[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_ctr)) {
                $data['limitimesheet'] = $data_ctr;
            }
        }

        $client_timereport = $data['cfinal_array'] = array();
        if (isset($data['limitimesheet'])) {

            foreach ($data['limitimesheet'] as $eachR) {
                $temp = array();
                $temp['client_name'] = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{
                    'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                $temp['hrs'] = $eachR['hrs'];
                $client_timereport[$eachR{'old_services'}->service_name][] = $temp;

            }
        }

        $data['cfinal_array'] = $client_timereport;

        // echo View::make('staff.timesheet.client_timereport')->with('cfinal_array',$data['cfinal_array']);
        if (!empty($data['cfinal_array'])) {
            
            //
            $viewToLoad = 'staff/timesheet/excelclienttimereport';
        ///////////  Start Generate and store excel file ////////////////////////////
        Excel::create('clientftimesheet_list', function ($excel)use ($data, $viewToLoad)
        {

            $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
            {
                $sheet->loadView($viewToLoad)->with($data); }
            )->save(); }
        );

        //


        $filepath = storage_path() . '/exports/clientftimesheet_list.xls';
        $fileName = 'clientftimesheet_list.xls';
        $headers = array('Content-Type: application/vnd.ms-excel', );

        return Response::download($filepath, $fileName, $headers);
        exit;
        
        
            
            //
           } 
    
        
    }
    
    
    
    public function pdfstaffnoclient_time_sheet($str_staff,$strfromdate,$strtodate){
        
        

        $str_data = array();
        $data_str = array();
        $data = array();
        
        
         $data['from'] =$strfromdate;
        $data['to']=$strtodate;
        
             $t= time();
            
            $time = date("Y-m-d H:i:s",$t);
            
            $pieces = explode(" ", $time);
            $data['cdate'] =     $pieces[0];
            $data['ctime']  =  $pieces[1];
        
        
        
        

        $str_data['str_staff'] = $str_staff;
        $str_data['str_client'] = "";
        $str_data['strfromdate'] = date('Y-m-d', strtotime($strfromdate));
        $str_data['strtodate'] = date('Y-m-d', strtotime($strtodate));


        $form = $str_data['strfromdate'];
        $to = $str_data['strtodate'];

        if ($str_data['str_client'] != "") {

            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $str_data['str_client'])->where('staff_id', '=', $str_data['str_staff'])->
                get();

        } else {

            // $strlimitimesheet = TimeSheetReport::groupBy('rel_client_id')->whereBetween('created_date', array($form, $to))->where('staff_id','=',$str_data['str_staff'])->get();
            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('staff_id', '=', $str_data['str_staff'])->get();
        }

        //echo $this->last_query();
        //die();
        //echo '<pre>';
        //print_r($strlimitimesheet);
        if (!empty($strlimitimesheet)) {
            foreach ($strlimitimesheet as $key => $val) {


                $data_str[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_str[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                //$data_str[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->select("vat_scheme_name")->first();
                
                $data_str[$key]['old_service'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
               
                
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data_str[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_str[$key]['hrs'] = $val['hrs'];
                $data_str[$key]['notes'] = $val['notes'];
                $data_str[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_str)) {
                $data['limitimesheetstr'] = $data_str;
                //echo '<pre>';
                //print_r($data);
            }
        }

        $staff_timereport = $data['final_array'] = $data['total'] = array();
        if (isset($data['limitimesheetstr'])) {

            foreach ($data['limitimesheetstr'] as $eachR) {
                $temp = array();
                //$temp['client_name']  = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{
                    'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                $temp['service'] = $eachR{'old_service'}->service_name;

                $temp['hrs'] = $eachR['hrs'];


                //$staff_timereport[$eachR{'client_detail'}->field_id][] = $temp;

                $staff_timereport[$eachR{'client_detail'}->field_value][] = $temp;


            }


        }
        
        
        
        $data['sname']= $temp['staff_name'];
        $data['final_array'] = $staff_timereport;
        
        //echo View::make('staff.timesheet.staff_timereport')->with('final_array', $data['final_array']);
        
        $pdf = PDF::loadView('staff/timesheet/pdfstafftimereport', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            
         $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
                
                $canvas = $dom_pdf ->get_canvas();
               // $canvas->page_text(72, 18, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
                
                $canvas->page_text(700, 18, "Page - {PAGE_NUM}", null, 10, array(0, 0, 0));
            
            return $pdf->download('Staff_Time_Reportpdf.pdf');
        
        
        
        
        
                
    }
    
    public function pdfstaff_time_sheet($str_staff,$str_client,$strfromdate,$strtodate){
        
        
        
        

        $str_data = array();
        $data_str = array();
        $data = array();



            
            $data['from'] =$strfromdate;
            $data['to']=$strtodate;
            
            $t= time();
            
            $time = date("Y-m-d H:i:s",$t);
            
            $pieces = explode(" ", $time);
            $data['cdate'] =     $pieces[0];
            $data['ctime']  =  $pieces[1];
        
        
        $str_data['str_staff'] = $str_staff;
        $str_data['str_client'] = $str_client;
        $str_data['strfromdate'] = date('Y-m-d', strtotime($strfromdate));
        $str_data['strtodate'] = date('Y-m-d', strtotime($strtodate));


        $form = $str_data['strfromdate'];
        $to = $str_data['strtodate'];

        if ($str_data['str_client'] != "") {

            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $str_data['str_client'])->where('staff_id', '=', $str_data['str_staff'])->
                get();

        } else {

            // $strlimitimesheet = TimeSheetReport::groupBy('rel_client_id')->whereBetween('created_date', array($form, $to))->where('staff_id','=',$str_data['str_staff'])->get();
            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('staff_id', '=', $str_data['str_staff'])->get();
        }

        //echo $this->last_query();
        //die();
        //echo '<pre>';
        //print_r($strlimitimesheet);
        if (!empty($strlimitimesheet)) {
            foreach ($strlimitimesheet as $key => $val) {


                $data_str[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_str[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
               // $data_str[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->select("vat_scheme_name")->first();
                $data_str[$key]['old_service'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
               
                
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data_str[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_str[$key]['hrs'] = $val['hrs'];
                $data_str[$key]['notes'] = $val['notes'];
                $data_str[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_str)) {
                $data['limitimesheetstr'] = $data_str;
                //echo '<pre>';
                //print_r($data);
            }
        }

        $staff_timereport = $data['final_array'] = $data['total'] = array();
        if (isset($data['limitimesheetstr'])) {

            foreach ($data['limitimesheetstr'] as $eachR) {
                $temp = array();
                //$temp['client_name']  = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{
                    'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                $temp['service'] = $eachR{'old_service'}->service_name;

                $temp['hrs'] = $eachR['hrs'];


                //$staff_timereport[$eachR{'client_detail'}->field_id][] = $temp;

                $staff_timereport[$eachR{'client_detail'}->field_value][] = $temp;


            }


        }
        $data['sname']= $temp['staff_name'];
        $data['final_array'] = $staff_timereport;
        
        //echo View::make('staff.timesheet.staff_timereport')->with('final_array', $data['final_array']);
        
        $pdf = PDF::loadView('staff/timesheet/pdfstafftimereport', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
           
            $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
                
                $canvas = $dom_pdf ->get_canvas();
               // $canvas->page_text(72, 18, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
                
                $canvas->page_text(700, 18, "Page - {PAGE_NUM}", null, 10, array(0, 0, 0));
           
            return $pdf->download('Staff_Time_Reportpdf.pdf');
        
        
        
        
        
                
    
        
        
    }
    
    
    
    
    
    
    public function excelstaff_time_sheet($str_staff,$str_client,$strfromdate,$strtodate){
        
        
        
        

        $str_data = array();
        $data_str = array();
        $data = array();

        $str_data['str_staff'] = $str_staff;
        $str_data['str_client'] = $str_client;
        $str_data['strfromdate'] = date('Y-m-d', strtotime($strfromdate));
        $str_data['strtodate'] = date('Y-m-d', strtotime($strtodate));


        $form = $str_data['strfromdate'];
        $to = $str_data['strtodate'];

        if ($str_data['str_client'] != "") {

            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $str_data['str_client'])->where('staff_id', '=', $str_data['str_staff'])->
                get();

        } else {

            // $strlimitimesheet = TimeSheetReport::groupBy('rel_client_id')->whereBetween('created_date', array($form, $to))->where('staff_id','=',$str_data['str_staff'])->get();
            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('staff_id', '=', $str_data['str_staff'])->get();
        }

        //echo $this->last_query();
        //die();
        //echo '<pre>';
        //print_r($strlimitimesheet);
        if (!empty($strlimitimesheet)) {
            foreach ($strlimitimesheet as $key => $val) {


                $data_str[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_str[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                //$data_str[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->select("vat_scheme_name")->first();
                 $data_str[$key]['old_service'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
               
                
                
                
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data_str[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_str[$key]['hrs'] = $val['hrs'];
                $data_str[$key]['notes'] = $val['notes'];
                $data_str[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_str)) {
                $data['limitimesheetstr'] = $data_str;
                //echo '<pre>';
                //print_r($data);
            }
        }

        $staff_timereport = $data['final_array'] = $data['total'] = array();
        if (isset($data['limitimesheetstr'])) {

            foreach ($data['limitimesheetstr'] as $eachR) {
                $temp = array();
                //$temp['client_name']  = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{
                    'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                $temp['service'] = $eachR{'old_service'}->service_name;

                $temp['hrs'] = $eachR['hrs'];


                //$staff_timereport[$eachR{'client_detail'}->field_id][] = $temp;

                $staff_timereport[$eachR{'client_detail'}->field_value][] = $temp;


            }


        }

        $data['final_array'] = $staff_timereport;
        
        //echo View::make('staff.timesheet.staff_timereport')->with('final_array', $data['final_array']);
        
     
     
     //   $pdf = PDF::loadView('staff/timesheet/pdfstafftimereport', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            //return $pdf->download('stafftimesheetpdf.pdf');
        
        
        $viewToLoad = 'staff/timesheet/excelstafftimereport';
        ///////////  Start Generate and store excel file ////////////////////////////
        Excel::create('stafftimesheet_list', function ($excel)use ($data, $viewToLoad)
        {

            $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
            {
                $sheet->loadView($viewToLoad)->with($data); }
            )->save(); }
        );

        //


        $filepath = storage_path() . '/exports/stafftimesheet_list.xls';
        $fileName = 'stafftimesheet_list.xls';
        $headers = array('Content-Type: application/vnd.ms-excel', );

        return Response::download($filepath, $fileName, $headers);
        exit;

        
        
        
                
    
        
        
    }
    
    public function excelstaffnoclient_time_sheet($str_staff,$strfromdate,$strtodate){
        
        
        
        

        $str_data = array();
        $data_str = array();
        $data = array();

        $str_data['str_staff'] = $str_staff;
        $str_data['str_client'] = "";
        $str_data['strfromdate'] = date('Y-m-d', strtotime($strfromdate));
        $str_data['strtodate'] = date('Y-m-d', strtotime($strtodate));


        $form = $str_data['strfromdate'];
        $to = $str_data['strtodate'];

        if ($str_data['str_client'] != "") {

            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('rel_client_id', '=', $str_data['str_client'])->where('staff_id', '=', $str_data['str_staff'])->
                get();

        } else {

            // $strlimitimesheet = TimeSheetReport::groupBy('rel_client_id')->whereBetween('created_date', array($form, $to))->where('staff_id','=',$str_data['str_staff'])->get();
            $strlimitimesheet = TimeSheetReport::whereBetween('created_date', array($form, $to))->
                where('staff_id', '=', $str_data['str_staff'])->get();
        }

        //echo $this->last_query();
        //die();
        //echo '<pre>';
        //print_r($strlimitimesheet);
        if (!empty($strlimitimesheet)) {
            foreach ($strlimitimesheet as $key => $val) {


                $data_str[$key]['timesheet_id'] = $val['timesheet_id'];
                $data_str[$key]['staff_detail'] = User::where("user_id", "=", $val['staff_id'])->
                    select("user_id", "fname", "lname")->first();
                //$data_str[$key]['old_vat_scheme'] = VatScheme::where("vat_scheme_id", "=", $val['vat_scheme_type'])->select("vat_scheme_name")->first();
                $data_str[$key]['old_service'] = Service::where("service_id", "=", $val['vat_scheme_type'])->select("service_name")->first();
               
                
                
                
                
                //$data2[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->where("field_name", "=", "business_name")->orWhere("field_name", "=", "client_name")->first();
                $data_str[$key]['client_detail'] = StepsFieldsClient::where("client_id", "=", $val['rel_client_id'])->
                    where(function ($query)
                {
                    $query->where("field_name", "=", "business_name")->orWhere("field_name", "=",
                        "client_name"); }
                )->first();

                //echo $this->last_query();
                $data_str[$key]['hrs'] = $val['hrs'];
                $data_str[$key]['notes'] = $val['notes'];
                $data_str[$key]['created_date'] = date("d-m-Y", strtotime($val['created_date']));
            }
            //echo $val;die();
            if (!empty($data_str)) {
                $data['limitimesheetstr'] = $data_str;
                //echo '<pre>';
                //print_r($data);
            }
        }

        $staff_timereport = $data['final_array'] = $data['total'] = array();
        if (isset($data['limitimesheetstr'])) {

            foreach ($data['limitimesheetstr'] as $eachR) {
                $temp = array();
                //$temp['client_name']  = $eachR{'client_detail'}->field_value;
                $temp['staff_name'] = $eachR{'staff_detail'}->fname . " " . $eachR{
                    'staff_detail'}->lname;
                $temp['date'] = $eachR['created_date'];
                $temp['service'] = $eachR{'old_service'}->service_name;

                $temp['hrs'] = $eachR['hrs'];


                //$staff_timereport[$eachR{'client_detail'}->field_id][] = $temp;

                $staff_timereport[$eachR{'client_detail'}->field_value][] = $temp;


            }


        }

        $data['final_array'] = $staff_timereport;
        
        //echo View::make('staff.timesheet.staff_timereport')->with('final_array', $data['final_array']);
        
     
     
     //   $pdf = PDF::loadView('staff/timesheet/pdfstafftimereport', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            //return $pdf->download('stafftimesheetpdf.pdf');
        
        
        $viewToLoad = 'staff/timesheet/excelstafftimereport';
        ///////////  Start Generate and store excel file ////////////////////////////
        Excel::create('stafftimesheet_list', function ($excel)use ($data, $viewToLoad)
        {

            $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
            {
                $sheet->loadView($viewToLoad)->with($data); }
            )->save(); }
        );

        //


        $filepath = storage_path() . '/exports/stafftimesheet_list.xls';
        $fileName = 'stafftimesheet_list.xls';
        $headers = array('Content-Type: application/vnd.ms-excel', );

        return Response::download($filepath, $fileName, $headers);
        exit;

    }

    public function expense_type_action()
    {
        $session = Session::get('admin_details');
        $action   = Input::get("action");

        if($action == 'add'){
            $data['expense_type']   = Input::get("expense_type_name");
            $data['user_id']        = $session['id'];
            $data['status']         = "new";

            $last_id = ExpenseType::insertGetId($data);
        }else if($action == 'delete_attachment'){
            $last_id = Input::get("timesheet_id");
            $upData['attachment'] = '';
            TimeSheetReport::where("timesheet_id", "=", $last_id)->update($upData);
        }else if($action == 'viewTimeSheet'){
            $client_id  = Input::get("client_id");
            $service_id = Input::get("service_id");
            
            $data['details'] = TimeSheetReport::getByClientIdAndServiceId( $client_id, $service_id );
            echo json_encode($data);
            exit();
        }else{
            $last_id = Input::get("field_id");
            ExpenseType::where("expense_id", "=", $last_id)->delete();
        }
        
        echo $last_id;
        exit();
    }

    public function update_file(){
        $timesheet_id = Input::get("tableHidId");
        $fileName = '';
        if (Input::hasFile('attachmentTbl')) {
            $file           = Input::file('attachmentTbl');
            $destination    = "uploads/expense_files";
            $fileName       = Input::file('attachmentTbl')->getClientOriginalName();
            $fileName       = time().'-'.$fileName;

            Input::file('attachmentTbl')->move($destination, $fileName);

            $upData['attachment'] = $fileName;
            TimeSheetReport::where("timesheet_id", "=", $timesheet_id)->update($upData);
        }

        $data['fileName']       = $fileName;
        $data['timesheet_id']   = $timesheet_id;

        echo json_encode($data);
    }

}
