<?php
require_once ("global.php");
$act = $_POST ['act'];
if ($act=='add') {	
	$record = array(
		'title'			=>$_POST ['title'],
		'titleen'			=>$_POST ['titleen'],
		'titlejp'			=>$_POST ['titlejp'],
		'pic_url'			=>$_POST ['pic_url'],
		'category'			=>$_POST ['category'],
		'state'			=>$_POST ['state']
	);
	if(!empty($_FILES['content']['name'])){
		$upload_file = uploadFile('content');//上传图片，返回地址
		$record['content']=$upload_file;
	}
	$id = $db->save('phpaadb_notice',$record);
	header("Location: notice.php");
}

if ($act=='edit'){
	$id = $_POST ['id'];
	$record = array(
		'title'			=>$_POST ['title'],
		'titleen'			=>$_POST ['titleen'],
		'titlejp'			=>$_POST ['titlejp'],
		'pic_url'			=>$_POST ['pic_url'],
		'category'			=>$_POST ['category'],
		'state'			=>$_POST ['state']
	);
	

	if(!empty($_FILES['content']['name'])){
		$upload_file = uploadFile('content');//上传图片，返回地址
		$record['content']=$upload_file;
	}
	 $db->update('phpaadb_notice',$record,'id='.$id);
	 header("Location: notice.php");
}

if ($act=='delete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_notice','id in('.$id.')');
	exit();
}

//删除缩略图
if ($act=='delpic') {
	$id = $_POST ['id'];
	$pic_path = $db->getOneField("select content from phpaadb_notice where id=".$id);
	$pic_path = $db->getOneField("select content from phpaadb_notice where id=".$id);
	if(is_file(ROOT_PATH.$pic_path)){
		@unlink(ROOT_PATH.$pic_path);
	}
	$db->update('phpaadb_notice',array('pic'=>''),'id in('.$id.')');
	exit();
}

?>