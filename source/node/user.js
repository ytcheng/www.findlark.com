//var io = require('socket.io').listen(9092, '64.34.253.111'),
var io = require('socket.io').listen(80),
		cookie = require('cookie'),
		redis = require("redis"),
		client = redis.createClient(6379, '127.0.0.1'),
		users = {};

io.of("/user").authorization(function(handshakeData, callback) {
	if(!handshakeData.headers.cookie) {
		return callback("cookie is null!", false);
	}
	
	var cookies = cookie.parse(handshakeData.headers.cookie);
	if(!cookies.uid) {
		return callback("Login status error!", false);
	}
	
	handshakeData.cookies = cookies;
	callback(null, true);
}).on('connection', function(socket) {
	//console.log(socket.handshake.cookies);
	var uid = socket.handshake.cookies.uid;
	users[uid] = socket;
	
	console.log(uid);
	
	socket.on('disconnect', function () {
		delete users[uid];
		console.log("disconnect:"+uid);
	});
	
	socket.on("chat", function(data) {
		console.log(data);
		users[data.toUid].emit("news", {time:"12121", title:data.msg});
	});
});

