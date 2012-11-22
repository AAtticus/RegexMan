<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Play extends MY_GameController {

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

	public function start($game_mode)
	{
		$Game = new Game();
		$Game->date_created 	 = date("Y-m-d");
		$Game->game_mode		 = $game_mode;
		$Game->points_collected	 = 0;
		$Game->completed		 = 0;
		$Game->completed_question_ids = serialize(array('-1'));

		$Questions = new Question();
		
		if($Game->game_mode == 'story')
		{
			$Questions->where('difficulty >', 10)->order_by('difficulty', 'asc')->get();
		}

		if($Game->game_mode == 'tutorial')
		{
			$Questions->where('difficulty <=', 10)->order_by('difficulty', 'asc')->get();
		}

		if($Game->game_mode == 'survival')
		{
			$Questions->order_by('id', 'random')->limit(4)->get();
		}

		$Game->current_question_id = $Questions->id;

		try 
		{
			$GameUser = new User();
       		$GameUser->get_by_id($this->session->userdata('GameUserId'));
			
			$Game->save($GameUser);

			foreach($Questions as $q)
			{
				$Game->save($q);
			}

			redirect('play/game/'.$Game->id.'/'.$Game->current_question_id);
		}
		catch(Exception $e)
		{
			show_error('Couldnt start this game: ' .$e);
		}


	}

	public function game($id, $question_id)
	{

		$Game = new Game();
		$Game->get_by_id($id);

		if( is_numeric($Game->id) )
		{

			if( $Game->completed )
			{
				redirect('/pages/completed');
			}

			$Question = new Question();
			$Question->get_by_id($question_id);

			if(in_array($Question->id, unserialize($Game->completed_question_ids)))
			{
				redirect('/play/game/'.$Game->id.'/'.$Game->current_question_id);
			}

			if ( $this->input->post() )
			{

				$regex  = trim($this->input->post('regex'));

				$results =  array_values(preg_grep('#'.$regex.'#', explode('|' ,$Question->input)));
        		$correct_answer = array_values(preg_grep('#'.$Question->pattern.'#', explode('|' ,$Question->input)));

        		if( !array_diff($results, $correct_answer) && count($results) >= count($correct_answer))
        		{
        			$this->twiggy->set('continue', true);
        			
        			
        			if($Game->game_mode == 'story')
        			{
        				$this->addScore($Game->id, $Question->difficulty);
        			}
        			elseif($Game->game_mode == 'survival') 
        			{
        				$this->addScore($Game->id, 25 + $Question->difficulty);
        			}
        			else 
        			{

        			}

        			$this->addQuestionToCompleted($Game->id, $Question->id);

        			$NxtQuestion = $this->findNextQuestion($Game->id);

        			if(is_numeric($NxtQuestion->id))
        			{
        				$Game->current_question_id = $NxtQuestion->id;
        				$Game->save();
        				$this->twiggy->set('NxtQuestion', $NxtQuestion->to_array());
        			}
        			else {

        				$Game->completed = 1;
        				$Game->save();
        				redirect('/pages/completed');

        			}

        			$Game->get_by_id($id);
        		}
        		else 
        		{
        			$Game->points_collected -= 1;
        			$Game->save();
        		}

        		$UserLines = array();

        		foreach($results as $result)
        		{
        			if(in_array($result, $correct_answer))
        			{
        				array_push($UserLines, array('text' => $result, 'class' => 'text-success'));
        			}
        			else {
        				array_push($UserLines, array('text' => $result, 'class' => 'text-error'));
        			}

        		}

        		$this->twiggy->set('UserLines', $UserLines);
				$this->twiggy->set('Regex', trim($regex));

			}


			$this->twiggy->set('Game', $Game->to_array());

			$Question->answer = preg_grep('#'.$Question->pattern.'#', explode('|' ,$Question->input));

			$this->twiggy->set('Question', $Question->to_array());
			
			if($Game->game_mode == 'story' || $Game->game_mode == 'tutorial')
			{
				$this->twiggy->set('progress', $this->calculateProgressStoryMode($Game->id));
				$this->twiggy->display('story_mode_game');
			} else 
			{
				$this->twiggy->display('survival_mode_game');
			}

		}
		else 
		{
			redirect('/404');
		}

	}

	private function addScore($game_id, $points)
	{

		$Game = new Game();
		$Game->get_by_id($game_id);
		$Game->points_collected += $points;
		$Game->save();

	}

	private function findNextQuestion($game_id)
	{
		$Game = new Game();
		$Game->get_by_id($game_id);

		$NxtQuestion = $Game->question->where_not_in('id', unserialize($Game->completed_question_ids))->limit(1)->get();

		return $NxtQuestion;
	}

	private function addQuestionToCompleted($game_id, $question_id)
	{
		$Game = new Game();
		$Game->get_by_id($game_id);

		$completed_question_ids = unserialize($Game->completed_question_ids);
		array_push($completed_question_ids, $question_id);
		$Game->completed_question_ids = serialize($completed_question_ids);
		$Game->save();
	}

	public function cancel($game_id)
	{
		$Game = new Game();
		$Game->get_by_id($game_id);

		if($this->session->userdata('GameUserId') == $Game->user_id)
		{
			$Game->delete();
			redirect('/profile');
		}
	}

	private function calculateProgressStoryMode($game_id)
	{


		$Game = new Game();
		$Game->get_by_id($game_id);

		$Questions = new Question();

		$numberCompleted = count(unserialize($Game->completed_question_ids)) -1;
		$numberTotal	 = $Questions->count();

		return (($numberCompleted) / ($numberTotal)) * 100;
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */