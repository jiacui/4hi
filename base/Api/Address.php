<?php
namespace Base\Api;
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
		// return \Base\Dao\AddressTable::instance()->get_single(null, array('user_id'=>$user_id));
		return \Base\Dao\AddressTable::instance()->get(null, array('id','name','address','province','city','mobile','civil_id','civil_card_pic1','civil_card_pic2'), array('user_id'=>$user_id));
	}

	public static function get($id) 
	{
		return \Base\Dao\AddressTable::instance()->get_single($id);
	}

	public static function delete($id, $user_id) 
	{
		return \Base\Dao\AddressTable::instance()->delete($id, array('user_id'=>$user_id));
	}
}

