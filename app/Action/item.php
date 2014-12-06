<?php
namespace App\Action;
use \Lavender\Filter;

class Item extends \Lavender\WebPage
{

	/**
	 * default action
	 *
	 * @return array
	 */
	public function index_action()
	{
		return array('code' => 0, 'msg' => 'welcome');
	}

}

