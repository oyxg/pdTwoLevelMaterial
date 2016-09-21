<?php
/**
 * 功能：错误
 * 作者：武仝
 * 日期：2014-3-21 下午1:28:17
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class ErrorController extends Controller{
	
	public $layout="//layouts/no_head_foot";
	/**
	 * 没有权限
	 */
	public function actionNoPermission(){
		$this->render("no_permission");
	}
	
	public function actionError(){
		$error=Yii::app()->errorHandler->error;
		$this->setPageTitle($error['message']." - ".$error['code']);
		$this->render("error",$error);
	}
}
