<?php
class ImageController extends Controller {
	
	public function actionIndex() {
		$data = LarkImage::model()->getList();
		
		$this->render('index', array('data'=>$data));
	}
	
	public function actionAdd() {
		
		$request = Yii::app()->request;
		if($request->isPostRequest) {
			$model = LarkImage::model();
			$model->attributes = $request->getParam('Form');
			$model->id = null;
			$model->isNewRecord = true;
			$model->save();
			
			$this->redirect('/admin/image/index');
		}
		
		$this->render('add');
	}
	
	public function actionDel($id) {
		LarkImage::model()->deleteByPk($id);
		$this->redirect('/admin/image/index');
	}
	
}