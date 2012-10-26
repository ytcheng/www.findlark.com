var ImageList = function() {
	this.page = 0; //页码
	this.loadList = [];
	this.imageListData = [];
	this.allowAjax = true;
	this.isMax = false;
	
	this.opts = {
		defaultImgSrc: '/static/images/image_bg.gif',
		container: $("body"),
		imageGetUrl: '/gallery/list',
		scrollBox: 'main',
		baseUrl: ''
	};
};

ImageList.prototype = {
	init: function() {
		this.bindEvent();
		this.getImageList();
	},
	
	set: function(options) {
		for(var k in options) {
			if(typeof this.opts[k] != "undefined") this.opts[k] = options[k];
		}
	},
	
	bindEvent: function() {
		var _this = this;
		
		$(window).scroll(function() {
			_this.loadImage();
			var r = $(document).height() - $(this).scrollTop() - $(this).height();
			
			if(r < 200) {
				_this.getImageList();
			}
		});
	},
	
	/**
	 * 生成单个 li 标签HTML代码，每生成一个标签， 照片统计+1
	 * @param data 列表数据 JSON
	 * return HTML
	 */
	mkHtml: function(data) {
		var originalSrc = this.opts.baseUrl+data.dir+data.name+'.'+data.ext;
		var thumbSrc = this.opts.baseUrl+data.dir+'thumb/thumb_200_0_'+data.name+'.'+data.ext;
		var imgHeight = data.height * 200 / data.width;
		
		var html = '<div class="img" style="display:none">'
		+ '<a href="'+originalSrc+'" index="'+data.id+'" class="played">'
		+ '<img data-original="'+thumbSrc+'" src="/static/images/image_bg.gif" width="200" height="'+imgHeight+'">'
		+ '</a>'
		+ '<div class="desc"></div>'
		+ '</div>';
		
		return html;
	},
	
	/**
	 * 生成图片列表
	 * @param list 图片列表数据 JSON
	 */
	mkImageList: function(list) {
		var _this = this;
		
		for(var k in list) {
			var html = this.mkHtml(list[k]), $boxes = $(html);
			$(this.opts.container).append($boxes).masonry('appended', $boxes);
		}
		
		$(".played").colorbox({
			rel: "played",
			maxWidth: '95%',
			maxHeight: '95%',
			opacity: 0.35,
			photo: true
		});

		setTimeout(function() {
			_this.mkLoadList();
			_this.loadImage();
		}, 200);
	},
	
	// 记录需要 延时加载的图片对象
	mkLoadList: function() {
		var _this = this;
		
		$(this.opts.container).find("img[src='"+this.opts.defaultImgSrc+"']").each(function(k) {
			_this.loadList[k] = $(this);
		});
	},
	
	/**
	 * 根据滚动条位置加载图片
	 */
	loadImage: function() {
		var nowTop = $(window).scrollTop() + $(window).height();
		
		for(var k in this.loadList) {
			if(typeof this.loadList[k] === "undefined") break;
			
			var obj = $(this.loadList[k]), ofs = obj.offset();
			if(ofs.top < nowTop) {
				obj.parents(".img:eq(0)").show();

				// obj.attr("src", obj.attr("data-original"));
				delete this.loadList[k];
			}
		}
		this.loadList.sort();
	},
	
	/**
	 * 获取图片列表，没获取一次，page+1
	 */
	getImageList: function() {
		if(this.isMax == true || this.allowAjax == false) return;
		this.allowAjax = false
		
		var _this = this;
		$.ajax({
			url: this.opts.imageGetUrl,
			data: {page:this.page},
			dataType: "json",
			success: function(data) {
				if(data.length == 0) {
					_this.isMax = true;
					return false;
				}
				_this.mkImageList(data);
				_this.allowAjax = true;
			},
			error: function() {
				this.allowAjax = true;
			}
		});
		this.page++;
	}
};