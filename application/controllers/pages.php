<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_GameController {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent:: __construct();
	}

	public function completed()
	{
		$this->twiggy->set('GameUser', $this->data['GameUser']);
		$this->twiggy->display('completed');
	}

	public function you_lost()
	{
		$this->twiggy->set('GameUser', $this->data['GameUser']);
		$this->twiggy->display('lost');
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */