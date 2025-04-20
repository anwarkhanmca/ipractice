<?php
class JobsCtStatusName extends Eloquent {

	public $timestamps = false;

	/*public static function getIdByName( $name )
    {
    	$id = '';
        $data = VatScheme::where("vat_scheme_name", '=', $name)->select("vat_scheme_id")->first();
        if(isset($data['vat_scheme_id']) && $data['vat_scheme_id'] != ''){
        	$id = $data['vat_scheme_id'];
		}
		return $id;
    }*/

    public static function getStatusNameByClientServiceId( $client_id, $service_id )
    {
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];
      $name = 'Not Started';

      $details = DB::table('jobs_ct_status_names as js')
        ->where("js.service_id", $service_id)
        ->where("js.client_id", $client_id)
        ->join('jobs_steps as jstps', 'jstps.step_id', '=', 'js.status_id')
        ->whereIn("js.user_id", $groupUserId)
        ->select('jstps.title')
        ->first();

      if(isset($details['title']) && $details['title'] != ''){
        $name = $details['title'];
      }
      return $name;
    }

    public static function saveJobStatus($client_id, $service_id, $status_id)
    {
      $session    = Session::get('admin_details');
      $user_id    = $session['id'];

      $id = 0;
      if($service_id == 3){
        $d = JobsCtStatusName::where("client_id", $client_id)->where("service_id", $service_id)
          ->select("id")->first();
        
        $ud['status_id'] = $status_id;
        if(isset($d['id']) && $d['id'] >0){
          JobsCtStatusName::where('id', $d['id'])->update($ud);
          $id = $d['id'];
        }else{
          $ud['user_id']    = $user_id;
          $ud['client_id']  = $client_id;
          $ud['service_id'] = $service_id;
          $id = JobsCtStatusName::insertGetId($ud);
        }
      }  
      return $id;
    }

    public static function deleteJobStatus($client_id, $service_id)
    {
      $session        = Session::get('admin_details');
      $groupUserId    = $session['group_users'];

      $details = DB::table('jobs_ct_status_names as js')
        ->where("js.service_id", $service_id)
        ->where("js.client_id", $client_id)
        ->join('jobs_steps as jstps', 'jstps.step_id', '=', 'js.status_id')
        ->whereIn("js.user_id", $groupUserId)
        ->where("jstps.short_name", 'filed')
        ->select('jstps.short_name')
        ->first();
      //Common::last_query();die;

      if(empty($details->short_name) || $details->short_name != 'filed'){
        JobsCtStatusName::where("client_id", $client_id)->where("service_id", $service_id)->delete();
      }
    }

}
