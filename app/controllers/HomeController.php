<?php

class HomeController extends BaseController
{

  public function __construct()
  {
    parent::__construct();
    $session = Session::get('admin_details');
    $user_id = $session['id'];
  }
  
  public function db_connect()
  {
    if (DB::connection()->getDatabaseName()) {
        echo "Conncted sucessfully to database : " . DB::connection()->getDatabaseName();
        die;
    }
  }

  public function home()
  {
    $data['page_title'] = "i-Practice | Practice Automation";
    return View::make('home.index', $data);
  }

  public function dashboard()
  {
    $session    = Session::get('admin_details');
    $user_id    = $session['id'];
    $user_type  = $session['user_type'];

    if (!isset($user_id) && $user_id == "") {
        return Redirect::to('/');
    }else if (isset($user_type) && $user_type == "C") {
        return Redirect::to('/invitedclient-dashboard');
    }

    $data['heading']    = "DASHBOARD";
    $data['title']      = "Dashboard";

    $data['access']     = UserAccess::getUserAccess();
    $data['userinfo']   = $session;
    $data['_token']     = Session::get('_token');
    //print_r($data['access']);
    return View::make('home.dashboard', $data);
  }

    public function individual_clients()
    {
      $client_data      = array();
      $data['heading']  = "CLIENT LIST - INDIVIDUALS";
      $data['title']    = "Individual Clients List";
      $admin_s      = Session::get('admin_details');
      $user_id      = $admin_s['id'];
      $groupUserId  = Common::getUserIdByGroupId($admin_s['group_id']);

      if (empty($user_id)) {
        return Redirect::to('/');
      }

      /*$client_ids = Client::where("is_deleted", "N")->where("type", "ind")->
          where("is_archive", "N")->where("is_relation_add", "N")->whereIn("user_id",
          $groupUserId)->select("client_id", "show_archive")->get();
      $i = 0;
      if (isset($client_ids) && count($client_ids) > 0) {
        foreach ($client_ids as $client_id) {
          $client_details = StepsFieldsClient::where('client_id', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();

          $client_data[$i]['client_id']       = $client_id->client_id;
          $client_data[$i]['show_archive']    = $client_id->show_archive;

          if (isset($client_details) && count($client_details) > 0) {
              $address = "";
              foreach ($client_details as $client_row) {
                  //get staff name start
                if (!empty($client_row['field_name']) && $client_row['field_name']=="resp_staff"){
                  $staff_name = User::where('user_id',$client_row->field_value)->select("fname",
                          "lname")->first();
                  $client_data[$i]['staff_name'] = strtoupper(substr($staff_name['fname'], 0, 1)) .
                          " " . strtoupper(substr($staff_name['lname'], 0, 1));
                  }
                  //get staff name end

                  $client_data[$i]['relationship'] = Common::get_relationship_client($client_id->client_id);
                  //get business name end


                  //get residencial address
                if(isset($client_row['field_name']) && $client_row['field_name']=="res_address"){
                  $client_data[$i]['address']=ClientAddress::getFullAddress($client_row->field_value);
                }


                if(isset($client_row['field_name']) && $client_row['field_name']=="business_type"){
                  $business_type = OrganisationType::where('organisation_id', $client_row->field_value)->first();
                  $client_data[$i][$client_row['field_name']] = $business_type['name'];
                } else {
                  $client_data[$i][$client_row['field_name']] = $client_row->field_value;
                }

              }

              $client_data[$i]['invitation_status'] = User::getInvitationStatus($client_id->client_id);
              $i++;
          }

        }
      }
      $data['client_details'] = $client_data;*/

      $data['client_fields'] = ClientField::where("field_type", "ind")->get();
      //echo '<pre>';print_r($client_data);die;
      return View::make('home.individual.individual_client', $data);
    }

    public function organisation_clients()
    {
      $client_data        = array();
      $data['heading']    = "CLIENT LIST - ORGANISATIONS";
      $data['title']      = "Organisation Clients List";
      $admin_s = Session::get('admin_details'); // session
      $user_id = $admin_s['id']; //session user id
      $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

      if (empty($user_id)) {
          return Redirect::to('/');
      }

      /*$client_ids = Client::where("is_deleted", "N")->where("type", "org")->
          where("is_archive", "N")->where("is_relation_add", "N")->whereIn("user_id",
          $groupUserId)->select("client_id", "created", "show_archive")->orderBy("client_id",
          "DESC")->get();
      $i = 0;
      if (isset($client_ids) && count($client_ids) > 0) {
        foreach ($client_ids as $client_id) {
          $client_details = StepsFieldsClient::where('client_id', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();

          $client_data[$i]['client_id'] = $client_id->client_id;
          $client_data[$i]['show_archive'] = $client_id->show_archive;
          $appointment_name = ClientRelationship::where('client_id', $client_id->client_id)->select("appointment_with")->first();

          $relation_name = StepsFieldsClient::where('client_id', $appointment_name['appointment_with'])->where('field_name', "name")->select("field_value")->first();

          if (isset($client_details) && count($client_details) > 0) {
            $corres_address = "";
            foreach ($client_details as $client_row) {
              if (!empty($relation_name['field_value'])) {
                $client_data[$i]['staff_name'] = $relation_name['field_value'];
              }

              if (isset($client_row['field_name']) && $client_row['field_name']=="next_acc_due"){
                $client_data[$i]['deadacc_count'] = $this->getDayCount($client_row->field_value);
              }
              if (isset($client_row['field_name']) && $client_row['field_name']=="next_ret_due") {
                $client_data[$i]['deadret_count'] = $this->getDayCount($client_row->field_value);
              }
              if(isset($client_row['field_name']) && $client_row['field_name']=="acc_ref_month"){
                $client_data[$i]['ref_month'] = App::make('ChdataController')->
                      getMonthNameShort($client_row->field_value);
              }

              if (isset($client_row['field_name']) && $client_row['field_name']=="business_type"){
                $business_type = OrganisationType::where('organisation_id', $client_row->field_value)->first();
                $client_data[$i][$client_row['field_name']] = $business_type['name'];
              } else {
                $client_data[$i][$client_row['field_name']] = $client_row->field_value;
              }

              if(isset($client_row['field_name']) && $client_row['field_name']=="corres_address"){
                $corres_address = ClientAddress::getFullAddress($client_row->field_value);
              }
                
            }
            $client_data[$i]['corres_address'] = $corres_address;

            $i++;
          }
        }
      }
      $data['client_details'] = $client_data;*/

      $data['client_fields'] = ClientField::where("field_type", "org")->get();

      //echo '<pre>';print_r($data['client_details']);die;
      //echo '<pre>';print_r($data);die;

      return View::make('home.organisation.organisation_client', $data);
    }


    function getDayCount($from) 
    {
        $arr = explode('-', $from);
        $date1 = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        $date2 = date("Y-m-d");
        $diff = strtotime($date1) - strtotime($date2);
        $days = round($diff / 86400);

        return $days;
    }

    public function add_individual_client()
    {

        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];

        if (empty($user_id)) {
            return Redirect::to('/');
        }

        $data['heading'] = "";
        $data['title'] = "Add Client";
        $data['previous_page'] = '<a href="/individual-clients">Individual Clients List</a>';

        $data['rel_types'] = RelationshipType::where("show_status", "=", "individual")->
            orderBy("relation_type_id")->get();
        $data['marital_status'] = MaritalStatus::orderBy("marital_status_id")->get();
        $data['titles'] = Title::orderBy("title_id")->get();
        $data['tax_office'] = TaxOfficeAddress::select("parent_id", "office_id",
            "office_name")->get();
        $data['tax_office_by_id'] = TaxOfficeAddress::where("office_id", "=", 1)->first();
        $data['steps'] = Step::where("status", "=", "old")->orderBy("step_id")->get();
        $data['substep'] = Step::whereIn("user_id", $groupUserId)->where("client_type",
            "=", "ind")->where("parent_id", "=", 1)->orderBy("step_id")->get(); //echo $this->last_query();
        $data['responsible_staff'] = $this->get_responsible_staff();
        $data['countries'] = Country::orderBy('country_name')->get();
        $data['nationalities'] = Nationality::get();
        $data['field_types'] = FieldType::get();
        //$data['cont_address'] = $this->get_contact_address();
        $data['cont_address'] = ClientAddress::getAllDetails();

        $data['allClients'] = $this->get_all_clients();

        $data['old_services'] = Service::where("status", "=", "old")->where("client_type",
            "=", "ind")->orderBy("service_name")->get();
        $data['new_services'] = Service::where("status", "=", "new")->where("client_type",
            "=", "ind")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();

        $steps_fields_users = StepsFieldsAddedUser::whereIn("user_id", $groupUserId)->
            where("substep_id", "=", '0')->where("client_type", "=", "ind")->get();
        foreach ($steps_fields_users as $key => $steps_fields_row) {
            $steps_fields_users[$key]->select_option = explode(",", $steps_fields_row->
                select_option);
        }
        $data['steps_fields_users'] = $steps_fields_users;

        //###########User added section and sub section start##########//
        $steps = array();
        $subsections = Step::whereIn("user_id", $groupUserId)->where("status", "=",
            "new")->get();
        //echo $this->last_query();die;
        foreach ($subsections as $key => $val) {
            if (isset($val->status) && $val->status == "new") {
                $steps[$key]['step_id'] = $val->step_id;
                $steps[$key]['parent_id'] = $val->parent_id;
                $steps[$key]['short_code'] = $val->short_code;
                $steps[$key]['title'] = $val->title;
                $steps[$key]['status'] = $val->status;
            }

        }
        $data['subsections'] = $this->buildtree($steps, "ind");
        //###########User added section and sub section start##########//
        //$data['contacts']    = ContactAddress::getAllContactNameAndId();

