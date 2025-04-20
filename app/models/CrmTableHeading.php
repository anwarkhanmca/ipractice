<?php
class CrmTableHeading  extends Eloquent{
	
	public $timestamps = false;
	
	/*public static function getAllHeadings()
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = DB::table('crm_table_headings')
            ->where(function ($query) use ($groupUserId)  {
                $query->whereIn('user_id', $groupUserId)
            ->orWhere('user_id', '=', '0');
            })->get();
        return CrmTableHeading::getArray($details);
	}*/
	public static function getAllHeadings()
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

		$details = CrmTableHeading::whereIn('user_id', $groupUserId)->get();
        return CrmTableHeading::getArray($details);
	}

	public static function getAllData()
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = DB::table('crm_table_headings as cth')->whereIn('cth.user_id', $groupUserId)
    	->leftjoin('package_types as pt', 'cth.package_type', '=', 'pt.value')
    	->select('cth.*', 'pt.name as package_name')
    	->get();

    return json_decode(json_encode($details), true);
	}

	public static function getTableHeadingsData($is_archive)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = DB::table('crm_table_headings as cth')->whereIn('cth.user_id', $groupUserId)
    	->where('cth.is_archive', $is_archive)
    	->leftjoin('package_types as pt', 'cth.package_type', '=', 'pt.value')
    	->select('cth.*', 'pt.name as package_name')
    	->get();

    return json_decode(json_encode($details), true);
	}

	public static function getDetailsById($heading_id)
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = DB::table('crm_table_headings as cth')->whereIn('cth.user_id', $groupUserId)
    	->where('cth.heading_id', $heading_id)
    	->leftjoin('package_types as pt', 'cth.package_type', '=', 'pt.value')
    	->select('cth.*', 'pt.name as package_name')
    	->first();

    return json_decode(json_encode($details), true);
	}

	public static function getDetailsByHeadingId($heading_id)
  {
  	$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = CrmTableHeading::whereIn('user_id', $groupUserId)->where('heading_id', $heading_id)->get();
    return CrmTableHeading::getArray($details);
  }

  public static function getPackageTypeByHeadingId($heading_id)
  {
  	$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details        = CrmTableHeading::where('heading_id', $heading_id)->select('package_type')->first();
    //Common::last_query();
    $ret_value = '';
    if(isset($details['package_type']) && $details['package_type'] != "")
        $ret_value = $details['package_type'];
    return $ret_value;
  }

	/*public static function getAllShowHeadings()
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = DB::table('crm_table_headings')->where('is_show', '=', 'Y')
            ->where(function ($query) use ($groupUserId)  {
                $query->whereIn('user_id', $groupUserId)
            ->orWhere('user_id', '=', '0');
            })->get();
        
        return CrmTableHeading::getArray($details);
	}*/
	public static function getAllShowHeadings()
	{
		$session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

		$details = CrmTableHeading::whereIn('user_id', $groupUserId)->where('is_show', 'Y')->get();
        
    return CrmTableHeading::getArray($details);
	}

	public static function getArray($details)
	{
		$data = array();
		if(isset($details) && count($details) >0 )
    {
    	foreach ($details as $key => $v) {
    		$p_id = $v->proposal_id;
    		$h_id = $v->heading_id;

    		$data[$key]['heading_id'] 		= $v->heading_id;
				$data[$key]['user_id'] 			= $v->user_id;
				$data[$key]['proposal_id'] 		= $v->proposal_id;
				$data[$key]['heading_name'] 	= $v->heading_name;
				$data[$key]['status'] 			= $v->status;
				$data[$key]['is_show'] 			= $v->is_show;
				$data[$key]['is_archive'] 		= $v->is_archive;
				$data[$key]['package_name'] 	= PackageType::getPackageNameByType($v->package_type);
				$data[$key]['created'] 			= $v->created;
				$data[$key]['crm_proptbl_id'] 	= CrmProposalTable::getCrmpropTableId($p_id, $h_id);
  		}
  	}
  	return $data;
	}


	public static function insert_data($postData)
	{
		$session        = Session::get('admin_details');
    $user_id    	= $session['id'];

		$data['heading_name'] 	= $postData['heading_name'];
		$data['proposal_id'] 	= $postData['proposal_id'];
		$data['user_id'] 		= $user_id;
		$data['status'] 		= 'new';
		$data['is_show'] 		= 'N';
		$data['package_type'] 	= $postData['package_type'];
		$data['added_from'] 	= 'AE';
		$data['created'] 		= date('Y-m-d H:i:s');
		$data['heading_id'] 	= CrmTableHeading::insertGetId($data);
		//Common::last_query();die;
		$data['package_name'] 	= PackageType::getPackageNameByType($postData['package_type']);

		//Common::last_query();die;
		return $data;
	}

}
