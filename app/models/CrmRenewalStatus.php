<?php
class CrmRenewalStatus extends Eloquent {

	public $timestamps = false;

    public static function getAllStatus()
    {
        $data = array();
        $renewals = CrmRenewalStatus::get();
        if(isset($renewals) && count($renewals) > 0){
            foreach ($renewals as $key => $value) {
                $data[$key]['renewal_status_id']    = $value->renewal_status_id;
                $data[$key]['short_name']           = $value->short_name;
                $data[$key]['status_name']          = $value->status_name;
                $data[$key]['status']               = $value->status;
                $data[$key]['is_show']              = $value->is_show;
            }
        }
        return $data;
    }

}
