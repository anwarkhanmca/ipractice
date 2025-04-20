<?php
class CrmProposalServiceFee extends Eloquent {

	public $timestamps = false;

	public static function getDetailsByProposalServiceId( $p_service_id, $groupUserId )
    {
        $details = CrmProposalServiceFee::whereIn('user_id',$groupUserId)->where("p_service_id",$p_service_id)->get();
		return CrmProposalServiceFee::getArray($details);
    }

    public static function getDetailsByServiceTableId( $p_serv_table_id, $groupUserId )
    {
        $details = CrmProposalServiceFee::whereIn('user_id',$groupUserId)->where("p_serv_table_id",$p_serv_table_id)->get();
        return CrmProposalServiceFee::getArray($details);
    }

    public static function getDetailsByTableId( $p_serv_table_id )
    {
        $details = CrmProposalServiceFee::where("p_serv_table_id",$p_serv_table_id)->get();
        return CrmProposalServiceFee::getArray($details);
    }

    public static function getDetailsByPServiceId( $p_service_id )
    {
        $details = CrmProposalServiceFee::where("p_service_id",$p_service_id)->get();
        return CrmProposalServiceFee::getArray($details);
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0 )
        {
            foreach ($details as $key => $value) {
                $data[$key]['id']               = $value->id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]['proposal_id']      = $value->proposal_id;
                $data[$key]['p_service_id']     = $value->p_service_id;
                $data[$key]["p_serv_table_id"]  = $value->p_serv_table_id;
                $data[$key]['desc']             = $value->desc;
                $data[$key]['fees']             = ($value->fees != '0.00')?$value->fees:'';
                $data[$key]['notes']            = $value->notes;
                $data[$key]['created']          = $value->created;
            }
        }
        return $data;
    }

}
