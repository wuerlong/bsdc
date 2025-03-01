$(function(){
	var delParent;
	var defaults = {
		fileType : ["jpg","png","bmp","jpeg"],   // 上传文件的类型
		fileSize : 1024 * 1024 * 2               // 上传文件的大小 10M
	};
	/*点击图片的文本框*/
	$(".file").change(function(){	 
		var idFile = $(this).attr("id");
		var file = document.getElementById(idFile);
		var imgContainer = $(this).parents(".z_photo"); //存放图片的父亲元素
		var fileList = file.files; //获取的图片文件
		var input = $(this).parent();//文本框的父亲元素
		var imgArr = [];
		//遍历得到的图片文件
		var numUp = imgContainer.find(".up-section").length;
		var totalNum = numUp + fileList.length;  //总的数量
		if(fileList.length > 2 || totalNum > 2 ){
			alert("上传图片数目不可以超过2个，请重新选择");
		}else if(numUp < 2){
			fileList = validateUp(fileList);
			for(var i = 0;i<fileList.length;i++){
				var imgUrl = window.URL.createObjectURL(fileList[i]);
				    imgArr.push(imgUrl);
				var $section = $("<section class='up-section fl loading'>");
				    imgContainer.prepend($section);
				var $span = $("<span class='up-span'>");
				    $span.appendTo($section);
				
			    var $img0 = $("<img class='close-upimg'>").on("click",function(event){
					   event.preventDefault();
						event.stopPropagation();
						$(".works-mask").css("display","flex");
						delParent = $(this).parent();
					});   
					$img0.attr("src","img/a7.png").appendTo($section);
			    var $img = $("<img class='up-img up-opcity'>");
			        $img.attr("src",imgArr[i]);
			        $img.appendTo($section);
			    var $p = $("<p class='img-name-p'>");
			        $p.html(fileList[i].name).appendTo($section);
			    var $input = $("<input id='taglocation' name='taglocation' value='' type='hidden'>");
			        $input.appendTo($section);
			    var $input2 = $("<input id='tags' name='tags' value='' type='hidden'/>");
			        $input2.appendTo($section);
		    }
		}
		setTimeout(function(){
             $(".up-section").removeClass("loading");
		 	 $(".up-img").removeClass("up-opcity");
		},450);
		numUp = imgContainer.find(".up-section").length;
		if(numUp >= 2){
			$(this).parent().hide();
			$(".step_2_btn").addClass("btn-active"); 
		}
		
		//当有图片时，改变css
		if($(".up-section").length > 0){
			$(".z_photo").css("justify-content","space-between");
		}else{
			$(".z_photo").css("justify-content","center");
		}
	});

    $(".z_photo").delegate(".close-upimg","click",function(){
     	$(".works-mask").show();
     	delParent = $(this).parent();
	});
		
	$(".wsdel-ok").click(function(){
		$(".works-mask").hide();
		var numUp = delParent.siblings().length;
		if(numUp < 3){
			delParent.parent().find(".z_file").show();
		}
		delParent.remove();
		
		if($(".up-section").length < 2){
			$(".step_2_btn").removeClass("btn-active");
		}
		//当有图片时，改变css
		if($(".up-section").length > 0){
			$(".z_photo").css("justify-content","space-between");
		}else{
			$(".z_photo").css("justify-content","center");
		}
	});
	
	$(".wsdel-no").click(function(){
		$(".works-mask").hide();
	});
		
	function validateUp(files){
		var arrFiles = [];//替换的文件数组
		for(var i = 0, file; file = files[i]; i++){
			//获取文件上传的后缀名
			var newStr = file.name.split("").reverse().join("");
			if(newStr.split(".")[0] != null){
				var type = newStr.split(".")[0].split("").reverse().join("");
				console.log(type+"===type===");
				if(jQuery.inArray(type, defaults.fileType) > -1){
					// 类型符合，可以上传
					if (file.size >= defaults.fileSize) {
						alert1(file.size);
						alert1('上传的图片不能超过2MB');	
					} else {
						// 在这里需要判断当前所有文件中
						arrFiles.push(file);	
					}
				}else{
					alert1('图片仅支持jpg、png、bmp、jpeg格式');	
				}
			}else{
				alert1('未知的文件');	
			}
		}
		return arrFiles;
	}
	function alert1(e) {
        $(".mask_box").css("display","flex");
        $(".box0").text(e);

        setTimeout(function() {
            $(".mask_box").css("display","none");
        }, 1500)
    }
})
