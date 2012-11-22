<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	Question Class
*	
*	Transforms Question table into an Question object
*/

class Question extends DataMapper {

	var $has_many 	 = array("game");
	//----------------------------------------------------------------
	// VALIDATION
	//----------------------------------------------------------------

	public $validation = array(
		'difficulty' => array(
			'label' => 'Difficulty Level',
			'rules' => array('required')
		),
		'pattern' => array(
			'label' => 'Correct suggested pattern',
			'rules' => array('required')
		),
		'input' => array(
			'label' => 'Question Input Text',
			'rules' => array('required')
		),
		'answer' => array(
			'label' => 'Correct Answer',
			'rules' => array('trim')
		),
		'description' => array(
			'label' => 'Description',
			'rules' => array('required')
		)
	);


}
?>