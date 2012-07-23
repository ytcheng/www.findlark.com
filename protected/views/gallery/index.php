<div class="show-image" id="show-image" style="display:none">
	<div class="close-bar" id="close-bar">
		<div class="close-button"></div>
	</div>
	
	<div class="center-box">
		<div class="image-box" id="image-box">
			
		</div>
		
		<div class="comment-box" style="display:none">
			<div class="comment">
				<div class="comment-title">ÆÀÂÛ(12)</div>
				<div class="comment-content">111</div>
			</div>
			<div class="image-info">
				<div class="info-title">Í¼Æ¬ÏêÇé</div>
				<div class="info-content">222</div>
			</div>
		</div>
		
		<div class="prev-bar" id="prev-bar"><div class="prev-button" style="display:none"></div></div>
		<div class="next-bar" id="next-bar"><div class="next-button" style="display:none"></div></div>
		<div class="clear"></div>
	</div>
	
	<div class="bottom-bar">
		
	</div>
</div>
<div class="main" id="main">
	<div class="image-list" id="image-list">
		<ul class="odd">
		</ul>
		
		<ul class="even">
		</ul>
		<div class="clear"></div>
	</div>
</div>

<script type="text/javascript" src="/static/js/gallery.js"></script>
<script type="text/javascript">
	$(function () {
		
		var player = new ImagePlayer();
		player.init();
		
		var list = new ImageList();
		list.init();
		
		$("#image-list img").live('click', function() {
			player.openPlayer(this);
		});
	});
</script>