<?php
/**
 * 用户认证类
 * 
 * 作者：武仝
 * 日期：2013-09-22 19:56
 * 版权：Copyright © 2013 无锡扬晟科技有限公司
 * 网站：http://www.iyoungsun.com
 * 个人：http://www.wutong.biz
 *
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * 用户被禁用
	 * @var int
	 */
	const ERROR_DISABLED=3;
	/**
	 * 用户ID
	 * @var int
	 */
	private $userID=null;
	
	public $user=null;
	/**
	 * 验证用户
	 * @return boolean 是否通过验证
	 */
	public function authenticate()
	{
		//实例化User模型
		$user=new User();
		//查找经过构造器传入的用户名的用户数据
		$userObj=$user->find("loginName='{$this->username}'");
		
		//检测合法性
		if ($userObj===null) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			$this->errorMessage="不存在此用户名";
		}else if ($userObj->loginPassword!==User::encodePassword($this->password)) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			$this->errorMessage="登录密码不正确";
		}else if ($userObj->disabled==="1") {
			$this->errorCode=self::ERROR_DISABLED;
			$this->errorMessage="此用户已经被系统禁用";
		}else{
			//存储会话其他数据
			$this->userID=$userObj->id;
			$this->setState("userName", $userObj->userName);
			//更新登录信息
			$userObj->isNewRecord=false;
			$userObj->lastLogin=date("Y-m-d H:i:s");
			$userObj->loginCount=new CDbExpression("loginCount+1");
			$userObj->save();
			$this->errorCode=self::ERROR_NONE;
			$this->user=$userObj;
			if ($this->hasEventHandler("onLoginSuccess")) {
				$this->onLoginSuccess($this);;
			}
		}
		return !$this->errorCode;
	}
	/**
	 * 返回用户ID
	 * @see CUserIdentity::getId()
	 */
	public function getId(){
		return $this->userID;
	}
	
	public function getName(){
		return $this->getState("userName");
	}
	/**
	 * 登录成功事件
	 * @param UserIdentity $event
	 */
	public function onLoginSuccess($event){
		$this->raiseEvent("onLoginSuccess", $event);
	}
}