<?php
class TaxreturnMessage  extends Eloquent{
	
	public $timestamps = false;
	public static function getMessage1($checklist_id)
	{
		$data = array();

        $details = TaxreturnMessage::where('checklist_id', '=', $checklist_id)->get();
        if(isset($details) && count($details) >0){
	        foreach ($details as $key => $value) {
                $details = User::where("user_id", "=", $value->from_user_id)->select("fname", "lname", "client_id")->first();
                if(isset($details['client_id']) && $details['client_id'] == '0'){
                    $from_name = getStaffNameById($value->from_user_id);
                }else{
                    $from_name = getClientNameByClientId($details['client_id']);
                }
                
                $details = User::where("user_id", "=", $value->to_user_id)->select("fname", "lname", "client_id")->first();
                if(isset($details['client_id']) && $details['client_id'] == '0'){
                    $to_name = getStaffNameById($value->to_user_id);
                }else{
                    $to_name = getClientNameByClientId($details['client_id']);
                }
                
                
                $data[$key]['from_bladge'] 	= Client::get_initial_badge($from_name);
                $data[$key]['to_bladge'] 	= Client::get_initial_badge($to_name);
	        	$data[$key]['message_id'] 	= $value->message_id;
				$data[$key]['checklist_id'] = $value->checklist_id;
				$data[$key]['service_id'] 	= $value->service_id;
				$data[$key]['from_user_id'] = $value->from_user_id;
				$data[$key]['to_user_id'] 	= $value->to_user_id;
				$data[$key]['subject'] 		= $value->subject;
				$data[$key]['message'] 		= $value->message;
				$data[$key]['is_deleted'] 	= $value->is_deleted;
				$data[$key]['is_viewed'] 	= $value->is_viewed;
				$data[$key]['reply_id'] 	= $value->reply_id;
				$data[$key]['created'] 		= $value->created;
        	}
		}
		//print_r($data);die;
		return $data;
	}

	public static function getDetailsByMessageId($message_id)
	{
		$data = array();

        $value = TaxreturnMessage::where('message_id', '=', $message_id)->first();
        if(isset($value) && count($value) >0){
        	$data['message_id'] 	= $value->message_id;
			$data['checklist_id'] 	= $value->checklist_id;
			$data['service_id'] 	= $value->service_id;
			$data['from_user_id'] 	= $value->from_user_id;
			$data['to_user_id'] 	= $value->to_user_id;
			$data['subject'] 		= $value->subject;
			$data['message'] 		= $value->message;
			$data['is_deleted'] 	= $value->is_deleted;
			$data['is_viewed'] 		= $value->is_viewed;
			$data['reply_id'] 		= $value->reply_id;
			$data['created'] 		= $value->created;
		}
		//print_r($data);die;
		return $data;
	}

	public static function getMessage($checklist_id, $client_id)
	{
		$data1 = array();
		$dataOuter = array();
        
        $user_id = User::getUserIdByClientId($client_id);
        
        //$details = TaxreturnMessage::where('checklist_id', '=', $checklist_id)->where('reply_id', '=', 0)->where('from_user_id', '=', $user_id)->orWhere('to_user_id', '=', $user_id)->orderBy('message_id', 'DESC')->get();
        
        $details = TaxreturnMessage::where(function($query) use ($user_id)
        {
            $query->where('from_user_id', '=', $user_id);
            $query->orWhere('to_user_id', '=', $user_id);
        })
        ->where('checklist_id', '=', $checklist_id)->where('reply_id', '=', 0)->orderBy('message_id', 'DESC')->get();
        //Common::last_query();
        if(isset($details) && count($details) >0){
        	foreach ($details as $key => $value) {
        		$i = 0;
        		$data = array();

        		$dataOuter[$key]['message_id'] 	= $value->message_id;
        		$dataOuter[$key]['subject'] 	= $value->subject;

        		$data[$i] 	= TaxreturnMessage::getDetailsByMessageId($value->message_id);
                if(isset($data) && count($data) >0){
			        foreach ($data as $k => $row) {
                        $details = User::where("user_id", "=", $row['from_user_id'])->select("fname", "lname", "client_id")->first();
                        if(isset($details['client_id']) && $details['client_id'] == '0'){
                            $from_name = User::getStaffNameById($row['from_user_id']);
                        }else{
                            $from_name = Client::getClientNameByClientId($details['client_id']);
                        }

                        $details = User::where("user_id", "=", $row['to_user_id'])->select("fname", "lname", "client_id")->first();
                        if(isset($details['client_id']) && $details['client_id'] == '0'){
                            $to_name = User::getStaffNameById($row['to_user_id']);
                        }else{
                            $to_name = Client::getClientNameByClientId($details['client_id']);
                        }
                        
                        $data[$i]['from_bladge'] 	= Client::get_initial_badge($from_name);
                        $data[$i]['to_bladge']      = Client::get_initial_badge($to_name);
                    }
		        }
//echo "<pre>";print_r($data);die;
        		$details_1 = TaxreturnMessage::where('reply_id', '=', $value->message_id)->orderBy('message_id', 'ASC')->get();
        		//Common::last_query();
        		$i++;
		        if(isset($details_1) && count($details_1) >0){
			        foreach ($details_1 as $key1 => $value_1) {
                        $details = User::where("user_id", "=", $value_1->from_user_id)->select("fname", "lname", "client_id")->first();
                        if(isset($details['client_id']) && $details['client_id'] == '0'){
                            $from_name = User::getStaffNameById($value_1->from_user_id);
                        }else{
                            $from_name = Client::getClientNameByClientId($details['client_id']);
                        }

                        $details = User::where("user_id", "=", $value_1->to_user_id)->select("fname", "lname", "client_id")->first();
                        if(isset($details['client_id']) && $details['client_id'] == '0'){
                            $to_name = User::getStaffNameById($value_1->to_user_id);
                        }else{
                            $to_name = Client::getClientNameByClientId($details['client_id']);
                        }


                        $data[$i]['from_bladge'] 	= Client::get_initial_badge($from_name);
                        $data[$i]['to_bladge']      = Client::get_initial_badge($to_name);
			        	$data[$i]['message_id'] 	= $value_1->message_id;
						$data[$i]['checklist_id'] 	= $value_1->checklist_id;
						$data[$i]['service_id'] 	= $value_1->service_id;
						$data[$i]['from_user_id'] 	= $value_1->from_user_id;
						$data[$i]['to_user_id'] 	= $value_1->to_user_id;
						$data[$i]['subject'] 		= $value_1->subject;
						$data[$i]['message'] 		= $value_1->message;
						$data[$i]['is_deleted'] 	= $value_1->is_deleted;
						$data[$i]['is_viewed'] 		= $value_1->is_viewed;
						$data[$i]['reply_id'] 		= $value_1->reply_id;
						$data[$i]['created'] 		= $value_1->created;
						//echo "<pre>";print_r($data);//die;
						$i++;
		        	}
		        	
		        }
		        $dataOuter[$key]['messages'] 	= $data;
			}
		}
		//echo "<pre>";print_r($dataOuter);die;
		return $dataOuter;
	}
	

}
