<?php

class ProductController extends BaseController {

	public function product()
	{
		if (Request::isMethod('post')) {
			Input::merge(array_map('trim', Input::all()));

			$changeAttributes = array(
			    'product_name' => 'Product Name',
			    'price' => 'Price',
			    'tax_id' => 'Tax Rate',
			);

			$rules = array(
				        'product_name' => 'required|max:100',
				        'price' => 'required|numeric',
				        'tax_id' => 'required|numeric',
				    );

		    $validator = Validator::make(Input::all(), $rules);

		    $validator->setAttributeNames($changeAttributes); 

		    if ($validator->fails())
		    {
		    	return Redirect::back()->withErrors($validator)->withInput();
		    } else {
				$productData['product_name'] = Input::get('product_name');
				$productData['price'] = Input::get('price');
				$productData['tax_id'] = Input::get('tax_id');
				if(Input::has('product_id')){
					Product::where('id', Input::get('product_id'))->update($productData);
					Session::flash('info_msg', 'Information has been updated succesfully.');
				} else{
					Product::insert($productData);
					Session::flash('info_msg', 'Information has been added succesfully.');
				}
				return Redirect::to('/crm/product');
			}
		} 
		
		$data['products'] = Product::all();
		$data['taxes'] = Tax::all();
		$data['form_title'] = 'Add Product';
		$data['content_header'] = 'Products';

		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'product';
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

	public function edit_product($product_id)
	{
		$data['editProduct'] = Product::find($product_id);

		$data['products'] = Product::all();
		$data['taxes'] = Tax::all();
		$data['form_title'] = 'Update Product';
		$data['content_header'] = 'View Products';
		
		// information for crm index
		$owner_id = 'all';
		$page_open = "/crm";


		$data['page_open'] = 'product';
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

	public function delete_product($product_id)
	{
		Product::where('id', $product_id)->delete();
		Session::flash('info_msg', 'Information has been deleted succesfully.');
		return Redirect::to('/crm/product');
	}	

	public function check_product($productId)
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