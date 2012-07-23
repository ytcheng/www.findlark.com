/**
 *
 * Copyright (c) 2009 Jun(qq100015091)
 * http://www.xlabi.com
 * http://www.xlabi.com/tp/jscroll.html
 * jun5091@gmail.com
 */
$.fn.extend({//添加滚轮事件//by jun
	mousewheel:function(Func) {
		return this.each(function() {
			var _self = this;
		  		_self.D = 0;//滚动方向
			if($.browser.msie || $.browser.safari) {
				_self.onmousewheel = function() {
					_self.D = event.wheelDelta;
					event.returnValue = false;
					Func && Func.call(_self);
				};
			} else {
				_self.addEventListener("DOMMouseScroll", function(e) {
					_self.D = e.detail > 0 ? -1 : 1;
					e.preventDefault();
					Func && Func.call(_self);
				},false);
			}
		});
	}
});

$.fn.extend({
	jscroll:function(j) {
		return this.each(function() {
			j = j || {}
			j.Bar = j.Bar||{};//2级对象
			j.Btn = j.Btn||{};//2级对象
			j.Bar.Bg = j.Bar.Bg||{};//3级对象
			j.Bar.Bd = j.Bar.Bd||{};//3级对象
			j.Btn.uBg = j.Btn.uBg||{};//3级对象
			j.Btn.dBg = j.Btn.dBg||{};//3级对象
			var jun = { W:"15px"
						,BgUrl:""
						,Bg:"#efefef"
						,Bar:{  Pos:"up"
								,Bd:{Out:"#b5b5b5",Hover:"#ccc"}
								,Bg:{Out:"#fff",Hover:"#fff",Focus:"orange"}}
						,Btn:{  btn:true
								,uBg:{Out:"#ccc",Hover:"#fff",Focus:"orange"}
								,dBg:{Out:"#ccc",Hover:"#fff",Focus:"orange"}}
						,Fn:function(){}
			}
			
			j.W = j.W||jun.W;
			j.BgUrl = j.BgUrl||jun.BgUrl;
			j.Bg = j.Bg||jun.Bg;
				j.Bar.Pos = j.Bar.Pos||jun.Bar.Pos;
					j.Bar.Bd.Out = j.Bar.Bd.Out||jun.Bar.Bd.Out;
					j.Bar.Bd.Hover = j.Bar.Bd.Hover||jun.Bar.Bd.Hover;
					j.Bar.Bg.Out = j.Bar.Bg.Out||jun.Bar.Bg.Out;
					j.Bar.Bg.Hover = j.Bar.Bg.Hover||jun.Bar.Bg.Hover;
					j.Bar.Bg.Focus = j.Bar.Bg.Focus||jun.Bar.Bg.Focus;
				j.Btn.btn = j.Btn.btn!=undefined?j.Btn.btn:jun.Btn.btn;
					j.Btn.uBg.Out = j.Btn.uBg.Out||jun.Btn.uBg.Out;
					j.Btn.uBg.Hover = j.Btn.uBg.Hover||jun.Btn.uBg.Hover;
					j.Btn.uBg.Focus = j.Btn.uBg.Focus||jun.Btn.uBg.Focus;
					j.Btn.dBg.Out = j.Btn.dBg.Out||jun.Btn.dBg.Out;
					j.Btn.dBg.Hover = j.Btn.dBg.Hover||jun.Btn.dBg.Hover;
					j.Btn.dBg.Focus = j.Btn.dBg.Focus||jun.Btn.dBg.Focus;
			j.Fn = j.Fn||jun.Fn;
			var _self = this;
			var Stime,Sp=0,Isup=0;
			$(_self).css({overflow:"hidden",position:"relative",padding:"0px"});
			var dw = $(_self).width(), dh = $(_self).height()-2;
			var sw = j.W ? parseInt(j.W) : 21;
			var sl = dw - sw
			var bw = j.Btn.btn==true ? sw : 0;
			if($(_self).children(".jscroll-c").html() == null) {//存在性检测
				$(_self).wrapInner("<div class='jscroll-c'></div>");
				$(_self).children(".jscroll-c").prepend("<div class='jscroll-o'></div>");

				//FX修改：根据参数判断 是否需要“上下按钮”， 不需要时直接屏蔽html代码输出，修正IE8下， 设置为false仍旧显示的BUG
				var scrollHtml = "<div class='jscroll-e' unselectable='on' style='height:"+dh+"px;'>";
				if(j.Btn.btn==true) { scrollHtml += "<div class='jscroll-u'></div>"; }
				scrollHtml += "<div class='jscroll-h' unselectable='on'></div>";
				if(j.Btn.btn==true) { scrollHtml += "<div class='jscroll-d'></div>"; }
				scrollHtml += "</div>"
				$(_self).append(scrollHtml);
			}
			var jscrollc = $(_self).children(".jscroll-c");
			var jscrolle = $(_self).children(".jscroll-e");
			var jscrollh = jscrolle.children(".jscroll-h");
			var jscrollu = jscrolle.children(".jscroll-u");
			var jscrolld = jscrolle.children(".jscroll-d");
			if($.browser.msie){document.execCommand("BackgroundImageCache", false, true);}
			jscrollc.css({"padding-right":sw});
			jscrolle.css({width:sw,background:j.Bg,"background-image":j.BgUrl});
			jscrollh.css({top:bw,background:j.Bar.Bg.Out,"background-image":j.BgUrl,"border-color":j.Bar.Bd.Out,width:sw-2});
			jscrollu.css({height:bw,background:j.Btn.uBg.Out,"background-image":j.BgUrl});
			jscrolld.css({height:bw,background:j.Btn.dBg.Out,"background-image":j.BgUrl});
			jscrollh.hover(function(){if(Isup==0)$(this).css({background:j.Bar.Bg.Hover,"background-image":j.BgUrl,"border-color":j.Bar.Bd.Hover})},function(){if(Isup==0)$(this).css({background:j.Bar.Bg.Out,"background-image":j.BgUrl,"border-color":j.Bar.Bd.Out})})
			jscrollu.hover(function(){if(Isup==0)$(this).css({background:j.Btn.uBg.Hover,"background-image":j.BgUrl})},function(){if(Isup==0)$(this).css({background:j.Btn.uBg.Out,"background-image":j.BgUrl})})
			jscrolld.hover(function(){if(Isup==0)$(this).css({background:j.Btn.dBg.Hover,"background-image":j.BgUrl})},function(){if(Isup==0)$(this).css({background:j.Btn.dBg.Out,"background-image":j.BgUrl})})
			var sch = jscrollc.height();
			//var sh = Math.pow(dh,2) / sch ;//Math.pow(x,y)x的y次方
			//var sh = (dh-2*bw)*dh / sch
			var sh = 80;
			//alert(sch);
			sh = sh < 10 ? 10 : sh; //---原if(sh < 10) { sh = 10 }
			//alert(sch);
			var wh = sh/4; //鼠标滚轮 滚动时候跳动幅度
		//	sh = parseInt(sh);
			var curT = 0;//-parseInt(jscrollc.css("top")); //滚动高度其实值
			var allowS = false;
			jscrollh.height(sh);

			//jscrollh.css({"top":curT + "px"}); //设置滚动条起始位置
			jscrollc.animate({"top":"0px"}, 600); //重置

			if(sch <= dh){
				jscrollc.css({"padding-right":"8px"});
				jscrolle.css({display:"none"});
			} else {
				allowS=true;
				jscrolle.css({display:"block"});
			}
			if(j.Bar.Pos!="up"){
				curT=dh-sh-bw;
				setT();
			}
			jscrollh.bind("mousedown",function(e) {
				j['Fn'] && j['Fn'].call(_self);
				Isup=1;
				jscrollh.css({background:j.Bar.Bg.Focus,"background-image":j.BgUrl})
				var pageY = e.pageY ,t = parseInt($(this).css("top"));
				$(document).mousemove(function(e2){
					 curT =t+ e2.pageY - pageY;//pageY浏览器可视区域鼠标位置，screenY屏幕可视区域鼠标位置
						setT();
				});
				$(document).mouseup(function(){
					Isup=0;
					jscrollh.css({background:j.Bar.Bg.Out,"background-image":j.BgUrl,"border-color":j.Bar.Bd.Out})
					$(document).unbind();
				});
				return false;
			});
			jscrollu.bind("mousedown",function(e){
			j['Fn'] && j['Fn'].call(_self);
				Isup=1;
				jscrollu.css({background:j.Btn.uBg.Focus,"background-image":j.BgUrl})
				_self.timeSetT("u");
				$(document).mouseup(function(){
					Isup=0;
					jscrollu.css({background:j.Btn.uBg.Out,"background-image":j.BgUrl})
					$(document).unbind();
					clearTimeout(Stime);
					Sp=0;
				});
				return false;
			});
			jscrolld.bind("mousedown",function(e){
			j['Fn'] && j['Fn'].call(_self);
				Isup=1;
				jscrolld.css({background:j.Btn.dBg.Focus,"background-image":j.BgUrl})
				_self.timeSetT("d");
				$(document).mouseup(function(){
					Isup=0;
					jscrolld.css({background:j.Btn.dBg.Out,"background-image":j.BgUrl})
					$(document).unbind();
					clearTimeout(Stime);
					Sp=0;
				});
				return false;
			});
			_self.timeSetT = function(d){
				var self=this;
				if(d=="u"){curT-=wh;}else{curT+=wh;}
				setT();
				Sp+=2;
				var t =500 - Sp*50;
				if(t<=0){t=0};
				Stime = setTimeout(function(){self.timeSetT(d);},t);
			}
			jscrolle.bind("mousedown",function(e){
					j['Fn'] && j['Fn'].call(_self);
							curT = curT + e.pageY - jscrollh.offset().top - sh/2;
							asetT();
							return false;
			});
			function asetT(){
						if(curT < bw){curT=bw;}
						if(curT > dh-sh-bw){curT=dh-sh-bw;}
						jscrollh.stop().animate({top:curT},100);

						//FX修正，滚动到底部时，内容也与底部对其
						var scT = -((curT - bw) * (sch - dh) / (dh - 2 * bw - sh));
						jscrollc.stop().animate({top:scT},1000);
			};
			function setT(){
						if(curT<bw){curT=bw;}
						if(curT>dh-sh-bw){curT=dh-sh-bw;}
						jscrollh.css({top:curT});

						//FX修正，滚动到底部时，内容也与底部对其
						var scT = -((curT - bw) * (sch - dh) / (dh - 2 * bw - sh));
						jscrollc.css({top:scT});
			};
			$(_self).mousewheel(function(){
					if(allowS!=true) return;
					j['Fn'] && j['Fn'].call(_self);
						if(this.D>0){curT-=wh;}else{curT+=wh;};
						setT();
			});
		});
	}
});