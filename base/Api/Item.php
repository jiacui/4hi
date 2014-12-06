<?php
namespace Base\Api;
use Lavender\Errno;
use Lavender\Exception;

class Item
{
	const STATUS_IN_STORAGE=1;
	const STATUS_PAID=2;
	const STATUS_CLEARANCE=3;
	const STATUS_MAIL=4;

	public static function get($id)
	{	
		return \Base\Dao\ItemTable::instance()->get_single($id);
	}

	public static function add($item) {
		$item_id = \Lavender\IdMaker::make('item');
		$item['create_time'] = date('y-m-d H:i:s');
		$item['update_time'] = date('y-m-d H:i:s');
		\Base\Dao\ItemTable::instance()->set($item_id, $item);
	}

	public static function update($item) {
		$item['update_time'] = date('y-m-d H:i:s');
		\Base\Dao\ItemTable::instance()->set($item['id'], $item);
	}

	public static function get_list_by_user($user_id, $page, $size) {
		return \Base\Dao\ItemTable::instance()->get(null, null, array('user_id'=>$user_id) , 'id desc', ($page-1)*$size, $size);
	}

	public static function get_list($page, $size) {
		return \Base\Dao\ItemTable::instance()->get(null, null, null , 'id desc', ($page-1)*$size, $size);
	}

	public static function delete($id) {
		\Base\Dao\ItemTable::instance()->delete($id);
	}

}

