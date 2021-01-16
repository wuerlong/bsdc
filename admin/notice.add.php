<?php
include ("global.php");

$id		 = trim($_GET ['id'])?trim($_GET ['id']):0;
$act			 = trim($_GET ['act'])?trim($_GET ['act']):'add';

$actName = $act == 'add'?'添加':'修改';

$notice = $db->find ( "select * from phpaadb_notice where id=" . $id );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>无标题文档</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
function doAction(a,id){
	ids = 0;
	if(a=='delpic'){
		$.ajax({
			url:'notice.action.php',
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
<form action="notice.action.php" method="post" enctype="multipart/form-data" style="margin:0">
  <input type="hidden" name="act" value="<?php echo $act;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
    <tr>
      <td height="31"><strong><?php echo $actName;?>KV</strong></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td height="40" align="right" class="form_list">中文标题 ：</td>
      <td class="form_list"><input name="title" type="text" class="form" style="width: 300px" value="<?php echo $notice ['title'];?>"></td>
    </tr>
    <tr>
      <td height="40" align="right" class="form_list">英文标题 ：</td>
      <td class="form_list"><input name="titleen" type="text" class="form" style="width: 300px" value="<?php echo $notice ['titleen'];?>"></td>
    </tr>
    <tr>
      <td height="40" align="right" class="form_list">日文标题 ：</td>
      <td class="form_list"><input name="titlejp" type="text" class="form" style="width: 300px" value="<?php echo $notice ['titlejp'];?>"></td>
    </tr>
    <tr>
      <td height="40" align="right" class="form_list">图片：</td>
      <td class="form_list"><input type="file" id="content" name="content">
      <div id="picdiv">
          <?php 
                if(!empty($notice ['content'])){
                ?>
          <img src="../<?php echo $notice ['content'];?>" width="100" height="40" onMouseOver="document.getElementById('bigPic').style.display=''" onMouseOut="document.getElementById('bigPic').style.display='none'">
          <div id="bigPic" style="display:none; position:absolute;"><img src="../<?php echo $notice ['content'];?>"></div>
 
              <font style="cursor:pointer; font-size:12px" onclick="doAction('delpic',<?php echo $id;?>)">删除图片</font>
          <?php
                }
                ?>
        </div>
    </tr>
    <tr>
      <td height="40" align="right" class="form_list">顺序：</td>
      <td height="40" class="form_list">
      <input name="state" id="state" type="text" class="form" style="width: 300px" value="<?php echo $notice ['state'];?>">
        （数字越大，位置越靠前）</td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
    <tr>
      <td height="31" align="center"><input name="id" type="hidden" value="<?php echo $id;?>">
        <input type="submit" name="button" id="button" value="提交">
        <input type="button" value="返回" onClick="window.history.go(-1)">
        &nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
