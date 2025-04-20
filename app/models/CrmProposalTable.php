<?php
class CrmProposalTable  extends Eloquent{
	public $timestamps = false;
	
	public static function getDetailsByProposalId( $proposal_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
        ->where('cpt.proposal_id', '=', $proposal_id)
        ->leftJoin('crm_table_headings as cth', 'cpt.heading_id', '=', 'cth.heading_id')
        ->select('cpt.*', 'cth.heading_name')->orderBy('cpt.sorting', 'asc')
        ->get();
        //Common::last_query();die;
		return CrmProposalTable::getArray($details, $groupUserId);
	}

	public static function getDetailsPreview( $proposal_id, $groupUserId )
	{
		$details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
        ->where('cpt.proposal_id', '=', $proposal_id)
        ->leftJoin('crm_table_headings as cth', 'cpt.heading_id', '=', 'cth.heading_id')
        ->select('cpt.*', 'cth.heading_name')->orderBy('cpt.sorting', 'asc')
        ->get();
        //Common::last_query();die;
		return CrmProposalTable::getArray($details, $groupUserId);
	}

	public static function getGrandDetailsByProposalId( $proposal_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
        ->where('cpt.proposal_id', '=', $proposal_id)
        ->where('cpt.is_show', 'G')
        ->leftJoin('crm_table_headings as cth', 'cpt.heading_id', '=', 'cth.heading_id')
        ->select('cpt.*', 'cth.heading_name')->orderBy('cpt.sorting', 'asc')
        ->get();
        //Common::last_query();die;
		return CrmProposalTable::getArray($details, $groupUserId);
	}

	public static function getGrandDetailsPreview( $proposal_id, $groupUserId )
	{
		$details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
        ->where('cpt.proposal_id', '=', $proposal_id)
        ->where('cpt.is_show', 'G')
        ->leftJoin('crm_table_headings as cth', 'cpt.heading_id', '=', 'cth.heading_id')
        ->select('cpt.*', 'cth.heading_name')->orderBy('cpt.sorting', 'asc')
        ->get();
        //Common::last_query();die;
		return CrmProposalTable::getArray($details, $groupUserId);
	}

	

