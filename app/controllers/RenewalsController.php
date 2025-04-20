<?php
class RenewalsController extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)){
            Redirect::to('/login')->send();
        }
    }
	
	public function index($client_id, $client_type, $tab_no)
    {
        $data = array();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
        
        $data['heading']        = "CLIENT DETAILS";
        $data['previous_page']  = '<a href="/crm/Mg==/YWxs/clients">CRM</a>';
        $data['title']          = "Client Details";
        $data['encoded_type']   = $client_type;
        $data['encoded_tab_no'] = $tab_no;
        $data['tab_no']         = base64_decode($tab_no);
        $data['goto_url']       = "/renewals";

        $data['details']        = Common::clientDetailsById( $client_id );
        $data['acc_details']    = CrmAccDetail::getDetailsByClientId($client_id);

        if($data['tab_no'] == 1){
            $data['titles']         = Title::orderBy("title_id")->get();
            $data['staff_details']  = User::getAllStaffDetails();
            $data['relationship']   = Common::get_relationship_client( $client_id );
            $data['old_org_types']  = OrganisationType::where("client_type", "=", "all")->
                orderBy("name")->get();
            $data['new_org_types']  = OrganisationType::where("client_type", "=", "org")->
                whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();
            $data['old_lead_sources']   = LeadSource::getOldLeadSource();
            $data['new_lead_sources']   = LeadSource::getNewLeadSource();
            //$data['industry_lists']     = IndustryList::getIndustryList();
            $data['countries']          = Country::getAllCountry();
            $data['status_id']          = CrmLeadsStatus::getTabIdByLeadsId( $data['details']['crm_leads_id'] );

            //++++++++++++++ CRM RENEWALS +++++++++++++//
            $data['crm_renewals']       = CrmRenewal::getCrmRenewalByClientId($client_id);
            $data['crm_tasks']          = CrmRenewalTask::getCrmTaskByClientId($client_id);
            //$data['opportunities']      = $this->getOpportunityByClientId($client_id);
            $data['contact_persons']    = ContactAddress::get_all_contacts($client_id);
            $data['leads_details']      = $this->getLeadsByClientId($client_id);
            $data['billing_address']    = $this->getBillingAddressByClientId($client_id);
            $data['business_desc']      = BusinessDescription::getDescByClientId($client_id);
        }else{
            $data['services']    = ClientService::getServicesByClient($client_id);
            $data['rnl_history'] = RenewalsHistory::getDetailsByClient($client_id);
            $data['opportunities']      = $this->getOpportunityByClientId($client_id);
        }

        $data['client_name']    = Client::getClientNameByClientId($client_id);
        $data['initial_badge']  = Client::get_initial_badge($data['client_name']);
     //  echo $data['billing_address'];//die;
        //echo "<pre>";print_r($data['details']);die;
        return view::make("crm/edit_client", $data);
    } 

    public function getBillingAddressByClientId($client_id)
    {
        $data  = array();
        $details = Client::where('client_id', '=', $client_id)->select('crm_contact_type', 'type')->first();

        if(isset($details['crm_contact_type']) && $details['crm_contact_type'] != "" && $details['crm_contact_type'] != "none"){
            //$data = ContactAddress::getClientContactAddress($client_id, $details['crm_contact_type']);
            $data = ClientAddress::getAddressByClientIdAndType($client_id, $details['crm_contact_type']);
        }else{
            $data = CrmBillingAddress::getDefaultContactAddress($client_id);
        }
        //echo Common::last_query();
        //print_r($data);die;
        
        $address = "";
        if(isset($data['address1']) && $data['address1'] != ""){
            $address .= $data['address1'].", ";
        }
        if(isset($data['address2']) && $data['address2'] != ""){
            $address .= $data['address2'].", ";
        }
        if(isset($data['city']) && $data['city'] != ""){
            $address .= $data['city'].", ";
        }
        if(isset($data['county']) && $data['county'] != ""){
            $address .= $data['county'].", ";
        }
        if(isset($data['country']) && $data['country'] != ""){
            $country = Country::getCountryNameByCountryId($data['country']);
            $address .= $country.", ";
        }
        if(isset($data['postcode']) && $data['postcode'] != ""){
            $address .= $data['postcode'].", ";
        }

        if($address != ""){
            $address = substr($address, 0, -2);
        }
        return $address;
    }

    public function getLeadsByClientId($client_id)
    {
        $data  = array();
        $leads_id = Client::where('client_id', '=', $client_id)->select('crm_leads_id')->first();
        if(isset($leads_id['crm_leads_id']) && $leads_id['crm_leads_id'] != 0){
            $data = CrmLead::getLeadsByLeadsId($leads_id['crm_leads_id']);
        }
        
        return $data;
    }

    public function getOpportunityByClientId($client_id)
    {
        $data1 = array();
        $data2 = array();
        $data  = array();
        $leads_id = Client::where('client_id', '=', $client_id)->select('crm_leads_id')->first();
        if(isset($leads_id['crm_leads_id']) && $leads_id['crm_leads_id'] != 0){
            $data1[0] = CrmLead::getLeadsByLeadsId($leads_id['crm_leads_id']);
        }
        $data2 = CrmLead::getOpportunityByClientId($client_id);
        $data = array_merge($data1, $data2);

        foreach ($data as $key=>$value){
            $leads[$key] = isset($value['leads_id'])?$value['leads_id']:0;
        } 

        if(isset($data) && count($data)>0){
            array_multisort($leads, SORT_DESC, $data);
        }
        
        return $data;
    }

    public function save_notes()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $action         = Input::get('action');
        $client_id      = Input::get('client_id');
        $added_from     = Input::get('added_from');
        $insrt['title'] = Input::get('title');
        $insrt['notes'] = Input::get('notes');

        if($added_from == 'N'){
            if(isset($action) && $action == 'add') {
                $insrt['date']          = date('Y-m-d');
                $insrt['time']          = date('h:i');
            }
        }else{
            $insrt['date']  = date('Y-m-d', strtotime(Input::get('date')));
            $insrt['time']  = Input::get('time');
        }
        
        if(isset($action) && $action == 'add') {
            $insrt['user_id']       = $user_id;
            $insrt['client_id']     = $client_id;
            $insrt['added_from']    = $added_from;
            $insrt['created']       = date("Y-m-d H:i:s");
            $renewal_id = CrmRenewal::insertGetId($insrt);
        } else {
            $renewal_id  = Input::get('renewal_id');
            CrmRenewal::where('renewal_id', '=', $renewal_id)->update($insrt);
        }

        $crm_renewals = CrmRenewal::getCrmRenewalByRenewalId($renewal_id);
        echo json_encode($crm_renewals);
    }   

    public function get_renewals_details()
    {
        $renewal_id = Input::get('renewal_id');
        $details = CrmRenewal::getCrmRenewalByRenewalId($renewal_id);
        echo json_encode($details);
    } 

    public function delete_notes()
    {
        $renewal_id = Input::get('renewal_id');
        $action = CrmRenewal::where('renewal_id', '=', $renewal_id)->delete();
        echo $action;
    } 

    public function save_tasks()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $task_action        = Input::get('task_action');
        $client_id          = Input::get('client_id');
        $insrt['task_name'] = Input::get('task_name');
        $insrt['task_date'] = date('Y-m-d', strtotime(Input::get('task_date')));
        $time = str_replace(' ','',Input::get('task_time'));
        $insrt['task_time'] = date('H:i', strtotime($time)).':'.date('s');
        
        if(isset($task_action) && $task_action == 'add') {
            $insrt['user_id']       = $user_id;
            $insrt['client_id']     = $client_id;
            $insrt['created']       = date("Y-m-d H:i:s");
            CrmRenewalTask::insert($insrt);
        } else {
            $task_id  = Input::get('task_id');
            CrmRenewalTask::where('task_id', '=', $task_id)->update($insrt);
        }
        //echo $this->last_query();
    } 

    public function get_task_details()
    {
        $task_id = Input::get('task_id');
        $details = CrmRenewalTask::getCrmTaskByRenewalId($task_id);
        echo json_encode($details);
    }

    public function delete_tasks()
    {
        $task_id = Input::get('task_id');
        $action = CrmRenewalTask::where('task_id', '=', $task_id)->delete();
        echo $action;
    } 

    public function get_contact_address()
    {
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get('client_id');
        $type       = Input::get('type');
        $value      = Input::get('value');
        /*$details    = ContactAddress::getClientContactAddress($client_id, $value);
        if(isset($details['country']) && $details['country'] != ''){
            $details['country_name'] = Country::getCountryNameByCountryId($details['country']);
        }*/
        $data['crm_contact_type'] = $value;
        Client::where('client_id','=',$client_id)->update($data);
        $details = $this->getBillingAddressByClientId($client_id);
        echo $details;
    }

    public function delete_opportunity()
    {
        $leads_id = Input::get('leads_id');
        $client_id = Input::get('client_id');
        $action = CrmLead::where('leads_id', '=', $leads_id)->delete();
        CrmLeadsStatus::where('leads_id', '=', $leads_id)->delete();
        $update['crm_leads_id'] = '0';
        Client::where('client_id', '=', $client_id)->update($update);
        echo $action;
    } 

    public function save_opportunity_data()
    {
        $data = array();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId    = $session['group_users'];

        $details            = Input::get();
        $saved_from         = $details['saved_from'];
        $type               = $details['type'];
        $leads_id           = $details['leads_id'];
        //print_r($details);die;
        $data['date']               = date('Y-m-d', strtotime($details['date']));
        $data['deal_certainty']     = $details['deal_certainty'];
        $data['deal_owner']         = isset($details['deal_owner']) ? $details['deal_owner'] :"0";
        $data['contact_person']     = isset($details['contact_person']) ? $details['contact_person'] :"0";

        if ($type == "ind") {
            $data['prospect_title'] = $details['prospect_title'];
            $data['prospect_fname'] = $details['prospect_fname'];
            $data['prospect_lname'] = $details['prospect_lname'];
        } else {
            $data['business_type']  = $details['business_type'];
            $data['prospect_name']  = $details['prospect_name'];
            $data['contact_title']  = $details['contact_title'];
            $data['contact_fname']  = $details['contact_fname'];
            $data['contact_lname']  = $details['contact_lname'];
        }
        $data['existing_client']    = $details['client_id'];
        $data['user_id']            = $user_id;
        $data['leads_type']         = "O";
        $data['client_type']        = $details['type'];
        $data['phone']              = $details['phone'];
        $data['mobile']             = $details['mobile'];
        $data['email']              = $details['email'];
        $data['quoted_value']       = $details['quoted_value'];
        $data['lead_source']        = isset($details['lead_source'])?$details['lead_source']:"0";
        $data['notes'] = $details['notes'];

        if ($leads_id == 0) {
            $last_id = CrmLead::insertGetId($data);
            $leadstatus['user_id'] = $user_id;
            $leadstatus['leads_id'] = $last_id;
            $leadstatus['leads_tab_id'] = 2;
            $leadstatus['created'] = date("Y-m-d H:i:s");
            CrmLeadsStatus::insert($leadstatus);
        } else {
            $leads_type = CrmLead::getLeadsTypeByLeadsId($leads_id);
            $last_id = $leads_id;
            if(isset($leads_type) && $leads_type == 'L'){
                $leadstatus['leads_tab_id'] = 2;
                CrmLeadsStatus::whereIn("user_id", $groupUserId)->where('leads_id', '=', $leads_id)->update($leadstatus);
            }
            CrmLead::where('leads_id', '=', $leads_id)->update($data);
        }

        if($saved_from == "CD"){
            $client_id     = $details['client_id'];
            $tab_no        = $details['tab_no'];
            $encoded_type  = $details['encoded_type'];
            Client::where('client_id', '=', $client_id)->update(array('crm_leads_id'=>$last_id));
            return Redirect::to('/renewals/'.$client_id.'/'.$encoded_type.'/'.$tab_no);
        }else{
            $encode_page_open   = $details['encode_page_open'];
            $encode_owner_id    = $details['encode_owner_id'];
            return Redirect::to('/crm/'.$encode_page_open.'/'.$encode_owner_id);
        }
        //print_r($data);die;
    }

    public function get_contact_details()
    {
        $address_type   = Input::get('address_type');
        $client_id      = Input::get('client_id');
        $details = ContactAddress::getClientContactAddress($client_id, $address_type);
        if(isset($details['country']) && $details['country'] != ''){
            $details['country_name'] = Country::getCountryNameByCountryId($details['country']);
        }
        echo json_encode($details);
        exit;
    }

    public function save_billing_data()
    {
        $data = array();
        $details        = Input::get();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $client_id      = $details['client_id'];
        $tab_no         = $details['tab_no'];
        $encoded_type   = $details['encoded_type'];
        $billing_id     = $details['billing_id'];
        $type           = $details['type'];
        
        //print_r($details);die;
        $data['address1']       = $details['bill_addr1'];
        $data['address2']       = $details['bill_addr2'];
        $data['city']           = $details['bill_city'];
        $data['county']         = $details['bill_county'];
        $data['country']        = $details['bill_country'];
        $data['postcode']       = $details['bill_postcode'];
        
        if ($billing_id == 0) {
            $data['user_id']    = $user_id;
            $data['client_id']  = $client_id;
            $data['created']    = date('Y-m-d H:i:s');
            $last_id = CrmBillingAddress::insertGetId($data);
        } else {
            CrmBillingAddress::where('billing_id', '=', $billing_id)->update($data);
        }

        
        return Redirect::to('/renewals/'.$client_id.'/'.$encoded_type.'/'.$tab_no);
        //print_r($data);die;
    }

    public function ajax_billing_details()
    {
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get('client_id');
        $details    = CrmBillingAddress::getDefaultContactAddress($client_id);

        echo json_encode($details);
    }

    public function save_account_details()
    {
        $crm_details    = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id      = Input::get('client_id');
        $data_type      = Input::get('data_type');
        $text           = Input::get('text');
        $client_type    = Input::get('client_type');
        $page_open      = Input::get('page_open');

        $details    = CrmAccDetail::getDetailsByClientId($client_id);
        if (isset($details) && count($details) >0) {
            // Roll forword action //
            if($data_type == 'fwddate'){
                $enddate        = Input::get('enddate');
                $roll_amount    = Input::get('roll_amount');

                $rninsrt['client_id']   = $client_id;
                $rninsrt['start_date']  = (isset($details['startdate']) && $details['startdate'] != '')?date('Y-m-d', strtotime($details['startdate'])):'0000-00-00';
                $rninsrt['end_date']    = (isset($details['enddate']) && $details['enddate'] != '')?date('Y-m-d', strtotime($details['enddate'])):'0000-00-00';
                $rninsrt['amount']      = $details['billing_amount'];
                $rninsrt['created']     = date('Y-m-d H:i:s');
                RenewalsHistory::insert($rninsrt);

                $data['startdate']      = date('Y-m-d', strtotime($text));
                $data['enddate']        = date('Y-m-d', strtotime($enddate));
                $data['billing_amount'] = $roll_amount;
            }else{
                if($data_type == 'startdate'){
                    $data['startdate']  = date('Y-m-d', strtotime($text));
                    $data['enddate']    = date("Y-m-d", strtotime('-1 day', strtotime('+1 years', strtotime($text)) ));
                }else if($data_type == 'engagement_date'){
                    $data[$data_type]  = date('Y-m-d', strtotime($text));
                }else{
                    $data[$data_type]   = $text;
                }
            }
            CrmAccDetail::where('acc_id', $details['acc_id'])->update($data);

        } else {
            $details['billing_amount'] = 0;

            if($data_type == 'startdate'){
                $data['startdate']  = date('Y-m-d', strtotime($text));
                $data['enddate']    = date("Y-m-d",strtotime('-1 day', strtotime('+1 years', strtotime($text)) ));
            }else if($data_type == 'engagement_date'){
                $data[$data_type]  = date('Y-m-d', strtotime($text));
            }else{
                $data[$data_type]   = $text;
            }
            $data['user_id']    = $user_id;
            $data['client_id']  = $client_id;
            $data['created']    = date('Y-m-d H:i:s');//echo "<pre>";print_r($data);die;
            $last_id = CrmAccDetail::insertGetId($data);
        }

        $crm_details    = CrmAccDetail::getDetailsByClientId($client_id);


        /* header value */
        if($client_type == 'org'){
            $clint_dtls = App::make('CrmController')->getTabTwoOneDetails($page_open);
        }else{
            $clint_dtls = App::make('CrmController')->getTabTwoTwoDetails($page_open);
        }
        if(isset($clint_dtls['annual_ammount']) && $clint_dtls['annual_ammount'] != ""){
            $ammount = str_replace(',', '', $clint_dtls['annual_ammount']);
            $crm_details['ann_amnt'] = number_format($ammount, 2);
            $crm_details['ann_avg']  = number_format($ammount/count($clint_dtls['client_details']), 2);
            $crm_details['mon_amnt'] = number_format($ammount/12, 2);
            $crm_details['mon_avg']  = number_format($ammount/(12*count($clint_dtls['client_details'])), 2);
        }
        /* header value end*/

        //$crm_details['renewals']  = RenewalsManage::getRenewalsByProposalAndClientId($proposal_id, $client_id);

        echo json_encode($crm_details);
    }

    public function save_client_details()
    {
        $client_id  = Input::get('client_id');
        $data_type  = Input::get('data_type');
        $text       = Input::get('text');

        $details = Client::where('client_id', '=', $client_id)->select('created')->first();
        $exp = explode(' ', $details);
        $data[$data_type]   = date('Y-m-d', strtotime($text))." ".$exp[1];
        Client::where('client_id', '=', $client_id)->update($data);
        echo $text;
    }

    public function send_manage_task(){ 
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id      = Input::get("client_id");
        $proposal_id    = Input::get("proposal_id");
        $from_page      = Input::get("from_page");
        
        /*$manages = RenewalsManage::whereIn("user_id",$groupUserId)->where("client_id",$client_id)->first();
        $data["status"] = "Y";        
        if(isset($manages) && count($manages) >0){
            RenewalsManage::where("manage_id", $manages['manage_id'])->update($data);
            $last_id = $manages['manage_id'];
        }else{
            $data["user_id"]    = $user_id;
            $data["client_id"]  = $client_id;
            $data["created"]    = date('Y-m-d H:i:s');
            $last_id = RenewalsManage::insertGetId($data);
        }*/


        // Renewal proposal section
        if($proposal_id >0){
            $crm_proposal_id = CrmProposal::getIdByProposalId($proposal_id);
            $postData['crm_proposal_id']    = $crm_proposal_id;
            $postData['from_page']          = $from_page;
            $data['crm_proposal_id']        = App::make('ProposalController')->copyProposal($postData);
            $dataC['crm_proposal_id']       = $data['crm_proposal_id'];
            $dataC['proposal_id']           = $proposal_id;

            // =============== renewal manage table data update start ================ //
            $annual_fee = CrmProposalTable::getRecurAmntByProposalId($proposal_id, $groupUserId);
            $dataC['startdate']    = CrmProposal::getColumnByCrmProposalId('start_date',$data['crm_proposal_id']);
            $dataC['enddate']      = CrmProposal::getColumnByCrmProposalId('end_date',$data['crm_proposal_id']);
            $dataC['annual_fee']   = $annual_fee;
            //RenewalsManage::where('crm_proposal_id', $last_id)->update($rmdara);
            // =============== renewal manage table data update end ================ //

            //RenewalsManage::where('manage_id', $last_id)->update($dataC);
        }else{
            $details    = CrmAccDetail::getDetailsByClientId($client_id);
            if (isset($details['startdate']) && $details['startdate'] != '') {
                $sd = $details['startdate'];
                $ed = $details['enddate'];

                $dataC['startdate']  = date("Y-m-d", strtotime('+1 year', strtotime($sd)) );
                $dataC['enddate']    = date("Y-m-d", strtotime('+1 year', strtotime($ed)) );
                CrmAccDetail::where('acc_id', $details['acc_id'])->update($dataC);
                $dataC['annual_fee'] = $details['billing_amount'];
                //RenewalsManage::where('manage_id', $last_id)->update($dataC);
            }
        }

        //manage renewal
        $dataC["user_id"]    = $user_id;
        $dataC["status"]     = "Y"; 
        $dataC["client_id"]  = $client_id;
        $dataC["created"]    = date('Y-m-d H:i:s');
        $last_id = RenewalsManage::insertGetId($dataC);

        
        $data['crm_details']    = CrmAccDetail::getDetailsByClientId($client_id);
        $data['manage_id']      = $last_id;

        echo json_encode($data);
        exit;
    }

    public function send_global_task()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_array   = array();
        $update_data    = array();
        $dead_line      = Input::get("dead_line");
        $page_open      = Input::get("page_open");

        $service_id = 0;
        $data['company_details'] = CrmRenewal::getCrmClientDetails($page_open);
        //print_r($data['company_details']);
        $all_count = 0;
        $i = 0;
        if(isset($data['company_details']) && count($data['company_details']) >0){
            foreach ($data['company_details'] as $key => $details) {
                //$count =$details['accounts']['count_down'];
                if(isset($details['accounts']['count_down']) && $details['accounts']['count_down'] <= $dead_line){
                    $jobs = RenewalsManage::getDetailsByClientId($details['client_id']);
                    $job_data["status"]     = "Y";
                    $job_data["user_id"]    = $user_id;
                    $job_data["client_id"]  = $details['client_id'];
                    //$job_data["created"]    = date("Y-m-d H:i:s");
                    if(isset($jobs) && count($jobs) >0){
                        RenewalsManage::where("manage_id", "=", $jobs['manage_id'])->update($job_data);
                        $last_id = $jobs['manage_id'];
                    }else{
                        $last_id = RenewalsManage::insertGetId($job_data);
                    }
                    $client_array[$i]['client_id'] = $details['client_id'];
                    $i++;
                }
            }
        }

        $autosend = AutosendTask::getDetailsByServiceId( $service_id, 'C' );
        $autoData["user_id"]      = $user_id;
        $autoData['days']         = $dead_line;
        $autoData['service_id']   = 0;
        if(isset($autosend) && count($autosend) >0 ){
            AutosendTask::where('autosend_id', '=', $autosend['autosend_id'])->update($autoData);
        }else{
            $autoData['purpose']   = 'C';
            AutosendTask::insert($autoData);
        }
        
        echo json_encode($client_array);
    }

    public function delete_single_task()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get("client_id");
        RenewalsManage::whereIn("user_id", $groupUserId)->where("client_id", "=",$client_id)->delete();
        RenewalManageStatus::whereIn("user_id", $groupUserId)->where("client_id", "=",$client_id)->delete();

        echo $client_id;
    }

    public function get_date_format()
    {
        $data = array();
        $startdate  = Input::get("startdate");
        $enddate    = Input::get("enddate");
        $client_id  = Input::get("client_id");
        $data = CrmAccDetail::getDetailsByClientId($client_id);

        $data['startdate'] = date("d-m-Y", strtotime('+1 years', strtotime($startdate)));
        $data['enddate'] = date("d-m-Y", strtotime('+1 years', strtotime($enddate)));
        echo json_encode($data);
    }

    public function delete_renewal_history()
    {
        $history_id  = Input::get("history_id");
        RenewalsHistory::where("rnl_history_id", $history_id)->delete();
        echo $this->last_query();
        echo 1;
    }

	public function pdfdwonload($client_id, $client_type, $tab_no)
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
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
        
        $data['heading']        = "CLIENT DETAILS";
        $data['previous_page']  = '<a href="/crm/MTE=/YWxs">Crm</a>';
        $data['title']          = "Client Details";
        $data['encoded_type']   = $client_type;
        $data['encoded_tab_no'] = $tab_no;
        $data['tab_no']         = base64_decode($tab_no);
        $data['goto_url']       = "/renewals";

        $data['details']        = Common::clientDetailsById( $client_id );
        $data['acc_details']    = CrmAccDetail::getDetailsByClientId($client_id);

        if($data['tab_no'] == 1){
            $data['titles']         = Title::orderBy("title_id")->get();
            $data['staff_details']  = User::getAllStaffDetails();
            $data['relationship']   = Common::get_relationship_client( $client_id );
            $data['old_org_types']  = OrganisationType::where("client_type", "=", "all")->
                orderBy("name")->get();
            $data['new_org_types']  = OrganisationType::where("client_type", "=", "org")->
                whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();
            $data['old_lead_sources']   = LeadSource::getOldLeadSource();
            $data['new_lead_sources']   = LeadSource::getNewLeadSource();
            $data['industry_lists']     = IndustryList::getIndustryList();
            $data['countries']          = Country::getAllCountry();
            $data['status_id']          = CrmLeadsStatus::getTabIdByLeadsId( $data['details']['crm_leads_id'] );

            //++++++++++++++ CRM RENEWALS +++++++++++++//
            $data['crm_renewals']       = CrmRenewal::getCrmRenewalByClientId($client_id);
            $data['crm_tasks']          = CrmRenewalTask::getCrmTaskByClientId($client_id);
            //$data['opportunities']      = $this->getOpportunityByClientId($client_id);
            $data['contact_persons']    = ContactAddress::get_all_contacts($client_id);
            $data['leads_details']      = $this->getLeadsByClientId($client_id);
            $data['billing_address']    = $this->getBillingAddressByClientId($client_id);
        }else{
            $data['services']    = ClientService::getServicesByClient($client_id);
            $data['rnl_history'] = RenewalsHistory::getDetailsByClient($client_id);
            $data['opportunities']      = $this->getOpportunityByClientId($client_id);
        }
        
        //echo $data['billing_address'];//die;
       // echo "<pre>";print_r($data['details']);die;
        
        if($data['details']['business_name']){
            $filename=ucfirst(strtolower($data['details']['business_name']));
            $file_name = str_replace(' ', '_', $filename);
        }
        else{
            $file_name=ucfirst(strtolower("cleint_details"));
            }
        
        
        $pdf = PDF::loadView('crm/pdfeditclient', $data)->setPaper('a4')->setOrientation('landscape')->setWarnings(false);

		$output = $pdf->output();

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
        
        
        
		return $pdf->download($file_name.'.pdf');
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        return view::make("crm/edit_client", $data);
    } 

    public function get_sign_off_date()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $client_id      = Input::get('client_id');

        $data['soffdate'] = CrmAccDetail::get_sign_off_date($client_id);
        echo json_encode($data);
    }



    

}
