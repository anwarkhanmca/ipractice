<?php
class ClientDataStore extends Eloquent {

	public $timestamps = false;

	public static function getDetailsByStoreId($store_id)
    {
        $data = array();
        $details = ClientDataStore::where('store_id', $store_id)->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['field_id']         = $value->field_id;
                $data[$key]['field_name']       = $value->field_name;
                $data[$key]['prev_value']       = $value->prev_value;
                $data[$key]['updated_value']    = $value->updated_value;
                $data[$key]['full_name']        = $value->full_name;
            }
        }
        return $data;
    }

}
