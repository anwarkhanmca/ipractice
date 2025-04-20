<?php
class DataStore extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
	{
		$data = array();
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$value = 0;
		$client_details = DataStore::whereIn('user_id', $groupUserId)->orderBy('store_id', 'DESC')->get();
		//$client_details = DataStore::get();;
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $value) {
				if($value->client_type == 'staff'){
					$name = User::getStaffNameById($value->user_id);
				}else{
					$name = Client::getClientNameByClientId($value->client_id);
				}

				$data[$key]['store_id'] 		= $value->store_id;
				$data[$key]['user_id'] 			= $value->user_id;
				$data[$key]['client_id'] 		= $value->client_id;
				$data[$key]['client_type'] 	= $value->client_type;
				$data[$key]['client_name'] 	= $name;
				$data[$key]['is_read'] 			= $value->is_read;
				$data[$key]['date'] 				= date('d-m-Y', strtotime($value->created));
				$data[$key]['time'] 				= date('H:i a', strtotime($value->created));
				$data[$key]['created'] 			= $value->created;
				$data[$key]['details'] 			= ClientDataStore::getDetailsByStoreId($value->store_id);
			}
		}
		return $data;
	}

	public static function getNotificationDetails()
	{ 
		$data = array();
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId  = $session['group_users'];
		$user_type  	= $session['user_type'];
		$client_id  	= $session['client_id'];
		$notifications = NotificationManage::getNotificationView();

		if($user_type == 'C'){
			$client_details = DataStore::whereIn('user_id', $groupUserId)->where('client_type', '!=', 'tasks')->where('client_id',$client_id)->orderBy('store_id', 'DESC')->get();
		}else{
			/*$dtls = UserAccess::where('user_id', $user_id)->where('access_id', 4)->first();
			if(isset($dtls->access_id) && $dtls->access_id != ''){
				$client_details = DataStore::whereIn('user_id', $groupUserId)->where('client_type', '!=', 'tasks')->where('added_from', '!=', 'main_portal')->orderBy('store_id', 'DESC')->get();
			}else{
				$client_details = DataStore::whereIn('user_id', $groupUserId)->where('client_type', '!=', 'tasks')->where('added_from', '!=', 'main_portal')->where('client_type','!=', 'staff')->orderBy('store_id', 'DESC')->get();
			}*/

			$where = " WHERE user_id = '".$user_id."' AND is_read='N' ";
			if(in_array('staff', $notifications)){
				$where .= " AND client_type != 'staff'";
			}else{
				$where .= " AND client_type = 'staff'";
			}
			if(in_array('client', $notifications)){
				$where .= " AND client_type != 'org' AND client_type != 'ind' ";
			}else{
				$where .= " || (client_type = 'org' || client_type = 'ind') ";
			}

			$select = "select * FROM data_stores ".$where." order by store_id desc ";
			//echo $select;//die;
			$client_details = DB::select( DB::raw( $select ) );
		}

		$value = 0;
		//Common::last_query();die;
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $value) {
				if($value->client_type == 'staff'){
					$name = User::getStaffNameById($value->user_id);
				}else{
					$name = Client::getClientNameByClientId($value->client_id);
				}

				$data[$key]['store_id'] 		= $value->store_id;
				$data[$key]['user_id'] 			= $value->user_id;
				$data[$key]['client_id'] 		= $value->client_id;
				$data[$key]['client_type'] 	= $value->client_type;
				$data[$key]['client_name'] 	= $name;
				$data[$key]['is_read'] 			= $value->is_read;
				$data[$key]['date'] 				= date('d-m-Y', strtotime($value->created));
				$data[$key]['time'] 				= date('H:i a', strtotime($value->created));
				$data[$key]['created'] 			= $value->created;
				$data[$key]['details'] 			= ClientDataStore::getDetailsByStoreId($value->store_id);
			}
		}
		return $data;
	}

	public static function getDetailsByStoreId($store_id)
	{
		$data = array();
		$session 			= Session::get('admin_details');
		$user_id 			= $session['id'];
		$groupUserId  = $session['group_users'];

		$details 	= DataStore::where('store_id', $store_id)->first();
		$data 		= DataStore::getSingleArray($details);
		
		return $data;
	}

	public static function getUnreadCount()
	{
		$session 		= Session::get('admin_details');
		$groupUserId    = $session['group_users'];

		$count = DataStore::whereIn('user_id', $groupUserId)->where('is_read', 'N')->count();
		return $count;
	}

	public static function getUnreadNotificationCount()
	{
		$session 			= Session::get('admin_details');
		
		$user_type  	= $session['user_type'];
		$client_id  	= $session['client_id'];
		$user_id  		= $session['id'];
		
		$notifications = NotificationManage::getNotificationView();
		//echo "<pre>";print_r($notifications);die;

		if($user_type == 'C'){
			$groupUserId  = $session['group_users'];
			$count = DataStore::whereIn('user_id',$groupUserId)->where('client_type','!=','tasks')->where('is_read','N')->where('client_id',$client_id)->count();
		}else{
			//$groupUserId 	= Client::getSessionUserIds();
			$where = " WHERE user_id = '".$user_id."' AND is_read='N' ";
			if(in_array('staff', $notifications)){
				$where .= " AND client_type != 'staff'";
			}else{
				$where .= " AND client_type = 'staff'";
			}
			if(in_array('client', $notifications)){
				$where .= " AND client_type != 'org' AND client_type != 'ind' ";
			}else{
				$where .= " || (client_type = 'org' || client_type = 'ind') ";
			}

			$select = "select count(*) as count FROM data_stores ".$where;
			//echo $select;//die;
			$details = DB::select( DB::raw( $select ) );
			$count = $details[0]->count;
			//echo $count;
			//echo "<pre>";print_r($details);die;

			/*$count = DataStore::whereIn('user_id', $groupUserId)->where('client_type', '!=', 'tasks')->where('added_from','!=','main_portal')->where('is_read','N')->where('client_type','!=','staff')->count();
			$dtls = UserAccess::where('user_id', $user_id)->where('access_id', 4)->first();
			if(isset($dtls->access_id) && $dtls->access_id != ''){
				$count1 = DataStore::whereIn('user_id', $groupUserId)->where('client_type', '!=', 'tasks')->where('added_from', '!=', 'main_portal')->where('is_read', 'N')->where('client_type', 'staff')->count();
				$count = $count + $count1;
			}*/
			
		}
		//Common::last_query();die;
		return $count;
	}

	public static function getSingleArray($value)
	{
		$data = array();
		if(isset($value) && count($value) >0){
			if($value->client_type == 'staff'){
				$client_name = User::getStaffNameById($value->user_id);
			}else{
				$client_name = Client::getClientNameByClientId($value->client_id);
			}
			
			$data['store_id'] 		= $value->store_id;
			$data['user_id'] 			= $value->user_id;
			$data['client_id'] 		= $value->client_id;
			$data['client_type'] 	= $value->client_type;
			$data['client_name'] 	= ucwords(strtolower($client_name));
			$data['is_read'] 			= $value->is_read;
			$data['date'] 				= date('d-m-Y', strtotime($value->created));
			$data['time'] 				= date('H:i a', strtotime($value->created));
			$data['created'] 			= $value->created;
			$data['description'] 	= ClientDataStore::getDetailsByStoreId($value->store_id);
		}
		return $data;
	}

	public static function actHstryLists($sendData)
  {  
    $start        = $sendData['start'];
    $limit        = $sendData['limit'];
    $sorting      = $sendData['sorting'];
    $search       = $sendData['search'];
    $client_id    = $sendData['client_id'];
    $data =  $od  = array();

    $sort         = explode(' ', $sorting);
    $groupUserId  = Client::getSessionUserIds();

    $header_sort  = '';
    $where = " WHERE ds.user_id IN (".implode(',', $groupUserId).") AND (ds.client_type='tasks' || ds.client_type='ind' || ds.client_type='org' || ds.client_type='files') AND ds.client_id='".$client_id."' ";

    $staff_name   = " CONCAT(u.fname, ' ', u.lname) ";
    $date_time   	= " DATE_FORMAT(ds.created, '%d-%m-%Y %H:%i') ";

    if($sort[0] == 'staff_name'){
      $header_sort = " order by ".$staff_name.' '.$sort[1];
    }else if($sort[0] == 'job_name'){
      $header_sort = " order by ds.job_name ".$sort[1];
    }else if($sort[0] == 'client_type'){
      $header_sort = " order by ds.client_type ".$sort[1];
    }else if($sort[0] == 'client_name'){
      $header_sort = " order by ds.client_name ".$sort[1];
    }else if($sort[0] == 'date_time'){
      $header_sort = " order by ds.store_id ".$sort[1];
    }

    if(isset($search) && $search != ''){
      $where .= " AND (";
      $where .= $date_time." LIKE '%".$search."%' OR ";
      $where .= " ds.client_type LIKE '%".$search."%' OR ";
      $where .= " ds.client_name LIKE '%".$search."%' OR ";
      $where .= " ds.job_name LIKE '%".$search."%' OR ";
      $where .= $staff_name." LIKE '%".$search."%') ";
    }

    $select = "select ds.store_id, ds.client_type, ds.client_id, 
    	ds.client_name, ds.job_name, ds.notes, ds.added_from,
      ".$staff_name." as staff_name,
      ".$date_time." as date_time
    ";

    $query = " FROM data_stores ds left join users u ON u.user_id = ds.user_id ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

    //============== total count section ==============
    $total_qry    = "select count(ds.store_id) as count ".$query;
    $totalVal     = DB::select($total_qry);
    $total        = json_decode(json_encode($totalVal), true);

    $data['details']      = json_decode(json_encode($od), true);
    $data['TotalRecord']  = $total[0]['count'];

    return $data;

  }



}
