<?php
class TaxRate extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails($used_for)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = DB::table('tax_rates')->where('used_for', '=', $used_for)
			->where(function ($query) use ($groupUserId)  {
                $query->whereIn('user_id', $groupUserId)
            ->orWhere('user_id', '=', '0');
            })->get();
        //Common::last_query();die;
        //print_r($session);die;
        return TaxRate::getArray($details);
	}

	public static function getTaxNameById($tax_id)
	{
		$name = '';

		$details = TaxRate::where('tax_rate_id', '=', $tax_id)->select('name')->first();
        if(isset($details['name']) && $details['name'] != ''){
        	$name = $details['name'];
        }
        return $name;
	}

	public static function getTaxPercentById($tax_id)
	{
		$rate = 0;

		$details = TaxRate::where('tax_rate_id', $tax_id)->select('rate')->first();
        if(isset($details->rate) && $details->rate != ''){
        	$rate = $details->rate;
        }
        return $rate;
	}

	public static function getSingleArray($details)
	{
		$data = array();
		if(isset($details) && count($details) >0){
			$data['tax_rate_id'] 	= $details->tax_rate_id;
			$data['user_id'] 		= $details->user_id;
			$data['name'] 			= $details->name;
			$data['rate'] 			= $details->rate;
			$data['status'] 		= $details->status;
			$data['is_archive'] 	= $details->is_archive;
			$data['used_for'] 		= $details->used_for;
			$data['created'] 		= $details->created;			
		}
		return $data;
	}

	public static function getArray($details)
	{
		$data = array();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['tax_rate_id'] 	= $value->tax_rate_id;
				$data[$key]['user_id'] 		= $value->user_id;
				$data[$key]['name'] 		= $value->name;
				$data[$key]['rate'] 		= $value->rate;
				$data[$key]['status'] 		= $value->status;
				$data[$key]['is_archive'] 	= $value->is_archive;
				$data[$key]['used_for'] 	= $value->used_for;
				$data[$key]['created'] 		= $value->created;
			}
			
		}
		return $data;
	}

}
