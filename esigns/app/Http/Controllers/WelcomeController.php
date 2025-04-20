<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;
use Session;

class WelcomeController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (\Auth::check()) {
			return new RedirectResponse(url('/home'));
		}
		return view('login');
		
	}

	public function authuser(Request $request) {
		//dd($request->server('HTTP_REFERER'));

		$uemail = $request->email;
		//$token = $request->token;
		$name = explode('-', $request->name);
		Session::set('pname',  $request->pname);

		$user = User::where('email', $uemail)->get()->first();

		if (sizeof($user) > 0) {
			if (Auth::attempt(['email' => $request->email, 'password' => 123456])) {
			 	return redirect()->to('/home');
			} else {
				return view(404);
			}
		} else {
			$newuser = new User;
			$newuser->email = $uemail;
			$newuser->fname = $name[0];
			$newuser->lname = $name[1];
			$newuser->password = bcrypt(123456);
			$newuser->save();

			if (Auth::attempt(['email' => $newuser->email, 'password' => 123456])) {
			 	return redirect()->to('/home');
			} else {
				return view(404);
			}
		}
	}

}
