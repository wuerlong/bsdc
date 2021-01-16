<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("data/config.inc.php");

$openid = $_SESSION['openid'];

if(!$openid){
	header("Location: code/");
	exit();
}

$act = trim($_POST ['act']);

if (isset ( $_POST ["username"] )) {
	$username = mysql_real_escape_string($_POST ["username"]);
} else {
	$username = "";
}
if (isset ( $_POST ["tel"] )) {
	$tel = mysql_real_escape_string($_POST ["tel"]);
} else {
	$tel = "";
}

if(empty($_POST['username'])){
	exit("<script>alert('姓名不能为空!');window.history.go(-1)</script>");
}
if(empty($_POST['tel'])){
	exit("<script>alert('手机不能为空!');window.history.go(-1)</script>");
}

$user_row = $db->find("select id,tel,username,recommendid from phpaadb_member where username = '".$username."' and tel='".$tel."'");

if (!empty($user_row)) {
	$record = array(
		'openid'			=>$openid
	);
	$db->update('phpaadb_member',$record,'id='.$user_row['id']);
	$_SESSION['uid'] = $user_row['id'];
	$_SESSION['tel'] = $user_row['tel'];
	$_SESSION['uname'] = $user_row['username'];
	$_SESSION['recommendid'] = $user_row['recommendid'];
	header("Location: index.php");
}else{
	exit("<script>alert('查无此人，请重新输入！');window.history.go(-1)</script>");
}

?>