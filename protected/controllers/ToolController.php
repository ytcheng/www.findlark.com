<?php
class AboutController extends Controller
{
	public $layout = 'column_about';
	public $page = 'about';
	public $tabLi = array('summary'=>'游戏介绍', 'features'=>'游戏特色', 'pics'=>'游戏截图', 'vedios'=>'游戏视频');
	public $category;
	
	public function actionSummary() {
		$this->category = 'summary';
		
		$this->render('summary');
	}
	
	public function actionFeatures() {
		$this->category = 'features';
		
		$this->render('feature');
	}
	
	public function actionPics() {
		$this->category = 'pics';
		
		$gallery = Yii::app()->CMSApi->albumList(array('cid'=>gallery));
		foreach($gallery as $k=>$v) {
			$gid = $k;
			break;
		}
		
		$page = isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
		$pageSize = 12;
		$pic_count = Yii::app()->CMSApi->imageListCount(array('album'=>$gid));
		$page_count = ceil($pic_count / $pageSize);
		$page = $page > $page_count ? $page_count : $page;
		
		$pics = Yii::app()->CMSApi->imageList(array('album'=>$gid, 'offset'=>($page - 1) * $pageSize, 'limit'=>$pageSize));
		
		$this->render('pic', array('pics'=> $pics, 'page'=> $page, 'page_count'=> $page_count));
	}
	
	public function actionVedios() {
		$this->category = 'vedios';
		$this->render('vedio');
	}

}