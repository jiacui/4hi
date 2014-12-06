<?php
namespace Base;

use Lavender\Core;

class FileHelper
{
	const FILE_PATH = 'file';
	const PIC_PATH = 'pic';
	const VOICE_PATH = 'voice';
	const THUMB_MAX = 200; // 缩略图的最大宽 or 高
	const BORDER = 0; // 边框像素
	const STANDARD_MAX = 720; // 标准图最小边不得大于这个值

	/**
	 * 图片上传至文件服务器
	 *
	 * @param unknown $tmp_name 待保存的图片二进制流
	 * @param unknown $img_name 保存后的图片名字
	 * @param unknown $upload_dir 图片上传的目录
	 * @param unknown $is_suf 是否写入后缀
	 * @throws \Exception
	 * @return number
	 */
	public static function binary_image_upload($binary,$suf,$img_name,$upload_dir,$prefix=null,$is_suffix=0)
	{
		if(!is_dir($upload_dir)){
			self::create_folder($upload_dir);
		}

		if(!$is_suffix){
			$suf=null;
		}
		if(file_exists($upload_dir.$img_name)){
			rename($upload_dir.$prefix.$img_name, $upload_dir.time().'_'.$img_name.$suf);
		}


		if(file_put_contents($upload_dir.$prefix.$img_name.$suf, $binary,LOCK_EX)){
			return $prefix.$img_name.$suf;
		}

		return false;

	}

	/**
	 * 参照 set_user_face_url方法，用于网页客户端上传用户头像至文件服务器
	 * 如公众号web端更新自己的头像
	 * 
	 * @param string $binary
	 * @param int $uid
	 * @throws \Exception
	 * @return bool | array
	 */
	public static function binary_set_user_face($binary, $uid)
	{
		$tmp_name = L_APP_PATH . 'wwwroot/temp/' . $uid;
		$tmp_dir = dirname($tmp_name);
		if (!is_dir($tmp_dir)) {
			if (false === mkdir($tmp_dir, 0777, true)) {
				throw new \Exception('get false that mkdir when set face');
			}
		}
		
		$data = null;
		
		try{
			file_put_contents($tmp_name, $binary, LOCK_EX);
			$data = Api\User::set_face($uid, $tmp_name);
		} catch(\Exception $e) {
			unlink($tmp_name);
		}
		
		unlink($tmp_name);
		
		return $data;
	}

	/**
	 * 设置apk版本文件
	 *
	 * @param $file_path 原文件路径
	 * @param $filename 文件名
	 * @return string 版本文件地址
	 */
	public static function set_vision_url($file_path, $filename)
	{
		$conf = Core::get_config('const', 'apk');

		$dir = $conf['upload_path']. $conf['path'] ;
		$file = $dir . $filename;

		self::create_folder($dir);


		if(file_exists($file)){
			rename($file, $file.date('YmdHis'));
		}

		return move_uploaded_file($file_path, $file);

	}

	/**
	 * 获取apk版本文件地址
	 *
	 * @param $filename 文件名
	 * @return null string
	 */
	public static function get_vision_url($filename)
	{
		if (empty($filename)) {
			return null;
		}
		$conf = Core::get_config('const', 'apk');

		return $conf['upload_url'].$conf['path']. $filename;

	}

	/**
	 * 删除apk版本文件
	 *
	 * @param
	 *            $filename
	 */
	public static function delete_vision_file($filename)
	{
		if (strpos($filename, "/") === false){
			$conf = Core::get_config('const', 'apk');
			unlink($conf['upload_path']. $conf['path'] . $filename);
			return true;
		}

		return false;

	}

