<?php
class CrmProposalId extends Eloquent {

	public $timestamps = false;

	public static function getNewProposalId()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = CrmProposalId::whereIn('user_id', $groupUserId)->select('proposal_id')->orderBy('proposal_id','DESC')->first();
        if(isset($details->proposal_id) && $details->proposal_id !=''){
            $proposal_id = $details->proposal_id + 1;
        }else{
            $proposal_id = 100001;
        }
        return $proposal_id;
    }

    public static function insertProposalId($proposal_id)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $pId['user_id']     = $user_id;
        $pId['proposal_id'] = $proposal_id;
        $lastId = CrmProposalId::insertGetId($pId);
        return $lastId;
    }

}
