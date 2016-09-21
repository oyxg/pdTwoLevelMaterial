<?php
/**
 * 功能：Excel读取
 * 作者：武仝
 * 日期：2014-3-26 下午4:54:03
 * 版权：Copyright 2007-2014 wutong All Right Reserved
 * 网址：http://www.wutong.biz
 */
/**
 * ---------------------------------------------------------
 * 2014-12-10 修正了无法正确读取列数和行数的问题
 * 2015-02-13 修正了列数为B的时候实际数字为1个Bug
 */
require_once dirname(dirname(__FILE__)).'/phpexcel/PHPExcel.php';

class MayaExcelReader{
	
	/**
	 * 导入的数据之后的每个元素的索引名称
	 * @var array
	 */
	public $field=null;
	
	/**
	 * 根据字母得到列数
	 * @var array
	 */
	public static $cellLen=array(
		"A"=>1,"B"=>2,"C"=>3,"D"=>4,"E"=>5,"F"=>6,"G"=>7,"H"=>8,"I"=>9,"J"=>10,"K"=>11,"L"=>12,"M"=>13,"N"=>14,"O"=>15,"P"=>16,"Q"=>17,"R"=>18,"S"=>19,"T"=>20,"U"=>21,"V"=>22,"W"=>23,"X"=>24,"Y"=>25,"Z"=>26,
		"AA"=>27,"AB"=>28,"AC"=>29,"AD"=>30,"AE"=>31,"AF"=>32,"AG"=>33,"AH"=>34,"AI"=>35,"AJ"=>36,"AK"=>37,"AL"=>38,"AM"=>39,"AN"=>40,"AO"=>41,"AP"=>42,"AQ"=>43,"AR"=>44,"AS"=>45,"AT"=>46,"AU"=>47,"AV"=>48,"AW"=>49,"AX"=>50,"AY"=>51,"AZ"=>52
	);
	
	/**
	 * 单元格头
	 * @var array
	 */
	static protected $cellHead=array(
		"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
		"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ"
	);
	
	/**
	 * 根据1900返回的整数进行转换成0000-00-00
	 * @param string $days
	 * @param boolean $time
	 * @return string|unknown
	 */
	public static function excelTime($days, $time=false){
		if(is_numeric($days)){
			$jd = GregorianToJD(1, 1, 1970);
			$gregorian = JDToGregorian($jd+intval($days)-25569);
			$myDate = explode('/',$gregorian);
			$myDateStr = str_pad($myDate[2],4,'0', STR_PAD_LEFT)
			."-".str_pad($myDate[0],2,'0', STR_PAD_LEFT)
			."-".str_pad($myDate[1],2,'0', STR_PAD_LEFT)
			.($time?" 00:00:00":'');
			return $myDateStr;
		}
		return $days;
	}
	
	/**
	 * 导入数据
	 * @param string $file
	 * <p>要导入的excel地址</p>
	 * @param number $indexRow
	 * <p>从第几行导入，从1开始</p>
	 * @param number $activeSheet
	 * <p>导入哪个sheet，从0开始</p>
	 * @return array
	 */
	public function importData($file,$indexRow=1,$activeSheet=0){
		$PHPReader=new PHPExcel_Reader_Excel5();
		$PHPExcel=$PHPReader->load($file);
		$currentSheet=$PHPExcel->getSheet($activeSheet);
		//声明数据
		$data=array();
		//取得一共有多少列
		//$allColumn=$currentSheet->getHighestColumn();
		$allColumn=$currentSheet->getHighestDataColumn();
		//取得一共有多少行
		//$allRow=$currentSheet->getHighestRow();
		$allRow=$currentSheet->getHighestDataRow();
		//起始数据索引
		$arrIndex=0;
		//列数 int
		$cellCount=self::$cellLen[$allColumn];
		//循环读取
		for($row=$indexRow; $row<=$allRow; $row++){
			//获取每列的数据
			for($cell=0; $cell<$cellCount; $cell++){
				//var_dump($currentSheet->getCell(self::$cellHead[$cell].$row)->getValue());
				$__field=$this->field==null ? $cell : $this->field[$cell];
				$data[$arrIndex][$__field]=addslashes(trim($currentSheet->getCell(self::$cellHead[$cell].$row)->getValue()));
			}
			$arrIndex++;
		}
		return $data;
	}
}
