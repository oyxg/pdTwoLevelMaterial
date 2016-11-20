<?php
//仪器仪表信息表
class InstrumentInfo extends ActiveRecord{

	public $id;
	public $className;//分类
	public $name;
	public $num;//配置数量
	public $price;
	public $unit;
	public $standard;//规格型号
	public $jsgf;//技术规范
	public $isBp;
	public $isZc;
	public $mbh;//物资编号
	public $cbh;//公司编号

//	private $_pk = 'id';

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
		return 'mod_instrument_info';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'className,name,num,price,isBp,isZc',
				'required'
			),
			array(
				'unit,standard,jsgf,mbh,cbh',
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
				'className'=>'物资分类',
				'name'=>'物资名称',
				'num'=>'配置数量',
				'price'=>'单价',
				'unit'=>'单位',
				'standard'=>'规格型号',
				'jsgf'=>'技术规范',
				'isBp'=>'标配/选配',
				'isZc'=>'是否资产',
				'mbh'=>'物资编号',
				'cbh'=>'公司编号',
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

	const YES="y";
	const NO="n";
	/**
	 * @return array
	 */
	public static function getTypeList(){
		return array(
				self::YES=> '<span style="font-weight: bold">是</span>',
				self::NO=> '<span style="font-weight: bold">否</span>'
		);
	}
	/**
	 * 获取状态
	 * @param string $key
	 * @return string
	 */
	public static function getState($key){
		$list=self::getTypeList();
		return $list[$key];
	}
}