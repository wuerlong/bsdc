<?php
	
 include_once 'global.php';

 
 $headimgurl = $_GET['headimgurl'];
 $nickname = $_GET['nickname'];
 
 //echo $openid;die;

 if($openid){
	// echo $openid;die;
	$user_row = check_code($openid);
	if(!empty($user_row)){
		 $_SESSION['uid'] = $user_row['id'];
		$_SESSION['tel'] = $user_row['tel'];
		$_SESSION['uname'] = $user_row['username'];
		$_SESSION['recommendid'] = $user_row['recommendid'];
		 header("Location:main.php");
	 	 exit(); 
	  }else{
		  header("Location: login.php");
	 	 exit(); 
	  }
	  
 }else{
	 header("Location: code/");
	 exit();
 }

function check_code($openid){
	global $db;
	$date = $db->find("select id,tel,username,recommendid from phpaadb_member where openid='".$openid."' and state = 0 order by id desc");
	return $date;
}
?>