$('#login_btu').click(function() {
	var tel = $.trim($('#tel').val());
	var username = $.trim($('#username').val());
	if (!isPhoneNo(tel)) {
		alert("请输入有效的手机号码");
		$("#tel").focus();
		return false;
	}
	if(username==""){
		alert("姓名不能为空");
		$("#name").focus();
		return false;
	}
	
	
	

});
// 验证手机号
function isPhoneNo(phone) { 
	 var pattern = /^1[3456789]\d{9}$/; 
	 
	 return pattern.test(phone); 
}