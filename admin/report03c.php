<?php
require_once ("global.php");

$id 		= !empty($id) ? $id : 0;
//$partment 		= !empty($partment) ? $partment : '';

$worklist = $db->findAll("select * from phpaadb_friendlink order by id desc");
//print_r($worklist);
$timelist = array();
foreach ($worklist as $ff){
	$sttime = $ff['tel'].' 00:00:00';
	$entime = $ff['worktime'].' 00:00:00';
	$starttime = strtotime($sttime);
	$endtime = strtotime($entime);

	array_push($timelist,$ff['tel']);
	//$timelist = array($worklist['tel']);
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

}

if($id>0){
	
	
	//print_r($timelist);
	//echo $sttime;
	if($_SESSION['userid']==2){
		$orderlist = $db->findAll("select a.* from phpaadb_order a left join phpaadb_member b on a.tel = b.tel  where  a.pickortime = '".$id."' and category = '早餐' and a.carno = '宝教实验学校' and num > 0 order by b.inviteid desc,b.id asc ");
	}else{
		$orderlist = $db->findAll("select a.* from phpaadb_order a left join phpaadb_member b on a.tel = b.tel  where  a.pickortime = '".$id."' and category = '早餐' and a.carno != '宝教实验学校' and num > 0 order by b.inviteid desc,b.id asc ");
	}
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
          <td height="30">吃饭汇总名单（早餐） 
            &nbsp;&nbsp;&nbsp;</td>
          <td width="300"><select name="select"
					onChange="window.location.href='report03c.php?id='+this.value">
					<option value="0">--请选择日期--</option>
              <?php
	foreach ($timelist as $tlist){
  ?>
  <option value="<?php echo $tlist;?>"><?php echo $tlist;?></option>
  <?php
	}
  ?>
          </select>&nbsp;&nbsp;</td>
        </tr>
      </table>
      <!--startprint-->
     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" class="table_form table table-bordered table-striped" id="test_table">
        <tr>
          <td colspan="6"><?php echo $partment;?>吃饭汇总名单（早餐） <br>
          (<?php echo $id?>)
          </td>
        </tr>
        <tr>
          <td width="100">部  室</td>
          <td>姓名</td>
		  <td>数量</td>
          <td>签收</td>
        </tr>
        <?php
		$num01 = 0;

	foreach ($orderlist as $list){
		$num01 = $num01+$list['num'];
  ?>
        <tr>
          <td><?php echo $list['carno'];?></td>
          <td><?php echo $list['uname'];?>&nbsp;</td>
          <td><?php echo $list['num'];?>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
    <?php
	}
  ?>    
        <tr>
          <td></td>
          <td>总计</td>
          <td><?php echo $num01;?>&nbsp;</td>
		  <td></td>
        </tr>
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
