<?php
class NovelCommand extends CConsoleCommand {
	public $baseUrl;
	
	public function actionIndex() {
		$this->baseUrl = 'http://50.117.115.67';
		
		// <a href="read-htm-tid-3038768-search-1000-orderway-postdate-asc-DESC.html" id="a_ajax_3038768" class="subject">【我和古月凤的性事(剃毛篇)】【短篇】【jiuyaokankan】</a>
		
		for($i = 1; $i < 5; $i++) {
			$url = sprintf('%s/thread-htm-fid-58-page-%d.html', $this->baseUrl, $i);
			
			$matchUrls = Curl::model()->matchContent($url, '#\<a\s+href\="read-htm-tid-(.*?).html"\s+id\="a_ajax_[\d]+"\s+class\="subject">(.*?)\<\/a\>#');
			
			if(!$matchUrls) continue;
			
			foreach($matchUrls[1] as $key => $item) {
				$pageUrl = sprintf('%s/read-htm-tid-%s.html', $this->baseUrl, $item);
				
				$contents = Curl::model()->matchContent($pageUrl, '#\<div\s+class=".*?"\s+id\="read_tpc"\>(.*?)\<\/div\>#s');
				$contents = preg_replace("#\[\s+此帖被.*?编辑.*?$#m", '', $contents[1][0]);
				$contents = preg_replace("#\<(?!br).*?\>#", '', $contents);
				
				$matchTitle = preg_match("#【(.*?)】#", $matchUrls[2][$key], $title);
				$title = $matchTitle && $title[1] ? $title[1] : $matchUrls[2][$key];
				$title = preg_replace("#\<.*?\>#", '', $title);
				
				try{
					$model = LarkNovel::model();
					$model->id = null;
					$model->title = $title;
					$model->content = $contents;
					$model->summary = mb_substr(preg_replace("#\<.*?\>#", '', $contents), 0, 150, 'UTF8');
					$model->isNewRecord = true;
					$model->save();
				}catch(Exception $e) {
					echo var_dump($model->getErrors());
				}
			}
		}
	}
}


