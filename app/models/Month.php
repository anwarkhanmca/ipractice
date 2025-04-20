<?php
class Month extends Eloquent {

	public $timestamps = false;

	public static function getMonthDetails()
    {
        $details  = Month::get();
        return Month::getArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $row) {
                $data[$key]['id']             = $row->id;
                $data[$key]['month_id']       = $row->month_id;
                $data[$key]['short_name']     = $row->short_name;
                $data[$key]['holiday_month']  = $row->holiday_month;
                $data[$key]['full_name']      = $row->full_name;
            }
        }
        return $data;
    }


}
