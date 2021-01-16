<?php
require_once ("global.php");

$act = trim($_POST ['act']);

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
		'price'		=>$_POST ['price'],
		'att'			=>$_POST ['att'],
		'color'			=>is_array($_POST ['color'])?implode(',',$_POST ['color']):'',
		'beizhu'		=>$_POST ['beizhu'],
		'orderlist'		=>$_POST ['orderlist'],
		'brand'		=>$_POST ['brand'],
		'purpose'		=>$_POST ['purpose'],
		'subsidiary'		=>$_POST ['subsidiary'],
		'resume'		=>$_POST ['resume'],
		'infor01'		=>$_POST ['infor01'],
		'infor02'		=>$_POST ['infor02'],
		'infor03'		=>$_POST ['infor03'],
		'infor04'		=>$_POST ['infor04'],
		'infor05'		=>$_POST ['infor05'],
		'infor06'		=>$_POST ['infor06'],
		'infor07'		=>$_POST ['infor07'],
		'infor08'		=>$_POST ['infor08'],
		'infor09'		=>$_POST ['infor09'],
		'content'		=>$_POST ['content'],
		'pubdate'		=>date ( "Y-m-d H:i:s" ),
		'created_date'	=>date ( "Y-m-d H:i:s" ),
		'created_by'	=>$_COOKIE['userid']	
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['pic']=$upload_file;
	}
	$id = $db->save('phpaadb_case',$record);
	header("Location: case.php?id=".$_POST['cid']);
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
		'price'		=>$_POST ['price'],
		'att'			=>$_POST ['att'],
		'color'			=>is_array($_POST ['color'])?implode(',',$_POST ['color']):'',
		'beizhu'		=>$_POST ['beizhu'],
		'orderlist'		=>$_POST ['orderlist'],
		'brand'		=>$_POST ['brand'],
		'purpose'		=>$_POST ['purpose'],
		'subsidiary'		=>$_POST ['subsidiary'],
		'resume'		=>$_POST ['resume'],
		'infor01'		=>$_POST ['infor01'],
		'infor02'		=>$_POST ['infor02'],
		'infor03'		=>$_POST ['infor03'],
		'infor04'		=>$_POST ['infor04'],
		'infor05'		=>$_POST ['infor05'],
		'infor06'		=>$_POST ['infor06'],
		'infor07'		=>$_POST ['infor07'],
		'infor08'		=>$_POST ['infor08'],
		'infor09'		=>$_POST ['infor09'],
		'content'		=>$_POST ['content'],
		'pubdate'	=>date ( "Y-m-d H:i:s" ),
		'created_date'	=>date ( "Y-m-d H:i:s" ),
		'created_by'	=>$_COOKIE['userid']	
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['pic']=$upload_file;
	}
	$db->update('phpaadb_case',$record,'id='.$id);
	header("Location: case.php?id=".$_POST['cid']);
}

//删除文章
if ($act=='delete') {	
	$id = $_POST ['id'];
	$db->update('phpaadb_case',array('delete_session_id'=>$_COOKIE['userid']),'id in('.$id.')');
	exit();
}

//转移文章
if ($act=='move') {	
	$scid =$_POST['scid'];
	$id = $_POST ['id'];
	$db->update('phpaadb_case',array('cid'=>$scid),'id in('.$id.')');
	exit();
}

//删除缩略图
if ($act=='delpic') {
	$id = $_POST ['id'];
	$pic_path = $db->getOneField("select pic from phpaadb_article where id=".$id);
	$pic_path = $db->getOneField("select pic from phpaadb_article where id=".$id);
	if(is_file(ROOT_PATH.$pic_path)){
		@unlink(ROOT_PATH.$pic_path);
	}
	$db->update('phpaadb_article',array('pic'=>''),'id in('.$id.')');
	exit();
}

//彻底删除垃圾
if ($act=='cdelete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_case','id in('.$id.')');
	exit();
}

//还原垃圾
if ($act=='revert') {	
	$id = $_POST ['id'];
	$db->query("UPDATE phpaadb_case set delete_session_id = null where id in (".$id.")");
}


?>