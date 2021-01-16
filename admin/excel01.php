<?php
error_reporting(0);
require_once ("global.php");
require_once('excel/PHPExcel.php');

$id 		= !empty($id) ? $id : 0;

$orderlist = $db->findAll("select a.* from phpaadb_order a left join phpaadb_member b on a.tel = b.tel  where  a.pickortime = '".$id."' and category = '早餐' order by b.inviteid desc,b.id asc ");



//实例化excel类
$objPHPExcel = new \PHPExcel();
// 操作第一个工作表
$objPHPExcel->setActiveSheetIndex(0);
// 设置sheet名
$objPHPExcel->getActiveSheet()->setTitle('吃饭汇总名单（早餐）');

// 设置表格宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);


// 列名表头文字加粗
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
// 列表头文字居中
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()
	->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// 列名赋值
$objPHPExcel->getActiveSheet()->setCellValue('A1', '部室');
$objPHPExcel->getActiveSheet()->setCellValue('B1', '姓名');
$objPHPExcel->getActiveSheet()->setCellValue('C1', '数量');
$objPHPExcel->getActiveSheet()->setCellValue('D1', '签收');



// 数据起始行
$row_num = 2;
// 向每行单元格插入数据
foreach($orderlist as $value)
{
	// 设置所有垂直居中
	$objPHPExcel->getActiveSheet()->getStyle('A' . $row_num . ':' . 'J' . $row_num)->getAlignment()
		->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// 设置价格为数字格式
	$objPHPExcel->getActiveSheet()->getStyle('F' . $row_num)->getNumberFormat()
		->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
	// 居中
	$objPHPExcel->getActiveSheet()->getStyle('A' . $row_num . ':' . 'F' . $row_num)->getAlignment()
		->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// 设置单元格数值
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $row_num, $value['carno']);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $row_num, $value['uname']);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $row_num, $value['num']);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $row_num, '');
	$row_num++;
}

$outputFileName = '吃饭汇总名单（早餐）_' . time() . '.xls';//导出的文件名
$xlsWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
ob_end_clean();
header("Content-type: application/vnd.ms-excel; charset=gbk");
header("Content-Type: application/force-download");//告诉浏览器强制下载
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header('Content-Disposition:inline;filename="' . $outputFileName . '"');//attachment作为附件下载,inline在线下载,filename设置文件名
header("Content-Transfer-Encoding: binary");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");//设置浏览器响应缓存
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
$xlsWriter->save("php://output");
echo file_get_contents($outputFileName);


?>