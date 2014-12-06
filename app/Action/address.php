<?php
namespace App\Action;
use \Lavender\Filter;
use \Lavender\Exception;
use \Lavender\Errno;

class Address extends \Base\WebPage
{

	/**
	 * default action
	 *
	 * @return array
	 */
	public function index_action()
	{
		// var_dump($this->session->offsetGet("info"));
		$session = $this->session->offsetGet("info");
		$addrs = \Base\Api\Address::get_by_user($session['user_id']);
		// var_dump($addrs);exit;
		return array('code' => 0, 'data' => array('addrs'=>$addrs, 'address_id'=>$session['address_id']));
	}

	public function add_action()
	{
		// $session = $this->session->offsetGet("info");
		// $addr = \Base\Api\Address::get_by_user($session['user_id']);
		return array('code' => 0);
	}

	// public function add_submit_action()
	// {		
	// 	$param = $this->parameters(array(
	// 		'name' => Filter::T_STRING,
	// 		'address' => Filter::T_STRING,
	// 		'post_code' => Filter::T_STRING,
	// 		'mobile' => Filter::T_STRING,
	// 		'civil_id' => Filter::T_STRING
	// 		), self::M_POST, true);

	// 	$session = $this->session->offsetGet("info");

	// 	$addr = array(
	// 		'name'=>$param['name'],
	// 		'address'=>$param['address'],
	// 		'post_code'=>$param['post_code'],
	// 		'mobile'=>$param['mobile'],
	// 		'civil_id'=>$param['civil_id'],
	// 		'user_id'=>intval($session['user_id']),
	// 		);

	// 	$param_file = $this->parameters(array(
	// 		'file1' => Filter::T_RAW,'file2' => Filter::T_RAW), self::M_FILE, false);
	
	// 	if($param_file['file1']['size'] > 0) {
	// 		$pic_url = $this->upload_file($param_file['file1'])['url'];
	// 		$addr['civil_card_pic1'] = $pic_url;
	// 	} 
	// 	if($param_file['file2']['size'] > 0) {
	// 		$pic_url = $this->upload_file($param_file['file2'])['url'];
	// 		$addr['civil_card_pic2'] = $pic_url;
	// 	}

	// 	$addr_id = \Base\Api\Address::get_by_user($session['user_id'])['id'];
	// 	if(empty($addr_id)) {
	// 		\Base\Api\Address::add($addr);
	// 	} else {
	// 		$addr['id'] = $addr_id;
	// 		\Base\Api\Address::update($addr);
	// 	}
		
		
	// 	$this->redirect("/?action=main.index");
	// 	return array('code' => 0, 'msg' => 'welcome', 'view' => 'main/index');
	// }

	public function edit_action()
	{				
		$param = $this->parameters(array('id' => Filter::T_STRING), self::M_GET, true);		
		$session = $this->session->offsetGet("info");
		$addr = \Base\Api\Address::get($param['id']);
		return array('code' => 0, 'data'=> array('addr'=>$addr));
	}

	public function delete_action()
	{				
		$param = $this->parameters(array('id' => Filter::T_STRING), self::M_GET, true);
		$session = $this->session->offsetGet("info");
		\Base\Api\Address::delete($param['id'], $session['user_id']);
		$this->redirect("/?action=address.index");
		return array('code' => 0, 'msg' => 'welcome', 'view' => 'main/index');
	}

	public function set_default_action()
	{				
		$param = $this->parameters(array('id' => Filter::T_STRING), self::M_GET, true);		
		$session = $this->session->offsetGet("info");
		$session['address_id'] = $param['id'];
		$this->session->offsetSet("info", $session);

		\Base\Api\User::update($session['user_id'], array('address_id'=>$param['id']));

		$this->redirect("/?action=address.index");
		return array('code' => 0, 'msg' => 'welcome', 'view' => 'main/index');
	}

	public function add_submit_action()
	{		
		$param = $this->parameters(array(			
			'name' => Filter::T_STRING,
			'address' => Filter::T_STRING,
			'province' => Filter::T_STRING,
			'city' => Filter::T_STRING,
			'post_code' => Filter::T_STRING,
			'mobile' => Filter::T_STRING,
			'civil_id' => Filter::T_STRING
			), self::M_POST, true);

		$param_plus = $this->parameters(array('id'=>Filter::T_INT), self::M_POST, false);

		$session = $this->session->offsetGet("info");

		$addr = array(			
			// 'id'=>$param['id'],
			'name'=>$param['name'],
			'province'=>$param['province'],
			'city'=>$param['city'],
			'address'=>$param['address'],
			'post_code'=>$param['post_code'],
			'mobile'=>$param['mobile'],
			'civil_id'=>$param['civil_id'],
			'user_id'=>intval($session['user_id']),
			);

		$param_file = $this->parameters(array(
			'file1' => Filter::T_RAW,'file2' => Filter::T_RAW), self::M_FILE, false);
	
		if($param_file['file1']['size'] > 0) {
			$pic_url = $this->upload_file($param_file['file1'])['url'];
			$addr['civil_card_pic1'] = $pic_url;
		} 
		if($param_file['file2']['size'] > 0) {
			$pic_url = $this->upload_file($param_file['file2'])['url'];
			$addr['civil_card_pic2'] = $pic_url;
		}

		// $addr_id = \Base\Api\Address::get_by_user($session['user_id'])['id'];
		if(empty($param_plus['id'])) {
			\Base\Api\Address::add($addr);
		} else {
			$addr['id'] = $param_plus['id'];
			\Base\Api\Address::update($addr);
		}
		
		
		$this->redirect("/?action=address.index");
		return array('code' => 0, 'msg' => 'welcome', 'view' => 'main/index');
	}

	private function upload_file($file) {
		if($file['error'] > 0){
			throw new Exception('file error:' . $file['error'], Errno::INPUT_PARAM_INVALID);		
			return ['url'=>''];
		}
		if(!is_uploaded_file($file['tmp_name']) || $file['size'] == 0){
			throw new Exception('file error:' . $file['error'], Errno::INPUT_PARAM_INVALID);
			return ['url'=>''];
		}
		if($file['size'] > 2 * 1024 * 1024){
			throw new Exception('size over 2MB', Errno::INPUT_PARAM_INVALID);		
			return ['url'=>''];
		}

		return \Base\FileHelper::set_file_url($file['tmp_name'], 1, $file['type'], $file['size'], substr(strrchr($file['name'], '.'), 1));
	}


}

