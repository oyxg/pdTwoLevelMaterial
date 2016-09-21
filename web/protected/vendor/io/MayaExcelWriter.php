<?php
/**
 * 功能：Excel 写入
 * 作者：武仝
 * 日期：2013-11-29 上午9:11:06
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 */
/**-----------------------------------------------------------------
 changelog:
 
	2013-12-12 增加了 “标题”功能，调用setSubject()方法设置
	2014-03-17 增加了 saveBrowser 方法清除缓冲区的代码
	
-----------------------------------------------------------------*/

/**-----------------------------------------------------------------
 example:

		$excel=new MayaExcelWriter();
		//保存文件名
		$fileName="问题汇总表";
		//标题
		$excel->setSubject($fileName);
		//列字段
		$excel->setFields(array(
			array("name"=>"问题编号","width"=>17),
			array("name"=>"班组名称","width"=>12),
			array("name"=>"变电站名称","width"=>12),
			array("name"=>"发现时间","width"=>20),
			array("name"=>"发现者","width"=>7),
			array("name"=>"问题大类","width"=>14),
		));
		//设置数据
		$excel->setData(array(
			array(1,2,3),
			array(1,2,3),
			array(1,2,3),
		));
		//运行
		$excel->run();
		//保存输出到浏览器
		$excel->saveBrowser($fileName);
-----------------------------------------------------------------*/

//require_once 'Classes/PHPExcel.php';
//require_once 'MayaExcelStyle.php';

require_once dirname(dirname(__FILE__)).'/phpexcel/PHPExcel.php';

class MayaExcelWriter{
	/**
	 * 设置标题
	 */
	private $subject="";
	/**
	 * 存储的数据
	 */
	private $data=null;
	/**
	 * 当前最大列数
	 */
	private $columnNum=0;
	/**
	 * 当前最大行数
	 */
	private $rowNum=0;
	/**
	 * 字段参数
	 */
	private $fields=array();
	/**
	 * 样式
	 * @var MayaExcelStyle
	 */
	public $style=null;
	/**
	 * PHPExcel对象
	 * @var PHPExcel
	 */
	public $phpExcel=null;
	/**
	 * 当前使用的工作表
	 * @var PHPExcel_Worksheet
	 */
	public $activeSheet=null;
	/**
	 * PHPExcel_Writer对象
	 * @var PHPExcel_Writer_Excel5
	 */
	public $excelWriter=null;
	
	/**
	 * 构造
	 * @param string 路径
	 */
	public function __construct(array $data=null){
		if ($data!=null) {
			$this->setData($data);
		}
		$this->init();
	}
	public function init(){
		//实例化PHPExcel
		$this->phpExcel=new PHPExcel();
		//获取当前使用的工作表
		$this->activeSheet=$this->phpExcel->getActiveSheet();
		//设置工作表选项卡名称
		$this->activeSheet->setTitle("data");
		//实例化Writer
		$this->excelWriter=new PHPExcel_Writer_Excel5($this->phpExcel);
		//实例化默认样式
		$this->style=new MayaExcelStyle();
	}
	/**
	 * 设置标题
	 * @param string 第一行标题
	 */
	public function setSubject($subject){
		$this->subject=$subject;
	}
	/**
	 * 设置要储存的数据
	 * @param array 数组数据
	 */
	public function setData(array $data){
		$this->data=$data;
	}
	/**
	 * 设置字段参数（array( 'name'=>'字段名','width'=>字段宽度)）
	 * @param array 字段参数
	 */
	public function setFields(array $fields){
		$this->fields=$fields;
	}
	/**
	 * 设置excel样式
	 */
	public function setStyle(){
		$this->setColumnAndRow();
		$this->activeSheet->getDefaultRowDimension()->setRowHeight($this->style->rowHeight);
		$this->activeSheet->getStyle("A1:".$this->columnNum.$this->rowNum)->applyFromArray($this->style->borderStyle);
		$this->activeSheet->getStyle("A1:".$this->columnNum.$this->rowNum)->applyFromArray($this->style->alignmentStyle);
		$this->activeSheet->getStyle("A1:".$this->columnNum.$this->rowNum)->applyFromArray($this->style->globalStyle);
	}
	public function setColumnAndRow(){
		$this->columnNum=$this->activeSheet->getHighestColumn();
		$this->rowNum=$this->activeSheet->getHighestRow();
	}
	/**
	 * 运行
	 */
	public function run(){
		//检测是否是合法的数据
		if (!is_array($this->data[0])) {
			//throw new Exception("数据为空，没有记录需要导出");
			WMessage::htmlWarn("数据为空，没有记录需要导出", 0);
		}
		//数据的键
		$dataKeys=array_keys($this->data[0]);
		//列的长度
		$dataFieldCount=count($dataKeys);
		//循环添加数据
		for($i=0;$i<count($this->data);$i++){
			for($j=0;$j<$dataFieldCount;$j++){
				$cell=$this->activeSheet->getCellByColumnAndRow($j,$i+1);
				$cell->setValue($this->data[$i][$dataKeys[$j]]);
				$cell->getStyle()->getAlignment()->setWrapText(true);
				if($i%2==1){
					$column_row=$cell->getColumn().$cell->getRow();
					$this->activeSheet->getStyle($column_row)->getFill()->applyFromArray($this->style->rowBackStyle);
				}
			}
		}
		//在顶部插入一行
		$this->activeSheet->insertNewRowBefore(1,1);
		//设置列的选项
		for($i=0;$i<count($this->fields);$i++){
			$cell=$this->activeSheet->getCellByColumnAndRow($i,1);
			$cell->setValue($this->fields[$i]['name']);
			$this->activeSheet->getColumnDimensionByColumn($i)->setWidth($this->fields[$i]['width']);
		}
		//获取最大列数和行数
		$this->setColumnAndRow();
		$this->activeSheet->getStyle("A1:".$this->columnNum."1")->applyFromArray($this->style->fieldStyle);
		//设置全局默认样式
		$this->setStyle();
		//如果设置了标题
		if($this->subject!=""){
			//在顶部插入一行
			$this->activeSheet->insertNewRowBefore(1,1);
			//合并
			$this->activeSheet->mergeCells('A1:'.$this->columnNum."1");
			//设置标题
			$this->activeSheet->setCellValue('A1',$this->subject);
			//设置行高
			$this->activeSheet->getRowDimension('1')->setRowHeight(40);
			//设置对齐
			$this->activeSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->activeSheet->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//设置样式
			$this->activeSheet->getStyle('A1')->getFont()->setName("微软雅黑");
			$this->activeSheet->getStyle('A1')->getFont()->setBold(true);
			$this->activeSheet->getStyle('A1')->getFont()->setSize(14);
		}
		
	}
	/**
	 * 输出到浏览器
	 * @param string 保存文件名
	 */
	public function saveBrowser($fileName){
		ob_clean();
		$fileName=iconv("utf-8", "gbk", $fileName);
		header("content-type:application/iyoungsun");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Disposition: attachment;filename="'.$fileName.'.xls"');
		$this->excelWriter->save("php://output");
	}
	/**
	 * 保存到磁盘
	 * @param string 保存路径（要包含文件名）
	 */
	public function savePath($path){
		$this->excelWriter->save(iconv("utf-8", "gbk", $path));
	}
}

