<?php
/**
 * 功能：临时物资
 * 作者：陈天宇
 * 日期：2016-4-5
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class WTempMaterial{
	
	/**
	 * 物资ID
	 */
	public $materialID;
	/**
	 * 数量
	 */
	public $number=0;
	/**
	 * @var Material
	 */
	public $material=null;
	
	/**
	 * 构造
	 * @param int $materialID
	 * @param int $number
	 */
	function __construct($materialID,$number){
		$this->materialID=$materialID;
		$this->number=$number;
	}
	/**
	 * 更新
	 */
	public function  update(){
		$this->material=Material::model()->findByPk($this->materialID);
	}
	/**
	 * 验证
	 * @throws Exception
	 */
	public function validate(){
		$this->update();
		if ($this->material->currCount < $this->number) {
			throw new Exception("申请数量超出库存数");
		}
	}
}