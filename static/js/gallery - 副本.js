var baseUrl = "http://www.findlark.com";

// 图片播放
var ImagePlayer = function () {
	this.doc = parent.document;
	this.win = parent.window;
	
	this.imgObjectList = {}; // 缓存图片对象列表
	this.imageInfo = {}; // 缓存图片信息列表
	this.nowImageId = 0;
};

ImagePlayer.prototype = {
	
	init: function () {
		//this.turnSize();
		this.bindEvent();
	},
	
	bindEvent: function() {
		var _this = this;
		
		// 按键事件
		$(window).keydown(function(event) {
			// Esc
			if(event.which == 27) {
				_this.closePlayer();
			}
		});
		
		$("#show-image-box").click(function() {
			_this.openPlayer();
		});
		 
		// 关闭
		$("#close-bar, #close-bar .close-button").mouseover(function() {
			$("#close-bar .close-button").addClass("close-button-hover");
		}).mouseout(function() {
			$("#close-bar .close-button").removeClass("close-button-hover");
		}).click(function() {
			_this.closePlayer();
		});
		
		// 上一张
		var autoTime;
		$("#prev-bar, #prev-bar .prev-button").live("mouseover", function() {
			$("#prev-bar .prev-button").show();
		}).mouseout(function() {
			$("#prev-bar .prev-button").hide();
		}).click(function() {
			_this.getImage(_this.nowImageId, 1);
		});
		
		// 下一张
		$("#next-bar, #next-bar .next-button").mouseover(function() {
			$("#next-bar .next-button").show();
		}).mouseout(function() {
			$("#next-bar .next-button").hide();
		}).click(function() {
			_this.getImage(_this.nowImageId, -1);
		});
		
		$("#image-box img").live("click", function() {
			_this.getImage(_this.nowImageId, -1);
		})
		$(window).resize(function() {
			_this.turnSize();
		});
	},
	
	/**
	 * 
	 */
	turnSize: function () {
		mainHeight = $(this.doc).height();
		mainWidth = $(this.doc).width();
		$("#show-image").css({"height":mainHeight+"px"});
		
		$("#main").css({"margin-left":Math.max(0, (mainWidth - 960 - 5) / 2)+"px"});
		$("#prev-bar .prev-button, #next-bar .next-button").css("margin-top", mainHeight * 0.38 + "px");
	},
	
	showAllImage: function () {
		
	},
	
	showComment: function () {
		
		
	},
	
	addComment: function () {
		
	},
	
	hideComment: function () {
		
	},
	
	closePlayer: function () {
		window.parent.iObj.showHeader();
		
		this.turnSize();
		$("#show-image").fadeOut(300);
	},
	
	/**
	 * 打开图片播放器
	 * @param imgObject 图片对象
	 */
	openPlayer: function (imgObject) {
		this.showImage(imgObject);
		
		var sTop = $(this.doc).find("#main").scrollTop();
		window.parent.iObj.hiddenHeader();
		this.turnSize();
		$("#show-image").css({"top":sTop+"px"}).fadeIn(400);
	},
	
	showImage: function(imgObj) {
		var imgId = $(imgObj).attr("index");
		this.getImage(imgId, 0);
	},
	
	/**
	 * AJAX 获取图片
	 * @param imageId 需要获取的图片ID
	 * @param modus >0 获取ID值大于当前ID 的一张，<0 反之，等于0获取当前ID 图片
	 */
	getImage: function(imgId, modus) {
		var _this = this;
		
		$.get("/gallery/detail", {id:imgId, modus:modus}, function(data) {
			if(data == null) {
				alert('已经是最后一张了~');
				_this.showAllImage();
				return false;
			}
			
			_this.nowImageId = data.id;
			if(typeof _this.imgObjectList[data.id] == "undefined") {
				var imgSrc = baseUrl+data.dir+data.name+'.'+data.ext;
				img = $('<img src="'+imgSrc+'">');
				_this.imgObjectList[data.id] = img;
			}

			_this.putImage(data);
		}, 'json');
	},
	
	/**
	 * 输出图片，
	 * @param imgId 图片ID
	 */
	putImage: function (data) {
		var imgObj = this.imgObjectList[data.id],
			imgHeight = data.height,
			imgWidth = data.width;

		$(imgObj).css({"width":imgWidth+"px", "height":imgHeight+"px"}).hide();
		$("#image-box").html($(imgObj));
		
		eval("var histogram="+data.histogram);
		this.createImageHistogram(histogram.r, histogram.valve, "rgba(0,0,0,1)");
		this.turnImageSize();
	},
	
	// 调整图片大小
	turnImageSize: function() {
		var imgObj = $("#image-box img"),
			maxHeight = $(this.win).height() - 120,
			maxWidth = $("#comment-box").is(":visible") ? $(this.win).width() - 370 : $(this.win).width() - 80,
			imgHeight = $(imgObj).height(),
			imgWidth = $(imgObj).width();
		
		if(imgHeight > maxHeight) {
			imgWidth = imgWidth * maxHeight / imgHeight;
			imgHeight = maxHeight;
		}
		if(imgWidth > maxWidth) {
			imgHeight = imgHeight * maxWidth / imgWidth;
			imgWidth = maxWidth;
		}
		
		$(imgObj).css({"width":imgWidth+"px", "height":imgHeight+"px", "margin-top":(maxHeight-imgHeight)/2+"px", "margin-left":(maxWidth-imgWidth+80)/2+"px"}).show();
	},
	
	/**
	 * 绘制直方图
	 * @param data
	 * @param color RGB 颜色
	 * @param valve 阀值
	 */
	createImageHistogram: function(data, valve, color) {
		$("#histogram-box").empty().append('<canvas id="imageHistogram" width="256" height="100"></canvas>');
		var canvas = document.getElementById('imageHistogram');
		try{
			if(!canvas.getContext('2d')) {
				$("#histogram-box").remove();
				return;
			}
		} catch(e){
			return false;
		};
		
		var ctx = canvas.getContext('2d');
		var canvasHeight = canvas.height;
		ctx.globalCompositeOperation = 'lighter';

		ctx.beginPath();
		ctx.strokeStyle = color;
		for(var k in data) {
			if(data[k] == 0 || !/^\d+$/.test(k)) continue;
			var max = Math.min(data['max'], valve);
 			ctx.moveTo(k, canvasHeight);
 			var to = canvasHeight - Math.min(data[k], max) / max * canvasHeight;
 			ctx.lineTo(k, Math.round(to));
		}
		ctx.stroke();
	}
};

