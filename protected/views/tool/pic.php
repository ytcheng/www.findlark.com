<script type="text/javascript" src="<?php echo Yii::app()->params->staticUrl;?>/js/jquery.colorbox-min.js">
</script>
<link href="<?php echo Yii::app()->params->staticUrl;?>/css/colorbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$(function(){
		$("a[rel=pics]").colorbox({opacity:'0.6', maxWidth:"80%"});
		$("a[rel=pics1]").colorbox({opacity:'0.6', maxWidth:"80%"});
	});
</script>

<div class="tab_content">
  <!--游戏介绍开始-->
  <div class="game_intro" style="display:none;"></div>
  <!--游戏介绍结束-->
  <!--游戏截图开始-->
  <div class="game_jietu">
    <ul class="tushs">
    	<?php foreach($pics as $k=>$v) { ?>
    	<li>
	      <p class="tupics"><span class="tupnds"><a href="<?php echo $v['thumb'][0];?>" rel="pics" title="<?php echo $v['title'];?>"><img src="<?php echo $v['thumb'][2];?>" width="253" border="0" /></a></span></p>
	      <p class="tuzis"><a href="<?php echo $v['thumb'][0];?>" rel="pics1" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></p>
	    </li>
    	<?php } ?>
    </ul>
    <div class="clear"></div>
    <div class="pagenumQu">
      <ul  class="yiiPager">
        <li class="first"><a href="<?php echo Yii::app()->createUrl('about/pic', array('page'=>($page - 1)));?>">上一页</a></li>
       	<?php
       	for($i = 1; $i <= $page_count; $i++) {
       		$selected = $i == $page ? ' selected' : '';
       		echo '<li class="page'.$selected.'"><a href="'.Yii::app()->createUrl('about/pic', array('page'=>$i)).'">'.$i.'</a></li>';
       	}
       	?>
        <li class="last"><a href="<?php echo Yii::app()->createUrl('about/pic', array('page'=>($page + 1)));?>">下一页</a></li>
      </ul>
      <div class="clear"></div>
    </div>
  </div>
  <!--游戏截图结束-<div class="game_vedio" style="display:none;"></div><!--游戏视频结束-->
</div>