<?php
/**
 * 功能：临时物资
 * 作者：陈天宇
 * 日期：2016-4-5
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class WTempUseMaterial{
	
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
	function __construct($materialID,$number,$formCode){
		$this->materialID=$materialID;
		$this->number=$number;
		$this->formCode = $formCode;
	}
	/**
	 * 更新
	 */
	public function  update(){
		$this->material=Material::model()->findByPk($this->materialID);
	}
	/**
	 * 验证领料
	 * @throws Exception
	 */
	public function validate(){
		$this->update();
		if ($this->material->applyNum < $this->number) {
			throw new Exception("数量过多，请减少数量");
		}
	}
	/**
	 * 更新
	 */
	public function  update2(){
		$formID = ReceiveForm::model()->find("formCode='{$this->formCode}'")->id;
		$this->material=ReceiveFormMaterial::model()->find("materialID='{$this->materialID}' AND formID='{$formID}'");
//		throw new Exception($this->materialID);
	}
	/**
	 * 验证2退料
	 * @throws Exception
	 */
	public function validate2(){
		$this->update2();
		if ($this->material->applyNum < $this->number) {
			throw new Exception("数量过多，请减少数量");
		}
	}
}