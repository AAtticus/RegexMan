<?php


/* End of file twiggy_helper.php */


function explodeToUl($input)
{
	$lines = explode('|', $input);

	$output = '<ul class="unstyled">';

	foreach($lines as $line)
	{
		$output.= "<li>$line</li>";
	}

	$output .= '</ul>';

	return $output;

}

function arrayToUl($input)
{

	$output = '<ul class="unstyled">';

	foreach($input as $line)
	{
		$output.= "<li>$line</li>";
	}

	$output .= '</ul>';

	return $output;

}