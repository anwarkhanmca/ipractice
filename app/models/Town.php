<?php
class Town extends Eloquent {

	public $timestamps = false;

    public static function getTownById( $id )
    {
        $name = '';
        $data = Town::where("id", $id)->select("town")->first();
        if(isset($data['town']) && $data['town'] != ''){
            $name = $data['town'];
        }
        return $name;
    }

    public static function getCountyByTown( $town )
    {
        $name = '';
        $data = Town::where("town", $town)->select("county")->first();
        if(isset($data['county']) && $data['county'] != ''){
            $name = $data['county'];
        }
        return $name;
    }

}
