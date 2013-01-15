//var io = require('socket.io').listen(9092, '64.34.253.111'),
var io = require('socket.io').listen(80),
		redis = require("redis"),
		client = redis.createClient(6379, '127.0.0.1'),
		http = require('http'),
		users = {};

io.of('/private').authorization(function (handshakeData, callback) {
  console.dir(handshakeData);
  handshakeData.foo = 'baz';
  callback(null, true);
}).on('connection', function (socket) {
	socketList[socket.id] = socket;
	console.log("connect:"+socket.id);

	socket.on('disconnect', function () {
		delete socketList[socket.id];
		console.log("disconnect:"+socket.id);
	});
});