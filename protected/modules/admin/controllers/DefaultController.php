<?php
class DefaultController extends Controller {
	private $allowType = array('gif', 'png', 'jpg');
	
	public function actionIndex() {
		$this->render('index');
	}
	
	public function actionPicture() {
		if(isset($_POST, $_POST['submit'])) {
			if($_POST['id']) {
				$this->modifyPic($_POST);
			} else {
				if(!isset($_FILES) || empty($_FILES) || $_FILES['error'] != 0) {
					throw new Exception('File submission failed!');
				}
				
				$this->addPic($_POST, $_FILES['file']);
			}
			$this->redirect('/admin/default/picture');
			Yii::app()->end();
		}
		
		$this->render('addPicture');
	}
	
	// 修改图片信息
	private function modifyPic($info) {
		$model = LarkPicture::model()->findByPk($info['id']);
		
		if($model && !empty($model)) {
			if(!empty($info['title'])) $model->'title' = $info['title'];
			if(!empty($info['tag'])) $model->'tag' = $info['tag'];
			if(!empty($info['desc'])) $model->'desc' = $info['desc'];
			
			$model->save();
		}
	}
	
	// 添加 图片
	private function addPic($info, $file) {
		$img = Image::getInstance();
		
		$path = $img->uploadFile($file);
		$imageInfo = $img->getImageInfo($path['path']);
		$thumb = $img->mkImageThumb($path['dir'], $path['name'].'.'.$path['ext']);
		
		$imgHash = ImageHash::getInstance();
		$hash = $imgHash->getImageHash($thumb);
		
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