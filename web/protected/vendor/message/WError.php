<?php
/**
 * 功能：错误消息
 * 作者：武仝
 * 日期：2014-2-17 下午7:56:02
 * 版权：Copyright 2007-2013 wutong All Right Reserved
 * 网址：http://www.wutong.biz
 */
/**
 * --------------------------------
 * 更新
 * 2014-03-12 修正实例化消息赋值错误的问题
 *
 */
class WError{
	/**
	 * 错误码
	 * @var number
	 */
	private $errorCode;
	/**
	 * 错误信息
	 * @var string
	 */
	private $errorMessage="";
	
	public function __construct($msg="",$code=0){
		$this->setError($msg, $code);
	}
	/**
	 * 设置错误码
	 * @param number $code
	 */
	public function setErrorCode($code){
		$this->errorCode=$code;
	}
	/**
	 * 获取错误码
	 * @return number
	 */
	public function getErrorCode(){
		return $this->errorCode;
	}
	
	/**
	 * 设置错误信息
	 * @param string $msg
	 */
	public function setErrorMessage($msg){
		$this->errorMessage=$msg;
	}
	/**
	 * 获取错误信息
	 * @return string
	 */
	public function getErrorMessage(){
		return $this->errorMessage;
	}
	/**
	 * 设置错误码和信息
	 * @param string $msg
	 * @param string $code
	 */
	public function setError($msg,$code){
		$this->setErrorCode($code);
		$this->setErrorMessage($msg);
	}
	/**
	 * 获取错误码和消息
	 * @return array
	 */
	public function getError(){
		return array(
			"code"=>$this->getErrorCode(),
			"message"=>$this->getErrorMessage()	
		);
	}
	/**
	 * 从Error对象设置错误信息
	 * @param WError $error
	 */
	public function setErrorByError(WError $error){
		$this->setError($error->getErrorCode(), $error->getErrorMessage());
	}
}
