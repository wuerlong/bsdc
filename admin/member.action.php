<?php
require_once ("global.php");
$act = $_POST ['act'];


if ($act=='add') {
	if(empty($_POST['recommendid'])){
		exit("<script>alert('部门不能为空!');window.history.go(-1)</script>");
	}
	if(empty($_POST['username'])){
		exit("<script>alert('姓名不能为空!');window.history.go(-1)</script>");
	}
	if(empty($_POST['tel'])){
		exit("<script>alert('手机号不能为空!');window.history.go(-1)</script>");
	}
	
	if(check_username($_POST['tel'])){
		exit("<script>alert('老师 ".$_POST['username']." 已经存在!');window.history.go(-1)</script>");
	}
	
	$nid = check_partment($_POST['recommendid']);
	
	$id = $nid['id'] + 1;
	//print_r($nid) ;die;
	
	$record = array(
		'id'			=>$id,
		'recommendid'			=>$_POST ['recommendid'],
		'username'			=>$_POST ['username'],
		'tel'			=>$_POST ['tel']
	);
	$id = $db->save('phpaadb_member',$record);
	header("Location: member.php");
}

if ($act=='edit'){
	
	if(empty($_POST['recommendid'])){
		exit("<script>alert('部门不能为空!');window.history.go(-1)</script>");
	}
	if(empty($_POST['username'])){
		exit("<script>alert('姓名不能为空!');window.history.go(-1)</script>");
	}
	if(empty($_POST['tel'])){
		exit("<script>alert('手机号不能为空!');window.history.go(-1)</script>");
	}
	
	$pname = $db->find("select recommendid from phpaadb_member where id='".$_POST['userid']."' order by id desc");
	
	//print_r($pname) ;die;
	
	if($pname['recommendid'] == $_POST['recommendid']){
		$record = array(
			'recommendid'			=>$_POST ['recommendid'],
			'username'			=>$_POST ['username'],
			'tel'			=>$_POST ['tel']
		);
		$db->update('phpaadb_member',$record,'id='.$_POST['userid']);
	}else{
		$nid = check_partment($_POST['recommendid']);
	
		$id = $nid['id'] + 1;
		
		$record = array(
			'id'			=>$id,
			'recommendid'			=>$_POST ['recommendid'],
			'username'			=>$_POST ['username'],
			'tel'			=>$_POST ['tel']
		);
		$db->update('phpaadb_member',$record,'tel='.$_POST['tel']);
	}
	
	header("Location: member.php");
}

//验证留言
if ($act=='validate'){
	$id = $_POST ['id'];
	$record = array(
		'state'			=>$_POST ['validate']
	);
	 $db->update('phpaadb_member',$record,'id='.$id);
	 exit();
}

//管理员回复


if ($act=='delete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_member','id in('.$id.')');
	exit();
}


function check_username($tel){
	global $db;
	return $db->getRowsNum("select id from phpaadb_member where tel='".$tel."'");
}

function check_partment($partment){
	global $db;
	
	$pid = $db->find("select id from phpaadb_member where recommendid='".$partment."' order by id desc");
	
	return $pid;
}


?>