var broadcast = function() {
	this.socketList = {}; // 连接的用户列表
	this.connectCount = 0; // 当前连接数
	this.maxConnect = 100; // 允许最大连接数
	
	this.maxBlockTime; // redis 最长阻塞时间 (s)
}

broadcast.prototype = {
	firstConnectMsg: function() {
		var msg = '{"title":"Hello. Click me!", "content":"Hello, Do you want to say something?"}';

		this.send(msg);
	},
	
	// 发送广播
	send: function(msg) {
		msg = this.formatMsg(msg);
		if(!msg) return this.run();
	
		for(var k in this.socketList) {
			this.socketList[k].emit("news", msg);
		}
		
		this.run();
	},
	
	// 格式化消息
	formatMsg: function(msg) {
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
}

// 运行
broadcast.prototype.run = function() {
	var _this = this;
	redisClient.brpop("findlark_msg", _this.maxBlockTime, function(err, msg) {
		if(msg && msg[1]) {
			_this.send(msg[1]);
		} else {
			_this.run();
		}
	});
}

broadcast.prototype.listenEvent = function(socket) {
	if(this.connectCount > this.maxConnect) return false;
	++this.connectCount;
	
	this.socketList[socket.id] = socket;
	console.log("connect:"+socket.id);
	
	var _this = this;
	socket.on('disconnect', function () {
		delete _this.socketList[socket.id];
		--_this.connectCount;
		console.log("disconnect:"+socket.id);
	});
	
	this.firstConnectMsg();
}

module.exports = new broadcast();