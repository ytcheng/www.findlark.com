<div id="header">
	<div class="header-middle">
		<div id="header-logo"><!--a href="/">FindLark.</a--></div>
		<div class="header-nav" id="header-nav">
			<ul>
				<li class="current"><a href="/home" name="home">首页</a></li>
				<li><a href="/blog" name="blog">博文</a></li>
				<li><a href="http://hi.baidu.com/findlark/item/97b9dfe6a8b1a4f5fa42ba9c" name="space">空间</a></li>
				<li><a href="/tool" name="tool">工具</a></li>
			</ul>
		</div>
		<div class="current-nav" id="current-nav"></div>
	</div>
	<div class="clear-header"></div>
</div>

<!--Main-//-->
<div class="main" id="main"><iframe src="" id="content" class="content" frameborder="no" border="0" scrolling="yes" allowTransparency="true"></iframe></div>

<script type="text/javascript" src="<?php echo Yii::app()->params->staticUrl;?>/js/index.js"></script>
<script type="text/javascript">
	$(function () {
		iObj.init();
	});
</script>

