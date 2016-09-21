<?php
/**
 * 功能：退料单物资表
 * 作者：陈天宇
 * 日期：2016-5-3
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class ReturnFormMaterial extends ActiveRecord{

	public $id;//主键
	public $formID;//关联领用单ID
	public $batchCode;//批次号
	public $goodsCode;//物资编码
	public $goodsName;//物资描述
	public $factory;//厂家
	public $extendCode;//扩展编码
	public $number;//领用数量
	public $unit;//单位
	public $price;//单价
	public $receiveFormCode;//

	/**
	 * 获取模型实例
	 * @return Material
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	/**
	 * 表名
	 * @see CActiveRecord::tableName()
	 */
	public function tableName(){
		return 'mod_return_form_material';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'formID,goodsCode,goodsName,number',
				'required'
			),
			array(
				'batchCode,factory,extendCode,unit,price',
				'safe'
			)
		);
	}
	/**
	 * 属性标签
	 * @return multitype:string
	 */
	public function attributeLabels(){
		return array(
				'id'=>'主键',
				'formID'=>'关联领用单ID',
				'batchCode'=>'批次号',
				'goodsCode'=>'资产编号',
				'goodsName'=>'物资描述',
				'factory'=>'厂家',
				'extendCode'=>'扩展编码',
				'unit'=>'计量单位',
				'number'=>'领用数量',
				'price'=>'单价',
				'receiveFormCode'=>'关联领料单号',
		);
	}
		/**
	 * 是否存在指定ID
	 * @return bool
	 */
	public static function hasOne($id){
		return parent::hasOne($id,__CLASS__);
	}
	/**
	 * 获取列表
	 * @return array
	 */
	public static function getList(){
		return parent::getList(__CLASS__);
	}
	/**
	 * 获取名称
	 * @param int $id
	 * @return string
	 */
	public static function getName($id){
		return parent::getName($id,__CLASS__);
	}

}