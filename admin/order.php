<?php
require_once ("global.php");

$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
$page_size 		= 10;
$sql_string = "select * from phpaadb_order order by id desc";
$total_nums = $db->getRowsNum ( $sql_string );
$mpurl 	= "order.php";
$friendlink_list = $db->selectLimit ( $sql_string, $page_size, ($page - 1) * $page_size );

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文章管理</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript" ></script>
<script type="text/javascript">
function doAction(a,id,v){
	if(a=='validate'){
		$.ajax({
			url:'order.action.php',
			type: 'POST',
			data:'act=validate&id='+id+'&validate='+v,
			success: function(data){
				if(data) alert(data);
				window.location.href = window.location.href;
			}
		});
	}
	if(a=='delete'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'order.action.php',
				type: 'POST',
				data:'act=delete&id='+id,
				success: function(data){
					if(data) alert(data);
					window.location.href = window.location.href;
				}
			});
		}
	}
	
	if(a=='deleteAll'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'order.action.php',
				type: 'POST',
				data:'act=delete&id='+getCheckedIds('checkbox'),
				success: function(data){
					if(data) alert(data);
					window.location.href = window.location.href;
				}
			});
		}
	}
}

function reply(id,reply){
	var str 	= "<hr>回复留言<br>";
	str			+= "<textarea id=\"reply_"+id+"\" style=\"width:300px;height:100px\">"+reply+"</textarea>";
	str			+= "&nbsp;<input type=\"button\" value=\"保存\" onclick=\"savereply("+id+")\">";
	document.getElementById('replyDiv'+id).innerHTML=str;
}

function savereply(id){
	var val = document.getElementById('reply_'+id).value;
	$.ajax({
		url:'order.action.php',
		type: 'POST',
		data:'act=reply&id='+id+"&reply="+val,
		success: function(data){
			if(data) alert(data);
			window.location.href = window.location.href;
		}
	});
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
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000
}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" style="padding:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_head">
        <tr>
          <td height="30">招聘管理 
            &nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
        <?php
	foreach ($friendlink_list as $list){
  ?>
        <tr>
          <td height="26" align="left" style="background-color:#EEEEEE">&nbsp;
            <input type="checkbox" name="checkbox" value="<?php echo $list['id'];?>" onClick="checkDeleteStatus('checkbox')">
            <font style="color:#009900"><?php echo date('Y-m-d',$list['addtime']);?></font> &nbsp;&nbsp;姓名：<?php echo $list['username'];?>&nbsp;&nbsp;性别：<?php echo $list['sex'];?>&nbsp;&nbsp;省份：<?php echo $list['province'];?> &nbsp;&nbsp;城市：<?php echo $list['city'];?> &nbsp;&nbsp;Email：<?php echo $list['email'];?>&nbsp;&nbsp;IP：<?php echo $list['ip'];?></td>
          <th width="140" align="center" style="background-color:#EEEEEE"> <?php
if($list['validate']==0){
?>
            <label style="cursor:pointer; color:#FF0000" onClick="doAction('validate',<?php echo $list['id'];?>,1)">未查看</label>
            <?php
}else{
?>
            <label style="cursor:pointer;" onClick="doAction('validate',<?php echo $list['id'];?>,0)">已查看</label>
            <?php
}
?>
            <label style="cursor:pointer" onClick="doAction('delete',<?php echo $list['id'];?>)">删除</label></th>
        </tr>
        <tr class="row">
          <td height="26" colspan="2" style="line-height:20px" >资格证书:<?php echo $list['qualifications'];?><br>
            工龄:<?php echo $list['years'];?><br>
            职位:<?php echo $list['position'];?><br>
            学历:<?php echo $list['academic'];?></td>
        </tr>
        <?php
	}
  ?>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_footer">
        <tr>
          <td height="3" background="admin/images/20070907_03.gif"><input type="checkbox" name="checkbox11" value="checkbox" onClick="checkAll(this,'checkbox')">
            全选
            <input type="button" id="DeleteCheckboxButton" value="批量删除" disabled="disabled" onClick="doAction('deleteAll')"></td>
          <td height="3" background="admin/images/20070907_03.gif"><?php echo multi ( $total_nums, $page_size, $page, $mpurl, 0, 5 );?></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
