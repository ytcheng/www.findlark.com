var larkSns = function() {
	this.loginUserId = 0;
	this.firendList = {};
	
	
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