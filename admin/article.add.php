<?php
include ("global.php");
include ("../include/editor/fckeditor_php5.php");

$cid	= trim($_GET ['cid'])?trim($_GET ['cid']):0;
$id	= trim($_GET ['id'])?trim($_GET ['id']):0;
$act	= trim($_GET ['act'])?trim($_GET ['act']):'add';

$actName = $act == 'add'?'添加':'修改';
if (!empty($id)) {
	$id = mysql_real_escape_string(verify_id($id));
}
$article = $db->find ( "select * from phpaadb_article where id=" . $id );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>无标题文档</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/ueditor/1.4.3/ueditor.config.js"></script> 
<script type="text/javascript" src="lib/ueditor/1.4.3/ueditor.all.min.js"> </script> 
<script type="text/javascript" src="lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script> 
<script type="text/javascript">
function doAction(a,id){
	ids = 0;
	if(a=='delpic'){
		$.ajax({
			url:'article.action.php',
			type: 'POST',
			data:'act=delpic&id='+id,
			success: function(data){
				document.getElementById('picdiv').innerHTML="";
			}
		});
	}
}
</script>
</head>
<body onLoad="document.getElementById('title').focus()">
    <form action="article.action.php" method="post" enctype="multipart/form-data" name="form1">
        <input type="hidden" name="act" value="<?php echo $act;?>">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
          <tr>
            <td height="31"><strong><?php echo $actName;?>文章</strong></td>
          </tr>
        </table>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
    <td height="40" class="form_list">所属栏目：</td>
    <td class="form_list"><input name="cid" type="hidden" value="<?php echo $id;?>">
        <select name="cid">
          <option value="0">--未分类--</option>
          <?php getCategorySelect ($cid)?>
        </select>
    <td colspan="2" class="form_list">&nbsp;</td>
    </tr>
  <tr>
    <td width="10%" height="40" class="form_list">标题 ：</td>
    <td width="40%" class="form_list"><input name="title" type="text" class="form" style="width: 90%" value="<?php echo $article ['title'];?>"></td>
    <td width="10%" class="form_list">副标题：</td>
    <td width="40%" class="form_list"><input name="subtitle" type="text" class="form" style="width: 90%" value="<?php echo $article ['subtitle'];?>"></td>
  </tr>
  
    
  <tr>
    <td height="40" class="form_list">缩略图：</td>
    <td colspan="3" class="form_list"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200"><input type="file" name="pic" id="pic"></td>
        <td><div id="picdiv">
          <?php 
                if(!empty($article ['pic'])){
                ?>
          <img src="../<?php echo $article ['pic'];?>" width="100" height="40" onMouseOver="document.getElementById('bigPic').style.display=''" onMouseOut="document.getElementById('bigPic').style.display='none'">
          <div id="bigPic" style="display:none; position:absolute;"><img src="../<?php echo $article ['pic'];?>"></div>
 
              <font style="cursor:pointer; font-size:12px" onclick="doAction('delpic',<?php echo $id;?>)">删除图片</font>
          <?php
                }
                ?>
        </div>           </td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td height="40" class="form_list">发布时间：</td>
    <td class="form_list"><input name="pubdate" type="text" class="form" style="width: 90%" value="<?php echo $article ['pubdate'];?>"></td>
    <td class="form_list">排序：</td>
    <td class="form_list"><input name="orderlist" type="text" class="form" value="<?php echo $article ['orderlist'];?>"> （数值越大排序越靠前）</td>
  </tr>
  
  <tr>
    <td height="40" colspan="4" align="center" class="form_list">
    <script id="content" name="content" type="text/plain" style="width:90%;height:400px;"><?php echo $article ['content'];?></script>    
	</td>
  </tr>
</table>
        
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
          <tr>
            <td height="31" align="center"><strong><span class="form_footer">
              <input name="id" type="hidden" value="<?php echo $id;?>">
              <input type="submit" name="button" id="button" value=" 提 交 ">
              <input type="button" value=" 返 回 " onClick="window.history.go(-1)">
            </span></strong></td>
          </tr>
        </table>
</form>
<script type="text/javascript">
$(function(){

	var ue = UE.getEditor('content');
	
});
</script>
</body>
</html>
