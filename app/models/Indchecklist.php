<?php
class Indchecklist extends Eloquent{
	
	public $timestamps = false;

	public static function getAllIndchecklistTypeById( $id )
    {
        return Indchecklist::select("*")->where("checklist_id", $id)->get();
    }


}
