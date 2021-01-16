<?php
require_once ("global.php");
$act = $_POST['act'];

if($act=='add'){
	$pid = $_POST['pid'];
	$record = array(
		'pid'		=>$_POST ['pid'],
		'name'		=>$_POST ['name'],		
		'seq'		=>$_POST ['seq'],
		'description'=>$_POST['description']
	);
	$id = $db->save('phpaadb_category',$record);
	header("Location: category.php");
}
if ($act=='edit'){
	$pid = $_POST['pid'];
	$id  = $_POST['cid'];
	if (!empty($id)) {
		$id = mysql_real_escape_string(verify_id($id));
	}
	$record = array(
		'pid'		=>$_POST ['pid'],
		'name'		=>$_POST ['name'],		
		'seq'		=>$_POST ['seq'],
		'description'=>$_POST['description']
	);
	$db->update('phpaadb_category',$record,'id='.$id);
	header("Location: category.php");
}

if ($act=='delete'){
	$id = $_POST['id'];
	if (!empty($id)) {
		$id = mysql_real_escape_string(verify_id($id));
	}
	$ids = getAllCatetoryIds($id);
	$db->delete('phpaadb_category','id in('.$ids.')');
	$db->update('phpaadb_article',array('delete_session_id'=>$_COOKIE['userid']),'cid in('.$ids.')');
	exit(1);
}


function getAllChildCategoryIds($id,&$ids=''){
	global $db;
	if (!empty($id)) {
		$id = mysql_real_escape_string(verify_id($id));
	}
	$list = $db->findAll("select id from phpaadb_category where pid=".$id);
	foreach($list as $ls){
		$ids = empty($ids)?$ls['id']:$ids .','.$ls['id'];
		getAllChildCategoryIds($ls['id'],$ids);
	}
	return $ids;
}
function getAllCatetoryIds($id){
	if (!empty($id)) {
		$id = mysql_real_escape_string(verify_id($id));
	}
	$ids = getAllChildCategoryIds($id);
	return empty($ids)?$id:$id.','.$ids;
}
?>