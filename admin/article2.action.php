<?php
require_once ("global.php");

$act = trim($_POST ['act']);
//var_dump($_POST);
//die;
//添加文章
if ($act=='add') {
	if(empty($_POST['title'])){
		exit("<script>alert('标题不能为空!');window.history.go(-1)</script>");
	}
	if(empty($_POST['cid'])){
		exit("<script>alert('请选择栏目!');window.history.go(-1)</script>");
	}
	$record = array(
		'cid'			=>$_POST ['cid'],
		'title'			=>$_POST ['title'],
		'subtitle'		=>$_POST ['subtitle'],
		'att'			=>is_array($_POST ['att'])?implode(',',$_POST ['att']):'',
		'source'		=>$_POST ['source'],
		'author'		=>$_POST ['author'],
		'resume'		=>$_POST ['resume'],
		'content'		=>$_POST ['content'],
		'orderlist'		=>$_POST ['orderlist'],
		'pubdate'		=>$_POST ['pubdate'],
		'created_date'	=>date ( "Y-m-d H:i:s" ),
		'created_by'	=>$_COOKIE['userid']	
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['pic']=$upload_file;
	}
	$id = $db->save('phpaadb_rest',$record);
	header("Location: article2.php");
}

//修改文章
if ($act=='edit'){
	$id = $_POST ['id'];
	if(empty($_POST['title'])){
		exit("<script>alert('标题不能为空!');window.history.go(-1)</script>");
	}
	if(empty($_POST['cid'])){
		exit("<script>alert('栏目不能为空!');window.history.go(-1)</script>");
	}	
	$record = array(
		'cid'			=>$_POST ['cid'],
		'title'			=>$_POST ['title'],
		'subtitle'		=>$_POST ['subtitle'],
		'att'			=>is_array($_POST ['att'])?implode(',',$_POST ['att']):'',
		'source'		=>$_POST ['source'],
		'author'		=>$_POST ['author'],
		'resume'		=>$_POST ['resume'],
		'content'		=>$_POST ['content'],
		'orderlist'		=>$_POST ['orderlist'],
		'pubdate'	=>$_POST ['pubdate'],
		'created_date'	=>date ( "Y-m-d H:i:s" ),
		'created_by'	=>$_COOKIE['userid']	
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['pic']=$upload_file;
	}
	$db->update('phpaadb_rest',$record,'id='.$id);
	header("Location: article2.php");
}

//删除文章
if ($act=='delete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_rest','id in('.$id.')');
	exit();
}

//转移文章
if ($act=='move') {	
	$scid =$_POST['scid'];
	$id = $_POST ['id'];
	$db->update('phpaadb_rest',array('cid'=>$scid),'id in('.$id.')');
	exit();
}

//删除缩略图
if ($act=='delpic') {
	$id = $_POST ['id'];
	$pic_path = $db->getOneField("select pic from phpaadb_res where id=".$id);
	$pic_path = $db->getOneField("select pic from phpaadb_res where id=".$id);
	if(is_file(ROOT_PATH.$pic_path)){
		@unlink(ROOT_PATH.$pic_path);
	}
	$db->update('phpaadb_rest',array('pic'=>''),'id in('.$id.')');
	exit();
}

//彻底删除垃圾
if ($act=='cdelete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_rest','id in('.$id.')');
	exit();
}

//还原垃圾
if ($act=='revert') {	
	$id = $_POST ['id'];
	$db->query("UPDATE phpaadb_rest set delete_session_id = null where id in (".$id.")");
}


?>