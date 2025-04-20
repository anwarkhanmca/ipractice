<?php
class ProposalService extends Eloquent {
	public $timestamps = false;
	public static function getAllDetails()
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $details = ProposalService::whereIn('user_id', $groupUserId)->get();
    //Common::last_query();die;
    //print_r($session);die;
    return ProposalService::getArray($details);
	}

	public static function getProposalServices()
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = ProposalService::whereIn('user_id', $groupUserId)->where('service_id', '=', 0)->get();
    //Common::last_query();die;
    //print_r($session);die;
    return ProposalService::getArray($details);
	}

	public static function getDetailsById( $prop_serv_id )
	{
    $details = ProposalService::where('prop_serv_id', $prop_serv_id)->first();
    return ProposalService::getSingleArray($details);
	}

	public static function getTaxRateByServiceId( $service_id )
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$tax_rate = '';
    $details = ProposalService::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->select('tax_rate')->first();
    if(isset($details->tax_rate) && $details->tax_rate != ''){
    	$tax_rate = $details->tax_rate;
    }
    //Common::last_query();
    return TaxRate::getTaxPercentById($tax_rate);
	}

	public static function getTaxRateIdByServiceId( $service_id )
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$tax_rate = '';
    $details = ProposalService::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->select('tax_rate')->first();
    if(isset($details->tax_rate) && $details->tax_rate != ''){
    	$tax_rate = $details->tax_rate;
    }
    return $tax_rate;
	}

	public static function getNameByServiceId( $service_id )
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$service_name = '';
    $details = ProposalService::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->select('service_name')->first();
    if(isset($details->service_name) && $details->service_name != ''){
    	$service_name = $details->service_name;
    }
    return $service_name;
	}

	public static function getPriceByServiceId( $service_id )
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$price = '';
    $details = ProposalService::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->select('price')->first();
    if(isset($details->price) && $details->price != ''){
    	$price = $details->price;
    }
    return $price;
	}

	public static function getDetailsByServiceId( $service_id )
	{
		$session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];
    
    $details = ProposalService::whereIn('user_id', $groupUserId)->where('service_id', $service_id)->first();
    return ProposalService::getSingleArray($details);
	}

	public static function getAllProposalService()
	{
		$data1 = array();
		$data2 = array();

		$services 	= Service::getServiceIdAndNameByType('org');
		if(isset($services) && count($services) > 0){
			foreach ($services as $key => $s) {
				$checkData = ProposalService::getDetailsByServiceId( $s['service_id'] );
				if( isset($checkData) && count($checkData) >0 ){
					$data1[] = $checkData;
				}else{
					$data1[$key]['service_id'] 		= $s['service_id'];
					$data1[$key]['service_name'] 	= Service::getNameServiceId( $s['service_id'] );
					$data1[$key]['price'] 			= '';
					$data1[$key]['tax_rate'] 		= '';
				}
			}
		}

		$data2 	= ProposalService::getProposalServices();
		$data 	= array_merge($data1, $data2);

		return $data;
	}

	public static function getSingleArray($details)
	{
		$data = array();
		if(isset($details) && count($details) >0){
			$data['prop_serv_id'] 	= $details->prop_serv_id;
			$data['service_id'] 	= $details->service_id;
			$data['user_id'] 		= $details->user_id;
			$data['service_name'] 	= $details->service_name;
			$data['price'] 			= $details->price;
			$data['tax_rate'] 		= $details->tax_rate;
			$data['tax_name'] 		= TaxRate::getTaxNameById( $details->tax_rate );
			$data['tax_percent'] 	= TaxRate::getTaxPercentById( $details->tax_rate );
			$data['created'] 		= $details->created;			
		}
		return $data;
	}

	public static function getArray($details)
	{
		$data = array();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['prop_serv_id'] = $value->prop_serv_id;
				$data[$key]['service_id'] 	= $value->service_id;
				$data[$key]['user_id'] 		= $value->user_id;
				$data[$key]['service_name'] = $value->service_name;
				$data[$key]['price'] 		= $value->price;
				$data[$key]['tax_rate'] 	= $value->tax_rate;
				$data[$key]['tax_name'] 	= TaxRate::getTaxNameById( $value->tax_rate );
				$data[$key]['tax_percent'] 	= TaxRate::getTaxPercentById( $value->tax_rate );
				$data[$key]['created'] 		= $value->created;
				$data[$key]['activities'] 	= ProposalActivity::getDataByServiceAndPropServId( '0', $value->prop_serv_id, 'P');
			}
			
		}
		return $data;
	}


	



}
