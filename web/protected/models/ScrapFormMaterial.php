<?php
//物资入库记录表
class ScrapFormMaterial extends ActiveRecord{
	/** 
	 * 主键
	 */
	public $id;
	/**
	 * 关联保费表ID
	 */
	public $formID;
	/**
	 * 物资编号
	 */
	public $goodsCode;
	/**
	 * 物资描述
	 */
	public $goodsName;
	/**
	 * 规格型号
	 */
	public $standard;
	/**
	 * 计量单位
	 */
	public $unit;
	/**
	 * 设计折旧数量
	 */
	public $designNum;
	/**
	 * 实退数量
	 */
	public $number;
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
		return 'mod_scrap_form_material';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'formID,goodsCode,goodsName,number',
				'required'
			),
			array(
				'standard,unit,designNum,remark',
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
				'formID'=>'关联报废表ID',
				'goodsCode'=>'资产编号',
				'goodsName'=>'物资描述',
				'standard'=>'规格型号',
				'unit'=>'计量单位',
				'designNum'=>'设计折旧数量',
				'number'=>'实退数量',
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
	/**************************************************分割线**************************/
	/**
	 * 检查货架编码在同一个仓库是否重复
	 * @param string $position
	 */
	public function checkPosition($position){
		if (Material::model()->count("storeID=".$this->storeID." AND position='{$this->position}'")) {
			$this->addError($position,"同样的货架编码已经存在");
		}
	}
}