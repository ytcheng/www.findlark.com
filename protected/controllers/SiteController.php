<?php
class SiteController extends Controller {
	
	public function actions() {
		return array(
			'proxy'=>array(
				'class'=>'common.actions.UProxyAction',
				'allowHost'=>array(
					'passport.uuzu.com',
					'api.uuzu.com',
					'cb.uuzu.com'
				)
			),
		);
	}
	
	public function actionIndex() {
		
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
}