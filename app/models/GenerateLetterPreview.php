<?php
class GenerateLetterPreview  extends Eloquent{
	
	public $timestamps = false;
	
	public static function getAllDraftTemplate()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $templates      = array();
        $details = GenerateLetterPreview::whereIn("user_id", $groupUserId)->where("save_as", "=", 'D')->get();
        return GenerateLetterPreview::getArray($details);
    }

    public static function getByRecipientTemplateId($resp_id, $temp_id, $save_as)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $templates      = array();
        $details = GenerateLetterPreview::whereIn("user_id", $groupUserId)->where("recipient_id", "=", $resp_id)->where("template_id", "=", $temp_id)->where("save_as", "=", $save_as)->first()->toArray();
        return $details;
    }

    public static function getcontentByRecipientTemplateId($resp_id, $temp_id, $save_as)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $templates      = array();
        $content = '';
        $details = GenerateLetterPreview::whereIn("user_id", $groupUserId)->where("recipient_id", "=", $resp_id)->where("template_id", "=", $temp_id)->where("save_as", "=", $save_as)->select('content')->first();
        if(isset($details) && count($details) >0){
        	$content = $details['content'];
        }

        return $content;
    }

    public static function getFinalContentByRespId($recipient_id, $save_as)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $templates      = array();
        $content = '';
        $template_id = GenerateLetterRecepient::getTemplateIdByRecipientId($recipient_id);
        /*$content = GenerateLetterPreview::getcontentByRecipientTemplateId($recipient_id,$template_id,$save_as);
        if(empty($content)){
        	$content = LetterTemplate::getTemplateContentById($template_id);
        }*/
        $postData['template_id'] = $template_id;
        $postData['recipient_id'] = $recipient_id;
        $details = App::make('LettersController')->getPreviewData($postData);

        return $details['newcontent'];
    }


	public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['preview_temp_id']  = $value->preview_temp_id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['template_id']      = $value->template_id;
                $data[$key]['recipient_id']     = $value->recipient_id;
                $data[$key]['subject'] 			= $value->subject;
                $data[$key]['content'] 			= $value->content;
                $data[$key]['user_name']        = User::getStaffNameById($value->user_id);
                $data[$key]['item_id']          = $value->item_id;
                $data[$key]['item_name']        = GenerateLetterRecepient::getItemName($value->item_id, $value->item_type);
                $data[$key]['item_type']        = $value->item_type;
                $data[$key]['save_as']        	= $value->save_as;
                $data[$key]['created']          = $value->created;
            }
        }
        return $data;
    }
}
