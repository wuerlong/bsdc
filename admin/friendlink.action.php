<?php
require_once ("global.php");
$act = $_POST ['act'];

if ($act=='add') {	
	$record = array(
		'tel'		=>$_POST ['tel'],
		'name'			=>$_POST ['name'],
		'url'			=>$_POST ['url'],
		'worktime'			=>$_POST ['worktime'],
		'content'	=>$_POST ['content'],
		'seq'			=>$_POST ['seq']
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['pic']=$upload_file;
	}
	$id = $db->save('phpaadb_friendlink',$record);
	header("Location: friendlink.php");
}

if ($act=='edit'){
	$id = $_POST ['id'];
	$record = array(
		'tel'		=>$_POST ['tel'],
		'name'			=>$_POST ['name'],
		'url'			=>$_POST ['url'],
		'worktime'			=>$_POST ['worktime'],
		'content'	=>$_POST ['content'],
		'seq'			=>$_POST ['seq']
	);
	if(!empty($_FILES['pic']['name'])){
		$upload_file = uploadFile('pic');//上传图片，返回地址
		$record['pic']=$upload_file;
	}
	 $db->update('phpaadb_friendlink',$record,'id='.$id);
	 header("Location: friendlink.php");
}

if ($act=='validate') {	
	$id = $_POST ['id'];
	$state = $_POST ['state'];
	
	if($state==0){
		$db->update('phpaadb_friendlink',array('state'=>$_POST ['state']),'id='.$id);
		exit();
	}
	//
	
	$worklist = $db->find("select * from phpaadb_friendlink where id = '".$id."' order by seq asc");
	
	$orderlist = $db->findAll("select * from phpaadb_order where pickortime >= '".$worklist['tel']."' and pickortime <= '".$worklist['worktime']."' group by tel ");
	
	$telid ='';
	foreach ($orderlist as $list){
		$telid = $list['tel']."','".$telid;
	}
	$telid = substr($telid,0,-3);
	
	//echo "select * from phpaadb_member where tel not in  ('".$telid."') order by inviteid desc";die;
	
	$userlist = $db->findAll("select * from phpaadb_member where tel not in  ('".$telid."') order by inviteid desc,id asc");
	
	
	$sttime = $worklist['tel'].' 00:00:00';
	$entime = $worklist['worktime'].' 00:00:00';
	$starttime = strtotime($sttime);
	$endtime = strtotime($entime);
	
	$timelist = array($worklist['tel']);
	$timeli = $starttime;
	for ($x=0; $x<=11; $x++) {
		$timeli = $timeli + 86400;
		if($timeli<=$endtime){
			$timelo = date('Y-m-d',$timeli);
			if($timelo=='2020-06-25' || $timelo=='2020-06-26' || $timelo=='2020-06-27' || $timelo=='2020-09-26' || $timelo=='2020-10-01' || $timelo=='2020-10-02' || $timelo=='2020-10-03' || $timelo=='2020-10-04' || $timelo=='2020-10-05' || $timelo=='2020-10-06' || $timelo=='2020-10-07' || $timelo=='2020-10-08'){
				
			}else{
				array_push($timelist,$timelo);
			}
		}
	}
	
	//print_r($timelist);die;
	//print_r($userlist);die;
	//echo $telid;die;
	foreach ($userlist as $ulist){
		
		foreach ($timelist as $value){
			
			$record = array(
				'uname'			=>$ulist['username'],
				'carno'			=>$ulist['recommendid'],
				'tel'		=>$ulist['tel'],
				'shopid'			=>$ulist['username'],
				'serviceid'		=>'点餐服务',
				'picktime'		=>$value.'早餐',
				'pickortime'		=>$value,
				'num'		=>1,
				'type'		=>0,
				'category'		=>'早餐',
				'pubdate'		=>date ( "Y-m-d H:i:s" ),
				'created_date'	=>date ( "Y-m-d H:i:s" )
			);
			
			$record1 = array(
				'uname'			=>$ulist['username'],
				'carno'			=>$ulist['recommendid'],
				'tel'		=>$ulist['tel'],
				'shopid'			=>$ulist['username'],
				'serviceid'		=>'点餐服务',
				'picktime'		=>$value.'午餐',
				'pickortime'		=>$value,
				'num'		=>1,
				'type'		=>0,
				'category'		=>'午餐',
				'pubdate'		=>date ( "Y-m-d H:i:s" ),
				'created_date'	=>date ( "Y-m-d H:i:s" )
			);
			
			$id = $db->save('phpaadb_order',$record);
			
			$id1 = $db->save('phpaadb_order',$record1);
			
		}
		
	}
	
	$db->update('phpaadb_friendlink',array('state'=>$_POST ['state']),'id='.$id);
	exit();
}

if ($act=='down') {	
	$id = $_POST ['id'];
	$db->update('phpaadb_friendlink',array('state'=>'1'),'id in('.$id.')');
	exit();
}

if ($act=='delete') {	
	$id = $_POST ['id'];
	$db->delete('phpaadb_friendlink','id in('.$id.')');
	exit();
}

//删除缩略图
if ($act=='delpic') {
	$id = $_POST ['id'];
	$pic_path = $db->getOneField("select pic from phpaadb_friendlink where id=".$id);
	if(is_file(ROOT_PATH.$pic_path)){
		@unlink(ROOT_PATH.$pic_path);
	}
	$db->update('phpaadb_friendlink',array('pic'=>''),'id in('.$id.')');
	exit();
}
?>