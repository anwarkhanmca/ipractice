<?php
class CrmProposalTerm  extends Eloquent{
	public $timestamps = false;

    public static function getDetailsById( $id )
    {
        $data 		= array();
       	$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTerm::whereIn('user_id',$groupUserId)->where("id",$id)->first();
        return CrmProposalTerm::getSingleArray($details);
    }

    public static function getAllDetails()
    {
        $data 			= array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalTerm::whereIn('user_id', $groupUserId)->get();
        return CrmProposalTerm::getArray($details);
    }

    public static function getDetailsByProposalId( $proposal_id, $groupUserId )
    {
        $data = array();
        $details = CrmProposalTerm::whereIn('user_id', $groupUserId)->where("proposal_id", $proposal_id)->first();
        return CrmProposalTerm::getSingleArray($details);
    }

    public static function getDetailsPreview( $proposal_id, $groupUserId )
    {
        $data  = array();
        $details = CrmProposalTerm::whereIn('user_id', $groupUserId)->where("proposal_id", $proposal_id)->first();
        return CrmProposalTerm::getSingleArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['id']               = $value->id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['user_name']        = User::getStaffNameById($value->user_id);
                $data[$key]['proposal_id']    	= $value->proposal_id;
                $data[$key]['terms']             = $value->terms;
                $data[$key]['created']          = date('d-m-Y', strtotime($value->created));
                $data[$key]['modified']         = date('d-m-Y', strtotime($value->modified));
            }
        }
        return $data;
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data['id']               = $value->id;
            $data['user_id']          = $value->user_id;
            $data['user_name']        = User::getStaffNameById($value->user_id);
            $data['proposal_id']      = $value->proposal_id;
            $data['terms']            = $value->terms;
            $data['created']          = date('d-m-Y', strtotime($value->created));
            $data['modified']         = date('d-m-Y', strtotime($value->modified));
        }
        return $data;
    }
	
	

}
