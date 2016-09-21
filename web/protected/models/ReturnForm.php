<?php

/**
 * 功能：物资退料单
 * 作者：陈天宇
 * 日期：2016-5-3
 * 版权：Copyright 2007-2016 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class ReturnForm extends ActiveRecord{

	public $id;//主键
	public $storeID;//仓库ID
	public $userID;//用户ID
	public $formCode;//表单编号
	public $nature;//性质：qx:抢修；dx:大修
	public $outTime;//发料时间
	public $glPro;//关联工程
	public $glProCode;//关联工程编号
	public $batchCode;//批次号
	public $remark;//备注
	public $pic;//附件
	public $state;//状态：sh:审核;zf:作废;tg:通过;
	public $opinion;//作废原因
	public $date;//退料单生成时间
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
		return 'mod_return_form';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'userID,storeID,formCode,nature,state,date',
				'required'
			),
			array(
				'outTime,glPro,glProCode,batchCode,remark,pic,opinion',
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
				'userID'=>'用户ID',
				'formCode'=>'表单编号',
				'nature'=>'性质',
				'outTime'=>'发料时间',
				'glPro'=>'关联项目',
				'glProCode'=>'关联项目编号',
				'batchCode'=>'批次号',
				'remark'=>'备注',
				'pic'=>'附件',
				'state'=>'状态',
				'opinion'=>'作废原因',
				'date'=>'退料单日期'
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
	 * 统计出当月批次数量
	 * @param string $position
	 */
	public function countBatchCode($key){
		$count = self::model()->count("batchCode Like '{$key}%'");
		return $count;
	}
	//状态：sh:审核;zf:作废;tg:通过;
	/**
	 * 领用单状态：审批
	 */
	const STATE_SH="sh";
	/**
	 * 领用单状态：作废
	 */
	const STATE_ZF="zf";
	/**
	 * 领用单状态：通过
	 */
	const STATE_TG="tg";
	/**
	 * @return array
	 */
	public static function getTypeList(){
		return array(
				self::STATE_SH=> '<span style="color: #0008e3">审批</span>',
				self::STATE_ZF=> '<span style="color: #e30400">作废</span>',
				self::STATE_TG=> '<span style="color: #00ff00">通过</span>'
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