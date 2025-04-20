<?php
class ClientListAllocation extends Eloquent {

	public $timestamps = false;
	public static function getAllocatedStaff($client_id, $service_id)
    {
    	$client_array = array();
		$client_details = ClientListAllocation::where("client_id", $client_id)->where("service_id", $service_id)->get();
		if(isset($client_details) && count($client_details) >0){
			$x=0;
			foreach ($client_details as $key => $details) {
				for($k=1;$k<=5;$k++){
					if(isset($details['staff_id'.$k]) && $details['staff_id'.$k] != "0"){
						$staff_name = User::getStaffNameById($details['staff_id'.$k]);
						if(isset($staff_name) && $staff_name != ''){
							$client_array[$x]['column_no'] 	= $k;
							$client_array[$x]['staff_id'] 	= $details['staff_id'.$k];
							$client_array[$x]['staff_name'] = $staff_name;
							$x++;
						}
					}
				}
			}
		}
		//print_r($client_array);//die;
		return array_values($client_array);
    }

    public static function staffByClientService($client_id, $service_id)
    {
    	$client_array 	= array();
    	$session 				= Session::get('admin_details');
			$user_id 				= $session['id'];
			$groupUserId 		= $session['group_users'];

			$value = ClientListAllocation::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->get();//first
			//print_r($client_array);die;
			$details = ClientListAllocation::getArray($value);
			return $details;
    }

    public static function withStaffNameByClientService($client_id, $service_id)
    {
    	$staff1 = $staff2 = $staff3 = $staff4 = $staff5 = array();
    	$allocStaff = ClientListAllocation::staffByClientService($client_id, $service_id);

    	//Common::last_query();
			if(isset($allocStaff) && count($allocStaff) >0){
				foreach ($allocStaff as $k => $value) {
					for($i = 1; $i <=5; $i++){
						$staff = 'staff'.$i;
						if(isset($value['staff_id'.$i]) && !in_array($value['staff_id'.$i], $$staff)){
							$allocStaff[$k]['staff_name'.$i] = User::getStaffNameById($value['staff_id'.$i]);
							array_push($$staff, $value['staff_id'.$i]);
						}
					}
					/*if(isset($value['staff_id1']) && !in_array($value['staff_id1'], $staff1)){
						$allocStaff[$k]['staff_name1'] = User::getStaffNameById(isset($value['staff_id1'])?$value['staff_id1']:0);
						array_push($staff1, $value['staff_id1']);
					}
					if(isset($value['staff_id2']) && !in_array($value['staff_id2'], $staff2)){
						$allocStaff[$k]['staff_name2'] = User::getStaffNameById($value['staff_id2']);
						array_push($staff2, $value['staff_id2']);
					}
					if(isset($value['staff_id3']) && !in_array($value['staff_id3'], $staff3)){
						$allocStaff[$k]['staff_name3'] = User::getStaffNameById($value['staff_id3']);
						array_push($staff3, $value['staff_id3']);
					}
					if(isset($value['staff_id4']) && !in_array($value['staff_id4'], $staff4)){
						$allocStaff[$k]['staff_name4'] = User::getStaffNameById($value['staff_id4']);
						array_push($staff4, $value['staff_id4']);
					}
					if(isset($value['staff_id5']) && !in_array($value['staff_id5'], $staff5)){
						$allocStaff[$k]['staff_name5'] = User::getStaffNameById($value['staff_id5']);
						array_push($staff5, $value['staff_id5']);
					}*/


				}
			}
			//echo "<pre>";print_r($allocStaff);die;
			return $allocStaff;
    }

  public static function getDetailsByServiceId($service_id)
  {
  	$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

  	$details = ClientListAllocation::whereIn('user_id', $groupUserId)
  			->where("service_id", $service_id)->get();
  	$allocationStaff = ClientListAllocation::getArray($details);

		if(isset($allocationStaff) && count($allocationStaff) >0){
			foreach ($allocationStaff as $key => $value) {
				for($i = 1; $i <=5; $i++){
					$allocationStaff[$key]['staff_name'.$i] = User::getStaffNameById($value['staff_id'.$i]);
				}
			}
		}
		return $allocationStaff;
  }

