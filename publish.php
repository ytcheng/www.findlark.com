<?php
session_start();
if(isset($_POST['auth']) && md5($_POST['auth']) == '1') {
	$_SESSION['auth'] = true;
}

if(!isset($_SESSION['auth']) || !$_SESSION['auth']) {
	echo '
	<form action="" method="post">
	password：<input type="text" name="auth" value="" autocomplate="off">
	<input type="submit" value="LOGIN">
	</form>
	';
	exit();
}

if(isset($_POST['publish_code'])) {
	$file = $_FILES['file'];
	$path = time();
	$dir = dirname(__FILE__).'/';
	
	$fullPath = $dir.$file['name'];
	if(@ move_uploaded_file($file['tmp_name'], $fullPath)) {
		$command = sprintf('cd %s; unzip -o %s; rm -rf %s; chown www:www -R *; chmod +r -R *; chmod +x -R protected/*;', $dir, $file['name'], $file['name']);
		exec($command, $message, $return);
		echo '</pre>';
		print_r($message);
		echo $return;
		echo '<a href="">刷新</a>';
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
		<title>FindLark</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<form action="" method="post" enctype="multipart/form-data">
			文件: <input type="file" name="file"><br>
			<input type="submit" name="publish_code" value="提交">
		</form>
	</body>
</html>
