<?php
class MarkController extends AdminController {
	
	public function actionIndex() {
		$data = $this->getList(LarkMark::model());
		
		$this->render('index', array('data'=>$data));
	}
	
	// 添加
	public function actionAdd() {
		$request = Yii::app()->request;
		if($request->isPostRequest) {
			$model = LarkMark::model();
			$model->attributes = $request->getParam('Form');
			$model->timeline = time();
			$model->id = null;
			$model->isNewRecord = true;
			$model->save();
			
			$this->redirect('/admin/mark/add');
		}
		
		$this->render('add');
	}
	
	// 添加
	public function actionModify($id) {
		$request = Yii::app()->request;
		$data = LarkMark::model()->findByPk($id);
		if($request->isPostRequest) {
			if(!empty($data)) {
				$data->attributes = $request->getParam('Form');
				$model->timeline = time();
				$data->id = $id;
				$data->save();
			}
			
			$this->redirect('/admin/mark/index');
		}
		
		$this->render('add', array('data'=>$data));
	}
	
	// 删除
	public function actionDel($id) {
		LarkMark::model()->deleteByPk($id);
		$this->redirect('/admin/mark/index');
	}
	
}