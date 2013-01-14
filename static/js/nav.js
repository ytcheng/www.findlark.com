var larkNav = function() {
	
	
	this.nav = {};
	this.init = function() {
		var obj = $("#nav");
		
		this.nav.ofs = obj.offset();
		this.nav.width = obj.width();
		this.nav.height = obj.height();
		
	};
	
	this.init();
}

larkNav.prototype = {
	show: function(myName) {
		var obj = $("#"+myName);
		if(!obj.length) return false;
		
		obj.is(":visible") ? this.close(obj) : this.open(obj);
	},
	
	open: function(obj, callback) {
		this.closeOther($(obj).attr("class"));
		
		$(obj).css({"top":"0px", "left":this.nav.ofs.left+"px"})
		.show()
		.animate({"top":(this.nav.ofs.top+this.nav.height+4)+"px"}, 200, function() {
			
			if(callback) callback();
		});
	},
	
	close: function(obj, callback) {
		$(obj).animate({"top":"0px"}, 200, function() {
			$(this).hide();
			if(callback) callback();
		});
	},
	
	closeOther: function(myName) {
		$("#content").children("div").each(function() {
			if($(this).attr("class") != myName && $(this).is(":visible")) {
				$(this).fadeOut();
			}
		});
	}
}