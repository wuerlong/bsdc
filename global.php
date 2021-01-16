<?php
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
/**
 * 前台公用配置文件
 * 
 */
session_start();
$openid = $_SESSION['openid'];
$uid = $_SESSION['uid'];
$tel = $_SESSION['tel'];
$uname = $_SESSION['uname'];
$recommendid = $_SESSION['recommendid'];
require_once 'data/config.inc.php';				//系统初始化文件
require_once 'include/function.web.php';		//后台公用函数库
?>