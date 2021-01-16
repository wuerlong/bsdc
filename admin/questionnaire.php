<?php
require_once ("global.php");

$page 		= !empty($page) ? intval($page) : 1;
$page_size 	= 20;
$keywords 	= trim($keywords);
$mpurl 		= $_SERVER['PHP_SELF']."?id=".$id."&keywords=".$keywords;

//查询SQL
$sql = "select a.*,b.name as cname from phpaadb_questionnaire a 
		left outer join phpaadb_case_category b on a.cid=b.id";

$sql .=	" order by a.id desc";

//总记录数
$total_nums = $db->getRowsNum ($sql );

//执行分页查询
$notice_list = $db->selectLimit ( $sql, $page_size, ($page - 1) * $page_size );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文章管理</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript" ></script>
<script type="text/javascript">
function doAction(a,id){
	if(a=='deleteAll'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'questionnaire.action.php',
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
				url:'questionnaire.action.php',
				type: 'POST',
				data:'act=delete&id='+id,
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
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" style="padding:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_head">
        <tr>
          <td height="30">问题库管理 
            &nbsp;&nbsp;&nbsp;</td>
          <td width="80"><input type="button" value="添加问题" onClick="location.href='questionnaire.add.php?act=add'" class="submit"></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
        <tr>
          <th width="40"><input type="checkbox" name="checkbox11" value="checkbox" onClick="checkAll(this,'checkbox')"></th>
          <th>活动名称</th>
          <th>问题标题</th>
          <th>添加时间</th>
          <th width="80" height="26">操作</th>
        </tr>
        <?php
	foreach ($notice_list as $list){
  ?>
        <tr onMouseOver="this.className='relow'" onMouseOut="this.className='row'" class="row">
          <td align="center" ><input type="checkbox" name="checkbox" value="<?php echo $list['id'];?>" onClick="checkDeleteStatus('checkbox')"></td>
          <td><?php echo $list ['cname'];?>&nbsp;</td>
          <td><a href="questionnaire.add.php?act=edit&id=<?php echo $list['id'];?>"><?php echo $list['title'];?></a>&nbsp;</td>
          <td align="center" ><?php echo date("Y-m-d H:i:s",$list['addtime']);?>&nbsp;</td>
          <td align="center"><a href="questionnaire.add.php?act=edit&id=<?php echo $list['id'];?>"><img src="images/edit.gif" alt="修改" border="0"></a> <img src="images/del.gif" alt="删除" onClick="doAction('delete',<?php echo $list['id'];?>)" style="cursor:pointer"></td>
        </tr>
        <?php
	}
  ?>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_footer">
        <tr>
          <td height="29" style="text-align:left; padding-left:10px"><div style=" float:left">
              <input type="button" id="DeleteCheckboxButton" value="删 除" disabled="disabled" onClick="doAction('deleteAll')">
            </div>
            <div style="float: right; padding-right: 50px"> <?php echo multi ( $total_nums, $page_size, $page, $mpurl, 0, 5 );?></div></td>
        </tr>
        <tr>
          <td height="3" colspan="2" background="admin/images/20070907_03.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
