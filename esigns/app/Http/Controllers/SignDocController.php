<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Recipient;
use App\Doc;
use App\Signrequest;
use App\User;
use App\Signplace;
use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \Smalot\PdfParser\Parser;
use App\Libraries\Tcpdf\Tcpdf_parser;
use App\Libraries\Setasign\Fpdf\Fpdf;
use App\Libraries\Setasign\Fpdi\Fpdi;
use App;
use PDF;
use Redirect;
use Mail;

class SignDocController extends Controller {

	public function __construct()
	{
		// $this->middleware('guest');
	}

	public function index($key)
	{	
		$user = Recipient::where('url_key', $key)
				->where('status', 0)
				->get();
		if (sizeof($user) > 0) {
			return view('passcode')->with('key', $key);	
		} else {
			abort(404);
		}
		
	}

	public function verifyPasscode(Request $request, $key) {
	 	
	 	$recip = Recipient::where('url_key', $key)
				->where('status', 0)
				->where('passcode', $request->passcode)
				->get()
				->first();
		
		$docinfo = Doc::where('id', $recip->doc_id)->get()->first(); 
		$reqinfo = Signrequest::where('id', $docinfo->request_id)->get()->first(); 
		$sentby = User::where('id', $docinfo->created_by)->get()->first();
		$sendername = $sentby->fname.' '.$sentby->lname;
		if (sizeof($recip) > 0) {
			Session::set('filename', $docinfo->file_name);
			Session::set('doctitle', $reqinfo->title);
			Session::set('sentby', $sendername);
			Session::set('recipname', $recip->name);
			Session::set('url_key', $recip->url_key);
			Session::set('recep_type', $docinfo->recep_type);

			return redirect()->to('signit');
		}
		
	}
//loads sign doc view
	public function signDocument() {
		//dd(Session::get('filename'));
		if(!Session::get('filename')) {
			abort(404);
		}

		$recip = Recipient::where('url_key', Session::get('url_key'))
				//->where('status', 0)
				->get()
				->first();
		
		Session::set('status', $recip->status);
		
		return view('signDoc')->with([
			'filename' => Session::get('filename'),
			'doctitle' => Session::get('doctitle'), 
			'sentby' => Session::get('sentby'),
			'recipname' => Session::get('recipname')
		]);
	}

//write the signs on the document
	public function makeSign(Request $request) {
		if(!Session::get('filename')) {
			abort(404);
		}

		if ($request->coords) {

			$recip = Recipient::where('url_key', Session::get('url_key'))
				//->where('status', 0)
				->get()
				->first();

			if (sizeof($recip) > 0) {
				
				$count = 0;
				foreach ($request->coords as $coords) {
					
					$temp = explode(',', $request->coords[$count]);
					$top = $temp[0];
					$left = $temp[1];
					$page = $temp[2];
					$rX = $left * 0.264583333;
					$rY = $top * 0.264583333;

					$image_path = "./public/media/".md5(time().uniqid()).".png"; 
					$decoded = base64_decode(str_replace('data:image/png;base64,', '',$request->image[$count]));
					file_put_contents($image_path, $decoded);
					$image_format = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

					$pdf = new \FPDI();
					$pdffile = './public/media/'.Session::get('filename');
					$pagecount = $pdf->setSourceFile('./public/media/'.Session::get('filename'));
					
					for ($i = 1; $i <= $pagecount; $i++) {
						$tplIdx = $pdf->importPage($i);
						$pdf->AddPage();
						$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
						if ($i == $page) {
							$pdf->Image($image_path, $rX , $rY , 31, 13, $image_format);	
						}	
					}
					$pdf->output("./public/media/".Session::get('filename'),'F');
					
					$count++;
				}
				$recip->status = 1;
			    $recip->signed_on = Carbon::now();
			    $recip->sign_image = $request->image[0];
				$recip->recip_ip = $request->ip();
				$recip->user_agent = $request->header('User-Agent');
			    $recip->save();
			    //dd($recip);
			    $requpdate = Signrequest::where('id', $recip->request_id)->get()->first();
			    $requpdate->signed_count = intval($requpdate->signed_count) + 1;

			    if ($requpdate->signed_count === (intval($requpdate->recep_count) * intval($requpdate->docs_count)) ) {
			    	// send downloadable copy to all
			    	$recips = Recipient::where('request_id', $requpdate->id)->groupBy('email')->get();
			    	foreach ($recips as $recip) {
			    		$mail['name'] = $recip->name;
				    	$mail['email'] = $recip->email;
				    	$mail['title'] = $requpdate->title;
				    	$mail['desc'] = $requpdate->description_msg;
				    	$ddocs = Doc::where('request_id', $requpdate->id)->get();
				    	foreach ($ddocs as $ddoc) {
				    		$mail['link'][] = url().'/public/media/'.rawurlencode($ddoc->file_name);
				    	}
			    		Mail::send('emails.doccopydownload', ['mail' => $mail], function ($message) use($recip)
				       {
				            $message->from('info@i-practice.com', 'I-Practice' );
				            $message->to($recip->email)
				            	->subject('Your downloadable copy');
				       });
			    		unset($mail);
			    	}
			    	$requpdate->status = 1;
			    }
			    $requpdate->save();
			    //check if current recip have signed all docs
			    $recipreqs = Recipient::where('request_id', $recip->request_id)->where('email', $recip->email)->get()->all();
			    $flag = 0;
			    $cnt = 0;
			    foreach ($recipreqs as $ck) {
			    	if ($ck->status == 1) {
			    		++$flag;
			    	}
			    	++$cnt;
			    }

			    // check if queued request then send next mail
			    if ($recip->order_queue > 0 && $cnt == $flag) {
			    	$nextrecip = Recipient::where('order_queue', intval($recip->order_queue) + 1)->where('request_id', $requpdate->id)->get()->all();
			    	if (sizeof($nextrecip) > 0) { // then send next email
			    		foreach ($nextrecip as $next) {
			    			$mail['recep_link'][] = url()."/passcode/".$next->url_key;
			    		}
			    		$mail['recep_name'] = $nextrecip[0]->name;
						$mail['recep_passcode'] = $nextrecip[0]->passcode;
						$mail['title'] = $requpdate->title;
				    	$mail['desc'] = $requpdate->description_msg;
						Mail::send('emails.docsignrequest', ['mail' => $mail], function ($message) use($nextrecip)
				        {
				            $message->from('info@i-practice.com', 'I-Practice' );
				            $message->to($nextrecip[0]->email)
				            	->subject('Document sign request');
				        });
			    	}
			    }

			    return redirect()->to('signit');
			} else {
				abort(404);
			}
		}

	}

