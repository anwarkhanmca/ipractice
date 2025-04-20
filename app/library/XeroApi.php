<?php
require '../../bootstrap/autoload.php';
$app = require_once '../../bootstrap/start.php';
$request = $app['request'];
$client = (new \Stack\Builder)
->push('Illuminate\Cookie\Guard', $app['encrypter'])
->push('Illuminate\Cookie\Queue', $app['cookie'])
->push('Illuminate\Session\Middleware', $app['session'], null);
$stack = $client->resolve($app);
$stack->handle($request);
$isAuthorized = Auth::check();

class XeroApi 
{
	public static function save_invoices($invoices, $contacts) {
	  $session 			= Session::get('admin_details');
	  $user_id 			= $session['id'];
	  $groupUserId    	= $session['group_users'];
	  $data = array();
	  $encode_invoice = json_encode($invoices);
	  $decode_invoice = json_decode($encode_invoice);
	  //echo "<pre>";print_r($decode_invoice->Invoice);die;
	  if(isset($decode_invoice->Invoice) && count($decode_invoice->Invoice) >0){
	  	$details  = CrmInvoiceDebit::getAllRecords();
		if(isset($details) && count($details) >0){
			$Invoice_nos = CrmManageInvoice::getAllInvoiceNumber();
			CrmInvoiceDebit::whereIn("user_id", $groupUserId)->whereNotIn("InvoiceNumber", $Invoice_nos)->where('merged_client_id', '=', 0)->delete();
			$cid['is_deleted'] = 'Y';
			CrmInvoiceDebit::whereIn("user_id", $groupUserId)->whereNotIn("InvoiceNumber", $Invoice_nos)->update($cid);
		}
	  	$invData = array();
		foreach ($decode_invoice->Invoice as $key => $val) {
			$data['ContactID'] 	= isset($val->Contact->ContactID)?$val->Contact->ContactID:'';
			$data['user_id'] 	      = $user_id;
			$data['Name'] 	 	      = isset($val->Contact->Name)?$val->Contact->Name:'';
			$data['Date'] 	 	      = isset($val->Date)?$val->Date:'';
			$data['DueDate'] 	 	  = isset($val->DueDate)?$val->DueDate:'';
			$data['BrandingThemeID']  = isset($val->BrandingThemeID)?$val->BrandingThemeID:'';
			$data['Status'] 	 	  = isset($val->Status)?$val->Status:'';
			$data['LineAmountTypes']  = isset($val->LineAmountTypes)?$val->LineAmountTypes:'';
			$data['SubTotal']		  = isset($val->SubTotal)?$val->SubTotal:'';
			$data['TotalTax'] 		  = isset($val->TotalTax)?$val->TotalTax:'';
			$data['Total'] 	 		  = isset($val->Total)?$val->Total:'';
			$data['UpdatedDateUTC']   = isset($val->UpdatedDateUTC)?$val->UpdatedDateUTC:'';
			$data['CurrencyCode'] 	  = isset($val->CurrencyCode)?$val->CurrencyCode:'';
			$data['Type'] 	 		  = isset($val->Type)?$val->Type:'';
			$data['InvoiceID'] 	 	  = isset($val->InvoiceID)?$val->InvoiceID:'';
			$data['InvoiceNumber'] 	  = isset($val->InvoiceNumber)?$val->InvoiceNumber:'';
			$data['Reference'] 	 	  = isset($val->Reference)?$val->Reference:'';
			$data['AmountDue'] 	 	  = isset($val->AmountDue)?$val->AmountDue:'';
			$data['AmountPaid'] 	  = isset($val->AmountPaid)?$val->AmountPaid:'';
			$data['AmountCredited']   = isset($val->AmountCredited)?$val->AmountCredited:'';
			$data['SentToContact'] 	  = isset($val->SentToContact)?$val->SentToContact:'';
			$data['CurrencyRate'] 	  = isset($val->CurrencyRate)?$val->CurrencyRate:'';
			$data['HasAttachments']   = isset($val->HasAttachments)?$val->HasAttachments:'';
			$data['is_deleted']   	  = 'N';
			$data['created']   	  	  = date('Y-m-d H:i:s');

			/* ============ Auto Collect Logic ============= */
			$data['is_deleted'] = CrmInvoiceDebit::AutocollectByContactId($data['ContactID']);
			if(isset($data['is_deleted']) && $data['is_deleted'] == 'Y'){
				$data['ToBeCollected']   = $data['AmountDue'];
                $data['collection_date'] = date('Y-m-d', strtotime($data['Date']));
			}
			/* ============ Auto Collect Logic ============= */

			/* ============ Check Email Address Start ============= */
			$email = XeroApi::checkEmailAddress($contacts, $data['ContactID']);
			$data['EmailAddress'] 		= $email;
			$data['merged_client_id'] 	= Client::getClientIdByEmail($email, 'org');
			/* ============ Check Email Address End ============= */

			/* ============ Check Auto Send Start ============= */
			$value = CrmInvoiceAutosend::CheckAutosendByContactId($data['ContactID']);
			if($value == 1){
				$insrt['user_id']          = $user_id;
                $insrt['invoice_number']   = $data['InvoiceNumber'];
                $insrt['collection_date']  = date('Y-m-d', strtotime($data['DueDate']));
                $insrt['amount']           = $data['AmountDue'];
                $insrt['created']          = date('Y-m-d H:i:s');
                CrmManageInvoice::insert($insrt);	
			}
			/* ============ Check Auto Send End ============= */

			
			$cont_detls  = CrmInvoiceDebit::InvoiceByContactAndInvoiceNo($data['ContactID'], $data['InvoiceNumber']);
			if(isset($cont_detls) && count($cont_detls) >0){
				$cid['is_deleted'] = 'N';
				$invoice_id = $cont_detls['crm_invoice_id'];
				CrmInvoiceDebit::where('crm_invoice_id', '=', $invoice_id)->update($cid);
			}else{
				$invData[] = $data;
			}
		}
		CrmInvoiceDebit::insert($invData);
	  }
	  return 1;
    }

