<?php
require_once ("global.php");

$page 		= !empty($page) ? intval($page) : 1;
$page_size 	= 20;
$keywords 	= trim($keywords);
$mpurl 		= $_SERVER['PHP_SELF']."?id=".$id."&keywords=".$keywords;


//查询SQL
$sql = "select a.*,b.name
		from phpaadb_answer a 
		left outer join phpaadb_case_category b on a.qid=b.id where nickname <>'' ";


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
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" style="padding:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_head">
        <tr>
          <td height="30">答题记录 
          &nbsp;&nbsp;&nbsp;</td>
          <td width="80"><input type="button" value="导出记录" onClick="location.href='export01.php'" class="submit"></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
        <tr>
          <th width="40">序号</th>
          <th width="250" height="26">用户名</th>
          <th>答题题目</th>
          <th>所选选项</th>
          <th>答题时间</th>
          <th>提交时间</th>
        </tr>
        <?php
	foreach ($notice_list as $list){
  ?>
        <tr onMouseOver="this.className='relow'" onMouseOut="this.className='row'" class="row">
          <td align="center" ><?php echo $list['id'];?></td>
          <td height="26" align="center" ><?php echo $list['nickname'];?>&nbsp;</td>
          <td align="center" ><?php echo $list['name'];?>&nbsp;</td>
          <td align="center" ><?php
				 $qalists = unserialize($list['selection']);
				foreach ($qalists as $qalist){	
			?><?php echo $qalist['tit'];?> | <?php }?>&nbsp;</td>
          <td align="center" ><?php echo $list['usetime'];?> 秒&nbsp;</td>
          <td align="center" ><?php echo date("Y-m-d H:i:s",$list['addtime']);?>&nbsp;</td>
        </tr>
        <?php
	}
  ?>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_footer">
        <tr>
          <td height="29" style="text-align:left; padding-left:10px"><div style="float: right; padding-right: 50px"> 
			<?php echo multi ( $total_nums, $page_size, $page, $mpurl, 0, 5 );?></div></td>
        </tr>
        <tr>
          <td height="3" colspan="2" background="admin/images/20070907_03.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>