  public static function getPositionName( $position )
	{
		$name = AllocationHeading::getHeadingNameById( $position );
		return $name;
	}

/*  public static function getClientIdByServiceId( $service_id )
	{
		$data = array();
		$session 			= Session::get('admin_details');
		$groupUserId 	= $session['group_users'];

		$details = ClientListAllocation::whereIn('user_id', $groupUserId)
				->where("service_id", $service_id)->get();
		if(isset($details) && count($details) >0){
			foreach ($details as $k => $v) {
				array_push($data, $v->client_id);
			}
		}
		return $data;
	}*/

  public static function getSingleArray($value)
  {
  	$client_array = array();
		if(isset($value) && count($value) >0){
			$client_array['client_allocation_id'] 	= $value->client_allocation_id;
			$client_array['user_id'] 					= $value->user_id;
			$client_array['client_type'] 			= $value->client_type;
			$client_array['client_id'] 				= $value->client_id;
			$client_array['service_id'] 			= $value->service_id;
			$client_array['staff_id1'] 				= $value->staff_id1;
			$client_array['staff_id2'] 				= $value->staff_id2;
			$client_array['staff_id3'] 				= $value->staff_id3;
			$client_array['staff_id4'] 				= $value->staff_id4;
			$client_array['staff_id5'] 				= $value->staff_id5;
			$client_array['staff_hrs1'] 			= $value->staff_hrs1;
			$client_array['staff_hrs2'] 			= $value->staff_hrs2;
			$client_array['staff_hrs3'] 			= $value->staff_hrs3;
			$client_array['staff_hrs4'] 			= $value->staff_hrs4;
			$client_array['staff_hrs5'] 			= $value->staff_hrs5;
			$client_array['created'] 					= date('d-m-Y', strtotime($value->created));
		}
	
		//print_r($client_array);die;
		return $client_array;
  }

