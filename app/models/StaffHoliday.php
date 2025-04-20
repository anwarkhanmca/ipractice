<?php
class StaffHoliday extends Eloquent {

	public $timestamps = false;

    public static function getAllDetails()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = StaffHoliday::whereIn("user_id", $groupUserId)->get();

        return StaffHoliday::getArray($details);
    }

	public static function staffHolidayByStaffId($staff_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = StaffHoliday::whereIn("user_id", $groupUserId)->where('staff_id', '=', $staff_id)->first();

        return StaffHoliday::getSingleArray($details);
    }

    public static function staffHolidayByStartDate($start_date)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = StaffHoliday::whereIn("user_id", $groupUserId)->where('start_date', '=', $start_date)->get();

        return StaffHoliday::getArray($details);
    }

    public static function staffHolidayByStaffAndDate($staff_id, $start_date)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $start_date     = date('Y-m-d', strtotime($start_date));
        $details        = StaffHoliday::whereIn("user_id", $groupUserId)->where('staff_id', '=', $staff_id)->where('start_date', '=', $start_date)->first();

        return StaffHoliday::getSingleArray($details);
    }

    public static function getEntitlementDays($staff_id)
    {
        $ent_days = 0;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = StaffHoliday::whereIn("user_id", $groupUserId)->where('staff_id', '=', $staff_id)->first();
        if(isset($details['ent_days']) && ['ent_days'] != ""){
            $ent_days = $details['ent_days'];
        }
        return $ent_days;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $details) {
                $data[$key]['staff_holiday_id'] = $details->staff_holiday_id;
                $data[$key]['user_id']      = $details->user_id;
                $data[$key]['staff_id']     = $details->staff_id;
                $data[$key]['ent_days']     = (isset($details->ent_days) && $details->ent_days != '')?$details->ent_days:'0';
                $data[$key]['days_taken']   = $details->days_taken;
                //$data[$key]['current_balance']   = Holidayrequest::countLeaveByStateAndId('Approved', $details->staff_id, 1);
                $data[$key]['remaining']    = $details->remaining;
                $data[$key]['notes']        = $details->notes;
                $data[$key]['created']      = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['staff_holiday_id']   = $details->staff_holiday_id;
            $data['user_id']            = $details->user_id;
            $data['staff_id']           = $details->staff_id;
            $data['ent_days']           = (isset($details->ent_days) && $details->ent_days != '')?$details->ent_days:'0';
            $data['days_taken']         = $details->days_taken;
            //$data['current_balance']   = Holidayrequest::countLeaveByStateAndId('Approved', $details->staff_id, 1, '01-01-2015');
            $data['remaining']          = $details->remaining;
            $data['notes']              = $details->notes;
            $data['created']            = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
        }
        return $data;
    }

}
