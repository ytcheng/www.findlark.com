var extend = function(dest, source) {
	var obj = new source;
	for(var k in obj) {
		dest.prototype[k] = obj[k];
	}
}

var baseModel = function() {
	this.loadImg = function(params) {
		var _this = this, img = new Image;
		img.src = params.src;
		img.onload = function(){
			_this.onImageLoad(img, params);
		}
	}
	
	this.onImageLoad = function(img, params) {
		var ctx = this.draw(img, params.canvasId);
		params.callback(img, ctx);
	}
	
	// 将图片绘制到 canvas 画布
	this.draw = function(img, canvasId) {
		var canvas = document.getElementById(canvasId),
				ctx = document.getElementById(canvasId).getContext('2d');
		
		canvas.height = img.height;
		canvas.width = img.width;
		
		ctx.drawImage(img, 0, 0);
		ctx.stroke();
		
		return ctx;
	}
}

var histogram = function() {};
extend(histogram, baseModel);

			
// 获取图片直方图数据
histogram.prototype.getHistogramData = function(imgData) {
	var len = imgData.length, histogramData = initData();
	histogramData.valve = len/4/64; // 阀值，取总像素的 1/64 (参考PhotoShop)

	var keys = ['gray', 'r', 'g', 'b'], k, rgb = {};
	for(var i = 0; i < len; i+=4) {
		rgb = {r:imgData[i], g:imgData[i+1], b:imgData[i+2]};
		rgb.gray = Math.round( rgb.r * 0.3 + rgb.g * 0.59 + rgb.b * 0.11 );
		
		for(var j = 0; j < 4; j++) {
			k = keys[j];
			histogramData[k][rgb[k]]++;
		}
		histogramData.rgb[rgb.r] += 1/3;
		histogramData.rgb[rgb.g] += 1/3;
		histogramData.rgb[rgb.b] += 1/3; 
	}
	
	var len = keys.push("rgb");
	for(var i = 0; i < 256; i++) {
		for(var j = 0; j < len; j++) {
			k = keys[j];
			histogramData.count[k] += histogramData[k][i];
		}
	}
	
	// 初始化直方图 数据
	function initData() {
		var histogramData = {gray:[], r:[], g:[], b:[], rgb:[]};
		for(var i=0; i < 256; i++) {
			for(var k in histogramData) {
				histogramData[k][i] = 0;
			}
		}
		histogramData.count = {gray:0, r:0, g:0, b:0, rgb:0};
		return histogramData;
	}
	
	return histogramData;
}

/**
 * 绘制直方图
 * @param Object histogramData 直方图数据
 * @param String k 键值
 * @param String color RGB颜色
 * @param String canvasId 输出画布的ID
 * @param Boolean clearRect 是否清除画布
 */
histogram.prototype.createHistogram = function(histogramData, k, color, canvasId, clearRect) {
	var canvas = document.getElementById(canvasId),
			ctx = canvas.getContext('2d'),
			canvasHeight = canvas.height,
			data = histogramData[k];
	
	if(clearRect) ctx.clearRect(0, 0, canvas.width, canvasHeight);
	
	ctx.globalCompositeOperation = 'lighter';
	ctx.beginPath();
	ctx.strokeStyle = color;
	ctx.fillStyle = color;
	var i = 0;
	ctx.moveTo(0, canvasHeight);
	for(var k in data) {
		if(data[k] == 0 || !/^\d+$/.test(k)) continue;
		var to = canvasHeight - Math.min(data[k], histogramData.valve) / histogramData.valve * canvasHeight;
		ctx.lineTo(k, Math.round(to));
	}
	ctx.lineTo(256, canvasHeight);
	ctx.fill();
}

// 计算数量 和 百分位
histogram.prototype.count = function(histogramData, k, positionX) {
	if(k == 'all') k = 'rgb';
	
	sum = 0;
	for(var i = 0; i <= positionX; i++) {
		sum += histogramData[k][i];
	}
	var ratio =(sum/histogramData.count[k]*100).toFixed(2),
			amount = Math.round(histogramData[k][positionX]);
	if(k == 'rgb') amount *= 3;
	
	return {amount:amount, ratio:ratio};
}

histogram.prototype.turnExposure = function(n) {
	n = 300;
	
	var newImgData = this.imgData, avg = 0;
	for(var i = 0; i < this.imgDataLen; i+=4) {
		// avg = Math.pow( (newImgData.data[i]+newImgData.data[i+1]+newImgData.data[i+2])/3/256 , 0.7);
		
		newImgData.data[i] = add(newImgData.data[i], n-100, avg);
		newImgData.data[i+1] = add(newImgData.data[i+1], n-100, avg);
		newImgData.data[i+2] = add(newImgData.data[i+2], n-100, avg);
	}
	
	this.ctx.clearRect(0, 0, this.img.width, this.img.height);
	this.ctx.putImageData(newImgData, 0, 0);
	function add(c, i, avg) {
		avg = Math.pow(c/256, 1);
		
		return Math.min(Math.round(c+c/(256-c)*i/100), 255);
		
		return Math.min(Math.round(c+(255-c)*i*avg/100), 255);
	}
}