	/**
	 * 设置文件
	 *
	 * @param $file_path 原文件路径(temp
	 *            路径）
	 * @param $type 类型
	 *            0 文件 1 图片 2 声音
	 * @param $mine_type mine类型（当文件）
	 * @param $file_size 文件大小，大于1m时压缩， -1表示不压缩
	 * @return array url 文件地址 thumb 文件缩略图
	 */
	public static function set_file_url($file_path, $type, $mine_type, $file_size = -1, $suffix)
	{
		$path_head = '';
		switch ($type) {
			case 0:
			{
				$path_head = self::FILE_PATH;
				break;
			}
			case 1:
			{
				$path_head = self::PIC_PATH;
				break;
			}
			case 2:
			{
				$path_head = self::VOICE_PATH;
				break;
			}
		}
		$md5str = md5($file_path);
		$md5len = strlen($md5str);
		$upload_path = $path_head . '/' . date("Ymd") . '/' . substr($md5str, 0, 2) . '/' . substr($md5str, $md5len - 2) . '/';
		self::create_folder(Core::get_config('const','file')['UPLOAD_PATH'] . $upload_path);
		$filename = $upload_path . $md5str;
		
		if (1 == $type) {
			$max_size = 300*1024;
			if($file_size>$max_size){
				$percent = $max_size/$file_size; //压缩比

				list($width, $height) = getimagesize($file_path); //获取原图尺寸
				//缩放尺寸
				$newwidth = $width * $percent;
				$newheight = $height * $percent;

				self::resize_image($file_path, $newwidth, $newheight, Core::get_config('const','file')['UPLOAD_PATH'] . $filename, '.'.$suffix, $mine_type);
				unlink($file_path);

			}else{
				move_uploaded_file($file_path, Core::get_config('const','file')['UPLOAD_PATH'] . $filename . '.' . $suffix);
			}
			self::resize_image(Core::get_config('const','file')['UPLOAD_PATH'] . $filename, 160, 160, Core::get_config('const','file')['UPLOAD_PATH'] . $tfilename, '.thumb.'.$suffix, $mine_type);

			return array('url' => Core::get_config('const','file')['UPLOAD_URL'] . $filename . '.' . $suffix, 'thumb' => Core::get_config('const','file')['UPLOAD_URL'] . $tfilename . '.thumb.'.$suffix);
		}
		move_uploaded_file($file_path, Core::get_config('const','file')['UPLOAD_PATH'] . $filename . '.' . $suffix);
		return array('url' => Core::get_config('const','file')['UPLOAD_URL'] . $filename . '.' . $suffix, 'thumb' => '');

	}

	/**
	 * 设置视频
	 * @param $file_path
	 * @param $thumb_path
	 * @return array
	 */
	public static function set_video_url($file_path, $thumb_path)
	{
		$md5str = md5($file_path);
		$md5len = strlen($md5str);
		$upload_path = 'video' . '/' . date("Ymd") . '/' . substr($md5str, 0, 2) . '/' . substr($md5str, $md5len - 2) . '/';
		self::create_folder(Core::get_config('const','file')['UPLOAD_PATH'] . $upload_path);
		$filename = $upload_path . $md5str;
		move_uploaded_file($file_path, Core::get_config('const','file')['UPLOAD_PATH'] . $filename);
		move_uploaded_file($thumb_path, Core::get_config('const','file')['UPLOAD_PATH'] . $filename . '.thumb');
		return array(
			'url' => Core::get_config('const','file')['UPLOAD_URL'] . $filename,
			'thumb' => Core::get_config('const','file')['UPLOAD_URL'] . $filename . '.thumb',
		);
	}

