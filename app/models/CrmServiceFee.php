<?php
class CrmServiceFee extends Eloquent {

	public $timestamps = false;

	public static function getDetailsById( $id )
    {
        $details = CrmServiceFee::where("id",$id)->first();
		return CrmServiceFee::getSingleArray($details);
    }

    public static function getDetailsByTableId( $serv_table_id )
    {
        $details = CrmServiceFee::where("serv_table_id",$serv_table_id)->get();
        return CrmServiceFee::getArray($details);
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0 )
        {
            $data['id']               = $value->id;
            $data['user_id']          = $value->user_id;
            $data["serv_table_id"]      = $value->serv_table_id;
            $data['desc']             = $value->desc;
            $data['fees']             = ($value->fees != '0.00')?$value->fees:'';
            $data['created']          = $value->created;
        }
        return $data;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0 )
        {
            foreach ($details as $key => $value) {
                $data[$key]['id']               = $value->id;
                $data[$key]['user_id']          = $value->user_id;
                $data[$key]["serv_table_id"]    = $value->serv_table_id;
                $data[$key]['desc']             = $value->desc;
                $data[$key]['fees']             = ($value->fees != '0.00')?$value->fees:'';
                $data[$key]['created']          = $value->created;
            }
        }
        return $data;
    }

}
