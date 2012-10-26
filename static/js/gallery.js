// 弹窗
function prompt(win){
	var _this = this;
	this.win = win || window;
	this.init = function(content, callback){
		this.callback = callback;
		var content = content,
			getTop = this.win.document.body || this.win.documentElement,
			// 获取容器
			container = typeof content == 'string' ? $(content).appendTo(getTop).hide() :
				(content instanceof jQuery ? content : $(content)).clone(true).appendTo(getTop).hide();
		// 检测容器是否存在。
		if(!container.length) {
			throw new Error('Empty object');
			return;
		}
		// 绑定给对象
		this.container = container;
		return this;
	}
	this.layout = function(callback) {
		if(!this.container){
			throw new Error('Must be init');
			return;
		}
		typeof callback === "function" && callback(this);
		return this;
	}
	this.show = function() {
		// 布局这个浮层的位置。
		var ofs = this.getOffset();
		
		this.container.css({
			position:'absolute',
			left: ofs.left,
			top: ofs.top,
			display:'block',
			zIndex:1000000
		});
		this.backgroundObj = background({opacity:0.5}).show();
		typeof this.callback === 'function' && this.callback(this);
	}
	this.hide = function(){
		this.container.hide();
		background().hide();
	}
	this.remove = function(){
		this.container && this.container.remove();
		this.container = null;
	}
	
	// 获取浮动层的偏移量
	this.getOffset = function() {
		var ofs = {}, doc = $(_this.win);
		
		ofs.left = Math.max(0, doc.scrollLeft() + (doc.width() - $(this.container).width()) / 2),
		ofs.top = Math.max(0, doc.scrollTop() + (doc.height() - $(this.container).height())/2 - 40);
		return ofs;
	}
	
	// 监控 window 对象的 resize 事件
	$(this.win).resize(function() {
		var ofs = _this.getOffset();
		$(_this.container).css({"left": ofs.left+"px", "top": ofs.top+"px"});
	});
}

function background(o) {
	var o = o || {},
		zIndex = o.zindex || 999999,
		width = Math.max(document.body.clientWidth || document.documentElement.clientWidth) + 'px',
		height = Math.max(document.body.clientHeight || document.documentElement.clientHeight) + 'px',
		iframe = !$('#backgroundBoardId').length ? $('<iframe id="backgroundBoardId" scrolling="no" frameborder="0" \
			style="overflow:hidden; \
			position:absolute; \
			background:#000; \
			z-index:'+zIndex+'; \
			width:'+width+'; \
			left:0; \
			top:0; \
			height:'+height+'; \
			display:none" src="http://pic.uuzu.com/one/js/bck.htm"></iframe>').appendTo(document.body || document.documentElement).css('opacity',(o.opacity || .7))
			: $('#backgroundBoardId').css({width:width,height:height});
	return iframe;
}

/**
 * 图片播放器
 */
var imgPlayer = {
	control:true,
	imgLen:0,
	newImgId:-1,
	imgObj: new Object,

	// 初始化
	init:function (obj) {
		this.imgObj = obj;
		this.imgLen = this.imgObj.length;
		var _this = this;

		this.imgObj.unbind("click").bind("click", function () {
			pop.showPic($(this).attr("title"), $(this).attr("data-imgSrc"));
			_this.newImgId = $(this).parents("li").index();

			$("#pop_tuku_bar .to-next").unbind("click").bind("click", function () {
				_this.toNext();
			});
			$("#pop_tuku_bar .to-prev").unbind("click").bind("click", function () {
				_this.toPrev();
			});
			$("#pop_tuku_bar .pt_pics img").unbind("click").bind("click", function () {
				_this.toNext();
			});

			_this.loading();
			return false;
		});
	},

	// 上一张
	toPrev:function () {
		if(!this.control) {
			return;
		}
		this.control = false;

		var nextId = this.newImgId - 1 >= 0 ? this.newImgId - 1 : this.imgLen - 1;
		this.newImgId = nextId;

		$("#pop_tuku_bar .pt_pics img:eq(0)").attr("src", this.imgObj.eq(nextId).attr("data-imgSrc"));
		$("#pop_tuku_bar .pt_nms").html(this.imgObj.eq(nextId).attr("title"));
		this.loading();
		this.control = true;
	},

	// 下一张
	toNext:function() {
		if(!this.control) {
			return;
		}
		this.control = false;

		var nextId = this.newImgId + 1 >= this.imgLen ? 0 : this.newImgId + 1;
		this.newImgId = nextId;
		

		$("#pop_tuku_bar .pt_pics img:eq(0)").attr("src", this.imgObj.eq(nextId).attr("data-imgSrc"));
		$("#pop_tuku_bar .pt_nms a").html(this.imgObj.eq(nextId).attr("title"));
		this.loading();
		this.control = true;
	},

	// 加载
	loading:function() {
		var popObj = $("#pop_tuku_bar"), h = popObj.height(), w = popObj.width() - Math.ceil((this.newImgId + 1) / 1000000) * 34;
		popObj.children(".loadingDiv").css({"height":h+"px", "width":w+"px", "top":"0px"}).fadeIn(0);
		popObj.find(".loadingDiv img").css({"top":(h/2) + "px", "left":(w/2)+"px"});

		$("#pop_tuku_bar .pt_pics img:eq(0)").unbind("load").load(function () {
			$(this).removeAttr("style");
			var winH = $(window).height(),
					winW = $(window).width(),
					maxH = winH * 0.8,
					maxW = winW * 0.8,
					imgH = $(this).height(),
					imgW = $(this).width();

			if(imgH > maxH) {
				imgW = imgW * maxH / imgH;
				imgH = maxH;
			}
			if(imgW > maxW) {
				imgH = imgH * maxW / imgW;
				imgW = maxW;
			}
			var pLeft = $(document).scrollLeft() + (winW - imgW) / 2,
					pTop = $(document).scrollTop() + (winH - imgH) / 2;

			$(this).css({"width":imgW+"px", "height":imgH+"px"});
			popObj.find("div.tuku_left").hide();
			
			popObj.animate({"top":pTop+"px", "left":pLeft+"px", "width":(imgW+35)+"px", "height":(imgH+35)+"px"}, 500);
			popObj.find(".loadingDiv img").animate({"top":(imgH/2) + "px", "left":(imgW/2)+"px"}, 500);
			popObj.children(".loadingDiv").animate({"width":imgW+"px", "height":(imgH+35)+"px"}, 500, function () {
				//$(this).slideToggle(1000);
				$(this).animate({"height":"0px", "top":(imgH+35)+"px"}, 900);
				popObj.find("div.tuku_left").css({"width":imgW+"px", "height":(imgH+35)+"px"}).show();
			});
		});
	}
}