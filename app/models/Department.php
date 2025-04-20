<?php
class Department  extends Eloquent{
	
	public $timestamps = false;

	public static function getAllDepartmentTypeById( $id )
    {
        return Department::select("*")->where("department_id", $id)->get();
    }

    public static function getDepartmentById( $id )
    {
    	$name = "";
        $details = Department::where("department_id", $id)->select("name")->first();
        if(isset($details) && count($details) >0){
            $name = $details['name'];
        }
        return $name;
    } 


}
