<?php
//仪器仪表表入库
class Instrument extends ActiveRecord{

	public $id;
	public $class;//资产分类
	public $projectCode;//项目编号
	public $projectName;//项目名称
	public $card;//资产卡片
	public $SAP;//SAP编号
	public $equCode;//设备编号
	public $materialCode;//物资编码
	public $materialName;//物资名称
	public $storeAddress;//存放地址
	public $standard;//型号
	public $factory;//厂家
	public $factoryCode;//出厂编号
	public $factoryDate;//出厂日期
	public $unit;//单位
	public $num;//数量
	public $price;//单价
	public $distribution;//配送单位
	public $contact;//联系人
	public $tel;//联系电话
	public $file;//附件
	public $state;//状态

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
		return 'mod_instrument';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'materialCode,materialName,storeAddress,state',
				'required'
			),
			array(
				'class,projectCode,projectName,card,SAP,equCode,standard,factory,factoryCode,factoryDate,unit,num,price,distribution,contact,tel,file',
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
				'class'=>'资产分类',
				'projectCode'=>'项目编号',
				'projectName'=>'项目名称',
				'card'=>'资产卡片',
				'SAP'=>'SAP编号',
				'equCode'=>'设备编号',
				'materialCode'=>'物资编码',
				'materialName'=>'物资名称',
				'storeAddress'=>'存放地址',
				'standard'=>'型号',
				'factory'=>'厂家',
				'factoryCode'=>'出厂编号',
				'factoryDate'=>'出厂日期',
				'unit'=>'单位',
				'num'=>'数量',
				'price'=>'单价',
				'distribution'=>'配送单位',
				'contact'=>'联系人',
				'tel'=>'联系电话',
				'file'=>'附件',
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

}