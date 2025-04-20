<?php
class UserRelatedCompany extends Eloquent {

	public $timestamps = false;
    public static function getRelationClientId($user_id)
    {
        $data = array();
        $rel_client = UserRelatedCompany::where('user_id', '=', $user_id)->get();
        $i = 0;
        if(isset($rel_client) && count($rel_client) >0){
			foreach ($rel_client as $key => $value) {
				$data[$i] 		= $value['client_id'];
				$i++;
			}
		}
        
        return $data;
    }
    
    public static function checkUserRelation($client_id, $user_id)
	{
    	$data   = array();    
		$details = UserRelatedCompany::where("client_id", "=", $client_id)->where("user_id", "=", $user_id)->first();
        if(isset($details) && count($details) >0){
			$data['related_company_id'] = $details['related_company_id'];
            $data['client_id']          = $details['client_id'];
            $data['user_id']            = $details['user_id'];
            $data['status']             = $details['status'];
		}
        
		return $data;
	}
    
    
    
}
