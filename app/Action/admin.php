<?php
namespace App\Action;
use \Lavender\Filter;

class Admin extends \Lavender\WebPage
{
	protected $without_auth_actions = array(
		'*',
	);

	/**
	 * default action
	 *
	 * @return array
	 */
	public function index_action()
	{
		return array('code' => 0, 'msg' => 'welcome');
	}


	public function users_action()
	{
		$users = \App\Api\User::get_list(1, 10);
		return array('code' => 0, 'msg' => 'welcome', 'users' => $users);
	}

	public function items_action()
	{
		$items = \Base\Api\Item::get_list(1, 10);
		foreach ($items as $key => $item) {
			if(!empty($item['user_id'])) {
				$item['username'] = \Base\Api\User::get_base($item['user_id'])['username'];
				$items[$key] = $item;
			}
		}
		return array('code' => 0, 'msg' => 'welcome', 'items' => $items);
	}

	public function add_item_action()
	{
		$param = $this->parameters(array(
			'username'=>Filter::T_STRING,
			'expre_in'=>Filter::T_STRING,
			'trade_us_no'=>Filter::T_STRING,
			'desc'=>Filter::T_STRING,
			'weight'=>Filter::T_FLOAT,
		), self::M_POST, true);

		$item = array();
		$item['expre_in'] = $param['expre_in'];
		$item['trade_us_no'] = $param['trade_us_no'];
		$item['desc'] = $param['desc'];
		$item['weight'] = $param['weight'];
		$item['status'] = \Base\Api\Item::STATUS_IN_STORAGE;

		$users = \Base\Api\User::get_by_username($param['username']);
		if(!empty($users)) {
			$item['user_id'] = $users[0]['id'];
		}

		\Base\Api\Item::add($item);

		$this->redirect("/?action=admin.items");
		return array('code' => 0, 'view' => 'admin/items');
	}

	public function update_item_action()
	{
		$param = $this->parameters(array(
			'id'=>Filter::T_INT,
			'username'=>Filter::T_STRING,
			'product_name'=>Filter::T_STRING,
			'count'=>Filter::T_STRING,
			'weight'=>Filter::T_FLOAT,
			'amount'=>Filter::T_INT,
		), self::M_POST, true);

		$item = array();
		$item['id'] = $param['id'];
		$item['name'] = $param['product_name'];
		$item['count'] = $param['count'];
		$item['weight'] = $param['weight'];
		$item['amount'] = $param['amount'];
		
		$users = \Base\Api\User::get_by_username($param['username']);
		if(!empty($users)) {
			$item['user_id'] = $users[0]['id'];
		}

		\Base\Api\Item::update($item);

		$this->redirect("/?action=admin.items");
		return array('code' => 0, 'view' => 'admin/items');
	}

	public function update_item_clearance_action()
	{
		$param = $this->parameters(array(
			'id'=>Filter::T_INT
		), self::M_GET, true);

		$item = \Base\Api\Item::get($param['id']);
		$item['status'] = \Base\Api\Item::STATUS_CLEARANCE;
		\Base\Api\Item::update($item);

		$this->redirect("/?action=admin.items");
		return array('code' => 0, 'view' => 'admin/items');	
	}

	public function delete_user_action()
	{
		$param = $this->parameters(array(
			'id'=>Filter::T_INT,
		), self::M_GET, true);
		\App\Api\User::delete($param['id']);
		$users = \App\Api\User::get_list(1, 10);
		return array('code' => 0, 'msg' => 'welcome', 'view' => 'admin/users', 'users' => $users);
	}
}

