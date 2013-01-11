<?php
class SiteController extends Controller {
	
	public function actionIndex() {
		
		$this->layout = 'public';
		$this->render('index');
	}
	
	public function actionError() {
		if($error=Yii::app()->errorHandler->error) {
			//if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			//else
		    	//$this->render('error', $error);
		}
	}
	
	public function actionImage($pid) {
		$data = LarkImage::model()->findAll('panoramio_id='.intval($pid));
		
		echo CJSON::encode($data);
		//$this->render('image', array('data'=>$data));
	}
	
	public function actionMark() {
		$data = LarkMark::model()->findAll("1 limit 100");
		
		echo CJSON::encode($data);
	}
}