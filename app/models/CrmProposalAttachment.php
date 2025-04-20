<?php
class CrmProposalAttachment extends Eloquent {
    public $timestamps = false;
    public function __construct()
    {
        parent::__construct();
        $session            = Session::get('admin_details');
        $this->user_id      = $session['id'];
        $this->groupUserId  = $session['group_users'];
    }

	public static function getAttachmentIdByProposalId( $proposal_id )
    {
    	$data = array();
        $session      = Session::get('admin_details');
        $groupUserId  = $session['group_users'];

        $details = CrmProposalAttachment::whereIn("user_id", $groupUserId)->where('proposal_id', $proposal_id)->where('status', 'A')->select("attachment_id")->get();
        //Common::last_query();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
                $data[$key] = $value->attachment_id;
            }
		}
		return $data;
    }

    public static function checkDataByAttachmentId($attachment_id)
    {
        $count =CrmProposalAttachment::where('attachment_id',$attachment_id)->count();
        return $count;
    }

    public static function getNotesByProposalIdAttachmentId( $proposal_id, $attachment_id )
    {
        $notes = '';
        $session      = Session::get('admin_details');
        $groupUserId  = $session['group_users'];

        $details = CrmProposalAttachment::whereIn("user_id", $groupUserId)->where('proposal_id', '=', $proposal_id)->where('attachment_id', '=', $attachment_id)->select('notes')->first();
        //Common::last_query();
        if(isset($details->notes) && $details->notes != ''){
            $notes = $details->notes;
        }
        return $notes;
    }

    public static function getAllAttachmentsByProposalId( $proposal_id )
    {
        $data = array();
        $session      = Session::get('admin_details');
        $groupUserId  = $session['group_users'];

        $details = DB::table('crm_proposal_attachments as cpa')
            ->leftjoin('attachments as a', 'cpa.attachment_id', '=', 'a.id')
            ->where('cpa.status', '=', 'A')->whereIn('cpa.user_id', $groupUserId)
            ->where('cpa.proposal_id', $proposal_id)
            ->select('cpa.*', 'a.title', 'a.file')->get();
        if (isset($details) && count($details) >0) {
            foreach ($details as $k => $v) {
                $data[$k]['cp_attach_id']   = $v->cp_attach_id;
                $data[$k]['user_id']        = $v->user_id;
                $data[$k]['proposal_id']    = $v->proposal_id;
                $data[$k]['attachment_id']  = $v->attachment_id;
                $data[$k]['status']         = $v->status;
                $data[$k]['notes']          = $v->notes;
                $data[$k]['title']          = $v->title;
                $data[$k]['file']           = $v->file;
            }
        }
        return $data;
    }

    public static function getAllAttachmentsPreview( $proposal_id, $groupUserId )
    {
        $data = array();

        $details = DB::table('crm_proposal_attachments as cpa')
            ->leftjoin('attachments as a', 'cpa.attachment_id', '=', 'a.id')
            ->where('cpa.status', '=', 'A')->whereIn('cpa.user_id', $groupUserId)
            ->where('cpa.proposal_id', $proposal_id)
            ->select('cpa.*', 'a.title', 'a.file')->get();
        if (isset($details) && count($details) >0) {
            foreach ($details as $k => $v) {
                $data[$k]['cp_attach_id']   = $v->cp_attach_id;
                $data[$k]['user_id']        = $v->user_id;
                $data[$k]['proposal_id']    = $v->proposal_id;
                $data[$k]['attachment_id']  = $v->attachment_id;
                $data[$k]['status']         = $v->status;
                $data[$k]['notes']          = $v->notes;
                $data[$k]['title']          = $v->title;
                $data[$k]['file']           = $v->file;
            }
        }
        return $data;
    }

    

}