	public static function checkTable( $proposal_id, $heading_id )
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTable::whereIn('user_id', $groupUserId)->where('proposal_id', $proposal_id)
        ->where('heading_id', $heading_id)->first();
        $show_table = '';
        if(isset($details) && count($details) >0 ){
        	$show_table = $details->is_show;
        }
        return $show_table;
	}

  public static function getIdByProposalId( $proposal_id )
  {
    $session        = Session::get('admin_details');
    $groupUserId    = $session['group_users'];

    $details = CrmProposalTable::whereIn('user_id', $groupUserId)->where('proposal_id', $proposal_id)
    ->select('id')->first();
    $id = 0;
    if(isset($details['id']) && $details['id'] != '' ){
      $id = $details['id'];
    }
    return $id;
  }

    public static function checkSeparateTable( $proposal_id, $heading_id )
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTable::whereIn('user_id', $groupUserId)->where('proposal_id', $proposal_id)
        ->where('heading_id', $heading_id)->where('show_other', 'Y')->first();
        $show_table = 'N';
        if(isset($details) && count($details) >0 ){
            $show_table = 'Y';
        }
        return $show_table;
    }

    public static function checkGroupTable( $proposal_id, $heading_id )
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTable::whereIn('user_id', $groupUserId)->where('proposal_id', $proposal_id)
        ->where('heading_id', $heading_id)->where('show_group', 'Y')->first();
        $show_table = 'N';
        if(isset($details) && count($details) >0 ){
            $show_table = 'Y';
        }
        return $show_table;
    }
    
    public static function getCrmpropTableId( $proposal_id, $heading_id )
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTable::whereIn('user_id', $groupUserId)->where('proposal_id', $proposal_id)
        ->where('heading_id', $heading_id)->select('id')->first();
        $id = '0';
        if(isset($details->id) && $details->id != '' ){
            $id = $details->id;
        }
        //Common::last_query();die;
        return $id;
    }

	public static function getFeesByProposalId( $proposal_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $sum =CrmProposalTable::whereIn('user_id',$groupUserId)->where('proposal_id',$proposal_id)->sum('fees');
        //Common::last_query();
		return $sum;
	}

    public static function getGrossFeesByProposalId( $proposal_id )
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $gross1 = $gross2 = 0;

        $data['content']        = CrmProposalTable::getOtherTableDetails($proposal_id, $groupUserId);
        $data['grandTotals']    = CrmProposalTable::getGrandDetailsPreview( $proposal_id, $groupUserId );

        //Common::last_query();
        if(isset($data['content']) && count($data['content']) >0){
            $Grand1 = 0;
            foreach ($data['content'] as $k => $v) {
                if(isset($v['show_other']) && $v['show_other'] =='Y'){
                    if(isset($v['package_type']) && $v['package_type'] =='R' || $v['package_type'] =='F'){
                        if(isset($v['services']) && count($v['services']) > 0){
                            foreach($v['services'] as $k=>$vs){
                                //$Grand1 += $vs['fees'];
                                $vat = 0;
                                if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee'){
                                    $vat = ($vs['taxPercent']*$vs['fees'])/100;
                                }
                                $gross1 += $vs['fees']+$vat;
                            }
                        }
                    }
                    
                }
            }
        }

        $grang_total = 0;
        if(isset($data['grandTotals']) && count($data['grandTotals']) > 0){
            foreach($data['grandTotals'] as $k=>$v){
                if(isset($v['show_group']) && $v['show_group'] =='Y'){
                    //$grang_total += str_replace(',','',$v['preview_fees']);
                    if(isset($v['package_type']) && $v['package_type']=='R' || $v['package_type']=='F'){
                        if(isset($v['services']) && count($v['services']) > 0){
                            foreach($v['services'] as $k=>$vs){
                                $vat2 = 0;
                                //$grang_total += $vs['fees'];
                                if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee'){
                                    $vat2 = ($vs['taxPercent']*$vs['fees'])/100;
                                }
                                $gross2 += ($vs['fees']+$vat2);
                            }
                        }
                    }
                    //$gross2 = $grang_total+$vat2;
                }
            }
        }
        $gross = $gross1+$gross2;
        return number_format($gross, 2);
    }

    public static function getProposalAmountByProposalId( $proposal_id )
    {
      $session        = Session::get('admin_details');
      $user_id        = $session['id'];
      $groupUserId    = $session['group_users'];
      $gross = 0;

      $data['content']  = CrmProposalTable::getOtherTableDetails($proposal_id, $groupUserId);

      //Common::last_query();
      if(isset($data['content']) && count($data['content']) >0){
        foreach ($data['content'] as $k => $v) {
          if(isset($v['show_other']) && $v['show_other'] == 'Y'){
            if( $v['package_type'] != 'O' && $v['package_type'] !='C'){
              if(isset($v['services']) && count($v['services']) > 0){
                foreach($v['services'] as $k=>$vs){
                  $vat = 0;
                  if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee'){
                    $vat = ($vs['taxPercent']*$vs['fees'])/100;
                  }
                  $gross += $vs['fees']+$vat;
                }
              }
            }
          }
        }
      }

      return number_format($gross, 2);
    }

    public static function getDetailsByHeadingId($heading_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTable::whereIn('user_id', $groupUserId)->where('heading_id', $heading_id)
            ->where('proposal_id', '!=', 99999)->get();
        return CrmProposalTable::getArray($details, $groupUserId);
    }

	public static function getArray($details, $groupUserId)
	{
		$data = array();
		if(isset($details) && count($details) >0 )
        {
        	foreach ($details as $key => $value) {
        		$services 		= CrmProposalService::getServicesByTableIdPreview($value->id, $groupUserId);
        		$preview_fees 	= CrmProposalService::getPreviewFeesByIdPreview($value->id, $groupUserId);

                $data[$key]['id'] 			= $value->id;
				$data[$key]['user_id'] 		= $value->user_id;
				$data[$key]['proposal_id'] 	= $value->proposal_id;
				$data[$key]['heading_id'] 	= $value->heading_id;
				$data[$key]['heading_name'] = $value->heading_name;
				$data[$key]['services'] 	= $services;
				$data[$key]['fees'] 		= ($value->fees != '0.00')?$value->fees:'';
				$data[$key]["preview_fees"] = $preview_fees;
				$data[$key]['sorting'] 		= $value->sorting;
				$data[$key]['is_show'] 		= $value->is_show;
                $data[$key]['show_other']   = $value->show_other;
                $data[$key]['show_group']   = $value->show_group;
                $data[$key]['recurring']    = $value->recurring;
                $data[$key]['package_type'] = $value->package_type;
				$data[$key]['created'] 		= $value->created;
        	}
    	}
    	return $data;
	}


    public static function updateTableFees($p_service_id)
    {
        $p_table_id         = CrmProposalService::getTableIdByProposalServiceId($p_service_id);
        $Tbldata['fees']    = CrmProposalService::getSumFeesByTableId($p_table_id );
        CrmProposalTable::where('id',$p_table_id)->update($Tbldata);
    }

    public static function getOtherTableDetails($proposal_id, $groupUserId)
    {
        $data = array();

        $details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
        ->where('cpt.proposal_id', $proposal_id)->where('cpt.show_other', 'Y')
        ->leftJoin('crm_table_headings as cth', 'cpt.heading_id', '=', 'cth.heading_id')
        ->select('cpt.*', 'cth.heading_name')->orderBy('cpt.sorting', 'asc')
        ->get();
        //Common::last_query();die;

        $content =  CrmProposalTable::getArray($details, $groupUserId);
        if(isset($content) && count($content) >0){
            foreach ($content as $k => $v) {
                if(isset($v['services']) && count($v['services']) >0 ){
                    foreach ($v['services'] as $ks => $vs) {
                        $billing = array();

                        $billfreqArr = CrmProposalTable::getBillingFrequency();
                        foreach ($billfreqArr as $kba => $vba) {
                            $mnth = CrmProposalService::dataByTableAndBilling($v['id'],$vba,$groupUserId);
                            if(isset($mnth) && count($mnth) >0){
                                $grosAmnt = 0;
                                foreach ($mnth as $kc => $vc) {
                                    if(isset($vc['fee_type']) && $vc['fee_type'] == 'fixed_fee'){
                                        $grosAmnt += $vc['preview_fees']+($vc['taxPercent']*$vc['preview_fees'])/100;
                                    }
                                }
                                $kba = ($kba == 'IA' || $kba == 'OC')?'1':$kba;
                                $mba = ($kba == '12')?$kba:'&nbsp; '.$kba;
                                
                                $billing[$vba]['left']      = $mba;
                                $billing[$vba]['right']     = number_format($grosAmnt/$kba, 2);
                                $billing[$vba]['amount']    = number_format($grosAmnt, 2);
                            }
                        }
                    }
                }
                $data[$k] = $v;
                $data[$k]['billing'] = !empty($billing)?$billing:array();
            }
        }

        //echo "<pre>";print_r($data);die;
        return $data;
    }


    public static function getBillingFrequency()
    {
        $data['12'] = 'Monthly';
        $data['2']  = 'Six Monthly';
        $data['4']  = 'Quarterly';
        $data['1']  = 'Yearly';
        $data['IA'] = 'In Advance';
        $data['OC'] = 'On Completion';

        return $data;
    }

    public static function getRecurringValue($proposal_id, $heading_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTable::whereIn('user_id', $groupUserId)->where('proposal_id', $proposal_id)->where('heading_id', $heading_id)->select('package_type')->first();
        $recurring = 'F';
        if(isset($details['package_type']) && $details['package_type'] != ''){
            $recurring = $details['package_type'];
        }
        return $recurring;
    }

    public static function getPackageTypeById($id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $packages = CrmProposalTable::whereIn('user_id', $groupUserId)->where('id',$id)->select('package_type')->first();

        $package_type = '';
        if(isset($packages->package_type) && $packages->package_type != ''){
            $package_type = $packages->package_type;
        }
        return $package_type;
    }

    public static function getRecurAmntByProposalId($proposal_id, $groupUserId)
    {
        $details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
        ->where('cpt.proposal_id', $proposal_id)->where('cpt.package_type', 'R')->select('cpt.id')->get();
        //Common::last_query();die;

        $grang_total    = 0;
        $gross          = 0;
        if(isset($details) && count($details) > 0){
            foreach($details as $k=>$v){
                $services = CrmProposalService::getServicesByTableIdPreview($v->id, $groupUserId);
                //echo "<pre>";print_r($services);die;
                
                if(isset($services) && count($services) > 0){
                    foreach($services as $k=>$vs){
                        //$grang_total += $vs['fees'];
                        $vat = 0;
                        /*if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee'){
                            $vat = ($vs['taxPercent']*$vs['fees'])/100;
                        }*/
                        $gross += ($vs['fees']+$vat);
                    }
                    //$gross += $grang_total+$vat;
                }

            }
        }

        return $gross;
    }

    public static function getNonRecurAmntByProposalId($proposal_id, $groupUserId)
    {
        $details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
        ->where('cpt.proposal_id', $proposal_id)->where('cpt.package_type', 'F')->select('cpt.id')->get();
        //Common::last_query();die;

        $grang_total    = 0;
        $gross          = 0;
        if(isset($details) && count($details) > 0){
            foreach($details as $k=>$v){
                $services = CrmProposalService::getServicesByTableIdPreview($v->id, $groupUserId);
                
                if(isset($services) && count($services) > 0){
                    foreach($services as $k=>$vs){
                        $vat = 0;
                        $gross += ($vs['fees']+$vat);
                    }
                }
            }
        }

        return $gross;
    }


    public static function getAmountByTableId( $p_table_id )
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $gross = 0;

        $services = CrmProposalService::getServicesByTableIdPreview($p_table_id, $groupUserId);

        //Common::last_query();
        if(isset($services) && count($services) > 0){
            foreach($services as $k=>$vs){
                $vat = 0;
                if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee'){
                    $vat = ($vs['taxPercent']*$vs['fees'])/100;
                }
                $gross += $vs['fees']+$vat;
            }
        }

        return number_format($gross, 2);
    }


  public static function copyProposalTableData($Idata, $settingsPId)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $old_proposal_id = $settingsPId;
    $new_proposal_id = $Idata['proposal_id'];

    $tables = CrmProposalTable::whereIn('user_id', $groupUserId)->where('heading_id', $Idata['heading_id'])->where('proposal_id',$old_proposal_id)->get()->toArray();

    foreach ($tables as $t) 
    {
      $old_p_table_id = $t['id'];
      unset($t['id']);
      $t['proposal_id']   = $new_proposal_id;
      $t['package_type']  = CrmTableHeading::getPackageTypeByHeadingId($Idata['heading_id']);
      $p_table_id = CrmProposalTable::insertGetId($t);

      $services   = CrmProposalService::where('p_table_id', $old_p_table_id )->get()->toArray();
      foreach ($services as $s) 
      {
        $old_p_service_id = $s['p_service_id'];
        unset($s['p_service_id']);
        $s['p_table_id'] = $p_table_id;
        $p_service_id = CrmProposalService::insertGetId($s);

        $services   = CrmProposalActivity::where('p_service_id', $old_p_service_id )->get()->toArray();
        foreach ($services as $a) 
        {
            unset($a['p_activity_id']);
            $a['p_service_id'] = $p_service_id;
            $p_activity_id = CrmProposalActivity::insertGetId($a);
        }

        /* crm_proposal_service_fees */
        $sfees  = CrmProposalServiceFee::where('p_service_id', $old_p_service_id )->where('proposal_id', $old_proposal_id )->get()->toArray();
        foreach ($sfees as $sf) 
        {
            unset($sf['id']);
            $sf['p_service_id'] = $p_service_id;
            $sf['proposal_id']  = $new_proposal_id;
            $p_activity_id = CrmProposalServiceFee::insertGetId($sf);
        }
      }
    }

  }

  public static function removeProposalTableData($heading_id, $proposal_id)
  {
    $session        = Session::get('admin_details');
    $user_id        = $session['id'];
    $groupUserId    = $session['group_users'];

    $dtls1 = CrmProposalTable::whereIn('user_id', $groupUserId)->where('heading_id', $heading_id)->where('proposal_id', $proposal_id)->select('id')->get();
    if(isset($dtls1) && count($dtls1) >0){
      foreach ($dtls1 as $k => $v) {
        CrmProposalTable::where('id', $v->id)->delete();

        $dtls2=CrmProposalService::whereIn('user_id',$groupUserId)->where('p_table_id',$v->id)->select('p_service_id')->get();
        if(isset($dtls2) && count($dtls2) >0){
          foreach ($dtls2 as $k => $v1) {
            CrmProposalActivity::where('p_service_id',$v1->p_service_id)->delete();
            CrmProposalServiceFee::where('p_service_id', $v1->p_service_id )->where('proposal_id', $proposal_id )->delete();
          }
        }
        CrmProposalService::where('p_table_id', $v->id )->delete();

      }
    }

    CrmProposalGrandTotal::whereIn('user_id', $groupUserId)->where('heading_id', $heading_id)->where('proposal_id', $proposal_id)->delete();

  }


}
