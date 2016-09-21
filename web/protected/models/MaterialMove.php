<?php
//物资移库记录表
class MaterialMove extends ActiveRecord{

	public $materialID;
	public $storeID;//目标库
	public $moveformID;
	public $goodsCode;
	public $batchCode;//批次号
	public $extendCode;
	public $goodsName;
	public $factory;//厂家
	public $standard;
	public $unit;
	public $price;
	public $number;
	public $minCount;
	public $validityDate;
	public $remark;
	public $comeStoreID;//来源库
	public $comeMaterialID;//来源物资
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
		return 'mod_material_move';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'materialID,storeID,moveformID,goodsCode,batchCode,number',
				'required'
			),
			array(
				'goodsName,factory,extendCode,standard,unit,price,minCount,validityDate,remark,
				workCode,factory_contact,factory_tel,erpLL,erpCK',
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
				'materialID'=>'物资ID',
				'storeID'=>'仓库ID',
				'comeStoreID'=>'来源仓库ID',
				'comeMaterialID'=>'来源物资ID',
				'moveformID'=>'入库单ID',
				'goodsCode'=>'物资编码',
				'batchCode'=>'批次号',
				'extendCode'=>'扩展编码',
				'goodsName'=>'物资描述',
				'factory'=>'厂家',
				'standard'=>'规格',
				'unit'=>'单位',
				'number'=>'移库数量',
				'price'=>'单价',
				'minCount'=>'最低库存',
				'validityDate'=>'有效期',
				'remark'=>'备注',
				'workCode'=>'工单号',
				'factory_contact'=>'厂家联系人',
				'factory_tel'=>'厂家联系电话',
				'erpLL'=>'ERP领料单',
				'erpCK'=>'ERP出库单'
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