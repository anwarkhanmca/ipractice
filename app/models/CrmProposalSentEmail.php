<?php
class CrmProposalSentEmail extends Eloquent {
	public $timestamps = false;

	public static function getDetailsByCrmProposalId($crm_proposal_id)
    {
        $details = CrmProposalSentEmail::where('crm_proposal_id', $crm_proposal_id)->first();
		return CrmProposalSentEmail::getSingleArray($details);
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data['id']               = $value->id;
            $data['user_id']          = $value->user_id;
            $data['crm_proposal_id']  = $value->crm_proposal_id;
            $data['save_type']        = CrmProposal::getSaveTypeById($value->crm_proposal_id);
            $data['email']            = $value->email;
            $data['created']          = date('d-m-Y', strtotime($value->created));
            $data['created_format']   = date('l, d F Y H:i', strtotime($value->created));
        }
        return $data;
    }
	
    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['id']               = $value->id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['crm_proposal_id']  = $value->crm_proposal_id;
                $data[$key]['save_type']        = CrmProposal::getSaveTypeById($value->crm_proposal_id);
                $data[$key]['email']            = $value->email;
                $data[$key]['created']          = date('d-m-Y', strtotime($value->created));
                $data[$key]['created_format']   = date('l, d F Y H:i', strtotime($value->created));
            }
        }
        return $data;
    }

    public static function saveEmailAddress($actionEmail, $crm_proposal_id)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $Data['email'] = $actionEmail;

        $details = CrmProposalSentEmail::where('crm_proposal_id', $crm_proposal_id)->first();
        if(isset($details) && count($details) >0){
            CrmProposalSentEmail::where('crm_proposal_id', $crm_proposal_id)->update($Data);
        }else{
            $Data['user_id']            = $user_id;
            $Data['crm_proposal_id']    = $crm_proposal_id;
            $Data['created']            = date('Y-m-d H:i:s');
            CrmProposalSentEmail::insertGetId($Data);
        }
    }

    public static function getEmailByCrmProposalId($crm_proposal_id)
    {
        $email = '';
        $details = CrmProposalSentEmail::where('crm_proposal_id', $crm_proposal_id)->select('email')->first();
        if(isset($details->email) && $details->email != ''){
            $email = $details->email;
        }
        return $email;
    }

}
