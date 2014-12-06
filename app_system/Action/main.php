<?php
namespace App\Action;
use \Lavender\Filter;

class Main extends \Lavender\WebPage
{

	/**
	 * default action
	 *
	 * @return array
	 */
	public function index_action()
	{
		var_dump($this->session->offsetGet("info"));
		return array('code' => 0, 'msg' => 'welcome');
	}


}

