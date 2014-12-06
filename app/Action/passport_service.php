<?php
namespace App\Action;
use \Lavender\Filter;
use \Lavender\Exception;
use \Lavender\Errno;

class Passport_Service extends \Lavender\WebService
{
	protected $without_auth_actions = array(
		'*',
	);

	public function check_username_action()
	{
		$param = $this->parameters(array(
			'username'=>Filter::T_STRING
		), self::M_GET, true);

		if(\Base\Api\Passport::is_username_exit($param['username'])) {
			return array('code' => 100001, 'msg' => 'username exist!');
		}else {
			return array('code' => 0);
		}
	}

	public function check_nickname_action()
	{
		$param = $this->parameters(array(
			'nickname'=>Filter::T_STRING
		), self::M_GET, true);

		if(\Base\Api\Passport::is_nickname_exit($param['nickname'])) {
			return array('code' => 100001, 'msg' => 'nickname exist!');
		}else {
			return array('code' => 0);
		}
	}

	public function check_mobile_action()
	{
		$param = $this->parameters(array(
			'mobile'=>Filter::T_STRING
		), self::M_GET, true);

		if(\Base\Api\Passport::is_mobile_exit($param['mobile'])) {
			return array('code' => 100001, 'msg' => 'mobile exist!');
		}else {
			return array('code' => 0);
		}
	}
}

