<?php
namespace App\Action;
use \Lavender\Filter;

class Order extends \Base\WebPage
{

	/**
	 * default action
	 *
	 * @return array
	 */
	public function index_action()
	{
		$session = $this->session->offsetGet("info");
		$orders = \Base\Api\Order::get_list_by_user($session['user_id'], 1, 10);
		foreach ($orders as $key => $order) {
			if(!empty($order['item_ids'])){
				$ids = split(',', $order['item_ids']);
				$items = array();
				foreach ($ids as $id) {
					$items[] = \Base\Api\Item::get($id);				
				}
				$order['items'] = $items;
			}
			$orders[$key] = $order;
		}
		return array('code' => 0, 'data' => array('orders' => $orders, 'session'=>$session));
	}

	public function prepare_action()
	{	
		$param = $this->parameters(array(
			'ids'=>Filter::T_STRING
		), self::M_GET, true);

		$session = $this->session->offsetGet("info");
		$addrs = \Base\Api\Address::get_by_user($session['user_id']);

		$ids = split(',', $param['ids']);

		$items = array();
		$amount = 0;
		$weight = 0;
		foreach ($ids as $id) {
			$item = \Base\Api\Item::get($id);
			$items[] = $item;
			$amount += $item['amount'];
			$weight += $item['weight'];
			// if(!empty($item)) {
			// 	$item['status'] = \Base\Api\Item::STATUS_PAID;
			// 	\Base\Api\Item::update($item);
			// }
		}

		return array(
			'code' => 0, 
			'data'=>array(
				'items' => $items, 
				'amount'=>$amount,
				'weight'=>$weight, 
				'addrs'=>$addrs,
				'address_id'=>$session['address_id']));
	}

	public function create_action()
	{
		$param = $this->parameters(array(
				'item_ids' => Filter::T_STRING,
				'address_id' => Filter::T_STRING
			), self::M_POST, true);

		$session = $this->session->offsetGet("info");
		// $addr = \Base\Api\Address::get($session['user_id']);

		$ids = split(',', $param['item_ids']);

		$items = array();
		$amount = 0;
		$weight = 0;
		foreach ($ids as $id) {
			$item = \Base\Api\Item::get($id);
			$items[] = $item;
			$amount += $item['amount'];
			$weight += $item['weight'];
		}

		$order = array('user_id' => $session['user_id']);
		$order['item_ids'] = $param['item_ids'];
		$order['address_id'] = $param['address_id'];
		$order['amount'] = $amount;
		$order['weight'] = $weight;
		$order['status'] = \Base\Api\Order::STATUS_UNPAID;

		\Base\Api\Order::add($order);
		return array('code' => 0, 'msg' => 'success');
	}

}

