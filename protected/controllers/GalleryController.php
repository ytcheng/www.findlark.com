<?php

class GalleryController extends Controller {
	public $pageSize = 10;
	

	public function actionIndex() {
		$this->render('index');
	}
	
	public function actionList($page = 0) {
		$page = max($page, 0);
		
		$criteria = new CDbCriteria;
		
		$criteria->select = "`id`,`title`,`tag`,`desc`,FROM_UNIXTIME(timeline,'%Y-%d-%m') as timeline,`dir`,`name`,`ext`,`share_times`,`score`";
		$criteria->offset = $page * $this->pageSize;
		$criteria->limit = $this->pageSize;
		
		$list = LarkPicture::model()->findAll($criteria);
		
		echo CJSON::encode($list);
	}
	
	public function actionImage($id, $modus = 0) {
		$str = $modus < 0 ? '<' : ($modus > 0 ? '>' : '');
		
		$criteria = new CDbCriteria;
		$criteria->limit = 1;
		$criteria->compare('id', $str.$id);
		
		$image = LarkPicture::model()->find($criteria);
		
		echo CJSON::encode($image);
	}
}