        //print_r($data['contacts']);die;
        //echo $this->last_query();die;
        return View::make('home.individual.add_individual_client', $data);
    }

    public function add_organisation_client()
    {

        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $data['user_type'] = $admin_s['user_type'];
        $groupUserId = $admin_s['group_users'];

        if (empty($user_id)) {
            return Redirect::to('/');
        }

        $data['heading'] = "";
        $data['title'] = "Add Client";
        $data['previous_page'] =
            '<a href="/organisation-clients">Organisation Clients List</a>';

        $data['old_org_types'] = OrganisationType::where("client_type", "=", "all")->
            orderBy("name")->get();
        $data['new_org_types'] = OrganisationType::where("client_type", "=", "org")->
            whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->
            get();


        $data['rel_types'] = RelationshipType::orderBy("relation_type_id")->get();
        $data['steps'] = Step::where("status", "=", "old")->orderBy("step_id")->get();
        $data['substep'] = Step::where("client_type", "=", "org")->where("parent_id",
            "=", 1)->whereIn("user_id", $groupUserId)->orderBy("step_id")->get();
        $data['staff_details'] = User::whereIn("user_id", $groupUserId)->select("user_id","fname", "lname")->get();
        
        
         $taxOfficeaddress = TaxOfficeAddress::where("parent_id", "==", "0")->select("office_id","office_name")->get();
         
         $income=array();
         $j=0;
         foreach($taxOfficeaddress as $key=>$valeuname){
            $income[$j]['office_type']="I";
            $income[$j]['office_id']=$valeuname['office_id'];
            $income[$j]['office_name']=$valeuname['office_name'];
            
           $j++;
           }
          // echo '<pre>';print_r($income);
        $corporation=array();
        $corporationtaxOffice = CorporationTaxOffice::select("corp_tax_id", "office_name")->get();
        
         foreach($corporationtaxOffice as $key=>$valeuname){
            $corporation[$j]['office_type']="C";
            $corporation[$j]['office_id']=$valeuname['corp_tax_id'];
            $corporation[$j]['office_name']=$valeuname['office_name'];
            
           $j++;
        }
           //echo '<pre>';print_r($corporation);
        
        $finalarry=array_merge($income,$corporation);
        
        $data['taxallofficeaddress']=$finalarry;
            
        $data['tax_office'] = TaxOfficeAddress::select("parent_id", "office_id",
            "office_name")->get();

        $data['old_services'] = Service::where("status", "=", "old")->orderBy("service_name")->
            get();
        $data['new_services'] = Service::where("status", "=", "new")->whereIn("user_id",
            $groupUserId)->orderBy("service_name")->get();

        $data['countries'] = Country::orderBy('country_name')->get();
        $data['field_types'] = FieldType::get();

        $data['old_vat_schemes'] = VatScheme::where("status", "=", "old")->orderBy("vat_scheme_name")->
            get();
        $data['new_vat_schemes'] = VatScheme::where("status", "=", "new")->whereIn("user_id",
            $groupUserId)->orderBy("vat_scheme_name")->get();
        //echo $this->last_query();die;
        //$data['cont_address'] = $this->get_orgcontact_address();
        //$data['cont_address'] 	 = $this->getAllOrgContactAddress();
        $data['cont_address'] = ClientAddress::getAllDetails();
        $data['allClients'] = $this->get_all_clients();


        $data['reg_address'] = RegisteredAddress::orderBy("reg_id")->get();

        $steps_fields_users = StepsFieldsAddedUser::whereIn("user_id", $groupUserId)->
            where("substep_id", "=", '0')->where("client_type", "=", "org")->get();
        foreach ($steps_fields_users as $key => $steps_fields_row) {
            $steps_fields_users[$key]->select_option = explode(",", $steps_fields_row->
                select_option);
        }
        $data['steps_fields_users'] = $steps_fields_users;

        //###########User added section and sub section start##########//
        $steps = array();
        $subsections = Step::whereIn("user_id", $groupUserId)->where("status", "=",
            "new")->get();
        foreach ($subsections as $key => $val) {
            if (isset($val->status) && $val->status == "new") {
                $steps[$key]['step_id'] = $val->step_id;
                $steps[$key]['parent_id'] = $val->parent_id;
                $steps[$key]['short_code'] = $val->short_code;
                $steps[$key]['title'] = $val->title;
                $steps[$key]['status'] = $val->status;
            }

        }
        $data['subsections'] = $this->buildtree($steps, "org");
        //###########User added section and sub section start##########//
        $data['months'] = array("01" => "JAN", "02" => "FEB", "03" => "MAR", "04" => "APR", "05" => "MAY",
            "06"=>"JUN", "07"=>"JUL", "08"=>"AUG", "09"=>"SEPT", "10"=>"OCT", "11"=>"NOV", "12" => "DEC");
        $data['contacts']    = ContactAddress::getAllContactNameAndId();
        $data['business']    = BusinessDescription::getAllDetails();

        return View::make('home.organisation.add_organisation_client', $data);

    }

    public function buildtree($steps, $client_type)
    {
        $branch = array();
        foreach ($steps as $element) {
            $children = StepsFieldsAddedUser::where("substep_id", "=", $element['step_id'])->
                where("client_type", "=", $client_type)->get();
            foreach ($children as $key => $steps_fields_row) {
                $children[$key]->select_option = explode(",", $steps_fields_row->select_option);
            }
            if (isset($children) && count($children) > 0) {
                foreach ($children as $key => $row) {
                    $element['children'][$key]['field_id'] = $row->field_id;
                    $element['children'][$key]['user_id'] = $row->user_id;
                    $element['children'][$key]['step_id'] = $row->step_id;
                    $element['children'][$key]['field_type'] = $row->field_type;
                    $element['children'][$key]['field_name'] = $row->field_name;
                    $element['children'][$key]['field_value'] = $row->field_value;
                    $element['children'][$key]['select_option'] = $row->select_option;
                    $element['children'][$key]['client_type'] = $row->client_type;
                }
                $branch[] = $element;
            }

        }
        return $branch;
    }

    public function get_contact_address()
    {
        $client_data = array();

        //die('sff');
        $admin_s = Session::get('admin_details'); // session
        $user_id = $admin_s['id']; //session user id
        $groupUserId = $admin_s['group_users'];
        //print_r($groupUserId);die();
        //die('sff');
        if (isset($groupUserId)) {
            //$client_ids = Client::where('is_deleted', '=', "N")->where('type', '=', "org")->whereIn('user_id', $groupUserId)->select("client_id")->get();
            $client_ids = Client::select("client_id")->where('is_deleted', '=', "N")->where("type",
                "=", "ind")->whereIn('user_id', $groupUserId)->get();
        }
        //
        //echo $this->last_query();die;


        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];

        $client_ids = Client::where('is_deleted', '=', "N")->where('type', '=', "ind")->
            whereIn('user_id', $groupUserId)->select("client_id")->get();
        //$client_array = Client::where("type", "=", "ind")->where('user_id', '=', $groupUserId)->select("client_id")->get();
        //echo $this->last_query();//die;

        $i = 0;
        if (isset($client_ids)) {
            foreach ($client_ids as $key => $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();

                $client_data[$i]['client_id'] = $client_id->client_id;
                //echo $this->last_query();//die;

                if (isset($client_details) && count($client_details) > 0) {
                    foreach ($client_details as $client_row) {
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_addr_line1") {
                            $client_data[$i]['res_addr_line1'] = $client_row['field_value'];
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "serv_addr_line1") {
                            $client_data[$i]['serv_addr_line1'] = $client_row['field_value'];
                        }

                    }
                }
                $i++;
            }
        }
        //echo "<pre>";print_r($client_data);die;
        return $client_data;
    }

    public function get_orgcontact_address()
    {
        $client_data = array();

        $admin_s = Session::get('admin_details'); // session
        $user_id = $admin_s['id']; //session user id
        $groupUserId = $admin_s['group_users'];

        $client_ids = Client::where('is_deleted', '=', "N")->where('type', '=', "org")->
            whereIn('user_id', $groupUserId)->select("client_id")->get();

        //echo $this->last_query();die;
        $i = 0;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();

                $client_data[$i]['client_id'] = $client_id->client_id;
                //echo $this->last_query();die;

                if (isset($client_details) && count($client_details) > 0) {
                    foreach ($client_details as $client_row) {

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "trad_cont_addr_line1")) {

                            $client_data[$i]['trad_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "reg_cont_addr_line1")) {

                            $client_data[$i]['reg_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "corres_cont_addr_line1")) {

                            $client_data[$i]['corres_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "banker_cont_addr_line1")) {

                            $client_data[$i]['banker_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "oldacc_cont_addr_line1")) {

                            $client_data[$i]['oldacc_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "auditors_cont_addr_line1")) {

                            $client_data[$i]['auditors_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "solicitors_cont_addr_line1")) {

                            $client_data[$i]['solicitors_cont_addr_line1'] = $client_row['field_value'];
                        }


                    }


                    //res_addr_line1
                }
                $i++;
            }
        }
        //echo "<pre>";print_r($client_data);die;
        return $client_data;
    }
    public function getAllOrgContactAddress()
    {
        $client_data = array();

        $admin_s = Session::get('admin_details'); // session
        $user_id = $admin_s['id']; //session user id
        $groupUserId = $admin_s['group_users'];

        $client_ids = Client::where('is_deleted', '=', "N")->where('type', '=', "org")->
            whereIn('user_id', $groupUserId)->select("client_id")->get();

        //echo $this->last_query();die;
        $i = 0;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();

                $client_data[$i]['client_id'] = $client_id->client_id;
                //echo $this->last_query();die;

                if (isset($client_details) && count($client_details) > 0) {
                    foreach ($client_details as $client_row) {

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "trad_cont_addr_line1")) {

                            $client_data[$i]['trad_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "reg_cont_addr_line1")) {

                            $client_data[$i]['reg_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "corres_cont_addr_line1")) {

                            $client_data[$i]['corres_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "banker_cont_addr_line1")) {

                            $client_data[$i]['banker_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "oldacc_cont_addr_line1")) {

                            $client_data[$i]['oldacc_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "auditors_cont_addr_line1")) {

                            $client_data[$i]['auditors_cont_addr_line1'] = $client_row['field_value'];
                        }

                        if (isset($client_row['field_name']) && ($client_row['field_name'] ==
                            "solicitors_cont_addr_line1")) {

                            $client_data[$i]['solicitors_cont_addr_line1'] = $client_row['field_value'];
                        }


                    }


                    //res_addr_line1
                }
                $i++;
            }
        }


        //echo "<pre>";print_r($client_data);die;
        return $client_data;
    }

    public function insert_individual_client()
    {
        $postData = Input::all();
        $arrData = array();

        //print_r($store_datas);die();

        $admin_s        = Session::get('admin_details');
        $user_id        = $admin_s['id'];
        $user_type      = $admin_s['user_type'];
        $groupUserId    = $admin_s['group_users'];

        if (isset($postData['client_id']) && $postData['client_id'] == "new") {
            $client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'ind'));
        } else {
            $client_id = $postData['client_id'];
            Client::where("client_id", $client_id)->update(array(
                "is_deleted" => "N",
                'type' => 'ind',
                'is_relation_add' => 'N'));
            /* =============== Store Updating data ===================== */
            if (isset($user_type) && $user_type == "C") {
              $postData['added_from'] = 'client_portal';
            }else{
              $postData['added_from'] = 'main_portal';
            }
            StepsFieldsClient::storeUpdatingData($postData);
            /* =============== Store Updating data ===================== */
            StepsFieldsClient::where("client_id", $client_id)->delete();
        }

        //echo $this->last_query();die;
        //################ GENERAL SECTION START #################//
        $step_id = 1;
        if (!empty($postData['client_code'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'client_code', $postData['client_code']);
        }

        $client_name = "";
        if (!empty($postData['title'])) {
            //$client_name.=$postData['title']." ";
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'title', $postData['title']);
        }

        if (!empty($postData['fname'])) {
            $client_name .= $postData['fname'] . " ";
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'fname', $postData['fname']);
        }

        if (!empty($postData['mname'])) {
            $client_name .= $postData['mname'] . " ";
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'mname', $postData['mname']);
        }

        if (!empty($postData['lname'])) {
            $client_name .= $postData['lname'];
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'lname', $postData['lname']);
        }

        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'client_name',
            trim($client_name));

        if (!empty($postData['gender'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'gender', $postData['gender']);
        }
        if (!empty($postData['dob'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'dob', $postData['dob']);
        }
        if (!empty($postData['marital_status'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'marital_status',
                $postData['marital_status']);
        }
        if (!empty($postData['spouse_dob'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'spouse_dob', $postData['spouse_dob']);
        }
        if (!empty($postData['country'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'country_id', $postData['country']);
        }

        if (!empty($postData['occupation'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'occupation', $postData['occupation']);
        }
        if (!empty($postData['nationality'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'nationality_id',
                $postData['nationality']);
        }
        //################ GENERAL SECTION END #################//

        //################ TAX SECTION START #################//
        $step_id = 2;
        if (!empty($postData['ni_number'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ni_number', $postData['ni_number']);
        }
        if (!empty($postData['tax_reference'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_reference',
                $postData['tax_reference']);
        }
        if (!empty($postData['other_office_id'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_office_id',
                $postData['other_office_id']);
        } else {
            if (!empty($postData['tax_office_id'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_office_id',
                    $postData['tax_office_id']);
            }
        }
        if (!empty($postData['tax_address'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_address', $postData['tax_address']);
        }
        if (!empty($postData['tax_zipcode'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_zipcode', $postData['tax_zipcode']);
        }
        if (!empty($postData['tax_telephone'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_telephone',
                $postData['tax_telephone']);
        }
        if (!empty($postData['tax_region'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_region', $postData['tax_region']);
        }
        //################ TAX INFORMATION SECTION END #################//

        //################ CONTACT INFORMATION SECTION START #################//
        $step_id = 3;
        if(isset($postData['serv_address']) && $postData['serv_address'] != ''){
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_address', $postData['serv_address']);
        }
        if(isset($postData['res_address']) && $postData['res_address'] != ''){
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_address', $postData['res_address']);
        }
        /*if (!empty($postData['serv_addr_line1'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                'serv_addr_line1', $postData['serv_addr_line1']);
        }
        if (!empty($postData['serv_addr_line2'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                'serv_addr_line2', $postData['serv_addr_line2']);
        }
        if (!empty($postData['serv_city'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_city', $postData['serv_city']);
        }
        if (!empty($postData['serv_county'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_county', $postData['serv_county']);
        }

        if (!empty($postData['serv_postcode'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_postcode',
                $postData['serv_postcode']);
        }
        if (!empty($postData['serv_country'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'serv_country',
                $postData['serv_country']);
        }
        if (!empty($postData['res_addr_line1'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_addr_line1',
                $postData['res_addr_line1']);
        }
        if (!empty($postData['res_addr_line2'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_addr_line2',
                $postData['res_addr_line2']);
        }
        if (!empty($postData['res_city'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_city', $postData['res_city']);
        }
        if (!empty($postData['res_county'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_county', $postData['res_county']);
        }
        if (!empty($postData['res_postcode'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_postcode',
                $postData['res_postcode']);
        }
        if (!empty($postData['res_country'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_country', $postData['res_country']);
        }*/

        if (!empty($postData['res_tele_code'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_tele_code',
                $postData['res_tele_code']);
        }
        if (!empty($postData['res_telephone'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_telephone',
                $postData['res_telephone']);
        }
        if (!empty($postData['res_mobile_code'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                'res_mobile_code', $postData['res_mobile_code']);

        }
        if (!empty($postData['res_mobile'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_mobile', $postData['res_mobile']);

        }
        if (!empty($postData['res_email'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_email', $postData['res_email']);
        }
        if (!empty($postData['res_website'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_website', $postData['res_website']);
        }
        if (!empty($postData['res_skype'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'res_skype', $postData['res_skype']);
        }
        //################ CONTACT INFORMATION SECTION END #################//

        //############# RELATIONSHIP START ###################//
        if (!empty($postData['app_hidd_array'])) {
            $relData = array();
            $app_hidd_array = explode(",", $postData['app_hidd_array']); //print_r($app_hidd_array);
            foreach ($app_hidd_array as $row) {
                $rel_row = explode("mpm", $row);

                $rel_client = ClientRelationship::where("client_id", "=", $client_id)->where("relationship_type_id",
                    "=", $rel_row['1'])->where("appointment_with", "=", $rel_row['2'])->first();

                if (isset($rel_client) && count($rel_client) > 0) {
                    //$relData['relationship_type_id'] = $rel_row['1'];
                    ClientRelationship::where("client_id", "=", $client_id)->where("appointment_with",
                        "=", $rel_row['2'])->update($relData);
                } else {
                    $relData['client_id'] = $client_id;
                    $relData['appointment_with'] = $rel_row['2'];
                    $relData['relationship_type_id'] = $rel_row['1'];
                    ClientRelationship::insert($relData);
                }

            }
            //ClientRelationship::insert($relData);

        }
        //############# RELATIONSHIP END ###################//


        //############# ACTING SECTION START ###################//
        if (!empty($postData['acting_hidd_array'])) {
            $actData = array();
            $acting_hidd_array = explode(",", $postData['acting_hidd_array']);
            foreach ($acting_hidd_array as $row) {
                $act_row = explode("mpm", $row);
                $actData[] = array(
                    'user_id' => $user_id,
                    'client_id' => $client_id,
                    'acting_client_id' => $act_row['1']);

                $update_data['is_relation_add'] = "N";
                $data_client = Client::where("client_id", "=", $act_row['1'])->first();
                if (isset($data_client['chd_type']) && $data_client['chd_type'] == "ind") {
                    $update_data['type'] = "ind";
                }
                if (isset($data_client['chd_type']) && $data_client['chd_type'] == "org") {
                    $update_data['type'] = "org";
                }
                Client::where("client_id", "=", $act_row['1'])->update($update_data);

            }
            ClientActing::insert($actData);

        }
        //############# ACTING SECTION END ###################//

        //################ OTHERS SECTION END #################//
        $step_id = 5;
        if (!empty($postData['aml_checks'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'aml_checks', $postData['aml_checks']);
        }
        if (!empty($postData['tax_ret_req'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_ret_req', $postData['tax_ret_req']);
        }
        if (isset($postData['other_services']) && count($postData['other_services']) > 0) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'other_services',
                serialize($postData['other_services']));
        }

        /*if (!empty($postData['resp_staff'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'resp_staff', $postData['resp_staff']);
        }*/

        ClientService::where("client_id", "=", $client_id)->delete();
        if (isset($postData['other_services']) && count($postData['other_services']) > 0) {
            //$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'other_services', serialize($postData['other_services']));
            $relData = array();
            foreach ($postData['other_services'] as $service_id) {
                $servData['client_id'] = $client_id;
                $servData['service_id'] = $service_id;
                ClientService::insert($servData);
            }
        }

        //################## USER ADDED FIELD START ###############//
        $field_added = StepsFieldsAddedUser::where("client_type", "ind")->whereIn("user_id",
            $groupUserId)->get();
        //echo $this->last_query();die;
        if (isset($field_added) && count($field_added) > 0) {
            foreach ($field_added as $key => $value) {
                $field_name = strtolower($value->field_name);
                if (isset($postData[$field_name]) && $postData[$field_name] != "") {
                    $arrData[] = $this->save_client($user_id, $client_id, $value->step_id, $field_name,
                        $postData[$field_name]);
                }
            }
        }
        //################## USER ADDED FIELD END ###############//


        // ################# File upload in the other section start ############### //
        $file_details = ClientFile::where('client_id', $client_id)->first();
        if (isset($file_details) && count($file_details) > 0) {
            $client_file_id = $file_details['client_file_id'];
        } else {
            $file_data['client_id'] = $client_id;
            $client_file_id = ClientFile::insertGetId($file_data);
        }
        for ($i = 1; $i <= 2; $i++) {
            //$i = 1;
            if (Input::hasFile('passport' . $i)) {
                $file = Input::file('passport' . $i);
                $destinationPath = "uploads/passports/";
                $fileName = Input::file('passport' . $i)->getClientOriginalName();
                //$fileName = $fileName;
                $result = Input::file('passport' . $i)->move($destinationPath, $fileName);

                $file_data['passport' . $i] = $fileName;
                ClientFile::where("client_file_id", "=", $client_file_id)->update($file_data);

                ### delete the previous image if exists ###
                if (isset($file_details['passport' . $i]) && $file_details['passport' . $i] !=
                    "") {
                    $prevPath = "uploads/passports/" . $file_details['passport' . $i];
                    if (file_exists($prevPath)) {
                        unlink($prevPath);
                    }
                }

                ### delete the previous image if exists ###

            }
        }

        for ($i = 1; $i <= 2; $i++) {
            //$i = 1;
            if (Input::hasFile('document' . $i)) {
                $file = Input::file('document' . $i);
                $destinationPath = "uploads/documents/";
                $fileName = Input::file('document' . $i)->getClientOriginalName();
                //$fileName = $fileName;
                $result = Input::file('document' . $i)->move($destinationPath, $fileName);

                $file_data['document' . $i] = $fileName;
                ClientFile::where("client_file_id", "=", $client_file_id)->update($file_data);

                ### delete the previous image if exists ###
                if (isset($file_details['document' . $i]) && $file_details['document' . $i] !=
                    "") {
                    $prevPath = "uploads/documents/" . $file_details['document' . $i];
                    if (file_exists($prevPath)) {
                        unlink($prevPath);
                    }
                }

                ### delete the previous image if exists ###

            }
        }

        if (Input::hasFile('profile_photo')) {

            $users = User::where('client_id', '=', $client_id)->select('user_id')->first();
            if(isset($users['user_id']) && $users['user_id'] != ''){
                $files = ClientFile::where('client_id', "=", $users['user_id'])->first();
                if (isset($files) && count($files) > 0) {
                    $client_file_id = $files['client_file_id'];
                } else {
                    $file_data['client_id'] = $users['user_id'];
                    $client_file_id = ClientFile::insertGetId($file_data);
                }
            }
            
            $file = Input::file('profile_photo');
            $destinationPath = "uploads/profile_photo/";
            $fileName   = Input::file('profile_photo')->getClientOriginalName();
            $fileName   = time().'_'.$fileName;
            $result     = Input::file('profile_photo')->move($destinationPath,$fileName);

            $file_data['profile_photo'] = $fileName;
            ClientFile::where("client_file_id","=",$client_file_id)->update($file_data);

            ### delete the previous image if exists ###
            if(isset($file_details['profile_photo'])&&$file_details['profile_photo']!='')
            {
                $prevPath = "uploads/profile_photo/" . $file_details['profile_photo'];
                if (file_exists($prevPath)) {
                    unlink($prevPath);
                }
            }

            ### delete the previous image if exists ###
        } else {
            if(isset($postData['old_profile_photo']) && $postData['old_profile_photo']!=""){
                $arrData[] = $this->save_profile($user_id, $staff_id, 1, 'profile_photo', $postData['old_profile_photo']);
            }
        }

        // ################# File upload in the other section end ############### //

        //print_r($arrData);die;
        StepsFieldsClient::insert($arrData);

        if (isset($user_type) && $user_type == "C") {
            if (isset($postData['photo_save'])) {
                return Redirect::to("/client/edit-ind-client/".$client_id."/".base64_encode($postData['page_name']));
            }else{
                return Redirect::to('/client-portal');
            }
            //return Redirect::to('/invitedclient-dashboard');
        } else {
            return Redirect::to('/individual-clients');
        }


    }

    public function get_office_address()
    {
        $tax_office_address = array();
        $office_id = Input::get("office_id");
        if (Request::ajax()) {
            $tax_office_address = TaxOfficeAddress::where("office_id", "=", $office_id)->
                first();
            //echo $this->last_query();die;
        }

        echo json_encode($tax_office_address);
        exit();
    }

  function save_relationship()
  {
    $rel_types = array();
    $rel_type_id    = Input::get("rel_type_id");
    $rel_client_id  = Input::get("rel_client_id");
    $client_id      = Input::get("client_id");

    if (Request::ajax()) {
      $rel_types = RelationshipType::where("relation_type_id", $rel_type_id)->first();
        //echo $this->last_query();die;
    }

    $client_details = Common::clientDetailsById($rel_client_id);
    //print_r($rel_types['client_details']);die;
    //######## get client type #########//
    //$client_data = Client::where("client_id", "=", $rel_client_id)->first();
    if (isset($client_details) && count($client_details) > 0) {
      if ($client_details['type'] == "ind") {
        $client_details['link'] = "/client/edit-ind-client/" . $rel_client_id . '/' .
        base64_encode('ind_client');
      } else
        if ($client_details['type'] == "org") {
          $client_details['link'] = "/client/edit-org-client/" . $rel_client_id . '/' .
                base64_encode('org_client');
        } else
          if ($client_details['type'] == "chd") {
            if ($client_details['chd_type'] == "ind") {
                $client_details['link'] = "/client/edit-ind-client/" . $rel_client_id . '/' .
                    base64_encode('ind_client');
            } else
              if ($client_details['chd_type'] == "org") {
                  $client_details['link'] = "/client/edit-org-client/" . $rel_client_id . '/' .
                      base64_encode('org_client');
              }
          } else {
            $client_details['link'] = "";
          }

      }
      //######## get client type #########//
      $rel_types['client_details'] = $client_details;
      $rel_types['client_relship_id'] = ClientRelationship::getRelId($client_id, $rel_client_id);


      echo json_encode($rel_types);
      exit();

    }

    public function save_userdefined_field()
    {
        $data = array();

        $admin_s = Session::get('admin_details'); // session
        $back_url = Input::get("back_url");

        $data['user_id'] = $admin_s['id'];
        $data['step_id'] = Input::get("step_id");
        $data['substep_id'] = Input::get("substep_id");
        $data['field_name'] = str_replace(" ", "_", Input::get("field_name"));
        $data['field_type'] = Input::get("field_type");
        $data['client_type'] = Input::get("client_type");
        $data['select_option'] = Input::get("select_option");

        $field_id = StepsFieldsAddedUser::insertGetId($data);
        if ($back_url == "add_ind") {
            return Redirect::to('/individual/add-client');
        } else if ($back_url == "edit_ind") {
            return Redirect::to('/client/edit-ind-client/' . Input::get("client_id"));
        } else if ($back_url == "add_org") {
            return Redirect::to('/organisation/add-client');
        } else if ($back_url == "edit_org") {
            return Redirect::to('/client/edit-org-client/' . Input::get("client_id"));
        }

    }


    public function edit_services()
    {

        $servicetxt_id = Input::get("servicetxt_id");
        $id = Input::get("id");
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];
        $first_serv = DB::table('services')->where("status", "=", "old")->where("user_id",
            "=", 0);

        $data['services'] = Service::where("status", "=", "new")->whereIn("user_id", $groupUserId)->
            union($first_serv)->orderBy("service_id")->get();


        $stafftxt_id = Input::get("stafftxt_id");
        $data['staff_details'] = User::whereIn("user_id", $groupUserId)->select("user_id",
            "fname", "lname")->get();
        $data['stafftxt_id'] = $stafftxt_id;
        $data['id'] = $id;
        $data['user_id'] = $user_id;
        $data['first_serv'] = $first_serv;
        $data['servicetxt_id'] = $servicetxt_id;

        //echo '<pre>';
        //print_r($data['services']);
        return View::make('home.organisation.edit_service', $data);

    }


    function save_services()
    {
        $rel_types = array();
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        $service_id = Input::get("service_id");
        $staff_id = Input::get("staff_id");

        if (Request::ajax()) {
            $temp_types = Service::where("service_id", "=", $service_id)->first();
            $user = User::where("user_id", "=", $staff_id)->select("fname", "lname")->first();
            //echo $this->last_query();die;
        }
        $rel_types['service'] = $temp_types['service_name'];
        $rel_types['staff'] = $user['fname'] . " " . $user['lname'];

        echo json_encode($rel_types);
        exit();
    }

    public function search_client()
    {
        $client_details = array();
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        $search_value   = Input::get("search_value");
        $client_type    = Input::get("client_type");
        $client_ids     = Client::where('is_deleted', '=', "N")->where("type", "=", $client_type)->
            where('user_id', '=', $user_id)->select("client_id")->get();
        if ($client_type == "org") {
            $field_name = 'business_name';
        } else {
            $field_name = 'fname';
        }
        $i = 0;
        foreach ($client_ids as $client_id) {
            $client_name = StepsFieldsClient::where("field_value", "like", '%' . $search_value .
                '%')->where('field_name', '=', $field_name)->where('client_id', '=', $client_id->
                client_id)->select("field_value")->first();
            if (isset($client_name) && count($client_name) > 0) {
                $client_details[$i]['client_id'] = $client_id->client_id;
                $client_details[$i]['client_name'] = $client_name['field_value'];
                $i++;
            }

            //echo $this->last_query();
        }

        echo json_encode($client_details);
        exit();
    }

    public function get_all_clients()
    {
        $client_details = array();
        $orgclients = array();
        $indclients = array();

        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];

        $search_value = Input::get("search_value");
        $client_ids = Client::whereIn('user_id', $groupUserId)->where('is_deleted',"N")->where("is_archive", "N")->where("type", "!=", "non")->select("client_id", 'type')->get();
        //echo $this->last_query();die;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $key => $client_id) {
                if($client_id->type == 'ind')
                    $indclients[$key]['client_id'] = $client_id->client_id;
                if($client_id->type == 'org')
                    $orgclients[$key]['client_id'] = $client_id->client_id;
            }
        }
        //echo $this->last_query();die;
        $org_client     = $this->getOrgClient($orgclients, $search_value);
        $ind_client     = $this->getIndClient($indclients, $search_value);
        $client_details = array_merge($org_client, $ind_client); 

        /*========================Short By Create Time Portion==============================*/
        if (isset($client_details) && count($client_details) > 0) {
            foreach ($client_details as $value) {
                $client_name[] = strtolower($value['client_name']);
            }
            array_multisort($client_name, SORT_ASC, $client_details);
        }
        /*=======================Short By Create Time Portion===============================*/

        return $client_details;
        exit();
    }

    public function get_all_ind_clients()
    {
        $client_details = array();
        $clients = array();

        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];

        $client_ids = Client::whereIn('user_id', $groupUserId)->where('is_deleted', '=',
            "N")->where("is_archive", "=", "N")->where("type", "=", "ind")->select("client_id")->
            get();
        //echo $this->last_query();die;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $key => $client_id) {
                $clients[$key]['client_id'] = $client_id->client_id;
            }
        }

        $client_details = $this->getIndClient($clients, "");
        /*========================Short By Client Name Portion==============================*/
        if (isset($client_details) && count($client_details) > 0) {
            foreach ($client_details as $value) {
                $client_name[] = strtolower($value['client_name']);
            }
            array_multisort($client_name, SORT_ASC, $client_details);
        }

        //print_r($client_details);die;
        /*=======================Short By Client Name Portion===============================*/

        return $client_details;
        exit();
    }

    public function search_all_client()
    {
        $client_details = array();
        $clients = array();

        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = $admin_s['group_users'];

        $search_value = Input::get("search_value");
        $client_ids = Client::whereIn('user_id', $groupUserId)->where('is_deleted', '=',
            "N")->where("type", "!=", "chd")->select("client_id")->get();
        //echo $this->last_query();die;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $key => $client_id) {
                $clients[$key]['client_id'] = $client_id->client_id;
            }
        }
        //echo $this->last_query();die;
        $org_client = $this->getOrgClient($clients, $search_value);
        $ind_client = $this->getIndClient($clients, $search_value);
        //$chd_client = $this->getChdClient($clients, $search_value);
        $client_details = array_merge($org_client, $ind_client); //print_r($client_details);die;
        //$client_details = $this->getUniqueArray($client_details);

        echo json_encode($client_details);
        exit();
    }

    function getUniqueArray($data)
    {
        $data1 = array();
        $data1 = $data;
        for ($q = 0; $q < count($data); $q++) {
            for ($p = 0; $p < count($data1); $p++) {
                if ($data[$q]["client_name"] != $data1[$p]["client_name"]) {
                    $data1[$p]["client_id"] = $data[$q]["client_id"];
                    $data1[$p]["client_name"] = $data[$q]["client_name"];
                }
            }
        }
        $data1 = array_values(array_map("unserialize", array_unique(array_map("serialize",
            $data1))));
        return $data1;
    }

    function getOrgClient($client_ids, $search_value)
    {
      $clients = array();
      $client_name = StepsFieldsClient::whereIn('client_id', $client_ids)->where('field_name', '=', 'business_name')->select("field_value", "client_id")->get();

      if (isset($client_name) && count($client_name) > 0) {
        foreach ($client_name as $key => $name) {
          $clients[$key]['client_id']     = $name->client_id;
          $clients[$key]['client_name']   = trim($name->field_value);
          $clients[$key]['client_type']   = 'org';
        }
      }
      //echo $this->last_query();die;
      return $clients;
    }
    function getIndClient($client_ids, $search_value)
    {
        $clients = array();
        //$client_name = StepsFieldsClient::where("field_value", "like", '%' . $search_value . '%')->where('field_name', '=', 'client_name')->whereIn('client_id', $client_ids)->select("field_value", "client_id")->get();
        $client_name = StepsFieldsClient::whereIn('client_id', $client_ids)->where('field_name', '=', 'client_name')->select("field_value", "client_id")->get();

        if (isset($client_name) && count($client_name) > 0) {
            foreach ($client_name as $key => $name) {
                $clients[$key]['client_id']     = $name->client_id;
                $clients[$key]['client_name']   = trim($name->field_value);
                $clients[$key]['client_type']   = 'ind';
            }
        }
        //echo $this->last_query();die;
        return $clients;
    }

    /*public function search_all_client() {
    $client_details = array();
    $admin_s = Session::get('admin_details');
    $user_id = $admin_s['id'];
    $groupUserId = $admin_s['group_users'];
    
    $search_value = Input::get("search_value");
    $client_ids = Client::whereIn('user_id', $groupUserId)->select("client_id", "type")->get();

    $i = 0;
    foreach ($client_ids as $client_id) {
    if ($client_id->type == "org") {
    $client_name = StepsFieldsClient::where("field_value", "like", '%' . $search_value . '%')->where('field_name', '=', 'business_name')->where('client_id', '=', $client_id->client_id)->select("field_value")->first();
    //$field_name = 'business_name';
    } else {
    //$field_name = 'fname';
    $client_name = StepsFieldsClient::where("field_value", "like", '%' . $search_value . '%')->where('field_name', '=', 'fname')->orwhere('field_name', '=', 'mname')->orwhere('field_name', '=', 'lname')->where('client_id', '=', $client_id->client_id)->select("field_value")->get();
    }
    
    //echo $this->last_query();die;
    if (isset($client_name) && count($client_name) > 0) {
    $client_details[$i]['client_id'] = $client_id->client_id;
    if ($client_id->type == "org") {die("lll");
    $client_details[$i]['client_name'] = $client_name['field_value'];
    }else{
    $name = "";
    foreach($client_name as $value){
    $name.=$value->field_value." ";
    }
    $client_details[$i]['client_name'] = trim($name);
    }
    
    $i++;
    }

    //echo $this->last_query();
    }

    echo json_encode($client_details);
    exit();
    }*/

    public function insert_organisation_client()
    {  
      $postData     = Input::all();

      $corres_cont_name = $postData['corres_cont_name'];

      $data         = array();
      $arrData      = array();
      $admin_s      = Session::get('admin_details');
      $user_id      = $admin_s['id'];
      $user_type    = $admin_s['user_type'];
      $groupUserId  = $admin_s['group_users'];

      if (isset($postData['client_id']) && $postData['client_id'] == "new") {
        $client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'org'));
      } else {
        $client_id = $postData['client_id'];
        Client::where("client_id", $client_id)->update(array(
            "is_deleted" => "N",
            'type' => 'org',
            'is_relation_add' => 'N'));

        /* =============== Store Updating data ===================== */
        if (isset($user_type) && $user_type == "C") {
          $postData['added_from'] = 'client_portal';
        }else{
          $postData['added_from'] = 'main_portal';
        }
        StepsFieldsClient::storeUpdatingOrgData($postData);
        /* =============== Store Updating data ===================== */

        StepsFieldsClient::where("client_id", $client_id)->delete();
        //ClientRelationship::where("client_id", "=", $client_id)->delete();
      }

      //#############BUSINESS INFORMATION START###################//
      $step_id = 1;
      if (!empty($postData['client_code'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'client_code', $postData['client_code']);
      }
      if (!empty($postData['business_type'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'business_type',
              $postData['business_type']);
      }
      if (!empty($postData['display_in_ch'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'display_in_ch',
              'Y');
      } else {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'display_in_ch',
              'N');
      }
      if (!empty($postData['business_name'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'business_name',
              $postData['business_name']);
      }
      if (!empty($postData['registration_number'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id,
              'registration_number', $postData['registration_number']);
      }
      if (!empty($postData['incorporation_date'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id,
              'incorporation_date', $postData['incorporation_date']);
      }
      if (!empty($postData['registered_in'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'registered_in',
              $postData['registered_in']);
      }
      if (!empty($postData['business_desc'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'business_desc',
              $postData['business_desc']);
      }

      if (isset($postData['ann_ret_check']) && $postData['ann_ret_check'] != "") {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ann_ret_check',
          $postData['ann_ret_check']);

        if (!empty($postData['made_up_date'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'made_up_date',
                $postData['made_up_date']);
        }
        if (!empty($postData['next_ret_due'])) {
          $arrData[] = $this->save_client( $user_id, $client_id, $step_id, 'next_ret_due',
                date('Y-m-d', strtotime($postData['next_ret_due'])) );
        }
        if (!empty($postData['ch_auth_code'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ch_auth_code',
                $postData['ch_auth_code']);
        }
      }

      if(isset($postData['yearend_acc_check']) && $postData['yearend_acc_check']!= "") {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id,
            'yearend_acc_check', $postData['yearend_acc_check']);

        if (!empty($postData['acc_ref_day'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'acc_ref_day', $postData['acc_ref_day']);
        }
        if (!empty($postData['acc_ref_month'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'acc_ref_month',
                $postData['acc_ref_month']);
        }
        if (!empty($postData['last_acc_madeup_date'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                'last_acc_madeup_date', $postData['last_acc_madeup_date']);
        }
        if (!empty($postData['next_acc_due'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'next_acc_due',
                date('Y-m-d', strtotime($postData['next_acc_due']) ) );
        }
        if (!empty($postData['next_made_up_to'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'next_made_up_to',
                date('Y-m-d', strtotime($postData['next_made_up_to']) ) );
        }
      }
        //#############BUSINESS INFORMATION END###################//

      //#############TAX INFORMATION START###################//
      $step_id = 2;
      if (isset($postData['reg_for_vat']) && $postData['reg_for_vat'] != "") {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'reg_for_vat', $postData['reg_for_vat']);

          if (!empty($postData['effective_date'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'effective_date',
                  $postData['effective_date']);
          }
          if (!empty($postData['vat_number'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'vat_number', $postData['vat_number']);
          }
          if (!empty($postData['vat_scheme_type'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                  'vat_scheme_type', $postData['vat_scheme_type']);
          }
          if (!empty($postData['vat_scheme'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'vat_scheme', $postData['vat_scheme']);
          }
          if (!empty($postData['ret_frequency'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ret_frequency',
                  $postData['ret_frequency']);
          }
          if (!empty($postData['vat_stagger'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'vat_stagger', $postData['vat_stagger']);
          }
      }

      if (!empty($postData['ec_scale_list'])) {
        $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ec_scale_list',
          $postData['ec_scale_list']);
        if (!empty($postData['ecsl_freq'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'ecsl_freq', $postData['ecsl_freq']);
        }
      }

        if (!empty($postData['tax_div'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_div', $postData['tax_div']);

            if (isset($postData['tax_reference'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_reference',
                    $postData['tax_reference']);
            }
            
            if (isset($postData['utrsamllbox'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'utrsamllbox',
                    $postData['utrsamllbox']);
            }
            if (!empty($postData['tax_reference_type'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                    'tax_reference_type', $postData['tax_reference_type']);
            }
            if (!empty($postData['other_office_id'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                    'other_office_id', $postData['other_office_id']);
            }
            if (!empty($postData['tax_office_id'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_office_id',
                    $postData['tax_office_id']);
            }
            if (!empty($postData['tax_address'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_address', $postData['tax_address']);
            }
            if (!empty($postData['tax_zipcode'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_zipcode', $postData['tax_zipcode']);
            }
            if (!empty($postData['tax_telephone'])) {
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'tax_telephone',
                    $postData['tax_telephone']);
            }
        }

        if (!empty($postData['paye_reg'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'paye_reg', $postData['paye_reg']);

            if (!empty($postData['cis_registered'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'cis_registered',
                    $postData['cis_registered']);
            }

            if (!empty($postData['acc_office_ref'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'acc_office_ref',
                    $postData['acc_office_ref']);
            }
            
            
            if (!empty($postData['samllpayeref'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'samllpayeref',
                    $postData['samllpayeref']);
            }
             if (!empty($postData['samllaccofcref'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'samllaccofcref',
                    $postData['samllaccofcref']);
            }
            
            if (!empty($postData['paye_reference'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'paye_reference',
                    $postData['paye_reference']);
            }
            if (!empty($postData['paye_district'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'paye_district',
                    $postData['paye_district']);
            }
            if (!empty($postData['employer_office'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                    'employer_office', $postData['employer_office']);
            }
            if (!empty($postData['employer_postcode'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                    'employer_postcode', $postData['employer_postcode']);
            }
            if (!empty($postData['employer_telephone'])) {
              $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                    'employer_telephone', $postData['employer_telephone']);
            }
        }

        if (!empty($postData['hmrc_login_details'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                'hmrc_login_details', $postData['hmrc_login_details']);
        }

        //#############TAX INFORMATION END###################//
        //print_r($arrData);die;
        //#############CONTACT INFORMATION START###################//
        $step_id = 3;
        
        if (!empty($postData['contacttelephone'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'contacttelephone',
                $postData['contacttelephone']);
        }

        if(!empty($postData['primary_contacts'])){
          $person = $postData['primary_contacts'];
          $contPerson = explode('_', $person);//echo $contPerson[0];die;

          $arrData[]=Client::save_client($user_id, $client_id,3,'primary_contacts',$person);
          $arrData[]=Client::save_client($user_id, $client_id, 3,'contact_person',$contPerson[0]);
          $arrData[]=Client::save_client($user_id, $client_id, 3,'person_type',$contPerson[1]);
          if($contPerson[1] == 'R'){
            $person_name  = Client::getClientNameByClientId($contPerson[0]);
          }
          if($contPerson[1] == 'C'){
            $person_name  = ContactAddress::getContactNameById($contPerson[0]);
          }
          $arrData[]    = Client::save_client($user_id, $client_id, 3, 'person_name', $person_name);

        }
        
        if (!empty($postData['contactmobile'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'contactmobile', $postData['contactmobile']);
        }

        if (!empty($postData['contactfax'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'contactfax', $postData['contactfax']);
        }
        
        if (!empty($postData['contactemail'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'contactemail', $postData['contactemail']);
        }
            
        if (!empty($postData['contactwebsite'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'contactwebsite',
                $postData['contactwebsite']);
        }
        
        if (isset($postData['cont_banker_addr']) && $postData['cont_banker_addr'] != "") {
        
          if (!empty($postData['bank_name'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_name', $postData['bank_name']);
          }
        
        if (!empty($postData['bank_short_code'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_short_code', $postData['bank_short_code']);
        }
        
        if (!empty($postData['bank_acc_no'])) {
          $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_acc_no', $postData['bank_acc_no']);
        }
            
            
        }
            
        $array = array( "trad", "reg", "corres", "banker", "oldacc", "auditors", "solicitors");
        foreach ($array as $key => $val) { //echo $postData[$val . '_address'];//die;

            if(isset($postData[$val . '_address']) && $postData[$val . '_address'] != ''){
                $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val.'_address', $postData[$val . '_address']);
            }

            if (isset($postData['cont_' . $val . '_addr']) && $postData['cont_' . $val .
                '_addr'] != "") {

                if(isset($postData['cont_' . $val . '_addr']) && $postData['cont_' . $val . '_addr'] != ''){
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'cont_' . $val .
                    '_addr', $postData['cont_' . $val . '_addr']);
                }

                if (isset($postData[$val . '_name_check']) && $postData[$val . '_name_check'] !=
                    "") {
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                        '_name_check', $postData[$val . '_name_check']);

                    if (!empty($postData[$val . '_cont_name'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_name', $postData[$val . '_cont_name']);
                    }
                    if (!empty($postData[$val . '_cont_tele_code'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_tele_code', $postData[$val . '_cont_tele_code']);
                    }
                    if (!empty($postData[$val . '_cont_telephone'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_telephone', $postData[$val . '_cont_telephone']);
                    }
                    if (!empty($postData[$val . '_cont_mobile_code'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_mobile_code', $postData[$val . '_cont_mobile_code']);
                    }
                    if (!empty($postData[$val . '_cont_mobile'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_mobile', $postData[$val . '_cont_mobile']);
                    }
                    if (!empty($postData[$val . '_cont_email'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_email', $postData[$val . '_cont_email']);
                    }
                    if (!empty($postData[$val . '_cont_website'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_website', $postData[$val . '_cont_website']);
                    }
                    if (!empty($postData[$val . '_cont_skype'])) {
                        $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                            '_cont_skype', $postData[$val . '_cont_skype']);
                    }

                }

                /*$ClntAddr['user_id']        = $user_id;
                $ClntAddr['address_type']   = $val;
                if (!empty($postData[$val . '_cont_addr_line1'])) {
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                        '_cont_addr_line1', $postData[$val . '_cont_addr_line1']);
                    $ClntAddr['address1'] = $postData[$val . '_cont_addr_line1'];
                }
                if (!empty($postData[$val . '_cont_addr_line2'])) {
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                        '_cont_addr_line2', $postData[$val . '_cont_addr_line2']);
                    $ClntAddr['address2'] = $postData[$val . '_cont_addr_line2'];
                }
                if (!empty($postData[$val . '_cont_city'])) {
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                        '_cont_city', $postData[$val . '_cont_city']);
                    $ClntAddr['city'] = $postData[$val . '_cont_city'];
                }
                if (!empty($postData[$val . '_cont_county'])) {
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                        '_cont_county', $postData[$val . '_cont_county']);
                    $ClntAddr['county'] = $postData[$val . '_cont_county'];
                }
                if (!empty($postData[$val . '_cont_postcode'])) {
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                        '_cont_postcode', $postData[$val . '_cont_postcode']);
                    $ClntAddr['postcode'] = $postData[$val . '_cont_postcode'];
                }
                if (!empty($postData[$val . '_cont_country'])) {
                    $arrData[] = $this->save_client($user_id, $client_id, $step_id, $val .
                        '_cont_country', $postData[$val . '_cont_country']);
                    $ClntAddr['country'] = $postData[$val . '_cont_country'];
                }*/


                //############# Address Section Start ###################//
                /*$checkaddr1     = substr($ClntAddr['address1'], 0, 7);
                $checkpost      = $ClntAddr['postcode'];
                $checkAddr      = ClientAddress::checkAddress($checkaddr1, $checkpost);
                if($checkAddr == '0'){
                    ClientAddress::insert($ClntAddr);
                }*/
                //############# Address Section End ###################//


            }
        }
        //echo '<pre>';print_r($arrData);die();
        //############# CONTACT INFORMATION END ###################//

        //############# RELATIONSHIP START ###################//
        if (!empty($postData['app_hidd_array'])) {
            $relData = array();
            $app_hidd_array = explode(",", $postData['app_hidd_array']); //print_r($app_hidd_array);
            foreach ($app_hidd_array as $row) {
                $rel_row = explode("mpm", $row);
                $rel_client = ClientRelationship::where("client_id", "=", $client_id)->where("relationship_type_id",
                    "=", $rel_row['1'])->where("appointment_with", "=", $rel_row['2'])->first();

                if (isset($rel_client) && count($rel_client) > 0) {
                    $relData['relationship_type_id'] = $rel_row['1'];
                    ClientRelationship::where("client_id", $client_id)->where("appointment_with",
                        $rel_row['2'])->update($relData);
                } else {
                    $relData['client_id'] = $client_id;
                    $relData['appointment_with'] = $rel_row['2'];
                    $relData['relationship_type_id'] = $rel_row['1'];
                    ClientRelationship::insert($relData);
                }
            }
            //ClientRelationship::insert($relData);

        }
        //#############RELATIONSHIP END ###################//

        //############# ACTING SECTION START ###################//
        if (!empty($postData['acting_hidd_array'])) {
            $actData = array();
            $acting_hidd_array = explode(",", $postData['acting_hidd_array']);
            foreach ($acting_hidd_array as $row) {
                $act_row = explode("mpm", $row);
                $actData[] = array(
                    'user_id' => $user_id,
                    'client_id' => $client_id,
                    'acting_client_id' => $act_row['1']);

                $update_data['is_relation_add'] = "N";
                $data_client = Client::where("client_id", "=", $act_row['1'])->first();
                if (isset($data_client['chd_type']) && $data_client['chd_type'] == "ind") {
                    $update_data['type'] = "ind";
                }
                if (isset($data_client['chd_type']) && $data_client['chd_type'] == "org") {
                    $update_data['type'] = "org";
                }
                Client::where("client_id", $act_row['1'])->update($update_data);
            }
            ClientActing::insert($actData);

        }
        //############# ACTING SECTION END ###################//

        //############# OTHERS INFORMATION START ###################//
        $step_id = 5;
        if (!empty($postData['bank_name'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_name', $postData['bank_name']);
        }
        if (!empty($postData['bank_short_code'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                'bank_short_code', $postData['bank_short_code']);
        }
        if (!empty($postData['bank_acc_no'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id, 'bank_acc_no', $postData['bank_acc_no']);
        } 
        if (!empty($postData['bank_mark_source'])) {
            $arrData[] = $this->save_client($user_id, $client_id, $step_id,
                'bank_mark_source', $postData['bank_mark_source']);
        }
        //############# OTHERS INFORMATION END ###################//

        //############# SERVICES START ###################//
        /*if (!empty($postData['serv_hidd_array'])) {
        $relData = array();
        $serv_hidd_array = explode(",", $postData['serv_hidd_array']);
        foreach ($serv_hidd_array as $row) {
        $rel_row = explode("mpm", $row);
        $relData[] = array(
        'client_id' => $client_id,
        'service_id' => $rel_row['0'],
        'staff_id' => $rel_row['1'],
        );
        }
        ClientService::insert($relData);
        }*/
        ClientService::where("client_id", $client_id)->delete();
        if (isset($postData['other_services']) && count($postData['other_services']) > 0) {
            //$arrData[] = $this->save_client($user_id, $client_id, $step_id, 'other_services', serialize($postData['other_services']));
            $relData = array();
            foreach ($postData['other_services'] as $service_id) {
                $servData['client_id'] = $client_id;
                $servData['service_id'] = $service_id;
                ClientService::insert($servData);
            }
        }
        //############# SERVICES END ###################//


        //################## USER ADDED FIELD START ###############//
      $field_added = StepsFieldsAddedUser::where("client_type", "org")->whereIn("user_id",
          $groupUserId)->get();
      //echo $this->last_query();die;
      if (isset($field_added) && count($field_added) > 0) {
        foreach ($field_added as $key => $value) {
          $field_name = strtolower($value->field_name);
          if (isset($postData[$field_name]) && $postData[$field_name] != "") {
            $arrData[] = $this->save_client($user_id, $client_id, $value->step_id, $field_name,
                  $postData[$field_name]);
          }
        }
      }
      //################## USER ADDED FIELD END ###############//

      StepsFieldsClient::insert($arrData);

      if (isset($user_type) && $user_type == "C") {
        return Redirect::to('/client-portal');
        //return Redirect::to('/invitedclient-dashboard');
      } else {
        return Redirect::to('/organisation-clients');
      }

    }

    public function save_client($user_id, $client_id, $step_id, $field_name, $field_value)
    {
      $data = array();
      $data['user_id']      = $user_id;
      $data['client_id']    = $client_id;
      $data['step_id']      = $step_id;
      $data['field_name']   = $field_name;
      $data['field_value']  = $field_value;
      return $data;
      //OrganisationClient::insert($data);
    }

    public function show_new_table()
    {
        $data = array();
        $postData = Input::all();

        $four = $postData['four'];
        $six = $postData['six'];
        $seven = $postData['seven'];
        $eight = $postData['eight'];
        $nine = $postData['nine'];
        $ten = $postData['ten'];

        $client_data = array();

        $admin_s = Session::get('admin_details'); // session
        $user_id = $admin_s['id']; //session user id
        //$user_id = 1;
        $client_ids = Client::where('is_deleted', '=', "N")->where("type", "=", "ind")->
            where('user_id', '=', $user_id)->select("client_id")->get();
        $i = 0;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();
                //$client_data[$i]['client_id'] 	= $client_id->client_id;

                $appointment_name = ClientRelationship::where('client_id', '=', $client_id->
                    client_id)->select("appointment_with")->first();
                //echo $this->last_query();//die;
                $relation_name = StepsFieldsClient::where('client_id', '=', $appointment_name['appointment_with'])->
                    where('field_name', '=', "business_name")->select("field_value")->first();

                if (isset($client_details) && count($client_details) > 0) {
                    foreach ($client_details as $client_row) {

                        //get staff name start
                        if (!empty($client_row['field_name']) && $client_row['field_name'] ==
                            "resp_staff") {
                            $staff_name = User::where('user_id', '=', $client_row->field_value)->select("fname",
                                "lname")->first();
                            //echo $this->last_query();die;
                            $client_data[$i]['staff_name'] = $staff_name['fname'] . " " . $staff_name['lname'];
                        }
                        //get staff name end

                        //get business name start
                        if (!empty($relation_name['field_value']) && in_array("business_name", $postData)) {
                            $client_data[$i]['business_name'] = $relation_name['field_value'];
                        }
                        //get business name end

                        //get client name start
                        if (!empty($client_row['field_name']) && $client_row['field_name'] == "name") {
                            $client_data[$i][$client_row['field_name']] = $client_row->field_value;
                        }
                        //get client name end

                        if ($client_row['field_name'] == $four || $client_row['field_name'] == $six || $client_row['field_name'] ==
                            $seven || $client_row['field_name'] == $eight || $client_row['field_name'] == $nine ||
                            $client_row['field_name'] == $ten) {
                            $client_data[$i][$client_row['field_name']] = $client_row->field_value;

                            if (($client_row['field_name'] == "acting") && in_array("acting", $postData)) {
                                $client_data[$i]['acting'] = "Yes";
                            }

                        }
                    }
                }
                $i++;
            }
        }

        //print_r($client_data);die;
        echo json_encode($client_data);
        exit();
    }

    public function search_individual_client()
    {
        $data = array();
        $admin_s = Session::get('admin_details'); // session
        $user_id = $admin_s['id']; //session user id
        //$user_id = 1;
        $postData = Input::all();
        $search_value = $postData['search_value'];

        $client_ids = Client::where('is_deleted', '=', "N")->where("type", "=", "ind")->
            where('user_id', '=', $user_id)->select("client_id")->get();
        //echo $this->last_query();die;
        $i = 0;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();
                //echo $this->last_query();die;
                //$client_data[$i]['client_id'] 	= $client_id->client_id;

                $appointment_name = ClientRelationship::where('client_id', '=', $client_id->
                    client_id)->select("appointment_with")->first();
                //echo $this->last_query();//die;
                $relation_name = StepsFieldsClient::where('client_id', '=', $appointment_name['appointment_with'])->
                    where('field_name', '=', "business_name")->select("field_value")->first();

                if (isset($client_details) && count($client_details) > 0) {
                    foreach ($client_details as $client_row) {
                        //get staff name start
                        if (!empty($client_row['field_name']) && $client_row['field_name'] ==
                            "resp_staff") {
                            $staff_name = User::where('user_id', '=', $client_row->field_value)->select("fname",
                                "lname")->first();
                            //echo $this->last_query();die;
                            $client_data[$i]['staff_name'] = strtoupper(substr($staff_name['fname'], 0, 1)) .
                                " " . strtoupper(substr($staff_name['lname'], 0, 1));
                        } else {
                            $client_data[$i]['staff_name'] = "";
                        }
                        //get staff name end

                        //get business name start
                        if (!empty($relation_name['field_value'])) {
                            $client_data[$i]['business_name'] = $relation_name['field_value'];
                        }
                        //get business name end

                        //get Acting start
                        if (!empty($client_row['field_name']) && $client_row['field_name'] == "acting") {
                            $client_data[$i]['acting'] = "Yes";
                        } else {
                            $client_data[$i]['acting'] = "No";
                        }
                        //get business name end

                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "business_type") {
                            $business_type = OrganisationType::where('organisation_id', '=', $client_row->
                                field_value)->first();
                            $client_data[$i][$client_row['field_name']] = $business_type['name'];
                        } else {
                            $client_data[$i][$client_row['field_name']] = $client_row->field_value;
                        }

                    }

                    $i++;
                }

            }
        }

        foreach ($client_data as $key => $value) {
            if (!in_array_field($search_value, $client_data['name'], $client_data)) {
                unset($client_data[$key]);
            }
        }

        print_r($client_data);
        die;
        echo json_encode($client_data);
        exit();
    }

    /*
    public function edit_client($client_id){
    
    //print_r($clientid);die('j');
    
    //$data['title'] = "Client Edit";
    //  $data['heading'] = "Client USER";
    
    $client_details = StepsFieldsClient::where('client_id', '=', $client_id)->select("field_id", "field_name", "field_value")->get();
    
    
    
    
    
    //$data['clientinfo'] = StepsFieldsClient::select('*')->where('client_id', '=', $client_id)->get();
    echo "<pre>";print_r($client_details);
    die('edit');
    }*/

    public function get_responsible_staff()
    {
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];

        $resp_staff = User::whereIn("user_id", $groupUserId)->where("client_id", "=", 0)->
            select('fname', 'lname', 'user_id')->get();
        foreach ($resp_staff as $key => $value) {
            $data[$key]['user_id'] = $value->user_id;
            $data[$key]['fname'] = isset($value->fname) ? $value->fname : "";
            $data[$key]['lname'] = isset($value->lname) ? $value->lname : "";
            /*
            if(isset($value->client_id) && $value->client_id != 0){
            $text = $value->client_id."="."function";
            $details = App::make('ClientController')->client_details_by_client_id($text);
            //print_r($details);die;
            $data[$key]['fname'] 	= isset($details['client_details']['fname'])?$details['client_details']['fname']:"";
            $data[$key]['lname'] 	= isset($details['client_details']['lname'])?$details['client_details']['lname']:"";
            }else{
            $data[$key]['fname'] 	= $value->fname;
            $data[$key]['lname'] 	= $value->lname;
            }*/

        }

        return $data;
    }

    public function indonboard()
    {
        $client_data = array();
        $data['heading'] = "Individual On Boarding Clients List";
        $data['title'] = "Individual On Boarding Clients List";
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

        if (empty($user_id)) {
            return Redirect::to('/');
        }

        $client_ids = Client::where("is_deleted", "=", "N")->where("type", "=", "ind")->
            where("is_archive", "=", "N")->where("is_relation_add", "=", "N")->where("is_onboard",
            "=", "Y")->whereIn("user_id", $groupUserId)->select("client_id", "created",
            "show_archive")->get();
        //echo $this->last_query();die;
        $i = 0;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();

                $client_data[$i]['client_id'] = $client_id->client_id;
                $client_data[$i]['show_archive'] = $client_id->show_archive;
                $client_data[$i]['created'] = $client_id->created;

                //$appointment_name = ClientRelationship::where('client_id', '=', $client_id->client_id)->select("appointment_with")->first();
                //echo $this->last_query();//die;
                //$relation_name = StepsFieldsClient::where('client_id', '=', $appointment_name['appointment_with'])->where('field_name', '=', "business_name")->select("field_value")->first();

                if (isset($client_details) && count($client_details) > 0) {
                    $address = "";
                    foreach ($client_details as $client_row) {
                        //get staff name start
                        if (!empty($client_row['field_name']) && $client_row['field_name'] ==
                            "resp_staff") {
                            $staff_name = User::where('user_id', '=', $client_row->field_value)->select("fname",
                                "lname")->first();
                            //echo $this->last_query();die;
                            $client_data[$i]['staff_name'] = strtoupper(substr($staff_name['fname'], 0, 1)) .
                                " " . strtoupper(substr($staff_name['lname'], 0, 1));
                        }
                        //get staff name end

                        //get business name start
                        /*if (!empty($relation_name['field_value'])) {
                        $client_data[$i]['business_name'] = $relation_name['field_value'];
                        }*/
                        $client_data[$i]['relationship'] = Common::get_relationship_client($client_id->
                            client_id);
                        //get business name end


                        //get residencial address
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_addr_line1") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_addr_line2") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] == "res_city") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_county") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_postcode") {
                            $address .= $client_row->field_value . ", ";
                        }


                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "business_type") {
                            $business_type = OrganisationType::where('organisation_id', '=', $client_row->
                                field_value)->first();
                            $client_data[$i][$client_row['field_name']] = $business_type['name'];
                        } else {
                            $client_data[$i][$client_row['field_name']] = $client_row->field_value;
                        }

                    }

                    $client_data[$i]['address'] = substr($address, 0, -2);
                    $i++;
                }


            }
        }
        //print_r($client_data);die;
        $data['client_details'] = $client_data;

        $data['client_fields'] = ClientField::where("field_type", "=", "ind")->get();
        //die;$data['allClients'] = $this->get_all_clients();
        $data['old_postion_types'] = Indchecklist::whereIn("user_id", $groupUserId)->
            where("status", "=", "old")->orderBy("name")->get();
        $data['new_postion_types'] = Indchecklist::whereIn("user_id", $groupUserId)->
            where("status", "=", "new")->orderBy("name")->get();
        //print_r($data['client_details']);die;
        return View::make('home.individual.indonboard', $data);


    }

    public function orgpdf($search, $type)
    {

       // echo $search;
        //echo $type;die();
        $client_data        = array();
        $temp = $newvardump = array();
        $final_arr          = array();
        //echo $search; die;
        $client_data        = array();
        $client_details     = array();
        $data               = array();
        $t                  = time();
        $time               = date("Y-m-d H:i:s", $t);
        $pieces             = explode(" ", $time);
        $data['cdate']      = $pieces[0];
        $data['ctime']      = $pieces[1];
        $today              = date("j F  Y");
        $data['today']      = $today;
        $time               = date(" G:i:s ");
        $data['time']       = $time;
        $data['heading'] = "CLIENT LIST - ORGANISATIONS";
        $data['title'] = "Organisation Clients List";
        $admin_s = Session::get('admin_details'); // session
        $user_id = $admin_s['id']; //session user id
        $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

        if ($search == "NONE") {
            $client_details = Client::getAllOrgClientDetails();
            //echo '<pre>';print_r($client_details);die();
        } else {
            $searchvalue = strtolower($search);
            $client_details = Client::getAllOrgClientDetails();
          // echo '<pre>';print_r($client_details);die;
            
            if (isset($client_details) && count($client_details) > 0) {

                foreach ($client_details as $key => $value) {
                    $filterdata = array();
                   
                   
                    if (isset($value['client_id']) && $value['client_id'] != "") {
                        $filterdata['client_id'] = $value['client_id'];
                    }
                    if (isset($value['business_type']) && $value['business_type'] != "") {
                        $filterdata['business_type'] = $value['business_type'];
                    }
                    
                    if (isset($value['registration_number']) && $value['registration_number'] != "") {
                        $filterdata['registration_number'] = $value['registration_number'];
                    }
                    if (isset($value['business_name']) && $value['business_name'] != "") {
                        $filterdata['business_name'] = $value['business_name'];
                    }
                    
                    if (isset($value['last_acc_madeup_date']) && $value['last_acc_madeup_date'] != "") {
                        $filterdata['last_acc_madeup_date'] = $value['last_acc_madeup_date'];
                    }
                    
                    if (isset($value['acc_ref_day']) && $value['acc_ref_day'] != "") {
                        $filterdata['acc_ref_day'] = $value['acc_ref_day'];
                    }
                    
                    if (isset($value['ref_month']) && $value['ref_month'] != "") {
                        $filterdata['ref_month'] = $value['ref_month'];
                    }
                    
                    if (isset($value['deadacc_count']) && $value['deadacc_count'] != "") {
                        $filterdata['deadacc_count'] = $value['deadacc_count'];
                    }
                    if (isset($value['deadret_count']) && $value['deadret_count'] != "") {
                        $filterdata['deadret_count'] = $value['deadret_count'];
                    }
                    if (isset($value['tax_reference']) && $value['tax_reference'] != "") {
                        $filterdata['tax_reference'] = $value['tax_reference'];
                    }
                    
                    if (isset($value['vat_number']) && $value['vat_number'] != "") {
                        $filterdata['vat_number'] = $value['vat_number'];
                    }
                    
                     if (isset($value['vat_stagger']) && $value['vat_stagger'] != "") {
                        $filterdata['vat_stagger'] = $value['vat_stagger'];
                    }
                     if (isset($value['corres_address'])) {
                        $filterdata['corres_address'] = $value['corres_address']['fullAddress'];
                    }
                    
                    
                    if (isset($value['year_end']) && $value['year_end'] != "") {
                        $filterdata['year_end'] = $value['year_end'];
                    }
                    
                    
                   // echo '<pre>';print_r($filterdata);//die();
                    
                    $value = $this->arraytolower($value);
                   
                    $temp = $this->search_array($filterdata, $searchvalue, $final_arr);

                    if (isset($temp) && count($temp) > 0) {
                        $newvardump[$key] = $client_details[$key];
                    }
                }
            }
            $client_details = array_values($newvardump);
        }
        
        
        if (isset($client_details) && count($client_details) > 0) {
            foreach ($client_details as $value) {
                $client_name[] = strtolower($value['business_name']); //Creates $volume, $edition, $name and $type arrays.
            }
            array_multisort($client_name, SORT_ASC, $client_details);
        }
        
        

        $data['client_details'] = $client_details;
       // echo '<pre>';print_r($data['client_details']);die;
        $data['client_fields'] = ClientField::where("field_type", "=", "org")->get();

        //echo '<pre>';print_r($data['client_details']);die;

        //return View::make('home.organisation.organisation_client', $data);
        //	$data['user_lists'] = User::whereIn("user_id", $groupUserId)->get();
        if ($type == "pdf") {

            $pdf = PDF::loadView('home/organisation/orgpdf', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
            return $pdf->download('Organisation_clients_list.pdf');
            
        }
        elseif ($type == "excel") {
            /*ob_end_clean();
            ob_start();*/
            $viewToLoad = 'home/organisation/orgexcel';
            ///////////  Start Generate and store excel file ////////////////////////////
            Excel::create('Organisation_clients_list', function ($excel) use ($data, $viewToLoad)
            {
                $excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad)
                {
                    $sheet->loadView($viewToLoad)->with($data); }
                )->save(); }
            );
            $filepath   = storage_path() . '/exports/Organisation_clients_list.xls';//echo $filepath;die;
            $fileName   = 'Organisation_clients_list.xls';
            $headers    = array('Content-Type: application/vnd.ms-excel', );

    
            return Response::download($filepath, $fileName, $headers);

            exit;
        }
    }

    function download_orgexcel()
    {


        $client_data = array();
        $data['heading'] = "CLIENT LIST - ORGANISATIONS";
        $data['title'] = "Organisation Clients List";
        $admin_s = Session::get('admin_details'); // session
        $user_id = $admin_s['id']; //session user id
        $t = time();
        $time = date("Y-m-d H:i:s", $t);
        $pieces = explode(" ", $time);
        $data['cdate'] = $pieces[0];

        $data['ctime'] = $pieces[1];

        $today = date("j F  Y");
        $data['today'] = $today;

        $time = date(" G:i:s ");
        $data['time'] = $time;
        $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

        if (empty($user_id)) {
            return Redirect::to('/');
        }

        $client_ids = Client::where("is_deleted", "=", "N")->where("type", "=", "org")->
            where("is_archive", "=", "N")->where("is_relation_add", "=", "N")->whereIn("user_id",
            $groupUserId)->select("client_id", "created", "show_archive")->orderBy("client_id",
            "DESC")->get();
        //echo'<pre>'; print_r($client_ids);die();

        //echo $this->last_query();die;
        $i = 0;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();

                //echo '<pre>';print_r($client_details);die;


                $client_data[$i]['client_id'] = $client_id->client_id;
                $client_data[$i]['show_archive'] = $client_id->show_archive;
                //$client_data[$i]['created'] 	= $client_id->created;
                $appointment_name = ClientRelationship::where('client_id', '=', $client_id->
                    client_id)->select("appointment_with")->first();
                //echo $this->last_query();//die;
                $relation_name = StepsFieldsClient::where('client_id', '=', $appointment_name['appointment_with'])->
                    where('field_name', '=', "name")->select("field_value")->first();

                if (isset($client_details) && count($client_details) > 0) {
                    $corres_address = "";
                    foreach ($client_details as $client_row) {
                        //get business name start
                        if (!empty($relation_name['field_value'])) {
                            $client_data[$i]['staff_name'] = $relation_name['field_value'];
                        }

                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "next_acc_due") {
                            $client_data[$i]['deadacc_count'] = $this->getDayCount($client_row->field_value);
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "next_ret_due") {
                            $client_data[$i]['deadret_count'] = $this->getDayCount($client_row->field_value);
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "acc_ref_month") {
                            $client_data[$i]['ref_month'] = App::make('ChdataController')->
                                getMonthNameShort($client_row->field_value);
                        }

                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "business_type") {
                            $business_type = OrganisationType::where('organisation_id', '=', $client_row->
                                field_value)->first();
                            $client_data[$i][$client_row['field_name']] = $business_type['name'];
                        } else {
                            $client_data[$i][$client_row['field_name']] = $client_row->field_value;
                        }

                        // ############### GET CORRESPONDENSE ADDRESS START ################## //
                        if (isset($client_row->field_name) && $client_row->field_name ==
                            "corres_cont_addr_line1") {
                            $corres_address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row->field_name) && $client_row->field_name ==
                            "corres_cont_addr_line2") {
                            $corres_address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row->field_name) && $client_row->field_name ==
                            "corres_cont_county") {
                            $corres_address .= $client_row->field_value . ", ";
                        }
                        // ############### GET CORRESPONDENSE ADDRESS END ################## //
                    }
                    $client_data[$i]['corres_address'] = substr($corres_address, 0, -2);

                    $i++;
                }

                //echo $this->last_query();die;
            }
        }
        $data['client_details'] = $client_data;

        $data['client_fields'] = ClientField::where("field_type", "=", "org")->get();


        $viewToLoad = 'home/organisation/orgexcel';
        ///////////  Start Generate and store excel file ////////////////////////////
        Excel::create('OrgList', function ($excel)use ($data, $viewToLoad)
        {

            $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
            {
                $sheet->loadView($viewToLoad)->with($data); }
            )->save(); }
        );

        //


        $filepath = storage_path() . '/exports/OrgList.xls';
        $fileName = 'OrgList.xls';
        $headers = array('Content-Type: application/vnd.ms-excel', );

        return Response::download($filepath, $fileName, $headers);
        exit;
    }


    public function indpdf($search, $type)
    {


        // echo $type;die();

        $temp = $newvardump = array();
        $final_arr = array();
        //echo $search; die;
        $client_data = array();
        $client_details = array();
        $data = array();
        $t = time();
        $time = date("Y-m-d H:i:s", $t);
        $pieces = explode(" ", $time);
        $data['cdate'] = $pieces[0];
        $data['ctime'] = $pieces[1];
        $today = date("j F  Y");
        $data['today'] = $today;
        $time = date(" G:i:s ");
        $data['time'] = $time;
        $data['heading'] = "";
        $data['title'] = "Individual Clients List";
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

        if (empty($user_id)) {
            return Redirect::to('/');
        }

        if ($search == "NONE") {
            $client_details = Client::getAllIndClientDetails();
        } else {
            $searchvalue = strtolower($search);
            $client_details = Client::getAllIndClientDetails();
            //echo '<pre>';print_r($client_details);die;
            
            if (isset($client_details) && count($client_details) > 0) {

                foreach ($client_details as $key => $value) {
                    $filterdata = array();
                    if (isset($value['fname']) && $value['fname'] != "") {
                        $filterdata['fname'] = $value['fname'];
                    }

                    if (isset($value['mname']) && $value['mname'] != "") {
                        $filterdata['mname'] = $value['mname'];
                    }
                    if (isset($value['lname']) && $value['lname'] != "") {
                        $filterdata['lname'] = $value['lname'];
                    }

                    if (isset($value['dob']) && $value['dob'] != "") {
                        $filterdata['dob'] = $value['dob'];
                    }
                    if (isset($value['ni_number']) && $value['ni_number'] != "") {
                        $filterdata['ni_number'] = $value['ni_number'];
                    }

                    if (isset($value['tax_reference']) && $value['tax_reference'] != "") {
                        $filterdata['tax_reference'] = $value['tax_reference'];
                    }
                    if (isset($value['res_addr_line1']) && $value['res_addr_line1'] != "") {
                        $filterdata['res_addr_line1'] = $value['res_addr_line1'];
                    }
                    if (isset($value['res_addr_line2']) && $value['res_addr_line2'] != "") {
                        $filterdata['res_addr_line2'] = $value['res_addr_line2'];
                    }
                    if (isset($value['res_city']) && $value['res_city'] != "") {
                        $filterdata['res_city'] = $value['res_city'];
                    }
                    if (isset($value['res_county']) && $value['res_county'] != "") {
                        $filterdata['res_county'] = $value['res_county'];
                    }

                    if (isset($value['res_postcode']) && $value['res_postcode'] != "") {
                        $filterdata['res_postcode'] = $value['res_postcode'];
                    }

                    if (isset($value['gender']) && $value['gender'] != "") {
                        $filterdata['gender'] = $value['gender'];
                    }
                    if (isset($value['client_id']) && $value['client_id'] != "") {
                        $filterdata['client_id'] = $value['client_id'];
                    }
                    
                    
                    
                   
                    if (isset($value['relationship'][0]) && $value['relationship'][0] != "") {
                      
                     //echo'<pre>'; print_r($value['relationship'][0]);//die();
                     $filterdata['relationship1']=$value['relationship'][0]['name'];
                     
                      /*   foreach($value['relationship'] as $key=>$relation_row){
                            
                            $filterdata['relationship'][$key]= $relation_row['name'];
                            
                         } */
                      }
                    
                    
                    
                    if (isset($value['other_services']) && $value['other_services'] != "") {
                        $filterdata['other_services'] = "Yes";
                    }
                    else{
                        $filterdata['other_services'] = "No";
                    }
                    
                    
                                                                                                
                    
                    //echo '<pre>';print_r($value);
                    // $value = $this->arraytolower($searchvalue,$value);
                   // echo '<pre>';print_r($filterdata['relationship']);//die();
                    $value = $this->arraytolower($value);
                    // echo '<pre>';print_r($value);
                    //$array_with_lcvalues = array_map('strtolower',$value);
                    //$c = array_map("show_case", $searchvalue, $value);

                    //echo '<pre>';print_r($value);die();

                    // $temp = $this->search_array($filterdata, $searchvalue , $final_arr);
                    
                    $temp = $this->search_array($filterdata, $searchvalue, $final_arr);

                    if (isset($temp) && count($temp) > 0) {
                        $newvardump[$key] = $client_details[$key];

                        // $newvardump[$key] = $client_details[$key];

                    }
                    //array_push($newvardump , $temp);


                    //echo '<pre>';print_r($newvardump);die;

                    /*
                    if(array_search($searchvalue,$value)){
                    $client_data[$key] = $client_details[$key];
                    } */
                    
                }
              // die();

                // die();
                //echo '<pre>';print_r($newvardump);die;
                //$client_details = array_values($client_data);
                //$client_details = array_values($newvardump);
            }
            $client_details = array_values($newvardump);
        }
        //print_r($filterdata);die;

        // echo '<pre>';print_r($client_details);die();
        //echo '<pre>';print_r($client_data);die();
        //print_r($client_data);die;

        $data['client_details'] = $client_details;
        //echo '<pre>';print_r($data['client_details']);die;
        $data['client_fields'] = ClientField::where("field_type", "=", "ind")->get();
        //die;
        //echo '<pre>';print_r($data['client_details']);die;

        if ($type == "pdf") {
            $pdf = PDF::loadView('home/individual/indpdf', $data)->setPaper('a4')->
                setOrientation('landscape')->setWarnings(false);
            return $pdf->download('Individual_clients_list.pdf');
        } elseif ($type == "excel") {
            $viewToLoad = 'home/individual/indexcel';
            ///////////  Start Generate and store excel file ////////////////////////////
            Excel::create('Individual_clients_list', function ($excel)use ($data, $viewToLoad)
            {

                $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
                {
                    $sheet->loadView($viewToLoad)->with($data); }
                )->save(); }
            );

            //


            $filepath = storage_path() . '/exports/Individual_clients_list.xls';
            $fileName = 'Individual_clients_list.xls';
            $headers = array('Content-Type: application/vnd.ms-excel', );

            return Response::download($filepath, $fileName, $headers);
            exit;

        }


    }

    function search_array($value, $searchvalue, $final_arr)
    {   
        //echo '<pre>';print_r($value);die();        
        $arr = $value;

        //echo '<pre>';print_r($value);die;
        foreach ($value as $key => $val) {
            if($searchvalue == ''){
                array_push($final_arr, $arr);
            }else{
                if (!stristr($val, $searchvalue) === false) {
                    if (count($final_arr) > 0) {
                        foreach ($final_arr as $keyF => $eachF) {
                            if ($eachF['client_id'] != $value['client_id']) {
                                array_push($final_arr, $arr);
                            }
                        }
                    } else {
                        array_push($final_arr, $arr);
                    }
                }
            }
        }
        return $final_arr;
    }


    /*
    
    public function arraytolower($searchvalue,$array) { 
    //echo $searchvalue; die();
    //echo '<pre>';print_r($array);die;
    $final_array=array();
    foreach($array as $key => $value) { 
    
    if(is_array($value))
    {  
    //echo '<pre>';print_r($value);
    foreach($value as $subkey => $val){
    $array[$key] = $this->arraytolower($searchvalue,$val); 
    //$newArray = $this->arraytolower($searchvalue,$val);
    if(isset($val) && $val != "" &&  strpos($searchvalue,$val)){
    $final_array[]= $val[$key];
    print_r($val);
    }
    }
    
    //print_r($array[$key]);die();
    }
    
    else {
    if(isset($value) && $value != "" && strpos($searchvalue,$value)){
    
    $final_array[]= $array[$key];
    } 
    }
    
    }
    die;        
    //echo '<pre>';print_r($final_array);die;
    return $final_array; 
    } 
    */

    public function arraytolower($array)
    {

        foreach ($array as $key => $value) {
            if (is_array($value))
                $array[$key] = $this->arraytolower($value);
            else
                $array[$key] = strtolower($value);
        }
        return $array;
    }

    public function indexcel()
    {


        $client_data = array();
        $t = time();
        $time = date("Y-m-d H:i:s", $t);
        $pieces = explode(" ", $time);
        $data['cdate'] = $pieces[0];
        $data['ctime'] = $pieces[1];
        $today = date("j F  Y");
        $data['today'] = $today;
        $time = date(" G:i:s ");
        $data['time'] = $time;
        $data['heading'] = "";
        $data['title'] = "Individual Clients List";
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

        if (empty($user_id)) {
            return Redirect::to('/');
        }

        $client_ids = Client::where("is_deleted", "=", "N")->where("type", "=", "ind")->
            where("is_archive", "=", "N")->where("is_relation_add", "=", "N")->whereIn("user_id",
            $groupUserId)->select("client_id", "show_archive")->get();
        //echo $this->last_query();die;
        $i = 0;
        if (isset($client_ids) && count($client_ids) > 0) {
            foreach ($client_ids as $client_id) {
                $client_details = StepsFieldsClient::where('client_id', '=', $client_id->
                    client_id)->select("field_id", "field_name", "field_value")->get();

                $client_data[$i]['client_id'] = $client_id->client_id;
                $client_data[$i]['show_archive'] = $client_id->show_archive;

                //$appointment_name = ClientRelationship::where('client_id', '=', $client_id->client_id)->select("appointment_with")->first();
                //echo $this->last_query();//die;
                //$relation_name = StepsFieldsClient::where('client_id', '=', $appointment_name['appointment_with'])->where('field_name', '=', "business_name")->select("field_value")->first();

                if (isset($client_details) && count($client_details) > 0) {
                    $address = "";
                    foreach ($client_details as $client_row) {
                        //get staff name start
                        if (!empty($client_row['field_name']) && $client_row['field_name'] ==
                            "resp_staff") {
                            $staff_name = User::where('user_id', '=', $client_row->field_value)->select("fname",
                                "lname")->first();
                            //echo $this->last_query();die;
                            $client_data[$i]['staff_name'] = strtoupper(substr($staff_name['fname'], 0, 1)) .
                                " " . strtoupper(substr($staff_name['lname'], 0, 1));
                        }
                        //get staff name end

                        //get business name start
                        /*if (!empty($relation_name['field_value'])) {
                        $client_data[$i]['business_name'] = $relation_name['field_value'];
                        }*/
                        $client_data[$i]['relationship'] = Common::get_relationship_client($client_id->
                            client_id);
                        //get business name end


                        //get residencial address
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_addr_line1") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_addr_line2") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] == "res_city") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_county") {
                            $address .= $client_row->field_value . ", ";
                        }
                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "res_postcode") {
                            $address .= $client_row->field_value . ", ";
                        }


                        if (isset($client_row['field_name']) && $client_row['field_name'] ==
                            "business_type") {
                            $business_type = OrganisationType::where('organisation_id', '=', $client_row->
                                field_value)->first();
                            $client_data[$i][$client_row['field_name']] = $business_type['name'];
                        } else {
                            $client_data[$i][$client_row['field_name']] = $client_row->field_value;
                        }

                    }

                    $client_data[$i]['address'] = substr($address, 0, -2);
                    $i++;
                }


            }
        }
        //print_r($client_data);die;
        $data['client_details'] = $client_data;

        $data['client_fields'] = ClientField::where("field_type", "=", "ind")->get();
        //die;
        //print_r($data['client_details']);die;


        $viewToLoad = 'home/individual/indexcel';
        ///////////  Start Generate and store excel file ////////////////////////////
        Excel::create('Individual_clients_list', function ($excel)use ($data, $viewToLoad)
        {

            $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
            {
                $sheet->loadView($viewToLoad)->with($data); }
            )->save(); }
        );

        //


        $filepath = storage_path() . '/exports/Individual_clients_list.xls';
        $fileName = 'Individual_clients_list.xls';
        $headers = array('Content-Type: application/vnd.ms-excel', );

        return Response::download($filepath, $fileName, $headers);
        exit;


    }
    public function orgunicorporated()
    {

        $data['title'] = "BULK UPLOAD";
        $data['heading'] = "";
        $data['previous_page'] =
            '<a href="/organisation-clients">Organisation Client List</a>';

        //$data['back_url'] = base64_decode($back_url);

        /*if ($data['back_url'] == "org_list") {
        $data['previous_page'] =
        '<a href="/organisation-clients">Organisation Clients List</a>';
        } else {
        $data['previous_page'] = '<a href="/chdata/index">Ch Data List</a>';
        } */
        //echo $data['back_url'];die;
        return View::make("home.organisation.bulk_file_upload", $data);

        die('afafaf');
    }


}
