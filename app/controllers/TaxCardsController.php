<?php
class TaxCardsController extends BaseController
{
    public function __construct()
    {
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

    public function dashboard()
    {

        $data['heading'] = "TAX CARDS";
        $data['title'] = "Tax Cards";
        $data['heading'] = "TAX CARDS DASHBOARD";
        $session_data = Session::get('admin_details');
        $data['user_type'] = $session_data['user_type'];
        $groupUserId = $session_data['group_users'];

        return View::make('tax_cards.dashboard',$data);
    }
    

}
