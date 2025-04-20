<?php
class ChdataController extends BaseController
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

    public function index()
    { 
        $data = array();
        $client_data = array();
        $data['heading'] = "COMPANIES' HOUSE";
        $data['title'] = "Companies' House";
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

        if (empty($user_id)) {
            return Redirect::to('/');
        }

        $data['company_details'] = Client::getAllOrgClientDetails();

        //echo "<pre>";print_r($data['company_details']);die;
        return View::make('ch_data.chdata_list', $data);


    }

    public function chdata_details($number)
    {
        //print_r($number);die();
        $data = array();
        $data['heading']    = "COMPANY DETAILS";
        $data['title']      = "Company Details";
        $details            = Common::getCompanyDetails($number);
        $company_data       = Common::getCompanyData($number);
        //echo "<pre>";print_r($details);die;
        $registered_office  = Common::getRegisteredOffice($number);
        $officers           = Common::getOfficerDetails($number);
        $filling_history    = Common::getFillingHistory($number);
        //$insolvency 		= Common::getInsolvency($number);

        $data['details'] = $details->primaryTopic;
        $data['type']    = (isset($company_data->type) && $company_data->type != "")?$company_data->type:"";
        //$data['details']			= Common::getCompanyData($number);
        $data['officers'] = $officers->items;
        $data['filling_history'] = $filling_history->items;
        $data['registered_office'] = $registered_office;

        $data['nature_of_business'] = $this->getSicDescription($details->primaryTopic->SICCodes->SicText);
        $data['client_data']        = $this->getRegisteredIn($details->primaryTopic->CompanyNumber);
        $data['insolvency']         = Common::getInsolvency($number);
        $data['charges']            = Common::getCharges($number);
        $data['chnumber']           = $number;
        //$data['authen_code']        = Client::getAuthenticationCode($number);

        //echo "<pre>";print_r($company_data);die;
        return View::make("ch_data.chdata_details", $data);
    }

    private function getSicDescription($sic_codes)
    {
      $text = "";
      if (isset($sic_codes) && count($sic_codes) > 0) {
        $text = implode(",", $sic_codes);
      }
      return $text;
    }

    private function getRegisteredIn($company_no)
    {
        $array = array();
        $details = StepsFieldsClient::where("field_value", "=", $company_no)->where("step_id",
            "=", 1)->where("field_name", "=", "registration_number")->first();
        //print_r($details);echo $this->last_query();die;
        if (isset($details) && count($details) > 0) {
            $all_details = StepsFieldsClient::where("client_id", "=", $details['client_id'])->
                where("step_id", "=", 1)->get();
            foreach ($all_details as $key => $value) {
                if (isset($value->field_name) && $value->field_name == "registered_in") {
                    $reg_in = RegisteredAddress::where("reg_id", "=", $value->field_value)->first();
                    $array['registered_in'] = $reg_in['reg_name'];
                }
                if (isset($value->field_name) && $value->field_name == "ch_auth_code") {
                    $array['ch_auth_code'] = $value->field_value;
                }
            }

        }
        //print_r($array);die;
        //echo $this->last_query();die;
        return $array;
    }

    public function getMonthName($month)
    {
        switch ($month) {
            case '1':
                return "January";
                break;
            case '2':
                return "February";
                break;
            case '3':
                return "March";
                break;
            case '4':
                return "April";
                break;
            case '5':
                return "May";
                break;
            case '6':
                return "June";
                break;
            case '7':
                return "July";
                break;
            case '8':
                return "August";
                break;
            case '9':
                return "September";
                break;
            case '10':
                return "October";
                break;
            case '11':
                return "November";
                break;
            case '12':
                return "December";
                break;

            default:
                return $month;
                break;
        }
    }

    public function getMonthNameShort($month)
    {
        switch ($month) {
            case '1':
                return "JAN";
                break;
            case '2':
                return "FEB";
                break;
            case '3':
                return "MAR";
                break;
            case '4':
                return "APR";
                break;
            case '5':
                return "MAY";
                break;
            case '6':
                return "JUN";
                break;
            case '7':
                return "JUL";
                break;
            case '8':
                return "AUG";
                break;
            case '9':
                return "SEPT";
                break;
            case '10':
                return "OCT";
                break;
            case '11':
                return "NOV";
                break;
            case '12':
                return "DEC";
                break;

            default:
                return $month;
                break;
        }
    }

    public function officers_details()
    {
        $number = Input::get("number");
        $key = Input::get("key");
        $data = array();
        $off_data = array();

        $officers = Common::getOfficerDetails($number); //print_r($officers);die;

        if (isset($officers->items[$key]->date_of_birth)) {
            $month = $this->getMonthName($officers->items[$key]->date_of_birth->month);
            $year = $officers->items[$key]->date_of_birth->year;
            $off_data['dob'] = $month . ", " . $year;
        }

        $off_data['nationality'] = isset($officers->items[$key]->nationality) ? $officers->
            items[$key]->nationality : "";
        $off_data['officer_role'] = isset($officers->items[$key]->officer_role) ? $officers->
            items[$key]->officer_role : "";
        $off_data['name'] = isset($officers->items[$key]->name) ? $officers->items[$key]->
            name : "";
        $off_data['occupation'] = isset($officers->items[$key]->occupation) ? $officers->
            items[$key]->occupation : "";
        $off_data['appointed_on'] = isset($officers->items[$key]->appointed_on) ? $officers->
            items[$key]->appointed_on : "";
      
        $off_data['resigned_on'] = isset($officers->items[$key]->resigned_on) ? $officers->items[$key]->resigned_on : "";
            
            
        $off_data['country_of_residence'] = isset($officers->items[$key]->
            country_of_residence) ? $officers->items[$key]->country_of_residence : "";
        $off_data['address'] = isset($officers->items[$key]->address) ? $officers->
            items[$key]->address : "";
        $off_data['links'] = isset($officers->items[$key]->links) ? $officers->items[$key]->
            links : "";

        $data['officers'] = $off_data;
        //print_r($data['officers']);die;
        echo View::make("ch_data.ajax_officer_details", $data);

    }

    public function import_from_ch($back_url)
    {
        $data['title'] = "Import from CH";
        $data['heading'] = "";
        $data['back_url'] = base64_decode($back_url);

        if ($data['back_url'] == "ind_list") {
            $data['previous_page'] =
                '<a href="/individual-clients">Individual Clients List</a>';
        } else
            if ($data['back_url'] == "org_list") {
                $data['previous_page'] =
                    '<a href="/organisation-clients">Organisation Clients List</a>';
            } else {
                $data['previous_page'] = '<a href="/chdata/index">Ch Data List</a>';
            }
            //echo $data['back_url'];die;
            return View::make("ch_data.import_from_ch", $data);
    }

    public function search_company()
    {
        $company = array();
        $value = str_replace(" ", "+", Input::get("value"));
        //$value = "Alexander+Rosse";
        $compamy_details = Common::getSearchCompany($value);
        if (isset($compamy_details->items) && count($compamy_details->items) > 0) { //print_r($compamy_details->items);die;
            foreach ($compamy_details->items as $key => $value) {
                $company[$key]['company_name'] = $value->title;
                $company[$key]['company_number'] = isset($value->company_number)?$value->company_number:0;
            }
        }
        $data['company_details'] = $company;
        //print_r($data);die;

        echo View::make("ch_data.ajax_company_search_result", $data);
    }

    public function company_details()
    {
        $number = Input::get("number");
        $back_url = Input::get("back_url");
        $data = array();
        $data['officers'] = array();

        $details = Common::getCompanyDetails($number);
        $registered_office = Common::getRegisteredOffice($number);
        $officers = Common::getOfficerDetails($number);
        if (isset($officers->items) && count($officers->items) > 0) {
            $data['officers'] = $officers->items;
        }
        //print_r($data['officers']);die;
        $data['details'] = $details->primaryTopic;

        $data['registered_office'] = $registered_office;
        $data['nature_of_business'] = $this->getSicDescription($details->primaryTopic->
            SICCodes->SicText);

        if ($back_url == "ind_list") {
            echo View::make("ch_data.ajax_ind_company_details", $data);
        } else {
            echo View::make("ch_data.ajax_company_details", $data);
        }


    }

    public function update_existing_client($client_id, $details)
    {
      $admin_s = Session::get('admin_details');
      $user_id = $admin_s['id'];
      $groupUserId = $admin_s['group_users'];

      $client_value = Client::where("client_id", $client_id)->whereIn("user_id",
           $groupUserId)->select("chd_type", "type")->first();
      if (isset($client_value['chd_type']) && $client_value['chd_type'] != "") {
          $update['type'] = $client_value['chd_type'];
      }
      $update['is_deleted'] = "N";
      $update['is_archive'] = "N";

      Client::where("client_id", $client_id)->whereIn("user_id", $groupUserId)->update($update);

      /* ############## Update Client details Start ################ */
      if (isset($details->company_name)) {
        StepsFieldsClient::where("client_id", $client_id)->where("user_id", $user_id)->
              where("field_name", "business_name")->update(array("field_value"=>$details->company_name));
      }
      if (isset($details->date_of_creation)) {
        StepsFieldsClient::where("client_id", $client_id)->where("user_id", $user_id)->
              where("field_name", "incorporation_date")->update(array("field_value"=>$details->date_of_creation));
      }
      if (isset($details->type)) {
        if ($details->type == "ltd" || $details->type == "limited") {
            $type = 2;
        } else
        if ($details->type == "llp") {
            $type = 1;
        } else {
            $type = "";
        }
        StepsFieldsClient::where("client_id", $client_id)->where("user_id", $user_id)->
                where("field_name", "business_type")->update(array("field_value"=>$type));
      }
      if (isset($details->jurisdiction)) {
        $reg_in = RegisteredAddress::where("reg_name", ucwords($details->jurisdiction))->select("reg_id")->first();
        StepsFieldsClient::where("client_id", $client_id)->where("user_id",$user_id)->
              where("field_name","registered_in")->update(array("field_value"=>$reg_in['reg_id']));

      }
      /*if (isset($details->sic_codes) && count($details->sic_codes) > 0) {
        $codes_data = "";
        foreach ($details->sic_codes as $key => $value) {
          $sic_codes = SicCodesDescription::where("sic_codes", $value)->first();
          $codes_data .= $sic_codes['description'] . ", ";
        }
        $codes_data = substr($codes_data, 0, -2);
        StepsFieldsClient::where("client_id", $client_id)->where("user_id", $user_id)->
              where("field_name", "business_desc")->update(array("field_value" => $codes_data));
      }*/
      if(isset($details->sic_codes) && count($details->sic_codes) > 0) {
        foreach ($details->sic_codes as $key => $value) {
          //$arrData[] = Client::save_client($user_id, $client_id, 1, 'business_desc', $value);
          StepsFieldsClient::updateField($client_id, "business_desc", $value, 1);
          break;
        }
      }
      //echo "<pre>";print_r($arrData);die;

      if (isset($details->confirmation_statement->next_due)) {
        $ret_check = 1;
        StepsFieldsClient::where("client_id", $client_id)->where("user_id", $user_id)->
              where("field_name", "next_ret_due")->update(array("field_value" =>
                  str_replace("/", "-", $details->confirmation_statement->next_due)));
      }
      if (isset($details->confirmation_statement->last_made_up_to)) {
        $ret_check = 1;
        $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
              'made_up_date', $details->confirmation_statement->last_made_up_to);
      }
      if (isset($details->accounts->last_accounts->made_up_to)) {
        $acc_check = 1;
        $field_value = $details->accounts->last_accounts->made_up_to;
        StepsFieldsClient::updateField($client_id, "last_acc_madeup_date", $field_value, 1);
      }
      if (isset($details->accounts->next_due)) {
        $acc_check = 1;
        $field_value = $details->accounts->next_due;
        StepsFieldsClient::updateField($client_id, "next_acc_due", $field_value, 1);
      }
      if (isset($details->accounts->next_made_up_to)) {
        $acc_check = 1;
        $field_value = $details->accounts->next_made_up_to;
        StepsFieldsClient::updateField($client_id, "next_made_up_to", $field_value, 1);
        /*StepsFieldsClient::where("client_id", $client_id)->where("user_id", $user_id)->
              where("field_name", "next_made_up_to")->update(array("field_value" => $details->
                  accounts->next_made_up_to));*/
      }
      if (isset($details->accounts->accounting_reference_date->day)) {
        $acc_check = 1;
        $field_value = $details->accounts->accounting_reference_date->day;
        StepsFieldsClient::updateField($client_id, "acc_ref_day", $field_value, 1);
      }
      if (isset($details->accounts->accounting_reference_date->month)) {
        $acc_check = 1;
        $field_value = $details->accounts->accounting_reference_date->month;
        StepsFieldsClient::updateField($client_id, "acc_ref_month", $field_value, 1);
      }

      if (isset($details->registered_office_address->address_line_1)) {
        $regaddr['address1'] = $details->registered_office_address->address_line_1;
      }
      if (isset($details->registered_office_address->address_line_2)) {
        $regaddr['address2'] = $details->registered_office_address->address_line_2;
      }
      if (isset($details->registered_office_address->locality)) {
        $regaddr['city'] = $details->registered_office_address->locality;
      }
      if (isset($details->registered_office_address->postal_code)) {
        $regaddr['postcode'] = $details->registered_office_address->postal_code;
      }
      if (isset($details->registered_office_address->country)) {
        $country_name = $details->registered_office_address->country;
        $country = Country::where("country_name", $country_name)->select("country_id")->first();
        $regaddr['country'] = $country['country_id'];
      }
      /* ############## Update Client details End ################ */

      $regaddr['address_type']     = 'reg';
      $regaddr['user_id']          = $user_id;
      $regaddr['client_id']        = $client_id;
      $checkaddr     = substr($regaddr['address1'], 0, 7);
      $checkpost     = $regaddr['postcode'];
      $checkAddr     = ClientAddress::checkAddress($checkaddr, $checkpost, 'main');
      if($checkAddr == 0){
          $address_id = ClientAddress::insertGetId($regaddr);
          Client::updateQuery($client_id,'3','reg_address',$address_id);
      }else{
          Client::updateQuery($client_id,'3','reg_address',$checkAddr);
      }

      /*$appointment = ClientRelationship::where('appointment_with', '=', $client_id)->select("client_id", "relationship_type_id")->first();
      if(isset($appointment) && count($appointment) >0 ){
      
      $act_data['user_id'] 			= $user_id;
      $act_data['client_id'] 			= $client_id;
      $act_data['acting_client_id'] 	= $appointment['client_id'];
      ClientActing::insert($act_data);
      }*/

    }

    public function import_company_details($value)
    { 
      $value          = explode("=", $value);
      $number         = $value[0];
      $function_type  = $value[1]; //echo $number;die;
      $client_id      = 0;

      $data           = array();
      $details        = Common::getCompanyData($number);
      $admin_s        = Session::get('admin_details');
      //$groupUserId    = $admin_s['group_users'];
      $user_id        = $admin_s['id'];
      //echo "<pre>";print_r($details);die;

      $groupUserId    = Client::getSessionUserIds();

      $w = "where c.is_deleted='N' and c.user_id IN ('".implode(',', $groupUserId)."') and c.type='org' and sfc.field_name='registration_number' and sfc.field_value='".$details->company_number."' and c.client_id = sfc.client_id group by sfc.client_id ";

      $query = "select c.client_id FROM clients c JOIN steps_fields_clients as sfc ".$w." limit 1";

      //echo $query;die;
      $od = DB::select( $query );
      $client_data = json_decode(json_encode($od), true);
      //echo "<pre>";print_r($client_data);die;

      //################# If company number exists Start ##################//
      /*$client_data = StepsFieldsClient::whereIn("user_id", $groupUserId)
          ->where("field_name", "registration_number")
          ->where("field_value", $details->company_number)
          ->select("client_id")->first();*/

    if (isset($client_data[0]) && count($client_data[0]) > 0) {
      $client_id = $client_data[0]['client_id'];
      $this->update_existing_client($client_id, $details);
      if ($function_type == "ajax") {
          echo $client_id;
          exit();
      } else {
          return $client_id;
          exit();
      }

    } else {
        $client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'org'));
    }
    //################# If company number exists End ##################//

    $ret_check = 0;
    $acc_check = 0;
    $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
        'display_in_ch', 'Y');

    if (isset($details->company_name)) {
      $arrData[] = Client::save_client($user_id, $client_id, 1, 'business_name', $details->company_name);
    }
    if (isset($details->company_number)) {
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'registration_number', $details->company_number);
    }
    if (isset($details->date_of_creation)) {
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'incorporation_date', $details->date_of_creation);
    }
    if (isset($details->type)) {
      if ($details->type == "ltd" || $details->type == "limited") {
          $type = 2;
      } else
        if ($details->type == "llp") {
          $type = 1;
        } else {
          $type = "";
        }
        $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'business_type', $type);
    }

    if (isset($details->jurisdiction)) {
      $reg_in = RegisteredAddress::where("reg_name", ucwords($details->jurisdiction))->select("reg_id")->first();
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'registered_in', $reg_in['reg_id']);
    }

    if(isset($details->sic_codes) && count($details->sic_codes) > 0) {
      foreach ($details->sic_codes as $key => $value) {
        $arrData[] = Client::save_client($user_id, $client_id, 1, 'business_desc', $value);
        break;
      }
    }

    if (isset($details->confirmation_statement->next_due)) {
      $ret_check = 1;
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'next_ret_due', str_replace("/", "-", $details->confirmation_statement->next_due));
    }
    if (isset($details->confirmation_statement->last_made_up_to)) {
      $ret_check = 1;
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'made_up_date', $details->confirmation_statement->last_made_up_to);
    }
    if (isset($details->accounts->last_accounts->made_up_to)) {
      $acc_check = 1;
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'last_acc_madeup_date', $details->accounts->last_accounts->made_up_to);
    }
    if (isset($details->accounts->next_due)) {
      $acc_check = 1;
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'next_acc_due', $details->accounts->next_due);
    }
    if (isset($details->accounts->next_made_up_to)) {
      $acc_check = 1;
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'next_made_up_to', $details->accounts->next_made_up_to);
    }
    if (isset($details->accounts->accounting_reference_date->day)) {
      $acc_check = 1;
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'acc_ref_day', $details->accounts->accounting_reference_date->day);
    }
    if (isset($details->accounts->accounting_reference_date->month)) {
        $acc_check = 1;
        $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'acc_ref_month', $details->accounts->accounting_reference_date->month);
    }
    if ($ret_check == 1) {
      $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'ann_ret_check', 1);
    }
    if ($acc_check == 1) {
        $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'yearend_acc_check', 1);
    }

    $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
        'cont_reg_addr', 'reg');
    if (isset($details->registered_office_address->address_line_1)) {
      $regaddr['address1'] = $details->registered_office_address->address_line_1;
    }
    if (isset($details->registered_office_address->address_line_2)) {
      $regaddr['address2'] = $details->registered_office_address->address_line_2;
    }
    if (isset($details->registered_office_address->locality)) {
      $regaddr['city'] = $details->registered_office_address->locality;
    }
    if (isset($details->registered_office_address->postal_code)) {
      $regaddr['postcode'] = $details->registered_office_address->postal_code;
    }
    if (isset($details->registered_office_address->country)) {
      $country = Country::where("country_name", "=", $details->registered_office_address->country)->select("country_id")->first();
      $regaddr['country'] = $country['country_id'];
    }
    //print_r($arrData);die;
    $inserted = StepsFieldsClient::insert($arrData);

    $regaddr['address_type']     = 'reg';
    $regaddr['user_id']          = $user_id;
    $regaddr['client_id']        = $client_id;
    $checkaddr     = substr($regaddr['address1'], 0, 7);
    $checkpost     = $regaddr['postcode'];
    $checkAddr     = ClientAddress::checkAddress($checkaddr, $checkpost, 'main');
    if($checkAddr == 0){
      $address_id = ClientAddress::insertGetId($regaddr);
      Client::updateQuery($client_id,'3','reg_address',$address_id);
    }else{
      Client::updateQuery($client_id,'3','reg_address',$checkAddr);
    }

    /* ==================== Services ========================== */
    //ClientService::checkedAllServices($client_id, 'org');


    if ($function_type == "ajax") {
      if ($inserted) {
        echo $client_id;
        exit;
      } else {
        echo 0;
        exit;
      }
    } else {
      return $client_id;
    }

    }

    public function insertClientDetails($relation_id, $client_id, $row, $app_client_id)
    {
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        if (strpos($row->officer_role, 'corporate') !== false) {
            $name = str_replace(" ", "+", $row->name);
            $details = Common::getSearchCompany($name);
            //echo $details->items[0]->company_number;die;

            //////////////Check the officer is exists or not/////////////
            //$exists_client = StepsfieldsClient::where("field_name", "=", "business_name")->where("field_value", "=", $row->name)->first();
            //////////////Check the officer is exists or not////////////

            Client::where("client_id", "=", $app_client_id)->update(array('chd_type' =>
                    'org'));

            if (isset($details->items[0]->company_number)) {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'registration_number', $details->items[0]->company_number);
            }
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                1, 'display_in_ch', 'Y');

            if (isset($row->name) && $row->name != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'business_name', $row->name);
            }
            if (isset($row->address->address_line_1) && $row->address->address_line_1 != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'reg_cont_addr_line1', $row->address->address_line_1);
            }
            if (isset($row->address->address_line_2) && $row->address->address_line_2 != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'reg_cont_addr_line2', $row->address->address_line_2);
            }
            if (isset($row->address->postal_code) && $row->address->postal_code != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'reg_cont_postcode', $row->address->postal_code);
            }
            if (isset($row->address->locality) && $row->address->locality != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'reg_cont_city', $row->address->locality);
            }
            if (isset($row->address->country) && $row->address->country != "") {
                $country = Country::where("country_name", "=", ucwords($row->address->country))->
                    first();
                if (isset($country) && count($country) > 0) {
                    $country = $country['country_id'];
                } else {
                    $country = 0;
                }
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'reg_cont_country', $country);
            }

            //StepsFieldsClient::insert($arrNewData);//echo $this->last_query();die;
            //}

        } else {

            Client::where("client_id", "=", $app_client_id)->update(array('chd_type' =>
                    'ind'));

            $client_name = "";
            $mname = "";
            $full_name = explode(",", $row->name);
            $half_name = explode(" ", trim($full_name[1]));

            if (isset($half_name[0]) && $half_name[0] != "") {
                $client_name .= $half_name[0] . " ";
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'fname', $half_name[0]);
            }
            if (isset($half_name[1]) && $half_name[1] != "") {
                $client_name .= $half_name[1] . " ";
                $mname .= $half_name[1] . " ";
            }
            if (isset($half_name[2]) && $half_name[2] != "") {
                $client_name .= $half_name[2] . " ";
                $mname .= $half_name[2] . " ";
            }
            if (isset($mname) && $mname != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                    'mname', $mname);
            }

            if (isset($full_name[0]) && $full_name[0] != "") {
                $client_name .= $full_name[0];
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                    1, 'lname', $full_name[0]);
            }
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $app_client_id,
                1, 'client_name', trim($client_name));

            /*############### Address ###############*/
            if (isset($row->address->address_line_1) && $row->address->address_line_1 != "") {
                $house_no = "";
                if (isset($row->address->premises) && $row->address->premises != "") {
                    $house_no = $row->address->premises;
                }
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                    'serv_addr_line1', trim($house_no . " " . $row->address->address_line_1));
            }
            if (isset($row->address->address_line_2) && $row->address->address_line_2 != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                    'serv_addr_line2', $row->address->address_line_2);
            }
            if (isset($row->address->postal_code) && $row->address->postal_code != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                    'serv_postcode', $row->address->postal_code);
            }
            if (isset($row->address->locality) && $row->address->locality != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                    'serv_city', $row->address->locality);
            }

            /*############### Address End ###############*/
            if (isset($row->country_of_residence) && $row->country_of_residence != "") {
                $country = Country::where("country_name", "=", ucwords($row->
                    country_of_residence))->select("country_id")->first();
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                    'country_id', $country['country_id']);
            }
            if (isset($row->nationality) && $row->nationality != "") {
                $nationality = Nationality::where("nationality_name", "=", ucwords($row->
                    nationality))->select("nationality_id")->first();
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                    'nationality_id', $nationality['nationality_id']);
            }
            if (isset($row->occupation) && $row->occupation != "") {
                $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                    'occupation', $row->occupation);
            }

            //////////////Check the officer is exists or not/////////////
            //$exists_client = StepsfieldsClient::where("field_name", "=", "client_name")->where("field_value", "=", trim($client_name))->first();//echo $this->last_query();die;
            //////////////Check the officer is exists or not////////////

        }

        StepsFieldsClient::insert($arrNewData);

    }

    public function insert_corporate_company($number, $client_id)
    {
        $data = array();
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        $details = Common::getCompanyData($number);
        //print_r($details);die;

        $ret_check = 0;
        $acc_check = 0;
        $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'display_in_ch', 'Y');

        if (isset($details->company_name)) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'business_name', $details->company_name);
        }
        if (isset($details->company_number)) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'registration_number', $details->company_number);
        }
        if (isset($details->date_of_creation)) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'incorporation_date', $details->date_of_creation);
        }
        if (isset($details->type)) {
          if ($details->type == "ltd" || $details->type == "limited") {
              $type = 2;
          } else
            if ($details->type == "llp") {
                $type = 1;
            } else {
                $type = "";
            }
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                    'business_type', $type);
        }
        if (isset($details->jurisdiction)) {
            $reg_in = RegisteredAddress::where("reg_name", ucwords(str_replace("-", " ",
                $details->jurisdiction)))->select("reg_id")->first();
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'registered_in', $reg_in['reg_id']);
        }
        /*if (isset($details->sic_codes) && count($details->sic_codes) > 0) {
          $codes_data = "";
          foreach ($details->sic_codes as $key => $value) {
              $sic_codes = SicCodesDescription::where("sic_codes", $value)->first();
              $codes_data .= $sic_codes['description'] . ", ";
          }
          $codes_data = substr($codes_data, 0, -2);
          $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'business_desc', $codes_data);
        }*/
        if(isset($details->sic_codes) && count($details->sic_codes) > 0) {
          foreach ($details->sic_codes as $key => $value) {
            $arrData[] = Client::save_client($user_id, $client_id, 1, 'business_desc', $value);
            break;
          }
        }
        if (isset($details->confirmation_statement->next_due)) {
            $ret_check = 1;
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'next_ret_due', str_replace("/", "-", $details->confirmation_statement->next_due));
        }
        if (isset($details->confirmation_statement->last_made_up_to)) {
            $ret_check = 1;
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'made_up_date', $details->confirmation_statement->last_made_up_to);
        }
        if (isset($details->accounts->last_accounts->made_up_to)) {
            $acc_check = 1;
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'last_acc_madeup_date', $details->accounts->last_accounts->made_up_to);
        }
        if (isset($details->accounts->next_due)) {
            $acc_check = 1;
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'next_acc_due', $details->accounts->next_due);
        }
        if (isset($details->accounts->next_made_up_to)) {
          $acc_check = 1;
          $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'next_made_up_to', $details->accounts->next_made_up_to);
        }
        if (isset($details->accounts->accounting_reference_date->day)) {
            $acc_check = 1;
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'acc_ref_day', $details->accounts->accounting_reference_date->day);
        }
        if (isset($details->accounts->accounting_reference_date->month)) {
            $acc_check = 1;
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'acc_ref_month', $details->accounts->accounting_reference_date->month);
        }
        if ($ret_check == 1) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'ann_ret_check', 1);
        }
        if ($acc_check == 1) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'yearend_acc_check', 1);
        }

        //$registered_office 				= Common::getRegisteredOffice($number);
        $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
            'cont_reg_addr', 'reg');
        if (isset($details->registered_office_address->address_line_1)) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                'reg_cont_addr_line1', $details->registered_office_address->address_line_1);
        }
        if (isset($details->registered_office_address->address_line_2)) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                'reg_cont_addr_line2', $details->registered_office_address->address_line_2);
        }
        if (isset($details->registered_office_address->locality)) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                'reg_cont_city', $details->registered_office_address->locality);
        }
        if (isset($details->registered_office_address->postal_code)) {
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                'reg_cont_postcode', $details->registered_office_address->postal_code);
        }
        if (isset($details->registered_office_address->country)) {
            $country = Country::where("country_name", "=", $details->
                registered_office_address->country)->select("country_id")->first();
            $arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,
                'reg_cont_country', $country['country_id']);
        }
        //print_r($arrData);die;
        $inserted = StepsFieldsClient::insert($arrData);

        $officers = Common::getOfficerDetails($number); //print_r($officers);die;
        if (isset($officers->items) && count($officers->items) > 0) {
            foreach ($officers->items as $key => $row) {
                $app_client_id = Client::insertGetId(array("user_id" => $user_id, 'type' =>
                        'chd'));
                if (isset($row->officer_role) && $row->officer_role != "") {
                    $relationship_type = RelationshipType::where("relation_type", "=", ucwords($row->
                        officer_role))->first();
                    $rel_type = $relationship_type['relation_type_id'];
                }

                $relData['client_id'] = $client_id;
                $relData['appointment_with'] = $app_client_id;
                $relData['relationship_type_id'] = isset($rel_type) ? $rel_type : "0";
                ClientRelationship::insert($relData);

                $actData['user_id'] = $user_id;
                $actData['client_id'] = $client_id;
                $actData['acting_client_id'] = isset($app_client_id) ? $app_client_id : "0";
                ClientActing::insert($actData);

                $getReturn = $this->insertClientDetails($row, $app_client_id);

            }

        }


    }


    public function goto_edit_client()
    {
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        $company_number = Input::get("company_number");
        $key = Input::get("key");
        $relation_client_id = Input::get("client_id");
        $data = array();

        $officers = Common::getOfficerDetails($company_number); //print_r($officers);die;
        if (isset($officers->items[$key]) && count($officers->items[$key]) > 0) {
            $officer = $officers->items[$key];

            if (strpos($officer->officer_role, 'corporate') !== false) {
                $name = str_replace(" ", "+", $officer->name);
                $details = Common::getSearchCompany($name);
                if (isset($details->items[0]->company_number)) {
                    $company_number = $details->items[0]->company_number . "=function";
                } else {
                    echo 0;
                    exit;
                }

                //$client_id = $this->insert_org_client($company_number);
                $client_id = $this->import_company_details($company_number);
                //$data['link'] = "/client/edit-org-client/".$client_id;
                $data['link'] = "org";
                $data['goto_link'] = base64_encode("org_client");
            } else {
                $client_id = $this->checkClientExists($officer->name);
                if ($client_id != "") {
                    $this->update_individual_client($officer, $client_id);
                } else {
                    $client_id = $this->insert_individual_client($officer);
                }

                //$data['link'] = "/client/edit-ind-client/".$client_id;
                $data['link'] = "ind";
                $data['goto_link'] = base64_encode("ind_client");
            }
            $data['client_id'] = $client_id;
            $data['base_url'] = url();

        }

        // ############# RELATIONSHIP SECTION START ############## //
        if (isset($relation_client_id) && $relation_client_id != "") {
            $rel_data['client_id'] = $relation_client_id;
            $rel_data['appointment_with'] = $client_id;
            $relation = RelationshipType::where("relation_type", "=", ucwords($officer->officer_role))->select("relation_type_id")->first();
            //echo $this->last_query();die;
            if (isset($relation['relation_type_id']) && $relation['relation_type_id'] != "") {
                $rel_data['relationship_type_id'] = $relation['relation_type_id'];
                $data['relationship_type'] = ucwords($officer->officer_role);
            } else {
                $rel_data['relationship_type_id'] = 0;
                $data['relationship_type'] = "";
            }
            $relation_id = ClientRelationship::insertGetId($rel_data);

            $data['appointment_name']   = $officer->name;
            $data['rel_client_id']      = $client_id;
            $data['relation_id']        = $relation_id;
        }
        $data['client_type'] = Client::getClientTypeByClientId($client_id);

        // ############# RELATIONSHIP SECTION END ############## //


        echo json_encode($data);
        exit;
    }

    public function insert_individual_client($row)
    {
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        $mname = "";
        $client_name = "";
        $full_name = explode(",", $row->name);
        $half_name = explode(" ", trim($full_name[1]));

        //$client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'chd', 'chd_type' => 'ind'));
        //$client_name = $this->checkClientExists($row->name);
        $client_id = Client::insertGetId(array(
            "user_id" => $user_id,
            'type' => 'ind',
            'chd_type' => 'ind'));

        if (isset($half_name[0]) && $half_name[0] != "") {
            $client_name .= $half_name[0] . " ";
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'fname', $half_name[0]);
        }
        if (isset($half_name[1]) && $half_name[1] != "") {
            $client_name .= $half_name[1] . " ";
            $mname .= $half_name[1] . " ";
        }
        if (isset($half_name[2]) && $half_name[2] != "") {
            $client_name .= $half_name[2] . " ";
            $mname .= $half_name[2] . " ";
        }
        if (isset($mname) && $mname != "") {
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'mname', $mname);
        }

        if (isset($full_name[0]) && $full_name[0] != "") {
            $client_name .= $full_name[0];
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'lname', $full_name[0]);
        }
        $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
            'client_name', $client_name);

        $month = $year = "";
        if (isset($row->date_of_birth->month) && $row->date_of_birth->month != "") {
            $month = ($row->date_of_birth->month>9)?$row->date_of_birth->month:'0'.$row->date_of_birth->month;
        }
        if (isset($row->date_of_birth->year) && $row->date_of_birth->year != "") {
            $year = $row->date_of_birth->year;
        }
        if($month != "" && $year != ""){
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'dob', 'xx-'.$month.'-'.$year);
        }


        /*############### Address Start ###############*/
        if (isset($row->address->address_line_1) && $row->address->address_line_1 != "") {
            $house_no = "";
            if (isset($row->address->premises) && $row->address->premises != "") {
                $house_no = $row->address->premises;
            }
            //$arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'serv_addr_line1', trim($house_no . " " . $row->address->address_line_1));
            $servaddr['address1'] = trim($house_no . " " . $row->address->address_line_1);
        }
        if (isset($row->address->address_line_2) && $row->address->address_line_2 != "") {
            //$arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'serv_addr_line2', $row->address->address_line_2);
            $servaddr['address2'] = $row->address->address_line_2;
        }
        if (isset($row->address->postal_code) && $row->address->postal_code != "") {
            //$arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'serv_postcode', $row->address->postal_code);
            $servaddr['postcode'] = $row->address->postal_code;
        }
        if (isset($row->address->locality) && $row->address->locality != "") {
            //$arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'serv_city', $row->address->locality);
            $servaddr['city'] = $row->address->locality;
        }

        /*############### Address End ###############*/
        if (isset($row->country_of_residence) && $row->country_of_residence != "") {
            $country_id = 0;
            $country = Country::where("country_name", "=", ucwords($row->country_of_residence))->select("country_id")->first();
            //$arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'country_id', $country['country_id']);
            $country_id = $country['country_id'];
            $servaddr['country'] = $country_id;
        }
        if (isset($row->nationality) && $row->nationality != "") {
            $nationality = Nationality::where("nationality_name", "=", ucwords($row->
                nationality))->select("nationality_id")->first();
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'nationality_id', $nationality['nationality_id']);
        }
        if (isset($row->occupation) && $row->occupation != "") {
            $arrNewData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,
                'occupation', $row->occupation);
        }

        StepsFieldsClient::insert($arrNewData);

        $servaddr['address_type']     = 'serv';
        $servaddr['user_id']          = $user_id;
        $servaddr['client_id']        = $client_id;
        $checkaddr     = substr($servaddr['address1'], 0, 7);
        $checkpost     = $servaddr['postcode'];
        $checkAddr     = ClientAddress::checkAddress($checkaddr, $checkpost, 'main');
        if($checkAddr == 0){
            $address_id = ClientAddress::insertGetId($servaddr);
            Client::updateQuery($client_id,'3','serv_address',$address_id);
        }else{
            Client::updateQuery($client_id,'3','serv_address',$checkAddr);
        }


        /* ==================== Services ========================== */
        //ClientService::checkedAllServices($client_id, 'ind');
        

        return $client_id;
    }

    public function update_individual_client($row, $client_id)
    {
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        $full_name = explode(",", $row->name);
        $half_name = explode(" ", trim($full_name[1]));

        $client_name = "";
        $mname = "";
        if (isset($half_name[0]) && $half_name[0] != "") {
            $client_name .= $half_name[0] . " ";
            $this->updateQuery($client_id, $user_id, "fname", $half_name[0]);
        }
        if (isset($half_name[1]) && $half_name[1] != "") {
            $client_name .= $half_name[1] . " ";
            $mname .= $half_name[1] . " ";
        }
        if (isset($half_name[2]) && $half_name[2] != "") {
            $client_name .= $half_name[2] . " ";
            $mname .= $half_name[2] . " ";
        }
        if (isset($mname) && $mname != "") {
            $this->updateQuery($client_id, $user_id, "mname", $mname);
        }

        if (isset($full_name[0]) && $full_name[0] != "") {
            $client_name .= $full_name[0];
            $this->updateQuery($client_id, $user_id, "lname", $full_name[0]);
        }
        $this->updateQuery($client_id, $user_id, "client_name", $client_name);

        /*############### Address Start ###############*/
        if (isset($row->address->address_line_1) && $row->address->address_line_1 != "") {
            $house_no = "";
            if (isset($row->address->premises) && $row->address->premises != "") {
                $house_no = $row->address->premises;
            }
            //$this->updateQuery($client_id, $user_id, "serv_addr_line1", trim($house_no . " " .$row->address->address_line_1));
            $servaddr['address1'] = trim($house_no . " " .$row->address->address_line_1);
        }
        if (isset($row->address->address_line_2) && $row->address->address_line_2 != "") {
            //$this->updateQuery($client_id, $user_id, "serv_addr_line2", $row->address->address_line_2);
            $servaddr['address2'] = $row->address->address_line_2;
        }
        if (isset($row->address->postal_code) && $row->address->postal_code != "") {
            //$this->updateQuery($client_id, $user_id, "serv_postcode", $row->address->postal_code);
            $servaddr['postcode'] = $row->address->postal_code;
        }
        if (isset($row->address->locality) && $row->address->locality != "") {
            //$this->updateQuery($client_id, $user_id, "serv_city", $row->address->locality);
            $servaddr['city'] = $row->address->locality;
        }

        /*############### Address End ###############*/
        if (isset($row->country_of_residence) && $row->country_of_residence != "") {
            $country = Country::where("country_name", "=", ucwords($row->country_of_residence))->select("country_id")->first();
            //$this->updateQuery($client_id, $user_id, "country_id", $country['country_id']);
            $servaddr['country'] = $country['country_id'];
        }
        if (isset($row->nationality) && $row->nationality != "") {
            $nationality = Nationality::where("nationality_name", "=", ucwords($row->
                nationality))->select("nationality_id")->first();
            $this->updateQuery($client_id, $user_id, "nationality_id", $nationality['nationality_id']);
        }
        if (isset($row->occupation) && $row->occupation != "") {
            $this->updateQuery($client_id, $user_id, "occupation", $row->occupation);
        }

        $servaddr['address_type']     = 'serv';
        $servaddr['user_id']          = $user_id;
        $servaddr['client_id']        = $client_id;
        $checkaddr     = substr($servaddr['address1'], 0, 7);
        $checkpost     = $servaddr['postcode'];
        $checkAddr     = ClientAddress::checkAddress($checkaddr, $checkpost, 'main');
        if($checkAddr == 0){
            $address_id = ClientAddress::insertGetId($servaddr);
            Client::updateQuery($client_id,'3','serv_address',$address_id);
        }else{
            Client::updateQuery($client_id,'3','serv_address',$checkAddr);
        }

    }

    public function updateQuery($client_id, $user_id, $field_name, $field_value)
    {
        StepsFieldsClient::where("client_id", "=", $client_id)->where("user_id", "=", $user_id)->
            where("field_name", "=", $field_name)->update(array("field_value" => $field_value));
    }

    public function checkClientExists($name)
    {
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];
        $client_name = "";
        $client_id = "";
        $full_name = explode(",", $name);
        $half_name = explode(" ", trim($full_name[1]));

        if (isset($half_name[0]) && $half_name[0] != "") {
            $client_name .= $half_name[0] . " ";
        }
        if (isset($half_name[1]) && $half_name[1] != "") {
            $client_name .= $half_name[1] . " ";
        }
        if (isset($half_name[2]) && $half_name[2] != "") {
            $client_name .= $half_name[2] . " ";
        }

        if (isset($full_name[0]) && $full_name[0] != "") {
            $client_name .= $full_name[0];
        }

        $client_data = StepsFieldsClient::where("field_name", "client_name")->
            where("field_value", trim($client_name))->where("user_id", $user_id)->
            select("client_id")->first();
        //echo $this->last_query();die;
        if (isset($client_data) && count($client_data) > 0) {
            $client_id = $client_data['client_id'];
        }

        return $client_id;
    }


    public function get_shareholders_client()
    {
      $data = array();
      $number = Input::get("company_number");
      $filling_history = Common::getFillingHistory($number); //print_r($officers);die;
      if (isset($filling_history->items) && count($filling_history->items) > 0) {
        foreach ($filling_history->items as $key => $value) {
          if ($value->category == 'incorporation' || $value->category == 'annual-return') {
            $data[$key]['company_number'] = $number;
            $data[$key]['date'] = date("d-m-Y", strtotime($value->date));
            $data[$key]['category'] = ucwords(str_replace('-', ' ', $value->category));
            $data[$key]['transaction_id'] = $value->transaction_id;
          }
        }
      }

      echo json_encode($data);
      exit;
    }

    public function bulk_company_upload_page($back_url)
    {
      $data['title'] = "Bulk file upload";
      $data['heading'] = "";
      $data['back_url'] = base64_decode($back_url);

      if ($data['back_url'] == "org_list" || $data['back_url'] == "org_unin") {
          $data['previous_page'] = '<a href="/organisation-clients">Organisation Clients List</a>';
      }else if ($data['back_url'] == "ind_list") {
          $data['previous_page'] = '<a href="/individual-clients">Individual Clients List</a>';
      }else {
          $data['previous_page'] = '<a href="/chdata/index">Ch Data List</a>';
      }
      //echo $data['back_url'];die;
      return View::make("ch_data.bulk_file_upload", $data);
    }

    public function bulk_file_upload()
    {
        $session = Session::get('admin_details');
        $data['user_id'] = $session['id'];
        $back_url = Input::get("back_url");
        ////
        $output_dir = "uploads/bulkfile/";
        $return = '0';
        if (isset($_FILES["bulk_file"])) {
            if ($_FILES["bulk_file"]["error"] > 0) {
                $return = '0';
            } else {
                $destinationPath = $output_dir . $_FILES["bulk_file"]["name"];
                move_uploaded_file($_FILES["bulk_file"]["tmp_name"], $destinationPath);
                $csvFile = public_path() . '/' . $destinationPath;
                $areas = $this->csv_to_array($csvFile);

                //print_r($areas);die;
                if (isset($areas) && count($areas) > 0) {
                    if (count($areas) > 100) {
                        $return = '1';
                    } else {
                        foreach ($areas as $key => $value) {
                            //$value = $value['company_number'] . "=function";
                            if(isset($back_url) && $back_url == 'ind_list'){
                                $data['type']       = 'ind';
                                $data['chd_type']   = 'ind';
                                $client_id = Client::insertGetId($data);
                                $return = '4';
                            }else{
                                if(isset($value['CRN']) && $value['CRN'] != ""){
                                    $number = $value['CRN'] . "=function";
                                    $client_id = $this->import_company_details($number);
                                }else{
                                    $data['type']   = 'org';  
                                    $client_id = Client::insertGetId($data);
                                }
                                $return = '2';
                            }
                            Client::updateImportedClient($client_id, $value, $return);
                        }

                        if (file_exists($destinationPath)) {
                            unlink($destinationPath);
                        }
                    }

                } else {
                    $return = '3';
                }

            }

        }

        echo $return;
        die;
    }

    public function csv_to_array($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = NULL;
        //$header = array("company_number");
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }//print_r($data);die;
            fclose($handle);
        }
        return $data;
    }

    public function manage_tasks()
    {
      $session = Session::get('admin_details');
      $data['previous_page'] = '<a href="/chdata/index">CH DATA</a>';
      $data['heading'] = "ANNUAL RETURNS - <span style='font-size:17px;'>MANAGE DEADLINES</span>";
      $data['title'] = "Annual Returns";
      $user_id = $session['id'];
      $user_type = $session['user_type'];

      if (!isset($user_id) && $user_id == "") {
        return Redirect::to('/');
      } else if (isset($user_type) && $user_type == "C") {
        return Redirect::to('/invitedclient-dashboard');
      }

      $data['jobs_steps'] = JobsStep::where("job_id", 9)->orderBy("shorting_id")->get();
      $data['client_details'] = Client::getAllOrgClientDetails();
      //print_r($data['client_details']);die;
      return View::make('ch_data.manage_tasks', $data);
    }

    public function save_edit_status()
    {
      $data = array();
      $step_id = Input::get('step_id');
      $type = Input::get('type');
      if (isset($type) && $type == "title") {
        $data['title'] = Input::get("status_name");
        $title = $data['title'];
      } else {
        $value = JobsStep::where("step_id", $step_id)->first();
        if ($value['status'] == "S") {
            $data['status'] = "H";
        } else {
            $data['status'] = "S";
        }
        $title = $value['title'];
      }
      $sql = JobsStep::where("step_id", $step_id)->update($data);

      $value1 = JobsStep::where("step_id", $step_id)->first();
      echo $value1['title'];
      exit;
    }

    public function send_manage_task()
    {
      $field_name = Input::get("field_name");
      $data[$field_name] = "Y";
      $client_id = Input::get("client_id");
      $sql = Client::where("client_id", "=", $client_id)->update($data);
      echo 1;
    }

    public function delete_manage_task()
    {
      $client_delete_id = Input::get("client_delete_id");
      //print_r($client_delete_id);die;
      foreach ($client_delete_id as $client_id) {
        $del_data['ch_manage_task'] = "N";
        Client::where('client_id', '=', $client_id)->update($del_data);
      }
    }

    public function delete_single_task()
    {
      $client_id  = Input::get("client_id");
      $service_id = Input::get("service_id");
      //print_r($client_delete_id);die;
      $del_data['ch_manage_task'] = "N";
      Client::where('client_id', $client_id)->update($del_data);
      JobStatus::where("client_id", $client_id)->where("service_id", $service_id)->delete();
      echo 1;
    }

    public function change_job_status()
    {
      $session      = Session::get('admin_details');
      $user_id      = $session['id'];
      $groupUserId  = $session['group_users'];

      $client_id  = Input::get("client_id");
      $service_id = Input::get("service_id");
      $status_id  = Input::get("status_id");

      if (isset($status_id) && $status_id == 10) {
        $update_data['ch_manage_task'] = 'N';
        Client::where('client_id', '=', $client_id)->update($update_data);
      }

      $qry = JobStatus::where("client_id", $client_id)->where("service_id",$service_id)->first();
      if (isset($qry) && count($qry) > 0) {
        $updateData['status_id'] = $status_id;
        JobStatus::where("job_status_id", "=", $qry["job_status_id"])->update($updateData);
      } else {
        $data['client_id'] = $client_id;
        $data['service_id'] = $service_id;
        $data['status_id'] = $status_id;
        JobStatus::insert($data);
      }

      echo 1;
    }

    public function send_global_task()
    {
      $session = Session::get('admin_details');
      $user_id = $session['id'];
      $groupUserId = $session['group_users'];

      $client_array = array();
      $update_data = array();
      $dead_line = Input::get("dead_line");
      $service_id = Input::get("service_id");
      $data['company_details'] = Client::getAllOrgClientDetails();
      $all_count = 0;
      $i = 0;
      if (isset($data['company_details']) && count($data['company_details']) > 0) {
        foreach ($data['company_details'] as $key => $details) {
          if ((isset($details['services_id']) && in_array($service_id, $details['services_id']))) {
            if (isset($details['deadacc_count']) && $details['deadacc_count'] <= $dead_line) {
              $update_data['ch_manage_task'] = 'Y';
              Client::where('client_id', $details['client_id'])->update($update_data);
              $client_array[$i]['client_id'] = $details['client_id'];
              $i++;
            }
          }
        }
      }

      $autosend = AutosendTask::whereIn("user_id", $groupUserId)->where('service_id',  $service_id)->first();
      if (isset($autosend) && count($autosend) > 0) {
          $updateData['days'] = $dead_line;
          AutosendTask::where('autosend_id', '=', $autosend['autosend_id'])->update($updateData);
      } else {
          $insrt_data['service_id'] = $service_id;
          $insrt_data['days'] = $dead_line;
          AutosendTask::insert($insrt_data);
      }

      /*if(isset($update_data) && count($update_data) >0 ){
      Client::where('client_id', '=', $client_id)->update($update_data);
      }*/
      echo json_encode($client_array);

    }


    public function chdatapdf()
    {
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

      $client_data = array();
      $data['heading'] = "CH DATA";
      $data['title'] = "Ch Data";
      $admin_s = Session::get('admin_details');
      $user_id = $admin_s['id'];
      $groupUserId = Common::getUserIdByGroupId($admin_s['group_id']);

      if (empty($user_id)) {
          return Redirect::to('/');
      }

      $data['company_details'] = Client::getAllOrgClientDetails();

      //print_r($data['jobs_steps']);die;
      //return View::make('ch_data.chdata_list', $data);


      $pdf = PDF::loadView('ch_data/chdatapdf', $data)->setPaper('a4')->
          setOrientation('landscape')->setWarnings(false);
      return $pdf->download('ch_data.pdf');


    }


    public function chdataexcel()
    {

      $data = array();
      $client_data = array();
      $data['heading'] = "CH DATA";
      $data['title'] = "Ch Data";
      $admin_s = Session::get('admin_details');
      $user_id = $admin_s['id'];
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

      $data['company_details'] = Client::getAllOrgClientDetails();


      $viewToLoad = 'ch_data/chdataexcel';
      ///////////  Start Generate and store excel file ////////////////////////////
      Excel::create('ch_data', function ($excel)use ($data, $viewToLoad)
      {

          $excel->sheet('Sheetname', function ($sheet)use ($data, $viewToLoad)
          {
              $sheet->loadView($viewToLoad)->with($data); }
          )->save(); }
      );

        //


      $filepath = storage_path() . '/exports/ch_data.xls';
      $fileName = 'ch_data.xls';
      $headers = array('Content-Type: application/vnd.ms-excel', );

      return Response::download($filepath, $fileName, $headers);
      exit;


    }

    public function chadtadetailspdf($number)
    {
      $data = array();
      $off_data = array();
      $t = time();
      $time = date("Y-m-d H:i:s", $t);
      $pieces = explode(" ", $time);
      $data['cdate'] = $pieces[0];
      $data['ctime'] = $pieces[1];
      $today = date("j F  Y");
      $data['today'] = $today;
      $time = date(" G:i:s ");
      $data['time'] = $time;

      //print_r($data['time']);die();


      $data['heading'] = "COMPANY DETAILS";
      $data['title'] = "Company Details";
      $details = Common::getCompanyDetails($number);
      //$details 			= Common::getCompanyData($number);
      //print_r($details);die;
      $registered_office = Common::getRegisteredOffice($number);
      $officers = Common::getOfficerDetails($number);
      
      $filling_history = Common::getFillingHistory($number);
      //$insolvency 		= Common::getInsolvency($number);

      $data['details'] = $details->primaryTopic;
      //$data['details']			= Common::getCompanyData($number);
      $data['officers'] = $officers->items;
      $data['filling_history'] = $filling_history->items;
      $data['registered_office'] = $registered_office;

      $data['nature_of_business'] = $this->getSicDescription($details->primaryTopic->
          SICCodes->SicText);
      $data['client_data'] = $this->getRegisteredIn($details->primaryTopic->
          CompanyNumber);
      $data['insolvency'] = Common::getInsolvency($number);
      $data['charges'] = Common::getCharges($number);
      $data['chnumber'] = $number;


      $c_name = $data['details'];

      $company_name = str_replace(' ', '_', $c_name->CompanyName);
      //print_r($data['officers']);die;
      //	return View::make("ch_data.chdata_details", $data);
      
    /*  
      // popup
      //$number = Input::get("number");
      foreach($data['officers'] as $newkey=>$field_row){
      echo $field_row->country_of_recidence; die();
      //echo $key;
      }
      // die();
      
      $key 	= $newkey; 
      //$data 		= array();
      

      //$officers 	= Common::getOfficerDetails($number);
      //echo '<pre>';print_r($officers);die;
      
      // foreach($officers as $key=>$field_row){
      
      if(isset($officers->items[$key]->date_of_birth)){
      $month = $this->getMonthName($officers->items[$key]->date_of_birth->month);
      $year = $officers->items[$key]->date_of_birth->year;
      $off_data['dob'] = $month.", ".$year;
      }
      
      $off_data['nationality'] 			= isset($officers->items[$key]->nationality)?$officers->items[$key]->nationality:"";
      $off_data['officer_role'] 			= isset($officers->items[$key]->officer_role)?$officers->items[$key]->officer_role:"";
      $off_data['name'] 					= isset($officers->items[$key]->name)?$officers->items[$key]->name:"";
      $off_data['occupation'] 			= isset($officers->items[$key]->occupation)?$officers->items[$key]->occupation:"";
      $off_data['appointed_on'] 			= isset($officers->items[$key]->appointed_on)?$officers->items[$key]->appointed_on:"";
      $off_data['resigned_on'] 			= isset($officers->items[$key]->resigned_on)?$officers->items[$key]->resigned_on:"";
      $off_data['country_of_residence'] 	= isset($officers->items[$key]->country_of_residence)?$officers->items[$key]->country_of_residence:"";
      $off_data['address'] 				= isset($officers->items[$key]->address)?$officers->items[$key]->address:"";
      $off_data['links'] 					= isset($officers->items[$key]->links)?$officers->items[$key]->links:"";

      
      //}
      $data['officers'] = $off_data; 
      
      echo '<pre>';print_r($data['officers']);die;
      
      //popup
      */
      // echo '<pre>';print_r($data['officers']);die;

      $off = array();
      if (isset($data['officers']) && count($data['officers']) > 0) {
        foreach ($data['officers'] as $key => $field_row) {
            
           
          if (isset($field_row->resigned_on) && count($field_row->resigned_on) > 0) {
              
              $off[$key]['resigned_on'] = $field_row->resigned_on;
          }
          


          if (isset($field_row->name) && count($field_row->name) > 0) {
              $off[$key]['name'] = $field_row->name;
          }

          if (isset($field_row->date_of_birth->month) && count($field_row->date_of_birth->month)>0){
              $off[$key]['dobmonth'] = $this->getMonthName($field_row->date_of_birth->month);
          }

          if (isset($field_row->date_of_birth->year) && count($field_row->date_of_birth->year) > 0){
              $off[$key]['dobyear'] = $field_row->date_of_birth->year;
          }
          if (isset($field_row->nationality) && count($field_row->nationality) > 0) {
              $off[$key]['nationality'] = $field_row->nationality;
          }
          if (isset($field_row->officer_role) && count($field_row->officer_role) > 0) {
              $off[$key]['ocu'] = $field_row->officer_role;
          }

          if (isset($field_row->country_of_residence) && count($field_row->country_of_residence)>0){
            $off[$key]['country'] = $field_row->country_of_residence;
          }


          if (isset($field_row->officer_role) && count($field_row->officer_role) > 0) {
              $off[$key]['offrole'] = $field_row->officer_role;
          }

          if (isset($field_row->appointed_on) && count($field_row->appointed_on) > 0) {
              $off[$key]['appointed'] = $field_row->appointed_on;
          }

          //$off[$key]['dobmonth']=$field_row->date_of_birth->month;
          $off[$key]['address'] = $field_row->address;


        }
      }

      $data['offdetails'] = $off;

      //print_r($data['offdetails']);die();


      $pdf = PDF::loadView('ch_data/chdetailspdf', $data)->setPaper('a4')->
          setOrientation('landscape')->setWarnings(false);
      $output = $pdf->output();

      //$final_output =
      //echo "<pre>"; print_r( $output );die;
      $dom_pdf = $pdf->getDomPDF();

      $canvas = $dom_pdf->get_canvas();
      //echo $canvas->get_page_number();die;


      if (isset($canvas)) {

          $canvas->page_script('
                  if ($PAGE_NUM > 1) {
                      $PAGE_NUM=$PAGE_NUM-1;
                      $PAGE_COUNT=$PAGE_COUNT-1;
                      $font = Font_Metrics::get_font("Arial, Helvetica, sans-serif", "normal");
                      $size = 10;
          
                      $pageText1 =  " Page " ;
                      $y1 = $pdf->get_height() - 35;
                      $x1 = $pdf->get_width() - 80- Font_Metrics::get_text_width($pageText1, $font, $size);
                      $pdf->text($x1, $y1, $pageText1, $font, $size,array(0, 0, 255));
          
                      $pageText = $PAGE_NUM . " of " . $PAGE_COUNT;
                      $y = $pdf->get_height() - 35;
                      $x = $pdf->get_width() - 50 - Font_Metrics::get_text_width($pageText, $font, $size);
                      $pdf->text($x, $y, $pageText, $font, $size,array(0, 0, 255));
                  }
              ');
      }


      return $pdf->download($company_name . '.pdf');


    }


    public function autologin($number, $auth_code)
    {
      $data = array();
      $details = ChLogin::getDetails();
      if(isset($details) && count($details) >0){
        $data['un1'] = $details['email'];
        $data['pw1'] = $details['password'];
        $data['pw2'] = (isset($auth_code) && $auth_code != "123456")?$auth_code:"";
      }else{
        $data['un1'] = '';
        $data['pw1'] = '';
        $data['pw2'] = '';
      }
      $data['un2'] = $number;//print_r($data);die;
      return View::make('autologin.login', $data);
    }

    public function remotecall($un1, $pw1)
    {
      $data = array();
      $data['un1'] = $un1;
      $data['pw1'] = $pw1;
      return View::make('autologin.remotecall', $data);
    }



}
