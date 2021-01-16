<?php
	
 include_once 'global.php';

if(!$openid){
	header("Location: code/");
	exit();
}


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户绑定</title>
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<meta content="telephone=no" name="format-detection"/>
<link href="css/login.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<section class="aui-flexView">
  <header class="aui-navBar aui-navBar-fixed b-line">
    <div class="aui-center"> <span class="aui-center-title">用户绑定</span> </div>
  </header>
  <section class="aui-scrollView">
    <div class="aui-code-box">
      <form  action="user.action.php" method="post" enctype="multipart/form-data" name="form1">
        <p class="aui-code-line">
          <input type="text" class="aui-code-line-input" value="" name="tel" id="tel" autocomplete="off" placeholder="请输入您的手机号"/>
        </p>
        <p class="aui-code-line aui-code-line-clear">
          <input type="text" class="aui-code-line-input" value="" name="username" id="username" autocomplete="off" placeholder="请输入您的姓名"/>
        </p>
        <div class="aui-code-btn">
          <button id="login_btu">提交</button>
        </div>
      </form>
    </div>
  </section>
</section>
<script type="text/javascript" src="js/login.js"></script>
</body>
</html>
