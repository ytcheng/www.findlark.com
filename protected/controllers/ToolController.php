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
	
	public function actionLogin() {
		$this->render('login');
	}
	
	private function addTool() {
		$file = $_FILES['file'];
		$path = time();
		$dir = realpath( dirname(__FILE__).'/../../extends').'/'.$path;
		mkdir($dir);
		$fullPath = $dir.'/'.$file['name'];
		if(@ move_uploaded_file($file['tmp_name'], $fullPath)) {
			$command = sprintf('cd %s; unzip %s; chown www:www -R *; chmod +x -R *;', $dir, $file['name']);
			shell_exec($command);
			
			$model = LarkExtends::model();
			$model->title = Yii::app()->request->getParam('title');
			$model->path = $path;
			$model->isNewRecord = true;
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