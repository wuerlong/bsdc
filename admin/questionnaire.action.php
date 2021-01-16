<?php
require_once ("global.php");
$act = $_POST ['act'];
if ($act=='add') {	
	$content = serialize($_POST['qalist']);
	$record = array(
		'title'			=>$_POST ['title'],
		'content'			=>$content,
		'qa'			=>$_POST ['qa'],
		'qb'			=>$_POST ['qb'],
		'qc'			=>$_POST ['qc'],
		'qd'			=>$_POST ['qd'],
		'correct'			=>$_POST ['correct'],
		'cid'			=>$_POST ['cid'],
		'addtime'			=>time()
	);

	$id = $db->save('phpaadb_questionnaire',$record);
	header("Location: questionnaire.php");
}

if ($act=='edit'){
	$id = $_POST ['id'];
	$content = serialize($_POST['qalist']);
	//echo $content;die;
	$record = array(
		'title'			=>$_POST ['title'],
		'content'			=>$content,
		'qa'			=>$_POST ['qa'],
		'qb'			=>$_POST ['qb'],
		'qc'			=>$_POST ['qc'],
		'qd'			=>$_POST ['qd'],
		'correct'			=>$_POST ['correct'],
		'cid'			=>$_POST ['cid']
	);
	
	 $db->update('phpaadb_questionnaire',$record,'id='.$id);
	 header("Location: questionnaire.php");
}

if ($act=='delete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_questionnaire','id in('.$id.')');
	exit();
}

?>