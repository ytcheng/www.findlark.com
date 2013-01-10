<style>
	.page_area{text-align:center;margin:25px 0 15px;color:#555;}
	.page_area a{color:#555;}
	.page_num a{display:inline-block;width:19px;height:19px;line-height:19px;background-position:0 -208px;margin:0 5px 0 0;}
	.page_num a.selected{background:none;font-weight:bold;}
	
	table{width:100%}
	table td, table th{text-align:center; height:22px; line-height:22px;}
	table th{background-color:#09f; color:#f5f5f5}
</style>

<?php if(isset($data['page'])) { ?>
<div class="page_area">
	<?php
	if(isset($_GET['page'])) unset($_GET['page']);
	$url .= '?'.http_build_query($_GET);
	?>
	共<?php echo $data['pageCount'];?>页/<?php echo $data['count'];?>条记录
	<a href="<?php echo $url.'&page=0';?>" class="firstPage">首页</a>
	<a href="<?php echo $url.'&page='.($data['page']-1);?>" class="prevPage">上一页</a>
	<span class="page_num">
		<?php
		$start = $data['page'] > 5 ? $data['page']-5 : 1;
		$end = min($start + 10, $data['pageCount']);
		for($i = $start; $i <= $end; $i++) {
			echo '<a href="'.$url.'&page='.$i.'"'.($i == $data['page'] ? ' class="selected"' : '').'>'.$i.'</a>';
		}
		?>
	</span>
	<a href="<?php echo $url.'&page='.($data['page']+1);?>" class="nextPage">下一页</a>
	<a href="<?php echo $url.'&page='.$data['pageCount'];?>" class="endPage">末页</a>
</div>
<?php } ?>