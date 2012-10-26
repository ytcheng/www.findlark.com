<h3>HOME PAGE</h3>

<div id="box">
	<span id="content"></span>
	
	<span id="cursor">▂</span>
</div>


<script type="text/javascript" src="/static/js/home.js"></script>
<script type="text/javascript">
	
	setInterval(function() {
		if($("#cursor").is(":visible")) {
			$("#cursor").hide();
		} else {
			$("#cursor").show();
		}
	}, 500);
	
</script>