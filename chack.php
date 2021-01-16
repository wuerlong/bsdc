<?php
 include_once 'global.php';

 //$order_list = $db->findAll("select * from phpaadb_order where tel = '" . $tel."' and num > 0 order by id desc");
  $friendlink = $db->find("select * from phpaadb_friendlink where state = 0 order by id desc");
 
$sttime = $friendlink['tel'].' 00:00:00';
$entime = $friendlink['worktime'].' 00:00:00';
$starttime = strtotime($sttime);
$endtime = strtotime($entime);


$timelist = array($friendlink['tel']);
$timeli = $starttime;
for ($x=0; $x<=10; $x++) {
	$timeli = $timeli + 86400;
	if($timeli<=$endtime){
		$timelo = date('Y-m-d',$timeli);
		array_push($timelist,$timelo);
	}
}

$orderlist = $db->findAll("select * from phpaadb_order where type = 1 order by state desc ");


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
<script type="text/javascript">
function doAction(a,id,v){
	if(a=='validate'){
		$.ajax({
			url:'research.action.php',
			type: 'POST',
			data:'act=validate&id='+id+'&validate='+v,
			success: function(data){
				window.location.href = window.location.href;
			}
		});
	}
	if(a=='delete'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'research.action.php',
				type: 'POST',
				data:'act=delete&id='+id,
				success: function(data){
					if(data) alert('删除成功');
					window.location.href = window.location.href;
				}
			});
		}
	}
	
	if(a=='deleteAll'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'research.action.php',
				type: 'POST',
				data:'act=delete&id='+getCheckedIds('checkbox'),
				success: function(data){
					if(data) alert('删除成功');
					window.location.href = window.location.href;
				}
			});
		}
	}
}

</script>
</head>
<body>
<section class="aui-flexView">
  <header class="aui-navBar aui-navBar-fixed b-line">
    <div class="aui-center"> <span class="aui-center-title">审核列表</span> </div>
    <!--<a href="add.php" class="aui-navBar-item"> <i class="icon icon-sys"></i>加餐 </a> --> </header>
  <section class="aui-scrollView">
    <div> <img src="images/banner.jpg" width="100%" > </div>
    <div class="aui-login-line">
      <h2>最近一周加餐审核列表</h2>
    </div>
    <?php
	foreach ($orderlist as $list){
  ?>
    <div class="underline">
      <?php if($list['type']==0){?>
      <span>正常（<?php echo $list['num'];?>份）</span>
      <?php }else{?>
      <span>加餐（
      <?php if($list['state']==0){?>
      已审核
      <?php }else{?>
      审核中
      <?php }?>
      ）</span>
      <?php }?>
      时间：<?php echo $list['picktime'];?><br>
      人数： <?php echo $list['num'];?><br>
      单位信息： <?php echo $list['company'];?> <br>
      餐费标准： <?php echo $list['level'];?><br>
      理由： <?php echo $list['beizhu'];?>
      <div class="aui-code-box" style="padding:0">
      <div class="aui-code-btn" style="padding:0">
        <button type="button"  name="chack" onClick="doAction('validate',<?php echo $list['id'];?>,0)">审核</button>
      </div>
    </div>
      </div>
    
    <?php
	}
  ?>
  </section>
</section>
</body>
</html>
