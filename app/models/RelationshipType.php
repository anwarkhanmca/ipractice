<?php
class RelationshipType  extends Eloquent{
	
	public $timestamps = false;
	public static function getAllDetailsByStatus($status)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = RelationshipType::where("show_status", "=", $status)->orderBy("relation_type_id")->get();
        return RelationshipType::getArray($details);
    }

  public static function getArray($details)
  {
      $data = array();
      if(isset($details) && count($details) >0){
          foreach ($details as $key => $value) {
              $data[$key]['relation_type_id']  = $value->relation_type_id;
              $data[$key]['relation_type']     = $value->relation_type;
              $data[$key]['show_status']       = $value->show_status;
          }
      }
      return $data;
  }

  


}
