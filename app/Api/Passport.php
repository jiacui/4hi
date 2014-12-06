<?php
namespace App\Api;
use Lavender\Errno;
use Lavender\Exception;

class Passport
{
	public static function register_user($user) 
	{
		return Dao\UserTable::instance()->add(null, $user);
	}

	public static function is_username_exit($username) 
	{
		return !empty(Dao\UserTable::instance()->get(null, array('id'), array('username' => $username)));
	}

	public static function login($username, $password)
	{
		return Dao\UserTable::instance()->get_single(null, array('username' => $username, 'password' => $password));
	}
}

