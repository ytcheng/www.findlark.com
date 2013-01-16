mysql = require("mysql");

mysql.createConnection({
	host: 'localhost',
	port: 3306,
	user: 'fx',
	password: 'qw12ER#$',
	database: 'fx_findlark'
}).connect(function(err) {
  if(err) throw err;
});


connection = mysql.createConnection('mysql://fx:qw12ER#$@localhost:3306/fx_findlark').connect(function(err) {
  if(err) throw err;
});

