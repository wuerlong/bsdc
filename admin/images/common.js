//*******************************************************************************
//　マスタの検索項目の表示・非表示
//*******************************************************************************

function toggleSearchColumn(){
	if($("#tableSearchColumn").css("display") == "block"){
		hideSearchColumn();
	}else{
		showSearchColumn();
	}
	return false;
}

function showSearchColumn(){
	
	// 対象カラム選択エリアを表示
	$("#tableSearchColumn").slideDown('fast');
	
	return false;
	
}

function hideSearchColumn(){
	
	// 対象カラム選択エリアを表示
	$("#tableSearchColumn").slideUp('fast');
	
	return false;
	
}


//*******************************************************************************
//　マスタの更新
//*******************************************************************************

function master_edit(target_url, target_box_id){
  var options = { 
		dataType: "json",
		url: target_url,
		type: 'post',
		success: function(res){

			if(res.result && res.action == "delete"){
				if (res.page) {
					var url = res.page + ".php";
				} else  {
					var url = "./";
				}
				
				atod_dialog('show',res.html,null, url);
				$('#'+atod_overlay_name).addClass("pointer").bind('click',function(){
					atod_dialog('hide',null,res.focus_id, url);
				});
				$(":file").removeAttr("disabled");
				return false;
			}else{
				if($("#lastInsertId").attr("name") && res.result && res.lastInsertId){
					if (!res.page) {
						var url = "edit.php?"+ $("#lastInsertId").attr("name") +"="+res.lastInsertId;
					} else  {
						var url = res.page + ".php?"+ $("#lastInsertId").attr("name") +"="+res.lastInsertId;
					}
					
				}else{
					if (res.page && res.result) {
						var url = res.page + ".php";
					} else  {
						var url = "";
					}
				}
				atod_dialog('show',res.html,res.focus_id,url);
				$('#'+atod_overlay_name).addClass("pointer").bind('click',function(){
					atod_dialog('hide',null,res.focus_id,url);
				});
				$(":file").removeAttr("disabled");
				return false;
			}
			
			if(res.lastInsertId){
				if($("#primary_key").length){
					$("#primary_key").text(res.lastInsertId);
				}
				if($("#lastInsertId").length){
					$("#lastInsertId").val(res.lastInsertId);
				}
				if($("#action").length){
					$("#action").val("update");
				}
				if($("#edit_mode_str").length){
					$("#edit_mode_str").text("編集");
				}
			}
			
			$(":file").removeAttr("disabled");
			
			return false;
		},
		beforeSubmit: function(){
			var confirmStr 	= null;
			var delete_flg 	= $("#delete_flg").attr("checked");
			var action			= $("#action").val();
			
			switch(action){
				case "insert":
					confirmStr = "新規登録を実行してもよろしいですか？";
					break;
				case "update":
				default:
					
					if(delete_flg){
						confirmStr = "削除を実行してもよろしいですか？";
					}else{
						confirmStr = "更新を実行してもよろしいですか？";
					}
					
			}
			
			if(!confirm(confirmStr)){
				return false;
			}
			
			$(":file").attr("disabled","disabled");

		}
	};
	$('#'+target_box_id).ajaxSubmit(options);
}


//*******************************************************************************
//　マスタの画像登録
//*******************************************************************************

function master_image_edit(target_url, target_box_id){
  var options = { 
		dataType: "json",
		url: target_url,
		type: 'post',
		success: function(res){
			
			if(res.result && res.action == "delete"){
				atod_dialog('show',res.html,null, "./");
				$('#'+atod_overlay_name).addClass("pointer").bind('click',function(){
					atod_dialog('hide',null,res.focus_id, "./");
				});
				$(":file").removeAttr("disabled");
				return false;
			}else{
				if($("#lastInsertId").attr("name") && res.result && res.lastInsertId){
					var url = "edit.php?"+ $("#lastInsertId").attr("name") +"="+res.lastInsertId;
				}else{
					var url = "";
				}
				atod_dialog('show',res.html,res.focus_id,url);
				$('#'+atod_overlay_name).addClass("pointer").bind('click',function(){
					atod_dialog('hide',null,res.focus_id,url);
				});
				$(":file").removeAttr("disabled");
				return false;
			}
			
			$(":file").removeAttr("disabled");
			
			return false;
		},
		beforeSubmit: function(){
			var confirmStr 	= null;
			var delete_flg 	= $("#delete_flg").attr("checked");
			var action			= $("#action").val();
			
			confirmStr = "登録を実行してもよろしいですか？";
			
			if(!confirm(confirmStr)){
				return false;
			}
			
			$(":file").attr("disabled","disabled");
			
		}
	};
	$('#'+target_box_id).ajaxSubmit(options);
}


