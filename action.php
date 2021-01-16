<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("data/config.inc.php");

$act = trim($_POST ['act']);
$n1 = trim($_POST ['n1']);
$num = substr($n1, 1);

if (isset ( $_POST ["id"] )) {
	$id = mysql_real_escape_string($_POST ["id"]);
} else {
	$id = "";
}

$serviceid = '点餐服务'; 



$var=explode(",",$id);

$numlist=explode(",",$num);


//print_r($numlist);die;
$i = 0;
foreach ($var as $value) {
	
	if($value!=''){
		$category = mb_substr($value,-2,2,'utf-8');
		//echo $statue;die;
		$order = $db->find("select id from phpaadb_order where uname = '".$_SESSION ['uname']."' and tel='".$_SESSION ['tel']."' and picktime = '".$value."' and type = 0 " );
		if($order){
			$record = array(
				'uname'			=>$_SESSION ['uname'],
				'carno'			=>$_SESSION ['recommendid'],
				'tel'		=>$_SESSION ['tel'],
				'shopid'			=>$_SESSION ['uname'],
				'serviceid'		=>$serviceid,
				'picktime'		=>$value,
				'pickortime'		=>substr($value,0,-4),
				'num'		=>$numlist[$i],
				'type'		=>0,
				'category'		=>$category,
				'pubdate'		=>date ( "Y-m-d H:i:s" ),
				'created_date'	=>date ( "Y-m-d H:i:s" )
			);
			$db->update('phpaadb_order',$record,'id='.$order['id']);
		}else{
			$record = array(
				'uname'			=>$_SESSION ['uname'],
				'carno'			=>$_SESSION ['recommendid'],
				'tel'		=>$_SESSION ['tel'],
				'shopid'			=>$_SESSION ['uname'],
				'serviceid'		=>$serviceid,
				'picktime'		=>$value,
				'pickortime'		=>substr($value,0,-4),
				'num'		=>$numlist[$i],
				'type'		=>0,
				'category'		=>$category,
				'pubdate'		=>date ( "Y-m-d H:i:s" ),
				'created_date'	=>date ( "Y-m-d H:i:s" )
			);
			
			$id = $db->save('phpaadb_order',$record);
		} 
	}
	$i++;
}



header("Location: ok.php");

?>