<div class="extends_list">
	<ul>
	<?php
	$list = LarkExtends::model()->findAll();
	foreach($list as $key => $item) {
		printf('<li><a href="/extends/%s">%d. %s</a></li>', $item->path, $key+1, $item->title);
	}
	?>
	</ul>
</div>