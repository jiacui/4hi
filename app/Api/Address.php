<?php
namespace App\Api;
use Lavender\Errno;
use Lavender\Exception;

class Address
{
	public static function add($addr) 
	{
		return \Base\Dao\AddressTable::instance()->add(null, $addr);
	}

	public static function update($addr) 
	{
		return \Base\Dao\AddressTable::instance()->update($addr['id'], $addr);
	}

	public static function get_by_user($user_id) 
	{
		return \Base\Dao\AddressTable::instance()->get_single(null, array('user_id'=>$user_id));
	}
}

