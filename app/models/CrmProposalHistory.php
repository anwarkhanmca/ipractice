<?php
class CrmProposalHistory  extends Eloquent{
	public $timestamps = false;
    public $user_id;
    public $groupUserId;

    public function __construct()
    {
        parent::__construct();
        $session            = Session::get('admin_details');
        $this->user_id      = $session['id'];
        $this->groupUserId  = $session['group_users'];
    }

    public static function getHistoryProposalById($proposal_id)
    {
        $session      = Session::get('admin_details');
        $user_id      = $session['id'];
        $groupUserId  = $session['group_users'];

        $details = CrmProposalHistory::whereIn('user_id',$groupUserId)->where('proposal_id',$proposal_id)->get();

        return CrmProposalHistory::getArray($details);
    }

    public static function getHistoryById($id)
    {
        $details = CrmProposalHistory::where('id', $id)->first();

        return CrmProposalHistory::getSingleArray($details);
    }

    public static function insertProposalHistory($postData)
    {
        $session      = Session::get('admin_details');
        $user_id      = $session['id'];

        $data['user_id']        = !isset($user_id)?$postData['user_id']:$user_id;
        $data['proposal_id']    = $postData['proposalID'];
        $data['event_type']     = CrmProposalHistory::getFullType($postData['save_type']);
        $data['ip_address']     = Common::get_ip_address();
        $data['created']        = date('Y-m-d H:i:s');

        $details = CrmProposalHistory::where('user_id',$data['user_id'])->where('proposal_id',$data['proposal_id'])->where('event_type',$data['event_type'])->where('ip_address',$data['ip_address'])->first();
        if(empty($details))
            CrmProposalHistory::insert($data);
    }

    

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data["id"]               = $value->id;
            $data["user_id"]          = $value->user_id;
            $data["proposal_id"]      = $value->proposal_id;
            $data["event_type"]       = $value->event_type;
            $data["ip_address"]       = $value->ip_address;
            $data["created"]          = $value->created;
            //$data['added']            = date('l, d F Y H:i:s', strtotime($value->created));
            $data['added']            = date('d/m/Y H:i:s', strtotime($value->created));
        }
        return $data;
    }

	public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                if($value->event_type == 'Viewed' || $value->event_type == 'Signed'){
                    $crm_proposal_id = CrmProposal::getIdByProposalId($value->proposal_id);
                    $user_name = CrmProposalSentEmail::getEmailByCrmProposalId($crm_proposal_id);
                }else{
                    $user_name = User::getStaffNameById($value->user_id);
                }

                $data[$key]["id"]               = $value->id;
                $data[$key]["user_id"]         	= $value->user_id;
                $data[$key]["user_name"]        = $user_name;
                $data[$key]["proposal_id"]      = $value->proposal_id;
                $data[$key]["event_type"]       = $value->event_type;
                $data[$key]["ip_address"]       = $value->ip_address;
                $data[$key]["created"] 			= $value->created;
                $data[$key]['added']            = date('d/m/Y H:i:s', strtotime($value->created));
            }
        }
        return $data;
    }

    public static function getFullType($status)
    {
        $name = '';
        if($status == 'D'){
            $name = 'Drafted';
        }else if($status == 'F'){
            $name = 'Finalised';
        }else if($status == 'T'){
            $name = 'Templated';
        }else if($status == 'E'){
            $name = 'Sent';
        }else if($status == 'V'){
            $name = 'Viewed';
        }else if($status == 'A'){
            $name = 'Signed';
        }else if($status == 'MA'){
            $name = 'Marked as Accepted';
        }else if($status == 'L'){
            $name = 'Lost';
        }else if($status == 'ML'){
            $name = 'Marked as Lost';
        }else if($status == 'R'){
            $name = 'Revoked';
        }else if($status == 'C'){
            $name = 'Copied';
        }else if($status == 'Edit'){
            $name = 'Edited';
        }
        return $name;
    }

}
