<?php
class ESignController extends BaseController {
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
        $data = array();
        $data['heading']    = "E - SIGN";
        $data['title']      = "E - Sign";
        $admin_s = Session::get('admin_details');
        $user_id = $admin_s['id'];

        return View::make('e_sign.e_sign', $data);
    }

    public function deleteDoc($id) {

        Doc::where('created_by', Auth::user()->id)
            ->where('id', $id)
            ->delete();

        return redirect()->to('/');
    }


    
}
