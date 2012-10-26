<?php

class GalleryController extends Controller {
	public $pageSize = 10;
	

	public function actionIndex() {
		$this->render('index');
	}
	
	public function actionList($page = 0) {
		$page = max($page, 0);
		
		$criteria = new CDbCriteria;
		
		$criteria->offset = $page * $this->pageSize;
		$criteria->limit = $this->pageSize;
		$criteria->order = '`id` desc';
		
		$list = LarkPicture::model()->findAll($criteria);
		echo CJSON::encode($list);
	}
	
	public function actionDetail($id, $modus = 0) {
		$str = '';
		$criteria = new CDbCriteria;
		$criteria->limit = 1;
		
		if($modus < 0) {
			$str = '<';
			$criteria->order = '`id` desc';
		} else if($modus > 0) {
			$str = '>';
			$criteria->order = '`id` asc';
		}
		
		$criteria->compare('id', $str.$id);
		
		$image = LarkPicture::model()->find($criteria);
		
		echo CJSON::encode($image);
	}
}