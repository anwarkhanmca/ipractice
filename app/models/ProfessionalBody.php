<?php
class ProfessionalBody extends Eloquent {

	public $timestamps = false;

	public static function getNameById( $id )
    {
    	$name = '';
        $data = ProfessionalBody::where("p_body_id", '=', $id)->first();
        if(isset($data['name']) && $data['name'] != ''){
        	$name = $data['name'];
		}
		return $name;
    }

    public static function getDetails()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = ProfessionalBody::whereIn("user_id", $groupUserId)->get();
        
        return ProfessionalBody::getArray($details);
    }

    public static function getArray($array)
    {
        $data = array();
        if(isset($array) && count($array) >0){
            foreach ($array as $i => $details) {
                $data[$i]['p_body_id']      = $details->p_body_id;
                $data[$i]['user_id']        = $details->user_id;
                $data[$i]['name']           = $details->name;
                $data[$i]['status']         = $details->status;
                $data[$i]['created']        = date('d-m-Y', strtotime($details->created));
            }
        }
        return $data;
    }

    public static function getSingleArray()
    {
        
    }

}
