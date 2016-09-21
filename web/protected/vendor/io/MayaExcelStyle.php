<?php
/**
 * 功能：Excel配置
 * 作者：武仝
 * 日期：2013-11-29 下午12:41:08
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 */
class MayaExcelStyle{
	/**
	 * 字体
	 */
	public $fontName="微软雅黑";
	/**
	 * 文字大小
	 */
	public $fontSize=9;
	/**
	 * 字体颜色
	 */
	public $fontColor="#000000";
	/**
	 * 字段背景色
	 */
	public $fieldBackgroundColor="#cccccc";
	/**
	 * 单元格边框颜色
	 */
	public $cellBorderColor="#666";
	/**
	 * 单元格宽度
	 */
	public $cellWidth=30;
	/**
	 * 单元格高度
	 */
	public $rowHeight=20;
	/**
	 * 颜色对象
	 * @var PHPExcel_Style_Color
	 */
	public $fontColorObj=null;
	public $fieldBackgroundColorObj=null;
	/**
	 * 边框样式
	 * @var array
	 */
	public $borderStyle=array(
		'borders'=>array(
			'allborders'=>array(
				'style'=>PHPExcel_Style_Border::BORDER_THIN,
				'color'=>array(
					'argb'=>'FFAAAAAA'
				)
			)
		)
	);
	/**
	 * 首行字段样式
	 * @var array
	 */
	public $fieldStyle=array(
		'fill'=>array(
			'type'=>PHPExcel_Style_Fill::FILL_SOLID,
			'rotation'=>90,
			'startcolor'=>array(
				'argb'=>'FFEEEEEE'
			),
			'endcolor'=>array(
				'argb'=>'FFFFFFFF'
			)
		),
		'font'=>array(
			'size'=>9,
			'name'=>'微软雅黑',
			'bold'=>true,
		)
	);
	public $rowBackStyle=array(
			'type'=>PHPExcel_Style_Fill::FILL_SOLID,
			'rotation'=>90,
			'startcolor'=>array(
				'argb'=>'FFF7F7F7'
			),
			'endcolor'=>array(
				'argb'=>'FFFFFFFF'
			)
	);
	public $alignmentStyle=array(
		'alignment'=>array(
			'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
		)
	);
	public $fontStyle=array(
		'font'=>array(
			'size'=>9,
			'name'=>'微软雅黑'
		)
	);
	public $globalStyle=array(
		'font'=>array(
			'size'=>9,
			'name'=>'微软雅黑'
		),
		'alignment'=>array(
			'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
		)
	);
	/**
	 * 构造
	 */
	public function __construct(){
		//$this->fontColorObj=new PHPExcel_Style_Color();
		//$this->fieldBackgroundColorObj=new PHPExcel_Style_Color();
	}
	
}