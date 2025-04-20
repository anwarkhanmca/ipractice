<?php
class ClientAddress extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
    {
        $data       = array();
        $session            = Session::get('admin_details');
        $user_id            = $session['id'];
        $groupUserId        = $session['group_users'];

        $details = ClientAddress::whereIn("user_id", $groupUserId)->get();
        return ClientAddress::getArray($details);
    }

    public static function getDetailsById($address_id)
    {
        $data       = array();
        $session            = Session::get('admin_details');
        $user_id            = $session['id'];
        $groupUserId        = $session['group_users'];

        $value = ClientAddress::where("address_id", '=', $address_id)->first();
        if(isset($value) && count($value) >0){
            $data['address_id']     = $value['address_id'];
            $data['user_id']        = $value['user_id'];
            $data['address1']       = $value['address1'];
            $data['address2']       = $value['address2'];
            $data['city']           = $value['city'];
            $data['county']         = $value['county'];
            $data['postcode']       = $value['postcode'];
            $data['country']        = $value['country'];
            $data['country_name']   = Country::getCountryNameByCountryId($value['country']);
            $data['fullAddress']    = ClientAddress::getFullAddress($address_id);
            $data['is_show_main']   = $value->is_show_main;
            $data['is_show_client'] = $value->is_show_client;
        }
        return $data;
    }

    public static function checkAddress($checkaddr1, $checkpost, $page_open)
    {
        $return   = 0;
        $session            = Session::get('admin_details');
        $user_id            = $session['id'];
        $groupUserId        = $session['group_users'];

        if($page_open == 'main')
            $details = ClientAddress::whereIn("user_id", $groupUserId)->get();
        else
           $details = ClientAddress::whereIn("user_id", $groupUserId)->where('is_show_client', 'Y')->get();
            
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $value1    = substr($value->address1, 0, 7);
                if($checkaddr1 == $value1 && $checkpost == $value->postcode){
                    $return = $value->address_id;
                    break;
                }
            }
        }
        return $return;
    }

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['address_id']  = $value->address_id;
                $data[$key]['user_id']     = $value->user_id;
                $data[$key]['address1']    = $value->address1;
                $data[$key]['address2']    = $value->address2;
                $data[$key]['city']        = $value->city;
                $data[$key]['county']           = $value->county;
                $data[$key]['postcode']         = $value->postcode;
                $data[$key]['country']          = $value->country;
                $data[$key]['country_name']     = Country::getCountryNameByCountryId($value->country);
                $data[$key]['fullAddress']      = ClientAddress::getFullAddress($value->address_id);
                $data[$key]['is_show_main']     = $value->is_show_main;
                $data[$key]['is_show_client']   = $value->is_show_client;
            }
        }
        return $data;
    }

    public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
            $data['address_id']         = $value->address_id;
            $data['user_id']            = $value->user_id;
            $data['address1']           = $value->address1;
            $data['address2']           = $value->address2;
            $data['city']               = $value->city;
            $data['county']             = $value->county;
            $data['postcode']           = $value->postcode;
            $data['country']            = $value->country;
            $data['country_name']       = Country::getCountryNameByCountryId($value->country);
            $data['fullAddress']        = ClientAddress::getFullAddress($value->address_id);
            $data['is_show_main']       = $value->is_show_main;
            $data['is_show_client']     = $value->is_show_client;
        }
        return $data;
    }

    public static function getFullAddress($address_id)
    {
        $address = "";
        if($address_id != '0' && $address_id != ""){
            $value = ClientAddress::where("address_id", $address_id)->first();

            $country_name  = Country::getCountryNameByCountryId($value['country']);
            $address .= (isset($value->address1) && $value->address1 != '')?$value->address1:'';
            $address .= (isset($value->address2) && $value->address2 != '')?', '.$value->address2:'';
            $address .= (isset($value->city) && $value->city != '')?', '.$value->city:'';
            $address .= (isset($value->county) && $value->county != '')?', '.$value->county:'';
            $address .= (isset($value->postcode) && $value->postcode != '')?', '.$value->postcode:'';
            $address .= (isset($country_name) && $country_name != '')?', '.$country_name:'';
        }
        
        return $address;
    }

    public static function getClientAddress($client_id, $client_type)
    {
        $type = ($client_type == 'ind')?"res":"corres";
        
        $address_id = StepsFieldsClient::getAddressIdByClientId($client_id, $type.'_address');
        $address = ClientAddress::getFullAddress($address_id);
        return $address;
    }

    public static function getAllAddressAndId()
    {
        $data = array();
        $session            = Session::get('admin_details');
        $user_id            = $session['id'];
        $groupUserId        = $session['group_users'];

        $details = ClientAddress::whereIn("user_id", $groupUserId)->select('address_id', 'address_type')->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['address_id']   = $value->address_id;
                $data[$key]['address_type'] = $value->address_type;
                $data[$key]['fullAddress']  = ClientAddress::getFullAddress($value->address_id);
            }
        }
        return $data;
    }

    public static function fullAddressByClientIdAndType($client_id, $address_type)
    {
        $address = "";
        $value = ClientAddress::where("client_id", $client_id)->where("address_type", $address_type)->first();

        $country_name  = Country::getCountryNameByCountryId($value['country']);
        $address .= (isset($value->address1) && $value->address1 != '')?$value->address1:'';
        $address .= (isset($value->address2) && $value->address2 != '')?', '.$value->address2:'';
        $address .= (isset($value->city) && $value->city != '')?', '.$value->city:'';
        $address .= (isset($value->county) && $value->county != '')?', '.$value->county:'';
        $address .= (isset($value->postcode) && $value->postcode != '')?', '.$value->postcode:'';
        $address .= (isset($country_name) && $country_name != '')?', '.$country_name:'';
        
        return $address;
    }

    public static function getAddressForClientPortal($client_id, $client_type)
    {
        $data           = array();
        $addressId      = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        if($client_type == 'ind'){
            $array = array( "serv", "res");
        }else{
            $array = array( "trad", "reg", "corres", "banker", "oldacc", "auditors", "solicitors");
        }
        
        $i = 0;
        foreach ($array as $key => $val) {
            $address   = StepsFieldsClient::getAddressIdByClientId($client_id, $val.'_address');
            if($address != 0){
                $addressId[$i] = $address;
                $i++;
            }
        }
        //echo "<pre>";print_r($addressId);die;

        $Ids = ClientAddress::whereIn("user_id", $groupUserId)->where("is_show_client", 'Y')->where("client_id", $client_id)->get();
        if(isset($Ids) && count($Ids) >0){
            foreach ($Ids as $key => $value) {
                $addressId[$i] = $value->address_id;
                $i++;
            }
        }

        if(isset($addressId) && count($addressId) >0){
            $details = ClientAddress::whereIn("address_id", $addressId)->get();
            $data = ClientAddress::getArray($details);
        }
        return $data;
    }

    public static function getAddressByClientIdAndType($client_id, $address_type)
    {
        $data = array();
        $address_id = StepsFieldsClient::getAddressIdByClientId($client_id, $address_type."_address");
        if($address_id != ""){
            $data    = ClientAddress::getDetailsById($address_id);
        }
        
        return $data;
    }

    public static function addressByplaceHolder($postData)
    {
        $contact_type   = $postData['contact_type'];
        $client_id      = $postData['client_id'];
        $short_name     = $postData['short_name'];

        $value = ' ';
        if($short_name == 'client_address'){
            $type   = explode('_', $contact_type);
            if($type[0] == 'p'){
                $value =  CrmLead::getFullAddress($client_id);
            }
            if($type[0] == 'c'){
                $type = ($type[1] == 'ind')?'res':'corres';
                $address_id = StepsFieldsClient::getAddressIdByClientId($client_id, $type."_address");
                if($address_id != ""){
                    $value = ClientAddress::getFullAddress($address_id);
                }
            }
        }

        //$value = trim( ltrim( rtrim( trim($value), ',' ) ) );
        $value = trim( trim($value, ',' ) );
        return $value;
    }

}
