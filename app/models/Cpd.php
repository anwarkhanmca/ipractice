<?php
class Cpd extends Eloquent {

	public $timestamps = false;

	public static function getAllDetails()
	{
		$data = array();
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        
		$details = Cpd::WhereIn('user_id',$groupUserId)->get();
		if(isset($details) && count($details) >0){
			foreach ($details as $key => $value) {
				$data[$key]['cpd_id'] 			= $value->cpd_id;
				$data[$key]['user_id'] 			= $value->user_id;
				$data[$key]['course_name'] 		= CpdCourseName::getCourseNameById($value->course_name);
				$data[$key]['course_date'] 		= $value->course_date;
				$data[$key]['course_time'] 		= $value->course_time;
				$data[$key]['course_duration'] 	= $value->course_duration;
				$data[$key]['notes'] 			= $value->notes;
				$data[$key]['file'] 			= $value->file;
				$data[$key]['user_id'] 			= unserialize($value->attendees);
				$data[$key]['attendees'] 		= Cpd::getAttendeesUser($value->attendees);
				$data[$key]['is_booked'] 		= $value->is_booked;
				$data[$key]['is_log'] 			= $value->is_log;
				$data[$key]['is_tracker'] 		= $value->is_tracker;
				$data[$key]['created'] 			= date("d-m-Y", strtotime($value->created));
			}
		}
		return $data;
	}

	public static function getDetailsByCpdId($cpd_id)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        
		$value = Cpd::Where('cpd_id', '=', $cpd_id)->first();
		if(isset($value) && count($value) >0){
			$data['cpd_id'] 			= $value->cpd_id;
			$data['user_id'] 			= $value->user_id;
			$data['course_name'] 		= $value->course_name;
			$data['course_date'] 		= $value->course_date;
			$data['course_time'] 		= $value->course_time;
			$data['course_duration'] 	= $value->course_duration;
			$data['notes'] 				= $value->notes;
			$data['file'] 				= $value->file;
			$data['user_id'] 			= unserialize($value->attendees);
			$data['attendees'] 			= Cpd::getAttendeesUser($value->attendees);
			$data['is_booked'] 			= $value->is_booked;
			$data['is_log'] 			= $value->is_log;
			$data['is_tracker'] 		= $value->is_tracker;
			$data['created'] 			= date("d-m-Y", strtotime($value->created));
		}
		return $data;
	}

	public static function getDetailsByUserAndDate($user_id, $date)
	{
		$data = array();
		$session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];
        
		$details = Cpd::WhereIn('user_id',$groupUserId)->where('course_date', '=', $date)->where('is_log', '=', 'Y')->get();
		if (isset($details) && count($details) >0) {
			$i = 0;
			foreach ($details as $key => $value) {
				$attendees = unserialize($value->attendees);

				if(is_array($attendees) && in_array($user_id, $attendees)){
					$data[$i]['staff_name'] = User::getStaffNameById($user_id);
					$data[$i]['date'] 		= $value->course_date;
					$data[$i]['duration'] 	= $value->course_duration;
					$data[$i]['color_code'] = '228B22';
					$i++;
				}
			}
		}

//echo "<pre>";print_r($data);
		//$details = Cpd::getSingleArray($value);
		return $data;
	}

	public static function getAttendeesUser($serialise){
		$data = array();
		if (isset($serialise) && $serialise != "") {
            $attendees = unserialize($serialise);
            $userdetails = User::select("fname", "lname")->WhereIn("user_id", $attendees)->get();

            foreach ($userdetails as $indexkey => $username) {
				$data[$indexkey]['name'] = $username->fname . " " . $username->lname;
            }
        }
        return $data;
	}

	public static function getSingleArray($value)
    {
        $data = array();
        if(isset($value) && count($value) >0){
			$data['cpd_id'] 			= $value->cpd_id;
			$data['user_id'] 			= $value->user_id;
			$data['course_name'] 		= $value->course_name;
			$data['course_date'] 		= $value->course_date;
			$data['course_time'] 		= $value->course_time;
			$data['course_duration'] 	= $value->course_duration;
			$data['notes'] 				= $value->notes;
			$data['file'] 				= $value->file;
			$data['user_id'] 			= unserialize($value->attendees);
			$data['attendees'] 			= Cpd::getAttendeesUser($value->attendees);
			$data['is_booked'] 			= $value->is_booked;
			$data['is_log'] 			= $value->is_log;
			$data['is_tracker'] 		= $value->is_tracker;
			$data['created'] 			= date("d-m-Y", strtotime($value->created));
		}
        return $data;
    }

}
