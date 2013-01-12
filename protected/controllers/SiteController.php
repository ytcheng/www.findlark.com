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
	
	public function actionSpeak() {
		$this->checkAjaxRequest();
		$request = Yii::app()->request;
		$params = array(
			'title'=> $request->getParam('title'),
			'content'=> $request->getParam('content'),
			'latitude'=> $request->getParam('latitude'),
			'longitude'=> $request->getParam('longitude')
		);
		
		$params = array_map(array($this, 'filter'), $params);
		
		$redisKey = 'findlark_msg';
		$r = Yii::app()->redis->lpush($redisKey, CJSON::encode($params));
		$this->_end(0, 'success!'.var_export($r, true));
	}
	
	public function actionMark() {
		$data = LarkMark::model()->findAll("1 limit 100");
		
		echo CJSON::encode($data);
	}
	
	private function filter($value) {
		$value = str_replace(array('\''), array("&apos;"), $value);
		$value = preg_replace("#\<\/?(?!img|br|a).*?\/?\>#", '', $value);
		return $value;
	}
}