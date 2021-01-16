<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("data/config.inc.php");

$act = trim($_POST ['act']);

if (isset ( $_POST ["num"] )) {
	$num = mysql_real_escape_string($_POST ["num"]);
} else {
	$num = "";
}
if (isset ( $_POST ["company"] )) {
	$company = mysql_real_escape_string($_POST ["company"]);
} else {
	$company = "";
}
if (isset ( $_POST ["picktime"] )) {
	$picktime = mysql_real_escape_string($_POST ["picktime"]);
} else {
	$picktime = "";
}
if (isset ( $_POST ["level"] )) {
	$level = mysql_real_escape_string($_POST ["level"]);
} else {
	$level = "";
}
if (isset ( $_POST ["beizhu"] )) {
	$beizhu = mysql_real_escape_string($_POST ["beizhu"]);
} else {
	$beizhu = "";
}
$serviceid = '点餐服务'; 
$record = array(
	'uname'			=>$_SESSION ['uname'],
	'carno'			=>$_SESSION ['recommendid'],
	'tel'		=>$_SESSION ['tel'],
	'shopid'			=>$_SESSION ['uname'],
	'serviceid'		=>$serviceid,
	'num'		=>$_POST ['num'],
	'company'		=>$_POST ['company'],
	'picktime'		=>$_POST ['picktime'],
	'level'		=>$_POST ['level'],
	'beizhu'		=>$_POST ['beizhu'],
	'state'		=>1,
	'type'		=>1,
	'pubdate'		=>date ( "Y-m-d H:i:s" ),
	'created_date'	=>date ( "Y-m-d H:i:s" )
);

$id = $db->save('phpaadb_order',$record);

header("Location: ok.php");

?>