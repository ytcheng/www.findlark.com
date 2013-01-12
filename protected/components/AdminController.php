<?php

class AdminController extends Controller {
	// 查询列表
	public $pageSize = 25;
	
	public function getList($model, $isAll = false) {
		$request = Yii::app()->request;
		$data = array('list'=>array(), 'pager'=>array());
		
		$data['filter'] = $model->getFilter($model->attributes, $isAll);
		$criteria = $model->getCriteria($data['filter']);

		$page = max($request->getParam('page', 0), 1);
		$count = $model->count($criteria);
		if($count == 0) return $data;

		$pageCount = ceil($count / $this->pageSize);
		$page = min($page, $pageCount);
		$criteria->offset = ($page - 1) * $this->pageSize;
		$criteria->limit = $this->pageSize;

		$list = $model->findAll($criteria);

		$data['pager'] = array(
			'page'=>$page,
			'count'=>$count,
			'pageCount'=>$pageCount
		);
		$data['list'] = $list;
		return $data;
	}
	
	// 创建 选择列表
	public function createSelectList($data, $params = array(), $default = null) {
		if(!is_array($data) || !is_array($params)) return '';
		
		$string = '';
		foreach($params as $key => $value) {
			$string .= sprintf(' %s="%s"', $key, $value);
		}
		
		$html = sprintf('<select%s>', $string);
		
		foreach($data as $key => $value) {
			$selected = $this->equal($key,$default) ? ' selected="selected"' : '';
			$html .= sprintf('<option value="%s"%s>%s</option>', $key, $selected, $value);
		}
		$html .= '</select>';
		return $html;
	}
	
	// 创建 选择列表数据
	public function createSelectData($model, $id, $name) {
		$data = $model->findAll('1 limit 100');
		$list = array();
		foreach($data as $item) {
			$list[$item->$id] = $item->$name;
		}
		return $list;
	}
	
	protected function equal($a, $b) {
		if(!empty($a) || !empty($b)) return $a==$b;
		
		if(( $a === 0 || $a === '0') && ($b === 0 || $b === '0')) return true;
		if(( $a === '' || $a === null) && ($b === '' || $b === null)) return true;
		return false;
	}
}