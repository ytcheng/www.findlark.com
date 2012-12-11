function indexObject() {
	var _this = this;
	this.a = 1;
	this.b = 2;
	this.longTime = 600;
	this.shortTime = 300;
	this.currentNav = null;
	
	this.winHeight = 0;
	this.winWidth = 0;
};

indexObject.prototype = {
	
	init: function() {
		this.bindEvent();
		
		if(this.currentNav === null) {
			this.currentNav = $("#header-nav").find("a:eq(0)");
		}
		this.nav(this.currentNav);
		this.winHeight = $(window).height();
		this.winWidth = $(window).width();
		
		this.turnMainHeight();
	},
	
	// 绑定事件
	bindEvent: function() {
		var _this = this;
		
		$("#header-nav").find("a").bind("click", function () {
			$(this).blur();
			_this.nav(this);
			return false;
		});
		
		$(window).resize(function () {
			_this.winHeight = $(window).height();
			_this.winWidth = $(window).width();
			_this.turnMainHeight();
			_this.moveCurrent();
		})
		$("#content").load(function () {
			_this.afterLoading();
		});
	},
	
	turnMainHeight: function () {
		var headerH = $("#header").height() + parseInt($("#header").css('top'));
		var mainHeight = this.winHeight - headerH;
		
		if($.browser.msie && $.browser.version < 9) {
			mainHeight -= 2;
		}
		
		//$("#header-bg").css('height', headerH+'px');
		$("#main").css({"height": mainHeight+"px"});
		$("#content").css({"height":mainHeight+"px"});
	},
	
	/**
	 * 在Iframe 中加载链接
	 * @param url 需要加载的链接
	 */
	loading:function(url) {
		//var loadBg = $("#loading-bg");
		//loadBg.fadeTo(this.shortTime, 0.8);
		//loadBg.children(".loading-icon").css({"top":10 + "px", "left":(loadBg.width() - 40) / 2 + "px"});
		$("#content").attr("src", url);
	},
	
	afterLoading:function() {
		return;
		// $("#loading-bg").fadeOut(this.longTime);
		
		var contentHeight = $(document.getElementById('content').contentWindow.document.body).height()+15;
		contentHeight = Math.max($("#main").height(), contentHeight);
		$("#content").css({"height":$("#main").height()+"px"});
	},
	
	/**
	 * 导航条切换
	 */
	nav:function(obj) {
		this.currentNav = obj;
		this.moveCurrent(true);
		
		$("#header-nav li.current").removeClass("current");
		$(this.currentNav).parent("li").addClass("current");
		
		var url = $(this.currentNav).attr("href");
		this.loading(url);
	},
	
	/**
	 * 移动当前页表示
	 */
	moveCurrent: function(showAnimate) {
		showAnimate = showAnimate || false;
		
		var topOfs = $(".header-middle").offset(), navOfs = $(this.currentNav).offset();
		var ofsLeft = navOfs.left - 5 - topOfs.left;
		
		showAnimate ? $("#current-nav").animate({"left":ofsLeft+"px"}, this.shortTime) : 
		$("#current-nav").css({"left":ofsLeft+"px"});
	},
	
	/**
	 * 隐藏头部
	 */
	hiddenHeader: function() {
		var headerH = $("#header").height()+1;
		var _this = this;
		
		$("#main").css({"overflow":"hidden", "height": this.winHeight+"px"});
		$("#content").css({"height":($("#content").height()+headerH)+"px"});
		$("#header").animate({'top':-headerH+'px'}, 400, function() {
			_this.turnMainHeight();
		});
		$("#header-bg").animate({'height':0+'px'}, 400);
	},
	
	/**
	 * 显示头部
	 */
	showHeader: function() {
		var headerH = $("#header").height()+1;
		var _this = this;
		$("#header").animate({'top':'0px'}, 100, function() {
			$("#content").css({"height":($("#content").height()-headerH)+"px"});
			_this.turnMainHeight();
		});
		$("#main").css("overflow", "auto");
		$("#header-bg").animate({'height':headerH+'px'}, 100);
	}
}

var iObj = new indexObject();
