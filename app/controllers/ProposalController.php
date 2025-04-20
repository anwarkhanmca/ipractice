<?php

class ProposalController extends BaseController {
	public $user_id;
	public $groupUserId;

	public function __construct()
	{
		parent::__construct();
		$session    = Session::get('admin_details');
    	$this->user_id    = $session['id'];
    	$this->groupUserId    = $session['group_users'];
    	//echo $this->user_id.'kk';die;
    	if(empty($this->user_id)){
    		return Redirect::to('/login')->send();
    	}
	}

	public function dashboard()
	{
    $today 		= date('Y-m-d');
    $admin_s 	= Session::get('admin_details'); // session
		$user_id 	= $admin_s['id'];

    $data['printed'] 		= ProposalInfo::where('status', 'PRINTED')->count();
    $data['downloaded'] = ProposalInfo::where('status', 'DOWNLOADED')->count();
    $data['emailed'] 		= ProposalInfo::where('status', 'EMAILED')->count();
    $data['invoiced'] 	= Invoice::count();
    $data['initiated'] 	= ProposalInfo::where('status', 'INITIATED')->count();
    $data['draft'] 			= ProposalInfo::where('status', 'DRAFT')->count();
    $data['total'] 			= ProposalInfo::count();

    $data['todaysTotal'] = Bill::where('receiving_date', $today)->sum('amount');
    $data['monthsTotal'] = Bill::where('receiving_date', '>=', date('Y-m-01', strtotime($today)))->sum('amount');
    $data['yearsTotal'] = Bill::where('receiving_date', '>=', date('Y-01-01', strtotime($today)))->sum('amount');
    $data['tillNowTotal'] 	= Bill::sum('amount');

    $data['partiallyPaid'] 	= Invoice::where('payment_status','Partially Paid')->count();
    $data['due'] 						= Invoice::where('payment_status','Due')->count();
    $data['paid'] 					= Invoice::where('payment_status','Paid')->count();
    
    $data['company_info'] 	= PracticeDetail::where('user_id', $user_id)->first();

		$owner_id 	= 'all';
		$page_open 	= "/crm";


		$data['page_open'] 			= 'dashboard';
		$data['goto_url'] 			= $page_open;
		$data['owner_id'] 			= $owner_id;

		$data['encode_page_open'] = $page_open;
    $data['encode_owner_id']  = $owner_id; 
    $data['proposals']        = "proposals";
    $data['tab_no'] 					= 'proposal';
    $data['heading']    			= "PROPOSALS";
    $data['title']      			= "PROPOSALS";
    $data['selected_page']    = "dashboard";

		return View::make('crm.index', $data);
	}

	public function product()
	{

		if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
		    'service_name' => 'Product Name',
		    'price' => 'Price',
		    'tax_rate' => 'Tax Rate',
			);

			$rules = array(
        'service_name' => 'required|max:100',
        'price' => 'required|numeric',
        'tax_rate' => 'required',
	    );

	    $validator = Validator::make(Input::all(), $rules);

	    $validator->setAttributeNames($changeAttributes); 

