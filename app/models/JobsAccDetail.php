<?php
class JobsAccDetail extends Eloquent { 

	public $timestamps = false;
	public static function getDetailsByClientId($client_id)
	{
		$data = array();
		$session = Session::get('admin_details');
    $user_id = $session['id'];
    $groupUserId = $session['group_users'];

		$details = JobsAccDetail::whereIn("user_id",$groupUserId)->where('client_id',$client_id)->first();
		return JobsAccDetail::getSingleArray($details);
	}

	public static function getDetailsByClientAndServiceId($client_id, $service_id)
	{
		$data = array();
		$session = Session::get('admin_details');
    $user_id = $session['id'];
    $groupUserId = $session['group_users'];

		$details = JobsAccDetail::whereIn("user_id", $groupUserId)->where('client_id', $client_id)->where('service_id', $service_id)->first();
		return JobsAccDetail::getSingleArray($details);
	}

	public static function getSingleArray($value)
	{
		$data = array();

		if(isset($value) && count($value) >0){
			$data['acc_id'] 		  		= $value['acc_id'];
			$data['user_id'] 		  		= $value['user_id'];
			$data['client_id'] 		  	= $value['client_id'];
			$data['service_id'] 	  	= $value['service_id'];
			$data['tax_return_start'] = isset($value['tax_return_start'])?date('d-m-Y', strtotime($value['tax_return_start'])):"";
			$data['tax_return_end']   = isset($value['tax_return_end'])?date("d-m-Y", strtotime($value['tax_return_end'])):"";
			$data['tax_return_date']  = isset($value['tax_return_end'])?date("d-m-Y", strtotime('+1 year', strtotime($value['tax_return_end']))):"";
			$data['roll_fwd_start']   = isset($value['roll_fwd_start'])?date("d-m-Y", strtotime($value['roll_fwd_start'])):"";
			$data['roll_fwd_end']     = isset($value['roll_fwd_end'])?date("d-m-Y",  strtotime($value['roll_fwd_end'])):"";
			$data['roll_fwd_date']    = isset($value['roll_fwd_end'])?date("d-m-Y", strtotime('+1 year', strtotime($value['roll_fwd_end']))):"";

			$data['count_down'] 	  	= JobsAccDetail::getCountDown($data['tax_return_date']);
			$data['roll_count'] 	  	= JobsAccDetail::getCountDown($data['roll_fwd_date']);
			$data['repeat_day'] 	  	= $value['repeat_day'];
			$data['first_due_date']   = (isset($value['first_due_date']) && $value['first_due_date'] != '0000-00-00')?date("d-m-Y", strtotime($value['first_due_date'])):"";
			$data['hrs_wk'] 		  		= $value['hrs_wk'];
			$data['end_date_opt'] 	  = (isset($value['end_date_opt']) && $value['end_date_opt'] != '0000-00-00')?date("d-m-Y", strtotime($value['end_date_opt'])):"";
			$data['next_send_date']   = (isset($value['next_send_date']) && $value['next_send_date'] != '0000-00-00')?date("d-m-Y", strtotime($value['next_send_date'])):"";
			$data['completion_date']  = (isset($value['completion_date']) && $value['completion_date'] != '0000-00-00')?date("d-m-Y", strtotime($value['completion_date'])):"";
			$data['completion_days']  = JobsAccDetail::getCountDays($data['completion_date']);
			$data['deadline_date']    = (isset($value['deadline_date']) && $value['deadline_date'] != '0000-00-00')?date("d-m-Y", strtotime($value['deadline_date'])):"";
			$data['job_frequency'] 		= $value['job_frequency'];
			$data['job_name'] 		  	= $value['job_name'];
			$data['created'] 		  		= $value['created'];
		}
		return $data;
	}

	public static function getDeadlineDateByClientId($client_id, $service_id)
	{
		$date = "";
		$session 			= Session::get('admin_details');
    $user_id 			= $session['id'];
    $groupUserId 	= $session['group_users'];

		$value = JobsAccDetail::whereIn("user_id", $groupUserId)->where('service_id', $service_id)->where('client_id', $client_id)->first();
		if(isset($value['deadline_date']) && $value['deadline_date'] != ""){
			$date = $value['deadline_date'];
		}
		//Common::last_query();
		return $date;
	}

	public static function getFieldValueByClientId($field_name, $client_id, $service_id)
	{
		$date = "";
		$session 			= Session::get('admin_details');
    $user_id 			= $session['id'];
    $groupUserId 	= $session['group_users'];

		$value = JobsAccDetail::whereIn("user_id", $groupUserId)->where('service_id', $service_id)->where('client_id', $client_id)->select($field_name)->first();
		if(isset($value[$field_name]) && $value[$field_name]!="" && $value[$field_name]!='0000-00-00'){
			$date = $value[$field_name];
		}
		//Common::last_query();
		return $date;
	}

	public static function updateCustomDeadline($client_id, $service_id)
	{
		$data = array();
		$session 			= Session::get('admin_details');
    $user_id 			= $session['id'];
    $groupUserId 	= $session['group_users'];

		$value = JobsAccDetail::whereIn("user_id", $groupUserId)->where('service_id', $service_id)->where('client_id', $client_id)->select('acc_id', 'deadline_date', 'job_frequency', 'completion_date')->first();
		if(isset($value['job_frequency']) && $value['job_frequency']!=""){
			$job_frequency = $value['job_frequency'];
			$deadline_date = $value['deadline_date'];
			if($job_frequency == 'Monthly'){
				$data['deadline_date'] = date('Y-m-d', strtotime('+1 month', strtotime($deadline_date)));
			}
			if($job_frequency == 'Quarterly'){
				$data['deadline_date'] = date('Y-m-d', strtotime('+3 months', strtotime($deadline_date)));
			}
			if($job_frequency == 'Yearly'){
				$data['deadline_date'] = date('Y-m-d', strtotime('+1 year', strtotime($deadline_date)));
			}
			JobsAccDetail::where("acc_id", $value['acc_id'])->update($data);
		}

		if($service_id == 6){
			$data['completion_date']=date('Y-m-d',strtotime('+1 year',strtotime($value['completion_date'])));
			JobsAccDetail::where("acc_id", $value['acc_id'])->update($data);
		}
		//Common::last_query();
		return $data;
	}

