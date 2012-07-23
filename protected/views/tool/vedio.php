<script type="text/javascript" src="<?php echo Yii::app()->params->staticUrl;?>/js/jwplayer.js">
</script>
<script type="text/javascript">
	var autoplay = false;
	
	function mkVedio(img, vedio) {
		jwplayer("mediaplayer").setup({
			skin: "<?php echo Yii::app()->params->staticUrl;?>/images/flash/glow.zip",
			stretching: "fill",
			showdigits: "total",
			autostart: autoplay,
			flashplayer: "<?php echo Yii::app()->params->staticUrl;?>/images/flash/player.swf",
			image: img,
			width: 616,
			height: 397,
			file: vedio
		});
		autoplay = false;
	}
	
	function play(obj) {
		var img = obj.attr("rel");
		var vedio = obj.siblings(".btn_down").attr("href");
		var t = obj.attr("title");

		mkVedio(img, vedio);
	}

	$(function(){
		play($(".vedio_list ul li:eq(0)").find("a.btn_play"));
		
		$(".vedio_list .btn_play").bind("click", function () {
			autoplay = true;
			play($(this));
		});
		
		$(".vedio_list .vedio_bo a").bind("click", function() {
			autoplay = true;
			play($(this).parent(".vedio_bo").siblings(".vedio_btn").children(".btn_play"));
		})
		
		$(".vedio_list .vedio_tu img").bind("click", function () {
			autoplay = true;
			play($(this).parents(".vedio_tu").siblings(".vedio_btn").children(".btn_play"));
		});
	});
</script>
<div class="tab_content">
  <div class="game_vedio">
    <div class="play_game_vedio" id="play_game_vedio" style="display:">
    	<div id="mediaplayer" style="display:none"></div>
    </div>
    <div class="vedio_list">
    	<ul>
      <?php
      $list = Yii::app()->CMSApi->articleList(array('cid'=>'vedio'));
      foreach($list as $k => $v) {
      	preg_match("#http\:\/\/(.*?)\.flv#", $v['summary'], $url_match);
      	if(!$url_match || !$url_match[1]) continue;
      	$url = 'http://'.$url_match[1].'.flv';
      ?>
      <li>
			  <p class="vedio_bo"><a href="javascript:;" title="播放">播放</a></p>
			  <p class="vedio_tu">
			  	<a href="javascript:;"><img src="<?php echo $v['thumb'][3];?>" alt="播放" width="161" height="108" border="0"/></a>
			  </p>
			  <p class="vedio_btn">
			  	<a href="javascript:;" title="<?php echo $v['title'];?>" class="btn_play" rel="<?php echo $v['thumb'][2];?>"><img src="<?php echo Yii::app()->params->staticUrl;?>/images/djyx/btn_play.gif" alt="播放" /></a>
			  	<a href="<?php echo $url;?>" title="" class="btn_down"><img src="<?php echo Yii::app()->params->staticUrl;?>/images/djyx/btn_down.gif" alt="下载" /></a>
			  </p>
			</li>
      <?php	 } ?>
      <div class="clear"></div>
    	</ul>
    </div>
  </div>
  <!--游戏视频结束-->
</div>

