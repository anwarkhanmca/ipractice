<?php

class AttachmentController extends BaseController {

	public function attachment()
	{
		if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'title' => 'Title',
			    'file' => 'PDF',
			);

			$rules = array(
				        'title' => 'required|max:100',
				        'file' => 'required|mimes:pdf',
				    );

		    $validator = Validator::make(Input::all(), $rules);

		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
				if(Input::hasFile('file')){
					$file = Input::file('file');
					if($file->getMimeType() == 'application/pdf'){
						$fileName = $file->getClientOriginalName();
						$upload_success = $file->move('../uploads/pdf forms/', $fileName);

						$attachData['title'] = Input::get('title');
						$attachData['file'] = $fileName;
						Attachment::insert($attachData);
						Session::flash('info_msg', 'Attachment has been added successfully.');
						return Redirect::to('/crm/attachment');	
					} else {
						Session::flash('info_msg', 'Please upload only pdf file.');
						return Redirect::to('/crm/attachment');	
					}
				} else {
					Session::flash('info_msg', 'Pdf File field should not be empty.');
					return Redirect::to('/crm/attachment');
				}
		    }	
		} 
		
		$data['attachments'] = Attachment::all();
		$data['form_title'] = 'Add Attachment';
		$data['content_header'] = 'Attachments';

		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'attachment';
		$data['goto_url'] = $page_open;
		$data['owner_id'] = $owner_id;

		$data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id; 
        $data['tab_no'] = 6;
        $data['all_count'] = 0;
        $data['heading']    = "CRM";
        $data['title']      = "Crm";

		return View::make('crm.index', $data);
	}

	public function preview_attachment($attachment_id)
	{
		$attachment = Attachment::find($attachment_id);
        $file= "../uploads/pdf forms/". $attachment->file;

        return Response::make(file_get_contents($file), 200, [
							    'Content-Type' => 'application/pdf',
							    'Content-Disposition' => 'inline; '.$attachment->file,
							]);

	}

	public function delete_attachment($attachment_id)
	{
		$attachment = Attachment::find($attachment_id);
		$file = '../uploads/pdf forms/'. $attachment->file;
		if(File::exists($file)) {
			File::delete($file);
			$attachment->delete();
			Session::flash('info_msg', 'File has been deleted successfully.');
			return Redirect::to('/crm/attachment');
		} else {
			Session::flash('info_msg', 'File is not exists.');
			return Redirect::to('/crm/attachment');
		}
	}	

	public function getDownload($attachment_id){
		$attachment = Attachment::find($attachment_id);
        $file= "../uploads/pdf forms/". $attachment->file;

        return Response::download($file);
	}

	public function check_attachment($attachmentId)
	{
		return '';
		// $products = Product::where('tax_id', $taxId)->get(['id']);
		// $data = '';
		// foreach($products as $product){
		// 	$data.=$product->id.", ";
		// }

		// if($data != ''){
		// 	return "This tax is already in use. To delete this tax you have to delete ". substr($data, 0, -2) ." Product first";
		// } else {
		// 	return $data;
		// }
	}	
}