<?php
include ("global.php");
$id 		= !empty($id) ? intval($id) : 0;
$page 		= !empty($page) ? intval($page) : 1;
$page_size 	= 20;
$keywords 	= trim($keywords);
$mpurl 		= $_SERVER['PHP_SELF']."?id=".$id."&keywords=".$keywords;

//查询SQL
$sql = "select a.*,b.name as cname,c.username 
		from phpaadb_case a 
		left outer join phpaadb_case_category b on a.cid=b.id
		left outer join phpaadb_users c on a.created_by=c.userid
		where a.delete_session_id is null";
if($id != 0){
	$sql .= " and a.cid=".$id;
}
if(!empty($keywords)){
	$sql.=" and (a.title like '%".$keywords."%' or a.content like '%".$keywords."%')";
}

$sql .=	" order by a.id desc";

//总记录数
$total_nums = $db->getRowsNum ($sql );

//执行分页查询
$article_list = $db->selectLimit ( $sql, $page_size, ($page - 1) * $page_size );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>案例管理</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
function doAction(a,id){
	ids = 0;
	if(a=='deleteAll'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'case.action.php',
				type: 'POST',
				data:'act=delete&id='+getCheckedIds('checkbox'),
				success: function(data){
					window.location.href = window.location.href;
				}
			});
		}
	}
	if(a=='delete'){
		if(confirm('请确认是否删除！')){
			$.ajax({
				url:'case.action.php',
				type: 'POST',
				data:'act=delete&id='+id,
				success: function(data){
					window.location.href = window.location.href;
				}
			});
		}
	}
	if(a=='moveAll'){
		scid = document.getElementById("selectCid").value;
		if(confirm('请确认是否转移！')){
			$.ajax({
				url:'case.action.php',
				type: 'POST',
				data:'act=move&scid='+scid+'&id='+getCheckedIds('checkbox'),
				success: function(data){
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
			document.getElementById('updateCategoryButton').disabled=false;
			document.getElementById('selectCid').disabled=false;
			
			return;
		}
	}
	document.getElementById('DeleteCheckboxButton').disabled=true;
	document.getElementById('updateCategoryButton').disabled=true;
	document.getElementById('selectCid').disabled=true;
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="padding: 10px;">
		<form method="get" action="case.php" style="margin: 0"><input
			type="hidden" name="cid" value="<?php echo $id;?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0"
			class="serach">
			<tr>
				<td width="70" height="40" align="right">关键搜索：  </td>
				<td width="135" style="padding-left: 2px"><input title="输入案例标题"
					name="keywords" type="text" value="<?php echo $keywords;?>"></td>
				<td><input type="image" name="Submit5" src="images/search.gif"
					style="border: none; height: 19px; width: 66px" /></td>
			</tr>
		</table>
		</form>
		<table width="100%" border="0" cellpadding="0" cellspacing="0"
			class="table_head">
			<tr>
				<td width="200" height="31">案例管理</td>
				<td align="right"><select name="select"
					onChange="window.location.href='case.php?id='+this.value">
					<option value="0">--所有栏目--</option>
              <?php getCaseCategorySelect ($id)?>
                    </select> <input type="button" value="添加案例"
					onClick="location.href='case.add.php?act=add&cid=<?php echo $id;?>'"
					class="submit"></td>
			</tr>
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0"
			class="table_form">
			<tr>
				<th width="40"><input type="checkbox" name="checkbox11"
					value="checkbox" onClick="checkAll(this,'checkbox')"></th>
				<th height="26">案例标题</th>
				<th width="90" height="26">发布人</th>
				<th width="150" height="26">发布时间</th>
				<th width="80">所属栏目</th>
				<th width="80" height="26">操作</th>
			</tr>
        <?php
			foreach ( $article_list as $al ) {
		?>
        <tr onMouseOver="this.className='relow'"
				onMouseOut="this.className='row'" class="row">
				<td align="center"><input type="checkbox" name="checkbox"
					value="<?php echo $al ['id'];?>"
					onClick="checkDeleteStatus('checkbox')"></td>
				<td height="26"><a
					href="case.add.php?act=edit&id=<?php echo $al ['id'];?>&cid=<?php echo $al ['cid'];?>"> <?php echo $al ['title'];?> </a>&nbsp;</td>
				<td height="26" align="center"><?php echo $al ['username'];?> &nbsp;</td>
				<td height="26" align="center"><?php echo $al ['created_date'];?> &nbsp;</td>
				<td align="center"><?php echo $al ['cname'];?> &nbsp;</td>
				<td height="26" align="center"><a
					href="case.add.php?act=add&cid=<?php echo $al['cid'];?>&id=<?php echo $al ['id'];?>">复制</a> <a
					href="case.add.php?act=edit&cid=<?php echo $al['cid'];?>&id=<?php echo $al ['id'];?>"><img
					src="images/edit.gif" alt="修改" border="0"></a> <img
					src="images/del.gif" alt="删除"
					onClick="doAction('delete',<?php echo $al ['id'];?>)"
					style="cursor: pointer"></td>
			</tr>
          <?php
		}
		?>
      </table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0"
			class="table_footer">
			<tr>
				<td height="29" style="text-align: left; padding-left: 10px">
				<div style="float: left;"><input type="button"
					id="DeleteCheckboxButton" value="批量删除" disabled="disabled"
					onClick="doAction('deleteAll')"> &nbsp; 转移到 <select id="selectCid"
					name="selectCid" disabled>
                <?php getCaseCategorySelect ();?>
              </select> <input id="updateCategoryButton" type="button"
					value="批量转移" disabled="disabled" onClick="doAction('moveAll')"></div>
				<div style="float: right; padding-right: 50px"> 
			<?php echo multi ( $total_nums, $page_size, $page, $mpurl, 0, 5 );?></div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</html>