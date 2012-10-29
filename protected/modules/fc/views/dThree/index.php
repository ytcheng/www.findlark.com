<style>
	body{font-size:12px; color:#333;}
	table{border:1px solid #777; font-size:12px; color:#333; margin-bottom:5px; width:400px;}
	
	th{background-color:#1c76d0; color:#fff}
	tr.odd{background-color:#e0eefb}
	td, th{width:40px;}
	
</style>

<div>
	
	<!--form action="/fc/dThree/import" method="post" enctype="multipart/form-data">
		<input type="file" value="" name="file">
		<input type="submit" name="提交">
	</form-->
	
</div>
<div>
	
	<?php
	echo '<b>n1:</b>'.$this->getTable(1);
	echo '<b>n2:</b>'.$this->getTable(2);
	echo '<b>n3:</b>'.$this->getTable(3);
	?>
	<div id="total">
		
	</div>
</div>
<script type="text/javascript" src="/static/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
	var total = [0,0,0,0,0,0,0,0,0,0];
	
	$("table").each(function() {
		$(this).find("tr.odd td").each(function(i) {
			var tdVal = $(this).html();
			total[i] = total[i]*1 + tdVal*1;
		});
	});
	
	var table = $("table:eq(0)").clone().empty().html('<tr class="odd"></tr>');
	$("#total").append(table);
	for(var i in total) {
		$("#total").find("tr").append("<td>"+(total[i]/3).toFixed(2)+"</td>");
	}
	
	$("table").each(function() {
		var maxVal = 0, maxObj;
		var minVal = 100, minObj;
		
		$(this).find("tr.odd td").each(function(i) {
			var tdVal = $(this).html()*1;
			
			if(tdVal > maxVal) {
				maxVal = tdVal;
				maxObj = this;
			}
			
			if(tdVal < minVal) {
				minVal = tdVal;
				minObj = this;
			}
		});
		
		$(maxObj).css("color", "red");
		$(minObj).css("color", "#ff0");
	});
</script>