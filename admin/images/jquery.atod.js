//*******************************************************************************
//　初期設定
//*******************************************************************************

//オーバーレイのID名 
var atod_overlay_name = "atod-overlay";

//ローディングのID名 
var atod_loading_name = "atod-loading";

//ダイアログボックスのID名 
var atod_dialog_name 	= "atod-dialog";

//lightboxのID名 
var atod_lightbox_name 	= "atod-lightbox";


//IE6かどうかの確認 
var ie = (function(){
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
	
	//bodyにオーバーレイ関係を設置
	if($("#"+atod_loading_name).length == 0){
		$("body").prepend('<div id="' + atod_loading_name + '"><img src="/cms/common/img/common/loading.gif" alt="Loading..." /></div>');
	}
	if($("#"+atod_overlay_name).length == 0){
		$("body").prepend('<div id="' + atod_overlay_name + '"></div>');
	}
	if($("#"+atod_dialog_name).length == 0){
		$("body").prepend('<div id="' + atod_dialog_name + '"></div>');
	}
	if($("#"+atod_lightbox_name).length == 0){
		$("body").prepend('<div id="' + atod_lightbox_name + '"></div>');
	}
	
	//IE6で position:fixed を実現する (require: jquery.exfixed-1.3.1.js)
	if(ie === 6){
		$("#" + atod_overlay_name).exFixed();
		$("#" + atod_loading_name).exFixed();
		//$("#" + atod_dialog_name).exFixed();
		$("#" + atod_dialog_name).css({position:"absolute"});
		$("#header").exFixed();
		if($("#headerNavi").length){
			$("#headerNavi").exFixed();
		}
		
		$("#pageTopRight").exFixed();
		//$("#pageTopRight").css({position:"absolute"});
		$("#footer").exFixed();
	}
	
	//ヘッダーのサブメニューを隠す
	$(".headerSubNavi").hide();
	
	//テキストボックス・テキストエリアにフォーカスが入ったときの処理
	if(document.URL.indexOf("/cms/person/edit.php") == -1){
		$(":text, :password, :checkbox, :radio, textarea, select").focus(function(){
			$(this).addClass("focus");
			$(this).parents("td").children(".explanation").attr("style","color:#0099ff");
		});

		//テキストボックス・テキストエリアにフォーカス無くなったときの処理
		$(":text, :password, :checkbox, :radio, textarea, select").blur(function(){
			if(!$(this).hasClass("error")){
				$(this).removeClass("focus");
			}
			$(this).parents("td").children(".explanation").attr("style","");
		});
	}
	//Ajax通信時オーバーレイを操作する
	$("body")
		.bind("ajaxStart", function(){
			atod_overlay('show');
			atod_loading('show');
		})
		.bind("ajaxComplete", function(){
			atod_loading('hide');
		})
		.bind("ajaxError", function(event, XMLHttpRequest, options, thrownError){
			atod_loading('hide');
			var html = "ajaxError: 通信に失敗しました。\n\n"+XMLHttpRequest.responseText;
			atod_dialog('show',html, '', '');
	});
	
	//ヘッダーメニューのロールオーバー
	$(".headerNavi").hover(
		function(){
			$(this).find("a").show();
			$(this).find("div").css("display","block");
		},
		function(){
			//$(this).find("a").delay(500).hide();
			$(this).children("div").css("display","none");
		}
	);

	//ページトップへ(右Fixed)のロールオーバー
	$("#pageTopRight").hover(
		function(){
			$(this).css("right","0px");
		},
		function(){
			$(this).css("right","-37px");
		}
	);
	
	//ページトップへ(右Fixed)のクリック時
	$("#pageTopRight").click(function(){
		$("html,body").animate({"scrollTop": 0},500,"easeOutQuart");
	});
	
	/*
	//container を表示
	if($("#container").length){
		$("#container").animate({opacity:1},500,"easeInQuart");
	}
	*/
	
	

});


//*******************************************************************************
//　イベント用関数
//*******************************************************************************

