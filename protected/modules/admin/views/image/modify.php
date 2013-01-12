<form action="/admin/image/modify">
	标题：<input type="text" value="<?php echo $data->title;?>" name="title">
	panoramio_id：<input type="text" value="<?php echo $data->panoramio_id;?>" name="panoramio_id">
	
	<input type="submit" value="提交">
</form>

<div>
	<img src="<?php echo $data->src;?>">
</div>