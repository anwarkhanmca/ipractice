<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Input;
use App\Doc;
use App\Recipient;
use App\Signrequest;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Contracts\Mail\Mailer;
use \Smalot\PdfParser\Parser;
use App\Libraries\Tcpdf\Tcpdf;
use App\Libraries\Tcpdf\Tcpdf_parser;
use App\Libraries\Setasign\Fpdf\Fpdf;
use App\Libraries\Setasign\Fpdi\Fpdi;
use App;
use PDF;

class CreateSignController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		
		return view('wizard');
	}

	public function upload(Request $request) {

		if (Input::hasFile('file'))
	    {  
	        $file = Input::file('file');
	        $temp = explode(".", $file->getClientOriginalName());
			$newfilename = $temp[0] . '-' . round(microtime(true)) . '.' . end($temp);
	        $path = 'public/media';

	        $success = $file->move($path, $newfilename);
	        $savedfile = explode('/', str_replace('\\', '/', $success));

	        if ($success) {
	        	echo json_encode(array("filename" => $newfilename,
	        							"title" => $temp[0]));
	        }
	    } else {
	        echo 'fail';
	    }
	}

	public function createSign(Request $request) {
		
		$signReq = new Signrequest;
		$signReq->title = $request->docTitle;
		$signReq->created_by = Auth::user()->id;
		$signReq->created_on = Carbon::now();
		$signReq->recep_count = count($request->recipEmail);
		$signReq->docs_count = count($request->docName);
		$signReq->description_msg = $request->docDesc;
		$signReq->save();

		$mail['mail_title'] = $signReq->title;

		$c = 0;
		foreach ($request->docName as $reqDoc) {
			$doc = new Doc;
			$doc->file_name = $request->docName[$c];
			$doc->request_id = $signReq->id;
			$doc->created_by = Auth::user()->id;
			$doc->created_on = Carbon::now();
			$doc->save();
			$c++;

			unset($doc);
		}

		$i = 0;
		$order = 0;
		foreach($request->recipName as $recipName) {

			$reqdocs = Doc::where('request_id', $signReq->id)->get();
			$pcode = substr(str_shuffle('0123456789') , 0 , 4);
			$p = 9; // for changing the url key for each doc
			if ($request->reqMethod > 0) {
				$order++;
			}
			foreach ($reqdocs as $rdoc) {
				$recip = new Recipient;
				$recip->doc_id = $rdoc->id;
				$recip->request_id = $signReq->id; 
				$recip->name = $request->recipName[$i];
				$recip->email = $request->recipEmail[$i];
				$recip->passcode = $pcode;
				$recip->url_key = md5($recip->passcode.$p);
				$recip->sent_on = Carbon::now();
				$recip->order_queue = $order;
				$recip->save();
				$p++;
				$mail['recep_link'][] = url()."/passcode/".$recip->url_key;
			}

			if ($request->reqMethod == 0) {
				$mail['recep_name'] = $recip->name;
				$mail['recep_passcode'] = $recip->passcode;
				$mail['title'] = $signReq->title;
				$mail['desc'] = $signReq->description_msg;
				//dd($mail);
				// send the mail here
				Mail::send('emails.docsignrequest', ['mail' => $mail], function ($message) use($recip)
		        {
		            $message->from('info@i-practice.com', 'I-Practice' );
		            $message->to($recip->email)
		            	->subject('Document sign request');
		        });
				unset($mail);
			} else {
				if ($order == 1) {
					$mail['recep_name'] = $recip->name;
					$mail['recep_passcode'] = $recip->passcode;
					$mail['title'] = $signReq->title;
					$mail['desc'] = $signReq->description_msg;
					//dd($mail);
					// send the mail here
					Mail::send('emails.docsignrequest', ['mail' => $mail], function ($message) use($recip)
			        {
			            $message->from('info@i-practice.com', 'I-Practice' );
			            $message->to($recip->email)
			            	->subject('Document sign request');
			        });
					unset($mail);
				}
				
			}
			//	dd($recip);
			unset($recip);
			$i++;
		}
		

		return redirect()->to('/');
	}
}
