<?php
namespace Base;

class WebPage extends \Lavender\WebPage {
	protected function render_auth_error($msg, $code = 401)
	{
		$data = array(
			'code' => $code,
			'msg' => $msg,
			'view' => 'passport/login',
		);

		return $this->render($data);
	}
}
