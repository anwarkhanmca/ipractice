<?php
class CrmTableService extends Eloquent {

	public $timestamps = false;

    public static function getServicesByHeadingId($heading_id)
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = DB::table('crm_table_services as cts')->whereIn('cts.user_id', $groupUserId)
            ->where('cts.heading_id', '=', $heading_id)
            ->leftJoin('services as s', 's.service_id', '=', 'cts.service_id')
            ->select('cts.*', 's.service_name', 's.base_fee')->orderBy('cts.sorting', 'asc')
            ->get();
        //Common::last_query();die;
        return CrmTableService::getArray($details);
    }




    public static function getArray($details)
    {
        $d = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $v) {                

                $d[$key]["id"]              = $v->id;
                $d[$key]["user_id"]         = $v->user_id;
                $d[$key]["heading_id"]      = $v->heading_id;
                $d[$key]["service_id"]      = $v->service_id;
                $d[$key]["fee_type"]        = $v->fee_type;
                $d[$key]["flex_fees"]       = $v->flex_fees;
                $d[$key]["fees"]            = $v->fees;
                $d[$key]["is_show_fees"]    = $v->is_show_fees;
                $d[$key]["billing_freq"]    = $v->billing_freq;
                $d[$key]["tax_rate"]        = $v->tax_rate;
                $d[$key]["isFeeAdded"]      = $v->isFeeAdded;
                $d[$key]["notes"]           = $v->notes;
                $d[$key]["service_name"]    = $v->service_name;
                $d[$key]["base_fee"]        = $v->base_fee;
            }
        }
        return $d;
    }

}
