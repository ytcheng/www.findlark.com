<h3>图片上传</h3>

<div id="upload_form_list">
	<form action="/admin/image/upload" method="post" target="image_upload" enctype="multipart/form-data">
		标题：<input type="text" name="title">
		panoramio:<input type="text" name="panoramio_id">
		
		文件：<input type="file" name="image">
		
		<span class="info"></span>
	</form>
</div>


<div>
	<a href="javascript:;" id="start_upload">上传</a> - 
	<a href="javascript:;" id="add_form">增加</a> - 
	<a href="/admin/image/index">列表</a>  
</div>
<iframe name="image_upload" id="image_upload" style="border:1px solid #777; width:100%;"></iframe>

<script type="text/javascript">
	var i = 0, l = 0;
	$(function() {
		var $form = $("#upload_form_list form:eq(0)").clone();
		$("#start_upload").click(function() {
			i = 0, l = $("#upload_form_list form").length;
			submitForm();
			return false;
		});
		
		$("#add_form").click(function() {
			$("#upload_form_list").append('<br>');
			$("#upload_form_list").append($form.clone());
			return false;
		}).trigger("click").trigger("click").trigger("click");
		
		$("#image_upload").load(function() {
			var r = $(document.getElementById('image_upload').contentWindow.document).find("body").html();
			$("#upload_form_list form").eq(i-1).find(".info").html(r);
			setTimeout(function() {
				submitForm();
			}, 200);
		});
	});
	
	function submitForm() {
		if(i >= l) return false;
		$("#upload_form_list form:eq("+i+")").submit();
		i++;
	}
</script>