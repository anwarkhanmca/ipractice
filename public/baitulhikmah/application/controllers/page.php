<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public function contact()
	{
		$data['content']	= "pages/contact";
		$data['title']		= $this->lang->line('contact_menu');
		$this->load->view('layouts/default', $data);
	}

	public function about()
	{
		$data['content']	= "pages/about";
		$data['title']		= $this->lang->line('about_menu');
		$this->load->view('layouts/default', $data);
	}

	public function gallery()
	{
		$data['content']	= "pages/gallery";
		$data['title']		= $this->lang->line('gallery_menu');
		$this->load->view('layouts/default', $data);
	}

	public function video()
	{
		$data['content']	= "pages/video";
		$data['title']		= $this->lang->line('video');
		$this->load->view('layouts/default', $data);
	}

	public function audio()
	{
		$data['content']	= "pages/audio";
		$data['title']		= $this->lang->line('audio');
		$this->load->view('layouts/default', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */