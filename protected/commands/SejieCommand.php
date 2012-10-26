<?php

class SejieCommand extends CConsoleCommand {
	
	public function actionIndex() {
		$url = "http://sejie.wanxun.org/post/2012-09-25/40039413449";
		
		for($i = 1; $i < 100; $i++) {
			$url = 'http://sejie.wanxun.org/';
			if($i > 1) $url = $url.'page/'.$i;
			
			$pages = Curl::model()->matchContent($url, "#http\:\/\/sejie\.wanxun\.org\/post\/(?:\d+)-(?:\d+)-(?:\d+)\/(?:\d+)#");
			foreach($pages as $page) {
				$images = Curl::model()->matchContent($page, "#\<img.*?src\=(?:\"|\')(.*?)(?:\"|\')#");
				foreach($images as $img) {
					ImageCrawl::model()->saveImg($img);
				}
			}
			break;
		}
	}
}