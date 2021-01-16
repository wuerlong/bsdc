<?php
require_once ("global.php");

$id 		= !empty($id) ? $id : 0;
//$partment 		= !empty($partment) ? $partment : '';

//$worklist = $db->find("select * from phpaadb_friendlink  order by seq asc");
//print_r($worklist);
//echo $id;

if($id>0){
	$timea = explode("-",$id);
	//echo $timea[1];
	if( $timea[1] == '1' || $timea[1] == '3' || $timea[1] == '5' || $timea[1] == '7' || $timea[1] == '8'|| $timea[1] == '10' || $timea[1] == '12'){
		$entime = $id.'-31 00:00:00';
		$endx = 31;
	}else if($timea[1] == '2'){
		$entime = $id.'-29 00:00:00';
		$endx = 29;
	}else{
		$entime = $id.'-30 00:00:00';
		$endx = 30;
	}

	$sttime = $id.'-01 00:00:00';
	//$entime = $id.'-30 00:00:00';
	$starttime = strtotime($sttime);
	$endtime = strtotime($entime);


	$timelist = array();
	$timeli = $starttime;
	for ($x=0; $x<$endx; $x++) {
		if($timeli<=$endtime){
			$timelo = date('Y-m-d',$timeli);
			array_push($timelist,$timelo);
		}
		$timeli = $timeli + 86400;
	}


	
	
	//print_r($timelist);
	//echo $sttime;
	$orderlist = $db->findAll("select a.* from phpaadb_order a left join phpaadb_member b on a.tel = b.tel  where  a.pickortime >= '".$timelist[0]."' and a.pickortime <= '".$timelist[29]."' and category = '早餐' group by tel order by b.id asc ");
	//print_r($orderlist);
}






?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>吃饭汇总名单（早餐）</title>
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
          <td height="30">月份汇总表 
            &nbsp;&nbsp;&nbsp;</td>
          <td width="300"><select name="select"
					onChange="window.location.href='report04a.php?id='+this.value">
					<option value="0">--请选择月份--</option>

  <option value="2019-11">2019-11</option>
   <option value="2019-12">2019-12</option>
    <option value="2020-01">2020-01</option>
	 <option value="2020-02">2020-02</option>
	  <option value="2020-03">2020-03</option>
	   <option value="2020-04">2020-04</option>
	    <option value="2020-05">2020-05</option>
<option value="2020-06">2020-06</option>
<option value="2020-07">2020-07</option>
<option value="2020-08">2020-08</option>
<option value="2020-09">2020-09</option>
<option value="2020-10">2020-10</option>
<option value="2020-11">2020-11</option>
<option value="2020-12">2020-12</option>
<option value="2021-01">2021-01</option>
	 <option value="2021-02">2021-02</option>
	  <option value="2021-03">2021-03</option>
	   <option value="2021-04">2021-04</option>
	    <option value="2021-05">2021-05</option>
          </select>&nbsp;&nbsp;</td>
        </tr>
      </table>
      <!--startprint-->
      <table width="1500" border="1" align="center" cellpadding="2" cellspacing="0" class="table_form table table-bordered table-striped" id="test_table">
        <tr>
          <td colspan="32"><?php echo $id;?>月份早餐吃饭汇总名单<br>
          (<?php echo $id?>)
          </td>
        </tr>
        <tr>
          <td width="100">部  室</td>
          <td width="100">姓名</td>
		  <?php foreach ($timelist as $val){?>
          <td><?php echo $val;?></td>
		  <?php }?>

        </tr>
        <?php
		$num01 = 0;

	foreach ($orderlist as $list){
		$num01 = $num01+$list['num'];
  ?>
        <tr>
          <td><?php echo $list['carno'];?></td>
          <td><?php echo $list['uname'];?>&nbsp;</td>
          <?php 
		  foreach ($timelist as $listval){
		   $uulist = $db->findAll("select * from phpaadb_order where uname = '".$list['uname']."' and pickortime = '".$listval."' and category = '早餐' order by pickortime asc ");
		  ?>
          <td><?php echo $uulist[0]['num'];?>&nbsp;</td>
        <?php }?>
        </tr>
    <?php
	}
  ?>    

      </table>
      <!--endprint-->
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_footer">
        <tr>
          <td height="29" style="text-align:left; padding-left:10px"><div style=" float:left"> <button type="button" class="btn btn-success btn-block" id="generate-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> 导出</button> </div></td>
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
</body>
</html>
