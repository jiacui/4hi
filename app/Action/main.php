<?php
namespace App\Action;
use \Lavender\Filter;

class Main extends \Base\WebPage
{

	/**
	 * default action
	 *
	 * @return array
	 */
	public function index_action()
	{
		// var_dump($this->session->offsetGet("info"));
		$session = $this->session->offsetGet("info");
		$items = \Base\Api\Item::get_list_by_user($session['user_id'], 1, 10);
		return array('code' => 0, 'items' => $items, 'session'=>$session);
	}	

	public function pay_action()
	{	
		$param = $this->parameters(array(
			'ids'=>Filter::T_STRING
		), self::M_GET, true);

		$ids = split(',', $param['ids']);
		foreach ($ids as $id) {
			$item = \Base\Api\Item::get($id);
			if(!empty($item)) {
				$item['status'] = \Base\Api\Item::STATUS_PAID;
				\Base\Api\Item::update($item);
			}
		}
		
		$this->redirect("/?action=main.index");
		return array('code' => 0, 'msg' => 'welcome');		
	}

}

