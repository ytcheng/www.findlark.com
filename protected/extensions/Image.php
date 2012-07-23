<?php

class Image{
	public $allowPicType = array('image/jpg'=>'jpg', 'image/pjpeg'=>'jpg', 'image/jpeg'=>'jpg', 'image/png'=>'png', 'image/gif'=>'gif');
	private static $_instance = null;
	
	function __construct() {
		
	}
	
	public static function getInstance() {
		if(self::$_instance === null){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function makeDir() {
		$arr = array(date('Y'), date('m'), 'thumb');
		$uploadPath = realpath(Yii::app()->basePath.'/../upload');
		foreach($arr as $v) {
			$uploadPath .= '/'.$v;
			if(!file_exists($uploadPath)) {
				if(!mkdir($uploadPath)) {
					throw new Exception('Failed to create directory!');
				}
			}
		}
		
		return substr($uploadPath, 0, -5);
	}
	
	/**
	 * 上传文件
	 * @param $file 客户端提交的文件信息，格式等同于$_FILE['file']
	 * return 文件路径
	 */
	public function uploadFile($file) {
		if(!isset($this->allowPicType[$file['type']])) {
			throw new Exception('File type not allowed!');
		}
		
		$fileExt = $this->allowPicType[$file['type']];
		$uploadDir = $this->makeDir();
		$fileName = $this->mkFileName();
		$filePath = $uploadDir.$fileName.'.'.$fileExt;
		
		# 创建文件
		if(!@ move_uploaded_file($file['tmp_name'], $filePath)) {
			throw new Exception('File upload failed!');
		}
		
		return array('path'=>$filePath, 'dir'=>$uploadDir, 'name'=>$fileName, 'ext'=>$fileExt);
	}
	
	/**
	 * 生成文件名
	 */
	public function mkFileName() {
		$n = microtime(true) * 100;
		$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$fileName = '';
		
		while($n) {
			$x = $n % 26;
			$fileName .= $str[$x];
			$n = floor($n / 26);
		}
		
		return strrev($fileName);
	}
	
	/**
	 * 获取图片信息，直方图、exif等
	 */
	public function getImageInfo($file) {
		if (!class_exists('Imagick')) {
			throw new Exception('Must load the Imagick extension');
		}
		if(!file_exists($file)) {
			throw new Exception('File does not exist! '.$file);
		}
		
		// 填充数组
		$arr = array_fill_keys(range(0, 255), 0);
		$histogram = array('gray'=> $arr, 'r'=> $arr, 'g'=> $arr, 'b'=> $arr, 'rgb'=> $arr);
		
		$image = new Imagick($file);
		$properties = $image->getImageProperties('*', true);
		unset($properties['exif:MakerNote'], $properties['exif:UserComment']);
		
		if($image->getImageWidth() > 1440) {
			$image->thumbnailImage(1440, 0);
			$image->writeImage($file);
			unset($image);
			$image = new Imagick($file);
		}
		$w = $image->getImageWidth();
		$h = $image->getImageHeight();
		$count = $w * $h;
		$pixels = $image->getImageHistogram();
		foreach($pixels as $p) {
			$rgb = $p->getColor();
			$gray = $rgb['r'] * 0.3 + $rgb['g'] * 0.59 + $rgb['b'] * 0.11;
			$gray = round($gray);
			
			$histogram['gray'][$gray]++;
			$histogram['r'][$rgb['r']]++;
			$histogram['g'][$rgb['g']]++;
			$histogram['b'][$rgb['b']]++;
			$histogram['rgb'][$rgb['r']] += 1 / 3; 
			$histogram['rgb'][$rgb['g']] += 1 / 3; 
			$histogram['rgb'][$rgb['b']] += 1 / 3; 
		}
		
		foreach($histogram['rgb'] as $k => $v) {
			$histogram['rgb'][$k] = round($v);
		}
		
		// 计算
		foreach($histogram as $k => $arr) {
			$histogram[$k]['sum'] = array_sum($arr);
			$histogram[$k]['max'] = max($arr);
		}

		// 总像素
		$histogram['width'] = $w;
		$histogram['height'] = $h;
		$histogram['count'] = $count;
		// 阀值，取总像素的 1/64（参考PhotoShop）
		$histogram['valve'] = $count / 64;
		
		return array('histogram'=>$histogram, 'properties'=>$properties);
	}
	
	// 生成缩略图
	public function mkImageThumb($imageDir, $imageName) {
		$img = new Imagick($imageDir.$imageName);
		$img->thumbnailImage(460, 0);
		$img->writeImage($imageDir.'thumb/thumb460_'.$imageName);
		$img->thumbnailImage(0, 90);
		$img->writeImage($imageDir.'thumb/thumb90_'.$imageName);
		return $imageDir.'thumb/thumb90_'.$imageName;
	}
	
	public function getImageExif() {
		
		
	}
}