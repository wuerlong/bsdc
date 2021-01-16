<?php 
require_once ("global.php"); 
set_time_limit(0); 
$dbdir =  ROOT_PATH."data/database_bakup/";
$dbdir = str_replace('\\','/',$dbdir);
$txtname = array(); 
if($_POST){ 
	if(!is_writable($dbdir)) { 
		echo "对不起！指定的备份目录不可写！请修改权限"; 
		exit; 
	} 
	if($_POST["action"]=='backup'){//备份数据 
		foreach($_POST["tbl_name"] as $tbl){ 
			$txtname[] = $tbl.".txt"; 
			$sql = "SELECT * FROM `$tbl` INTO OUTFILE '".$dbdir.end($txtname)."'"; 
			$db->query($sql); 
		}
		//将生成的临时备份文件合在一起 
		$outfile = date("Y-m-d").".sql"; 
		if(file_exists($dbdir.$outfile)) @unlink($dbdir.$outfile); 
		$fpr = fopen($dbdir.$outfile, "a"); 
		foreach($txtname as $txt){
			if(file_exists($dbdir.$txt)){
				$tdata = readfiles($dbdir.$txt);
				$tbl = explode(".", $txt); 
				$str = "`".$tbl[0]."`{{".$tdata."}}"; 
				if(fwrite($fpr, $str)){
					echo $tbl[0]."...写入 $outfile 成功！<br>\n";
				}else{ 
					echo $tbl[0]."...写入 $outfile 失败！<br>\n"; 
				}
				@unlink($dbdir.$txt);
			} 
		} 
		fclose($fpr); 
	 }else{//恢复数据 
	    $_POST["sqlfile"]="2010-07-14.sql";
		$tdata = readfiles($dbdir.$_POST["sqlfile"]); 
		preg_match_all("/`(.*)`\{\{(.*)\}\}/isU", $tdata, $data_ar); 
		foreach($data_ar[1] as $k => $tt){ 
			if(empty($data_ar[2][$k])) continue; 
			$tfile = $dbdir.$tt.".txt"; 
			$fp = fopen($tfile, "w"); 
			if(fwrite($fp, $data_ar[2][$k])){ 
				//清空表 
				$sql = "TRUNCATE TABLE `$tt`"; 
				$db->query($sql);
				//重新装入数据 
				$sql = "LOAD DATA LOW_PRIORITY INFILE '".$dbdir.$tt.".txt"."' INTO TABLE `$tt`"; 
				if($db->query($sql)){ 
					fclose($fp); 
					echo $tt."表数据恢复成功！<br>\n"; 
					unlink($dbdir.$tt.".txt"); 
				}else{ 
					echo $tt."表数据恢复失败！<br>\n"; 
				} 
			} 
		}
	} 
} 
  
 /*  
  * 读取文件内容 
  * 参数 $file 为文件名及完整路径 
  * 返回文件内容 
  */ 
function readfiles($file){ 
	$tdata = ""; 
	$fp = fopen($file, "r"); 
	if(filesize($file) <= 0) return; 
	while($data = fread($fp, filesize($file))){ 
		$tdata .= $data; 
	} 
	fclose($fp); 
	return $tdata; 
} 

?>  