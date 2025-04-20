<?php
class Color extends Eloquent {

	public $timestamps = false;
	public static function getAllDetails()
	{
		$data = array();
		$details = Color::get();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['color_id'] 	= $value['color_id'];
				$data[$key]['color_name'] 	= $value['color_name'];
				$data[$key]['color_code'] 	= $value['color_code'];
				$data[$key]['is_show'] 		= $value['is_show'];
			}
			
		}
		return $data;
	}
}
