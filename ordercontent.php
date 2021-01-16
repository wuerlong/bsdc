<?php
 include_once 'global.php';
 

 $friendlink = $db->find("select * from phpaadb_friendlink where state = 0 order by id desc");

$friendlink['content'] =  str_replace("\n","<br />", $friendlink['content']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>学院点餐</title>
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<meta content="telephone=no" name="format-detection"/>
<link href="css/login.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<style type="text/css">
        .contentcc img{
            width:100%;
        }
    </style>
</head>
<body>
<section class="aui-flexView">
  <header class="aui-navBar aui-navBar-fixed b-line">
  <a href="javascript:;" class="aui-navBar-item" onclick="javascript:history.back(-1);"> <i class="icon icon-return"></i> </a>
    <div class="aui-center"> <span class="aui-center-title">本周菜单</span> </div>
     </header>
  <section class="aui-scrollView">
    <div class="aui-login-line">
      <h2>本周菜单</h2>
    </div>
    <div class="contentcc" style="text-align:center; padding-top:20px;"><?php echo $friendlink['content'];?></div>
    <div class="aui-code-box">
      <div class="aui-code-btn">
        <button type="button" id="order">点餐</button>
      </div>
    </div>
  </section>
</section>
<script type="text/javascript">
$('#order').click(function() {
	window.location.href = 'order.php';
});
</script>
</body>
</html>
