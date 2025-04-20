<?php
class HolidayType extends Eloquent {

    public $timestamps = false;
    public static function getTypeNameById($type_id)
    {
        $ret_value = "";
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = HolidayType::where('type_id', '=', $type_id)->first();
        if(isset($details['name']) && $details['name'] != "")
            $ret_value = $details['name'];
        return $ret_value;
    }

    public static function getColorCodeById($type_id)
    {
        $ret_value = "";
        $details   = HolidayType::where('type_id', '=', $type_id)->first();
        if(isset($details['color']) && $details['color'] != "")
            $ret_value = $details['color'];
        return $ret_value;
    }

    public static function getHolidayTypeId()
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $ret_value = "";
        $details        = HolidayType::select('name')->first();
        if(isset($details['name']) && $details['name'] != "")
            $ret_value = $details['name'];
        return $ret_value;
    }

    public static function getHolidayTypes($status)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        if($status == 'O'){
            $details    = HolidayType::where('status', '=', $status)->where('is_show', '=', 'Y')->get();
        }else{
            $details    = HolidayType::whereIn("user_id", $groupUserId)->where('status', '=', $status)->where('is_show', '=', 'Y')->get();
        }
        
        //Common::last_query();die;
        return HolidayType::getArray($details);
    }

    public static function getHolidayTypesById($type_id)
    {
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        $details        = HolidayType::where('type_id', '=', $type_id)->first();
        return HolidayType::getSingleArray($details);
    }

    public static function getArray($all_details)
    {
        $data = array();
        if(isset($all_details) && count($all_details) >0){
            foreach ($all_details as $key => $details) {
                $data[$key]['type_id']   = $details->type_id;
                $data[$key]['user_id']   = $details->user_id;
                $data[$key]['name']      = $details->name;
                $data[$key]['status']    = $details->status;
                $data[$key]['color']     = $details->color;
                $data[$key]['is_show']   = $details->is_show;
                $data[$key]['created']   = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['type_id']   = $details->type_id;
            $data['user_id']   = $details->user_id;
            $data['name']      = $details->name;
            $data['status']    = $details->status;
            $data['color']     = $details->color;
            $data['is_show']   = $details->is_show;
            $data['created']   = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
        }
        return $data;
    }

}
