<?php

class ProposalPreviewController extends BaseController {
	public $user_id;
	public $groupUserId;

	public function __construct()
	{
		parent::__construct();
		$session    		= Session::get('admin_details');
    	$this->user_id    	= $session['id'];
    	$this->groupUserId  = $session['group_users'];

	}

	public function action()
	{
		$data 			= array();
		$action 		= Input::get('action');	

		switch ($action) {
			case 'saveSignature':
				$postData = Input::all();
				$data['signedData'] = $this->saveSignature($postData);
				echo View::make('crm.proposal.proposals.ajax_signed_popup', $data);
				//echo json_encode($data);
				break;
			case 'markedSigned':
				$postData = Input::all();
				$data['details'] = $this->saveSignature($postData);
				echo json_encode($data);
				break;
			case 'saveCommentInPreview':
				$postData 			= Input::all();
				$data['comments'] 	= $this->saveCommentInPreview($postData);
				echo View::make('crm.proposal.proposals.ajax_comment_preview', $data);
				//echo json_encode($data);
				break;




			

			default:
				# code...
				break;
		}

	}

	public function proposal_preview($crm_proposal_id, $page_from='email', $is_rejected='')
	{
		$data['title'] 			= 'Proposal Preview';
		$data['base_url'] 		= url();

		$crm_proposal_id 		= Crypt::decrypt($crm_proposal_id);
		$proposal_id 			= CrmProposal::getProposalIdByCrmProposalId( $crm_proposal_id );
		$user_id 				= CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);
		$group_id 				= User::getGroupIdByUserId($user_id);
		$groupUserId    		= Common::getUserIdByGroupId($group_id);

		$data['proposal_id'] 	= $proposal_id;
		$data['crm_proposal_id']= $crm_proposal_id;
		$data['cover'] 			= $this->getCoverDetails($proposal_id, $groupUserId);

		$data['practice'] 		= PracticeDetail::getPracticeDetailsPreview( $groupUserId );
		$data['attachments'] 	= CrmProposalAttachment::getAllAttachmentsPreview($proposal_id, $groupUserId);
		//$data['terms'] 			= TermsConditionFile::getTermsAndConditionsPreview($groupUserId);
		$data['terms'] 			= CrmProposalTerm::getDetailsByProposalId( $proposal_id, $groupUserId);
		$data['coverLetter'] 	= CrmProposalCoverletter::getDetailsPreview($proposal_id, $groupUserId);	
		$data['content'] 		= CrmProposalTable::getOtherTableDetails($proposal_id, $groupUserId);
		$data['grandTotals'] 	= CrmProposalTable::getGrandDetailsPreview( $proposal_id, $groupUserId );
		$data['comments'] 		= CrmProposalComment::getDetailsByCrmProposalId($crm_proposal_id);

		$data['signedName'] 	= CrmProposal::getSenderByCrmProposalId($crm_proposal_id);
		$data['signedData'] 	= CrmProposalSign::getDetailsByCrmProposalId($crm_proposal_id);

		$data['color'] 			= CrmProposal::getPreviewBrandingColor( $groupUserId, $crm_proposal_id );
		$data['logo'] 			= CrmProposal::getPreviewBrandingLogo( $groupUserId, $crm_proposal_id );

		/* for group table checking */
		$groupTableShow = 0;
		if(isset($data['grandTotals']) && count($data['grandTotals']) >0){
			foreach ($data['grandTotals'] as $k => $v) {
				if(isset($v['show_group']) && $v['show_group'] == 'Y'){
					$groupTableShow = 1;
				}
			}
		}
		$data['groupTableShow'] = $groupTableShow;
		/* for group table checking */

