<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('sample/welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/sample/welcome.php */
