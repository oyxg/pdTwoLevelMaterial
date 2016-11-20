<?php
//防汛物资表入库
class PreFloodIn extends ActiveRecord{

	public $id;
	public $mID;//防汛物资ID
	public $bzID;//班组
	public $num;//领用数量
	public $projectCode;//项目编号
	public $projectName;//项目名称
	public $workCode;//工单号
	public $erpLL;//ERP领料单
	public $file;//附件
	public $state;//状态
	public $date;//状态

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
		return 'mod_preflood_in';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'mID,bzID,num,date',
				'required'
			),
			array(
				'projectCode,projectName,workCode,erpLL,file,state',
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
				'mID'=>'防汛物资ID',
				'bzID'=>'班组',
				'num'=>'领用数量',
				'projectCode'=>'项目编号',
				'projectName'=>'项目名称',
				'workCode'=>'工单号',
				'erpLL'=>'ERP领料单',
				'file'=>'附件',
				'state'=>'状态',
				'date'=>'入库日期'
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
	 * 状态：正常
	 */
	const STATE_NORMAL="zc";
	/**
	 * 状态：送修
	 */
	const STATE_SEND="send";
	/**
	 * 状态：报废
	 */
	const STATE_SCRAP="scrap";
	/**
	 * @return array
	 */
	public static function getTypeList(){
		return array(
				self::STATE_NORMAL=> '<span style="color: #00aa00">正常</span>',
				self::STATE_SEND=> '<span style="color: #000099">送修</span>',
				self::STATE_SCRAP=> '<span style="color: #999999">报废</span>'
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


	/**
	 * @return array
	 */
	public static function getBzList(){
		return array(
				'工区','一班','二班','三班','四班','五班','六班'
		);
	}
	/**
	 * 获取班组
	 * @param string $key
	 * @return string
	 */
	public static function getBz($key){
		$list=self::getBzList();
		return $list[$key];
	}
}