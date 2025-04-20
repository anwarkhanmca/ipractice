<?php
class FileSign extends Eloquent {

	public $timestamps = false;

	public static function getDocumentsByClientId($client_id)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = FileSign::whereIn("user_id", $groupUserId)->where('client_id', '=', $client_id)->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['file_id'] = $value->file_id;
                $data[$key]['user_id'] = $value->user_id;
                $data[$key]['client_id'] = $value->client_id;
                $data[$key]['document'] = $value->document;
                $data[$key]['created'] = date('d-m-Y', strtotime($value->created));
            }
        }
        return $data;
    }

    public static function getDocumentsByClients($clients)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = FileSign::whereIn("user_id", $groupUserId)->whereIn('client_id', $clients)->get();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]['file_id'] = $value->file_id;
                $data[$key]['user_id'] = $value->user_id;
                $data[$key]['client_id'] = $value->client_id;
                $data[$key]['document'] = $value->document;
                $data[$key]['created'] = date('d-m-Y', strtotime($value->created));
            }
        }
        return $data;
    }

    public static function getDocumentsByFileId($file_id)
    {
        $data = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = FileSign::where('file_id', '=', $file_id)->first();
        if(isset($details) && count($details) >0){
            $data['file_id']    = $details['file_id'];
            $data['user_id']    = $details['user_id'];
            $data['client_id']  = $details['client_id'];
            $data['document']   = $details['document'];
            $data['created']    = date('d-m-Y', strtotime($details['created']));
        }
        return $data;
    }
    
    public static function getRelationClient()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $client_id      = $session['client_id'];

        $rel_client = Client::getRelationClientId($client_id);
        //print_r($rel_client);die;
        $i = 0;
        foreach ($rel_client as $key => $value) {
            $data[$i]['client_id'] 		= $value;
            $data[$i]['client_name'] 	= Client::getClientNameByClientId($value);
            $i++;
        }
        $data[$i]['client_id'] 		= $client_id;
        $data[$i]['client_name'] 	= Client::getClientNameByClientId($client_id);

        $sort = array();
        foreach($data as $k=>$v) {
            $sort[$k] = strtolower($v['client_name']);
        }

        array_multisort($sort, SORT_ASC, $data);
        
        return $data;
    }


}
