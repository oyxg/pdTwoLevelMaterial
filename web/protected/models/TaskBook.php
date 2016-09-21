<?php
class TaskBook extends ActiveRecord{
	/** 
	 * 主键
	 */
	public $id;
	public $bookCode;//任务书编号
	public $date;//施工日期
	public $zrdw;//责任单位
	public $zrbz;//责任班组
	public $phdw;//配合单位
	public $line;//线路及设备名称
	public $content;//内容
	public $state;//状态：通过，退回，审核，编辑
	public $uID;//用户ID
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
		return 'mod_task_book';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'bookCode,state,uID',
				'required'
			),
			array(
				'date,zrdw,zrbz,phdw,line,content',
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
				'bookCode'=>'任务书编号',
				'zrdw'=>'责任单位',
				'zrbz'=>'责任班组',
				'phdw'=>'配合单位',
				'line'=>'线路及设备名称',
				'content'=>'内容',
				'date'=>'施工日期',
				'state'=>'状态',
				'uID'=>'用户ID'
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
	public function countBookCode($key){
		$count = self::model()->count("bookCode Like '{$key}%'");
		return $count;
	}

	//状态：通过，退回，审核，编辑
	const STATE_B="edit";//编辑
	const STATE_S="examine";//审核
	const STATE_T="back";//退回
	const STATE_G="adopt";//通过
	/**
	 * @return array
	 */
	public static function getTypeList(){
		return array(
				self::STATE_B=> '<span style="color: #333333">编辑</span>',
				self::STATE_S=> '<span style="color: #0008e3">审批</span>',
				self::STATE_T=> '<span style="color: #e30400">作废</span>',
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