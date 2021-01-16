<?php
 include_once 'global.php';
 

 $friendlink = $db->find("select * from phpaadb_friendlink where state = 1 order by id desc");
 
 if(!$friendlink){
	 exit("<script>alert('点餐时间暂未开启!');window.history.go(-1)</script>");
 }
 
$sttime = $friendlink['tel'].' 00:00:00';
$entime = $friendlink['worktime'].' 00:00:00';
$starttime = strtotime($sttime);
$endtime = strtotime($entime);


$timelist = array($friendlink['tel']);
$timeli = $starttime;
for ($x=0; $x<=11; $x++) {
	$timeli = $timeli + 86400;
	if($timeli<=$endtime){
		$timelo = date('Y-m-d',$timeli);
		if($timelo=='2020-06-25' || $timelo=='2020-06-26' || $timelo=='2020-06-27' || $timelo=='2020-09-26' || $timelo=='2020-10-01' || $timelo=='2020-10-02' || $timelo=='2020-10-03' || $timelo=='2020-10-04' || $timelo=='2020-10-05' || $timelo=='2020-10-06' || $timelo=='2020-10-07' || $timelo=='2020-10-08'){
			
		}else{
			array_push($timelist,$timelo);
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
<meta content="telephone=no" name="format-detection"/>
<title>点餐平台</title>
<link rel="stylesheet" type="text/css" href="css/reset.css"/>
<link rel="stylesheet" type="text/css" href="css/index.css"/>
<link href="css/login.css" rel="stylesheet" type="text/css"/>
</head>
<body style="overflow-y:auto;">
<section class="aui-flexView"> 
  <!--头部-->
  <header class="aui-navBar aui-navBar-fixed b-line"> <a href="javascript:;" class="aui-navBar-item" onclick="javascript:history.back(-1);"> <i class="icon icon-return"></i> </a>
    <div class="aui-center"> <span class="aui-center-title" style="font-size:0.60rem">点餐</span> </div>
    <a href="ordercontent.php" class="aui-navBar-item"> <i class="icon icon-sys"></i>本周菜单 </a>
  </header>
  <!--头部--> 
  <!--主题-->
  <div class="con">
    <div class="content">
      <div class="list">
        <p>可选择时间</p>
      </div>
      <ul ind="0">
	  
	  <li>早餐</li>
	  <?php
	foreach ($timelist as $list){
  ?>
      
        <li class="clearfix orderlist">
          <div class="label fl">
            <label style="display:none;">
              <input style="display:none;" type="checkbox" checked="checked" name="checkbox"
					value="<?php echo $list;?>早餐" onClick="checkDeleteStatus('checkbox')"/>
              <img src="c_checkbox_on.png"/> </label>
          </div>
          <div class="text fl">
            <p class="overflow"><?php echo $list;?></p>
            <p class="clearfix"> <span class="fl red">￥4</span> <span class="fr">
              <input type="button" value="-" class="btn1" />
              <span class="number">1</span>
              <input type="button" value="+"  class="btn2"/>
              </span> </p>
          </div>
        </li>
   <?php
	}
  ?>   
	  <li>午餐</li>
<?php
	foreach ($timelist as $list){
  ?>
      
        <li class="clearfix orderlist">
          <div class="label fl">
            <label style="display:none;">
              <input style="display:none;" type="checkbox" checked="checked" name="checkbox"
					value="<?php echo $list;?>午餐" onClick="checkDeleteStatus('checkbox')"/>
              <img src="c_checkbox_on.png"/> </label>
          </div>
          <div class="text fl">
            <p class="overflow"><?php echo $list;?></p>
            <p class="clearfix"> <span class="fl red">￥12</span> <span class="fr">
              <input type="button" value="-" class="btn1" />
              <span class="number">1</span>
              <input type="button" value="+"  class="btn2"/>
              </span> </p>
          </div>
        </li>
   <?php
	}
  ?>     

        
      </ul>
      <p class="total">一共
        <number></number>
        份：<span></span></p>
    </div>
  </div>
  <!--主题--> 
  <!--结算-->
  <div class="bottom fixed">
    <div class="fr"> 点餐金额：<span></span>
      <button class="sett">提交</button>
    </div>
  </div>
  <!--结算--> 
</section>
<!--删除-->
<div class="bottom fixed" style="display: none;">
  <div class="fr">
    <button class="delete">删除</button>
  </div>
</div>
<!--删除--> 
<!--弹框-->
<div class="text1 fixed">
  <form>
    <input type="number"/>
    <input type="button"  value="确定"/>
  </form>
</div>
<!--弹框--> 
<!--弹框2-->
<div class="alert fixed"></div>
<!--弹框2--> 
<script src="js/web.js"></script> 
<script src="js/zepto.js"></script> 
<script src="js/index.js"></script>
</body>
</html>
