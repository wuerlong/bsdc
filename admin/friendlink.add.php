<?php
include ("global.php");
include ("../include/editor/fckeditor_php5.php");

$id		 = trim($_GET ['id'])?trim($_GET ['id']):0;
$act			 = trim($_GET ['act'])?trim($_GET ['act']):'add';
if (!empty($id)) {
	$id = mysql_real_escape_string(verify_id($id));
}
$actName = $act == 'add'?'添加':'修改';

$friendlink = $db->find ( "select * from phpaadb_friendlink where id=" . $id );
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
			url:'friendlink.action.php',
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

<body onLoad="document.getElementById('name').focus()">
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
  <tr>
    <td width="*" height="1299" valign="top" style="padding: 10px;"><form action="friendlink.action.php" method="post" enctype="multipart/form-data" name="form1">
        <input type="hidden" name="act" value="<?php echo $act;?>">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td height="829" valign="top" style="padding:10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
                <tr>
                  <td height="31"><?php echo $actName;?>时间</td>
                </tr>
              </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                  <td height="40" align="right" class="form_list">名称 ：</td>
                  <td class="form_list"><input name="name" type="text" class="form" style="width: 300px" value="<?php echo $friendlink ['name'];?>"></td>
                </tr>
                <tr>
                  <td height="40" align="right" class="form_list">餐费标准：</td>
                  <td class="form_list"><input name="url" type="text" class="form" style="width: 300px" value="<?php echo $friendlink ['url'];?>"></td>
                </tr>
                <tr>
                  <td height="40" align="right" class="form_list">预约开始时间：</td>
                  <td class="form_list"><input name="tel" type="text" class="form" style="width: 300px" value="<?php echo $friendlink ['tel'];?>"></td>
                </tr>
                <tr>
                  <td height="40" align="right" class="form_list">预约结束时间：</td>
                  <td class="form_list"><input name="worktime" type="text" class="form" style="width: 300px" value="<?php echo $friendlink ['worktime'];?>"></td>
                </tr>
                
                <tr>
                  <td height="40" align="right" class="form_list">菜单：</td>
                  <td class="form_list"><?php
$oFCKeditor = new FCKeditor('content') ;
$oFCKeditor->BasePath	= "../include/editor/" ;
$oFCKeditor->Height = 350;
$oFCKeditor->Value		= $friendlink ['content'];
$oFCKeditor->Create() ;
    ?>
                </tr>
                <tr>
                  <td height="40" align="right" class="form_list">排序：</td>
                  <td height="40" class="form_list"><input name="seq" type="text" class="form" style="width: 50px" value="<?php echo $friendlink ['seq']?$friendlink ['seq']:0;?>"></td>
                </tr>
              </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
                <tr>
                  <td height="31" align="center"><input name="id" type="hidden" value="<?php echo $id;?>">
                    <input type="submit" name="button" id="button" value="提交">
                    <input type="button" value="返回" onClick="window.history.go(-1)">
                    &nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </form></td>
  </tr>
</table>
</body>
</html>
