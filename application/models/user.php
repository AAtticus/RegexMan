<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	User Class
*	
*	Transforms User table into an User object
*/

class User extends DataMapper {

	var $has_many 	 = array("game");
	//----------------------------------------------------------------
	// VALIDATION
	//----------------------------------------------------------------

	public $validation = array(
		'uid' => array(
			'label' => 'Oath UID',
			'rules' => array('required')
		),
		'first_name' => array(
			'label' => 'First Name',
			'rules' => array('required','trim')
		),
		'last_name' => array(
			'label' => 'Last Name',
			'rules' => array('required','trim')
		),
		'image' => array(
			'label' => 'Image',
			'rules' => array('trim')
		),
		'email' => array(
			'label' => 'Email',
			'rules' => array('required')
		)
	);

	public $default_order_by = array('id' => 'desc');

}
?>