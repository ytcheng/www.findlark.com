<?php
error_reporting(E_ALL);
class HomeController extends Controller {
	
	public function actionIndex() {
		
		$this->testmatch();
		
		$urls = array(
			"http://m3.img.libdd.com/farm4/2012/0913/13/EA3F8589A929EB3EC5BFB4FFC1FF5218C65D14C41000_515_690.jpg",
			"http://www.baidu.com",
			"http://www.oschina.net",
			"http://www.qidian.com",
			"http://www.yupoo.com",
			"http://bbs.aoshitang.com/",
			"http://open.163.com/",
			"http://www.360buy.com/",
			"http://www.wikipedia.org/",
			"http://open.weibo.com/",
			"http://www.oschina.net/news/34044",
			"http://www.oschina.net/news/34041/apple-lightning-chip",
			"http://www.oschina.net/news/34040/google-de-locale",
			"http://my.oschina.net/zhzhenqin/blog/84414",
			"http://www.oschina.net/question/249672_75701#answers",
			"http://www.oschina.net/news/34022/e-ink-android-phone",
			"http://www.oschina.net/news/34020/mathgen",
			"http://blog.csdn.net/bill200711022/article/details/6861123",
		);
		
		$statr = microtime(true);
		foreach($urls as $url) {
			//$img = Curl::model()->request($url, array("header"=>0));
		}
		
		$end = microtime(true);
		echo $end - $statr;
		
		$statr = microtime(true);
		echo "<br>";
		//$url = "http://m3.img.libdd.com/farm4/2012/0913/13/EA3F8589A929EB3EC5BFB4FFC1FF5218C65D14C41000_515_690.jpg";
		//$img = Curl::model()->request($url, array("header"=>0));
		
		//Curl::model()->multipleRequest($urls, array("header"=>0));
		
		echo  microtime(true) - $statr;
		
		$this->render("index");
	}
	
	public function testmatch() {
		
		
		$string = '<a href="" >asas</a>d
		<br>as<font color="">da
		asa<b>asas</b>
		asas
		';
		
		
		$contents = preg_replace("#\<(?!br).*?\>#", '', $string);
		var_dump($contents);
	}
}