<?php
require_once ("global.php");
$friendlink_list = $db->findAll("select * from phpaadb_friendlink order by seq asc");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文章管理</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript" ></script>
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" style="padding:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_head">
        <tr>
          <td height="30">时间管理 
          &nbsp;&nbsp;&nbsp;</td>
          <td width="80"><input name="button" type="button" class="submit" onClick="location.href='friendlink.add.php?act=add'" value="添加"></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
        <tr>
          <th><input type="checkbox" name="checkbox11" value="checkbox" onClick="checkAll(this,'checkbox')"></th>
          <th height="26">名称</th>
          <th>餐费标准</th>
          <th height="26">预约开始时间</th>
          <th>预约结束时间</th>
          <th>状态</th>
          <th height="26">操作</th>
        </tr>
        <?php
	foreach ($friendlink_list as $list){
  ?>
        <tr onMouseOver="this.className='relow'" onMouseOut="this.className='row'" class="row">
          <td align="center" ><input type="checkbox" name="checkbox" value="<?php echo $list['id'];?>" onClick="checkDeleteStatus('checkbox')"></td>
          <td height="26" align="center" ><a href="friendlink.add.php?act=edit&id=<?php echo $list['id'];?>"><?php echo $list['name'];?></a>&nbsp;</td>
          <td align="center"><?php echo $list['url'];?>&nbsp;</td>
          <td height="26" align="center"><?php echo $list['tel'];?>&nbsp;</td>
          <td align="center"><?php echo $list['worktime'];?>&nbsp;</td>
          <td align="center"><?php if($list['state']=='0'){ ?>开启<?php }else{?>关闭<?php }?>&nbsp;</td>
          <td height="26" align="center"><a href="friendlink.add.php?act=edit&id=<?php echo $list['id'];?>"><img src="images/edit.gif" alt="修改" border="0"></a> <img src="images/del.gif" alt="删除" onClick="doAction('delete',<?php echo $list['id'];?>)" style="cursor:pointer"> <br><?php
if($list['state']=='0'){
?>
            <label style="cursor:pointer; color:#FF0000" onClick="doAction('validate',<?php echo $list['id'];?>,1)">关闭预约</label>
            <?php
}else{
?>
            <label style="cursor:pointer;" onClick="doAction('validate',<?php echo $list['id'];?>,0)">开启预约</label>
            <?php
}
?></td>
        </tr>
        <?php
	}
  ?>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_footer">
        <tr>
          <td height="29" style="text-align:left; padding-left:10px"><div style=" float:left">
              <input type="button" id="DeleteCheckboxButton" value="批量删除" disabled="disabled" onClick="doAction('deleteAll')">
            </div></td>
        </tr>
        <tr>
          <td height="3" colspan="2" background="images/20070907_03.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
