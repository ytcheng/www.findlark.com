<?php
$criteria=new CDbCriteria;
$criteria->limit = 20;
$imgs = LarkPicture::model()->findAll();
?>

<div class="show-image" id="show-image" style="display:none">
	<div class="close-bar" id="close-bar">
		<div class="close-button"></div>
	</div>
	
	<div class="center-box">
		<div class="image-box" id="image-box">
			
		</div>
		
		<div class="comment-box" id="comment-box" style="">
			<div class="comment">
				<div class="comment-title">评论(12)</div>
				<div class="comment-content" style="display:none">111</div>
			</div>
			<div class="image-info">
				<div class="info-title">图片详情</div>
				<div class="info-content">
					<div id="histogram-box"></div>
					
				</div>
			</div>
		</div>
		
		<div class="prev-bar" id="prev-bar"><div class="prev-button" style="display:none"></div></div>
		<div class="next-bar" id="next-bar"><div class="next-button" style="display:none"></div></div>
		<div class="clear"></div>
	</div>
	
	<div class="bottom-bar">
		<div class="buttons">
			<div class="comment">评论</div> 
			<div class="share">分享</div>
		</div>
	</div>
</div>
<div class="main" id="main">
	<div class="image-list" id="image-list">
		<ul class="odd">
		</ul>
		
		<ul class="even">
		</ul>
		<div class="clear"></div>
	</div>
</div>

<script type="text/javascript">
	
</script>