	public static function getCountDown($enddate)
	{
		$today 	= date('d-m-Y');
		$diff 	= strtotime($enddate) - strtotime($today);
		$days 	= round($diff/86400);
		
		return $days;
	}

	public static function getCountDays($enddate)
	{
		$today 	= date('d-m-Y');
		if($enddate == ''){
			$days = 0;
		}else{
			$diff 	= strtotime($today) - strtotime($enddate);
			$days 	= round($diff/86400);
		}
		return $days;
	}

	public static function tasksThirdTable($sendData)
	{
    $start 				= $sendData['start'];
  	$limit 				= $sendData['limit'];
  	$sorting 			= $sendData['sorting'];
  	$search 			= $sendData['search'];
  	$service_id 	= $sendData['service_id'];
  	$page_open  	= $sendData['page_open'];
  	$staff_id  		= JobsStaffFilter::getStaffIdByServiceId($service_id);

  	$data =  $od 	= array();
		$sort 				= explode(' ', $sorting);
		$groupUserId 	= Client::getSessionUserIds();

		$header_sort 	= '';
		if($staff_id == 'all'){
    	$where = " WHERE ";
    }else if($staff_id == 'none'){
    	$where = " WHERE jct.client_id NOT IN (SELECT client_id FROM client_list_allocations WHERE service_id = jct.service_id and (staff_id1 != 0 OR staff_id2 != 0 OR staff_id3 != 0 OR staff_id4 != 0 OR staff_id5 != 0 ) ) AND ";
    }else{
    	$where = " WHERE jct.client_id IN (SELECT client_id FROM client_list_allocations WHERE service_id=jct.service_id and (staff_id1='".$staff_id."' OR staff_id2='".$staff_id."' OR staff_id3='".$staff_id."' OR staff_id4='".$staff_id."' OR staff_id5='".$staff_id."')) AND ";
    }

    $where .=" jct.user_id IN('".implode(',',$groupUserId)."') AND jct.service_id='".$service_id."' ";

		$registration_number 	= StepsFieldsClient::clientFieldQuery('registration_number');
		$client_name  				= StepsFieldsClient::clientNameQuery();
		$vat_number 					= StepsFieldsClient::clientFieldQuery('vat_number');
		$ret_frequency 				= StepsFieldsClient::clientFieldQuery('ret_frequency');
		$last_acc_madeup_date = StepsFieldsClient::clientFieldQuery('last_acc_madeup_date');
		$next_return 	 				= StepsFieldsClient::nextReturnQuery();


		$return_date = " (select jm.return_date from jobs_manages as jm where jm.job_manage_id=jct.job_manage_id) ";

		$job_due_date = " (select DATE_FORMAT(jm.created,'%d-%m-%Y') from jobs_manages as jm where jm.job_manage_id=jct.job_manage_id) ";

		$tax_reference_type = " (select field_value from steps_fields_clients where field_name='tax_reference_type' and client_id=jct.client_id group by client_id) ";
		$ct_reference = " (select field_value from steps_fields_clients where field_name='tax_reference' and client_id=jct.client_id group by client_id) ";

		$tax_return_start = " (SELECT IF(tax_return_start='0000-00-00','',DATE_FORMAT(tax_return_start, '%d-%m-%Y') ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=jct.client_id group by client_id ) ";
		$tax_return = JobsAccDetail::CTReferenceQuery($service_id);
		$period_end = " (SELECT IF(jm.period_end='0000-00-00','',DATE_FORMAT(jm.period_end, '%d-%m-%Y') )from jobs_manages as jm where jm.job_manage_id=jct.job_manage_id) ";
		$completion = " (SELECT IF(completion_date='0000-00-00','',DATE_FORMAT(completion_date, '%d-%m-%Y') ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=jct.client_id group by client_id ) ";
		$made_up_date = " (SELECT field_value FROM steps_fields_clients WHERE field_name='made_up_date' and client_id=jct.client_id group by client_id) ";
		$ecsl_freq = " (SELECT field_value FROM steps_fields_clients WHERE field_name='ecsl_freq' and client_id=jct.client_id group by client_id) ";
		$ni_number = " (SELECT field_value FROM steps_fields_clients WHERE field_name='ni_number' and client_id=jct.client_id group by client_id) ";
		$tax_reference = " (select field_value from steps_fields_clients where field_name='tax_reference' and client_id=jct.client_id group by client_id) ";

		//$time_sheet = " (select count(tsr.*) as count from time_sheet_reports as tsr where tsr.service_id='".$service_id."' AND tsr.completed_task_id = jct.task_id AND tsr.tasks_client_id = jct.client_id ) ";

    if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'registration_number'){
			$header_sort = " order by ".$registration_number.' '.$sort[1];
		}else if($sort[0] == 'vat_number'){
			$header_sort = " order by ".$vat_number.' '.$sort[1];
		}else if($sort[0] == 'ret_frequency'){
			$header_sort = " order by ".$ret_frequency.' '.$sort[1];
		}else if($sort[0] == 'return_date'){
			$header_sort = " order by ".$return_date.' '.$sort[1];
		}else if($sort[0] == 'last_acc_madeup_date'){
			$header_sort = " order by ".$last_acc_madeup_date.' '.$sort[1];
		}else if($sort[0] == 'job_due_date'){
			$header_sort = " order by ".$job_due_date.' '.$sort[1];
		}else if($sort[0] == 'completion_date'){
			$header_sort = " order by jct.date ".$sort[1];
		}else if($sort[0] == 'ct_reference'){
			$header_sort = " order by ".$ct_reference.' '.$sort[1];
		}else if($sort[0] == 'tax_return'){
			$header_sort = " order by ".$tax_return.' '.$sort[1];
		}else if($sort[0] == 'period_end'){
			$header_sort = " order by ".$period_end.' '.$sort[1];
		}else if($sort[0] == 'completion'){
			$header_sort = " order by ".$completion.' '.$sort[1];
		}else if($sort[0] == 'made_up_date'){
			$header_sort = " order by ".$made_up_date.' '.$sort[1];
		}else if($sort[0] == 'ecsl_freq'){
			$header_sort = " order by ".$ecsl_freq.' '.$sort[1];
		}else if($sort[0] == 'ni_number'){
			$header_sort = " order by ".$ni_number.' '.$sort[1];
		}

