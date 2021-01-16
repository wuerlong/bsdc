<?php
/*
 * phpaaCMS公共配置文件
 */
header('Content-Type: text/html; charset=utf-8');

if(!defined('ROOT_PATH')) define('ROOT_PATH',dirname(dirname(__FILE__)).'/');

require_once ROOT_PATH.'data/website.inc.php';		//网站信息配置文件 						
require_once ROOT_PATH.'data/database.inc.php';		//数据库配置文件
require_once ROOT_PATH.'include/mysql.class.php';	//数据库操作类
require_once ROOT_PATH.'include/functions.php';		//公共函数函数



/**
 *-----------------------------------------------
 * 数据库连接
 *-----------------------------------------------
 */
$db = new Mysql();
$db->connect(DB_HOST,DB_USER,DB_PWD,DB_NAME,DB_CHARSET);
//$db->debug();

/*防止 PHP 5.1.x 使用时间函数报错*/
if(function_exists('date_default_timezone_set')) date_default_timezone_set('PRC');


foreach(array('_COOKIE', '_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		$_key{0} != '_' && $$_key = daddslashes($_value);
	}
}
unset($_request, $_key, $_value);

function daddslashes($string, $force = 0) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}
?>