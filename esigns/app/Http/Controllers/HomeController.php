<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use App\Doc;
use App\Recipient;
use App\Signrequest;
use Auth;
use DB;
use Carbon;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$docs = Doc::where('created_by', Auth::user()->id)->orderBy('created_on','DESC')->get()->all();
		foreach ($docs as &$doc) {
			$req  = Signrequest::where('id', $doc['request_id'])->get()->first();
			$doc['reqTitle'] = $req['title'];
			$doc['status'] = $req['status'];
			$declinedRecips = Recipient::where('doc_id', $doc->id)->where('status', 2)->get()->all();
			$doc['declined'] = $declinedRecips;
		}
		return view('home')->with(compact('docs'));
	}

	public function deleteDoc($id) {

		Doc::where('created_by', Auth::user()->id)
			->where('id', $id)
			->delete();

		return redirect()->to('/');
	}

}
