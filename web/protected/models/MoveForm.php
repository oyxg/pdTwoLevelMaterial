<?php
class MoveForm extends ActiveRecord{
	/** 
	 * 主键
	 */
	public $id;
	/**
	 * 仓库ID
	 */
	public $storeID;
	/**
	 * 批次编号
	 */
	public $moveFormCode;
	/**
	 * 批次编号
	 */
	public $batchCode;
	/**
	 * 移库时间
	 */
	public $date;
	/**
	 * 备注
	 */
	public $remark;
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
		return 'mod_move_form';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'storeID,date,moveFormCode',
				'required'
			),
			array(
				'batchCode,remark',
				'safe'
			),
		);
	}
	/**
	 * 属性标签
	 * @return multitype:string
	 */
	public function attributeLabels(){
		return array(
				'id'=>'主键',
				'storeID'=>'仓库ID',
				'moveFormCode'=>'移库单号',
				'batchCode'=>'批次号',
				'date'=>'移库日期',
				'remark'=>'备注'
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
	 * 统计出当月入库单数量
	 * @param string $position
	 */
	public function countFormCode($key){
		$count = MoveForm::model()->count("moveformCode Like '{$key}%'");
		return $count;
	}
	/**
	 * 统计出当月批次数量
	 * @param string $position
	 */
	public function countBatchCode($key){
		$count = MoveForm::model()->count("batchCode Like '{$key}%'");
		return $count;
	}
}