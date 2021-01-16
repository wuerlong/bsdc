<?php 

/* 
 * 功能：数据备份/恢复文件简易方法 
 *   以日期为单位，一天一个备份文件，以当天最后备份为准 
 *   用提交表单的形式进行操作， 
 *  其中$_POST["tbl_name"]为预备份表名称数组 
 *      $_POST["sqlfile"]为预恢复数据文件的名称 
 *  注意：该备份没有结构备份，只有数据备份 
 * 
 *  备份文件格式： 
 *  `表名称1`{{数据1}}`表名称2`{{数据2}}`表名称3`{{数据3}}... 
 *  
 * 创建时间：2005-02-25 
 * E-mail: kingerq AT msn.com 
 * 来源：http://blog.csdn.net/kingerq 
 */ 

require_once ("global.php");

set_time_limit(0); 

$dbdir = ROOT_PATH."data/database_bakup/";//用绝对路径 
echo $dbdir;
$txtname = array(); 
if($_POST){ 
 if(!is_writable($dbdir)) { 
  echo "对不起！指定的备份目录不可写！请修改权限"; 
  exit; 
 } 
  
 //op为一个隐形域，识别备份或者恢复 
 if($_POST["op"]){//备份数据 
  //生成每个表的临时备份文件 
  foreach($_POST["tbl_name"] as $tbl){ 
   $txtname[] = $tbl.".txt"; 
   $sql = "SELECT * FROM `$tbl`  
INTO OUTFILE '".$dbdir.end($txtname)."'"; 
   $db->query($sql); 
  } 
  
  //将生成的临时备份文件合在一起 
  $outfile = date("Y-m-d").".sql"; 
   
  if(file_exists($dbdir.$outfile)) @unlink($dbdir.$outfile); 
   
  $fpr = fopen($dbdir.$outfile, "a"); 
  foreach($txtname as $txt){ 
   if(file_exists($dbdir.$txt)){ 
    //读取临时备份文件 
    $tdata = readfiles($dbdir.$txt); 
         
    //生成备份文件 
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
    $sql = "LOAD DATA LOW_PRIORITY INFILE ' 
".$dbdir.$tt.".txt"."' INTO TABLE `$tt`"; 
    if($db->query($sql)){ 
     fclose($fp); 
     echo $tt."表数据恢复成功！<br>\n"; 
     unlink($dbdir.$tt.".txt"); 
    }else{ 
     echo $tt."表数据恢复失败！<br>\n"; 
    } 
   } 
    
  } 
  //echo $tdata; 
  //print_r($data_ar); 
  //exit; 
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