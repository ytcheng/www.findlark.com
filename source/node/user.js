var user = function() {
	this.privateKey = '10001';
	this.list = {};
	
	
};

user.prototype = {
	
	init: function() {
		
	},
	
	friendList: function(socket) {
		var uid = socket.user_id, _this = this;
		var sql = "SELECT * FROM lark_user as lu, lark_friend as lf WHERE lf.uid="+uid+" && lf.f_uid=lu.uid";
		mysqlConnection.query(sql, function(err, rows, fields) {
			if(err) rows = [];
		  
		  var callback = function(groups) {
		  	var data = {friends:rows, groups:groups};
		  	socket.emit("friend_list", data);
		  }
		  
		  _this.getFriendGroupByUid(uid, callback);
		  //console.log('The solution is: ', rows[0].solution);
		});
	},
	
	getFriendGroupByUid: function(uid, callback) {
		var sql = "SELECT * FROM lark_friend_group WHERE uid="+uid;
		mysqlConnection.query(sql, function(err, rows, fields) {
		  if(err) rows = [];
		  
		  callback(rows);
		});
	}
	
};

user.prototype.auth = function(handshakeData, callback) {
	if(!handshakeData.headers.cookie) {
		return callback("cookie is null!", false);
	}
	
	var cookies = cookie.parse(handshakeData.headers.cookie);
	if(!cookies.uid) {
		return callback("Login status error!", false);
	}
	
	handshakeData.cookies = cookies;
	callback(null, true);
};

// 用户事件监控
user.prototype.listenEvent = function(socket) {
	var _this = this,
			date = new Date(),
			nowTime = date.toLocaleTimeString();

	socket.on('disconnect', function () {
		delete users[socket.user_id];
		console.log("disconnect:"+socket.user_id);
	});
	
	// data {toUid:1, msg:1212}
	socket.on("chat", function(data) {
		if(user.list[data.toUid] && data.msg != '') {
			user.list[data.toUid].emit("chat_msg", {msg:data.msg, time:nowTime, from:socket.user_id});
			
		} else {  // 该用户不在线
			
		}
	});
	
	socket.on("friend", function(data) {
		if(data.action && typeof(_this['friend'+data.action]) == "function") {
			_this['friend'+data.action](socket);
		}
	});
	
	/*
		
		
		
	*/
};

module.exports = new user();