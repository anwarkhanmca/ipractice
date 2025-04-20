<?php
class Service  extends Eloquent{
	
	public $timestamps = false;
	public static function getNameServiceId( $service_id )
	{
		$name = "";
		$details = Service::where('service_id',$service_id)->select('service_name')->first();
		if(isset($details['service_name']) && $details['service_name'] != ""){
			$name 	= $details['service_name'];
		}
		return $name;
	}

	public static function getOldOrgService()
    {
        $ret_value = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = Service::where('service_id',"<",10)->orderBy('ordering', 'ASC')->get();
        return Service::getArray($details);
    }

    public static function getAllOrgService()
    {
        $ret_value = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = Service::where("client_type", 'org')->get();
        return Service::getArray($details);
    }

    public static function getAllServiceByType($type)
    {
        $ret_value = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = DB::table('services')->where("client_type", "=", $type)
            ->where(function ($query) use ($groupUserId)  {
                $query->whereIn('user_id', $groupUserId)
            ->orWhere('user_id', '=', '0');
            })->orderBy('service_name')->get();

        //$details = Service::where("client_type", "=", $type)->orderBy('service_name')->get();
        return Service::getArray($details);
    }

    public static function getServiceIdAndNameByType($type)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = DB::table('services')->where("client_type", "=", $type)
            ->where(function ($query) use ($groupUserId)  {
                $query->whereIn('user_id', $groupUserId)
            ->orWhere('user_id', '=', '0');
            })->orderBy('service_name')->select('service_id', 'service_name')->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]["service_id"]      = $value->service_id;
                $data[$key]["service_name"]    = $value->service_name;
            }
        }
        //$details = Service::where("client_type", "=", $type)->orderBy('service_name')->get();
        return $data;
    }

    public static function getLastOrderId($type)
    {
        $ret_value = 1;
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $services = Service::where("client_type", "=", $type)->orderBy('ordering', 'DESC')->first();
        if(isset($services["ordering"]) && $services["ordering"] != ''){
            $ret_value = $services['ordering'];

        }
        return $ret_value;
    }

    public static function getCustomTasks($type)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = Service::whereIn('user_id', $groupUserId)->where("client_type", $type)->where("status", 'new')->get();
        
        return Service::getArray($details);
    }

    public static function getAllCustomTasks()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = Service::whereIn('user_id', $groupUserId)->where("status", 'new')->get();
        
        return Service::getArray($details);
    }
    
    public static function getAllOldServiceByType($type)
    {
        $details = Service::where("client_type", "=", $type)->where("status", "=", 'old')->get();
        return Service::getArray($details);
    }
    
    /*public static function getAllServices()
    {
        $data = array();
        $old_org_services = Service::getAllOldServiceByType('org');
        $new_org_services = Service::getCustomTasks('org');
        
        $old_ind_services = Service::getAllOldServiceByType('ind');
        $new_ind_services = Service::getCustomTasks('ind');
        
        $data = array_merge($old_org_services, $new_org_services, $old_ind_services, $new_ind_services);
        
        return array_values($data);
    }*/
    public static function getAllServices()
    {
        $details = Service::get();
        return Service::getArray($details);
    }

    public static function getServicesByType( $type )
    {
        $data           = array();
        $old_services   = array();
        $new_services   = array();

        if($type == 'org'){
            $old_services = Service::getAllOldServiceByType( $type );
            $new_services = Service::getCustomTasks( $type );
        }else{
            $old_services = Service::getAllOldServiceByType( $type );
            $new_services = Service::getCustomTasks( $type );
        }
        
        $data = array_merge($old_services, $new_services);
        
        return array_values($data);
    }
    

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]["service_id"]      = $value->service_id;
                $data[$key]["user_id"]         = $value->user_id;
                $data[$key]["client_type"]     = $value->client_type;
                $data[$key]["client_id"]       = $value->client_id;
                $data[$key]["service_name"]    = $value->service_name;
                $data[$key]["ordering"]        = $value->ordering;
                $data[$key]["status"]          = $value->status;
                $data[$key]["is_archive"]      = $value->is_archive;
                $data[$key]["show_archive"]    = $value->show_archive;
                $data[$key]["custom_head"]= CustomTasksTableHeading::getDetailsByServiceId($value->service_id);
                $data[$key]["price"]           = $value->price;
                $data[$key]["base_fee"]        = $value->base_fee;
                $data[$key]["tax_rate"]        = $value->tax_rate;
                $data[$key]["added_from"]      = $value->added_from;
            }
        }
        return $data;
    }

    public static function getHeadingName($service_id)
    {
      $service_name = Service::getNameServiceId($service_id);
      return $service_name;
      /*switch ($service_id){
        case 1:
          return 'VAT RETURNS';
          break;
        case 2:
          return 'EC SALES LIST';
          break;
        case 3:
          return 'ACCOUNTS';
          break;
        case 4:
          return 'BOOKKEEPING';
          break;
        case 5:
          return 'CORPORATION TAX';
          break;
        case 6:
          return 'AUDITS';
          break;
        case 7:
          return 'INCOME TAX RETURNS';
          break;
        case 8:
          return 'MANAGEMENT ACCOUNTS';
          break;
        case 9:
          return 'CONFIRMATION STATEMENT';
          break;
          
      }*/
    }
	

}
