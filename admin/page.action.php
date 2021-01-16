<?php
require_once ("global.php");
$act = $_POST ['act'];
if ($act=='add') {	
	$record = array(
		'title'				=>$_POST ['title'],
		'code'				=>$_POST ['code'],
		'content'			=>$_POST ['content'],
		'created_date'		=>date("Y-m-d H:i:s")
	);
	$id = $db->save('phpaadb_page',$record);
	header("Location: page.php");
}

if ($act=='edit'){
	$id = $_POST ['id'];
	if (!empty($id)) {
		$id = mysql_real_escape_string(verify_id($id));
	}
	$record = array(
		'title'				=>$_POST ['title'],
		'code'				=>$_POST ['code'],
		'content'			=>$_POST ['content']
	);
	 $db->update('phpaadb_page',$record,'id='.$id);
	 header("Location: page.php");
}

if ($act=='delete') {	
	$id = $_POST ['id'];
	if (!empty($id)) {
		$id = mysql_real_escape_string(verify_id($id));
	}
	$db->delete('phpaadb_page','id in('.$id.')');
	exit();
}

?>