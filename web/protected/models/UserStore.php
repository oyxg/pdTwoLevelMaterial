<?php
class UserStore extends ActiveRecord{
	/** 
	 * 用户ID
	 */
	public $userID;
	/** 
	 * 仓库ID
	 */
	public $storeID;
	
	/**
	 * 获取模型实例
	 * @return UserStore
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
        
	/**
	 * 表名
	 * @see CActiveRecord::tableName()
	 */
	public function tableName(){
		return 'mod_user_store';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'userID,storeID,',
				'required'
			),
			array(
				'userID',
				'checkExists',
				"on"=>self::SCENES_ADD
			),
			array(
				'id',
				'numerical',
				'on'=>self::SCENES_EDIT
			)
		);
	}
	/**
	 * 检测是否同名
	 * @param int $userID
	 */
	public function checkExists($userID){
		$criteria=new CDbCriteria();
		$criteria->condition="userID='{$this->userID}' AND storeID={$this->storeID}";
		if($this->count($criteria)>0){
			$this->addError($userID,"相同的数据已经存在");
		}
	}
	/**
	 * 属性标签
	 * @return multitype:string
	 */
	public function attributeLabels(){
		return array(
			'userID'=>'用户ID',
			'storeID'=>'仓库ID'
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
	 * 绑定
	 * @param int $storeID
	 * @param int $userID
	 * @return boolean
	 */
	public function bind($storeID,$userID){
		$this->storeID=$storeID;
		$this->userID=$userID;
		if ($this->add()) {
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 根据人员获取仓库
	 * @param int $userID 人员
	 * @return Store | null
	 */
	public static function getStoreByUserID($userID=null){
		if ($userID==null) {
			$userID=Yii::app()->user->getId();
		}
		$userStore=self::model()->find("userID=".$userID);
		if(!$userStore){
			return null;	
		}
		$store=Store::model()->findByPk($userStore->storeID);
		if (!$store) {
			return null;
		}
		return $userStore;
	}
	
	/**
	 * 根据仓库获取人员列表
	 * @param int $storeID
	 * @return array | null
	 */
	public static function getUserListByStoreID($storeID){
		$command=Yii::app()->db->createCommand();
		$sql="SELECT * FROM mod_store s INNER JOIN mod_user_store us ON us.storeID=s.storeID WHERE s.storeID=".$storeID;
		$command->setText($sql);
		return $command->queryAll();
	}
}