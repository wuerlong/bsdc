<?php
require_once ("global.php");
$act = $_POST['act'];
if($act=='add'){
	$pid = $_POST['pid'];
	$record = array(
		'pid'		=>$_POST ['pid'],
		'name'		=>$_POST ['name'],		
		'seq'		=>$_POST ['seq']
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['description']=$upload_file;
	}
	$id = $db->save('phpaadb_category',$record);
	header("Location: category_pro.php");
}
if ($act=='edit'){
	$pid = $_POST['pid'];
	$id  = $_POST['cid'];
	$record = array(
		'pid'		=>$_POST ['pid'],
		'name'		=>$_POST ['name'],		
		'seq'		=>$_POST ['seq']
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['description']=$upload_file;
	}
	$db->update('phpaadb_category',$record,'id='.$id);
	header("Location: category_pro.php");
}

if ($act=='delete'){
	$id = $_POST['id'];
	$ids = getAllCatetoryIds($id);
	$db->delete('phpaadb_category','id in('.$ids.')');
	$db->update('phpaadb_article',array('delete_session_id'=>$_COOKIE['userid']),'cid in('.$ids.')');
	exit(1);
}


function getAllChildCategoryIds($id,&$ids=''){
	global $db;
	$list = $db->findAll("select id from phpaadb_category where pid=".$id);
	foreach($list as $ls){
		$ids = empty($ids)?$ls['id']:$ids .','.$ls['id'];
		getAllChildCategoryIds($ls['id'],$ids);
	}
	return $ids;
}
function getAllCatetoryIds($id){
	$ids = getAllChildCategoryIds($id);
	return empty($ids)?$id:$id.','.$ids;
}
//删除缩略图
if ($act=='delpic') {
	$id = $_POST ['id'];
	$pic_path = $db->getOneField("select description from phpaadb_category where id=".$id);
	if(is_file(ROOT_PATH.$pic_path)){
		@unlink(ROOT_PATH.$pic_path);
	}
	$db->update('phpaadb_category',array('description'=>''),'id in('.$id.')');
	exit();
}

?>