//*******************************************************************************
//　html読み込み完了時の動作
//*******************************************************************************

$(document).ready(function(){
	//　プルダウンメニューの表示
	$("#menu li").hover(function() {
		$(this).children('ul').show();
	}, function() {
		$(this).children('ul').hide();
	});
	
	/*
	// Font set
	var ua = navigator.userAgent;
	
	// Mac
	if (ua.match(/Mac|PPC/)){
		$("body").css("fontFamily", "'ヒラギノ角ゴ Pro W3','Hiragino Kaku Gothic Pro', Osaka, Helvetica, 'Arial Black', sans-serif");
	
	// Windows Server 2003, Windows XP 以下
	}else if(ua.match(/Win(dows )?95/) || ua.match(/Win(dows )?NT( 4\.0)/) || ua.match(/Win(dows )?98/) || ua.match(/Win(dows )?(NT 5\.0|2000)/) || ua.match(/Win(dows)? (9x 4\.90|ME)/) || ua.match(/Win(dows )?(NT 5\.1|XP)/) || ua.match(/Win(dows )?NT 5\.2/)){
		$("body").css("fontFamily", "'ＭＳ Ｐゴシック', 'MS PGothic', Helvetica,'ヒラギノ角ゴ Pro W3', 'Hiragino Kaku Gothic Pro', meiryo, Osaka, sans-serif");
	
	}
	*/
	
});


//*******************************************************************************
//　イベント用関数
//*******************************************************************************

$(function(){
	
});


//*******************************************************************************
//　イベント用関数
//*******************************************************************************

//テキストボックス・テキストエリアにフォーカスが入ったときの処理
function myFocus(){
	$(":text, textarea").focus(function(){
		$(this).addClass("focus");
	});
}

//テキストボックス・テキストエリアにフォーカス無くなったときの処理
function myBlur(){
	//テキストボックス・テキストエリアにフォーカス無くなったときの処理
	$(":text, textarea").blur(function(){
		$(this).removeClass("focus");
	});
}

//*******************************************************************************
//　frmSubmit処理(確認なし)
//*******************************************************************************

function frmSubmit(frm,url){

	document.getElementById(frm).action = url;
	document.getElementById(frm).submit();
	return true;

}


//*******************************************************************************
//　frmSubmit処理(確認あり)
//*******************************************************************************

function frmSubmitConfirm(frm,url){

	if(window.confirm("実行してもよろしいですか？")){
		document.getElementById(frm).action = url;
		document.getElementById(frm).submit();
		return true;
	}
	
	return false;
	
}


//*******************************************************************************
//　アイテム削除時の確認
//*******************************************************************************

function itemDel(actionurl) {
	
	if(actionurl){
		if(window.confirm("画像削除を実行してもよろしいですか？")){
			window.location.href = actionurl;
			return true;
		}
	}
	
	return false;
	
}


//*******************************************************************************
//　エンターキー押下でもsubmitさせない
//*******************************************************************************

function BlockEnter(evt){
	evt = (evt) ? evt : event; 
	var charCode=(evt.charCode) ? evt.charCode : 
		((evt.which) ? evt.which : evt.keyCode);
	if ( Number(charCode) == 13 || Number(charCode) == 3) {
		return false;
	} else {
		return true;
	}
}

function attachBlockEnter(formid) {
	var elements = document.getElementById(formid).elements;
	for (var j=0; j < elements.length; j++) {
		var e = elements[j];	
		if (e.type == "text"){
			e.onkeypress=BlockEnter;
		}
	}
	
	return false;
}



//*******************************************************************************
//　ロールオーパー
//*******************************************************************************

function initRollOverImages() {  
	var image_cache = new Object();  
	$(".rollover").not("[@src*='_on.']").each(function(i) {  
		var imgsrc = this.src;  
		var dot = this.src.lastIndexOf('.');  
		var imgsrc_on = this.src.substr(0, dot) + '_on' + this.src.substr(dot, 4);  
		image_cache[this.src] = new Image();  
		image_cache[this.src].src = imgsrc_on;  
		$(this).hover(  
			function() { this.src = imgsrc_on; },  
			function() { this.src = imgsrc; }  
		);  
	});  
}





