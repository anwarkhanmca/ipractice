<?php
class CrmProposalComment extends Eloquent {
	public $timestamps = false;

	public static function getDetailsByCrmProposalId($crm_proposal_id)
    {
        $details = CrmProposalComment::where('crm_proposal_id', $crm_proposal_id)->orderBy('id', 'desc')->get();
		return CrmProposalComment::getArray($details);
    }

    public static function getUnreadCount($crm_proposal_id)
    {
        $count=CrmProposalComment::where('crm_proposal_id',$crm_proposal_id)->where('is_read','N')->get()->count();
		return $count;
    }



    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
            	if($value->added_from == 'preview'){
            		$previewSender = CrmProposal::getSenderByCrmProposalId($value->crm_proposal_id);
            	}else{
            		$previewSender = User::getStaffNameById($value->user_id);
            	}
                $data[$key]['id']  				= $value->id;
                $data[$key]['user_id']  		= $value->user_id;
                $data[$key]['crm_proposal_id']  = $value->crm_proposal_id;
                $data[$key]['comment']    		= $value->comment;
                $data[$key]['previewSender']    = $previewSender;
                $data[$key]['is_read']    		= $value->is_read;
                $data[$key]['created']          = date('d-m-Y', strtotime($value->created));
                $data[$key]['created_format']   = date('l, d F Y H:i', strtotime($value->created));
                $data[$key]['modified']         = date('d-m-Y', strtotime($value->modified));
            }
        }
        return $data;
    }
	

}