	/**
	 * 设置分享文件
	 *
	 * @param $file_path 原文件路径(temp路径）
	 * @param $path_head 目录头
	 * @param $type 类型 0 文件 1 图片 2 声音
	 * @param $mine_type mine类型（当文件）
	 * @return array url 文件地址 thumb 文件缩略图
	 */
	public static function set_share_file_url($file_path, $file_size, $type, $mine_type, $extension)
	{
		$path_head = '';
		switch ($type) {
			case 0:
				$path_head = self::FILE_PATH;
				break;
			case 1:
				$path_head = self::PIC_PATH;
				break;
			case 2:
				$path_head = self::VOICE_PATH;
				break;
		}

		$conf = Core::get_config('const', 'file');
		$md5str = md5_file($file_path) . '_' . $file_size . '_1';
		$upload_path = 'share/' . $path_head . '/' . substr($md5str, 0, 2) . '/' . substr($md5str, 2, 2) . '/' . substr($md5str, 4, 2) . '/' . substr($md5str, 6, 2) . '/';
		$dir = $conf['SHARE_PATH']  . $upload_path;
		if(!is_dir($dir)){
			if( mkdir($dir, 0777, true) === false ){
				throw new \Exception('mkdir false');
			}
		}

		$filename = $upload_path . $md5str;

		if ($type == 1) {
			$img = new \Lavender\Image($file_path);

			// 最大边处理 图片宽 or 高 大于指定规格，则压缩
			$options_thumb = array(
				'src_w' => $img->width,
				'src_h' => $img->height,
				'dst_x' => self::BORDER,
				'dst_y' => self::BORDER,
				'dst_w' => self::THUMB_MAX,
				'dst_h' => self::THUMB_MAX,
				'fill' => 1,
				'rgb' => array(235, 245, 255)); // 冰雪的颜色(含版权)

			if( ($img->width > self::THUMB_MAX) || ($img->height > self::THUMB_MAX) ){
				$srcW = $img->width;
				$srcH = $img->height;
				$srcX = 0;
				$srcY = 0;

				// 高 > 宽
				if ($img->height > $img->width) {
					if($img->width >= self::THUMB_MAX){
						$srcH = $srcW;
						$srcY = ceil(($img->height / 2) - ($img->width / 2));
					}else{
						$srcH = self::THUMB_MAX;
						$srcY = ceil(($img->height / 2) - (self::THUMB_MAX / 2));
					}

				}
				// 宽 > 高
				elseif ( $img->width > $img->height) {
					if($img->height >= self::THUMB_MAX){
						$srcW = $srcH;
						$srcX = ceil(($img->width / 2) - ($img->height / 2));
					}else{
						$srcW = self::THUMB_MAX;
						$srcX = ceil(($img->width / 2) - (self::THUMB_MAX / 2));
					}

				}
				$options_thumb['src_w'] = $srcW;
				$options_thumb['src_h'] = $srcH;
				$options_thumb['src_x'] = $srcX;
				$options_thumb['src_y'] = $srcY;
			}

			// 最小边处理
			$width_standard = $img->width;
			$height_standard = $img->height;
			$options_standard = array();
			if(($img->width > self::STANDARD_MAX) || ($img->height > self::STANDARD_MAX)){
				// 宽 < 高
				if ( ($img->width > self::STANDARD_MAX) && ($img->width < $img->height) ) {
					$rate = round($img->width / $img->height, 2); // 比率保留2位小数
					$width_standard = self::STANDARD_MAX;
					$height_standard = floor($img->height * $rate);
				}
				// 宽 > 高
				elseif( ($img->height > self::STANDARD_MAX) && ($img->height < $img->width) ){
					$rate = round($img->height / $img->width, 2); // 比率保留2位小数
					$width_standard = floor($img->width  * $rate);
					$height_standard = self::STANDARD_MAX;
				}
				// 宽 = 高
				else {
					$width_standard = $height_standard = self::STANDARD_MAX;
				}

				$options_standard = array('src_w' => $img->width, 'src_h' => $img->height);
			}

			$quality = 100;
// 			$img->save_copy($conf['SHARE_PATH'] . $filename . '.origianl', $img->width, $img->height); // 取消原图
			$img->save_copy($conf['SHARE_PATH'] . $filename, $width_standard, $height_standard, $quality * 0.95, $options_standard);
			$img->save_copy($conf['SHARE_PATH'] . $filename . '.thumb', self::THUMB_MAX + (self::BORDER * 2), (self::BORDER * 2) + self::THUMB_MAX, $quality * 0.8, $options_thumb);

			return array(
				'url' => $conf['SHARE_URL']  . $filename,
				'thumb' => $conf['SHARE_URL']  . $filename . '.thumb',
				'dir' => $upload_path,
				'id' => $md5str,
			);
		}

		$filename = $filename . $extension;
		move_uploaded_file($file_path, $conf['SHARE_PATH'] . $filename);
		return array(
			'url' => $conf['SHARE_URL'] . $filename,
			'thumb' => '',
			'dir' => $upload_path,
			'id' => $md5str,
		);
	}

	/**
	 * 获取分享文件名
	 *
	 * @param $url_path
	 * @return mixed
	 */
	public static function get_share_file_name($url_path)
	{
		$paths = explode('/', $url_path);
		$path_count = count($paths);
		$md5str = $paths[$path_count - 1];
		return $md5str;
	}

	/**
	 * 获取分享文件地址
	 *
	 * @param $filename
	 * @param $path_head
	 * @return string
	 */
	public static function get_share_file_url($filename, $path_head)
	{
		$upload_path = 'share/' . $path_head . '/' . substr($filename, 0, 2) . '/' . substr($filename, 2, 2) . '/' . substr($filename, 4, 2) . '/' . substr($filename, 6, 2) . '/';
		$filename = $upload_path . $filename;
		return Core::get_config('const','file')['SHARE_URL']  . $filename;
	}

