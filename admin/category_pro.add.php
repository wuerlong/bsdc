<?php
require_once ("global.php");
$act			 = trim($_GET ['act'])?trim($_GET ['act']):'add';

$pid	 = trim($_GET ['pid'])?trim($_GET ['pid']):0;
$id		 = trim($_GET ['id'])?trim($_GET ['id']):0;

$actName = $act == 'add'?'添加':'修改';


$name="";
$seq=0;
if($act=='edit'){
	$classify_row = $db->find("select * from phpaadb_category where id=".$id);
	$pid 	= $classify_row['pid'];
	$name	= $classify_row['name'];
	$seq 	= $classify_row['seq'];	
	$description = $classify_row['description'];	
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
function doAction(a,id){
	ids = 0;
	if(a=='delpic'){
		$.ajax({
			url:'category_pro.action.php',
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

<body>
<form action="category_pro.action.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="<?php echo $act;?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
  <tr>
    <td width="39%" height="31"><?php echo $actName;?>栏目</td>
    <td width="61%" align="right"></td>
    <td width="61%" align="right">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0" class="table_list">
	<tr class="row">
	  <td width="60" align="right" class="form_list">父栏目：</td>
	  <td height="26" class="form_list">
      <select name="pid" style="font-size:12px">
<option value="57" > 新品上市</option></select>
 </td>
    </tr>
	<tr class="row">
		<td align="right" class="form_list">栏目名称：</td>
	  <td height="26" class="form_list"><input name="name" type="text"
			value="<?php echo $name;?>" style="width: 250px"></td>
	</tr>
    <tr>
    <td height="40" class="form_list">缩略图：</td>
    <td class="form_list"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200"><input type="file" name="pic" id="pic"></td>
        <td><div id="picdiv">
          <?php 
                if(!empty($description)){
                ?>
          <img src="../<?php echo $description;?>" width="100" height="40" onMouseOver="document.getElementById('bigPic').style.display=''" onMouseOut="document.getElementById('bigPic').style.display='none'">
          <div id="bigPic" style="display:none; position:absolute;"><img src="../<?php echo $description;?>"></div>
               <font style="cursor:pointer; font-size:12px" onclick="doAction('delpic',<?php echo $id;?>)">删除图片</font>
          <?php
                }
                ?>
        </div>           </td>
      </tr>
    </table></td>
  </tr>
	<tr class="row">
		<td align="right" class="form_list">排序：</td>
	  <td height="26" class="form_list"><input name="seq" type="text" id="seq"
			style="width: 50px" value="<?php echo $seq;?>"></td>
	</tr>
    
</table>

<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0" class="form_title">
<tr>
		<td height="29" style="text-align: left">
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input
			type="submit" name="button" id="button" value="<?php echo $actName;?>栏目"> <input
			type="button" onClick="window.history.go(-1)" value="返回" /> <input
			type="hidden" name="cid" value="<?php echo $id;?>">			</td>
	</tr>
	<tr>
		<td height="3" background="admin/images/20070907_03.gif"></td>
	</tr>
</table>
</form>
</body>
</html>