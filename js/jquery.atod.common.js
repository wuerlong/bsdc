//*******************************************************************************
//　初期設定
//*******************************************************************************

//IE6かどうかの確認
var isIE = (function(){
  var undef,
    v = 3,
    div = document.createElement('div'),
    all = div.getElementsByTagName('i');
  while (
    div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
    all[0]
  );
  return v > 4 ? v : undef;
}());


//*******************************************************************************
//　html読み込み完了時の動作
//*******************************************************************************

$(document).ready(function(){
	
	
	
});


//*******************************************************************************
//　イベント用関数
//*******************************************************************************

$(function(){
	
	// ロールオーバーの処理
	
	// IE6,7,8 はただのロールオーバー
	if(!jQuery.support.opacity){
		
		$('.opRollover').hover(
			function(){
				$(this).fadeTo("fast", 0.4);
			},
			function(){
				$(this).fadeTo("fast", 1);
			}
		);
		
	}else{
		
		$('.opRollover').live("mouseover", function(){
			$(this).stop().animate({opacity: 0.4}, "fast");
		}).live("mouseout", function(){
			$(this).stop().animate({opacity: 1}, "slow");
		});
		
	}
	
	
	// Font set
	var ua = navigator.userAgent;
	
	// Mac & Safari
	if (ua.match(/Mac|PPC/)){
		$("body").css("font-family", "GeosansLightRegular, 'ヒラギノ角ゴ Pro W3','Hiragino Kaku Gothic Pro', Osaka, Helvetica, 'Arial Black', sans-serif");
	
	// Windows Server 2003, Windows XP 以下
	}else if(ua.match(/Win(dows )?95/) || ua.match(/Win(dows )?NT( 4\.0)/) || ua.match(/Win(dows )?98/) || ua.match(/Win(dows )?(NT 5\.0|2000)/) || ua.match(/Win(dows)? (9x 4\.90|ME)/) || ua.match(/Win(dows )?(NT 5\.1|XP)/) || ua.match(/Win(dows )?NT 5\.2/)){
		$("body").css("font-family", "'ＭＳ Ｐゴシック', 'MS PGothic', Helvetica,'ヒラギノ角ゴ Pro W3', 'Hiragino Kaku Gothic Pro', meiryo, Osaka, sans-serif");
	
	}
	
	// スムーズスクロール
	$('a[href^=#]').click(function() {
		var speed = 800;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$('html,body').animate({scrollTop:position}, speed, 'easeOutExpo');
		return false;
	});
	
	// ページトップへの処理
	if($("#toPageTop").length){
		
		var w_h  = $(window).height();
		var d_h  = $(document).height();
		var footer_top = $("#footer").offset().top;
		var s_top_limit = 100;
		
		$(window).exScrollEvent({
			delay : 10,
			callback : function(evt,param){
				
				var param_top = param.scroll.top;
				
				if(typeof param.prevScroll == 'undefined'){
					return false;
				}
				
				if(param_top > s_top_limit){
					if($("#toPageTop").css("display") == "none"){
						$("#toPageTop").fadeIn(500);
					}
				}else{
					if($("#toPageTop").css("display") != "none"){
						$("#toPageTop").fadeOut(500);
					}
				}
				
				// スクロール開始
				if(param.status == 1){
					
				}
				
				// スクロール中
				if(param.status == 2){
					
				}
				
				// スクロール終了
				if(param.status == 0){
					
				}
			}
		});
	} // ページトップへの処理終わり
	
	
});



//*******************************************************************************
//　windowスクロール
//*******************************************************************************

$(window).scroll(function(){

});

//*******************************************************************************
//　windowリサイズ
//*******************************************************************************

$(window).resize(function(){
	if($("#toPageTop").length){
		if($(document).height() - $(window).height() == 0){
			$("#toPageTop").fadeOut(500);
		}
	}
});


//*******************************************************************************
//　各種共通関数
//*******************************************************************************

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

// URLのクエリ部分を配列で返す
function getUrlVars(){ 
  var vars = [], hash; 
  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&'); 
  for(var i = 0; i < hashes.length; i++) { 
      hash = hashes[i].split('='); 
      vars.push(hash[0]); 
      vars[hash[0]] = hash[1]; 
  } 
  return vars; 
}

// ハッシュを取得
function getUrlHash(url){
	
	if(!url){
		url = document.URL;
	}
	
	var hash;
	
	if(url.indexOf("#") == -1){
		return hash;
	}else{
		hash = url.split("#")[1].split('?')[0];
	}
	
	return hash;
	
}

//IDに#を付ける処理
function addSharp(box_id){
	if(box_id && box_id.indexOf("#") == -1){
		box_id = "#" + box_id;
	}
	return box_id;
}


// ログ出力用関数
function log(obj){
	window.console.log(obj);
}