		if(isset($search) && $search != ''){
			$where .= " AND (".$client_name." LIKE '%".$search."%' OR ";

			if($service_id == 1){
				$where .= $vat_number." LIKE '%".$search."%' OR ";
				$where .= $ret_frequency." LIKE '%".$search."%' OR ";
				$where .= $return_date." LIKE '%".$search."%' OR ";
				$where .= "jct.date LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' ) ";
			}
			if($service_id == 2){
				$where .= $vat_number." LIKE '%".$search."%' OR ";
				$where .= $ret_frequency." LIKE '%".$search."%' OR ";
				$where .= $ecsl_freq." LIKE '%".$search."%' OR ";
				$where .= "jct.date LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' ) ";
			}
			if($service_id == 3){
				$where .= $last_acc_madeup_date." LIKE '%".$search."%' OR ";
				$where .= "jct.date LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' ) ";
			}
			if($service_id == 4){
				$where .= "jct.date LIKE '%".$search."%' OR ";
				$where .= $job_due_date." LIKE '%".$search."%' ) ";
			}
			if($service_id == 5){
				$where .= $ct_reference." LIKE '%".$search."%' OR ";
				$where .= $tax_return." LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' ) ";
			}
			if($service_id == 6){
				$where .= $period_end." LIKE '%".$search."%' OR ";
				$where .= $completion." LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' ) ";
			}
			if($service_id == 7){
				$where .= $return_date." LIKE '%".$search."%' OR ";
				$where .= $tax_reference." LIKE '%".$search."%' OR ";
				$where .= $ni_number." LIKE '%".$search."%' ) ";
			}
			if($service_id == 8){
				$where .= $return_date." LIKE '%".$search."%' OR ";
				$where .= "jct.date LIKE '%".$search."%' ) ";
			}
			if($service_id == 9){
				$where .= $next_return." LIKE '%".$search."%' OR ";
				$where .= $made_up_date." LIKE '%".$search."%' OR ";
				$where .= "jct.date LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' ) ";
			}
			
		}
		//IF(jct.filling_date='0000-00-00 00:00:00','',DATE_FORMAT(jct.filling_date,'%d-%m-%Y'))
		$select = "select jct.task_id, jct.job_manage_id, jct.client_id, jct.date, jct.notes,
			jct.date as filling_date, c.type,
			".$client_name." as client_name,
			".$registration_number." as registration_number,
			".$vat_number." as vat_number,
			".$ret_frequency." as ret_frequency,
			".$return_date." as return_date,
			".$last_acc_madeup_date." as last_acc_madeup_date,
			".$job_due_date." as job_due_date,
			".$tax_reference_type." as tax_reference_type,
			".$ct_reference." as ct_reference,
			".$tax_return." as tax_return,
			".$tax_return_start." as tax_return_start,
			".$period_end." as period_end,
			".$completion." as completion,
			".$next_return." as next_return,
			".$made_up_date." as made_up_date,
			".$ecsl_freq." as ecsl_freq
    ";

    $query = " FROM jobs_completed_tasks jct JOIN clients c ON jct.client_id=c.client_id ";

    $query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

		//============== total count section ==============
    $total_qry 		= "select count(jct.client_id) as count ".$query;
    $totalVal 		= DB::select($total_qry);
    $total 				= json_decode(json_encode($totalVal), true);

