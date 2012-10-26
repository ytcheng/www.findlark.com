<?php

class SejieCommand extends CConsoleCommand {
	
	public function actionIndex() {
		$url = "http://50.117.115.67/thread-htm-fid-58.html";
		
		for($i = 1; $i < 100; $i++) {
			$url = 'http://sejie.wanxun.org/';
			if($i > 1) $url = $url.'page/'.$i;
			
			$pages = ImageCrawl::model()->searchPage($url, "#\<a#", 0);
			foreach($pages as $page) {
				ImageCrawl::model()->searchImg($page, "#\<img.*?src\=(?:\"|\')(.*?)(?:\"|\')#", 1);
			}
			break;
		}
	}
}




