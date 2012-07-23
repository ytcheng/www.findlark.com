<?php
/**
 * 相似图片搜索hash的php实现
 */
class ImageHash {
	private static $_instance = null;
	
	// 缩略图尺寸
	public $thumbWidth = 8;
	public $thumbHeight = 8;
	
	// Imagick 对象
	private $img;
	
	public static function getInstance() {
		if (self::$_instance === null){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function getImageHash($file) {
		if (!class_exists('Imagick')) {
			throw new Exception('Must load the Imagick extension');
		}
		if(!file_exists($file)) {
			throw new Exception('File does not exist! '.$file);
		}

		$this->img = new Imagick($file);
		$this->img->thumbnailImage($this->thumbWidth, $this->thumbHeight);
		return $this->getHash();
	}
	
	/**
	 * 计算两个hash的汉明距离，2进制值
	 */
	public function getHashHamming($hash1, $hash2) {
		$count = 0;
		
		$hashGmp1 = gmp_init($hash1, 2);
		$hashGmp2 = gmp_init($hash2, 2);
		$negative = gmp_init('-1');
		$xor = gmp_xor($hashGmp1, $hashGmp2);
		
		while(gmp_strval($xor,2)) {
    	++$count;
    	$xor = gmp_and($xor, gmp_add($xor, $negative));
		}
		return $count;
	}

	/**
	 * 计算图片HASH 值
	 * return 返回16进制hash值
	 */
	public function getHash() {
		$gray = array();
		for ($y=0; $y < $this->thumbHeight; $y++) {
			for ($x=0; $x < $this->thumbWidth; $x++) {
				$rgb = $this->img->getImagePixelColor($x, $y)->getColor();
				$l = $rgb['r'] * 0.3 + $rgb['g'] * 0.59 + $rgb['b'] * 0.11;
				$gray[] = round($l);
			}
		}
		$total = array_sum($gray);
		
		$average = $total / ($this->thumbHeight * $this->thumbWidth);
		$hashString = '';
		foreach($gray as $k => $v) {
			$hashString .= $v < $average ? 0 : 1;
		}
		return base_convert($hashString, 2, 16);
	}
}