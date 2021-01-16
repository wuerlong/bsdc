<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>加餐</title>
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
    <div class="aui-center"> <span class="aui-center-title">加餐</span> </div>
  </header>
  <section class="aui-scrollView">
    <div class="aui-code-box">
      <form  action="add.action.php" method="post" enctype="multipart/form-data" name="form1">
        <p class="aui-code-line">
          <input type="text" class="aui-code-line-input" name="num" value="" id="num"  placeholder="来访人数"/>
        </p>
        <p class="aui-code-line">
          <input type="text" class="aui-code-line-input" name="company" value="" id="company" autocomplete="off" placeholder="单位信息"/>
        </p>
        <p class="aui-code-line">
          <input type="date" class="aui-code-line-input" name="picktime" value="" id="picktime"  placeholder="来访日期"/>
        </p>
        <p class="aui-code-line">
          <select class="aui-code-line-input" name="level" id="level">
            <option value="">请选择餐费标准</option>
            <option value="12元">12元</option>
            <option value="15元">15元</option>
            <option value="20元">20元</option>
          </select>
        </p>
        <p class="aui-code-line">
          <input type="text" id="beizhu" name="beizhu" class="aui-code-line-input" placeholder="来访事由" value="">
        </p>
        <div class="aui-code-btn">
          <button id="register">加餐</button>
        </div>
      </form>
    </div>
  </section>
</section>
<script type="text/javascript" src="js/register.js"></script>
</body>
</html>
