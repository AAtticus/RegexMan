<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	Game Class
*	
*	Transforms Games table into an Game object
*/

class Game extends DataMapper {

	var $has_many 	 = array("question");
	var $has_one	 = array("user");
	//----------------------------------------------------------------
	// VALIDATION
	//----------------------------------------------------------------

	public $validation = array(
		'date_created' => array(
			'label' => 'Date Created',
			'rules' => array('required')
		),
		'game_mode' => array(
			'label' => 'Game Mode',
			'rules' => array('required')
		),
		'points_collected' => array(
			'label' => 'Points Collected',
			'rules' => array('required')
		),
		'completed' => array(
			'label' => 'Completed Game',
			'rules' => array('trim')
		),
		'current_question_id' => array(
			'label' => 'Current Question ID',
			'rules' => array('required')
		),
		'completed_question_ids' => array(
			'label' => 'Completed Questions'
		),
		'user_id' => array(
			'label' => 'User Owner'
		)
	);

	public $default_order_by = array('id' => 'desc');

}
?>