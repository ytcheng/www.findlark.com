var position = {latitude: 31.1, longitude:104.3}, mapZoom = 5;
var map; // google map 对象

function _error(err) {
	console.log(err);
	showMap();
}

function _location(p) {
	console.log(p);
	position.latitude = p.coords.latitude;
	position.longitude = p.coords.longitude;
	
	mapZoom = 8;
	showMap();
}

function showMap() {
	var mapTypes = ['ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN'];
	
	var mapOptions = {
		center: new google.maps.LatLng(parseFloat(position.latitude), parseFloat(position.longitude)),
		zoom: mapZoom,
		//mapTypeId: google.maps.MapTypeId.HYBRID
		mapTypeId: google.maps.MapTypeId[mapTypes[3]]
	};
	map = new google.maps.Map(document.getElementById("google_map"), mapOptions);
	
	var panoramioLayer = new google.maps.panoramio.PanoramioLayer();
	panoramioLayer.setUserId('7046414');
	//panoramioLayer.setUserId(46655109);
	//panoramioLayer.setTag('摄影');
	
	//panoramioLayer.setOptions({suppressInfoWindows:true});
	panoramioLayer.setMap(map);
	
	google.maps.event.addListener(panoramioLayer, 'click', function(event) {
		event.infoWindowHtml = '<div id="info_window_div">'
			+ '<div style="font-size:14px; font-weight:700">'+event.featureDetails.title+'</div>'
			+ '<div style="margin:5px 0px; width:240px; height:160px; overflow:hidden"><a href="javascript:;" class="thumb_image">'
			//+ '<img src="https://mw2.google.com/mw-panoramio/photos/small/'+event.featureDetails.photoId+'.jpg"></a></div>'
			+ '<img src="http://static.panoramio.com.storage.googleapis.com/photos/small/'+event.featureDetails.photoId+'.jpg"></a></div>'
			
			+ '<div style="height:20px;">'
			+ '<div style="float:left"><a href="'+event.featureDetails.url+'" target="_blank"><img src="https://maps.gstatic.com/intl/en_us/mapfiles/iw_panoramio.png"></a></div>'
			//+ '<div style="float:right"><a href="https://www.panoramio.com/user/7046414" target="_blank">'+event.featureDetails.author+'</a>'
			+ '<div style="float:right"><a href="http://hi.baidu.com/findlark" target="_blank">FindLark</a>'
			+ '</div></div>';
			
		loadImageList('/site/image/pid/'+event.featureDetails.photoId);
		// small: https://mw2.google.com/mw-panoramio/photos/small/84493955.jpg
	});
	
	google.maps.event.addListener(map, 'click', function(event) {
    console.log(event);
  });
	
	afterMapLoad();
}

// 加载图片列表
function loadImageList(url) {
	$.get(url, {}, function(data) {
		var html = '';
		for(var i in data) {
			html += createImageHtml(data[i]);
		}
		$("#image_list").html(html);
		
		$("#image_list a").fancybox({
			cyclic:true,
			speedOut: 10,
			transitionOut:'none'
		});
	}, 'json');
}

function createImageHtml(data) {
	var t = data.title == null ? '' : data.title;
	
	return '<a href="'+data.src+'" rel="rel_'+data.panoramio_id+'" title="'+t+'">'+data.panoramio_id+'</a>';
}

// 地图加载完成之后
function afterMapLoad() {
	
	loadMark();
}

// 加载标记
function loadMark() {
	$.get('/site/mark', {}, function(data) {
		for(var i in data) {
			addMark(data[i]);
		}
	}, 'json');
}

function addMark(data) {
	var myLatlng = new google.maps.LatLng(parseFloat(data.latitude), parseFloat(data.longitude));
	//var myLatlng = new google.maps.LatLng(31.1, 111.1);
	
	var infowindow = new google.maps.InfoWindow({
    content: data.content
	});
	
	var marker = new google.maps.Marker({
	    position: myLatlng,
	    map: map,
	    title: data.title
	});
	
	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map, marker);
	});
	
	console.log(data);
}

$(function() {
	var winHeight = $(window).height(), winWidth = $(window).width();
	$("#google_map").css({"height":winHeight+"px"});
	
	try{
		var r = navigator.geolocation.getCurrentPosition(_location, _error);
		console.log(r);
	}catch(e) {
		showMap();
	}

	$("#info_window_div a.thumb_image").live("click", function() {
		$("#image_list a:eq(0)").trigger("click");
		return false;
	});
});
