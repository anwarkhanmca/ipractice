<?php
class TechUpdate extends Eloquent {

	public $timestamps = false;
	public static function getAllRecords()
    {
        $data = array();
        $tech_updates = TechUpdate::get();
        if(isset($tech_updates) && count($tech_updates) >0){
            foreach ($tech_updates as $key => $tech_up) {
                $data[$key]['techup_id']    = $tech_up->techup_id;
                $data[$key]['subject']  = $tech_up->subject;
                $data[$key]['description']      = $tech_up->description;
                $data[$key]['date']         = date('h A, d F Y',$tech_up->date);
                $data[$key]['created_at']         = $tech_up->created_at;
            }
        }
        //print_r($data);
        return $data;
    }
}
