<?php
class CrmArchivedDetail extends Eloquent {

	public $timestamps = false;

	public static function getArchivedDetails()
	{
		$data = array();
		$session = Session::get('admin_details');
        $groupUserId = $session['group_users'];

        $details = CrmArchivedDetail::whereIn("user_id", $groupUserId)->get();
        if(isset($details) && count($details) > 0){
            foreach ($details as $key => $value) {
                $data[$key]['crm_archived_id']    	= $value->crm_archived_id;
                $data[$key]['user_id']          	= $value->user_id;
                $data[$key]['client_name']        	= $value->client_name;
                $data[$key]['annual_fee']        	= $value->annual_fee;
                $data[$key]['contract_start_date']  = (isset($value->contract_start_date) && $value->contract_start_date != '0000-00-00')?date('d-m-Y', strtotime($value->contract_start_date)):'';
                $data[$key]['notes']    			= $value->notes;
                $data[$key]['quotes']          		= $value->quotes;
                $data[$key]['status_name']        	= $value->status_name;
                $data[$key]['created']  			= $value->created;
            }
        }//print_r($data);die;
        return $data;
	}

	public static function save_details($client_id)
	{
		$ins_data = array();
		$session = Session::get('admin_details');
        $user_id = $session['id'];

        $acc_details = CrmAccDetail::getDetailsByClientId($client_id);

		$ins_data['user_id']               	= $user_id;

		$ins_data['join_date']             	= '';

        $ins_data['client_name']           	= Client::getClientNameByClientId($client_id);

        $ins_data['annual_fee']            	= (isset($acc_details['billing_amount']) && $acc_details['billing_amount'] != '')?$acc_details['billing_amount']:'';

        $ins_data['contract_start_date']   	= (isset($acc_details['engagement_date']) && $acc_details['engagement_date'] != '')?date('Y-m-d', strtotime($acc_details['engagement_date'])):'';

        $ins_data['notes']                 	= '';

        $ins_data['quotes']                	= '';

        $ins_data['status_name']           	= 'Accepted';

        $ins_data['created']               	= date('Y-m-d H:i:s');
        CrmArchivedDetail::insert($ins_data);
	}

}
