<?php
class CrmProposalService  extends Eloquent{
	public $timestamps = false;

	public static function getProposalServicesNotesById($id)
	{
        $notes = '';
		$details = CrmProposalService::where('p_service_id', $id)->select('notes')->first();
        if(isset($details->notes) && $details->notes != ''){
            $notes = $details->notes;
        }
        return $notes;
	}

    public static function getFlexFeesById($id)
    {
        $flex_fees = 0;
        $details = CrmProposalService::where('p_service_id', $id)->select('flex_fees')->first();
        if(isset($details->flex_fees) && $details->flex_fees != ''){
            $flex_fees = $details->flex_fees;
        }
        return $flex_fees;
    }

    public static function getFeesById($id)
    {
        $fees = 0;
        $details = CrmProposalService::where('p_service_id', $id)->select('fees')->first();
        if(isset($details->fees) && $details->fees != ''){
            $fees = $details->fees;
        }
        return $fees;
    }

    public static function getTableIdByProposalServiceId($id)
    {
        $p_table_id = 0;
        $details = CrmProposalService::where('p_service_id', $id)->select('p_table_id')->first();
        if(isset($details->p_table_id) && $details->p_table_id != ''){
            $p_table_id = $details->p_table_id;
        }
        return $p_table_id;
    }

    public static function getFeeTableIdByPServiceId($p_service_id)
    {
        $fee_type = 0;
        $details = CrmProposalService::where('p_service_id', $p_service_id)->select('fee_type')->first();
        if(isset($details->fee_type) && $details->fee_type != ''){
            $fee_type = $details->fee_type;
        }
        return $fee_type;
    }

    public static function getSumFeesByTableId($table_id)
    {
        $fees =CrmProposalService::where('p_table_id',$table_id)->sum('fees');
        return $fees;
    }

    public static function getIsFeeAddedById($id)
    {
        $isFeeAdded = 'Y';
        $details = CrmProposalService::where('p_service_id', $id)->select('isFeeAdded')->first();
        if(isset($details->isFeeAdded) && $details->isFeeAdded != ''){
            $isFeeAdded = $details->isFeeAdded;
        }
        return $isFeeAdded;
    }

