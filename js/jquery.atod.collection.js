/*!
 * jQuery Slideshow v1.0
 *
 * Copyright (C) 2012 AtoD Inc.
 *
 */
$(function(){
	
  $.fn.slideshow = function(settings){
		
		var settings = jQuery.extend({
			clsSlide  		: ".slide",                   // スライドさせるボックス
			clsSlideitem	: ".slideitem",               // アイテムボックス
			wrap_slide_id : "#wrap_slide_id",           // アイテムを表示させるラッパー
			nextId        : "",                         // 次へボタンのセレクタ
			prevId        : "",                         // 前へボタンのセレクタ
			prevnexthiddenflg: true,                    // 自動で「前へ」「次へ」ボタンを隠すかどうか
			naviId        : "",                         // ナビゲーションのセレクタ
			speed         : 600,                        // アニメーションの速さ
			easing        : "easeInOutCubic",           // イージング
			animation     : "slide",                    // スライドかフェードか
			pause         : 5000,                       // 停止させるミリ秒
			autoplay      : true,                       // 自動で再生するかどうか
			repeat        : true                        // リピートするかどうか(autoplay=trueの場合のみ機能)
		},settings);
		
		// スライドの親ボックス
		var wrap_id   = "#" + $(this).attr('id');
		
		// スクロール領域
		var src_id    = "#" + $(wrap_id).parent().attr('id');
		
		
		// グローバル変数
		var arrSlide    = [];
		var arrSlideItem= [];
		var curNo       = 0;
		var prevNo      = 0;
		var $wrap       = $(wrap_id);
		var $wrap_item  = $(settings.wrap_slide_id);
		var $src        = $(src_id);
		var $slide      = $(settings.clsSlide);
		var wrapWidth   = 0;
		var is_moving   = false;
		var timer_id    = null;
		
		// ボタン
		var $next       = $(settings.nextId);
		var $prev       = $(settings.prevId);
		
		// ナビゲーション
		var $navi       = $(settings.naviId);
		var arrNavi     = [];
		
		// 処理待ちの関数配列
		var interval    = 200;
		var objTimer    = {
												count_flg   : true,
												past_secont : 0,
												next_func   : function(){}
											};
		
		// デバッグ用関数
		function debug(obj){
			log(obj);
		}
		
		// デバッグ用関数
		function log(obj) {
			// console.log などが使用できない場合の処理
			if (!window.console) {
			  (function() {
			      var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml",
			        "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
			      window.console = {};
			      for (var i = 0; i < names.length; ++i)
			        window.console[names[i]] = function() {}
			  })();
			}
			window.console.log(obj);
		}
		
		// タイマーを初期化
		function setTimer(){
			if(objTimer.count_flg && $("#lightboxOverlay").css("display") != "block" && $("#sb-container").css("display") != "block"){
				objTimer.past_secont = parseInt(objTimer.past_secont)+interval;
			}
			if(objTimer.past_secont >= settings.pause && typeof objTimer.next_func == "function"){
				objTimer.next_func();
			}
		}
		
		
		function init(){
			
			timer_id = setInterval(function(){setTimer()}, interval);
			
			// src領域のCSS設定
			$src.css({overflow: "hidden", position: "relative"});
			
			// wrap領域のCSS設定
			$wrap.css({position: "absolute"});
			
			$(wrap_id+" "+settings.clsSlide).each(function(k, v){
				
				if(settings.animation == "slide"){
					// 各スライドを横に並べる
					v.left = wrapWidth;
					
					// 横幅を取得
					wrapWidth = wrapWidth + parseInt($(v).width());
				}else if(settings.animation == "fade"){
					// 各スライドをレイヤーとして重ねる
					if(k == 0){
						$(v).css({position: "absolute", opacity: 1});
					}else{
						$(v).css({position: "absolute", opacity: 0});
					}
				}
				
				
				
				// 初期の高さを決定
				if(k == 0){
					$src.height($(v).height());
				}
				
				// スライドを配列に入れる
				arrSlide[k] = v;
				
			});
			
			if(settings.animation == "slide"){
				// スライド領域の横幅を設定
				$wrap.width(wrapWidth);
			}
			
			// ボタンを設定
			if($next.length){
				$next.hover(
					function(){
						$next.css("backgroundPosition", "left -59px");
					},
					function(){
						$next.css("backgroundPosition", "left 0px");
					}
				);
					
				$next.click(function(){
					if(parseInt(curNo) >= arrSlide.length - 1){
						var nextNo = 0;
					}else{
						var nextNo = curNo + 1;
					}
					showSlide(nextNo);
				});
				if(arrSlide.length <= 1 && settings.prevnexthiddenflg){
					//$next.hide();
				}
			}
			if($prev.length){
				$prev.hover(
					function(){
						$prev.css("backgroundPosition", "left -59px");
					},
					function(){
						$prev.css("backgroundPosition", "left 0px");
					}
				);
				$prev.click(function(){
					if(curNo < 1){
						var prevNo = arrSlide.length - 1;
					}else{
						var prevNo = curNo - 1;
					}
					showSlide(prevNo);
				});
				if(settings.prevnexthiddenflg){
					//$prev.hide();
				}
			}
			
			// ナビゲーションを設定
			if($navi.length){
				var src_w  = parseInt($src.width());
				var navi_w = parseInt($navi.width());
				var pl     = parseInt((src_w - navi_w) / 2);
				$navi.css("width", navi_w);
				$navi.css("paddingLeft", pl);
				
				$navi.children("li").each(function(k, v){
					if(k == 0){
						$(this).addClass("current");
					}
					arrNavi[k] = v;
					$(this).click(function(){
						showSlide(k);
					});
					
					$(this).hover(
						function(){
							$(this).addClass("current");
						},
						function(){
							if(curNo != k){
								$(this).removeClass("current");
							}
						}
					);
					
				});
			}
			
			// アイテムの表示設定
			if($wrap_item.length){
				$wrap_item.children(settings.clsSlideitem).css({opacity: 0});
				$wrap_item.children(settings.clsSlideitem).each(function(k, v){
					// アイテムを配列に入れる
					arrSlideItem[k] = v;
					
					// 初回は最初のアイテムを表示しておく
					if(k == 0){
						$(v).css({opacity: 1, display:"block"});
					}
				});
			}
			
			
			// タイマー動作フラグを変更する
			$slide.hover(
				function(){
					//objTimer.count_flg = false;
					objTimer.count_flg = true;
					//$(this).css("opacity", 0.8);
				},
				function(){
					objTimer.count_flg = true;
					//$(this).css("opacity", 1);
				}
			);
			
			objTimer.next_func = nextSlide;
		}
		
		function nextSlide(){
			// repeat=trueで、curNoがスライド数を超えている場合は最初に戻す
			if(settings.repeat === true){
				if(parseInt(curNo) >= arrSlide.length - 1){
					var nextNo = 0;
				}else{
					var nextNo = curNo + 1;
				}
			}
			
			// 自動再生の場合、かつ、スライドが複数ある場合のみ実行
			if(settings.autoplay === true && arrSlide.length > 1){
				showSlide(nextNo);
			}
		}
		
		function showSlide(i){
			if(i == 0 && $prev.length && settings.prevnexthiddenflg){
				//$prev.hide();
			}else{
				$prev.show();
			}
			if(i == arrSlide.length - 1 && $next.length && settings.prevnexthiddenflg){
				//$next.hide();
			}else{
				$next.show();
			}
			
			// 数値に変換
			i = parseInt(i);
			
			if(curNo == i){
				return false;
			}
			
			// ナビの設定
			if(arrNavi.length){
				$(arrNavi[curNo]).removeClass("current");
				$(arrNavi[i]).addClass("current");
			}
			
			if(settings.animation == "slide"){
				
				// i番目のスライド位置を取得
				var $slide       = $(arrSlide[i]);
				var targetLeft   = parseInt(arrSlide[i].left) * -1;
				var targetHeight = parseInt($slide.css("height"));
				
				var curItemNo    = curNo;
				
				// アイテムを非表示
				$(arrSlideItem[curItemNo]).queue([]).stop(true,true).fadeTo("slow", 0);
				
				// アイテムがある場合は表示する
				$wrap_item.height($(arrSlideItem[i]).height());
				$(arrSlideItem[i]).stop().queue([]).fadeTo("slow", 1);
				
				// コンテナ領域の高さを変化させる
				$src.queue([]).stop(true,true).animate({height: targetHeight}, settings.speed, settings.easing, function(){});
				$wrap.queue([]).stop(true,true).animate({left: targetLeft}, settings.speed, settings.easing, function(){});
			
			}else if(settings.animation == "fade"){
				
				$(arrSlide[curNo]).stop(true,true).animate({opacity: 0}, settings.speed, settings.easing, function(){});
				$(arrSlide[i]).stop(true,true).animate({opacity: 1}, settings.speed, settings.easing, function(){});
				
			}
			
			curNo = i;
			
			objTimer.past_secont = 0;
			objTimer.next_func = nextSlide;
		}
		
		
		//********************************************************
		// ロールオーバー用の画像名を取得
		//********************************************************

		function getRolloverImgName(src, prefix){
			if(!prefix){
				prefix = "_on";
			}
			if(typeof src !== 'undefined'){
				var src_on = src.substr(0, src.lastIndexOf('.'))
				           + prefix
				           + src.substring(src.lastIndexOf('.'));
				
			}
			return src_on;
		}


		//********************************************************
		// ロールアウト用の画像名を取得
		//********************************************************

		function getRolloutImgName(src, prefix){
			if(!prefix){
				prefix = "_on";
			}
			if(typeof src !== 'undefined'){
				return src.replaceAll(prefix,"");
			}
		}
		
		
		//trim関数
		function trim(str){
		  return String(str).replace(/^[ 　]*/gim, "").replace(/[ 　]*$/gim, "");
		}
		String.prototype.trim = function (str){
		  return String(str).replace(/^[ 　]*/gim, "").replace(/[ 　]*$/gim, "");
		}

		//POSTデータ送信時、JSONで値を返す
		$.postJSON=function(url, data, callback){
		    $.post(url, data, callback, "json");
		};

		// 全置換：全ての文字列 org を dest に置き換える  
		String.prototype.replaceAll = function (org, dest){
		  return this.split(org).join(dest);
		}
		
		return init();
	}
	
  
});
