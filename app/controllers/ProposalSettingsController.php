<?php

class ProposalSettingsController extends BaseController {
	public function __construct()
	{
		parent::__construct();
		$session    = Session::get('admin_details');
    	$this->user_id    		= $session['id'];
    	$this->group_id    		= $session['group_id'];
    	$this->groupUserId    	= $session['group_users'];
	}

	public function branding()
	{
		$data['content_header'] = 'Branding';
		$owner_id 				= 'all';
		$data['goto_url'] 		= '/crm';
		$data['page_open'] 		= 'branding';
        $data['tab_no'] 		= 'proposal';
        $data['all_count'] 		= 0;
        $data['heading']    	= "PROPOSALS";
        $data['title']      	= "PROPOSALS";
        $data['selected_page']  = "branding";
        $data['owner_id'] 		= $owner_id;
        $data['encode_owner_id']= $owner_id;
        $data['user_id'] 		= $this->user_id;
        $data['group_id'] 		= $this->group_id;

        $data['practice'] 		= PracticeDetail::getPracticeDetailsData();	
        $data['imageColors'] 	= CrmColorDetect::getAllDetails();	
        //echo "<pre>";print_r($data['practice']);die;
		return View::make('crm.index', $data);
	}

	public function terms()
	{
		$data['content_header'] = 'Terms';
		$owner_id 				= 'all';
		$data['goto_url'] 		= '/crm';
		$data['page_open'] 		= 'terms';
        $data['tab_no'] 		= 'proposal';
        $data['all_count'] 		= 0;
        $data['heading']    	= "PROPOSALS";
        $data['title']      	= "PROPOSALS";
        $data['selected_page']  = "terms";
        $data['owner_id'] 		= $owner_id;
        $data['encode_owner_id']= $owner_id;

		$data['terms'] 			= TermsConditionFile::getTermsAndConditions();

		return View::make('crm.index', $data);
	}

	public function apps()
	{
		$data['content_header'] = 'Apps';
		$owner_id 				= 'all';
		$data['goto_url'] 		= '/crm';
		$data['page_open'] 		= 'apps';
        $data['tab_no'] 		= 'proposal';
        $data['all_count'] 		= 0;
        $data['heading']    	= "PROPOSALS";
        $data['title']      	= "PROPOSALS";
        $data['selected_page']  = "apps";
        $data['owner_id'] 		= $owner_id;
        $data['encode_owner_id']= $owner_id;
        $data['group_id'] 		= $this->group_id;

		$data['apps'] 			= TermsConditionFile::getTermsAndConditions();

		return View::make('crm.index', $data);
	}

	public function apps_xero()
	{
		return View::make('crm.settings.apps');
	}

	public function action()
	{
		$data 			= array();
		$action 		= Input::get('action');	
		$postData 		= Input::all();

		switch ($action) {
			case 'saveColorCode':
				$this->saveColorCode( $postData );
				$data['practice'] = PracticeDetail::getPracticeDetailsData();	
				//echo json_encode($data);
				//echo "<pre>";print_r($data['practice']);die;
				echo View::make('crm/includes/ajax_branding', $data);
				break;
			case 'logoChange':
				$data = $this->logoChange( $postData );
				echo json_encode($data);
				break;
			case 'savepNewLetterTemplate':
				$data['template'] = $this->savepNewLetterTemplate( $postData );
				echo json_encode($data);
				break;
			case 'deleteTemp':
				$this->deleteTemp( $postData );
				echo json_encode($postData);
				break;
			case 'getProposalTemplate':
				$type 			= $postData['type'];
				$table_id 		= $postData['table_id'];

				if($type == 'template'){
					$data['details'] = CrmProposalTemplate::getDetailsByTemplateId($table_id);
					$address = ClientAddress::addressByplaceHolder($postData);
					$data['details']['desc'] = str_replace('[Client Address]',$address,$data['details']['desc']);
				}else{
					$data['details'] = CrmProposalCoverletter::getDetailsByCoverLetterId($table_id);
				}
				echo json_encode($data);
				break;
			case 'saveCPCoverLetter':
				$data['details'] = $this->saveCPCoverLetter( $postData );
				echo json_encode($data);
				break;
			case 'deleteBrandingLogo':
				$data = $this->deleteBrandingLogo($postData);
				echo json_encode($data);
				break;
			case 'checkServiceInProposal':
				$data['count'] = $this->checkServiceInProposal($postData);
				echo json_encode($data);
				break;
			case 'archiveProposalItems':
				$data['details'] = $this->archiveProposalItems($postData);
				echo json_encode($data);
				break;
			case 'checkActivityInProposal':
				$data['count'] = $this->checkActivityInProposal($postData);
				echo json_encode($data);
				break;
			case 'checkAttachmentInProposal':
				$data['count'] = $this->checkAttachmentInProposal($postData);
				echo json_encode($data);
				break;
			
				
			default:
				
				break;
		}

	}


	public function replace_placeholder($content){
		$details['replacing'] 	= PlaceholderName::getReplacingName('view_name');
		$details['replaced'] 	= PlaceholderName::getReplacingName('short_name');

		$content  = str_replace("&nbsp;", " ", $content);
		foreach ($details['replaced'] as $key => $v) {
			$details['replaced'][$key] = isset($details['details'][$v])?$details['details'][$v]:'[undefined]';
		}
		$data['newcontent'] 	= str_replace($details['replacing'], $details['replaced'], $content);
	}

