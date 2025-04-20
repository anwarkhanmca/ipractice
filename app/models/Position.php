<?php
class Position  extends Eloquent{
	
	public $timestamps = false;

	public static function getAllPositionTypeById( $id )
    {
        return Position::select("*")->where("position_id", $id)->get();
    }

    public static function getPositionByUserId( $staff_id )
    {
    	$position_name = "";
    	$fields = StepsFieldsStaff::where("staff_id", "=", $staff_id)->WHERE('field_name', '=', 'position_type')->first();
        
        if (isset($fields['field_value']) && $fields['field_value'] != "") {
            $postion_types = Position::where("position_id", "=", $fields['field_value'])->select("name")->first();
            $position_name = $postion_types['name'];
        }
        
        return $position_name;
    }

    public static function getNameByPositionId( $position_id )
    {
    	$position_name = "";
    	$postion = Position::where("position_id", "=", $position_id)->select("name")->first();
        
        if (isset($postion['name']) && $postion['name'] != "") {
            $position_name = $postion['name'];
        }
        
        return $position_name;
    }
    


}
