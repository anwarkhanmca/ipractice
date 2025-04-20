<?php
class CrmProposalCoverletter  extends Eloquent{
	public $timestamps = false;
	public static function getAllCoverLetters()
    {
        $data 		= array();
       	$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = DB::table('crm_proposal_coverletters as cpcl')->whereIn('cp.user_id', $groupUserId)
        	->join('crm_proposals as cp', 'cpcl.proposal_id', '=', 'cp.proposalID')
        	->select('cpcl.*', 'cp.proposal_title', 'cp.prospect_id', 'cp.contact_type')
        	->get();
        //Common::last_query();die;
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $v) {
                $data[$key]['cover_letter_id']  = $v->cover_letter_id;
                $data[$key]['user_id']          = $v->user_id;
                $data[$key]['user_name']        = User::getStaffNameById($v->user_id);
                $data[$key]['proposal_id']    	= $v->proposal_id;
                $data[$key]['template_id']    	= $v->template_id;
                $data[$key]['title']            = $v->title;
                $data[$key]['desc']             = $v->desc;
                $data[$key]['placeholder_desc'] = $v->placeholder_desc;
                $data[$key]['created']          = date('d-m-Y', strtotime($v->created));
                $data[$key]['modified']         = date('d-m-Y', strtotime($v->modified));

                $data[$key]['proposal_title']   = $v->proposal_title;
                $data[$key]['prospect_name']  = CrmProposal::getProspectName($v->contact_type,$v->prospect_id);
            }
        }
        return $data;
    }

    public static function getDetailsByCoverLetterId( $letter_id )
    {
        $data 		= array();
       	$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalCoverletter::whereIn('user_id',$groupUserId)->where("cover_letter_id",$letter_id)->first();
        return CrmProposalCoverletter::getSingleArray($details);
    }

    public static function getAllDetails()
    {
        $data 			= array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalCoverletter::whereIn('user_id', $groupUserId)->get();
        return CrmProposalCoverletter::getArray($details);
    }

    public static function getDetailsByProposalId( $proposal_id )
    {
        $data 			= array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CrmProposalCoverletter::whereIn('user_id', $groupUserId)->where("proposal_id", $proposal_id)->first();
        return CrmProposalCoverletter::getSingleArray($details);
    }

    public static function getDetailsPreview( $proposal_id, $groupUserId )
    {
        $data           = array();
        $details = CrmProposalCoverletter::whereIn('user_id', $groupUserId)
            ->where("proposal_id", $proposal_id)->first();
        return CrmProposalCoverletter::getSingleArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $v) {
                $data[$key]['cover_letter_id']  = $v->cover_letter_id;
                $data[$key]['user_id']          = $v->user_id;
                $data[$key]['user_name']        = User::getStaffNameById($v->user_id);
                $data[$key]['proposal_id']    	= $v->proposal_id;
                $data[$key]['template_id']    	= $v->template_id;
                $data[$key]['title']            = $v->title;
                $data[$key]['desc']             = $v->desc;
                $data[$key]['placeholder_desc'] = $v->placeholder_desc;
                $data[$key]['created']          = date('d-m-Y', strtotime($v->created));
                $data[$key]['modified']         = date('d-m-Y', strtotime($v->modified));
            }
        }
        return $data;
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data['cover_letter_id']  	= $value->cover_letter_id;
            $data['user_id']          	= $value->user_id;
            $data['user_name']        	= User::getStaffNameById($value->user_id);
            $data['proposal_id']    	= $value->proposal_id;
            $data['template_id']    	= $value->template_id;
            $data['title']            	= $value->title;
            $data['desc']             	= $value->desc;
            $data['placeholder_desc']   = $value->placeholder_desc;
            $data['created']          	= date('d-m-Y', strtotime($value->created));
            $data['modified']         	= date('d-m-Y', strtotime($value->modified));
        }
        return $data;
    }
	
	

}
