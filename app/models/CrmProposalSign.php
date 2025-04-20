<?php
class CrmProposalSign  extends Eloquent{
	public $timestamps = false;

	public static function getDetailsById( $id )
	{
		$details = CrmProposalSign::where('id',$id)->first();
		return CrmProposalSign::getSingleArray($details);
	}

    public static function getDetailsByCrmProposalId( $crm_proposal_id )
    {
        $details = CrmProposalSign::where('crm_proposal_id',$crm_proposal_id)->first();
        return CrmProposalSign::getSingleArray($details);
    }

	public static function getSingleArray($value)
	{
		$data = array();
		if(isset($value) && count($value) >0 )
        {
        	$data['id']                = $value->id;
            $data['crm_proposal_id']   = $value->crm_proposal_id;
            $data['save_type']         = CrmProposal::getSaveTypeById($value->crm_proposal_id);
            $data['signature']         = $value->signature;
            $data['ip_address']        = $value->ip_address;
            $data['created']           = $value->created;
            $data['added']             = date('l, d F Y H:i', strtotime($value->created));
            $data['updated']           = $value->updated;
    	}
    	return $data;
	}

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0 )
        {
            foreach ($details as $key => $value) {
                $data[$key]['id']                = $value->id;
                $data[$key]['crm_proposal_id']   = $value->crm_proposal_id;
                $data[$key]['save_type']         = CrmProposal::getSaveTypeById($value->crm_proposal_id);
                $data[$key]['signature']         = $value->signature;
                $data[$key]['ip_address']        = $value->ip_address;
                $data[$key]['created']           = $value->created;
                $data[$key]['added']             = date('l, d F Y H:i', strtotime($value->created));
                $data[$key]['updated']           = $value->updated;
            }
        }
        return $data;
    }
}