    public static function getServicesByTableId($p_table_id)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = DB::table('crm_proposal_services as cps')->whereIn('cps.user_id', $groupUserId)
            ->where('cps.p_table_id', $p_table_id)
            ->leftJoin('services as s', 's.service_id', '=', 'cps.service_id')
            ->select('cps.*', 's.service_name', 's.base_fee')->orderBy('cps.sorting', 'asc')
            ->get();
        //Common::last_query();die;
        return CrmProposalService::getArray($details, $groupUserId);
    }

    public static function getServicesByTableIdPreview($p_table_id, $groupUserId)
    {
        $details = DB::table('crm_proposal_services as cps')->whereIn('cps.user_id', $groupUserId)
            ->where('cps.p_table_id', '=', $p_table_id)
            ->leftJoin('services as s', 's.service_id', '=', 'cps.service_id')
            ->select('cps.*', 's.service_name', 's.base_fee')->orderBy('cps.sorting', 'asc')
            ->get();
        //Common::last_query();die;
        return CrmProposalService::getArray($details, $groupUserId);
    }

    public static function dataByTableAndBilling($p_table_id, $billing_freq, $groupUserId)
    {
        $details = DB::table('crm_proposal_services as cps')->whereIn('cps.user_id', $groupUserId)
            ->where('cps.p_table_id', $p_table_id)->where('cps.billing_freq', $billing_freq)
            ->leftJoin('services as s', 's.service_id', '=', 'cps.service_id')
            ->select('cps.*', 's.service_name', 's.base_fee')->orderBy('cps.sorting', 'asc')
            ->get();
        //Common::last_query();die;
        return CrmProposalService::getArray($details, $groupUserId);
    }

    public static function getPreviewFeesById($id)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $total = 0;
        $qry = CrmProposalService::where('p_table_id', $id)->get();
        $details = CrmProposalService::getArray($qry, $groupUserId);
        //Common::last_query();die;
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $total += $value['preview_fees'];
            }
        }
        return $total;
    }

    public static function getPreviewFeesByIdPreview($id, $groupUserId)
    {
        $total = 0;
        $qry = CrmProposalService::where('p_table_id', $id)->get();
        $details = CrmProposalService::getArray($qry, $groupUserId);
        //Common::last_query();die;
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $total += $value['preview_fees'];
            }
        }
        return $total;
    }

	public static function checkTable( $p_table_id, $service_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = CrmProposalService::whereIn('user_id', $groupUserId)->where('p_table_id', $p_table_id)
        ->where('service_id', $service_id)->first();
        $count = 0;
        if(isset($details) && count($details) >0 ){
        	$count = 1;
        }
        return $count;
	}

	public static function checkAlreadyAdded( $service_id, $proposal_id )
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
        $details = DB::table('crm_proposal_tables as cpt')->whereIn('cpt.user_id', $groupUserId)
	        ->where('cpt.proposal_id', '=', $proposal_id)
	        ->leftJoin('crm_proposal_services as cps', 'cpt.id', '=', 'cps.p_table_id')
	        ->where('cps.service_id', '=', $service_id)
	        ->select('cpt.id')->first();
	    //Common::last_query();//die;
        /*$details = CrmProposalService::whereIn('user_id',$groupUserId)->where('service_id','=',$service_id)->first();*/
        $count = 0;
        if(isset($details) && count($details) >0 ){
        	$count = count($details);
        }
        return $count;
	}

    public static function getDetailsById($id, $groupUserId)
    {
        $details = CrmProposalService::where('p_service_id', $id)->first();
        return CrmProposalService::getSingleArray($details, $groupUserId);
    }

    public static function getSingleArray($value, $groupUserId)
    {
        $d = array();
        if(isset($value) && count($value) >0){
            $pservid = $value->p_service_id;
            $feesTableDtls = array();
            $preview_fees   = CrmProposalActivity::getPreviewFeesByPServiceId($pservid);
            $activities     = CrmProposalActivity::getActitiesByPropServiceId($pservid, $groupUserId);

            /*if($value->fee_type != '' && $value->fee_type != 'fee_table' && $value->fee_type != 'fixed_fee'){
                $feesTableDtls  = CrmProposalServicesTable::getDetailsById($value->fee_type);
            }*/

            $feesTableDtls = CrmProposalServicesTable::getDetailsByProposalServiceId($pservid, $groupUserId);
            
            $d["p_service_id"]    = $value->p_service_id;
            $d["user_id"]         = $value->user_id;
            $d["p_table_id"]      = $value->p_table_id;
            $d["service_id"]      = $value->service_id;
            $d["service_name"]    = $value->service_name;
            $d["notes"]           = $value->notes;
            $d["fee_type"]        = $value->fee_type;
            $d["flex_fees"]       = ($value->flex_fees != '0')?$value->flex_fees:'100';
            $d["fees"]            = ($value->fees != '0.00')?$value->fees:'';
            $d["is_show_fees"]    = $value->is_show_fees;
            $d["billing_freq"]    = $value->billing_freq;
            $d["taxRate"]         = $value->tax_rate;
            $d["taxPercent"]      = TaxRate::getTaxPercentById($value->tax_rate);
            $d["sorting"]         = $value->sorting;
            $d["preview_fees"]    = empty($activities)?$value->fees:$preview_fees;
            $d["isFeeAdded"]      = $value->isFeeAdded;
            $d["base_fee"]        = ProposalService::getPriceByServiceId($value->service_id);
            $d["created"]         = $value->created;
            $d["activities"]      = $activities;
            $d["feesTableDtls"]   = $feesTableDtls;
            $d["tax_rate"]        = ProposalService::getTaxRateIdByServiceId($value->service_id);
            $d["table_id"]        = CrmProposalServicesTable::checkIsTableAdded($value->p_service_id);
        }
        return $d;
    }

	public static function getArray($details, $groupUserId)
    {
        $d = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $pservid = $value->p_service_id;
                $feesTableDtls = array();

                $preview_fees   = CrmProposalActivity::getPreviewFeesByPServiceId($pservid);
                $activities     = CrmProposalActivity::getActitiesByPropServiceId($pservid, $groupUserId);

                /*if($value->fee_type != '' && $value->fee_type != 'fee_table' && $value->fee_type != 'fixed_fee'){
                  //$feesTableDtls  = CrmProposalServiceFee::getDetailsByProposalServiceId($pservid,$groupUserId);
                    $feesTableDtls  = CrmProposalServicesTable::getDetailsById($value->fee_type);
                }*/
                $feesTableDtls = CrmProposalServicesTable::getDetailsByProposalServiceId($pservid, $groupUserId);
                

                $d[$key]["p_service_id"]    = $value->p_service_id;
                $d[$key]["user_id"]         = $value->user_id;
                $d[$key]["p_table_id"]     	= $value->p_table_id;
                $d[$key]["service_id"]    	= $value->service_id;
                $d[$key]["service_name"]    = $value->service_name;
                $d[$key]["notes"]           = $value->notes;
                $d[$key]["fee_type"]        = $value->fee_type;
                //$d[$key]["hrs"]             = ($value->hrs != '0.00')?$value->hrs:'';
                $d[$key]["flex_fees"]       = ($value->flex_fees != '0')?$value->flex_fees:'100';
                $d[$key]["fees"]            = ($value->fees != '0.00')?$value->fees:'';
                $d[$key]["is_show_fees"]    = $value->is_show_fees;
                $d[$key]["billing_freq"]    = $value->billing_freq;
                $d[$key]["taxRate"]         = $value->tax_rate;
                $d[$key]["taxPercent"]      = TaxRate::getTaxPercentById($value->tax_rate);
                $d[$key]["sorting"]        	= $value->sorting;
                $d[$key]["preview_fees"]    = (empty($activities) || $value->isFeeAdded=='N')?$value->fees:$preview_fees;
                $d[$key]["isFeeAdded"]      = $value->isFeeAdded;
                $d[$key]["base_fee"]        = ProposalService::getPriceByServiceId($value->service_id);
                $d[$key]["created"] 		= $value->created;
                $d[$key]["activities"]      = $activities;
                $d[$key]["feesTableDtls"]   = $feesTableDtls;
                $d[$key]["tax_rate"]        = ProposalService::getTaxRateIdByServiceId($value->service_id);
                $d[$key]["table_id"]        = CrmProposalServicesTable::checkIsTableAdded($value->p_service_id);
            }
        }
        return $d;
    }

    public static function updateServiceFees($p_service_id)
    {
        $dataCPS['fees'] = CrmProposalActivity::getPreviewFeesByPServiceId($p_service_id);
        $dataCPS['flex_fees'] = 100;
        CrmProposalService::where('p_service_id',$p_service_id)->update($dataCPS);
    }

    public static function checkDataByServiceId($service_id)
    {
        $count =CrmProposalService::where('service_id',$service_id)->count();
        return $count;
    }

    public static function checkDataByTaxRate($tax_rate)
    {
        $count =CrmProposalService::where('tax_rate',$tax_rate)->count();
        return $count;
    }

    public static function getServicesIdByClient($prospect_id, $contact_type)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        /*$proposals = CrmProposalService::where("prospect_id", $prospect_id)->where("contact_type", $type)->select('proposalID')->get();
        if(isset($proposals) && count($proposals) >0){
            foreach ($proposals as $k => $v) {
                
            }
        }*/

        $details = DB::table('crm_proposal_services as cps')->whereIn('cps.user_id', $groupUserId)
            ->leftJoin('crm_proposal_tables as cpt', 'cpt.id', '=', 'cps.p_table_id')
            ->leftJoin('crm_proposals as cp', 'cpt.proposal_id', '=', 'cp.proposalID')
            ->where("prospect_id", $prospect_id)->where("contact_type", $contact_type)
            ->where("cps.is_signed", 'Y')
            ->select('cps.service_id')->groupBy('cps.service_id')->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $k => $v) {
                $data[$k] = $v->service_id;
            }
        }
        return $data;
    }

}