	public function archiveProposalItems($postData)
	{
		$column_name   	= $postData['column_name'];
  		$column_value  	= $postData['column_value'];
  		$table_name    	= $postData['table_name'];
  		$update_value 	= $postData['update_value'];
  		$event    		= $postData['event'];

  		if($event == 'archive' || $event == 'unarchive'){
	  		$upData['is_archive'] = $update_value;
	  		DB::table($table_name)->where($column_name, $column_value)->update($upData);
	  	}
	  	if($event == 'delete'){
	  		DB::table($table_name)->where($column_name, $column_value)->delete();
	  	}
  		return $postData;
	}

	public function checkAttachmentInProposal($postData)
	{
		$attachment_id = $postData['attachment_id'];
		$count = CrmProposalAttachment::checkDataByAttachmentId($attachment_id);
		return $count;
	}

	public function checkServiceInProposal($postData)
	{
		$service_id = $postData['service_id'];
		$count = CrmProposalService::checkDataByServiceId($service_id);
		return $count;
	}

	public function checkActivityInProposal($postData)
	{
		$activity_id = $postData['activity_id'];
		$count = CrmProposalActivity::where('activity_id',$activity_id)->count();
		return $count;
	}

	public function deleteBrandingLogo($postData)
	{
		$logo_name = PracticeDetail::whereIn('user_id',$this->groupUserId)->select('crm_branding_logo')->first();
		if(isset($logo->crm_branding_logo) && $logo->crm_branding_logo != ''){
			//unlink('colorextract/images/'.$logo_name);
		}
		$Updata['crm_branding_logo'] 	= '';
		$Updata['use_color'] 			= 'N';
		PracticeDetail::whereIn('user_id', $this->groupUserId)->update($Updata);
		CrmColorDetect::whereIn('user_id', $this->groupUserId)->delete();

		$data['success'] = 1;
		return $data;
	}

	public function saveCPCoverLetter( $postData )
	{
		$cover_letter_id 			= $postData['cover_letter_id'];
		$Idata['proposal_id'] 		= $postData['proposal_id'];
		//$Idata['letter_id'] 		= $postData['letter_id'];
		$Idata['template_id'] 		= $postData['template_id'];
		$Idata['desc'] 				= $postData['desc'];
		
		$original_addr = ClientAddress::addressByplaceHolder($postData);

		//$address=str_ireplace('<p>','',$postData['placeholder_desc']);
		//$address=str_ireplace('</p>','',$address); 
		$original_addr = str_ireplace(' ', '&nbsp;', $original_addr);
		$original_addr = str_ireplace(',', '<br />', $original_addr);
		

		//$Idata['placeholder_desc'] = $address;

		$Idata['placeholder_desc'] = str_replace($original_addr, '[Client Address]',$postData['placeholder_desc']);

		if($cover_letter_id > 0){
			$Idata['modified'] 	= date('Y-m-d H:i:s');
			CrmProposalCoverletter::where('cover_letter_id', $cover_letter_id)->update($Idata);
		}else{
			$Idata['user_id'] 	= $this->user_id;
			$Idata['created'] 	= date('Y-m-d H:i:s');
			$Idata['modified'] 	= date('Y-m-d H:i:s');
			$cover_letter_id 	= CrmProposalCoverletter::insertGetId($Idata);
		}
		$details = CrmProposalCoverletter::getDetailsByCoverLetterId( $cover_letter_id );
		return $details;
	}

	public function deleteTemp( $postData )
	{
		$template_id = $postData['template_id'];
		CrmProposalTemplate::where('template_id', $template_id)->delete();
	}

	public function savepNewLetterTemplate( $postData )
	{
		$template_id = $postData['pNewLetterId'];
		$Idata['title'] 		= $postData['pnTempTitle'];
		$Idata['desc'] 			= $postData['desc'];
		
		if($template_id > 0){
			$Idata['modified'] 	= date('Y-m-d H:i:s');
			CrmProposalTemplate::where('template_id', $template_id)->update($Idata);
		}else{
			$Idata['user_id'] 	= $this->user_id;
			$Idata['template_type'] = 'L';
			$Idata['created'] 	= date('Y-m-d H:i:s');
			$Idata['modified'] 	= date('Y-m-d H:i:s');
			$template_id = CrmProposalTemplate::insertGetId($Idata);
		}
		$details = CrmProposalTemplate::getDetailsByTemplateId( $template_id );
		return $details;
	}

	public function saveColorCode( $postData )
	{
		$type = $postData['type'];
		if($type == 'manual_change'){
			$data['crm_manual_color'] 	= $postData['color'];
		}
		if($type == 'auto_change'){
			$data['crm_auto_color'] 	= $postData['color'];
		}
		if($type == 'manual_use'){
			$data['crm_manual_color'] 	= $postData['color'];
			$data['use_color'] 			= $postData['use_color'];
		}
		if($type == 'manual_notuse' || $type == 'auto_notuse'){
			$data['use_color'] 			= 'N';
		}
		if($type == 'auto_use'){
			$data['crm_auto_color'] 	= $postData['color'];
			$data['use_color'] 			= $postData['use_color'];
		}
		
		PracticeDetail::whereIn("user_id", $this->groupUserId)->update($data);
		return $data;
	}
	
    

}

