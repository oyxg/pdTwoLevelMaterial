<?php
//物资表
class Material extends ActiveRecord{

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
	public $accessory;//附件
	public $minCount;
	public $currCount;
	public $applyNum;
	public $del;
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
		return 'mod_material';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'storeID,goodsCode,currCount',
				'required'
			),
			array(
				'batchCode,goodsName,factory,standard,unit,applyNum,price,minCount,validityDate,remark,accessory,del
				factory,factory_contact,factory_tel,erpLL,erpCK,workCode',
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
				'materialID'=>'主键',
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
				'accessory'=>'附件',
				'minCount'=>'最低库存',
				'currCount'=>'当前库存',
				'applyNum'=>'可申请数',
				'del'=>'是否删除',
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
	/**
	 * 统计出当月批次数量
	 * @param string $position
	 */
	public function countBatchCode($key){
		$count = self::model()->count("batchCode Like '{$key}%'");
		return $count;
	}
}