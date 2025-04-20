<?php
class VatScheme extends Eloquent {

	public $timestamps = false;

	public static function getIdByName( $name )
    {
    	$id = '';
        $data = VatScheme::where("vat_scheme_name", '=', $name)->select("vat_scheme_id")->first();
        if(isset($data['vat_scheme_id']) && $data['vat_scheme_id'] != ''){
        	$id = $data['vat_scheme_id'];
		}
		return $id;
    }

    public static function getNameById( $id )
    {
        $name = '';
        $data = VatScheme::where("vat_scheme_id", '=', $id)->select("vat_scheme_name")->first();
        if(isset($data['vat_scheme_name']) && $data['vat_scheme_name'] != ''){
            $name = $data['vat_scheme_name'];
        }
        return $name;
    }

}
