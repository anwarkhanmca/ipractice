<?php
class LetterHead  extends Eloquent{
	
	public $timestamps = false;

	
	public static function getLetterHeads()
	{
		$session        = Session::get('admin_details');
        $groupId    = $session['group_id'];

        $details = LetterHead::where("uid", $groupId)->get();
        
        return LetterHead::getArray($details);
	}

	public static function deleteLetterHeadById($id)
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $user_id        = $session['id'];

        $lhead = LetterHead::where("id", "=", $id)->where("uid", "=", $session['group_id'])->first();
        $lhead->delete();

        return true;
	}

	public static function makeDefaultLetterHeadById($id)
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $user_id        = $session['id'];

        $lhead = LetterHead::where("isdefaullt", "=", 1)->where("uid", "=", $session['group_id'])->update(array('isdefaullt' => 0));
        $lhead = LetterHead::where("id", "=", $id)->where("uid", "=", $session['group_id'])->update(array('isdefaullt' => 1));

        return true;
	}

	public static function getLetterHeadById($id)
	{
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = LetterHead::where("id", "=", $id)->first()->toArray();
        
        return $details;
	}

	public static function getArray($details)
	{
		$data = array();
		if (isset($details) && count($details) > 0) {
			foreach ($details as $key => $template_row) {
				$data[$key]['id'] 			= $template_row->id;
				$data[$key]['name'] 		= $template_row->name;
				$data[$key]['type'] 		= $template_row->type;
				$data[$key]['isdefaullt']	= $template_row->isdefaullt;
				$data[$key]['subject'] 		= $template_row->subject;
				$data[$key]['created'] 		= $template_row->created;
				$data[$key]['modified'] 	= $template_row->modified;
				$data[$key]['uid'] 			= $template_row->uid;
				$data[$key]['user_name']    = User::getStaffNameById($template_row->uid);
			}
		}
		return $data;
	}

	public static function saveLetterHead($postData)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $file = Input::file('pdf');

        $insrtData['name'] = $file->getClientOriginalName();
        if (file_exists(public_path().'/letter_heads/'.$file->getClientOriginalName())) {
        	$insrtData['name'] = round(microtime(true)) . '-' . $file->getClientOriginalName();   	
        }
        $insrtData['uid']   	= $session['group_id'];
        $insrtData['created']   = date('Y-m-d H:i:s');

        if (sizeof(LetterHead::where("uid", $session['group_id'])->get()) < 1) {
        	$insrtData['isdefaullt'] = 1;
        }

        $insert_id 	= LetterHead::insertGetId($insrtData);
        if(isset($insert_id) && $insert_id >= 0 ){
        	$name = $insrtData['name'];
			$filepath 	= public_path().'/letter_heads/';
			$file->move($filepath, $name);

			return true;
		}
        
        return false;
    }

	public static function getDefaultLetterHead() {
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $user_id        = $session['id'];
        
        $dflhead = LetterHead::where("isdefaullt", "=", 1)->where("uid", "=", $session['group_id'])->first();
		if ($dflhead) {
			return $dflhead;
		}
		return false;
	}
}
