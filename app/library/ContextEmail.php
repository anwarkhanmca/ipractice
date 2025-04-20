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

class ContextEmail 
{
	public static function get_session() {
		$session = Session::get('admin_details');
		//print_r($session);die;
        return $session;
    }

    public static function saveDataTodoList($data)
    {
    	$session = Session::get('admin_details');
    	$user_id = $session['id'];
    	//print_r($session);die;

    	$d = array();
    	$i = 0;
    	if(isset($data) && count($data)>0 ){
	    	foreach ($data as $k => $v) {

	    		$details = User::where('todo_email', $v['to_email'])->select('user_id')->first();
	    		if(isset($details->user_id) && $details->user_id != ''){
	    			$times = Todolistnewtask::where('sent_time', $v['sent_time'])->select('sent_time')->first();
	    			if(empty($times) || count($times) <= 0){
	    				$d[$i]['user_id'] 		= $details->user_id;
	    				$d[$i]['group_id'] 		= Common::getGroupId($details->user_id);
	    				$d[$i]['staff_id'] 		= $details->user_id;
			    	  	$d[$i]['added_from'] 	= 'cron';
						$d[$i]['taskname'] 	 	= $v['subject'];
						$d[$i]['taskdate'] 	 	= $v['taskdate'];
						$d[$i]['task_time'] 	= $v['task_time'];
						$d[$i]['sent_time'] 	= $v['sent_time'];
						$d[$i]['status'] 	 	= 'not_started';
						$d[$i]['notes'] 	 	= $v['body'];
						$d[$i]['is_viewed'] 	= 'N';
						$d[$i]['created'] 	 	= date('Y-m-d H:i:s');

						$i++;
	    			}
	    		}
	    	  	
	    	}  
	    }

	    if(!empty($d)){
	    	Todolistnewtask::insert($d);
	    }


	    $count = Todolistnewtask::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->orWhere('staff_id', $user_id);
        })->where('is_viewed', 'N')->count();

        if($count >0 ){
            Todolistnewtask::where('user_id', $user_id)->update(array('is_viewed'=>'Y'));
        }
        return $count;
    }





}
