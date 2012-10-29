<?php

class DThreeController extends Controller {
	public function actionIndex() {
		$this->layout = 'main';
		
		
		$this->render('index');
	}
	
	public function actionImport() {
		if(isset($_FILES) && !empty($_FILES)) {
			$this->import($_FILES['file']);
		}
		
		
		$this->redirect('/fc/dThree/index');
		Yii::app()->end();
	}
	
	private function import($file) {
		
		if($file['error'] == 0) {
			$fp = fopen($file['tmp_name'], 'r');
			$model = DThreeHistory::model();
			while(!feof($fp)) {
				$line = fgets($fp);
				$arr = explode(' ', $line);
				$n1 = substr($arr[2], 0, 1);
				$n2 = substr($arr[2], 1, 1);
				$n3 = substr($arr[2], 2, 1);
				
				$model->id = $arr[1];
				$model->timeline = strtotime($arr[0].' 00:00:00');
				$model->n1 = $n1;
				$model->n2 = $n2;
				$model->n3 = $n3;
				$model->isNewRecord = true;
				$model->save();
			}
		}
	}
	
	public function getTable($n) {
		$model = DThreeHistory::model();
		$criteria=new CDbCriteria;
		$criteria->select = 'count(*) as n1';
		$criteria->group = 'n'.$n;
		$counts = $model->findAll($criteria);
		$sum = $model->count();
		
		echo $sum."<br>";
		
		return $this->createTableHtml($counts, $sum);
	}
	
	private function createTableHtml($counts, $sum) {
		$html = '<table cellspacing=1 cellpadding=3>';
		$html.= '<tr>';
		for($i = 0; $i < 10; $i++) {
			$html.= sprintf('<th>%d</th>', $i);
		}
		$html.= '</tr>';
		$html.= '<tr>';
		foreach($counts as $item) {
			$html.= sprintf('<td>%d</td>', $item->n1);
		}
		$html.= '</tr>';
		$html.= '<tr class="odd">';
		foreach($counts as $item) {
			$html.= sprintf('<td>%.2f</td>', 100*$item->n1/$sum);
		}
		$html.= '</tr>';
		$html.= '</table>';
		
		return $html;
		
	}
}