<?php
/**
 * 功能：登录
 * 作者：武仝
 * 日期：2013-11-7 下午7:56:29
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 */
class LoginController extends CController{
	/**
	 * 登录
	 */
	public function actionIndex(){
		$this->setPageTitle("登录");
		$cookieList=Yii::app()->request->getCookies();
		if(Yii::app()->request->isAjaxRequest){
			try{
				//實例化用户验证
				$userIdent=new UserIdentity($_POST['loginName'],$_POST['loginPassword']);
				$userIdent->attachEventHandler("onLoginSuccess", function(UserIdentity $ui){
					if ($_POST['remember']=="yes") {
						//用户名cookie
						$lname=new CHttpCookie("lname", $_POST['loginName']);
						$lname->expire=time()+180*24*3600;
						Yii::app()->request->cookies['lname']=$lname;
						//密码cookie
						$lpassword=new CHttpCookie("lpassword", base64_encode($_POST['loginPassword']));
						$lpassword->expire=time()+180*24*3600;
						Yii::app()->request->cookies['lpassword']=$lpassword;
					}else{
						unset(Yii::app()->request->cookies['lname']);
						unset(Yii::app()->request->cookies['lpassword']);
					}
				});
				//如果验证通过
				if($userIdent->authenticate()){
					//保存用户登录信息
					Yii::app()->user->login($userIdent);
					WMessage::ajaxInfo("登录成功",1,array(
						"url"=>Auth::getURLByRole()
					));
				}else{
					$info=$userIdent->errorMessage;
					WMessage::ajaxInfo($info,0);
				}
			}catch(CDbException $e){
				//$info=iconv("gbk","utf-8",$e->getMessage());
				$info=$e->getMessage();
				WMessage::ajaxInfo("无法登录，请检查数据库连接：".$info,0);
			}catch (Exception $e){
				WMessage::ajaxInfo("无法登录：".$e->getMessage(),0);
			}
		}
		$this->renderPartial("login",array(
			"cookieList"=>$cookieList
		));
	}

	/**
	 * 退出登录
	 */
	public function actionOut(){
		Yii::app()->user->logout();
		$this->redirect($this->createUrl("login/"));
	}
}