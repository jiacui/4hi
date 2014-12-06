<?php
namespace App\Action;
use \Lavender\Filter;
use \Lavender\Exception;
use \Lavender\Errno;

class User extends \Base\WebPage
{

	public function profile_action()
	{				
		$session = $this->session->offsetGet("info");
		$user = \Base\Api\User::get($session['user_id']);
		return array('code' => 0, 'data'=> array('user'=>$user));
	}

	public function update_profile_action()
	{		
		$param = $this->parameters(array(
			'province' => Filter::T_STRING,
			'city' => Filter::T_STRING,
			'address' => Filter::T_STRING,
			'mobile' => Filter::T_STRING,
			'qq' => Filter::T_STRING,
			'email' => Filter::T_STRING,
			'civil_id' => Filter::T_STRING
			), self::M_POST, true);

		$session = $this->session->offsetGet("info");

		$addr = array(
			'province'=>$param['province'],
			'city'=>$param['city'],
			'address'=>$param['address'],			
			'mobile'=>$param['mobile'],
			'qq'=>$param['qq'],
			'civil_id'=>$param['civil_id'],
			'email'=>$param['email'],
			);

		\Base\Api\User::update($session['user_id'], $addr);
		
		
		$this->redirect("/?action=user.profile");
		return array('code' => 0, 'msg' => 'welcome', 'view' => 'main/index');
	}


}

