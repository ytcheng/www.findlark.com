<?php
class ToolController extends Controller {
	public function actionIndex() {
		if(Yii::app()->request->isPostRequest) {
			$this->login();
			$this->addTool();
			$this->redirect('/tool');
		}
		
		$data = LarkExtends::model()->findAll();
		$this->render('index');
	}
	
	private function addTool() {
		$file = $_FILES['file'];
		
		$dir = realpath( dirname(__FILE__).'/../../extends').'/'.time();
		mkdir($dir);
		$fullPath = $dir.'/'.$file['name'];
		if(@ move_uploaded_file($file['tmp_name'], $fullPath)) {
			shell_exec('unzip '.$fullPath);
			$command = sprintf('cd %s; chown www:www -R *; chmod +x -R *;', $dir);
			shell_exec($command);
			
			$model = LarkExtends::model();
			$model->title = Yii::app()->request->getParam('title');
			$model->isNewRequest = true;
			$model->save();
		}
	}
	
	private function login() {
		if($auth = Yii::app()->request->getPost('auth')) {
			if($auth == 'byfx0515()') Yii::app()->session->add('auth', true);
		}
		
		if(!Yii::app()->session->get('auth')) {
			Yii::app()->end();
		}
	}
}