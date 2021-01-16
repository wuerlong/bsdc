<?php
require_once ("global.php");
$act = $_POST ['act'];

//验证留言
if ($act=='validate'){
	$id = $_POST ['id'];
	$record = array(
		'state'			=>$_POST ['validate']
	);
	 $db->update('phpaadb_order',$record,'id='.$id);
	 exit();
}

//管理员回复


if ($act=='delete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_order','id in('.$id.')');
	exit();
}

?>