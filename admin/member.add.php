<?php
require_once ("global.php");
$userid		 = trim($_GET ['userid'])?trim($_GET ['userid']):0;
if (!empty($userid)) {
	$userid = mysql_real_escape_string(verify_id($userid));
}
$act			 = trim($_GET ['act'])?trim($_GET ['act']):'add';
$actName = $act == 'add'?'添加':'修改';
$users = $db->find ( "select * from phpaadb_member where id=" . $userid );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="member.action.php" method="post">
  <input type="hidden" name="act" value="<?php echo $act;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
    <tr>
      <td height="31"><strong><?php echo $actName;?>信息</strong></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0" class="table_list">
    <tr>
      <td align="right" class="form_list">部门：</td>
      <td height="26" class="form_list">
	  <select name="recommendid" >
					<option value="0">--请选择部门--</option>
              <option value="院长室" <?php if($users ['recommendid']=='院长室'){?>selected="selected"<?php }?>>总支院长室</option>
              <option value="干训室" <?php if($users ['recommendid']=='干训室'){?>selected="selected"<?php }?>>干训部</option>
              <option value="师训室" <?php if($users ['recommendid']=='师训室'){?>selected="selected"<?php }?>>师训办</option>
              <option value="中学教研室" <?php if($users ['recommendid']=='中学教研室'){?>selected="selected"<?php }?>>中学教研室</option>
              <option value="小幼教研室" <?php if($users ['recommendid']=='小幼教研室'){?>selected="selected"<?php }?>>小幼教研室</option>
              <option value="德育室" <?php if($users ['recommendid']=='德育室'){?>selected="selected"<?php }?>>德育室</option>
              <option value="科研室" <?php if($users ['recommendid']=='科研室'){?>selected="selected"<?php }?>>科研室</option>
              <option value="教发室" <?php if($users ['recommendid']=='教发室'){?>selected="selected"<?php }?>>教发室</option>
              <option value="信息部" <?php if($users ['recommendid']=='信息部'){?>selected="selected"<?php }?>>信息部</option>
              <option value="院务办" <?php if($users ['recommendid']=='院务办'){?>selected="selected"<?php }?>>院务办</option>
              <option value="总务处" <?php if($users ['recommendid']=='总务处'){?>selected="selected"<?php }?>>总务处</option>
              <option value="其他" <?php if($users ['recommendid']=='其他'){?>selected="selected"<?php }?>>其他</option>
          </select>
	  </td>
    </tr>
    <tr>
      <td align="right" class="form_list">姓名：</td>
      <td height="26" class="form_list"><input name="username" type="text"
			style="width: 200px" value="<?php echo $users ['username'];?>"></td>
      </td>
    </tr>
	<tr>
      <td align="right" class="form_list">电话：</td>
      <td height="26" class="form_list"><input name="tel" type="text"
			style="width: 200px" value="<?php echo $users ['tel'];?>"></td>
      </td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
    <tr>
      <td height="29" class="form_footer" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input
			type="submit" name="button" id="button" value="<?php echo $actName;?>老师">
        <input
			type="button" onClick="window.history.go(-1)" value="返回" />
		<input
			type="hidden" name="userid" value="<?php echo $userid;?>">
       </td>
    </tr>
    <tr>
      <td height="3" background="admin/images/20070907_03.gif"></td>
    </tr>
  </table>
</form>
</body>
</html>