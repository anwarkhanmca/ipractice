<?php
class GenerateLetterRecepient extends Eloquent {
    public $timestamps = false;

	public static function getAllReceipient()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = GenerateLetterRecepient::whereIn("user_id", $groupUserId)->where('template_id', '<>', '0')->get();
        
        return GenerateLetterRecepient::getArray($details);
    }

    public static function getAllFinalReceipient()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $templates  = LetterTemplate::getFinalTemplateId();
        $details    = GenerateLetterRecepient::whereIn("template_id", $templates)->get();
        
        return GenerateLetterRecepient::getArray($details);
    }

    public static function getAllDraftReceipient()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $user_id        = $session['id'];
        $templates      = array();

        $details = LetterTemplate::where("user_id", "=", $user_id)->where('save_as', '=', 'D')->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value){
                $templates[] = $value['template_id'];
            }
        }

        $details = GenerateLetterRecepient::whereIn("template_id", $templates)->get();
        
        return GenerateLetterRecepient::getArray($details);
    }

    public static function getReceipientByTemplate($template_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = GenerateLetterRecepient::whereIn("user_id", $groupUserId)->where("template_id", "=", $template_id)->get();
        
        return GenerateLetterRecepient::getArray($details);
    }

    public static function getReceipientCountByTemplate($template_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $count = GenerateLetterRecepient::whereIn("user_id", $groupUserId)->where("template_id", "=", $template_id)->get()->count();
        
        return $count;
    }

    public static function getTemplateIdByRecipientId($recipient_id)
    {
        $details = GenerateLetterRecepient::where("recipient_id", "=", $recipient_id)->select('template_id')->first();
        
        return $details['template_id'];
    }

    public static function getReceipientBySession($recip_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = GenerateLetterRecepient::whereIn("recipient_id", $recip_id)->get();
        
        return GenerateLetterRecepient::getArray($details);
    }

    public static function getReceipientById($recipient_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = GenerateLetterRecepient::where("recipient_id", "=", $recipient_id)->first();
        
        return $details;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['recipient_id']     = $value->recipient_id;
                $data[$key]['template_id']      = $value->template_id;
                $data[$key]['template_subject'] = LetterTemplate::getTemplateNameById($value->template_id);
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['user_name']        = User::getStaffNameById($value->user_id);
                $data[$key]['item_id']          = $value->item_id;
                $data[$key]['item_name']        = GenerateLetterRecepient::getItemName($value->item_id, $value->item_type);
                $data[$key]['item_type']        = $value->item_type;
                $data[$key]['created']          = date('d-m-Y', strtotime($value->created));
            }
        }
        return $data;
    }

    public static function getItemName($item_id, $item_type)
    {
        $item_name = '';
        if($item_type == 'org' || $item_type == 'ind' || $item_type == 'group'){
            $item_name = Client::getClientNameByClientId($item_id);
        }else if($item_type == 'staff'){
            $item_name = User::getStaffNameById($item_id);
        }else if($item_type == 'other'){
            $item_name = ContactAddress::getCompanyNameById($item_id);
        }/*else if($item_type == 'group'){
            $item_name = ContactsStep::getStepNameById($item_id);
        }*/

        return $item_name;
    }

}
