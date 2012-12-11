<?php
class ToolController extends Controller {
	public function beforeAction($action) {
		session_start();
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
		if(Yii::app()->request->isPostRequest) {
			$this->addTool();
			$this->redirect('/tool');
		}
		
		$this->render('index');
	}
	
	private function addTool() {
		$file = $_FILES['file'];
		$title = $_POST['title'];
		
		$dir = realpath( dirname(__FILE__).'/../../extends').'/'.time();
		mkdir($dir);
		$fullPath = $dir.'/'.$file['name'];
		if(!@ move_uploaded_file($file['tmp_name'], $fullPath)) {
			shell_exec('unzip '.$fullPath);
			$command = sprintf('cd %s; chown www:www -R *; chmod +x -R *;', $dir);
			shell_exec($command);
		}
	}
}