	/**
	 * 删除分享文件
	 *
	 * @param $filename
	 * @param $path_head
	 */
	public static function delete_share_file($filename)
	{
		unlink(Core::get_config('const','file')['SHARE_PATH']  . $filename);
	}

	/**
	 * 设置收藏文件
	 *
	 * @param $file_path 原文件路径(temp 路径）
	 * @param $path_head 目录头
	 * @param $type 类型 0 文件 1 图片 2 声音
	 * @param $mine_type mine类型（当文件）
	 * @return array url 文件地址 thumb 文件缩略图
	 */
	public static function set_collect_file_url($file_path, $file_size, $type, $mine_type)
	{
		$path_head = '';
		switch ($type) {
			case 0:
			{
				$path_head = self::FILE_PATH;
				break;
			}
			case 1:
			{
				$path_head = self::PIC_PATH;
				break;
			}
			case 2:
			{
				$path_head = self::VOICE_PATH;
				break;
			}
		}
		$md5str = md5_file($file_path) . '_' . strval($file_size) . '_2';
		$upload_path = 'collect/' . $path_head . '/' . substr($md5str, 0, 2) . '/' . substr($md5str, 2, 2) . '/' . substr($md5str, 4, 2) . '/' . substr($md5str, 6, 2) . '/';
		self::create_folder(Core::get_config('const','file')['COLLECT_PATH']  . $upload_path);
		$filename = $upload_path . $md5str;
		move_uploaded_file($file_path, Core::get_config('const','file')['COLLECT_PATH']  . $filename);
		if (1 == $type) {
			self::resize_image(Core::get_config('const','file')['COLLECT_PATH']  . $filename, 180, 180, Core::get_config('const','file')['COLLECT_PATH']  . $filename, '.thumb', $mine_type);
			return array(
				'url' => Core::get_config('const','file')['COLLECT_URL']  . $filename,
				'thumb' => Core::get_config('const','file')['COLLECT_URL']  . $filename . '.thumb',
				'dir' => $upload_path,
				'id' => $md5str,
			);
		}
		return array(
			'url' => Core::get_config('const','file')['COLLECT_URL']  . $filename,
			'thumb' => '',
			'dir' => $upload_path,
			'id' => $md5str,
		);
	}

	/**
	 * 获取收藏文件名
	 *
	 * @param $url_path
	 * @return mixed
	 */
	public static function get_collect_file_name($url_path)
	{
		$paths = explode('/', $url_path);
		$path_count = count($paths);
		$md5str = $paths[$path_count - 1];
		return $md5str;
	}

	/**
	 * 获取收藏文件地址
	 *
	 * @param $filename
	 * @param $path_head
	 * @return string
	 */
	public static function get_collect_file_url($filename, $path_head)
	{
		$upload_path = 'collect/' . $path_head . '/' . substr($filename, 0, 2) . '/' . substr($filename, 2, 2) . '/' . substr($filename, 4, 2) . '/' . substr($filename, 6, 2) . '/';
		$filename = $upload_path . $filename;
		return Core::get_config('const','file')['COLLECT_URL']  . $filename;
	}


	/**
	 * 删除收藏文件
	 *
	 * @param $filename
	 * @param $path_head
	 */
	public static function delete_collect_file($filename)
	{
		unlink(Core::get_config('const','file')['COLLECT_PATH']  . $filename);
	}

	/**
	 * 获取用户时间戳头像图片地址 @param $uid 用户id @param $time 时间戳 @return 图片网络地址
	 */
	public static function get_user_face_url($uid, $time, $req_zone = null)
	{
		return Api\User::get_face($uid, $time, $req_zone);

// 		$url_header = Core::get_config ( 'const', 'file' )['FACE_UPLOAD_URL'];
// 		if(empty( $time)){
// 			return array('url' => null,'thumb' => null);
// 		}
// 		$filename = $uid;
// 		$face_path = 'face/' . chunk_split ( str_pad ( $uid, 16, "0", STR_PAD_LEFT ), 2, "/" );
// 		$face_path = $face_path . $filename;
// 		$data = array (
// 			'url' => $url_header . $face_path . '?' . $time,
// 			'thumb' => $url_header . $face_path . '.thumb' . '?' . $time);
// 		return $data;

	}

