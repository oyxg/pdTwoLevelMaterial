<?php
//任务书物资表
class TaskBookMaterial extends ActiveRecord{
	/** 
	 * 主键
	 */
	public $id;
	public $bookCode;
	public $goodsName;
	public $standard;
	public $unit;
	public $price;//单价

	public $number;//申请数
	public $materialID;//物资ID
	public $batchCode;//批次号
	public $goodsCode;//物资编号
	public $sfnumber;//实发数
	public $applyNum;//可退回数（若要）

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
		return 'mod_task_book_material';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'bookCode,goodsName,number,materialID,batchCode,goodsCode',
				'required'
			),
			array(
				'standard,unit,price',
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
				'bookCode'=>'关联任务书',
				'goodsName'=>'物资名称',
				'standard'=>'规格型号',
				'unit'=>'单位',
				'price'=>'单价',
				'number'=>'数量',
				'materialID'=>'物资ID',
				'batchCode'=>'批次号',
				'goodsCode'=>'物资编号',
				'sfnumber'=>'实发数',
				'applyNum'=>'可退回数'
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