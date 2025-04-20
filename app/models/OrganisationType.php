<?php
class OrganisationType  extends Eloquent{
	
	public $timestamps = false;

	public static function getAllOrganizationTypeById( $id )
    {
        return OrganisationType::select("*")->where("organisation_id", $id)->get();
    }

    public static function getNewOrganizationType()
    {
        $session            = Session::get('admin_details');
        $groupUserId        = $session['group_users'];
        return OrganisationType::where("client_type", "org")->where("status", "new")->
            whereIn("user_id", $groupUserId)->orderBy("name")->get();
    }

    public static function getIdByName( $name )
    {
    	$id = '';
        $data = OrganisationType::where("name",  $name)->select("organisation_id")->first();
        if(isset($data['organisation_id']) && $data['organisation_id'] != ''){
        	$id = $data['organisation_id'];
		}
		return $id;
    }

    public static function getNameById( $id )
    {
        $name = '';
        $data = OrganisationType::where("organisation_id",  $id)->select("name")->first();
        if(isset($data['name']) && $data['name'] != ''){
            $name = $data['name'];
        }
        return $name;
    }


}