$(function(){
	
	
	
});


//*******************************************************************************
//　オーバーレイ関連関数
//*******************************************************************************

//オーバーレイを表示・非表示
var atod_overlay = function(mode){
	if($("#" + atod_overlay_name).length){
		if(mode == "show"){
			
			if(ie === 6){
				$("#" + atod_overlay_name).height($(document).height());
			}
			
			$("#" + atod_overlay_name).show();
		}else{
			$("#" + atod_overlay_name).hide().addClass("pointer").unbind('click');
		}
	}
};

//Loadingを表示
var atod_loading = function(mode){
	if($("#" + atod_loading_name).length){
		if(mode == "show"){
			$("#" + atod_loading_name).show();
		}else{
			$("#" + atod_loading_name).hide();
		}
	}
};

//ダイアログを表示
var atod_dialog = function(mode,html,focus_id,move_url){
	if($("#" + atod_dialog_name).length){
		if(mode == "show"){
			$("#" + atod_dialog_name).html('');
			if(html){
				$("#" + atod_dialog_name).html('<div>'+html+'</div>');
			}
			if(focus_id == 'undefined' || typeof focus_id == 'undefined'){
				focus_id = null;
			}
			if(move_url == 'undefined' || move_url == 'undefined'){
				move_url = null;
			}
			$("#" + atod_dialog_name).append('<div class="pt10 right"><a href="javascript:;" onclick="atod_dialog(\'hide\',\'' + null + '\',\'' + focus_id + '\',\'' + move_url + '\')">閉じる</a></div>');
			// 中央に表示
			set_header_center(atod_dialog_name);
			$("#" + atod_dialog_name).css("opacity",0);
			if(ie === 6){
				$("#" + atod_dialog_name).animate({top:$(window).scrollTop(),opacity:1},500,"easeOutQuart");
			}else{
				$("#" + atod_dialog_name).animate({top:0,opacity:1},500,"easeOutQuart");
			}
		}else{
			var iTop;
			var wTop;
			if(ie === 6){
				iTop = $(window).scrollTop()
			}else{
				iTop = -1 * Math.floor($("#" + atod_dialog_name).outerHeight());
			}
			$("#" + atod_dialog_name).animate({top:iTop,opacity:0},500,"easeOutQuart",function(){
				$(this).css("display","none");
				
				if(typeof move_url != "undefined" && move_url != "undefined" && move_url){
					location.href = move_url;
					return false;
				}
				
				if($("#" + atod_lightbox_name).css("display") != "block"){
					atod_overlay('hide');
					if(focus_id){
						$("#"+focus_id).focus();
						// 現在のスクロールバーの位置
						wTop = $(window).scrollTop();
						$(window).scrollTop(wTop - 110)
					}
				}
			});
		}
	}
};


//lightboxを表示
var atod_lightbox = function(mode,html,focus_id){
	if($("#" + atod_lightbox_name).length){
		if(mode == "show"){
			$("#" + atod_lightbox_name).html('');
			if(html){
				$("#" + atod_lightbox_name).html(html);
			}
			if($("#" + atod_lightbox_name).css("display") != "block"){
				$("#" + atod_lightbox_name).css("opacity",0);
			}
			$("#" + atod_lightbox_name).css("display","block");
			// 横中央に表示
			set_horizon_center("#" + atod_lightbox_name);
			$("#" + atod_lightbox_name).animate({top:$(window).scrollTop()+50,opacity:1},500,"easeOutQuart",function(){
				if(focus_id){
					$("#"+focus_id).focus();
				}
			});
		}else{
			if($("#" + atod_dialog_name).css("display") != "block"){
				$("#" + atod_lightbox_name).animate({top:$(window).scrollTop()+50,opacity:0},500,"easeOutQuart",function(){
					atod_overlay('hide');
					$(this).css("display","none");
					if(focus_id){
						$("#"+focus_id).focus();
					}
				});
			}
		}
	}
};



