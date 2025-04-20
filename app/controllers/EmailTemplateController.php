<?php
// By PK

class EmailTemplateController extends BaseController {
	public function __construct() {
		parent::__construct();
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login')->send();
		}
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}
	}
	
	// List all Available Template files
	public function index() {
		$session = Session::get('admin_details');
		
		$data['title'] = 'Templates';
		//$data['previous_page'] = '<a href="/send-letters-emails">Send Letters Emails</a>';
		$data['previous_page'] = '<a href="/letters">Letters</a>';
		$data['heading'] = "TEMPLATES";
		
		$data['templates']=ContactEmailTemplate::select('*')->where('uid', '=', $session['id'])->get();
		$data['placeholders']=Placeholder::get();
		$data['template_types'] = TemplateType::get();
		
		//print_r($data['placeholders']);die;
		return View::make('email_template.index', $data);
	}

	// Create Template files
	public function edit($id=null) {
		$data['title'] 			= 'Edit Template';
		$data['previous_page'] 	= '<a href="/letters/templates">Templates</a>';
		$data['heading'] 		= "Edit Template";
		
		if(Request::isMethod('get') && $id!=null){
			$data['placeholders']=Placeholder::select('module')->distinct()->get();
			$data['template_types'] = TemplateType::get();
			
			$data['templateData'] = $this->getTemplate($id);
			
			$filepath='email_templates/'.$id.'.txt';
			
			$data['templateBody'] = File::get($filepath);
			
			//print_r($data['templateData']);die;
			return View::make('email_template.edit',$data);
		}
		
		$tmpl_data = array();
		$postData = Input::all();
		$session = Session::get('admin_details');
		
		$template_id=$postData['template_id'];
		
		$tmpl_data['uid'] 		=	$session['id'];
		//$tmpl_data['name'] 		=	$postData['template_name'];
		//$tmpl_data['type'] 		=	$postData['template_type'];
		$tmpl_data['subject'] 	=	$postData['template_subject'];
		
		if(!empty($template_id) && $template_id>=0 ){
			$tmpl_data['modified']	= date('Y-m-d H:i:s');
			
			try{
				ContactEmailTemplate::where('id','=',$template_id)->update($tmpl_data);
				
				$filepath='email_templates/'.$template_id.'.txt';
				File::put($filepath,$postData['template_message']);
				
			}catch(Exception $ex){
				$errorCode = $ex->errorInfo[1];
				Session::flash('error', 'Problem in editing file');
			}
			
			Session::flash('success', 'Your template has been edited');
		}
		
		return Redirect::to('/letters/templates');
	}
	
	// Create Template files
	public function add($copyId = 0) {
		
		$data['title'] 			= 'Add Templates';
		$data['previous_page'] 	= '<a href="/letters/templates">Templates</a>';
		$data['heading'] 		= "Add Template";
		
		if(Request::isMethod('get')){
			$data['placeholders']	= Placeholder::select('module')->distinct()->get();
			$data['template_types'] = TemplateType::get();
			
			if($copyId != 0){
				$data['templateData'] 	= $this->getTemplate($copyId);
				$filepath='email_templates/'.$copyId.'.txt';
				$data['templateBody'] = File::get($filepath);
			}
			
			return View::make('email_template.add',$data);
		}
		
		$tmpl_data 		= array();
		$postData 		= Input::all();
		$session 		= Session::get('admin_details');
		
		$template_id	= $postData['template_id'];
		
		$tmpl_data['uid'] 		=	$session['id'];
		//$tmpl_data['name'] 		=	$postData['template_name'];
		//$tmpl_data['type'] 		=	$postData['template_type'];
		$tmpl_data['subject'] 	=	$postData['template_subject'];
		
		if(empty($template_id)){
			$tmpl_data['created'] = date('Y-m-d H:i:s');
			
			try{
				$insert_id=ContactEmailTemplate::insertGetId($tmpl_data);
			}catch(Exception $ex){
				$errorCode = $ex->errorInfo[1];
				if($errorCode == 1062){
					Session::flash('error', 'You Can\'t create a Duplicate template, Please edit the existing one');
				}
			}
			if(isset($insert_id) && $insert_id >= 0 ){
				$filepath='email_templates/'.$insert_id.'.txt';
				File::put($filepath,$postData['template_message']);
			}
			Session::flash('success', 'Your template has been created');
		}
		
		return Redirect::to('/letters/templates');
	}
	
	// Get and return template data in json form
	public function getTemplate($id){
		$data = ContactEmailTemplate::where('id','=',$id)->first()->toArray();
		if(Request::ajax()){
			echo json_encode($data);
		}else{
			return $data;
		}
	}

	// Get and return all session data
	public function ses(){
		$data = Session::all();
		echo "<pre>";print_r($data);
	}
	
	// set all placeholders and values
	public function placeholdersKV(){
		$ps=Placeholder::get();
		$placeholders=array();
		foreach($ps as $p){
			$k = "[" . $p->table . "." . $p->field . "]";
			$placeholders[$k]=$this->getTFValue($p->table, $p->field);
		}
		
		//echo "<pre>"; print_r($placeholders);
		return $placeholders;
	}
	
	// get placeholder value
	private function getTFValue($table, $field){
		return $r = DB::table($table)->select($field)->take(1)->pluck($field);
	}
	
	// get Templates by TypeId
	public function getTemplatesByID($typeID, $format='object'){
		$session = Session::get('admin_details');
		
		$templates = ContactEmailTemplate::where('type','=',$typeID)->where('uid', '=', $session['id'])->get();
		if($format=='json'){
			$options='<option>Select Template</option>';
			foreach($templates as $k=>$template){
				$options.="<option value='".$template->id."' >". $template->name ."</option>";
			}
			echo $options;
		}
		else
			return $templates;
	}
	
	// Delete the Templates
	public function delete($id){
		//$r=0;
		$templete = ContactEmailTemplate::select('name')->where('id','=',$id)->get();
		$r = ContactEmailTemplate::where('id','=',$id)->delete();
		if($r){
			File::delete(public_path('email_templates/'.$templete[0]->name.'.txt'));
			echo "Deleted";
		}
		else
			echo "Error, In deleting";
	}

	public function email_templates_action() {
		$session        = Session::get('admin_details');
        $user_id 		= $session['id'];
        $groupUserId    = $session['group_users'];

		$postData = Input::all();
		$data = array();
		switch ($postData['action']) {
			case 'deleteContactTemplate':
				$data = $this->deleteTemplates($postData);
				echo json_encode($data);
				break;
			case 'nameByplaceHolder':
				$postData 			= Input::all();
				$data['details'] 	= ClientAddress::addressByplaceHolder($postData);
				echo json_encode($data);
				break;

			default:
				# code...
				break;
		}
	}



	public function deleteTemplates($postData)
	{
		ContactEmailTemplate::whereIn('id', $postData['delete_ids'])->delete();
		$data['action'] = 'delete';
		return $data;
	}
}
