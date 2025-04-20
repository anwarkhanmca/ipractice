<?php
class StaffAppraisalSign  extends Eloquent{
	
	public $timestamps = false;
	
	public static function getDetailsByAppraisalId($appraisal_id, $page_type)
	{
		$details = StaffAppraisalSign::where("staff_appraisal_id", "=", $appraisal_id)->where("page_type", "=", $page_type)->first();
		
		return StaffAppraisalSign::getSingleArray($details);
	}

	public static function getSingleArray($details)
	{
		$data = array();
		if(isset($details) && count($details) >0){
			$data['sign_id'] = $details->sign_id;
			$data['staff_appraisal_id'] = $details->staff_appraisal_id;
			$data['user_id'] 	= $details->user_id;
			$data['page_type'] 	= $details->page_type;
			$data['date'] 		= date('d-m-Y', strtotime($details->created));
			$data['time'] 		= date('H:i', strtotime($details->created));
			$data['created'] 	= $details->created;
			$data['staff_name'] = User::getStaffNameById( $details->user_id );
		}
		return $data;
	}



}
