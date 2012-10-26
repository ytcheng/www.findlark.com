<div id="header">
	<div class="header-middle">
		<div id="header-logo"><!--a href="/">FindLark.</a--></div>
		<div class="header-nav" id="header-nav">
			<ul>
				<li class="current"><a href="/home">首页</a></li>
				<li><a href="/blog">博文</a></li>
				<li><a href="/gallery">图集</a></li>
				<li><a href="/tool">工具</a></li>
			</ul>
		</div>
		<div class="current-nav" id="current-nav"></div>
	</div>
	<div class="clear-header"></div>
</div>

<div class="header-bg" id="header-bg"></div>

<!--Main-//-->
<div class="main" id="main"><iframe src="/home" id="content" class="content" frameborder="no" border="0" scrolling="yes" allowTransparency="true"></iframe></div>

<!--载入中背景-//-->
<div class="loading-bg" id="loading-bg" style="display:none">
	<div class="loading-icon">
		<img src="/static/images/loading.gif">
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->params->staticUrl;?>/js/index.js"></script>
<script type="text/javascript">
	$(function () {
		iObj.init();
	});
</script>