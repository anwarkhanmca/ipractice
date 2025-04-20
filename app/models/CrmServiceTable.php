<?php
class CrmServiceTable extends Eloquent {

	public $timestamps = false;

    public static function getAllTables( $groupUserId )
    {
        $details = CrmServiceTable::whereIn('user_id', $groupUserId)->get();
        return CrmServiceTable::getArray($details);
    }

    public static function getDetailsById( $id )
    {
        $details = CrmServiceTable::where("id", $id)->first();
        return CrmServiceTable::getSingleArray($details);
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0 )
        {
            $data['id']           = $value->id;
            $data['user_id']      = $value->user_id;
            $data['table_name']   = $value->table_name;
            $data['table_type']   = $value->table_type;
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
                $data[$key]['table_name']   = $value->table_name;
                $data[$key]['table_type']   = $value->table_type;
                $data[$key]['created']      = $value->created;
            }
        }
        return $data;
    }

    public static function deleteById($id)
    {
        CrmServiceTable::where("id", $id)->delete();
        CrmServiceFee::where("serv_table_id", $id)->delete();
    }

    public static function copyTableToProposalService($postData){
        $id             = $postData['id'];
        $proposal_id    = $postData['proposal_id'];
        $p_service_id   = $postData['p_service_id'];

        //delete first for replace
        CrmProposalServicesTable::deleteById($id);

        $details = CrmServiceTable::getDetailsById( $id );

        $Tdata['table_name']    = !empty($details['table_name'])?$details['table_name']:'';
        $Tdata['table_type']    = !empty($details['table_type'])?$details['table_type']:'';
        $Tdata['user_id']       = !empty($details['user_id'])?$details['user_id']:'';
        $Tdata['proposal_id']   = $proposal_id;
        $Tdata['p_service_id']  = $p_service_id;
        $Tdata['created']       = date('Y-m-d H:i:s');
        $last_id = CrmProposalServicesTable::insertGetId($Tdata);

        $dtls = CrmServiceFee::getDetailsByTableId( $id );
        if(isset($dtls) && count($dtls) >0){
            foreach ($dtls as $k => $v) {
                $data[$k]['desc']           = !empty($v['desc'])?$v['desc']:'';
                $data[$k]['fees']           = !empty($v['desc'])?$v['fees']:'';
                $data[$k]['user_id']        = !empty($v['user_id'])?$v['user_id']:'';
                $data[$k]['proposal_id']    = $proposal_id;
                $data[$k]['p_service_id']   = $p_service_id;
                $data[$k]['p_serv_table_id']= $last_id;
                $data[$k]['created']        = date('Y-m-d H:i:s');
            }
        }
        //print_r($data);die;
        if(!empty($data)){
            CrmProposalServiceFee::insert($data);
        }

        $detls = CrmProposalServicesTable::getDetailsById($last_id);
        return $detls;
    }





}
