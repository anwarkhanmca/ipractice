<?php
class CrmController extends BaseController
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
      //echo $user_id;die;
  }

  public function action()
  {
    $data         = array();
    $session      = Session::get('admin_details');
    $user_id      = $session['id'];
    $groupUserId  = $session['group_users'];
    $postData     = Input::all();

    switch ($postData['action']) {
      case 'getContactNameByType':
        $contactType = $postData['contactType'];
        if($contactType == 'A'){
          $data['details'] = Client::getClientNameAndIdByType('ind');
        }else{
          $data['details'] = ContactAddress::getAllContactNameAndId();
        }
        echo json_encode($data);
        break;
      case 'getContactDetailsByType':
        $contact_id   = $postData['contact_id'];
        $contact_type = $postData['contact_type'];
        if($contact_type == 'R'){
          $data['details'] = Common::clientDetailsById( $contact_id );
        }else{
          $data['details'] = ContactAddress::getContactDetailsById( $contact_id );
        }
        echo json_encode($data);
        break;
      case 'contactDetailsByClientId':
        $client_id   = $postData['client_id'];
        $data['details'] = ContactAddress::getAllContactListByClientId( $client_id );
        echo json_encode($data);
        break;
      default:
        # code...
        break;
    }

  }

    public function index($page_open, $owner_id, $proposals)
    {
        $data           = array();
        $service_id     = 0;
        $data['leads']  = array();

        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";
        $session            = Session::get('admin_details');
        $user_id            = $session['id'];
        $groupUserId        = $session['group_users'];
        $won_value          = Session::get('won_show_archive');
        $lost_value         = Session::get('lost_show_archive');
        if (isset($won_value) && $won_value == 'Y') {
            $data['won_archive'] = 'Show Archived';
        } else {
            $data['won_archive'] = 'Hide Archived';
        }
        if (isset($lost_value) && $lost_value == 'Y') {
            $data['lost_archive'] = 'Show Archived';
        } else {
            $data['lost_archive'] = 'Hide Archived';
        }

        $data['page_open']          = base64_decode($page_open);
        $data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id;
        $data['proposals']          = $proposals;
        $data['user_id']            = $user_id;
        $data['owner_id']           = base64_decode($owner_id);
        $data['goto_url']           = "/crm";

        $data['selected_page']      = 'dashboard';
        
        $data['tab_no']             = $this->getTabNo($data['page_open']); 
        //echo $data['tab_no'];
        switch ($data['page_open']) {
            case '2':
            case '21':
                $data['client_count']   = Client::countClientByType('org');
                //$data['annual_ammount'] = CrmAccDetail::getOrgAnnualAmmount('org');
                $data['annual_ammount'] = CrmProposal::getClientAnnualFees('org');
                $data['client_type']    = 'org';
                break;
            case '22':
                /*$tab_details    = $this->getTabTwoTwoDetails($data['page_open']);
                $data['tab_details']    = $tab_details['client_details'];*/
                //$data['annual_ammount'] = $tab_details['annual_ammount'];
                $data['client_count']   = Client::countClientByType('ind');
                //$data['annual_ammount'] = CrmAccDetail::getOrgAnnualAmmount('ind');
                $data['annual_ammount'] = CrmProposal::getClientAnnualFees('ind');
                $data['client_type']    = 'ind';
                break;
            case '3':
                //$data['tab_details']  = $this->getTabThreeOneDetails($data['page_open']);
                $data['tab_details']  = $this->getManageRenewalDetails();
                break;
            case '32':
            case '33':
            case '34':
            case '35':
            case '36':
            case '37':
                $data['tab_details']  = $this->getOtherTabDetails($data['page_open']);
                break;
            case '38':
                $data['tab_details']  = CrmArchivedDetail::getArchivedDetails();
                break;
            case '4':
                $data['tab_details']  = $this->getInvoiceDetails();
                //$data['org_clients']  = Client::getAllOrgClientDetails();
                $data['org_clients']  = $this->getallOrgClientDetails();
                break;
            case '42':
                $data['tab_details']  = $this->getToBeCollectedDetails();
                break;
            case '611':
                $data['clients']    = Client::getClientNameAndIdByType('ind');
                $data['contacts']   = ContactAddress::getAllContactNameAndId();
                break;
            case '9':
                $data['added_from'] = "wip";
                $data['allClients'] = Client::getClientNameAndId();
                break;
            default:
                
                break;
        }

        //echo '<pre>'; print_r($data['tab_details']);die;
        if($data['tab_no'] == 3){
            $data['status_dropdown'] = RenewalsManage::getAllStatus();
            //$data['tab_status']      = $this->getAllStatus();
            $data['total_count']     = RenewalsManage::getAllCount();
            //$data['notstarted_count']   = RenewalsManage::countNotStarted();
            //echo '<pre>'; print_r($data['status_dropdown']);die;
        }

        if($data['tab_no'] != 2 && $data['tab_no'] != 21){
            $data['autosend']           = AutosendTask::getDetailsByServiceId( $service_id, 'C' );
            $data['titles']             = Title::orderBy("title_id")->get();
            $data['countries']          = Country::orderBy('country_name')->get();
            $data['old_org_types']      = OrganisationType::where("client_type", "all")->orderBy("name")->get();
            $data['new_org_types']      = OrganisationType::where("client_type", "org")->
                whereIn("user_id", $groupUserId)->where("status", "new")->orderBy("name")->get();
            $data['industry_lists']     = IndustryList::getIndustryList();
            $data['staff_details']      = User::getAllStaffDetails();
            $data['old_lead_sources']   = LeadSource::getOldLeadSource();
            $data['new_lead_sources']   = LeadSource::getNewLeadSource();
            //$data['leads_tabs'] = CrmLeadsTab::getAllTabDetails(); 
            $data['leads_tabs']         = LeadsTabManage::getAllTabDetails(); 

            $data['invoice_leads_details']  = CrmLead::getInvoiceLeadsDetails();
            $data['leads_details']          = CrmLead::getAllOpportunity();

            $total = 0;
            $average = 0;
            $likely = 0;
            $all_count = 0;
            if (isset($data['leads_details']) && count($data['leads_details']) > 0) {
                foreach ($data['leads_details'] as $key => $value) {
                    $date1 = date('Y-m-d', strtotime($value['date']));
                    
                    if(isset($value['lead_status']) && ($value['lead_status'] != 8 && $value['lead_status'] != 9 && $value['lead_status'] != 10)){
                        $quoted_value = str_replace(",", "", $value['quoted_value']);
                        $total += $quoted_value;
                        $likely += ($value['deal_certainty'] * $quoted_value) / 100;

                        $data['leads_details'][$key]['deal_age'] = $this->getAgeCount($date1, date('Y-m-d'));
                        $all_count++;
                        
                    }else{
                        $status = CrmLeadsStatus::getDetailsByLeadsId($value['leads_id']);
                        $date2  = date('Y-m-d', strtotime($status['likely']));
                        $date = $this->getAgeCount($date1, $date2);
                        $data['leads_details'][$key]['deal_age'] = $date;//getDealAge
                        //die('else');
                    }
                }
                if(isset($all_count) && $all_count != 0){
                    $average = $total/$all_count;
                }
            }
            $data['all_count']      = $all_count;
            $data['all_total']      = number_format($total, 2);
            $data['all_average']    = number_format($average, 2);
            $data['all_likely']     = number_format($likely, 2);
        }

        //=================LEADS TAB ===================//
        if($data['tab_no'] == 5){
            $leads = $this->leadstabDetails();
            $data['leads'] = $leads;
        }
        if($data['page_open'] == 611){
          
        }


        $data['cont_address'] = ClientAddress::getAllAddressAndId();
       //echo '<pre>'; print_r($data);die();
       //echo "<pre>";print_r($data['leads_details']);echo "</pre>";die;
        return View::make('crm.index', $data);
    }

    public function getallOrgClientDetails()
    {
        $data = array();
        $amount_due = $collected = 0;
        $orgs  = Client::getAllOrgClientDetails();
        if(isset($orgs) && count($orgs) >0){
          foreach ($orgs as $key => $value) {
            $client_id          = $value['client_id'];
            $contact_persons    = ContactAddress::get_all_contacts($client_id);
            $orgs[$key]['contact_persons'] = $contact_persons;
            $contact_id = CrmInvoiceDebit::contactIdByMergeId($client_id);
            //echo $this->last_query();echo "<br>";
            if($contact_id != 0){
                $orgs[$key]['ContactID']     = $contact_id;
                $orgs[$key]['AmountDue']     = CrmInvoiceDebit::totalAmount($contact_id);
                $orgs[$key]['ToBeCollected'] = CrmInvoiceDebit::totalCollected($contact_id);
                $orgs[$key]['contacts']      = $this->get_contact_details($client_id);
                $orgs[$key]['auto_collect']  = $this->getAutoCollect($client_id);
            }else{
                /*$orgs[$key]['AmountDue']     = '0.00';
                $orgs[$key]['ToBeCollected'] = '0.00';*/
                unset($orgs[$key]);
            }

          }
        }
        //echo '<pre>'; print_r($orgs);die();
        return $orgs;
    }
    
    public function get_contact_details($client_id)
    {
        $data = array();
        $details = CrmInvoiceContact::getDetailsByClientId($client_id);
        //echo $this->last_query();
        //echo '<pre>'; print_r($details);die();
        if(isset($details['crm_contact_id']) && $details['crm_contact_id'] != ''){
            $cont_client_id = $details['cont_client_id'];
            $type           = $details['cont_addr_type'];
            
            $data = Client::getAddressByClientId( $cont_client_id, $type );
            $data['check']  = $cont_client_id.'_'.$type;
            //$data['auto_collect']  = $details['auto_collect'];
        }
        return $data;
    }

    public function getAutoCollect($client_id)
    {
        $data           = array();
        $auto_collect   = 'N';
        $details        = CrmInvoiceDebit::detailsByMergeClientId($client_id);
        if(isset($details) && count($details) >0 ){
            $auto_collect = $details['auto_collect'];
        }
        return $auto_collect;
    }

    public function getInvoiceDetails()
    {
        $data = array();
        $amount_due = $collected = 0;
        $data = CrmInvoiceDebit::invoice_groupby_contactid();
        if(isset($data) && count($data) >0){
          foreach ($data as $key => $value) {
            $data[$key]['TotalAmountDue']= CrmInvoiceDebit::totalAmount($value['ContactID']);
            $data[$key]['TotalCollected']= CrmInvoiceDebit::totalCollected($value['ContactID']);
            $amount_due += $data[$key]['TotalAmountDue'];
            $collected  += $data[$key]['TotalCollected'];
          }
        }

        $details['invoice_details'] = $data;
        $details['Amount_Due']      = $amount_due;
        $details['ToBe_Collected']  = $collected;
        return $details;
    }

    public function getToBeCollectedDetails()
    {
        $details    = array();
        $amount     = 0;
        $inv_nos    = CrmManageInvoice::getAllInvoiceNumber();
        $details    = CrmInvoiceDebit::getToBeCollected($inv_nos);
        $amount_due = $collected = 0;
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
              $data = CrmManageInvoice::getDetailsByInvoiceNumber($value['InvoiceNumber']);
              if(isset($data['amount']) && $data['amount'] != ""){
                $amount = $data['amount'];
              }
              if(isset($data['collection_date']) && $data['collection_date']!="0000-00-00"){
                $collection_date = $data['collection_date'];
              }
              $details[$key]['new_amount']      = $amount;
              $details[$key]['collection_date'] = $collection_date;
              $amount_due += $amount;
              $collected  += $details[$key]['ToBeCollected'];
            }
        }
        //echo $this->last_query();
        $invoices['invoice_details'] = $details;
        $invoices['Amount_Due']      = $amount_due;
        $invoices['ToBe_Collected']  = $collected;
        //echo '<pre>';print_r($invoices);die;
        return $invoices;
    }

    public function getAllStatus()
    {
        $tab_status = array();
        $tab_status = CrmRenewalStatus::getAllStatus();
        if(isset($tab_status) && count($tab_status) >0){
            foreach ($tab_status as $key => $value) {
                $tab_status[$key]['count'] = RenewalsManage::countByStatusId($value['renewal_status_id']);
            }
        }
        return $tab_status;
    }

    public function getTabThreeOneDetails($page_open)
    {
        $data   = array();
        $tab21  = array();
        $tab22  = array();
        $tab3   = array();

        $tab21 = $this->getTabTwoOneDetails($page_open);
        $tab22 = $this->getTabTwoTwoDetails($page_open);
        $data = array_merge($tab21['client_details'], $tab22['client_details']);
        if(isset($data) && count($data) >0){
            foreach ($data as $key => $value) {
                if(isset($value['manage_renewals']) && $value['manage_renewals'] == "Y"){
                    $tab3[$key] = $data[$key];

                    $client_id = $value['client_id'];
                    $tab3[$key]['tab_no']       = $this->getTabNoByClientId($client_id);
                    $tab3[$key]['status_id']    = $this->getStatusByClientId($client_id);
                }
            }
        }
        //echo "<pre>";print_r($tab3);die;
        return array_values($tab3);
    }

    public function getOtherTabDetails($page_open)
    {
        $data   = array();
        $details = array();

        $details = $this->getTabThreeOneDetails($page_open);
        if(isset($details) && count($details) > 0){
            foreach ($details as $key => $client_row) {
                if(isset($client_row['tab_no']) && $client_row['tab_no'] == $page_open){
                    $data[$key] = $details[$key];
                }
            }
        }
        return $data;
    }

    public function getTabNoByClientId($client_id)
    {
        $details = RenewalManageStatus::getDetailsByClientId($client_id);
        if(isset($details) && count($details) > 0){
            $tab_no = '3'.$details['status_id'];
        }else{
            $tab_no = 32;
        }
        return $tab_no;
    }

    public function getStatusByClientId($client_id)
    {
        $details = RenewalManageStatus::getDetailsByClientId($client_id);
        if(isset($details) && count($details) > 0){
            $status_id = $details['status_id'];
        }else{
            $status_id = 2;
        }
        return $status_id;
    }

    public function getTabTwoOneDetails($page_open)
    {
        $data           = array();
        $final_array    = array();
        $toal_annual    = "";
        $service_id     = 0;

        $client_details = Client::getAllOrgClientDetails();
        if(isset($client_details) && count($client_details) >0){
          foreach ($client_details as $key => $client_row) {
            if($client_row['is_deleted'] == 'N' && $client_row['is_archive'] == 'N'){
              $final_array[$key]  = $client_row;
              $acc_details = CrmAccDetail::getDetailsByClientId($client_row['client_id']);
              $final_array[$key]['accounts'] = $acc_details;
              if(isset($acc_details['billing_amount']) && $acc_details['billing_amount']!=""){
                    $toal_annual += str_replace(',','', $acc_details['billing_amount']);
                }
            }
          }
        }

        if(isset($final_array) && count($final_array) >0){
          foreach ($final_array as $key => $value) {
            /*==============AUTO SEND START================*/
            if($page_open == 2){
                $days  = AutosendTask::getDaysByServiceId( $service_id, 'C' );
                if(isset($value['accounts']['count_down']) && $value['accounts']['count_down']<=$days){
                    RenewalsManage::updateRenewalsManage($value['client_id']);
                }
            }
            /*==============AUTO SEND END================*/
            $final_array[$key]['manage_renewals'] = RenewalsManage::getManageRenewalsByClientId($value['client_id']);
          }
        }

        $data['annual_ammount'] = $toal_annual;
        $data['client_details'] = array_values($final_array);
        //echo "<pre>";print_r($data['client_details']);die;
        return $data;
    }

    public function getTabTwoTwoDetails($page_open)
    {
        $data           = array();
        $final_array    = array();
        $toal_annual    = "";
        $service_id     = 0;

        $client_details = Client::getAllIndClientDetails();
        if(isset($client_details) && count($client_details) >0){
          foreach ($client_details as $key => $client_row) {
            if($client_row['is_deleted'] == 'N' && $client_row['is_archive'] == 'N'){
              $final_array[$key]  = $client_row;
              $acc_details = CrmAccDetail::getDetailsByClientId($client_row['client_id']);
              $final_array[$key]['accounts'] = $acc_details;
              if(isset($acc_details['billing_amount']) && $acc_details['billing_amount']!=""){
                    $toal_annual += str_replace(',','', $acc_details['billing_amount']);
                }
            }
          }
        }

        if(isset($final_array) && count($final_array) >0){
          foreach ($final_array as $key => $value) {
            /*==============AUTO SEND START================*/
            if($page_open == 2){
                $days  = AutosendTask::getDaysByServiceId( $service_id, 'C' );
                if(isset($value['accounts']['count_down']) && $value['accounts']['count_down']<=$days){
                    RenewalsManage::updateRenewalsManage($value['client_id']);
                }
            }
            /*==============AUTO SEND END================*/
            $final_array[$key]['manage_renewals'] = RenewalsManage::getManageRenewalsByClientId($value['client_id']);
          }
        }

        $data['annual_ammount'] = $toal_annual;
        $data['client_details'] = array_values($final_array);
        //echo "<pre>";print_r($data['client_details']);die;
        return $data;
    }

    public function leadstabDetails()
    {
        $data = array();
        $leads = CrmLead::getAllLeads();
        $total = 0;
        $leads_count = 0;
        if (isset($leads) && count($leads) > 0) {
            foreach ($leads as $key => $value) {
                $leads_count++;
            }
        }
        $data['leads_details']  = $leads;
        $data['leads_count']    = $leads_count;

        return $data;
    }

  public function save_leads_data()
  {
    $data           = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $details        = Input::get();
    $saved_from     = $details['saved_from'];
    $type           = $details['type'];
    $leads_id       = $details['leads_id'];
    //print_r($details);die;

    $data['user_id']          = $user_id;
    $data['leads_type']       = "O";
    $data['client_type']      = $details['type'];
    $data['date']             = date('Y-m-d', strtotime($details['date']));
    $data['deal_certainty']   = $details['deal_certainty'];
    $data['deal_owner']       = isset($details['deal_owner']) ? $details['deal_owner']:"0";
    $data['is_exists']        = $details['is_exists'];
    $data['existing_client']  = isset($details['existing_client'])?$details['existing_client']:"0";
    $data['proposal_title']   = $details['proposal_title'];
    $data['quoted_value']     = $details['quoted_value'];
    $data['phone']            = $details['phone'];
    $data['mobile']           = $details['mobile'];
    $data['email']            = $details['email'];
    $data['lead_source']      = isset($details['lead_source']) ? $details['lead_source']:"0";
    $data['industry']         = isset($details['industry']) ? $details['industry']:"0";
    $data['annual_revenue']   = $details['annual_revenue'];
    $data['website']          = $details['website'];
    $data['address_id']       = $details['res_address'];
    $data['notes']            = $details['notes'];

    if ($type == "ind") {
      $data['prospect_title'] = $details['prospect_title'];
      $data['prospect_fname'] = $details['prospect_fname'];
      $data['prospect_lname'] = $details['prospect_lname'];
    } else {
      $data['business_type']  = isset($details['business_type'])?$details['business_type']:"0";
      if($details['is_exists'] == 'N'){
        $contact_person  = isset($details['contact_person'])?$details['contact_person']:"";
        $data['prospect_name']    = $details['prospect_name'];
        $data['add_contact']      = $details['addContact'];
        $data['contact_type']     = $details['contactType'];
        $data['position']         = $details['position'];
      }else{
        $contact_person  = isset($details['contact_id'])?$details['contact_id']:"";
        $client_id = !empty($details['existing_client'])?$details['existing_client']:0;
        /*$existing = explode('_', $details['existing_client']);
        if(isset($existing[1]) && $existing[1] == 'CL'){
          $data['prospect_name']  = Client::getClientNameByClientId($existing[0]);
        }
        if(isset($existing[1]) && $existing[1] == 'CA'){
          $data['prospect_name']  = ContactAddress::getContactNameById($existing[0]);
        }*/
        $data['prospect_name'] = Client::getClientNameByClientId($client_id);
        $data['phone'] = StepsFieldsClient::getFieldValueByClientId($client_id,'contacttelephone');
        $data['mobile'] = StepsFieldsClient::getFieldValueByClientId($client_id, 'contactmobile');
        $data['email'] = StepsFieldsClient::getFieldValueByClientId($client_id, 'contactemail');
        $data['website'] = StepsFieldsClient::getFieldValueByClientId($client_id,'contactwebsite');
        $data['address_id']=StepsFieldsClient::getFieldValueByClientId($client_id,'corres_address');
        $data['contact_name'] = $details['contact_name'];
      }

      if($details['addContact'] == 'E'){
        $person = explode('_', $contact_person);
        $data['contact_person'] = isset($person[0])?$person[0]:'';
        $data['person_type']    = isset($person[1])?$person[1]:'';
      }else{
        $data['contact_title']  = $details['contact_title'];
        $data['contact_fname']  = $details['contact_fname'];
        $data['contact_mname']  = $details['contact_mname'];
        $data['contact_lname']  = $details['contact_lname'];
      }
      
    }
      
    //echo $data['contact_person'];die;
    if ($leads_id == 0) {
      $last_id = CrmLead::insertGetId($data);
      $leadstatus['user_id']      = $user_id;
      $leadstatus['leads_id']     = $last_id;
      $leadstatus['leads_tab_id'] = ($saved_from == "new_proposal")?5:2;
      $leadstatus['created']      = date("Y-m-d H:i:s");
      CrmLeadsStatus::insert($leadstatus);
    } else {
      $leads_type = CrmLead::getLeadsTypeByLeadsId($leads_id);
      $last_id = $leads_id;
      if(isset($leads_type) && $leads_type == 'L'){
        $leadstatus['leads_tab_id'] = ($saved_from == "new_proposal")?5:2;
        CrmLeadsStatus::whereIn("user_id", $groupUserId)->where('leads_id', $leads_id)->update($leadstatus);
      }
      CrmLead::where('leads_id', $leads_id)->update($data);
    }

    if($saved_from == "CD"){
      $client_id     = $details['client_id'];
      $tab_no        = $details['tab_no'];
      $encoded_type  = $details['encoded_type'];
      Client::where('client_id', $client_id)->update(array('crm_leads_id'=>$last_id));
      //return Redirect::to('/renewals/'.$client_id.'/'.$encoded_type.'/'.$tab_no);
    }

    $data['leads_id']  = $last_id;
    echo json_encode($data);
    //print_r($data);die;
  }

    public function save_new_leads()
    {
        $data = array();
        $session = Session::get('admin_details');
        $user_id = $session['id'];

        $details = Input::get();
        $encode_page_open = $details['encode_page_open'];
        $encode_owner_id = $details['encode_owner_id'];
        $type = $details['new_type'];
        $leads_id = $details['new_leads_id'];

        if ($type == "ind") {
            $data['prospect_title'] = $details['new_prospect_title'];
            $data['prospect_fname'] = $details['new_prospect_fname'];
            $data['prospect_lname'] = $details['new_prospect_lname'];
        } else {
            $data['business_type'] = isset($details['new_business_type'])?$details['new_business_type']:
                "0";
            $data['prospect_name'] = $details['new_prospect_name'];
            $data['contact_title'] = $details['new_contact_title'];
            $data['contact_fname'] = $details['new_contact_fname'];
            $data['contact_lname'] = $details['new_contact_lname'];
        }
        $data['user_id']        = $user_id;
        $data['leads_type']     = "L";
        $data['client_type']    = $details['new_type'];
        $data['date']           = date('Y-m-d', strtotime($details['new_lead_date']));
        $data['deal_owner']     = isset($details['new_deal_owner']) ? $details['new_deal_owner']:"0";
        $data['phone']          = $details['new_phone'];
        $data['mobile']         = $details['new_mobile'];
        $data['email']          = $details['new_email'];
        $data['website']        = $details['new_website'];
        $data['lead_source']    = isset($details['new_lead_source']) ? $details['new_lead_source'] :
            "0";
        $data['industry']       = isset($details['new_industry']) ? $details['new_industry'] : "0";
        $data['notes']          = $details['new_notes'];

        if ($leads_id == 0) {
            $last_id = CrmLead::insertGetId($data);
            $leadstatus['user_id'] = $user_id;
            $leadstatus['leads_id'] = $last_id;
            $leadstatus['leads_tab_id'] = 11;
            $leadstatus['created'] = date("Y-m-d H:i:s");
            CrmLeadsStatus::insert($leadstatus);
        } else {
            CrmLead::where('leads_id', '=', $leads_id)->update($data);
        }

        return Redirect::to('/crm/' . $encode_page_open . '/' . $encode_owner_id.'/leads');
        //print_r($data);die;
    }

    public function add_new_source()
    {
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $data['user_id']        = $user_id;
        $data['status']         = "new";
        $data['is_show']        = Input::get("client_type");
        $data['source_name']    = Input::get("source_name");
        $last_id = LeadSource::insertGetId($data);
        echo $last_id;
    }

    public function delete_source_name()
    {
        $source_id = Input::get("field_id");
        LeadSource::where("source_id", "=", $source_id)->delete();
        echo $source_id;
    }

    public function get_form_dropdown()
    {
        $data = array();
        $client_data = array();
        $leads_details = array();
        $leads_details['date'] = date("d-m-Y");
        $type = Input::get("type");
        $leads_id = Input::get("leads_id");

        //======== Client Details ========//
        /*if ($type == "ind") {
            $existing_clients = Client::getAllIndClientDetails();
            if (isset($existing_clients) && count($existing_clients) > 0) {
                foreach ($existing_clients as $key => $value) {
                    $client_data[$key]['client_id'] = $value['client_id'];
                    $client_data[$key]['client_name'] = $value['client_name'];
                }
            }
        } else {
            $existing_clients = Client::getAllOrgClientDetails();
            if (isset($existing_clients) && count($existing_clients) > 0) {
                foreach ($existing_clients as $key => $value) {
                    $client_data[$key]['client_id'] = isset($value['client_id'])?$value['client_id']:'';
                    $client_data[$key]['client_name'] = isset($value['business_name'])?$value['business_name']:'';
                }
            }
        }


        if (isset($client_data) && count($client_data) > 0) {
            foreach ($client_data as $value) {
                $client_name[] = strtolower($value['client_name']);
            }
            array_multisort($client_name, SORT_ASC, $client_data);
        }*/
        //======== Client Details ========//

        $client_data = Client::getAllClientsByType($type, '');

        if ($leads_id != '0') {
            $leads_details = CrmLead::getLeadsByLeadsId($leads_id);
        } else {
            $leads_details['deal_certainty'] = 100;
        }

        $data['leads_details'] = $leads_details;
        $data['existing_clients'] = $client_data;

        echo json_encode($data);
    }

    public function save_edit_status()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $step_id = Input::get('step_id');
        //CrmLeadsTab
        $type = Input::get('type');
        if (isset($type) && $type == "title") {
            $data['tab_name'] = Input::get("status_name");
            $title = $data['tab_name'];
        } else {
            $value = LeadsTabManage::whereIn("user_id", $groupUserId)->where("tab_id", "=", $step_id)->first();
            if ($value['status'] == "S") {
                $data['status'] = "H";
            } else {
                $data['status'] = "S";
            }
            $title = $value['tab_name'];
        }
        $sql = LeadsTabManage::whereIn("user_id", $groupUserId)->where("tab_id", "=", $step_id)->update($data);

        echo $title;
        exit;
    }

    public function delete_leads_details()
    {
        $leads_ids = Input::get('leads_delete_id');//print_r($leads_ids);die;
        foreach ($leads_ids as $leads_id) {
            CrmLead::where('leads_id', $leads_id)->update(array('is_deleted' => 'Y'));
            CrmLeadsStatus::where('leads_id', $leads_id)->delete();
        }
    }

    public function sendto_another_tab()
    {
        $session = Session::get('admin_details');
        $user_id = $session['id'];

        $data['leads_tab_id'] = Input::get('tab_id');
        $data['leads_id'] = Input::get('leads_id');
        $data['user_id'] = $user_id;

        $leads_status = CrmLeadsStatus::getDetailsByLeadsId($data['leads_id']);
        if (isset($leads_status) && count($leads_status) > 0) {
            CrmLeadsStatus::where("leads_status_id", "=", $leads_status['leads_status_id'])->
                update($data);
            $last_id = $leads_status['leads_status_id'];
        } else {
            $data['created'] = date("Y-m-d H:i:s");
            $last_id = CrmLeadsStatus::insertGetId($data);
        }
        echo $last_id;
    }

    public function get_client_address()
    {
        $data = array();
        $client_id = Input::get('client_id');
        $client_type = Input::get('client_type');
        $details = Common::clientDetailsById($client_id);
        if ($client_type == "org") {
            $type = "corres";
            $data['address'] = ContactAddress::getClientContactAddress($client_id, $type);
            if (isset($details['business_name'])) {
                $data['address']['business_name'] = $details['business_name'];
            }
            if (isset($details['business_type'])) {
                if (strtolower($details['business_type']) == "llp") {
                    $business_type = 1;
                }
                if (strtolower($details['business_type']) == "company") {
                    $business_type = 2;
                }
                if (strtolower($details['business_type']) == "partnership") {
                    $business_type = 3;
                }
                if (strtolower($details['business_type']) == "sole trader") {
                    $business_type = 4;
                }
                $data['address']['business_type'] = $business_type;
            }
            if (isset($details['corres_cont_name'])) {
                $name = explode(" ", $details['corres_cont_name']);
                $data['address']['contact_fname'] = isset($name[0]) ? $name[0] : "";
                $data['address']['contact_lname'] = isset($name[1]) ? $name[1] : "";
            }
        } else {
            $type = "res";
            $data['address'] = ContactAddress::getClientContactAddress($client_id, $type);
            if (isset($details['title'])) {
                $data['address']['prospect_title'] = $details['title'];
            }
            if (isset($details['fname'])) {
                $data['address']['prospect_fname'] = $details['fname'];
            }
            if (isset($details['lname'])) {
                $data['address']['prospect_lname'] = $details['lname'];
            }

        }

        $data['existing_clients']   = $this->get_all_contact($client_type);
        $data['relationship']       = Common::get_relationship_client($client_id);
        $data['contacts']           = ContactAddress::getContactNameAndIdByClientId($client_id);
        //print_r($data);

        echo json_encode($data);
        exit;
    }

    public function get_all_contact($type)
    {
        $client_data = array();
        //======== Client Details ========//
        if ($type == "ind") {
            $existing_clients = Client::getAllIndClientDetails();
            if (isset($existing_clients) && count($existing_clients) > 0) {
                foreach ($existing_clients as $key => $value) {
                    $client_data[$key]['client_id'] = $value['client_id'];
                    $client_data[$key]['client_name'] = $value['client_name'];
                }
            }
        } else {
            $existing_clients = Client::getAllOrgClientDetails();
            if (isset($existing_clients) && count($existing_clients) > 0) {
                foreach ($existing_clients as $key => $value) {
                    $client_data[$key]['client_id'] = isset($value['client_id'])?$value['client_id']:'';
                    $client_data[$key]['client_name'] = isset($value['business_name'])?$value['business_name']:'';
                }
            }
        }

        if (isset($client_data) && count($client_data) > 0) {
            foreach ($client_data as $value) {
                $client_name[] = strtolower($value['client_name']);
            }
            array_multisort($client_name, SORT_ASC, $client_data);
        }
        //======== Client Details ========//

        return $client_data;
    }

    /*public function show_graph()
    {
    $data = array();
    $month      = Input::get('month');
    $year       = Input::get('year');
    $compare    = Input::get('compare');
    $day = $this->getDay($month, $year);
    ///////////////////////////
    $to_date    = $day.'-'.$month.'-'.$year;
    $from_date  = date('d-m-Y', strtotime('-1 months', strtotime('01-'.$month.'-'.$year)));
    //////////////////////////
    //echo $from_date."=".$to_date;die;
    $divided_by = 1000;

    $details = CrmLead::getDataWithDateRange($from_date, $to_date);
    $jan_total = $feb_total = $mar_total = $apr_total = $may_total = $jun_total = $jul_total = $aug_total = $sep_total = $oct_total = $nov_total = $dec_total = 0;
    if(isset($details) && count($details) >0){
    foreach ($details as $key => $value) {
    $date = explode("-", $value['date']);
    $month = $date[1];
    if($month == "01"){
    $jan_total += $value['quoted_value'];
    //$jan_won += $value['quoted_value'];
    }
    if($month == "02"){
    $feb_total += $value['quoted_value'];
    }
    if($month == "03"){
    $mar_total += $value['quoted_value'];
    }
    if($month == "04"){
    $apr_total += $value['quoted_value'];
    }
    if($month == "05"){
    $may_total += $value['quoted_value'];
    }
    if($month == "06"){
    $jun_total += $value['quoted_value'];
    }
    if($month == "07"){
    $jul_total += $value['quoted_value'];
    }
    if($month == "08"){
    $aug_total += $value['quoted_value'];
    }
    if($month == "09"){
    $sep_total += $value['quoted_value'];
    }
    if($month == "10"){
    $oct_total += $value['quoted_value'];
    }
    if($month == "11"){
    $nov_total += $value['quoted_value'];
    }
    if($month == "12"){
    $dec_total += $value['quoted_value'];
    }
    }
    }
    $data['jan_total'] = $jan_total/$divided_by;
    $data['feb_total'] = $feb_total/$divided_by;
    $data['mar_total'] = $mar_total/$divided_by;
    $data['apr_total'] = $apr_total/$divided_by;
    $data['may_total'] = $may_total/$divided_by;
    $data['jun_total'] = $jun_total/$divided_by;
    $data['jul_total'] = $jul_total/$divided_by;
    $data['aug_total'] = $aug_total/$divided_by;
    $data['sep_total'] = $sep_total/$divided_by;
    $data['oct_total'] = $oct_total/$divided_by;
    $data['nov_total'] = $nov_total/$divided_by;
    $data['dec_total'] = $dec_total/$divided_by;
    //print_r($data);
    //Common::last_query();
    echo view::make("crm/ajax.graph", $data);
    }*/
    public function show_graph()
    {
        $data = array();
        $month = Input::get('month');
        $year = Input::get('year');
        $compare = Input::get('compare');
        $day = $this->getDay($month, $year);
        ///////////////////////////
        $to_date = $year . '-' . $month . '-' . $day;
        $from_date = date('Y-m-d', strtotime('-' . $compare . ' months', strtotime('01-' .
            $month . '-' . $year)));
        //$from_year = explode('-', $from_date);
        //////////////////////////
        //echo $from_date."=".$to_date;die;
        $divided_by = 1000;

        $lead_status = CrmLeadsStatus::leadsStatusByTabId(11); //print_r($lead_status);die;
        if (isset($lead_status) && count($lead_status) > 0) {
            $jan_total = $feb_total = $mar_total = $apr_total = $may_total = $jun_total = $jul_total =
                $aug_total = $sep_total = $oct_total = $nov_total = $dec_total = 0;
            $jan_year = $feb_year = $mar_year = $apr_year = $may_year = $jun_year = $jul_year =
                $aug_year = $sep_year = $oct_year = $nov_year = $dec_year = '';
            foreach ($lead_status as $i => $row) {
                $details = CrmLead::getDataWithDateRangeAndLeadsId($from_date, $to_date, $row['leads_id']);
                //echo $this->last_query();
                if (isset($details) && count($details) > 0) {
                    foreach ($details as $key => $value) {
                        $date = explode("-", $value['date']);
                        $month = $date[1];
                        $year = $date[2];
                        if (isset($value['quoted_value']) && $value['quoted_value'] != "") {
                            $quoted_value = str_replace(',', '', $value['quoted_value']);
                        } else {
                            $quoted_value = 0;
                        }

                        if ($month == "01") {
                            $jan_total += $quoted_value;
                            $jan_year = '"Jan-' . $year . '"';
                        }
                        if ($month == "02") {
                            $feb_total += $quoted_value;
                            $feb_year = '"Feb-' . $year . '"';
                        }
                        if ($month == "03") {
                            $mar_total += $quoted_value;
                            $mar_year = '"Mar-' . $year . '"';
                        }
                        if ($month == "04") {
                            $apr_total += $quoted_value;
                            $apr_year = '"Apr-' . $year . '"';
                        }
                        if ($month == "05") {
                            $may_total += $quoted_value;
                            $may_year = '"May-' . $year . '"';
                        }
                        if ($month == "06") {
                            $jun_total += $quoted_value;
                            $jun_year = '"Jun-' . $year . '"';
                        }
                        if ($month == "07") {
                            $jul_total += $quoted_value;
                            $jul_year = '"Jul-' . $year . '"';
                        }
                        if ($month == "08") {
                            $aug_total += $quoted_value;
                            $aug_year = '"Aug-' . $year . '"';
                        }
                        if ($month == "09") {
                            $sep_total += $quoted_value;
                            $sep_year = '"Sept-' . $year . '"';
                        }
                        if ($month == "10") {
                            $oct_total += $quoted_value;
                            $oct_year = '"Oct-' . $year . '"';
                        }
                        if ($month == "11") {
                            $nov_total += $quoted_value;
                            $nov_year = '"Nov-' . $year . '"';
                        }
                        if ($month == "12") {
                            $dec_total += $quoted_value;
                            $dec_year = '"Dec-' . $year . '"';
                        }
                    }
                }
            }
        }

        $data['jan_total'] = $jan_total / $divided_by;
        $data['feb_total'] = $feb_total / $divided_by;
        $data['mar_total'] = $mar_total / $divided_by;
        $data['apr_total'] = $apr_total / $divided_by;
        $data['may_total'] = $may_total / $divided_by;
        $data['jun_total'] = $jun_total / $divided_by;
        $data['jul_total'] = $jul_total / $divided_by;
        $data['aug_total'] = $aug_total / $divided_by;
        $data['sep_total'] = $sep_total / $divided_by;
        $data['oct_total'] = $oct_total / $divided_by;
        $data['nov_total'] = $nov_total / $divided_by;
        $data['dec_total'] = $dec_total / $divided_by;

        $data['months'] = $jan_year . ', ' . $feb_year . ', ' . $mar_year . ', ' . $apr_year .
            ', ' . $may_year . ', ' . $jun_year . ', ' . $jul_year . ', ' . $aug_year . ', ' .
            $sep_year . ', ' . $oct_year . ', ' . $nov_year . ', ' . $dec_year;
        //print_r($data);
        //Common::last_query();
        echo view::make("crm/ajax.graph", $data);
    }

    public function getDay($month, $year)
    {
        if ($month == '01' || $month == '03' || $month == '05' || $month == '07' || $month ==
            '08' || $month == '10' || $month == '12') {
            $day = 31;
        } else
            if ($month == '04' || $month == '06' || $month == '09' || $month == '11') {
                $day = 30;
            } else {
                $value = $year % 4;
                if ($value == 0) {
                    $day = 28;
                } else {
                    $day = 29;
                }
            }
            return $day;
    }

    public function archive_leads()
    {
        $leads_ids  = Input::get("leads_ids");
        $status     = Input::get("status");
        $tab_id     = Input::get("tab_id");
        if($tab_id == 8){
            Session::put('won_show_archive', 'Y');
        }
        if($tab_id == 9){
            Session::put('lost_show_archive', 'Y');
        }

        //print_r($clients_id);die;
        foreach ($leads_ids as $leads_id) {
            if ($status == "Archive") {
                $up_data['is_archive'] = 'Y';
                $up_data['show_archive'] = 'Y';
            } else {
                $up_data['is_archive'] = 'N';
                $up_data['show_archive'] = 'N';
            }
            CrmLead::where('leads_id', '=', $leads_id)->update($up_data);
        }
    }

    public function show_archive_leads()
    {
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];

        $is_archive = Input::get("is_archive");
        $tab_id     = Input::get("tab_id");
        //echo $is_archive;die;
        if ($is_archive == "Y") {
            if($tab_id == 8){
                Session::put('won_show_archive', 'Y');
            }
            if($tab_id == 9){
                Session::put('lost_show_archive', 'Y');
            }
        } else {
            if($tab_id == 8){
                Session::put('won_show_archive', 'N');
            }
            if($tab_id == 9){
                Session::put('lost_show_archive', 'N');
            }
        }

        $group_leads_id = CrmLeadsStatus::leadsStatusByTabId($tab_id);

        if(isset($group_leads_id) && count($group_leads_id) >0){
            foreach ($group_leads_id as $key => $value) {
                $affected = CrmLead::whereIn("user_id", $groupUserId)->where("show_archive", "=", "Y")->where("leads_id", $value['leads_id'])->update(array("is_archive" => $is_archive));
            }
            
        }
        //echo $this->last_query();die;
    }

    public function graph_page()
    {
        $data = array();
        $data['heading'] = "GRAPH";
        $data['previous_page'] = '<a href="/crm/MTE=/YWxs">Crm</a>';
        $data['back_url'] = '/crm/MTE=/YWxs';
        $data['title'] = "Graph";
        $data['sub_title'] = "Graph";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];

        $data['months'] = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December');

        return view::make("crm/graph_page", $data);
    }

    public function report()
    {
        $data = array();
        $data['heading'] = "CLOSED DEAL REPORTS";
        //$data['previous_page'] = '<a href="/crm/MTE=/YWxs">CRM</a>';
        $data['back_url'] = '/crm/MTE=/YWxs';
        $data['title'] = "CRM";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];

        $data['staff_details'] = User::getAllStaffDetails();

        return view::make("crm/report", $data);
    }


    public function renewals()
    {
        $data = array();
        $data['heading'] = "Renewals";
        $data['previous_page'] = '<a href="/crm/MTE=/YWxs">Crm</a>';
        $data['title'] = "Renewals";

        return view::make("crm/renewals", $data);
    }

    public function show_leads_report()
    {
        $data   = array();
        $data1  = array();
        $where  = array();
        
        $session    = Session::get('admin_details');
        $user_id    = $session['id'];
        $groupUserId = $session['group_users'];

        $details    = Input::get();
        $status_id  = $details['status_id'];
        $user_id    = $details['user_id'];
        $is_deleted = $details['is_deleted'];
        $is_archive = $details['is_archive'];
        $date_from  = date('Y-m-d', strtotime($details['date_from']));
        $date_to    = date('Y-m-d', strtotime($details['date_to']));

        if (isset($status_id) && $status_id != "") {
            $where['cls.leads_tab_id'] = $status_id;
        }

        if (isset($user_id) && $user_id != "") {
            if ($user_id == "unassigned") {
                $where['cl.deal_owner'] = 0;
                $converson_user = "0";
            } else {
                $where['cl.deal_owner'] = $user_id;
                $converson_user = $user_id;
            }
        } else {
            $converson_user = "all";
        }

        if (isset($is_deleted) && $is_deleted == "N") {
            $where['cl.is_deleted'] = 'N';
        }

        if (isset($is_archive) && $is_archive == 'N') {
            $where['cl.is_archive'] = 'N';
        }
        //echo $user_id;die;
        $details = DB::table('crm_leads_statuses as cls')->whereIn("cl.user_id", $groupUserId)->
            where($where)->where('cl.close_date', '!=', '0000-00-00')->whereBetween('cl.date', array($date_from, $date_to))->join('crm_leads as cl',
            'cls.leads_id', '=', 'cl.leads_id')->join('crm_leads_tabs as clt', 'clt.tab_id',
            '=', 'cls.leads_tab_id')->select('cl.*', 'clt.tab_name')->get();

        //echo $this->last_query();die;
        $outer_details = DB::table('crm_leads_statuses as cls')->whereIn("cl.user_id", $groupUserId)->
            where($where)->where('cl.close_date', '!=', '0000-00-00')->whereBetween('cl.date', array($date_from, $date_to))->join('crm_leads as cl',
            'cls.leads_id', '=', 'cl.leads_id')->groupBy('cl.deal_owner')->select('cl.deal_owner')->
            get();

        //echo $this->last_query();die;
        $avg_age = $total_amount = 0;
        $count = 1;
        $won = $lost = 0;
        if (isset($details) && count($details) > 0) {
            foreach ($details as $key => $row) {
                if (isset($row->deal_owner) && $row->deal_owner != "0") {
                    $name = User::getStaffNameById($row->deal_owner);
                } else {
                    $name = "";
                }

                if ($row->client_type == 'org') {
                    $prospect_name = $row->prospect_name;
                } else {
                    $prospect_name = $row->prospect_title . " " . $row->prospect_fname . " " . $row->
                        prospect_lname;
                }

                $data1[$key]['leads_id'] = $row->leads_id;
                $data1[$key]['deal_owner'] = $row->deal_owner;
                $data1[$key]['deal_owner_name'] = $name;
                $data1[$key]['prospect_name'] = $prospect_name;
                $data1[$key]['close_date'] = date('d-m-Y', strtotime($row->date));
                $data1[$key]['tab_name'] = $row->tab_name;
                $data1[$key]['quoted_value'] = number_format(str_replace(',', '', $row->
                    quoted_value), 2);
                $data1[$key]['age'] = $this->getAgeCount($row->date, date('Y-m-d'));

                $avg_age += $data1[$key]['age'];
                $count++;
            }
            $count--;
        }
        $data['details'] = $data1;
        $data['outer_details'] = $outer_details;
        $data['avg_age'] = $avg_age / $count;

        /////////////Converson Rate////////////
        $leads_details = CrmLead::getDataWithDateRange($date_from, $date_to);
        if (isset($leads_details) && count($leads_details) > 0) {
            foreach ($leads_details as $key => $value) {
                if ($converson_user == "all") {
                    $tab_id = CrmLeadsStatus::getTabIdByLeadsId($value['leads_id']);
                    if (isset($tab_id) && $tab_id == '8') {
                        $won++;
                    }
                    if (isset($tab_id) && $tab_id == '9') {
                        $lost++;
                    }
                } else {
                    if ($value['deal_owner_id'] == $converson_user) {
                        $tab_id = CrmLeadsStatus::getTabIdByLeadsId($value['leads_id']);
                        if (isset($tab_id) && $tab_id == '8') {
                            $won++;
                        }
                        if (isset($tab_id) && $tab_id == '9') {
                            $lost++;
                        }
                    }
                }

            }

        }

        if (($won + $lost) == 0) {
            $data['converson_rate'] = 0;
        } else {
            $data['converson_rate'] = $won * 100 / ($won + $lost);
        }

        //echo "Total : ".($won + $lost);die;
        /////////////Converson Rate////////////
        //print_r($data);die;
        echo view::make("crm/ajax/report", $data);
    }

    public function getAgeCount($from, $date2)
    {
        $days = 0;
        if ($from != "") {
            $date1 = $from;
            //$date2 = date("Y-m-d");
            //echo $date2;die;

            $diff = strtotime($date2) - strtotime($date1);
            $days = round($diff / 86400);
        }

        return $days;
    }

    public function getDealAge($date1, $date2)
    {
        $days = 0;//echo $date2;die;
        if ($from != "") {
            $diff = strtotime($date2) - strtotime($date1);
            $days = round($diff / 86400);
        }

        return $days;
    }


    public function inboxmail()
    {

        return view::make("crm/inboxmail");
    }


    public function save_close_date()
    {
        $leads_id      = Input::get("leads_id");
        $close_date    = Input::get("close_date");

        $up_data['close_date'] = date('Y-m-d', strtotime($close_date));
        CrmLead::where('leads_id', '=', $leads_id)->update($up_data);
    }

    public function getTabNo($page_open)
    {
        $tab_no = 1;
        if($page_open == 11){
            $tab_no = 1;
        }
        if($page_open == 2 || $page_open == 21 || $page_open == 22){
            $tab_no = 2;
        }
        if($page_open == 3 || $page_open == 31 || $page_open == 32 || $page_open == 33 || $page_open == 34 || $page_open == 35 || $page_open == 36 || $page_open == 37 || $page_open == 38){
            $tab_no = 3;
        }
        if($page_open == 4 || $page_open == 41 || $page_open == 42 || $page_open == 43){
            $tab_no = 4;
        }
        if($page_open == 51 || $page_open == 511 || $page_open == 512 || $page_open == 513){
            $tab_no = 5;
        }
        if($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617 || $page_open == 62 || $page_open == 63 || $page_open == 64 || $page_open == 65){
            $tab_no = 6;
        }
        if($page_open == 7){
            $tab_no = 7;
        }
        if($page_open == 8){
            $tab_no = 8;
        }
        if($page_open == 9){
            $tab_no = 9;
        }

        return $tab_no;
    }

    public function sendto_client_list()
    {
      $leads_id       = Input::get("leads_id");
      $client_type    = Input::get("client_type");
      $ld             = CrmLead::getLeadsByLeadsId( $leads_id );
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];
      $client_id = 0;

      if(isset($ld) && count($ld) >0){
        if(isset($ld['client_type']) && $ld['client_type'] == 'org'){
          $company_name = $ld['prospect_name'];
          if(isset($ld['business_type']) && ($ld['business_type']==1 || $ld['business_type']==2)){
            //$company_name  = "LYSTABLE INDUSTRIES LTD";
            $number = CrmLead::getCompanyNumber($company_name);
            //echo $number;die;
            $client_id = 0;
            if(isset($number) && $number != '0'){
              $value = $number.'=function';//echo $value;die;
              $client_id  = App::make('ChdataController')->import_company_details($value);
            }
          }else{
            $client_id = Client::insertGetId(array("user_id"=>$user_id,'type'=>'org','chd_type'=>'org'));
            //StepsFieldsClient::update_org_client($ld, $client_id);
          }
          StepsFieldsClient::update_org_client($ld, $client_id);

          if($client_id != 0){
            CrmLead::where('leads_id', $leads_id)->update(array('is_onboarding'=>'Y'));
            Client::where('client_id', $client_id)->update(array('is_onboard' => 'Y'));
            //StepsFieldsClient::update_step_field_client($ld, $client_id);

          }else{
            $client_id  = 'spell_check';
          }
            
        }else{
          $indClnt['user_id']     = $user_id;
          $indClnt['type']        = 'ind';
          $indClnt['chd_type']    = 'ind';
          $indClnt['is_onboard']  = 'Y';

          $client_id = Client::insertGetId($indClnt);
          CrmLead::where('leads_id', $leads_id)->update(array('is_onboarding'=>'Y'));
          StepsFieldsClient::update_ind_client($ld, $client_id);
        }
        Client::where('client_id', $client_id)->update(array('crm_leads_id' => $leads_id));
        $crm_proposal_id = CrmLead::getCrmProposalIdByLeadsId($leads_id);
        if(isset($crm_proposal_id) && $crm_proposal_id >0){
          $cpsl['client_id']      = $client_id;
          $cpsl['prospect_id']    = $client_id;
          $cpsl['contact_type']   = 'c_'.$ld['client_type'];
          CrmProposal::where('crm_proposal_id',$crm_proposal_id)->update($cpsl);


          $proposalId = CrmProposal::getProposalIdByCrmProposalId($crm_proposal_id);
          Todolistnewtask::saveProposalServicesToWip($proposalId, $groupUserId);

        }
      }
      

      echo $client_id;die;
    }
    
    public function crmpdf($page_open,$owner_id){
        
        //echo $page_open;die();
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
        $data['leads'] = array();

        $data['heading'] = "CRMPDF";
        $data['title'] = "CrmPdf";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
        $won_value = Session::get('won_show_archive');
        $lost_value = Session::get('lost_show_archive');
        if (isset($won_value) && $won_value == 'Y') {
            $data['won_archive'] = 'Show Archived';
        } else {
            $data['won_archive'] = 'Hide Archived';
        }
        if (isset($lost_value) && $lost_value == 'Y') {
            $data['lost_archive'] = 'Show Archived';
        } else {
            $data['lost_archive'] = 'Hide Archived';
        }

        $data['page_open']          = base64_decode($page_open); 
        $data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id;
        $data['owner_id']           = base64_decode($owner_id);
        $data['goto_url']           = "/crm";
        $data['tab_no']             = $this->getTabNo($data['page_open']); //die();

        switch ($data['page_open']) {
            case '2':
                $data['tab21_details']  = $this->getTabTwoOneDetails($data['page_open']);
                break;
            case '21':
                $data['tab21_details']  = $this->getTabTwoOneDetails($data['page_open']);
                break;
            case '22':
                $data['tab22_details']  = $this->getTabTwoTwoDetails($data['page_open']);
                break;
            
            default:
                
                break;
        }
        
        
        //echo '<pre>';print_r($data['tab22_details']);die();
        
        $data['leads_details'] = array();
        //echo "<pre>";print_r($data);die;
        $data['titles'] = Title::orderBy("title_id")->get();
        $data['countries'] = Country::orderBy('country_name')->get();
        $data['old_org_types'] = OrganisationType::where("client_type", "=", "all")->
            orderBy("name")->get();
        $data['new_org_types'] = OrganisationType::where("client_type", "=", "org")->
            whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->
            get();
        $data['industry_lists'] = IndustryList::getIndustryList();
        $data['staff_details'] = User::getAllStaffDetails();
        $data['old_lead_sources'] = LeadSource::getOldLeadSource();
        $data['new_lead_sources'] = LeadSource::getNewLeadSource();
        $data['leads_tabs'] = CrmLeadsTab::getAllTabDetails(); 

        $data['invoice_leads_details'] = CrmLead::getInvoiceLeadsDetails();
        $data['leads_details'] = CrmLead::getAllOpportunity();
        
        $total = 0;
        $average = 0;
        $likely = 0;
        $all_count = 0;
        if (isset($data['leads_details']) && count($data['leads_details']) > 0) {
            foreach ($data['leads_details'] as $key => $value) {
                if(isset($value['lead_status']) && ($value['lead_status'] != 8 && $value['lead_status'] != 9 && $value['lead_status'] != 10)){
                    $quoted_value = str_replace(",", "", $value['quoted_value']);
                    $total += $quoted_value;
                    $likely += ($value['deal_certainty'] * $quoted_value) / 100;

                    $status = CrmLeadsStatus::getDetailsByLeadsId($value['leads_id']);
                    //echo $this->last_query();
                    if (isset($status['leads_tab_id']) && ($status['leads_tab_id'] == 8 || $status['leads_tab_id'] == 9 || $status['leads_tab_id'] == 10)) {
                        $date = explode(' ', $status['likely']);
                        $data['leads_details'][$key]['deal_age'] = $this->getDealAge($value['date'], $date[0]);
                    } else {
                        $data['leads_details'][$key]['deal_age'] = $this->getAgeCount($value['date'], date('Y-m-d'));
                    }
                    $all_count++;
                    
                }
            }
            if(isset($all_count) && $all_count != 0){
                $average = $total/$all_count;
            }
        }
        $data['all_count']      = $all_count;
        $data['all_total']      = number_format($total, 2);
        $data['all_average']    = number_format($average, 2);
        $data['all_likely']     = number_format($likely, 2);

        //=================LEADS TAB ===================//
        if($data['tab_no'] == 5){
            $leads = $this->leadstabDetails();
            $data['leads'] = $leads;
        }
        
        //echo "<pre>";print_r($data['tab21_details']);echo "</pre>";die;
        $pdf = PDF::loadView('crm.pdfcrm', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
		
        
        if($data['page_open']== '51')
        {
            $filename="CRM_LEADS";
        }
        
        else if($data['page_open']== '2' || $data['page_open']== '21')
        {
            $filename="CRMorganization_clientdetails";
        }
        
        else if($data['page_open']== '22')
        {
            $filename="CRMindividual_clientdetails";
        }
       
        else if($data['page_open']== '611' || $data['page_open']== '612' || $data['page_open']== '613' || $data['page_open']== '614' || $data['page_open']== '615' || $data['page_open']== '616'|| $data['page_open']== '617')
        {
            $filename="CRMOPPORTUNITIES_OPENED";
        }
        
        else if($data['page_open']=='62')
        {
            $filename="CRMOPPORTUNITIES_CLOSED_WON";
        }
        else if($data['page_open']=='63')
        {
            $filename="CRMOPPORTUNITIES_CLOSED_LOST";
        }
        
        else if($data['page_open']=='64')
        {
            $filename="CRMOPPORTUNITIES_COLD";
        }
        else{
            $filename="Crm";
        }
        return $pdf->download($filename.'.pdf');
        //return View::make('crm.pdfcrm', $data);die();
    
        
    }
    
    
    
    public function pdfreport($status,$owner,$from,$to,$isdeleted,$isarchive){
        
        $data   = array();
        $data1  = array();
        $where  = array();
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
        $session    = Session::get('admin_details');
        $user_id    = $session['id'];
        $groupUserId = $session['group_users'];

        //$details    = Input::get();
        $status_id  = $status;
        $user_id    = $owner;
        $is_deleted = $isdeleted;
        $is_archive = $isarchive;
        $date_from  = date('Y-m-d', strtotime($from));
        $date_to    = date('Y-m-d', strtotime($to));

        if (isset($status_id) && $status_id != "") {
            $where['cls.leads_tab_id'] = $status_id;
        }

        if (isset($user_id) && $user_id != "") {
            if ($user_id == "unassigned") {
                $where['cl.deal_owner'] = 0;
                $converson_user = "0";
            } else {
                $where['cl.deal_owner'] = $user_id;
                $converson_user = $user_id;
            }
        } else {
            $converson_user = "all";
        }

        if (isset($is_deleted) && $is_deleted == "N") {
            $where['cl.is_deleted'] = 'N';
        }

        if (isset($is_archive) && $is_archive == 'N') {
            $where['cl.is_archive'] = 'N';
        }
        //echo $user_id;die;
        $details = DB::table('crm_leads_statuses as cls')->whereIn("cl.user_id", $groupUserId)->
            where($where)->where('cl.close_date', '!=', '0000-00-00')->whereBetween('cl.date', array($date_from, $date_to))->join('crm_leads as cl',
            'cls.leads_id', '=', 'cl.leads_id')->join('crm_leads_tabs as clt', 'clt.tab_id',
            '=', 'cls.leads_tab_id')->select('cl.*', 'clt.tab_name')->get();

        //echo $this->last_query();die;
        $outer_details = DB::table('crm_leads_statuses as cls')->whereIn("cl.user_id", $groupUserId)->
            where($where)->where('cl.close_date', '!=', '0000-00-00')->whereBetween('cl.date', array($date_from, $date_to))->join('crm_leads as cl',
            'cls.leads_id', '=', 'cl.leads_id')->groupBy('cl.deal_owner')->select('cl.deal_owner')->
            get();

        //echo $this->last_query();die;
        $avg_age = $total_amount = 0;
        $count = 1;
        $won = $lost = 0;
        if (isset($details) && count($details) > 0) {
            foreach ($details as $key => $row) {
                if (isset($row->deal_owner) && $row->deal_owner != "0") {
                    $name = User::getStaffNameById($row->deal_owner);
                } else {
                    $name = "";
                }

                if ($row->client_type == 'org') {
                    $prospect_name = $row->prospect_name;
                } else {
                    $prospect_name = $row->prospect_title . " " . $row->prospect_fname . " " . $row->
                        prospect_lname;
                }

                $data1[$key]['leads_id'] = $row->leads_id;
                $data1[$key]['deal_owner'] = $row->deal_owner;
                $data1[$key]['deal_owner_name'] = $name;
                $data1[$key]['prospect_name'] = $prospect_name;
                $data1[$key]['close_date'] = date('d-m-Y', strtotime($row->date));
                $data1[$key]['tab_name'] = $row->tab_name;
                $data1[$key]['quoted_value'] = number_format(str_replace(',', '', $row->
                    quoted_value), 2);
                $data1[$key]['age'] = $this->getAgeCount($row->date, date('Y-m-d'));

                $avg_age += $data1[$key]['age'];
                $count++;
            }
            $count--;
        }
        $data['details'] = $data1;
        $data['outer_details'] = $outer_details;
        $data['avg_age'] = $avg_age / $count;

        /////////////Converson Rate////////////
        $leads_details = CrmLead::getDataWithDateRange($date_from, $date_to);
        if (isset($leads_details) && count($leads_details) > 0) {
            foreach ($leads_details as $key => $value) {
                if ($converson_user == "all") {
                    $tab_id = CrmLeadsStatus::getTabIdByLeadsId($value['leads_id']);
                    if (isset($tab_id) && $tab_id == '8') {
                        $won++;
                    }
                    if (isset($tab_id) && $tab_id == '9') {
                        $lost++;
                    }
                } else {
                    if ($value['deal_owner_id'] == $converson_user) {
                        $tab_id = CrmLeadsStatus::getTabIdByLeadsId($value['leads_id']);
                        if (isset($tab_id) && $tab_id == '8') {
                            $won++;
                        }
                        if (isset($tab_id) && $tab_id == '9') {
                            $lost++;
                        }
                    }
                }

            }

        }

        if (($won + $lost) == 0) {
            $data['converson_rate'] = 0;
        } else {
            $data['converson_rate'] = $won * 100 / ($won + $lost);
        }

        //echo "Total : ".($won + $lost);die;
        /////////////Converson Rate////////////
        //print_r($data);die;
        $pdf = PDF::loadView('crm/ajax/pdfreport', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
		return $pdf->download('CrmDealreport.pdf');
        //echo view::make("", $data);
    
    }


    public function excelreport($status,$owner,$from,$to,$isdeleted,$isarchive){
        
        $data   = array();
        $data1  = array();
        $where  = array();
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
        $session    = Session::get('admin_details');
        $user_id    = $session['id'];
        $groupUserId = $session['group_users'];

        //$details    = Input::get();
        $status_id  = $status;
        $user_id    = $owner;
        $is_deleted = $isdeleted;
        $is_archive = $isarchive;
        $date_from  = date('Y-m-d', strtotime($from));
        $date_to    = date('Y-m-d', strtotime($to));

        if (isset($status_id) && $status_id != "") {
            $where['cls.leads_tab_id'] = $status_id;
        }

        if (isset($user_id) && $user_id != "") {
            if ($user_id == "unassigned") {
                $where['cl.deal_owner'] = 0;
                $converson_user = "0";
            } else {
                $where['cl.deal_owner'] = $user_id;
                $converson_user = $user_id;
            }
        } else {
            $converson_user = "all";
        }

        if (isset($is_deleted) && $is_deleted == "N") {
            $where['cl.is_deleted'] = 'N';
        }

        if (isset($is_archive) && $is_archive == 'N') {
            $where['cl.is_archive'] = 'N';
        }
        //echo $user_id;die;
        $details = DB::table('crm_leads_statuses as cls')->whereIn("cl.user_id", $groupUserId)->
            where($where)->where('cl.close_date', '!=', '0000-00-00')->whereBetween('cl.date', array($date_from, $date_to))->join('crm_leads as cl',
            'cls.leads_id', '=', 'cl.leads_id')->join('crm_leads_tabs as clt', 'clt.tab_id',
            '=', 'cls.leads_tab_id')->select('cl.*', 'clt.tab_name')->get();

        //echo $this->last_query();die;
        $outer_details = DB::table('crm_leads_statuses as cls')->whereIn("cl.user_id", $groupUserId)->
            where($where)->where('cl.close_date', '!=', '0000-00-00')->whereBetween('cl.date', array($date_from, $date_to))->join('crm_leads as cl',
            'cls.leads_id', '=', 'cl.leads_id')->groupBy('cl.deal_owner')->select('cl.deal_owner')->
            get();

        //echo $this->last_query();die;
        $avg_age = $total_amount = 0;
        $count = 1;
        $won = $lost = 0;
        if (isset($details) && count($details) > 0) {
            foreach ($details as $key => $row) {
                if (isset($row->deal_owner) && $row->deal_owner != "0") {
                    $name = User::getStaffNameById($row->deal_owner);
                } else {
                    $name = "";
                }

                if ($row->client_type == 'org') {
                    $prospect_name = $row->prospect_name;
                } else {
                    $prospect_name = $row->prospect_title . " " . $row->prospect_fname . " " . $row->
                        prospect_lname;
                }

                $data1[$key]['leads_id'] = $row->leads_id;
                $data1[$key]['deal_owner'] = $row->deal_owner;
                $data1[$key]['deal_owner_name'] = $name;
                $data1[$key]['prospect_name'] = $prospect_name;
                $data1[$key]['close_date'] = date('d-m-Y', strtotime($row->date));
                $data1[$key]['tab_name'] = $row->tab_name;
                $data1[$key]['quoted_value'] = number_format(str_replace(',', '', $row->
                    quoted_value), 2);
                $data1[$key]['age'] = $this->getAgeCount($row->date, 'Y-m-d');

                $avg_age += $data1[$key]['age'];
                $count++;
            }
            $count--;
        }
        $data['details'] = $data1;
        $data['outer_details'] = $outer_details;
        $data['avg_age'] = $avg_age / $count;

        /////////////Converson Rate////////////
        $leads_details = CrmLead::getDataWithDateRange($date_from, $date_to);
        if (isset($leads_details) && count($leads_details) > 0) {
            foreach ($leads_details as $key => $value) {
                if ($converson_user == "all") {
                    $tab_id = CrmLeadsStatus::getTabIdByLeadsId($value['leads_id']);
                    if (isset($tab_id) && $tab_id == '8') {
                        $won++;
                    }
                    if (isset($tab_id) && $tab_id == '9') {
                        $lost++;
                    }
                } else {
                    if ($value['deal_owner_id'] == $converson_user) {
                        $tab_id = CrmLeadsStatus::getTabIdByLeadsId($value['leads_id']);
                        if (isset($tab_id) && $tab_id == '8') {
                            $won++;
                        }
                        if (isset($tab_id) && $tab_id == '9') {
                            $lost++;
                        }
                    }
                }

            }

        }

        if (($won + $lost) == 0) {
            $data['converson_rate'] = 0;
        } else {
            $data['converson_rate'] = $won * 100 / ($won + $lost);
        }


        
        $viewToLoad = 'crm/ajax/excelreport';
			///////////  Start Generate and store excel file ////////////////////////////
			Excel::create('crm_list', function ($excel) use ($data, $viewToLoad) {

				$excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad) {
					$sheet->loadView($viewToLoad)->with($data);
				})->save();

			});
        
        //
        
	   
		$filepath = storage_path() . '/exports/crm_list.xls';
		$fileName = 'file.xls';
		$headers = array(
			'Content-Type: application/vnd.ms-excel',
		);

		return Response::download($filepath, $fileName, $headers);
		exit;
   
        //echo "Total : ".($won + $lost);die;
        /////////////Converson Rate////////////
        //print_r($data);die;
       
    }

    public function ajax_save_status()
    {
        $data = array();
        $renewal_status_id = Input::get('renewal_status_id');
        $type = Input::get('type');
        if (isset($type) && $type == "title") {
            $data['status_name'] = Input::get("status_name");
            $title = $data['status_name'];
        } else {
            $value = CrmRenewalStatus::where("renewal_status_id", "=", $renewal_status_id)->first();
            if ($value['status'] == "S") {
                $data['status'] = "H";
            } else {
                $data['status'] = "S";
            }
            $title = $value['status_name'];
        }
        $sql = CrmRenewalStatus::where("renewal_status_id", "=", $renewal_status_id)->update($data);
        
        echo $title;
        exit;
    }

    function change_renewal_status()
    {
        $session = Session::get('admin_details');
        $user_id = $session['id'];

        $client_id    = Input::get('client_id');
        $status_id    = Input::get('renewal_status_id');

        if($status_id == 7){
            CrmArchivedDetail::save_details($client_id);
        }


        $details = RenewalManageStatus::getDetailsByClientId($client_id);
        $insrt_data["status_id"] = $status_id;
        if(isset($details) && count($details) >0){
            RenewalManageStatus::where("ren_status_id", "=", $details['ren_status_id'])->update($insrt_data);
            $last_id = $details['ren_status_id'];
        }else{
            $insrt_data["user_id"]    = $user_id;
            $insrt_data["client_id"]  = $client_id;
            $insrt_data["created"]    = date('Y-m-d H:i:s');
            $last_id = RenewalManageStatus::insertGetId($insrt_data);
        }
        echo $last_id;
        //print_r($details);
    }

    public function delete_archived_client()
    {
        $archive_id    = Input::get('archive_id');
        CrmArchivedDetail::where('crm_archived_id', '=', $archive_id)->delete();
        echo $archive_id;
    }
    
    public function delete_todolist()
    {
        $ids    = Input::get('ids');
        Todolistnewtask::whereIn('todolistnewtasks_id', $ids)->delete();
    }
    
    public function excelcrm($page_open,$owner_id){
        
        
        
       // echo $page_open;die();
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
        $data['leads'] = array();

        $data['heading'] = "CRMPDF";
        $data['title'] = "CrmPdf";
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
        $won_value = Session::get('won_show_archive');
        $lost_value = Session::get('lost_show_archive');
        if (isset($won_value) && $won_value == 'Y') {
            $data['won_archive'] = 'Show Archived';
        } else {
            $data['won_archive'] = 'Hide Archived';
        }
        if (isset($lost_value) && $lost_value == 'Y') {
            $data['lost_archive'] = 'Show Archived';
        } else {
            $data['lost_archive'] = 'Hide Archived';
        }

        $data['page_open']          = base64_decode($page_open); 
        $data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id;
        $data['owner_id']           = base64_decode($owner_id);
        $data['goto_url']           = "/crm";
        $data['tab_no']             = $this->getTabNo($data['page_open']); //die();

        switch ($data['page_open']) {
            case '2':
                $data['tab21_details']  = $this->getTabTwoOneDetails($data['page_open']);
                break;
            case '21':
                $data['tab21_details']  = $this->getTabTwoOneDetails($data['page_open']);
                break;
            case '22':
                $data['tab22_details']  = $this->getTabTwoTwoDetails($data['page_open']);
                break;
            
            default:
                
                break;
        }
        
        $data['leads_details'] = array();
        //echo "<pre>";print_r($data);die;
        $data['titles'] = Title::orderBy("title_id")->get();
        $data['countries'] = Country::orderBy('country_name')->get();
        $data['old_org_types'] = OrganisationType::where("client_type", "=", "all")->
            orderBy("name")->get();
        $data['new_org_types'] = OrganisationType::where("client_type", "=", "org")->
            whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->
            get();
        $data['industry_lists'] = IndustryList::getIndustryList();
        $data['staff_details'] = User::getAllStaffDetails();
        $data['old_lead_sources'] = LeadSource::getOldLeadSource();
        $data['new_lead_sources'] = LeadSource::getNewLeadSource();
        $data['leads_tabs'] = CrmLeadsTab::getAllTabDetails(); 

        $data['invoice_leads_details'] = CrmLead::getInvoiceLeadsDetails();
        $data['leads_details'] = CrmLead::getAllOpportunity();
        
        $total = 0;
        $average = 0;
        $likely = 0;
        $all_count = 0;
        if (isset($data['leads_details']) && count($data['leads_details']) > 0) {
            foreach ($data['leads_details'] as $key => $value) {
                if(isset($value['lead_status']) && ($value['lead_status'] != 8 && $value['lead_status'] != 9 && $value['lead_status'] != 10)){
                    $quoted_value = str_replace(",", "", $value['quoted_value']);
                    $total += $quoted_value;
                    $likely += ($value['deal_certainty'] * $quoted_value) / 100;

                    $status = CrmLeadsStatus::getDetailsByLeadsId($value['leads_id']);
                    //echo $this->last_query();
                    if (isset($status['leads_tab_id']) && ($status['leads_tab_id'] == 8 || $status['leads_tab_id'] == 9 || $status['leads_tab_id'] == 10)) {
                        $date = explode(' ', $status['likely']);
                        $data['leads_details'][$key]['deal_age'] = $this->getDealAge($value['date'], $date[0]);
                    } else {
                        $data['leads_details'][$key]['deal_age'] = $this->getAgeCount($value['date'], date(Y-m-d));
                    }
                    $all_count++;
                    
                }
            }
            if(isset($all_count) && $all_count != 0){
                $average = $total/$all_count;
            }
        }
        $data['all_count']      = $all_count;
        $data['all_total']      = number_format($total, 2);
        $data['all_average']    = number_format($average, 2);
        $data['all_likely']     = number_format($likely, 2);

        //=================LEADS TAB ===================//
        if($data['tab_no'] == 5){
            $leads = $this->leadstabDetails();
            $data['leads'] = $leads;
        }
        //echo '<pre>';print_r($data);die();
        //echo "<pre>";print_r($data['tab21_details']);echo "</pre>";die;
      
        
        if($data['page_open']== '51')
        {
            $filename="CRM_LEADS";
        }
        
        else if($data['page_open']== '2' || $data['page_open']== '21')
        {
            $filename="CRMorganization_clientdetails";
        }
        
        else if($data['page_open']== '22')
        {
            $filename="CRMindividual_clientdetails";
        }
       
        else if($data['page_open']== '611' || $data['page_open']== '612' || $data['page_open']== '613' || $data['page_open']== '614' || $data['page_open']== '615' || $data['page_open']== '616'|| $data['page_open']== '617')
        {
            $filename="CRMOPPORTUNITIES_OPENED";
        }
        
        else if($data['page_open']=='62')
        {
            $filename="CRMOPPORTUNITIES_CLOSED_WON";
        }
        else if($data['page_open']=='63')
        {
            $filename="CRMOPPORTUNITIES_CLOSED_LOST";
        }
        
        else if($data['page_open']=='64')
        {
            $filename="CRMOPPORTUNITIES_COLD";
        }
        else{
            $filename="Crm";
        }
        
        //echo $filename;die();
       // return $pdf->download($filename.'.pdf');
        //return View::make('crm.pdfcrm', $data);die();
    
        $viewToLoad = 'crm/excelcrm';
			///////////  Start Generate and store excel file ////////////////////////////
			Excel::create('crm_list', function ($excel) use ($data, $viewToLoad) {

				$excel->sheet('Sheetname', function ($sheet) use ($data, $viewToLoad) {
					$sheet->loadView($viewToLoad)->with($data);
				})->save();

			});
        
        //
        
	   
		$filepath = storage_path() . '/exports/crm_list.xls';
		$fileName = $filename.'.xls';
		$headers = array(
			'Content-Type: application/vnd.ms-excel',
		);

		return Response::download($filepath, $fileName, $headers);
		exit;
   
        
    }

    public function invoice_by_contactid(){
        $data       = array();
        $id         = Input::get('id');
        $contact_id = Input::get('contact_id');
        $details    = CrmInvoiceDebit::invoice_by_contactid($contact_id);
        $total = $paid = $credited = $due = $tobecollect = 0;
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
               $total       += $value['Total'];
               $paid        += $value['AmountPaid'];
               $credited    += $value['AmountCredited'];
               $due         += $value['AmountDue'];
               $tobecollect += $value['ToBeCollected'];
               $is_send     = CrmManageInvoice::checkIsSend($value['InvoiceNumber']);
               $details[$key]['is_send'] = $is_send;
            }
        }
        $data['total']      = number_format($total, 2);
        $data['paid']       = number_format($paid, 2);
        $data['credited']   = number_format($credited, 2);
        $data['due']        = number_format($due, 2);
        $data['tobecollect']= number_format($tobecollect, 2);
        $name               = CrmInvoiceDebit::name_by_contactid($contact_id);
        $data['name']       = strtoupper(strtolower($name));
        $data['details']    = $details;
        $data['check_box']  = CrmInvoiceAutosend::CheckAutosendByContactId( $contact_id );

        echo json_encode($data);
        exit();     
    }

    public function update_invoice(){
        $data       = array();
        $owner_id   = Input::get('owner_id');
        $contact_id = Input::get('pop_contact_id');

        $details    = CrmInvoiceDebit::invoice_by_contactid($contact_id);  
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $inv_id = $value['crm_invoice_id'];
                $data['ToBeCollected'] = Input::get('collected_'.$inv_id);
                $coll_date = Input::get('collection_date_'.$inv_id);
                if($coll_date != ""){
                    $data['collection_date'] = date('Y-m-d', strtotime($coll_date));
                }
                CrmInvoiceDebit::where('crm_invoice_id', '=', $value['crm_invoice_id'])->update($data);
            }
        }
        return Redirect::to('/crm/'.base64_encode('4').'/'.base64_encode($owner_id));
        exit();     
    }

    public function merge_xero_clients() {
        $data       = array();
        $details    = array();
        $client_type    = Input::get('client_type');
        $contact_id     = Input::get('contact_id');

        if($client_type == 'xero'){
            $invoice_id     = Input::get('invoice_id');
            $org_client_id  = Input::get('org_client_id');
            $data['merged_client_id']   = $org_client_id;
            //$data['auto_collect']       = 'Y';
        }else{
            $contact_id  = Input::get('contact_id');
            $data['merged_client_id'] = 0;
        }
        CrmInvoiceDebit::where('ContactID', '=', $contact_id)->update($data);
        $AmountDue      = CrmInvoiceDebit::totalAmount($contact_id);
        $ToBeCollected  = CrmInvoiceDebit::totalCollected($contact_id);
        $details['AmountDue']       = number_format($AmountDue, 2);
        $details['ToBeCollected']   = number_format($ToBeCollected, 2);
        
        //echo $details['inv_client'];die;
        echo json_encode($details);
        exit;
    }

    public function address_by_client_type(){
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];

        $value          = Input::get('value');
        $clients        = explode('_', $value);
        $client_id      = Input::get('client_id');
        $cont_client_id = $clients[0];
        $address_type   = $clients[1];
        $data = Client::getAddressByClientId($cont_client_id, $address_type);
        /* ============= Client Invoice Contact Update Start =========== */
        $clinv['user_id']           = $user_id;
        $clinv['cont_client_id']    = $cont_client_id;
        $clinv['cont_addr_type']    = $address_type;

        $details = CrmInvoiceContact::getDetailsByClientId($client_id);
        if(isset($details) && count($details) >0){
            CrmInvoiceContact::where('crm_contact_id', '=', $details['crm_contact_id'])->update($clinv);
        }else{
            $clinv['client_id'] = $client_id;
            $clinv['created']   = date('Y-m-d H:i:s');
            CrmInvoiceContact::insert($clinv);
        }
        /* ============= Client Invoice Contact Update End =========== */
        echo json_encode($data);
        exit;
    }

    public function get_auto_collect()
    {
        $client_type    = Input::get('client_type');
        
        if($client_type == 'org'){
            $client_id  = Input::get('client_id');
            $details    = CrmInvoiceDebit::detailsByMergeClientId($client_id);
            $contact_id = isset($details['ContactID'])?$details['ContactID']:'';
        }else{
            $contact_id = Input::get('contact_id');
        }

        $auto_collect = CrmInvoiceDebit::AutocollectByContactId($contact_id);
        $data['auto_collect']   = $auto_collect;
        $data['ContactID']      = $contact_id;
        
        echo json_encode($data);
        exit;
    }

    public function check_collection_date()
    {
        $contact_id = Input::get('contact_id');
        
        $details = CrmInvoiceDebit::invoice_by_contactid($contact_id);
        if(isset($details) && count($details) >0){
            $i = 0;
            foreach ($details as $key => $value) {
               if(isset($value['collection_date']) && $value['collection_date'] != ''){
                    $i++;
               }
            }
        }
        $data['check'] = $i;
        echo json_encode($data);
        exit;
    }

    public function save_auto_collect()
    {
        $data       = array();
        $details    = array();
        $client_type    = Input::get('client_type');
        $contact_id     = Input::get('contact_id');
        $invoice_id     = Input::get('invoice_id');
        $auto_collect   = Input::get('auto_collect');

        $data['auto_collect'] = $auto_collect;
        CrmInvoiceDebit::where('ContactID', '=', $contact_id)->update($data);
        
        $details = CrmInvoiceDebit::invoice_by_contactid($contact_id);
        if(isset($details) && count($details) >0){
            $invData = array();
            foreach ($details as $key => $value) {
                $invData['ToBeCollected']   = $value['AmountDue'];
                $invData['collection_date'] = date('Y-m-d', strtotime($value['Date']));
                CrmInvoiceDebit::where('crm_invoice_id', '=', $value['crm_invoice_id'])->update($invData);
            }
        }
        
        $ToBeCollected = CrmInvoiceDebit::totalCollected($contact_id);
        $data['ToBeCollected'] = number_format($ToBeCollected, 2);
        echo json_encode($data);
        exit;
    }

    public function send_to_collect()
    {
        $data           = array(); 
        $details        = array(); 
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $status     = Input::get('status');
        //print_r($details);die;
        if($status == 'send'){
            $invoice_id     = Input::get('invoice_id');
            $details        = CrmInvoiceDebit::invoice_by_id($invoice_id);

            $collect_date   = Input::get('collect_date');
            $amount         = Input::get('amount');
            $invoice_number = $details['InvoiceNumber'];

            $insrt_data['user_id']          = $user_id;
            $insrt_data['invoice_number']   = $invoice_number;
            $insrt_data['collection_date']  = date('Y-m-d', strtotime($collect_date));
            $insrt_data['amount']           = $amount;
            $insrt_data['created']          = date('Y-m-d H:i:s');
            CrmManageInvoice::insert($insrt_data);
        }
        if($status == 'open'){
            $invoice_id     = Input::get('invoice_id');
            $details        = CrmInvoiceDebit::invoice_by_id($invoice_id);
        }
        if($status == 'multiple'){
            $contact_id     = Input::get('contact_id');
            $autoinsrt['user_id']       = $user_id;
            $autoinsrt['contact_id']    = $contact_id;
            $autoinsrt['created']       = date('Y-m-d H:i:s');
            CrmInvoiceAutosend::insert($autoinsrt);
            $details = $this->autosend_invoice($contact_id);
        }
        if($status == 'uncheck'){
            $contact_id     = Input::get('contact_id');
            CrmInvoiceAutosend::whereIn("user_id", $groupUserId)->where("contact_id", '=', $contact_id)->delete();
        }
        $data['details'] = $details;
        echo json_encode($data);
        exit;
    }

    public function autosend_invoice($contact_id)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $details        = CrmInvoiceDebit::invoice_by_contactid($contact_id);
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data = array();
                $invs = CrmManageInvoice::getDetailsByInvoiceNumber($value['InvoiceNumber']);
                $data['collection_date'] = date('Y-m-d', strtotime($value['DueDate']));
                $data['amount']          = $value['AmountDue'];
                if(isset($invs) && count($invs) >0){
                    CrmManageInvoice::where('manage_id', '=', $invs['manage_id'])->update($data);
                }else{
                    $data['user_id']          = $user_id;
                    $data['invoice_number']   = $value['InvoiceNumber'];
                    $data['created']          = date('Y-m-d H:i:s');
                    CrmManageInvoice::insert($data);
                }
            }
        }
        return $details;
    }


    public function delete_invoice()
    {
        $data           = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $invoice_id = Input::get('invoice_id');
        $invoice_no = Input::get('invoice_no');
        CrmManageInvoice::whereIn('user_id', $groupUserId)->where('invoice_number', $invoice_no)->delete();
        //CrmManageInvoice::whereIn('user_id', $groupUserId)->where('crm_invoice_id', '=', $invoice_id)->delete();
        $data['invoice_id'] = $invoice_id;
        $data['invoice_no'] = $invoice_no;
        echo json_encode($data);
        exit;
    }

    public function ajax_get_org_client()
    {
        $service_id     = 0;
        $rows           = array();
        $data           = $matches = array();
        $start          = $_GET['jtStartIndex'];
        $limit          = $_GET['jtPageSize'];
        $sorting        = $_GET['jtSorting'];
        $sort           = explode(' ', $sorting);
        $page_open      = $_GET['page_open'];
        $client_type    = $_GET['client_type'];

        $search_text    = isset($_POST["search"])?trim($_POST['search']):'';


        //$tab_details        = CrmAccDetail::getTabTwoOneDetails($page_open);
        //$details['details'] = $tab_details['client_details'];
        $details = CrmAccDetail::getOrganisationTab($start,$limit,$page_open,$client_type,$sorting,$search_text);

        //echo "<pre>";print_r($details);die;
        if(isset($details['details']) && count($details['details']) >0){
            foreach($details['details'] as $i=>$v){
                $af = isset($v['annual_fee'])?number_format($v['annual_fee'],2):'';
                //$af = CrmProposal::getAnnualFeesByClientId($v['client_id']);

                $sd = !empty($v['startdate'])?date('d-m-Y', strtotime($v['startdate']) ):'';
                $ed = !empty($v['enddate'])?date('d-m-Y', strtotime($v['enddate']) ):'';
                //==============AUTO SEND START================
                /*if($page_open == 2){
                    $days  = AutosendTask::getDaysByServiceId( $service_id, 'C' );
                    if(isset($v['count_down']) && $v['count_down'] <= $days){
                        RenewalsManage::updateRenewalsManage($v['client_id']);
                    }
                }*/
                //==============AUTO SEND END================
                $contracts = CrmProposal::recurringProposalByClientId($v['client_id']);
                $renewals  = RenewalsManage::getManageRenewalsByClientId($v['client_id']);

                $matches[$i]['key']                 = $i;
                $matches[$i]['client_id']           = $v['client_id'];
                $matches[$i]['client_name']         = isset($v['client_name'])?$v['client_name']:'';
                $matches[$i]['type']                = $v['type'];
                $matches[$i]['crm_leads_id']        = $v['crm_leads_id'];
                $matches[$i]['created']             = $v['created'];

                $matches[$i]['recurring_contracts'] = $contracts;
                $matches[$i]['engagement_date']     = ($v['engagement_date'] != NULL)?$v['engagement_date']:'';
                $matches[$i]['annual_fee']          = $af;
                $matches[$i]['monthly_fee']         = isset($v['monthly_fee'])?$v['monthly_fee']:'';
                $matches[$i]['startdate']           = $sd;
                $matches[$i]['enddate']             = $ed;
                $matches[$i]['count_down']          = $v['count_down'];
                $matches[$i]['type_url']            = base64_encode($v['type'].'_client').'/'.base64_encode(1);
                $matches[$i]['manage_renewals']     = $renewals;
            }
        }

        //echo "<pre>";print_r($matches);die;
        
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result']             = "OK";
        $jTableResult['TotalRecordCount']   = $details['TotalRecord'];
        $jTableResult['Records']            = $matches;
        print json_encode($jTableResult);
    }

    public function getManageRenewalDetails()
    {
        $data           = array();
        /*$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        //$groupUserId    = Client::getSessionUserIds();

        $details = DB::table('renewals_manages as rm')
                    ->leftjoin('steps_fields_clients as sfc', 'rm.client_id', '=', 'sfc.client_id')
                    ->where('sfc.field_name', 'business_name')
                    ->whereIn('rm.user_id', $groupUserId)
                    ->select('rm.client_id', 'sfc.field_value as client_name')
                    ->get();

        $data['details'] = json_decode(json_encode($details), true);
        //echo "<pre>";print_r($data['details']);die;
        return $data['details'];*/
    }


}
