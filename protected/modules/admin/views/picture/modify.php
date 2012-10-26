<h3>修改图片</h3>

<form name="form" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $data->id;?>">
	<table>
		<tr>
			<td>标题：</td>
			<td><input type="text" name="title" value="<?php echo $data->title;?>"></td>
		</tr>
		
		<tr>
			<td>标签：</td>
			<td><input type="text" name="tag" value="<?php echo $data->tag;?>"></td>
		</tr>
		
		<tr>
			<td>描述：</td>
			<td><textarea name="desc"><?php echo $data->desc;?></textarea></td>
		</tr>
		
		<tr>
			<td>图片：</td>
			<td><img src="<?php echo $data->dir.'/thumb/thumb460_'.$data->name.'.'.$data->ext;?>"></td>
		</tr>
		
		<tr>
			<td><input type="submit" name="submit" value="提交"></td>
			<td></td>
		</tr>
	</table>
</form>