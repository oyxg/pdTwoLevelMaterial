<?php
class ScrapForm extends ActiveRecord{
	/** 
	 * 主键
	 */
	public $id;
	/**
	 * 仓库ID
	 */
	public $storeID;
	/**
	 * 表单编号
	 */
	public $formCode;
	/**
	 * 班组ID,记录谁提交的
	 */
	public $bID;
	/**
	 * 专职ID,记录交给哪个专职处理
	 */
	public $zID;
	/**
	 * 工程编号
	 */
	public $projectCode;
	/**
	 * 工程名称
	 */
	public $projectName;
	/**
	 * 技术鉴定意见
	 */
	public $opinion;
	/**
	 * 提交日期
	 */
	public $date;
	/**
	 * 状态：0：审批；1：退回；2:通过；
	 */
	public $state;
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
		return 'mod_scrap_form';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'storeID,formCode,bID,zID,projectCode,projectName,date,state',
				'required'
			),
			array(
				'opinion',
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
				'formCode'=>'表单编号',
				'bID'=>'班组ID',
				'zID'=>'专职ID',
				'projectCode'=>'项目编号',
				'projectName'=>'项目名称',
				'opinion'=>'技术鉴定意见',
				'date'=>'提交日期',
				'state'=>'状态'
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
		$count = self::model()->count("formCode Like '{$key}%'");
		return $count;
	}
	/**
	 * 报废表状态：审批
	 */
	const STATE_S="0";
	/**
	 * 报废表状态：退回
	 */
	const STATE_T="1";
	/**
	 * 报废表状态：通过
	 */
	const STATE_G="2";
	/**
	 * @return array
	 */
	public static function getTypeList(){
		return array(
				self::STATE_S=> '<span style="color: #0008e3">审批</span>',
				self::STATE_T=> '<span style="color: #e30400">退回</span>',
				self::STATE_G=> '<span style="color: #00ff00">通过</span>'
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