<link rel="stylesheet" type="text/css" href="/static/js/fancybox/jquery.fancybox-1.3.4.css">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeTbbaUbaoslV0OY-Jyoex6kfMBXRRIZk&sensor=false&libraries=panoramio"></script>
<script type="text/javascript" src="/static/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<div id="google_map" style="height:90%; width:100%"></div>

<div id="image_list" style="display:none"></div>
<div id="input_speak" class="input_speak">
	经度：<input type="text" name="longitude" value=""><br>
	纬度：<input type="text" name="latitude" value=""><br>
	标题：<input type="text" name="title" value=""><br>
	内容：<input type="text" name="content" value="">
	<input type="submit" value="提交" id="submit_speak"> <input type="submit" value="取消" id="cancel_speak">
</div>
<script src="/static/js/socket.io/socket.io.js"></script>
<script type="text/javascript" src="/static/js/home.js"></script>