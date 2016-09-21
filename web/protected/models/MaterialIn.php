<?php
//物资入库记录表
class MaterialIn extends ActiveRecord{

	public $materialID;
	public $storeID;
	public $batchCode;//批次号
	public $goodsCode;
	public $extendCode;
	public $goodsName;
	public $workCode;//工单号
	public $erpLL;//领料单
	public $erpCK;//出库单
	public $factory;//厂家
	public $factory_contact;//厂家联系人
	public $factory_tel;//厂家联系电话
	public $standard;
	public $unit;
	public $price;
	public $validityDate;
	public $remark;
	public $minCount;
	public $currCount;
	public $informID;
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
		return 'mod_material_in';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'storeID,informID,goodsCode,currCount',
				'required'
			),
			array(
				'goodsName,standard,unit,price,minCount,validityDate,remark',
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
				'materialID'=>'物资ID',
				'storeID'=>'仓库ID',
				'batchCode'=>'批次号',
				'goodsCode'=>'物资编码',
				'extendCode'=>'扩展编码',
				'goodsName'=>'物资描述',
				'workCode'=>'工单号',
				'erpLL'=>'领料单',
				'erpCK'=>'出库单',
				'factory'=>'厂家',
				'factory_contact'=>'厂家联系人',
				'factory_tel'=>'厂家联系电话',
				'standard'=>'规格',
				'unit'=>'单位',
				'price'=>'单价',
				'validityDate'=>'有效期',
				'remark'=>'备注',
				'minCount'=>'最低库存',
				'currCount'=>'当前库存',
				'informID'=>'入库单ID',
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