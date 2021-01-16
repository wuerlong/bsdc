<?php
require_once ("global.php");

$id 		= !empty($id) ? $id : 0;

$orderlist = $db->findAll("select a.carno,a.uname,a.num from phpaadb_order a left join phpaadb_member b on a.tel = b.tel  where  a.picktime = '".$id."' order by b.inviteid asc,b.id asc ");


/**
 * ������excel�ļ�(һ�㵼�����ĵĶ������룬��Ҫ���б���ת����
 * ʹ�÷�������
 * $excel = new Excel();
 * $excel->addHeader(array('��1','��2','��3','��4'));
 * $excel->addBody(
            array(
                array('����1','����2','����3','����4'),
                array('����1','����2','����3','����4'),
                array('����1','����2','����3','����4'),
                array('����1','����2','����3','����4')
            )
        );
 * $excel->downLoad();
 */
 
$excel = new Excel();
$header = array('����','����','����','ǩ��');
$excel->addHeader($header);
$excel->addBody($orderlist);
$excel->downLoad();
		
class Excel{
    private $head;
    private $body;
     
    /**
     * 
     * @param type $arr һά����
     */
    public function addHeader($arr){
        foreach($arr as $headVal){
            $headVal = $headVal;
            $this->head .= "{$headVal}\t ";
        }
        $this->head .= "\n";
    }
     
    /**
     * 
     * @param type $arr ��ά����
     */
    public function addBody($arr){
        foreach($arr as $arrBody){
            foreach($arrBody as $bodyVal){
                $bodyVal = $this->charset($bodyVal);
                $this->body .= "{$bodyVal}\t ";
            }
            $this->body .= "\n";
        }
    }
     
    /**
     * ����excel�ļ�
     */
    public function downLoad($filename=''){
        if(!$filename)
            $filename = date('YmdHis',time()).'.xls';
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=$filename"); 
        header("Content-Type:charset=gb2312");
        if($this->head)
            echo $this->head;
        echo $this->body;
    }
     
    /**
     * ����ת��
     * @param type $string
     * @return string
     */
    public function charset($string){
        return iconv("utf-8", "gb2312", $string);
    }
}
?>