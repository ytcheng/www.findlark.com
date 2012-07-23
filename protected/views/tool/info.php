<?php
$list = Yii::app()->CMSApi->articleList(array('cid'=>'info', 'offset'=>0, 'limit'=>1));
$list = array_shift($list);

$detail = Yii::app()->CMSApi->articleInfo(array('id'=> $list['id']));
?>
<div class="tab_content">
	<!--游戏介绍开始-->
	<div class="game_intro">
		<?php echo $detail['content'];?>
	</div>
	<!--游戏介绍结束-->
</div>