//ヘッダー中央に表示
var set_header_center = function(box_id){
	
	if(box_id && box_id.indexOf("#") == -1){
		box_id = "#" + box_id;
	}
	
	var iTop;
	
	if(ie === 6){
		iTop = $(window).scrollTop();
	}else{
		iTop = -1 * Math.floor($("#" + atod_dialog_name).outerHeight());
	}
	
	var iLeft 	= Math.floor(($(window).width() - $(box_id).width()) / 2);
	
	$(box_id).css({
		left: iLeft,
		top: iTop,
		display: "block"
	});
	
	return false;
	
}

//画面中央に表示
var set_screen_center = function(box_id){
	
	if(box_id && box_id.indexOf("#") == -1){
		box_id = "#" + box_id;
	}
	
	var iTop 		= Math.floor(($(window).height() - $(box_id).height()) / 2);
	var iLeft 	= Math.floor(($(window).width() - $(box_id).width()) / 2);
	
	$(box_id).css({
		left: iLeft,
		top: iTop
	});
	
	return false;
	
}

//横中央に表示
var set_horizon_center = function(box_id){
	
	if(box_id && box_id.indexOf("#") == -1){
		box_id = "#" + box_id;
	}
	
	var iLeft 	= Math.floor(($(window).width() - $(box_id).width()) / 2);
	
	$(box_id).css({
		left: iLeft
	});
	
	return false;
	
}




//*******************************************************************************
//　windowスクロール
//*******************************************************************************

$(window).scroll(function(){
	if(ie === 6 && $("#" + atod_dialog_name).css("display") == 'block'){
		//$("#" + atod_dialog_name).css("top",$(window).scrollTop());
		set_header_center(atod_dialog_name);
	}
});

//*******************************************************************************
//　windowリサイズ
//*******************************************************************************

$(window).resize(function(){
	//if(ie === 6 && $("#" + atod_dialog_name).css("display") == 'block'){
		//$("#" + atod_dialog_name).css("top",$(window).scrollTop());
		set_screen_center(atod_lightbox_name);
	//}
});


//*******************************************************************************
//　keypress時にオーバーレイが表示されていたらキャンセル
//*******************************************************************************

/*
$(document).keypress(function(e){
	
	if(e.which == 0 && $("#atod-loading-overlay").css("display") != "none"){
		$("#atod-loading-overlay").focus();
		return false;
	}
		
});
*/

//*******************************************************************************
//　フォーム内の値を取得してPOSTでデータを送信
//*******************************************************************************

function makeFormData(box_id){
	var obj = new Object();
	var target;
	var type;
	var key;
	var value;
	var setFlg;
	
	if(box_id && box_id.indexOf("#") == -1){
		box_id = "#" + box_id;
	}
	
	if(box_id){
		target_box_parts = box_id + " .formparts,";
	}else{
		target_box_parts = ".formparts";
	}
	
	$(target_box_parts).each(function(){
		target = $(this);
		type = this.type;
		key = this.name;
		setFlg = true;
		
		if(type.indexOf("checkbox") != -1){
			if(target.attr("checked") == true){
				value = target.val();
			}else{
				value = "";
			}
		}else if(type.indexOf("radio") != -1){
			if(target.attr("checked") == true){
				setFlg = true;
				value = target.val();
			}else{
				setFlg = false;
			}
			
		}else{
			value = target.val();
		}
		
		if(setFlg == true){
			obj[key] = value;
		}
		
		
	});
	
	return obj;
	
}


//*******************************************************************************
//　IDに#をつける処理
//*******************************************************************************

function set_box_id(box_id){
	
	if(box_id && box_id.indexOf("#") == -1){
		box_id = "#" + box_id;
	}
	
	return box_id;
}



//*******************************************************************************
//　画像のアップロード
//*******************************************************************************

