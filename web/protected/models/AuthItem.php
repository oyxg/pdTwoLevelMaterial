<?php
class AuthItem extends ActiveRecord{
	/** 
	 * 项目名称
	 */
	public $name;
	/** 
	 * 项目类型-角色,任务,操作
	 */
	public $type;
	/** 
	 * 描述
	 */
	public $description;
	/** 
	 * 业务规则
	 */
	public $bizrule;
	/** 
	 * 附加数据
	 */
	public $data;
	
	/**
	 * 获取模型实例
	 * @return AuthItem
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	/**
	 * 表名
	 * @see CActiveRecord::tableName()
	 */
	public function tableName(){
		return 'auth_item';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'name,type,description',
				'required'
			),
			array(
				'bizrule,data,',
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
			'name'=>'项目名称',
			'type'=>'项目类型-角色,任务,操作',
			'description'=>'描述',
			'bizrule'=>'业务规则',
			'data'=>'附加数据'
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
	* 项目类型 - 角色
	*/
	const TYPE_ROLES="2";
	/**
	* 项目类型 - 任务
	*/
	const TYPE_TASKS="1";
	/**
	* 项目类型 - 操作
	*/
	const TYPE_OPERATIONS="0";
	/**
	* 获取项目类型列表
	* @return array
	*/
	public static function getTypeList(){
		return array(
			self::TYPE_ROLES=>"角色",
			self::TYPE_TASKS=>"任务",
			self::TYPE_OPERATIONS=>"操作"
		);
	}
	/**
	* 获取项目类型名称
	* @param string $key
	* @return string
	*/
	public static function getTypeName($key){
		$list=self::getTypeList();
		return $list[$key];
	}
	/**
	* 检测项目类型键值是否存在
	* @param string $key
	* @return bool
	*/
	public static function hasTypeOne($key){
		$list=self::getTypeList();
		return array_key_exists($key,$list);
	}
}