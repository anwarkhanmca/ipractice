<?php
require '../../bootstrap/autoload.php';
$app = require_once '../../bootstrap/start.php';
$request = $app['request'];
$client = (new \Stack\Builder)
->push('Illuminate\Cookie\Guard', $app['encrypter'])
->push('Illuminate\Cookie\Queue', $app['cookie'])
->push('Illuminate\Session\Middleware', $app['session'], null);
$stack = $client->resolve($app);
$stack->handle($request);
$isAuthorized = Auth::check();

class FileAndSign {

	public static function get_session() {
		/*require '../../bootstrap/autoload.php';
		$app = require_once '../../bootstrap/start.php';
		$request = $app['request'];
		$client = (new \Stack\Builder)
		->push('Illuminate\Cookie\Guard', $app['encrypter'])
		->push('Illuminate\Cookie\Queue', $app['cookie'])
		->push('Illuminate\Session\Middleware', $app['session'], null);
		$stack = $client->resolve($app);
		$stack->handle($request);
		$isAuthorized = Auth::check();*/

		$session = Session::get('admin_details');
		//print_r($session);die;
        return $session;
    }

    public static function getAllClients()
    {
    	$data = Client::getClientNameAndId();
    	//$data = App::make('HomeController')->search_all_client();
    	//echo "<pre>";print_r($data);die;
    	return $data;
    }

    public static function getDocumentsByClientId($client_id)
    {
    	$details 		= array();
    	$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$details = FileSign::getDocumentsByClientId($client_id);
		
		//echo "<pre>";print_r($details);die;
    	return $details;
    }

    public static function getDocumentsByFileId($file_id)
    {
    	$data 		= '';
    	$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId    = $session['group_users'];

		$details = FileSign::getDocumentsByFileId($file_id);
		if(isset($details['document']) && $details['document'] != ""){
			$data = $details['document'];
		}
		
    	return $data;
    }

    public static function getUnreadCount()
    {
    	$unread_count = DataStore::getUnreadCount();
    	return $unread_count;
    }
    
}
