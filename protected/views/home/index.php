<div id="google_map" style="height:90%; width:100%"></div>

<div id="nav">
	<div class="operators">
		<ul>
			<li name="share">分享</li>
			<li name="friend">好友</li>
			<li name="message">消息</li>
			<li name="say">说点</li>
		</ul>
	</div>
</div>

<div id="content">
	
	<!--分享-->
	<div id="share" class="share">
		<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
			<a class="bds_qzone"></a>
			<a class="bds_tsina"></a>
			<a class="bds_tqq"></a>
			<a class="bds_renren"></a>
			<a class="bds_t163"></a>
			<span class="bds_more"></span>
			<a class="shareCount"></a>
		</div>
	</div>
	
	<!--好友-->
	<div id="friend" class="friend">
		<div class="friend_group">
			<div class="friend_group_name">分组1</div>
			<ul>
				<li>11</li>
				<li>22</li>
				<li>33</li>
			</ul>
		</div>
		<div class="friend_group">
			<div class="friend_group_name">分组2</div>
			<ul>
				<li>44</li>
				<li>55</li>
			</ul>
		</div>
		<div class="friend_group">
			<div class="friend_group_name">分组3</div>
			<ul>
				<li>66</li>
			</ul>
		</div>
	</div>
	
	<!--消息-->
	<div id="message" class="message"></div>
	
	<!--说点-->
	<div id="say" class="say"></div>
</div>

<div id="input_speak" class="input_speak">
	<input type="hidden" name="longitude" value="">
	<input type="hidden" name="latitude" value="">

	<div class="speak_alert">
		温馨提示：您说的话只会在地图上保留24小时, <br>
		拖动红色标记可改变说话位置
	</div>
	标题：<input type="text" name="title" value="" class="ibox"><br>
	内容：<input type="text" name="content" value="" class="ibox"><br>
	<input type="submit" value="提交" id="submit_speak"> <input type="submit" value="取消" id="cancel_speak">
</div>


<div id="image_list" style="display:none"></div>
<script type="text/javascript">
	var socketConnectString = "<?php printf("http://%s:%s", Yii::app()->params->socketHost, Yii::app()->params->socketPort);?>";
	$(function() {
		document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?" + Math.ceil(new Date()/3600000);
	});
</script>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=1843748" ></script>
<script type="text/javascript" id="bdshell_js"></script>

<link rel="stylesheet" type="text/css" href="/static/js/fancybox/jquery.fancybox-1.3.4.css">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeTbbaUbaoslV0OY-Jyoex6kfMBXRRIZk&sensor=false&libraries=panoramio"></script>
<script type="text/javascript" src="/static/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="/static/js/socket.io/socket.io.js"></script>
<script type="text/javascript" src="/static/js/map.js"></script>
<script type="text/javascript" src="/static/js/sns.js"></script>
<script type="text/javascript" src="/static/js/nav.js"></script>
<script type="text/javascript" src="/static/js/home.js"></script>