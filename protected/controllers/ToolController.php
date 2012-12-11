<?php
class ToolController extends Controller {
	public function beforeAction($action) {
		if($auth = Yii::app()->request->getPost('auth')) {
			if($auth == 'byfx0515()') Yii::app()->session->add('auth', true);
		}
		
		if(!Yii::app()->session->get('auth')) {
			$this->render('login');
			return false;
		}
		
		return parent::beforeAction($action);
	}
	
	public function actionIndex() {
		
		$this->render('index');
	}

}