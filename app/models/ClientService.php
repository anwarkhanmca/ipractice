<?php
class ClientService  extends Eloquent{
	
	public $timestamps = false;
	public static function getServicesByClient($client_id)
	{
		$data = array();
		$service = DB::table('client_services as cs')->where("cs.client_id", "=", $client_id)
            ->join('services as s', 'cs.service_id', '=', 's.service_id')
            ->select('cs.*', 's.service_name')->get();
        if(isset($service) && count($service) >0 )
        {
        	foreach ($service as $key => $row) {
        		$data[$key]['client_service_id'] 	= $row->client_service_id;
        		$data[$key]['client_id'] 			= $row->client_id;
        		$data[$key]['service_id'] 			= $row->service_id;
        		$data[$key]['service_name'] 		= $row->service_name;
        	}
        }
        return $data;
	}

  public static function getClientIdByServiceId($service_id)
  {
      $data = array();
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];

      //$service = ClientService::where("service_id","=",$service_id)->select('client_id')->get();
      $service = DB::table('client_services as cs')
          ->where("cs.service_id", $service_id)
          ->join('clients as c', 'c.client_id', '=', 'cs.client_id')
          ->whereIn("c.user_id", $groupUserId)
          ->select('cs.client_id')
          ->get();

      if(isset($service) && count($service) >0 )
      {
          foreach ($service as $key => $row) {
              $data[$key] = $row->client_id;
          }
      }
      return $data;
  }

  public static function getServiceIdByClientId($client_id)
  {
      $service_id = "";
      $service = ClientService::where("client_id","=",$client_id)->select('service_id')->first();
      if(isset($service['service_id']) && $service['service_id'] != "" )
      {
          $service_id = $service['service_id'];
      }
      return $service_id;
  }

  public static function checkServiceIdByClientId($client_id, $service_id)
  {//echo $service_id;die;
      $serviceId = "";
      $service = ClientService::where("client_id", $client_id)->where("service_id", $service_id)->select('service_id')->first();
      //echo Common::last_query();
      if(isset($service['service_id']) && $service['service_id'] != "" )
      {
          $serviceId = $service['service_id'];
      }
      return $serviceId;
  }

  public static function checkedAllServices($client_id, $client_type)
  {
    ClientService::where("client_id", $client_id)->delete();
    $other_services = Service::getAllServiceByType( $client_type );
    if (isset($other_services) && count($other_services) > 0) {
      $relData = array();
      foreach ($other_services as $service_row) {
        $servData['client_id'] = $client_id;
        $servData['service_id'] = $service_row['service_id'];
        ClientService::insert($servData);
      }
    }
  }

  public static function clientAllocationLists($sendData)
  {  
    $start        = $sendData['start'];
    $limit        = $sendData['limit'];
    $sorting      = $sendData['sorting'];
    $search       = $sendData['search'];
    $type         = $sendData['client_type'];
    $service_id   = $sendData['service_id'];
    //$service_id   = 10;
    //echo $staff_id;die;
    $data =  $od  = array();

    $sort         = explode(' ', $sorting);
    $groupUserId  = Client::getSessionUserIds();

    $header_sort  = '';
    $where = "where c.is_deleted='N' and c.is_archive='N' and c.is_relation_add='N' and c.user_id IN ('".implode(',', $groupUserId)."') and c.type='".$type."' AND cs.service_id ='".$service_id."' AND cs.service_id > 0 ";

    $client_name          = StepsFieldsClient::clientNameQuery();
    $business_type        = StepsFieldsClient::businessTypeQuery();

    if($sort[0] == 'client_name'){
      $header_sort = " order by ".$client_name.' '.$sort[1];
    }

    if(isset($search) && $search != ''){
      $where .= " AND (";
      if($type == 'org'){
        $where .= $business_type." LIKE '%".$search."%' OR ";
      }
      $where .= $client_name." LIKE '%".$search."%') ";
    }

    $select = "select c.client_id, c.type, cs.service_id, 
      ".$client_name." as client_name,
      ".$business_type." as business_type
    ";

    $query = " FROM clients c JOIN client_services cs ON cs.client_id=c.client_id ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

    //============== total count section ==============
    $total_qry    = "select count(c.client_id) as count ".$query;
    $totalVal     = DB::select($total_qry);
    $total        = json_decode(json_encode($totalVal), true);

    $data['details']      = json_decode(json_encode($od), true);
    $data['TotalRecord']  = $total[0]['count'];

    return $data;

  }
	
	

}
