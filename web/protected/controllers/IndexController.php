<?php
/**
 * 功能：欢迎页面
 * 作者：武仝
 * 日期：2014-02-27 
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved.
 * 网址：http://www.iyoungsun.com
 */
class IndexController extends Controller{
	/**
	 * 首页
	 */
	public function actionIndex(){
		
		if (Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->createUrl("login"));
			exit();
		}
		$this->redirect(Auth::getURLByRole());
		//$this->render("index");
	}
}