// 利用 矩阵卷积 调整图片 RGB
histogram.prototype.ConvolutionMatrix = function(ctx, outputCanvasId, matrix, divisor, offset) {
	// 创建一个输出的 imageData 对象
	var matrix =[
	0,0,0,
	0,1,0,
	0,0,0], divisor = 1, offset = 128;
	
	var imageData = ctx.getImageData(0, 0, this.img.width, this.img.height);
	var w = this.img.width, h = this.img.height;
	var iD = imageData.data, oD = imageData.data;
	var m = matrix;
	
	// 对除了边缘的点之外的内部点的 RGB 进行操作，透明度在最后都设为 255
	for (var y = 1; y < h-1; y += 1) {
		for (var x = 1; x < w-1; x += 1) {
			for (var c = 0; c < 3; c += 1) {
				var i = (y*w + x)*4 + c;
				oD[i] = offset
					+(m[0]*iD[i-w*4-4] + m[1]*iD[i-w*4] + m[2]*iD[i-w*4+4]
					+ m[3]*iD[i-4]     + m[4]*iD[i]     + m[5]*iD[i+4]
					+ m[6]*iD[i+w*4-4] + m[7]*iD[i+w*4] + m[8]*iD[i+w*4+4])
					/ divisor;
				oD[i] = Math.round(oD[i]);
			}
			oD[(y*w + x)*4 + 3] = 255; // 设置透明度
		}
	}
	
	imageData.data = oD;
	
	var obj = document.getElementById(outputCanvasId), canvas = obj.getContext('2d');
	obj.height = this.img.height;
	obj.width = this.img.width;
	
	canvas.clearRect(0, 0, obj.width, obj.height);
	canvas.putImageData(output, 0, 0);
}

// 颜色
var colorModel = function() {
	// RGB -> HSV(B)
	this.rgb2hsv = function(rgb) {
		var hsv = {};
		rgb = this.int2float(rgb);
		hsv.h = this.calculateH(rgb);
		hsv.s = rgb.max == 0 ? 0 : rgb.poor/rgb.max;
		hsv.v = rgb.max;
		
		return hsv;
	}
	
	// RGB -> HSL
	this.rgb2hsl = function(rgb) {
		var hsl = {};
		rgb = this.int2float(rgb);
		hsl.h = this.calculateH(rgb);
		hsl.l = (rgb.max+rgb.min)/2;
		
		if(hsv.l == 0 || rgb.poor == 0) hsl.s = 0;
		else if(hsl.l > 0 && hsl.l <= 0.5) hsl.s = rgb.poor/2/hsl.l;
		else if(hsl.l > 0.5) hsl.s = rgb.poor/(2-2*hsl.l);
			
		return hsl;
	}
	
	// HSL -> RGB
	this.hsl2rgb = function(hsl) {
		var rgb = {r:0, g:0, b:0};
		if(hsl.s == 0) rgb = {r:hsl.l, g:hsl.l, b:hsl.l};
		else {
			var q, p, h;
			q = hsl.l < 0.5 ? hsl.l*(1+hsl.s) : hsl.l+hsl.s - hsl.l*hsl.s;
			p = 2*hsl.l - q;
			h = hsl.h/360;
			rgb.r = h+1/3;
			rgb.g = h;
			rgb.b = h-1/3;
			for(var k in rgb) {
				if(rgb[k] < 0) rgb[k] += 1;
				else if(rgb[k] > 1) rgb[k] -= 1;
				
				if(rgb[k] < 1/6) rgb[k] = p+(q-p)*6*rgb[k];
				else if(rgb[k] < 1/2) rgb[k] = q;
				else if(rgb[k] < 2/3) rgb[k] = p+(q-p)*6*(2/3-rgb[k]);
				else rgb[k] = p;
			}
		}
		
		return this.floot2int(rgb);
	}
	
	// HSV(B) -> RGB
	this.hsv2rgb = function(hsv) {
		var rgb = {r:0, g:0, b:0};
		var h,f,p,q,t;
		h = Math.floor( (hsv.h/60)%6 );
		f = hsv.h/60-h;
		p = hsv.v*(1-hsv.s);
		q = hsv.v*(1-f*hsv.s);
		t = hsv.v*(1-(1-f)*hsv.s);

		switch(h) {
			case 0: rgb = {r:hsv.v, g:t, b:p}; break;
			case 1: rgb = {r:q, g:hsv.v, b:p}; break;
			case 2: rgb = {r:p, g:hsv.v, b:t}; break;
			case 3: rgb = {r:p, g:q, b:hsv.v}; break;
			case 4: rgb = {r:t, g:p, b:hsv.v}; break;
			case 5: rgb = {r:hsv.v, g:p, b:q}; break;
			default: break;
		}
		return this.floot2int(rgb);
	}
	
	// 计算 HSV 和 HSL 中的 H
	this.calculateH = function(rgb) {
		var h = 0;
		
		if(rgb.poor == 0) h = 0;
		else if(rgb.max == rgb.r) {
			h = 60*(g-b)/poor;
			if(rgb.g < rgb.b) h += 360;
		}
		else if(rgb.max == rgb.g) h = 60*(rgb.b-rgb.r)/rgb.poor + 120;
		else if(rgb.max == rgb.b) h = 60*(rgb.r-rgb.g)/rgb.poor + 240;
		
		return h;
	}
	
	// 对RGB 颜色进行处理， 转换为 0-1 之间的值
	this.int2float = function(rgb) {
		var fRGB = {};
		for(var k in rgb) {
			fRGB[k] = Math.min(Math.abs(rgb[k])/255, 1);
		}
		
		fRGB.max = Math.max(fRGB.r, fRGB.g, fRGB.b);
		fRGB.min = Math.min(fRGB.r, fRGB.g, fRGB.b);
		fRGB.poor = fRGB.max - fRGB.min;
		
		return fRGB;
	}
	
	// 浮点型 RGB 转整型
	this.floot2int = function(rgb) {
		var iRGB = {};
		for(var k in rgb) {
			iRGB[k] = Math.round(rgb[k]*255);
		}
		return iRGB;
	}
}