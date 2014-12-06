<?php
namespace Base\Api;
use Lavender\Errno;
use Lavender\Exception;

class User
{
	/**
	 * single or multipie get base info
	 *
	 * @param mixed 	$id int or int array
	 *
	 * @return array
	 */
	public static function get_base($id)
	{
		if (is_array($id)) {
			$records = \Base\Dao\UserTable::instance()->get($id, ['id', 'username', 'name']);

			$items = array();
			foreach ($records as $item) {
				$item['id'] = intval($item['id']);
				$item['username'] = $item['username'];
				$item['name'] = $item['name'];
				$items[$item['id']] = $item;
			}

			return $items;
		}

		$result = \Base\Dao\UserTable::instance()->get_single($id);

		$result['id'] = intval($result['id']);
		$result['username'] = $result['username'];
		$result['name'] = $result['name'];

		return $result;
	}

	public static function get($user_id) {
		return \Base\Dao\UserTable::instance()->get_single($user_id);
	}

	public static function addUser($user) {
		\Base\Dao\UserTable::instance()->add(null, $user);
	}

	public static function get_list($page, $size) {
		return \Base\Dao\UserTable::instance()->get(null, null, null , 'id desc', ($page-1)*$size, $size);
	}

	public static function get_by_username($username) 
	{
		return \Base\Dao\UserTable::instance()->get(null, array('id'), array('username' => $username));
	}

	public static function update($id, $user) {
		\Base\Dao\UserTable::instance()->update($id, $user);
	}

	public static function delete($id) {
		\Base\Dao\UserTable::instance()->delete($id);
	}

}

