var larkSns = function() {
	this.loginUserId = 0;
	this.firendList = {};
	
	this.init = function() {
		
		
	};
	
	this.loginSuccess = function() {
		$("#friend .myself").html('<strong>'+user.userInfo.nickname+'</strong>').show();
		
		
		this.bindEvent();
		
	};
}

larkSns.prototype = {
	
}

larkSns.prototype.sendSpeak = function () {
	var speak = {};
	speak.latitude = $("input[name=latitude]").val();
	speak.longitude = $("input[name=longitude]").val();
	speak.content = $.trim( $("input[name=content]").val() ) ;
	speak.title = $.trim( $("input[name=title]").val() );

	if(speak.title == '' || speak.content == '') return;
	
	$.post("/site/speak", speak, function(data) {
		if(data.error == 0) {
			$("input[name=content]").val('');
			$("input[name=title]").val('');
			$("#cancel_speak").trigger("click");
		} else {
			alert(data.msg);
		}
	}, 'json');
}

larkSns.prototype.bindEvent = function() {
	
	$("#friend .friend_group_name").live("click", function() {
		$(this).siblings("ul").slideToggle(300);
	});
	
}
