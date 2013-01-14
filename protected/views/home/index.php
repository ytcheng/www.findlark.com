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
			<div class="friend_group_name">分组1 <span>[7/15]</span></div>
			<ul>
				<li>11</li>
				<li>22</li>
				<li>33</li>
			</ul>
		</div>
		<div class="friend_group">
			<div class="friend_group_name">分组2 <span>[6/13]</span></div>
			<ul>
				<li>44</li>
				<li>55</li>
			</ul>
		</div>
		<div class="friend_group">
			<div class="friend_group_name">分组3 <span>[1/22]</span></div>
			<ul>
				<li>66</li>
			</ul>
		</div>
	</div>
	
	<!--消息-->
	<div id="message" class="message">
		<div id="reg" class="reg">
			<form action="/site/reg" method="post" id="user_reg_form">
				<table>
					<tr>
						<td class="reg_item">邮箱地址：</td>
						<td class="reg_detail"><input type="text" name="RegForm[email]" value="" class="RegForm_email"></td>
						<td class="reg_info"></td>
					</tr>
					<tr>
						<td class="reg_item">登录密码：</td>
						<td class="reg_detail"><input type="password" name="RegForm[password]" value="" class="RegForm_password"></td>
						<td class="reg_info"></td>
					</tr>
					<tr>
						<td class="reg_item">再次输入：</td>
						<td class="reg_detail"><input type="password" name="RegForm[repeat]" value="" class="RegForm_repeat"></td>
						<td class="reg_info"></td>
					</tr>
					<tr>
						<td class="reg_item">昵称：</td>
						<td class="reg_detail"><input type="text" name="RegForm[nickname]" value="" class="RegForm_nickname"></td>
						<td class="reg_info"></td>
					</tr>
					<tr>
						<td class="reg_item">验证码：</td>
						<td class="reg_detail"><input type="text" name="RegForm[verifycode]" value="" class="RegForm_verifycode"></td>
						<td class="reg_info"><img src="/site/captcha" style="height:24px;"></td>
					</tr>
					<tr>
						<td colspan="3">
							<input type="button" value="注册" id="user_reg_button">
							<a href="javascript:;" class="user_login">登录</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
		
	</div>
	
	<!--说点-->
	<div id="say" class="say">
		<div id="login" class="login">
			<form action="/site/login" method="post">
				<table>
					<tr>
						<td>邮箱：</td>
						<td><input type="text" name="email" value=""></td>
					</tr>
					<tr>
						<td>密码：</td>
						<td><input type="password" name="password" value=""></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="button" value="登录">
							<a href="javascript:;" class="user_reg">注册</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
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