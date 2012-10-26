<h3>发布文章</h3>
<script type="text/javascript" src="/static/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/static/kindeditor/kindeditor-min.js"></script>
<style type="text/css">

</style>

<form name="form" action="" method="post" enctype="multipart/form-data" id="blog_form">
	<input type="hidden" name="id" value="0">
	<table>
		<tr>
			<td>标题：</td>
			<td><input type="text" name="title" value=""></td>
		</tr>
		
		<tr>
			<td>标签：</td>
			<td><input type="text" name="tag" value=""></td>
		</tr>
		
		<tr>
			<td>分类：</td>
			<td>
				<input type="text" name="classify_name" value="">
				<select name="classify">
					<option value="0">请选择</option>
					<?php
					$list = LarkClassify::model()->findAll("`type`='blog'");
					foreach($list as $item) {
						echo '<option value="'.$item->id.'">'.$item->name.'</option>';
					}
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>图片：</td>
			<td><input type="text" name="pic" value=""></td>
		</tr>
		
		<tr>
			<td>简介：</td>
			<td><textarea name="summary" style="width:300px; height:80px;"></textarea></td>
		</tr>
		
		<tr>
			<td>内容：</td>
			<td><textarea id="editor_id" name="content" style="width:700px; height:300px;"></textarea></td>
		</tr>
		
		<tr>
			<td></td>
			<td><input id="submit" type="submit" name="submit" value="提交"></td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('#editor_id');
	});
	$("#blog_form").submit(function() {
		editor.sync();
		//$("#content").val(editor.html());
	});
</script>