<?php if(Yii::app()->session->get('auth')) { ?>
	<form action="/tool" method="post" enctype="multipart/form-data">
		文件: <input type="file" name="file"><br>
		标题：<input type="text" name="title" value="test gallery"><br>
		
		<input type="submit" value="提交">
	</form>
<?php } ?>
<div>
	<?php
	$list = LarkExtends::model()->findAll();
	foreach($list as $item) {
		printf('<a href="%s/extends/%s">%s</a>', Yii::app()->params->baseUrl, $item->path, $item->title);
	}
	?>
</div>

