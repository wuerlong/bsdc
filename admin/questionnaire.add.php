<?php
include ("global.php");

$id		 = trim($_GET ['id'])?trim($_GET ['id']):0;
$act			 = trim($_GET ['act'])?trim($_GET ['act']):'add';

$actName = $act == 'add'?'添加':'修改';

$questionnaire = $db->find ( "select * from phpaadb_questionnaire where id=" . $id );
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
			url:'questionnaire.action.php',
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
<form action="questionnaire.action.php" method="post" enctype="multipart/form-data" style="margin:0">
  <input type="hidden" name="act" value="<?php echo $act;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form_title">
    <tr>
      <td height="31"><strong><?php echo $actName;?>问题</strong></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td width="15%" height="40" align="right" class="form_list">期数 ：</td>
      <td width="39%" class="form_list"><input name="cid" type="hidden" value="<?php echo $id;?>">
        <select name="cid">
          <option value="0">--未分类--</option>
          <?php getCaseCategorySelect ($questionnaire ['cid'])?>
        </select></td>
      <td width="46%" class="form_list"><input type="button" value="增加选项" onClick="javascript:c()" class="submit"></td>
    </tr>
    <tr>
      <td width="15%" height="40" align="right" class="form_list">问题 ：</td>
      <td width="39%" class="form_list"><input name="title" type="text" class="form" style="width: 300px" value="<?php echo $questionnaire ['title'];?>"></td>
      <td width="46%" class="form_list">正确选项
        <input name="correct" type="text" value="<?php echo $questionnaire ['correct'];?>" >
        （输入正确选项的序号）</td>
    </tr>
    <tr>
      <td colspan="3"><table width="100%" id="addtest">
          <?php if($act=='add'){
		  $qalistnum = 3;
		  ?>
          <tr>
            <td width="15%" height="40" align="right" class="form_list">选项1</td>
            <td class="form_list"><input name="qalist[1][tit]" type="text" class="form" style="width: 300px" value=""></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="40" align="right" class="form_list">选项2</td>
            <td class="form_list"><input name="qalist[2][tit]" type="text" class="form" style="width: 300px" value=""></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="40" align="right" class="form_list">选项3</td>
            <td class="form_list"><input name="qalist[3][tit]" type="text" class="form" style="width: 300px" value=""></td>
            <td>&nbsp;</td>
          </tr>
          <?php }else{
				 $qalists = unserialize($questionnaire['content']);
				 $qalistnum = count($qalists);
				 $i=0;
				foreach ($qalists as $qalist){
				$i=$i+1;
			?>
          <tr>
            <td height="40" width="15%" align="right" class="form_list">选项<?php echo $i;?></td>
            <td class="form_list"><input name="qalist[<?php echo $i;?>][tit]" type="text" class="form" style="width: 300px" value="<?php echo $qalist['tit'];?>"></td>
            <td>&nbsp;</td>
          </tr>
          <?php } }?>
        </table></td>
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
<script type="text/javascript">
var index = <?php echo $qalistnum;?>;
function c(){
	var addstep = index + 1;
	$("#addtest tr:last").after("<tr>" + 
        "<td height='40' align='right' class='form_list'>选项"+ addstep +"</td>" + 
        "<td class='form_list'>" + 
          "<input type='text' name='qalist[" + addstep + "][tit]' class='form' style='width: 300px'>" +
        "</td>" + 
        "<td>"+
          "&nbsp;"+
        "</td>"+
      "</tr>");
	index += 1;
}
</script>
</body>
</html>