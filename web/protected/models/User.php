<?php
/**
 * 功能：用户模型
 * 作者：武仝
 * 日期：2014-4-8 上午11:13:16
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class User extends ActiveRecord{
	/** 
	 * id
	 */
	public $id;
	/** 
	 * 登录名
	 */
	public $loginName;
	/** 
	 * 登录密码
	 */
	public $loginPassword;
	/** 
	 * 用户姓名
	 */
	public $userName;
	/** 
	 * 英文姓名
	 */
	public $englishName;
	/** 
	 * 登录次数
	 */
	public $loginCount;
	/** 
	 * 最后一次登录
	 */
	public $lastLogin;
	/** 
	 * 是否禁用
	 */
	public $disabled;
	/** 
	 * email
	 */
	public $email;
	
	/**
	 * 获取模型实例
	 * @return User
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	/**
	 * 表名
	 * @see CActiveRecord::tableName()
	 */
	public function tableName(){
		return 'mod_user';
	}
	/**
	 * 验证规则
	 * @see CModel::rules()
	 */
	public function rules(){
		return array(
			array(
				'loginName,loginPassword,userName,',
				'required'
			),
			array(
				'englishName,loginCount,lastLogin,disabled,email,nickName',
				'safe'
			),
			array(
				'loginName',
				'checkLoginName',
				'on'=>self::SCENES_ADD
			),
			array(
				'id',
				'numerical',
				'on'=>self::SCENES_EDIT
			)
		);
	}
	/**
	 * 检测用户名是否唯一
	 * @param string $loginName
	 */
	public function checkLoginName($loginName){
		$count=$this->count("loginName='{$this->loginName}'");
		if($count > 0){
			$label=$this->getAttributeLabel($loginName);
			$this->addError($loginName,"{$label} 已经存在");
		}
	}
	/**
	 * 属性标签
	 * @return multitype:string
	 */
	public function attributeLabels(){
		return array(
			'id'=>'id',
			'loginName'=>'登录名',
			'loginPassword'=>'登录密码',
			'userName'=>'用户姓名',
			'englishName'=>'英文姓名',
			'loginCount'=>'登录次数',
			'lastLogin'=>'最后一次登录',
			'disabled'=>'是否禁用',
			'email'=>'email'
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
	 * 获取具有指定项目的用户
	 * @param string $item
	 * @return Ambigous <multitype:, NULL>
	 */
	public static function getListByItem($item){
		$cacheName="user_".$item;
		$userList=Yii::app()->cache->get($cacheName);
		if($userList===false){
			$userList=self::getUserList();
			for($i=0; $i < count($userList); $i++){
				if(!Auth::has($item,$userList[$i]->id)){
					array_splice($userList,$i,1);
					$i-=1;
				}
			}
			Yii::app()->cache->set($cacheName,$userList);
		}
		return $userList;
	}
	/**
	 * 加密密码
	 * @param string $password
	 * @return string
	 */
	public static function encodePassword($password){
		return $password;
		//return md5(md5($password));
	}
	/**
	 * 获取用户列表
	 * @return array
	 */
	public static function getUserList(){
		$userList=null;
		if(!($userList=Yii::app()->cache->get("user_cache"))){
			//条件对象
			$criteria=new CDbCriteria();
			$criteria->order="LEFT(CONVERT(userName USING gbk),1)";
			//查询
			$userList=self::model(__CLASS__)->getRecord($criteria);
			if($userList == null){
				return null;
			}
			Yii::app()->cache->set("user_cache",$userList);
		}
		return $userList;
	}
	/**
	 * 获取用户信息
	 * @param int $userID
	 * @return User
	 */
	public static function getUserByID($userID){
		if(!is_numeric($userID)){
			return null;
		}
		$result=self::model()->findByPk($userID);
		return $result;
	}
	/**
	 * 修改密码
	 * @param string $srcPwd
	 * @param string $newPwd1
	 * @param string $newPwd2
	 * @return boolean
	 */
	public function updatePassword($srcPwd="",$newPwd1="",$newPwd2=""){
		if ($srcPwd=="" || $newPwd1=="" || $newPwd2=="") {
			$this->error=new WError("原密码、新密码1、新密码2 不能为空");
			return false;
		}
		if ($newPwd1!==$newPwd2) {
			$this->error=new WError("两次输入的新密码不一致");
			return false;
		}
		if ($srcPwd==$newPwd1) {
			$this->error=new WError("原密码不能跟新密码一样");
			return false;
		}
		$encodePwd=self::encodePassword($srcPwd);
		if ($this->loginPassword!==$encodePwd) {
			$this->error=new WError("原始密码不正确");
			return false;
		}
		$this->loginPassword=self::encodePassword($newPwd1);
		$this->isNewRecord=false;
		$this->setScenario(self::SCENES_EDIT);
		if($this->save()){
			return true;
		}else{
			$this->error=new WError("系统出现错误，修改失败");
			return false;
		}
	}
	/**
	 * 获取当前登录用户的ID
	 * @return int
	 */
	public static function getID(){
		return Yii::app()->user->getId();
	}
}