		$details = CrmProposal::getProposalById( $crm_proposal_id );
		if(empty($details)){
			$data['message'] = 'This proposal has been deleted';
			return View::make('crm.proposal.reject_preview', $data);
		}else{
			if($page_from == 'email'){
				if(isset($details['is_rejected']) && $details['is_rejected'] != $is_rejected){
					$data['message'] = 'This proposal has been revoked!<br>Contact sender for details';
					return View::make('crm.proposal.reject_preview', $data);
				}else{
					$save_type = CrmProposal::getSaveTypeById($crm_proposal_id);
					$uPdata['save_type'] = $save_type;
					if($save_type != 'A' && $save_type != 'MA' && $save_type != 'L' && $save_type != 'ML'){
						$uPdata['save_type'] = 'V';
						CrmProposal::updateByCrmProposalId($uPdata, $crm_proposal_id);
					}

					$uPdata['proposalID'] 	= $proposal_id;
					$uPdata['user_id'] 		= $user_id;
					CrmProposalHistory::insertProposalHistory($uPdata);
				}
			}
		}
		//echo $proposal_id;die;
		//echo "<pre>";print_r($data['grandTotals']);die;
		return View::make('crm.proposal.proposal_preview', $data);
	}


	public function getCoverDetails($proposal_id, $groupUserId)
	{
		$data['practice'] 	= PracticeDetail::getPracticeDetails($groupUserId);
		$data['proposal'] 	= CrmProposal::getDetailsByProposalId($proposal_id, $groupUserId);
		return $data;
	}

	public function saveSignature($postData)
	{
		$crm_proposal_id 	= $postData['crm_proposal_id'];
		$action_type 			= $postData['action_type'];

		$user_id 					= CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);
		$group_id 				= User::getGroupIdByUserId($user_id);
		$groupUserId    	= Common::getUserIdByGroupId($group_id);
		$proposalId 			= CrmProposal::getProposalIdByCrmProposalId($crm_proposal_id);

		if($action_type == 'A' || $action_type == 'MA'){
			$Updata['recurring_amount'] = CrmProposalTable::getRecurAmntByProposalId($proposalId, $groupUserId);
			$Updata['nonrecurr_amount'] = CrmProposalTable::getNonRecurAmntByProposalId($proposalId,$groupUserId);

			// update crm proposal services table for accepted
			$p_table_id = CrmProposalTable::getIdByProposalId($proposalId);
			CrmProposalService::where('p_table_id', $p_table_id)->update(array('is_signed'=>'Y'));

		}
		//echo $Updata['recurring_amount'];die;
		if($action_type == 'A' || $action_type == 'L'){
			$signatureText 	= $postData['signatureText'];
		}else{
			$signatureText 	= CrmProposal::getSenderByCrmProposalId($crm_proposal_id);

			$Updata['brand_color'] 	= PracticeDetail::getBrandingColor( $groupUserId );
			$Updata['brand_logo'] 	= PracticeDetail::getBrandingLogo( $groupUserId );
		}

		$Indata['crm_proposal_id'] 	= $crm_proposal_id;
		$Indata['signature'] 		= $signatureText;
		$Indata['ip_address'] 		= Common::get_ip_address();
		$Indata['created'] 			= date('Y-m-d H:i:s');
		$Indata['updated'] 			= date('Y-m-d H:i:s');

		CrmProposalSign::where('crm_proposal_id', $crm_proposal_id)->delete();
		$Updata['save_type'] 	= $action_type;
		$Updata['is_signed'] 	= 'Y';
		$Updata['signed_date'] 	= date('Y-m-d');
		CrmProposal::where('crm_proposal_id', $crm_proposal_id)->update($Updata);
		$id 			= CrmProposalSign::insertGetId($Indata);
		$details 	= CrmProposalSign::getDetailsById($id);

		$data['save_type'] 	= $action_type;
		$data['proposalID'] = CrmProposal::getProposalIdByCrmProposalId($crm_proposal_id);
		$data['user_id'] 		= CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);
		//echo "<pre>";print_r($data);die;
		CrmProposalHistory::insertProposalHistory($data);

		// save data into crm_leads table
		$contact_type = CrmProposal::getContactTypeById($crm_proposal_id);
		if($contact_type == 'p_ind' || $contact_type == 'p_org'){
			$this->saveIntoProspect($crm_proposal_id, $action_type);
		}else{
			Todolistnewtask::saveProposalServicesToWip($proposalId, $groupUserId);
		}

		/* ============ Email Send Section Start ================ */
		if($action_type == 'A' || $action_type == 'L'){
			if($action_type == 'A'){
				$data['subject'] 	= 'Congratulations your proposal has been Accepted!';
				$text 				= 'accepted';
			}else{
				$data['subject'] 	= 'Your Proposal has been Declined';
				$text 				= 'declined';
			}

			$data['practice'] 		= PracticeDetail::getPracticeDetailsPreview( $groupUserId );
			$secDrop 							= CrmProposal::getSecondDropById($crm_proposal_id);
			$data['senderEmail'] 	= Config::get('constant.ADMINEMAIL');
			$data['actionEmail'] 	= CrmProposal::getUserEmailByCrmProposalId($crm_proposal_id);
			//$data['actionEmail'] 	= 'anwarkhanmca786@gmail.com';
			//echo $data['actionEmail'];die;
			$data['newphrase'] 		= '<p>Hi,</p>
			    <p style="margin-bottom:10px;">Your proposal ID '.$data['proposalID'].' to '.$secDrop.' has been '.$text.'.</p>
			    <p style="margin-bottom:5px;">Kind regards</p>
			    <p>I-Practice Team</p>';
			Mail::send('crm.proposal.emails.proposal', $data, function ($message) use ($data) {
				$message->from($data['senderEmail'], $data['practice']['display_name']);
				$message->to($data['actionEmail']);
				$message->subject($data['subject']);
			});
		}

		/*if($action_type == 'A' || $action_type == 'MA'){
			Todolistnewtask::saveProposalServicesToWip($proposalId, $groupUserId);
		}*/
		
		/* ============ Email Send Section End ================ */
		return $details;
	}

	public function saveIntoProspect($crm_proposal_id, $action_type)
    {
        $data = array();
        $user_id = CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);

		if(isset($crm_proposal_id) && $crm_proposal_id >0){
            if($action_type =='A' || $action_type == 'MA' || $action_type == 'L' || $action_type == 'ML'){
                $details = CrmProposal::getProposalById($crm_proposal_id);

                $contact_type = explode('_', $details['contact_type']);
                if($contact_type[1] == 'org'){
                	$data['prospect_name']      = $details['prospect_name'];
                	$data['proposal_title']     = $details['proposal_title'];
                }else{
                	$pn = explode(' ', $details['prospect_name']);
                	$data['prospect_title']     = !empty($pn[0])?$pn[0]:'';
                	$data['prospect_fname']     = !empty($pn[1])?$pn[1]:'';
                	$data['prospect_lname']     = !empty($pn[2])?$pn[2]:'';
                }

                $data['leads_type']         = 'O';
                $data['user_id']            = $user_id;
                $data['crm_proposal_id']    = $crm_proposal_id;
                $data['client_type']    	= $contact_type[1];
                $data['close_date']         = date('Y-m-d', strtotime($details['end_date']));
                $data['contact_person']     = $details['contact_name'];
                
                $data['quoted_value']       = $details['gross_fees'];
                $data['created']            = date('Y-m-d H:i:s');

                $last_id = CrmLead::getLeadsIdByCrmProposalId($crm_proposal_id);
                if($last_id == 0){
                	$last_id = CrmLead::insertGetId($data);
                }
                
                $data1['leads_tab_id']  = ($details['save_type']=='A' || $details['save_type']=='MA')?8:9;
                $tab_id = CrmLeadsStatus::getTabIdByLeadsId($last_id);
                if($tab_id > 0){
                	CrmLeadsStatus::where('leads_id', $last_id)->update($data1);
                }else{
                	$data1['user_id']       = $user_id;
                	$data1['leads_id']      = $last_id;
                	$data1['created']       = date('Y-m-d H:i:s');
                	CrmLeadsStatus::insertGetId($data1);
                }
            }
        }
        return $data;
    }

	public function saveCommentInPreview($postData)
	{
		$data 		= array();

		$comment_text 		= $postData['comment_text'];
		$added_from 		= $postData['added_from'];
		$crm_proposal_id 	= $postData['crm_proposal_id'];

		$data['crm_proposal_id'] 	= $crm_proposal_id;
		$data['comment'] 			= $comment_text;
		$data['user_id'] 			= ($added_from == 'popup')?$this->user_id:0;
		$data['added_from'] 		= $added_from;
		$data['is_read'] 			= ($added_from == 'popup')?'Y':'N';
		$data['created'] 			= date('Y-m-d H:i:s');
		$data['modified'] 			= date('Y-m-d H:i:s');

		CrmProposalComment::insert($data);

		/* ============= Email Send Start =============== */
		$proposal_id 		= CrmProposal::getProposalIdByCrmProposalId( $crm_proposal_id );
		$user_id 			= CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);
		$group_id 			= User::getGroupIdByUserId($user_id);
		$groupUserId    	= Common::getUserIdByGroupId($group_id);
		$data['practice'] 	= PracticeDetail::getPracticeDetailsPreview( $groupUserId );
		$data['senderEmail']= Config::get('constant.ADMINEMAIL');
		$data['proposal'] 	= CrmProposal::getProposalById( $crm_proposal_id );

		
		$sentEmail = CrmProposalSentEmail::getEmailByCrmProposalId($crm_proposal_id);
		if($added_from == 'popup'){
			$actionEmail 	= $sentEmail;
		}else{
			$userEmail 		= User::getEmailByUserId($user_id);
			if(!empty($sentEmail))
				$actionEmail = $userEmail.','.$sentEmail;
			else
				$actionEmail = $userEmail;
		}
		$data['actionEmail']= explode(',', $actionEmail);
		if(isset($data['actionEmail']) && count($data['actionEmail']) >0){
			$data['newphrase'] 	= $comment_text;
			Mail::send('crm.proposal.emails.proposal', $data, function ($message) use ($data) {
				$message->from($data['senderEmail'], $data['practice']['display_name']);
				$message->to($data['actionEmail']);
				//$message->subject($data['practice']['display_name'].' has posted comment to a proposal '.$data['proposal']['proposalID']);
				$message->subject('New comment notification [Proposal ID '.$data['proposal']['proposalID'].']');
			});
		}
		/* ============= Email Send End =============== */

		$details = CrmProposalComment::getDetailsByCrmProposalId($crm_proposal_id);
		return $details;
	}



	public function testemailtemplate(){
		$data['newphrase'] = '<p>Dear Arthur Asiamah,</p>
		    <p>Thanks for the opportunity.</p>
		    <p style="margin-bottom:10px;">Please click <a href="http://eweb.ipractice.com/proposal-preview/eyJpdiI6IkR5bEZNdTJiZFZGeTJvUTk5aHZOWEE9PSIsInZhbHVlIjoiYWZhWWdmZWYwQmlCNWRyTjBpZkFodz09IiwibWFjIjoiODYxZjJmN2UxMzNkOWM4MmRiZjVhYjFmZDdlNjNhNDUwNTNlZjNiMjM3NTk5YjhlYzdkMDI4Njk1NjFlMDkxOSJ9/email/1488811814" target="_blank">here</a>  to view the proposal.</p>
		    <p style="margin-bottom:10px;">Please do not hesitate to call if you have any queries regarding the proposal.</p>
		    <p style="margin-bottom:10px;">Kind regards</p>
		    <p style="margin-bottom:5px;">ABEL ASIAMAH</p>
		    <p>Alexander Rosse Limited</p>';


		return View::make('crm.proposal.emails.proposal', $data);
	}


}	