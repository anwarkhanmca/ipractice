<?php
//opcache_reset ();
//Cache::forget('user_list');

class TaxController extends BaseController {

	public function tax()
	{
		if (Request::isMethod('post')) {

			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'tax_name' => 'Tax Name',
			    'tax_rate' => 'Tax Rate',
			);

			$rules = array(
				        'tax_name' => 'required|max:100',
				        'tax_rate' => 'required|numeric',
				    );

		    $validator = Validator::make(Input::all(), $rules);
		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
				$taxData['tax_name'] = Input::get('tax_name');
				$taxData['tax_rate'] = Input::get('tax_rate');
				if(Input::has('tax_id')){
					Tax::where('id', Input::get('tax_id'))->update($taxData);
					Session::flash('info_msg', 'Tax has been updated Successfully.');
				} else{
					Tax::insert($taxData);
					Session::flash('info_msg', 'Tax has been added Successfully.');
				}
				return Redirect::to('/crm/tax');
			}	
		} 
		
		$data['taxes'] = Tax::all();
		$data['form_title'] = 'Add Tax';
		$data['content_header'] = 'Taxes';

		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'tax';
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

	public function edit_tax($taxId)
	{
		$data['editTax'] = Tax::find($taxId);
		$data['taxes'] = Tax::all();
		$data['form_title'] = 'Update Tax';
		$data['content_header'] = 'View Tax';
		
		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'tax';
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

	public function delete_tax($taxId)
	{
		Tax::where('id', $taxId)->delete();
		Session::flash('info_msg', 'Tax has been deleted Successfully.');
		return Redirect::to('/crm/tax');
	}

	public function check_tax($taxId)
	{
		$products = Product::where('tax_id', $taxId)->get(['id']);
		$data = '';
		foreach($products as $product){
			$data.=$product->id.", ";
		}

		if($data != ''){
			return "This tax is already in use. To delete this tax you have to delete ". substr($data, 0, -2) ." Product first";
		} else {
			return $data;
		}
	}		
}	