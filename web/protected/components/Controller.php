<?php
/**
 * 功能：项目控制器
 * 作者：武仝
 * 日期：2013-12-3 下午9:45:28
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 公司：扬晟科技（http://www.iyoungsun.com）
 */
class Controller extends CController{
	/**
	 * 默认布局
	 */
	public $layout="//layouts/main";
	/**
	 * 面包屑
	 */
	public $breadcrumbs=array();
	/**
	 * 控制器名称
	 */
	public $controllerName="";
	/**
	 * 分页
	 * @var CPagination
	 */
	public $pagination=null;
	
	public function init(){
		if (Yii::app()->user->isGuest) {
			header("Location:/login.html");
			exit();
		}
		$this->setBread("");
	}
	
	/**
	 * 设置面包屑
	 * @param string $name
	 */
	public function setBread($name){
		$this->breadcrumbs=array(
			$this->controllerName,
			$name
		);
	}
	/**
	 * 不使用布局
	 */
	public function setLayoutNone(){
		$this->layout="//layouts/layout_none";
	}
	
}