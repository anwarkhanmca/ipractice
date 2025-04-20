<?php
/*
	use "add_new_template_type" where you want to implement feature of adding new template types
	ex: <a href="javascript:void(0);" data-baseurl="{{url()}}" id="add_new_template_type" >Add New</a>
	
	also include this js file "template_type.js" to your blade file
	ex: <script src="{{ URL :: asset('js/template_type.js') }}" type="text/javascript"></script>
*/

class TemplateTypeController extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)){
            Redirect::to('/login')->send();
        }
    }
    
    public function index()
    {
		
    }
	public function newType(){
		return Response::view('template_type.newType');
	}
	
	public function add(){
		$insertData['template_type_name']=Input::get('type_name');
		$id = TemplateType::insertGetId($insertData);
		if($id>='0')
			return 'true';
		else
			return 'false';
	}
}
