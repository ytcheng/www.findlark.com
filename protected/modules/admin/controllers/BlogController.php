<?php
class BlogController extends Controller {
	
	function actionAdd() {
		
		if(!empty($_POST)) {
			empty($_POST['id']) ? $this->addBlog() : $this->modifyBlog();
			$this->redirect('/admin/blog/add');
			Yii::app()->end();
		}
		
		$this->render('add', array('data' => $data));
	}
	
	private function addBlog() {
		$model = LarkBlog::model();
		
		$model->attributes = array(
			'title'=> $_POST['title'],
			'tag'=> $_POST['tag'],
			'classify'=> $this->getClassify(),
			'pic'=> $_POST['pic'],
			'content'=> $_POST['content'],
			'summary'=> $_POST['summary'],
			'timeline'=> time()
		);
		
		$model->setIsNewRecord(true);
		if(!$model->save()) {
			throw new Exception('Save failed'.var_export($model->getErrors(), true));
		}
	}
	
	private function modifyBlog() {
		
	}
	
	private function getClassify() {
		if($_POST['classify'] != 0) return $_POST['classify'];
		if(trim($_POST['classify_name']) == '') return 1;
		
		$model = LarkClassify::model();
		$model->name = trim($_POST['classify_name']);
		$model->type = 'blog';
		$model->setIsNewRecord(true);
		if(!$model->save()) {
			throw new Exception('Save failed'.var_export($model->getErrors(), true));
		}
		return $model->id;
	}
	
	
	
	
}