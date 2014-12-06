<?php
namespace App\Action;

use Golo\ErrnoPlus;
use Golo\FileHelper;
use Golo\GoloWebService;
use Lavender\Filter;

class File_Service extends GoloWebService
{
	/**
	 * upload action
	 *
	 * @return array
	 */
	public function upload_action()
	{
		$param = $this->parameters(array(
			'type' => Filter::T_INT,), self::M_POST, true);

		$param_file = $this->parameters(array(
			'file' => Filter::T_RAW,), self::M_FILE, true);

		if($param['type'] < 0 || $param['type'] > 2){
			return $this->error('type value:' . $param_file, ErrnoPlus::PARAM_INVALID);
		}
		if($param_file['file']['error'] > 0){
			return $this->error('file error:' . $param_file['file']['error'], ErrnoPlus::PARAM_INVALID);
		}
		if(!is_uploaded_file($param_file['file']['tmp_name']) || $param_file['file']['size'] == 0){
			return $this->error('no file or size is 0', ErrnoPlus::PARAM_INVALID);
		}
		if($param_file['file']['size'] > 5 * 1024 * 1024){
			return $this->error('size over 5MB', ErrnoPlus::PARAM_INVALID);
		}

		$data = FileHelper::set_file_url($param_file['file']['tmp_name'], $param_file, $param_file['file']['type'], $param_file['file']['size']);

		return $this->success('', $data);
	}

	/**
	 * 上传视频接口
	 * @return array
	 */
	public function video_action()
	{
		$param_file = $this->parameters(array(
			'file' => Filter::T_RAW,
			'thumb' => Filter::T_RAW), self::M_FILE, true);

		if($param_file['file']['error'] > 0 || $param_file['thumb']['error'] > 0){
			return $this->error('file error:' . $param_file['file']['error'], ErrnoPlus::PARAM_INVALID);
		}
		if(!is_uploaded_file($param_file["file"]["tmp_name"]) || $param_file['file']['size'] == 0 || 
			!is_uploaded_file($param_file["thumb"]["tmp_name"]) || $param_file["thumb"]["size"] == 0){
			return $this->error('no file or size is 0', ErrnoPlus::PARAM_INVALID);
		}
		if($param_file['file']['size'] + $param_file['thumb']['size'] > 10 * 1024 * 1024){
			return $this->error('size over 10MB', ErrnoPlus::PARAM_INVALID);
		}

		$data = FileHelper::set_video_url($param_file['file']['tmp_name'], $param_file['thumb']['tmp_name'],$param_file['file']['type']);

		return $this->success('success', $data);
	}

}