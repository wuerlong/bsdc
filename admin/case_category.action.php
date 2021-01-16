<?php
require_once ("global.php");
$act = $_POST['act'];

if($act=='add'){
	$pid = $_POST['pid'];
	$record = array(
		'pid'		=>$_POST ['pid'],
		'name'		=>$_POST ['name'],		
		'seq'		=>$_POST ['seq'],
		'description'=>$_POST['description'],
		'addtime'			=>time()
	);
	$id = $db->save('phpaadb_case_category',$record);
	header("Location: case_category.php");
}
if ($act=='edit'){
	$pid = $_POST['pid'];
	$id  = $_POST['cid'];
	$record = array(
		'pid'		=>$_POST ['pid'],
		'name'		=>$_POST ['name'],		
		'seq'		=>$_POST ['seq'],
		'description'=>$_POST['description']
	);
	$db->update('phpaadb_case_category',$record,'id='.$id);
	header("Location: case_category.php");
}

if ($act=='delete'){
	$id = $_POST['id'];
	$ids = getAllCatetoryIds($id);
	$db->delete('phpaadb_case_category','id in('.$ids.')');
	$db->update('phpaadb_case',array('delete_session_id'=>$_COOKIE['userid']),'cid in('.$ids.')');
	exit(1);
}


function getAllChildCategoryIds($id,&$ids=''){
	global $db;
	$list = $db->findAll("select id from phpaadb_case_category where pid=".$id);
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
?>