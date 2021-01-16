<?php
require_once ("global.php");

$id 		= !empty($id) ? intval($id) : 0;

if($id>0){
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
	
	
	
}

$num01 = 0;
$num02 = 0;
$num03 = 0;
$num04 = 0;
$num05 = 0;


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>部门汇总总表</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script src="../include/jquery.js" type="text/javascript" ></script>

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" style="padding:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table_head">
        <tr>
          <td height="30">部门汇总总表 
            &nbsp;&nbsp;&nbsp;</td>
          <td width="80"><select name="select"
					onChange="window.location.href='report01b.php?id='+this.value">
					<option value="0">--请选择周--</option>
              <?php getWeekSelect ($id)?>
          </select></td>
        </tr>
      </table>
      <!--startprint-->
      <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" class="table_form table table-bordered table-striped" id="test_table">
        <tr>
          <td colspan="<?php echo ($timelistlengh+1);?>">吃饭汇总表<br>
          (<?php echo $timelist[0]?> - <?php echo $timelist[$timelistlengh-1]?>)</td>
        </tr>
        <tr>
		  <td width="100"></td>
          <?php 
	for ($i=0;$i<$timelistlengh;$i++){
		?>
          <td><?php echo $timelist[$i]?></td>
		  <?php }?>
        </tr>
        <tr>
          <td>宝教实验学校 </td>
          <?php 
	foreach ($timelist as $val){
		$uulist = $db->find("select sum(num) as totalnum from phpaadb_order where carno = '宝教实验学校' and type = 0 and pickortime = '".$val."' and category ='午餐' ");
		for ($i=0;$i<$timelistlengh;$i++){
			if($val==$timelist[$i]){
				$num[$i] = $num[$i]+$uulist['totalnum'];
			}
		}
	
		  ?>
          <td><?php echo intval($uulist['totalnum']);?>&nbsp;</td>
        <?php }?>
        </tr>
        
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
          <td height="29" style="text-align:left; padding-left:10px"><div style=" float:left"> <input type="button" id="print" value="打印" > <button type="button" class="btn btn-success btn-block" id="generate-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> 导出</button></div></td>
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
