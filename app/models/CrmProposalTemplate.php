<?php
class CrmProposalTemplate extends Eloquent {
    public $timestamps = false;

	public static function getDetailsByTemplateId( $template_id )
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details = CrmProposalTemplate::whereIn('user_id', $groupUserId)->where("template_id", $template_id)->first();
        return CrmProposalTemplate::getSingleArray($details);
    }

    public static function getDetailsByTemplateType( $template_type )
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details = CrmProposalTemplate::whereIn('user_id', $groupUserId)->where("template_type", $template_type)->get();
        return CrmProposalTemplate::getArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['template_id']      = $value->template_id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['user_name']        = User::getStaffNameById($value->user_id);
                $data[$key]['title']            = $value->title;
                $data[$key]['desc']             = $value->desc;
                $data[$key]['template_type']    = $value->template_type;
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
            $data['template_id']    = $value->template_id;
            $data['user_id']        = $value->user_id;
            $data['user_name']      = User::getStaffNameById($value->user_id);
            $data['title']          = $value->title;
            $data['desc']           = $value->desc;
            $data['template_type']  = $value->template_type;
            $data['created']        = date('d-m-Y', strtotime($value->created));
            $data['modified']       = date('d-m-Y', strtotime($value->modified));
        }
        return $data;
    }

}
