//var io = require('socket.io').listen(9091, '64.34.253.111'),
var io = require('socket.io').listen(80),
		redis = require("redis"),
		client = redis.createClient(6379, '127.0.0.1'),
		socketList = {}; // 连接的用户列表
		connectCount = 0, // 当前连接数
		maxConnect = 100; // 允许最大连接数

io.sockets.on('connection', function (socket) {
	if(connectCount > maxConnect) return false;
	++connectCount;
	
	socketList[socket.id] = socket;
	console.log("connect:"+socket.id);

	socket.on('disconnect', function () {
		delete socketList[socket.id];
		--connectCount;
		console.log("disconnect:"+socket.id);
	});
	
	firstConnectMsg();
});

// 给第一次连接 的用户发送消息
function firstConnectMsg() {
	var msg = '{"title":"Hello. Click me!", "content":"Hello, Do you want to say something?"}';

	send(msg);
}

// 广播，给每个连接上的客户端 发送消息
function send(msg) {
	msg = formatMsg(msg);
	if(!msg) return run();

	for(var k in socketList) {
		socketList[k].emit("news", msg);
	}
	
	run();
}

/*
 * 将字符串消息 格式化 为 JSON 消息，失败时返回 false
 * @param String msg JSON 格式字符串
 * @return JSON Object OR false
 */
function formatMsg(msg) {
	try{
		msg = JSON.parse(msg);
	} catch(e) {
		console.log(e);
		return false;
	}
	var date = new Date();
	msg.time = date.toLocaleTimeString();

	var defaultMsg = {
		title: '',
		content: '',
		icon:'say',
		author: '',
		latitude: 0,
		longitude: 0,
		time: 0
	};
	
	for(var k in msg) {
		defaultMsg[k] = msg[k];
	}
	return defaultMsg;
}

/*
 * 从 redis 队列中取消息进行发送，
 * 利用 redis 的阻塞队列
 */
var maxBlockTime = 15; // 最长阻塞时间 (s)
function run() {
	console.log("run");
	client.brpop("findlark_msg", maxBlockTime, function(err, msg) {
		console.log(err);
		console.log(msg);
		if(msg && msg[1]) {
			send(msg[1]);
		} else {
			run();
		}
	});
}

run();