<?php
require_once ("global.php");

$page 			= $_GET ['page'] ? $_GET ['page'] : 1;
$page_size 		= 10;
$sql_string = "select a.*,b.username,b.nickname from phpaadb_car a left join phpaadb_member b on a.openid = b.openid  order by a.id desc";
$total_nums = $db->getRowsNum ( $sql_string );
$mpurl 	= "message.php";
$car_list = $db->selectLimit ( $sql_string, $page_size, ($page - 1) * $page_size );

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
			url:'message.action.php',
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
				url:'message.action.php',
				type: 'POST',
				data:'act=delete&id='+id,
				success: function(data){
					if(data) alert('操作成功');
					window.location.href = window.location.href;
				}
			});
		}
	}
	
	if(a=='deleteAll'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'message.action.php',
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
          <td height="30">加餐管理 
          &nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
        <tr>
          <th><input type="checkbox" name="checkbox11" value="checkbox" onClick="checkAll(this,'checkbox')"></th>
          <th height="26">姓名</th>
          <th>职位</th>
          <th>来访人数</th>
          <th>单位信息</th>
          <th>来访日期</th>
          <th>餐费标准</th>
          <th>添加时间</th>
          <th height="26">操作</th>
        </tr>
        <?php
	foreach ($car_list as $list){
  ?>
        <tr onMouseOver="this.className='relow'" onMouseOut="this.className='row'" class="row">
          <td align="center" ><input type="checkbox" name="checkbox" value="<?php echo $list['id'];?>" onClick="checkDeleteStatus('checkbox')"></td>
          <td align="center"><?php echo $list['username'];?>[<?php echo $list['nickname'];?>]&nbsp;</td>
          <td align="center"><?php echo $list['licenseplatenumber'];?>
            &nbsp;</td>
          <td><?php echo $list['brand'];?>&nbsp;</td>
          <td><?php echo $list['baoxian'];?>&nbsp;</td>
          <td><?php echo $list['endtime1'];?>&nbsp;</td>
          <td><?php echo $list['baoxian1'];?>&nbsp;</td>
          <td align="center"><?php echo $list['pubdate'];?>&nbsp;</td>
          <td align="center"> <?php
if($list['state']==0){
?>
            <label style="cursor:pointer; color:#FF0000" onClick="doAction('validate',<?php echo $list['id'];?>,1)">未审核</label>
            <?php
}else{
?>
            <label style="cursor:pointer;" onClick="doAction('validate',<?php echo $list['id'];?>,0)">已审核</label>
            <?php
}
?>
            <label style="cursor:pointer" onClick="doAction('delete',<?php echo $list['id'];?>)">删除</label></td>
        </tr>
        <?php
	}
  ?>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_footer">
        <tr>
          <td height="3" background="admin/images/20070907_03.gif">
          <input type="checkbox" name="checkbox11" value="checkbox" onClick="checkAll(this,'checkbox')">全选
          <input type="button" id="DeleteCheckboxButton" value="批量删除" disabled="disabled" onClick="doAction('deleteAll')">
          </td>
          <td height="3" background="admin/images/20070907_03.gif">
          <?php echo multi ( $total_nums, $page_size, $page, $mpurl, 0, 5 );?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>