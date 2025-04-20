<?php
class AllocationHeadingDefault  extends Eloquent{
	
	public $timestamps = false;
	public static function getHeadings()
    {
    	$array = array();
		$details = AllocationHeadingDefault::get();
		return AllocationHeadingDefault::getArray($details);
    }

    public static function getArray($details)
	{
		$data = array();

		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['id'] 			= $value->id;
				$data[$key]['heading_name'] = $value->heading_name;
			}
		}
		return $data;
	}

}