function image_upload(input_file_box, tmp_box, delete_box) {
	
	var input_file_box = set_box_id(input_file_box);
	var tmp_box = set_box_id(tmp_box);
	var delete_box = set_box_id(delete_box);
	
	
	var formparts = makeFormData(tmp_box);
	
	$(delete_box).attr("disabled", "disabled");
	
	// ローディングをつける
	$(set_box_id(formparts.src_id)).addClass("image-loading");
	$(set_box_id(formparts.src_id)).attr("src", "/cms/common/img/common/blank.gif");
	
  $(input_file_box).upload(
  	'/cms/api/upload_image.php', 
  	formparts,
  	function(res) {
			if(res.result){
        if(res.upload_tmp_url.thumb && typeof res.upload_tmp_url.thumb != 'undefined'){
					if($("#"+res.post.src_id).length){
						$("#"+res.post.src_id).attr("src", res.upload_tmp_url.thumb);
					}
					if(res.post.form_hidden_name && typeof res.post.form_hidden_name != 'undefined'){
						$("#"+res.post.form_hidden_name).val(res.file_name);
					}
				}
			}else{
				atod_dialog('show',res.errmsg,'','');
				$('#'+atod_overlay_name).addClass("pointer").bind('click',function(){
					atod_dialog('hide',null,'','');
				});
			}
			$(delete_box).removeAttr("disabled");
			$(set_box_id(formparts.src_id)).removeClass("image-loading");
  	}, 
  	'json'
  );
  
  return false;
}

//*******************************************************************************
//　画像の削除
//*******************************************************************************

function image_delete(src_id, hidden_id){
	if(src_id && src_id.indexOf("#") == -1){
		src_id = "#" + src_id;
	}
	if(hidden_id && hidden_id.indexOf("#") == -1){
		hidden_id = "#" + hidden_id;
	}
	
	if($(src_id).length){
		$(src_id).attr("src", "/cms/common/img/common/blank.gif");
	}
	
	if($(hidden_id).length){
		$(hidden_id).val("");
	}
	
	return false;
	
}


//*******************************************************************************
//　ファイルのアップロード
//*******************************************************************************

function file_upload(input_file_box, tmp_box, delete_box) {
	
	var input_file_box = set_box_id(input_file_box);
	var tmp_box = set_box_id(tmp_box);
	var delete_box = set_box_id(delete_box);
	
	
	var formparts = makeFormData(tmp_box);
	
	$(delete_box).attr("disabled", "disabled");
	
	// ローディングをつける
	$(set_box_id(formparts.src_id)).addClass("image-loading");
	
  $(input_file_box).upload(
  	'/cms/api/upload_file.php', 
  	formparts,
  	function(res) {
			if(res.result){
        if(res.upload_tmp_url && typeof res.upload_tmp_url != 'undefined'){
					if($("#"+res.post.src_id).length){
						$("#"+res.post.src_id).html('<a href="'+res.upload_tmp_url+'" target="_blank">'+res.upload_tmp_name+'</a>');
					}
					if(res.post.form_hidden_name && typeof res.post.form_hidden_name != 'undefined'){
						$("#"+res.post.form_hidden_name).val(res.file_name);
					}
				}
			}else{
				atod_dialog('show',res.errmsg,'','');
				$('#'+atod_overlay_name).addClass("pointer").bind('click',function(){
					atod_dialog('hide',null,'','');
				});
			}
			$(delete_box).removeAttr("disabled");
			$(set_box_id(formparts.src_id)).removeClass("image-loading");
  	}, 
  	'json'
  );
  
  return false;
}


//*******************************************************************************
//　ファイルの削除
//*******************************************************************************

function file_delete(src_id, hidden_id){
	if(src_id && src_id.indexOf("#") == -1){
		src_id = "#" + src_id;
	}
	if(hidden_id && hidden_id.indexOf("#") == -1){
		hidden_id = "#" + hidden_id;
	}
	
	if($(src_id).length){
		$(src_id).html('');
	}
	
	if($(hidden_id).length){
		$(hidden_id).val("");
	}
	
	return false;
	
}


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

// ログ出力用関数
function atod_log(obj){
	return window.console.debug(obj);
}
