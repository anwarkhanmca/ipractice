<?php
class HolidayDetail extends Eloquent {

	public $timestamps = false;

	public static function getHolidayId()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $ret_value = "";
        $details        = HolidayDetail::whereIn("user_id", $groupUserId)->select('holiday_id')->first();
        if(isset($details['holiday_id']) && $details['holiday_id'] != "")
            $ret_value = $details['holiday_id'];
        return $ret_value;
    }

    public static function getAllowRollover()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $ret_value = "N";
        $details        = HolidayDetail::whereIn("user_id", $groupUserId)->select('allow_rollover')->first();
        if(isset($details['allow_rollover']) && $details['allow_rollover'] == "Y")
            $ret_value = $details['allow_rollover'];
        return $ret_value;
    }

    public static function getHolidayDate()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $date = "";
        $details        = HolidayDetail::whereIn("user_id", $groupUserId)->select('holiday_date')->first();
        if(isset($details['holiday_date']) && $details['holiday_date'] != "0000-00-00")
            $date = date('d-m-Y', strtotime($details['holiday_date']));
        return $date;
    }
    

    public static function getHolidayDetails()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = HolidayDetail::whereIn("user_id", $groupUserId)->first();

        return HolidayDetail::getSingleArray($details);
    }

    public static function getHolidayDetailsByUserId($user_id)
    {
        $details  = HolidayDetail::where("user_id", '=', $user_id)->first();
        
        return HolidayDetail::getSingleArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $details) {
                $data[$key]['holiday_id']       = $details->holiday_id;
                $data[$key]['user_id']          = $details->user_id;
                $data[$key]['holiday_date']     = (isset($details->holiday_date) && $details->holiday_date!='0000-00-00')?date('d-m-Y',strtotime($details->holiday_date)):'';
                $data[$key]['holiday_end']      = (isset($details->holiday_end) && $details->holiday_end!='0000-00-00')?date('d-m-Y',strtotime($details->holiday_end)):'';
                $data[$key]['allow_rollover']   = $details->allow_rollover;
                $data[$key]['timeoff_type_id']  = $details->timeoff_type_id;
                $data[$key]['created']          = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['holiday_id']       = $details->holiday_id;
            $data['user_id']          = $details->user_id;
            $data['holiday_date']     = (isset($details->holiday_date) && $details->holiday_date!='0000-00-00')?date('d-m-Y',strtotime($details->holiday_date)):'';
            $data['holiday_end']      = (isset($details->holiday_end) && $details->holiday_end!='0000-00-00')?date('d-m-Y',strtotime($details->holiday_end)):'';
            $data['allow_rollover']   = $details->allow_rollover;
            $data['timeoff_type_id']  = $details->timeoff_type_id;
            $data['created']          = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
        }
        return $data;
    }

}
