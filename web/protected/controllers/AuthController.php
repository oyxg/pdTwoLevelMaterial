<?php
class AuthController extends Controller{
	public $controllerName="权限";
	/**
	 * 列表
	 */
	public function actionItemList(){
		$this->setBread("列表");
		//查询参数
		$condition[]="1=1";
		$condition[]=$_GET['name'] == "" ? "" : "AND INSTR(name,'{$_GET['name']}')>0";
		$condition[]=$_GET['type'] == "" ? "" : "AND type='{$_GET['type']}'";
		//模型实例化
		$ai=new AuthItem();
		//条件
		$criteria=new CDbCriteria();
		$criteria->order="CONVERT(LEFT(name,1) USING gbk)  asc";
		$criteria->condition=implode(" ",$condition);
		//分页
		$this->pagination=new CPagination();
		$this->pagination->pageSize=20;
		//查找数据
		$rsList=$ai->getRecord($criteria,$this->pagination);
		//渲染视图
		$this->render("auth_item_list",array(
			"rsList"=>$rsList
		));
	}
	/**
	 * 添加授权项目
	 */
	public function actionItemAdd(){
		if(Yii::app()->request->isAjaxRequest){
			$ai=new AuthItem();
			$ai->attributes=$_POST;
			if(!$ai->validate()){
				WMessage::ajaxInfo($ai->error->getErrorMessage(),0);
			}
			$am=Auth::getAuthManager();
			try{
				$authItem=$am->createAuthItem($ai->name,$ai->type,$ai->description,$ai->bizrule,$ai->data);
				if($_POST['other'] == "yes"){
					$listItem=$am->createAuthItem($ai->name . "List",AuthItem::TYPE_OPERATIONS,$ai->description . "（列表）");
					if($_POST['bindTask'] == "1"){
						$authItem->addChild($listItem->name);
					}
					$addItem=$am->createAuthItem($ai->name . "Add",AuthItem::TYPE_OPERATIONS,$ai->description . "（添加）");
					if($_POST['bindTask'] == "1"){
						$authItem->addChild($addItem->name);
					}
					$deleteItem=$am->createAuthItem($ai->name . "Delete",AuthItem::TYPE_OPERATIONS,$ai->description . "（刪除）");
					if($_POST['bindTask'] == "1"){
						$authItem->addChild($deleteItem->name);
					}
					$editItem=$am->createAuthItem($ai->name . "Edit",AuthItem::TYPE_OPERATIONS,$ai->description . "（修改）");
					if($_POST['bindTask'] == "1"){
						$authItem->addChild($editItem->name);
					}
				}
			}catch(Exception $e){
				$mess=$e->getCode() == 23000 ? "已经存在" : $e->getMessage();
				WMessage::ajaxInfo($mess,0);
			}
			if($authItem instanceof CAuthItem){
				WCache::clearAll();
				WMessage::ajaxInfo();
			}else{
				WMessage::ajaxInfo("未知错误");
			}
		}
		$this->setLayoutNone();
		$this->render("auth_item_form");
	}
	/**
	 * 编辑项
	 * @throws Exception
	 */
	public function actionItemEdit(){
		if(Yii::app()->request->isAjaxRequest){
			//授权管理器
			$am=Auth::getAuthManager();
			//获得项
			$item=$am->getAuthItem($_POST['oldName']);
			try{
				if(!($item instanceof CAuthItem)){
					throw new Exception("非法的項目");
				}
				if($_POST['oldName'] != $_POST['name']){
					$item->setName($_POST['name']);
				}
				$item->setDescription($_POST['description']);
				$item->setBizRule($_POST['bizrule']);
				$item->setData($_POST['data']);
			}catch(Exception $e){
				$mess=$e->getMessage();
				WMessage::ajaxInfo($mess,0);
			}
			WCache::clearAll();
			WMessage::ajaxInfo();
		}
		//授权管理器
		$am=Auth::getAuthManager();
		//获得项
		$item=$am->getAuthItem(urldecode($_GET['item']));
		
		$this->setLayoutNone();
		$this->render("auth_item_form",array(
			"auth_item"=>$item
		));
	}
	/**
	 * 添加子项
	 */
	public function actionItemChildAdd(){
		$parent=urldecode($_GET['parentItem']);
		if($parent == ""){
			WMessage::htmlWarn("父项目不能为空");
		}
		$am=Auth::getAuthManager();
		$parentItem=$am->getAuthItem($parent);
		if($parentItem == null){
			WMessage::htmlWarn("没有数据");
		}
		$this->setLayoutNone();
		$this->render("auth_item_child_form",array(
			"parentItem"=>$parentItem,
			"parent"=>$parent
		));
	}
	/**
	 * 编辑子项
	 */
	public function actionItemChildEdit(){
		//父项目
		$parent=$_POST['parent'];
		//方法
		$method=$_POST['method'];
		//子项
		$item=$_POST['item'];
		//授权管理器
		$am=Auth::getAuthManager();
		//获得父项
		$parentItem=$am->getAuthItem($parent);
		//如果找不到父项目
		if($parentItem == null){
			WMessage::ajaxInfo("没有数据",0);
		}
		try{
			//添加子项
			if($method == "allow"){
				$flag=$parentItem->addChild($item);
			}else{
				//移除子项
				$flag=$parentItem->removeChild($item);
			}
		}catch(Exception $e){
			$mess=$e->getCode() == 23000 ? "已经存在" : $e->getMessage();
			WMessage::ajaxInfo($mess,0);
		}
		if($flag){
			WCache::clearAll();
			WMessage::ajaxInfo();
		}else{
			WMessage::ajaxInfo("操作失败",0);
		}
	}
	/**
	 * 移除项
	 */
	public function actionItemChildRemove(){
		//授权管理器
		$am=Auth::getAuthManager();
		//移除项
		$flag=$am->removeAuthItem($_POST['item']);
		
		if($flag){
			WCache::clearAll();
			WMessage::ajaxInfo();
		}else{
			WMessage::ajaxInfo("操作失败",0);
		}
	}
	/**
	 * 给用户绑定/解绑 项目
	 * @throws Exception
	 */
	public function actionItemUserEdit(){
		if(Yii::app()->request->isAjaxRequest){
			$userID=$_POST['userID'];
			$method=$_POST['method'];
			//授权管理器
			$am=Auth::getAuthManager();
			//获得项
			$item=$am->getAuthItem($_POST['item']);
			try{
				if(!($item instanceof CAuthItem)){
					throw new Exception("非法的項目");
				}
				//添加项
				if($method == "allow"){
					$flag=$am->assign($item->name,$userID,"","");
					//$flag=$item->assign($userID);
				}else{
					//移除项
					$flag=$am->revoke($item->name,$userID);
					//$flag=$item->revoke($userID);
				}
			}catch(Exception $e){
				$mess=$e->getMessage();
				WMessage::ajaxInfo($mess,0);
			}
			WCache::clearAll();
			WMessage::ajaxInfo();
		}
		
		$userID=$_GET['userID'];
		//渲染
		$this->setLayoutNone();
		$this->render("auth_item_user_form",array(
			"userID"=>$userID
		));
	}
}