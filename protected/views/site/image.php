<style>
	body{border:1px solid #222}
	.image_content{margin:10px 10px 0px 10px; position:relative;}
	#operator{height:20px; line-height:20px;}
</style>

<div class="image_content">
	<div id="image_list">
		<?php
		foreach($data as $item) {
			printf("<div><img src=\"/static/images/image_bg.gif\" data=\"%s\" style=\"display:none\"></div>\n", $item->src);
		}
		?>
	</div>
	<div id="operator">
		<a href="javascript:;" id="prev">prev</a> |
		<a href="javascript:;" id="next">next</a>
	</div>
</div>
<div id="loading"></div>

<script type="text/javascript">
	$(function() {
		
		init();
		
		
	});
	
	// fancybox-wrap
	// fancybox-content
	
	var i = 0;
	function init() {
		var obj = $("#image_list img").eq(i);
		
		obj.attr("src", obj.attr("data"));
		
		obj.load(function() {
			var imgWidth = $(this).width(), imgHeight = $(this).height();
			var winWidth = imgWidth + 20, winHeight = imgHeight+30;
			
			$(window.parent.window.document).find(".aui_state_focus").css({"width":winWidth+"px", "height":winHeight+"px"});
			
			$(this).show();
		});
	}
</script>