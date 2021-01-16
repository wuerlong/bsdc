<?php
 include_once 'global.php';

 if(!$uid){
	 header("Location: login.php");
	 exit();
 }
 //echo $uid;
 //$order_list = $db->findAll("select * from phpaadb_order where tel = '" . $tel."' and num > 0 order by id desc");
 
 $friendlink_list = $db->findAll("select * from phpaadb_friendlink order by id desc limit 0 ,2");
 
// print_r($friendlink_list);

  $order_list = $db->findAll("select * from phpaadb_order where tel = '" . $tel."' and pickortime >= '".$friendlink_list[1]['tel']."' and pickortime <= '".$friendlink_list[0]['worktime']."'  order by id desc limit 0,22");
  
  
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
	if(a=='deleteAll'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'friendlink.action.php',
				type: 'POST',
				data:'act=delete&id='+getCheckedIds('checkbox'),
				success: function(data){
					if(data) alert(data);
					window.location.href = window.location.href;
				}
			});
		}
	}
	if(a=='delete'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'friendlink.action.php',
				type: 'POST',
				data:'act=delete&id='+id,
				success: function(data){
					if(data) alert(data);
					window.location.href = window.location.href;
				}
			});
		}
	}
	if(a=='validate'){
		$.ajax({
			url:'friendlink.action.php',
			type: 'POST',
			data:'act=validate&id='+id+'&state='+v,
			success: function(data){
				if(data) alert('操作成功');
				window.location.href = window.location.href;
			}
		});
	}
}
//全选/取消
function checkAll(o,checkBoxName){
	var oc = document.getElementsByName(checkBoxName);
	for(var i=0; i<oc.length; i++) {
		if(o.checked){
			oc[i].checked=true;	
		}else{
			oc[i].checked=false;	
		}
	}
	checkDeleteStatus(checkBoxName)
}

//检查有选择的项，如果有删除按钮可操作
function checkDeleteStatus(checkBoxName){
	var oc = document.getElementsByName(checkBoxName);
	for(var i=0; i<oc.length; i++) {
		if(oc[i].checked){
			document.getElementById('DeleteCheckboxButton').disabled=false;
			return;
		}
	}
	document.getElementById('DeleteCheckboxButton').disabled=true;
}

//获取所有被选中项的ID组成字符串
function getCheckedIds(checkBoxName){
	var oc = document.getElementsByName(checkBoxName);
	var CheckedIds = "";
	for(var i=0; i<oc.length; i++) {
		if(oc[i].checked){
			if(CheckedIds==''){
				CheckedIds = oc[i].value;	
			}else{
				CheckedIds +=","+oc[i].value;	
			}
			
		}
	}
	return CheckedIds;
}
</script>
</head>
<body>
<section class="aui-flexView">
  <header class="aui-navBar aui-navBar-fixed b-line">
    <div class="aui-center"> <span class="aui-center-title">我的点餐列表</span> </div>
    <!--a href="add.php" class="aui-navBar-item"> <i class="icon icon-sys"></i>加餐 </a-->&nbsp;&nbsp;<?php if($uid == 147){?><!--a href="chack.php" class="aui-navBar-item"> <i class="icon icon-sys"></i>审核 </a--><?php }?> </header>
  <section class="aui-scrollView">
    <div> <img src="images/banner.jpg" width="100%" > </div>
    
    
    <div class="aui-login-line">
      <h2>最近一周订餐列表</h2>
    </div>
    <?php
	foreach ($order_list as $list){
  ?>
    <div class="underline"> <?php if($list['type']==0){?><span>正常（<?php echo $list['num'];?>份）</span><?php }else{?><span>加餐（<?php if($list['state']==0){?>已审核<?php }else{?>审核中<?php }?>）</span><?php }?><?php echo $list['picktime'];?> </div>
   <?php
	}
  ?>
    <div class="aui-code-box">
      <div class="aui-code-btn">
        <button type="button" id="order">点餐</button>
      </div>
    </div>
    <?php if($uid == 918){?>
    <?php
	foreach ($friendlink_list as $ff){
  ?>
    <div class="aui-login-line">
      <h2>点餐时间</h2>
    </div>
    <div class="underline"><?php echo $ff['name'];?><br>开始时间： <?php echo $ff['tel'];?><br>结束时间：<?php echo $ff['worktime'];?><br><?php
if($ff['state']=='0'){
?>
            <label style="cursor:pointer; color:#FF0000" onClick="doAction('validate',<?php echo $ff['id'];?>,1)">关闭预约</label>
            <?php
}else{
?>
            <label style="cursor:pointer;" onClick="doAction('validate',<?php echo $ff['id'];?>,0)">开启预约</label>
            <?php
}
?></div>
    
    <?php
	}
  ?>
  <?php
	}
  ?>
  </section>
</section>
<script type="text/javascript">
$('#order').click(function() {
	window.location.href = 'order.php';
});
</script>
</body>
</html>
