var share = {
	nowShareObj:new Object,

	init: function () {
		var _this = this;
		$(".blog .add-share").bind("mouseover", function() {
			_this.nowShareObj = this;
			_this.showShare();
		});

		$("#share-box a").bind("click", function() {
			_this.doShare(this);
		});
		$("#share-box").bind("mouseout", function () {
			$(this).hide();
		}).bind("mouseover", function() {
			$(this).show();
		});
	},

	showShare: function () {
		var ofs = $(this.nowShareObj).offset();
		ofs.left = ofs.left-14;
		ofs.top = ofs.top-16;
		$("#share-box a.share").html($(this.nowShareObj).html());
		$("#share-box").css({"top":ofs.top+"px", "left":ofs.left+"px"}).show();
	},

	doShare: function(me) {
		var stype = $(me).attr("class"),
				originalObj = $(this.nowShareObj).siblings(".original");
				surl = originalObj.attr("href"),
				stitle = "Blog-FX | "+originalObj.attr("alt"),
				spic = originalObj.attr("imgSrc") || "",
				bloghome = "http://www.vimyself.com",
				u = encodeURIComponent(surl),
				t = encodeURIComponent(stitle),
				p = encodeURIComponent(spic),
				openUrl = false;

		switch(stype){
			case "qqt":
				t=encodeURIComponent('#' + stitle);
				su=encodeURIComponent(bloghome);
				openUrl = 'http://v.t.qq.com/share/share.php?title='+t+'&url='+u+'&source=1000012&site='+su+'&pic='+p;
				break;
			case "qzone":
				var content = {
					url:surl,
					desc:"我在FX的博客("+bloghome+")阅读了这篇文章，觉得不错，分享给大家 .^_^.",
					title:stitle,
					summary:$(this.nowShareObj).parent("div").siblings("div[name=summary]").html() || "Blog-FX",
					site:'FX的博客 '+bloghome,
					pics:spic
				};
				var s = [];
				for(var i in content) {
					s.push(i + '=' + encodeURIComponent(content[i]||''));
				}
				openUrl = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?'+s.join('&');
				break;
			case "renren":
				openUrl = 'http://share.renren.com/share/buttonshare.do?link='+u+'&title='+t+'source=&sourceUrl=';
				break;
			case "douban":
				openUrl = 'http://www.douban.com/recommend/?url='+u+'&title='+t;
				break;
			case "sinat":
				openUrl = 'http://service.weibo.com/share/share.php?url='+u+'&appkey=&title='+t+'&pic='+p+'&ralateUid=&language=zh_cn';
				break;
		}
		this.noteShareLog(stype);
		openUrl && window.open(openUrl, "_blank");
	},

	noteShareLog: function(stype) {
		
		
	},
	
	addFavorite: function (me) {
		var ftype = $(me).attr("ftype"),
				fid = $(me).attr("fid");
		$.post();
	}

};

$(function() {
	share.init();
})