var ImageList = function() {
	this.oddHieght = 0;	// 统计第一列高度
	this.evenHieght = 0;	// 统计第二列高度
	this.imageCount = 0;	// 统计当前页面图片数量
	this.page = 0; //页码
	
	this.doc = parent.document;
	this.win = parent.window;
	this.defaultImgSrc = '/static/images/image_bg.gif';
	this.loadList = [];
	this.imageListData = [];
};

ImageList.prototype = {
	init: function() {
		var _this = this;
		
		//this.mkImageList(imgList);
		this.bindEvent();
		this.getImageList();
	},
	
	bindEvent: function() {
		var _this = this;
		
		$(this.doc).find("#main").scroll(function() {
			
			
			_this.loadImage();
		});
	},
	
	/**
	 * 生成单个 li 标签HTML代码，每生成一个标签， 照片统计+1
	 * @param data 列表数据 JSON
	 * return HTML
	 */
	mkLi: function(data) {
		var imgSrc = baseUrl+data.dir+'thumb/thumb460_'+data.name+'.'+data.ext;
		var html = '<li><img src="'+this.defaultImgSrc +'" imgSrc="'+imgSrc+'" index="'+data.id+'" width="460"></li>';
		return html;
	},
	
	/**
	 * 生成图片列表
	 * @param list 图片列表数据 JSON
	 */
	mkImageList: function(list) {
		for(var k in list) {
			var html = this.mkLi(list[k]);
			
			if(this.oddHieght <= this.evenHieght) {
				
				this.oddHieght += list[k].height*1;
				$("#image-list .odd").append(html);
			} else {
				this.evenHieght += list[k].height*1;
				$("#image-list .even").append(html);
			}
		}
		
		this.mkLoadList();
		this.loadImage();
	},
	
	// 记录需要 延时加载的图片对象
	mkLoadList: function() {
		var _this = this;
		
		$("#image-list img[src='"+this.defaultImgSrc+"']").each(function(k) {
			_this.loadList[k] = $(this);
		});
	},
	
	/**
	 * 根据滚动条位置加载图片
	 */
	loadImage: function() {
		var nowTop = $(this.doc).find("#main").scrollTop() + $(this.win).height();
		
		for(var k in this.loadList) {
			if(typeof this.loadList[k] === "undefined") break;
			
			var obj = $(this.loadList[k]), ofs = obj.offset();
			if(ofs.top < nowTop) {
				obj.attr("src", obj.attr("imgSrc"));
				delete this.loadList[k];
			}
		}
		this.loadList.sort();
	},
	
	/**
	 * 获取图片列表，没获取一次，page+1
	 */
	getImageList: function() {
		var _this = this;
		
		$.get('/gallery/list', {page:_this.page}, function(data) {
			_this.mkImageList(data);
		}, 'json');
		
		this.page++;
	}
	
};