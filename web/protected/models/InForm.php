<?php
class InForm extends ActiveRecord{

	public $id;//主键
	public $storeID;//仓库ID
	public $informCode;//入库单号
	public $date;
	public $contact;//联系人
	public $tel;//联系人电话
	public $remark;//联系人电话
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
		return 'mod_in_form';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'informCode,date',
				'required'
			),
			array(
				'glProCode,glPro,contact,tel,remark',
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
				'informCode'=>'入库单号',
				'date'=>'入库日期',
				'glProCode'=>'关联大修项目编号',
				'glPro'=>'关联大修项目',
				'contact'=>'联系人',
				'tel'=>'联系人电话',
				'remark'=>'备注',
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
	 * 统计出当月入库单数量
	 * @param string $position
	 */
	public function countFormCode($key){
		$count = InForm::model()->count("informCode Like '{$key}%'");
		return $count;
	}
	/**
	 * 统计出当月批次数量
	 * @param string $position
	 */
	public function countBatchCode($key){
		$count = InForm::model()->count("batchCode Like '{$key}%'");
		return $count;
	}
}