<?php
require_once ("global.php");

$act = $_POST ['act'];

if ($act=='add') {	
	$upload_file = uploadFile('file');//�ϴ�ͼƬ�����ص�ַ
	header("Location: file.php");
}

if ($act=='delete') {	
	$id = $_POST ['id'];
	$list = $db->findAll('select * from phpaadb_file where id in('.$id.')');
	foreach($list as $ls){
		@unlink(dirname(dirname(__FILE__)).'/'.$ls['path']);
	}
	$db->delete('phpaadb_file','id in('.$id.')');
	exit();
}

?>