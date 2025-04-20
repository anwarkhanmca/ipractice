<?php
class LetterTemplate extends Eloquent {

	public $timestamps = false;

	public static function getActiveTemplate()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = LetterTemplate::whereIn("user_id", $groupUserId)->where('status', '=', 'A')->first();
        
        return LetterTemplate::getSingleArray($details);
    }

    public static function getTemplateNameById($template_id)
    {
        $subject = "";
        $details = LetterTemplate::where('template_id', '=', $template_id)->select('subject')->first();
        if(isset($details['subject']) && $details['subject'] != ""){
            $subject = $details['subject'];
        }
        return $subject;
    }

    public static function getTemplateContentById($template_id)
    {
        $content = "";
        $details = LetterTemplate::where('template_id', '=', $template_id)->select('content')->first();
        if(isset($details['content']) && $details['content'] != ""){
            $content = $details['content'];
        }
        return $content;
    }

    public static function getFinalTemplate()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = DB::table('letter_templates')->whereIn("user_id", $groupUserId)
            ->where('save_as', '=', 'F')->where(function ($query) use ($user_id)  {
                $query->where('confidentialUserId', '=', '0')
              ->orWhere('confidentialUserId', '=', $user_id);
            })->get();
        //Common::last_query();die;

        //$details = LetterTemplate::whereIn("user_id", $groupUserId)->where('save_as', '=', 'F')->get();
        
        return LetterTemplate::getArray($details);
    }

    public static function getFinalTemplateId()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $templates      = array();

        $final = DB::table('letter_templates')->whereIn("user_id", $groupUserId)
            ->where('save_as', '=', 'F')->where(function ($query) use ($user_id)  {
                $query->where('confidentialUserId', '=', '0')
              ->orWhere('confidentialUserId', '=', $user_id);
            })->select('template_id')->get();
        //Common::last_query();die;
        if(isset($final) && count($final) >0){
            foreach ($final as $key => $value) {
                $templates[] = $value->template_id;
            }
        }

        return $templates;
    }

    public static function getDraftTemplate()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = LetterTemplate::where("user_id", "=", $user_id)->where('save_as', '=', 'D')->get();
        
        return LetterTemplate::getArray($details);
    }

    public static function getTemplateById($template_id)
    {
        $details = LetterTemplate::where("template_id", "=", $template_id)->first();
        
        return LetterTemplate::getSingleArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['template_id']          = $value->template_id;
                $data[$key]['user_id']              = $value->user_id;
                $data[$key]['user_name']            = User::getStaffNameById($value->user_id);
                $data[$key]['subject']              = $value->subject;
                $data[$key]['content']              = $value->content;
                $data[$key]['confidentialUserId']   = $value->confidentialUserId;
                $data[$key]['status']               = $value->status;
                $data[$key]['created']              = $value->created;
            }
        }
        return $data;
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data['template_id']        = $value->template_id;
            $data['user_id']            = $value->user_id;
            $data['subject']            = $value->subject;
            $data['content']            = $value->content;
            $data['confidentialUserId'] = $value->confidentialUserId;
            $data['status']             = $value->status;
            $data['created']            = $value->created;
        }
        return $data;
    }

    public static function saveTemplate($postData)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $recipients     = Session::get('recipients');

        $template_id    = $postData['template_id'];

        $insrtData['user_id']   = $user_id;
        $insrtData['subject']   = $postData['subject'];
        $insrtData['content']   = $postData['content'];
        $insrtData['save_as']   = $postData['save_as'];
        

        if($postData['page_open'] == 2){
            $insrtData['status']    = $postData['status'];

            if($template_id == '0'){
                $insrtData['created']   = date('Y-m-d H:i:s');
                $last_id = LetterTemplate::insertGetId($insrtData);
            }else{
                LetterTemplate::where('template_id', '=', $template_id)->update($insrtData);
                $last_id = $template_id;
            }
            
            if(isset($recipients) && count($recipients) > 0){
              GenerateLetterRecepient::whereIn("recipient_id",$recipients)->update(array('template_id'=>$last_id));
              Session::forget('recipients');
            }

            GenerateLetterPreview::where('template_id','=',$template_id)->delete();

        }else{
            /* ================= Preview Tab Logic ========================= */
            $details = GenerateLetterRecepient::where("recipient_id", "=", $postData['recipient_id'])->select('item_id', 'item_type')->first();
            $prevDerls = GenerateLetterPreview::whereIn('user_id', $groupUserId)->where('template_id', '=', $template_id)->where('item_id', '=', $details['item_id'])->where('item_type', '=', $details['item_type'])->first();
            if(isset($prevDerls) && count($prevDerls)>0){
                $last_id = $prevDerls['preview_temp_id'];
                GenerateLetterPreview::where('preview_temp_id', '=', $last_id)->update($insrtData);
            }else{
                $insrtData['template_id']   = $template_id;
                $insrtData['recipient_id']  = $postData['recipient_id'];
                $insrtData['item_id']       = $details['item_id'];
                $insrtData['item_type']     = $details['item_type'];
                $insrtData['created']       = date('Y-m-d H:i:s');
                GenerateLetterPreview::insertGetId($insrtData);
            }
            /* ================= Preview Tab Logic ========================= */

            if($postData['save_as'] == 'F'){
                LetterTemplate::where('template_id', '=', $template_id)->update(array('save_as'=>'F'));
            }
            $last_id = $template_id;
        }

        
        
        return $last_id;
    }

    public static function getGeneratePdfDetails($recipient_id)
    {
        $data = array();
        $session    = Session::get('admin_details');
        $user_id    = $session['id'];

        $details = GenerateLetterRecepient::getReceipientById($recipient_id);
        if(isset($details) && count($details) >0){
            $staff_id   = $details['user_id'];
            $item_id    = $details['item_id'];
            $item_type  = $details['item_type'];
            if($item_type == 'org'){
                $data = Common::orgClientDetailsForPlaceHolder($item_id);
                /*$data = Common::clientDetailsById($item_id);
                unset($data['allocation']);unset($data['registered_address']);unset($data['TAddress']);
                unset($data['job_status']);unset($data['services_id']);unset($data['trading_address']);
                $data['incorporation_date'] = (isset($data['incorporation_date']) && $data['incorporation_date'] !='')?date('dS F, Y', strtotime($data['incorporation_date'])):'';
                $data['made_up_date'] = (isset($data['made_up_date']) && $data['made_up_date'] !='')?date('dS F, Y', strtotime($data['made_up_date'])):'';
                $data['next_ret_due'] = (isset($data['next_ret_due']) && $data['next_ret_due'] !='')?date('dS F, Y', strtotime($data['next_ret_due'])):''; 
                $data['effective_date'] = (isset($data['effective_date']) && $data['effective_date'] !='')?date('dS F, Y', strtotime($data['effective_date'])):''; */
            }
            if($item_type == 'ind'){
                $data = Common::clientDetailsByIdForPlaceHolder($item_id);
            }
            if($item_type == 'staff'){
                $data = User::getGeneralPlaceHolder($item_id);
            }
        }

        /* ======================= General Section ========================= */
        $general = Common::getGeneralPlaceHolder();
        $practiceDetails = PracticeDetail::getGeneralPlaceHolder();

        $finalArray = array_merge($data, $general, $practiceDetails);

        return $finalArray;
        //echo "<pre>";print_r($data);die;
    }

    public static function getDetailsForPdfByRespId($recipient_id)
    {
        $data = array();
        $details = GenerateLetterRecepient::getReceipientById($recipient_id);
        if(isset($details['template_id']) && $details['template_id'] != 0){
            $data = LetterTemplate::getTemplateById($details['template_id']);
        }

        return $data;
    }

    public static function getReplacedContent($recipient_id)
    {
        $data = array();

        $details['details']     = LetterTemplate::getGeneratePdfDetails($recipient_id);
        $details['templates']   = LetterTemplate::getDetailsForPdfByRespId($recipient_id);
        $details['replacing']   = PlaceholderName::getReplacingName('view_name');
        $details['replaced']    = PlaceholderName::getReplacingName('short_name');

        $content  = str_replace("&nbsp;", " ", $details['templates']['content']);
        foreach ($details['replaced'] as $key => $value) {
            $details['replaced'][$key] = isset($details['details'][$value])?$details['details'][$value]:'[undefined]';
        }
        $data['newcontent']     = str_replace($details['replacing'], $details['replaced'], $content);
        $data['newsubject']     = $details['templates']['subject'];

        return $data;
    }



}
