<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');


class MY_GameController extends CI_Controller
{
    function __construct()
    {
        parent:: __construct();

        if(!$this->session->userdata('GameUserId'))
        {
            redirect('/');
        }

        $GameUser = new User();
        $GameUser->get_by_id($this->session->userdata('GameUserId'));

        $this->data['GameUser'] = $GameUser->to_array(); 


        $this->twiggy->register_filter('explodeToUl');
        $this->twiggy->register_filter('arrayToUl');

    }
}