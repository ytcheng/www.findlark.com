<div>
	<form action="/admin/mark/index">
		标题:<input type="text" name="title" value="<?php echo $data['filter']['title'];?>">
		内容:<input type="text" name="content" value="<?php echo $data['filter']['content'];?>">
		经度:<input type="text" name="longitude" value="<?php echo $data['filter']['longitude'];?>">
		纬度:<input type="text" name="latitude" value="<?php echo $data['filter']['latitude'];?>">
		<input type="submit" value="查询">
		<a href="/admin/mark/add">添加</a>
	</form>
</div>
<table>
	<thead>
		<tr>
			<th>作者</th>
			<th>标题</th>
			<th>经度</th>
			<th>纬度</th>
			<th width="60%">内容</th>
			<th>显示</th>
			<th>时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data['list'] as $item) { ?>
		<tr>
			<td><?php echo $item->author;?></td>
			<td><?php echo $item->title;?></td>
			<td><?php echo $item->longitude;?></td>
			<td><?php echo $item->latitude;?></td>
			<td><?php echo $item->content;?></td>
			<td><?php echo $item->display;?></td>
			<td><?php echo date('Y-m-d H:i', $item->timeline);?></td>
			<td>
				<a href="/admin/mark/modify/id/<?php echo $item->id;?>">编辑</a>
				<a href="/admin/mark/del/id/<?php echo $item->id;?>">删除</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script type="text/javascript">
	$("a[rel=image]").fancybox({
		cyclic:true,
		speedOut: 10,
		transitionOut:'none'
	});
</script>
<?php
$this->renderPartial('/_page', array('data'=>$data['pager'], 'url'=>'/admin/mark/index'));
?>