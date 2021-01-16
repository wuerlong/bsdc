<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>操作成功</title>
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<meta content="telephone=no" name="format-detection"/>
<link href="css/login.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<section class="aui-flexView">
  <header class="aui-navBar aui-navBar-fixed b-line"> <a href="javascript:;" class="aui-navBar-item" onclick="javascript:history.back(-1);"> <i class="icon icon-return"></i> </a>
    <div class="aui-center"> <span class="aui-center-title">操作成功</span> </div>
  </header>
  <section class="aui-scrollView">
    <div class="aui-code-box">
      <div><img src="images/submit.png" ></div>
      <div class="aui-code-btn">
        <button id="login_btu">返回</button>
      </div>
    </div>
  </section>
</section>
<script type="text/javascript">
$('#login_btu').click(function() {
	window.location.href = 'index.php';
});
</script>
</body>
</html>
