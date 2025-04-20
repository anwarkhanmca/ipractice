<?php 
include ('connect.php'); 
include('../../app/library/FileAndSign.php');
/*function searchClientByName($client_id, $searchvalue)
{
	$data 			= array();
	$client_details = array();
	$final_arr 		= array();
	$newvardump 	= array();

	$details = FileAndSign::getDocumentsByClientId($client_id);
	if(isset($details) && count($details) >0){
		foreach ($details as $key => $value) {
			$value = App::make('HomeController')->arraytolower($value);
			$temp  = App::make('HomeController')->search_array($value,$searchvalue,$final_arr);
			if(isset($temp) && count($temp) > 0){
                $newvardump[$key] = $details[$key];
			}
		}
		$client_details = array_values($newvardump);
	}
    return $client_details;
}*/

$action 	= $_REQUEST['action'];
$data = '';

if($action == 'all'){
	$client_id 		= $_REQUEST['client_id'];
	$documents = FileAndSign::getDocumentsByClientId($client_id);
	
	if(isset($documents) && count($documents) >0){
		foreach($documents as $key=>$row){
			$data .= '<li class="file_hide_'.$row['file_id'].'"><span class="text_left view_document" data-file_id="'.$row['file_id'].'" title="'.$row['document'].'">'.substr($row['document'], 0, 24).'</span> <span class="text_right delete_files" data-file_id="'.$row['file_id'].'"><img src="../img/cross.png" height="12" /></span><div class="clearfix"></div></li>';
		} 
	}
}else if($action == 'delete'){
	$file_id 	= $_REQUEST['file_id'];
	FileSign::where('file_id', $file_id)->delete();
	$data = $file_id;
}else if($action == 'search_client'){
	$data = '';
	$portal 		= $_REQUEST['portal'];
	$client_name 	= $_REQUEST['client_name'];
	$details = Client::searchClientByName($client_name);

	if($portal == 'client'){
		$clientData 	= array();
		$session        = Session::get('admin_details');
    	$client_id    	= $session['client_id'];
    	if(isset($details) && count($details) >0){
			$clients = Client::getRelationClientId($client_id);
			$i = 0;
			foreach ($details as $key => $value) {
				$cl_id = $value['client_id'];
				if(in_array($cl_id, $clients) && isset($value['client_type']) && $value['client_type']=='org'){
					$clientData[$i]['client_id'] 	= $cl_id;
					$clientData[$i]['client_name'] 	= Client::getClientNameByClientId($cl_id);
					$i++;
				}
			}
			$clientData[$i]['client_id'] 	= $client_id;
			$clientData[$i]['client_name'] 	= Client::getClientNameByClientId($client_id);

			$sort = array();
	        foreach($clientData as $k=>$v) {
	            $sort[$k] = strtolower($v['client_name']);
	        }

	        array_multisort($sort, SORT_ASC, $clientData);
		}
		$details = $clientData;
	}
    
	if(isset($details) && count($details) >0){
		foreach($details as $key=>$value){
			if( !empty( $value['client_name'] ) ){
				$data .= "<li><a href='javascript:void(0)' class='putClientName' data-client_name='".$value['client_name']."' data-client_id='".$value['client_id']."'>".$value['client_name']."</a></li>";
			}
		} 
	}
    
}else if($action == 'search_client_portal'){
	$data = array();
	$session        = Session::get('admin_details');
    $client_id    	= $session['client_id'];
	$client_name 	= $_REQUEST['client_name'];

	$details = Client::searchClientByName($client_name);
	if(isset($details) && count($details) >0){
		$clients = Client::getRelationClientId($client_id);
		//print_r($details);die;
		$i = 0;
		foreach ($details as $key => $value) {
			$cl_id = $value['client_id'];
			if(in_array($cl_id, $clients) && isset($value['client_type']) && $value['client_type']=='org'){
				$data[$i] = $details[$key];
				$i++;
			}
		}
		$data[$i]['client_id'] 		= $client_id;
		$data[$i]['client_name'] 	= Client::getClientNameByClientId($client_id);
	}
	$data = json_encode($data);
}else if($action == 'insert_doc'){
	if(isset($_REQUEST['client_id']) && $_REQUEST['client_id'] != ''){
		$doc_name 		= $_REQUEST['doc_name'];
		$client_id 		= $_REQUEST['client_id'];
		$session      = Session::get('admin_details');
	  $user_id    	= $session['id'];

    $insrt_data['user_id'] 		= $user_id;
    $insrt_data['client_id'] 	= $client_id;
    $insrt_data['document'] 	= $doc_name;
    $insrt_data['created'] 		= date('Y-m-d H:i:s');
		$file_id = FileSign::insertGetId($insrt_data);
		$data = '<li class="file_hide_'.$file_id.'"><span class="text_left view_document" data-file_id="'.$file_id.'" title="'.$doc_name.'">'.substr($doc_name, 0, 24).'</span> <span class="text_right delete_files" data-file_id="'.$file_id.'"><img src="../img/cross.png" height="12" /></span><div class="clearfix"></div></li>';

		/* client edit form activity pop up display */
		$addData['user_id'] 		= $user_id;
		$addData['client_id'] 	= $client_id;
		$addData['client_type'] = 'files';
		$addData['is_read'] 		= 'N';
		$addData['added_from'] 	= 'file_upload';
		$addData['notes'] 			= $doc_name;
		DataStore::insertGetId($addData);
	}
	
}else if($action == 'delete_doc'){
	$doc_name 		= $_REQUEST['doc_name'];
	$client_id 		= $_REQUEST['client_id'];
	$session      = Session::get('admin_details');
  $user_id    	= $session['id'];

    $details = FileSign::where('client_id', $client_id)->where('user_id', $user_id)->where('document', $doc_name)->select('file_id')->first();
    $file_id = '';
    if(isset($details['file_id']) && $details['file_id'] != ''){
    	$file_id = $details['file_id'];
    	FileSign::where('file_id', $file_id)->delete();

    	/* client edit form activity pop up display */
			$addData['user_id'] 		= $user_id;
			$addData['client_id'] 	= $client_id;
			$addData['client_type'] = 'files';
			$addData['is_read'] 		= 'N';
			$addData['added_from'] 	= 'file_delete';
			$addData['notes'] 			= $doc_name;
			DataStore::insertGetId($addData);
    }
    
	$data = $file_id;
}else{
	$file_id 	= $_REQUEST['file_id'];
	$data = FileAndSign::getDocumentsByFileId($file_id);
}


echo $data;
?>