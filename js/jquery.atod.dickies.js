var menuFlg = false;

$(document).ready(function(){ 
	setWrapperWitdh();
}); 

$(function(){

});


$(function(){
	
	// トップページスライドショー
	$('#wrapper').slideshow({
		clsSlide  		: ".slide",                   // スライドさせるボックス
		nextId        : "",  // Nextボタンのセレクタ
		prevId        : "",  // Prevボタンのセレクタ
		prevnexthiddenflg: true,
		naviId        : "",        // ナビゲーションのボックス
		speed         : 1000,                        // アニメーションの速さ
		easing        : "easeInOutExpo",            // イージング
		animation     : "fade",
		pause         : 2000,                       // 停止させるミリ秒
		autoplay      : true,                      // 自動で再生するかどうか
		repeat        : true                       // リピートするかどうか(autoplay=trueの場合のみ機能)
	});
	
	
	// カラーイメージ表示
	$("#globalnavi li, #subnavi li").hover(
		function(){
			var window_h      = parseInt($(window).height());
			var min_bottom    = 85;
			var max_bottom    = window_h - 110;
			var target_bottom = parseInt(Math.random() * max_bottom) + min_bottom;
			
			$("#menuBarImageColor").css("bottom", target_bottom).show();
		},
		function(){
			$("#menuBarImageColor").hide();
		}
	);
	
}); 


function setWrapperWitdh(){
	var body_width = $("body").width();
	$('#wrapper').width(body_width - 205);
	$('#wrapper').height($(window).height());
	
	return false;
}

