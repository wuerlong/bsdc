<?php
include ("global.php");
include ("../include/editor/fckeditor_php5.php");

$cid	= trim($_GET ['cid'])?trim($_GET ['cid']):0;
$id	= trim($_GET ['id'])?trim($_GET ['id']):0;
$act	= trim($_GET ['act'])?trim($_GET ['act']):'add';
if (!empty($id)) {
	$id = mysql_real_escape_string(verify_id($id));
}
$actName = $act == 'add'?'添加':'修改';
$article = $db->find ( "select * from phpaadb_case where id=" . $id );
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
			url:'case.action.php',
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
<form action="case.action.php" method="post" enctype="multipart/form-data" name="form1">
  <input type="hidden" name="act" value="<?php echo $act;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
    <tr>
      <td height="31"><strong><?php echo $actName;?>商品</strong></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="10%" height="40" class="form_list">中文标题 ：</td>
      <td width="40%" class="form_list"><input name="title" type="text" class="form" style="width: 90%" value="<?php echo $article ['title'];?>"></td>
      <td width="10%" class="form_list">英文标题：</td>
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
              </div></td>
          </tr>
        </table></td>
    </tr>
    <!--<tr>
    <td height="40" class="form_list">属性：</td>
    <td class="form_list">
    <input type="radio" name="att" value="" <?php if($article['att']=="") echo "checked";?>> 清空状态&nbsp;&nbsp;
    <input type="radio" name="att" value="a" <?php if($article['att']=="a") echo "checked";?>> A&nbsp;&nbsp;
    <input type="radio" name="att" value="b" <?php if($article['att']=="b") echo "checked";?>> B&nbsp;&nbsp;
    <input type="radio" name="att" value="c" <?php if($article['att']=="c") echo "checked";?>> C&nbsp;&nbsp;
    <input type="radio" name="att" value="d" <?php if($article['att']=="d") echo "checked";?>> D&nbsp;&nbsp;
    <input type="radio" name="att" value="e" <?php if($article['att']=="e") echo "checked";?>> E&nbsp;&nbsp;
    
    <input type="checkbox" name="att[]" value="d" <?php if(strstr($article['att'],"d")) echo "checked";?>> 日语输入法&nbsp;&nbsp;
    <input type="checkbox" name="att[]" value="e" <?php if(strstr($article['att'],"e")) echo "checked";?>> 4G&nbsp;&nbsp;
    <input type="checkbox" name="att[]" value="f" <?php if(strstr($article['att'],"f")) echo "checked";?>> IOS&nbsp;&nbsp;
    <input type="checkbox" name="att[]" value="g" <?php if(strstr($article['att'],"g")) echo "checked";?>> Android&nbsp;&nbsp;
    <input type="checkbox" name="att[]" value="h" <?php if(strstr($article['att'],"g")) echo "checked";?>> Windows&nbsp;&nbsp;
    <input type="checkbox" name="att[]" value="i" <?php if(strstr($article['att'],"g")) echo "checked";?>> WIFI&nbsp;&nbsp; 
      </td>
     <td class="form_list">排序：</td>
    <td class="form_list"><input name="orderlist" type="text" class="form" value="<?php echo $article ['orderlist'];?>"> （数值越大排序越靠前）</td>
  </tr>
  <tr>
    <td height="40" class="form_list">颜色：</td>
    <td colspan="3" class="form_list">
    
    <input type="checkbox" name="color[]" value="黑色" <?php if(strstr($article['color'],"黑色")) echo "checked";?>> 黑色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="白色" <?php if(strstr($article['color'],"白色")) echo "checked";?>> 白色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="紫色" <?php if(strstr($article['color'],"紫色")) echo "checked";?>> 紫色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="ピンク色" <?php if(strstr($article['color'],"ピンク色")) echo "checked";?>> ピンク色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="青色" <?php if(strstr($article['color'],"青色")) echo "checked";?>> 青色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="赤色" <?php if(strstr($article['color'],"赤色")) echo "checked";?>> 赤色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="黄色" <?php if(strstr($article['color'],"黄色")) echo "checked";?>> 黄色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="绿色" <?php if(strstr($article['color'],"绿色")) echo "checked";?>> 绿色&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="スペースグレイ" <?php if(strstr($article['color'],"スペースグレイ")) echo "checked";?>> スペースグレイ&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="ゴールド" <?php if(strstr($article['color'],"ゴールド")) echo "checked";?>> ゴールド&nbsp;&nbsp;
    <input type="checkbox" name="color[]" value="シルバー" <?php if(strstr($article['color'],"シルバー")) echo "checked";?>> シルバー&nbsp;&nbsp;
      </td>
  </tr> --> 
    <!--  <tr>
    <td height="40" class="form_list">备注：</td>
    <td class="form_list"><textarea name="beizhu" class="form" style="width: 90%; height: 50px; overflow: auto"><?php echo trim ( $article ['beizhu'] );?></textarea></td>
    
  </tr> --> 
    <!--<tr>
    <td height="40" class="form_list">价格：</td>
    <td class="form_list"><input name="price" type="text" class="form" value="<?php echo $article ['price'];?>"></td>
    <td class="form_list">品牌：</td>
    <td class="form_list"><input name="brand" type="text" class="form" value="<?php echo $article ['brand'];?>"></td>
  </tr> -->
    <tr>
      <td height="40" class="form_list">项目地点：</td>
      <td class="form_list"><input name="infor01" type="text" class="form" value="<?php echo $article ['infor01'];?>"></td>
      <td class="form_list">Site location：</td>
      <td class="form_list"><input name="infor06" type="text" class="form" value="<?php echo $article ['infor06'];?>"></td>
    </tr>
    <tr>
      <td height="40" class="form_list">用途：</td>
      <td class="form_list"><input name="infor03" type="text" class="form" value="<?php echo $article ['infor03'];?>"></td>
      <td height="40" class="form_list"> category：</td>
      <td class="form_list"><input name="infor07" type="text" class="form" value="<?php echo $article ['infor07'];?>"></td>
    </tr>
    <tr>
    <td height="40" class="form_list">日文标题：</td>
    <td class="form_list"><input name="infor05" type="text" class="form" value="<?php echo $article ['infor05'];?>" style="width: 90%"></td>
    <td height="40" class="form_list">日文项目地点：</td>
    <td class="form_list"><input name="infor09" type="text" class="form" value="<?php echo $article ['infor09'];?>"></td>
    </tr>
  <tr>
    <td class="form_list">排序：</td>
    <td class="form_list"><input name="orderlist" type="text" class="form" value="<?php echo $article ['orderlist'];?>">
      （数值越大排序越靠前）</td>
    <td class="form_list">日文用途：</td>
    <td class="form_list"><input name="infor08" type="text" class="form" value="<?php echo $article ['infor08'];?>"></td>
  </tr>
    <tr>
      <td height="40" class="form_list">所属栏目：</td>
      <td class="form_list"><input name="cid" type="hidden" value="<?php echo $id;?>">
        <select name="cid">
          <option value="0">--未分类--</option>
          <?php getCaseCategorySelect ($cid)?>
        </select></td>
      <td class="form_list">摘要：</td>
      <td class="form_list"><textarea name="resume" class="form" style="width: 90%; height: 50px; overflow: auto"><?php echo trim ( $article ['resume'] );?></textarea></td>
    </tr>
    <!--<tr>
    <td height="40" class="form_list">产品功能：</td>
    <td class="form_list"><textarea name="purpose" class="form" style="width: 90%; height: 50px; overflow: auto"><?php echo trim ( $article ['purpose'] );?></textarea></td>
    <td class="form_list">附属：</td>
    <td class="form_list"><textarea name="subsidiary" class="form" style="width: 90%; height: 50px; overflow: auto"><?php echo trim ( $article ['subsidiary'] );?></textarea></td>
  </tr> -->
    <tr>
      <td height="40" colspan="4" align="center" class="form_list"><?php


$oFCKeditor = new FCKeditor('content') ;
$oFCKeditor->BasePath	= "../include/editor/" ;
$oFCKeditor->Height = 350;
$oFCKeditor->Value		= $article ['content'];
$oFCKeditor->Create() ;
    ?></td>
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
</body>
</html>
