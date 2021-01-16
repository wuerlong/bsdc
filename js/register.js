$("#register").click(function(){
			
	var num = $.trim($('#num').val());
	var company = $.trim($('#company').val());
	var picktime=$.trim($("#picktime").val());
	var level=$.trim($("#level").val());
	if(num==""){
		alert("来访人数不能为空");
		$("#name").focus();
		return false;
	}
	if(company=="")
	  {
	   alert("单位信息不能为空");
	   $("#email").focus();
	   return false;
	  }
	if(picktime=="")
	  {
	   alert("来访日期不能为空");
	   $("#email").focus();
	   return false;
	  }
	if(level=="")
	  {
	   alert("餐费标准不能为空");
	   $("#email").focus();
	   return false;
	  }

	
});