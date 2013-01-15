var larkUser = function() {
	this.userInfo = null;
	
	
	this.init = function() {
		var _this = this;
		
		$.get('/site/login', {}, function(data) {
			//map.init();
			nav.init();
			sns.init();
			
			if(data.error == 0) {
				_this.loginSuccess(data);
			} else {
				_this.bindEvent();
			}
		}, 'json');
	};
}

larkUser.prototype = {
	// 登录
	login: function(obj) {
		var _this = this;
		
		$(obj).publicAjaxPost({
			url:'/site/login',
			formId:'user_login_form',
			successCall: function(data) {
				_this.loginSuccess(data);
				$.fn.closePublicBox(0);
			},
			showSuccessMsg: false,
		});
	},
	
	// 注册
	reg: function(obj) {
		var _this = this;
		
		$(obj).publicAjaxPost({
			url:'/site/reg',
			formId:'user_reg_form',
			successCall: function(data) {
				_this.loginSuccess(data);
			},
			showSuccessMsg: false
		});
	},
	
	// 登录成功
	loginSuccess: function(data) {
		this.userInfo = data.params;
		if($.trim(this.userInfo.nickname) == '') this.userInfo.nickname = this.userInfo.email;
		
		$.cookie('uid', this.userInfo.uid);
		
		if(nav.lastName != null) $("#nav .operators li[name="+nav.lastName+"]").trigger("click");
		sns.loginSuccess();
	}
};

larkUser.prototype.bindEvent = function() {
	var _this = this;
	// 用户相关
	$("#user_reg_button").click(function() {
		_this.reg(this);
		return false;
	});
	
	// 刷新验证码
	$("img.reg_captcha").click(function() {
		$.get("/site/captcha/refresh/1", {}, function(data) {
			$("img.reg_captcha").attr("src", data.url);
		}, "json");
	});
	
	$("#user_login_button").click(function() {
		_this.login(this);
	});
	
}