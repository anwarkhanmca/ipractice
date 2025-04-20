<?php
class CrmProposalServicesTable extends Eloquent {

	public $timestamps = false;

	public static function getDetailsByProposalServiceId( $p_service_id, $groupUserId ) 
    {
        $details = CrmProposalServicesTable::whereIn('user_id',$groupUserId)->where("p_service_id",$p_service_id)->first();
		return CrmProposalServicesTable::getSingleArray($details);
    }

    public static function getDetailsByProposalId( $proposal_id, $groupUserId )
    {
        $details = CrmProposalServicesTable::whereIn('user_id',$groupUserId)->get();
        return CrmProposalServicesTable::getArray($details);
    }

    public static function getAllTables( $groupUserId )
    {
        $details = CrmProposalServicesTable::whereIn('user_id',$groupUserId)->get();
        return CrmProposalServicesTable::getArray($details);
    }

    public static function getDetailsById( $id )
    {
        $details = CrmProposalServicesTable::where("id", $id)->first();
        return CrmProposalServicesTable::getSingleArray($details);
    }

    public static function getProposalServiceIdById( $id )
    {
        $details = CrmProposalServicesTable::where("id",$id)->first();
        $p_service_id = 0;
        if(isset($details->p_service_id) && $details->p_service_id != ''){
            $p_service_id = $details->p_service_id;
        }
        return $p_service_id;
    }

    public static function checkIsTableAdded( $p_service_id )
    {
        $details = CrmProposalServicesTable::where("p_service_id",$p_service_id)->select('id')->first();
        $id = 0;
        if(isset($details->id) && $details->id != ''){
            $id = $details->id;
        }
        return $id;
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0 )
        {
            $data['id']           = $value->id;
            $data['user_id']      = $value->user_id;
            $data['proposal_id']  = $value->proposal_id;
            $data['p_service_id'] = $value->p_service_id;
            $data['table_name']   = $value->table_name;
            $data['table_type']   = $value->table_type;
            //$data['details']      = CrmProposalServiceFee::getDetailsByTableId($value->id);
            //$data['details']      = CrmProposalServiceFee::getDetailsByTableId($value->p_service_id);
            $data['details']      = CrmProposalServiceFee::getDetailsByPServiceId($value->p_service_id);
            $data['created']      = $value->created;
        }
        return $data;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0 )
        {
            foreach ($details as $key => $value) {
                $data[$key]['id']           = $value->id;
                $data[$key]['user_id']      = $value->user_id;
                $data[$key]['proposal_id']  = $value->proposal_id;
                $data[$key]['p_service_id'] = $value->p_service_id;
                $data[$key]['table_name']   = $value->table_name;
                $data[$key]['table_type']   = $value->table_type;
                $data[$key]['details']      = CrmProposalServiceFee::getDetailsByPServiceId($value->p_service_id);
                $data[$key]['created']      = $value->created;
            }
        }
        return $data;
    }

    public static function deleteById($id)
    {
        CrmProposalServicesTable::where("id", $id)->delete();
        CrmProposalServiceFee::where("p_serv_table_id", $id)->delete();
    }

}
