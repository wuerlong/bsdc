<?php
error_reporting(0);
/**
 * 后台公用配置文件
 * 
 * 用于后台应用初始化、后台权限验证 等
 */
session_start();
require_once '../data/config.inc.php';				//系统初始化文件
require_once '../include/function.admin.php';		//后台公用函数库

//后台登陆验证
if (!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
	setcookie(lastURL,get_url());//记录上次访问地址
	header("Location: login.php");
	exit();
}
?>