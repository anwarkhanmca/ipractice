<?php

class ClientPortalController extends BaseController {

	public function files()
	{
		$doc = array();
		$session        = Session::get('admin_details');
		$user_id    	= $session['id'];
        $groupUserId    = $session['group_users'];

		$data['heading'] 		= "FILES";
		$data['title'] 			= "Files";
		$data['portal']         = "client";
		$data['client_id'] 		= $session['client_id'];
		$client_id 				= $data['client_id'];

		$rel_clients = Common::get_relationship_client($client_id);
		$clients[] = $client_id;
		if(isset($rel_clients) && count($rel_clients) > 0 ){
			foreach($rel_clients as $key=>$value) {
				$clients[] = $value['client_id'];
			}
		}
		$allClient = array_unique($clients);

		$data['documents']      = FileSign::getDocumentsByClients($allClient);
        $data['client_details'] = FileSign::getRelationClient();
		
		//echo "<pre>";print_r($data['documents']);die;

		return View::make('Invitedclient/files/index', $data);
	}
    
    

}

