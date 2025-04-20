<?php
class CustomTasksTableHeading extends Eloquent {

	public $timestamps = false;

	public static function manageCustomTaskTableHeading($service_id, $field1, $field2)
    {
        $session      = Session::get('admin_details');
        $user_id      = $session['id'];

        $jobs = CustomTasksTableHeading::getDetailsByServiceId( $service_id );

        $data["field1"]         = $field1; 
        $data["field2"]         = $field2;

        if(isset($jobs) && count($jobs) >0){
            CustomTasksTableHeading::where("cust_head_id", "=", $jobs['cust_head_id'])->update($data);
            $last_id = $jobs['cust_head_id'];
        }else{
            $data["user_id"]    = $user_id;
            $data["service_id"] = $service_id;
            $data["created"]    = date('Y-m-d H:i:s');
            $last_id = CustomTasksTableHeading::insertGetId($data);
        }
        //return CustomTasksTableHeading::getDetailsByHeadingId( $last_id );
    }

    public static function getDetailsByServiceId( $service_id )
    {
        $data = array();
        $session      = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = CustomTasksTableHeading::whereIn('user_id', $groupUserId)->where('service_id', '=', $service_id)->first();
        
        return CustomTasksTableHeading::getSingleArray( $details );
    }

    public static function getDetailsByHeadingId( $heading_id )
    {
        $details = CustomTasksTableHeading::where('cust_head_id', '=', $heading_id)->first();
        return CustomTasksTableHeading::getSingleArray( $details );
    }

    public static function getSingleArray( $details )
    {
        $data = array();
        if(isset($details) && count($details) >0){
            $data['cust_head_id']   = $details->cust_head_id;
            $data['user_id']        = $details->user_id;
            $data['service_id']     = $details->service_id;
            $data['field1']         = $details->field1;
            $data['field2']         = $details->field2;
            //$data['headfield1']     = Common::getCorrectFieldName( $details->field1 );
            //$data['headfield2']     = Common::getCorrectFieldName( $details->field2 );
            $data['created']        = $details->created;
        }
        return $data;
    }

}
