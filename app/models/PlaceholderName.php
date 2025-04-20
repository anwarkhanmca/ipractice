<?php
class PlaceholderName extends Eloquent {

	public static function getNameByType($type)
    {
        $details = PlaceholderName::where('type', '=', $type)->orderBy('shorting')->get();
        
        return PlaceholderName::getArray($details);
    }

    public static function getReplacingName($column_name)
    {
        $data = array();
        $details = PlaceholderName::select($column_name)->orderBy('placeholder_id')->get()->toArray();
        
        if(isset($details) && count($details)>0){
            foreach ($details as $key => $value) {
                if($column_name == 'view_name'){
                    $data[] = '['.$value[$column_name].']';
                }
                if($column_name == 'short_name'){
                    $data[] = $value[$column_name];
                }
            }
        }
        
        return $data;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['placeholder_id']   = $value->placeholder_id;
                $data[$key]['view_name']        = $value->view_name;
                $data[$key]['short_name']       = $value->short_name;
                $data[$key]['type']             = $value->type;
            }
        }
        return $data;
    }

}
