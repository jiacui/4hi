<?php
namespace Base\Api;
use Lavender\Errno;
use Lavender\Exception;
use Base\Dao\UserTable;

class Passport
{
	public static function register_user($user) 
	{
		$user_id = \Lavender\IdMaker::make('user');
		UserTable::instance()->add($user_id, $user);
	}

	public static function is_username_exit($username) 
	{
		return !empty(UserTable::instance()->get(null, array('id'), array('username' => $username)));
	}

	public static function is_nickname_exit($nickname) 
	{
		return !empty(UserTable::instance()->get(null, array('id'), array('nickname' => $nickname)));
	}

	public static function is_mobile_exit($mobile) 
	{
		return !empty(UserTable::instance()->get(null, array('id'), array('mobile' => $mobile)));
	}

	public static function login($username, $password)
	{
		return UserTable::instance()->get_single(null, array('username' => $username, 'password' => $password));
	}
}

