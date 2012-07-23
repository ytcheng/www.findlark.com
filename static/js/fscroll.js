var Fscroll = function() {
	this.nowScrollTop = 0;		// 当前滚动条Top值
	this.nowContentTop = 0;		// 当前内容框Top值
	this.wheelHeight = 15;		// 每次鼠标滚轮滚动，调节的 滚动条 高度
	this.wheelContent = 0;		// 每次鼠标滚轮滚动，调节的 内容框 高度
	this.wheelTimes = 0;			// 滚轮滚动次数，该次数后滚动条到达顶部或者底部
	this.maxHeight = 0;				// 滚动条所能滚动的最大高度
	this.contentHeight = 0;		// 内容框高度
	this.blockHeight = 0;			// 滚动块高度
	this.scrollBoxHeight = 0; // 滚动条 盒子 高度
	
	this.scrollBox = new Object;
	this.scrollBlock = new Object;
	this.scrollContent = new Object;
	
	this.mouseDown = false;
}

Fscroll.prototype = {
	/**
	 * 初始化以及事件绑定
	 */
	init: function() {
		var _this = this;
		this.turnElement();
		
		if(this.blockHeight > this.scrollBoxHeight) {
			$(this.scrollBox).hide();
		} else {
			$(this.scrollBlock).css("height", this.blockHeight+"px");
		}
		
		$(this.scrollBlock).bind("mousedown",function(event) {
			$(this).css({"background-color":"#666"});
			
			var pageY = event.pageY,
					t = parseInt($(this).css("top"));
			$(document).mousemove(function(event2) {
				_this.nowScrollTop = t + event2.pageY - pageY;
				_this.setScrollTop();
			});
			$(document).mouseup(function() {
				$(_this.scrollBlock).css({"background-color":""});
				$(document).unbind();
			});
			return false;
		});
		
		$(this.scrollBox).mousewheel(function(event, delta, deltaX, deltaY) {
			_this.nowScrollTop -= deltaY * _this.wheelHeight
			_this.setScrollTop();
		});
		
		$(this.scrollContent).mousewheel(function(event, delta, deltaX, deltaY) {
			_this.nowScrollTop -= deltaY * _this.wheelHeight
			_this.setScrollTop();
		});
	},
	
	scrollMouseEvent: function() {
		$(this.scrollBox).bind("mouseover", function() {
			$(this).css({"border-left-width":"1px", "background-color":"#f0f0f0"});
		}).bind("mouseout", function() {
			$(this).css({"border-left-width":"0px", "background-color":"#fff"});
		});
	},
	
	/**
	 * 调节变量元素的值
	 */
	turnElement: function() {
		// 包含margin，padding，border
		this.contentHeight = $(this.scrollContent).height()
		+ parseInt($(this.scrollContent).css("padding-top")) + parseInt($(this.scrollContent).css("padding-bottom"))
		+ parseInt($(this.scrollContent).css("margin-bottom")) + parseInt($(this.scrollContent).css("margin-top"))
		+ (parseInt($(this.scrollContent).css("border-top")) || 0) + (parseInt($(this.scrollContent).css("border-bottom")) || 0);// IE 下兼容性处理
		
		this.scrollBoxHeight = $(this.scrollBox).height();
		this.blockHeight = this.scrollBoxHeight * this.scrollBoxHeight / this.contentHeight;

		this.maxHeight = this.scrollBoxHeight - this.blockHeight - 1;
		this.wheelTimes = this.maxHeight / this.wheelHeight;
		this.wheelContent = (this.contentHeight - this.scrollBoxHeight) / this.wheelTimes;
	},
	
	/**
	 * 调节Top值
	 */
	setScrollTop: function () {
		this.nowScrollTop = Math.max(1, this.nowScrollTop);
		this.nowScrollTop = Math.min(this.maxHeight, this.nowScrollTop);
		$(this.scrollBlock).css("top", this.nowScrollTop);
		
		this.nowContentTop = (this.nowScrollTop ==1 ? 0 : ++this.nowScrollTop) / this.wheelHeight * this.wheelContent * -1;
		
		$(this.scrollContent).css("top", this.nowContentTop);
	}
	
};