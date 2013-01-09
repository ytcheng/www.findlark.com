<form action="" method="post">
	标题:<input type="text" name="title"><br>
	路径:<input type="text" name="path"><br>
	
	<input type="submit" value="提交">
	
	ALTER TABLE `lark_extends` CHANGE `path` `path` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
</form>