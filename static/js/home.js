var map, sns, nav;

$(function() {
	map = new larkMap;
	sns = new larkSns;
	nav = new larkNav;

	var winHeight = $(window).height(), winWidth = $(window).width();

	$("#google_map").css({"height":winHeight+"px"});
	
	try{
		var geolocationError = function(err) { // 定位失败
			console.log(err);
			map.getPositionSuccess = false;
			map.showGoogleMap();
		},
		geolocationSuccess = function(data) { // 定位成功
			map.position.latitude = data.coords.latitude;
			map.position.longitude = data.coords.longitude;
			map.getPositionSuccess = true;
			map.defaultZoom = 8;
			map.showGoogleMap();
		};
		
		navigator.geolocation.getCurrentPosition(geolocationSuccess, geolocationError);
	}catch(e) {
		map.showGoogleMap();
	}
	
	// 导航切换
	$("#nav .operators li").click(function() {
		if($(this).attr("class") == "current") {
			$(this).removeClass();
		} else {
			$("#nav .operators li.current").removeClass();
			$(this).addClass("current");
		}
		nav.show($(this).attr("name"));
	});
	
	$("#friend .friend_group_name").live("click", function() {
		$(this).siblings("ul").slideToggle(300);
	});
	
	// 显示我要说
	$("div.speak a").live("click", function() {
		var obj = $("#input_speak"), h = obj.height(), w = obj.width(), l = (winWidth-w-2) / 1;
		
		if(obj.is(":hidden")) {
			obj.css({"top":(h*-1 - 2)+"px", "left":l+"px"}).show().animate({"top":"0px"}, 300);
			
			map.showDragMark('<div style="color:#E93D12; margin-top:10px;">你将在这里说话，<br>想改变位置吗？只需要托我过去~</div>', function(e){
				$("input[name=latitude]").val(e.latLng.Ya);
				$("input[name=longitude]").val(e.latLng.Za);
			});
		}
		
		return false;
	});
	
	// 提交我要说
	$("#submit_speak").click(function() {
		sns.sendSpeak();
		return false;
	});
	
	// 取消
	$("#cancel_speak").click(function() {
		map.hideDragMark();
		
		var obj = $("#input_speak"), h = obj.height();
		obj.animate({"top":(h*-1 - 2)+"px"}, 300, function() {
			$(this).hide();
		});
	});
	
	$("div.mark_content a").live("click", function() {
		$(this).attr("target", "_blank");
		return true;
	});
	
	$(".info_window_div a.thumb_image").live("click", function() {
		$("#image_list a:eq(0)").trigger("click");
		return false;
	});
	
	// 用户相关
	$("#user_reg_button").click(function() {
		$.ajax({
			url: "/site/reg",
			data: $('#user_reg_form').serialize(),
			type: "post",
			dataType: "json",
			success: function(data) {
				console.log(data);
			},
			error: function() {
				
			}
		});
	})
});