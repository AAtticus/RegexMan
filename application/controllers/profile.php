<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_GameController {

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

	public function index()
	{
		$this->twiggy->set('GameUser', $this->data['GameUser']);

		$User = new User();
		$User->get_by_id($this->data['GameUser']['id']);
		$MyGames = $User->game->get();

		$this->twiggy->set('MyGames', $MyGames->all_to_array());
		
		$this->twiggy->set('TotalPoints', $MyGames->select_sum('points_collected')->get()->to_array());
		
		$this->twiggy->display('dashboard');
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */