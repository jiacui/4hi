<?php
namespace App\Action;
use \Lavender\Filter;

class Admin_Service extends \Lavender\WebService
{
	protected $without_auth_actions = array(
		'*',
	);

	public function get_item_action()
	{
		$param = $this->parameters(array('id'=>Filter::T_INT), self::M_GET, true);

		$item = \Base\Api\Item::get($param['id']);
		if(!empty($item['user_id'])) {
			$item['username'] = \Base\Api\User::get_base($item['user_id'])['username'];
		}
		return array('code' => 0, 'msg' => 'welcome', 'item' => $item);
	}

	public function check_username_action()
	{
		$param = $this->parameters(array(
			'username'=>Filter::T_STRING
		), self::M_GET, true);

		$result = \Base\Api\User::get_by_username($param['username']);
		if(!empty($result)) {
			return array('code' => 0, 'user' => $result[0]);
		}else {
			return array('code' => 0);
		}
	}
}

