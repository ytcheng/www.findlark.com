<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params->staticUrl;?>/css/blog.css">
<script type="text/javascript" src="<?php echo Yii::app()->params->staticUrl;?>/js/share.js">
</script>

<div class="blog">
	<div class="blog-list" id="blog-list">
		<!--
		<div class="blog-box">
			<div class="blog-title">
				<a href="">那一年，沉寂在美好的回忆里</a>
			</div>
			<div class="blog-info">
				<span>分类：<a href="">浮生闲谈</a></span>
				<span>标签：<a href="">我的</a>,<a href="">吃饭</a></span>
				<span>日期：2012-09-03 21:15</span>
				<span>浏览：131</span>
			</div>

			<div class="blog-summary" name="summary">
				我的博文描述我的博文描述我的博文描述我的博文描述我的博文描述我
				的博文描述我的博文描述我的博文描述我的博文描述我的博文描述我的博文描述
				的博文描述我的博文描<br>述我的博文描述我的博文<br>描述我的博文描<br>述我的博文描述
				的博文描述我的博文描述我的博文描<br>述我的博文描述我的博文描述我的博文描述
			</div>
			<div class="blog-operation">
				<a href="http://www.ibyfx.com/12113.html" class="original" alt="那一年，沉寂在美好的回忆里" imgSrc="">原文</a> <span class="split-line">|</span>
				<a href="" class="add-comment">点评(2)</a> <span class="split-line">|</span>
				<a href="javascript:;" class="add-favourite" ftype="article" fid="3415">喜欢(12)</a> <span class="split-line">|</span>
				<a href="javascript:;" class="add-share">分享(3)</a>
			</div>
		</div>
		
		<div class="blog-box">
			<div class="blog-title">
				<a href="">那一年，沉寂在美好的回忆里</a>
			</div>
			<div class="blog-info">
				<span>分类：<a href="">浮生闲谈</a></span>
				<span>标签：<a href="">我的</a>,<a href="">吃饭</a></span>
				<span>日期：2012-09-03 21:15</span>
				<span>浏览：131</span>
			</div>

			<div class="blog-summary">
				我的博文描述我的博文描述我的博文描述我的博文描述我的博文描述我
				的博文描述我的博文描述我的博文描述我的博文描述我的博文描述我的博文描述
				的博文描述我的博文描<br>述我的博文描述我的博文<br>描述我的博文描<br>述我的博文描述
				的博文描述我的博文描述我的博文描<br>述我的博文描述我的博文描述我的博文描述
			</div>
			<div class="blog-operation">
				<a href="">原文</a> <span class="split-line">|</span>
				<a href="" class="add-comment">点评(2)</a> <span class="split-line">|</span>
				<a href="javascript:;" class="add-favourite">喜欢(12)</a> <span class="split-line">|</span>
				<a href="javascript:;" class="add-share">分享(3)</a>
			</div>
		</div>
		
		<div class="blo
		-->
	</div>
	
	<div class="blog-sidebar">
		<form action="" method="get" id="blog-search-form" onsubmit="">
			<input type="text" name="s" value="">
			<input type="submit" name="submit" value="查询">
		</form>
		
		<div>
			博文归档
			
		</div>
	</div>
	
	<div style="clear:both"></div>
</div>

<div id="share-box">
	<p>
		<a class="share">分享()</a>
		<a class="qqt" href="javascript:;">腾讯微博</a>
		<a class="qzone" href="javascript:;">QQ空间</a>
		<a class="renren" href="javascript:;">人人网</a>
		<a class="douban" href="javascript:;">豆瓣</a>
		<a class="sinat" href="javascript:;">新浪微博</a>
	</p>
</div>
<script type="text/javascript">
	var baseUrl = 'http://www.findlark.com';
	
	$.ajax({
		url:'/blog/list?<?php echo http_build_query($_GET);?>',
		type:'get',
		data:'',
		dataType:'json',
		success: function(data) {
			var html = '', item = '', tag = '';
			for(var k in data) {
				item = data[k];
				tag = '';
				for(var i in item.tag) {
					tag += '<a href="'+baseUrl+'/blog/index/tag/'+item.tag[i]+'">'+item.tag[i]+'</a>&nbsp;';
				}
				
				html = '<div class="blog-box">'+
					'<div class="blog-title">'+
						'<a href="'+baseUrl+'/blog/'+item.id+'.html">'+item.title+'</a>'+
					'</div>'+
					'<div class="blog-info">'+
						'<span>分类：<a href="'+baseUrl+'/blog/index/classify/'+item.classify_id+'">'+item.classify_name+'</a></span>'+
						'<span>标签：'+tag+'</span>'+
						'<span>日期：'+item.timeline+'</span>'+
					'</div>'+
					'<div class="blog-summary" name="summary">'+item.summary+'</div>'+
					'<div class="blog-operation">'+
						'<a href="'+baseUrl+'/blog/'+item.id+'.html" class="original" alt="'+item.title+'">原文</a> <span class="split-line">|</span>'+
						'<a href="javascript:;" class="add-comment">点评('+item.comment_count+')</a> <span class="split-line">|</span>'+
						'<a href="javascript:;" class="add-share">分享</a>'+
					'</div>'+
				'</div>';
				
				$("#blog-list").append(html);
			}
			
		},
		error: function() {
			alert('failed');
		}
	});
</script>