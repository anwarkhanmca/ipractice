<?php
class PastLeaveDetail extends Eloquent {

	public $timestamps = false;

	public static function getPastLeave($staff_id, $start)
    {
        $total_day  = 0;
        $start_date = date('Y-m-d', strtotime($start));
        $end        = date('Y-m-d', strtotime('+1 year', strtotime($start_date)));
        $end_date   = date('Y-m-d', strtotime('-1 day', strtotime($end)));
        
        $details  = PastLeaveDetail::where("user_id", "=", $staff_id)->where('start_date', '=', $start_date)->where('end_date', '=', $end_date)->first();
        //print_r($details);die;
        if(isset($details['total_leave']) && $details['total_leave'] !=""){
          $total_day = $details['total_leave'];
        }//Common::last_query();die;
        //echo $total_day;die;
        return $total_day;
    }

    public static function leavesByStaffAndDate($staff_id, $start)
    {
        $total_day  = 0;
        $start_date = date('Y-m-d', strtotime($start));
        $end        = date('Y-m-d', strtotime('+1 year', strtotime($start)));
        $end_date   = date('Y-m-d', strtotime('-1 day', strtotime($end)));
        
        $details  = PastLeaveDetail::where("user_id", "=", $staff_id)->where('start_date', '=', $start_date)->where('end_date', '=', $end_date)->first();
        
        return PastLeaveDetail::getSingleArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $details) {
                $data[$key]['past_leave_id']  = $details->past_leave_id;
                $data[$key]['user_id']        = $details->user_id;
                $data[$key]['start_date']     = (isset($details->start_date) && $details->start_date!='0000-00-00')?date('d-m-Y',strtotime($details->start_date)):'';
                $data[$key]['end_date']       = (isset($details->end_date) && $details->end_date!='0000-00-00')?date('d-m-Y',strtotime($details->end_date)):'';
                $data[$key]['total_leave']    = $details->total_leave;
                $data[$key]['created']        = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
            }
        }
        return $data;
    }

    public static function getSingleArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['past_leave_id']  = $details->past_leave_id;
            $data['user_id']        = $details->user_id;
            $data['start_date']     = (isset($details->start_date) && $details->start_date!='0000-00-00')?date('d-m-Y',strtotime($details->start_date)):'';
            $data['end_date']       = (isset($details->end_date) && $details->end_date!='0000-00-00')?date('d-m-Y',strtotime($details->end_date)):'';
            $data['total_leave']    = $details->total_leave;
            $data['created']        = (isset($details->created) && $details->created != '0000-00-00')?date('d-m-Y', strtotime($details->created)):'';
        }
        return $data;
    }

}
