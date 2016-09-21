<?php
/**
 * 功能：物资领用记录表
 * 作者：陈天宇
 * 日期：2016-5-3
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class ReceiveFormMaterial extends ActiveRecord{

	public $id;//主键
	public $formID;//关联领用单ID
	public $materialID;//物资ID
	public $batchCode;//批次号
	public $goodsCode;//物资编号
	public $goodsName;//物资描述
	public $factory;//厂家
	public $extendCode;//扩展编码
	public $number;//请领数
	public $sfnumber;//实发数
	public $applyNum;//退料时可申请数
	public $unit;//单位
	public $price;//单价
	public $remark;//备注

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
		return 'mod_receive_form_material';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'formID,goodsCode,goodsName,number,materialID',
				'required'
			),
			array(
				'batchCode,factory,extendCode,unit,price,remark',
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
				'materialID'=>'物资ID',
				'batchCode'=>'批次号',
				'goodsCode'=>'资产编号',
				'goodsName'=>'物资描述',
				'factory'=>'厂家',
				'extendCode'=>'扩展编码',
				'unit'=>'计量单位',
				'number'=>'请领数',
				'sfnumber'=>'实发数',
				'applyNum'=>'退料时可申请数',
				'price'=>'单价',
				'remark'=>'备注',
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