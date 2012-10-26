<?php
class PictureController extends Controller {
	private $allowType = array('gif', 'png', 'jpg');
	
	public function actionAdd() {
		if(isset($_POST, $_POST['submit'])) {
			if(!isset($_FILES) || empty($_FILES) || $_FILES['error'] != 0) {
				throw new Exception('File submission failed!');
			}
			$this->addPic($_POST, $_FILES['file']);
			$this->redirect('/admin/picture/add');
			Yii::app()->end();
		}
		
		$this->render('add');
	}
	
	public function actionModify($id = 0) {
		if(isset($_POST, $_POST['id'], $_POST['submit'])) {
			$this->modifyPic($_POST);
			$this->redirect('/admin/picture/modify/id/'.$_POST['id']);
			Yii::app()->end();
		}
		
		$data = LarkPicture::model()->findByPk($id);
		$this->render('modify', array('data'=>$data));
	}
	
	public function actionDel($id = 0) {
		$del = LarkPicture::model()->deleteByPk($id);
		echo CJSON::encode(array('result'=>($del ? 1 : 0)));
	}
	
	// 修改图片信息
	private function modifyPic($info) {
		$model = LarkPicture::model()->findByPk($info['id']);
		
		if($model && !empty($model)) {
			if(!empty($info['title'])) $model->title = $info['title'];
			if(!empty($info['tag'])) $model->tag = $info['tag'];
			if(!empty($info['desc'])) $model->desc = $info['desc'];
			
			$model->save();
		}
	}
	
	// 添加 图片
	private function addPic($info, $file) {
		$img = ImageUpload::model();
		
		$path = $img->uploadFile($file);
		$thumb = $img->mkImageThumb($path['dir'], $path['name'].'.'.$path['ext']);
		$imageInfo = $img->getImageInfo($path['path']);
		$hash = ImageHash::model()->getImageHash($thumb);
		
		$model = LarkPicture::model();
		$model->attributes = array(
			'title'=> empty($info['title']) ? $path['name'] : $info['title'],
			'tag'=> $info['tag'],
			'desc'=> $info['desc'],
			'timeline'=> time(),
			'width'=> $imageInfo['histogram']['width'],
			'height'=> $imageInfo['histogram']['height'],
			'dir'=> str_replace(realpath(Yii::app()->basePath.'/../'), '', $path['dir']),
			'name'=> $path['name'],
			'ext'=> $path['ext'],
			'histogram'=> CJSON::encode($imageInfo['histogram']),
			'properties'=> CJSON::encode($imageInfo['properties']),
			'hash'=> $hash
		);
		
		$model->setIsNewRecord(true);
		if(!$model->save()) {
			throw new Exception('Save failed'.var_export($model->getErrors(), true));
		}
	}
}