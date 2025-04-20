<?php

class LettersController extends BaseController {
	public function __construct()
	{
		parent::__construct();
	    $session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];
		if (empty($user_id)) {
			Redirect::to('/login')->send();
		}
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}
	}
	
	public function dashboard()
	{
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $data['heading']            = 'LETTERS & CONTACTS';
        $data['title']              = ucfirst(strtolower($data['heading']));		

		//echo "<prev>".print_r($data);die;
		return View::make('letters.dashboard', $data);
	}

	public function generate_letter($page_open, $template_id, $copyId=0, $type='L') 
	{
		$data['title'] 			= 'Generate Letter';
		$data['previous_page'] 	= '<a href="/letters">Letters & Contacts</a>';
		$data['heading'] 		= "GENERATE LETTER";
		$admin_s 				= Session::get('admin_details');
		$user_id 				= $admin_s['id'];
		$groupUserId 			= $admin_s['group_users'];
		$data['page_open'] 		= $page_open;
		$data['user_id'] 		= $user_id;
		$data['template_id']	= $template_id;
		$data['isCopyId']		= $copyId;
		$data['type']			= $type;
        
		$data['template_types'] = TemplateType::get();
		
        $data['old_services'] 	= Service::where("status", "old")->orderBy("service_name")->get();
        $data['new_services'] 	= Service::where("status", "new")->whereIn("user_id", $groupUserId)->orderBy("service_name")->get();
		
		$data['ind_client_details'] = Client::getAllIndClientDetails();

		$data['letterheads'] = LetterHead::getLetterHeads();
		// error_log(print_r($data['letter-heads'], true));

		if($template_id != 0){
        	$data['contacts'] = GenerateLetterRecepient::getReceipientByTemplate($template_id);
        }
		
		if($page_open == 2){
			if($template_id != 0){
				$data['tempDetails'] = LetterTemplate::getTemplateById($template_id);
				$data['content'] = $data['tempDetails']['content'];
			}
			if($copyId != 0){
				$isCopyId = explode('-', $copyId);
				$template_id 	= $isCopyId[0];
				$resp_id 		= $isCopyId[1];

				if($type == 'L'){
					$dtls = GenerateLetterPreview::getcontentByRecipientTemplateId($resp_id,$template_id,'F');
					if(empty($dtls)){
						$data['content'] = LetterTemplate::getTemplateContentById($template_id);
					}else{
						$data['content'] = $dtls;
					}
				}else{
					$data['templateData'] = ContactEmailTemplate::getEmailTemplateById($template_id);
					$filepath='email_templates/'.$template_id.'.txt';

					$data['content'] = File::get($filepath);
				}
			}
			/*$data['templates'] 	= ContactEmailTemplate::getEmailTemplate();
			$data['letters'] 	= LetterTemplate::getFinalTemplate();
			$data['recipients'] = GenerateLetterRecepient::getAllFinalReceipient();*/

			if(Session::has('recipients')){
				$recipients = Session::get('recipients');
				$resptDtls = GenerateLetterRecepient::whereIn("recipient_id", $recipients)->get();
				$data['contacts'] = GenerateLetterRecepient::getArray($resptDtls);
			}
			//echo "<pre>";print_r($data['contacts']);die;
		}
		if($page_open == 1){
			if($template_id != 0){
				$data['itemDetails'] = GenerateLetterRecepient::getReceipientByTemplate($template_id);
			}

			/* =================== Remove Session ====================*/
			GenerateLetterRecepient::where("template_id", '0')->delete();
			if(Session::has('recipients')){
				$recipients = Session::get('recipients');
				GenerateLetterRecepient::whereIn("recipient_id", $recipients)->delete();
				Session::forget('recipients');
			}
		}

		if($page_open != 1 && $page_open != 2){
			$pageOpen 		= explode('-', $page_open);
			$recipient_id 	= $pageOpen[1];
			$data['recipient_id']	= $recipient_id;

			$newData = $this->getPreviewData($data);
			$data['newsubject'] = $newData['newsubject'];
			$data['newcontent'] = $newData['newcontent'];
		}

		$data['templates'] 	= ContactEmailTemplate::getEmailTemplate();
		$data['letters'] 	= LetterTemplate::getFinalTemplate();
		$data['recipients'] = GenerateLetterRecepient::getAllFinalReceipient();

		//echo "<pre>"; print_r($groupUserId); die;
		return View::make('letters.generate_letter', $data);
	}

	public function generate_letter_action() {
		$session        = Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId    = $session['group_users'];

		$postData = Input::all();
		$data = array();
		switch ($postData['action']) {
			case 'changeDropdown':
				$data = $this->getAllValueByContactType($postData);
				echo json_encode($data);
				break;

			case 'getSearchValue':
				$data = $this->getSearchValueByContactType($postData);
				echo json_encode($data);
				break;

			case 'addToTable':
				$recipients = $this->inserIntoTable($postData);
				//echo "<pre>";print_r($recipients);

				//$data = GenerateLetterRecepient::getAllReceipient();
				$data = GenerateLetterRecepient::getReceipientBySession($recipients);
				echo json_encode($data);
				break;

			case 'deleteGenerateLetter':
				GenerateLetterRecepient::whereIn('recipient_id', $postData['delete_ids'])->delete();
				$data['return'] = 1;
				echo json_encode($data);
				break;

			case 'deleteItem':
				$this->deleteTemplateData($postData);
				$data['return'] = 1;
				echo json_encode($data);
				break;

			case 'getPlaceHolder':
				$data = PlaceholderName::getNameByType($postData['dropValue']);
				echo json_encode($data);
				break;

			case 'confidential':
				$data = $this->checkConfidential($postData);
				echo json_encode($data);
				break;

			case 'saveTemplate':
				if($postData['status'] == 'T'){
					$template_id = ContactEmailTemplate::saveAsTemplateDetails($postData);
					$data['message'] 		= 'success';
					$data['template_id'] 	= $template_id;
				}else{
					if (Session::has('recipients') || $postData['template_id'] != '0') {
					  $template_id = LetterTemplate::saveTemplate($postData);
					  $data['message'] 		= 'success';
					  $data['template_id'] 	= $template_id;
					}else{
						$data['message'] = 'error';
					}
				}

				if($data['message'] == 'success'){
					$data['recipient_id'] 	= $postData['recipient_id'];
					$data['previews'] 		= $this->getPreviewData($data);
				}
				
				echo json_encode($data);
				break;

			case 'getTemplateData':
				$data = $this->getTemplateById($postData);
				echo json_encode($data);
				break;

			case 'generatePdfTemplate':
				$data['templateName'] = $this->generatePdfTemplate($postData);
				echo json_encode($data);
				break;

			case 'getPreviewData':
				$data['details'] = $this->getPreviewData($postData);
				echo json_encode($data);
				break;

			case 'checkContactSession':
				$data = $this->checkContactSession($postData);
				echo json_encode($data);
				break;

			case 'generatePdfForView':
				$data['templateName'] = $this->generatePdfForView($postData);
				echo json_encode($data);
				break;
			
			default:
				# code...
				break;
		}
	}

	public function generatePdfForView($postData)
	{
		$admin_s 			= Session::get('admin_details');
		$user_id 			= $admin_s['id'];
		$groupUserId 		= $admin_s['group_users'];

		$recipient_id 	= $postData['recipient_id'];
		$template_id 	= $postData['template_id'];

		$details['details'] 	= LetterTemplate::getGeneratePdfDetails($recipient_id);
		$details['templates'] 	= LetterTemplate::getDetailsForPdfByRespId($recipient_id);
		$details['replacing'] 	= PlaceholderName::getReplacingName('view_name');
		$details['replaced'] 	= PlaceholderName::getReplacingName('short_name');

		$data['template_id'] 	= $details['templates']['template_id'];

		$finalCont = GenerateLetterPreview::getcontentByRecipientTemplateId($recipient_id, $data['template_id'], 'F');
		if(!empty($finalCont)){
			$data['content'] 	= $finalCont;
		}else{
			$content  = str_replace("&nbsp;", " ", $details['templates']['content']);
			foreach ($details['replaced'] as $key => $value) {
				$details['replaced'][$key] = isset($details['details'][$value])?$details['details'][$value]:'[undefined]';
			}
			$data['content'] 	= str_replace($details['replacing'], $details['replaced'], $content);
		}

		$pdf = PDF::loadView('letters/generate_pdf/template', $data)->setPaper('a4')->
            setOrientation('portrait')->setWarnings(false);
        $templateName = $user_id.'_template.pdf';
        if(file_exists('uploads/emailTemplates/'.$templateName)){
        	unlink('uploads/emailTemplates/'.$templateName);
        }
        $output = $pdf->save('uploads/emailTemplates/'.$templateName);

        return $templateName;
	}

	public function checkContactSession($postData)
	{
		$data = $contacts = array();
		$template_id = $postData['template_id'];
		$recipients  = Session::get('recipients');
		if(isset($recipients) && count($recipients)>0){
			$count = count($recipients);
		}else if($template_id != '0'){
			$count = GenerateLetterRecepient::getReceipientCountByTemplate($template_id);
		}else{
			$count = 0;
		}
		$data['count'] = $count;

		/* =================== Tab 2 ===================== */
		if($data['count'] > 0){
			$copyId = $postData['isCopyId'];
			$type 	= $postData['type'];

			if($template_id != 0){
				$data['tempDetails'] = LetterTemplate::getTemplateById($template_id);
				$data['content'] = $data['tempDetails']['content'];
			}
			if($copyId != 0){
				$isCopyId = explode('-', $copyId);
				$template_id 	= $isCopyId[0];
				$resp_id 		= $isCopyId[1];

				if($type == 'L'){
					$dtls = GenerateLetterPreview::getcontentByRecipientTemplateId($resp_id,$template_id,'F');
					if(empty($dtls)){
						$data['content'] = LetterTemplate::getTemplateContentById($template_id);
					}else{
						$data['content'] = $dtls;
					}
				}else{
					$data['templateData'] = ContactEmailTemplate::getEmailTemplateById($template_id);
					$filepath='email_templates/'.$template_id.'.txt';

					$data['content'] = File::get($filepath);
				}
			}
			$data['templates'] 	= ContactEmailTemplate::getEmailTemplate();
			$data['letters'] 	= LetterTemplate::getFinalTemplate();
			$data['recipients'] = GenerateLetterRecepient::getAllFinalReceipient();

			if(Session::has('recipients')){
				$recipients = Session::get('recipients');
				$resptDtls = GenerateLetterRecepient::whereIn("recipient_id", $recipients)->get();
				$contacts = GenerateLetterRecepient::getArray($resptDtls);
			}
			//echo "<pre>";print_r($data['contacts']);die;
		}

		$data['contacts'] = $contacts;
		return $data;
	}
	

	public function getPreviewData($postData)
	{
		$session        = Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId    = $session['group_users'];

		$data 			= array();
		$template_id 	= $postData['template_id'];
		$recipient_id 	= $postData['recipient_id'];

		$detailsPrev = GenerateLetterPreview::whereIn("user_id", $groupUserId)->where("template_id", $template_id)->where("recipient_id", $recipient_id)->first();
		//echo count($detailsPrev);die;
		if(isset($detailsPrev) && count($detailsPrev)>0){
			$data['newcontent'] 	= $detailsPrev['content'];
			$data['newsubject'] 	= $detailsPrev['subject'];
			$data['template_id']	= $detailsPrev['template_id'];
		}else{
			$details['details'] 	= LetterTemplate::getGeneratePdfDetails($recipient_id);
			$details['templates'] 	= LetterTemplate::getDetailsForPdfByRespId($recipient_id);
			$details['replacing'] 	= PlaceholderName::getReplacingName('view_name');
			$details['replaced'] 	= PlaceholderName::getReplacingName('short_name');

			$content  = str_replace("&nbsp;", " ", $details['templates']['content']);
			foreach ($details['replaced'] as $key => $value) {
				$details['replaced'][$key] = isset($details['details'][$value])?$details['details'][$value]:'[undefined]';
				//echo $details['replaced'][$key];
			}
			$data['newcontent'] 	= str_replace($details['replacing'], $details['replaced'], $content);
			$data['newsubject'] 	= $details['templates']['subject'];
			$data['template_id']	= $details['templates']['template_id'];
			//echo "<pre>";print_r($details['details']);die;
		}
		//echo $data['newcontent'];die('end');
		return $data;
	}

	public function generatePdfTemplate($postData)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id 		= $session['id'];

		$data['content'] = $postData['content'];

		$subject 		= $postData['subject'];
		$item_name 		= $postData['item_name'];
		$lhead 			= $postData['lhead'];

		if (isset($lhead)) {
			$selectedLHead = $this->get_letter_head($lhead);
		} 
		$ltpdf = new FPDI();

		if ($selectedLHead) {
			$pdffile = public_path().'/letter_heads/'.$selectedLHead['name'];
			$pagecount = $ltpdf->setSourceFile($pdffile);
			$tplIdx = $ltpdf->importPage(1);
			$ltpdf->AddPage();
			$ltpdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		} else {
			$ltpdf->AddPage();
		}
		
		$ltpdf->SetFont('Times');	
		$ltpdf->WriteHTML($data['content']);

		//LetterTemplate::where('template_id','=',$postData['template_id'])->update($data);
		
		// $pdf = PDF::loadView('letters/generate_pdf/template', $data)->setPaper('a4')->
                // setOrientation('portrait')->setWarnings(false);

        $templateName = $subject.' - '.$item_name.'.pdf';
        if(file_exists('uploads/emailTemplates/'.$templateName)){
        	unlink('uploads/emailTemplates/'.$templateName);
        }
        //$output = $pdf->save('uploads/emailTemplates/'.$templateName);
		
		$ltpdf->output('uploads/emailTemplates/'.$templateName,'F');
        
        return $templateName;
	}

	public function getTemplateById($postData)
	{
		$data = array();
		if($postData['type'] == 'L'){
			$data['templateBody'] = LetterTemplate::getTemplateContentById($postData['dropValue']);
		}else if($postData['type'] == 'C'){
			$recipient_id = $postData['dropValue'];
			$data['templateBody'] = GenerateLetterPreview::getFinalContentByRespId($recipient_id,'F');
		}else{
			$filepath='email_templates/'.$postData['dropValue'].'.txt';
			$data['templateBody'] = File::get($filepath);
		}
		return $data;
	}

	public function checkConfidential($postData)
	{
		$session 	= Session::get('admin_details');
		$user_id 	= $session['id'];

		$UpdateData = array();
		if(isset($postData['checkbox']) && $postData['checkbox'] == 'checked'){
			$UpdateData['confidentialUserId'] = $user_id;
		}else{
			$UpdateData['confidentialUserId'] = 0;
		}
		LetterTemplate::where('template_id', '=', $postData['template_id'])->update($UpdateData);
		return $UpdateData;
	}

	public function deleteTemplateData($delete_ids)
	{
		LetterTemplate::whereIn('template_id', $delete_ids)->delete();
		GenerateLetterRecepient::whereIn('template_id', $delete_ids)->delete();

	}

	public function inserIntoTable($postData) {
		$session        = Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId    = $session['group_users'];
        $dataInsrt 		= array();
        $template_id 	= $postData['template_id'];

        $dataInsrt['user_id'] 	= $user_id;
        $dataInsrt['item_type'] = $postData['dropValue'];
        $dataInsrt['created'] 	= date('Y-m-d H:i:s');


        if($postData['dropValue'] == 'group'){
        	$cntgrpDtls = ContactsGroup::getContactsGroupByGroupId($postData['item_id']);
        	if(isset($cntgrpDtls) && count($cntgrpDtls) >0){
        		foreach ($cntgrpDtls as $key => $value) {
        			$details = GenerateLetterRecepient::whereIn("user_id", $groupUserId)->where('item_type', '=', $postData['dropValue'])->where('item_id', '=', $value['client_id'])->where('template_id', '=', $template_id)->first();
        			if(empty($details) || count($details) <= 0){
        				$dataInsrt['item_id'] 	= $value['client_id'];
						$dataInsrt['group_id']  = $postData['item_id'];
						$last_id = GenerateLetterRecepient::insertGetId($dataInsrt);
						Session::push('recipients', $last_id);
        			}
				}
			}
        }else if($postData['dropValue'] == 'org' || $postData['dropValue'] == 'ind'){
        	$details = GenerateLetterRecepient::whereIn("user_id", $groupUserId)->where('item_type', '=', $postData['dropValue'])->where('item_id', '=', $postData['item_id'])->where('template_id', '=', $template_id)->first();
			if(empty($details) || count($details) <= 0){
				$dataInsrt['item_id'] 	= $postData['item_id'];
				$last_id = GenerateLetterRecepient::insertGetId($dataInsrt);
				Session::push('recipients', $last_id);
			}
        }else{
        	$dataInsrt['item_id'] 	= $postData['item_id'];
			$last_id = GenerateLetterRecepient::insertGetId($dataInsrt);
			Session::push('recipients', $last_id);
        }

        $recipients = Session::get('recipients');
		return $recipients;
	}

	public function getAllValueByContactType($postData) {
		$data = array();
		$value 			= $postData['dropValue'];
		$template_id 	= $postData['template_id'];

		if($value == 'org' || $value == 'ind'){
			$details 	= Client::getAllClientsByType($value, '');
			//echo "<pre>";print_r($details);die;
			$data 		= $this->checkContactType($details, $value, 'client_id', $template_id);
		}else if($value == 'staff'){
			$details 	= User::getAllStaffName();
			$data 		= $this->checkContactType($details, $value, 'user_id', $template_id);
		}else if($value == 'other'){
			$details 	= ContactAddress::getAllContactDetails();
			$data 		= $this->checkContactType($details, $value, 'contact_id', $template_id);
		}else if($value == 'group'){
			$details 	= ContactsStep::getAllNewGroupDetails();
			$data 		= $this->checkContactType($details, $value, 'step_id', $template_id);
		}

		return $data;
	}

	public function checkContactType($data, $item_type, $item_id, $template_id) {
		$session        = Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId    = $session['group_users'];

		$details = array();
		if(isset($data) && count($data) >0){
			foreach ($data as $key => $value) {
				if($item_type == 'ind' || $item_type == 'org' || $item_type == 'group'){
					$dtls = GenerateLetterRecepient::whereIn("user_id", $groupUserId)->where('item_id', '=', $value[$item_id])->where('template_id', '=', $template_id)->get();
				}else{
					$dtls = GenerateLetterRecepient::whereIn("user_id", $groupUserId)->where('item_type', '=', $item_type)->where('item_id', '=', $value[$item_id])->where('template_id', '=', $template_id)->get();
				}
				
				if(empty($dtls) || count($dtls) <=0){
					$details[$key] = $data[$key];
				}
			}
		}
		//echo "<pre>";print_r($details);die;
		return $details;
	}

	public function getSearchValueByContactType($postData) {
		$data = array();
		$dropValue 		= $postData['dropValue'];
		$template_id 	= $postData['template_id'];

		if($postData['dropValue'] == 'org' || $postData['dropValue'] == 'ind'){
			$data1 		= Client::getAllClientsByType($postData['dropValue'], $postData['searchValue'] );
			$data 		= $this->checkContactType($data1, $postData['dropValue'], 'client_id', $template_id);
		}else if($postData['dropValue'] == 'staff'){
			$details = User::getAllStaffName();
			$data1 = $this->searchArrayKeyVal('staff_name', $postData['searchValue'], $details, $dropValue);
			$data 		= $this->checkContactType($data1, $postData['dropValue'], 'user_id', $template_id);
		}else if($postData['dropValue'] == 'other'){
			$details = ContactAddress::getAllContactDetails();
			$data1 = $this->searchArrayKeyVal('company_name', $postData['searchValue'], $details, $dropValue);
			$data 		= $this->checkContactType($data1, $postData['dropValue'], 'contact_id', $template_id);
		}else if($postData['dropValue'] == 'group'){
			$data1 = ContactsStep::getAllNewGroupDetails();
			$data 		= $this->checkContactType($data1, $postData['dropValue'], 'step_id', $template_id);
		}

		return $data;
	}

	function searchArrayKeyVal($column_name, $searchValue, $details, $dropValue) {
		$data = array();
		$i = 0;
		if($searchValue != ""){
			if(isset($details) && count($details) >0){
				foreach ($details as $key => $val) {
					if (strpos(strtolower($val[$column_name]), strtolower(trim($searchValue))) !== false) {
						if($dropValue == 'staff'){
							$data[$i]['user_id'] 	= $val['user_id'];
			            }else if($dropValue == 'other'){
							$data[$i]['user_id'] 	= $val['user_id'];
			            }
						$data[$i][$column_name] = $val[$column_name];
			            
			            $i++;
			        }
				}
		    }
		}else{
			$data = $details;
		}
	    
	    return $data;
	}

	public function getValueByItemId($postData) {
		$data = '';
		$dropValue = $postData['dropValue'];
		if($dropValue == 'org' || $dropValue == 'ind'){
			$data = Client::getClientNameByClientId($postData['item_id'] );
		}else if($dropValue == 'staff'){
			$data = User::getStaffNameById($postData['item_id']);
		}else if($dropValue == 'other'){
			$data = ContactAddress::getCompanyNameById($postData['item_id']);
		}else if($dropValue == 'group'){
			$data = ContactsStep::getStepNameById($postData['item_id']);
		}

		return $data;
	}

    public function view_letter($page_open) {
		$data['title'] 	= 'View Letter';
		$data['previous_page'] = '<a href="/letters">Letters & Contacts</a>';
		$data['heading'] 	= "VIEW LETTER";
		$admin_s 			= Session::get('admin_details');
		$user_id 			= $admin_s['id'];
		$groupUserId 		= $admin_s['group_users'];
		$data['page_open'] 	= $page_open;
		$data['user_id'] 	= $user_id;
		$data['recipient_id'] 	= 0;

		
		if($page_open == 1){
			//$data['itemDetails'] = GenerateLetterRecepient::getAllFinalReceipient();
			$data['finalDetails'] = LetterTemplate::getFinalTemplate();
		}else if($page_open == 2){
			//$data['draftDetails'] = GenerateLetterRecepient::getAllDraftReceipient();
			//$data['draftPreviewDetails'] = GenerateLetterPreview::getAllDraftTemplate();
			$data['draftDetails'] = LetterTemplate::getDraftTemplate();
		}

		if($page_open != 1 && $page_open != 2){
			$pageOpen 		= explode('-', $page_open);
			$template_id 	= $pageOpen[1];
			
			if($pageOpen[0] == '31'){
				$data['template_id'] = $template_id;
				$data['itemDetails'] = GenerateLetterRecepient::getReceipientByTemplate($template_id);
			}else{
				$data['template_id'] = GenerateLetterRecepient::getTemplateIdByRecipientId($pageOpen[1]);
				/*$recipient_id 			= $pageOpen[1];
				$details['details'] 	= LetterTemplate::getGeneratePdfDetails($recipient_id);
				$details['templates'] 	= LetterTemplate::getDetailsForPdfByRespId($template_id);
				$details['replacing'] 	= PlaceholderName::getReplacingName('view_name');
				$details['replaced'] 	= PlaceholderName::getReplacingName('short_name');

				$data['template_id'] 	= $details['templates']['template_id'];

				$finalCont = GenerateLetterPreview::getcontentByRecipientTemplateId($recipient_id, $data['template_id'], 'F');
				if(!empty($finalCont)){
					$data['content'] 	= $finalCont;
				}else{
					$content  = str_replace("&nbsp;", " ", $details['templates']['content']);
					foreach ($details['replaced'] as $key => $value) {
						$details['replaced'][$key] = isset($details['details'][$value])?$details['details'][$value]:'[undefined]';
					}
					$data['content'] 	= str_replace($details['replacing'], $details['replaced'], $content);
				}

				$pdf = PDF::loadView('letters/generate_pdf/template', $data)->setPaper('a4')->
	                setOrientation('portrait')->setWarnings(false);
	            $templateName = $user_id.'_template.pdf';
	            if(file_exists('uploads/emailTemplates/'.$templateName)){
	            	unlink('uploads/emailTemplates/'.$templateName);
	            }
	            $output = $pdf->save('uploads/emailTemplates/'.$templateName);*/
			}
			$data['template_title'] = LetterTemplate::getTemplateNameById($data['template_id']);
		}


		//echo "<pre>";print_r($data['itemDetails']);die;
		return View::make('letters.view_letter', $data);
	}

	public function templates() {
		$data['title'] 	= 'Templates';
		$data['previous_page'] = '<a href="/letters">Letters & Contacts</a>';
		$data['heading'] 	= "TEMPLATES";
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 		= $session['group_users'];
		
		$data['templates'] 	= ContactEmailTemplate::getEmailTemplate();
		//$data['placeholders']=Placeholder::get();
		//$data['template_types'] = TemplateType::get();
		
		//print_r($data['placeholders']);die;
		return View::make('letters.templates', $data);
	}

	public function template_action($template_id = 0, $copyId = 0)
	{
		$action = ($template_id == 0)?'Add':'Edit';
		$data['title'] 			= $action.' Templates';
		$data['previous_page'] 	= '<a href="/letters/templates">Templates</a>';
		$data['heading'] 		= $data['title'];

		$data['placeholders']	= Placeholder::select('module')->distinct()->get();
		$data['template_types'] = TemplateType::get();
		
		if($copyId != 0){
			$data['templateData'] 	= $this->getTemplate($copyId);
			$filepath='email_templates/'.$copyId.'.txt';
			$data['templateBody'] = File::get($filepath);
		}
		
		return View::make('letters.templates.add',$data);
	}


	// hcb - letter heads controllers
	public function letter_heads_listing() {
		$data['title'] 	= 'Letter Heads';
		$data['previous_page'] = '<a href="/letters">Letters & Contacts</a>';
		$data['heading'] 	= "Letter Heads";
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 		= $session['group_users'];
		
		$data['letterheads'] 	= LetterHead::getLetterHeads();

		return View::make('letters.letterheads.listing', $data);
	}

	public function add_letter_head() {
		$data['title'] 	= 'Upload Letter Heads';
		$data['previous_page'] = '<a href="/letters">Letters & Contacts</a> / <a href="/letters/letter-head">Letter Heads</a>';
		$data['heading'] 	= "Upload Letter Heads";
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId 		= $session['group_users'];

		return View::make('letters.letterheads.upload', $data);
	}

	public function upload_letter_head() {
		$data = Input::all();
		$response = LetterHead::saveLetterHead($data);
                                                                                                                                                                               
		if ($response == true) {
			Redirect::to('/letters/letter-head')->send();
		} else {
			echo "error";
		}
	}

	public function delete_letter_head() {

		$response = LetterHead::deleteLetterHeadById(Input::get('id'));

		if ($response == true) {
			return "success";
		} else {
			Redirect::to('/letters/letter-head')->send();
		}
	}

	public function make_default_letter_head() {

		$response = LetterHead::makeDefaultLetterHeadById(Input::get('id'));

		if ($response == true) {
			return "success";
		} else {
			Redirect::to('/letters/letter-head')->send();
		}
	}

	public function get_default_letter_head() {

		return LetterHead::getDefaultLetterHead();
	}

	public function get_letter_head($id) {

		return LetterHead::getLetterHeadById($id);
	}




	/* test */
	public function table_test()
	{
		$data = array();
		return View::make('table_test.table', $data);
	}

}
