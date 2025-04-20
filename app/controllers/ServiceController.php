<?php

class ServiceController extends BaseController {
	public $timestamps = false;

	public function service($is_archive = 'hide')
	{
		$details = array();
		$data['content_header'] = 'Services';
		$owner_id 				= 'all';
		$data['goto_url'] 		= '/crm';
		$data['page_open'] 		= 'service';
        $data['tab_no'] 		= 'proposal';
        $data['all_count'] 		= 0;
        $data['heading']    	= "PROPOSALS";
        $data['title']      	= "PROPOSALS";
        $data['selected_page']  = "service";
        $data['owner_id'] 		= $owner_id;
        $data['encode_owner_id']= $owner_id;
        $data['is_archive'] 	= $is_archive;


		$data['TaxRates'] 		= TaxRate::getAllDetails('C');
		$data['ServicesProp'] 	= ProposalService::getAllDetails();
		//$data['ServicesTask'] 	= $this->getDefaultServiceDetails();
		$ServicesTask 			= $this->getActivityByServiceIds();
		$data['ServicesTask'] 	= Common::getArchiveArray($ServicesTask, $is_archive);
		
		//echo "<pre>";print_r($data['ServicesTask']);die;
		return View::make('crm.index', $data);
	}

	public function getActivityByServiceIds()
	{
		$data = array();

		//$services 	= Service::getAllServiceByType('org');
		$services 	= Service::getAllServices();
		if(isset($services) && count($services) > 0){
			foreach ($services as $key => $s) {
				$details = ProposalActivity::getDataByServiceId( $s['service_id'] );
				$service_name = ProposalService::getNameByServiceId( $s['service_id'] );
				if(empty($service_name)){
					$service_name = Service::getNameServiceId( $s['service_id'] );
				}

				$data[$key] 					= $s;
				$data[$key]['service_name'] 	= $service_name;
				$data[$key]['price'] 			= ProposalService::getPriceByServiceId($s['service_id']);
				$data[$key]['tax_rate'] 		= ProposalService::getTaxRateByServiceId($s['service_id']);
				$data[$key]['activities'] 		= $details;
			}
		}
		//echo "<pre>";print_r($data);die;
		return $data;
	}

	public function getDefaultServiceDetails()
	{
		$data = array();
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

		$services 	= Service::getAllServiceByType('org');
		if(isset($services) && count($services) > 0){
			foreach ($services as $key => $s) {
				$checkData = ProposalService::getDetailsByServiceId( $s['service_id'] );
				if( isset($checkData) && count($checkData) >0 ){
					$data[] = $checkData;
					//$data[]['activities'] = ProposalActivity::getDataByServiceAndPropServId('0', $checkData[$key]['prop_serv_id'], 'P');
				}else{
					$data[$key]['service_id'] 		= $s['service_id'];
					$data[$key]['service_name'] 	= Service::getNameServiceId( $s['service_id'] );
					$data[$key]['price'] 			= '';
					$data[$key]['tax_rate'] 		= '';
					//$data[$key]['activities'] = ProposalActivity::getDataByServiceAndPropServId($s['service_id'], '0', 'T');
				}
				$data[$key]['activities'] = ProposalActivity::getDataByServiceAndPropServId( $s['service_id'], '0', 'T');
			}
		}
		//echo "<pre>";print_r($data);die;
		return $data;
	}

