<?php
class ToolController extends Controller {
	
	public function actionIndex() {
		
		$this->render('index');
	}
	
	public function actionAdd() {
		
		$request = Yii::app()->request;
		if($request->isPostRequest) {
			$model = LarkExtends::model();
			$model->id = null;
			$model->title = $request->getParam('title');
			$model->path = $request->getParam('path');
			$model->isNewRecord = true;
			$model->save();
			
			$this->redirect('/admin/tool/add');
		}
		
		$this->render('add');
	}
	
}