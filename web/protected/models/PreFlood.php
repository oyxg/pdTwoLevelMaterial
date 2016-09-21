<?php
//防汛物资表
class PreFlood extends ActiveRecord{

	public $id;
	public $name;
	public $configure;//标准配置
	public $price;
	public $unit;
	public $jsgf;//技术规范
	public $remark;
	public $pzlevel;//配置级别
	public $className;//分类名称
	public $a_xc;//一班现存
	public $b_xc;//二班现存
	public $c_xc;
	public $d_xc;
	public $e_xc;
	public $f_xc;
	public $a_xq;//一班需求
	public $b_xq;
	public $c_xq;
	public $d_xq;
	public $e_xq;
	public $f_xq;
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
		return 'mod_preflood';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'name,className',
				'required'
			),
			array(
				'unit,jsgf,configure,price,remark,pzlevel,
				a_xc,b_xc,c_xc,d_xc,e_xc,f_xc,
				a_xq,b_xq,c_xq,d_xq,e_xq,f_xq',
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
				'name'=>'物资名称',
				'configure'=>'标准配置',
				'price'=>'单价',
				'unit'=>'单位',
				'jsgf'=>'技术规范',
				'remark'=>'备注',
				'pzlevel'=>'配置级别',
				'className'=>'分类名称',
				'a_xc'=>'一班现存',
				'b_xc'=>'二班现存',
				'c_xc'=>'三班现存',
				'd_xc'=>'四班现存',
				'e_xc'=>'五班现存',
				'f_xc'=>'六班现存',
				'a_xq'=>'一班需求',
				'b_xq'=>'二班需求',
				'c_xq'=>'三班需求',
				'd_xq'=>'四班需求',
				'e_xq'=>'五班需求',
				'f_xq'=>'六班需求'
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