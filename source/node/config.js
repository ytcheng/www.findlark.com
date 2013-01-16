global.config = {
	socketPort: 80, //9091
	redis:{
		port:6379,//redis端口号
		host:"127.0.0.1"//redis ip
	},
	mysql:{
		host:'192.168.137.1',
		port:3306,
		user:'fx',
		password:'fx1989',
		database:'findlark'
	},
	
	sotre_redis:{
		port:6379,//redis端口号
		host:"127.0.0.1"//redis ip
	},
	stat_sync_count:1,//统计合并同步数量，即队列中超过这么多数量就会进行一次同步
	kf_session_prefix:"session_",//客服session前缀,
	login_timeout:60,//登录超时。断线后超过这个时间没有连就清除相关数据
	user_cookie_key:"uuzu_UAUTH",//保存用户信息的cookie键
	user_query_key:"auth",
	user_session_key:"sessionid",//用户sessionid　cookie键
	kf_session_key:"sessionid",//客服sessionid　cookie键	
	games:{
		1:{name:'平台'},
		2:{name:'三十六计'},
		3:{name:'十年一剑'},
		4:{name:'七十二变'},
		5:{name:'一代宗师'},
		7:{name:'大将军'},
		8:{name:'大侠传'},
		20:{name:'轩辕变'}		
	}
}