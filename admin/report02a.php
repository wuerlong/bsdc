<?php
require_once ("global.php");

$id 		= !empty($id) ? intval($id) : 0;
$partment 		= !empty($partment) ? $partment : '';

if($id>0 && $partment !=''){
	$worklist = $db->find("select * from phpaadb_friendlink where id = '".$id."' order by seq asc");
	//print_r($worklist);
	$sttime = $worklist['tel'].' 00:00:00';
	$entime = $worklist['worktime'].' 00:00:00';
	$starttime = strtotime($sttime);
	$endtime = strtotime($entime);


	$timelist = array($worklist['tel']);
	$timeli = $starttime;
	for ($x=0; $x<=11; $x++) {
		$timeli = $timeli + 86400;
		if($timeli<=$endtime){
			$timelo = date('Y-m-d',$timeli);
			if($timelo=='2020-06-25' || $timelo=='2020-06-26' || $timelo=='2020-06-27' || $timelo=='2020-09-26' || $timelo=='2020-10-01' || $timelo=='2020-10-02' || $timelo=='2020-10-03' || $timelo=='2020-10-04' || $timelo=='2020-10-05' || $timelo=='2020-10-06' || $timelo=='2020-10-07' || $timelo=='2020-10-08'){
			
			}else{
				array_push($timelist,$timelo);
			}
		}
	}
	$timelistlengh = sizeof($timelist);
	//print_r($timelist);
	//echo $sttime;
	$orderlist = $db->findAll("select * from phpaadb_order where carno = '".$partment."' and pickortime >= '".$worklist['tel']."' and pickortime <= '".$worklist['worktime']."' group by uname order by id asc ");
	
	//print_r($orderlist);
	
}




?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>部门汇总总表</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript" ></script>
<script src="../js/jquery-3.4.1.js" type="text/javascript"></script>
<script src="../js/jquery.PrintArea.js" type="text/javascript"></script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" style="padding:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_head">
        <tr>
          <td height="30">吃饭登记表 
            &nbsp;&nbsp;&nbsp;</td>
          <td width="300"><select name="select"
					onChange="window.location.href='report02a.php?partment=<?php echo $partment;?>&id='+this.value">
					<option value="0">--请选择周--</option>
              <?php getWeekSelect ($id)?>
          </select>&nbsp;&nbsp;<select name="select"
					onChange="window.location.href='report02a.php?id=<?php echo $id;?>&partment='+this.value">
					<option value="0">--请选择部门--</option>
              <option value="院长室" <?php if($partment=='院长室'){?>selected="selected"<?php }?>>总支院长室</option>
              <option value="干训室" <?php if($partment=='干训室'){?>selected="selected"<?php }?>>干训部</option>
              <option value="师训室" <?php if($partment=='师训室'){?>selected="selected"<?php }?>>师训办</option>
              <option value="中学教研室" <?php if($partment=='中学教研室'){?>selected="selected"<?php }?>>中学教研室</option>
              <option value="小幼教研室" <?php if($partment=='小幼教研室'){?>selected="selected"<?php }?>>小幼教研室</option>
              <option value="德育室" <?php if($partment=='德育室'){?>selected="selected"<?php }?>>德育室</option>
              <option value="科研室" <?php if($partment=='科研室'){?>selected="selected"<?php }?>>科研室</option>
              <option value="教发室" <?php if($partment=='教发室'){?>selected="selected"<?php }?>>教发室</option>
              <option value="信息部" <?php if($partment=='信息部'){?>selected="selected"<?php }?>>信息部</option>
              <option value="院务办" <?php if($partment=='院务办'){?>selected="selected"<?php }?>>院务办</option>
              <option value="总务处" <?php if($partment=='总务处'){?>selected="selected"<?php }?>>总务处</option>
              <option value="其他" <?php if($partment=='其他'){?>selected="selected"<?php }?>>其他</option>
          </select></td>
        </tr>
      </table>
      <!--startprint-->
      <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" class="table_form table table-bordered table-striped" id="test_table">
        <tr>
          <td colspan="<?php echo ($timelistlengh+1);?>"><?php echo $partment;?>早餐吃饭表<br>
          (<?php echo $timelist[0]?> - <?php echo $timelist[$timelistlengh-1]?>)
          </td>
        </tr>
        <tr>
		  <td width="100" >姓名</td>
          <?php 
	for ($i=0;$i<$timelistlengh;$i++){
		?>
          <td><?php echo $timelist[$i]?></td>
		  <?php }?>
        </tr>
        <?php
		$num01 = 0;
		$num02 = 0;
		$num03 = 0;
		$num04 = 0;
		$num05 = 0;
	foreach ($orderlist as $list){
  ?>
        <tr>
          <td><?php echo $list['uname'];?></td>
          <?php 
		   $uulist = $db->findAll("select * from phpaadb_order where uname = '".$list['uname']."' and pickortime >= '".$worklist['tel']."' and pickortime <= '".$worklist['worktime']."' and category ='早餐' order by pickortime asc ");

	foreach ($uulist as $val){
		for ($i=0;$i<$timelistlengh;$i++){
			if($val['pickortime']==$timelist[$i]){
				$num[$i] = $num[$i]+$val['num'];
			}
		}
	
		  ?>
          <td><?php echo $val['num'];?>&nbsp;</td>
        <?php }?>
        </tr>
    <?php
	}
  ?>    
        <tr>
          <td>总计</td>
          <?php 
	for ($i=0;$i<$timelistlengh;$i++){
		?>
          <td><?php echo $num[$i]?></td>
		  <?php }?>
        </tr>
      </table>
      <!--endprint-->
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_footer">
        <tr>
          <td height="29" style="text-align:left; padding-left:10px"><div style=" float:left"> <input type="button" id="print" value="打印" > <button type="button" class="btn btn-success btn-block" id="generate-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> 导出</button> </div></td>
        </tr>
        <tr>
          <td height="3" colspan="2" background="admin/images/20070907_03.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>
<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/jszip/3.1.5/jszip.min.js"></script>
<script type="text/javascript" src="external/FileSaver.js"></script>
<script type="text/javascript" src="scripts/excel-gen.js"></script>
<script type="text/javascript" src="scripts/demo.page.js"></script>
<script>
    $(document).ready(function() {
        $("#print").click(function() {

			bdhtml=window.document.body.innerHTML; 
			sprnstr="<!--startprint-->"; //开始打印标识字符串有17个字符
			eprnstr="<!--endprint-->"; //结束打印标识字符串
			prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17); //从开始打印标识之后的内容
			prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr)); //截取开始标识和结束标识之间的内容
			window.document.body.innerHTML=prnhtml; //把需要打印的指定内容赋给body.innerHTML
			window.print(); //调用浏览器的打印功能打印指定区域
			window.document.body.innerHTML=bdhtml;//重新给页面内容赋值；
			return false;

        })
    });
</script>
</body>
</html>