	    if ($validator->fails())
	    {
	    	return Redirect::back()->withErrors($validator)->withInput();
	    } else {
	    	$admin_s = Session::get('admin_details'); // session
			$user_id = $admin_s['id'];

				$productData['service_name'] = Input::get('service_name');
				$productData['price'] = Input::get('price');
				$productData['tax_rate'] = Input::get('tax_rate');
				$productData['user_id'] = $user_id;
				$productData['client_type'] = '';
				$productData['client_id'] = 0;
				$productData['ordering'] = 0;
				$productData['status'] = 'new';


				if(Input::has('service_id')){
					Service::where('service_id', Input::get('service_id'))->update($productData);
					Session::flash('info_msg', 'Information has been updated succesfully.');
				} else{
					Service::insert($productData);
					Session::flash('info_msg', 'Information has been added succesfully.');
				}
				return Redirect::to('/crm/product');
			}
		} 
		
		$data['products'] = Service::all();
		// $data['taxes'] = Tax::all();
		$data['form_title'] = 'Add Product';
		$data['content_header'] = 'Products';

		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'product';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         	= "proposals";
    $data['tab_no'] 			= 'proposal';
    $data['all_count'] 			= 0;
    $data['heading']    		= "PROPOSALS";
    $data['title']      		= "PROPOSALS";
    $data['selected_page']      = "product";

		return View::make('crm.index', $data);
	}

	public function edit_product($product_id)
	{
		$data['editProduct'] = Service::find($product_id);

		$data['products'] = Service::all();
		// $data['taxes'] = Tax::all();
		$data['form_title'] = 'Update Product';
		$data['content_header'] = 'View Products';
		
		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'product';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         = "proposals";
    $data['tab_no'] = 'proposal';
    $data['all_count'] = 0;
    $data['heading']    = "PROPOSALS";
    $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);

	}

	public function delete_product($product_id)
	{
		Service::where('service_id', $product_id)->delete();
		Session::flash('info_msg', 'Information has been deleted succesfully.');
		return Redirect::to('/crm/product');
	}	

	public function check_product($service_id)
	{
		$proposal_products = ProposalProduct::where('service_id', $service_id)->groupBy('proposal_id')->get(['proposal_id']);
		$data = '';
		foreach($proposal_products as $proposal_product){
			$data.=$proposal_product->proposal_id.", ";
		}

		if($data != ''){
			return "Sorry! This Prodcut is already in use. To delete this product you have to delete ". substr($data, 0, -2) ." Proposal first.";
		} else {
			return $data;
		}
	}

	public function check_proposal($proposal_id)
	{
		$invoice_id = Invoice::where('proposal_id', $proposal_id)->first();

		if($invoice_id){
			return "Sorry, this proposal has already invoice, you have to delete this invoice ".$invoice_id->id." before deleting.";
		} else {
			return '';
		}
	}

	public function check_invoice($invoice_id)
	{
		$bills = Bill::where('invoice_id', $invoice_id)->get(['id']);
		$data = '';
		foreach($bills as $bill){
			$data.=$bill->id.", ";
		}

		if($data != ''){
			return "Sorry, this invoice has already billed, you have to delete ". substr($data, 0, -2) ." bill before deleting invoice.";
		} else {
			return $data;
		}
	}
	
	public function getBillsByInvoice()
	{
		$bills = Bill::where('invoice_id', Input::get('invoice_id'))->get();
    $i = 0;
    foreach ($bills as $bill) {
      echo "<tr>";
      echo "<td>".++$i."</td>";
      echo "<td> $ ".$bill->amount."</td>";
      echo "<td>".date('d/m/Y', strtotime($bill->receiving_date))."</td>";
      echo "</tr>";
    }
	}

	public function tax()
	{
		if (Request::isMethod('post')) {

			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
		    'tax_name' => 'Tax Name',
		    'tax_rate' => 'Tax Rate',
			);

			$rules = array(
        'tax_name' => 'required|max:100',
        'tax_rate' => 'required|numeric',
	    );

	    $validator = Validator::make(Input::all(), $rules);
	    $validator->setAttributeNames($changeAttributes); 

	    if ($validator->fails())
	    {
	    	return Redirect::back()->withErrors($validator)->withInput();
	    } else {
				$taxData['tax_name'] = Input::get('tax_name');
				$taxData['tax_rate'] = Input::get('tax_rate');
				if(Input::has('tax_id')){
					Tax::where('id', Input::get('tax_id'))->update($taxData);
					Session::flash('info_msg', 'Tax has been updated Successfully.');
				} else{
					Tax::insert($taxData);
					Session::flash('info_msg', 'Tax has been added Successfully.');
				}
				return Redirect::to('/crm/tax');
			}	
		} 
		
		$data['taxes'] = Tax::all();
		$data['form_title'] = 'Add Tax';
		$data['content_header'] = 'Taxes';

		// information for crm index
		$owner_id 	= 'all';
		$page_open 	= "/crm";


		$data['page_open'] 	= 'tax';
		$data['goto_url'] 	= $page_open;
		$data['owner_id'] 	= $owner_id;

		$data['encode_page_open'] = $page_open;
    $data['encode_owner_id']  = $owner_id; 
    $data['proposals']        = "proposals";
    $data['tab_no'] 					= 'proposal';
    $data['all_count'] 				= 0;
    $data['heading']    			= "PROPOSALS";
    $data['title']      			= "PROPOSALS";

		return View::make('crm.index', $data);
	}

	public function edit_tax($taxId)
	{
		$data['editTax'] = Tax::find($taxId);
		$data['taxes'] = Tax::all();
		$data['form_title'] = 'Update Tax';
		$data['content_header'] = 'View Tax';
		
		// information for crm index
		$owner_id 	= 'all';
		$page_open 	= "/crm";


		$data['page_open'] 	= 'tax';
		$data['goto_url'] 	= $page_open;
		$data['owner_id'] 	= $owner_id;

		$data['encode_page_open'] = $page_open;
    $data['encode_owner_id']  = $owner_id; 
    $data['proposals']        = "proposals";
    $data['tab_no'] 					= 'proposal';
    $data['all_count'] 				= 0;
    $data['heading']    			= "PROPOSALS";
    $data['title']      			= "PROPOSALS";

		return View::make('crm.index', $data);
	}

	public function delete_tax($taxId)
	{
		Tax::where('id', $taxId)->delete();
		Session::flash('info_msg', 'Tax has been deleted Successfully.');
		return Redirect::to('/crm/tax');
	}

	public function check_tax($taxId)
	{
		$products = Product::where('tax_id', $taxId)->get(['id']);
		$data = '';
		foreach($products as $product){
			$data.=$product->id.", ";
		}

		if($data != ''){
			return "This tax is already in use. To delete this tax you have to delete ". substr($data, 0, -2) ." Product first";
		} else {
			return $data;
		}
	}

	public function attachment($is_archive='hide')
	{
		if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'title' => 'Title',
			    'file' => 'PDF',
			);

			$rules = array(
				        'title' => 'required|max:100',
				        'file' => 'required|mimes:pdf',
				    );

		    $validator = Validator::make(Input::all(), $rules);

		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
				if(Input::hasFile('file')){
					$file = Input::file('file');//echo $file->getMimeType();die;
					if($file->getMimeType() == 'application/pdf'){
						$fileName = $file->getClientOriginalName();
						$upload_success = $file->move(base_path('public/uploads/pdf forms/'), $fileName);

						$attachData['title'] 	= Input::get('title');
						$attachData['file'] 	= $fileName;
						$attachData['user_id'] 	= $this->user_id;
						Attachment::insert($attachData);
						Session::flash('info_msg', 'Attachment has been added successfully.');
						return Redirect::to('/crm/attachment');	
					} else {
						Session::flash('info_msg', 'Please upload only pdf file.');
						return Redirect::to('/crm/attachment');	
					}
				} else {
					Session::flash('info_msg', 'Pdf File field should not be empty.');
					return Redirect::to('/crm/attachment');
				}
		    }	
		} 
		
		$attachments = Attachment::getAllDetails();
		$dtlsAttach = array();
		if(isset($attachments) && count($attachments) >0){
			foreach ($attachments as $k => $v) {
				if($is_archive == 'hide'){
					if($v['is_archive'] == 'N')
						$dtlsAttach[$k] = $v;
				}else{
					$dtlsAttach[$k] = $v;
				}
			}
		}
		$data['attachments'] 	= $dtlsAttach;
		//$data['terms'] 			= TermsConditionFile::getTermsAndConditions();
		$data['form_title'] 	= 'Add Attachment';
		$data['content_header'] = 'Attachments';

		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] 	= 'attachment';
		$data['goto_url'] 	= $page_open;
		$data['owner_id'] 	= $owner_id;
		$data['is_archive'] = $is_archive;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         	= "proposals";
        $data['tab_no'] 			= 'proposal';
        $data['all_count'] 			= 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";
        $data['selected_page']      = "attachment";

		return View::make('crm.index', $data);
	}

	public function preview_attachment($attachment_id)
	{
		$attachment = Attachment::find($attachment_id);
        $file= base_path("/public/uploads/pdf forms/". $attachment->file);

        if(File::exists($file)) {
	        return Response::make(file_get_contents($file), 200, [
								    'Content-Type' => 'application/pdf',
								    'Content-Disposition' => 'inline; '.$attachment->file,
								]);

        } else {
    		Session::flash('info_msg', 'File is not exists.');
			return Redirect::to('/crm/attachment');
    	}

	}

	public function delete_attachment()
	{
		$attachment_id = Input::get('id');
		$count = CrmProposalAttachment::checkDataByAttachmentId($attachment_id);
		//echo $count;
		//Common::last_query();die;
		if($count <= 0){
			$attachment = Attachment::where('id', $attachment_id)->first();
			$file = base_path('/public/uploads/pdf forms/'. $attachment->file);
			if(File::exists($file)) {
				File::delete($file);
				$attachment->delete();
				Session::flash('info_msg', 'File has been deleted successfully.');
				//return Redirect::to('/crm/attachment');
			} else {
				$attachment->delete();
				Session::flash('info_msg', 'File is not exists.');
				//return Redirect::to('/crm/attachment');
			}
		}
		return $count;
	}	

	public function getDownload($attachment_id){
		$attachment = Attachment::find($attachment_id);
        $file= base_path("/public/uploads/pdf forms/". $attachment->file);

        if(File::exists($file)) {
        	return Response::download($file);
    	} else {
    		Session::flash('info_msg', 'File is not exists.');
			return Redirect::to('/crm/attachment');
    	}
	}

	public function check_attachment($attachmentId)
	{
		$attachments = AttachedPDF::where('attachment_id', $attachmentId)->groupBy('proposal_id')->get(['proposal_id']);
		$data = '';
		foreach($attachments as $attachment){
			$data.=$attachment->proposal_id.", ";
		}

		if($data != ''){
			return "Sorry! This Attachment is already in use. To delete this attachment file you have to delete ". substr($data, 0, -2) ." Proposal first.";
		} else {
			return $data;
		}
	}

	public function viewAllProposal()
	{ 
		if(empty($this->user_id)){
  		return Redirect::to('/login')->send();
  	}

		$data['selected_page'] 	= 'view all proposals';
		$data['proposal_page'] 	= 'final';
		$data['page_open'] 			= 'proposal';
		$data['goto_url'] 			= "/crm";
		$data['proposals']      = "proposals";
    $data['tab_no'] 				= 'proposal';
    $data['owner_id'] 			= 'all';
    $data['heading']    		= "PROPOSALS";
    $data['title']      		= "PROPOSALS";
    $data['tab_level']      = "42";

    //$data['ProposalsData'] = CrmProposal::getDetailsBySaveType('F');
    //$data['ProposalsData'] = CrmProposal::getAllDetails();
    //echo '<pre>';print_r($data['ProposalsData']);
		return View::make('crm.index', $data);
	}

	public function viewDraft()
	{
		$data['selected_page'] 	= 'view all proposals';
		$data['proposal_page'] 	= 'draft';

		$data['page_open'] 		= 'proposal';
		$data['goto_url'] 		= "/crm";
		$data['owner_id'] 		= 'all';

    $data['proposals']      = "proposals";
    $data['tab_no'] 		= 'proposal';
    $data['heading']    	= "PROPOSALS";
    $data['title']      	= "PROPOSALS";
    $data['tab_level']      = "422";

    $data['ProposalsData'] = CrmProposal::getDetailsBySaveType('D');
		//echo '<pre>';print_r($data['ProposalsData']);die;
		return View::make('crm.index', $data);
	}

	public function letter_template()
	{
		$data['proposal'] = ProposalInfo::all();

		$data['selected_page'] 		= 'view all proposals';
		$data['form_title'] 			= 'Add Product';
		$data['content_header'] 	= 'Proposals';
		$data['proposal_page'] 		= 'letter';

		// information for crm index
		$owner_id 	= 'all';
		$page_open 	= "/crm";


		$data['page_open'] 	= 'letter';
		$data['goto_url'] 	= $page_open;
		$data['owner_id'] 	= $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         	= "proposals";
    $data['tab_no'] 						= 'proposal';
    $data['all_count'] 					= 0;
    $data['heading']    				= "PROPOSALS";
    $data['title']      				= "PROPOSALS";
    $data['tab_level']      		= '4341';

    $data['templates']   = CrmProposalTemplate::getDetailsByTemplateType('L');

		return View::make('crm.index', $data);
	}

	public function pricing_template()
	{
		$data['proposal'] = ProposalInfo::all();

		$data['selected_page'] 		= 'view all proposals';
		$data['form_title'] 		= 'Add Product';
		$data['content_header'] 	= 'Proposals';
		$data['proposal_page'] 		= 'pricing';

		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'pricing';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         	= "proposals";
    $data['tab_no'] 			= 'proposal';
    $data['all_count'] 			= 0;
    $data['heading']    		= "PROPOSALS";
    $data['title']      		= "PROPOSALS";
    $data['tab_level']      	= '4342';

		return View::make('crm.index', $data);
	}

	public function proposal_template()
	{
		$data['selected_page'] 		= 'view all proposals';
		$data['form_title'] 		= 'Add Product';
		$data['content_header'] 	= 'Proposals';
		$data['proposal_page'] 		= 'p_template';

		$owner_id 	= 'all';
		$page_open 	= "/crm";


		$data['page_open'] 	= 'p_template';
		$data['goto_url'] 	= $page_open;
		$data['owner_id'] 	= $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         	= "proposals";
    $data['tab_no'] 			= 'proposal';
    $data['all_count'] 			= 0;
    $data['heading']    		= "PROPOSALS";
    $data['title']      		= "PROPOSALS";
    $data['tab_level']      	= '4342';

    $data['details'] 	= $this->getProposalTemplate();

		return View::make('crm.index', $data);
	}

	public function getProposalTemplate()
	{
		$data = array();
		$data['templates'] 	= CrmProposal::getDetailsBySaveType('T');

		//echo "<pre>";print_r($data['templates']);die;
		return $data;
	}

	public function new_proposal($prospect_id=0, $from_page='prospect')
	{ 
		$crmLeads 			= array();
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    $proposalId 		= CrmProposalId::getNewProposalId();
		$heading    		= "New Proposal";

		$data['previous_page']  = '<a href="/crm/MTE=/YWxs/crm">Crm</a>';
    $data['title']      		= "New Proposal";
		$data['page_open'] 			= 1;
		$data['tab_no'] 				= 1;
		$data['saved_from'] 		= 'new_proposal';
		$data['prospect_id'] 		= $prospect_id;
		$data['from_page'] 			= $from_page;
		
		$data['titles'] 				= Title::orderBy("title_id")->get();
    $data['countries'] 			= Country::orderBy('country_name')->get();
    $data['old_org_types'] 	= OrganisationType::where("client_type", "all")->orderBy("name")->get();
    $data['new_org_types'] 		= OrganisationType::getNewOrganizationType();
    $data['industry_lists'] 	= IndustryList::getIndustryList();
    $data['staff_details'] 		= User::getAllStaffDetails();
    $data['old_lead_sources'] = LeadSource::getOldLeadSource();
    $data['new_lead_sources'] = LeadSource::getNewLeadSource();
    $data['allOrgClients'] 		= Client::getAllClientsByType('org', '');
    $data['cont_address'] 		= ClientAddress::getAllAddressAndId();
    $data['relationTypes'] 		= RelationshipType::getAllDetailsByStatus("individual");


    if($prospect_id != 0 && $from_page == 'prospect'){
    	$crmLeads = $this->getExistingProspectById( $prospect_id );

    	$leadstatus['leads_tab_id'] = 5;
    	CrmLeadsStatus::whereIn("user_id",$groupUserId)->where('leads_id',$prospect_id)->update($leadstatus);
    }
    if($prospect_id!=0 && ($from_page=='proposal' || $from_page=='template' || $from_page=='prop_client_org')){
    	$crmLeads 	= $this->getExistingProposalById( $prospect_id );
    	$proposalId = $crmLeads['proposalID'];
    	$heading 	= ($from_page=='template')?"Edit ".ucfirst($from_page):'Edit Proposal';
    }
    /*if($prospect_id != 0 && $from_page == 'copy'){
    	$crm_proposal_id 	= $prospect_id;
    	$heading 			= "Edit Proposal";

    	$proposalId 	= $this->copyProposal($crm_proposal_id);
    }*/

    /*if($prospect_id == 0){
    	$data['prospect_id'] = $this->saveProposalAsDraft($proposalId);
    }*/

    $data['crmLeads'] 			= $crmLeads;
    $data['heading'] 				= $heading;
    $data['attachments'] 		= Attachment::getAllDetails();
    //$data['TaxRates'] 		= TaxRate::getAllDetails('C');
		$data['ServicesProp'] 	= ProposalService::getAllDetails();
		$data['ServicesTask'] 	= App::make('ServiceController')->getDefaultServiceDetails();
		$data['proposalId'] 		= $proposalId;
		//$data['tableHeadings'] 		= $this->getTableHeadingsData($proposalId);
		$data['content'] 				= CrmProposalTable::getDetailsByProposalId( $proposalId );
		//$data['grand_total'] 		= CrmProposalGrandTotal::getGrandTotal( $proposalId, 'G' );
		$data['encryptProposalId'] 	= Crypt::encrypt($proposalId);
		$data['attach_ids'] 		= CrmProposalAttachment::getAttachmentIdByProposalId( $proposalId );
		$data['templates']   		= CrmProposalTemplate::getDetailsByTemplateType('L');
		$data['letters']   			= CrmProposalCoverletter::getAllCoverLetters();
		$data['coverLetters']   = CrmProposalCoverletter::getDetailsByProposalId( $proposalId );
		$data['terms']   				= $this->getTermsByProposalId( $proposalId );

		//echo "<pre>";print_r($data['terms']);die;
		return View::make('crm.new_proposal', $data);
	}

	public function getTermsByProposalId( $proposalId ){
		$session            = Session::get('admin_details');
        $groupUserId        = $session['group_users'];

		$details   = CrmProposalTerm::getDetailsByProposalId( $proposalId, $groupUserId );
		if(empty($details)){
			$details   = TermsConditionFile::getTermsAndConditionsPreview($groupUserId);
			$details['terms'] = isset($details['description'])?$details['description']:'';
		}
		//Common::last_query();
		return $details;
	}

	public function saveProposalAsDraft( $postData )
	{
		$data['user_id'] 		= $this->user_id;
		$data['proposalID'] 	= $postData['proposal_id'];
		$data['contact_type'] 	= $postData['contact_type'];
		$data['prospect_id'] 	= $postData['prospect_id'];
		$data['client_id'] 		= $postData['prospect_id'];
		$data['contact_id'] 	= $postData['contact_id'];
		$data['contact_name'] 	= $postData['contact_name'];
		$data['template_name'] 	= $postData['TemplateName'];
		$data['validity'] 		= $postData['validity'];
		$data['proposal_title'] = $postData['proposal_title'];
		$data['start_date'] 	= date('Y-m-d', strtotime( $postData['start_date'] ));
		$data['end_date'] 		= date('Y-m-d', strtotime( $postData['end_date'] ));
		$data['save_type'] 		= ($postData['contact_type'] == 'template')?'T':'D';
		$data['created']		= date('Y-m-d H:i:s');

		$last_id = CrmProposal::checkProposalByProposalId( $postData['proposal_id']);
		if($last_id == 0){
			$data['is_signed'] 		= 'N';
			$data['is_rejected'] 	= time();

			$last_id = CrmProposal::insertGetId($data);
			CrmProposalId::insertProposalId($data['proposalID']);
		}
		return $last_id;
	}

	public function getServicesData( $p_table_id, $proposal_id )
	{
		$data = array();
		//$services 	= Service::getAllServiceByType('org');
		$services 	= Service::getAllServices();
		if(isset($services) && count($services) >0){
			foreach ($services as $k => $v) {
				$data[$k] = $v;
				$data[$k]['table_show'] 		= CrmProposalService::checkTable($p_table_id, $v['service_id']);
				$data[$k]['added_before'] 	= CrmProposalService::checkAlreadyAdded($v['service_id'], $proposal_id);

				$service_name = ProposalService::getNameByServiceId( $v['service_id'] );
				if(empty($service_name)){
					$service_name = Service::getNameServiceId( $v['service_id'] );
				}
				$data[$k]['service_name'] 	= $service_name;
				$data[$k]['base_fee'] 			= ProposalService::getPriceByServiceId($v['service_id']);
			}
		}
		return $data;
	}

	public function getTableHeadingsData($proposalId){
		$data = array();
		$tableHeadings 	= CrmTableHeading::getAllHeadings();
		if(isset($tableHeadings) && count($tableHeadings) >0){
			foreach ($tableHeadings as $k => $v) {
				$data[$k] = $v;
				$data[$k]['table_show'] 	= CrmProposalTable::checkTable($proposalId, $v['heading_id']);
				$data[$k]['separate_table'] = CrmProposalTable::checkSeparateTable($proposalId,$v['heading_id']);
				$data[$k]['group_table'] 	= CrmProposalTable::checkGroupTable($proposalId, $v['heading_id']);
				$data[$k]['grand_show'] 	= CrmProposalGrandTotal::checkTable($proposalId, $v['heading_id']);
				$data[$k]['recurring'] 		= CrmProposalTable::getRecurringValue($proposalId,$v['heading_id']);
			}
		}
		return $data;
	}

	public function getExistingProposalById( $prospect_id ){
		$v = CrmProposal::getProposalById( $prospect_id );
		$contact_type 	= $cpname = $cpId = $contactName = $contactId = '';
		$secDrop 		= array();
		if(isset($v) && count($v) >0){
			$v['firstDrop'] 	= $v['contact_type'];
	    	$v['cpId'] 			= $v['prospect_id'];
	    	$v['cpName'] 		= $v['prospect_name'];
	    	$v['contactId'] 	= $v['contact_id'];
	    	$v['contactName'] 	= !empty($v['contact_id'])?$v['contact_name']:'';
		}
		
		return $v;
	}

	public function getExistingProspectById( $prospect_id )
	{
		$v = CrmLead::getLeadsByLeadsId( $prospect_id );
		$contact_type 	= $cpname = $cpId = $contactName = $contactId = '';
		$secDrop 		= array();
  	if(isset($v) && count($v) >0){
			if(isset($v['existing_client']) && $v['existing_client'] != '0'){
				$contact_type = ($v['client_type'] == 'ind')?'c_ind':'c_org';
				$cpname = Client::getClientNameByClientId( $v['existing_client'] );
				$cpId 	= $v['existing_client'];
				$contactName 	= CrmLead::getContactNameByLeadsId($v['leads_id']);
				$contactId 		= $v['leads_id'];
			}else{
				$contact_type = ($v['client_type'] == 'ind')?'p_ind':'p_org';
				$cpname = CrmLead::getProspectNameByLeadsId($v['leads_id']);
				$cpId 	= $v['leads_id'];
				$contactName 	= CrmLead::getContactNameByLeadsId($v['leads_id']);
				$contactId 		= $v['leads_id'];
			}
  	}
  	$v['firstDrop'] 	= $contact_type;
  	$v['cpId'] 			= $cpId;
  	$v['cpName'] 		= $cpname;
  	$v['contactId'] 	= $contactId;
  	$v['contactName'] 	= $contactName;

  	return $v;
	}

	public function cover_letter(){
		$data['proposal'] = ProposalInfo::all();

		$data['selected_page'] 		= 'new_proposal';
		$data['form_title'] 		= 'Add Product';
		$data['content_header'] 	= 'Proposals';
		$data['proposal_page'] 		= 'new_proposal';

		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         	= "proposals";
    $data['tab_no'] 			= 'proposal';
    $data['all_count'] 			= 0;
    $data['heading']    		= "PROPOSALS";
    $data['title']      		= "PROPOSALS";

    $data['tab_level']      	= "4212";


		return View::make('crm.index', $data);
	}

	public function create_attachment(){
		$data['proposal'] = ProposalInfo::all();

		$data['selected_page'] 		= 'new_proposal';
		$data['form_title'] 		= 'Add Product';
		$data['content_header'] 	= 'Proposals';
		$data['proposal_page'] 		= 'new_proposal';

		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         	= "proposals";
    $data['tab_no'] 			= 'proposal';
    $data['all_count'] 			= 0;
    $data['heading']    		= "PROPOSALS";
    $data['title']      		= "PROPOSALS";

    $data['tab_level']      	= "4213";


		return View::make('crm.index', $data);
	}


	public function createProposal($proposal_id = null) 
	{
		if($proposal_id){
			$data['proposal'] 			= ProposalInfo::find($proposal_id);
			$data['services_used'] 	= ProposalProduct::where('proposal_id', $proposal_id)->get();
    }
		$ind_client = Client::where('type', 'ind')->get(['client_id'])->toArray();
		$ind_client_info = StepsFieldsClient::whereIn('client_id', $ind_client)->where('field_name', 'client_name')->get(['field_value', 'client_id'])->toArray();

		$org_client = Client::where('type', 'org')->get(['client_id'])->toArray();
		$org_client_info = StepsFieldsClient::whereIn('client_id', $org_client)->where('field_name', 'business_name')->get(['field_value', 'client_id'])->toArray();


    $data['customers'] = array_merge($ind_client_info, $org_client_info);
    // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
    $data['products'] = Product::all();
    // $data['taxlist'] = Tax::all();

    // information for crm index
		$owner_id = 'all';
		$page_open = "/crm";

		if(Request::segment(2) == 'copyProposal'){
			$data['page_title'] = 'Copy Proposal';
		}else if($proposal_id){
			$data['page_title'] = 'Edit Proposal';
		} else{
			$data['page_title'] = 'Create Proposal';	
		}

		$data['selected_page'] = 'select proposal';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
    $data['encode_owner_id']    = $owner_id; 
    $data['proposals']         = "proposals";
    $data['tab_no'] = 'proposal';
    $data['all_count'] = 0;
    $data['heading']    = "PROPOSALS";
    $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);


        // }
    }        

    public  function getServicesProducts()
    {
    	if(Request::ajax() && Request::isMethod('get')){
	    	$products = Service::where('service_name', 'like', '%'.Input::get('search_key').'%')->get();
	    	$result = '';
	    	foreach($products as $product) {
	    		$taxDefine = $product->tax_rate;
	    		if($taxDefine == ''){
	    			$taxDefine = 'None(0.00%),0';
	    		}
	    		$result.= "<li class='service_item' data-price='".$product->price."' data-ids='".$product->service_id."' data-tax='".$taxDefine."' data-tax_id='".$taxDefine."' onclick='addField(this);'>".$product->service_name."</li>";
	    		// $product_tax = Tax::find($product->tax_id);

	           	// $result.= "<li class='service_item' data-price='".$product->price."' data-ids='".$product->id."' data-tax='".$product_tax->tax_rate."' data-tax_id='".$product->tax_id."' onclick='addField(this);'>".$product->product_name."</li>";
	        }   
  			return Response::json($result);
    	} else {
    		return Response::json(false);
    	}
    }	

    public  function getTaxes(){
    	if(Request::ajax() && Request::isMethod('get')){
    		$taxes = Tax::all();
    		return Response::json($taxes);
    	}
    }

    public function saveProposal()
    {
    	if(Request::isMethod('post')){
    		if(Request::has('proposal_id') && !Request::has('action_identity')){
    			$proposal_info = ProposalInfo::find(Input::get('proposal_id'));
    			ProposalProduct::where('proposal_id', Input::get('proposal_id'))->delete();
    		} else {
    			$proposal_info = new ProposalInfo();
    		}
	    	
	    	$proposal_info->proposal_title = Input::get('proposal_title');
	    	$proposal_info->customer_id = Input::get('customer');

	    	$admin_s = Session::get('admin_details'); // session
				$user_id = $admin_s['id'];

	    	$proposal_info->prepared_by = $user_id;
	    	$proposal_info->sub_total = Input::get('subtotal');
	    	$proposal_info->sales_tax = Input::get('sales_tax');
	    	$proposal_info->total = Input::get('total');
	    	$proposal_info->save();

	    	foreach(Input::get('service') as $key=>$service){
	    		$proposal_product = new ProposalProduct();
	    		$proposal_product->service_id = $service;
	    		$proposal_product->proposal_id = $proposal_info->id;
	    		$proposal_product->description = Input::get('description')[$key];
	    		$proposal_product->quantity = Input::get('quantity')[$key];
	    		$proposal_product->unit_price = Input::get('unit_price')[$key];
	    		$proposal_product->tax_rate = Input::get('tax_rate')[$key];
	    		$proposal_product->discount = Input::get('discount')[$key];
	    		$proposal_product->tax_amount = Input::get('tax')[$key];
	    		$proposal_product->total_amount = Input::get('amount')[$key];
	    		$proposal_product->save();
	    	}

	    	if(Request::has('action_identity')){
	    		return Redirect::to('/crm/copyAttachFile/'.$proposal_info->id.'/'.Input::get('proposal_id'));
	    	}else if(Request::has('proposal_id')){
    			return Redirect::to('/crm/editAttachFile/'.$proposal_info->id);
    		} else {
    			return Redirect::to('/crm/attachFile/'.$proposal_info->id);
    		}
			} else {
    		return Redirect::to('crm/dashboard');
    	}
    }		

    public function attachFile($proposal_id, $copy_proposal_id = null){
    	if(Request::segment(2) == 'editAttachFile' || Request::segment(2) == 'copyAttachFile'){
    		if(Request::segment(2) == 'copyAttachFile'){
    			$attached_files = AttachedPDF::where('proposal_id', $copy_proposal_id)->get(['attachment_id']);
    			$data['copy_proposal_id'] = $copy_proposal_id;
    		} else {
    			$attached_files = AttachedPDF::where('proposal_id', $proposal_id)->get(['attachment_id']);
    		}

    		$attach_files = [];
    		foreach($attached_files as $file){
    			$attach_files[] = $file->attachment_id;
    		}
    		$data['attached_files'] = $attach_files;
    	}

        $data['proposal_id']=$proposal_id;
        $data['attachments']= Attachment::all();
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
        
        if(Request::segment(2) == 'copyAttachFile'){
        	$data['page_title'] = 'Copy Proposal';
        }else if(Request::segment(2) == 'editAttachFile'){
			$data['page_title'] = 'Edit Proposal';
		} else{
			$data['page_title'] = 'Create Proposal';	
		}

        // information for crm index
		$owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'select attachments';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function saveProposalAttachment(){
    	if(Request::isMethod('post')){
    		if(Input::get('page_title') == 'Edit Proposal'){
	           	AttachedPDF::where('proposal_id', Input::get('proposal_id'))->delete();
	        }
	        if(Request::has('files')){
	            foreach (Input::get('files') as $file) {
	            	$attached_pdf = new AttachedPDF();
	                $attached_pdf->attachment_id = $file;
	                $attached_pdf->proposal_id = Input::get('proposal_id');
	                $attached_pdf->save();
	            }
	        }

	        if(Request::has('copy_proposal_id')){
	        	return Redirect::to('crm/copyAdditionalNote/'.Input::get('proposal_id').'/'.Input::get('copy_proposal_id'));
	        }

	        if(Input::get('page_title') == 'Edit Proposal'){
	        	return Redirect::to('crm/editAdditionalNote/'.Input::get('proposal_id'));
	        }

	        return Redirect::to('crm/additionalNote/'.Input::get('proposal_id'));
    	} else {
    		return Redirect::to('crm/dashboard');
    	}
    }

    public function  additionalNote($proposal_id, $copy_proposal_id = null){
    	if(Request::segment(2) == 'editAdditionalNote'){
    		$data['note'] = AdditionalNote::where('proposal_id', $proposal_id)->first();
    	} else if(Request::segment(2) == 'copyAdditionalNote'){
    		$data['note'] = AdditionalNote::where('proposal_id', $copy_proposal_id)->first();
    		$data['copy_proposal_id']=$copy_proposal_id;
    	}

        $data['proposal_id'] = $proposal_id;
        //$data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();

        if(Request::segment(2) == 'copyAdditionalNote'){
        	$data['page_title'] = 'Copy Proposal';
        }else if(Request::segment(2) == 'editAdditionalNote'){
			$data['page_title'] = 'Edit Proposal';
		} else{
			$data['page_title'] = 'Create Proposal';	
		}

        // information for crm index
        $owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'additional note';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function  saveAdditionalNote(){
    	if (Request::isMethod('post')) {

			Input::merge(array_map('trim', Input::all()));

			$str = str_replace(array(' '), array(''), strip_tags(Input::get('note')));
			if($str=="<p><br></p>"||$str=="<br>"||$str==""){
				Session::flash('add_note_error', 'This Field  should not be empty');
				return Redirect::back();
			// }		

			// $changeAttributes = array(
			//     'note' => 'Note',
			// );

			// $rules = array(
			// 	        'note' => 'required',
			// 	    );

		 //    $validator = Validator::make(Input::all(), $rules);

		 //    $validator->setAttributeNames($changeAttributes); 

		 //    if ($validator->fails())
		 //    {
		 //    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
		    	if(Input::get('page_title') == 'Edit Proposal'){
	            	$additional_note = AdditionalNote::where('proposal_id', Input::get('proposal_id'))->first();
	            } 

	            if(!isset($additional_note)){
	            	$additional_note = new AdditionalNote();
	            }

		    	$additional_note->note = Input::get('note');
            	$additional_note->proposal_id = Input::get('proposal_id');
            	$additional_note->save();

            	if(Input::get('page_title') == 'Edit Proposal'){
            		return Redirect::to('crm/editSelectTemplate/'.Input::get('proposal_id'));
	        	}

            	return Redirect::to('crm/selectTemplate/'.Input::get('proposal_id'));
		    }	


		}
    }

    public function selectTemplate($proposal_id){
        $data['proposal_id'] = $proposal_id;
        $data['proposal_info'] = ProposalInfo::find($proposal_id);
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
        // $data['main_content'] = $this->load->view('select_template', $data, true);
        // $this->load->view('home', $data);

        if(Request::segment(2) == 'editSelectTemplate'){
			$data['page_title'] = 'Edit Proposal';
		} else{
			$data['page_title'] = 'Create Proposal';	
		}

        // information for crm index
        $owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'select template';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function proposalPreview(){
        $proposal_id=Input::get('proposal_id');
        if(Input::get('template')!=""){
            $template=Input::get('template');
        }else{
            $template=1;
        }
        switch($template){
            case 1:
                $templateUrl="preview_proposal";
                break;
            case 2:
                $templateUrl="preview_proposal_standard";
                break;
            case 3:
                $templateUrl="preview_proposal_corporate";
                break;
            default:
                $templateUrl="preview_proposal";
        }
        
        $admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id'];

        $company_info = PracticeDetail::where('user_id', $user_id)->first();
        $data['company_info'] = $company_info; 
        $data['company_address'] = PracticeAddress::where("practice_id", $company_info->practice_id)->first();

        $proposal_info = ProposalInfo::find($proposal_id);

  

        $data['customer_info'] = StepsFieldsClient::where('client_id', $proposal_info->customer_id)->lists('field_value', 'field_name');

        $data['proposal_info'] = $proposal_info;
        $data['note'] = AdditionalNote::where('proposal_id', $proposal_id)->first();
        $data['attachments'] = AttachedPDF::where('proposal_id', $proposal_id)->get();
        $data['service_products'] = ProposalProduct::where('proposal_id', $proposal_id)->get();

        $filename ="Proposal_Attachments".$proposal_id;
        $pdfFilePath = base_path('/public/proposalPdf/'. $filename .'.pdf');
        
        ini_set("pcre.backtrack_limit","1000000000");
        ini_set('memory_limit', '256M');
        $html = (string) View::make('crm.proposal.templates.'.$templateUrl, $data)->render();
        
        include(app_path() . '/third_party/mpdf/mpdf.php');
        $pdf = new mPDF($param);
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, 'F');

        if(count($data['attachments'])>0){
        	$pdf_merger = new \Clegginabox\PDFMerger\PDFMerger;

        	$pdf_merger->addPDF($pdfFilePath, 'all');

			foreach($data['attachments'] as $attachment) {
            	$pdf_merger->addPDF(base_path("/public/uploads/pdf forms/".Attachment::find($attachment->attachment_id)->file), 'all');
            }
            $merged_file_name = "Proposal_attachments_merged".$proposal_id.'.pdf'; //make it unique
            $pdf_merger->merge('file', base_path('/public/proposalPdf/'.$merged_file_name), 'P');

        } else {
            rename($pdfFilePath, base_path("/public/proposalPdf/Proposal_attachments_merged".$proposal_id.".pdf"));
        }

        if(file_exists($pdfFilePath)){
            unlink($pdfFilePath);
        }
        ProposalInfo::where('id',$proposal_id)->update(array('proposal_template'=>$template));



        return Redirect::to('crm/loadProposalPreview/'.$proposal_id);

    }

    public  function loadProposalPreview($proposal_id){

        $data = array();
        $data['proposal_id']=$proposal_id;
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
        // $data['main_content'] = $this->load->view('preview_proposal', $data, true);
        // $this->load->view('home', $data);


        // information for crm index
        $owner_id = 'all';
		$page_open = "/crm";
		$data['page_title'] = 'Preview Proposal';

		$data['selected_page'] = 'preview proposal';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";



		return View::make('crm.index', $data)->render();
    }

    public function editProposal($proposal_id) {
        // if ($this->session->userdata('user_id')) {
            // $data = array();
            $data['proposal'] = ProposalInfo::find($proposal_id);
            $data['services_used'] = ProposalProduct::where('proposal_id', $proposal_id)->get();

            $ind_client = Client::where('type', 'ind')->get(['client_id'])->toArray();
        	$ind_client_info = StepsFieldsClient::whereIn('client_id', $ind_client)->where('field_name', 'client_name')->get(['field_value', 'client_id'])->toArray();

        	$org_client = Client::where('type', 'org')->get(['client_id'])->toArray();
        	$org_client_info = StepsFieldsClient::whereIn('client_id', $org_client)->where('field_name', 'business_name')->get(['field_value', 'client_id'])->toArray();


            $data['customers'] = array_merge($ind_client_info, $org_client_info);

            // $data['customers'] = StepsFieldsClient::where('field_name', 'client_name')->groupBy('client_id')->lists('field_value', 'client_id');
            // $data['customers']=['1' => 'Saidul', '2' => 'Milan'];
            // $data['customers']=$this->db->order_by('customer_name','asc')->get('customer_info')->result();
            //$data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
            // $data['products'] = Product::all();
            // $data['taxlist'] = Tax::all();
            //$data['main_content'] = $this->load->view('edit_proposal', $data, true);
            //$this->load->view('home', $data);
            //dd($data);
        // } else {
        //     redirect("admin/index");
        // }

        $data['products'] = Product::all();
        $data['taxlist'] = Tax::all();

            // information for crm index
		$owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'select proposal';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);

    }

    public function downloadProposal($proposal_attach_merger, $proposal_id) {
        ProposalInfo::where('id',$proposal_id)->update(array('status'=>'DOWNLOADED','created_at'=>date('Y-m-d H:i:s')));
        $file= base_path("/public/proposalPdf/". $proposal_attach_merger);

        if(File::exists($file)) {
        	return Response::download($file);
    	} else {
    		Session::flash('info_msg', 'File is not exists.');
			return Redirect::to('/crm/loadProposalPreview/'.$proposal_id);
    	}
    }

    /*public function saveProposalAsDraft($proposal_id){
    	ProposalInfo::where('id',$proposal_id)->update(array('status'=>'DRAFT','created_at'=>date('Y-m-d H:i:s')));

        Session::flash('info_msg', 'Proposal has been saved as draft');
        return Redirect::to('/crm/viewAllProposal');
    }*/

    public function deleteProposal($proposal_id){
        ProposalInfo::destroy($proposal_id);
        ProposalProduct::where('proposal_id', $proposal_id)->delete();
        AttachedPDF::where('proposal_id', $proposal_id)->delete();

        Session::flash('info_msg', 'Proposal has been deleted successfully.');
		return Redirect::to('/crm/viewAllProposal');
    }

    public function ajaxSaveServiceOrProduct(){
     	if(Request::ajax() && Request::isMethod('post')){
     		$admin_s = Session::get('admin_details'); // session
			$user_id = $admin_s['id'];

     		$productData['service_name'] = Input::get('name');
			$productData['price'] = Input::get('price');
			$productData['tax_rate'] = Input::get('tax_rate');
			$productData['user_id'] = $user_id;
			$productData['client_type'] = '';
			$productData['client_id'] = 0;
			$productData['ordering'] = 0;
			$productData['status'] = 'new';
			
			$result = Service::insert($productData);
			if($result==true){
            	echo "SUCCESS";
        	}else{
            	echo mysql_error();
        	}
    	} else {
    		return Response::json(false);
    	}
    }

    public function getAttachmentInfo(){
    	$attachment = Attachment::find(Input::get('id'));
    	if($attachment){
    		echo $attachment->file;
    	} else {
    		echo false;
    	}
	}

	public function paymentTerms($proposal_id, $invoice_id = null){
        $data['proposal'] = ProposalInfo::find($proposal_id);
        if($invoice_id){
        	$data['invoice'] = Invoice::find($invoice_id);
        }

        $admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id'];

        $data['company_info'] = PracticeDetail::where('user_id', $user_id)->first();

        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
        
            // information for crm index
		$owner_id = 'all';
		$page_open = "/crm";

		if($invoice_id){
			$data['selected_page'] = 'Edit Invoice';
		} else {
			$data['selected_page'] = 'Create Invoice';
		}
		$data['page_open'] = 'invoice';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function createInvoice(){
    	if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'note' => 'Note',
			    'payment_term' => 'Payment Term',
			);

			$rules = array(
				        'note' => 'required',
				        'payment_term' => 'required',
				    );

		    $validator = Validator::make(Input::all(), $rules);

		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
		    	$data['note'] = Input::get('note');
	            $data['payment_terms'] = Input::get('payment_term');
	            $data['proposal_id'] = Input::get('proposal_id');
	            if(! Input::has('invoice_id')){
	            	$data['status']="INITIATED";	
	            }

	            if(Input::has('invoice_id')){
	            	Invoice::where('id', Input::get('invoice_id'))->update($data);
	            	$invoice = Invoice::find(Input::get('invoice_id'));
	            } else {
	            	$invoice_id = DB::table('invoice')->insertGetId($data);

	            	$invoice = Invoice::find($invoice_id);
	        	}

	            $proposal_info = ProposalInfo::find(Input::get('proposal_id'));
	            
	            $admin_s = Session::get('admin_details'); // session
				$user_id = $admin_s['id'];

        		$company_info = PracticeDetail::where('user_id', $user_id)->first();
        		$dataInvoice['company_info'] = $company_info; 
        		$dataInvoice['company_address'] = PracticeAddress::where("practice_id", $company_info->practice_id)->first();


	            $dataInvoice['customer_info'] = StepsFieldsClient::where('client_id', $proposal_info->customer_id)->lists('field_value', 'field_name');
	            $dataInvoice['invoice'] = $invoice;
	            $dataInvoice['proposal_info'] = $proposal_info;
	            $dataInvoice['service_products'] = ProposalProduct::where('proposal_id', Input::get('proposal_id'))->get();
	            // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();

	            $filename ="Invoice-id-".$invoice->proposal_id;
		        $pdfFilePath = base_path('/public/proposalPdf/Invoice/'. $filename .'.pdf');
		        
		        ini_set("pcre.backtrack_limit","1000000000");
		        ini_set('memory_limit', '256M');
		        $html = (string) View::make('crm.proposal.templates.invoice_template', $dataInvoice);
		        
		        include(app_path() . '/third_party/mpdf/mpdf.php');
		        $pdf = new mPDF($param);
		        $pdf->WriteHTML($html);
		        $pdf->Output($pdfFilePath, 'F');
		        return Redirect::to('/crm/previewInvoice/'.$invoice->id);
			}
		} 
    }

    public function previewInvoice($invoice_id){
        $invoice = Invoice::find($invoice_id);
        $data['invoice'] = $invoice;
        $data['proposal_info'] = ProposalInfo::find($invoice->proposal_id);
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
        // $data['main_content'] = $this->load->view('preview_invoice', $data, true);
        // $this->load->view('home', $data);

        // information for crm index
        $owner_id = 'all';
		$page_open = "/crm";
		$data['page_title'] = 'Preview Invoice';

		$data['selected_page'] = 'preview invoice';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function downloadInvoice($invoice_pdf, $invoice_id) {
    	Invoice::where('id', $invoice_id)->update(array('status'=>'DOWNLOADED'));
        
        $file= base_path("/public/proposalPdf/Invoice/". $invoice_pdf);

        if(File::exists($file)) {
        	return Response::download($file);
    	} else {
    		Session::flash('info_msg', 'File is not exists.');
			return Redirect::to('crm/previewInvoice/'.$invoice_id);
    	}
    }

    public function saveInvoiceAsDraft($invoice_id){
        Invoice::where('id', $invoice_id)->update(['status' => 'DRAFT']);
        Session::flash('info_msg', 'Invoice has been saved as draft.');
        return Redirect::to('crm/viewAllInvoice');
    }

    public function editInvoice($proposal_id, $invoice_id) {
        $data['invoice'] = Invoice::find($invoice_id);
        $data['proposal'] = ProposalInfo::find($proposal_id);
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
        
        $data['main_content'] = $this->load->view('edit_invoice', $data, true);
        $this->load->view('home', $data);
    }

    public function viewAllInvoice(){
        $data['invoices'] = Invoice::orderBy('id', 'desc')->get();
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();

        // information for crm index
        $owner_id = 'all';
		$page_open = "/crm";
		$data['page_title'] = 'Invoices';

		$data['selected_page'] = 'invoices';
		$data['page_open'] = 'invoice';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function deleteInvoice($invoice_id, $proposal_id){
    	$filePath = base_path('/public/proposalPdf/Invoice/Invoice-id-'.$proposal_id.".pdf");
        if(file_exists($filePath)){
            unlink($filePath);
        }

        Invoice::where('id', $invoice_id)->delete();
        Session::flash('info_msg', 'Invoice has been deleted successfully.');
		return Redirect::to('crm/viewAllInvoice');
    }

    public function viewAllBills(){
        $data=array();
        $data['bills'] = Bill::orderBy('id', 'desc')->get();
        
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();

        // information for crm index
        $owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'payment';
		$data['page_open'] = 'payment';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function amountReceiveForm(){
    	$invoices = Invoice::get(['proposal_id'])->toArray();
    	$proposal_customers = ProposalInfo::whereIn('id', $invoices)->groupBy('customer_id')->get(['customer_id'])->toArray();
    		
    	$ind_client = Client::where('type', 'ind')->whereIn('client_id', $proposal_customers)->get(['client_id'])->toArray();
    	$ind_client_info = StepsFieldsClient::whereIn('client_id', $ind_client)->where('field_name', 'client_name')->get(['field_value', 'client_id'])->toArray();

        $org_client = Client::where('type', 'org')->whereIn('client_id', $proposal_customers)->get(['client_id'])->toArray();
        $org_client_info = StepsFieldsClient::whereIn('client_id', $org_client)->where('field_name', 'business_name')->get(['field_value', 'client_id'])->toArray();

        $data['customers'] = array_merge($ind_client_info, $org_client_info);


    	// $data['customers'] = StepsFieldsClient::whereIn('client_id', $proposal_customers)->where('field_name', 'client_name')->lists('field_value', 'client_id');

        // $data['customers']=$this->db->query("select DISTINCT c.id,c.customer_name from customer_info c INNER JOIN proposal_info p ON c.id=p.customer_id INNER JOIN invoice i ON p.id=i.proposal_id")->result();
       // dd($data['customers']);
        // $data['compnay_info'] = $this->db->query("select * from company where id='1'")->row();
        // $data['main_content'] = $this->load->view('add_amount_receive', $data, true);
        // $this->load->view('home', $data);
    	// information for crm index
        $owner_id = 'all';
		$page_open = "/crm";
		$data['page_title'] = 'Add Payment';

		$data['selected_page'] = 'add payment';
		$data['page_open'] = 'payment';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function getInvoicesViaAjax(){
    	if(Request::ajax() && Request::isMethod('get')){
    		$proposals = ProposalInfo::where('customer_id', Input::get('customer_id'))->get();
    		$info = "<option selected='selected' value=''>Select</option>";
    		foreach($proposals as $proposal){
    			$invoice = Invoice::where('proposal_id', $proposal->id)->first();
    			if($invoice){
    				$info = $info.'<option value="'.$invoice->id.'">ID: '.$invoice->id.", Proposal: ".$proposal->proposal_title.'</option>';
    			}
    		} 
    		echo $info;
    	} else {
    		return Response::json(false);
    	}
    }

    public function getBillingAmount(){
    	$invoice = Invoice::find(Input::get('invoice_id'));
        $proposal = ProposalInfo::find($invoice->proposal_id);
        $paid = Bill::where('proposal_id', $invoice->proposal_id)->sum('amount');
        $data=array('amount'=>$proposal->total,'paid'=>$paid);
   		echo  json_encode($data);
    }

    public function saveAmountReceive(){
    	if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'customer' => 'Customer',
			    'invoice_id' => 'Invoice ID',
			    'receiving_date' => 'Receiving Date',
			    'amount' => 'Amount'
			);

			$rules = array(
				        'customer' => 'required',
					    'invoice_id' => 'required',
					    'receiving_date' => 'required',
					    'amount' => 'required'
				    );

		    $validator = Validator::make(Input::all(), $rules);

		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
		    	$invoice = Invoice::find(Input::get('invoice_id'));

		    	$data['customer_id'] = Input::get('customer');
	            $data['invoice_id'] = Input::get('invoice_id');
	            $data['receiving_date'] = date('Y-m-d', strtotime(Input::get('receiving_date')));
	            $data['amount'] = Input::get('amount');
	            $data['proposal_id'] = $invoice->proposal_id;
	            if(Input::has('bill_id')){
	            	Bill::where('id', Input::get('bill_id'))->update($data);
	            } else {
	            	Bill::insert($data);	
	            }
	            
	            //////////////////////payment status changin of invoice table//////////
	            $proposal_amount = ProposalInfo::find($invoice->proposal_id)->total;
	            $totalPaid = Bill::where('invoice_id', $invoice->id)->sum('amount');
	            if($totalPaid>=$proposal_amount){
	                $status="Paid";
	            }
	            elseif( $totalPaid > 0 && $totalPaid < $proposal_amount){
	                $status="Partially Paid";

	            }else{
	                $status="Due";
	            }
	            Invoice::where('id', $invoice->id)->update(['payment_status'=>$status]);
	            ////////////////////payment satus change ends here/////////////

	            if(Input::has('bill_id')){
	            	Session::flash('info_msg', 'Payment has been updated successfully.');
	            } else {
	            	Session::flash('info_msg', 'Payment has been received successfully.');
	            }
	            
				return Redirect::to('crm/viewAllBills');
		    }
		} 
		return Redirect::back();    	

    }

    public function deleteBill($bill_id){
	    Bill::where('id', $bill_id)->delete();
	    Session::flash('info_msg', 'Payment has been deleted successfully.');
		return Redirect::to('crm/viewAllBills');
	}

	public function editBIll($bill_id){
        $billInfo = Bill::find($bill_id);

        $invoices = Invoice::get(['proposal_id'])->toArray();
    	$proposal_customers = ProposalInfo::whereIn('id', $invoices)->groupBy('customer_id')->get(['customer_id'])->toArray();

    	$ind_client = Client::where('type', 'ind')->whereIn('client_id', $proposal_customers)->get(['client_id'])->toArray();
    	$ind_client_info = StepsFieldsClient::whereIn('client_id', $ind_client)->where('field_name', 'client_name')->get(['field_value', 'client_id'])->toArray();

        $org_client = Client::where('type', 'org')->whereIn('client_id', $proposal_customers)->get(['client_id'])->toArray();
        $org_client_info = StepsFieldsClient::whereIn('client_id', $org_client)->where('field_name', 'business_name')->get(['field_value', 'client_id'])->toArray();

        $data['customers'] = array_merge($ind_client_info, $org_client_info);

    	$data['total_bill'] = ProposalInfo::find($billInfo->proposal_id)->total;
    	$data['sum_paid'] = Bill::where('invoice_id', $billInfo->invoice_id)->sum('amount');
    	$data['billInfo']=$billInfo;

        $owner_id = 'all';
		$page_open = "/crm";
		$data['page_title'] = 'Edit Amount recieve';

		$data['selected_page'] = 'edit payment';
		$data['page_open'] = 'payment';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);

    }

    public  function sendProposalViaEmailForm($proposal_id){

    	$proposal_info = ProposalInfo::find($proposal_id);

    	$admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id'];

        $company_info = PracticeDetail::where('user_id', $user_id)->first();
        $data['company_info'] = $company_info; 
        $data['company_address'] = PracticeAddress::where("practice_id", $company_info->practice_id)->first();
        $data['customer_info'] = StepsFieldsClient::where('client_id', $proposal_info->customer_id)->lists('field_value', 'field_name');
        $data['proposal_info'] = $proposal_info;
        $data['proposal_id'] = $proposal_id;

        $owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'proposal_mail';
		$data['page_open'] = 'proposal';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);

    }

    public function sendProposalViaEmail(){
    	if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'email_to' => 'Email To',
			    'subject' => 'Subject',
			    'message' => 'Email Body',
			);

			$rules = array(
						'email_to' => 'required|email',
					    'subject' => 'required',
					    'message' => 'required|min:20',
				    );

		    $validator = Validator::make(Input::all(), $rules);

		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
		    	$admin_s = Session::get('admin_details'); // session
				$user_id = $admin_s['id'];

		        $company_info = PracticeDetail::where('user_id', $user_id)->first();
		        $data['company_info'] = $company_info; 
		        $data['company_address'] = PracticeAddress::where("practice_id", $company_info->practice_id)->first();
		    	$data['proposal_id'] = Input::get('proposal_id');
            	$data['message_text'] = Input::get('message');

		    	Mail::send('crm.proposal.templates.proposal_email_template', $data, function($message) use($company_info)
				{
					$message->from($company_info->practiceemail, $company_info->display_name);
				    $message->to(Input::get('email_to'), 'Saidul Islam')->subject(Input::get('subject'));
					$message->attach('public/proposalPdf/Proposal_attachments_merged'.Input::get('proposal_id').'.pdf');
				});	

				$data=['status'=>'EMAILED','created_at'=>date('Y-m-d H:i:s')];
				ProposalInfo::where('id', Input::get('proposal_id'))->update($data);

				Session::flash('info_msg', 'Proposal has been sent succesfully.');
				return Redirect::to('crm/viewAllProposal');
		    }	

		}    

    }

    public function saveProposalAsDraftFromEmailForm($proposal_id){
        $data=['status'=>'DRAFT'];
        ProposalInfo::where('id', $proposal_id)->update($data);
        Session::flash('info_msg', 'Proposal has been saved as draft.');
		return Redirect::to('crm/viewAllProposal');
    }

    public  function sendInvoiceViaEmailForm($invoice_id,$proposal_id){
    	$data['invoice'] = Invoice::find($invoice_id);
    	$proposal_info = ProposalInfo::find($proposal_id);

    	$admin_s = Session::get('admin_details'); // session
		$user_id = $admin_s['id'];

        $company_info = PracticeDetail::where('user_id', $user_id)->first();
        $data['company_info'] = $company_info; 
        $data['company_address'] = PracticeAddress::where("practice_id", $company_info->practice_id)->first();
        $data['customer_info'] = StepsFieldsClient::where('client_id', $proposal_info->customer_id)->lists('field_value', 'field_name');
        $data['proposal_info'] = $proposal_info;
        $data['proposal_id'] = $proposal_id;
        $data['invoice_id']=$invoice_id;

        $owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'invoice_mail';
		$data['page_open'] = 'invoice';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function saveInvoiceAsDraftFromEmailForm($invoice_id){
        $data=['status'=>'DRAFT'];
        Invoice::where('id', $invoice_id)->update($data);
        Session::flash('info_msg', 'Invoice has been saved as draft.');
		return Redirect::to('crm/viewAllInvoice');
    }

    public function sendInvoiceViaEmail(){
        if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'email_to' => 'Email To',
			    'subject' => 'Subject',
			    'message' => 'Email Body',
			);

			$rules = array(
						'email_to' => 'required|email',
					    'subject' => 'required',
					    'message' => 'required|min:20',
				    );

		    $validator = Validator::make(Input::all(), $rules);

		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
		    	$admin_s = Session::get('admin_details'); // session
				$user_id = $admin_s['id'];

		        $company_info = PracticeDetail::where('user_id', $user_id)->first();
		        $data['company_info'] = $company_info; 
		        $data['company_address'] = PracticeAddress::where("practice_id", $company_info->practice_id)->first();
		    	$data['proposal_id'] = Input::get('proposal_id');
            	$data['message_text'] = Input::get('message');

		    	Mail::send('crm.proposal.templates.invoice_email_template', $data, function($message) use($company_info)
				{
					$message->from($company_info->practiceemail, $company_info->display_name);
				    $message->to(Input::get('email_to'), Input::get('email_to'))->subject(Input::get('subject'));
					$message->attach('public/proposalPdf/Invoice/Invoice-id-'.Input::get('proposal_id').'.pdf');
				});	

		    	$data1=['status'=>'EMAILED'];
		    	Invoice::where('id', Input::get('invoice_id'))->update($data1);

				Session::flash('info_msg', 'Invoice has been sent succesfully');
				return Redirect::to('crm/viewAllInvoice');
		    }	
		}

    }

    public function makeSchedule($proposal_id){
	    $data['proposal_id'] = $proposal_id;

        $owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'make_schedule';
		$data['page_open'] = 'schedule';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
	}

	public function saveSchedule($proposal_id){
		$proposal_info = ProposalInfo::find($proposal_id);
        $schedule = Schedule::where('proposal_id', $proposal_id)->count();

        if($schedule>0){
            $message=FALSE;
            return View::make('crm.proposal.schedule_fail');
        }else{
            $data1['proposal_id']=$proposal_id;
            $data1['customer_id']=$proposal_info->customer_id;
            Schedule::insert($data1);   
            Session::flash('info_msg', 'success.');      
            $message=TRUE;
            return View::make('crm.proposal.schedule_success');
        }
    }

    public function viewAllSchedule(){
    	$data['schedules'] = Schedule::orderBy('id', 'desc')->get();

        $owner_id = 'all';
		$page_open = "/crm";

		$data['selected_page'] = 'schedule_grid';
		$data['page_open'] = 'schedule';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['proposals']         = "proposals";
        $data['tab_no'] = 'proposal';
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);
    }

    public function toggleScheduleStatus($status,$schedule_id){
        $data['status'] = $status;
        Schedule::where('id', $schedule_id)->update($data);
        Session::flash('info_msg', 'Status has been updated Successfully.');
		return Redirect::to('crm/viewAllSchedule');
    }

    public function deleteSchedule($schedule_id){
    	Schedule::where('id', $schedule_id)->delete();
    	Session::flash('info_msg', 'Schedule has been deleted Successfully');
		return Redirect::to('crm/viewAllSchedule');
    }

  public function action()
	{
		$data 			= array();
		$action 		= Input::get('action');	
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		switch ($action) {
			case 'getProspectByType':
				$postData = Input::all();
				$data['prospects'] = $this->getProspectByType( $postData );
				echo json_encode($data);
				break;
			case 'getContactByType':
				$postData = Input::all();
				$data['prospects'] = $this->getContactByType( $postData );
				echo json_encode($data);
				break;
			case 'saveNewProposal':
				$allData = Input::get('postData');
				$postData = json_decode($allData, true);
				$data['proposals'] = $this->saveNewProposal( $postData );
				echo json_encode($data);
				break;
			case 'save_new_proposal':
				$postData = Input::all();
				$data['proposals'] = $this->save_new_proposal( $postData );
				echo json_encode($data);
				break;
			case 'saveNewContact':
				$postData = Input::all();
				$data['contacts'] = $this->saveNewContactFromProposal( $postData );
				echo json_encode($data);
				break;
			case 'deleteProposal':
				$proposal_id = Input::get('proposal_id');
				$crm_proposal_id = Input::get('crm_proposal_id');
				$data['contacts'] 		= CrmProposal::deleteProposal( $proposal_id, $crm_proposal_id );
				$data['proposal_id'] 	= $proposal_id;
				echo json_encode($data);
				break;
			case 'addNewTable':
				$postData = Input::all();
				$postData['package_type'] = $postData['heading_type'];
				$data = CrmTableHeading::insert_data($postData);
				$d['user_id'] 		= $user_id;
				$d['proposal_id'] 	= $postData['proposal_id'];
				$d['heading_id'] 	= $data['heading_id'];
				$d['fees'] 			= '0.00';
				$d['is_show'] 		= 'O';
				$d['package_type']  = $data['package_type'];
				$d['created'] 		= date('Y-m-d H:i:s');
				$data['crm_proptbl_id'] = CrmProposalTable::insertGetId($d);

				echo json_encode($data);
				break;
			case 'savePackagePop':
				$postData = Input::all();
				$data['proposal_id'] 	= $postData['proposal_id'];
				$data['heading_name'] 	= $postData['package_name'];
				$data['user_id'] 		= $user_id;
				$data['status'] 		= 'new';
				$data['is_show'] 		= 'N';
				$data['package_type'] 	= $postData['package_type'];
				$data['added_from'] 	= 'S';
				$data['created'] 		= date('Y-m-d H:i:s');

				$heading_id = CrmTableHeading::insertGetId($data);
				$details['tableHeadings'][0] = CrmTableHeading::getDetailsById($heading_id);
				echo View::make('crm.proposal.proposals.ajax_standard_package_popup', $details);
				break;
			case 'editNewTable':
				$postData = Input::all();
				$data['heading_name'] 	= $postData['heading_name'];
				$heading_id 			= $postData['heading_id'];
				CrmTableHeading::where('heading_id', $heading_id)->update($data);
				echo json_encode($data);
				break;
			case 'deleteNewTable':
				$postData 	= Input::all();
				$heading_id = $postData['heading_id'];
				$details = CrmProposalTable::getDetailsByHeadingId($heading_id);
				if(isset($details) && count($details) >0){
					$data['message'] = 'exists';
				}else{
					CrmTableHeading::where('heading_id', $heading_id)->delete();
					$data['message'] = 'success';
				}
				echo json_encode($data);
				break;
			case 'addRemoveTable':
				$postData 		= Input::all();
				$proposal_id 	= $this->saveNewTableToProposal( $postData );
				//echo $proposal_id;die;
				//$data['content']= CrmProposalTable::getDetailsByProposalId( $proposal_id );
				$data['content']= CrmProposalTable::getDetailsByProposalId( $proposal_id );
				if($postData['type'] == 'add'){
					$this->saveProposalAsDraft( $postData );
				}

				echo View::make('crm.proposal.proposals.ajax_table_content', $data);
				break;
			case 'addNewService':
				$postData = Input::all();
				$data['service_name'] 	= $postData['service_name'];
				//$data['base_fee'] 		= str_replace(',','',$postData['srvBaseFee']);
				$data['user_id'] 		= $user_id;
				$data['client_type'] 	= 'org';
				$data['status'] 		= 'new';
				$data['added_from'] 	= 'new_proposal';
				$data['service_id'] 	= Service::insertGetId($data);

				$dataP['user_id'] 		= $user_id;
				$dataP['service_id'] 	= $data['service_id'];
				$dataP['service_name'] 	= $postData['service_name'];
				$dataP['price'] 		= str_replace(',','',$postData['srvBaseFee']);
				$dataP['created'] 		= date('Y-m-d H:i:s');
				ProposalService::insert($dataP);

				echo json_encode($data);
				break;
			case 'deleteNewService':
				$postData 	= Input::all();
				$service_id = $postData['service_id'];
				Service::where('service_id', $service_id)->delete();
				echo json_encode($postData);
				break;
			case 'editNewService':
				$postData = Input::all();
				$data = $this->editNewService($postData);
				echo json_encode($data);
				break;
			case 'addRemoveServicesToTable':
				$postData 		= Input::all();
				$page_name 		= $postData['page_name'];
				$this->saveNewServiceToProposalTable( $postData );
				$data['tax_rates'] 	= TaxRate::getAllDetails('C');

				$proposal_id 	= $postData['proposal_id'];
				$p_table_id 	= $postData['p_table_id'];

				$data['tables']= CrmProposalServicesTable::getDetailsByProposalId($proposal_id,$groupUserId);
				$data['services']   = CrmProposalService::getServicesByTableId($postData['p_table_id']);
				$data['totalAmnt'] 	= CrmProposalTable::getAmountByTableId($p_table_id);
				$data['package_type'] = CrmProposalTable::getPackageTypeById($p_table_id);

				echo View::make('crm.proposal.proposals.ajax_table_services_popup', $data);
				
				//print_r($data['services']);die;
				
				break;
			case 'getServiceVyTableId':
				$proposal_id 		= Input::get('proposal_id');
				$p_table_id 		= Input::get('p_table_id');
				$data['package_type'] = Input::get('package_type');

				$data['services'] 	= $this->getServicesData( $p_table_id, $proposal_id );
				$data['tax_rates'] 	= TaxRate::getAllDetails('C');
				$data['tables']= CrmProposalServicesTable::getDetailsByProposalId($proposal_id,$groupUserId);

				//print_r($data['services']);die;
				echo View::make('crm.proposal.proposals.ajax_service_popup', $data);
				break;
			case 'change_rows_order':
				$postData = Input::all();
				$data = $this->change_rows_order( $postData );
				echo json_encode($data);
				break;
			case 'getServicesByTableId':
				$proposal_id 	= Input::get('proposal_id');
				$p_table_id 	= Input::get('p_table_id');
				$data['tables'] =CrmProposalServicesTable::getDetailsByProposalId($proposal_id,$groupUserId);
				$data['services'] 		= CrmProposalService::getServicesByTableId($p_table_id);
				$data['tax_rates'] 		= TaxRate::getAllDetails('C');
				$data['package_type'] 	= CrmProposalTable::getPackageTypeById($p_table_id);
				//print_r($data['tables']);die;

				echo  View::make('crm.proposal.proposals.ajax_table_services_popup', $data);
				break;
			case 'getServicesByHeadingId':
				$heading_id 	= Input::get('heading_id');
				//$data['tables'] = CrmProposalServicesTable::getDetailsByProposalId($proposal_id,$groupUserId);
				$data['services'] 	= CrmTableService::getServicesByHeadingId($heading_id);
				$data['tax_rates'] 	= TaxRate::getAllDetails('C');
				//print_r($data['services']);die;

				echo  View::make('crm.proposal.proposals.ajax_heading_services_popup', $data);
				break;
			case 'getActivityByServiceId':
				$postData = Input::all();
				$data['activities'] = $this->getActivityByServiceId($postData);
				//print_r($data['activities']);die;
				echo View::make('crm.proposal.proposals.ajax_activity_popup', $data);
				break;
			case 'addNewActivity':
				$postData = Input::all();
				$data['user_id'] 		= $user_id;
				$data['name'] 			= $postData['activity_name'];
				$data['base_fee'] 		= str_replace(',','',$postData['actBaseFee']);
				$data['service_id'] 	= $postData['service_id'];
				$data['service_type'] 	= 'P';
				$data['created'] 		= date('Y-m-d H:i:s');
				$data['activity_id'] 	= ProposalActivity::insertGetId($data);
				echo json_encode($data);
				break;
			case 'deleteNewActivity':
				$postData 		= Input::all();
				$activity_id 	= $postData['activity_id'];
				ProposalActivity::where('activity_id', $activity_id)->delete();
				echo json_encode($postData);
				break;
			case 'editNewActivity':
				$postData = Input::all();
				//$data['name'] 		= $postData['activity_name'];
				$data['base_fee'] 	= $postData['base_fee'];
				$activity_id 		= $postData['activity_id'];
				ProposalActivity::where('activity_id', $activity_id)->update($data);
				echo json_encode($data);
				break;
			case 'addRemoveActivityToTable':
				$postData = Input::all();
				$p_service_id = $postData['p_service_id'];
				$data['details'] = $this->saveNewActivityToProposalTable( $postData );
				$data['activities']=CrmProposalActivity::getActitiesByPropServiceId($p_service_id,$groupUserId);
				$data['TotalServiceFees'] = CrmProposalActivity::getPreviewFeesByPServiceId($p_service_id);
				$data['p_table_id'] 			= CrmProposalService::getTableIdByProposalServiceId($p_service_id);
				$data['TotalTableFees'] 	= CrmProposalService::getSumFeesByTableId($data['p_table_id']);

				$data['package_type'] 		= CrmProposalTable::getPackageTypeById($data['p_table_id']);
				//echo "<pre>";print_r($data);die;
				echo View::make('crm.proposal.proposals.ajax_service_activities_popup', $data);
				break;
			case 'getActitiesByServiceId':
				$postData = Input::all();
				$proposal_id 		= Input::get('proposal_id');
				$p_service_id 	= Input::get('p_service_id');
				$data['activities'] = CrmProposalActivity::getActitiesByPropServiceId($p_service_id,$groupUserId);
				$data['isFeeAdded']	= CrmProposalService::getIsFeeAddedById($p_service_id);
				
				$p_table_id 	= CrmProposalService::getTableIdByProposalServiceId($p_service_id);
				$data['package_type']  = CrmProposalTable::getPackageTypeById($p_table_id);

				//print_r($data['package_type']);die;
				echo View::make('crm.proposal.proposals.ajax_service_activities_popup', $data);
				break;
			case 'getNotesByTableId':
				$postData = Input::all();
				$data['notes'] = $this->getNotesByTableId( $postData );
				echo json_encode($data);
				break;
			case 'saveNotesByTableId':
				$postData = Input::all();
				$data['notes'] = $this->saveNotesByTableId( $postData );
				echo json_encode($data);
				break;
			case 'saveHrsAndFees':
				$postData = Input::all();
				$data = $this->saveHrsAndFees( $postData );
				echo json_encode($data);
				break;
			case 'deleteActivityAndService':
				$postData = Input::all();
				$data = $this->deleteActivityAndService( $postData );
				echo json_encode($postData);
				break;
			case 'addRemoveGrandTotal':
				$postData = Input::all();
				$data = $this->addRemoveGrandTotal( $postData );
				echo json_encode($data);
				break;
			case 'grandTotalTablePop':
				$postData = Input::all();
				$proposal_id = $postData['proposal_id'];
				$data['tableHeadings'] 	= $this->getTableHeadingsData($proposal_id);
				echo json_encode($data);
				break;
			case 'checkProposalId':
				$postData 			= Input::all();
				$proposal_id 		= $postData['proposal_id'];
				//$crm_proposal_id 	= CrmProposal::checkProposalByProposalId($proposal_id);
				$data = CrmProposal::getDetailsByProposalId($proposal_id, $groupUserId);
				//$data['crm_proposal_id'] = $crm_proposal_id;
				/*if(isset($details['crm_proposal_id']) && $details['crm_proposal_id'] != '0'){
					$data['encryptProposalId'] 	= Crypt::encrypt($crm_proposal_id);
				}*/
				echo json_encode($data);
				break;
			case 'addRemoveAttachment':
				$postData 	= Input::all();
				$data 		= $this->addRemoveAttachment($postData);
				echo json_encode($data);
				break;
			case 'tcFileUpload':
				$postData 	= Input::all();
				//$data = $this->tcFileUpload();
				$data = $this->saveTermsAndCondition($postData);
				echo json_encode($data);
				break;
			case 'crmActivityOption':
				$postData 	= Input::all();
				$data = $this->crmActivityOption($postData);
				echo json_encode($data);
				break;
			case 'changeActivityFeeType':
				$postData 	= Input::all();
				$this->changeActivityFeeType($postData);
				echo json_encode($postData);
				break;
			case 'openAddOpperFee':
				$postData 	= Input::all();
				$p_service_id 	= $postData['p_service_id'];
				$action_type  	= $postData['action_type'];
				
				if($action_type == 'add_table'){
					$dtls = array();
					$tbls = array();
				}else if($action_type == 'view_table'){
					$id 	= $postData['id'];
					$tbls 	= CrmServiceTable::getDetailsById($id);
					$dtls 	= CrmServiceFee::getDetailsByTableId($id);
					
				}else{
					/*$serv_table_id 	= $postData['serv_table_id'];
					$p_service_id = CrmProposalServicesTable::getProposalServiceIdById($serv_table_id);
					$dtls = CrmProposalServiceFee::getDetailsByProposalServiceId($p_service_id,$groupUserId);
					$tbls = CrmProposalServicesTable::getDetailsByProposalServiceId($p_service_id,$groupUserId);
					*/
					$tbls= CrmProposalServicesTable::getDetailsByProposalServiceId($p_service_id,$groupUserId);
					$dtls = CrmProposalServiceFee::getDetailsByProposalServiceId($p_service_id,$groupUserId);
				}
				$data['details'] = $dtls;
				$data['tables']  = $tbls;

				echo View::make('crm.proposal.proposals.ajax_service_fees_table', $data);
				//echo json_encode($data);
				break;
			case 'saveServiceFeeTypePop':
				$postData 	= Input::all();
				$action_type  	= $postData['action_type'];
				if($action_type == 'add_table' || $action_type == 'view_table'){
					$data = $this->saveServiceTable($postData);
					$data['tables'] = CrmServiceTable::getAllTables( $groupUserId );
					echo View::make('crm.proposal.proposals.ajax_service_table_popup', $data);
				}else{
					$data = $this->saveServiceFeeTypePop($postData);
					echo json_encode($data);
				}
				break;
			case 'deleteServiceFeeType':
				$postData 	= Input::all();
				CrmProposalServiceFee::where('id',$postData['table_id'])->delete();
				echo json_encode($postData);
				break;
			case 'showHideFeesInPreview':
				$postData 	= Input::all();
				$this->showHideFeesInPreview($postData);
				//print_r($postData);die;
				echo json_encode($postData);
				break;
			case 'saveCommentInPreview':
				$postData 	= Input::all();
				$data['comments'] 	= $this->saveCommentInPreview($postData);
				echo json_encode($data);
				break;
			case 'getProposalComment':
				$postData 	= Input::all();
				$crm_proposal_id 	= $postData['crm_proposal_id'];
				CrmProposalComment::where('crm_proposal_id',$crm_proposal_id)->update(array('is_read'=>'Y'));
				$data['comments'] 	= CrmProposalComment::getDetailsByCrmProposalId($crm_proposal_id);
				echo json_encode($data);
				break;
			case 'sendEmailFromProposal':
				$postData = Input::all();
				$crm_proposal_id = $postData['crm_proposal_id'];
				$data = $this->sendEmailFromProposal($postData);
				echo json_encode($data);
				break;
			case 'getProposalEmailContent':
				$postData = Input::all();
				$data['content'] 	= $this->getProposalEmailContent($postData);
				$data['email'] 		= CrmProposal::getProposalSendingEmail($postData['crm_proposal_id']);
				echo json_encode($data);
				break;
			case 'saveSignature':
				$postData = Input::all();
				$data['details'] = $this->saveSignature($postData);
				echo View::make('crm.proposal.proposals.ajax_signed_popup', $data);
				//echo json_encode($data);
				break;
			case 'revokeProposal':
				$postData = Input::all();
				$data['details'] = $this->revokeProposal($postData);
				echo json_encode($data);
				break;
			case 'copyProposal':
				$postData = Input::all();
				$data['crm_proposal_id'] = $this->copyProposal($postData);
				echo json_encode($data);
				break;
			case 'getHistoryByProposalId':
				$postData = Input::all();
				$data['details'] 	= CrmProposalHistory::getHistoryProposalById($postData['proposal_id']);
				//$data['viewedEmail']=CrmProposalSentEmail::getEmailByCrmProposalId($postData['crm_proposal_id']);
				echo json_encode($data);
				break;
			case 'deleteServiceTable':
				$postData = Input::all();
				$data = $this->deleteServiceTable($postData);
				echo json_encode($data);
				break;
			case 'doNotUseFeesService':
				$postData = Input::all();
				$p_service_id = $postData['p_service_id'];
				$data['details'] 		= $this->doNotUseFeesService($postData);
				$data['p_table_id'] 	= CrmProposalService::getTableIdByProposalServiceId($p_service_id);
				$data['TotalTableFees'] = CrmProposalService::getSumFeesByTableId($data['p_table_id']);
				echo json_encode($data);
				break;
			case 'changeFlexFees':
				$postData = Input::all();
				$data = $this->changeFlexFees($postData);
				echo json_encode($data);
				break;
			case 'singleFieldChange':
				$postData = Input::all();
				$data = $this->singleFieldChange($postData);
				echo json_encode($data);
				break;
			case 'newProposalTablePop':
				$postData 	= Input::all();
				$proposalId = $postData['proposal_id'];
				$page_name 	= $postData['page_name'];

				$tableHeadings 	= $this->getTableHeadingsData($proposalId);
				$details = array();
				if(isset($tableHeadings) && count($tableHeadings) >0){
					foreach ($tableHeadings as $k => $v) {
						if($v['is_archive'] == 'N'){
							$details[$k] = $v;
						}
					}
				}
				$data['tableHeadings'] = $details;
				//echo "<pre>";print_r($details);die;
				if($page_name == 'settings'){
					echo View::make('crm.proposal.proposals.ajax_standard_package_popup', $data);
				}else{
					echo View::make('crm.proposal.proposals.ajax_service_package_popup', $data);
				}
				
				break;
			case 'openPackagePop':
				$postData 	= Input::all();
				$data['tableHeadings'] 	= CrmTableHeading::getTableHeadingsData('N');
				//echo "<pre>";print_r($data['tableHeadings']);die;
				echo View::make('crm.proposal.proposals.ajax_standard_package_popup', $data);
				break;
			case 'gatAllProposalPackages':
				$postData 	= Input::all();
				$proposalId = $postData['proposal_id'];
				$is_archive = $postData['is_archive'];

				$tableHeadings 			= $this->getTableHeadingsData($proposalId);
				$data['tableHeadings'] 	= Common::getArchiveArray($tableHeadings, $is_archive);
				echo View::make('crm.proposal.proposals.ajax_service_package_popup', $data);
				break;
			case 'getShowHidePackages':
				$postData 	= Input::all();
				$is_archive = $postData['is_archive'];

				$tableHeadings 			= CrmTableHeading::getAllData();
				$data['tableHeadings'] 	= Common::getArchiveArray($tableHeadings, $is_archive);
				echo View::make('crm.proposal.proposals.ajax_standard_package_popup', $data);
				break;
			case 'updateRecurring':
				$postData 		= Input::all();
				$proposal_id 	= $postData['proposal_id'];
				$heading_id 	= $postData['heading_id'];
				$data['recurring']		= $postData['recurring'];
				$where['proposal_id'] 	= $proposal_id;
				$where['heading_id'] 	= $heading_id;
				CrmProposalTable::whereIn('user_id', $groupUserId)->where($where)->update($data);
				break;
			case 'recurringDetails':
				$postData 		= Input::all();
				$proposal_id 	= $postData['proposal_id'];
				$client_id 		= $postData['client_id'];

				$details = CrmProposal::getDetailsByProposalId($proposal_id, $groupUserId);

				$annual_fee = CrmProposalTable::getRecurAmntByProposalId($proposal_id, $groupUserId);

				//$annual_fee = CrmAccDetail::annualFeeByProposalAndClientId($client_id, $proposal_id);

				$data['annual_fee'] 	= number_format($annual_fee,2);
				$data['monthly_fee']	= number_format($annual_fee/12, 2);
				$data['start_date'] 	= isset($details['start_date'])?date('d-m-Y', strtotime($details['start_date'])):'';
				$data['end_date']= isset($details['end_date'])?date('d-m-Y', strtotime($details['end_date'])):'';
				$data['count_down'] 	= CrmProposal::getCountDown( $data['end_date'] );
				$data['renewals']  = RenewalsManage::getRenewalsByProposalAndClientId($proposal_id, $client_id);
				$data['contracts'] = CrmProposal::recurringProposalByClientId($client_id);
				echo json_encode($data);
				break;
			case 'recurringStatusChange':
				$postData 		= Input::all();
				$save_type 		= $postData['save_type'];
				$client_id 		= $postData['client_id'];
				$manage_id 		= $postData['manage_id'];
				$dataMR['save_type'] 	= $save_type;
				$where['manage_id'] 	= $manage_id;
				RenewalsManage::whereIn('user_id', $groupUserId)->where($where)->update($dataMR);

				$status = CrmProposal::getFullStatus($save_type);
				$data['save_type'] = strtoupper(strtolower($status));

				$data['status_dropdown'] = RenewalsManage::getAllStatus();
	            $data['total_count']     = RenewalsManage::getAllCount();
	            
				echo json_encode($data);
				break;
			case 'actionManageContract':
				$postData = Input::all();
				$where['manage_id']		= $postData['manage_id'];
				if($postData['action_type'] == 'delete'){
					$update['is_delete']	= 'Y';
				}else if($postData['action_type'] == 'archive'){
					$update['is_archive']	= 'Y';
				}else{
					$update['is_archive']	= 'N';
				}
				RenewalsManage::whereIn('user_id', $groupUserId)->where($where)->update($update);

				$data['status_dropdown'] = RenewalsManage::getAllStatus();
	            $data['total_count']     = RenewalsManage::getAllCount();
				echo json_encode($data);
				break;
			case 'deleteOrgTab':
				$postData = Input::all();
				$where['client_id']	= $postData['client_id'];
				CrmAccDetail::whereIn('user_id', $groupUserId)->where($where)->delete();
				echo json_encode($postData);
				break;
			case 'getWipNotes':
				$postData = Input::all();
				$data['notes'] = Todolistnewtask::getNotesById($postData['id']);
				echo json_encode($data);
				break;
			case 'openViewServiceTales':
				$postData = Input::all();
				$data['tables'] = CrmServiceTable::getAllTables( $groupUserId );
				echo View::make('crm.proposal.proposals.ajax_service_table_popup', $data);
				break;
			case 'delete_service_table':
				$postData = Input::all();
				if($postData['delete_type'] == 'service_table'){
					CrmServiceTable::deleteById($postData['id']);
				}
				if($postData['delete_type'] == 'proposal_service_table'){
					CrmProposalServicesTable::deleteById($postData['id']);
				}
				echo json_encode($postData);
				break;
			case 'copyTableToProposalService':
				$postData = Input::all();
				$data['table'] = CrmServiceTable::copyTableToProposalService( $postData );
				echo json_encode($data);
				break;
			default:
				# code...
				break;
		}

	}


	public function crmActivityOption($postData)
	{
		$p_activity_id 			= $postData['p_activity_id'];
		$p_service_id 			= $postData['p_service_id'];
		$up['activity_option'] 	= $postData['value'];
		CrmProposalActivity::where('p_activity_id',$p_activity_id)->update($up);

		if($postData['value'] == 3){
			$servfees = CrmProposalActivity::getTotalHrsAndFeesByPServiceId($p_service_id);
			$fees = CrmProposalActivity::getFeesById($p_activity_id);
			$act_fee = $servfees['fees'] - $fees;

			$upData['fees'] 		= $act_fee;
			$upData['flex_fees'] 	= 100;
			//DB::table('crm_proposal_services')->where('p_service_id', $p_service_id)->update(['fees'=>DB::raw('fees-'.$fees), 'flex_fees'=>100]);
		}else{
			$fees = CrmProposalActivity::getTotalHrsAndFeesByPServiceId($p_service_id);
			$upData['fees'] 		= $fees['fees'];
			$upData['flex_fees'] 	= 100;
		}
		$isFeeAdded = CrmProposalService::getIsFeeAddedById($p_service_id);
		if($isFeeAdded == 'Y'){
			CrmProposalService::where('p_service_id',$p_service_id)->update($upData);
		}
		$data['fees'] = CrmProposalService::getFeesById($p_service_id);
		return $data;
	}

	public function editNewService($postData)
	{
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$data['service_name'] 	= $postData['service_name'];
		$data['price'] 			= $postData['base_fee'];
		$service_id 			= $postData['service_id'];
		$dtls = ProposalService::whereIn('user_id',$groupUserId)->where('service_id',$service_id)->first();
		if(isset($dtls) && count($dtls) >0){
			$prop_serv_id = $dtls->prop_serv_id;
			ProposalService::where('prop_serv_id',$prop_serv_id)->update($data);
		}else{
			$data['service_id'] = $postData['service_id'];
			$data['user_id'] 	= $user_id;
			$data['created'] 	= date('Y-m-d H:i:s');
			$prop_serv_id = ProposalService::insertGetId($data);
		}
		$details = ProposalService::getDetailsById($prop_serv_id);

		return $details;
	}

	public function singleFieldChange($postData)
	{
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$proposal_id 	= $postData['proposal_id'];
		$id_name 		= $postData['id_name'];
		$id_value 		= $postData['id_value'];
		$table_name 	= $postData['table_name'];
		$update_column 	= $postData['update_column'];
		$update_value 	= $postData['update_value'];

		$pData[$update_column] = $update_value;
		DB::table($table_name)->where($id_name, $id_value)->update($pData);

		return $postData;
	}

	public function changeFlexFees($postData){
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$field_value 	= $postData['field_value'];
		$type 			= $postData['type'];
		$column_name 	= $postData['column_name'];
		$table_id 		= $postData['table_id'];
		
		if($type == 'activity'){
			$p_service_id 	= $postData['p_service_id'];

			$flexFees 		= CrmProposalActivity::getFlexFeesById($table_id);
			$fees 			= CrmProposalActivity::getFeesById($table_id);
			$newFees 		= ($field_value*$fees)/$flexFees;

			$upData['flex_fees'] 	= $field_value;
			$upData['fees'] 		= $newFees;
			CrmProposalActivity::where('p_activity_id', $table_id)->update($upData);
			$data['details'] = CrmProposalActivity::getDetailsById($table_id);

			// ================ Sum into service table ===================== //
			$isFeeAdded = CrmProposalService::getIsFeeAddedById($p_service_id);
			$fees = CrmProposalActivity::getPreviewFeesByPServiceId($p_service_id);
			if($isFeeAdded == 'Y'){
				$dataCPS['fees'] = $fees;
				CrmProposalService::where('p_service_id',$p_service_id)->update($dataCPS);
			}
		}

		if($type == 'service'){
			$flexFees 	= CrmProposalService::getFlexFeesById($table_id);
			$fees 		= CrmProposalService::getFeesById($table_id);
			$newFees 	= ($field_value*$fees)/$flexFees;

			$upData['flex_fees'] 	= $field_value;
			$upData['fees'] 		= $newFees;
			CrmProposalService::where('p_service_id', $table_id)->update($upData);
			$data['details'] 	= CrmProposalService::getDetailsById($table_id, $groupUserId);
			$p_service_id 		= $table_id;
		}

		$data['totalServiceFee'] = CrmProposalService::getFeesById($p_service_id);
		$tbl_id 	= CrmProposalService::getTableIdByProposalServiceId($p_service_id);
		$sumFees 	= CrmProposalService::getSumFeesByTableId($tbl_id);
		CrmProposalTable::where('id', $tbl_id)->update(array('fees'=>$sumFees));
		$data['table_id'] 		= $tbl_id;
		$data['totalTableFee'] 	= number_format($sumFees, 2);
		return $data;
	}

	public function doNotUseFeesService($postData)
	{
		$session 		= Session::get('admin_details');
		$groupUserId    = $session['group_users'];

		if($postData['type'] == 'add'){
			$data['isFeeAdded'] = 'N';
			$data['fees'] 		= ProposalService::getPriceByServiceId( $postData['service_id'] );
		}else{
			$data['isFeeAdded'] = 'Y';
			$data['fees'] 		= CrmProposalActivity::getPreviewFeesByPServiceId( $postData['p_service_id'] );
		}
		$data['flex_fees'] 	= 100;

		CrmProposalService::where('p_service_id',$postData['p_service_id'])->update($data);
		CrmProposalTable::updateTableFees($postData['p_service_id']);

		$details = CrmProposalService::getDetailsById($postData['p_service_id'], $groupUserId);
		return $details;
	}

	public function deleteServiceTable($postData)
	{
		CrmProposalServicesTable::where('id',$postData['serv_table_id'])->delete();
		CrmProposalServiceFee::where('p_serv_table_id',$postData['serv_table_id'])->delete();

		$data['fee_type'] = 'fee_table';
		CrmProposalService::where('p_service_id',$postData['p_service_id'])->update($data);
		return $postData;
	}

	public function copyProposal($postData)
	{ 
		$old_crm_proposal_id 	= $postData['crm_proposal_id'];
		$from_page 				= $postData['from_page'];

		$old_proposal_id 	= CrmProposal::getProposalIdByCrmProposalId($old_crm_proposal_id);
		$new_proposal_id	= CrmProposal::getNewProposalId();

		/* ================ crm_proposals Table ================== */
		$proposals 	= CrmProposal::where('crm_proposal_id', $old_crm_proposal_id )->get()->toArray();
        foreach ($proposals as $data) 
        {
        	if($from_page == 'prop_client_org'){
        		$data['start_date'] = date("Y-m-d", strtotime('+1 year', strtotime($data['start_date'])));
        		$data['end_date'] 	= date("Y-m-d", strtotime('+1 year', strtotime($data['end_date'])));
        	}
        	unset($data['crm_proposal_id']);
        	$data['proposalID'] 	= $new_proposal_id;
        	$data['save_type'] 		= 'D';
        	$data['is_signed'] 		= 'N';
        	$data['created'] 		= date('Y-m-d H:i:s');
            $new_crm_proposal_id 	= CrmProposal::insertGetId($data);
            CrmProposalId::insertProposalId($data['proposalID']);
            $data['save_type'] 	= 'C';
            CrmProposalHistory::insertProposalHistory($data);
        }

    	/* ================ crm_proposal_attachments Table ================== */
    	$attachments = CrmProposalAttachment::where('proposal_id',$old_proposal_id )->get()->toArray();
      foreach ($attachments as $a) 
      {
      	unset($a['cp_attach_id']);
      	$a['proposal_id'] = $new_proposal_id;
        CrmProposalAttachment::insert($a);
      }

    	/* ================ crm_proposal_comments Table ================== */
    	$comments= CrmProposalComment::where('crm_proposal_id',$old_crm_proposal_id)->get()->toArray();
      foreach ($comments as $c) 
      {
      	unset($c['id']);
      	$c['crm_proposal_id'] = $new_crm_proposal_id;
        CrmProposalComment::insert($c);
      }

    	/* ================ crm_proposal_cover_letters Table ================== */
    	$cletters = CrmProposalCoverletter::where('proposal_id', $old_proposal_id )->get()->toArray();
      foreach ($cletters as $cl) 
      {
      	unset($cl['cover_letter_id']);
      	$cl['proposal_id'] = $new_proposal_id;
          CrmProposalCoverletter::insert($cl);
      }
    	/* ================ crm_proposal_grand_totals Table ================== */
    	$totals 	= CrmProposalGrandTotal::where('proposal_id', $old_proposal_id )->get()->toArray();
      foreach ($totals as $t) 
      {
      	unset($t['grand_total_id']);
      	$t['proposal_id'] = $new_proposal_id;
          CrmProposalGrandTotal::insert($t);
      }
    	/* ================ crm_table_headings Table ================== */
    	$heddings 	= CrmTableHeading::where('proposal_id', $old_proposal_id )->get()->toArray();
      foreach ($heddings as $h) 
      {
      	unset($h['heading_id']);
      	$h['proposal_id'] = $new_proposal_id;
        CrmTableHeading::insert($h);
      }
    	/* ================ crm_proposal_tables Table ================== */
    	$tables 	= CrmProposalTable::where('proposal_id', $old_proposal_id )->get()->toArray();
      foreach ($tables as $t) 
      {
      	$old_p_table_id = $t['id'];
      	unset($t['id']);
      	$t['proposal_id'] = $new_proposal_id;
        $p_table_id = CrmProposalTable::insertGetId($t);

        $services 	= CrmProposalService::where('p_table_id', $old_p_table_id )->get()->toArray();
        foreach ($services as $s) 
        {
        	$old_p_service_id = $s['p_service_id'];
        	unset($s['p_service_id']);
        	$s['p_table_id'] = $p_table_id;
            $p_service_id = CrmProposalService::insertGetId($s);

            $services 	= CrmProposalActivity::where('p_service_id', $old_p_service_id )->get()->toArray();
	        foreach ($services as $a) 
	        {
	        	unset($a['p_activity_id']);
	        	$a['p_service_id'] = $p_service_id;
            $p_activity_id = CrmProposalActivity::insertGetId($a);
					}

				/* crm_proposal_service_fees */
				$sfees 	= CrmProposalServiceFee::where('p_service_id', $old_p_service_id )->where('proposal_id', $old_proposal_id )->get()->toArray();
	      foreach ($sfees as $sf) 
	      {
	      	unset($sf['id']);
	      	$sf['p_service_id'] = $p_service_id;
	      	$sf['proposal_id'] 	= $new_proposal_id;
	        $p_activity_id = CrmProposalServiceFee::insertGetId($sf);
				}
      }
    }


    return $new_crm_proposal_id;
	}

	public function revokeProposal($postData)
	{
		$crm_proposal_id = $postData['crm_proposal_id'];
		$Udata['is_rejected'] 	= time();
		$Udata['save_type'] 	= 'R';
		$Udata['is_signed'] 	= 'N';
		$Udata['brand_color'] 	= '';
		$Udata['brand_logo'] 	= '';
		CrmProposal::where('crm_proposal_id', $crm_proposal_id)->update($Udata);
		CrmProposalSign::where('crm_proposal_id', $crm_proposal_id)->delete();

		$data['save_type'] 		= 'R';
		$data['proposalID'] = CrmProposal::getProposalIdByCrmProposalId($crm_proposal_id);
		CrmProposalHistory::insertProposalHistory($data);

	}

	

	public function getProposalEmailContent($postData)
	{
		$session    = Session::get('admin_details');
		$staff_user = $session['fname'].' '.$session['lname'];

		$email_text 		= $postData['content'];
		$crm_proposal_id 	= $postData['crm_proposal_id'];

		$proposal_id 		= CrmProposal::getProposalIdByCrmProposalId( $crm_proposal_id );
		$user_id 			= CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);
		$group_id 			= User::getGroupIdByUserId($user_id);
		$groupUserId    	= Common::getUserIdByGroupId($group_id);
		$data['practice'] 	= PracticeDetail::getPracticeDetailsPreview( $groupUserId );

		$data['proposal'] 	= CrmProposal::getProposalById( $crm_proposal_id );
		$data['senderName'] = CrmProposal::getSenderByCrmProposalId($crm_proposal_id);

		$link = '<a href="'.url().'/proposal-preview/'.$data['proposal']['entrpt_crm_prop_id'].'/email/'.$data['proposal']['is_rejected'].'" target="_blank">here</a>';
		$healthy 	= array("[Name]", "[link]", "[Staff User]" ,"[Practice Name]");
		$yummy   	= array($data['senderName'], $link, $staff_user, $data['practice']['display_name']);
		$newphrase 	= str_replace($healthy, $yummy, $email_text);

		return $newphrase;
	}

	public function sendEmailFromProposal($postData)
	{
		$details = array();
		$actionEmail 		= $postData['actionEmail'];
		$email_text 		= $postData['email_text'];
		$crm_proposal_id 	= $postData['crm_proposal_id'];
		$data['senderEmail']= Config::get('constant.ADMINEMAIL');
		//$senderEmail 		= 'hello@ipractice.co.uk';

		$proposal_id 		= CrmProposal::getProposalIdByCrmProposalId( $crm_proposal_id );
		$user_id 			= CrmProposal::getUserIdByCrmProposalId($crm_proposal_id);
		$group_id 			= User::getGroupIdByUserId($user_id);
		$groupUserId    	= Common::getUserIdByGroupId($group_id);
		$data['practice'] 	= PracticeDetail::getPracticeDetailsPreview( $groupUserId );

		$data['proposal'] 	= CrmProposal::getProposalById( $crm_proposal_id );
		$data['actionEmail']= explode(',', $actionEmail);
		$data['senderName'] = CrmProposal::getSenderByCrmProposalId($crm_proposal_id);
		$data['base_url'] 	= url();

		$data['newphrase'] = $email_text;
		Mail::send('crm.proposal.emails.proposal', $data, function ($message) use ($data) {
			$message->from($data['senderEmail'], $data['practice']['display_name']);
			$message->to($data['actionEmail']);
			$message->subject($data['practice']['display_name'].' has sent you a proposal '.$data['proposal']['proposalID']);
		});

		$data['proposal']['save_type'] = 'E';
		CrmProposalHistory::insertProposalHistory($data['proposal']);
		CrmProposalSentEmail::saveEmailAddress($actionEmail, $crm_proposal_id);

		$save_type = CrmProposal::getSaveTypeById($crm_proposal_id);
		if($save_type != 'MA' && $save_type != 'L' && $save_type != 'ML'){
			$dataBrnd['brand_color'] 	= PracticeDetail::getBrandingColor( $groupUserId );
			$dataBrnd['brand_logo'] 	= PracticeDetail::getBrandingLogo( $groupUserId );
			$dataBrnd['save_type'] 		= 'E';
			CrmProposal::where('crm_proposal_id', $crm_proposal_id)->update($dataBrnd);
		}

		$details = CrmProposalSentEmail::getDetailsByCrmProposalId($crm_proposal_id);
		return $details;		
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
				/*$message->subject($data['practice']['display_name'].' has posted comment to a proposal '.$data['proposal']['proposalID']);*/
				$message->subject('New comment notification [Proposal ID '.$data['proposal']['proposalID'].']');
			});
		}
		/* ============= Email Send End =============== */

		$details = CrmProposalComment::getDetailsByCrmProposalId($crm_proposal_id);
		return $details;
	}

	public function saveServiceTable($postData)
	{
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$action_type 	= $postData['action_type'];
		$p_service_id 	= $postData['p_service_id'];
		$proposal_id 	= $postData['proposal_id'];
		$description 	= $postData['feeTypeDesc'];
		$fees 			= $postData['feeTypeFees'];

		$Tdata['table_name'] = $postData['table_name'];
		$Tdata['table_type'] = $postData['table_type'];
		$Tdata['user_id'] 	 = $this->user_id;
		if($action_type == 'add_table' || $action_type == 'view_table'){
			$last_id = $postData['id'];
			if($last_id > 0){
				CrmServiceTable::where('id', $last_id)->update($Tdata);
			}else{
				$Tdata['created'] 		= date('Y-m-d H:i:s');
				$last_id = CrmServiceTable::insertGetId($Tdata);
			}
		}

		CrmServiceFee::where('serv_table_id', $last_id)->delete();
		if(isset($description) && count($description) >0){
			foreach ($description as $k => $v) {
				$data[$k]['serv_table_id'] 	= $last_id;
				$data[$k]['user_id'] 		= $this->user_id;
				$data[$k]['desc'] 			= $v;
				$data[$k]['fees'] 			= $fees[$k];
				$data[$k]['created'] 		= date('Y-m-d H:i:s');
			}
		}
		//print_r($data);die;
		if(!empty($data)){
			CrmServiceFee::insert($data);
		}

		return CrmServiceTable::getDetailsById($last_id);
	}

	public function saveServiceFeeTypePop($postData)
	{
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$action_type 	= $postData['action_type'];
		$p_service_id 	= $postData['p_service_id'];
		$proposal_id 	= $postData['proposal_id'];
		$description 	= $postData['feeTypeDesc'];
		$fees 			= $postData['feeTypeFees'];

		$Tdata['table_name'] 		= $postData['table_name'];
		$Tdata['table_type'] 		= $postData['table_type'];
		if($action_type == 'add'){ 
			$Tdata['user_id'] 		= $this->user_id;
			$Tdata['proposal_id'] 	= $proposal_id;
			$Tdata['p_service_id'] 	= $p_service_id;
			$Tdata['created'] 		= date('Y-m-d H:i:s');
			$last_id = CrmProposalServicesTable::insertGetId($Tdata);
		}else{
			//$table_id = CrmProposalService::getFeeTableIdByPServiceId($p_service_id);
			/*$tables = CrmProposalServicesTable::getDetailsByProposalServiceId($p_service_id,$groupUserId);*/
			/*if(isset($table_id) && $table_id != '0' && $table_id != 'fee_table'){
				CrmProposalServicesTable::where('id', $table_id)->update($Tdata);
				$last_id = $table_id;
			}*/
			$last_id = CrmProposalServicesTable::checkIsTableAdded( $p_service_id );
			CrmProposalServicesTable::where('id', $last_id)->update($Tdata);
		}
		$Tdata['id'] 	= $last_id;


		CrmProposalServiceFee::where('p_service_id',$p_service_id)->delete();
		//echo $last_id;die;
		if(isset($description) && count($description) >0){
			foreach ($description as $k => $v) {
				$data[$k]['desc'] 			= $v;
				$data[$k]['fees'] 			= $fees[$k];
				$data[$k]['user_id'] 		= $this->user_id;
				$data[$k]['proposal_id'] 	= $proposal_id;
				$data[$k]['p_service_id'] 	= $p_service_id;
				$data[$k]['p_serv_table_id']= $last_id;
				$data[$k]['created'] 		= date('Y-m-d H:i:s');
			}
		}
		//print_r($data);die;
		if(!empty($data)){
			CrmProposalServiceFee::insert($data);
		}

		$srData['fee_type'] = $last_id;
		CrmProposalService::where('p_service_id', $p_service_id)->update($srData);

		$resp['details'] = CrmProposalServiceFee::getDetailsByProposalServiceId($p_service_id, $groupUserId);
		//$resp['tables']  = CrmProposalServicesTable::getDetailsByProposalServiceId($p_service_id,$groupUserId);
		$resp['tables']  = $Tdata;
		//$resp['tables']  = CrmProposalServicesTable::getDetailsByProposalId($proposal_id,$groupUserId);
		return $resp;
	}

	public function changeActivityFeeType($postData)
	{
		$value 			= $postData['value'];
		$p_service_id 	= $postData['p_service_id'];
		$proposal_id 	= $postData['proposal_id'];

		$up['fee_type'] = $value;
		CrmProposalService::where('p_service_id',$p_service_id)->update($up);
	}

	public function showHideFeesInPreview($postData)
	{//print_r($postData);die;
		$table_id 		= $postData['table_id'];
		$popup 			= $postData['popup'];
		$proposal_id 	= $postData['proposal_id'];
		$type 			= $postData['type'];

		if($popup == 'activity'){
			$up['is_show_fees'] = $postData['type'];
			CrmProposalActivity::where('p_activity_id',$table_id)->update($up);
		}
		if($popup == 'service'){
			$up['is_show_fees'] = $postData['type'];
			CrmProposalService::where('p_service_id',$table_id)->update($up);
		}
	}

	public function saveTermsAndCondition($postData)
	{
		$d = TermsConditionFile::getTermsAndConditions();
		$attachData['description'] 	= $postData['description'];
		//Common::last_query();die;
		if(isset($d) && count($d) >0){
			TermsConditionFile::where('tc_file_id',$d['tc_file_id'])->update($attachData);
			$last_id = $d['tc_file_id'];
		}else{
			$attachData['user_id'] 	= $this->user_id;
			$attachData['created'] 	= date('Y-m-d H:i:s');
			$last_id = TermsConditionFile::insertGetId($attachData);
		}
		$details  = TermsConditionFile::getTermsAndConditions();
		return $details;
	}

	public function tcFileUpload()
	{
		$attachData = array();
		if(Input::hasFile('file')){
			$file = Input::file('file');
			if($file->getMimeType() == 'application/pdf'){
				$fileName = $file->getClientOriginalName();
				$upload_success = $file->move(base_path('public/uploads/tc_files/'), $fileName);
				$d = TermsConditionFile::getTermsAndConditions();
				$attachData['file_name'] 	= $fileName;
				if(isset($d) && count($d) >0){
					TermsConditionFile::where('tc_file_id',$d['tc_file_id'])->update($attachData);
				}else{
					$attachData['user_id'] 	= $this->user_id;
					$attachData['created'] 	= date('Y-m-d H:i:s');
					TermsConditionFile::insert($attachData);
				}
			}
		}
		return $attachData;
	}

	public function addRemoveAttachment( $postData )
	{
		$data = array();
		$proposal_id 	= $postData['proposal_id'];
		$attachment_id 	= $postData['attachment_id'];

		if($postData['type'] == 'add'){
			$idata['proposal_id'] 	= $proposal_id;
			$idata['attachment_id'] = $attachment_id;
			$idata['user_id'] 		= $this->user_id;
			$idata['status'] 		= 'A';
			
			$dtls = CrmProposalAttachment::whereIn('user_id', $this->groupUserId)->where('proposal_id', $idata['proposal_id'])->where('attachment_id', $idata['attachment_id'])->first();
			if(isset($dtls) && count($dtls) >0 ){
				CrmProposalAttachment::where('cp_attach_id', $dtls['cp_attach_id'])->update($idata);
			}else{
				$idata['created'] 	= date('Y-m-d H:i:s');
				CrmProposalAttachment::insert($idata);
			}
		}else{
			CrmProposalAttachment::whereIn('user_id', $this->groupUserId)->where('proposal_id', $proposal_id)->where('attachment_id', $attachment_id)->delete();
		}
		return $data;
	}

	public function addRemoveGrandTotal( $postData )
	{
		$data = array();
		$idata['proposal_id'] 	= $postData['proposal_id'];
		$idata['heading_id'] 	= $postData['heading_id'];
		$idata['user_id'] 		= $this->user_id;
		if($postData['type'] == 'add'){
			$idata['created'] 		= date('Y-m-d H:i:s');
			CrmProposalGrandTotal::insert($idata);
		}else{
			CrmProposalGrandTotal::whereIn('user_id', $this->groupUserId)->where('proposal_id', $idata['proposal_id'])->where('heading_id', $idata['heading_id'])->delete();
		}

		$data['grand_total']=CrmProposalGrandTotal::getGrandTotal($idata['proposal_id']);
		//Common::last_query();
		return $data;
	}

	public function deleteActivityAndService( $postData )
	{
		$table_id 		= Input::get('table_id');
		$type 			= Input::get('type');
		$table_name 	= Input::get('table_name');
		$table_id_name 	= Input::get('table_id_name');

		DB::table($table_name)->where($table_id_name, $table_id)->delete();
	}

	public function saveHrsAndFees( $postData )
	{
		$table_id 		= Input::get('table_id');
		$is_show 		= Input::get('is_show');
		$type 			= Input::get('type');
		$column_name 	= Input::get('column_name');
		$table_name 	= Input::get('table_name');
		$table_id_name 	= Input::get('table_id_name');

		$field_value = Input::get('field_value');
		$data[$column_name] = str_replace(',', '', $field_value);

		$data['flex_fees'] = 100;
		DB::table($table_name)->where($table_id_name, $table_id)->update($data);
		if($type == 'activity'){
			$p_service_id = CrmProposalActivity::getPServiceIdByPActivityId($table_id);
			$fData = CrmProposalActivity::getTotalHrsAndFeesByPServiceId($p_service_id);
			CrmProposalService::where('p_service_id', $p_service_id)->update($fData);
			
			// ================ Sum into service table ===================== //
			$isFeeAdded = CrmProposalService::getIsFeeAddedById($p_service_id);
			$fees = CrmProposalActivity::getPreviewFeesByPServiceId($p_service_id);
			if($isFeeAdded == 'Y'){
				$dataCPS['fees'] = $fees;
				CrmProposalService::where('p_service_id',$p_service_id)->update($dataCPS);
			}
			$fData['p_service_id'] 	= $p_service_id;
			$fData['flex_fees'] 	= $data['flex_fees'];
		}

		/* =============== Table Heading Fees ================ */
		$fees = CrmProposalService::getSumFeesByTableId($postData['crm_proptbl_id']);
		CrmProposalTable::where('id', $postData['crm_proptbl_id'])->update(array('fees'=>$fees));
		$fData['table_fees'] = number_format($fees, 2);		

		$grand_total = DB::table('crm_proposal_tables')->whereIn('user_id', $this->groupUserId)
					->where('proposal_id', $postData['proposal_id'])->where('is_show',$is_show)->sum('fees');
		$fData['grand_total'] 	= number_format($grand_total, 2);			
		$fData['table_id'] 		= $table_id;

		return $fData;
	}

	public function saveNotesByTableId( $postData )
	{
		$notes = '';
		$table_id 		= Input::get('table_id');
		$type 			= Input::get('type');
		$data['notes'] 	= Input::get('notes');
		if($type == 'service'){
			CrmProposalService::where('p_service_id', $table_id)->update($data);
		}
		if($type == 'activity'){
			CrmProposalActivity::where('p_activity_id', $table_id)->update($data);
		}
		if($type == 'crm_attachment'){
			$proposal_id 	= Input::get('proposal_id');
			$dtls = CrmProposalAttachment::where('proposal_id', $proposal_id)->where('attachment_id', $table_id)->first();
			if(isset($dtls) && count($dtls) >0){
				CrmProposalAttachment::where('cp_attach_id', $dtls->cp_attach_id)->update($data);
			}else{
				$data['proposal_id'] 	= $proposal_id;
				$data['user_id'] 		= $this->user_id;
				$data['attachment_id'] 	= $table_id;
				$data['status'] 		= 'I';
				$data['created'] 		= date('Y-m-d H:i:s');
				CrmProposalAttachment::insert($data);
			}
		}
		if($type == 'settings_attachment'){
			Attachment::where('id', $table_id)->update($data);
		}
		return $data['notes'];
	}

	public function getNotesByTableId( $postData )
	{
		$notes = '';
		$table_id 	= Input::get('table_id');
		$type 		= Input::get('type');
		if($type == 'service'){
			$notes = CrmProposalService::getProposalServicesNotesById($table_id);
		}
		if($type == 'activity'){
			$notes = CrmProposalActivity::getProposalActivityNotesById($table_id);
		}
		if($type == 'crm_attachment'){
			$proposal_id 	= Input::get('proposal_id');
			$notes = CrmProposalAttachment::getNotesByProposalIdAttachmentId( $proposal_id, $table_id );
			if($notes == ''){
				$notes = Attachment::getNotesByAttachmentId( $table_id );
			}
		}
		if($type == 'settings_attachment'){
			$notes = Attachment::getNotesByAttachmentId( $table_id );
		}
		return $notes;
	}

	public function getActivityByServiceId( $postData )
	{
		$data = array();
		$service_id 	= $postData['service_id'];
		$p_service_id 	= $postData['p_service_id'];

		$activities = ProposalActivity::getDataByServiceId( $service_id );
		if(isset($activities) && count($activities) > 0){
			foreach ($activities as $k => $v) {
				$data[$k] = $v;
				$data[$k]['table_show'] = CrmProposalActivity::checkTable($p_service_id,$v['activity_id']);
			}
		}
		return $data;
	}

	public function change_rows_order( $postData )
	{
		$id_name 	= Input::get('id_name');
		$table 		= Input::get('table');
		$column 	= Input::get('column');
		$ordering 	= Input::get('ordering');
		$ids = explode(',', $ordering);
		foreach ($ids as $k => $id) {
			$data[$column] = $k+1;
			/*if($table == 'crm_proposal_tables'){
				CrmProposalTable::where($id_name, '=', $id)->update($data);
			}
			if($table == 'crm_proposal_services'){
				CrmProposalService::where($id_name, '=', $id)->update($data);
			}*/
			DB::table($table)->where($id_name, $id)->update($data);
		}
	}

	public function saveNewActivityToProposalTable( $postData )
	{
		$data = array();

		$proposal_id 	= $postData['proposal_id'];
		$p_service_id 	= $postData['p_service_id'];
		$activity_id 	= $postData['activity_id'];
		$type 			= $postData['type'];
		//$package_type 	= (string)$postData['package_type'];
		$p_table_id = CrmProposalService::getTableIdByProposalServiceId($p_service_id);
		$package_type 	= CrmProposalTable::getPackageTypeById($p_table_id);


		//echo $package_type;die;

		$p_activity_id = 0;
		if($type == 'add'){
			$details = CrmProposalActivity::whereIn('user_id', $this->groupUserId)->where('p_service_id', $p_service_id)->where('activity_id', $activity_id)->first();
			if(!isset($details) && empty($details)){
				$Idata['user_id'] 			= $this->user_id;
				$Idata['p_service_id'] 		= $p_service_id;
				$Idata['activity_id']		= $activity_id;
				$Idata['activity_option']	= $postData['activity_option'];
				$Idata['flex_fees']			= 100;
				$Idata['is_show_fees']		= ($package_type == 'C')?'Y':'N';
				$Idata['fees']				= ProposalActivity::getBaseFeeById($activity_id);
				$Idata['created'] 			= date('Y-m-d H:i:s');
				$p_activity_id = CrmProposalActivity::insertGetId($Idata);
			}
			//Common::last_query();die;
			/* ================================== */
			$isFeeAdded = CrmProposalService::getIsFeeAddedById($p_service_id);
			if($isFeeAdded == 'Y'){
				CrmProposalService::updateServiceFees($p_service_id);
				CrmProposalTable::updateTableFees($p_service_id);
			}

		}
		if($type == 'remove'){
			CrmProposalActivity::whereIn('user_id', $this->groupUserId)->where('p_service_id', $p_service_id)->where('activity_id', $activity_id)->delete();
		}
		//echo $p_activity_id;die;
		return $p_activity_id;
	}

	public function saveNewServiceToProposalTable( $postData )
	{
		$data = array();
		
		$service_id 	= $postData['service_id'];
		$type 			= $postData['type'];
		$page_name 		= $postData['page_name'];

		$proposal_id 	= $postData['proposal_id'];
		$p_table_id 	= $postData['p_table_id'];		

		$packageType = CrmProposalTable::getPackageTypeById($p_table_id);
		//echo $package_type;
		//Common::last_query();die;

		if($type == 'add'){
			$details = DB::table('crm_proposal_services')->whereIn('user_id', $this->groupUserId)->where('p_table_id',$p_table_id)->where('service_id', $service_id)->first();
			if(!isset($details) && empty($details)){
				$Idata['user_id'] 		= $this->user_id;
				$Idata['service_id']	= $service_id;
				$Idata['p_table_id'] 	= $p_table_id;
				$Idata['billing_freq']	= ($packageType=='C')?'':'Monthly';
				$Idata['tax_rate']		= ($packageType=='C')?'':1;
				$Idata['is_show_fees']	= ($packageType=='C')?'Y':'N';
				$Idata['flex_fees']		= 100;
				$Idata['fees']		 	= ProposalService::getPriceByServiceId($service_id);
				$Idata['created'] 		= date('Y-m-d H:i:s');
				$p_service_id = DB::table('crm_proposal_services')->insertGetId($Idata);
			}
		}
		if($type == 'remove'){
			DB::table('crm_proposal_services')->whereIn('user_id', $this->groupUserId)->where('p_table_id',$p_table_id)->where('service_id', $service_id)->delete();
		}

		return 1;
	}

	/*public function saveNewServiceToProposalTable( $postData )
	{
		$data = array();
		
		$service_id 	= $postData['service_id'];
		$type 			= $postData['type'];
		$page_name 		= $postData['page_name'];

		if($page_name == 'settings'){
			$heading_id = $postData['heading_id'];
			if($type == 'add'){
				$details = DB::table('crm_table_services')->whereIn('user_id', $this->groupUserId)->where('heading_id',$heading_id)->where('service_id', $service_id)->first();
				if(!isset($details) && empty($details)){
					$Idata['user_id'] 		= $this->user_id;
					$Idata['service_id']	= $service_id;
					$Idata['heading_id'] 	= $heading_id;
					$Idata['billing_freq']	= 'Monthly';
					$Idata['tax_rate']		= 1;
					$Idata['flex_fees']		= 100;
					$Idata['fees']		 	= 0;
					$Idata['created'] 		= date('Y-m-d H:i:s');
					$p_service_id = DB::table('crm_table_services')->insertGetId($Idata);
				}
			}
			if($type == 'remove'){
				DB::table('crm_table_services')->whereIn('user_id', $this->groupUserId)->where('heading_id',$heading_id)->where('service_id', $service_id)->delete();
			}

		}else{
			$proposal_id 	= $postData['proposal_id'];
			$p_table_id 	= $postData['p_table_id'];			

			if($type == 'add'){
				$details = DB::table('crm_proposal_services')->whereIn('user_id', $this->groupUserId)->where('p_table_id',$p_table_id)->where('service_id', $service_id)->first();
				if(!isset($details) && empty($details)){
					$Idata['user_id'] 		= $this->user_id;
					$Idata['service_id']	= $service_id;
					$Idata['p_table_id'] 	= $p_table_id;
					$Idata['billing_freq']	= 'Monthly';
					$Idata['tax_rate']		= 1;
					$Idata['flex_fees']		= 100;
					$Idata['fees']		 	= ProposalService::getPriceByServiceId($service_id);
					$Idata['created'] 		= date('Y-m-d H:i:s');
					$p_service_id = DB::table('crm_proposal_services')->insertGetId($Idata);
				}
			}
			if($type == 'remove'){
				DB::table('crm_proposal_services')->whereIn('user_id', $this->groupUserId)->where('p_table_id',$p_table_id)->where('service_id', $service_id)->delete();
			}
		}

		return 1;
	}*/

	public function saveNewTableToProposal( $postData )
	{
		$data = array();
		$settingsPId = Common::getSettingsProposalId();

		$heading_id 	= $postData['heading_id'];
		$proposal_id 	= $postData['proposal_id'];
		$type 				= $postData['type'];
		$is_show 			= $postData['is_show'];
		if($type == 'add'){
			$details = CrmProposalTable::whereIn('user_id', $this->groupUserId)->where('heading_id', $heading_id)->where('proposal_id', $proposal_id)->first();
			$Idata['user_id'] 		= $this->user_id;
			$Idata['heading_id'] 	= $heading_id;
			$Idata['proposal_id']	= $proposal_id;
			$Idata['package_type']	= CrmTableHeading::getPackageTypeByHeadingId($heading_id);
			if($is_show == 'O'){
				$Idata['show_other']= 'Y';
				$Idata['show_group']= 'N';
				$Idata['is_show'] 	= 'O';
			}else{
				$Idata['show_group']= 'Y';
				$Idata['is_show'] 	= 'G';
			}
			//echo "<pre>";print_r($Idata);die;
			if(!isset($details) && empty($details)){
				$Idata['created'] 	= date('Y-m-d H:i:s');
				// ============= Add service and activity from settings proposalid ================
				$dls1 = CrmProposalTable::whereIn('user_id', $this->groupUserId)->where('heading_id', $heading_id)->where('proposal_id', $settingsPId)->first();
				if(isset($dls1) && count($dls1) >0){
					CrmProposalTable::copyProposalTableData($Idata, $settingsPId);
				}else{
					CrmProposalTable::insertGetId($Idata);
				}
				//Common::last_query();die;
			}else{
				CrmProposalTable::where('id', $details->id)->update($Idata);
				//Common::last_query();
			}

			/* ================= crm_proposal_grand_totals ================ */
			$d1 = CrmProposalGrandTotal::whereIn('user_id', $this->groupUserId)->where('heading_id', $heading_id)->where('proposal_id', $proposal_id)->first();
			if(!isset($d1) && empty($d1)){
				CrmProposalGrandTotal::insertGetId($Idata);
			}else{
				CrmProposalGrandTotal::where('grand_total_id', $d1->grand_total_id)->update($Idata);
			}
		}
		if($type == 'remove'){
			if($is_show == 'O'){
				CrmProposalTable::removeProposalTableData($heading_id, $proposal_id);

			}else{
				$Idata1['show_group']	= 'N';
				$Idata1['is_show'] 		= 'O';
				CrmProposalTable::whereIn('user_id', $this->groupUserId)->where('heading_id', $heading_id)->where('proposal_id', $proposal_id)->update($Idata1);
			}
			//Common::last_query();
		}
		return $proposal_id;
	}

	public function saveNewContactFromProposal( $postData )
	{
		$data = array();
		$contact_type 		= $postData['contact_type'];

		$insrtData['user_id'] 			= $this->user_id;
		$insrtData['client_id'] 		= $postData['company_name'];
		$insrtData['contact_type'] 	= $postData['contactTypeSec'];
		$insrtData['contact_title'] = $postData['contact_title'];
		$insrtData['contact_fname'] = $postData['contact_fname'];
		$insrtData['contact_mname'] = $postData['contact_mname'];
		$insrtData['contact_lname'] = $postData['contact_lname'];
		$insrtData['telephone'] 		= $postData['contact_telephone'];
		$insrtData['mobile'] 				= $postData['contact_mobile'];
		$insrtData['email'] 				= $postData['contact_email'];
		$insrtData['address_id'] 		= $postData['address_id'];
		$insrtData['added_from'] 		= $postData['savedFromA'];

		if($contact_type == 3){
			$insrtData['website'] 	= $postData['positionText'];
			$contact_id 	= ContactAddress::insertGetId($insrtData);
			$contact_type = 'C';
		}else{
			$date_add['type'] 		= ($contact_type == 1)?'ind':'non';
			$date_add['user_id'] 	= $this->user_id;
			$client_id 			= Client::insertGetId($date_add);
			$client_name 		= $this->insertIndividualClient($postData, $client_id);

			$contact_id 		= $client_id;
			$contact_type 	= 'R';
		}

		$data['contact_id'] 	= $contact_id;
		$data['contact_type'] = $contact_type;
		$data['contact_name'] = $insrtData['contact_title'].' '.$insrtData['contact_fname'].' '.$insrtData['contact_mname'].' '.$insrtData['contact_lname'];

		return $data;
	}

	public function insertIndividualClient($postData, $client_id)
	{
		$arrData = array();
		$user_id = $this->user_id;
		$relation_client_id = $postData['company_name'];
		$relation_type 			= $postData['positionDrop'];

		$title 			= $postData['contact_title'];
		$fname 			= $postData['contact_fname'];
		$mname 			= $postData['contact_mname'];
		$lname 			= $postData['contact_lname'];
		$telephone 	= $postData['contact_telephone'];
		$mobile 		= $postData['contact_mobile'];
		$email 			= $postData['contact_email'];
		$address_id = $postData['address_id'];

		$client_name = "";
		if (isset($title) && $title != "") {
			$client_name .= $title . " ";
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,'title',$title);
		}
		if (isset($fname) && $fname != "") {
			$client_name .= $fname . " ";
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1,'fname',$fname);
		}
		if (isset($mname) && $mname != "") {
			$client_name .= $mname . " ";
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id,1,'mname', $mname);
		}
		if (isset($lname) && $lname != "") {
			$client_name .= $lname;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'lname', $lname);
		}
		$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'client_name', trim($client_name));

		if (isset($telephone) && $telephone != "") {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'res_telephone', $telephone);
		}
		if (isset($mobile) && $mobile != "") {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'res_mobile', $mobile);
		}
		if (isset($email) && $email != "") {
			$arrData[] =App::make('HomeController')->save_client($user_id,$client_id,3,'res_email',$email);
		}
		if (isset($address_id) && $address_id != "") {
			$arrData[] = App::make('HomeController')->save_client($user_id,$client_id,3,'res_address',$address_id);
		}

		if(!empty($arrData)){
			StepsFieldsClient::insert($arrData);
		}

		/* ============= RELATIONSHIP SECTION START ============== */
		$rel_client = ClientRelationship::where("client_id", "=", $relation_client_id)->where("appointment_with", "=", $client_id)->first();
		if (isset($rel_client) && count($rel_client) > 0) {
			$rel_data['relationship_type_id'] = $relation_type;
			ClientRelationship::where("client_id", "=", $relation_client_id)->where("appointment_with",
				"=", $client_id)->update($rel_data);
		} else {
			$rel_data['client_id'] 				= $relation_client_id;
			$rel_data['appointment_with'] 		= $client_id;
			$rel_data['relationship_type_id'] 	= $relation_type;
			ClientRelationship::insert($rel_data);
		}
		// ############# RELATIONSHIP SECTION END ############## //

		return $client_name;
	}


	public function saveNewProposal( $postData )
	{	//echo "<pre>";print_r($postData);die;
		$data = array();
		$data['user_id'] 		= $this->user_id;
		$data['proposalID'] 	= $postData[8];
		$data['contact_type'] 	= $postData[0];
		$data['prospect_id'] 	= $postData[1];
		$data['client_id'] 		= $postData[1];
		$data['contact_id'] 	= $postData[2];//propContactDrop
		$data['contact_name'] 	= $postData[9];
		$data['validity'] 		= $postData[3];
		$data['proposal_title'] = $postData[4];
		$data['start_date'] 	= date('Y-m-d', strtotime( $postData[5] ));
		$data['end_date'] 		= date('Y-m-d', strtotime( $postData[6] ));
		$data['save_type'] 		= ($postData[7] == 'DC')?'D':$postData[7];
		$data['created']		= date('Y-m-d H:i:s');
		//echo "<pre>";print_r($data);die;
		$from_page 	= $postData[11];
		if($postData[10] != '0' && $from_page == 'proposal'){
			CrmProposal::where('crm_proposal_id', '=', $postData[10])->update($data);
			$last_id = $postData[10];
			//CrmProposalHistory::insertProposalHistory($data);
		}else{
			$last_id = CrmProposal::checkProposalByProposalId( $data['proposalID'] );
			if($last_id == 0){
				$data['is_signed'] 		= 'N';
				$data['is_rejected'] 	= time();
				$last_id = CrmProposal::insertGetId($data);
				CrmProposalId::insertProposalId($data['proposalID']);
				//CrmProposalHistory::insertProposalHistory($data);
			}else{
				CrmProposal::where('crm_proposal_id', '=', $postData[10])->update($data);
				$last_id = $postData[10];
				//CrmProposalHistory::insertProposalHistory($data);
			}
		}
		$data['crm_proposal_id'] = $last_id;
		
		if($postData[10] != '0' && $from_page == 'prospect'){
			$updtC['crm_proposal_id'] = $last_id;
			CrmLead::where('leads_id', '=', $postData[10])->update($updtC);
		}
		return $data;
	}

	public function save_new_proposal( $postData )
	{	
		$data = array();
		$data['user_id'] 				= $this->user_id;
		$data['proposalID'] 		= $postData['ProposalID'];
		$data['contact_type'] 	= $postData['contact_type'];
		$data['prospect_id'] 		= $postData['prospect_id'];
		$data['client_id'] 			= $postData['prospect_id'];
		$data['contact_id'] 		= $postData['contact_id'];//propContactDrop
		$data['contact_name'] 	= $postData['contact_name'];
		$data['validity'] 			= $postData['validity'];
		$data['proposal_title'] = $postData['proposal_title'];
		$data['start_date'] 		= date('Y-m-d', strtotime( $postData['start_date'] ));
		$data['end_date'] 			= date('Y-m-d', strtotime( $postData['end_date'] ));
		$data['count_down'] 		= CrmProposal::getCountDown($postData['end_date']);
		$data['template_name'] 	= isset($postData['TemplateName'])?$postData['TemplateName']:'';
		$data['created']				= date('Y-m-d H:i:s');

		if($data['contact_type'] == 'template'){
			$data['save_type'] 	= 'T';
		}else{
			$crm_proposal_id = CrmProposal::getIdByProposalId($data['proposalID']);
			$save_type = CrmProposal::getSaveTypeById($crm_proposal_id);
			$data['save_type'] = $save_type;
			if($save_type != 'A' && $save_type != 'MA' && $save_type != 'L' && $save_type != 'ML'){
				$data['save_type'] 	= ($postData['save_type'] == 'DC')?'D':$postData['save_type'];
			}
		}

		//echo "<pre>";print_r($data);die;
		$from_page 	= $postData['from_page'];
		if($postData['ExtProspectId'] != '0' && $from_page == 'proposal'){
			CrmProposal::where('crm_proposal_id', $postData['ExtProspectId'])->update($data);
			$last_id = $postData['ExtProspectId'];
		}else{
			$last_id = CrmProposal::checkProposalByProposalId( $data['proposalID'] );
			if($last_id == 0){
				$data['is_signed'] 		= 'N';
				$data['is_rejected'] 	= time();
				$last_id = CrmProposal::insertGetId($data);//Common::last_query();die;
				CrmProposalId::insertProposalId($data['proposalID']);//Common::last_query();die;
			}else{
				CrmProposal::where('crm_proposal_id', $postData['ExtProspectId'])->update($data);
				$last_id = $postData['ExtProspectId'];
			}
		}
		$data['crm_proposal_id'] = $last_id;
		if($data['save_type'] == 'T'){
			CrmProposalHistory::insertProposalHistory($data);
		}
		
		if($postData['ExtProspectId'] != '0' && $from_page == 'prospect'){
			$updtC['crm_proposal_id'] 	= CrmProposal::getIdByProposalId($data['proposalID']);
			$updtC['proposal_title'] 	= $postData['proposal_title'];
			$updtC['quoted_value'] 		= CrmProposalTable::getGrossFeesByProposalId($data['proposalID']);
			CrmLead::where('leads_id', $postData['ExtProspectId'])->update($updtC);
		}

		$terms = CrmProposalTerm::getDetailsByProposalId( $data['proposalID'], $this->groupUserId );
		$termsdata['terms'] 	= isset($postData['termsText'])?$postData['termsText']:'';
		$termsdata['modified'] 	= date('Y-m-d H:i:s');
		if(isset($terms) && count($terms) >0){
			CrmProposalTerm::where('id', $terms['id'])->update($termsdata);
		}else{
			$termsdata['user_id'] 		= $this->user_id;
			$termsdata['proposal_id'] = $postData['ProposalID'];
			$termsdata['created'] 		= date('Y-m-d H:i:s');
			CrmProposalTerm::insert($termsdata);//Common::last_query();die;
		}
 

		// =============== renewal manage table data update start ================ //
		$annual_fee = CrmProposalTable::getRecurAmntByProposalId($data['proposalID'],$this->groupUserId);
		$rmdara['startdate'] 	= date('Y-m-d', strtotime( $postData['start_date'] ));
		$rmdara['enddate'] 		= date('Y-m-d', strtotime( $postData['end_date'] ));
		$rmdara['annual_fee'] 	= $annual_fee;
		RenewalsManage::where('crm_proposal_id', $last_id)->update($rmdara);
		// =============== renewal manage table data update end ================ //

		return $data;
	}

	public function getContactByType($postData)
	{
		$data = array();
		$cont_type 	= explode('_', $postData['cont_type']);
		$item_id 	= $postData['item_id'];

		if($cont_type[0] == 'p'){
			$data[0]['contact_id'] 	= $item_id;
			$data[0]['contact_name'] 	= CrmLead::getContactNameByLeadsId($item_id);
		}else if($cont_type[0] == 'c'){
			$data = ContactAddress::getAllContactListByClientId($item_id);
		}
		return $data;
	}

	public function getProspectByType($postData)
	{
		$data = array();
		$cont_type = explode('_', $postData['cont_type']);
		if($cont_type[0] == 'p'){
			$data = CrmLead::getAllOpportunityByClientType($cont_type[1]);
		}else if($cont_type[0] == 'c'){
			$data = Client::getAllClientsByType($cont_type[1], '');
		}
		return $data;
	}

	/*public function proposal_preview($crm_proposal_id, $page_from='email', $is_rejected='')
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
		$data['terms'] 			= TermsConditionFile::getTermsAndConditionsPreview($groupUserId);
		$data['coverLetter'] 	= CrmProposalCoverletter::getDetailsPreview($proposal_id, $groupUserId);	
		$data['content'] 		= CrmProposalTable::getDetailsPreview( $proposal_id, $groupUserId );
		$data['grandTotals'] 	= CrmProposalTable::getGrandDetailsPreview( $proposal_id, $groupUserId );
		$data['comments'] 		= CrmProposalComment::getDetailsByCrmProposalId($crm_proposal_id);

		$data['signedName'] 	= CrmProposal::getSenderByCrmProposalId($crm_proposal_id);
		$data['signedData'] 	= CrmProposalSign::getDetailsByCrmProposalId($crm_proposal_id);
		

		if($page_from == 'email'){
			$details = CrmProposal::getProposalById( $crm_proposal_id );
			if(isset($details['is_rejected']) && $details['is_rejected'] != $is_rejected){
				return View::make('crm.proposal.reject_preview', $data);
			}else{
				$uPdata['save_type'] = 'V';
				CrmProposal::updateByCrmProposalId($uPdata, $crm_proposal_id);

				$uPdata['proposalID'] 	= $proposal_id;
				$uPdata['user_id'] 		= $user_id;
				CrmProposalHistory::insertProposalHistory($uPdata);
			}
		}
		//echo $proposal_id;die;
		//echo "<pre>";print_r($data['cover']);die;
		return View::make('crm.proposal.proposal_preview', $data);
	}

	public function getCoverDetails($proposal_id, $groupUserId)
	{
		$data['practice'] 	= PracticeDetail::getPracticeDetails($groupUserId);
		$data['proposal'] 	= CrmProposal::getDetailsByProposalId($proposal_id, $groupUserId);
		return $data;
	}*/

	public function delete_terms($id)
	{
		TermsConditionFile::where('tc_file_id', $id)->delete();
		return Redirect::to('/crm/attachment');
	}

	


}	