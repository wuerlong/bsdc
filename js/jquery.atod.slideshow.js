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
		var curNo       = 0;
		var prevNo      = 0;
		var $wrap       = $(wrap_id);
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
		
		// 背景画像が読み込まれたかどうかの判別用オブジェクト
		var bgImg        = {};
		var bgImgLoading = {};
		var bgImgLoaded  = 0;
		var bgImgNum     = 0;
		
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
		
		
		//********************************************************
		// 背景画像を読み込み
		//********************************************************
		
		function loadBgImg(){
			
			$slide.each(function(page,v){
				
				bgImgNum++;
				
				if(typeof bgImgLoading[page] == 'undefined'){
					
					// 読み込み開始フラグを立てる
					bgImgLoading[page] = {};
					bgImgLoading[page].status = 'start';
					
					// 背景画像の読み込み
			    var imgObj = new Image();
			    imgObj.src = $(this).children("img").attr("src");
			    
			    // 配列に画像を入れる
			    bgImg[page] = imgObj;
			    
			    // 読み込み完了までの監視メソッドを実行
			    setTimeout(function(){
						detectBgStatus(page);
					}, 100);
					
				}
			});
			
		}
		
		
		//********************************************************
		// 背景画像が読み込まれたかどうかを判別し、完了後HTMLを表示する
		//********************************************************
		
		function detectBgStatus(page){
			if(bgImg[page].complete != true){
		    setTimeout(function(){
					detectBgStatus(page)
				}, 100);
			}else{
				if(bgImgLoading[page].status == 'start' && bgImgLoading[page].status != 'complete'){
					
					//背景画像読み込みタイマーを解除
					clearTimeout("detectBgStatus(page)");
					
					// 読み込み完了済みにする
					bgImgLoading[page].status = 'complete';
					
					bgImgLoaded++;
					
				}
			}
			
			// 全て読み込まれたらhomeを表示する
			if(bgImgLoaded == bgImgNum){
				windowResize();
				init();
				$slide.children("img").fadeIn();
				
				// windowリサイズイベントに登録
				$(window).resize(function(){
			    windowResize();
				});
				
				// 常に表示位置を監視する
				setWindowReset();
			}
			
		}
		
		
		//********************************************************
		// 常に表示位置を監視する
		//********************************************************
		
		function setWindowReset(){
			setTimeout(function(){
				windowResize();
				setWindowReset();
				
		    
		    if(!is_moving){
					$wrap.css("left", parseInt(arrSlide[curNo].left * -1));
				}
				
			}, 500);
		}
		
		
		//********************************************************
		// window.resize時の処理
		//********************************************************
		
		function windowResize(){
			// iPhone対策(高さを100%にする)
			var h = window.innerHeight ? window.innerHeight : $(window).height();
			var w      = $(window).width();
			$("html, body").height(h).width(w);
			
			$("#wrapper").height(h).width(w-205);
			$("#container").height(h);
			setBgImg();
			
		}
		
		
		
		//********************************************************
		// 背景画像の大きさを調整する
		//********************************************************
		
		function setBgImg(){
			// 幅を初期化
			wrapWidth = 0;
			
			$slide.each(function(key, value){
				
				//$(this).width($(window).width());
				$(this).width($wrap.width());
				$(this).height($(window).height());
				
				var box_w     = $(this).width();
				var box_h     = $(this).height();
				var box_ratio = box_w / box_h;
				var img_w     = bgImg[key].width;
				var img_h     = bgImg[key].height;
				var img_ratio = img_w / img_h;
				var w_ratio   = img_w / box_w;
				var h_ratio   = img_h / box_h;
				
				var target_width;
				var target_height;
				var target_left;
				var target_top;
				
				var target  = $(this).children("img");
				
				if(target.length){
					// 縦に合わせる
					if(w_ratio > h_ratio){
						target_width  = parseInt(img_w * box_h / img_h);
						target_height = box_h;
						target_left   = parseInt((target_width - box_w) / 2) * -1;
						target_top    = 0;
					}
					
					// 横に合わせる
					else{
						target_width  = box_w;
						target_height = parseInt(img_h * box_w / img_w);
						target_left   = 0;
						target_top    = parseInt((target_height - box_h) / 2) * -1;
					}
					
					
					// 画像の大きさ、表示位置を決定する
					target.css({
						width : target_width,
						height: target_height,
						left  : target_left,
						top   : target_top
					});
				}
				
				if(settings.animation == "slide"){
					// 各スライドを横に並べる
					value.left = wrapWidth;
					
					// 横幅を取得
					wrapWidth = wrapWidth + parseInt(box_w);
					
				}else{
					wrapWidth = $wrap.width();
				}
					
			});
			
			// スライド領域の横幅を設定
			$wrap.width(wrapWidth);
			
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
						$(v).css({position: "absolute", opacity: 1, zIndex: 2});
					}else{
						$(v).css({position: "absolute", opacity: 0, zIndex: 1});
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
					$next.hide();
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
					$prev.hide();
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
						if(!$(this).hasClass("hidden")){
							showSlide(k);
						}
					});
					
					if(!$(this).hasClass("hidden")){
						$(this).hover(
							function(){
								$(this).addClass("current");
								showSlide(k);
							},
							function(){
								if(curNo != k){
									$(this).removeClass("current");
								}
							}
						);
					}
					
				});
			}
			
			// タイマー動作フラグを変更する
			$slide.hover(
				function(){
					objTimer.count_flg = false;
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
				$prev.hide();
			}else{
				$prev.show();
			}
			if(i == arrSlide.length - 1 && $next.length && settings.prevnexthiddenflg){
				$next.hide();
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
				if($(arrNavi[i]).hasClass("hidden")){
					showSlide(i+1);
					return false;
				}
				$(arrNavi[i]).addClass("current");
			}
			
			if(settings.animation == "slide"){
				
				// i番目のスライド位置を取得
				var $slide       = $(arrSlide[i]);
				var targetLeft   = parseInt(arrSlide[i].left) * -1;
				var targetHeight = parseInt($slide.css("height"));
				
				// コンテナ領域の高さを変化させる
				$src.queue([]).stop(true,true).animate({height: targetHeight}, settings.speed, settings.easing, function(){});
				$wrap.queue([]).stop(true,true).animate({left: targetLeft}, settings.speed, settings.easing);
			
			}else if(settings.animation == "fade"){
				
				$(arrSlide[curNo]).stop(true,true).animate({opacity: 0}, settings.speed, settings.easing, function(){
					$(this).css("zIndex", 1);
				});
				$(arrSlide[i]).stop(true,true).animate({opacity: 1}, settings.speed, settings.easing, function(){
					$(this).css("zIndex", 2);
				});
				
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
		
		return loadBgImg();
	}
	
  
});