	public function save_tax_action()
	{
		$action 		= Input::get('action');	
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		if($action == 'add_tax'){
			$data['name'] 		= Input::get('name');	
			$data['user_id'] 	= $user_id;	
			$data['rate'] 		= Input::get('tax_rate');
			$data['status'] 	= 'N';
			$data['used_for'] 	= 'C';
			$data['created'] 	= date('Y-m-d H:i:s');
			$last_id = TaxRate::insertGetId($data);
			echo $last_id;
		}else if($action == 'delete_tax'){
			$id = Input::get('id');
			$count = CrmProposalService::checkDataByTaxRate($id);
			if($count > 0){
				$data['message'] = 'exists';
			}else{
				$data['message'] = 'success';
				TaxRate::where('tax_rate_id', $id)->delete();
			}
			echo json_encode($data);
			exit;

		}else if($action == 'save_service'){
			$prop_serv_id 	= Input::get('prop_serv_id');
			$Servtype 		= Input::get('Servtype');
			$service_id 	= Input::get('service_id');
			$dbAction 		= Input::get('dbAction');

			$data['service_name'] 	= Input::get('service_name');	
			$data['user_id'] 		= $user_id;	
			$data['tax_rate'] 		= Input::get('tax_rate');
			$data['price'] 			= Input::get('price');

			if($dbAction == 'add'){
				$data['created'] 	= date('Y-m-d H:i:s');
				$srvData['user_id'] 		= $user_id;
				$srvData['client_type'] 	= 'org';
				$srvData['service_name'] 	= Input::get('service_name');	
				$srvData['status'] 			= 'new';
				$srvData['added_from']  	= 'proposal_settings';	
				$data['service_id'] = Service::insertGetId($srvData);
				$last_id = ProposalService::insertGetId($data);
			}else{
				if($Servtype == 'P'){
					ProposalService::where('prop_serv_id', $prop_serv_id)->update($data);
					$last_id = $prop_serv_id;
				}else{
					$checkData = ProposalService::getDetailsByServiceId( $service_id );
					if( isset($checkData) && count($checkData) >0 ){
						ProposalService::whereIn('user_id',$groupUserId)->where("service_id", $service_id)->update($data);
						$last_id = $checkData['prop_serv_id'];
					}else{
						$data['service_id'] = $service_id;
						$data['created'] 	= date('Y-m-d H:i:s');
						$last_id 	= ProposalService::insertGetId($data);
					}
				}
			}
			
			$details = ProposalService::getDetailsById( $last_id );
			echo json_encode($details);
			exit;
		}else if($action == 'getServiceById'){
			$activities = array();
			$type 			= Input::get('type');
			$prop_serv_id 	= Input::get('prop_serv_id');
			$service_id 	= Input::get('service_id');
			$is_archive 	= Input::get('is_archive');

			if($type == 'P'){
				$details 	= ProposalService::getDetailsById($prop_serv_id);
			}else{
				$checkData = ProposalService::getDetailsByServiceId( $service_id );
				if( isset($checkData) && count($checkData) >0 ){
					$details = ProposalService::getDetailsById($checkData['prop_serv_id']);
				}else{
					$details['service_name'] = Service::getNameServiceId( $service_id );
					$details['price'] 		= '';
					$details['tax_rate'] 	= '';
				}
			}
			//$activities = ProposalActivity::getDataByServiceAndPropServId($service_id, $prop_serv_id, $type);
			$activities = ProposalActivity::getDataByServiceId($service_id);

			$servData['service'] 	= $details;

			/*$actDtls = array();
			if(isset($activities) && count($activities) >0){
				foreach ($activities as $k => $v) {
					if($is_archive == 'hide'){
						if($v['is_archive'] == 'N'){
							$actDtls[$k] = $v;
						}
					}else{
						$actDtls[$k] = $v;
					}
				}
			}*/
			$servData['activities'] = Common::getArchiveArray($activities, $is_archive);
			echo json_encode($servData);
			exit;
		}else if($action == 'delete_service'){
			$prop_serv_id 	= Input::get('id');
			ProposalService::where('prop_serv_id', $prop_serv_id)->delete();
			$details 		= $prop_serv_id;
			echo json_encode($details);
			exit;
		}else if($action == 'saveActivity'){
			$actvData['user_id']		= $user_id;
			$actvData['service_id'] 	= Input::get('service_id');
			$actvData['prop_serv_id'] 	= Input::get('prop_serv_id');
			$actvData['name'] 			= Input::get('name');
			$actvData['base_fee'] 		= Input::get('base_fee');
			$actvData['service_type'] 	= Input::get('type');
			$actvData['created'] 		= date('Y-m-d H:i:s');

			$actvData['activity_id']	= ProposalActivity::insertGetId($actvData);
			$details['activity'] 		= $actvData;

			echo json_encode($details);
			exit;
		}else if($action == 'deleteActivity'){
			$activity_id 	= Input::get('activity_id');
			$count = CrmProposalActivity::where('activity_id',$activity_id)->count();
			if($count <= 0){
				ProposalActivity::where('activity_id', $activity_id)->delete();
			}
			$details['count']		= $count;
			$details['activity_id']	= $activity_id;
			echo json_encode($details);
			exit;
		}else if($action == 'servicesForProposal'){
			$pop_type 	= Input::get('pop_type');
			$srvData 	= ProposalService::getAllProposalService();
			$details['servList']	= $srvData;
			echo json_encode($details);
			exit;
		}else if($action == 'addServiceHead'){
			$data 	= array();
			$service_id 	= Input::get('service_id');
			$service_name 	= Input::get('service_name');

			$data['service_name'] = $service_name;
			$details['service']	= $data;
			echo json_encode($details);
			exit;
		}else if($action == 'getTaxRatePopup'){
			$is_archive = Input::get('is_archive');
			$TaxRates 	= TaxRate::getAllDetails('C');
			$data['TaxRates'] = Common::getArchiveArray($TaxRates, $is_archive);
			echo View::make('crm.proposal.proposals.ajax_tax_rate_popup', $data);
			exit;
		}

	}

	public function servicesForProposal()
	{
		$data = array();
		$details = Service::getServiceIdAndNameByType('org');
		if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]["service_id"]      	= $value['service_id'];
                $data[$key]["service_name"]    	= $value['service_name'];
                $data[$key]["price"]    		= ProposalService::getPriceByServiceId($value['service_id']);
            }
        }

		return $data;
	}

	public function edit_product($product_id)
	{
		$data['editProduct'] = Product::find($product_id);

		$data['products'] = Product::all();
		$data['taxes'] = Tax::all();
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
        $data['tab_no'] = 6;
        $data['all_count'] = 0;
        $data['heading']    = "PROPOSALS";
        $data['title']      = "PROPOSALS";

		return View::make('crm.index', $data);

	}

	public function delete_product($product_id)
	{
		Product::where('id', $product_id)->delete();
		Session::flash('info_msg', 'Information has been deleted succesfully.');
		return Redirect::to('/crm/product');
	}	

	public function check_product($productId)
	{
		return '';

		// $products = Product::where('tax_id', $taxId)->get(['id']);
		// $data = '';
		// foreach($products as $product){
		// 	$data.=$product->id.", ";
		// }

		// if($data != ''){
		// 	return "This tax is already in use. To delete this tax you have to delete ". substr($data, 0, -2) ." Product first";
		// } else {
		// 	return $data;
		// }
	}		
}	