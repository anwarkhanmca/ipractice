<?php
class Nationality extends Eloquent {

	public $timestamps = false;

	public static function getNationalityIdByName($name)
    {
        $id = '';
    	$details = Nationality::where('nationality_name', '=', $name)->first();
        if(isset($details) && count($details)){
            $id 	= $details['nationality_id'];
        }
        return $id;
    }

    public static function getNationalityNameById($nation_id)
    {
        $name = '';
        $details = Nationality::where('nationality_id', '=', $nation_id)->first();
        if(isset($details) && count($details)){
            $name  = $details['nationality_name'];
        }
        return $name;
    }

}
