<?php
class ImageController extends AdminController {
	
	public function actionIndex() {
		$data = $this->getList(LarkImage::model());
		
		$this->render('index', array('data'=>$data));
	}
	
	// 添加外链图片
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
	
	// 上传图片
	public function actionUpload() {
		$request = Yii::app()->request;
		if(!$request->isPostRequest) Yii::app()->end();
		
		$image = $_FILES['image'];
		if($image['error'] == 0) {
			
			$panoramio_id = $request->getParam('panoramio_id');
			$imgModel = ImageGD2_::model();
			$info = $imgModel->uploadImage($image, $panoramio_id);
			
			$model = LarkImage::model();
			$model->title = $request->getParam('title');
			$model->panoramio_id = $panoramio_id;
			$model->src = preg_replace("#^.*?/upload/(.*?)$#", '/upload/$1', $info['path']);
			$model->id = null;
			$model->isNewRecord = true;
			
			$model->save() ? $this->_end(0, '上传成功!') : $this->_end(1, $this->getModelFirstError($model));
		} else {
			$this->_end(1, '文件上传错误!');
		}
	}
	
	// 删除
	public function actionDel($id) {
		LarkImage::model()->deleteByPk($id);
		$this->redirect('/admin/image/index');
	}
	
	public function actionModify($id) {
		$data = LarkImage::model()->findByPk($id);
		if(empty($data)) {
			echo 'error';
			Yii::app()->end();
		}
		$request = Yii::app()->request;
		if($request->isPostRequest) {
			$data->title = $request->getPost("title");
			$data->panoramio_id = $request->getPost("panoramio_id");
			
			$data->save();
			$this->redirect('/admin/image/index');
		}
		
		$this->render('modify', array('data'=>$data));
		
	}
	
}