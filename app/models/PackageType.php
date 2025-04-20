<?php
class PackageType extends Eloquent {

	public $timestamps = false;

	public static function getProposalTypes()
    {
        $data = PackageType::get()->toArray();
        return $data;
    }

    public static function getPackageNameByType($type)
    {
        $name = '';
        $data = PackageType::where("value", $type)->select("name")->first();
        if(isset($data['name']) && $data['name'] != ''){
            $name = $data['name'];
        }
        return $name;
    }



}
