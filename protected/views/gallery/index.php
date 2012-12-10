<?php
$criteria=new CDbCriteria;
$criteria->limit = 20;
$list = LarkPicture::model()->findAll($criteria);
?>

<div class="gallery" id="main">
	<div class="image-list" id="image-list">
		<?php
		foreach($list as $img) {
			$originalSrc = $img->dir.$img->name.'.'.$img->ext;
			$src = $img->dir.'/thumb/thumb_200_0_'.$img->name.'.'.$img->ext;
			$height = $img->height * 200 / $img->width;
			printf('<div class="img" style="display:none"><a href="%s" class="played"><img data-original="%s" src="/static/images/image_bg.gif" width="200" height="%d"></a><div class="desc"></div></div>',
				$originalSrc, $src, $height);
		}
		?>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->params->staticUrl;?>/js/imageLoader.js"></script>
<script type="text/javascript">
	$(function() {
		$("#image-list").masonry({
			isAnimated: false,
			singleMode: true,
			isFitWidth: true,
			itemSelector: '.img'
		});
		
		var imgObj = new ImageList();
		imgObj.set({container:$("#image-list")});
		setTimeout(function(){
			imgObj.init();
		}, 200);
	});
</script>