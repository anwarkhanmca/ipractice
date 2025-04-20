<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		$data['content']	= "home/index";
		$data['title']		= "Home";

		$this->load->view('layouts/default', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */