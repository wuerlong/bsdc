<?php
require_once ("global.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
function doAction(a,id){
	if(a=='delete'){
		if(confirm('将删除栏目下的所有文章，请确认真的要删除吗？')){
			$.ajax({
				url:'case_category.action.php',
				type: 'POST',
				data: '&act=delete&id='+id,//对页面所有input元素进行序列化
				success: function(data){if(data) alert(data);
					window.location.href = window.location.href;
				}
			});			
		}
	}
	
}
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" style="padding:10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_head">
          <tr>
            <td width="39%" height="31">活动管理</td>
            <td width="61%" align="right"></td>
            <td width="61%" align="right"><input type="button" value="添加活动"
			onClick="location.href='case_category.add.php?act=add'" class="submit1"></td>
          </tr>
        </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_form">
          <tr>
            <th>活动名称</th>
            <th width="60">问题数</th>
            <th width="60">排序</th>
            <th width="230">操作</th>
          </tr>
          <?php
getCategoryList ();
?>
        </table>
      </td>
  </tr>
</table>
</body>
</html>



<?php
/*=======================================================================================*/
//获取栏目列表信息
function getCategoryList($id = 0, $level = 0) {
	global $db;
	$category_arr = $db->findAll ( "SELECT * FROM phpaadb_case_category WHERE pid = " . $id . " order by seq,id" );
	for($lev = 0; $lev < $level * 2 - 1; $lev ++) {
		$level_nbsp .= "　";
	}
	$level++;
	$level_nbsp .= "<font style=\"font-size:12px;font-family:wingdings\">".$level."</font>";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['name'];
		echo "
<tr onMouseOver=\"this.className='relow'\" onMouseOut=\"this.className='row'\" class=\"row\">
	<td height=\"26\" > " . $level_nbsp . " &nbsp; " . $name . "&nbsp;&nbsp;(cid: $id)</td>
	<td height=\"26\" align=\"center\" style=\"color:#FF0000\">" . getArticleNumOfCategory ( $id ) . "&nbsp;</td>
	<td height=\"26\" align=\"center\">" . $category ['seq'] . "&nbsp;</td>
	<td height=\"26\" align=\"center\">
		<a href='questionnaire.add.php?act=add&cid=" . $id . "'>添加问题</a> |&nbsp;
		<a href='case_category.add.php?act=edit&id=" . $id . "'>修改栏目</a> |&nbsp;
		<a href=\"javascript:doAction('delete'," . $id . ")\">删除</a></td>
</tr> ";
		getCategoryList ( $id, $level );
	}
}

//栏目下文章数
function getArticleNumOfCategory($id) {
	global $db;
	$sql = "SELECT id FROM phpaadb_questionnaire WHERE cid=" . $id . " ";
	return $db->getRowsNum ( $sql );
}
?>