	public function declineSign(Request $request) {
		$recip = Recipient::where('url_key', Session::get('url_key'))
				->get()
				->first();
		$recip->status = 2;
		$recip->save();

		$signDoc = Doc::where('id', $recip->doc_id)->get()->first();
		$req = Signrequest::where('id', $signDoc->request_id)->get()->first();
		Mail::send('emails.declinetosign', ['name' => $recip->name, 'title' => $req->title, 'email' => $recip->email], function ($message) use($recip)
		       {
		            $message->from('info@i-practice.com', 'I-Practice' );
		            $message->to('desizalim@hotmail.com')
		            	->subject('Declined to sign');
		       });

		return redirect()->to('/');
	}

	public function personalSign(Request $request) {
		$temp = explode(',', $request->coords);
		$top = $temp[0];
		$left = $temp[1];
		$page = $temp[2];
		$rX = $left * 0.264583333;
		$rY = $top * 0.264583333;

		$image_path = "./public/media/".md5(time().uniqid()).".png"; 
		$decoded = base64_decode(str_replace('data:image/png;base64,', '',$request->image));
		file_put_contents($image_path, $decoded);
		$image_format = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

		$pdf = new \FPDI();
		$pdffile = './public/media/'.$request->filename;
		$pagecount = $pdf->setSourceFile('./public/media/'.$request->filename);
		
		for ($i = 1; $i <= $pagecount; $i++) {
			$tplIdx = $pdf->importPage($i);
			$pdf->AddPage();
			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
			if ($i == $page) {
				$pdf->Image($image_path, $rX , $rY , 31, 13, $image_format);	
			}	
		}
		$pdf->output("./public/media/".$request->filename,'F');
		return 'success';
	}

}