    public static function get_session() {
		$session = Session::get('admin_details');
		//print_r($session);die;
        return $session;
    }

    public static function checkEmailAddress($contacts, $ContactID)
    {
    	$email = '';
    	if(isset($contacts) && count($contacts) >0){
    	  foreach ($contacts as $key => $val) {
			if(isset($val['ContactID']) && $val['ContactID'] == $ContactID){
				$email = $val['EmailAddress'];
			}
		  }
    	}
    	return $email;
    }
    public static function getContactArray($array)
    {
    	$data = array();
    	$encode_contact = json_encode($array['Contact']);
	    $contacts 		= json_decode($encode_contact);

    	if(isset($contacts) && count($contacts) >0){
    	  foreach ($contacts as $key => $val) {
			$data[$key]['ContactID']    = isset($val->ContactID)?$val->ContactID:'';
			$data[$key]['Name'] 	    = isset($val->Name)?$val->Name:'';
			$data[$key]['EmailAddress'] = $val->EmailAddress;
    	  }
    	}
    	return $data;
    }

    public static function getWipDetailsById($id)
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
                $data['taskdate']    = (isset($val->taskdate) && $val->taskdate !='0000-00-00')?$val->taskdate:"";
                $data['task_time']   = (isset($val->task_time) && $val->task_time!='00:00:00')?$val->task_time:"";

                $data['rel_client_id']  = $val->rel_client_id;
                $data['staff_id']       = $val->staff_id;
                $data['notes']          = $val->notes;
                $data['activities']     = $val->activities;
                $data['amount']         = $val->amount;
                $data['add_file']       = $val->add_file;
                $data['status']         = $val->status;
                $data['created']        = $val->created;
                $data['showin_tab']     = Todolistnewtask::getShowIn($data['taskdate'], $data['task_time']);
                $data['activity_name']  = ProposalActivity::getActivityNameByActivityIds($val->activities);
            }
        }
        return $data;
    }

    public static function getWipInvoiceDetailsByIds($ids)
    {
    	$data 	= array();
    	if(isset($ids) && $ids != ''){
    		$qry = "SELECT rel_client_id FROM todolistnewtasks WHERE todolistnewtasks_id IN (".$ids.") GROUP BY rel_client_id";
    		//echo $qry;die;
    		$dtls = DB::select(DB::raw( $qry ));

    		if (isset($dtls) && count($dtls) >0 && !empty($dtls)) {
	            foreach ($dtls as $k => $v) {
	            	$data[$k]['client_name'] = Common::ClientNameById($v->rel_client_id);
	            	$sqry = "SELECT activities, amount, taskname FROM todolistnewtasks WHERE rel_client_id = '".$v->rel_client_id."'";
	            	$sdtls = DB::select(DB::raw( $sqry ));
	            	$sdata 	= array();
	            	if (isset($sdtls) && count($sdtls) >0 && !empty($sdtls)) {
	            		foreach ($sdtls as $sk => $sv) {
	            			$act = $sv->activities;

	            			$sdata[$sk]['amount'] 		 = $sv->amount;
	            			$sdata[$sk]['taskname']      = $sv->taskname;
	            			$sdata[$sk]['activity_name'] = ProposalActivity::getActivityNameByActivityIds($act);
	            		}
	            	}
	            	$data[$k]['LineItem'] = $sdata;
	            }
	        }
    	}

    	return $data;
    }


    public static function updateWipInvoiceByIds($ids)
    {
    	if(isset($ids) && $ids != ''){
	    	$ids = explode(',', $ids);
	    	DB::table('todolistnewtasks')->whereIn('todolistnewtasks_id', $ids)
	        ->update(array('status' => 'invoiced'));  
	    }
    }





}
