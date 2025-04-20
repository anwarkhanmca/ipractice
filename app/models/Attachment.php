<?php
class Attachment  extends Eloquent{
	
	protected $table = 'attachments';
	public $timestamps = false;
	
	public static function getAllDetails()
	{
		$data = array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$details = Attachment::whereIn("user_id", $groupUserId)->get();
        if(isset($details) && count($details) >0 )
        {
        	foreach ($details as $key => $value) {
        		$data[$key]['id'] 			= $value['id'];
				$data[$key]['user_id'] 		= $value['user_id'];
				$data[$key]['title'] 		= $value['title'];
				$data[$key]['file'] 		= $value['file'];
				$data[$key]['notes'] 		= $value['notes'];
				$data[$key]['is_archive'] 	= $value['is_archive'];
        	}
    	}
        return $data;
	}

	public static function getNotesByAttachmentId($id)
	{
		$notes = '';
        $session      = Session::get('admin_details');
        $groupUserId  = $session['group_users'];

        $details = Attachment::whereIn("user_id", $groupUserId)->where('id', $id)->select('notes')->first();
        //Common::last_query();
        if(isset($details->notes) && $details->notes != ''){
            $notes = $details->notes;
        }
        return $notes;
	}

}
