<h3>添加图片</h3>

<form name="form" action="" method="post" enctype="multipart/form-data">
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
			<td>图片：</td>
			<td><input type="file" name="file" value=""></td>
		</tr>
		
		<tr>
			<td>描述：</td>
			<td><textarea name="desc"></textarea></td>
		</tr>
		
		<tr>
			<td><input type="submit" name="submit" value="提交"></td>
			<td></td>
		</tr>
	</table>
</form>