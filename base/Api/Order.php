<?php
namespace Base\Api;
use Lavender\Errno;
use Lavender\Exception;

class Order
{
	const STATUS_UNPAID=1;
	const STATUS_PAID=2;
	const STATUS_PAYING=3;

	public static function get($id)
	{	
		return \Base\Dao\OrderTable::instance()->get_single($id);
	}

	public static function add($order) {
		$order_id = \Lavender\IdMaker::make('order');
		$order['create_time'] = date('y-m-d H:i:s');
		$order['update_time'] = date('y-m-d H:i:s');
		\Base\Dao\OrderTable::instance()->set($order_id, $order);
	}

	public static function update($order) {
		$order['update_time'] = date('y-m-d H:i:s');
		\Base\Dao\OrderTable::instance()->set($order['id'], $order);
	}

	public static function get_list_by_user($user_id, $page, $size) {
		return \Base\Dao\OrderTable::instance()->get(null, null, array('user_id'=>$user_id) , 'id desc', ($page-1)*$size, $size);
	}

	public static function get_list($page, $size) {
		return \Base\Dao\OrderTable::instance()->get(null, null, null , 'id desc', ($page-1)*$size, $size);
	}

	public static function delete($id) {
		\Base\Dao\OrderTable::instance()->delete($id);
	}

}