		$data['details'] 			= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];

    return $data;
	}


	public static function tasksFirstTable($sendData)
	{  
    $start 				= $sendData['start'];
  	$limit 				= $sendData['limit'];
  	$sorting 			= $sendData['sorting'];
  	$search 			= $sendData['search'];
  	$service_id 	= $sendData['service_id'];
  	$page_open  	= $sendData['page_open'];
  	$staff_id  		= JobsStaffFilter::getStaffIdByServiceId($service_id);
  	//$service_id 	= 10;
  	//echo $staff_id;die;
  	$data =  $od 	= array();

    $sort 				= explode(' ', $sorting);
		$groupUserId 	= Client::getSessionUserIds();

		$header_sort 	= '';

		if($staff_id == 'all'){
    	$where = " WHERE ";
    }else if($staff_id == 'none'){
    	$where = " WHERE cs.client_id NOT IN (SELECT client_id FROM client_list_allocations WHERE service_id = cs.service_id and (staff_id1 != 0 OR staff_id2 != 0 OR staff_id3 != 0 OR staff_id4 != 0 OR staff_id5 != 0 ) ) AND ";
    }else{
    	$where = " WHERE cs.client_id IN (SELECT client_id FROM client_list_allocations WHERE service_id=cs.service_id and (staff_id1='".$staff_id."' OR staff_id2='".$staff_id."' OR staff_id3='".$staff_id."' OR staff_id4='".$staff_id."' OR staff_id5='".$staff_id."')) AND ";
    }
    $where .=" c.user_id IN ('".implode(',', $groupUserId)."') AND ";

    if($service_id == 7){
    	$where .=" cs.service_id IN (7,10) ";
    }else{
    	$where .=" cs.service_id='".$service_id."' ";
    }


		$manage_task = " (select jm.status from jobs_manages as jm where jm.client_id=cs.client_id and jm.service_id=cs.service_id group by jm.client_id) ";

		$vat_scheme_type 			= StepsFieldsClient::clientFieldQuery('vat_scheme_type');
		$client_name  				= StepsFieldsClient::clientNameQuery();
		$sign_off_date 				= CrmAccDetail::clientFieldQuery('sign_off_date');
		$year_end 						= StepsFieldsClient::yearEndQuery();
		$effective_date 			= StepsFieldsClient::clientFieldQuery('effective_date');
		$vat_number 					= StepsFieldsClient::clientFieldQuery('vat_number');
		$vat_stagger 					= StepsFieldsClient::clientFieldQuery('vat_stagger');
		$ret_frequency 				= StepsFieldsClient::clientFieldQuery('ret_frequency');
		$ecsl_freq 						= StepsFieldsClient::clientFieldQuery('ecsl_freq');
		$vat_scheme 					= StepsFieldsClient::clientFieldQuery('vat_scheme');
		$incorporation_date 	= StepsFieldsClient::clientFieldQuery('incorporation_date');
		$registration_number 	= StepsFieldsClient::clientFieldQuery('registration_number');
		$ch_auth_code 				= StepsFieldsClient::clientFieldQuery('ch_auth_code');
		$last_acc_madeup_date = StepsFieldsClient::clientFieldQuery('last_acc_madeup_date');
		$next_acc_due 				= StepsFieldsClient::clientFieldQuery('next_acc_due');
		$next_made_up_to 			= StepsFieldsClient::clientFieldQuery('next_made_up_to');
		$acc_ref_day 					= StepsFieldsClient::clientFieldQuery('acc_ref_day');
		$acc_ref_month 				= StepsFieldsClient::clientFieldQuery('acc_ref_month');
		$deadacc_count 				= StepsFieldsClient::deadCountQuery('next_acc_due');
		$completion_date 			= JobsAccDetail::clientFieldQuery('completion_date', $service_id);
		$completion_days 			= JobsAccDetail::completionDaysQuery($service_id);
		$repeat_day 					= JobsAccDetail::clientFieldQuery('repeat_day', $service_id);
		$hrs_wk 							= JobsAccDetail::clientFieldQuery('hrs_wk', $service_id);

		$made_up_date 				= StepsFieldsClient::clientFieldQuery('made_up_date');
		$next_return 					= StepsFieldsClient::nextReturnQuery();
		$next_ret_due 				= StepsFieldsClient::clientFieldQuery('next_ret_due');
		$deadret_count 				= StepsFieldsClient::deadCountQuery('next_ret_due');

		$tax_reference 				= StepsFieldsClient::clientFieldQuery('tax_reference');
		$roll_fwd_start 			= JobsAccDetail::clientDateFieldQuery('roll_fwd_start', $service_id);
		$roll_fwd_end 				= JobsAccDetail::clientDateFieldQuery('roll_fwd_end', $service_id);
		$roll_fwd_date 				= JobsAccDetail::rollForwardDateFieldQuery('roll_fwd_end', $service_id);
		$roll_count 					= JobsAccDetail::RollCountQuery($service_id);

		$accounts_date 				= JobsManage::AccountDateQuery('next_made_up_to', 3);
		$return_due_date 			= JobsManage::ReturnDueDateQuery(3);//service id for accounts
		$ct_count_down 				= JobsManage::CtCountDownQuery(3);
		$ni_number 						= StepsFieldsClient::clientFieldQuery('ni_number');
		$frequency 						= JobsNote::clientFieldQuery('frequency', $service_id);
		$due_date 						= JobsNote::clientFieldQuery('due_date', $service_id);

    if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'vat_scheme_type'){
			$header_sort = " order by ".$vat_scheme_type.' '.$sort[1];
		}else if($sort[0] == 'effective_date'){
			$header_sort = " order by ".$effective_date.' '.$sort[1];
		}else if($sort[0] == 'vat_number'){
			$header_sort = " order by ".$vat_number.' '.$sort[1];
		}else if($sort[0] == 'vat_stagger'){
			$header_sort = " order by ".$vat_stagger.' '.$sort[1];
		}else if($sort[0] == 'ret_frequency'){
			$header_sort = " order by ".$ret_frequency.' '.$sort[1];
		}else if($sort[0] == 'vat_scheme'){
			$header_sort = " order by ".$vat_scheme.' '.$sort[1];
		}else if($sort[0] == 'ecsl_freq'){
			$header_sort = " order by ".$ecsl_freq.' '.$sort[1];
		}else if($sort[0] == 'registration_number'){
			$header_sort = " order by ".$registration_number.' '.$sort[1];
		}else if($sort[0] == 'ch_auth_code'){
			$header_sort = " order by ".$ch_auth_code.' '.$sort[1];
		}else if($sort[0] == 'last_acc_madeup_date'){
			$header_sort = " order by ".$last_acc_madeup_date.' '.$sort[1];
		}else if($sort[0] == 'next_acc_due'){
			$header_sort = " order by ".$next_acc_due.' '.$sort[1];
		}else if($sort[0] == 'next_made_up_to'){
			$header_sort = " order by ".$next_made_up_to.' '.$sort[1];
		}else if($sort[0] == 'deadacc_count'){
			//$header_sort = " order by ".$deadacc_count.' '.$sort[1];
			//$next = ($sort[1] == 'ASC')?'DESC':'ASC';
			$header_sort = " ORDER BY CASE 
				WHEN ( ".$deadacc_count." <='0' && ".$deadacc_count." != 'NULL') THEN 0
				WHEN ( ".$deadacc_count." >'0' && ".$deadacc_count." != 'NULL') THEN 1
			 	ELSE 2 END ASC, ".$deadacc_count." DESC";

			/*$header_sort = " ORDER BY CASE 
				WHEN ( ".$deadacc_count." <=0 && ".$deadacc_count." != 'NULL') THEN 1
				WHEN ( ".$deadacc_count." >0 && ".$deadacc_count." != 'NULL') THEN 2
			 	ELSE 3 END, ABS(".$deadacc_count.") ".$sort[1];*/
			 	
		}else if($sort[0] == 'completion_date'){
			$header_sort = " order by ".$completion_date.' '.$sort[1];
		}else if($sort[0] == 'completion_days'){
			$header_sort = " order by ".$completion_days.' '.$sort[1];
		}else if($sort[0] == 'repeat_day'){
			$header_sort = " order by ".$repeat_day.' '.$sort[1];
		}else if($sort[0] == 'hrs_wk'){
			$header_sort = " order by ".$hrs_wk.' '.$sort[1];
		}else if($sort[0] == 'made_up_date'){
			$header_sort = " order by ".$made_up_date.' '.$sort[1];
		}else if($sort[0] == 'next_ret_due'){
			$header_sort = " order by ".$next_ret_due.' '.$sort[1];
		}else if($sort[0] == 'deadret_count'){
			$header_sort = " order by ".$deadret_count.' '.$sort[1];
		}else if($sort[0] == 'tax_reference'){
			$header_sort = " order by ".$tax_reference.' '.$sort[1];
		}else if($sort[0] == 'roll_fwd_start'){
			$header_sort = " order by ".$roll_fwd_start.' '.$sort[1];
		}else if($sort[0] == 'roll_fwd_date'){
			$header_sort = " order by ".$roll_fwd_date.' '.$sort[1];
		}else if($sort[0] == 'roll_count'){
			$header_sort = " order by ".$roll_count.' '.$sort[1];
		}else if($sort[0] == 'accounts_date'){
			$header_sort = " order by ".$accounts_date.' '.$sort[1];
		}else if($sort[0] == 'return_due_date'){
			$header_sort = " order by ".$return_due_date.' '.$sort[1];
		}else if($sort[0] == 'ct_count_down'){
			$header_sort = " order by ".$ct_count_down.' '.$sort[1];
			/*$next = ($sort[1] == 'ASC')?'DESC':'ASC';
			$header_sort = " ORDER BY CASE WHEN ".$ct_count_down." IS NULL THEN 0 ELSE 1 END ".$sort[1].", ".$ct_count_down." ".$next;*/
		}else if($sort[0] == 'ni_number'){
			$header_sort = " order by ".$ni_number.' '.$sort[1];
		}


		if(isset($search) && $search != ''){
			$where .= " AND (".$client_name." LIKE '%".$search."%' OR ";

			if($service_id == 1){
				$where .= $vat_scheme_type." LIKE '%".$search."%' OR ";
				$where .= $vat_number." LIKE '%".$search."%' OR ";
				$where .= $vat_stagger." LIKE '%".$search."%' OR ";
				$where .= $ret_frequency." LIKE '%".$search."%' OR ";
				$where .= $vat_scheme." LIKE '%".$search."%' OR ";
				$where .= $effective_date." LIKE '%".$search."%' ) ";
			}
			if($service_id == 2){
				$where .= $vat_scheme_type." LIKE '%".$search."%' OR ";
				$where .= $vat_number." LIKE '%".$search."%' OR ";
				$where .= $vat_stagger." LIKE '%".$search."%' OR ";
				$where .= $ecsl_freq." LIKE '%".$search."%' OR ";
				$where .= $vat_scheme." LIKE '%".$search."%' OR ";
				$where .= $effective_date." LIKE '%".$search."%' ) ";
			}
			if($service_id == 3){
				$where .= $incorporation_date." LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' OR ";
				$where .= $ch_auth_code." LIKE '%".$search."%' OR ";
				$where .= $last_acc_madeup_date." LIKE '%".$search."%' OR ";
				$where .= $next_acc_due." LIKE '%".$search."%' OR ";
				$where .= $year_end." LIKE '%".$search."%' OR ";
				$where .= $sign_off_date." LIKE '%".$search."%' OR ";
				$where .= $deadacc_count." LIKE '%".$search."%' ) ";
			}
			if($service_id == 4){
				$where .= $vat_scheme_type." LIKE '%".$search."%' OR ";
				$where .= $vat_stagger." LIKE '%".$search."%' OR ";
				$where .= $vat_scheme." LIKE '%".$search."%' OR ";
				$where .= $repeat_day." LIKE '%".$search."%' OR ";
				$where .= $hrs_wk." LIKE '%".$search."%' ) ";
			}
			if($service_id == 5){
				$where .= $year_end." LIKE '%".$search."%' OR ";
				$where .= $last_acc_madeup_date." LIKE '%".$search."%' OR ";
				$where .= $tax_reference." LIKE '%".$search."%' OR ";
				$where .= $roll_fwd_start." LIKE '%".$search."%' OR ";
				$where .= $roll_fwd_end." LIKE '%".$search."%' OR ";
				$where .= $roll_fwd_date." LIKE '%".$search."%' OR ";
				$where .= $accounts_date." LIKE '%".$search."%' OR ";
				$where .= $return_due_date." LIKE '%".$search."%' OR ";
				$where .= $ct_count_down." LIKE '%".$search."%' OR ";
				$where .= $roll_count." LIKE '%".$search."%' ) ";
			}
			if($service_id == 6){
				$where .= $incorporation_date." LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' OR ";
				$where .= $last_acc_madeup_date." LIKE '%".$search."%' OR ";
				$where .= $next_acc_due." LIKE '%".$search."%' OR ";
				$where .= $next_made_up_to." LIKE '%".$search."%' OR ";
				$where .= $year_end." LIKE '%".$search."%' OR ";
				$where .= $completion_date." LIKE '%".$search."%' OR ";
				$where .= $completion_days." LIKE '%".$search."%' OR ";
				$where .= $deadacc_count." LIKE '%".$search."%' ) ";
			}
			if($service_id == 7){
				$where .= $ni_number." LIKE '%".$search."%' OR ";
				$where .= $tax_reference." LIKE '%".$search."%' ) ";
			}
			if($service_id == 8){
				$where .= $vat_stagger." LIKE '%".$search."%' OR ";
				$where .= $year_end." LIKE '%".$search."%' ) ";
			}
			if($service_id == 9){
				$where .= $incorporation_date." LIKE '%".$search."%' OR ";
				$where .= $registration_number." LIKE '%".$search."%' OR ";
				$where .= $year_end." LIKE '%".$search."%' OR ";
				$where .= $ch_auth_code." LIKE '%".$search."%' OR ";
				$where .= $next_return." LIKE '%".$search."%' OR ";
				$where .= $made_up_date." LIKE '%".$search."%' OR ";
				$where .= $next_ret_due." LIKE '%".$search."%' OR ";
				$where .= $deadret_count." LIKE '%".$search."%' ) ";
			}

		}
		
		//$data['details'] = App::make('JobsController')->allClientByService($service_id, $staff_id, $page_open);

		$select = "select c.client_id, c.type,
			".$client_name." as client_name,
			".$effective_date." as effective_date,
			".$manage_task." as manage_task,
			".$vat_scheme_type." as vat_scheme_type,
			".$vat_number." as vat_number,
			".$vat_stagger." as vat_stagger,
			".$ret_frequency." as ret_frequency,
			".$ecsl_freq." as ecsl_freq,
			".$vat_scheme." as vat_scheme,
			".$incorporation_date." as incorporation_date,
			".$registration_number." as registration_number,
			".$ch_auth_code." as ch_auth_code,
			".$last_acc_madeup_date." as last_acc_madeup_date,
			".$next_return." as next_return,
			".$next_acc_due." as next_acc_due,
			".$next_made_up_to." as next_made_up_to,
			".$acc_ref_day." as acc_ref_day,
			".$acc_ref_month." as acc_ref_month,
			".$year_end." as year_end,
			".$sign_off_date." as sign_off_date,
			".$deadacc_count." as deadacc_count,
			".$completion_date." as completion_date,
			".$completion_days." as completion_days,
			".$repeat_day." as repeat_day,
			".$hrs_wk." as hrs_wk,
			".$made_up_date." as made_up_date,
			".$next_ret_due." as next_ret_due,
			".$deadret_count." as deadret_count,
			".$tax_reference." as tax_reference,
			".$roll_fwd_start." as roll_fwd_start,
			".$roll_fwd_end." as roll_fwd_end,
			".$roll_fwd_date." as roll_fwd_date,
			".$roll_count." as roll_count,
			".$accounts_date." as accounts_date,
			".$return_due_date." as return_due_date,
			".$ct_count_down." as ct_count_down,
			".$ni_number." as ni_number,
			".$frequency." as frequency,
			".$due_date." as due_date
    ";

    $query = " FROM client_services cs JOIN clients c ON cs.client_id=c.client_id ";

    
		$query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

		//============== total count section ==============
    $total_qry 		= "select count(cs.client_id) as count ".$query;
    $totalVal 		= DB::select($total_qry);
    $total 				= json_decode(json_encode($totalVal), true);

		$data['details'] 			= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];

    return $data;
	}

	public static function tasksSecondTable($sendData)
	{
    $start 				= $sendData['start'];
  	$limit 				= $sendData['limit'];
  	$sorting 			= $sendData['sorting'];
  	$search 			= $sendData['search'];
  	$service_id 	= $sendData['service_id'];
  	$status_id 		= $sendData['status_id'];
  	$page_open  	= $sendData['page_open'];

  	$field1 			= $sendData['field1'];
  	$field2  			= $sendData['field2'];

  	$staff_id  		= JobsStaffFilter::getStaffIdByServiceId($service_id);

  	$data =  $od 	= array();
		$sort 				= explode(' ', $sorting);
		$groupUserId 	= Client::getSessionUserIds();

		$header_sort 	= '';
		if($service_id==1 || $service_id==2 || $service_id==3 || $service_id==4 || $service_id==6 || $service_id==7 || $service_id > 9){
			if($staff_id == 'all'){
	    	$where = " WHERE ";
	    }else if($staff_id == 'none'){
	    	$where = " WHERE jm.client_id NOT IN (SELECT client_id FROM client_list_allocations WHERE service_id = jm.service_id and (staff_id1 != 0 OR staff_id2 != 0 OR staff_id3 != 0 OR staff_id4 != 0 OR staff_id5 != 0 ) ) AND ";
	    }else{
	    	$where = " WHERE jm.client_id IN (SELECT client_id FROM client_list_allocations WHERE service_id=jm.service_id and (staff_id1='".$staff_id."' OR staff_id2='".$staff_id."' OR staff_id3='".$staff_id."' OR staff_id4='".$staff_id."' OR staff_id5='".$staff_id."')) AND ";
	    }
	  }else{
	  	$where = " WHERE ";
	  }

    $where .=" c.user_id IN ('".implode(',', $groupUserId)."') AND ";

    if($service_id == 7){
    	$where .=" jm.service_id IN (7,10) ";
    }else{
    	$where .=" jm.service_id='".$service_id."' ";
    }

		$effective_date 			= StepsFieldsClient::clientFieldQuery('effective_date');
		$client_name  				= StepsFieldsClient::clientNameQuery();
		$vat_stagger 					= StepsFieldsClient::clientFieldQuery('vat_stagger');
		$ret_frequency 				= StepsFieldsClient::clientFieldQuery('ret_frequency');
		$job_start_date 			= JobsNote::clientJobNoteQuery('job_start_date');

		$incorporation_date 	= StepsFieldsClient::clientFieldQuery('incorporation_date');
		$year_end 						= StepsFieldsClient::yearEndQuery();
		$deadacc_count 				= StepsFieldsClient::deadCountQuery('next_acc_due');
		$next_acc_due 				= StepsFieldsClient::clientFieldQuery('next_acc_due');
		$ecsl_freq 						= StepsFieldsClient::clientFieldQuery('ecsl_freq');
		$completion_date 			= JobsAccDetail::clientFieldQuery('completion_date', $service_id);
		$completion_days 			= JobsAccDetail::completionDaysQuery($service_id);

		$ch_auth_code 				= StepsFieldsClient::clientFieldQuery('ch_auth_code');
		$next_return 					= StepsFieldsClient::nextReturnQuery();
		$next_ret_due 				= StepsFieldsClient::clientFieldQuery('next_ret_due');
		$deadret_count 				= StepsFieldsClient::deadCountQuery('next_ret_due');

		$accounts_date 				= JobsManage::AccountDateQuery('next_made_up_to', 5);
		$return_due_date 			= JobsManage::ReturnDueDateQuery(5);//service id for accounts
		$ct_count_down 				= JobsManage::CtCountDownQuery(5);

		/* ============= Custom tasks ============ */
		$deadline_date				= JobsAccDetail::clientFieldQuery('deadline_date', $service_id);
		$cust_job_name				= JobsAccDetail::clientFieldQuery('job_name', $service_id);
		$count_down 					= JobsAccDetail::CountDownQuery('deadline_date', $service_id);
		$field1_value 				= StepsFieldsClient::clientFieldQuery($field1);
		$field2_value 				= StepsFieldsClient::clientFieldQuery($field2);

		if($sort[0] == 'client_name'){
			$header_sort = " order by ".$client_name.' '.$sort[1];
		}else if($sort[0] == 'effective_date'){
			$header_sort = " order by ".$effective_date.' '.$sort[1];
		}else if($sort[0] == 'vat_stagger'){
			$header_sort = " order by ".$vat_stagger.' '.$sort[1];
		}else if($sort[0] == 'ret_frequency'){
			$header_sort = " order by ".$ret_frequency.' '.$sort[1];
		}else if($sort[0] == 'job_start_date'){
			$header_sort = " order by ".$job_start_date.' '.$sort[1];
		}else if($sort[0] == 'incorporation_date'){
			$header_sort = " order by ".$incorporation_date.' '.$sort[1];
		}else if($sort[0] == 'year_end'){
			$header_sort = " order by ".$year_end.' '.$sort[1];
		}else if($sort[0] == 'deadacc_count'){
			$header_sort = " order by ".$deadacc_count.' '.$sort[1];
		}else if($sort[0] == 'next_made_up_to'){
			$header_sort = " order by jm.next_made_up_to ".$sort[1];
		}else if($sort[0] == 'next_acc_due'){
			$header_sort = " order by ".$next_acc_due.' '.$sort[1];
		}else if($sort[0] == 'job_name'){
			$header_sort = " order by jm.job_name ".$sort[1];
		}else if($sort[0] == 'ecsl_freq'){
			$header_sort = " order by ".$ecsl_freq.' '.$sort[1];
		}else if($sort[0] == 'ch_auth_code'){
			$header_sort = " order by ".$ch_auth_code.' '.$sort[1];
		}else if($sort[0] == 'next_ret_due'){
			$header_sort = " order by ".$next_ret_due.' '.$sort[1];
		}else if($sort[0] == 'deadret_count'){
			$header_sort = " order by ".$deadret_count.' '.$sort[1];
		}

		else if($sort[0] == 'cust_job_name'){
			$header_sort = " order by ".$cust_job_name.' '.$sort[1];
		}else if($sort[0] == 'deadline_date'){
			$header_sort = " order by ".$deadline_date.' '.$sort[1];
		}else if($sort[0] == 'count_down'){
			$header_sort = " order by ".$count_down.' '.$sort[1];
		}else if($sort[0] == $field1){
			$header_sort = " order by ".$field1_value.' '.$sort[1];
		}else if($sort[0] == $field2){
			$header_sort = " order by ".$field2_value.' '.$sort[1];
		}

		if(isset($search) && $search != ''){
			$where .= " AND (".$client_name." LIKE '%".$search."%' OR ";

			if($service_id == 1){
				$where .= $vat_stagger." LIKE '%".$search."%' OR ";
				$where .= $ret_frequency." LIKE '%".$search."%' OR ";
				$where .= $job_start_date." LIKE '%".$search."%' OR ";
				$where .= $effective_date." LIKE '%".$search."%' ) ";
			}
			if($service_id == 2){
				$where .= $vat_stagger." LIKE '%".$search."%' OR ";
				$where .= $ecsl_freq." LIKE '%".$search."%' OR ";
				$where .= $job_start_date." LIKE '%".$search."%' OR ";
				$where .= $effective_date." LIKE '%".$search."%' ) ";
			}
			if($service_id == 3){
				$where .= $incorporation_date." LIKE '%".$search."%' OR ";
				$where .= $year_end." LIKE '%".$search."%' OR ";
				$where .= $deadacc_count." LIKE '%".$search."%' OR ";
				$where .= "jm.next_made_up_to LIKE '%".$search."%' OR ";
				$where .= $next_acc_due." LIKE '%".$search."%' ) ";
			}
			if($service_id == 4){
				$where .= " DATE_FORMAT(jm.created,'%d-%m-%Y') LIKE '%".$search."%' ) ";
			}
			if($service_id == 5){
				$where .= $accounts_date." LIKE '%".$search."%' OR ";
				$where .= $return_due_date." LIKE '%".$search."%' OR ";
				$where .= $ct_count_down." LIKE '%".$search."%' OR ";
				$where .= $year_end." LIKE '%".$search."%' ) ";
			}
			if($service_id == 7){
				$where .= " jm.return_date LIKE '%".$search."%' ) ";
			}
			if($service_id == 8){
				$where .= " jm.job_name LIKE '%".$search."%' ) ";
			}

			if($service_id >9){
				$where .= $field1_value." LIKE '%".$search."%' OR ";
				$where .= $field2_value." LIKE '%".$search."%' OR ";
				$where .= $cust_job_name." LIKE '%".$search."%' OR ";
				$where .= $deadline_date." LIKE '%".$search."%' OR ";
				$where .= $count_down." LIKE '%".$search."%' ) ";
			}
			
		}

		//DATE_FORMAT( DATE_ADD(jm.created, INTERVAL ".$days." DAY),'%d-%m-%Y %H:%I') as job_start_date,

		$select = "select jm.job_manage_id, jm.status as manage_task, jm.return_date, jm.e_reminders, 
			IF(jm.next_made_up_to='0000-00-00', '', DATE_FORMAT( jm.next_made_up_to,'%d-%m-%Y') ) as next_made_up_to, c.client_id, c.type, DATE_FORMAT(jm.created,'%d-%m-%Y') as job_due_date,
			IF(period_end='0000-00-00','',DATE_FORMAT( period_end, '%d-%m-%Y') ) as period_end,
			jm.job_name,
			".$client_name." as client_name,
			".$effective_date." as effective_date,
			".$vat_stagger." as vat_stagger,
			".$ret_frequency." as ret_frequency,
			".$job_start_date." as job_start_date,
			".$incorporation_date." as incorporation_date,
			".$year_end." as year_end,
			".$deadacc_count." as deadacc_count,
			".$next_acc_due." as next_acc_due,
			".$accounts_date." as accounts_date,
			".$return_due_date." as return_due_date,
			".$ct_count_down." as ct_count_down,
			".$ecsl_freq." as ecsl_freq,
			".$completion_date." as completion_date,
			".$completion_days." as completion_days,
			".$ch_auth_code." as ch_auth_code,
			".$next_ret_due." as next_ret_due,
			".$next_return." as next_return,
			".$deadret_count." as deadret_count,

			".$cust_job_name." as cust_job_name,
			".$deadline_date." as deadline_date,
			".$count_down." as count_down,
			".$field1_value." as field1_value,
			".$field2_value." as field2_value
    "; 

    $query = " FROM jobs_manages jm JOIN clients c ON jm.client_id=c.client_id ";
    if(isset($status_id) && $status_id == 2){
    	$query .= " AND jm.job_manage_id NOT IN (select job_manage_id from job_statuses js where js.service_id='".$service_id."' AND js.is_completed='N' AND user_id IN('".implode(',', $groupUserId)."')) ";
		}else if($status_id > 2){
			//$query .= " JOIN job_statuses js ON js.status_id='".$status_id."' AND js.service_id='".$service_id."' AND js.is_completed='N' AND js.job_manage_id=jm.job_manage_id ";
			$query .= " AND jm.job_manage_id IN(select job_manage_id from job_statuses js where  js.status_id='".$status_id."' AND js.service_id='".$service_id."' AND js.is_completed='N' AND user_id IN('".implode(',', $groupUserId)."')) ";
		}

    
		$query .= $where.$header_sort;
    $sql_limit = $select.$query." limit ".$start.", ".$limit;
    //echo $sql_limit;die;
    $od = DB::select($sql_limit);

		//============== total count section ==============
    $total_qry 		= "select count(jm.client_id) as count ".$query;
    $totalVal 		= DB::select($total_qry);
    $total 				= json_decode(json_encode($totalVal), true);

		$data['details'] 			= json_decode(json_encode($od), true);
		$data['TotalRecord'] 	= $total[0]['count'];

    return $data;
	}

	public static function clientFieldQuery($field_name, $service_id)
	{
		$fields = " ( SELECT ".$field_name." FROM jobs_acc_details jad WHERE jad.client_id=c.client_id AND jad.service_id = '".$service_id."' group by client_id ) ";
		return $fields;
	}

	public static function completionDaysQuery($service_id)
	{
		$fields = " ( SELECT IF(completion_date='0000-00-00', '0', DATEDIFF( completion_date, CURDATE()) ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
		return $fields;
	}

	public static function clientDateFieldQuery($field_name, $service_id)
	{
		$fields = " ( SELECT IF(".$field_name."='0000-00-00','',DATE_FORMAT(".$field_name.",'%d-%m-%Y') ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
		return $fields;
	}

	public static function rollForwardDateFieldQuery($field_name, $service_id)
	{
		$fields = " ( SELECT IF(".$field_name."='0000-00-00','',DATE_FORMAT( DATE_ADD(".$field_name.",INTERVAL 1 YEAR), '%d-%m-%Y' ) ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
		return $fields;
	}


	public static function countQuery($field_name, $service_id)
	{
		$fields = " ( SELECT IF(".$field_name."='0000-00-00', '0', DATEDIFF( ".$field_name.", CURDATE()) ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
		return $fields;
	}

	public static function RollCountQuery($service_id)
	{
		$rolFwdEnd = " ( SELECT DATE_FORMAT(DATE_ADD(roll_fwd_end,INTERVAL 1 YEAR), '%Y-%m-%d')  FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id) ";
		$roll_count = " ( SELECT IF(roll_fwd_end='0000-00-00', '0', DATEDIFF( ".$rolFwdEnd." ,CURDATE() ) ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
		return $roll_count;
	}

	public static function CountDownQuery($field_name, $service_id)
	{
		$rolFwdEnd = " ( SELECT DATE_FORMAT(".$field_name.", '%Y-%m-%d') FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id) ";
		$roll_count = " ( SELECT IF(".$field_name."='0000-00-00', '0', DATEDIFF( ".$rolFwdEnd." ,CURDATE() ) ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=c.client_id group by client_id ) ";
		return $roll_count;
	}

	public static function CTReferenceQuery($service_id)
	{
		$tax_return_start = " (SELECT IF(tax_return_start='0000-00-00','',DATE_FORMAT(tax_return_start, '%d-%m-%Y') ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=jct.client_id group by client_id ) ";
		$tax_return_end 	= " (SELECT IF(tax_return_end='0000-00-00','',DATE_FORMAT(tax_return_end, '%d-%m-%Y') ) FROM jobs_acc_details WHERE service_id = '".$service_id."' AND client_id=jct.client_id group by client_id ) ";

		$tax_return = " ( SELECT CONCAT( ".$tax_return_start." , ' - ', ".$tax_return_end." ) ) ";
		return $tax_return;
	}







}