	/**
	 * 设置用户头像 @param $file_path 原文件地址 @param $uid 用户id @param $时间戳 @param $文件类型 @return 头像地址
	 */
	public static function set_user_face_url($file_path, $uid, $time, $filetype)
	{
		return Api\User::set_face($uid, $file_path);

// 		$filename = $uid;
// 		$face_path = 'face/' . chunk_split ( str_pad ( $uid, 16, "0", STR_PAD_LEFT ), 2, "/" );
// 		self::create_folder ( Core::get_config ( 'const', 'file' ) . $face_path );
// 		if (! empty ( $filename )) {
// 			$face_path = $face_path . $filename;
// 			move_uploaded_file ( $file_path, Core::get_config ( 'const', 'file' ) . $face_path );
// 			self::resize_image ( Core::get_config ( 'const', 'file' ) . $face_path, 80, 80, Core::get_config ( 'const', 'file' ) . $face_path, '.thumb', $filetype );
// 			$data = array (
// 					'url' => Core::get_config ( 'const', 'file' ) . $face_path . '?' . $time,
// 					'thumb' => Core::get_config ( 'const', 'file' ) . $face_path . '.thumb' . '?' . $time
// 			);
// 			return $data;
// 		}
// 		return null;

	}

	/**
	 * 生成缩略图
	 *
	 * @param $src_imagename 原图片
	 * @param $maxwidth 最大宽度
	 * @param $maxheight 最大高度
	 * @param $savename 保存的文件名
	 * @param $filetype 文件后缀类型
	 * @param $mine_type mine 类型
	 */
	private static function resize_image($src_imagename, $maxwidth, $maxheight, $savename, $filetype, $mine_type)
	{
		$im = null;
		switch ($mine_type) {
			case "image/jpg":
			case "image/jpeg":
			case "image/pjpeg":
				$im = imagecreatefromjpeg($src_imagename);
				break;
			case "image/gif":
				$im = imagecreatefromgif($src_imagename);
				break;
			case "image/png":
				$im = imagecreatefrompng($src_imagename);
				break;
			default:
				$im = imagecreatefromjpeg($src_imagename);
				break;
		}
		$current_width = imagesx($im);
		$current_height = imagesy($im);

		if (($maxwidth && $current_width > $maxwidth) || ($maxheight && $current_height > $maxheight)) {
			if ($maxwidth && $current_width > $maxwidth) {
				$widthratio = $maxwidth / $current_width;
				$resizewidth_tag = true;
			}

			if ($maxheight && $current_height > $maxheight) {
				$heightratio = $maxheight / $current_height;
				$resizeheight_tag = true;
			}

			if ($resizewidth_tag && $resizeheight_tag) {
				if ($widthratio < $heightratio)
					$ratio = $widthratio;
				else
					$ratio = $heightratio;
			}

			if ($resizewidth_tag && !$resizeheight_tag)
				$ratio = $widthratio;
			if ($resizeheight_tag && !$resizewidth_tag)
				$ratio = $heightratio;

			$newwidth = $current_width * $ratio;
			$newheight = $current_height * $ratio;

			if (function_exists("imagecopyresampled")) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height);
			} else {
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height);
			}

			$savename = $savename . $filetype;
			imagejpeg($newim, $savename, 90);
			imagedestroy($newim);
		} else {
			$savename = $savename . $filetype;
			imagejpeg($im, $savename, 90);
		}

	}

	/**
	 * 逐级创建目录
	 *
	 * @param $path 路径
	 */
	private static function create_folder($path)
	{
		if (!is_dir($path)) {
			if (mkdir($path, 0777, true) === false) {
				throw new \Exception('mkdir false');
			}
		}
	}


	/**
	 * 设置反馈问题文件
	 *
	 * @param $file_path 原文件路径(temp路径）
	 * @param $path_head 目录头
	 * @param $type 类型 0 文件 1 图片 2 声音
	 * @param $mine_type mine类型（当文件）
	 * @return array url 文件地址 thumb 文件缩略图
	 */
	public static function set_feedback_file_url($file_path, $file_size, $type, $mine_type, $extension)
	{
		$path_head = '';
		switch ($type) {
			case 0:
				$path_head = self::FILE_PATH;
				break;
			case 1:
				$path_head = self::PIC_PATH;
				break;
			case 2:
				$path_head = self::VOICE_PATH;
				break;
		}

		$conf = Core::get_config('const', 'file');
		$md5str = md5_file($file_path) . '_' . $file_size . '_1';
		$upload_path = 'feedback/' . $path_head . '/' . substr($md5str, 0, 2) . '/' . substr($md5str, 2, 2) . '/' . substr($md5str, 4, 2) . '/' . substr($md5str, 6, 2) . '/';
		$dir = $conf['SHARE_PATH']  . $upload_path;
		if(!is_dir($dir)){
			if( mkdir($dir, 0777, true) === false ){
				throw new \Exception('mkdir false');
			}
		}

		$filename = $upload_path . $md5str;

		if ($type == 1) {
			$img = new \Lavender\Image($file_path);

			// 最大边处理 图片宽 or 高 大于指定规格，则压缩
			$options_thumb = array(
				'src_w' => $img->width,
				'src_h' => $img->height,
				'dst_x' => self::BORDER,
				'dst_y' => self::BORDER,
				'dst_w' => self::THUMB_MAX,
				'dst_h' => self::THUMB_MAX,
				'fill' => 1,
				'rgb' => array(235, 245, 255)); // 冰雪的颜色(含版权)

			if( ($img->width > self::THUMB_MAX) || ($img->height > self::THUMB_MAX) ){
				$srcW = $img->width;
				$srcH = $img->height;
				$srcX = 0;
				$srcY = 0;

				// 高 > 宽
				if ($img->height > $img->width) {
					if($img->width >= self::THUMB_MAX){
						$srcH = $srcW;
						$srcY = ceil(($img->height / 2) - ($img->width / 2));
					}else{
						$srcH = self::THUMB_MAX;
						$srcY = ceil(($img->height / 2) - (self::THUMB_MAX / 2));
					}

				}
				// 宽 > 高
				elseif ( $img->width > $img->height) {
					if($img->height >= self::THUMB_MAX){
						$srcW = $srcH;
						$srcX = ceil(($img->width / 2) - ($img->height / 2));
					}else{
						$srcW = self::THUMB_MAX;
						$srcX = ceil(($img->width / 2) - (self::THUMB_MAX / 2));
					}

				}
				$options_thumb['src_w'] = $srcW;
				$options_thumb['src_h'] = $srcH;
				$options_thumb['src_x'] = $srcX;
				$options_thumb['src_y'] = $srcY;
			}

			// 最小边处理
			$width_standard = $img->width;
			$height_standard = $img->height;
			$options_standard = array();
			if(($img->width > self::STANDARD_MAX) || ($img->height > self::STANDARD_MAX)){
				// 宽 < 高
				if ( ($img->width > self::STANDARD_MAX) && ($img->width < $img->height) ) {
					$rate = round($img->width / $img->height, 2); // 比率保留2位小数
					$width_standard = self::STANDARD_MAX;
					$height_standard = floor($img->height * $rate);
				}
				// 宽 > 高
				elseif( ($img->height > self::STANDARD_MAX) && ($img->height < $img->width) ){
					$rate = round($img->height / $img->width, 2); // 比率保留2位小数
					$width_standard = floor($img->width  * $rate);
					$height_standard = self::STANDARD_MAX;
				}
				// 宽 = 高
				else {
					$width_standard = $height_standard = self::STANDARD_MAX;
				}

				$options_standard = array('src_w' => $img->width, 'src_h' => $img->height);
			}

			$quality = 100;
// 			$img->save_copy($conf['SHARE_PATH'] . $filename . '.origianl', $img->width, $img->height); // 取消原图
			$img->save_copy($conf['SHARE_PATH'] . $filename, $width_standard, $height_standard, $quality * 0.95, $options_standard);
			$img->save_copy($conf['SHARE_PATH'] . $filename . '.thumb', self::THUMB_MAX + (self::BORDER * 2), (self::BORDER * 2) + self::THUMB_MAX, $quality * 0.8, $options_thumb);

			return array(
				'url' => $conf['SHARE_URL']  . $filename,
				'thumb' => $conf['SHARE_URL']  . $filename . '.thumb',
				'dir' => $upload_path,
				'id' => $md5str,
			);
		}

		$filename = $filename . $extension;
		move_uploaded_file($file_path, $conf['SHARE_PATH'] . $filename);
		return array(
			'url' => $conf['SHARE_URL'] . $filename,
			'thumb' => '',
			'dir' => $upload_path,
			'id' => $md5str,
		);
	}

}