//*******************************************************************************
//　リンク
//*******************************************************************************

function jump(url,target){
	
	if(url){
		
		if(target){
			window.open(url,target);
		}else{
			location.href = url;
		}
		
		return true;
	}else{
		return false;
	}
}


//*******************************************************************************
//　windowの高さを取得する関数
//*******************************************************************************

function getWindowHeight(){
	
	//Window Area
	if (self.innerHeight) {	// all except Explorer
		if(document.documentElement.clientWidth){
			windowWidth = document.documentElement.clientWidth; 
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	
	return windowHeight;
}


//*******************************************************************************
//　scrollの高さを取得する関数
//*******************************************************************************

function getScrollHeight(){
	
	//Scroll Area
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	//Window Area
	if (self.innerHeight) {	// all except Explorer
		if(document.documentElement.clientWidth){
			windowWidth = document.documentElement.clientWidth; 
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

	// Set pageHeight
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// Set pageWidth
	if(xScroll < windowWidth){	
		pageWidth = xScroll;		
	} else {
		pageWidth = windowWidth;
	}
	
	// lightboxalertbg Width
	if(pageWidth >= windowWidth){
		largestWidth = pageWidth; smallestWidth = windowWidth;
	}else{
		largestWidth = windowWidth; smallestWidth = pageWidth;
	}

	// lightboxalertbg Height
	if(pageHeight >= windowHeight){
		largestHeight = pageHeight; smallestHeight = windowHeight;
	}else{
		largestHeight = windowHeight; smallestHeight = pageHeight;
	}
	
	return largestHeight;
}


//*******************************************************************************
//　ajaxFileUpload (登録・更新時)
//*******************************************************************************

var IMG_ROOT     = "/upload/";
var IMG_TMP      = "/cms/upload/";
var NoImagePath  = "/cms/common/img/common/";
var NoImageName  = "noimage.jpg";

function ajaxFileUpload(targetForm,fileId){
	
	if(targetForm.indexOf("#") == -1){
		targetForm = "#" + targetForm;
	}
	
	var mode            = $(targetForm + " input[name=mode]").val();
	var relation_id     = $(targetForm + " input[name=relation_id]").val();
	var image_dir       = $(targetForm + " input[name=image_dir]").val();
	var image_category  = $(targetForm + " input[name=image_category]").val();
	var image_num       = $(targetForm + " input[name=image_num]").val();
	var image_width     = $(targetForm + " input[name=image_width]").val();
	var image_height    = $(targetForm + " input[name=image_height]").val();
	var image_id        = $(targetForm + " input[name=image_id]").val();
	var token           = $("input[name=token]").val();
	
	var action_url      = $(targetForm).attr('action');
	var img_path        = "";
	
	if(typeof(action_url) == 'undefined'){
		action_url = $(targetForm + " input[name=action_url]").val();
	}
	
	$.ajaxFileUpload
	(
		{
			url           :	action_url,
			secureuri     : false,
			fileElementId : fileId,
			mode          : mode,
			relation_id   : relation_id,
			image_dir     : image_dir,
			image_category: image_category,
			image_num     : image_num,
			token         : token,
			dataType      : 'json',
			success       : function (data, status)
			{
				if(typeof(data.errmsg) != 'undefined'){
					if(data.errmsg != '' && data.errmsg != null){
						alert("プログラムエラーが発生しました。\n" + data.errmsg);
					}else{
						//alert("ファイルをアップロードしました。\n" + data.msg);
						if(image_id){
							if(mode == "uploadmove"){
								if(image_width && image_height){
									img_path = IMG_ROOT + image_dir + "/" + image_width + "x" + image_height + "_" + data.result;
								}else{
									img_path = IMG_ROOT + image_dir + "/" + data.result;
								}
							}else if(mode == "upload"){
								if(image_width && image_height){
									img_path = IMG_TMP + image_width + "x" + image_height + "_" + data.result;
								}else{
									img_path = IMG_TMP + image_dir + "/" + data.result;
								}
							}
							
							if(img_path){
								$("#"+image_id).attr("src",img_path);
							}
							
						}
						
						//input type="file" を新しいものに差し替え
						newInputFile(targetForm,fileId,data.result);
					}
				}
			},
			error         : function (data, status, e){
				alert("通信中にエラーが発生しました。\n" + e);
			}
		}
	);
	
	return false;

}


//*******************************************************************************
//　ajaxFileDelete (削除時)
//*******************************************************************************

function ajaxFileDelete(targetForm,fileId){
	
	if(targetForm.indexOf("#") == -1){
		targetForm = "#" + targetForm;
	}
	
	var mode            = $(targetForm + " input[name=mode]").val();
	var relation_id     = $(targetForm + " input[name=relation_id]").val();
	var image_dir       = $(targetForm + " input[name=image_dir]").val();
	var image_category  = $(targetForm + " input[name=image_category]").val();
	var image_num       = $(targetForm + " input[name=image_num]").val();
	var image_width     = $(targetForm + " input[name=image_width]").val();
	var image_height    = $(targetForm + " input[name=image_height]").val();
	var image_id        = $(targetForm + " input[name=image_id]").val();
	var token           = $("input[name=token]").val();
	
	var action_url      = $(targetForm).attr('action');
	var img_path        = "";
	
	if(typeof(action_url) == 'undefined'){
		action_url = $(targetForm + " input[name=action_url]").val();
	}
	
	//削除モードの設定
	if(mode == 'uploadmove'){
		mode = "delete";
	}else{
		mode = "tmp_delete";
	}
	
	var curImage = $("#"+image_id).attr("src");
	
	if(curImage.indexOf("noimage") == -1){
		$.postJSON(
			action_url,
			{
				mode          : mode,
				relation_id   : relation_id,
				image_dir     : image_dir,
				image_category: image_category,
				image_num     : image_num,
				token         : token
			},
			function(data){
				if(typeof(data.errmsg) != 'undefined'){
					if(data.errmsg != '' && data.errmsg != null){
						alert("プログラムエラーが発生しました。\n" + data.errmsg);
						return false;
					}else{
						if(data.result){
							//alert("ファイルを削除しました。\n" + data.msg);
							if(image_width && image_height){
								img_path = NoImagePath + image_width + "x" + image_height + "_" + NoImageName;
							}else{
								img_path = NoImagePath + NoImageName;
							}
							$("#"+image_id).attr("src",img_path)
							return true;
						}else{
							alert("不明なエラーが発生しました。管理者に問い合わせて下さい。");
							return false;
						}
						
						//input type="file" を新しいものに差し替え
						newInputFile(targetForm,fileId,data.result);
						
					}
				}
				
				return false;
				
			}
		);
		
		return true;
	}else{
		alert("画像が登録されていないため削除はできません。");
		return false;
	}

}


//*******************************************************************************
//　input type="file" を新しいものに差し替え
//*******************************************************************************

function newInputFile(targetForm,fileId,image_name){
	
	var id = fileId;
	
	if(fileId.indexOf("#") == -1){
		fileId = "#" + fileId;
	}
	
	var hiddenId = fileId.replace("pic","hidden");
	
	var name   = $(fileId).attr("name");
	var myclass  = $(fileId).attr("class");
	var size   = $(fileId).attr("size");
	var parent = $(fileId).parent();
	var myonchange = $(targetForm + " input[name=btn_upload]").attr("onclick");
	
	if(image_name && $(hiddenId).attr("name")){
		$(hiddenId).val(image_name);
	}
	
	html = '<input type="file" name="' + name + '" size="' + size + '" class="' + myclass + '" id="' + id + '" />';
	
	$(fileId).remove();
	$(parent).prepend(html);
	if(typeof myonchange == 'function'){
		$(fileId).bind("change",myonchange);
	}
}


//*******************************************************************************
//　フォーム内の値を取得してPOSTでデータを作成
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

//*******************************************************************************
//　NAVIGATION
//*******************************************************************************

$(function(){
	
	var params = {height:"toggle", opacity:"toggle"};
	var second = 550;

	//
	$('#accordionBtn').toggle(function(){
		$(this).next('div').animate(params,second);
		$('#btnHover').fadeIn(second);
	},
	  function(){
		$(this).next('div').animate(params,second);
		$('#btnHover').hide();
   });
});


