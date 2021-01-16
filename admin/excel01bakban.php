<?php
error_reporting(0);
require_once ("global.php");
require_once('excel/PHPExcel.php');

$id 		= !empty($id) ? $id : 0;

$orderlist = $db->findAll("select a.carno,a.uname,a.num from phpaadb_order a left join phpaadb_member b on a.tel = b.tel  where  a.picktime = '".$id."' order by b.inviteid asc,b.id asc ");



//ʵ����excel��
$objPHPExcel = new \PHPExcel();
// ������һ��������
$objPHPExcel->setActiveSheetIndex(0);
// ����sheet��
$objPHPExcel->getActiveSheet()->setTitle('�Է������������緹��');

// ���ñ����
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);


// ������ͷ���ּӴ�
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
// �б�ͷ���־���
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()
	->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// ������ֵ
$objPHPExcel->getActiveSheet()->setCellValue('A1', '����');
$objPHPExcel->getActiveSheet()->setCellValue('B1', '����');
$objPHPExcel->getActiveSheet()->setCellValue('C1', '����');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ǩ��');



// ������ʼ��
$row_num = 2;
// ��ÿ�е�Ԫ���������
foreach($orderlist as $value)
{
	// �������д�ֱ����
	$objPHPExcel->getActiveSheet()->getStyle('A' . $row_num . ':' . 'J' . $row_num)->getAlignment()
		->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// ���ü۸�Ϊ���ָ�ʽ
	$objPHPExcel->getActiveSheet()->getStyle('F' . $row_num)->getNumberFormat()
		->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
	// ����
	$objPHPExcel->getActiveSheet()->getStyle('A' . $row_num . ':' . 'F' . $row_num)->getAlignment()
		->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// ���õ�Ԫ����ֵ
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $row_num, $value['carno']);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $row_num, $value['uname']);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $row_num, $value['num']);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $row_num, '');
	$row_num++;
}

$outputFileName = '�Է������������緹��_' . time() . '.xls';//�������ļ���
$xlsWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
header("Content-Type: application/force-download");//���������ǿ������
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header('Content-Disposition:inline;filename="' . $outputFileName . '"');//attachment��Ϊ��������,inline��������,filename�����ļ���
header("Content-Transfer-Encoding: binary");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");//�����������Ӧ����
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
$xlsWriter->save("php://output");
echo file_get_contents($outputFileName);


?>