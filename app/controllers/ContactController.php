<?php
class ContactController extends BaseController {
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
    $data['page_title'] = "Contact";
    return View::make('contact.contact', $data);
     
  }
}
