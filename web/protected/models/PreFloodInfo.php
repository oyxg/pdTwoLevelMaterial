<?php
//防汛物资信息表
class PreFloodInfo extends ActiveRecord{

	public $id;
	public $className;//分类名称
	public $name;
	public $price;
	public $unit;
	public $standard;//规格型号
	public $jsgf;//技术规范
	public $pzlevel;//配置级别
	public $configure;//配置标准
	public $factory;//厂家
	public $bh;//出厂编号
	public $contact;//联系人
	public $tel;//联系方式
	public $remark;//备注

//	private $_pk = 'id';

	public static function getType(){
		$types = array(
				'个人防护用品',
				'排水物资',
				'挡水物资',
				'照明工具',
				'辅助配套物资'
		);
		return $types;
	}
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
		return 'mod_preflood_info';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'className,name',
				'required'
			),
			array(
				'price,unit,standard,jsgf,pzlevel,configure,factory,bh,contact,tel,remark',
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
				'className'=>'分类名称',
				'name'=>'物资名称',
				'price'=>'单价',
				'unit'=>'单位',
				'standard'=>'规格型号',
				'jsgf'=>'技术规范',
				'pzlevel'=>'配置级别',
				'configure'=>'配置标准',
				'factory'=>'厂家',
				'bh'=>'出厂编号',
				'contact'=>'联系方式',
				'tel'=>'联系人',
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

}