  public static function getArray($details)
  {
  	$client_array = array();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$client_array[$key]['client_allocation_id'] 	= $value->client_allocation_id;
				$client_array[$key]['user_id'] 					= $value->user_id;
				$client_array[$key]['client_type'] 			= $value->client_type;
				$client_array[$key]['client_id'] 				= $value->client_id;
				$client_array[$key]['service_id'] 			= $value->service_id;
				$client_array[$key]['staff_id1'] 				= $value->staff_id1;
				$client_array[$key]['staff_id2'] 				= $value->staff_id2;
				$client_array[$key]['staff_id3'] 				= $value->staff_id3;
				$client_array[$key]['staff_id4'] 				= $value->staff_id4;
				$client_array[$key]['staff_id5'] 				= $value->staff_id5;
				$client_array[$key]['staff_hrs1'] 			= $value->staff_hrs1;
				$client_array[$key]['staff_hrs2'] 			= $value->staff_hrs2;
				$client_array[$key]['staff_hrs3'] 			= $value->staff_hrs3;
				$client_array[$key]['staff_hrs4'] 			= $value->staff_hrs4;
				$client_array[$key]['staff_hrs5'] 			= $value->staff_hrs5;
				$client_array[$key]['created'] 					= date('d-m-Y', strtotime($value->created));
			}
		}
	
		//print_r($client_array);die;
		return $client_array;
  }

  public static function getRoleByClientAndServiceId($client_id, $service_id, $user_id)
  {
  	$role = array();
  	$session 			= Session::get('admin_details');
		$groupUserId 	= $session['group_users'];

  	$list = ClientListAllocation::whereIn('user_id', $groupUserId)->where("client_id", $client_id)->where("service_id", $service_id)->get();
    if(isset($list) && count($list) >0){
			foreach ($list as $k=>$v) {
				if(isset($v->staff_id1) && $v->staff_id1 == $user_id){
					$position = ClientListAllocation::getPositionName( 1 );
					array_push($role, $position);
				}
				if($v->staff_id2 == $user_id){
					$position = ClientListAllocation::getPositionName( 2 );
					array_push($role, $position);
				}
				if($v->staff_id3 == $user_id){
					$position = ClientListAllocation::getPositionName( 3 );
					array_push($role, $position);
				}
				if($v->staff_id4 == $user_id){
					$position = ClientListAllocation::getPositionName( 4 );
					array_push($role, $position);
				}
				if($v->staff_id5 == $user_id){
					$position = ClientListAllocation::getPositionName( 5 );
					array_push($role, $position);
				}
			}
		}

		$roles = array_unique($role);

		return implode(',',$roles);
  }



  public static function sendNotification($clientIds, $staffIds, $service_id, $position)
  {
    $emails = $clients = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $group_id       = $session['group_id'];
    $groupUserId    = Client::getSessionUserIds();

    if(!empty($clientIds)){
    	foreach ($clientIds as $k => $client_id) {
    		$clients[$k]['client_name'] = Client::getClientNameByClientId($client_id);
    	}
    }


    if(!empty($staffIds)){
    	foreach ($staffIds as $k1 => $staff_id) {
    		$email1 = User::getEmailByUserId($user_id);
    		$email2 = User::getEmailByUserId($staff_id);
    		array_push($emails, $email1);
    		array_push($emails, $email2);

    		$data['email'] 				= $emails;
    		$data['senderEmail']  = Config::get('constant.ADMINEMAIL');
		    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
		    $data['clients']      = $clients;
		    $data['STAFFNAME']    = User::getStaffNameById($staff_id);
		    $data['USERNAME']    	= User::getStaffNameById($user_id);
		    $data['POSITION']    	= ClientListAllocation::getPositionName($position);
		    $data['SERVICENAME']  = Service::getNameServiceId( $service_id );
		    $data['SENDFROM']  		= 'bulk';
		    //echo "<pre>";print_r($data['email']);die;

		    Mail::send('emails.client_allocation', $data, function ($message) use ($data) {
		      $message->subject('CLIENT LIST ALLOCATION - '.$data['SERVICENAME']); 
		      $message->from($data['senderEmail']);
		      $message->to($data['email']);
		    });
    	}
    }
  }

  public static function sendEditNotification($client_id, $staffIds, $service_id)
  {
    $emails = $clients = array();
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $group_id       = $session['group_id'];
    $groupUserId    = Client::getSessionUserIds();

    if(!empty($staffIds)){
    	foreach ($staffIds as $k1 => $staff_id) {
    		$email1 = User::getEmailByUserId($user_id);
    		$email2 = User::getEmailByUserId($staff_id);
    		array_push($emails, $email1);
    		array_push($emails, $email2);

    		$data['email'] 				= $emails;
    		$data['senderEmail']  = Config::get('constant.ADMINEMAIL');
		    $data['PRACTICENAME'] = PracticeDetail::get_practice_name($group_id);
		    $data['STAFFNAME']    = User::getStaffNameById($staff_id);
		    $data['USERNAME']    	= User::getStaffNameById($user_id);
		    $data['CLIENTNAME']   = Client::getClientNameByClientId($client_id);
		    $data['POSITION']  		= ClientListAllocation::getRoleByClientAndServiceId($client_id,$service_id, $user_id);
		    $data['DATE']  				= date('d-m-Y');
		    $data['SENDFROM']  		= 'edit';
		    //echo "<pre>";print_r($data['POSITION']);die;

		    Mail::send('emails.client_allocation', $data, function ($message) use ($data) {
		      $message->subject('New Client Allocation - '.$data['CLIENTNAME']); 
		      $message->from($data['senderEmail']);
		      $message->to($data['email']);
		    });
    	}
    }
  }





}
