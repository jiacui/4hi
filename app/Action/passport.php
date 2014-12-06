<?php
namespace App\Action;
use \Lavender\Filter;
use \Lavender\Exception;
use \Lavender\Errno;

class Passport extends \Base\WebPage
{
	protected $without_auth_actions = array(
		'*',
	);

	/**
	 * default action
	 *
	 * @return array
	 */
	public function login_action()
	{
		if(!empty($this->session->offsetGet("info"))) {
			$this->redirect("/?action=main.index");
			return array('code' => 0, 'msg' => 'welcome');
		}
		return array('code' => 0, 'msg' => 'welcome');
	}

	public function login_submit_action()
	{
		$param = $this->parameters(array(
			'username'=>Filter::T_STRING ,
			'password'=>Filter::T_STRING,
		), self::M_POST, true);

		$username = $param['username'];
		// if (!(Filter::filter($username, Filter::T_EMAIL) || Filter::filter($username, Filter::T_MOBILE))) {
		// 	throw new Exception\Filter("Parameter '{$username}' is invalid", Errno::INPUT_PARAM_INVALID);
		// }

		$user = \Base\Api\Passport::login($username, md5($param['password']));

		if(empty($user)) {
			return array('code' => 0, 'msg' => '密码错误或用户名不存在', 'view' => 'passport/login');
		}

		$this->set_cookie(self::SESSION_KEY_NAME, $this->session->create($user['id'], time()));
		$this->session->offsetSet("info", array('user_id'=>$user['id'], 'username' => $param['username'], 'address_id'=>$user['address_id']));
		// $this->session->destroy();
		$this->redirect("/?action=main.index");
		return array('code' => 0, 'msg' => 'welcome', 'view' => 'main/index');
		// return $this->redirect("/?action=main.index");
	}

	public function register_action()
	{
		return array('code' => 0, 'msg' => 'welcome');
	}

	public function register_submit_action()
	{
		$param = $this->parameters(array(
			'username'=>Filter::T_STRING,
			'nickname'=>Filter::T_STRING,
			'password'=>Filter::T_STRING,
		), self::M_POST, true);

		$param_plus = $this->parameters(array('mobile'=>Filter::T_STRING), self::M_POST, false);
		$user = array();
		$user['username'] = $param['username'];
		$user['password'] = md5($param['password']);
		$user['nickname'] = $param['nickname'];
		$user['mobile'] = $param_plus['mobile'];

		if(\Base\Api\Passport::is_username_exit($param['username'])) {
			throw new Exception\Filter("Parameter '{$username}' is exit!", Errno::INPUT_PARAM_INVALID);
		}

 		\Base\Api\Passport::register_user($user);

		$this->redirect("/?action=main.index");
		return array('code' => 0, 'msg' => 'welcome');
	}

	public function logout_action()
	{
		$this->session->destroy();
		$this->set_cookie(self::SESSION_KEY_NAME, null);
		$this->redirect("/?action=passport.login");
		return array('code' => 0);
	}

}

